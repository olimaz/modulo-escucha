<?php

namespace App\Http\Controllers;

use App\Exports\excel_coExport;
use App\Exports\excel_ee_filtradoExport;
use App\Exports\excel_sujeto_colectivoExport;
use App\Http\Requests\Createentrevista_colectivaRequest;
use App\Http\Requests\Updateentrevista_colectivaRequest;
use App\Models\adjunto;
use App\Models\entrevista_colectiva;
use App\Models\entrevista_colectiva_adjunto;
use App\Models\entrevista_colectiva_dinamica;
use App\Models\entrevista_colectiva_interes;
use App\Models\entrevista_colectiva_mandato;
use App\Models\entrevista_etnica;
use App\Models\entrevista_individual;
use App\Models\entrevista_profundidad;
use App\Models\entrevistador;
use App\Models\excel_co;
use App\Models\excel_sujeto_colectivo;
use App\Models\traza_actividad;
use App\Repositories\entrevista_colectivaRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class entrevista_colectivaController extends AppBaseController
{
    /** @var  entrevista_colectivaRepository */
    private $entrevistaColectivaRepository;

    public function __construct(entrevista_colectivaRepository $entrevistaColectivaRepo)
    {
        $this->entrevistaColectivaRepository = $entrevistaColectivaRepo;

    }

    /**
     * Display a listing of the entrevista_colectiva.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }


        $filtros = entrevista_colectiva::filtros_default($request);
        //dd($filtros);


        $query = entrevista_colectiva::filtrar($filtros)->ordenar();
            //$debug['sql']= nl2br($query->toSql());
            //$debug['criterios']=$query->getBindings();
            //dd($debug);
        $entrevistaColectivas = $query->select(\DB::raw('entrevista_colectiva.*'))->paginate();
        $total_entrevistas = $entrevistaColectivas->total();  //Para el formulario de filtros


        $txt_titulo = "Entrevistas CO";
        return view('entrevista_colectivas.index')
            ->with('entrevistaColectivas', $entrevistaColectivas)
            ->with('total_entrevistas', $total_entrevistas)
            ->with('txt_titulo',$txt_titulo)
            ->with('filtros', $filtros);
    }

    /**
     * Show the form for creating a new entrevista_colectiva.
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
        $entrevistaColectiva = new entrevista_colectiva();
        $entrevistaColectiva->valores_iniciales($id_entrevistador);
        //dd($entrevistaColectiva);

        return view('entrevista_colectivas.create', compact('entrevistaColectiva'));
    }

    /**
     * Store a newly created entrevista_colectiva in storage.
     *
     * @param Createentrevista_colectivaRequest $request
     *
     * @return Response
     */
    public function store(Createentrevista_colectivaRequest $request) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $id_entrevistador=intval($request->id_entrevistador);

        //Validar número de entrevista
        $entrevista_numero = intval($request->entrevista_numero);
        $existe = entrevista_colectiva::where('id_entrevistador',$id_entrevistador)
            ->where('entrevista_numero',$entrevista_numero)
            ->first();
        if(!empty($existe)) {
            Flash::error("Número de entrevista en uso.  No puede duplicar el número $request->entrevista_numero");
            return redirect()->back()->withInput($request->all());
        }

        //Calcular el código
        $entrevista = new entrevista_colectiva();
        $entrevista->id_entrevistador=$id_entrevistador;
        $codigo = $entrevista->asignar_codigo($id_entrevistador);  //asigna correlativo y codigo


        $input = $request->all();
        //Datos calculados
        $input['entrevista_correlativo']=$entrevista->entrevista_correlativo;
        $input['entrevista_codigo']=$codigo;
        $input['id_entrevistador']=$id_entrevistador;
        $input['id_macroterritorio']=$request->id_territorio_macro;
        $input['id_usuario']=\Auth::user()->id;
        $input['numero_entrevistador']=entrevistador::find($id_entrevistador)->numero_entrevistador;

        //Manejo de fechas
        $input['entrevista_fecha_inicio']=$request->entrevista_fecha_inicio_submit;
        $input['entrevista_fecha_final']=$request->entrevista_fecha_final_submit;
        //$f_hechos=explode(" - ",$request->tema_rango);
        $input['tema_del'] = Carbon::createFromFormat("Y/m/d",$request->tema_anio_del."/01/01")->format("Y-m-d");
        $input['tema_al']  = Carbon::createFromFormat("Y/m/d",$request->tema_anio_al."/12/31")->format("Y-m-d");

        try {
            $nueva = new entrevista_colectiva();
            $nueva->fill($input);
            $nueva->clasificar_acceso();
            $nueva->save();

            //Mandato
            if(!is_array($request->mandato)) {
                $request->mandato=array($request->mandato);
            }
            foreach($request->mandato as $id) {
                $tmp['id_entrevista_colectiva'] = $nueva->id_entrevista_colectiva;
                $tmp['id_mandato']=$id;
                entrevista_colectiva_mandato::create($tmp);
            }
            // Nucleos tematicos
            if(!is_array($request->interes)) {
                $request->interes=array($request->interes);
            }
            foreach($request->interes as $id) {
                $tmp['id_entrevista_colectiva'] = $nueva->id_entrevista_colectiva;
                $tmp['id_interes']=$id;
                entrevista_colectiva_interes::create($tmp);
            }
            //Dinámicas
            if(!is_array($request->dinamica)) {
                $request->dinamica=array($request->dinamica);
            }
            foreach($request->dinamica as $txt) {
                if(strlen($txt)>0) {
                    $tmp['id_entrevista_colectiva'] = $nueva->id_entrevista_colectiva;
                    $tmp['dinamica'] = $txt;
                    entrevista_colectiva_dinamica::create($tmp);
                }
            }


            Flash::success('Información almacenada exitosamente.');
            //Traza de seguridad
            traza_actividad::create(['id_objeto'=>10, 'id_accion'=>3, 'codigo'=>$codigo, 'id_primaria'=>$nueva->id_entrevista_colectiva]);

            return redirect()->action('entrevista_colectivaController@gestionar_adjuntos',$nueva->id_entrevista_colectiva);

        }
        catch (\Exception $e) {
            Flash::error('Problemas al grabar la información: '.$e->getMessage());
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified entrevista_colectiva.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //Negar acceso a los de solo estadistica
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        //1: Confirmar que  que exista
        $entrevistaColectiva = $this->entrevistaColectivaRepository->findWithoutFail($id);
        if (empty($entrevistaColectiva)) {
            Flash::error("Entrevista Colectiva no existe($id)");
            return redirect(action('entrevista_colectivaController@index'));
        }

        //2: Confirmar acceso del usuario a la entrevista
        if(!$entrevistaColectiva->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Registrar traza
        traza_actividad::create(['id_objeto'=>10, 'id_accion'=>6, 'codigo'=>$entrevistaColectiva->entrevista_codigo, 'id_primaria'=>$id]);


        $txt_titulo = "Ent. ".$entrevistaColectiva->entrevista_codigo;
        return view('entrevista_colectivas.show')->with('entrevistaColectiva', $entrevistaColectiva)
                                        ->with('txt_titulo',$txt_titulo);
    }

    /**
     * Show the form for editing the specified entrevista_colectiva.
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
        $entrevistaColectiva = entrevista_colectiva::find($id);
        if (empty($entrevistaColectiva)) {
            Flash::error('Entrevista colectiva no existe');
            return redirect(action('entrevista_colectivaController@index'));
        }
        if(!$entrevistaColectiva->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }
        //Permisos de escritura
        if(!$entrevistaColectiva->puede_modificar_entrevista()) {
            abort(403,"No puede modificar esta entrevista");
        }



        return view('entrevista_colectivas.edit')->with('entrevistaColectiva', $entrevistaColectiva);
    }

    /**
     * Update the specified entrevista_colectiva in storage.
     *
     * @param  int              $id
     * @param Updateentrevista_colectivaRequest $request
     *
     * @return Response
     */
    public function update($id, Updateentrevista_colectivaRequest $request) {
        $entrevista = entrevista_colectiva::find($id);
        if (empty($entrevista)) {
            Flash::error("Entrevista colectiva ($id) no existe");
            return redirect(action('entrevista_colectivaController@index'));
        }
        //Leer el request y meterlo a un arreglo
        $input = $request->all();

        //Revisar que el número no se duplique
        $existe = entrevista_colectiva::where('id_entrevistador',$request->id_entrevistador)
            ->where('entrevista_numero',$request->entrevista_numero)
            ->where('id_entrevista_colectiva','<>',$id)
            ->first();
        if(!empty($existe)) {
            Flash::error("Número de entrevista en uso.  No puede duplicar el número $request->entrevista_numero");
            return redirect()->back()->withInput($request->all());
        }
        //Datos Calculados
        //El correlativo no puede cambiar
        unset($input['entrevista_correlativo']);
        //El entrevistador no puede cambiar
        unset($input['id_entrevistador']);
        //El numero de entrevistador no puede cambiar
        unset($input['numero_entrevistador']);


        //Macroterritorio
        $input['id_macroterritorio'] = $request->id_territorio_macro;
        //Fechas
        $input['entrevista_fecha_inicio']=$request->entrevista_fecha_inicio_submit;
        $input['entrevista_fecha_final']=$request->entrevista_fecha_final_submit;
        $input['tema_del'] = Carbon::createFromFormat("Y/m/d",$request->tema_anio_del."/01/01")->format("Y-m-d");
        $input['tema_al']  = Carbon::createFromFormat("Y/m/d",$request->tema_anio_al."/12/31")->format("Y-m-d");
        //dd($input);

        //Actualizar la BD
        $entrevista->fill($input);
        //Clasificar reservada-3 o reservada-4
        $entrevista->clasificar_acceso();
        //Recalcular el código, usar el entrevistador que tiene, no el logueado por aquello que otro lo modifique
        $entrevista->entrevista_codigo = $entrevista->calcular_codigo();
        //Grabar en la BD
        $entrevista->save();

        //Entidades débiles
        $entrevista->rel_mandato()->delete();
        if(!is_array($request->mandato)) {
            $request->mandato=array($request->mandato);
        }
        foreach($request->mandato as $id) {
            $tmp['id_entrevista_colectiva'] = $entrevista->id_entrevista_colectiva;
            $tmp['id_mandato']=$id;
            $registro = entrevista_colectiva_mandato::create($tmp);
        }
        // Nucleos tematicos
        $entrevista->rel_interes()->delete();
        if(!is_array($request->interes)) {
            $request->interes=array($request->interes);
        }
        foreach($request->interes as $id) {
            $tmp['id_entrevista_colectiva'] = $entrevista->id_entrevista_colectiva;
            $tmp['id_interes']=$id;
            entrevista_colectiva_interes::create($tmp);
        }
        //Dinámicas
        $entrevista->rel_dinamica()->delete();
        if(!is_array($request->dinamica)) {
            $request->dinamica=array($request->dinamica);
        }
        foreach($request->dinamica as $txt) {
            if(strlen($txt)>0) {
                $tmp['id_entrevista_colectiva'] = $entrevista->id_entrevista_colectiva;
                $tmp['dinamica'] = $txt;
                entrevista_colectiva_dinamica::create($tmp);
            }
        }

        //Registrar traza
        traza_actividad::create(['id_objeto'=>10, 'id_accion'=>4, 'codigo'=>$entrevista->entrevista_codigo , 'id_primaria'=>$entrevista->id_entrevista_colectiva]);
        // Notificar y redirigir
        Flash::success('Entrevista actualizada.');
        return redirect(action("entrevista_colectivaController@show",$entrevista->id_entrevista_colectiva));

    }

    /**
     * Remove the specified entrevista_colectiva from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        abort(403);
        $entrevistaColectiva = $this->entrevistaColectivaRepository->findWithoutFail($id);

        if (empty($entrevistaColectiva)) {
            Flash::error('Entrevista Colectiva not found');

            return redirect(route('entrevistaColectivas.index'));
        }

        $this->entrevistaColectivaRepository->delete($id);

        Flash::success('Entrevista Colectiva deleted successfully.');

        return redirect(route('entrevistaColectivas.index'));
    }
    //Para la gestión de adjuntos
    public function gestionar_adjuntos($id) {

        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $entrevista = entrevista_colectiva::find($id);


        if (empty($entrevista)) {
            Flash::error("Entrevista colectiva no existe($id)");
            return redirect(route('entrevista_colectivaController@index'));
        }


        //Ver que tenga permisos
        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Permisos de escritura
        if(!$entrevista->puede_modificar_entrevista()) {
            abort(403,"No puede modificar esta entrevista");
        }


        //Segundo chequeo: reservado-3
        if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
        }



        return view('entrevista_colectivas.gestionar_adjuntos')->with('entrevistaColectiva', $entrevista);
    }


    //Para refrescar por ajax la tabla luego del upload
    public function tabla_adjuntos($id) {
        $entrevista = entrevista_colectiva::find($id);
        if(!$entrevista) {
            abort(403,"Entrevista ($id) no existe");
        }

        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        return view('entrevista_colectivas.tabla_adjuntos')->with('entrevistaColectiva', $entrevista);
    }


    //PAra los autofill
    public function autofill_tema_descripcion(Request $request) {
        return entrevista_colectiva::listar_opciones_campo('tema_descripcion',$request->texto);
    }
    public function autofill_tema_objetivo(Request $request) {
        return entrevista_colectiva::listar_opciones_campo('tema_objetivo',$request->texto);
    }
    public function autofill_eventos_descripcion(Request $request) {
        return entrevista_colectiva::listar_opciones_campo('eventos_descripcion',$request->texto);
    }
    public function autofill_observaciones(Request $request) {
        return entrevista_colectiva::listar_opciones_campo('observaciones',$request->texto);
    }
    public function autofill_titulo(Request $request) {
        return entrevista_colectiva::listar_opciones_campo('titulo',$request->texto);
    }
    public function autofill_dinamica(Request $request) {
        return entrevista_colectiva::listar_opciones_dinamica($request->texto);
    }


    //Autorizar acceso a R3 y R4
    public function desclasificar($id)
    {
        //Negar acceso a los de solo estadistica
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        //1: Confirmar que  que exista
        $entrevistaColectiva =entrevista_colectiva::find($id);
        if (empty($entrevistaColectiva)) {
            abort(403, "No existe la entrevista indicada:$id");
        }

        //2: Confirmar acceso del usuario a la entrevista
        if(!$entrevistaColectiva->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Revisar privilegios de R3
        if(!$entrevistaColectiva->puede_desclasificar_entrevista()) {
            abort(403, "No puede modificar la entrevista.");
        }

        //Revisar que requiera clasificacion
        if($entrevistaColectiva->clasificacion_nivel > 3 ) {
            abort(403, "Esta es una entrevista clasificacion R-$entrevistaColectiva->clasificacion_nivel.");
        }



        return view('entrevista_colectivas.desclasificar',compact('entrevistaColectiva'));
    }

    //Mostar los formularios
    public  function anular($id) {
        $this->authorize('nivel-1');
        $expediente = entrevista_colectiva::find($id);
        $expediente->id_activo = $expediente->id_activo == 1 ? 2 : 1 ;
        $expediente->save();
        $codigo = $expediente->entrevista_codigo;
        $verbo = $expediente->id_activo == 1 ? "recuperado" : "anulado";
        //return ("Expediente $codigo $verbo");
        //Registrar traza
        traza_actividad::create(['id_objeto'=>10, 'id_accion'=>10, 'referencia'=>$verbo ,'codigo'=>$expediente->entrevista_codigo, 'id_primaria'=>$id]);

        return redirect(action('entrevista_colectivaController@show',$id));

    }

    ////////EXCELITO

    //Generar tabla plana
    public function generar_excel_plano() {
        $respuesta = excel_co::generar_plana();
        return response()->json($respuesta);
    }


    //Descargar tabla plana para resultados específicos
    public function generar_excel_filtrado(Request $request) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $filtros = entrevista_colectiva::filtros_default($request);
        //dd($filtros);
        $query = entrevista_colectiva::filtrar($filtros);
        //$debug['sql']= nl2br($query->toSql());
        //$debug['criterios']=$query->getBindings();
        //dd($debug);
        //$cantidad = $filtros->id_entrevistador == optional(\Auth::user())->id_entrevistador ? 30 : 15;
        $arreglo = $query->orderby('entrevista_colectiva.id_entrevista_colectiva')->pluck('entrevista_colectiva.id_entrevista_colectiva')->toArray();

        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>10, 'id_accion'=>8]);

        $anonimo = \Gate::denies('nivel-1');
        $txt = $anonimo ? '_anom_' : '_';

        return Excel::download(new excel_coExport($arreglo,$anonimo),"entrevistas_colectivas$txt$fecha.xlsx");
    }


    //Convierte en EE
    public static function trasladar_ee($id) {
        $existe = entrevista_colectiva::find($id);
        if($existe) {
            $nueva = $existe->trasladar_ee();
            if($nueva) {
                Flash::success("Entrevista guardada como $nueva->entrevista_codigo");
                return redirect()->action('entrevista_etnicaController@show',$nueva->id_entrevista_etnica);
            }
            else {
                Flash::error('Hubo prolemas con el traslado de la entrevista');
                return redirect()->back();
            }
        }
        else {
            Flash::error("No existe la entrevista a profundidad $id");
            return redirect()->back();
        }

    }

}
