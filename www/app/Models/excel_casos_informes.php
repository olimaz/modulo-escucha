<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_casos_informes
 * @property int $id_entrevistador
 * @property string $codigo
 * @property string $tipo
 * @property string $macroterritorio
 * @property string $territorio
 * @property string $fecha_registro
 * @property string $fecha_registro_a
 * @property string $fecha_registro_m
 * @property string $fecha_recepcion
 * @property string $fecha_recepcion_a
 * @property string $fecha_recepcion_m
 * @property string $titulo
 * @property string $autor
 * @property string $autor_tipo_organizacion
 * @property string $descripcion
 * @property string $tipo_soporte
 * @property string $contenido_texto
 * @property string $contenido_audiovisual
 * @property string $contenido_fotografia
 * @property string $contenido_sonoro
 * @property string $contenido_base_datos
 * @property string $contenido_otros
 * @property string $contenido_volumen
 * @property string $remitente_nombre
 * @property string $remitente_organizacion
 * @property string $remitente_tipo_organizacion
 * @property string $remitente_correo
 * @property string $remitente_telefono
 * @property string $remitente_cedula
 * @property string $entrega_lugar_n1_codigo
 * @property string $entrega_lugar_n1_txt
 * @property string $entrega_lugar_n2_codigo
 * @property string $entrega_lugar_n2_txt
 * @property string $entrega_lugar_n3_codigo
 * @property string $entrega_lugar_n3_txt
 * @property string $entrega_lugar_especifico
 * @property string $tiene_consentimiento
 * @property string $tiene_tratamiento
 * @property string $receptor_nombre
 * @property string $receptor_area
 * @property string $ubicacion_resguardo
 * @property string $receptor_anotaciones
 * @property string $caracterizacion_fecha
 * @property string $caracterizacion_fecha_a
 * @property string $caracterizacion_fecha_m
 * @property string $elaboracion_fecha
 * @property string $elaboracion_fecha_a
 * @property string $elaboracion_fecha_m
 * @property string $publicacion
 * @property string $publicacion_a
 * @property string $publicacion_m
 * @property string $cobertura_geo
 * @property string $cobertura_tiempo
 * @property string $sectores_incluye
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
 * @property int $ia_pueblo_etnico
 * @property int $ia_dialogo_social
 * @property int $ia_ds_o_convivencia
 * @property int $ia_ds_o_reconocimiento
 * @property int $ia_ds_o_no_repeticion
 * @property int $ia_genero
 * @property int $ia_enfoque_ps
 * @property int $ia_curso_vida
 * @property int $nucleo_01
 * @property int $nucleo_02
 * @property int $nucleo_03
 * @property int $nucleo_04
 * @property int $nucleo_05
 * @property int $nucleo_06
 * @property int $nucleo_07
 * @property int $nucleo_08
 * @property int $nucleo_09
 * @property int $nucleo_10
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
 * @property int $a_consentimiento
 * @property int $a_caso_informe
 * @property int $a_otros
 * @property float $entrega_lat
 * @property float $entrega_lon
 * @property string $created_at
 * @property string $updated_at
 * @property string json_adjuntos
 * @property string json_interes
 * @property string json_mandato
 * @property int clasificacion_nivel
 *
 * @property int conteo_consultas
 * @property string cobertura_geo_normalizada
 * @property string cobertura_geo_normalizada_codigos
 * @property string sectores_incluye_aa
 * @property string sectores_incluye_poblaciones
 * @property string sectores_incluye_ocupaciones

 */
