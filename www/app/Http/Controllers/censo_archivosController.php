<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createcenso_archivosRequest;
use App\Http\Requests\Updatecenso_archivosRequest;
use App\Models\adjunto;
use App\Models\censo_archivos;
use App\Models\censo_archivos_adjunto;
use App\Models\criterio_fijo;
use App\Models\entrevistador;
use App\Models\mis_casos;
use App\Models\traza_actividad;
use App\Repositories\censo_archivosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class censo_archivosController extends AppBaseController
{
    /** @var  censo_archivosRepository */
    private $censoArchivosRepository;

    public function __construct(censo_archivosRepository $censoArchivosRepo)
    {
        $this->censoArchivosRepository = $censoArchivosRepo;
    }

    /**
     * Display a listing of the censo_archivos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $censoArchivos = $this->censoArchivosRepository->paginate();

        $txt_titulo = "Archivos exilio";
        return view('censo_archivos.index')
            ->with('txt_titulo',$txt_titulo)
            ->with('censoArchivos', $censoArchivos);

    }

    /**
     * Show the form for creating a new censo_archivos.
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
        $censoArchivos = new censo_archivos();
        $censoArchivos->valores_iniciales($id_entrevistador);
        $txt_titulo = "Nuevo registro de archivo";
        return view('censo_archivos.create',compact('censoArchivos','txt_titulo'));
    }

    /**
     * Store a newly created censo_archivos in storage.
     *
     * @param Createcenso_archivosRequest $request
     *
     * @return Response
     */
    public function store(Createcenso_archivosRequest $request)
    {
        $toma = censo_archivos::crear_nuevo($request); //Verificar duplicados, asignar código, etc.
        if($toma->exito) {
            //Registrar traza
            traza_actividad::create(['id_objeto'=>9, 'id_accion'=>3, 'codigo'=>$toma->nuevo->entrevista_codigo, 'id_primaria'=>$toma->nuevo->id_censo_archivos]);
            return redirect()->action('censo_archivosController@show',$toma->nuevo->id_censo_archivos);
        }
        else {
            Flash::error($toma->mensaje);
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified censo_archivos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $id = (integer)$id;
        $censoArchivos = $this->censoArchivosRepository->findWithoutFail($id);

        if (empty($censoArchivos)) {
            Flash::error('Censo Archivos not found');

            return redirect(route('censoArchivos.index'));
        }
        //Registrar traza
        traza_actividad::create(['id_objeto'=>9, 'id_accion'=>6, 'codigo'=>$censoArchivos->entrevista_codigo, 'id_primaria'=>$id]);

        //que pestaña se muesta
        $activar = isset($request->activar) ? $request->activar : "m";  //m=metadatos
        $txt_titulo = $censoArchivos->entrevista_codigo;

        return view('censo_archivos.show')->with('censoArchivos', $censoArchivos)
                                            ->with('txt_titulo',$txt_titulo)
                                            ->with('activar', $activar);
    }

    /**
     * Show the form for editing the specified censo_archivos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $censoArchivos = $this->censoArchivosRepository->findWithoutFail($id);

        if (empty($censoArchivos)) {
            Flash::error('Censo Archivos not found');

            return redirect(route('censoArchivos.index'));
        }

        if(!$censoArchivos->puede_modificar_entrevista()) {
            abort(403,"No puede modificar este registro");
        }

        return view('censo_archivos.edit')->with('censoArchivos', $censoArchivos);
    }

    /**
     * Update the specified censo_archivos in storage.
     *
     * @param  int              $id
     * @param Updatecenso_archivosRequest $request
     *
     * @return Response
     */
    public function update($id, Updatecenso_archivosRequest $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $censoArchivos = censo_archivos::find($id);
        if (empty($censoArchivos)) {
            Flash::error("No existe el registro indicado ($id) ");
            return redirect(action('censo_archivosController@index'));
        }

        $toma = $censoArchivos->actualizar($request);
        if($toma->exito) {
            traza_actividad::create(['id_objeto'=>9, 'id_accion'=>4, 'codigo'=>$censoArchivos->entrevista_codigo, 'id_primaria'=>$id]);
            return redirect()->action('censo_archivosController@show',$id);
        }
        else {
            Flash::error($toma->mensaje);
            return redirect()->back()->withInput($request->all());
        }

    }

    /**
     * Remove the specified censo_archivos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        abort(403,'Operación no permitida');
        $censoArchivos = $this->censoArchivosRepository->findWithoutFail($id);

        if (empty($censoArchivos)) {
            Flash::error('Censo Archivos not found');

            return redirect(route('censoArchivos.index'));
        }

        $this->censoArchivosRepository->delete($id);

        Flash::success('Censo Archivos deleted successfully.');

        return redirect(route('censoArchivos.index'));
    }
    public  function anular($id) {
        $this->authorize('nivel-1');
        $expediente = censo_archivos::find($id);
        $expediente->id_activo = $expediente->id_activo == 1 ? 2 : 1 ;
        $expediente->save();
        $codigo = $expediente->entrevista_codigo;
        $verbo = $expediente->id_activo == 1 ? "recuperado" : "anulado";
        traza_actividad::create(['id_objeto'=>9, 'id_accion'=>10, 'referencia'=>$verbo ,'codigo'=>$expediente->entrevista_codigo, 'id_primaria'=>$id]);

        return redirect(action('censo_archivosController@show',$id));
        //return ("Expediente $codigo $verbo");

    }

    /*
     * ADJUNTOS
     */

    //Para refrescar por ajax la tabla luego del upload
    public function tabla_adjuntos($id) {
        $entrevista = censo_archivos::find($id);
        if(!$entrevista) {
            abort(403,"Registro  no existe ($id) ");
        }

        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar este registro");
        }


        return view('censo_archivos.tabla_adjuntos')->with('censoArchivo', $entrevista);
    }

    public function crear_adjunto(Request $request)
    {
        if(!isset($request->id_censo_archivos)) {
            Flash::error('Debe indicar el registro del archivo');
            return redirect()->back();
        }
        //dd($input);
        $id_censo_archivos = $request->id_censo_archivos;
        $e = censo_archivos::find($id_censo_archivos);
        if($e) {
            $nuevo = new censo_archivos_adjunto();
            $nuevo->fill($request->all());


            //Adjunto
            if($request->hasFile('archivo_4')) {
                $nombre_original=$request->file('archivo_4')->getClientOriginalName();
                $nuevo->id_adjunto = adjunto::crear_adjunto($request->archivo_4_filename, $nombre_original);
            }
            try {
                $nuevo->codigo_adjunto = $nuevo->calcular_codigo();  //en base al id_censo_archivos_adjunto
                $nuevo->save();

                traza_actividad::create(['id_objeto'=>26, 'id_accion'=>3, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$nuevo->id_censo_archivos_adjunto, 'referencia'=>$nuevo->descripcion]);
                $url = action("censo_archivosController@show",$e->id_censo_archivos)."?activar=a";
                return redirect($url);
            }
            catch (\Exception $e) {
                Flash::error('No se grabó el adjunto.  ¿dejó el nombre en blanco?');

            }


        }
        else {
            Flash::error("No existe el registro indicado($request->id_censo_archivos)");
        }
        return redirect()->back();
    }

    public function quitar_adjunto(Request $request)
    {
        $id=$request->id;
        $entrevista_adjunto = censo_archivos_adjunto::find($id);
        if (empty($entrevista_adjunto)) {
            Flash::error('Adjunto no existe');
            return redirect(action('censo_archivosConroller@index'));
        }
        $descripcion = $entrevista_adjunto->descripcion;
        $e = censo_archivos::find($entrevista_adjunto->id_censo_archivos);
        $id_adjunto =$entrevista_adjunto->id_adjunto;
        $entrevista_adjunto->delete();



        //Flash::success('Archivo adjunto eliminado.');
        traza_actividad::create(['id_objeto'=>26, 'id_accion'=>10, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_censo_archivos, 'referencia'=>"id_adjunto=$id_adjunto. $descripcion"]);
        return response()->json(true);
    }

    //Para la tabla que (ya no) se muestra
    public function editar_adjunto(Request $request)
    {
        $id=$request->id;
        $entrevista_adjunto = censo_archivos_adjunto::find($id);
        if (empty($entrevista_adjunto)) {
            Flash::error('Adjunto no existe');
            return redirect(action('censo_archivosController@index'));
        }
        $descripcion = $entrevista_adjunto->descripcion;
        $e = censo_archivos::find($entrevista_adjunto->id_censo_archivos);
        $id_adjunto =$entrevista_adjunto->id_adjunto;

        $entrevista_adjunto->delete();


        Flash::success('Archivo adjunto eliminado.');
        traza_actividad::create(['id_objeto'=>26, 'id_accion'=>4, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_censo_archivos, 'referencia'=>"id_adjunto=$id_adjunto. $descripcion"]);

        return response()->json(true);
    }

    //Adjuntos
    public function gestionar_adjuntos($id, Request $request) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $entrevista = censo_archivos::find($id);
        if (empty($entrevista)) {
            Flash::error("Registro no existe($id)");
            return redirect(route('censo_archivosController@index'));
        }
        //Ver que tenga permisos
        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar este registro");
        }
        //Permisos de escritura
        if(!$entrevista->puede_modificar_entrevista()) {
            abort(403,"No puede modificar este registro");
        }



        //Valores predeterminados
        $adjuntado = new censo_archivos_adjunto();


        return view('censo_archivos.gestionar_adjuntos')
            ->with('censoArchivo', $entrevista)
            ->with('adjuntado',$adjuntado);
    }
}
