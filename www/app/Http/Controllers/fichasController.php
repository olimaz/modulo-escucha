<?php

namespace App\Http\Controllers;

use App\Exports\entrevista_resultadosExport;
use App\Exports\exilioExport;
use App\Exports\ficha_priExport;
use App\Exports\peExport;
use App\Exports\spssExport;
use App\Exports\victima_personaExport;
use App\Exports\victimaExport;
use App\Models\cat_cat;
use App\Models\entrevista_individual;
use App\Models\excel_listados;
use App\Models\excel_spss;
use App\Models\persona_entrevistada;
use App\Models\persona_responsable;
use App\Models\traza_actividad;
use App\Models\victima;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Facades\Excel;

class fichasController extends Controller
{

    //
    public function dash(Request $request) {
        $this->authorize('revisar-m-nivel',[[1,2,6,10]]);
        $txt_titulo = "VI: explorar";
        $filtros = entrevista_individual::filtros_default($request);  //Para el ajax de
        $filtros->id_subserie = config('expedientes.vi');  //Solo VI
        $datos = entrevista_individual::conteos_dash_fichas();

        return view('fichas.dash', compact('filtros','datos','txt_titulo'));
    }
    public function about(Request $request) {
        $txt_titulo = "VI: acerca de ";
        return view('fichas.about',compact('txt_titulo'));
    }
    //Explicacion
    public function stats_comprension(Request $request) {
        $txt_titulo = "Stats: acerca de ";
        return view('pages.stats_comprension',compact('txt_titulo'));
    }

