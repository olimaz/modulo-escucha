<?php

/*
 * Generador de excel de la super sábana para Dario Paez
 */

namespace App\Models;

use App\Http\Controllers\cat_catController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Array_;

class excel_spss extends Model
{
    //
    public static function calcular_datos() {
        $inicio = Carbon::now();
        //Registrar el evento
        Log::notice("ETL de excel-spss: inicio del proceso");

        //Estructuras de control:
        $encabezados = array(); // Todos los encabezados en un solo arreglo, para grabar fila por fila
        $secciones = array();  //Encabezados, dividos por partes
        $mapa = array();  //Usado en cada sección para mapear celdas del excel a las respuestas
        $encabezados_item = array(); //Equivalencia por id_cat de columna a id_item
        $datos = array(); //Para generar el excel, cada fila equivale a una posición

        //Estructura general:
        $secciones[0]='Datos de la Entrevista';
        $secciones[1]='Información de la Víctima';
        $secciones[2]='Detalle de la violencia sufrida';
        $secciones[3]='Contexto de la violencia';
        $secciones[4]='Impactos individuales';
        $secciones[5]='Impactos relacionales';
        $secciones[6]='Resistencia';
        $secciones[7]='Impactos colectivos';
        $secciones[8]='Afrontamientos individuales';
        $secciones[9]='Afrontamientos familiares';
        $secciones[10]='Afrontamientos colectivos';
        //Encabezados.  Texto largo y descriptivo de todas las secciones
        $tmp=self::encabezados();
        $encabezados_item = $tmp->encabezados_item;
        $encabezados = $tmp->encabezados;

        //Procesar información
        $listado = entrevista_individual::id_activo(1)
                                            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','hecho.id_e_ind_fvt')
                                            ->join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
                                            ->join('fichas.hecho_victima','hecho.id_hecho','hecho_victima.id_hecho')
                                            ->join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
                                            ->join('fichas.persona_entrevistada','e_ind_fvt.id_e_ind_fvt','persona_entrevistada.id_e_ind_fvt')
                                            ->orderby('e_ind_fvt.id_e_ind_fvt')
                                            ->orderby('victima.id_victima')
                                            ->orderby('hecho.id_hecho')
                                            ->select('e_ind_fvt.id_e_ind_fvt','hecho.id_hecho','victima.id_victima','victima.id_persona','e_ind_fvt.entrevista_codigo','hecho_victima.id_hecho_victima')
                                            ->distinct()
                                            ->get();
        $num_fila=0;
        foreach($listado as $fila) {
            //Entrevista: sección 0
            $victima = victima::find($fila->id_victima);
            $persona = persona::find($victima->id_persona);
            $entrevistado = persona_entrevistada::where('id_e_ind_fvt',$fila->id_e_ind_fvt)->first();
            $hecho_victima = hecho_victima::find($fila->id_hecho_victima);
            $hecho = hecho::find($fila->id_hecho);
            $seccion=0;
            $datos[$num_fila][$seccion][] = $fila->id_e_ind_fvt;
            $datos[$num_fila][$seccion][] = $fila->id_hecho;
            $datos[$num_fila][$seccion][] = $fila->id_victima;
            $datos[$num_fila][$seccion][] = $fila->id_persona;
            $datos[$num_fila][$seccion][] = $fila->entrevista_codigo;
            $datos[$num_fila][$seccion][] = $entrevistado->es_victima==1 ? 1 : 0;
            $datos[$num_fila][$seccion][] = $entrevistado->es_testigo==1 ? 1 : 0;
            //Victima, sección 1
            $seccion=1;

            $relacion = relacion_victima::where('id_victima',$victima->id_victima)->first();
            if($relacion) {
                $txt = cat_item::describir($relacion->id_rel_victima);
            }
            else {
                $txt = "Sin especificar";
            }
            $datos[$num_fila][$seccion][]=$txt;
            $datos[$num_fila][$seccion][]=cat_item::describir($persona->id_sexo);
            $datos[$num_fila][$seccion][]=cat_item::describir($persona->id_orientacion);
            $datos[$num_fila][$seccion][]=cat_item::describir($persona->id_identidad);
            $datos[$num_fila][$seccion][]=$hecho_victima->edad;
            $datos[$num_fila][$seccion][]=persona::calcular_grupo_etario($hecho_victima->edad);

            $datos[$num_fila][$seccion][]=$persona->fec_nac_a;
            $datos[$num_fila][$seccion][]=$persona->fec_nac_m;
            $datos[$num_fila][$seccion][]=$persona->fec_nac_d;
            //Depto o muni
            $tmp=array("Sin especificar","Sin especificar","Sin especificar");
            if($persona->id_lugar_nacimiento > 0) {
                $tmp = self::geo_niveles($persona->id_lugar_nacimiento);
            }
            elseif($persona->id_lugar_nacimiento_depto > 0) {
                $tmp = self::geo_niveles($persona->id_lugar_nacimiento_depto);
            }


            $datos[$num_fila][$seccion][] = $tmp[0];
            $datos[$num_fila][$seccion][] = $tmp[1];

            $datos[$num_fila][$seccion][]=cat_item::describir($persona->id_etnia);
            $datos[$num_fila][$seccion][]=cat_item::describir($persona->id_etnia_indigena);
            $datos[$num_fila][$seccion][]=cat_item::describir($persona->id_nacionalidad);
            $datos[$num_fila][$seccion][]=cat_item::describir($persona->id_estado_civil);
            $tmp = self::geo_niveles($hecho_victima->id_lugar_residencia);
            $datos[$num_fila][$seccion][]=$tmp[0];
            $datos[$num_fila][$seccion][]=$tmp[1];
            $datos[$num_fila][$seccion][]=$tmp[2];
            $datos[$num_fila][$seccion][]=cat_item::describir($hecho_victima->id_lugar_residencia_tipo);
            $datos[$num_fila][$seccion][]=cat_item::describir($persona->id_edu_formal);
            $datos[$num_fila][$seccion][]=$persona->profesion;
            $datos[$num_fila][$seccion][]=$hecho_victima->ocupacion;
            //Discapacidad
            foreach($encabezados_item[44] as $id_item => $posicion) {
                $datos[$num_fila][$seccion][$posicion]=0;
            }
            $ultima_posicion=$posicion;
            $discapacidad = $persona->rel_discapacidad_fr;
            foreach($discapacidad as $tmp) {
                //dd($tmp);
                $posicion= $encabezados_item[44][$tmp->id_discapacidad];
                $datos[$num_fila][$seccion][$posicion]=1;
            }
            ///
            $ultima_posicion++;//continúo al final de todas las opciones
            $datos[$num_fila][$seccion][$ultima_posicion++] = $persona->cargo_publico==1 ? 1 : 0;
            $datos[$num_fila][$seccion][$ultima_posicion++] = $persona->cargo_publico_cual;
            $datos[$num_fila][$seccion][$ultima_posicion++] = cat_item::describir($persona->id_fuerza_publica);
            $datos[$num_fila][$seccion][$ultima_posicion++] = cat_item::describir($persona->id_fuerza_publica_estado);
            $datos[$num_fila][$seccion][$ultima_posicion++] = $persona->fuerza_publica_especificar;
            $datos[$num_fila][$seccion][$ultima_posicion++] = cat_item::describir($persona->id_actor_armado);
            $datos[$num_fila][$seccion][$ultima_posicion++] = $persona->actor_armado_especificar;

            //////VIOLENCIA: SECCIÓN 2
            $seccion=2;
            $datos[$num_fila][$seccion][0] = $hecho->cantidad_victimas;
            $conteo = hecho_victima::where('id_hecho',$hecho->id_hecho)->count();
            $datos[$num_fila][$seccion][1] = $conteo;
            $masacre = hecho_violencia::join('catalogos.violencia','hecho_violencia.id_subtipo_violencia','violencia.id_geo')
                                        ->where('id_hecho',$hecho->id_hecho)
                                        ->where('violencia.codigo','0502') //Masacre
                                        ->first();
            if($masacre) {
                $datos[$num_fila][$seccion][2] = $masacre->cantidad_muertos;
            }
            else {
                $datos[$num_fila][$seccion][2] = 0;
            }
            $datos[$num_fila][$seccion][3] = $hecho->fecha_ocurrencia_a;
            $datos[$num_fila][$seccion][4] = $hecho->fecha_ocurrencia_m;
            $datos[$num_fila][$seccion][5] = $hecho->fecha_ocurrencia_d;
            $datos[$num_fila][$seccion][6] = $hecho->fecha_fin_a;
            $datos[$num_fila][$seccion][7] = $hecho->fecha_fin_m;
            $datos[$num_fila][$seccion][8] = $hecho->fecha_fin_d;
            $datos[$num_fila][$seccion][9] = $hecho->aun_continuan==1 ? 1 : 0;
            $tmp =self::geo_niveles($hecho->id_lugar);
            $datos[$num_fila][$seccion][10] = $tmp[0];
            $datos[$num_fila][$seccion][11] = $tmp[1];
            $datos[$num_fila][$seccion][12] = $tmp[2];
            $datos[$num_fila][$seccion][13] = cat_item::describir($hecho->id_lugar_tipo);
            $datos[$num_fila][$seccion][14] = $hecho->sitio_especifico;
            //Tipos de violencia: inicializar
            foreach($encabezados_item['violencia'] as $columna) {
                $datos[$num_fila][$seccion][$columna]=0;
            }
            $lis_violencia = hecho_violencia::join('catalogos.violencia','hecho_violencia.id_subtipo_violencia','violencia.id_geo')
                                            ->where('id_hecho',$hecho->id_hecho)
                                            ->get();
            foreach($lis_violencia as $fila_violencia) {
                $posicion_subtipo= $encabezados_item['violencia'][$fila_violencia->codigo];
                $posicion_tipo = $encabezados_item['violencia'][substr($fila_violencia->codigo,0,2)];
                $datos[$num_fila][$seccion][$posicion_tipo] = 1;
                $datos[$num_fila][$seccion][$posicion_subtipo] = 1;
            }
            ///Agravantes: inicializar
            for ($i = 100; $i <= 126; $i++) {
                $datos[$num_fila][$seccion][$i]=-99;
            }
            foreach($lis_violencia as $fila_violencia) {
                //Amenaza
                if(substr($fila_violencia->codigo,0,2)=="07") {
                    $datos[$num_fila][$seccion][100] = cat_item::describir($fila_violencia->id_individual_colectiva);
                }
                //Tortura
                if(substr($fila_violencia->codigo,0,2)=="09") {
                    $datos[$num_fila][$seccion][101] = cat_item::describir($fila_violencia->id_individual_colectiva);
                    $datos[$num_fila][$seccion][102] = $fila_violencia->id_frente_otros == 1 ? 1 : 0;
                }
                //Violencia sexual
                if(substr($fila_violencia->codigo,0,2)=="10") {
                    $datos[$num_fila][$seccion][103] = cat_item::describir($fila_violencia->id_individual_colectiva);
                    $datos[$num_fila][$seccion][104] = $fila_violencia->id_frente_otros == 1 ? 1 : 0;
                    $datos[$num_fila][$seccion][105] = $fila_violencia->id_cometido_varios == 1 ? 1 : 0;
                    $datos[$num_fila][$seccion][106] = $fila_violencia->id_hubo_embarazo == 1 ? 1 : 0;
                    $datos[$num_fila][$seccion][107] = $fila_violencia->id_hubo_nacimiento == 1 ? 1 : 0;
                }
                //Esclavitud no sexual
                if(substr($fila_violencia->codigo,0,2)=="11") {
                    $datos[$num_fila][$seccion][108] = cat_item::describir($fila_violencia->id_individual_colectiva);
                    $datos[$num_fila][$seccion][109] = $fila_violencia->id_frente_otros == 1 ? 1 : 0;
                }
                //Reclutamiento NNA
                if(substr($fila_violencia->codigo,0,2)=="12") {
                    $datos[$num_fila][$seccion][110] = cat_item::describir($fila_violencia->id_individual_colectiva);
                    $datos[$num_fila][$seccion][111] = $fila_violencia->id_frente_otros == 1 ? 1 : 0;
                }
                //Detencion irregular
                if(substr($fila_violencia->codigo,0,2)=="13") {
                    $datos[$num_fila][$seccion][112] = cat_item::describir($fila_violencia->id_ind_fam_col);
                }
                //Secuestro
                if(substr($fila_violencia->codigo,0,2)=="14") {
                    $datos[$num_fila][$seccion][113] = cat_item::describir($fila_violencia->id_ind_fam_col);
                    $datos[$num_fila][$seccion][114] = $fila_violencia->id_frente_otros == 1 ? 1 : 0;
                }
                //Confinamiento
                if(substr($fila_violencia->codigo,0,2)=="15") {
                    $datos[$num_fila][$seccion][115] = cat_item::describir($fila_violencia->id_ind_fam_col);
                }
                //Despojo
                if(substr($fila_violencia->codigo,0,2)=="20") {
                    $datos[$num_fila][$seccion][116] = cat_item::describir($fila_violencia->id_ind_fam_col);
                }
                //Desplazamiento
                if(substr($fila_violencia->codigo,0,2)=="21") {
                    $datos[$num_fila][$seccion][117] = cat_item::describir($fila_violencia->id_ind_fam_col);
                    $tmp = self::geo_niveles($fila_violencia->id_lugar_salida);
                    $datos[$num_fila][$seccion][118] = $tmp[0];
                    $datos[$num_fila][$seccion][119] = $tmp[1];
                    $datos[$num_fila][$seccion][120] = $tmp[2];
                    $tmp = self::geo_niveles($fila_violencia->id_lugar_llegada);
                    $datos[$num_fila][$seccion][121] = $tmp[0];
                    $datos[$num_fila][$seccion][122] = $tmp[1];
                    $datos[$num_fila][$seccion][123] = $tmp[2];
                    $datos[$num_fila][$seccion][124] = cat_item::describir($fila_violencia->id_sentido_desplazamiento);
                    $datos[$num_fila][$seccion][125] = $fila_violencia->id_tuvo_retorno ==1 ? 1 : 0;
                    $datos[$num_fila][$seccion][126] = cat_item::describir($fila_violencia->id_ind_fam_col);
                }
            }
            //Responsabilidad colectiva: inicializar
            foreach($encabezados_item['aa'] as $cod => $pos) {
                $datos[$num_fila][$seccion][$pos] = 0;
            }
            foreach($encabezados_item['tc'] as $cod => $pos) {
                $datos[$num_fila][$seccion][$pos] = 0;
            }
            for ($i = 300; $i <= 307; $i++) {
                $datos[$num_fila][$seccion][$i]="NA";
            }

            $lis_responsabilidad = hecho_responsabilidad::where('id_hecho',$hecho->id_hecho)->get();
            foreach($lis_responsabilidad as $fila_responsabilidad) {
                if($fila_responsabilidad->aa_id_tipo > 0) {
                    $res = tipo_aa::find($fila_responsabilidad->aa_id_subtipo);
                    $posicion_subtipo= $encabezados_item['aa'][$res->codigo];
                    $posicion_tipo = $encabezados_item['aa'][substr($res->codigo,0,2)];
                    $datos[$num_fila][$seccion][$posicion_tipo] = 1;
                    $datos[$num_fila][$seccion][$posicion_subtipo] = 1;
                    //Detalle
                    $datos[$num_fila][$seccion][300] = $fila_responsabilidad->aa_nombre_grupo;
                    $datos[$num_fila][$seccion][301] = $fila_responsabilidad->aa_bloque;
                    $datos[$num_fila][$seccion][302] = $fila_responsabilidad->aa_frente;
                    $datos[$num_fila][$seccion][303] = $fila_responsabilidad->aa_unidad;
                    $datos[$num_fila][$seccion][304] = $fila_responsabilidad->aa_otro_cual;

                }
                elseif($fila_responsabilidad->tc_id_tipo > 0) {
                    $res = tipo_tc::find($fila_responsabilidad->tc_id_subtipo);
                    $posicion_subtipo= $encabezados_item['tc'][$res->codigo];
                    $posicion_tipo = $encabezados_item['tc'][substr($res->codigo,0,2)];
                    $datos[$num_fila][$seccion][$posicion_tipo] = 1;
                    $datos[$num_fila][$seccion][$posicion_subtipo] = 1;
                    $datos[$num_fila][$seccion][305] = $fila_responsabilidad->tc_detalle;
                    $datos[$num_fila][$seccion][306] = $fila_responsabilidad->tc_otro_cual;
                }
                if($fila_responsabilidad->otro_actor_cual) {
                    $datos[$num_fila][$seccion][307] = $fila_responsabilidad->otro_actor_cual;
                }
            }


            //////CONTEXTO: SECCIÓN 3
            $seccion=3;
            $catalogos = [127,128,129,130,131];
            //inicializar
            foreach($catalogos as $opcion) {
                foreach($encabezados_item[$opcion] as $id_item=>$columna) {
                    $datos[$num_fila][$seccion][$columna]=0;
                }
            }
            //procesar
            $listado = hecho_contexto::join('catalogos.cat_item','hecho_contexto.id_contexto','cat_item.id_item')
                                    ->where('id_hecho',$hecho->id_hecho)
                                    ->wherein('cat_item.id_cat',$catalogos)
                                    ->where('cat_item.habilitado',1)
                                    ->get();
            foreach($listado as $opcion) {
                $posicion= $encabezados_item[$opcion->id_cat][$opcion->id_item];
                $datos[$num_fila][$seccion][$posicion]=1;
            }

            ////  IMPACTOS INDIVIDUALES, SECCION 4
            $seccion=4;
            $catalogos = [132,133,134];
            //inicializar
            foreach($catalogos as $opcion) {
                foreach($encabezados_item[$opcion] as $id_item=>$columna) {
                    $datos[$num_fila][$seccion][$columna]=0;
                }
            }
            //procesar
            $listado = entrevista_impacto::join('catalogos.cat_item','entrevista_impacto.id_impacto','cat_item.id_item')
                ->where('id_e_ind_fvt',$fila->id_e_ind_fvt)
                ->where('cat_item.habilitado',1)
                ->wherein('cat_item.id_cat',$catalogos)
                ->get();
            foreach($listado as $opcion) {
                $posicion= $encabezados_item[$opcion->id_cat][$opcion->id_item];
                $datos[$num_fila][$seccion][$posicion]=1;
            }

            ////  IMPACTOS RELACIONES, SECCION 5
            $seccion=5;
            $catalogos = [135,136];
            //inicializar
            foreach($catalogos as $opcion) {
                foreach($encabezados_item[$opcion] as $id_item=>$columna) {
                    $datos[$num_fila][$seccion][$columna]=0;
                }
            }
            //procesar
            $listado = entrevista_impacto::join('catalogos.cat_item','entrevista_impacto.id_impacto','cat_item.id_item')
                ->where('id_e_ind_fvt',$fila->id_e_ind_fvt)
                ->where('cat_item.habilitado',1)
                ->wherein('cat_item.id_cat',$catalogos)
                ->get();
            foreach($listado as $opcion) {
                $posicion= $encabezados_item[$opcion->id_cat][$opcion->id_item];
                $datos[$num_fila][$seccion][$posicion]=1;
            }

            ////  REVICTIMIZACION, SECCION 6
            $seccion=6;
            $catalogos = [137];
            //inicializar
            foreach($catalogos as $opcion) {
                foreach($encabezados_item[$opcion] as $id_item=>$columna) {
                    $datos[$num_fila][$seccion][$columna]=0;
                }
            }
            //procesar
            $listado = entrevista_impacto::join('catalogos.cat_item','entrevista_impacto.id_impacto','cat_item.id_item')
                ->where('id_e_ind_fvt',$fila->id_e_ind_fvt)
                ->where('cat_item.habilitado',1)
                ->wherein('cat_item.id_cat',$catalogos)
                ->get();
            foreach($listado as $opcion) {
                $posicion= $encabezados_item[$opcion->id_cat][$opcion->id_item];
                $datos[$num_fila][$seccion][$posicion]=1;
            }

            ////  IMPACTOS COLECTIVOS, SECCION 7
            $seccion=7;
            $catalogos = [138,139,140,141,142,143];
            //inicializar
            foreach($catalogos as $opcion) {
                foreach($encabezados_item[$opcion] as $id_item=>$columna) {
                    $datos[$num_fila][$seccion][$columna]=0;
                }
            }
            //procesar
            $listado = entrevista_impacto::join('catalogos.cat_item','entrevista_impacto.id_impacto','cat_item.id_item')
                ->where('id_e_ind_fvt',$fila->id_e_ind_fvt)
                ->where('cat_item.habilitado',1)
                ->wherein('cat_item.id_cat',$catalogos)
                ->get();
            foreach($listado as $opcion) {
                $posicion= $encabezados_item[$opcion->id_cat][$opcion->id_item];
                $datos[$num_fila][$seccion][$posicion]=1;
            }

            ////  AFRONTAMIENTOS INDIVIDAUALES, SECCION 8
            $seccion=8;
            $catalogos = [144];
            //inicializar
            foreach($catalogos as $opcion) {
                foreach($encabezados_item[$opcion] as $id_item=>$columna) {
                    $datos[$num_fila][$seccion][$columna]=0;
                }
            }
            //procesar
            $listado = entrevista_impacto::join('catalogos.cat_item','entrevista_impacto.id_impacto','cat_item.id_item')
                ->where('id_e_ind_fvt',$fila->id_e_ind_fvt)
                ->where('cat_item.habilitado',1)
                ->wherein('cat_item.id_cat',$catalogos)
                ->get();
            foreach($listado as $opcion) {
                $posicion= $encabezados_item[$opcion->id_cat][$opcion->id_item];
                $datos[$num_fila][$seccion][$posicion]=1;
            }

            ////  AFRONTAMIENTOS FAMILIARES, SECCION 9
            $seccion=9;
            $catalogos = [145];
            //inicializar
            foreach($catalogos as $opcion) {
                foreach($encabezados_item[$opcion] as $id_item=>$columna) {
                    $datos[$num_fila][$seccion][$columna]=0;
                }
            }
            //procesar
            $listado = entrevista_impacto::join('catalogos.cat_item','entrevista_impacto.id_impacto','cat_item.id_item')
                ->where('id_e_ind_fvt',$fila->id_e_ind_fvt)
                ->where('cat_item.habilitado',1)
                ->wherein('cat_item.id_cat',$catalogos)
                ->get();
            foreach($listado as $opcion) {
                $posicion= $encabezados_item[$opcion->id_cat][$opcion->id_item];
                $datos[$num_fila][$seccion][$posicion]=1;
            }


            ////  AFRONTAMIENTOS COLECTIVOS, SECCION 10
            $seccion=10;
            $catalogos = [146,147,148];
            //inicializar
            foreach($catalogos as $opcion) {
                foreach($encabezados_item[$opcion] as $id_item=>$columna) {
                    $datos[$num_fila][$seccion][$columna]=0;
                }
            }
            //procesar
            $listado = entrevista_impacto::join('catalogos.cat_item','entrevista_impacto.id_impacto','cat_item.id_item')
                ->where('id_e_ind_fvt',$fila->id_e_ind_fvt)
                ->where('cat_item.habilitado',1)
                ->wherein('cat_item.id_cat',$catalogos)
                ->get();
            foreach($listado as $opcion) {
                $posicion= $encabezados_item[$opcion->id_cat][$opcion->id_item];
                $datos[$num_fila][$seccion][$posicion]=1;
            }












                //Nueva fila en el excel
            $num_fila++;


        }


        //Preparar respuesta
        $fin = Carbon::now();
        $res = new \stdClass();
        $res->inicio = $inicio;
        $res->fin = $fin;
        $res->duracion = $fin->diffForHumans($inicio);
        $res->encabezados = $encabezados;
        $res->secciones = $secciones;
        $res->mapa = $mapa;
        $res->encabezados_item = $encabezados_item;
        $res->datos = $datos;

        Log::info("ETL de excel-spss:  fin del proceso, $num_fila filas generadas. Tiempo: $res->duracion.");

        return $res;
    }
    //Recibe un id_geo y devuelve un arreglo de tres posiciones para c/nivel
    public static function geo_niveles($id_geo=0) {
        $res[0]="Sin especificar";
        $res[1]=$res[0];
        $res[2]=$res[0];
        $geo = geo::find($id_geo);
        if($geo) {
            if($geo->nivel==3) {
                $res[2]=$geo->descripcion;
                $padre=$geo::find($geo->id_padre);
                if($padre) {
                    $res[1] = $padre->descripcion;
                    $padre=$geo::find($padre->id_padre);
                    if($padre) {
                        $res[0]=$padre->descripcion;
                    }
                }
            }
            elseif($geo->nivel==2) {
                $res[1]=$geo->descripcion;
                $padre=$geo::find($geo->id_padre);
                if($padre) {
                    $res[0] = $padre->descripcion;
                }
            }
            else {
                $res[0]=$geo->descripcion;
            }
        }
        return $res;
    }

