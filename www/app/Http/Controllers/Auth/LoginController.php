<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\traza_actividad;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\User;


use Adldap\Laravel\Facades\Adldap;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:portable')->except('logout');

    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        $user->email = mb_strtolower($user->email);

        // only allow people with @company.com to login
        if(explode("@", $user->email)[1] !== 'comisiondelaverdad.co'){
            return redirect()->to('correo_negado');
        }

        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();



        if($existingUser){
            // log them in
            auth()->login($existingUser, true);
        } else {
            //Revisar si no está previamente registrado por Active Directory
            $ad = User::where('username','ilike' ,explode("@", $user->email)[0])->first();
            if($ad) {  //Usar el existente
               $newUser = $ad;
            }
            else {  //Crear uno nuevo
                $newUser = new User;
            }
            // Actualizar información
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->id;
            $newUser->avatar          = $user->avatar;
            $newUser->avatar_original = $user->avatar_original;
            $newUser->save();

            auth()->login($newUser, true);
        }
        traza_actividad::create(['id_accion'=>1]);
        return redirect()->to('/home');
    }

    public function forzar_login($id) {
        if(env('APP_ENV')<>'local') {
            return "Solo para pruebas";
        }

        $quien =User::find($id);
        if($quien) {
            auth()->logout();
            auth()->login($quien, true);
            //dd("Autenticado");
            return redirect()->to('/home');


        }
        else {
            dd("No existe el usuario $id");
        }
    }

    protected function attemptLogin_local(Request $request)
    {
        return $this->guard('portable')->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    // https://github.com/jotaelesalinas/laravel-simple-ldap-auth

    public function username()
    {
        if(config('expedientes.login_local')) {
            return 'email';
        }
        else {
            return config('ldap_auth.usernames.eloquent');
        }

    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
           // $this->username() => 'required|string|regex:/^\w+$/',
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request)
    {

            $hay_conexion = \App\User::conectar_servidor_ldap();
            if(!$hay_conexion) {
                return false;
            }

            $credentials = $request->only($this->username(), 'password');
            $username = $credentials[$this->username()];
            $password = $credentials['password'];

            $username=strtolower($username);
            $username = User::quitar_tildes($username);

            $user_format = env('LDAP_USER_FORMAT', 'cn=%s,'.env('LDAP_BASE_DN', ''));
            $userdn = sprintf($user_format, $username);

            $userdn="cev\\$username";

            // you might need this, as reported in
            // [#14](https://github.com/jotaelesalinas/laravel-simple-ldap-auth/issues/14):
            // Adldap::auth()->bind($userdn, $password);


            if(Adldap::auth()->attempt($userdn, $password, $bindAsUser = true)) {
                // the user exists in the LDAP server, with the provided password
                $user = \App\User::where($this->username(), 'ilike' ,$username)->first();
                if (!$user) {
                    //Ver si se había registrado con su correo
                    $correo = User::where('email','ilike',$username."@comisiondelaverdad.co")->first();
                    if($correo) {
                        $correo->username = $username;
                        $correo->save();
                        $user = $correo;  //Para que el resto de codigo furule
                    }
                    else {
                        // the user doesn't exist in the local database, so we have to create one
                        $user = new \App\User();
                        $user->username = $username;
                        $user->password = '';

                        $sync_attrs = $this->retrieveSyncAttributes($username);
                        $user->name=$sync_attrs['name'];
                        $user->save();
                    }
                }
                //Determinar cuando vence
                $login = User::login_ldap($credentials[$this->username()],$credentials['password']);

                //Grabar en la BD cuando toca cambiar la clave
                if($login->exito) {
                    User::fecha_cambio_clave($login->user_ldap,$user);
                }

                // by logging the user we create the session, so there is no need to login again (in the configured time).
                // pass false as second parameter if you want to force the session to expire when the user closes the browser.
                // have a look at the section 'session lifetime' in `config/session.php` for more options.
                $this->guard()->login($user, true);
                traza_actividad::create(['id_accion'=>1]);
                return true;
            }

            // the user doesn't exist in the LDAP server or the password is wrong
            // log error
            return false;
    }

    protected function retrieveSyncAttributes($username)
    {
        if(config('expedientes.login_local')) {
            return false;
        }

        $ldapuser = Adldap::search()->where(env('LDAP_USER_ATTRIBUTE'), '=', $username)->first();
        if ( !$ldapuser ) {
            // log error
            return false;
        }
        // if you want to see the list of available attributes in your specific LDAP server:
        // var_dump($ldapuser->attributes); exit;

        // needed if any attribute is not directly accessible via a method call.
        // attributes in \Adldap\Models\User are protected, so we will need
        // to retrieve them using reflection.
        $ldapuser_attrs = null;

        $attrs = [];

        foreach (config('ldap_auth.sync_attributes') as $local_attr => $ldap_attr) {
            if ( $local_attr == 'username' ) {
                continue;
            }

            $method = 'get' . $ldap_attr;
            if (method_exists($ldapuser, $method)) {
                $attrs[$local_attr] = $ldapuser->$method();
                continue;
            }

            if ($ldapuser_attrs === null) {
                $ldapuser_attrs = self::accessProtected($ldapuser, 'attributes');
            }

            if (!isset($ldapuser_attrs[$ldap_attr])) {
                // an exception could be thrown
                $attrs[$local_attr] = null;
                continue;
            }

            if (!is_array($ldapuser_attrs[$ldap_attr])) {
                $attrs[$local_attr] = $ldapuser_attrs[$ldap_attr];
            }

            if (count($ldapuser_attrs[$ldap_attr]) == 0) {
                // an exception could be thrown
                $attrs[$local_attr] = null;
                continue;
            }

            // now it returns the first item, but it could return
            // a comma-separated string or any other thing that suits you better
            $attrs[$local_attr] = $ldapuser_attrs[$ldap_attr][0];
            //$attrs[$local_attr] = implode(',', $ldapuser_attrs[$ldap_attr]);
        }

        return $attrs;
    }

    protected static function accessProtected ($obj, $prop)
    {
        $reflection = new \ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

    public function logout(Request $request)
    {
        traza_actividad::create(['id_accion'=>2]);
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }


    //Muestra el formulario de inicio de sesión
    public function show_formulario_credenciales() {
        return view('adminlte::login_frm');

    }


    //Login local

    public function login_portable(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required'
        ]);


        $exito =  \Auth::guard('portable')->attempt(
            $this->credentials($request), $request->filled('remember')
        );

        if($exito) {
            $user = User::where('email',$request->email)->first();
            $this->guard()->login($user, true);
            return redirect()->intended('/');
        }

//        dd($exito);
//
//
//
//        if (\Auth::guard('portable')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
//            dd("Exito");
//
//        }
        $error['maiz']="Usuario o clave incorrecta";
        return back()->withErrors($error)->withInput($request->only('email', 'remember'));
    }




}