    public function stats(Request $request) {
        $this->authorize('revisar-m-nivel',[[1,2,6,10]]);
        $txt_titulo = "VI: estadisticas";
        $filtros = entrevista_individual::filtros_default($request);


        $filtros->id_subserie = config('expedientes.vi');  //Solo VI
        $datos = entrevista_individual::stats_diligenciada_vi($filtros);


        //dd($filtros->violencia_tipo);
        $filtros->hay_filtro = entrevista_individual::contar_filtros_stats($filtros);

        if($filtros->hay_filtro > 0) {
            //Flash::warning("Mostrando resultados para un total de ".$datos->conteos->entrevistas." entrevistas a víctimas -VI- que coinciden con los filtros indicados y cuyas fichas han sido diligenciadas.");
        }

        //Para la concurrencia por demanda
        $lis_cat = cat_cat::wherein('id_cat', [132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148])
                                    ->orderby('descripcion')
                                    ->pluck('nombre','id_cat');

        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>22, 'codigo'=>'stats-fichas', 'id_primaria'=>null]);

        //dd($datos);
        //return view ('dash_fichas.stats_fichas', compact('datos','filtros','txt_titulo'));
        return view ('fichas.stats', compact('datos','filtros','txt_titulo','lis_cat'));
    }
    //Para el calculo de concurrencia de impactos
    function json_concurrencia_impactos(Request $request) {
        $filtros = entrevista_individual::filtros_default($request);
        $c1 = $request->id_c1;
        $c2 = $request->id_c2;
        $respuesta = entrevista_individual::json_concurrencia_impactos($filtros, $c1, $c2);
        return response()->json($respuesta);
    }
    //Fichas de víctimas
    public function victimas(Request $request) {
        $this->authorize('revisar-m-nivel',[[1,2,6,10]]);
        $txt_titulo = "VI: víctimas";
        $filtros = victima::filtros_default($request);


        $query = victima::seleccionar($filtros->id_tipo_listado)->filtrar($filtros)->ordenar_busqueda($filtros->id_tipo_listado);
        $query2 = clone $query;
        $listado = $query->simplePaginate();
        $total_filas = count($query2->get());
        if($request->debug==100) {
            $debug['sql_base']= nl2br($query->toSql());
            $debug['criterios']=$query->getBindings();
            $debug['sql_final']=entrevista_individual::getQueries($query);
            dd($debug);
        }
        //Advertir sobre uso de listados
        if($filtros->id_excel_listados > 0) {
            $excel = excel_listados::find($filtros->id_excel_listados);
            if($excel) {
                //Flash::warning("Aplicando filtrado general según el listado de códigos '$excel->link'");
            }
        }
        //dd($filtros);
        traza_actividad::create(['id_objeto'=>104, 'id_accion'=>41, 'referencia'=>'explorar fichas: victimas', 'id_primaria'=>null,'codigo'=>'explorar-fichas']);

        return view('fichas.victima', compact('filtros','listado','total_filas','txt_titulo'));

    }





    //Exportar
    public function exportar_victima(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $filtros = victima::filtros_default($request);
        $query = victima::seleccionar($filtros->id_tipo_listado)->filtrar($filtros);
        //$debug['sql']= nl2br($query->toSql());
        //$debug['criterios']=$query->getBindings();
        $a_hecho=array();

        $a_victima = $query->pluck('victima_hecho.id_victima')->toArray();
        //Determinar si es necesario agregar id_hecho como criterio para filtrar
        //Si se utilizó algún filtro por violencia, id_hecho debe utilizarse como criterio de filtrado
        $hay_filtro = victima::hay_filtro_hechos($filtros);

        if($hay_filtro) {
            $a_hecho = $query->pluck('victima_hecho.id_hecho')->toArray();
        }


        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        //dd($arreglo);
        traza_actividad::create(['id_objeto'=>104, 'id_accion'=>8, 'referencia'=>'exportar de explorar fichas: victima','codigo'=>'explorar-fichas']);
        return Excel::download(new victimaExport($a_victima,$a_hecho),"victima_violencia_$fecha.xlsx");
    }
    public function exportar_victima_persona(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $filtros = victima::filtros_default($request);
        $query = victima::seleccionar($filtros->id_tipo_listado)->filtrar($filtros);
        $debug['sql']= nl2br($query->toSql());
        $debug['criterios']=$query->getBindings();

        $arreglo = $query->pluck('victima.id_persona')->toArray();

        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        //dd($arreglo);
        traza_actividad::create(['id_objeto'=>104, 'id_accion'=>8, 'referencia'=>'exportar de explorar fichas: victima','codigo'=>'explorar-fichas']);
        return Excel::download(new victima_personaExport($arreglo),"victima_persona_$fecha.xlsx");
    }

    //Fichas de persona entrevistadas
    public function persona_entrevistada(Request $request) {
        $this->authorize('revisar-m-nivel',[[1,2,6,10]]);
        $txt_titulo = "VI: P. Entrevistada";
        $filtros = persona_entrevistada::filtros_default($request);


        $query = persona_entrevistada::seleccionar($filtros->id_tipo_listado)->filtrar($filtros)->ordenar_busqueda($filtros->id_tipo_listado);
        $query2 = clone $query;
        $listado = $query->simplePaginate();
        $total_filas = count($query2->get());
        if($request->debug==100) {
            $debug['sql_base']= nl2br($query->toSql());
            $debug['criterios']=$query->getBindings();
            $debug['sql_final']=entrevista_individual::getQueries($query);
            dd($debug);
        }

        //Advertir sobre uso de listados
        if($filtros->id_excel_listados > 0) {
            $excel = excel_listados::find($filtros->id_excel_listados);
            if($excel) {
                //Flash::warning("Aplicando filtrado general según el listado de códigos '$excel->link'");
            }
        }

        //dd($filtros);
        traza_actividad::create(['id_objeto'=>103, 'id_accion'=>41, 'referencia'=>'explorar fichas: persona entrevistada', 'id_primaria'=>null,'codigo'=>'explorar-fichas-pe']);

        return view('fichas.pe', compact('filtros','listado','total_filas','txt_titulo'));

    }

    //Exportar persona entrevistada
    public function exportar_persona_entrevistada(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $filtros = persona_entrevistada::filtros_default($request);
        $query = persona_entrevistada::seleccionar($filtros->id_tipo_listado)->filtrar($filtros);


        $arreglo = $query->pluck('persona_entrevistada.id_persona_entrevistada')->toArray();
        //dd($arreglo);

        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        //dd($arreglo);
        traza_actividad::create(['id_objeto'=>103, 'id_accion'=>8, 'referencia'=>'exportar de explorar fichas: persona entrevistada','codigo'=>'explorar-fichas']);
        return Excel::download(new peExport($arreglo),"persona_entrevistada_$fecha.xlsx");
    }


    //Fichas de presunto responsable individual
    public function pri(Request $request) {
        $this->authorize('revisar-m-nivel',[[1,2,6,10]]);
        $txt_titulo = "VI: PRI";
        $filtros = persona_responsable::filtros_default($request);


        $query = persona_responsable::seleccionar($filtros->id_tipo_listado)->filtrar($filtros)->ordenar_busqueda($filtros->id_tipo_listado);
        $query2 = clone $query;
        $listado = $query->simplePaginate();
        $total_filas = count($query2->get());
        if($request->debug==100) {
            $debug['sql_base']= nl2br($query->toSql());
            $debug['criterios']=$query->getBindings();
            $debug['sql_final']=entrevista_individual::getQueries($query);
            dd($debug);
        }
        //dd($filtros);
        traza_actividad::create(['id_objeto'=>102, 'id_accion'=>41, 'referencia'=>'explorar fichas: pri', 'id_primaria'=>null,'codigo'=>'explorar-fichas-pri']);

        return view('fichas.pr', compact('filtros','listado','total_filas','txt_titulo'));

    }
    //Exportar presunto responsable individual
    public function exportar_pri(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $filtros = persona_responsable::filtros_default($request);
        $query = persona_responsable::seleccionar($filtros->id_tipo_listado)->filtrar($filtros)->ordenar_busqueda($filtros->id_tipo_listado);
        $a_pri = $query->pluck('id_persona_responsable')->toArray();

        $fecha=date("Y-m-d");
        //dd($arreglo);
        traza_actividad::create(['id_objeto'=>102, 'id_accion'=>8, 'referencia'=>'exportar de explorar fichas: pri','codigo'=>'explorar-fichas']);
        return Excel::download(new ficha_priExport($a_pri),"presunto_responsable_individual_$fecha.xlsx");
    }



    //Exportar SPSS: versión visualizable
    public function spss_vista() {
        $info =  \App\Models\excel_spss::calcular_datos();
        return view('spss.show', compact('info'));

    }
    //Exportar SPSS: generar excel
    public static function spss_exportar() {
        $inicio = \Carbon\Carbon::now();
        $fecha=date("Y-m-d-H-i");
        $archivo =  "public/$fecha"."_spss_victimas.xlsx";

        $res = Excel::store(new spssExport(), $archivo);
        $fin= \Carbon\Carbon::now();
        $tiempo = $inicio->diffForHumans($fin);
        $respuesta=new \stdClass();
        $respuesta->inicio=$inicio;
        $respuesta->fin=$fin;
        $respuesta->tiempo=$tiempo;
        $respuesta->resultado=$res;
        $respuesta->archivo=$archivo;
        return response()->json($respuesta);
    }

    public static function spss_exportar_csv() {
        $respuesta =  excel_spss::exportar_csv();
        return response()->json($respuesta);
    }


    //En construccion
    public function en_construccion() {
        return view('fichas.construccion');
    }
}
