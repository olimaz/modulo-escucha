<?php

namespace App\Http\Controllers;

use App\Exports\entrevistaExport;
use App\Exports\excel_casos_informesExport;
use App\Http\Requests\Createcasos_informesRequest;
use App\Http\Requests\Updatecasos_informesRequest;
use App\Models\adjunto;
use App\Models\casos_informes;
use App\Models\casos_informes_geo;
use App\Models\casos_informes_interes;
use App\Models\casos_informes_mandato;
use App\Models\casos_informes_sectores;
use App\Models\entrevista_individual;
use App\Models\entrevista_individual_adjunto;
use App\Models\entrevista_individual_fr;
use App\Models\entrevistador;
use App\Models\excel_casos_informes;
use App\Models\excel_traza_actividad;
use App\Models\traza_actividad;
use App\Repositories\casos_informesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class casos_informesController extends AppBaseController
{
    /** @var  casos_informesRepository */
    private $casosInformesRepository;

    public function __construct(casos_informesRepository $casosInformesRepo)
    {
        $this->casosInformesRepository = $casosInformesRepo;
    }

    /**
     * Display a listing of the casos_informes.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $filtros = casos_informes::filtros_default($request);
        //dd($request);

        //dd($filtros);

        $query = casos_informes::filtrar($filtros)->ordenar();
        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();
        //dd($debug);
        $casosInformes = $query->paginate();
        //dd($casosInformes);

        $txt_titulo = "Casos e Informes";

        return view('casos_informes.index')
            ->with('filtros', $filtros)
            ->with('txt_titulo',$txt_titulo)
            ->with('casosInformes', $casosInformes);
    }

    /**
     * Show the form for creating a new casos_informes.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //dd($request);
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
                abort(403,"No puede ingresar casos para el entrevistador especificado: $numero");
            }
        }


        $casosInformes = new casos_informes();
        $casosInformes->id_subserie=config('expedientes.ci');
        $casosInformes->id_entrevistador=$id_entrevistador;
        $casosInformes->registro_fecha = date("Y-m-d");
        $casosInformes->recepcion_fecha = date("Y-m-d");
        $casosInformes->caracterizacion_fecha_caracterizacion= date("Y-m-d");
        $casosInformes->id_territorio = \Auth::user()->rel_entrevistador->id_territorio;
        $casosInformes->entrega_id_geo = \Auth::user()->rel_entrevistador->id_ubicacion;
        $casosInformes->receptor_nombre = \Auth::user()->name;
        return view('casos_informes.create',compact('casosInformes'));
    }

    /**
     * Store a newly created casos_informes in storage.
     *
     * @param Createcasos_informesRequest $request
     *
     * @return Response
     */
    public function store(Createcasos_informesRequest $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $id_entrevistador=\Auth::user()->id_entrevistador;
        if(isset($request->id_entrevistador)) {
            $permitidos = entrevistador::permitidos_acceso_entrevistas();
            if(in_array($request->id_entrevistador,$permitidos)) {
                $id_entrevistador=intval($request->id_entrevistador);
            }
            else {
                $quien = entrevistador::find($request->id_entrevistador);
                $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,5,'0',STR_PAD_LEFT) : "[desconocido]";
                abort(403,"No puede ingresar casos/informes para el entrevistador especificado: $numero");
            }
        }

        //Calcular el código según función de entrevista_individual
        $caso = new casos_informes();
        $caso->id_entrevistador=$id_entrevistador;
        $caso->id_subserie = config('expedientes.ci');
        $caso_codigo = $caso->asignar_codigo();  //asigna correlativo y codigo

        //dd($request);


        $input = $request->all();
        //Remiendo: por baboso estos campos se llaman diferente en e_ind_fvt
        $input['clasifica_nna'] = $request->clasificacion_nna;
        $input['clasifica_res']  = $request->clasificacion_res;
        $input['clasifica_sex']  = $request->clasificacion_sex;
        $input['clasifica_r1']  = $request->clasificacion_r1;
        $input['clasifica_r2']  = $request->clasificacion_r2;
        //Fin del remiendo
        //Datos calculados
        $input['correlativo']=$caso->correlativo;
        $input['codigo']=$caso_codigo;
        $input['id_entrevistador']=$id_entrevistador;
        $input['registro_fecha']=date("Y-m-d");
        $input['caracterizacion_fecha_caracterizacion']=date("Y-m-d");
        $input['id_macroterritorio']=$request->id_territorio_macro;
        //Manejo de fechas
        $input['recepcion_fecha']=$request->recepcion_fecha_submit;
        $input['caracterizacion_fecha_elaboracion']=$request->caracterizacion_fecha_elaboracion_submit;
        $input['caracterizacion_fecha_publicacion']=$request->caracterizacion_fecha_publicacion_submit;

        try {
            $nueva = casos_informes::create($input);
            $nueva->clasificar_acceso();
            $nueva->save();

            //Mandato
            if(!is_array($request->mandato)) {
                $request->mandato=array($request->mandato);
            }
            foreach($request->mandato as $id) {
                $tmp['id_casos_informes'] = $nueva->id_casos_informes;
                $tmp['id_mandato']=$id;
                casos_informes_mandato::create($tmp);
            }
            //Interes
            if(!is_array($request->interes)) {
                $request->interes=array($request->interes);
            }
            foreach($request->interes as $id) {
                $tmp['id_casos_informes'] = $nueva->id_casos_informes;
                $tmp['id_interes']=$id;
                casos_informes_interes::create($tmp);
            }
            //Actores Armados, poblaciones, ocupaciones
            if(!is_array($request->id_item)) {
                $request->id_item=array($request->id_item);
            }
            foreach($request->id_item as $id) {
                $tmp['id_casos_informes'] = $nueva->id_casos_informes;
                $tmp['id_item']=$id;
                casos_informes_sectores::create($tmp);
            }
            //Cobertura geográfica
            $insertar=array();
            foreach($request->id_geo_depto as $id=>$id_depto) {
                $valor=-1;
                if($id_depto >0) {
                    $valor=$id_depto;
                    if($request->id_geo_muni[$id] > 0) {
                        $valor=$request->id_geo_muni[$id];
                        if($request->id_geo[$id] > 0) {
                            $valor=$request->id_geo[$id];
                        }
                    }
                }
                if($valor>0) {
                    $insertar[]=$valor;
                }
            }
            foreach($insertar as $id_geo) {
                casos_informes_geo::create(['id_casos_informes'=>$nueva->id_casos_informes, 'id_geo'=>$id_geo]);
            }


            Flash::success('Información almacenada exitosamente.');
            //Traza de seguridad
            traza_actividad::create(['id_objeto'=>3, 'id_accion'=>3, 'codigo'=>$nueva->codigo, 'id_primaria'=>$nueva->id_casos_informes]);

            return redirect()->action('casos_informesController@show',$nueva->id_casos_informes);

        }
        catch (\Exception $e) {
            Flash::error('Problemas al grabar la información: '.$e->getMessage());
            return redirect(action('entrevista_individualController@index'));
        }

        return redirect(route('casosInformes.index'));
    }

    /**
     * Display the specified casos_informes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {

        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $casosInformes = $this->casosInformesRepository->findWithoutFail($id);
        /*
        if (empty($casosInformes)) {
            Flash::error('Casos Informes not found');
            return redirect(route('casosInformes.index'));
        }
        if(!\Gate::allows('es-propio',$casosInformes->id_entrevistador)) {
            $id_entrevistador=$casosInformes->id_entrevistador;
            $permitidos = entrevistador::permitidos_acceso_entrevistas();
            if(!in_array($id_entrevistador,$permitidos)) {
                $quien = entrevistador::find($casosInformes->id_entrevistador);
                $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,5,'0',STR_PAD_LEFT) : "[desconocido]";
                abort(403,"No puede consultar casos/informes para el entrevistador especificado: $numero");
            }
        }
        */

        traza_actividad::create(['id_objeto'=>3, 'id_accion'=>6, 'codigo'=>$casosInformes->codigo,  'id_primaria'=>$casosInformes->id_casos_informes]);

        $txt_titulo = "C/I ".$casosInformes->codigo;
        return view('casos_informes.show')->with('casosInformes', $casosInformes)->with('txt_titulo',$txt_titulo);
    }

    /**
     * Show the form for editing the specified casos_informes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $casosInformes=casos_informes::find($id);

        if (empty($casosInformes)) {
            Flash::error("Casos/Informe no existe ($id)");
            return redirect(route('casosInformes.index'));
        }



        //Revisar privilegios
        if(!$casosInformes->puede_modificar_entrevista()) {
            abort(403, "No puede modificar el caso/informe.");
        }



        return view('casos_informes.edit')->with('casosInformes', $casosInformes);
    }

    /**
     * Update the specified casos_informes in storage.
     *
     * @param  int              $id
     * @param Updatecasos_informesRequest $request
     *
     * @return Response
     */
    public function update($id, Updatecasos_informesRequest $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $casosInformes=casos_informes::find($id);
        if (empty($casosInformes)) {
            Flash::error("Casos/Informe no existe ($id)");
            return redirect(route('casosInformes.index'));
        }

        $input = $request->all();
        //Remiendo: por baboso estos campos se llaman diferente en e_ind_fvt
        $input['clasifica_nna'] = $request->clasificacion_nna;
        $input['clasifica_res']  = $request->clasificacion_res;
        $input['clasifica_sex']  = $request->clasificacion_sex;
        $input['clasifica_r1']  = $request->clasificacion_r1;
        $input['clasifica_r2']  = $request->clasificacion_r2;
        //Fin del remiendo
        //El correlativo no puede cambiar
        unset($input['correlativo']);
        //El codigo no puede cambiar
        unset($input['codigo']);
        //El entrevistador no puede cambiar
        unset($input['id_entrevistador']);

        //DAtos calculados
        $input['id_macroterritorio'] = $request->id_territorio_macro;
        //Manejo de fechas
        $input['recepcion_fecha']=$request->recepcion_fecha_submit;
        $input['caracterizacion_fecha_elaboracion']=$request->caracterizacion_fecha_elaboracion_submit;
        $input['caracterizacion_fecha_publicacion']=$request->caracterizacion_fecha_publicacion_submit;

        $casosInformes->fill($input);
        $casosInformes->clasificar_acceso();
        $casosInformes->save();

        //Entidades debiles
        try {
            //Intereses
            $casosInformes->rel_intereses()->delete();
            if (!is_array($request->interes)) {
                $request->interes = array($request->interes);
            }
            foreach ($request->interes as $id) {
                $tmp['id_casos_informes'] = $casosInformes->id_casos_informes;
                $tmp['id_interes'] = $id;
                $adjunto_fr = casos_informes_interes::create($tmp);
            }
            //Puntos del mandato
            $casosInformes->rel_mandato()->delete();
            if (!is_array($request->mandato)) {
                $request->mandato = array($request->mandato);
            }
            foreach ($request->mandato as $id) {
                $tmp['id_casos_informes'] = $casosInformes->id_casos_informes;
                $tmp['id_mandato'] = $id;
                $adjunto_fr = casos_informes_mandato::create($tmp);
            }
            //Actores Armados, poblaciones, ocupaciones
            $casosInformes->rel_sectores()->delete();
            if(!is_array($request->id_item)) {
                $request->id_item=array($request->id_item);
            }
            foreach($request->id_item as $id) {
                $tmp['id_casos_informes'] = $casosInformes->id_casos_informes;
                $tmp['id_item']=$id;
                casos_informes_sectores::create($tmp);
            }
            //Cobertura geográfica
            $casosInformes->rel_casos_informes_geo()->delete();
            $insertar=array();
            foreach($request->id_geo_depto as $id=>$id_depto) {
                $valor=-1;
                if($id_depto >0) {
                    $valor=$id_depto;
                    if($request->id_geo_muni[$id] > 0) {
                        $valor=$request->id_geo_muni[$id];
                        if($request->id_geo[$id] > 0) {
                            $valor=$request->id_geo[$id];
                        }
                    }
                }
                if($valor>0) {
                    $insertar[]=$valor;
                }
            }
            foreach($insertar as $id_geo) {
                casos_informes_geo::create(['id_casos_informes'=>$casosInformes->id_casos_informes, 'id_geo'=>$id_geo]);
            }

        }
        catch (\Exception $e) {
            //Generalmente el error es por duplicidad de llave primaria, lo registro y continúo
            Log::error('Problema al actualizar caso e informe: '.PHP_EOL.$e->getMessage());
            //Flash::error('Problemas al grabar la información: '.$e->getMessage());
            //return redirect(action('entrevista_individualController@index'));
        }

        Flash::success('Caso/informe actualizado.');
        traza_actividad::create(['id_objeto'=>3, 'id_accion'=>4, 'codigo'=>$casosInformes->codigo,  'id_primaria'=>$casosInformes->id_casos_informes]);
        return redirect(action("casos_informesController@show",$casosInformes->id_casos_informes));
    }

    /**
     * Remove the specified casos_informes from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        abort(403);
        $casosInformes = $this->casosInformesRepository->findWithoutFail($id);

        if (empty($casosInformes)) {
            Flash::error('Casos Informes not found');

            return redirect(route('casosInformes.index'));
        }

        $this->casosInformesRepository->delete($id);

        Flash::success('Casos Informes deleted successfully.');

        return redirect(route('casosInformes.index'));
    }


    //Para la gestión de adjuntos
    public function gestionar_adjuntos($id) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $casosInformes = $this->casosInformesRepository->findWithoutFail($id);

        if (empty($casosInformes)) {
            Flash::error("Caso/Informeno existe($id)");
            return redirect(route('casosInformes.index'));
        }

        if(!\Gate::allows('es-propio',$casosInformes->id_entrevistador)) {
            $this->authorize('escritura');
            $id_entrevistador=$casosInformes->id_entrevistador;
            $permitidos = entrevistador::permitidos_acceso_entrevistas();
            //dd($permitidos);
            if(!in_array($id_entrevistador,$permitidos)) {
                $quien = entrevistador::find($casosInformes->id_entrevistador);
                $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,5,'0',STR_PAD_LEFT) : "[desconocido]";
                abort(403,"No puede modificar casos para el entrevistador especificado: $numero");
            }
        }
        if($casosInformes->clasifica_nivel == 3) {
            if(\Gate::allows('transcriptor',$casosInformes->id_casos_informes)) {
                //Permitir el acceso
            }
            else {
                if(!\Gate::allows('es-propio',$casosInformes->id_entrevistador)) {
                    if (!$casosInformes->puede_acceder()) {
                        abort(403, "No puede consultar adjuntos para un expediente RESERVADO-3");
                    }
                }
            }
        }


        return view('casos_informes.gestionar_adjuntos')->with('casosInformes', $casosInformes);

    }


    //Para refrescar por ajax la tabla luego del upload
    public function tabla_adjuntos($id) {

        $padre = casos_informes::find($id);


        if(!\Gate::allows('es-propio',$padre->id_entrevistador)) {
            $id_entrevistador=$padre->id_entrevistador;
            $permitidos = entrevistador::permitidos_acceso_entrevistas();
            if(!in_array($id_entrevistador,$permitidos)) {
                $quien = entrevistador::find($request->id_entrevistador);
                $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,5,'0',STR_PAD_LEFT) : "[desconocido]";
                abort(403,"No puede modificar casos/informes para el entrevistador especificado: $numero");
            }
        }

        return view('casos_informes.tabla_adjuntos')->with('casosInformes', $padre);

    }

    //Recibe el post del formulario de agregar mas adjuntos
    public function agregar_adjuntos($id, Request $request) {
        //Ver que exista
        $padre = casos_informes::find($id);
        if (empty($padre)) {
            Flash::error("Caso/Informeno existe($id)");
            return redirect(route('casosInformes.index'));
        }
        if(!\Gate::allows('es-propio',$padre->id_entrevistador)) {
            $id_entrevistador=$padre->id_entrevistador;
            $permitidos = entrevistador::permitidos_acceso_entrevistas();
            if(!in_array($id_entrevistador,$permitidos)) {
                $quien = entrevistador::find($request->id_entrevistador);
                $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,5,'0',STR_PAD_LEFT) : "[desconocido]";
                abort(403,"No puede modificar casos/informes para el entrevistador especificado: $numero");
            }
        }

        //Agregar los archivos

        if(!empty($request->archivo_ci_filename)) {
            $archivo = str_replace("/storage/","/",$request->archivo_ci_filename);  //Quitar /storage/ al inicio
            $adjunto = adjunto::create(['ubicacion'=>$archivo]);
            $tmp['id_casos_informes'] = $id;
            $tmp['id_adjunto']=$adjunto->id_adjunto;
            $tmp['id_tipo']=1;
            $adjunto_rel = entrevista_individual_adjunto::create($tmp);
        }
        //Audio
        if(!empty($request->archivo_audio_filename)) {
            $archivo = str_replace("/storage/","/",$request->archivo_audio_filename);  //Quitar /storage/ al inicio
            $adjunto = adjunto::create(['ubicacion'=>$archivo]);
            $tmp['id_e_ind_fvt'] = $id;
            $tmp['id_adjunto']=$adjunto->id_adjunto;
            $tmp['id_tipo']=2;
            $adjunto_rel = entrevista_individual_adjunto::create($tmp);
        }
        //Fichas entrevista
        if(!empty($request->archivo_fichas_filename)) {
            $archivo = str_replace("/storage/","/",$request->archivo_fichas_filename);  //Quitar /storage/ al inicio
            $adjunto = adjunto::create(['ubicacion'=>$archivo]);
            $tmp['id_e_ind_fvt'] = $id;
            $tmp['id_adjunto']=$adjunto->id_adjunto;
            $tmp['id_tipo']=3;
            $adjunto_rel = entrevista_individual_adjunto::create($tmp);
        }
        //Otros
        if(!empty($request->archivo_otro_filename)) {
            $archivo = str_replace("/storage/","/",$request->archivo_otro_filename);  //Quitar /storage/ al inicio
            $adjunto = adjunto::create(['ubicacion'=>$archivo]);
            $tmp['id_e_ind_fvt'] = $id;
            $tmp['id_adjunto']=$adjunto->id_adjunto;
            $tmp['id_tipo']=4;
            $adjunto_rel = entrevista_individual_adjunto::create($tmp);
        }

        Flash::success("Archivos agregados exitosamente");
        return redirect(action('casos_informesController@gestionar_adjuntos',$id));


    }

    public function actualizar_vista() {
        $inicio = \Carbon\Carbon::now();
        $total = excel_casos_informes::generar_plana();
        $fin= \Carbon\Carbon::now();
        $tiempo = $inicio->diffForHumans($fin);
        $respuesta=new \stdClass();
        $respuesta->inicio=$inicio;
        $respuesta->fin=$fin;
        $respuesta->tiempo=$tiempo;
        $respuesta->filas=$total;
        return response()->json($respuesta);
    }

    public function excel_plano() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>8]);
        return Excel::download(new excel_casos_informesExport,"casos_informes_$fecha.xlsx");
    }

    // Anular/recuperar un registro

    public  function anular($id) {
        $this->authorize('nivel-1');
        $expediente = casos_informes::find($id);
        $expediente->id_activo = $expediente->id_activo == 1 ? 2 : 1 ;
        $expediente->save();
        $codigo = $expediente->entrevista_codigo;
        $verbo = $expediente->id_activo == 1 ? "recuperado" : "anulado";
        traza_actividad::create(['id_objeto'=>3, 'id_accion'=>10, 'referencia'=>$verbo ,'codigo'=>$codigo, 'id_primaria'=>$id]);
        return redirect(action('casos_informesController@show',$id));

    }

    /*
     * GENERAR JSON
     */
    /**
     * json para dublin core
     */
    public function json_dublin(casos_informes $caso) {
        $info =$caso->generar_dublin();
        //return \GuzzleHttp\json_encode($info->objeto);
        //$json = json_encode($info->objeto);
        $titulo = "Casos e informes: $caso->codigo <small> equivalencia a Dublin Core</small>";
        return view('layouts.json', compact('info','titulo'));



        //$json = \GuzzleHttp\json_encode($info->objeto);
        //$json_string = json_encode($info->objeto, JSON_PRETTY_PRINT);
        //return $json_string;

    }
}