    //Para separar el código en pedazos
    public static function encabezados() {
        $encabezados=array();
        $encabezados_item = array();
        //Sección 0: entrevista
        $encabezados[0][0]="id_entrevista";
        $encabezados[0][1]="id_hecho";
        $encabezados[0][2]="id_victima";
        $encabezados[0][3]="id_persona";
        $encabezados[0][4]="codigo entrevista";
        $encabezados[0][5]="entrevistado es victima";
        $encabezados[0][6]="entrevistado es testigo";
        //Seccion 1: Victima
        $seccion=1;
        $encabezados[$seccion][0]="Relacion entrevistado";
        $encabezados[$seccion][1]="Sexo";
        $encabezados[$seccion][2]="Orientacion sexual";
        $encabezados[$seccion][3]="Identidad de género";
        $encabezados[$seccion][4]="Edad";
        $encabezados[$seccion][5]="Grupo etario";
        $encabezados[$seccion][6]="Fecha de nacimimiento - año";
        $encabezados[$seccion][7]="Fecha de nacimimiento - mes";
        $encabezados[$seccion][8]="Fecha de nacimimiento - dia";
        $encabezados[$seccion][9]="Lugar de nacimiento - Departamento";
        $encabezados[$seccion][10]="Lugar de nacimiento - Municipio";
        $encabezados[$seccion][11]="Pertenencia etnica";
        $encabezados[$seccion][12]="Pertenencia indigena";
        $encabezados[$seccion][13]="Nacionalidad";
        $encabezados[$seccion][14]="Estado civil";
        $encabezados[$seccion][15]="Lugar de residencia - Departamento";
        $encabezados[$seccion][16]="Lugar de residencia - Municipio";
        $encabezados[$seccion][17]="Lugar de residencia - Lugar poblado";
        $encabezados[$seccion][18]="Lugar de residencia - Zona";
        $encabezados[$seccion][19]="Educación formal";
        $encabezados[$seccion][20]="Profesión";
        $encabezados[$seccion][21]="Ocupación actual";
        //Discapacidades:
        $opciones = cat_item::where('id_cat',44)->where('habilitado',1)->orderby('descripcion')->get();
        $nombre_catalogo =cat_cat::describir(44);
        $i=21; //Posición que toca
        foreach($opciones as $tmp) {
            $encabezados[$seccion][$i]="[$nombre_catalogo] ".$tmp->descripcion;
            $encabezados_item[44][$tmp->id_item]=$i; //el id_item a qué posición corresponde
            $i++;
        }
        $encabezados[$seccion][$i++]="Ejerce autoridad o cargo público";
        $encabezados[$seccion][$i++]="Ejerce autoridad o cargo público, ¿cual?";
        $encabezados[$seccion][$i++]="Miembro de la fuerza pública";
        $encabezados[$seccion][$i++]="Miembro de la fuerza pública - estado";
        $encabezados[$seccion][$i++]="Miembro de la fuerza pública - especificar";
        $encabezados[$seccion][$i++]="Miembro de un actor armado ilegal";
        $encabezados[$seccion][$i++]="Miembro de un actor armado ilegal - especificar";
        //Seccion 2: Violencia
        $seccion=2;
        $encabezados[$seccion][0]="Cantidad total de víctimas del hecho";
        $encabezados[$seccion][1]="Cantitdad total de víctimas identificadas";
        $encabezados[$seccion][2]="Masacre: Cantidad de muertos de muertos";
        $encabezados[$seccion][3]="Fecha de inicio - año";
        $encabezados[$seccion][4]="Fecha de inicio - mes";
        $encabezados[$seccion][5]="Fecha de inicio - día";
        $encabezados[$seccion][6]="Fecha de finalización - año";
        $encabezados[$seccion][7]="Fecha de finalización - mes";
        $encabezados[$seccion][8]="Fecha de finalización - día";
        $encabezados[$seccion][9]="Los hechos aún continúan";
        $encabezados[$seccion][10]="Lugar de la violencia - Departamento";
        $encabezados[$seccion][11]="Lugar de la violencia - Municipio";
        $encabezados[$seccion][12]="Lugar de la violencia - Lugar poblado";
        $encabezados[$seccion][13]="Lugar de la violencia - tipo de zona";
        $encabezados[$seccion][14]="Lugar de la violencia - ubicacación específica";
        //Tipos de violencia
        $sql = "select tipo.id_geo as id_tipo, subtipo.id_geo as id_subtipo, tipo.descripcion as tipo_viol, subtipo.descripcion as subtipo_viol, tipo.codigo as tipo_codigo, subtipo.codigo as subtipo_codigo
                        from catalogos.violencia as tipo
                             join catalogos.violencia as subtipo on subtipo.id_padre=tipo.id_geo
                        order by tipo.codigo, subtipo.codigo";
        $tipos_viol = \DB::select($sql);
        $i=20; //Posición actual
        $id_tipo=0;
        $ultima_posicion=$i;
        foreach($tipos_viol as $fila_violencia) {
            if($fila_violencia->id_tipo <> $id_tipo) {
                $encabezados[$seccion][$i]="Tipo: $fila_violencia->tipo_viol";
                //Mapeo
                $encabezados_item['violencia'][$fila_violencia->tipo_codigo]=$i;
                $id_tipo=$fila_violencia->id_tipo;
                $i++;
            }
            $encabezados[$seccion][$i]="Subtipo: $fila_violencia->subtipo_viol";
            $encabezados_item['violencia'][$fila_violencia->subtipo_codigo]=$i;
            $i++;
            $ultima_posicion=$i;
        }
        /// agravantes
        $encabezados[$seccion][100] = "Amenaza ejercida de forma";
        $encabezados[$seccion][101] = "Tortura ejercida de forma";
        $encabezados[$seccion][102] = "Tortura ejercida frente a terceros";
        $encabezados[$seccion][103] = "Violencia Sexual ejercida de forma";
        $encabezados[$seccion][104] = "Violencia Sexual ejercida frente a terceros";
        $encabezados[$seccion][105] = "Violencia Sexual ¿Los hechos fueron cometidos por varias personas?";
        $encabezados[$seccion][106] = "Violencia Sexual ¿Hubo embarazo como consecuencia de la violación sexual?";
        $encabezados[$seccion][107] = "Violencia Sexual Si hubo embarazo, ¿nació el bebé?";
        $encabezados[$seccion][108] = "ESCLAVITUD/TRABAJO FORZOSO SIN FINES SEXUALES, ejercida de forma";
        $encabezados[$seccion][109] = "ESCLAVITUD/TRABAJO FORZOSO SIN FINES SEXUALES, ejercida frente a terceros";
        $encabezados[$seccion][110] = "RECLUTAMIENTO DE NIÑOS, NIÑAS Y ADOLESCENTES, ejercida de forma";
        $encabezados[$seccion][111] = "RECLUTAMIENTO DE NIÑOS, NIÑAS Y ADOLESCENTES, ejercida frente a terceros";
        $encabezados[$seccion][112] = "DETENCIÓN ARBITRARIA, ejercida de forma";
        $encabezados[$seccion][113] = "SECUESTRO / TOMA DE REHENES, ejercida de forma";
        $encabezados[$seccion][114] = "SECUESTRO / TOMA DE REHENES, ejercida frente a terceros";
        $encabezados[$seccion][115] = "CONFINAMIENTO, ejercida de forma";
        $encabezados[$seccion][116] = "DESPOJO / ABANDONO DE TIERRAS, ejercida de forma";
        $encabezados[$seccion][117] = "DESPLAZAMIENTO FORZADO, ejercido de forma";
        $encabezados[$seccion][118] = "DESPLAZAMIENTO FORZADO, origen - departamento";
        $encabezados[$seccion][119] = "DESPLAZAMIENTO FORZADO, origen - municipio";
        $encabezados[$seccion][120] = "DESPLAZAMIENTO FORZADO, origen - centro problado";
        $encabezados[$seccion][121] = "DESPLAZAMIENTO FORZADO, destino - departamento";
        $encabezados[$seccion][122] = "DESPLAZAMIENTO FORZADO, destino - municipio";
        $encabezados[$seccion][123] = "DESPLAZAMIENTO FORZADO, destino - centro problado";
        $encabezados[$seccion][124] = "DESPLAZAMIENTO FORZADO, sentido del desplazamiento";
        $encabezados[$seccion][125] = "DESPLAZAMIENTO FORZADO, ¿LA PERSONA HA TENIDO UN PROCESO DE RETORNO?";
        $encabezados[$seccion][126] = "DESPLAZAMIENTO FORZADO, Modalidad del retorno";
        ////
        //Responsabilidad: AA
        $sql = "select tipo.id_geo as id_tipo, subtipo.id_geo as id_subtipo, tipo.descripcion as tipo_viol, subtipo.descripcion as subtipo_viol, tipo.codigo as tipo_codigo, subtipo.codigo as subtipo_codigo
                        from catalogos.aa as tipo
                             join catalogos.aa as subtipo on subtipo.id_padre=tipo.id_geo
                        order by tipo.codigo, subtipo.codigo";
        $tipos_viol = \DB::select($sql);
        $i=150; //Posición actual
        $id_tipo=0;
        $ultima_posicion=$i;
        foreach($tipos_viol as $fila_violencia) {
            if($fila_violencia->id_tipo <> $id_tipo) {
                $encabezados[$seccion][$i]="Responsabilidad, Actor Armado, Tipo: $fila_violencia->tipo_viol";
                //Mapeo
                $encabezados_item['aa'][$fila_violencia->tipo_codigo]=$i;
                $id_tipo=$fila_violencia->id_tipo;
                $i++;
            }
            $encabezados[$seccion][$i]="Responsabilidad, Actor Armado, Subtipo: $fila_violencia->subtipo_viol";
            $encabezados_item['aa'][$fila_violencia->subtipo_codigo]=$i;
            $i++;
            $ultima_posicion=$i;
        }

        //Responsabilidad: TC
        $sql = "select tipo.id_geo as id_tipo, subtipo.id_geo as id_subtipo, tipo.descripcion as tipo_viol, subtipo.descripcion as subtipo_viol, tipo.codigo as tipo_codigo, subtipo.codigo as subtipo_codigo
                        from catalogos.tc as tipo
                             join catalogos.tc as subtipo on subtipo.id_padre=tipo.id_geo
                        order by tipo.codigo, subtipo.codigo";
        $tipos_viol = \DB::select($sql);
        $i=200; //Posición actual
        $id_tipo=0;
        $ultima_posicion=$i;
        foreach($tipos_viol as $fila_violencia) {
            if($fila_violencia->id_tipo <> $id_tipo) {
                $encabezados[$seccion][$i]="Responsabilidad, Tercero Civil, Tipo: $fila_violencia->tipo_viol";
                //Mapeo
                $encabezados_item['tc'][$fila_violencia->tipo_codigo]=$i;
                $id_tipo=$fila_violencia->id_tipo;
                $i++;
            }
            $encabezados[$seccion][$i]="Responsabilidad, Tercero Civil, Subtipo: $fila_violencia->subtipo_viol";
            $encabezados_item['tc'][$fila_violencia->subtipo_codigo]=$i;
            $i++;
            $ultima_posicion=$i;
        }
        //Detalles de la responsabilidad
        $encabezados[$seccion][300] = "Actor Armado: Nombre del grupo";
        $encabezados[$seccion][301] = "Actor Armado: Bloque";
        $encabezados[$seccion][302] = "Actor Armado: Frente";
        $encabezados[$seccion][303] = "Actor Armado: Unidad";
        $encabezados[$seccion][304] = "Actor Armado: otro, ¿cuál?";
        $encabezados[$seccion][305] = "Tercero Civil: Especificar";
        $encabezados[$seccion][306] = "Tercero Civil: otro, ¿cuál?";
        $encabezados[$seccion][307] = "Otro actor: ¿cuál?";


        //Seccion 3: Contexto
        $seccion=3;
        $catalogos=[127,128,129,130,131];
        $opciones = cat_item::join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
                                ->where('habilitado',1)
                                ->wherein('cat_item.id_cat',$catalogos)
                                ->orderby('cat_item.id_cat')
                                ->orderby('cat_item.orden')
                                ->orderby('cat_item.descripcion')
                                ->select('cat_cat.nombre as catalogo','cat_item.descripcion as opcion','cat_cat.id_cat','cat_item.id_item')
                                ->get();
        $i=0;
        foreach($opciones as $item) {
            $encabezados_item[$item->id_cat][$item->id_item]=$i;
            $encabezados[$seccion][$i]="[$item->catalogo] - $item->opcion";
            $i++;
        }

        //Seccion 4: Impactos individuales
        $seccion=4;
        $catalogos=[132,133,134];
        $opciones = cat_item::join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('habilitado',1)
            ->wherein('cat_item.id_cat',$catalogos)
            ->orderby('cat_item.id_cat')
            ->orderby('cat_item.orden')
            ->orderby('cat_item.descripcion')
            ->select('cat_cat.nombre as catalogo','cat_item.descripcion as opcion','cat_cat.id_cat','cat_item.id_item')
            ->get();
        $i=0;
        foreach($opciones as $item) {
            $encabezados_item[$item->id_cat][$item->id_item]=$i;
            $encabezados[$seccion][$i]="[$item->catalogo] - $item->opcion";
            $i++;
        }

        //Seccion 5: Impactos relacionales
        $seccion=5;
        $catalogos=[135,136];
        $opciones = cat_item::join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('habilitado',1)
            ->wherein('cat_item.id_cat',$catalogos)
            ->orderby('cat_item.id_cat')
            ->orderby('cat_item.orden')
            ->orderby('cat_item.descripcion')
            ->select('cat_cat.nombre as catalogo','cat_item.descripcion as opcion','cat_cat.id_cat','cat_item.id_item')
            ->get();
        $i=0;
        foreach($opciones as $item) {
            $encabezados_item[$item->id_cat][$item->id_item]=$i;
            $encabezados[$seccion][$i]="[$item->catalogo] - $item->opcion";
            $i++;
        }

        //Seccion 6: Revictimización
        $seccion=6;
        $catalogos=[137];
        $opciones = cat_item::join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('habilitado',1)
            ->wherein('cat_item.id_cat',$catalogos)
            ->orderby('cat_item.id_cat')
            ->orderby('cat_item.orden')
            ->orderby('cat_item.descripcion')
            ->select('cat_cat.nombre as catalogo','cat_item.descripcion as opcion','cat_cat.id_cat','cat_item.id_item')
            ->get();
        $i=0;
        foreach($opciones as $item) {
            $encabezados_item[$item->id_cat][$item->id_item]=$i;
            $encabezados[$seccion][$i]="[$item->catalogo] - $item->opcion";
            $i++;
        }

        //Seccion 7: Impactos colectivos
        $seccion=7;
        $catalogos=[138,139,140,141,142,143];
        $opciones = cat_item::join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('habilitado',1)
            ->wherein('cat_item.id_cat',$catalogos)
            ->orderby('cat_item.id_cat')
            ->orderby('cat_item.orden')
            ->orderby('cat_item.descripcion')
            ->select('cat_cat.nombre as catalogo','cat_item.descripcion as opcion','cat_cat.id_cat','cat_item.id_item')
            ->get();
        $i=0;
        foreach($opciones as $item) {
            $encabezados_item[$item->id_cat][$item->id_item]=$i;
            $encabezados[$seccion][$i]="[$item->catalogo] - $item->opcion";
            $i++;
        }

        //Seccion 8: Afrontamientos individuales
        $seccion=8;
        $catalogos=[144];
        $opciones = cat_item::join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('habilitado',1)
            ->wherein('cat_item.id_cat',$catalogos)
            ->orderby('cat_item.id_cat')
            ->orderby('cat_item.orden')
            ->orderby('cat_item.descripcion')
            ->select('cat_cat.nombre as catalogo','cat_item.descripcion as opcion','cat_cat.id_cat','cat_item.id_item')
            ->get();
        $i=0;
        foreach($opciones as $item) {
            $encabezados_item[$item->id_cat][$item->id_item]=$i;
            $encabezados[$seccion][$i]="[$item->catalogo] - $item->opcion";
            $i++;
        }

        //Seccion 9: Afrontamientos familiares
        $seccion=9;
        $catalogos=[145];
        $opciones = cat_item::join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('habilitado',1)
            ->wherein('cat_item.id_cat',$catalogos)
            ->orderby('cat_item.id_cat')
            ->orderby('cat_item.orden')
            ->orderby('cat_item.descripcion')
            ->select('cat_cat.nombre as catalogo','cat_item.descripcion as opcion','cat_cat.id_cat','cat_item.id_item')
            ->get();
        $i=0;
        foreach($opciones as $item) {
            $encabezados_item[$item->id_cat][$item->id_item]=$i;
            $encabezados[$seccion][$i]="[$item->catalogo] - $item->opcion";
            $i++;
        }

        //Seccion 10: Afrontamientos colectivos
        $seccion=10;
        $catalogos=[146,147,148];
        $opciones = cat_item::join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('habilitado',1)
            ->wherein('cat_item.id_cat',$catalogos)
            ->orderby('cat_item.id_cat')
            ->orderby('cat_item.orden')
            ->orderby('cat_item.descripcion')
            ->select('cat_cat.nombre as catalogo','cat_item.descripcion as opcion','cat_cat.id_cat','cat_item.id_item')
            ->get();
        $i=0;
        foreach($opciones as $item) {
            $encabezados_item[$item->id_cat][$item->id_item]=$i;
            $encabezados[$seccion][$i]="[$item->catalogo] - $item->opcion";
            $i++;
        }











        $res= new \stdClass();
        $res->encabezados = $encabezados;
        $res->encabezados_item = $encabezados_item;

        return $res;

    }

