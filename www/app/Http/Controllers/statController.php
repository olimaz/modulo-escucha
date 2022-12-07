<?php

namespace App\Http\Controllers;

use App\Exports\entrevista_resultadosExport;
use App\Exports\excel_etiquetadoExport;
use App\Exports\personas_entrevistadasExport;
use App\Exports\uso_tesauroExport;
use App\graficador;
use App\Models\analitica_violencia;
use App\Models\casos_informes;
use App\Models\diagnostico_comunitario;
use App\Models\entrevista_colectiva;
use App\Models\entrevista_etnica;
use App\Models\entrevista_individual;
use App\Models\entrevista_prioridad;
use App\Models\entrevista_profundidad;
use App\Models\entrevistador;
use App\Models\etiqueta;
use App\Models\etiqueta_entrevista;
use App\Models\evento;
use App\Models\excel_personas_entrevistadas;
use App\Models\historia_vida;
use App\Models\marca_entrevista;
use App\Models\nvivo_clasificador;
use App\Models\stats;
use App\Models\tesauro;
use App\Models\traza_actividad;
use App\Models\traza_buscador;
use App\User;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Facades\Excel;

class statController extends Controller
{

    //Buscadora de transcripciones
    public function buscadora(Request $request) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $filtros = entrevista_individual::filtros_default($request);
        if(isset($request->id_tesauro) && !isset($request->p)) {  //Enlace desde el reporte del arbol de etiqutas
            $request->p=2;
        }

        $activa = isset($request->p) ? $request->p : 1;
        if(isset($request->marca)) {  //Buscar por marcas
            $activa=4;
        }

        /*
        $conteo_transcritas = transcribir_asignacion::where('id_situacion',2)->count();
        $conteo_etiquetadas = etiquetar_asignacion::where('id_situacion',2)->count();
        $filtros->conteo_transcritas = $conteo_transcritas;
        $filtros->conteo_etiquetadas = $conteo_etiquetadas;
        */

        $uso_marcas = marca_entrevista::listar_uso_marcas();


