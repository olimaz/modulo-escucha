<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createetiquetar_asignacionRequest;
use App\Http\Requests\Updateetiquetar_asignacionRequest;
use App\Models\diagnostico_comunitario;
use App\Models\entrevista_colectiva;
use App\Models\entrevista_etnica;
use App\Models\entrevista_individual;
use App\Models\entrevista_profundidad;
use App\Models\etiquetar_asignacion;
use App\Models\excel_asignaciones_etiquetado;
use App\Models\historia_vida;
use App\Models\prioridad;
use App\Models\procesamiento_tiempo;
use App\Models\seguimiento;
use App\Models\transcribir_asignacion;
use App\Models\traza_actividad;
use App\Repositories\etiquetar_asignacionRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class etiquetar_asignacionController extends AppBaseController
{
    /** @var  etiquetar_asignacionRepository */
    private $etiquetarAsignacionRepository;

    public function __construct(etiquetar_asignacionRepository $etiquetarAsignacionRepo)
    {
        $this->etiquetarAsignacionRepository = $etiquetarAsignacionRepo;
    }

    /**
     * Display a listing of the etiquetar_asignacion.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = etiquetar_asignacion::filtros_default($request);
        $etiquetarAsignacions = etiquetar_asignacion::filtrar($filtros)->ordenar()->paginate(50);

        //dd($etiquetarAsignacions);


        return view('etiquetar_asignacions.index')
            ->with('filtros', $filtros)
            ->with('etiquetarAsignacions', $etiquetarAsignacions);
        /*

        $this->etiquetarAsignacionRepository->pushCriteria(new RequestCriteria($request));
        $etiquetarAsignacions = $this->etiquetarAsignacionRepository->all();

        return view('etiquetar_asignacions.index')
            ->with('etiquetarAsignacions', $etiquetarAsignacions);
        */
    }

    /**
     * Show the form for creating a new etiquetar_asignacion.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $niveles=[10,1,2];
        $this->authorize('revisar-m-nivel', [$niveles]);

        $etiquetarAsignacion = new etiquetar_asignacion();
        $etiquetarAsignacion->urgente=2;
        if(isset($request->id)) {
            $e = entrevista_individual::find($request->id);
            $etiquetarAsignacion->id_e_ind_fvt=$request->id;
        }
        elseif(isset($request->id_pr)) {
            $e = entrevista_profundidad::find($request->id_pr);
            $etiquetarAsignacion->id_entrevista_profundidad=$request->id_pr;
        }
        elseif(isset($request->id_co)) {
            $e = entrevista_colectiva::find($request->id_co);
            $etiquetarAsignacion->id_entrevista_colectiva=$request->id_co;
        }
        elseif(isset($request->id_ee)) {
            $e = entrevista_etnica::find($request->id_ee);
            $etiquetarAsignacion->id_entrevista_etnica=$request->id_ee;
        }
        elseif(isset($request->id_dc)) {
            $e = diagnostico_comunitario::find($request->id_dc);
            $etiquetarAsignacion->id_diagnostico_comunitario=$request->id_dc;
        }
        elseif(isset($request->id_hv)) {
            $e = historia_vida::find($request->id_hv);
            $etiquetarAsignacion->id_historia_vida=$request->id_hv;
        }
        else {
            abort(403,'Debe especificar la entrevista a etiquetar');
        }




        if($e) {
            $etiquetarAsignacion->c_entrevista=$e->entrevista_codigo;
            $etiquetarAsignacion->n_entrevista=$e->entrevista_correlativo;
        }
        else {
            abort(403,'Debe especificar la entrevista a etiquetar');
        }

        return view('etiquetar_asignacions.create',compact('etiquetarAsignacion'));
        //return view('etiquetar_asignacions.create');
    }

    /**
     * Store a newly created etiquetar_asignacion in storage.
     *
     * @param Createetiquetar_asignacionRequest $request
     *
     * @return Response
     */
    public function store(Createetiquetar_asignacionRequest $request)
    {
        $input = $request->all();
        $input['id_autoriza']=\Auth::user()->id_entrevistador;
        $input['id_situacion']=1; //Asignado
        $input['fh_asignado']=Carbon::now();
        $nuevo = new etiquetar_asignacion();
        $nuevo->fill($input);
        $nuevo->save();

        //$etiquetarAsignacion = $this->etiquetarAsignacionRepository->create($input);
        //Revisar que no haya otra en curso
        $duplicada = $nuevo->buscar_duplicada();
        if($duplicada>0) {
            Flash::warning("¡Cuidado! Esta entrevista ya cuenta con una asignación previa");
        }

        Flash::success('Asignación creada');
        $e=false;
        //Registrar traza
        if($request->id_e_ind_fvt > 0) {
            $e = entrevista_individual::find($request->id_e_ind_fvt);
            traza_actividad::create(['id_objeto'=>1, 'id_accion'=>17, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_e_ind_fvt]);
        }
        elseif($request->id_entrevista_profundidad > 0) {
            $e = entrevista_profundidad::find($request->id_entrevista_profundidad);
            traza_actividad::create(['id_objeto'=>11, 'id_accion'=>17, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_profundidad]);
        }
        elseif($request->id_entrevista_colectiva > 0) {
            $e = entrevista_colectiva::find($request->id_entrevista_colectiva);
            traza_actividad::create(['id_objeto'=>10, 'id_accion'=>17, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_colectiva]);
        }
        elseif($request->id_entrevista_etnica > 0) {
            $e = entrevista_etnica::find($request->id_entrevista_etnica);
            traza_actividad::create(['id_objeto'=>14, 'id_accion'=>17, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_etnica]);
        }
        elseif($request->id_diagnostico_comunitario > 0) {
            $e = diagnostico_comunitario::find($request->id_diagnostico_comunitario);
            traza_actividad::create(['id_objeto'=>13, 'id_accion'=>17, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_diagnostico_comunitario]);
        }
        elseif($request->id_historia_vida > 0) {
            $e = historia_vida::find($request->id_historia_vida);
            traza_actividad::create(['id_objeto'=>12, 'id_accion'=>17, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_historia_vida]);
        }
        //Enviar a dataturks
        if($e) {
            $res = $e->dataturk_enviar_todo($request->id_transcriptor);  //Enviar al dataturk
            if(!$res->exito) {
                Flash::error("Problemas con la creacion del proyecto en data turk: $res->mensaje");
                Log::debug(json_encode($res));
            }
            //si está cerrada, abrirla
            $e->id_cerrado=2;
            $e->id_etiquetada = $nuevo->id_situacion;
            $e->save();
            //FAcilita la integración de datos
            $nuevo->codigo = $e->entrevista_codigo;
            $nuevo->save();
        }

        //Fin de la traza
        return redirect(route('etiquetarAsignacions.index'));
    }

    /**
     * Display the specified etiquetar_asignacion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $etiquetarAsignacion = $this->etiquetarAsignacionRepository->findWithoutFail($id);


        // Mostrar información del seguimiento
        $llave_foranea = transcribir_asignacion::obtener_id_entrevista($etiquetarAsignacion);
        $seguimiento = seguimiento::where('id_entrevista',$llave_foranea->id_entrevista)
            ->where('id_subserie',$llave_foranea->id_subserie)
            ->get();

        if (empty($etiquetarAsignacion)) {
            Flash::error('Etiquetar Asignacion not found');

            return redirect(route('etiquetarAsignacions.index'));
        }

        return view('etiquetar_asignacions.show')->with('seguimiento', $seguimiento)->with('etiquetarAsignacion', $etiquetarAsignacion);
    }

    /**
     * Show the form for editing the specified etiquetar_asignacion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id, Request $request)
    {
        //Solo transcriptores
        $niveles=[10,1,2,3,4,5,6,11];
        $this->authorize('revisar-m-nivel', [$niveles]);

        $etiquetarAsignacion = etiquetar_asignacion::find($id);
        if (empty($etiquetarAsignacion)) {
            Flash::error('Asignacion no encontrada');
            return redirect(route('etiquetarAsignacions.index'));
        }

        if(\Gate::allows('nivel-11')) {  //Solo si es propio
            $this->authorize('es-propio',$etiquetarAsignacion->id_transcriptor);
        }
        if($etiquetarAsignacion->id_situacion<>1) {
            abort(403,'No puede modificar esta asigación');
        }

        //Valores por defecto
        $etiquetarAsignacion->duracion_entrevista_minutos=0;
        $etiquetarAsignacion->duracion_transcripcion_minutos=0;
        $etiquetarAsignacion->duracion_etiquetado_minutos=0;
        $etiquetarAsignacion->duracion_fichas_minutos=0;
        //Ver si ya tenía prioridad
        $llave_foranea = transcribir_asignacion::obtener_id_entrevista($etiquetarAsignacion);
        $prioridad = prioridad::where('id_entrevista',$llave_foranea->id_entrevista)
            ->where('id_subserie',$llave_foranea->id_subserie)
            ->orderby('id_prioridad','desc')
            ->first();
        if($prioridad) {
            $etiquetarAsignacion->fluidez  = $prioridad->fluidez;
            $etiquetarAsignacion->d_hecho  = $prioridad->d_hecho;
            $etiquetarAsignacion->d_contexto  = $prioridad->d_contexto;
            $etiquetarAsignacion->d_impacto  = $prioridad->d_impacto;
            $etiquetarAsignacion->d_justicia  = $prioridad->d_justicia;
            $etiquetarAsignacion->cierre  = $prioridad->cierre;
            $etiquetarAsignacion->ahora_entiendo  = $prioridad->ahora_entiendo;
            $etiquetarAsignacion->cambio_perspectiva  = $prioridad->cambio_perspectiva;
        }




        if($etiquetarAsignacion->id_e_ind_fvt > 0) {
            $entrevista = entrevista_individual::find($etiquetarAsignacion->id_e_ind_fvt);
        }
        elseif($etiquetarAsignacion->id_entrevista_colectiva > 0) {
            $entrevista = entrevista_colectiva::find($etiquetarAsignacion->id_entrevista_colectiva);
        }
        elseif($etiquetarAsignacion->id_entrevista_etnica > 0) {
            $entrevista = entrevista_etnica::find($etiquetarAsignacion->id_entrevista_etnica);
        }
        elseif($etiquetarAsignacion->id_entrevista_profundidad > 0) {
            $entrevista = entrevista_profundidad::find($etiquetarAsignacion->id_entrevista_profundidad);
        }
        elseif($etiquetarAsignacion->id_diagnostico_comunitario > 0) {
            $entrevista = diagnostico_comunitario::find($etiquetarAsignacion->id_diagnostico_comunitario);
        }
        elseif($etiquetarAsignacion->id_historia_vida > 0) {
            $entrevista = historia_vida::find($etiquetarAsignacion->id_historia_vida);
        }
        else {
            abort(403, "Entrevista mal especificada");
        }

        return view('etiquetar_asignacions.edit')
            ->with('entrevista', $entrevista)
            ->with('etiquetarAsignacion', $etiquetarAsignacion);
    }

    /**
     * Update the specified etiquetar_asignacion in storage.
     *
     * @param  int              $id
     * @param Updateetiquetar_asignacionRequest $request
     *
     * @return Response
     */
    public function update($id, Updateetiquetar_asignacionRequest $request)
    {
        //Revisar las fechas
        try {
            $fh_inicio = Carbon::createFromFormat("Y-m-d H:i",$request->fecha_inicio_submit." ".$request->hora_inicio_submit);
            $fh_fin = Carbon::createFromFormat("Y-m-d H:i",$request->fecha_fin_submit." ".$request->hora_fin_submit);
        }
        catch(\Exception $e) {
            //Flash::warning('Datos no guardados: Valores de inicio/fin invalidos');
            return redirect()->back()->withInput($request->all())->withErrors(['msg'=>'Datos no guardados: Valores de inicio/fin invalidos']);
        }


        if($fh_fin <= $fh_inicio) {
            return redirect()->back()->withInput($request->all())->withErrors(['msg'=>'Datos no guardados: La fecha/hora de finalización debe ser posterior a la de inicio.']);
        }

        $etiquetarAsignacion = $this->etiquetarAsignacionRepository->findWithoutFail($id);

        if (empty($etiquetarAsignacion)) {
            Flash::error('Asignación no existe');
            return redirect(route('etiquetarAsignacions.index'));
        }

        //Buscar la entrevista
        if($etiquetarAsignacion->id_e_ind_fvt > 0) {
            $e = entrevista_individual::find($etiquetarAsignacion->id_e_ind_fvt);
        }
        elseif($etiquetarAsignacion->id_entrevista_profundidad > 0) {
            $e = entrevista_profundidad::find($etiquetarAsignacion->id_entrevista_profundidad);
        }
        elseif($etiquetarAsignacion->id_entrevista_colectiva > 0) {
            $e = entrevista_colectiva::find($etiquetarAsignacion->id_entrevista_colectiva);
        }
        elseif($etiquetarAsignacion->id_entrevista_etnica > 0) {
            $e = entrevista_etnica::find($etiquetarAsignacion->id_entrevista_etnica);
        }
        elseif($etiquetarAsignacion->id_diagnostico_comunitario > 0) {
            $e = diagnostico_comunitario::find($etiquetarAsignacion->id_diagnostico_comunitario);
        }
        elseif($etiquetarAsignacion->id_historia_vida > 0) {
            $e = historia_vida::find($etiquetarAsignacion->id_historia_vida);
        }


        //Revisar adjunto
        if($request->id_situacion==2) {  //Completado con exito
            //Ir a traer el etiquetado a dataturk
            $etiquetado = $e->dataturk_traer_etiquetado();
            $tiene_trans=$e->rel_adjunto()->where('id_tipo',25)->count();

            if($tiene_trans <=0){
                return redirect()->back()->withInput($request->all())->withErrors(['msg'=>'Datos no guardados: No se pudo extraer el archivo de etiquetado.  Pruebe asignarlo manualmente']);
            }
            else {
                Flash::success("Dataturks: exito al extraer el texto");
                //VAmos bien, desasignar
                $r = $e->dataturk_quitar_etiquetador($etiquetarAsignacion->id_transcriptor);

            }
        }
        else {  //Revocado o no etiquetado
            $r =  $e->dataturk_quitar_etiquetador($etiquetarAsignacion->id_transcriptor);
            if($r->exito) {
                Flash::success("Dataturks: exito al quitar al etiquetador");
            }
            else {
                Flash::error("Dataturks: problemas al quitar al etiquetador: $r->mensaje");

            }
        }

        $tiempo = $fh_inicio->diffInMinutes($fh_fin);
        //dd($request);



        //$etiquetarAsignacion->duracion_entrevista_minutos= intval($request->duracion_entrevista_minutos);
        $etiquetarAsignacion->id_situacion=$request->id_situacion;
        $etiquetarAsignacion->id_causa=$request->id_causa;
        $etiquetarAsignacion->observaciones=trim($request->observaciones);
        $etiquetarAsignacion->fh_transcrito=Carbon::now();
        $etiquetarAsignacion->fh_inicio = $fh_inicio;
        $etiquetarAsignacion->fh_fin = $fh_fin;
        $etiquetarAsignacion->duracion_etiquetado_real_minutos = $tiempo;
        $etiquetarAsignacion->duracion_etiquetado_minutos = $request->duracion_etiquetado_minutos;
        $etiquetarAsignacion->terceros = $request->terceros;
        $etiquetarAsignacion->save();


        //Procesar tiempos
        $llave_foranea = transcribir_asignacion::obtener_id_entrevista($etiquetarAsignacion);

        $a_tiempo = procesamiento_tiempo::procesar_request($request, $llave_foranea);

        //Procesar priorización
        $prioridad = prioridad::procesar_request($request, $llave_foranea);

        //Procesar cierre
        $seguimiento = seguimiento::procesar_request($request, $llave_foranea);

        Flash::success('Asignación actualizada');
        //Registrar traza
        //$entrevistaIndividual = entrevista_individual::find($etiquetarAsignacion->id_e_ind_fvt);
        //traza_actividad::create(['id_objeto'=>1, 'id_accion'=>15, 'codigo'=>'Transcripcion', 'id_primaria'=>$etiquetarAsignacion->id_etiquetar_asignacion]);
        //Registrar traza
        if($etiquetarAsignacion->id_e_ind_fvt > 0) {
            $e = entrevista_individual::find($etiquetarAsignacion->id_e_ind_fvt);
            traza_actividad::create(['id_objeto'=>1, 'id_accion'=>19, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_e_ind_fvt]);
        }
        elseif($etiquetarAsignacion->id_entrevista_profundidad > 0) {
            $e = entrevista_profundidad::find($etiquetarAsignacion->id_entrevista_profundidad);
            traza_actividad::create(['id_objeto'=>11, 'id_accion'=>19, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_profundidad]);
        }
        elseif($etiquetarAsignacion->id_entrevista_colectiva > 0) {
            $e = entrevista_colectiva::find($etiquetarAsignacion->id_entrevista_colectiva);
            traza_actividad::create(['id_objeto'=>10, 'id_accion'=>19, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_colectiva]);
        }
        elseif($etiquetarAsignacion->id_entrevista_etnica > 0) {
            $e = entrevista_etnica::find($etiquetarAsignacion->id_entrevista_etnica);
            traza_actividad::create(['id_objeto'=>14, 'id_accion'=>19, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_etnica]);
        }
        elseif($etiquetarAsignacion->id_diagnostico_comunitario > 0) {
            $e = diagnostico_comunitario::find($etiquetarAsignacion->id_diagnostico_comunitario);
            traza_actividad::create(['id_objeto'=>13, 'id_accion'=>19, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_diagnostico_comunitario]);
        }
        elseif($etiquetarAsignacion->id_historia_vida > 0) {
            $e = historia_vida::find($etiquetarAsignacion->id_historia_vida);
            traza_actividad::create(['id_objeto'=>12, 'id_accion'=>19, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_historia_vida]);
        }
        //Fin de la traza
        if(is_object($e)) {
            $e->id_etiquetada = $etiquetarAsignacion->id_situacion;
            $e->save();
            //dd("Actualizado");
        }

        return redirect(route('etiquetarAsignacions.index'));
    }

    /**
     * Remove the specified etiquetar_asignacion from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Solo transcriptores
        $niveles=[10,1];
        $this->authorize('revisar-m-nivel', [$niveles]);
        $etiquetarAsignacion = etiquetar_asignacion::find($id);
        if (empty($etiquetarAsignacion)) {
            Flash::error(' Asignacion no encontrada');
            return redirect(route('etiquetarAsignacions.index'));
        }

        if($etiquetarAsignacion->id_situacion<>1) {
            abort(403,'No puede revocar esta asigación');
        }





        $etiquetarAsignacion->id_situacion=3;
        $etiquetarAsignacion->fh_revocado=Carbon::now();
        $etiquetarAsignacion->save();
        //Registrar traza

        $e=false;
        if($etiquetarAsignacion->id_e_ind_fvt > 0) {
            $e = entrevista_individual::find($etiquetarAsignacion->id_e_ind_fvt);
            traza_actividad::create(['id_objeto'=>1, 'id_accion'=>18, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_e_ind_fvt]);
        }
        elseif($etiquetarAsignacion->id_entrevista_profundidad > 0) {
            $e = entrevista_profundidad::find($etiquetarAsignacion->id_entrevista_profundidad);
            traza_actividad::create(['id_objeto'=>11, 'id_accion'=>18, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_profundidad]);
        }
        elseif($etiquetarAsignacion->id_entrevista_colectiva > 0) {
            $e = entrevista_colectiva::find($etiquetarAsignacion->id_entrevista_colectiva);
            traza_actividad::create(['id_objeto'=>10, 'id_accion'=>18, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_colectiva]);
        }
        elseif($etiquetarAsignacion->id_entrevista_etnica > 0) {
            $e = entrevista_etnica::find($etiquetarAsignacion->id_entrevista_etnica);
            traza_actividad::create(['id_objeto'=>14, 'id_accion'=>18, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_etnica]);
        }
        elseif($etiquetarAsignacion->id_diagnostico_comunitario > 0) {
            $e = diagnostico_comunitario::find($etiquetarAsignacion->id_diagnostico_comunitario);
            traza_actividad::create(['id_objeto'=>13, 'id_accion'=>18, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_diagnostico_comunitario]);
        }
        elseif($etiquetarAsignacion->id_historia_vida > 0) {
            $e = historia_vida::find($etiquetarAsignacion->id_historia_vida);
            traza_actividad::create(['id_objeto'=>12, 'id_accion'=>18, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_historia_vida]);
        }
        //Fin de la traza
        if($e) {
            $r =  $e->dataturk_quitar_etiquetador($etiquetarAsignacion->id_transcriptor);
            if($r->exito) {
                Flash::success("Dataturks: exito al quitar al etiquetador");
            }
            else {
                Flash::error("Dataturks: problemas al quitar al etiquetador: $r->mensaje");
            }
            //Actualizar el estao
            $e->id_etiquetada = $etiquetarAsignacion->id_situacion;
            $e->save();
        }

        return redirect(route('etiquetarAsignacions.index'));
    }

    public function cuadro_resumen(Request $request) {
        $filtros = etiquetar_asignacion::filtros_default($request);
        $datos = etiquetar_asignacion::cuadro_resumen($filtros);
        if($datos->total > 0) {
            return view('etiquetar_asignacions.cuadro_resumen',compact('datos'));
        }
        else {
            abort(403,'Datos insuficientes');
        }

    }


    public function enviar_dataturk(Request $request) {
        $e=false;
        if(isset($request->id)) {
            $e = entrevista_individual::find($request->id);
        }
        elseif(isset($request->id_pr)) {
            $e = entrevista_profundidad::find($request->id_pr);
        }
        elseif(isset($request->id_co)) {
            $e = entrevista_colectiva::find($request->id_co);
        }
        elseif(isset($request->id_ee)) {
            $e = entrevista_etnica::find($request->id_ee);
        }
        elseif(isset($request->id_dc)) {
            $e = diagnostico_comunitario::find($request->id_dc);
        }
        elseif(isset($request->id_hv)) {
            $e = historia_vida::find($request->id_hv);
        }


        if(!isset($request->id_transcriptor)) {
            if(\Auth::check()) {
                $request->id_transcriptor =  \Auth::user()->id_transcriptor;
            }
            else {
                $request->id_transcriptor = 10;
            }
        }
        if($e) {
            $res = $e->dataturk_enviar_todo($request->id_transcriptor);  //Enviar al dataturk
            if(!$res->exito) {
                Flash::error("Problemas con la creacion del proyecto en data turk: $res->mensaje");
            }
            else {
                Flash::success('Entrevista enviada al dataturk');
            }
        }
        else {
            Flash::error('Error: no especificó la entrevista a enviar');
        }
        return redirect()->back();
    }

    public function generar_excel_plano() {
        $respuesta = excel_asignaciones_etiquetado::generar_plana();
        return response()->json($respuesta);
    }
}
