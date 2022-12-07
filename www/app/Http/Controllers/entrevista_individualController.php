<?php

namespace App\Http\Controllers;

use App\Exports\dinamicaExport;
use App\Exports\entrevista_integradaExport;
use App\Exports\entrevistaExport;
use App\Exports\entrevista_resultadosExport;
use App\Exports\excel_entrevista_seguimientoExport;
use App\Exports\excel_integrado_monitoreoExport;
use App\Exports\ficha_persona_entrevistadaExporte;
use App\Exports\ficha_victimaExport;
use App\Http\Requests\Createentrevista_individualRequest;
use App\Http\Requests\Updateentrevista_individualRequest;
use App\Models\adjunto;
use App\Models\cat_item;
use App\Models\entrevista;
use App\Models\entrevista_impacto;
use App\Models\entrevista_individual;
use App\Models\entrevista_individual_aa;
use App\Models\entrevista_individual_adjunto;
use App\Models\entrevista_individual_dinamica;
use App\Models\entrevista_individual_fr;
use App\Models\entrevista_individual_interes;
use App\Models\entrevista_individual_interes_area;
use App\Models\entrevista_individual_mandato;
use App\Models\entrevista_individual_stc;
use App\Models\entrevista_individual_tc;
use App\Models\entrevista_individual_tv;
use App\Models\entrevista_justicia;
use App\Models\entrevista_profundidad;
use App\Models\entrevistador;
use App\Models\etiqueta_entrevista;
use App\Models\etiquetar_asignacion;
use App\Models\excel_entrevista;
use App\Models\excel_ficha_persona_entrevistada;
use App\Models\excel_ficha_victima;
use App\Models\excel_integrado_monitoreo;
use App\Models\excel_ntrevista;
use App\Models\excel_entrevista_dinamica;
use App\Models\excel_entrevista_integrado;
use App\Models\excel_personas_entrevistadas;
use App\Models\excel_seguimiento_entrevistas;
use App\Models\persona_entrevistada;
use App\Models\persona_responsable;
use App\Models\sim_entrevista_victima;
use App\Models\tesauro;
use App\Models\transcribir_asignacion;
use App\Models\traza_actividad;
use App\Models\traza_buscador;
use App\Models\victima;
use App\Repositories\entrevista_individualRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use mysql_xdevapi\Exception;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Log;
use setasign\Fpdi\PdfParser\Type\PdfIndirectObjectReference;

class entrevista_individualController extends AppBaseController
{
    /** @var  entrevista_individualRepository */
    private $entrevistaIndividualRepository;

    public function __construct(entrevista_individualRepository $entrevistaIndividualRepo)
    {
        $this->entrevistaIndividualRepository = $entrevistaIndividualRepo;
    }

