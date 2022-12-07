<?php

namespace App\Http\Controllers;


use App\Exports\excel_usuariosExport;
use App\Http\Requests\CreateentrevistadorRequest;
use App\Http\Requests\UpdateentrevistadorRequest;
use App\Models\entrevistador;
use App\Models\entrevistador_acceso;
use App\Models\excel_usuarios;
use App\Models\traza_actividad;
use App\Repositories\entrevistadorRepository;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Flash;
use Response;

class entrevistadorController extends AppBaseController
{
    /** @var  entrevistadorRepository */
    private $entrevistadorRepository;

    public function __construct(entrevistadorRepository $entrevistadorRepo)
    {
        $this->entrevistadorRepository = $entrevistadorRepo;
    }

    /**
     * Display a listing of the entrevistador.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->authorize('nivel-1-al-6');
        $filtros = entrevistador::filtros_default($request);
        //dd($filtros);
        //Mostrar los confidenciales.  Solo aquí uso esta excepción
        $filtros->confidenciales=true;
        $filtros->confidenciales_ajenos=true;
        $filtros->todos = true;  //incluso los deshabilitados
        //dd($filtros);



        $entrevistadors = entrevistador::filtrar($filtros)->ordenar()->paginate();

        $txt_titulo = "Entrevistadores";

        return view('entrevistadors.index')
            ->with('entrevistadors', $entrevistadors)
            ->with('txt_titulo', $txt_titulo)
            ->with('filtros', $filtros);
    }

    /**
     * Show the form for creating a new entrevistador.
     *
     * @return Response
     */
    public function create()
    {


        if(\Gate::check('login-local')) {
            $this->authorize('nivel-1');
            return view('entrevistadors.create_local');
        }
        else {
            $quien = \Auth::user();


            if($quien->tiene_perfil()) {
                return redirect(action('entrevistadorController@edit',$quien->id_entrevistador));
            }
            else {
                return view('entrevistadors.create');
            }

        }



    }

    /**
     * Store a newly created entrevistador in storage.
     *
     * @param CreateentrevistadorRequest $request
     *
     * @return Response
     */
    public function store(CreateentrevistadorRequest $request)
    {
        if(\Gate::check('login-local')) {
            $input = $request->all();

            $usr['name']=$input['name'];
            $usr['email']=$input['email'];
            $usr['password']=$input['password'];
            $usuario = new User();
            $usuario->fill($usr);
            try {
                $usuario->save();
                $e = new entrevistador();
                $e->id_usuario=$usuario->id;
                $e->id_nivel=$input['id_nivel'];
                $e->id_macroterritorio=105;
                $e->id_territorio=141;
                $e->id_ubicacion=184;
                $e->numero_entrevistador = entrevistador::determinar_correlativo(null);
                $e->id_grupo=25; //Para diferenciarlos
                $e->save();

                traza_actividad::create(['id_objeto'=>4, 'id_accion'=>3 , 'id_primaria'=>$e->id_entrevistador, 'codigo'=>$e->numero_entrevistador]);

                Flash::success('Usuario creado exitosamente');

                return redirect(action('entrevistadorController@index'));
            }
            catch(\Exception $e) {
                $error['email']='Correo electrónico ya registrado en el sistema';
                return redirect()->back()->withInput($request->except('password'))->withErrors($error);
            }

        }
        else {
            $input = $request->all();
            $input['id_usuario']=\Auth::user()->id;
            $input['id_nivel']=config('expedientes.primer_registro'); //configurable en .env
            $input['id_macroterritorio']=$request->id_territorio_macro;
            $input['numero_entrevistador']=entrevistador::determinar_correlativo(\Auth::user()->username);
            //Hard code
            if($input['numero_entrevistador'] >= 50 ) {
                $input['id_grupo']=1;
            }
            else {
                $input['id_grupo']=2;  //Ruta pacifica
            }



            $entrevistador = $this->entrevistadorRepository->create($input);
            traza_actividad::create(['id_objeto'=>4, 'id_accion'=>3 , 'id_primaria'=>$entrevistador->id_entrevistador, 'codigo'=>$entrevistador->numero_entrevistador]);

            Flash::success('Gracias por completar su perfil. Su número de entrevistador es <h1>'.$input['numero_entrevistador'].'</h1>');

            return redirect(action('entrevistadorController@show',$entrevistador->id_entrevistador));
        }

    }

