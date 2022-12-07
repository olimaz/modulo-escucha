<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


/**
 * @property int $id_dinamica
 * @property int $id_e_ind_fvt
 * @property int $correlativo
 * @property string $dinamica
 * @property string $codigo_entrevista
 * @property string $codigo_entrevistador
 * @property int $macroterritorio_id
 * @property string $macroterritorio_txt
 * @property int $territorio_id
 * @property string $territorio_txt
 * @property string $entrevista_fecha
 * @property string $entrevista_lugar_n1_codigo
 * @property string $entrevista_lugar_n1_txt
 * @property string $entrevista_lugar_n2_codigo
 * @property string $entrevista_lugar_n2_txt
 * @property string $entrevista_lugar_n3_codigo
 * @property string $entrevista_lugar_n3_txt
 * @property string $titulo
 * @property string $hechos_lugar_n1_codigo
 * @property string $hechos_lugar_n1_txt
 * @property string $hechos_lugar_n2_codigo
 * @property string $hechos_lugar_n2_txt
 * @property string $hechos_lugar_n3_codigo
 * @property string $hechos_lugar_n3_txt
 * @property string $hechos_del
 * @property string $hechos_al
 * @property string $anotaciones
 * @property int $aa_paramilitar
 * @property int $aa_guerrilla
 * @property int $aa_fuerza_publica
 * @property int $aa_terceros_civiles
 * @property int $aa_otro
 * @property int $viol_homicidio
 * @property int $viol_atentado_vida
 * @property int $viol_amenaza_vida
 * @property int $viol_desaparicion_f
 * @property int $viol_tortura
 * @property int $viol_violencia_sexual
 * @property int $viol_esclavitud
 * @property int $viol_reclutamiento
 * @property int $viol_detencion_arbitraria
 * @property int $viol_secuestro
 * @property int $viol_confinamiento
 * @property int $viol_pillaje
 * @property int $viol_extorsion
 * @property int $viol_ataque_bien_protegido
 * @property int $viol_ataque_indiscriminado
 * @property int $viol_despojo_tierras
 * @property int $viol_desplazamiento_forzado
 * @property int $viol_exilio
 * @property int $i_objetivo_esclarecimiento
 * @property int $i_objetivo_reconocimiento
 * @property int $i_objetivo_convivencia
 * @property int $i_objetivo_no_repeticion
 * @property int $i_enfoque_genero
 * @property int $i_enfoque_psicosocial
 * @property int $i_enfoque_curso_vida
 * @property int $i_direccion_investigacion
 * @property int $i_direccion_territorios
 * @property int $i_direccion_etnica
 * @property int $i_comisionados
 * @property int $i_estrategia_arte
 * @property int $i_estrategia_comunicacion
 * @property int $i_estrategia_participacion
 * @property int $i_estrategia_pedagogia
 * @property int $i_grupo_acceso_informacion
 * @property int $i_presidencia
 * @property int $i_otra
 * @property int $i_enlace
 * @property int $i_sistema_informacion
 * @property int $mandato_01
 * @property int $mandato_02
 * @property int $mandato_03
 * @property int $mandato_04
 * @property int $mandato_05
 * @property int $mandato_06
 * @property int $mandato_07
 * @property int $mandato_08
 * @property int $mandato_09
 * @property int $mandato_10
 * @property int $mandato_11
 * @property int $mandato_12
 * @property int $mandato_13
 * @property string $a_consentimiento
 * @property string $a_audio
 * @property string $a_ficha_corta
 * @property string $a_ficha_larga
 * @property string $a_otros
 * @property string $a_transcripcion_preliminar
 * @property string $a_transcripcion_final
 * @property string $a_retroalimentacion
 * @property string $created_at
 * @property string $updated_at
 */