    public static function exportar_csv() {
        $info = self::calcular_datos();
        $inicio = Carbon::now();
        //Secciones
        $fila[0] = array();
        foreach($info->encabezados as $id_seccion => $detalle_seccion) {
            $fila[0][]=$info->secciones[$id_seccion];
            $blancos = count($detalle_seccion) - 1;
            for($i=1;$i<=$blancos; $i++) {
                $fila[0][]=null;
            }
        }
        //Encabezados
        $fila[1] = array();
        foreach($info->encabezados as $id_seccion => $detalle_seccion) {
            foreach($detalle_seccion as $txt) {
                $fila[1][]=$txt;
            }
        }

        //Generar CSV
        $fecha=date("Y-m-d-H-i");
        $nombre = $fecha."_spss_victimas.csv";
        $ubicacion = storage_path()."/app/public/$nombre";

        $file = fopen($ubicacion, 'w');
        fputcsv($file, $fila[0]);
        fputcsv($file, $fila[1]);


        foreach($info->datos as $seccion) {
            $tmp = array();
            foreach($seccion as $id_seccion => $columnas) {
                foreach($columnas as $txt) {
                    $tmp[] = $txt;
                }
            }
            //dd($tmp);
            fputcsv($file, $tmp);
        }

        fclose($file);

        $fin = Carbon::now();

        $info->archivo = new \stdClass();
        $info->archivo->inicio = $inicio;
        $info->archivo->fin = $fin;
        $info->archivo->duracion = $fin->diffForHumans($inicio);
        $info->archivo->archivo = $ubicacion;

        $tiempo = $info->archivo->duracion;
        $tiempo_generar = $info->duracion;

        Log::debug("Archivo CSV para SPSS generado: $ubicacion. Tiempo para calcular datos: $tiempo_generar.  Tiempo para el CSV: $tiempo.");

        return $info;
    }
}