    /**
     * Display a listing of the entrevista_individual.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        if(!isset($request->id_subserie)) {
            $request->id_subserie=config("expedientes.vi");
        }
        else {
            $request->id_subserie = (integer)$request->id_subserie;
        }

        $filtros = entrevista_individual::filtros_default($request);



        $query = entrevista_individual::filtrar($filtros)->ordenar();
            $debug['sql']= nl2br($query->toSql());
            $debug['criterios']=$query->getBindings();
            //dd($debug);
        $cantidad = $filtros->id_entrevistador == optional(\Auth::user())->id_entrevistador ? 30 : 15;
        $entrevistaIndividuals = $query->select(\DB::raw('distinct e_ind_fvt.*'))->paginate($cantidad);

        //dd("hola munedo:");


        if($request->id_subserie == config("expedientes.aa")) {
            $txt_titulo = "Entrevistas AA";
        }
        elseif($request->id_subserie == config("expedientes.tc")) {
            $txt_titulo = "Entrevistas TC";
        }
        else {
            $txt_titulo = "Entrevistas VI";
        }
        //dd($filtros);

        return view('entrevista_individuals.index')
            ->with('entrevistaIndividuals', $entrevistaIndividuals)
            ->with('filtros', $filtros)
            ->with('txt_titulo',$txt_titulo)
            ;
    }

    //Funciona igual que el index, pero en lugar de mostrar la tabla, permite descargar un excel. Usado donde se aplican filtros como en la buscadora
    public function generar_excel_filtrado(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $filtros = entrevista_individual::filtros_default($request);
        //dd($filtros);
        $query = entrevista_individual::filtrar($filtros);
        $debug['sql']= nl2br($query->toSql());
        $debug['criterios']=$query->getBindings();
        //dd($debug);
        //$cantidad = $filtros->id_entrevistador == optional(\Auth::user())->id_entrevistador ? 30 : 15;
        $arreglo = $query->orderby('e_ind_fvt.id_e_ind_fvt')->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
        //dd($arreglo);
        return $this->excel_plano_resultados($arreglo);
    }
    public function generar_excel_filtrado_victima(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $filtros = victima::filtros_default($request);
        $query = victima::seleccionar($filtros->id_tipo_listado)->filtrar($filtros);
        $arreglo = $query->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
        return $this->excel_plano_resultados($arreglo);
    }
    //Exportar entrevistas a partir de filtros de pri
    public function generar_excel_filtrado_pr(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $this->authorize('revisar-m-nivel',[[1,2,6,10]]);
        $filtros = persona_responsable::filtros_default($request);
        $query = persona_responsable::seleccionar($filtros->id_tipo_listado)->filtrar($filtros)->ordenar_busqueda($filtros->id_tipo_listado);
        $arreglo = $query->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
        return $this->excel_plano_resultados($arreglo, "entrevista_presunto_responsable_individual");
    }

    //Exportar entrevistas a partir de filtros de persona entrevistada
    public function generar_excel_filtrado_pe(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $this->authorize('revisar-m-nivel',[[1,2,6,10]]);
        $filtros = persona_entrevistada::filtros_default($request);
        $query = persona_entrevistada::seleccionar($filtros->id_tipo_listado)->filtrar($filtros);
        $arreglo = $query->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
        return $this->excel_plano_resultados($arreglo, "entrevista_persona_entrevistada");
    }

    /**
     * Show the form for creating a new entrevista_individual.
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

        //Por defecto, entrevista individual a familiares, victimas o testigos
        $id_subserie = isset($request->id_subserie) ? (integer)$request->id_subserie : config('expedientes.vi');
        $id_subserie = $id_subserie < 1 ? config('expedientes.vi') : $id_subserie;

        $entrevistador = entrevistador::find($id_entrevistador);

        $entrevistaIndividual = new entrevista_individual();
        $entrevistaIndividual->id_subserie=$id_subserie;
        $entrevistaIndividual->id_entrevistador=$id_entrevistador;
        $entrevistaIndividual->entrevista_numero = $entrevistaIndividual->cual_toca();
        $entrevistaIndividual->entrevista_fecha = date("Y-m-d");
        $entrevistaIndividual->id_territorio = $entrevistador->id_territorio;
        $entrevistaIndividual->entrevista_lugar = $entrevistador->id_ubicacion;
        $entrevistaIndividual->hechos_lugar = $entrevistador->id_ubicacion;
        $entrevistaIndividual->nna = 2;
        $entrevistaIndividual->id_etnico = 2;
        $entrevistaIndividual->id_prioritario = 2;

        $entrevista = new entrevista();


        return view('entrevista_individuals.create',compact('entrevistaIndividual'),compact('entrevista'));
    }

    /**
     * Store a newly created entrevista_individual in storage.
     *
     * @param Createentrevista_individualRequest $request
     *
     * @return Response
     */
    public function store(Createentrevista_individualRequest $request)
    {
        $request->id_subserie = (integer)$request->id_subserie;


        $id_entrevistador=\Auth::user()->id_entrevistador;
        //Sin validaciones.  Si logró crearla, no embarrarla a la hora de grabar
        $id_entrevistador=intval($request->id_entrevistador); //Por si lo hace a nombre de otro


        //Validar número de entrevista
        $entrevista_numero = intval($request->entrevista_numero);
        $existe = entrevista_individual::where('id_entrevistador',$id_entrevistador)
                                        ->where('entrevista_numero',$entrevista_numero)
                                        ->where('id_subserie',$request->id_subserie)
                                        ->first();
        if(!empty($existe)) {
            Flash::error("Número de entrevista en uso.  No puede duplicar el número $request->entrevista_numero");
            return redirect()->back()->withInput($request->all());
        }

        //Para calcular el código
        $entrevista = new entrevista_individual();
        $entrevista->id_entrevistador=$id_entrevistador;
        $entrevista->id_subserie=(integer)$request->id_subserie;
        $entrevista->entrevista_numero=$entrevista_numero;
        $entrevista_codigo = $entrevista->calcular_codigo();
        $entrevista_correlativo = $entrevista->calcular_correlativo();




        $input = $request->all();
        //Remiendo: por baboso estos campos se llaman diferente en e_ind_fvt
        $input['clasifica_nna'] = $request->clasificacion_nna;
        $input['clasifica_res']  = $request->clasificacion_res;
        $input['clasifica_sex']  = $request->clasificacion_sex;
        $input['clasifica_r1']  = $request->clasificacion_r1;
        $input['clasifica_r2']  = $request->clasificacion_r2;
        //Fin del remiendo
        //Datos calculados
        $input['entrevista_numero']=$entrevista_numero;
        $input['id_entrevistador']=$id_entrevistador;
        $input['id_macroterritorio']=$request->id_territorio_macro;
        $input['entrevista_codigo']=$entrevista_codigo;
        $input['entrevista_correlativo']=$entrevista_correlativo;
        $input['entrevista_fecha']=$request->entrevista_fecha_submit;
        $input['numero_entrevistador'] = entrevistador::find($id_entrevistador)->numero_entrevistador;

        //Hechos del - al
        $f_hechos=explode(" - ",$request->hechos_rango);
        try {
            $hechos_del = Carbon::createFromFormat("d/m/Y",$f_hechos[0])->format("Y-m-d");
            $hechos_al = Carbon::createFromFormat("d/m/Y",$f_hechos[1])->format("Y-m-d");
        }
        catch(\Exception $e) {
            Flash::error("Fecha de los hechos inválida, favor de revisar este dato");
            return redirect()->back()->withInput($request->all());
        }

        $input['hechos_del']=$hechos_del;
        $input['hechos_al']=$hechos_al;
        try {
            $nueva = entrevista_individual::create($input);
            $nueva->clasificar_acceso();
            $nueva->save();



            if($nueva->id_subserie == config('expedientes.vi')) {
                //Tablitas de detalle
                //Fuerza responsable
                if(!is_array($request->fr)) {
                    $request->fr=array($request->fr);
                }
                foreach($request->fr as $id) {
                    $tmp['id_e_ind_fvt'] = $nueva->id_e_ind_fvt;
                    $tmp['id_fr']=$id;
                    $adjunto_fr = entrevista_individual_fr::create($tmp);
                }
                //Tipos de violacion
                if(!is_array($request->tv)) {
                    $request->tv=array($request->tv);
                }
                foreach($request->tv as $id) {
                    $tmp['id_e_ind_fvt'] = $nueva->id_e_ind_fvt;
                    $tmp['id_tv']=$id;
                    $adjunto_tv = entrevista_individual_tv::create($tmp);
                }
            }
            elseif($nueva->id_subserie == config('expedientes.aa')) {
                //Fuerza responsable
                if(!is_array($request->fr)) {
                    $request->fr=array($request->fr);
                }
                foreach($request->fr as $id) {
                    $tmp['id_e_ind_fvt'] = $nueva->id_e_ind_fvt;
                    $tmp['id_fr']=$id;
                    $adjunto_fr = entrevista_individual_fr::create($tmp);
                }

                //Temas de Actor Armado
                if (!is_array($request->aa)) {
                    $request->aa = array($request->aa);
                }
                foreach ($request->aa as $id) {
                    $tmp['id_e_ind_fvt'] = $nueva->id_e_ind_fvt;
                    $tmp['id_aa'] = $id;
                    $adjunto_aa = entrevista_individual_aa::create($tmp);
                }
            }
            elseif($nueva->id_subserie == config('expedientes.tc')) {
                //Fuerza responsable
                if(!is_array($request->stc)) {
                    $request->stc=array($request->stc);
                }
                foreach($request->stc as $id) {
                    $tmp['id_e_ind_fvt'] = $nueva->id_e_ind_fvt;
                    $tmp['id_stc']=$id;
                    $adjunto_fr = entrevista_individual_stc::create($tmp);
                }
                //Temas de Tercero Civil
                if (!is_array($request->tc)) {
                    $request->tc = array($request->tc);
                }
                foreach ($request->tc as $id) {
                    $tmp['id_e_ind_fvt'] = $nueva->id_e_ind_fvt;
                    $tmp['id_tc'] = $id;
                    $adjunto_tc = entrevista_individual_tc::create($tmp);
                }
            }

            //Analisis preliminar: interes nucleos
            if(!is_array($request->interes)) {
                $request->interes=array($request->interes);
            }
            foreach($request->interes as $id) {
                $tmp['id_e_ind_fvt'] = $nueva->id_e_ind_fvt;
                $tmp['id_interes']=$id;
                $registro = entrevista_individual_interes::create($tmp);
            }
            //Analisis preliminar: interes area
            if(!is_array($request->interes_area)) {
                $request->interes_area=array($request->interes_area);
            }
            foreach($request->interes_area as $id) {
                if($id>0) {
                    $tmp['id_e_ind_fvt'] = $nueva->id_e_ind_fvt;
                    $tmp['id_interes']=$id;
                    $registro = entrevista_individual_interes_area::create($tmp);
                }

            }
            //Analisis preliminar: mandato
            if(!is_array($request->mandato)) {
                $request->mandato=array($request->mandato);
            }
            foreach($request->mandato as $id) {
                $tmp['id_e_ind_fvt'] = $nueva->id_e_ind_fvt;
                $tmp['id_mandato']=$id;
                $registro = entrevista_individual_mandato::create($tmp);
            }
            //Analisis preliminar: dinamicas
            if(!is_array($request->dinamica)) {
                $request->dinamica=array($request->dinamica);
            }
            foreach($request->dinamica as $txt) {
                $txt=trim($txt);
                if(strlen($txt)>0) {
                    $tmp['id_e_ind_fvt'] = $nueva->id_e_ind_fvt;
                    $tmp['dinamica']=trim($txt);
                    $registro = entrevista_individual_dinamica::create($tmp);
                }

            }

            // Logica nueva de la ficha de entrevistas
            // $f_entrevista = new entrevista();
            $request['id_e_ind_fvt']=$nueva->id_e_ind_fvt;
            //Log::info($request);
            entrevista::nuevo_procesar_request($request);
            // $f_entrevista->procesar_request($request);




            Flash::success('Entrevista almacenada exitosamente. Proceda a anexar los archivos respectivos');

            //Registrar traza
            traza_actividad::create(['id_objeto'=>1, 'id_accion'=>3, 'codigo'=>$nueva->entrevista_codigo, 'id_primaria'=>$nueva->id_e_ind_fvt]);

            //return redirect()->action('entrevista_individualController@show',$nueva->id_e_ind_fvt);
            return redirect()->action('entrevista_individualController@gestionar_adjuntos',$nueva->id_e_ind_fvt);

        }
        catch (\Exception $e) {
            Flash::error('Problemas: '.$e->getMessage());
            return redirect(action('entrevista_individualController@index'));
        }




    }