class excel_entrevista_dinamica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.excel_entrevista_dinamica';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_dinamica';

    /**
     * @var array
     */
    protected $fillable = ['id_e_ind_fvt','tipo_entrevista', 'correlativo', 'dinamica', 'codigo_entrevista', 'codigo_entrevistador', 'macroterritorio_id', 'macroterritorio_txt', 'territorio_id', 'territorio_txt', 'entrevista_fecha', 'entrevista_lugar_n1_codigo', 'entrevista_lugar_n1_txt', 'entrevista_lugar_n2_codigo', 'entrevista_lugar_n2_txt', 'entrevista_lugar_n3_codigo', 'entrevista_lugar_n3_txt', 'titulo', 'hechos_lugar_n1_codigo', 'hechos_lugar_n1_txt', 'hechos_lugar_n2_codigo', 'hechos_lugar_n2_txt', 'hechos_lugar_n3_codigo', 'hechos_lugar_n3_txt', 'hechos_del', 'hechos_al', 'anotaciones', 'aa_paramilitar', 'aa_guerrilla', 'aa_fuerza_publica', 'aa_terceros_civiles', 'aa_otro', 'viol_homicidio', 'viol_atentado_vida', 'viol_amenaza_vida', 'viol_desaparicion_f', 'viol_tortura', 'viol_violencia_sexual', 'viol_esclavitud', 'viol_reclutamiento', 'viol_detencion_arbitraria', 'viol_secuestro', 'viol_confinamiento', 'viol_pillaje', 'viol_extorsion', 'viol_ataque_bien_protegido', 'viol_ataque_indiscriminado', 'viol_despojo_tierras', 'viol_desplazamiento_forzado', 'viol_exilio', 'i_objetivo_esclarecimiento', 'i_objetivo_reconocimiento', 'i_objetivo_convivencia', 'i_objetivo_no_repeticion', 'i_enfoque_genero', 'i_enfoque_psicosocial', 'i_enfoque_curso_vida', 'i_direccion_investigacion', 'i_direccion_territorios', 'i_direccion_etnica', 'i_comisionados', 'i_estrategia_arte', 'i_estrategia_comunicacion', 'i_estrategia_participacion', 'i_estrategia_pedagogia', 'i_grupo_acceso_informacion', 'i_presidencia', 'i_otra', 'i_enlace', 'i_sistema_informacion', 'mandato_01', 'mandato_02', 'mandato_03', 'mandato_04', 'mandato_05', 'mandato_06', 'mandato_07', 'mandato_08', 'mandato_09', 'mandato_10', 'mandato_11', 'mandato_12', 'mandato_13', 'a_consentimiento', 'a_audio', 'a_ficha_corta', 'a_ficha_larga', 'a_otros', 'a_transcripcion_preliminar', 'a_transcripcion_final', 'a_retroalimentacion', 'created_at', 'updated_at'];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * The storage format of the model's date columns.
     * 
     * @var string
     */
    protected $dateFormat = 'U';



    public static function generar_plana($truncar=false) {
        /*
        if($truncar) {
            excel_entrevista_dinamica::truncate();
        }
        $filtros = entrevista_individual::filtros_default();
        $filtros->id_subserie=config('expedientes.vi');

        $max_excel = excel_entrevista_dinamica::max('id_e_ind_fvt');
        //$max_tabla = entrevista_individual::filtrar($filtros)->max('id_e_ind_fvt');
        $max_tabla = entrevista_individual::max('id_e_ind_fvt');

        if($max_tabla == $max_excel) {
            $total_filas = excel_entrevista_dinamica::count();
            return $total_filas;
        }
        */

        // nueva logica, simpre truncar
        Log::notice("ETL de dinámicas de entrevistas individuales: inicio del proceso");

        $total_filas=0;
        excel_entrevista_dinamica::truncate();
        //$listado = entrevista_individual::filtrar($filtros)
        $listado = entrevista_individual::join('esclarecimiento.e_ind_fvt_dinamica','e_ind_fvt.id_e_ind_fvt','=','e_ind_fvt_dinamica.id_e_ind_fvt')
            ->orderby('dinamica')
            ->orderby('entrevista_codigo')
            ->get();
        foreach($listado as $fila) {
            $excel = new excel_entrevista_dinamica();
            $excel->dinamica =$fila->dinamica;// Dinamicas
            $excel->id_e_ind_fvt = $fila->id_e_ind_fvt;
            $excel->tipo_entrevista = $fila->fmt_id_subserie_codigo;
            $excel->correlativo = $fila->entrevista_correlativo;
            $excel->clasificacion = $fila->clasifica_nivel;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $excel->macroterritorio_id = $fila->id_macroterritorio;
            $excel->macroterritorio_txt = $fila->fmt_id_macroterritorio;
            $excel->territorio_id = $fila->id_territorio;
            $excel->territorio_txt = $fila->fmt_id_territorio;

            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_id = $quien->id_grupo;
            $excel->grupo_txt = $quien->fmt_grupo;

            $excel->entrevista_fecha = $fila->fmt_entrevista_fecha;
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3_codigo = $geo->codigo;
                $excel->entrevista_lugar_n3_txt = $geo->descripcion;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2_codigo = $geo->codigo;
                    $excel->entrevista_lugar_n2_txt = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1_codigo = $geo->codigo;
                        $excel->entrevista_lugar_n1_txt = $geo->descripcion;
                    }
                }

            }

            $excel->titulo = $fila->titulo;
            $geo = $fila->rel_hechos_lugar;
            if($geo) {
                $excel->hechos_lugar_n3_codigo = $geo->codigo;
                $excel->hechos_lugar_n3_txt = $geo->descripcion;

                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->hechos_lugar_n2_codigo = $geo->codigo;
                    $excel->hechos_lugar_n2_txt = $geo->descripcion;

                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->hechos_lugar_n1_codigo = $geo->codigo;
                        $excel->hechos_lugar_n1_txt = $geo->descripcion;
                    }
                }

            }
            $excel->hechos_del = $fila->fmt_hechos_del;
            $excel->hechos_al = $fila->fmt_hechos_al;
            $excel->anotaciones = $fila->anotaciones;
            //Nuevos campos
            $excel->es_prioritario = $fila->id_prioritario==1 ? 1 : 0;
            $excel->prioritario_tema = $fila->prioritario_tema;
            $excel->sector_victima = $fila->fmt_id_sector;
            $excel->interes_etnico = $fila->id_etnico==1 ? 1 : 0;

            $excel->remitido = $fila->fmt_id_remitido;
            $excel->transcrita = strip_tags($fila->fmt_estado_transcripcion);
            //Fuerzas responsables
            $aa = $fila->rel_fr;
            foreach($aa as $item) {
                $campo=$item->rel_id_fr->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            //Violencia
            $aa = $fila->rel_tv;
            foreach($aa as $item) {
                $campo=$item->rel_id_tv->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            //Interes_area
            $aa = $fila->rel_interes_area;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
                //dd($campo);
            }
            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }

            $adjuntos[1]="a_consentimiento";
            $adjuntos[2]="a_audio";
            $adjuntos[3]="a_ficha_corta";
            $adjuntos[5]="a_ficha_larga";
            $adjuntos[4]="a_otros";
            $adjuntos[8]="a_transcripcion_preliminar";
            $adjuntos[6]="a_transcripcion_final";
            $adjuntos[10]="a_retroalimentacion";
            $adjuntos[11]="a_relatoria";
            $adjuntos[17]="a_certificacion_inicial";
            $adjuntos[18]="a_certificacion_final";
            $adjuntos[21]="a_plan_trabajo";
            $adjuntos[22]="a_valoracion";
            foreach($fila->rel_adjunto as $adjunto) {
                if(isset($adjuntos[$adjunto->id_tipo])) {
                    $campo=$adjuntos[$adjunto->id_tipo];
                    $excel->$campo=1;
                }
            }

            //Campos nuevos
            $lugar_e = $fila->rel_entrevista_lugar;
            if($lugar_e) {
                $excel->entrevista_lat = $lugar_e->lat;
                $excel->entrevista_lon = $lugar_e->lon;
            }
            $lugar_h = $fila->rel_hechos_lugar;
            if($lugar_h) {
                $excel->hechos_lat = $lugar_h->lat;
                $excel->hechos_lon = $lugar_h->lon;
            }

            //Buscar transcripcion html
            $lis_adjunto = $fila->rel_adjunto()->where('id_tipo',6)->get();
            $html="";
            foreach($lis_adjunto as $opcion) {
                $adjunto = $opcion->rel_id_adjunto;
                try {
                    $info = pathinfo($adjunto->ubicacion);
                }
                catch(\Exception $e) {

                }

                $ext = isset($info['extension']) ? $info['extension'] : "xxx";
                $ext=mb_strtolower($ext);
                if($ext=='html') {
                    $ubica='public'.$adjunto->ubicacion;
                    if(Storage::exists($ubica)) {
                        try {
                            $html .= Storage::get($ubica);
                        }
                        catch(\Exception $e) {
                            //no hacer nada
                        }

                    }
                }
            }
            $excel->transcripcion_html = $html;




            //dd($fila->fh_insert);
            if(!is_null($fila->fh_insert)) {
                $excel->created_at = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert);
            }

            if(!is_null($fila->fh_update)) {
                $excel->updated_at = Carbon::createFromFormat('Y-m-d H:i:s.u', $fila->fh_update);
            }

            $excel->save();
            $total_filas++;

        }
        Log::info("ETL de dinámicas de entrevistas individuales: fin del proceso, $total_filas filas generadas");
        return $total_filas;

    }

    public static function scopePermisos($query) {
        $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas();
        $query->join('esclarecimiento.e_ind_fvt','excel_entrevista_dinamica.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->wherein('e_ind_fvt.id_entrevistador',$arreglo_entrevistadores);
    }



}