class excel_casos_informes extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.excel_casos_informes';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_casos_informes';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_entrevistador', 'codigo', 'tipo', 'macroterritorio', 'territorio', 'fecha_registo', 'fecha_registo_a', 'fecha_registo_m', 'fecha_recepcion', 'fecha_recepcion_a', 'fecha_recepcion_m', 'titulo', 'autor','autor_tipo_organizacion', 'descripcion', 'tipo_soporte', 'contenido_texto', 'contenido_audiovisual', 'contenido_fotografia', 'contenido_sonoro', 'contenido_base_datos', 'contenido_otros', 'contenido_volumen', 'remitente_nombre', 'remitente_organizacion', 'remitente_tipo_organizacion', 'remitente_correo', 'remitente_telefono', 'remitente_cedula', 'entrega_lugar_n1_codigo', 'entrega_lugar_n1_txt', 'entrega_lugar_n2_codigo', 'entrega_lugar_n2_txt', 'entrega_lugar_n3_codigo', 'entrega_lugar_n3_txt', 'entrega_lugar_especifico', 'tiene_consentimiento', 'tiene_tratamiento', 'receptor_nombre', 'receptor_area', 'ubicacion_resguardo', 'receptor_anotaciones', 'caracterizacion_fecha', 'caracterizacion_fecha_a', 'caracterizacion_fecha_m', 'elaboracion_fecha', 'elaboracion_fecha_a', 'elaboracion_fecha_m', 'publicacion', 'publicacion_a', 'publicacion_m', 'cobertura_geo', 'cobertura_tiempo', 'sectores_incluye', 'i_objetivo_esclarecimiento', 'i_objetivo_reconocimiento', 'i_objetivo_convivencia', 'i_objetivo_no_repeticion', 'i_enfoque_genero', 'i_enfoque_psicosocial', 'i_enfoque_curso_vida', 'i_direccion_investigacion', 'i_direccion_territorios', 'i_direccion_etnica', 'i_comisionados', 'i_estrategia_arte', 'i_estrategia_comunicacion', 'i_estrategia_participacion', 'i_estrategia_pedagogia', 'i_grupo_acceso_informacion', 'i_presidencia', 'i_otra', 'i_enlace', 'i_sistema_informacion', 'ia_pueblo_etnico', 'ia_dialogo_social', 'ia_ds_o_convivencia', 'ia_ds_o_reconocimiento', 'ia_ds_o_no_repeticion', 'ia_genero', 'ia_enfoque_ps', 'ia_curso_vida', 'nucleo_01', 'nucleo_02', 'nucleo_03', 'nucleo_04', 'nucleo_05', 'nucleo_06', 'nucleo_07', 'nucleo_08', 'nucleo_09', 'nucleo_10', 'mandato_01', 'mandato_02', 'mandato_03', 'mandato_04', 'mandato_05', 'mandato_06', 'mandato_07', 'mandato_08', 'mandato_09', 'mandato_10', 'mandato_11', 'mandato_12', 'mandato_13', 'a_consentimiento', 'a_caso_informe', 'a_otros', 'entrega_lat', 'entrega_lon', 'created_at', 'updated_at'];

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
        $inicio = Carbon::now();
        // Nueva logica, siempre truncar
        Log::notice("ETL de casos e informes: inicio del proceso");
        $total_filas=0;
        excel_casos_informes::truncate();

        $listado = casos_informes::where('id_activo',1)->orderby('correlativo')->get();

        foreach($listado as $fila) {
            $excel = new excel_casos_informes();
            $excel->id_casos_informes = $fila->id_casos_informes;
            $excel->id_entrevistador = $fila->id_entrevistador;
            $excel->codigo = $fila->codigo;
            $excel->tipo = cat_item::describir($fila->caracterizacion_id_tipo);
            if($fila->caracterizacion_id_tipo == config('expedientes.caso_comision')) {
                $excel->cantidad_casos = $fila->cantidad_casos;
            }

            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio = $fila->fmt_id_territorio;
            $excel->fecha_registro = substr($fila->registro_fecha,0,10);
            $excel->fecha_registro_a = substr($fila->registro_fecha,0,4);
            $excel->fecha_registro_m = substr($fila->registro_fecha,0,7);
            $excel->fecha_recepcion = substr($fila->recepcion_fecha,0,10);
            $excel->fecha_recepcion_a = substr($fila->recepcion_fecha,0,4);
            $excel->fecha_recepcion_m = substr($fila->recepcion_fecha,0,7);
            $excel->titulo = $fila->titulo;
            $excel->autor = $fila->autor;
            $excel->autor_tipo_organizacion = $fila->fmt_autor_id_tipo_organizacion;
            $excel->descripcion = $fila->descripcion;
            $excel->conteo_consultas = entrevista_individual::conteo_hits($fila);
            $excel->tipo_soporte = cat_item::describir($fila->id_tipo_soporte);
            $excel->contenido_texto = $fila->contenido_texto;
            $excel->contenido_audiovisual = $fila->contenido_audiovisual;
            $excel->contenido_fotografia = $fila->contenido_fotografia;
            $excel->contenido_sonoro = $fila->contenido_sonoro;
            $excel->contenido_base_datos = $fila->contenido_base_datos;
            $excel->contenido_otros = $fila->contenido_otros;
            $excel->contenido_volumen = $fila->contenido_volumen;
            $excel->remitente_nombre  = $fila->remitente_nombre;
            $excel->remitente_organizacion  = $fila->remitente_organizacion;
            $excel->remitente_tipo_organizacion = cat_item::describir($fila->remitente_id_tipo_organizacion);
            $excel->remitente_correo  = $fila->remitente_correo;
            $excel->remitente_telefono  = $fila->remitente_telefono;
            $excel->remitente_cedula  = $fila->remitente_cedula;
            //Lugar de entrega
            $geo = $fila->rel_entrega_id_geo;
            if($geo) {
                $excel->entrega_lat = $geo->lat;
                $excel->entrega_lon = $geo->lon;

                $excel->entrega_lugar_n3_codigo = $geo->codigo;
                $excel->entrega_lugar_n3_txt = $geo->descripcion;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrega_lugar_n2_codigo = $geo->codigo;
                    $excel->entrega_lugar_n2_txt = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrega_lugar_n1_codigo = $geo->codigo;
                        $excel->entrega_lugar_n1_txt = $geo->descripcion;
                    }
                }
            }
            $excel->entrega_lugar_especifico = $fila->entrega_lugar;
            $excel->tiene_consentimiento = criterio_fijo::describir(2,$fila->entrega_id_consentimiento);
            $excel->tiene_tratamiento = criterio_fijo::describir(2,$fila->entrega_id_tratamiento);
            $excel->receptor_nombre = $fila->receptor_nombre;
            $excel->receptor_area = cat_item::describir($fila->receptor_id_area);
            $excel->ubicacion_resguardo = $fila->receptor_almacenaje;
            $excel->receptor_anotaciones = $fila->receptor_anotaciones;
            $excel->caracterizacion_fecha = substr($fila->caracterizacion_fecha_caracterizacion,0,10);
            $excel->caracterizacion_fecha_a = substr($fila->caracterizacion_fecha_caracterizacion,0,4);
            $excel->caracterizacion_fecha_m = substr($fila->caracterizacion_fecha_caracterizacion,0,7);
            $excel->elaboracion_fecha = substr($fila->caracterizacion_fecha_elaboracion,0,10);
            $excel->elaboracion_fecha_a = substr($fila->caracterizacion_fecha_elaboracion,0,4);
            $excel->elaboracion_fecha_m = substr($fila->caracterizacion_fecha_elaboracion,0,7);
            $excel->publicacion = substr($fila->caracterizacion_fecha_publicacion,0,10);
            $excel->publicacion_a = substr($fila->caracterizacion_fecha_publicacion,0,4);
            $excel->publicacion_m = substr($fila->caracterizacion_fecha_publicacion,0,7);
            $excel->cobertura_geo = $fila->caracterizacion_cobertura;
            $cobertura_geo_normalizada=null;
            $cobertura_geo_normalizada_codigos=null;
            $a_tmp=array();
            $a_tmp_codigos=array();
            foreach($fila->rel_casos_informes_geo as $tmp) {
                $a_tmp[] = geo::nombre_completo($tmp->id_geo);
                $a_tmp_codigos[] = geo::find($tmp->id_geo)->fmt_codigo;
            }
            if(count($a_tmp)>0) {
                $cobertura_geo_normalizada = implode(" | ",$a_tmp);
                $cobertura_geo_normalizada_codigos = implode(" | ",$a_tmp_codigos);
            }
            $excel->cobertura_geo_normalizada = $cobertura_geo_normalizada;
            $excel->cobertura_geo_normalizada_codigos = $cobertura_geo_normalizada_codigos;
            $excel->cobertura_tiempo = $fila->caracterizacion_temporalidad;
            $excel->sectores_incluye = $fila->caracterizacion_sectores;
            $a_tmp=array();
            foreach($fila->rel_sectores as $tmp ) {
                $item = cat_item::find($tmp->id_item);
                if($item) {
                    $a_tmp[$item->id_cat][]=$item->descripcion;
                }

            }
            $sectores_incluye_aa="";
            $sectores_incluye_poblaciones="";
            $sectores_incluye_ocupaciones="";
            if(isset($a_tmp[190])) {
                $sectores_incluye_aa = implode(" | ",$a_tmp[190]);
            }
            if(isset($a_tmp[191])) {
                $sectores_incluye_poblaciones = implode(" | ",$a_tmp[191]);
            }
            if(isset($a_tmp[192])) {
                $sectores_incluye_ocupaciones = implode(" | ",$a_tmp[192]);
            }
            $excel->sectores_incluye_aa = $sectores_incluye_aa;
            $excel->sectores_incluye_poblaciones = $sectores_incluye_poblaciones;
            $excel->sectores_incluye_ocupaciones = $sectores_incluye_ocupaciones;

            // intereses
            $aa = $fila->rel_intereses;
            $a_intereses=array();
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
                $a_json = array();
                $a_json['id']=$item->rel_id_interes->id_item;
                $a_json['txt']=$item->rel_id_interes->descripcion;
                $a_intereses[]=$a_json;
            }
            //Mandato
            $a_mandato=array();
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
                $a_json = array();
                $a_json['id']=$item->rel_id_mandato->id_item;
                $a_json['txt']=$item->rel_id_mandato->descripcion;
                $a_mandato[]=$a_json;
            }

            $adjuntos[1]="a_consentimiento";
            $adjuntos[15]="a_caso_informe";
            $adjuntos[4]="a_otros";
            foreach($fila->rel_adjunto as $adjunto) {
                if(isset($adjuntos[$adjunto->id_tipo])) {
                    $campo=$adjuntos[$adjunto->id_tipo];
                    $excel->$campo=1;
                }
            }


            if(!is_null($fila->fh_insert)) {
                $excel->created_at = Carbon::createFromFormat('Y-m-d H:i:s',$fila->fh_insert);
            }
            if(!is_null($fila->fh_update)) {
                $excel->updated_at = Carbon::createFromFormat('Y-m-d H:i:s', $fila->fh_update);
            }
            ////////////////////
            //Adjuntos
            $lis_adjuntos = array();
            foreach ($fila->rel_adjunto as $adjuntado) {
                if ($adjuntado->rel_id_adjunto) {
                    $registro = array();
                    $registro['id_adjunto'] = $adjuntado->id_adjunto;
                    $registro['tamano_en_bytes'] = $adjuntado->rel_id_adjunto->tamano_bruto;
                    $registro['id_tipo'] = $adjuntado->id_tipo;
                    $registro['tipo'] = criterio_fijo::describir(1, $adjuntado->id_tipo);
                    $registro['archivo'] = storage_path('app/public') . $adjuntado->rel_id_adjunto->ubicacion;
                    $registro['nombre_original'] = $adjuntado->rel_id_adjunto->nombre_original;
                    $registro['fecha_archivo'] = $adjuntado->rel_id_adjunto->fecha_ruso;
                    //
                    $adjunto = $adjuntado->rel_id_adjunto;
                    $acceso = new \stdClass();
                    $acceso->calificacion = new \stdClass();
                    $acceso->calificacion->id = $adjunto->id_calificacion;
                    $acceso->calificacion->txt = $adjunto->fmt_id_calificacion;
                    $a_justificacion=array();
                    if(count($adjunto->rel_justificacion) >0) {
                        foreach($adjunto->rel_justificacion as $justificacion) {
                            $tmp = new \stdClass();
                            $tmp->id = $justificacion->id_justificacion;
                            $tmp->txt = $justificacion->fmt_id_justificacion;
                            $a_justificacion[]=$tmp;
                        }
                    }
                    $acceso->justificacion=$a_justificacion;
                    $registro['calificacion']=$acceso;
                    //
                    $lis_adjuntos[] = $registro;
                }
            }
            $excel->json_adjuntos = json_encode($lis_adjuntos);
            $excel->json_interes = json_encode($a_intereses);
            $excel->json_mandato = json_encode($a_mandato);
            $excel->clasificacion_nivel = $fila->clasifica_nivel;
            $excel->clasificacion_sex = $fila->clasifica_sex == 1 ? 1 : 0;
            $excel->clasificacion_res = $fila->clasifica_res == 1 ? 1 : 0;
            $excel->clasificacion_nna = $fila->clasifica_nna == 1 ? 1 : 0;
            $excel->clasificacion_r2 = $fila->clasifica_r2 == 1 ? 1 : 0;



            $excel->save();
            $total_filas++;

        }
        $fin = Carbon::now();


        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;
        Log::info("ETL de casos e informes: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        return $respuesta;
    }

}