        if($activa == 2) {  //Buscar por tesauro

            $entrevistaIndividuals = new entrevista_individual();
            $entrevistasPR = new entrevista_profundidad();
            //Los filtros ya se definieron antes del if

            $query = etiqueta_entrevista::Id_geo_contenida($filtros->id_tesauro)
                                            ->otros_filtros($filtros);
                //$debug['sql']= nl2br($query->toSql());
                //$debug['criterios']=$query->getBindings();
                //dd($debug);
            $tesauro = $query->ordenar()->paginate();


            //Traza
            if($filtros->id_tesauro > 0) {
                $texto = tesauro::find($filtros->id_tesauro);
                traza_buscador::create(['id_tipo'=>2,'texto_buscado'=>trim($texto->codigo)]);
            }



            $txt_titulo = "Buscadora - tesauro";

            return view('buscador.buscadora',compact('filtros','entrevistaIndividuals','entrevistasPR','txt_titulo','tesauro','uso_marcas','activa'));
        }
        elseif($activa == 3) {  //Comparar  tesauro

            $entrevistaIndividuals = new entrevista_individual();
            $entrevistasPR = new entrevista_profundidad();
            //Los filtros ya se definieron antes del if

            $conteos = tesauro::conteo_comparado($filtros);
            $tesauro = tesauro::estructura_completa_comparada($conteos);
            //dd($tesauro);
            // Incluir gráfica
            $json_datos = json_encode(etiqueta_entrevista::json_jerarquico_comparado(true,$conteos));



            //Traza
            if($filtros->id_tesauro > 0) {
                $texto = tesauro::find($filtros->id_tesauro);
                traza_buscador::create(['id_tipo' => 4, 'texto_buscado' => trim($texto->codigo)]);
            }


            $txt_titulo = "Buscadora - comparativa";
            return view('buscador.buscadora',compact('filtros','entrevistaIndividuals','entrevistasPR','txt_titulo','tesauro','uso_marcas','activa','tesauro','json_datos'));
        }
        elseif($activa == 4) { //Buscar marcas

            //Convertirlo para marca_entrevista
            $request->id_marca = $request->marca;

            //Filtros de marca_entrevista.  No uso la misma variable $filtros porque no tiene otras variables usada por la busadora
            $filtros2=marca_entrevista::filtros_default($request);
            $listado = marca_entrevista::filtrar($filtros2)
                                ->where('id_subserie','<>', config('expedientes.mc'))
                                ->select('id_subserie', 'id_entrevista')
                                ->distinct()->paginate();
            //dd($listado);

            //Traza
            if(isset($request->marca)) {
                $texto = implode(",",$filtros2->id_marca);
                traza_buscador::create(['id_tipo'=>3,'texto_buscado'=>$texto]);
            }



            $txt_titulo = "Buscadora - marca";
            return view('buscador.buscadora',compact('filtros','txt_titulo','uso_marcas','listado','activa'));
        }
        else { //Buscar texto
            //if($filtros->hay_filtro_buscadora || strlen($filtros->fts) > 0 ) {
            if($filtros->hay_filtro_buscadora ) {
                //Entrevista individual: victimas
                $filtros->id_subserie=config('expedientes.vi');
                $query = entrevista_individual::filtrar($filtros);
                $entrevistaIndividuals = $query->select(\DB::raw('e_ind_fvt.*'))->paginate(15, ['*'], 'page_vi');

                $debug['sql']= nl2br($query->toSql());
                $debug['criterios']=$query->getBindings();
                //\Log::debug("FTS".\GuzzleHttp\json_encode($debug));
               //dd($debug);
                //
                //Entrevista individual: aa
                $filtros->id_subserie=config('expedientes.aa');
                $query = entrevista_individual::filtrar($filtros);
                $entrevistasAA = $query->select(\DB::raw('e_ind_fvt.*'))->paginate(15, ['*'], 'page_vi');
                //Entrevista individual: tc
                $filtros->id_subserie=config('expedientes.tc');
                $query = entrevista_individual::filtrar($filtros);
                $entrevistasTC = $query->select(\DB::raw('e_ind_fvt.*'))->paginate(15, ['*'], 'page_vi');
                //Entrevista a profundidad
                $filtros_pr = entrevista_profundidad::filtros_default($request);
                $query = entrevista_profundidad::filtrar($filtros_pr);
                $entrevistasPR = $query->select(\DB::raw('entrevista_profundidad.*'))->paginate(15, ['*'], 'page_pr');
                //Entrevistas colectivas
                $filtros_co = entrevista_colectiva::filtros_default($request);
                $query = entrevista_colectiva::filtrar($filtros_co);
                $entrevistasCO = $query->select(\DB::raw('entrevista_colectiva.*'))->paginate(15, ['*'], 'page_co');
                //Entrevistas etnica
                $filtros_ee = entrevista_etnica::filtros_default($request);
                $query = entrevista_etnica::filtrar($filtros_ee);
                $entrevistasEE = $query->select(\DB::raw('entrevista_etnica.*'))->paginate(15, ['*'], 'page_ee');
                //Diagnosticos comunitarios
                $filtros_dc = diagnostico_comunitario::filtros_default($request);
                $query = diagnostico_comunitario::filtrar($filtros_dc);
                $entrevistasDC = $query->select(\DB::raw('diagnostico_comunitario.*'))->paginate(15, ['*'], 'page_dc');
                //Historias de vida
                $filtros_hv = historia_vida::filtros_default($request);
                $query = historia_vida::filtrar($filtros_hv);
                $entrevistasHV = $query->select(\DB::raw('historia_vida.*'))->paginate(15, ['*'], 'page_hv');


                if(strlen(trim($filtros->fts))>0) {
                    traza_buscador::create(['id_tipo'=>1,'texto_buscado'=>trim($filtros->fts)]);
                }
            }
            else {
                $entrevistaIndividuals = new entrevista_individual();
                $entrevistasAA = new entrevista_individual();
                $entrevistasTC = new entrevista_individual();
                $entrevistasPR = new entrevista_profundidad();
                $entrevistasCO = new entrevista_colectiva();
                $entrevistasEE = new entrevista_etnica();
                $entrevistasDC = new diagnostico_comunitario();
                $entrevistasHV = new historia_vida();
            }


            $tesauro=null;



            $txt_titulo = "Buscadora - texto";
            return view('buscador.buscadora',compact('filtros','entrevistaIndividuals','entrevistasAA','entrevistasTC','entrevistasPR', 'entrevistasCO', 'entrevistasEE', 'entrevistasDC','entrevistasHV','txt_titulo','tesauro','uso_marcas','activa'));
        }
        //dd($filtros);



    }
    //Aceptar condiciones de la descarga
    public function descarga_acepto(Request $request) {
        $this->authorize('rol-descarga-transcripciones');  //Solo por rol
        //$cola=$request->getQueryString();
        return view('buscador.descarga_transcripciones', compact('request'));

    }

    //Para descargar todas las transcripciones de un solo
    // Utilizada en la buscadora
    public function descargar_transcripciones(Request $request) {
        $this->authorize('rol-descarga-transcripciones');  //Solo por rol
        $filtros = entrevista_individual::filtros_default($request);
        //dd($filtros);
        //dd($filtros);
        if($filtros->hay_filtro_buscadora ) {
            //Entrevista individual: victimas
            $filtros->id_subserie=config('expedientes.vi');
            $query = entrevista_individual::filtrar($filtros);
            $entrevistaIndividuals = $query->select(\DB::raw('e_ind_fvt.*'))->paginate(15, ['*'], 'page_vi');

            $debug['sql']= nl2br($query->toSql());
            $debug['criterios']=$query->getBindings();
            //\Log::debug("FTS".\GuzzleHttp\json_encode($debug));
            //dd($debug);
            //
            //Entrevista individual: aa
            $filtros->id_subserie=config('expedientes.aa');
            $query = entrevista_individual::filtrar($filtros);
            $entrevistasAA = $query->select(\DB::raw('e_ind_fvt.*'))->paginate(15, ['*'], 'page_vi');
            //Entrevista individual: tc
            $filtros->id_subserie=config('expedientes.tc');
            $query = entrevista_individual::filtrar($filtros);
            $entrevistasTC = $query->select(\DB::raw('e_ind_fvt.*'))->paginate(15, ['*'], 'page_vi');
            //Entrevista a profundidad
            $filtros_pr = entrevista_profundidad::filtros_default($request);
            $query = entrevista_profundidad::filtrar($filtros_pr);
            $entrevistasPR = $query->select(\DB::raw('entrevista_profundidad.*'))->paginate(15, ['*'], 'page_pr');
            //Entrevistas colectivas
            $filtros_co = entrevista_colectiva::filtros_default($request);
            $query = entrevista_colectiva::filtrar($filtros_co);
            $entrevistasCO = $query->select(\DB::raw('entrevista_colectiva.*'))->paginate(15, ['*'], 'page_co');
            //Entrevistas etnica
            $filtros_ee = entrevista_etnica::filtros_default($request);
            $query = entrevista_etnica::filtrar($filtros_ee);
            $entrevistasEE = $query->select(\DB::raw('entrevista_etnica.*'))->paginate(15, ['*'], 'page_ee');
            //Diagnosticos comunitarios
            $filtros_dc = diagnostico_comunitario::filtros_default($request);
            $query = diagnostico_comunitario::filtrar($filtros_dc);
            $entrevistasDC = $query->select(\DB::raw('diagnostico_comunitario.*'))->paginate(15, ['*'], 'page_dc');
            //Historias de vida
            $filtros_hv = historia_vida::filtros_default($request);
            $query = historia_vida::filtrar($filtros_hv);
            $entrevistasHV = $query->select(\DB::raw('historia_vida.*'))->paginate(15, ['*'], 'page_hv');

            $transcripciones = array();
            $entrevistas[]=$entrevistaIndividuals;
            $entrevistas[]=$entrevistasAA;
            $entrevistas[]=$entrevistasTC;
            $entrevistas[]=$entrevistasPR;
            $entrevistas[]=$entrevistasCO;
            $entrevistas[]=$entrevistasEE;
            $entrevistas[]=$entrevistasDC;
            $entrevistas[]=$entrevistasHV;
            foreach($entrevistas as $tipo) {
                foreach($tipo as $e) {
                    $transcripciones[$e->entrevista_codigo] = $e->html_transcripcion;
                }
            }
            if(count($transcripciones) > 0) {
                //Traza de seguridad
                $arr=array();
                //dd($filtros);
                foreach($filtros as $var=>$val){
                    if(is_array($val)) {
                        foreach($val as $val2) {
                            $arr[]="$var"."[]=$val2";
                        }
                    }
                    else {
                            $arr[]="$var=$val";
                    }

                }
                //dd($arr);
                $tmp = implode("&",$arr);
                //dd($tmp);
                traza_actividad::create(['id_objeto'=>55, 'id_accion'=>55, 'codigo'=>'transcripciones', 'id_primaria'=>null, 'referencia'=>$request->fullUrl()."?".$tmp]);
                return stats::exportar_transcripciones($transcripciones);
            }
            else {
                \Flash::warning('Sin transcripciones para exportar');
                return redirect()->action('statController@buscadora');
            }



        }
        else {
            \Flash::warning('No se especificó ningún filtro, no se pueden exportar todas las entrevistas');
            //dd($filtros);
            return redirect()->action('statController@buscadora');
        }

    }

    //Recibe el valor de busqueda rapida y muestra el mejor resultado
    public function busqueda_rapida(Request $request) {
        $buscar  = trim($request->br);
        $buscar = str_replace("'", " ",$buscar);
        $buscar = str_replace('"', " ",$buscar);
        if(empty($buscar)) {
            return redirect()->back()->withInput($request->all());
        }
        $buscar=mb_strtolower($buscar);

        if(strlen($buscar)>=6) { // xxx-vi
            $codigo = substr($buscar,3,3);
            if(strstr($buscar,'-vi')){
                $url=action('entrevista_individualController@index');
                $url.="?id_subserie=".config('expedientes.vi')."&br=$buscar";
                return redirect($url);
            }
            elseif(strstr($buscar,'-aa')) {
                $url=action('entrevista_individualController@index');
                $url.="?id_subserie=".config('expedientes.aa')."&br=$buscar";
                return redirect($url);
            }
            elseif(strstr($buscar,'-tc')) {
                $url=action('entrevista_individualController@index');
                $url.="?id_subserie=".config('expedientes.tc')."&br=$buscar";
                return redirect($url);
            }
            elseif(strstr($buscar,'-co')) {
                $url=action('entrevista_colectivaController@index');
                $url.="?br=$buscar";
                return redirect($url);
            }
            elseif(strstr($buscar,'-ee')) {
                $url=action('entrevista_etnicaController@index');
                $url.="?br=$buscar";
                return redirect($url);
            }
            elseif(strstr($buscar,'-pr')) {
                $url=action('entrevista_profundidadController@index');
                $url.="?br=$buscar";
                return redirect($url);
            }
            elseif(strstr($buscar,'-dc')) {
                $url=action('diagnostico_comunitarioController@index');
                $url.="?br=$buscar";
                return redirect($url);
            }
            elseif(strstr($buscar,'-hv')) {
                $url=action('historia_vidaController@index');
                $url.="?br=$buscar";
                return redirect($url);
            }
            elseif(strstr($buscar,'-ci')) {
                $url=action('casos_informesController@index');
                $url.="?br=$buscar";
                return redirect($url);
            }
            elseif(strstr($buscar,'-ct')) {
                $url=action('mis_casosController@index');
                $url.="?br=$buscar";
                return redirect($url);
            }

        }
        if(isset($request->br_url)) {
            $action = $request->br_url;

            if(strstr($action,'?')) {
                $action.="&br=$buscar";
            }
            else {
                $action.="?br=$buscar";
            }
            return redirect($action);

        }
        else { //algo no está bien

            return redirect('/');
        }

        //dd($request);
    }

    //Para integrar el sim a tableros
    //Recibe el valor de busqueda rapida y muestra el mejor resultado
    public function ubicar($codigo) {
        $buscar=mb_strtolower($codigo);
        //dd($buscar);

        if(strlen($buscar)>=6) { // xxx-vi
            if(strstr($buscar,'-vi')){
                $e = entrevista_individual::entrevista_codigo($buscar)->first();
                if($e) {
                    return redirect()->action('entrevista_individualController@show',$e->id_e_ind_fvt);
                }
            }
            elseif(strstr($buscar,'-aa')) {
                $e = entrevista_individual::entrevista_codigo($buscar)->first();

                if($e) {
                    //dd($e);
                    return redirect()->action('entrevista_individualController@show',$e->id_e_ind_fvt);
                }
            }
            elseif(strstr($buscar,'-tc')) {
                $e = entrevista_individual::entrevista_codigo($buscar)->first();
                if($e) {
                    return redirect()->action('entrevista_individualController@show',$e->id_e_ind_fvt);
                }
            }
            elseif(strstr($buscar,'-co')) {
                $e = entrevista_colectiva::entrevista_codigo($buscar)->first();
                if($e) {
                    return redirect()->action('entrevista_colectivaController@show',$e->id_entrevista_colectiva);
                }
            }
            elseif(strstr($buscar,'-ee')) {
                $e = entrevista_etnica::entrevista_codigo($buscar)->first();
                if($e) {
                    return redirect()->action('entrevista_etnicaController@show',$e->id_entrevista_etnica);
                }
            }
            elseif(strstr($buscar,'-pr')) {
                $e = entrevista_profundidad::entrevista_codigo($buscar)->first();
                if($e) {
                    return redirect()->action('entrevista_profundidadController@show',$e->id_entrevista_profundidad);
                }
            }
            elseif(strstr($buscar,'-dc')) {
                $e = diagnostico_comunitario::entrevista_codigo($buscar)->first();
                if($e) {
                    return redirect()->action('diagnostico_comunitarioController@show',$e->id_diagnostico_comunitario);
                }
            }
            elseif(strstr($buscar,'-hv')) {
                $e = historia_vida::entrevista_codigo($buscar)->first();
                if($e) {
                    return redirect()->action('historia_vidaController@show',$e->id_historia_vida);
                }
            }
            elseif(strstr($buscar,'-ci')) {
                $e = casos_informes::codigo($buscar)->first();
                if($e) {
                    return redirect()->action('casos_informesController@show',$e->id_casos_informes);
                }
            }
        }
        \Flash::error("No se encontró el expediente que corresponde al códgo '$buscar'");
        return redirect(url('entrevistaIndividuals?id_subserie=53'));

        //dd($request);
    }

    //Estadisticas generales metadatos
    public function dash_metadatos(Request $request) {
        $filtros=entrevista_individual::filtros_default($request);

        $total_entrevistas=entrevista_individual::filtrar($filtros)->count();



        $datos = new \stdClass();
        $datos->conteos = entrevista_individual::conteos($request);


        //Graficas de tiempo
        $datos->dia = entrevista_individual::datos_dia($filtros);
        $datos->g_dia = graficador::g_area_doble_eje($datos->dia);

        //Por entrevistador

        $datos->entrevistador = entrevista_individual::datos_entrevistador($filtros);
        $datos->g_entrevistador = graficador::g_columna($datos->entrevistador);

        //Por entrevistador
        $datos->entrevistador_grupo = entrevista_individual::datos_entrevistador_grupo($filtros);
        $datos->g_entrevistador_grupo = graficador::g_pie($datos->entrevistador_grupo);

        //Por clasificacion
        $datos->clasificacion = entrevista_individual::datos_clasificacion($filtros);
        $datos->g_clasificacion = graficador::g_pie($datos->clasificacion);

        //Por macro
        $datos->macro = entrevista_individual::datos_macro($filtros);

        //Super resumen por territorio
        $datos->territorio = entrevista_individual::datos_procesamiento($request);
        //dd($datos->territorio);
        //$datos->g_macro = graficador::g_barra($datos->macro);
        $datos->g_macro = graficador::g_columna_stack($datos->macro);

        // Entrevistas individuales
        $filtros->id_subserie=config('expedintes.vi');
        //Por Fuerza Responsable
        $datos->fr = entrevista_individual::datos_fr($filtros);
        //$datos->g_fr = graficador::g_pie($datos->fr);
        $datos->g_fr = graficador::g_columna($datos->fr);

        //Por Tipo de violacion
        $datos->tv = entrevista_individual::datos_tv($filtros);
        //$datos->g_tv = graficador::g_pie($datos->tv);
        $datos->g_tv = graficador::g_barra($datos->tv);

        // Entrevistas Actores Armados
        $filtros->id_subserie=config('expedintes.aa');
        //Por Fuerza Responsable
        $datos->aa_fr = entrevista_individual::datos_aa_fr($filtros);
        $datos->g_aa_fr = graficador::g_barra($datos->aa_fr);
        //Por temas
        $datos->aa = entrevista_individual::datos_aa($filtros);
        $datos->g_aa = graficador::g_barra($datos->aa);

        // Entrevistas Terceros civiles
        $filtros->id_subserie=config('expedintes.tc');
        //Por Fuerza Responsable
        $datos->stc = entrevista_individual::datos_stc($filtros);
        $datos->g_stc = graficador::g_barra($datos->stc);
        //Por temas
        $datos->tc = entrevista_individual::datos_tc($filtros);
        $datos->g_tc = graficador::g_barra($datos->tc);
        //dd($datos);

        //Entrevistas a profundidad
        $filtros=entrevista_profundidad::filtros_default($request);
        $datos->profundidad = entrevista_profundidad::datos_dash($filtros);

        //Entrevistas etnicas
        $filtros=entrevista_etnica::filtros_default($request);
        $datos->etnica = entrevista_etnica::datos_dash($filtros);

        //Entrevistas colectivas
        $filtros=entrevista_colectiva::filtros_default($request);
        $datos->colectiva = entrevista_colectiva::datos_dash($filtros);

        //Diagnostico comunitario
        $filtros = diagnostico_comunitario::filtros_default($request);
        $datos->dc = diagnostico_comunitario::datos_dash($filtros);

        //Historias de vida
        $filtros = historia_vida::filtros_default($request);
        $datos->hv = historia_vida::datos_dash($filtros);

        //Casos e informes
        $filtros_ci = casos_informes::filtros_default($request);
        $datos->ci = casos_informes::datos_dash($filtros_ci);




        //quitar las fechas para las graficas de tiempo
        $filtros->url_sin_fechas=$filtros->url;
        if(strlen($filtros->url_sin_fechas)>0) {
            $pedazos=explode("&",$filtros->url_sin_fechas);
            foreach($pedazos as $id=>$var) {
                if(strpos($var,"submit")>0) {
                    unset($pedazos[$id]);
                }
            }
            $filtros->url_sin_fechas=implode("&",$pedazos);
        }
        else {
            $filtros->url_sin_fechas="&";
        }

        $filtros->url_cola="";
        //dd($filtros->url);


        //Registrar traza
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>20, 'codigo'=>'stats-metadatos', 'id_primaria'=>null]);


        $txt_titulo = "Estadísticas";
        return view("entrevista_individuals.dash",compact('request','datos','filtros','total_entrevistas','txt_titulo'));


    }

    //No tenía donde poner esto
    // Tomado de https://adldap2.github.io/Adldap2/#/
    public function test_ldap(){
        $var = User::login_ldap("oliver.mazariegos","julio.21");
        dd($var);
    }

    public function test_ldap2($usr='',$pwd=''){
        if($usr=='x') {
            $usr = env('AD_USER');
        }
        if($pwd=='x') {
            $pwd = env('AD_PWD');
        }
        $var = User::login_ldap($usr,$pwd);
        dd($var);
    }

    //Reporte de personas entrevistadas
    public function reporte_entrevistados(Request $request) {
        $this->authorize('rol-reporte-entrevistados');

        $filtros = excel_personas_entrevistadas::filtros_default($request);

        $listado = excel_personas_entrevistadas::select(\DB::raw('excel_personas_entrevistadas.*'))->filtrar($filtros)->ordenar()->paginate();

        $txt_titulo = "Personas entrevistadas";
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>23, 'codigo'=>'reporte-entrev', 'id_primaria'=>null]);
        return view('reportes.entrevistados_v2',compact('listado','txt_titulo','filtros'));
    }


    //Estadisticas de diligenciamiento
    public function stats_diligenciada_vi(Request $request) {
        $txt_titulo = "Datos VI";
        $filtros = entrevista_individual::filtros_default($request);


        $filtros->id_subserie = config('expedientes.vi');  //Solo VI
        $datos = entrevista_individual::stats_diligenciada_vi($filtros);

        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>22, 'codigo'=>'stats-fichas', 'id_primaria'=>null]);


        //dd($datos);
        //return view ('dash_fichas.stats_fichas', compact('datos','filtros','txt_titulo'));
        return view ('dash_fichas.stats_fichas_ajax', compact('datos','filtros','txt_titulo'));

    }
    //Datos de las gráficas de la pestaña de procesamiento
    public function ajax_procesamiento(Request $request) {
        $filtros = entrevista_individual::filtros_default($request);
        $filtros->id_subserie = config('expedientes.vi');  //Solo VI
        $datos = entrevista_individual::json_procesamiento($filtros);
        return response()->json($datos);
    }
    //Datos de las gráficas de la pestaña de persona entrevistada
    public function ajax_entrevistada(Request $request) {
        $filtros = entrevista_individual::filtros_default($request);
        $filtros->id_subserie = config('expedientes.vi');  //Solo VI
        $datos = entrevista_individual::json_entrevistada($filtros);
        return response()->json($datos);
    }
    //Datos de las gráficas de la pestaña de victima
    public function ajax_victima(Request $request) {
        $filtros = entrevista_individual::filtros_default($request);
        $filtros->id_subserie = config('expedientes.vi');  //Solo VI
        $datos = entrevista_individual::json_victima($filtros);
        return response()->json($datos);
    }

    //Datos de las gráficas de la pestaña de pri
    public function ajax_pri(Request $request) {
        $filtros = entrevista_individual::filtros_default($request);
        $filtros->id_subserie = config('expedientes.vi');  //Solo VI
        $datos = entrevista_individual::json_pri($filtros);
        return response()->json($datos);
    }
    //Datos de las gráficas de la pestaña de violencia
    public function ajax_violencia(Request $request) {
        $filtros = entrevista_individual::filtros_default($request);
        $filtros->id_subserie = config('expedientes.vi');  //Solo VI
        $datos = entrevista_individual::json_violencia($filtros);
        return response()->json($datos);
    }
    //Datos de las gráficas de la pestaña de violencia
    public function ajax_exilio(Request $request) {
        $filtros = entrevista_individual::filtros_default($request);
        $filtros->id_subserie = config('expedientes.vi');  //Solo VI
        $datos = entrevista_individual::json_exilio($filtros);
        //dd($datos);
        return response()->json($datos);
    }


    public function pre_stats_diligenciada_vi(Request $request) {
        $destino=action('fichasController@stats');
        return view('pages.pre', compact('destino'));
    }

    public function tesauro_circulos(Request $request) {
        $quitar_entidades = isset($request->quitar_entidades);
        $json_datos = json_encode(etiqueta_entrevista::json_jerarquico($quitar_entidades));
        //return view("reportes.tesauro_circulos",compact("json_datos","quitar_entidades"));
        return view("reportes.tesauro_cuadros",compact("json_datos","quitar_entidades"));
    }
    public function violencia_relaciones(Request $request) {

        $res = entrevista_individual::armar_grafico_relaciones();
        $json_entidades = $res->json_entidades;
        $json_relaciones = $res->json_relaciones;
        return view("reportes.violencia_relaciones",compact("json_entidades","json_relaciones"));
    }

    //Personas entrevistadas
    //Funciona igual que el index, pero en lugar de mostrar la tabla, permite descargar un excel. Usado donde se aplican filtros como en la buscadora
    public function generar_excel_personas_entrevistadas(Request $request)
    {

        if(\Gate::denies('nivel-1')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $filtros = excel_personas_entrevistadas::filtros_default($request);
        //dd($filtros);
        $query = excel_personas_entrevistadas::filtrar($filtros);
        $debug['sql']= nl2br($query->toSql());
        $debug['criterios']=$query->getBindings();
        //dd($debug);
        //$cantidad = $filtros->id_entrevistador == optional(\Auth::user())->id_entrevistador ? 30 : 15;
        $arreglo = $query->ordenar()->pluck('id_excel_personas_entrevistadas')->toArray();
        //dd($arreglo);


        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>23, 'id_accion'=>8]);

        return Excel::download(new personas_entrevistadasExport($arreglo),"personas_entrevistadasa_$fecha.xlsx");
    }
    public function generar_excel_personas_entrevistadas_anonimo(Request $request)
    {



        $filtros = excel_personas_entrevistadas::filtros_default($request);
        //dd($filtros);
        $query = excel_personas_entrevistadas::filtrar($filtros);
        $debug['sql']= nl2br($query->toSql());
        $debug['criterios']=$query->getBindings();
        //dd($debug);
        //$cantidad = $filtros->id_entrevistador == optional(\Auth::user())->id_entrevistador ? 30 : 15;
        $arreglo = $query->ordenar()->pluck('id_excel_personas_entrevistadas')->toArray();
        //dd($arreglo);


        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>23, 'id_accion'=>8]);

        return Excel::download(new personas_entrevistadasExport($arreglo,true),"personas_entrevistadasa_anonimizado_$fecha.xlsx");
    }

    function descargar_uso_tesauro() {
        //$this->authorize('nivel-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>25, 'id_accion'=>8]);
        return Excel::download(new uso_tesauroExport(),"uso_tesauro_$fecha.xlsx");
    }

    function descargar_etiquetado(Request $request) {

        $filtros = entrevista_individual::filtros_default($request);

        $query = etiqueta_entrevista::Id_geo_contenida($filtros->id_tesauro)
            ->otros_filtros($filtros);

        //$debug['sql']= nl2br($query->toSql());
        //$debug['criterios']=$query->getBindings();
        //dd($debug);
        $fecha=date("Y-m-d");
        $arreglo = $query->pluck('id_etiqueta_entrevista')->toArray();

        return Excel::download(new excel_etiquetadoExport($arreglo),"etiquetado_res_$fecha.xlsx");

    }

    function mapa(Request $request) {
        $filtros = entrevista_individual::filtros_default($request);
        $datos = entrevista_individual::conteo_hechos($filtros);
        $filtros->hay_filtro = entrevista_individual::contar_filtros_stats($filtros);

         return view('fichas.mapa_v2',compact('filtros','datos'));
    }


    function test_nvivo($cuales = ['666-vI-00001','017-VI-00002','888-vi-00003','012-vi-00666','005-VI-00003','015-vi-00003','667-pr-12345','015-hv-00019','015-hv-00005'] ) {
        $cuales = ['005-vi-00003'];
        $res =  nvivo_clasificador::generar_qdpx($cuales);
        //$res =  nvivo_clasificador::test_ws_nvivo();

        if($res->exito) {
            //return $res->descarga;
            dd($res);
        }
        else {
            dd($res);
        }

    }

    //Concurrencia de violencia a nivel de victima
    public function concurrencia_victima() {
        $datos = analitica_violencia::concurrencia_victima();
        return view('reportes.concurrencia_victima',compact('datos'));
    }
    //Concurrencia de violencia a nivel de entrevista
    public function concurrencia_entrevista() {
        $datos = analitica_violencia::concurrencia_entrevista();
        return view('reportes.concurrencia_entrevista',compact('datos'));
    }
    //Concurrencia de responsabilidad a nivel de victima
    public function concurrencia_responsabilidad_victima() {
        $datos = analitica_violencia::concurrencia_responsabilidad_victima();
        return view('reportes.concurrencia_responsabilidad_victima',compact('datos'));
    }






}
