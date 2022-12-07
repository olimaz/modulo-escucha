<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_excel_control_adjuntos
 * @property int $id_entrevista
 * @property int $id_adjunto
 * @property string $tipo_entrevista
 * @property string $codigo_entrevista
 * @property int $consecutivo
 * @property string $tipo_adjunto
 * @property string $nombre_original
 * @property string $calificacion
 * @property int conteo_justificaciones
 * @property string justificaciones
 * @property string $justificacion_01
 * @property string $justificacion_02
 * @property string $justificacion_03
 * @property string $justificacion_04
 * @property string $justificacion_05
 * @property string $justificacion_06
 * @property string $justificacion_07
 * @property string $justificacion_08
 * @property string $justificacion_09
 * @property string $justificacion_10
 */
class excel_control_adjuntos extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.excel_control_adjuntos';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_excel_control_adjuntos';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'id_adjunto', 'tipo_entrevista', 'codigo_entrevista', 'consecutivo', 'tipo_adjunto', 'nombre_original', 'calificacion', 'justificacion_01', 'justificacion_02', 'justificacion_03', 'justificacion_04', 'justificacion_05', 'justificacion_06', 'justificacion_07', 'justificacion_08', 'justificacion_09', 'justificacion_10'];

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


    public static function generar_plana() {
        $inicio = Carbon::now();
        Log::notice("ETL de excel_control_adjuntos: inicio del proceso");

        self::truncate();
        $total_filas=0;
        // 1. Entrevista individual  (VI, AA, TC)
        $total_fvt = self::cargar_individuales();
        $total_filas+=$total_fvt;

        // 2. Colectivas
        $total_co = self::cargar_colectivas();
        $total_filas+=$total_co;

        // 3. Entrevistas Etnicas
        $total_ee = self::cargar_etnicas();
        $total_filas+=$total_ee;

        // 4. Entrevistas a profunidad
        $total_pr = self::cargar_profundidad();
        $total_filas+=$total_pr;

        // 5. Diagnóstico comunitario
        $total_dc = self::cargar_dc();
        $total_filas+=$total_dc;

        // 6. Historia de Vida
        $total_hv = self::cargar_hv();
        $total_filas+=$total_hv;

        // 7. Casos e informes
        $total_ci = self::cargar_ci();
        $total_filas+=$total_ci;


        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->vi = $total_fvt;
        $respuesta->co = $total_co;
        $respuesta->ee = $total_ee;
        $respuesta->pr = $total_pr;
        $respuesta->dc = $total_dc;
        $respuesta->hv = $total_hv;
        $respuesta->ci = $total_ci;
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;




        //Segundo grupo: Sujetos colectivos

        Log::info("ETL de excel_control_adjuntos: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");

        return $respuesta;

    }

    // Individuales: VI, AA, TC
    public static function cargar_individuales() {
        $total_filas=0;
        $listado = entrevista_individual::where('id_activo',1)->orderby('id_subserie')->orderby('id_e_ind_fvt')
                                        ->select('id_subserie','entrevista_codigo','id_e_ind_fvt')->get();

        $tipo[config('expedientes.vi')]='VI';
        $tipo[config('expedientes.aa')]='AA';
        $tipo[config('expedientes.tc')]='TC';
        foreach($listado as $fila) {
            $consecutivo=1;
            foreach($fila->rel_adjunto as $adjunto) {
                $excel = new self();
                $excel->id_entrevista = $fila->id_e_ind_fvt;
                $excel->id_adjunto=$adjunto->id_adjunto;
                $excel->tipo_entrevista = $tipo[$fila->id_subserie];
                $excel->codigo_entrevista = $fila->entrevista_codigo;
                $excel->consecutivo = $consecutivo++;
                $excel->tipo_adjunto = $adjunto->fmt_id_tipo;
                $excel->nombre_original = $adjunto->rel_id_adjunto->nombre_adjunto;
                $excel->calificacion = $adjunto->rel_id_adjunto->fmt_id_calificacion;
                $excel->archivo_encontrado = $adjunto->rel_id_adjunto->existe_archivo==1 ? 'Sí' :  ($adjunto->rel_id_adjunto->existe_archivo==2 ? 'No' : 'Desconocido');
                $excel->fecha_carga = $adjunto->rel_id_adjunto->fh_insert;
                $campo=1;
                $conteo=0;
                $a_id=[];
                foreach( $adjunto->rel_id_adjunto->rel_justificacion as $j) {
                    $donde = "justificacion_".str_pad($campo++,2,"0",STR_PAD_LEFT);
                    $excel->$donde = $j->fmt_id_justificacion;
                    $a_id[]=$j->id_justificacion;
                    $conteo++;
                }
                $excel->conteo_justificaciones = $conteo;
                $excel->justificaciones = implode(" ; ",$a_id);

                $excel->save();
                $total_filas++;

            }
        }
        return $total_filas;
    }

    // Colectivas
    public static function cargar_colectivas() {
        $total_filas=0;

        $listado = entrevista_colectiva::where('id_activo',1)->orderby('id_entrevista_colectiva')
            ->selectraw(\DB::raw("id_entrevista_colectiva, entrevista_codigo, 'CO' as tipo_entrevista"))->get();


        foreach($listado as $fila) {
            $consecutivo=1;
            foreach($fila->rel_adjunto as $adjunto) {
                $excel = new self();
                $excel->id_entrevista = $fila->id_entrevista_colectiva;
                $excel->id_adjunto=$adjunto->id_adjunto;
                $excel->tipo_entrevista = $fila->tipo_entrevista;
                $excel->codigo_entrevista = $fila->entrevista_codigo;
                $excel->consecutivo = $consecutivo++;
                $excel->tipo_adjunto = $adjunto->fmt_id_tipo;
                $excel->nombre_original = $adjunto->rel_id_adjunto->nombre_adjunto;
                $excel->calificacion = $adjunto->rel_id_adjunto->fmt_id_calificacion;
                $excel->archivo_encontrado = $adjunto->rel_id_adjunto->existe_archivo==1 ? 'Sí' :  ($adjunto->rel_id_adjunto->existe_archivo==2 ? 'No' : 'Desconocido');
                $excel->fecha_carga = $adjunto->rel_id_adjunto->fh_insert;
                $campo=1;
                $conteo=0;
                $a_id=[];
                foreach( $adjunto->rel_id_adjunto->rel_justificacion as $j) {
                    $donde = "justificacion_".str_pad($campo++,2,"0",STR_PAD_LEFT);
                    $excel->$donde = $j->fmt_id_justificacion;
                    $a_id[]=$j->id_justificacion;
                    $conteo++;
                }
                $excel->conteo_justificaciones = $conteo;
                $excel->justificaciones = implode(" ; ",$a_id);

                $excel->save();
                $total_filas++;
            }
        }
        return $total_filas;
    }


    // Etnicas
    public static function cargar_etnicas() {
        $total_filas=0;

        $listado = entrevista_etnica::where('id_activo',1)->orderby('id_entrevista_etnica')
            ->selectraw(\DB::raw("id_entrevista_etnica, entrevista_codigo, 'EE' as tipo_entrevista"))->get();


        foreach($listado as $fila) {
            $consecutivo=1;
            foreach($fila->rel_adjunto as $adjunto) {
                $excel = new self();
                $excel->id_entrevista = $fila->id_entrevista_etnica;
                $excel->id_adjunto=$adjunto->id_adjunto;
                $excel->tipo_entrevista = $fila->tipo_entrevista;
                $excel->codigo_entrevista = $fila->entrevista_codigo;
                $excel->consecutivo = $consecutivo++;
                $excel->tipo_adjunto = $adjunto->fmt_id_tipo;
                $excel->nombre_original = $adjunto->rel_id_adjunto->nombre_adjunto;
                $excel->calificacion = $adjunto->rel_id_adjunto->fmt_id_calificacion;
                $excel->archivo_encontrado = $adjunto->rel_id_adjunto->existe_archivo==1 ? 'Sí' :  ($adjunto->rel_id_adjunto->existe_archivo==2 ? 'No' : 'Desconocido');
                $excel->fecha_carga = $adjunto->rel_id_adjunto->fh_insert;
                $campo=1;
                $conteo=0;
                $a_id=[];
                foreach( $adjunto->rel_id_adjunto->rel_justificacion as $j) {
                    $donde = "justificacion_".str_pad($campo++,2,"0",STR_PAD_LEFT);
                    $excel->$donde = $j->fmt_id_justificacion;
                    $a_id[]=$j->id_justificacion;
                    $conteo++;
                }
                $excel->conteo_justificaciones = $conteo;
                $excel->justificaciones = implode(" ; ",$a_id);

                $excel->save();
                $total_filas++;
            }
        }
        return $total_filas;
    }

    // PR
    public static function cargar_profundidad() {
        $total_filas=0;

        $listado = entrevista_profundidad::where('id_activo',1)->orderby('id_entrevista_profundidad')
            ->selectraw(\DB::raw("id_entrevista_profundidad, entrevista_codigo, 'PR' as tipo_entrevista"))->get();


        foreach($listado as $fila) {
            $consecutivo=1;
            foreach($fila->rel_adjunto as $adjunto) {
                $excel = new self();
                $excel->id_entrevista = $fila->id_entrevista_profundidad;
                $excel->id_adjunto=$adjunto->id_adjunto;
                $excel->tipo_entrevista = $fila->tipo_entrevista;
                $excel->codigo_entrevista = $fila->entrevista_codigo;
                $excel->consecutivo = $consecutivo++;
                $excel->tipo_adjunto = $adjunto->fmt_id_tipo;
                $excel->nombre_original = $adjunto->rel_id_adjunto->nombre_adjunto;
                $excel->calificacion = $adjunto->rel_id_adjunto->fmt_id_calificacion;
                $excel->archivo_encontrado = $adjunto->rel_id_adjunto->existe_archivo==1 ? 'Sí' :  ($adjunto->rel_id_adjunto->existe_archivo==2 ? 'No' : 'Desconocido');
                $excel->fecha_carga = $adjunto->rel_id_adjunto->fh_insert;
                $campo=1;
                $conteo=0;
                $a_id=[];
                foreach( $adjunto->rel_id_adjunto->rel_justificacion as $j) {
                    $donde = "justificacion_".str_pad($campo++,2,"0",STR_PAD_LEFT);
                    $excel->$donde = $j->fmt_id_justificacion;
                    $a_id[]=$j->id_justificacion;
                    $conteo++;
                }
                $excel->conteo_justificaciones = $conteo;
                $excel->justificaciones = implode(" ; ",$a_id);

                $excel->save();
                $total_filas++;
            }
        }
        return $total_filas;
    }

    // Diagnostico Comunitario
    public static function cargar_dc() {
        $total_filas=0;

        $listado = diagnostico_comunitario::where('id_activo',1)->orderby('id_diagnostico_comunitario')
            ->selectraw(\DB::raw("id_diagnostico_comunitario, entrevista_codigo, 'DC' as tipo_entrevista"))->get();


        foreach($listado as $fila) {
            $consecutivo=1;
            foreach($fila->rel_adjunto as $adjunto) {
                $excel = new self();
                $excel->id_entrevista = $fila->id_diagnostico_comunitario;
                $excel->id_adjunto=$adjunto->id_adjunto;
                $excel->tipo_entrevista = $fila->tipo_entrevista;
                $excel->codigo_entrevista = $fila->entrevista_codigo;
                $excel->consecutivo = $consecutivo++;
                $excel->tipo_adjunto = $adjunto->fmt_id_tipo;
                $excel->nombre_original = $adjunto->rel_id_adjunto->nombre_adjunto;
                $excel->calificacion = $adjunto->rel_id_adjunto->fmt_id_calificacion;
                $excel->archivo_encontrado = $adjunto->rel_id_adjunto->existe_archivo==1 ? 'Sí' :  ($adjunto->rel_id_adjunto->existe_archivo==2 ? 'No' : 'Desconocido');
                $excel->fecha_carga = $adjunto->rel_id_adjunto->fh_insert;
                $campo=1;
                $conteo=0;
                $a_id=[];
                foreach( $adjunto->rel_id_adjunto->rel_justificacion as $j) {
                    $donde = "justificacion_".str_pad($campo++,2,"0",STR_PAD_LEFT);
                    $excel->$donde = $j->fmt_id_justificacion;
                    $a_id[]=$j->id_justificacion;
                    $conteo++;
                }
                $excel->conteo_justificaciones = $conteo;
                $excel->justificaciones = implode(" ; ",$a_id);

                $excel->save();
                $total_filas++;
            }
        }
        return $total_filas;
    }

    // Historia de Vida
    public static function cargar_hv() {
        $total_filas=0;

        $listado = historia_vida::where('id_activo',1)->orderby('id_historia_vida')
            ->selectraw(\DB::raw("id_historia_vida, entrevista_codigo, 'HV' as tipo_entrevista"))->get();


        foreach($listado as $fila) {
            $consecutivo=1;
            foreach($fila->rel_adjunto as $adjunto) {
                $excel = new self();
                $excel->id_entrevista = $fila->id_historia_vida;
                $excel->id_adjunto=$adjunto->id_adjunto;
                $excel->tipo_entrevista = $fila->tipo_entrevista;
                $excel->codigo_entrevista = $fila->entrevista_codigo;
                $excel->consecutivo = $consecutivo++;
                $excel->tipo_adjunto = $adjunto->fmt_id_tipo;
                $excel->nombre_original = $adjunto->rel_id_adjunto->nombre_adjunto;
                $excel->calificacion = $adjunto->rel_id_adjunto->fmt_id_calificacion;
                $excel->archivo_encontrado = $adjunto->rel_id_adjunto->existe_archivo==1 ? 'Sí' :  ($adjunto->rel_id_adjunto->existe_archivo==2 ? 'No' : 'Desconocido');
                $excel->fecha_carga = $adjunto->rel_id_adjunto->fh_insert;
                $campo=1;
                $conteo=0;
                $a_id=[];
                foreach( $adjunto->rel_id_adjunto->rel_justificacion as $j) {
                    $donde = "justificacion_".str_pad($campo++,2,"0",STR_PAD_LEFT);
                    $excel->$donde = $j->fmt_id_justificacion;
                    $a_id[]=$j->id_justificacion;
                    $conteo++;
                }
                $excel->conteo_justificaciones = $conteo;
                $excel->justificaciones = implode(" ; ",$a_id);

                $excel->save();
                $total_filas++;
            }
        }
        return $total_filas;
    }
    // Casos e informes
    public static function cargar_ci() {
        $total_filas=0;

        $listado = casos_informes::where('id_activo',1)->orderby('id_casos_informes')
            ->selectraw(\DB::raw("id_casos_informes, codigo, 'CI' as tipo_entrevista"))->get();


        foreach($listado as $fila) {
            $consecutivo=1;
            foreach($fila->rel_adjunto as $adjunto) {
                $excel = new self();
                $excel->id_entrevista = $fila->id_casos_informes;
                $excel->id_adjunto=$adjunto->id_adjunto;
                $excel->tipo_entrevista = $fila->tipo_entrevista;
                $excel->codigo_entrevista = $fila->codigo;
                $excel->consecutivo = $consecutivo++;
                $excel->tipo_adjunto = $adjunto->fmt_id_tipo;
                $excel->nombre_original = $adjunto->rel_id_adjunto->nombre_adjunto;
                $excel->calificacion = $adjunto->rel_id_adjunto->fmt_id_calificacion;
                $excel->archivo_encontrado = $adjunto->rel_id_adjunto->existe_archivo==1 ? 'Sí' :  ($adjunto->rel_id_adjunto->existe_archivo==2 ? 'No' : 'Desconocido');
                $excel->fecha_carga = $adjunto->rel_id_adjunto->fh_insert;

                $campo=1;
                $conteo=0;
                $a_id=[];
                foreach( $adjunto->rel_id_adjunto->rel_justificacion as $j) {
                    $donde = "justificacion_".str_pad($campo++,2,"0",STR_PAD_LEFT);
                    $excel->$donde = $j->fmt_id_justificacion;
                    $a_id[]=$j->id_justificacion;
                    $conteo++;
                }
                $excel->conteo_justificaciones = $conteo;
                $excel->justificaciones = implode(" ; ",$a_id);

                $excel->save();
                $total_filas++;
            }
        }
        return $total_filas;
    }

}
