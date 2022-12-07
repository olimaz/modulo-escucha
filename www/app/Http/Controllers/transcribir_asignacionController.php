<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createtranscribir_asignacionRequest;
use App\Http\Requests\Updatetranscribir_asignacionRequest;
use App\Models\diagnostico_comunitario;
use App\Models\entrevista_colectiva;
use App\Models\entrevista_etnica;
use App\Models\entrevista_individual;
use App\Models\entrevista_profundidad;
use App\Models\excel_asignaciones_transcripcion;
use App\Models\historia_vida;
use App\Models\prioridad;
use App\Models\procesamiento_tiempo;
use App\Models\seguimiento;
use App\Models\seguimiento_problema;
use App\Models\transcribir_asignacion;
use App\Models\traza_actividad;
use App\Repositories\transcribir_asignacionRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class transcribir_asignacionController extends AppBaseController
{
    /** @var  transcribir_asignacionRepository */
    private $transcribirAsignacionRepository;

    public function __construct(transcribir_asignacionRepository $transcribirAsignacionRepo)
    {
        $this->transcribirAsignacionRepository = $transcribirAsignacionRepo;
    }

    /**
     * Display a listing of the transcribir_asignacion.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = transcribir_asignacion::filtros_default($request);
        $transcribirAsignacions = transcribir_asignacion::filtrar($filtros)->ordenar()->paginate(50);

        //dd($transcribirAsignacions);


        return view('transcribir_asignacions.index')
            ->with('filtros', $filtros)
            ->with('transcribirAsignacions', $transcribirAsignacions);
    }

    /**
     * Show the form for creating a new transcribir_asignacion.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $niveles=[10,1,2];
        $this->authorize('revisar-m-nivel', [$niveles]);

        $transcribirAsignacion = new transcribir_asignacion();
        $transcribirAsignacion->urgente=2;
        if(isset($request->id)) {
            $e = entrevista_individual::find($request->id);
            $transcribirAsignacion->id_e_ind_fvt=$request->id;
        }
        elseif(isset($request->id_pr)) {
            $e = entrevista_profundidad::find($request->id_pr);
            $transcribirAsignacion->id_entrevista_profundidad=$request->id_pr;
        }
        elseif(isset($request->id_co)) {
            $e = entrevista_colectiva::find($request->id_co);
            $transcribirAsignacion->id_entrevista_colectiva=$request->id_co;
        }
        elseif(isset($request->id_ee)) {
            $e = entrevista_etnica::find($request->id_ee);
            $transcribirAsignacion->id_entrevista_etnica=$request->id_ee;
        }
        elseif(isset($request->id_dc)) {
            $e = diagnostico_comunitario::find($request->id_dc);
            $transcribirAsignacion->id_diagnostico_comunitario=$request->id_dc;
        }
        elseif(isset($request->id_hv)) {
            $e = historia_vida::find($request->id_hv);
            $transcribirAsignacion->id_historia_vida=$request->id_hv;
        }
        else {
            abort(403,'Debe especificar la entrevista a transcribir');
        }




        if($e) {
            $transcribirAsignacion->c_entrevista=$e->entrevista_codigo;
            $transcribirAsignacion->n_entrevista=$e->entrevista_correlativo;
            $horas = transcribir_asignacion::en_horas($e->tiempo_entrevista);
        }
        else {
            abort(403,'Debe especificar la entrevista a transcribir');
        }

        return view('transcribir_asignacions.create',compact('transcribirAsignacion','horas'));
    }

    /**
     * Store a newly created transcribir_asignacion in storage.
     *
     * @param Createtranscribir_asignacionRequest $request
     *
     * @return Response
     */
    public function store(Createtranscribir_asignacionRequest $request)
    {
        $input = $request->all();
        $input['id_autoriza']=\Auth::user()->id_entrevistador;
        $input['id_situacion']=1; //Asignado
        $input['fh_asignado']=Carbon::now();

        $transcribirAsignacion = $this->transcribirAsignacionRepository->create($input);
        //Revisar que no haya otra en curso
        $duplicada = $transcribirAsignacion->buscar_duplicada();
        if($duplicada>0) {
            Flash::warning("¡Cuidado! Esta entrevista ya cuenta con una asignación previa");
        }


        Flash::success('Asignación creada');
        //Registrar traza
        $e=false;
        if($request->id_e_ind_fvt > 0) {
            $e = entrevista_individual::find($request->id_e_ind_fvt);
            traza_actividad::create(['id_objeto'=>1, 'id_accion'=>13, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_e_ind_fvt]);
        }
        elseif($request->id_entrevista_profundidad > 0) {
            $e = entrevista_profundidad::find($request->id_entrevista_profundidad);
            traza_actividad::create(['id_objeto'=>11, 'id_accion'=>13, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_profundidad]);
        }
        elseif($request->id_entrevista_colectiva > 0) {
            $e = entrevista_colectiva::find($request->id_entrevista_colectiva);
            traza_actividad::create(['id_objeto'=>10, 'id_accion'=>13, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_colectiva]);
        }
        elseif($request->id_entrevista_etnica > 0) {
            $e = entrevista_etnica::find($request->id_entrevista_etnica);
            traza_actividad::create(['id_objeto'=>14, 'id_accion'=>13, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_etnica]);
        }
        elseif($request->id_diagnostico_comunitario > 0) {
            $e = diagnostico_comunitario::find($request->id_diagnostico_comunitario);
            traza_actividad::create(['id_objeto'=>13, 'id_accion'=>13, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_diagnostico_comunitario]);
        }
        elseif($request->id_historia_vida > 0) {
            $e = historia_vida::find($request->id_historia_vida);
            traza_actividad::create(['id_objeto'=>12, 'id_accion'=>13, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_historia_vida]);
        }

        if($e) {
            //si está cerrada, abrirla
            $e->id_cerrado=2;
            //Actualizar el estado
            $e->id_transcrita = $transcribirAsignacion->id_situacion;
            $e->save();
            //facilita la integracion de datos
            $transcribirAsignacion->codigo = $e->entrevista_codigo;
            $transcribirAsignacion->save();
        }


        //Fin de la traza

        return redirect(route('transcribirAsignacions.index'));
    }

    /**
     * Display the specified transcribir_asignacion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $transcribirAsignacion = $this->transcribirAsignacionRepository->findWithoutFail($id);


        // Mostrar información del seguimiento
        $llave_foranea = transcribir_asignacion::obtener_id_entrevista($transcribirAsignacion);
        $seguimiento = seguimiento::where('id_entrevista',$llave_foranea->id_entrevista)
                                    ->where('id_subserie',$llave_foranea->id_subserie)
                                    ->get();

        if (empty($transcribirAsignacion)) {
            Flash::error('Transcribir Asignacion not found');

            return redirect(route('transcribirAsignacions.index'));
        }

        return view('transcribir_asignacions.show')
                ->with('seguimiento', $seguimiento)
                ->with('transcribirAsignacion', $transcribirAsignacion);
    }

    /**
     * Show the form for editing the specified transcribir_asignacion.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        //Solo transcriptores
        $niveles=[10,1,2,3,4,5,6,11];
        $this->authorize('revisar-m-nivel', [$niveles]);

        $transcribirAsignacion = $this->transcribirAsignacionRepository->findWithoutFail($id);
        if (empty($transcribirAsignacion)) {
            Flash::error('Transcribir Asignacion not found');
            return redirect(route('transcribirAsignacions.index'));
        }
        //Valores por defecto
        $transcribirAsignacion->duracion_entrevista_minutos=0;
        $transcribirAsignacion->duracion_transcripcion_minutos=0;
        $transcribirAsignacion->duracion_etiquetado_minutos=0;
        $transcribirAsignacion->duracion_fichas_minutos=0;

        //Ver si ya tenía prioridad
        $llave_foranea = transcribir_asignacion::obtener_id_entrevista($transcribirAsignacion);
        $prioridad = prioridad::where('id_entrevista',$llave_foranea->id_entrevista)
                        ->where('id_subserie',$llave_foranea->id_subserie)
                        ->orderby('id_prioridad','desc')
                        ->first();
        if($prioridad) {
            $transcribirAsignacion->fluidez  = $prioridad->fluidez;
            $transcribirAsignacion->d_hecho  = $prioridad->d_hecho;
            $transcribirAsignacion->d_contexto  = $prioridad->d_contexto;
            $transcribirAsignacion->d_impacto  = $prioridad->d_impacto;
            $transcribirAsignacion->d_justicia  = $prioridad->d_justicia;
            $transcribirAsignacion->cierre  = $prioridad->cierre;
            $transcribirAsignacion->ahora_entiendo  = $prioridad->ahora_entiendo;
            $transcribirAsignacion->cambio_perspectiva  = $prioridad->cambio_perspectiva;
        }


        if(\Gate::allows('nivel-11')) {  //Solo si es propio
            $this->authorize('es-propio',$transcribirAsignacion->id_transcriptor);
        }
        if($transcribirAsignacion->id_situacion<>1) {
            abort(403,'No puede modificar esta asigación');
        }



        if($transcribirAsignacion->id_e_ind_fvt > 0) {
            $entrevista = entrevista_individual::find($transcribirAsignacion->id_e_ind_fvt);
        }
        elseif($transcribirAsignacion->id_entrevista_colectiva > 0) {
            $entrevista = entrevista_colectiva::find($transcribirAsignacion->id_entrevista_colectiva);
        }
        elseif($transcribirAsignacion->id_entrevista_etnica > 0) {
            $entrevista = entrevista_etnica::find($transcribirAsignacion->id_entrevista_etnica);
        }
        elseif($transcribirAsignacion->id_entrevista_profundidad > 0) {
            $entrevista = entrevista_profundidad::find($transcribirAsignacion->id_entrevista_profundidad);
        }
        elseif($transcribirAsignacion->id_diagnostico_comunitario > 0) {
            $entrevista = diagnostico_comunitario::find($transcribirAsignacion->id_diagnostico_comunitario);
        }
        elseif($transcribirAsignacion->id_historia_vida > 0) {
            $entrevista = historia_vida::find($transcribirAsignacion->id_historia_vida);
        }
        else {
            abort(403, "Entrevista mal especificada");
        }

        return view('transcribir_asignacions.edit')
            ->with('entrevista', $entrevista)
            ->with('transcribirAsignacion', $transcribirAsignacion);
    }

    /**
     * Update the specified transcribir_asignacion in storage.
     *
     * @param  int              $id
     * @param Updatetranscribir_asignacionRequest $request
     *
     * @return Response
     */
    public function update($id, Updatetranscribir_asignacionRequest $request)
    {

        //dd($request);
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

        $transcribirAsignacion = $this->transcribirAsignacionRepository->findWithoutFail($id);

        if (empty($transcribirAsignacion)) {
            Flash::error('Asignación no existe');
            return redirect(route('transcribirAsignacions.index'));
        }


        //Revisar adjunto
        if($request->id_situacion==2) {

            if($transcribirAsignacion->id_e_ind_fvt > 0) {
                $e = entrevista_individual::find($transcribirAsignacion->id_e_ind_fvt);
                $tiene_trans=$e->rel_adjunto()->where('id_tipo',6)->count();
            }
            elseif($transcribirAsignacion->id_entrevista_profundidad > 0) {
                $e = entrevista_profundidad::find($transcribirAsignacion->id_entrevista_profundidad);
                $tiene_trans=$e->rel_adjunto()->where('id_tipo',6)->count();
            }
            elseif($transcribirAsignacion->id_entrevista_colectiva > 0) {
                $e = entrevista_colectiva::find($transcribirAsignacion->id_entrevista_colectiva);
                $tiene_trans=$e->rel_adjunto()->where('id_tipo',6)->count();
            }
            elseif($transcribirAsignacion->id_entrevista_etnica > 0) {
                $e = entrevista_etnica::find($transcribirAsignacion->id_entrevista_etnica);
                $tiene_trans=$e->rel_adjunto()->where('id_tipo',6)->count();
            }
            elseif($transcribirAsignacion->id_diagnostico_comunitario > 0) {
                $e = diagnostico_comunitario::find($transcribirAsignacion->id_diagnostico_comunitario);
                $tiene_trans=$e->rel_adjunto()->where('id_tipo',6)->count();
            }
            elseif($transcribirAsignacion->id_historia_vida > 0) {
                $e = historia_vida::find($transcribirAsignacion->id_historia_vida);
                $tiene_trans=$e->rel_adjunto()->where('id_tipo',6)->count();
            }
            if($tiene_trans <=0){
                return redirect()->back()->withInput($request->all())->withErrors(['msg'=>'Datos no guardados: No se adjuntó la transcripción']);
            }
        }



        $tiempo = $fh_inicio->diffInMinutes($fh_fin);
        //dd($request);



        $transcribirAsignacion->duracion_entrevista_minutos= intval($request->duracion_entrevista_minutos);
        $transcribirAsignacion->id_situacion=$request->id_situacion;
        $transcribirAsignacion->id_causa=$request->id_causa;
        $transcribirAsignacion->observaciones=trim($request->observaciones);
        $transcribirAsignacion->fh_transcrito=Carbon::now();
        $transcribirAsignacion->fh_inicio = $fh_inicio;
        $transcribirAsignacion->fh_fin = $fh_fin;
        $transcribirAsignacion->duracion_transcripcion_real_minutos = $tiempo;
        $transcribirAsignacion->duracion_transcripcion_minutos = $request->duracion_transcripcion_minutos;
        $transcribirAsignacion->terceros = $request->terceros;
        $transcribirAsignacion->save();




        //Procesar tiempos
        $llave_foranea = transcribir_asignacion::obtener_id_entrevista($transcribirAsignacion);

        $a_tiempo = procesamiento_tiempo::procesar_request($request, $llave_foranea);

        //Procesar priorización
        $prioridad = prioridad::procesar_request($request, $llave_foranea);

        //Procesar cierre
        $seguimiento = seguimiento::procesar_request($request, $llave_foranea);





        Flash::success('Asignación actualizada');

        //Registrar traza
        if($transcribirAsignacion->id_e_ind_fvt > 0) {
            $e = entrevista_individual::find($transcribirAsignacion->id_e_ind_fvt);
            traza_actividad::create(['id_objeto'=>1, 'id_accion'=>15, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_e_ind_fvt]);
        }
        elseif($transcribirAsignacion->id_entrevista_profundidad > 0) {
            $e = entrevista_profundidad::find($transcribirAsignacion->id_entrevista_profundidad);
            traza_actividad::create(['id_objeto'=>11, 'id_accion'=>15, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_profundidad]);
        }
        elseif($transcribirAsignacion->id_entrevista_colectiva > 0) {
            $e = entrevista_colectiva::find($transcribirAsignacion->id_entrevista_colectiva);
            traza_actividad::create(['id_objeto'=>10, 'id_accion'=>15, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_colectiva]);
        }
        elseif($transcribirAsignacion->id_entrevista_etnica > 0) {
            $e = entrevista_etnica::find($transcribirAsignacion->id_entrevista_etnica);
            traza_actividad::create(['id_objeto'=>14, 'id_accion'=>15, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_etnica]);
        }
        elseif($transcribirAsignacion->id_diagnostico_comunitario > 0) {
            $e = diagnostico_comunitario::find($transcribirAsignacion->id_diagnostico_comunitario);
            traza_actividad::create(['id_objeto'=>13, 'id_accion'=>15, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_diagnostico_comunitario]);
        }
        elseif($transcribirAsignacion->id_historia_vida > 0) {
            $e = historia_vida::find($transcribirAsignacion->id_historia_vida);
            traza_actividad::create(['id_objeto'=>12, 'id_accion'=>15, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_historia_vida]);
        }


        if(is_object($e)) {
            $e->id_transcrita = $transcribirAsignacion->id_situacion;
            $e->save();
            //dd("Actualizado");
        }
        //Fin de la traza

        return redirect(route('transcribirAsignacions.index'));
    }

    /**
     * Revocar asigación, cambiando el estado a 3
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
        $transcribirAsignacion = $this->transcribirAsignacionRepository->findWithoutFail($id);
        if($transcribirAsignacion->id_situacion<>1) {
            abort(403,'No puede revocar esta asigación');
        }

        $transcribirAsignacion = $this->transcribirAsignacionRepository->findWithoutFail($id);

        if (empty($transcribirAsignacion)) {
            Flash::error(' Asignacion no encontrada');
            return redirect(route('transcribirAsignacions.index'));
        }

        $transcribirAsignacion->id_situacion=3;
        $transcribirAsignacion->fh_revocado=Carbon::now();
        $transcribirAsignacion->save();
        //Registrar traza

        //$entrevistaIndividual = entrevista_individual::find($transcribirAsignacion->id_e_ind_fvt);
        //traza_actividad::create(['id_objeto'=>1, 'id_accion'=>14, 'codigo'=>$entrevistaIndividual->entrevista_codigo, 'id_primaria'=>$entrevistaIndividual->id_e_ind_fvt]);
        if($transcribirAsignacion->id_e_ind_fvt > 0) {
            $e = entrevista_individual::find($transcribirAsignacion->id_e_ind_fvt);
            traza_actividad::create(['id_objeto'=>1, 'id_accion'=>14, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_e_ind_fvt]);
        }
        elseif($transcribirAsignacion->id_entrevista_profundidad > 0) {
            $e = entrevista_profundidad::find($transcribirAsignacion->id_entrevista_profundidad);
            traza_actividad::create(['id_objeto'=>11, 'id_accion'=>14, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_profundidad]);
        }
        elseif($transcribirAsignacion->id_entrevista_colectiva > 0) {
            $e = entrevista_colectiva::find($transcribirAsignacion->id_entrevista_colectiva);
            traza_actividad::create(['id_objeto'=>10, 'id_accion'=>14, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_colectiva]);
        }
        elseif($transcribirAsignacion->id_entrevista_etnica > 0) {
            $e = entrevista_etnica::find($transcribirAsignacion->id_entrevista_etnica);
            traza_actividad::create(['id_objeto'=>14, 'id_accion'=>14, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_entrevista_etnica]);
        }
        elseif($transcribirAsignacion->id_diagnostico_comunitario > 0) {
            $e = diagnostico_comunitario::find($transcribirAsignacion->id_diagnostico_comunitario);
            traza_actividad::create(['id_objeto'=>13, 'id_accion'=>14, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_diagnostico_comunitario]);
        }
        elseif($transcribirAsignacion->id_historia_vida > 0) {
            $e = historia_vida::find($transcribirAsignacion->id_historia_vida);
            traza_actividad::create(['id_objeto'=>12, 'id_accion'=>14, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_historia_vida]);
        }
        //Actualizar el estado
        if(is_object($e)) {
            $e->id_transcrita = $transcribirAsignacion->id_situacion;
            $e->save();
            //dd("Actualizado");
        }
        //Fin de la traza

        return redirect(route('transcribirAsignacions.index'));
    }
    public function cuadro_resumen(Request $request) {
        $filtros = transcribir_asignacion::filtros_default($request);
        $datos = transcribir_asignacion::cuadro_resumen($filtros);
        if($datos->total > 0) {
            return view('transcribir_asignacions.cuadro_resumen',compact('datos'));
        }
        else {
            abort(403,'Datos insuficientes');
        }

    }

    public function generar_excel_plano() {
        $respuesta = excel_asignaciones_transcripcion::generar_plana();
        return response()->json($respuesta);
    }



}
