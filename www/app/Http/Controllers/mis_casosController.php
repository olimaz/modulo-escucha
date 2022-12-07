<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createmis_casosRequest;
use App\Http\Requests\Updatemis_casosRequest;
use App\Models\adjunto;
use App\Models\adjunto_justificacion;
use App\Models\cat_item;
use App\Models\criterio_fijo;
use App\Models\desclasificar;
use App\Models\entrevistador;
use App\Models\historia_vida;
use App\Models\historia_vida_adjunto;
use App\Models\historia_vida_dinamica;
use App\Models\historia_vida_interes;
use App\Models\historia_vida_mandato;
use App\Models\historia_vida_tema;
use App\Models\mis_casos;
use App\Models\mis_casos_adjunto;
use App\Models\traza_actividad;
use App\Repositories\mis_casosRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class mis_casosController extends AppBaseController
{
    /** @var  mis_casosRepository */
    private $misCasosRepository;

    public function __construct(mis_casosRepository $misCasosRepo)
    {
        $this->misCasosRepository = $misCasosRepo;

    }

    /**
     * Display a listing of the mis_casos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$inicio = Carbon::now();
        $this->authorize('mis-casos');
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }



        $filtros = mis_casos::filtros_default($request);

        $query = mis_casos::filtrar($filtros)->ordenar();
        //$debug['sql']= nl2br($query->toSql());
        //$debug['criterios']=$query->getBindings();
        //dd($debug);
        $misCasos = $query->select(\DB::raw('mis_casos.*'))->paginate();
        //$fin = Carbon::now();
        //$tiempo = $fin->diffInMilliseconds($inicio);
        //Log::debug("Query del index, tiempo: $tiempo milisegundos");

        $total_entrevistas = $misCasos->total();  //Para el formulario de filtros


        $txt_titulo = "Mis casos";
        return view('mis_casos.index')
            ->with('misCasos', $misCasos)
            ->with('total_entrevistas', $total_entrevistas)
            ->with('txt_titulo',$txt_titulo)
            ->with('filtros', $filtros);
    }

    /**
     * Show the form for creating a new mis_casos.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $id_entrevistador=\Auth::user()->id_entrevistador;
        // A nombre de otro
        if(isset($request->id_entrevistador)) {
            $permitidos = entrevistador::permitidos_acceso_entrevistas();
            if(in_array($request->id_entrevistador,$permitidos)) {
                $id_entrevistador=intval($request->id_entrevistador);
            }
            else {
                $quien = entrevistador::find($request->id_entrevistador);
                $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,5,'0',STR_PAD_LEFT) : "[desconocido]";
                abort(403,"No puede ingresar entrevistas para el entrevistador especificado: $numero");
            }
        }
        $miCaso = new mis_casos();
        $miCaso->valores_iniciales($id_entrevistador);
        return view('mis_casos.create')->with('miCaso', $miCaso);;
    }

    /**
     * Store a newly created mis_casos in storage.
     *
     * @param Createmis_casosRequest $request
     *
     * @return Response
     */
    public function store(Createmis_casosRequest $request)
    {
        $toma = mis_casos::crear_nuevo($request); //Verificar duplicados, asignar código, etc.
        if($toma->exito) {
            //Registrar traza
            traza_actividad::create(['id_objeto'=>15, 'id_accion'=>3, 'codigo'=>$toma->nuevo->entrevista_codigo, 'id_primaria'=>$toma->nuevo->id_mis_casos]);
            return redirect()->action('mis_casosController@show',$toma->nuevo->id_mis_casos);
        }
        else {
            Flash::error($toma->mensaje);
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified mis_casos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, Request $request)
    {

        $this->authorize('mis-casos');
        //Negar acceso a los de solo estadistica
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $id = (integer)$id;
        //1: Confirmar que  que exista
        $misCasos = mis_casos::find($id);
        if (empty($misCasos)) {
            Flash::error('Caso no existe');
            return redirect(action('mis_casosController@index'));
        }

        //2: Confirmar acceso del usuario a la entrevista
        if(!$misCasos->puede_acceder_entrevista) {
            abort(403,"No puede consultar este caso");
        }

        //que pestaña se muesta
        $activar = isset($request->activar) ? $request->activar : "m";  //m=metadatos

        //Registrar traza
        traza_actividad::create(['id_objeto'=>15, 'id_accion'=>6, 'codigo'=>$misCasos->entrevista_codigo, 'id_primaria'=>$id]);

        $txt_titulo = $misCasos->entrevista_codigo;


        //Debug
        $ocultar=isset($request->ocultar) ? $request->ocultar : 10;  //10 = maximo
        return view('mis_casos.show')->with('misCasos', $misCasos)
                    ->with('txt_titulo',$txt_titulo)
                    ->with('ocultar', $ocultar)
                    ->with('activar', $activar);
    }

    /**
     * Show the form for editing the specified mis_casos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $this->authorize('mis-casos');
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $miCaso = mis_casos::find($id);
        if (empty($miCaso)) {
            Flash::error('Mi caso, no existe');
            return redirect(action('mis_casosController@index'));
        }
        if(!$miCaso->puede_acceder_entrevista) {
            abort(403,"No puede consultar este expediente");
        }

        //Permisos de escritura
        if(!$miCaso->puede_modificar_entrevista()) {
            abort(403,"No puede modificar este caso");
        }

        return view('mis_casos.edit')->with('miCaso', $miCaso);
    }

    /**
     * Update the specified mis_casos in storage.
     *
     * @param  int              $id
     * @param Updatemis_casosRequest $request
     *
     * @return Response
     */
    public function update($id, Updatemis_casosRequest $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $miCaso = mis_casos::find($id);
        if (empty($miCaso)) {
            Flash::error("No existe el caso indicado ($id) ");
            return redirect(action('mis_casosController@index'));

        }

        $toma = $miCaso->actualizar($request);
        if($toma->exito) {
            //Registrar traza
            traza_actividad::create(['id_objeto'=>15, 'id_accion'=>4, 'codigo'=>$miCaso->entrevista_codigo, 'id_primaria'=>$id]);
            return redirect()->action('mis_casosController@show',$id);
        }
        else {
            Flash::error($toma->mensaje);
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified mis_casos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->authorize('nivel-1');
        $misCasos = $this->misCasosRepository->findWithoutFail($id);

        if (empty($misCasos)) {
            Flash::error('Mis Casos not found');
            return redirect(route('misCasos.index'));
        }
        $misCasos->id_activo=2;
        $misCasos->save();

        //Flash::success('Caso eliminado');
        traza_actividad::create(['id_objeto'=>15, 'id_accion'=>10, 'codigo'=>$misCasos->entrevista_codigo, 'id_primaria'=>$id]);

        return redirect(route('misCasos.index'));
    }

    //Adjuntos
    public function gestionar_adjuntos($id, Request $request) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        if(isset($request->id_seccion)) {
            $id_seccion=$request->id_seccion;
            $seccion=criterio_fijo::where('id_grupo',50)->where('id_opcion',$id_seccion)->first();
            if($seccion) {
                $id_categoria = $seccion->texto;
            }
            else {
                Flash::error("Sección $id_seccion no existe");
                return redirect()->back();
            }
        }
        else {
            Flash::error("No especificó la sección");
            return redirect()->back();
        }
        $entrevista = mis_casos::find($id);
        if (empty($entrevista)) {
            Flash::error("Caso no existe($id)");
            return redirect(route('mis_casosController@index'));
        }
        //Ver que tenga permisos
        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar este caso");
        }
        //Permisos de escritura
        if(!$entrevista->puede_modificar_entrevista()) {
            abort(403,"No puede modificar este caso");
        }
        //Segundo chequeo: reservado-3
        if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
        }


        //Valores predeterminados
        $adjuntado = new mis_casos_adjunto();
        $adjuntado->valores_predeterminados();
        $adjuntado->id_seccion=$id_seccion;
        $adjuntado->id_categoria = $adjuntado->cual_categoria();

        return view('mis_casos.gestionar_adjuntos')
            ->with('miCaso', $entrevista)
            ->with('id_categoria', $id_categoria)
            ->with('adjuntado',$adjuntado)
            ->with('id_seccion',$id_seccion);
    }

    //Para refrescar por ajax la tabla luego del upload
    public function tabla_adjuntos($id) {
        $entrevista = mis_casos::find($id);
        if(!$entrevista) {
            abort(403,"Caso  no existe ($id) ");
        }

        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }


        return view('mis_casos.tabla_adjuntos')->with('miCaso', $entrevista);
    }

    public function crear_adjunto(Request $request)
    {
        if(!isset($request->id_mis_casos)) {
            Flash::error('Debe indicar el id_caso');
            return redirect()->back();
        }
        //dd($input);
        $id_mis_casos = $request->id_mis_casos;
        $caso = mis_casos::find($id_mis_casos);

        if($caso) {
            $nuevo = new mis_casos_adjunto();
            $nuevo->fill($request->all());
            //$nuevo->id_seccion = $request->id_seccion;
            //$nuevo->descripcion = $request->descripcion;
            //$nuevo->id_mis_casos = $request->id_mis_casos;

            //Adjunto
            if($request->hasFile('archivo_4')) {
                $nombre_original=$request->file('archivo_4')->getClientOriginalName();
                $nuevo->id_adjunto = adjunto::crear_adjunto($request->archivo_4_filename, $nombre_original);
            }
            try {
                $nuevo->codigo_adjunto = $nuevo->calcular_codigo();  //en base al id_mis_casos_adjunto
                $nuevo->save();
                $nuevo->calificar();

                $caso->actualizar_nivel_avance();
                //dd("Calculado: $caso->id_avance");
                traza_actividad::create(['id_objeto'=>20, 'id_accion'=>3, 'codigo'=>$caso->entrevista_codigo, 'id_primaria'=>$nuevo->id_mis_casos_adjunto, 'referencia'=>$nuevo->descripcion]);
                //Flash::message('Archivo anexado exitosamente');
                $url = action("mis_casosController@show",$caso->id_mis_casos)."?activar=s$nuevo->id_seccion";
                return redirect($url);
            }
            catch (\Exception $e) {
                Flash::error('No se grabó el adjunto.  ¿dejó el nombre en blanco?');
                //Log::debug('mis_casosController@crear_adjunto: '. $e->getMessage());
                //Flash::error();;
            }


        }
        else {
            Flash::error("No existe el caso indicado($request->id_mis_casos)");
        }
        return redirect()->back();
    }

    public function quitar_adjunto(Request $request)
    {
        $id=$request->id;
        $entrevista_adjunto = mis_casos_adjunto::find($id);
        if (empty($entrevista_adjunto)) {
            Flash::error('Adjunto no existe');
            return redirect(action('mis_casosController@index'));
        }
        $descripcion = $entrevista_adjunto->descripcion;
        $caso = mis_casos::find($entrevista_adjunto->id_mis_casos);
        $id_adjunto =$entrevista_adjunto->id_adjunto;
        $entrevista_adjunto->delete();
        $caso->actualizar_nivel_avance();


        //Flash::success('Archivo adjunto eliminado.');
        traza_actividad::create(['id_objeto'=>20, 'id_accion'=>10, 'codigo'=>$caso->entrevista_codigo, 'id_primaria'=>$caso->id_mis_casos, 'referencia'=>"id_adjunto=$id_adjunto. $descripcion"]);


        return response()->json(true);
    }

    //Para la tabla que (ya no) se muestra
    public function editar_adjunto(Request $request)
    {
        $id=$request->id;
        $entrevista_adjunto = mis_casos_adjunto::find($id);
        if (empty($entrevista_adjunto)) {
            Flash::error('Adjunto no existe');
            return redirect(action('mis_casosController@index'));
        }
        $descripcion = $entrevista_adjunto->descripcion;
        $caso = mis_casos::find($entrevista_adjunto->id_mis_casos);
        $id_adjunto =$entrevista_adjunto->id_adjunto;

        $entrevista_adjunto->delete();
        $caso->actualizar_nivel_avance();

        Flash::success('Archivo adjunto eliminado.');
        traza_actividad::create(['id_objeto'=>20, 'id_accion'=>4, 'codigo'=>$caso->entrevista_codigo, 'id_primaria'=>$caso->id_mis_casos, 'referencia'=>"id_adjunto=$id_adjunto. $descripcion"]);

        return response()->json(true);
    }
}