    /**
     * Display the specified entrevista_individual.
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
        $entrevistaIndividual = $this->entrevistaIndividualRepository->findWithoutFail($id);
        if (empty($entrevistaIndividual)) {
            //Flash::error("Entrevista Individual no existe (sh-ei)($id)");
            return redirect(route('entrevistaIndividuals.index'));
        }

        //2: Confirmar acceso del usuario a la entrevista
        if(!$entrevistaIndividual->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Registrar traza
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>6, 'codigo'=>$entrevistaIndividual->entrevista_codigo, 'id_primaria'=>$entrevistaIndividual->id_e_ind_fvt]);


        $entrevista = entrevista::where('id_e_ind_fvt', $id)->first();

        if(!is_object($entrevista))
        {
          $entrevista=new entrevista();
          $entrevista->valores_iniciales();
        }
        //Para el navegador
        $txt_titulo = "Ent. ".$entrevistaIndividual->entrevista_codigo;

        return view('entrevista_individuals.show',compact('entrevistaIndividual','entrevista','txt_titulo'));

        if($entrevistaIndividual->id_subserie == config('expedientes.vi')) {
            return view('entrevista_individuals.show_tabs',compact('entrevistaIndividual','entrevista','txt_titulo'));
        }
        else {
            return view('entrevista_individuals.show',compact('entrevistaIndividual','entrevista','txt_titulo'));
        }


        // return view('entrevista_individuals.show')->with('entrevistaIndividual'), $entrevistaIndividual)->with('entrevista'), $entrevista);
    }

    /**
     * Show the form for editing the specified entrevista_individual.
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
        $entrevistaIndividual = $this->entrevistaIndividualRepository->findWithoutFail($id);

        if (empty($entrevistaIndividual)) {
            Flash::error('Entrevista Individual no existe');
            return redirect(route('entrevistaIndividuals.index'));
        }



        //Revisar privilegios
        if(!$entrevistaIndividual->puede_modificar_entrevista()) {
            abort(403, "No puede modificar la entrevista.");
        }


        $entrevista = entrevista::where('id_e_ind_fvt', $id)->first();

        if(!is_object($entrevista))
        {
          $entrevista=new entrevista();
          $entrevista->valores_iniciales();
        }
        //$entrevista->conceder_entrevista=2;
        //$entrevista["conceder_entrevista"]=2;
        //return view('entrevista_individuals.edit')->with('entrevistaIndividual', $entrevistaIndividual)->with('entrevista', $entrevista);
          return view('entrevista_individuals.edit',compact('entrevistaIndividual'),compact('entrevista'));
    }

    /**
     * Update the specified entrevista_individual in storage.
     *
     * @param  int              $id
     * @param Updateentrevista_individualRequest $request
     *
     * @return Response
     */
    public function update($id, Updateentrevista_individualRequest $request)
    {
        $entrevista = entrevista_individual::find($id);
        $input = $request->all();
        //Remiendo: por baboso estos campos se llaman diferente en e_ind_fvt
        $input['clasifica_nna'] = $request->clasificacion_nna;
        $input['clasifica_res']  = $request->clasificacion_res;
        $input['clasifica_sex']  = $request->clasificacion_sex;
        $input['clasifica_r1']  = $request->clasificacion_r1;
        $input['clasifica_r2']  = $request->clasificacion_r2;
        //Fin del remiendo


        if (empty($entrevista)) {
            Flash::error("Entrevista Individual ($id) no existe");
            return redirect(action('entrevista_individualController@index'));
        }

        //Revisar que el número no se duplique
        $existe = entrevista_individual::where('id_entrevistador',$request->id_entrevistador)
            ->where('id_subserie',(integer)$request->id_subserie)
            ->where('entrevista_numero',$request->entrevista_numero)
            ->where('id_e_ind_fvt','<>',$id)
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
        //La subserie no puede cambiar
        unset($input['id_subserie']);


        //Macroterritorio
        $input['id_macroterritorio'] = $request->id_territorio_macro;
        //Fechas
        $input['entrevista_fecha']=$request->entrevista_fecha_submit;
        $f_hechos=explode(" - ",$request->hechos_rango);
        $hechos_del = Carbon::createFromFormat("d/m/Y",$f_hechos[0])->format("Y-m-d");
        $hechos_al = Carbon::createFromFormat("d/m/Y",$f_hechos[1])->format("Y-m-d");
        $input['hechos_del']=$hechos_del;
        $input['hechos_al']=$hechos_al;
        //dd($input);

        //Actualizar la BD
        $entrevista->fill($input);

        //Clasificar reservada-3 o reservada-4
        $entrevista->clasificar_acceso();

        //Recalcular el código, usar el entrevistador que tiene, no el logueado por aquello que otro lo modifique
        $entrevista->entrevista_codigo = $entrevista->calcular_codigo();

        $entrevista->save();


        /////// ENTIDADES DEBILES
        // Los adjuntos se gestionan por aparte (si son mas de 4, puede dar problemas el borrarlos todos)
        if($entrevista->id_subserie == config('expedientes.vi')) {
            //Fuerzas responsables
            $entrevista->rel_fr()->delete();
            //Fuerza responsable
            if (!is_array($request->fr)) {
                $request->fr = array($request->fr);
            }
            foreach ($request->fr as $id) {
                $tmp['id_e_ind_fvt'] = $entrevista->id_e_ind_fvt;
                $tmp['id_fr'] = $id;
                $adjunto_fr = entrevista_individual_fr::create($tmp);
            }
            //Tipos de violacion
            $entrevista->rel_tv()->delete();
            if (!is_array($request->tv)) {
                $request->tv = array($request->tv);
            }
            foreach ($request->tv as $id) {
                $tmp['id_e_ind_fvt'] = $entrevista->id_e_ind_fvt;
                $tmp['id_tv'] = $id;
                $adjunto_tv = entrevista_individual_tv::create($tmp);
            }
        }
        elseif($entrevista->id_subserie == config('expedientes.aa')) {
            //Fuerzas responsables
            $entrevista->rel_fr()->delete();
            if (!is_array($request->fr)) {
                $request->fr = array($request->fr);
            }
            foreach ($request->fr as $id) {
                $tmp['id_e_ind_fvt'] = $entrevista->id_e_ind_fvt;
                $tmp['id_fr'] = $id;
                $adjunto_fr = entrevista_individual_fr::create($tmp);
            }
            //Temas
            $entrevista->rel_aa()->delete();
            if (!is_array($request->aa)) {
                $request->aa = array($request->aa);
            }
            foreach ($request->aa as $id) {
                $tmp['id_e_ind_fvt'] = $entrevista->id_e_ind_fvt;
                $tmp['id_aa'] = $id;
                $adjunto_aa = entrevista_individual_aa::create($tmp);
            }
        }
        elseif($entrevista->id_subserie == config('expedientes.tc')) {
            //Sectores
            $entrevista->rel_stc()->delete();
            if (!is_array($request->stc)) {
                $request->stc = array($request->stc);
            }
            foreach ($request->stc as $id) {
                $tmp['id_e_ind_fvt'] = $entrevista->id_e_ind_fvt;
                $tmp['id_stc'] = $id;
                $adjunto_stc = entrevista_individual_stc::create($tmp);
            }
            //Temas
            $entrevista->rel_tc()->delete();
            if (!is_array($request->tc)) {
                $request->tc = array($request->tc);
            }
            foreach ($request->tc as $id) {
                $tmp['id_e_ind_fvt'] = $entrevista->id_e_ind_fvt;
                $tmp['id_tc'] = $id;
                $adjunto_tc = entrevista_individual_tc::create($tmp);
            }
        }
        //Analisis preliminar: interes núcleos
        $entrevista->rel_interes()->delete();
        if(!is_array($request->interes)) {
            $request->interes=array($request->interes);
        }
        foreach($request->interes as $id) {
            if($id>0) {
                $tmp['id_e_ind_fvt'] = $entrevista->id_e_ind_fvt;
                $tmp['id_interes'] = $id;
                $registro = entrevista_individual_interes::create($tmp);
            }
        }
        //Analisis preliminar: interes area
        $entrevista->rel_interes_area()->delete();
        if(!is_array($request->interes_area)) {
            $request->interes_area=array($request->interes_area);
        }
        foreach($request->interes_area as $id) {
            if($id>0) {
                $tmp['id_e_ind_fvt'] = $entrevista->id_e_ind_fvt;
                $tmp['id_interes']=$id;
                $registro = entrevista_individual_interes_area::create($tmp);
            }

        }
        //Analisis preliminar: mandato
        $entrevista->rel_mandato()->delete();
        if(!is_array($request->mandato)) {
            $request->mandato=array($request->mandato);
        }
        foreach($request->mandato as $id) {
            $tmp['id_e_ind_fvt'] = $entrevista->id_e_ind_fvt;
            $tmp['id_mandato']=$id;
            $registro = entrevista_individual_mandato::create($tmp);
        }
        //Analisis preliminar: dinamicas
        //dd($request->dinamica);
        $entrevista->rel_dinamica()->delete();
        if(!is_array($request->dinamica)) {
            $request->dinamica=array($request->dinamica);
        }
        foreach($request->dinamica as $txt) {
            $txt=trim($txt);
            if(strlen($txt)>0) {
                $tmp['id_e_ind_fvt'] = $entrevista->id_e_ind_fvt;
                $tmp['dinamica']=trim($txt);
                $registro = entrevista_individual_dinamica::create($tmp);
            }
        }

        // Logica nueva de la ficha de entrevistas
        //entrevista::nuevo_procesar_request($request);
        //$f_entrevista = new entrevista();
        //$f_entrevista-> ($request);

       $request['id_e_ind_fvt']=$entrevista->id_e_ind_fvt;
      //  Log::info($request);
        entrevista::nuevo_procesar_request($request);
        //entrevista::actualiza_procesar_request($request);
        // Log::info($request);


        Flash::success('Entrevista actualizada.');
        //Registrar traza
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>4, 'codigo'=>$entrevista->entrevista_codigo , 'id_primaria'=>$entrevista->id_e_ind_fvt]);

        return redirect(action("entrevista_individualController@show",$entrevista->id_e_ind_fvt));
    }

    /**
     * Remove the specified entrevista_individual from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        abort(403);

        $entrevistaIndividual = $this->entrevistaIndividualRepository->findWithoutFail($id);
        if (empty($entrevistaIndividual)) {
            Flash::error('Entrevista Individual no existe');
            return redirect(route('entrevistaIndividuals.index'));
        }
        $entrevistaIndividual->id_activo=2;
        $entrevistaIndividual->save();

        return redirect(route('entrevistaIndividuals.index'));
    }


    //Para la gestión de adjuntos
    public function gestionar_adjuntos($id) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $entrevistaIndividual = $this->entrevistaIndividualRepository->findWithoutFail($id);

        if (empty($entrevistaIndividual)) {
            Flash::error("Entrevista Individual no existe (ga)($id)");
            return redirect(route('entrevistaIndividuals.index'));
        }


        //Ver que tenga permisos
        if(!$entrevistaIndividual->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }


        //Segundo chequeo: reservado-3
        if(!$entrevistaIndividual->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
        }

        //Solo lectura
        //Revisar privilegios
        if(!$entrevistaIndividual->puede_modificar_entrevista()) {
            abort(403, "No puede modificar la entrevista.");
        }




        return view('entrevista_individuals.gestionar_adjuntos')->with('entrevistaIndividual', $entrevistaIndividual);

    }
    //Recibe el post del formulario de agregar mas adjuntos  (usado al final transcripciones)
    public function agregar_adjuntos($id, Request $request) {
        //Ver que exista
        $entrevista = entrevista_individual::find($id);


        if (empty($entrevista)) {
            Flash::error("Entrevista Individual no existe (aa)($id)");
            return redirect(route('entrevistaIndividuals.index'));
        }


        //Ver que tenga permisos
        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }


        //Segundo chequeo: reservado-3
        if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
        }




        //Agregar los archivos

        if(!empty($request->archivo_ci_filename)) {
            $archivo = str_replace("/storage/","/",$request->archivo_ci_filename);  //Quitar /storage/ al inicio
            $adjunto = adjunto::create(['ubicacion'=>$archivo]);
            $tmp['id_e_ind_fvt'] = $id;
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
        return redirect(action('entrevista_individualController@gestionar_adjuntos',$id));


    }

    //Para refrescar por ajax la tabla luego del upload
    public function tabla_adjuntos($id) {

        $entrevistaIndividual = $this->entrevistaIndividualRepository->findWithoutFail($id);


        if(!$entrevistaIndividual->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        return view('entrevista_individuals.tabla_adjuntos')->with('entrevistaIndividual', $entrevistaIndividual);

    }

    public function excel_plano() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $this->authorize('nivel-1');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>8]);
        return Excel::download(new entrevistaExport,"entrevistas_victimas_$fecha.xlsx");
    }
    public function excel_plano_anonimo() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>8]);
        return Excel::download(new entrevistaExport(true),"entrevistas_victimas_anonimo_$fecha.xlsx");
    }

    //Llamado a partir de un filtro.  Recibe el arreglo de los id_e_ind_fvt a exportar
    public function excel_plano_resultados($arreglo, $nombre="entrevistas_victimas_res") {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>8]);

        $anonimo = \Gate::denies('nivel-1');

        if($anonimo) {
            $nombre.="_anom";
        }
        return Excel::download(new entrevista_resultadosExport($arreglo, $anonimo),$nombre."_".$fecha.".xlsx");
    }


    public function excel_dinamica() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $this->authorize('nivel-1');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>8]);
        ignore_user_abort(TRUE);
        return Excel::download(new dinamicaExport(),"dinamicas_$fecha.xlsx");
    }
    public function excel_integrado() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $this->authorize('nivel-1');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>8]);
        return Excel::download(new entrevista_integradaExport,"entrevistas_integrado_$fecha.xlsx");
    }
    public function excel_integrado_anonimo() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>8]);
        return Excel::download(new entrevista_integradaExport(true),"entrevistas_integrado_anonimo_$fecha.xlsx");
    }
    //Con entrevistas borradas
    public function excel_integrado_monitoreo() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $this->authorize('nivel-1');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>8]);
        return Excel::download(new excel_integrado_monitoreoExport(),"entrevistas_integrado_monitoreo_$fecha.xlsx");
    }
    //Diligenciar los formularios
    public  function fichas($id) {
        $expediente = entrevista_individual::find($id);

        if (empty($expediente)) {
            Flash::error("Entrevista Individual no existe (f)($id)");
            return redirect(route('entrevistaIndividuals.index'));
        }

        //Ver que tenga permisos de acceso a la entrevista
        if(!$expediente->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Segundo chequeo: reservado-3
        if(!$expediente->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO.");
        }

        //Ver que tenga permisos de modificar la ficha
        $permisos = $expediente->permitir_modificar_fichas();
        if($permisos->permitido) {
            $conteos = $expediente->conteo_fichas();
            return view("entrevista_individuals.fichas",compact('expediente','conteos'));
        }
        else {
            abort(403,$permisos->texto);
        }

    }
    
    //Mostar los formularios
    public  function fichas_show($id, Request $request) {
        $expediente = entrevista_individual::find($id);

        if (empty($expediente)) {
            Flash::error("Entrevista Individual no existe (fsh)($id)");
            return redirect(route('entrevistaIndividuals.index'));
        }

        //Ver que tenga permisos de acceso a la entrevista
        if(!$expediente->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Segundo chequeo: reservado-3
        if(!$expediente->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
        }


        //Ver que tenga permisos de consultar la ficha
        $permisos = $expediente->permitir_ver_fichas();
        if($permisos->permitido) {
            $conteos = $expediente->conteo_fichas();
            $no_editar=true;

            // Para mostrar los impactos
            $hay_justicia = entrevista_justicia::entrevista($id)->first();
            $entrevista_justicia = $hay_justicia ? $hay_justicia : new entrevista_justicia();

            $hay_encabezado = entrevista_impacto::entrevista($id)->wherenull('id_impacto')->first();
            if($hay_encabezado) {
                $impacto =$hay_encabezado;
            }
            else {
                $impacto=new \stdClass();
                $impacto->transgeneracionales="";
                $impacto->afrentamiento_proceso="";
            }
            $ocultar_boton_volver=false;
            if(isset($request->volver)) {
                if($request->volver==0) {
                    $ocultar_boton_volver=true;
                }
            }
            return view("entrevista_individuals.fichas",compact('expediente','conteos','no_editar','entrevista_justicia','impacto','ocultar_boton_volver'));
        }
        else {
            abort(403,$permisos->texto);
        }


    }
    public function json_entrevista(Request $request) {

        $filtros=entrevista_individual::filtros_default($request);

        //Mapa Conflictos
        $datos = entrevista_individual::json_mapa($filtros,1);
        return response()->json($datos);
    }
    public function json_hechos(Request $request) {
        $datos=new \stdClass();
        $datos->filtros=entrevista_individual::filtros_default($request);

        //Mapa Conflictos
        $datos = entrevista_individual::json_mapa($datos->filtros,2);
        return response()->json($datos);
    }
    //Para el mapa de fichas de hechos
    public function json_hechos_ficha(Request $request) {
        $datos=new \stdClass();
        $filtros = entrevista_individual::filtros_default($request);

        //Mapa Conflictos
        $datos = entrevista_individual::json_mapa_violencia($filtros,2);
        return response()->json($datos);
    }

    public function json_hechos_ficha_v2(Request $request) {
        $datos=new \stdClass();
        $filtros = entrevista_individual::filtros_default($request);

        //Mapa Conflictos
        $datos = entrevista_individual::json_mapa_violencia_v2($filtros,2);
        return response()->json($datos);
    }




    public function json_numero(Request $request) {
        $numero = intval($request->numero);
        $id_subserie = isset($respuesta->id_subserie) ? $respuesta->id_subserie : config('expedientes.vi');
        $respuesta = new \stdClass();
        $respuesta->id=0;
        $respuesta->txt="Desconocido";
        if($numero>0) {
            $e = entrevista_individual::where('id_subserie',$id_subserie)->where('entrevista_correlativo',$numero)->first();
            if($e) {
                $respuesta->id = $e->id_e_ind_fvt;
                $respuesta->txt = $e->entrevista_codigo;
            }
        }
        return json_encode($respuesta);
    }

    public function generar_excel_plano() {
        $inicio = \Carbon\Carbon::now();
        $total = excel_entrevista::generar_plana(true);
        $fin= \Carbon\Carbon::now();
        $tiempo = $inicio->diffForHumans($fin);
        $respuesta=new \stdClass();
        $respuesta->inicio=$inicio;
        $respuesta->fin=$fin;
        $respuesta->tiempo=$tiempo;
        $respuesta->filas=$total;
        return response()->json($respuesta);
    }
    public function generar_excel_dinamica() {
        $inicio = \Carbon\Carbon::now();
        $total = excel_entrevista_dinamica::generar_plana(true);
        $fin= \Carbon\Carbon::now();
        $tiempo = $inicio->diffForHumans($fin);
        $respuesta=new \stdClass();
        $respuesta->inicio=$inicio;
        $respuesta->fin=$fin;
        $respuesta->tiempo=$tiempo;
        $respuesta->filas=$total;

        return response()->json($respuesta);
    }
    //integracion de datos
    public function generar_sim_victima() {
        ignore_user_abort(TRUE);
        $inicio = \Carbon\Carbon::now();
        $total = sim_entrevista_victima::generar_plana(true);
        $fin= \Carbon\Carbon::now();
        $tiempo = $inicio->diffForHumans($fin);
        $respuesta=new \stdClass();
        $respuesta->inicio=$inicio;
        $respuesta->fin=$fin;
        $respuesta->tiempo=$tiempo;
        $respuesta->filas=$total;
        return response()->json($respuesta);
    }

    //Generar integrado
    public function generar_excel_integrado() {
        $inicio = \Carbon\Carbon::now();
        $total = excel_entrevista_integrado::generar_plana(true);
        $fin= \Carbon\Carbon::now();
        $tiempo = $inicio->diffForHumans($fin);
        $respuesta=new \stdClass();
        $respuesta->integrado = new \stdClass();
        $respuesta->integrado->inicio=$inicio;
        $respuesta->integrado->fin=$fin;
        $respuesta->integrado->tiempo=$tiempo;
        $respuesta->integrado->filas=$total;
        $respuesta->monitoreo = excel_integrado_monitoreo::generar_plana(); //Incluye los borrados
        return response()->json($respuesta);
    }
    //Poblar tabla de excel_ficha_persona_enrevsitada
    public function generar_excel_ficha_persona_entrevistada() {
        ignore_user_abort(TRUE);
        $inicio = \Carbon\Carbon::now();
        $total = excel_ficha_persona_entrevistada::generar_plana();
        $fin= \Carbon\Carbon::now();
        $tiempo = $fin->diffForHumans($inicio);
        $respuesta=new \stdClass();
        $respuesta->inicio=$inicio;
        $respuesta->fin=$fin;
        $respuesta->tiempo=$tiempo;
        $respuesta->filas=$total;

        $excel = excel_personas_entrevistadas::generar_plana();
        $generacion = new \stdClass();
        $generacion->ficha_pe = $respuesta;
        $generacion->excel_pe = $excel;
        return response()->json($generacion);
    }
    public function generar_excel_seguimiento() {
        ignore_user_abort(TRUE);
        $respuesta = excel_seguimiento_entrevistas::generar_plana();
        return response()->json($respuesta);
    }
    public function descargar_excel_seguminiento() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>106, 'id_accion'=>8]);
        return Excel::download(new excel_entrevista_seguimientoExport(),"seguimiento_entrevistas_$fecha.xlsx");
    }

    //Generar excel de seguimiento


    //Descargar excel con contenido de tabla excel_ficha_persona_entrevistada
    public function descargar_excel_ficha_persona_entrevistada() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $this->authorize('nivel-1');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>103, 'id_accion'=>8]);
        return Excel::download(new ficha_persona_entrevistadaExporte,"ficha_persona_entrevistada_$fecha.xlsx");
    }
    //Descargar excel con contenido de tabla excel_ficha_persona_entrevistada
    public function descargar_excel_ficha_persona_entrevistada_anonimo() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>103, 'id_accion'=>8]);
        return Excel::download(new ficha_persona_entrevistadaExporte(true),"ficha_persona_entrevistada_anonimizada_$fecha.xlsx");
    }


    //Poblar tabla de excel_ficha_victima
    public function generar_excel_ficha_victima() {
        ignore_user_abort(TRUE);
        $inicio = \Carbon\Carbon::now();
        $total = excel_ficha_victima::generar_plana();
        $fin= \Carbon\Carbon::now();
        $tiempo = $fin->diffForHumans($inicio);
        $respuesta=new \stdClass();
        $respuesta->inicio=$inicio;
        $respuesta->fin=$fin;
        $respuesta->tiempo=$tiempo;
        $respuesta->filas=$total;
        return response()->json($respuesta);
    }
    //Descargar excel con contenido de tabla excel_ficha_persona_entrevistada
    public function descargar_excel_ficha_victima() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $this->authorize('nivel-1');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>104, 'id_accion'=>8]);
        return Excel::download(new ficha_victimaExport,"ficha_victima_$fecha.xlsx");
    }
    //Descargar excel con contenido de tabla excel_ficha_persona_entrevistada
    public function descargar_excel_ficha_victima_anonimo() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>104, 'id_accion'=>8]);
        return Excel::download(new ficha_victimaExport(true),"ficha_victima_anonimizado_$fecha.xlsx");
    }




    // Grabar comentarios de la diligenciada
    public function grabar_comentarios(Request $request) {

        $entrevista = entrevista_individual::find($request->id_e_ind_fvt);
        if($entrevista) {
            $entrevista->observaciones_diligenciada = $request->observaciones_diligenciada;
            $entrevista->save();
        }
        return redirect()->back();
    }

    public function autofill_prioritario(Request $request) {
        return entrevista_individual::listado_priorizacion($request->texto);
    }
    public function autofill_titulo(Request $request) {
        return entrevista_individual::listado_titulo($request->texto);
    }
    public function autofill_dinamica(Request $request) {
        return entrevista_individual::listado_dinamica($request->texto);
    }
    public function autofill_anotaciones(Request $request) {
        return entrevista_individual::listado_anotaciones($request->texto);
    }
    public function autofill_observaciones_diligenciada(Request $request) {
        return entrevista_individual::listado_observaciones_diligenciada($request->texto);
    }





    public function desclasificar($id)
    {
        //Negar acceso a los de solo estadistica
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        //1: Confirmar que  que exista
        $entrevistaIndividual = $this->entrevistaIndividualRepository->findWithoutFail($id);
        if (empty($entrevistaIndividual)) {
            Flash::error("Entrevista Individual no existe (des)($id)");
            return redirect(route('entrevistaIndividuals.index'));
        }

        //2: Confirmar acceso del usuario a la entrevista
        if(!$entrevistaIndividual->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Revisar privilegios de R3
        if(!$entrevistaIndividual->puede_desclasificar_entrevista()) {
            abort(403, "No puede modificar la entrevista.");
        }

        //Revisar que requiera clasificacion
        if($entrevistaIndividual->clasifica_nivel > 3 ) {
            abort(403, "Esta es una entrevista clasificacion R-$entrevistaIndividual->clasifica_nivel.");
        }

        return view('entrevista_individuals.desclasificar',compact('entrevistaIndividual'));
        // return view('entrevista_individuals.show')->with('entrevistaIndividual'), $entrevistaIndividual)->with('entrevista'), $entrevista);
    }

    // Anular/recuperar una entrevista
    public  function anular($id) {
        $this->authorize('nivel-1');
        $expediente = entrevista_individual::find($id);
        $expediente->id_activo = $expediente->id_activo == 1 ? 2 : 1 ;
        $expediente->save();
        $codigo = $expediente->entrevista_codigo;
        $verbo = $expediente->id_activo == 1 ? "recuperado" : "anulado";
        //Registrar traza
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>10, 'referencia'=>$verbo ,'codigo'=>$expediente->entrevista_codigo, 'id_primaria'=>$expediente->id_e_ind_fvt]);

        return redirect(action('entrevista_individualController@show',$expediente->id_e_ind_fvt));
        //return ("Expediente $codigo $verbo");

    }
    //Convierte en PR
    public static function trasladar_pr($id) {
        //dd($id);
        $existe = entrevista_individual::find($id);
        if($existe) {
            $nueva = $existe->trasladar_pr();
            if($nueva) {
                Flash::success("Entrevista guardada como $nueva->entrevista_codigo");
                return redirect()->action('entrevista_profundidadController@show',$nueva->id_entrevista_profundidad);
            }
            else {
                Flash::error('Hubo prolemas con el traslado de la entrevista');
                return redirect()->back();
            }
        }
        else {
            Flash::error("No existe la entrevista individual $id");
            return redirect()->back();
        }

    }
    //Convierte en HV
    public static function trasladar_hv($id) {
        //dd($id);
        $existe = entrevista_individual::find($id);
        if($existe) {
            $nueva = $existe->trasladar_hv();
            if($nueva) {
                Flash::success("Entrevista guardada como $nueva->entrevista_codigo");
                return redirect()->action('historia_vidaController@show',$nueva->id_historia_vida);
            }
            else {
                Flash::error('Hubo prolemas con el traslado de la entrevista');
                return redirect()->back();
            }
        }
        else {
            Flash::error("No existe la entrevista individual $id");
            return redirect()->back();
        }

    }

    //Convierte en CO
    public static function trasladar_co($id) {
        //dd($id);
        $existe = entrevista_individual::find($id);
        if($existe) {
            $nueva = $existe->trasladar_co();
            if($nueva) {
                Flash::success("Entrevista guardada como $nueva->entrevista_codigo");
                return redirect()->action('entrevista_colectivaController@show',$nueva->id_entrevista_colectiva);
            }
            else {
                Flash::error('Hubo prolemas con el traslado de la entrevista');
                return redirect()->back();
            }
        }
        else {
            Flash::error("No existe la entrevista individual $id");
            return redirect()->back();
        }

    }
}