    /**
     * Display the specified entrevistador.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $entrevistador = $this->entrevistadorRepository->findWithoutFail($id);
        if (empty($entrevistador)) {
            Flash::error('Entrevistador no existe');
            return redirect(route('entrevistadors.index'));
        }

        if(!\Gate::allows('es-propio',$id)) {
            if (\Gate::denies('nivel-1-2')) {
                if(\Gate::allows('nivel-3')) {
                    $this->authorize('misma-macro',$entrevistador->id_macroterritorio);
                }
                if(\Gate::allows('nivel-4')) {
                    //dd("Territorio del entrevistador: $entrevistador->id_territorio");
                    //dd("Territorio de la usuario: ".\Auth::user()->id_territorio);

                    $this->authorize('misma-territorial',$entrevistador->id_territorio);

                }
                if(\Gate::allows('nivel-5')) {
                    $this->authorize('es-propio',$entrevistador->id_entrevistador);
                }
            }
        }

        if(\Gate::check('login-local')) {
            return view('entrevistadors.show_local')->with('entrevistador', $entrevistador);
        }
        else {
            return view('entrevistadors.show')->with('entrevistador', $entrevistador);
        }




    }

    /**
     * Show the form for editing the specified entrevistador.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        if(\Gate::check('login-local')) {
            $entrevistador = $this->entrevistadorRepository->findWithoutFail($id);
            if (empty($entrevistador)) {
                Flash::error('Entrevistador no existente');
                return redirect(route('entrevistadors.index'));
            }
            if($entrevistador->id_usuario == \Auth::id()) {
                Flash::error('No puede modificarse a sí mismo');
                return redirect(route('entrevistadors.index'));
            }
            //dd($entrevistador);
            return view('entrevistadors.edit_local')->with('entrevistador', $entrevistador);

        }
        else {
            //Ver que exista
            $entrevistador = $this->entrevistadorRepository->findWithoutFail($id);
            if (empty($entrevistador)) {
                Flash::error('Entrevistador no existente');
                return redirect(route('entrevistadors.index'));
            }

            //Que no vean los ajenos
            if (\Gate::denies('nivel-1-2')) {
                $this->authorize('es-propio',$id);
            }
            else {
                $this->authorize('nivel-igual-inferior',$entrevistador->id_nivel);
            }
            return view('entrevistadors.edit')->with('entrevistador', $entrevistador);
        }





    }

    /**
     * Update the specified entrevistador in storage.
     *
     * @param  int              $id
     * @param UpdateentrevistadorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateentrevistadorRequest $request)
    {
        if(\Gate::check('login-local')) {
            $this->authorize('nivel-1');
            //Ver que exista
            $entrevistador = entrevistador::find($id);
            if (empty($entrevistador)) {
                Flash::error('Entrevistador no existente');
                return redirect(route('entrevistadors.index'));
            }

            $usuario = $entrevistador->rel_usuario;

            if(strlen($request->password)>=6) {
                $usuario->password = \Hash::make($request->password);
            }
            if(strlen($request->name)>=6) {
                $usuario->name = $request->name;
            }
            $usuario->save();
            $entrevistador->id_nivel=$request->id_nivel;
            $entrevistador->save();


            Flash::success('Usuario actualizado.');
            traza_actividad::create(['id_objeto'=>4, 'id_accion'=>4 , 'id_primaria'=>$entrevistador->id_entrevistador,  'codigo'=>$entrevistador->numero_entrevistador]);
            return redirect(action('entrevistadorController@index'));
        }
        else {
            //Ver que exista
            $entrevistador = entrevistador::find($id);
            if (empty($entrevistador)) {
                Flash::error('Entrevistador no existente');
                return redirect(route('entrevistadors.index'));
            }

            //Que no vean los ajenos
            if (\Gate::denies('nivel-1-2')) {
                $this->authorize('es-propio',$id);
            }
            else {
                $this->authorize('nivel-igual-inferior',$entrevistador->id_nivel);
            }

            $entrevistador->id_ubicacion=$request->id_ubicacion;
            $entrevistador->id_territorio=$request->id_territorio;
            $entrevistador->id_macroterritorio=$request->id_territorio_macro;
            //$entrevistador->solo_lectura=$request->solo_lectura;
            if(isset($request->id_grupo)) {
                $entrevistador->id_grupo=$request->id_grupo;
            }

            //$entrevistador->numero_entrevistador=$request->numero_entrevistador;
            $entrevistador->update();
            Flash::success('Perfil actualizado.');
            traza_actividad::create(['id_objeto'=>4, 'id_accion'=>4 , 'id_primaria'=>$entrevistador->id_entrevistador,  'codigo'=>$entrevistador->numero_entrevistador]);
            return redirect(action('entrevistadorController@show',$id));
        }

    }

    /**
     * Remove the specified entrevistador from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        abort(403);
        if (\Gate::denies('nivel-1')) {
            $this->authorize('es-propio',$id);
        }
        $entrevistador = $this->entrevistadorRepository->findWithoutFail($id);

        if (empty($entrevistador)) {
            Flash::error('Entrevistador not found');
            return redirect(route('entrevistadors.index'));
        }
        //$this->entrevistadorRepository->delete($id);
        Flash::success('Entrevistador eliminado');
        return redirect(route('entrevistadors.index'));
    }

    public function frm_nivel($id) {

        $entrevistador = entrevistador::find($id);
        if (empty($entrevistador)) {
            Flash::error('Entrevistador not found');
            return redirect(route('entrevistadors.index'));
        }


        $this->authorize('nivel-superior');
        $this->authorize('nivel-igual-inferior',$entrevistador->id_nivel);
        $this->authorize('escritura');

        return view('entrevistadors.nivel')->with('entrevistador', $entrevistador);

    }
    public function cambiar_nivel($id, Request $request) {
        $entrevistador = entrevistador::find($id);
        if (empty($entrevistador)) {
            Flash::error("Entrevistador no existe");
            return redirect(route('entrevistadors.index'));
        }


        $this->authorize('nivel-superior'); //Que tenga permisos
        $this->authorize('nivel-igual-inferior',$entrevistador->id_nivel);  //que no modifique a alguien de nivel superior



        //dd($request);



        $entrevistador->id_nivel=$request->id_nivel;
        $entrevistador->id_grupo=$request->id_grupo;
        $entrevistador->solo_lectura=$request->solo_lectura;
        //Liberar permisos
        $entrevistador->r3_nna = $request->r3_nna;
        $entrevistador->r3_vs = $request->r3_vs;
        $entrevistador->r3_ri = $request->r3_ri;
        $entrevistador->r3_aa = $request->r3_aa;

        $entrevistador->save();
        //Accesos
        $a_accesos=$request->id_grupo_acceso;
        $entrevistador->rel_acceso()->delete();
        if(is_array($a_accesos)) {
            if(in_array(-1,$a_accesos)) {
                //Escogió "ninguno": quitar todos los accesos, no hacer nada
            }
            else {
                foreach($a_accesos as $id_grupo) {
                    entrevistador_acceso::create(['id_entrevistador'=>$entrevistador->id_entrevistador,'id_grupo_acceso'=>$id_grupo,'id_nivel'=>$request->id_nivel_acceso]);
                }
            }
        }



        Flash::success('Privilegios actualizados');
        traza_actividad::create(['id_objeto'=>4, 'id_accion'=>7 , 'id_primaria'=>$entrevistador->id_entrevistador,  'codigo'=>$entrevistador->numero_entrevistador]);

        return redirect(action("entrevistadorController@show",$entrevistador->id_entrevistador));

    }

    public function deshabilitado() {
        return view('pages.deshabilitado');
    }

    public function json_numero(Request $request) {
        $numero = intval($request->numero);
        $respuesta = new \stdClass();
        $respuesta->id=0;
        $respuesta->txt="Desconocido";
        if($numero>0) {
            $e = entrevistador::where('numero_entrevistador',$numero)->first();
            if($e) {
                $respuesta->id = $e->id_entrevistador;
                $respuesta->txt = $e->fmt_numero_nombre; //todo: agregar la carga que tiene
            }
        }
        return json_encode($respuesta);
    }

    //Impersonalizar
    public function como_otro($id_entrevistador) {
        $this->authorize('nivel-1');

        $e = entrevistador::find($id_entrevistador);
        if($e) {
            $id_usuario = $e->id_usuario;
            \Auth::user()->setImpersonating($id_usuario);
            Flash::success("Actuando a nombre de $e->nombre");
        }

        //dd( \Auth::user() );
        //dd( \Session::get('impersonate'));
        return redirect()->action('HomeController@index');
    }
    public function ya_no()
    {
        if(\Auth::check()) {
            \Auth::user()->stopImpersonating();
            Flash::success("Fin de la actuación a nombre de otro");
        }
        return redirect()->action('entrevistadorController@index');
    }

    //Exportar
    public function generar_excel() {
        $respuesta = excel_usuarios::generar_plana();
        return response()->json($respuesta);
    }

    //Compromiso de reserva y confidencialidad
    public function solicitar_compromiso() {
        return view("pages.compromiso_reserva");
    }
    public function registrar_compromiso(Request $request) {
        //dd($request->all());
        $res = entrevistador::registrar_compromiso();
        return redirect()->action('HomeController@index');
    }

    //Descargar excel
    public function descargar_excel() {
       $this->authorize('nivel-1');

        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>4, 'id_accion'=>8]);
        return Excel::download(new excel_usuariosExport(),"usuarios_modulo_escucha_$fecha.xlsx");
    }


    //Paz y Salvo: verificar que las entrevistas estén completas
    public function paz_y_salvo(Request $request) {
        $filtros = entrevistador::filtros_pys($request);
        $quien = entrevistador::find($filtros->id_entrevistador);
        $datos =  $quien->verificar_entrevistas();


        //dd($datos);


        return view('pazysalvo.index',compact('datos','filtros'));
    }


    /**
     * AUtenticacion local
     */
    //Versión liviana: Cambiar clave
    public function frm_cambiar_clave() {
        //Flash::success('Ojo con esto');
        $entrevistador = \Auth::user()->rel_entrevistador;
        if($entrevistador) {
            return view ('entrevistadors.passwd', compact('entrevistador'));
        }
        else {
            return redirect()->back();
        }

    }
    public function cambiar_clave(Request $request) {

        //dd($request->all());
        $user = \Auth::user();

        $tmp['email']=$user->email;
        $tmp['password']=$request->password_old;

        //dd($tmp);

        $valido = \Auth::guard('portable')->validate($tmp);



        if($valido) {
            $user->password = \Hash::make($request->password);
            $user->save();
            Flash::success('Contraseña actualizada por solicitud del usuario');
            return redirect(action('entrevistadorController@show',\Auth::user()->id_entrevistador));
        }
        else {
            //$input=$request->all();
            return redirect()->action('entrevistadorController@frm_cambiar_clave')->withErrors(['password_old'=>"Contraseña actual incorrecta"]);
        }
    }

}
