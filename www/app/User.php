<?php

namespace App;

use Adldap\Adldap;
use App\Models\entrevistador;
use App\Models\traza_actividad;
use App\Models\user_vence;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rel_entrevistador() {
        return $this->belongsTo(entrevistador::class, 'id','id_usuario')->orderby('id_nivel');
    }

    public function rel_vencimiento() {
        return $this->belongsTo(user_vence::class,'id_user','id');
    }
    public function tiene_perfil() {
        //$perfil=entrevistador::where('id_usuario',$this->id)->first();
        $perfil=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($perfil) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getFmtNumeroEntrevistadorAttribute() {
        $cual = $this->rel_entrevistador;
        $cual=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($cual) {
            return $cual->fmt_numero_entrevistador;
        }
        else {
            return "Sin especificar";
        }
    }
    public function getFmtNumeroNombreEntrevistadorAttribute() {
        $cual = $this->rel_entrevistador;
        $cual=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($cual) {
            return $cual->fmt_numero_entrevistador." - ".$this->name;
        }
        else {
            return "Sin especificar";
        }
    }

    //Datos extraidos de la tabla entrevistador.  Me ahorra código de verificar si existe o no el registro asociado
    public function getFmtMacroterritorioAttribute() {
        $datos=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        //$datos = $this->rel_entrevistador;
        if($datos) {
            return $datos->fmt_id_macroterritorio;
        }
        else {
            return "Sin Especificar";
        }
    }
    public function getFmtTerritorioAttribute() {
        //$datos = $this->rel_entrevistador;
        $datos=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($datos) {
            return $datos->fmt_id_territorio;
        }
        else {
            return "Sin Especificar";
        }
    }

    //Datos extraidos de la tabla entrevistador.  Me ahorra código de verificar si existe o no el registro asociado
    public function getFmtPrivilegiosAttribute() {
        //$datos = $this->rel_entrevistador;
        $datos=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($datos) {
            return $datos->fmt_id_nivel;
        }
        else {
            return "Sin Especificar";
        }
    }
    //Datos extraidos de la tabla entrevistador.  Me ahorra código de verificar si existe o no el registro asociado
    public function getFmtUbicacionAttribute() {
        //$datos = $this->rel_entrevistador;
        $datos=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($datos) {
            return $datos->fmt_id_ubicacion;
        }
        else {
            return "Sin Especificar";
        }
    }
    public function getFmtIdGrupoAttribute() {
        //$datos = $this->rel_entrevistador;
        $datos=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($datos) {
            return $datos->fmt_id_grupo;
        }
        else {
            return "Sin Especificar";
        }
    }

    //Para ahorrarme chequeos y programacion
    public function getIdNivelAttribute() {
        $cual=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        //$cual = $this->rel_entrevistador;
        if($cual) {
            return $cual->id_nivel;
        }
        else {
            return 99;
        }
    }
    //Por si las moscas
    public function getNivelAttribute() {
        //$cual = $this->rel_entrevistador;
        $cual=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($cual) {
            return $cual->id_nivel;
        }
        else {
            return 99;
        }
    }
    public function getIdEntrevistadorAttribute() {
        //$cual = $this->rel_entrevistador;
        $cual=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($cual) {
            return $cual->id_entrevistador;
        }
        else {
            return 0;
        }
    }
    public function getIdMacroterritorioAttribute() {
        //$cual = $this->rel_entrevistador;
        $cual=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($cual) {
            return $cual->id_macroterritorio;
        }
        else {
            return 0;
        }
    }
    public function getIdTerritorioAttribute() {
        //$cual = $this->rel_entrevistador;
        $cual=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($cual) {
            return $cual->id_territorio;
        }
        else {
            return 0;
        }
    }

    public function getIdUbicacionAttribute() {
        //$cual = $this->rel_entrevistador;
        $cual=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($cual) {
            return $cual->id_ubicacion;
        }
        else {
            return 0;
        }
    }
    public function getIdGrupoAttribute() {
        $cual=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        //$cual = $this->rel_entrevistador;
        if($cual) {
            return $cual->id_grupo;
        }
        else {
            return 0;
        }
    }
    public function getSoloLecturaAttribute() {
        //$cual = $this->rel_entrevistador;
        $cual=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($cual) {
            return $cual->solo_lectura;
        }
        else {
            return 1;
        }
    }

    public static function conectar_servidor_ldap() {
        $ad = new Adldap();
        // Create a configuration array.
        $config = [
            'hosts'    => [env('AD_SERVER'), env('AD_SERVER_IP')],
            'base_dn'  => env('AD_DOMAIN'),
            //'username' => 'cev\\'.$usuario,
            //'password' => $clave,
            //'username' => 'cev\oliver.mazariegos',
            //'password' => 'Temporal2019',
        ];
        $ad->addProvider($config);
        try {
            // If a successful connection is made to your server, the provider will be returned.
            $provider = $ad->connect();
            return true;
        }
        catch (\Adldap\Auth\BindException $e) {
            //return $config;
            return false;

        }
    }


    public static  function login_ldap($usuario="",$clave="") {

        //Por si acaso
        if(substr($usuario,0,4)=='cev\\') {
            $usuario = substr($usuario,4);
        }
        $ad = new Adldap();
        // Create a configuration array.
        $config = [
            'hosts'    => [env('AD_SERVER'), env('AD_SERVER_IP')],
            'base_dn'  => env('AD_DOMAIN'),
            'username' => 'cev\\'.$usuario,
            'password' => $clave,
            //'username' => 'cev\oliver.mazariegos',
            //'password' => 'Temporal2019',
            //'use_ssl' =>true
        ];
        // Add a connection provider to Adldap.
        $ad->addProvider($config);

        $respuesta=new \stdClass();
        $respuesta->exito=false;
        $respuesta->texto="";

        $respuesta->usuario=$usuario;

        try {
            // If a successful connection is made to your server, the provider will be returned.
            $provider = $ad->connect();

            // Performing a query.
            //$results = $provider->search()->where('cn', '=', 'oliver.mazariegos')->get();

            // Finding a record.
            //$user = $provider->search()->find('oliver.mazariegos');
            $user_ldap = $provider->search()->findBy('samaccountname', $usuario);
            $nombre = $user_ldap->cn[0];
            $respuesta->texto= $nombre;
            $respuesta->exito=true;
            $respuesta->info =$config;
            $respuesta->user_ldap = $user_ldap;
            $respuesta->ad=$ad;
            $respuesta->provider=$provider;


        } catch (\Adldap\Auth\BindException $e) {
            //return $config;
            $respuesta->texto= $e->getMessage();
            $respuesta->info =$config;

        }
        return $respuesta;
    }

    public function getImagenAttribute() {
        if(empty($this->avatar)) {
            return url("logo_vertical.jpg");
        }
        else {
            return $this->avatar;
        }
    }

    public static function cambiar_clave($usuario,$clave_vieja, $clave_nueva) {
        $config = [
            'hosts'    => [env('AD_SERVER'), env('AD_SERVER_IP')],
            'base_dn'  => env('AD_DOMAIN'),
            'username' => 'cev\\'.$usuario,
            'password' => $clave_vieja,
            //'username' => 'cev\oliver.mazariegos',
            //'password' => 'Temporal2019',
        ];
        // Conectarse
        $ad = new Adldap();
        $ad->addProvider($config);

        $respuesta=new \stdClass();
        $respuesta->exito=false;
        $respuesta->texto="";
        $respuesta->usuario=$usuario;

        try {
            $provider = $ad->connect();
            $user = $provider->search()->users()->find($usuario);

            $cambio = $user->changePassword($clave_vieja,$clave_nueva)->save();
            //$cambio = $user->setPassword('abc123')->save();
            $respuesta->exito = $cambio;


            /*
            // If a successful connection is made to your server, the provider will be returned.
            $provider = $ad->connect();

                // User is now bound to your LDAP server.
                // Try and perform a password change:
                $user = $provider->search()->users()->find($usuario);

                $user->exists;

                if ($user->changePassword($clave_vieja, $clave_nueva)) {
                    // Password was changed.
                    $respuesta->texto="Contraseña actualizada";
                    $respuesta->exito=true;
                }
                else {
                    $respuesta->texto="No se pudo cambiar la clave";
                }
                */

        } catch (\Adldap\Auth\BindException $e) {
            //return $config;
            $respuesta->texto= $e->getMessage();
        }
        return $respuesta;

    }

    public static function listado_items($vacio="") {
        //$filtros = self::filtros_default();

        $query=User::orderby('name');

        //dd($query);

        $listado = $query->pluck('name','id');

        //dd($listado);


        if(strlen($vacio)>0) {
            if(count($listado)>1) {  //Si solo hay uno (nivel mas bajo), no tiene sentido el vacío
                $listado->prepend($vacio,-1);
            }
        }
        return $listado->toArray();
    }

    //Determina la fecha en que el usuario debe cambiar de clave
    // Lo almacena en user_clave y se calcula en cada login
    public static function fecha_cambio_clave($usuario_ldap,$usuario) {
        $cambio_clave= self::windows_to_carbon($usuario_ldap->pwdLastSet[0]);
        $cambio_clave->addDay(config('expedientes.ad_vence'));

        $existe = user_vence::where('id_user',$usuario->id)->first();
        if($existe) {
            $existe->fh_vence=$cambio_clave;
        }
        else {
            $existe = new user_vence();
            $existe->id_user = $usuario->id;
            $existe->fh_vence=$cambio_clave;
        }
        $existe->save();
        return $existe->fh_vence;
    }
    //Procesar los valores de fechas del Active Directory
    public static function windows_to_carbon($win){
        $sec       = (int)($win / 10000000); // divide by 10 000 000 to get seconds
        $uni = ($sec - 11644473600); // 1.1.1600 -> 1.1.1970 difference in sec
        return \Carbon\Carbon::createFromTimestamp($uni);

    }
    public function getDiasPendientesAttribute() {
        $vencimiento = user_vence::where('id_user',$this->id)->first();


        if(!$vencimiento) {  //Usuarios de gmail, o que no han registrado fecha de vencimiento
            return false;
        }
        else {
            $vence = Carbon::createFromFormat('Y-m-d H:i:s',$vencimiento->fh_vence);
            $dias_pendientes = $vence->diff(Carbon::now())->days;
            return $dias_pendientes;
        }
    }
    public function getTocaCambioAttribute() {
        $anticipacion=config('expedientes.ad_avisa');
        if(!$this->dias_pendientes) {
            return false;
        }
        else {
            return $this->dias_pendientes < $anticipacion;
        }
    }
    public function setUserNameAttribute($val) {
        $this->attributes['username']=mb_strtolower($val);
    }
    public function setEmailAttribute($val) {
        $this->attributes['email']=mb_strtolower($val);
    }

    public function getR3NnaAttribute() {
        $e=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($e) {
            return $e->r3_nna == 1;
        }
        else {
            return false;
        }

    }

    public function getR3VsAttribute() {
        $e=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($e) {
            return $e->r3_vs == 1;
        }
        else {
            return false;
        }
    }
    public function getR3RiAttribute() {
        $e=entrevistador::where('id_usuario',$this->id)->orderby('id_nivel')->first(); //Por si tiene varios perfiles, siempre devolver el mas alto
        if($e) {
            return $e->r3_ri == 1;
        }
        else {
            return false;
        }
    }


    //Para actuar como otro usuario: https://mauricius.dev/easily-impersonate-any-user-in-a-laravel-application/
    public function setImpersonating($id)
    {

        \Session::put('impersonate', $id);
        \Session::put('id_personificador',$this->id);
        $quien=self::find($id);
        if($quien) {
            $codigo=$quien->fmt_numero_nombre_entrevistador;
        }
        else {
            $codigo="id_entrevistador=$id";
        }
        traza_actividad::create(['id_objeto'=>4, 'id_accion'=>25 , 'id_primaria'=>$this->id_entrevistador, 'codigo'=>$codigo]);

    }

    public function stopImpersonating()
    {
        //A nombre de quien
        $user=user::find(\Session::get('impersonate'));
        if($user) {
            //Hago la traza antes de terminar la personificacion, para que los datos queden bien
            traza_actividad::create(['id_objeto'=>4, 'id_accion'=>26 , 'id_primaria'=>$user->id_entrevistador, 'codigo'=>$user->fmt_numero_nombre_entrevistador]);

            \Session::forget('impersonate');
            \Session::forget('id_personificador');
        }



    }

    public function isImpersonating()
    {
        return \Session::has('impersonate');
    }

    public static function red_interna() {
        $ip = \Request::ip();
        $red = substr($ip,0,8);
        $validas = ['172.16.1','127.0.0.'];
        $respuesta = new \stdClass();
        $respuesta->validas = $validas;
        $respuesta->red_interna = in_array($red,$validas);
        $respuesta->ip = $ip;
        return $respuesta;
    }

    //Enviar correos
    public static function test_correo() {
        $to_name = 'Oliver Mazariegos';
        $to_email = 'oliver.mazariegos@gmail.com';
        $data['name']='Sistema de Información Misional';
        $data['body']='Mensaje de prueba';
        try {
            \Mail::send('mails.test', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Prueba desde laravel');
                $message->from('etiquetado@comisiondelaverdad.co','SIM (etiquetado)');
            });
            return true;
        }
        catch (\Exception $e) {
            Log::error("Problemas con el envío de correo: ".PHP_EOL.$e->getMessage());
            return false;
        }

        return $res;
    }

    public function getFmtCorreoEAttribute() {
        $correo=$this->email;
        if(empty($correo)) {
            $correo = $this->username."@comisiondelaverdad.co";
        }
        return $correo;
    }

    public function getFmtCreatedAtAttribute() {
        try {
            $fecha = Carbon::createFromFormat("Y-m-d H:i:s",$this->created_at);
            return $fecha->format("d/m/Y H:i");
        }
        catch(\Exception  $e) {
            return $this->created_at;
        }
    }


    public static function quitar_tildes($str) {
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
        $str = strtr( $str, $unwanted_array );
        return $str;
    }



    //Este método lo debo correr cuando se publique la versión local, habilita un primer administrador
    public static function reset_clave_admin_local() {
        $u = self::find(2);
        $u->password=\Hash::make('123');
        $u->save();
        $e = $u->rel_entrevistador;
        $e->id_nivel=1;
        $e->save();

        return "Usuario $u->email actualizado con clave '123' y rol cambiado a administrador";
    }
}
