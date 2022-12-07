<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_persona_entrevistada
 * @property int $id_entrevista
 * @property int $id_persona
 * @property string $codigo_entrevista
 * @property string $nombre
 * @property string $apellido
 * @property string $otros_nombres
 * @property int $fec_nac_anio
 * @property int $fec_nac_mes
 * @property int $fec_nac_dia
 * @property string $lugar_nac_codigo
 * @property string $lugar_nac_n1_codigo
 * @property string $lugar_nac_n1_txt
 * @property string $lugar_nac_n2_codigo
 * @property string $lugar_nac_n3_codigo
 * @property string $lugar_nac_n3_txt
 * @property string $lugar_nac_n3_lat
 * @property string $lugar_nac_n3_lon
 * @property int $sexo_id
 * @property string $sexo_txt
 * @property int $edad
 * @property string $grupo_etario
 * @property int $orientacion_sexual_id
 * @property string $orientacion_sexual_txt
 * @property int $identidad_genero_id
 * @property string $identidad_genero_txt
 * @property int $pertenencia_etnica_id
 * @property string $pertenencia_etnica_txt
 * @property int $pertenencia_indigena_id
 * @property string $pertenencia_indigena_txt
 * @property int $documento_identidad_tipo_id
 * @property string $documento_identidad_tipo_txt
 * @property string $documento_identidad_numero
 * @property int $nacionalidad_id
 * @property string $nacionalidad_txt
 * @property int $estado_civil_id
 * @property string $estado_civil_txt
 * @property string $lugar_residencia_codigo
 * @property string $lugar_residencia_n1_codigo
 * @property string $lugar_residencia_n1_txt
 * @property string $lugar_residencia_n2_codigo
 * @property string $lugar_residencia_n3_codigo
 * @property string $lugar_residencia_n3_txt
 * @property string $lugar_residencia_n3_lat
 * @property string $lugar_residencia_n3_lon
 * @property int $lugar_residencia_zona_id
 * @property string $lugar_residencia_zona_txt
 * @property string $lugar_residencia_descripcion
 * @property int $educacion_formal_id
 * @property string $educacion_formal_txt
 * @property string $profesion
 * @property string $ocupacion_actual
 * @property int $cargo_publico
 * @property string $cargo_publico_cual
 * @property string $fuerza_publica_miembro
 * @property string $fuerza_publica_estado
 * @property string $fuerza_publica_especificar
 * @property string $actor_armado_ilegal
 * @property string $actor_armado_ilegal_especificar
 * @property int $organizacion_colectivo_participa
 * @property int $discapacidad_id
 * @property string $discapacidad_txt
 * @property int $es_victima
 * @property int $es_testigo
 * @property string $relato
 * @property int $insert_id_entrevistador
 * @property string $insert_fecha_hora
 * @property string $insert_fecha
 * @property string $insert_fecha_mes
 * @property int $update_id_entrevistador
 * @property string $update_fecha_hora
 */
class analitica_persona_entrevistada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.persona_entrevistada';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_persona_entrevistada';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'id_persona', 'codigo_entrevista', 'nombre', 'apellido', 'otros_nombres', 'fec_nac_anio', 'fec_nac_mes', 'fec_nac_dia', 'lugar_nac_n1_codigo', 'lugar_nac_n1_txt', 'lugar_nac_n2_codigo', 'lugar_nac_n3_codigo', 'lugar_nac_n3_txt', 'lugar_nac_n3_lat', 'lugar_nac_n3_lon', 'sexo_id', 'sexo_txt', 'orientacion_sexual_id', 'orientacion_sexual_txt', 'identidad_genero_id', 'identidad_genero_txt', 'pertenencia_etnica_id', 'pertenencia_etnica_txt', 'pertenencia_indigena_id', 'pertenencia_indigena_txt', 'documento_identidad_tipo_id', 'documento_identidad_tipo_txt', 'documento_identidad_numero', 'nacionalidad_id', 'nacionalidad_txt', 'estado_civil_id', 'estado_civil_txt', 'lugar_residencia_n1_codigo', 'lugar_residencia_n1_txt', 'lugar_residencia_n2_codigo', 'lugar_residencia_n3_codigo', 'lugar_residencia_n3_txt', 'lugar_residencia_n3_lat', 'lugar_residencia_n3_lon', 'lugar_residencia_zona_id', 'lugar_residencia_zona_txt', 'lugar_residencia_descripcion', 'educacion_formal_id', 'educacion_formal_txt', 'profesion', 'ocupacion_actual', 'cargo_publico', 'cargo_publico_cual', 'fuerza_publica_miembro', 'fuerza_publica_estado', 'fuerza_public_especificar', 'actor_armado_ilegal', 'actor_armado_especificar', 'organizacion_colectivo_participa', 'discapacidad', 'es_victima', 'es_testigo', 'relato'];

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


    /*
     * Poblar la tabla
     */
    public static function generar_plana() {
        $inicio = Carbon::now();
        //Registrar el evento
        Log::notice("ETL de analitica-personas entrevistadas: inicio del proceso");
        //Inicializar la tabla
        analitica_persona_entrevistada::truncate();

        //Listado: no borrados (id_activo=1) que tengan ficha de persona entrevsitada
        $listado = persona_entrevistada::join('esclarecimiento.e_ind_fvt','persona_entrevistada.id_e_ind_fvt','=','e_ind_fvt.id_e_ind_fvt')
            ->join('fichas.persona','persona_entrevistada.id_persona','=','persona.id_persona')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->orderby('persona_entrevistada.id_persona_entrevistada')
            ->distinct()
            ->select(\DB::raw('persona_entrevistada.*'))
            ->get();
        $total_filas=0;
        $total_errores=0;
        foreach($listado as $fila) {
            //Buscar referencias
            $persona = persona::find($fila->id_persona);
            $entrevista = entrevista_individual::find($fila->id_e_ind_fvt);
            //Crear registro
            $excel = new analitica_persona_entrevistada();
            $excel->id_persona_entrevistada = $fila->id_persona_entrevistada;
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->id_persona = $fila->id_persona;
            $excel->codigo_entrevista = $entrevista->entrevista_codigo;

            $excel->fec_nac_anio = $persona->fec_nac_a;
            $excel->fec_nac_mes = $persona->fec_nac_m;
            $excel->fec_nac_dia = $persona->fec_nac_d;
            $geo=false;
            if(!is_null($persona->id_lugar_nacimiento)){
                $geo = geo::find($persona->id_lugar_nacimiento);
            }
            elseif(!is_null($persona->id_lugar_nacimiento_depto)) {
                $geo = geo::find($persona->id_lugar_nacimiento_depto);
            }

            if($geo) {
                $excel->lugar_nac_codigo = $geo->codigo;
                $n=array();
                $n[1]['codigo']=null;
                $n[1]['txt']=null;
                $n[2]['codigo']=null;
                $n[2]['txt']=null;
                //$n[3]['codigo']=null;
                //$n[3]['txt']=null;
                $n[intval($geo->nivel)]['codigo']=$geo->codigo;
                $n[intval($geo->nivel)]['txt']=$geo->descripcion;
                while($geo = geo::find($geo->id_padre)) {
                    if($geo->nivel > 0 && $geo->nivel < 4) {
                        $n[intval($geo->nivel)]['codigo']=$geo->codigo;
                        $n[intval($geo->nivel)]["txt"]=$geo->descripcion;
                    }
                }
                //dd($n);
                foreach($n as $id_nivel => $texto) {
                    $campo='lugar_nac_n'.$id_nivel;
                    $codigo = $campo."_codigo";
                    $txt    = $campo."_txt";
                    if(isset($texto['codigo'])) {
                        $excel->$codigo = $texto['codigo'];
                        $excel->$txt = $texto['txt'];
                    }
                }
            }

            $excel->sexo_id = $persona->id_sexo;
            $excel->sexo_txt = cat_item::describir($persona->id_sexo);
            $excel->edad = $persona->calcular_edad($entrevista->entrevista_fecha);
            if($excel->edad==-99) { //Ingreso manual
                $excel->edad = $fila->edad;
            }

            if($excel->edad > 0 && $excel->edad < 18) {
                $excel->nombre = "(Menor de edad)";
                $excel->apellido =  "(Menor de edad)";
                $excel->otros_nombres =  "(Menor de edad)";
            }
            else {
                $excel->nombre = $persona->nombre;
                $excel->apellido = $persona->apellido;
                $excel->otros_nombres = $persona->alias;
            }

            //$excel->edad = $persona->edad;
            $excel->grupo_etario = persona::calcular_grupo_etario($excel->edad);
            $excel->orientacion_sexual_id = $persona->id_orientacion;
            $excel->orientacion_sexual_txt = cat_item::describir($persona->id_orientacion);
            $excel->identidad_genero_id = $persona->id_identidad;
            $excel->identidad_genero_txt = cat_item::describir($persona->id_identidad);
            $excel->pertenencia_etnica_id = $persona->id_etnia;
            $excel->pertenencia_etnica_txt = cat_item::describir($persona->id_etnia);
            $excel->pertenencia_indigena_id = $persona->id_etnia_indigena;
            $excel->pertenencia_indigena_txt = cat_item::describir($persona->id_etnia_indigena);
            $excel->documento_identidad_tipo_id = $persona->id_tipo_documento;
            $excel->documento_identidad_tipo_txt = cat_item::describir($persona->id_tipo_documento);
            $excel->documento_identidad_numero = $persona->num_documento;
            $excel->nacionalidad_id = $persona->id_nacionalidad;
            $excel->nacionalidad_txt = cat_item::describir($persona->id_nacionalidad);
            $excel->estado_civil_id = $persona->id_estado_civil;
            $excel->estado_civil_txt = cat_item::describir($persona->id_estado_civil);

            $geo=false;
            if(!is_null($persona->id_lugar_residencia)) {
                $geo = geo::find($persona->id_lugar_residencia);
            }
            elseif(!is_null($persona->id_lugar_residencia_muni)) {
                $geo = geo::find($persona->id_lugar_residencia_muni);
            }
            elseif(!is_null($persona->id_lugar_residencia_depto)) {
                $geo = geo::find($persona->id_lugar_residencia_depto);
            }
            if($geo) {
                $excel->lugar_residencia_codigo = $geo->codigo;
                $n=array();
                $n[1] = null;
                $n[2] = null;
                $n[3] = null;

                $n[intval($geo->nivel)]['codigo']=$geo->codigo;
                $n[intval($geo->nivel)]['txt']=$geo->descripcion;
                if($geo->nivel==3) {
                    $excel->lugar_residencia_n3_lat=$geo->lat;
                    $excel->lugar_residencia_n3_lon=$geo->lon;
                }
                while($geo = geo::find($geo->id_padre)) {
                    if($geo->nivel > 0 && $geo->nivel < 4) {
                        $n[intval($geo->nivel)]['codigo']=$geo->codigo;
                        $n[intval($geo->nivel)]["txt"]=$geo->descripcion;
                    }
                }

                foreach($n as $id_nivel => $texto) {
                    $campo='lugar_residencia_n'.$id_nivel;
                    $codigo = $campo."_codigo";
                    $txt    = $campo."_txt";
                    if(isset($texto['codigo'])) {
                        $excel->$codigo = $texto['codigo'];
                        $excel->$txt = $texto['txt'];
                    }

                }
            }

            $excel->lugar_residencia_zona_id = $persona->id_zona;
            $excel->lugar_residencia_zona_txt = cat_item::describir($persona->id_zona);
            $excel->lugar_residencia_descripcion = $persona->lugar_residencia_nombre_vereda;
            $excel->educacion_formal_id = $persona->id_edu_formal;
            $excel->educacion_formal_txt = cat_item::describir($persona->id_edu_formal);
            $excel->profesion = $persona->profesion;
            //$excel->ocupacion_actual = $persona->ocupacion_actual;
            $excel->ocupacion_actual = $persona->fmt_id_ocupacion_actual;
            $excel->ocupacion_actual_reclasificado = $persona->fmt_id_ocupacion_actual_reclasificado;
            $excel->cargo_publico = $persona->cargo_publico==1 ? 1 : 0;
            $excel->cargo_publico_cual = $persona->cargo_publico_cual;
            $excel->fuerza_publica_miembro = cat_item::describir($persona->id_fuerza_publica);
            $excel->fuerza_publica_especificar = $persona->fuerza_publica_especificar;
            $excel->fuerza_publica_estado = cat_item::describir($persona->id_fuerza_publica_estado);
            $excel->actor_armado_ilegal = cat_item::describir($persona->id_actor_armado);
            $excel->actor_armado_ilegal_especificar = $persona->actor_armado_especificar;
            $excel->organizacion_colectivo_participa =$persona->organizacion_colectivo==1 ? 1 : 0;
            //Discapacidad
            $detalle = $persona->rel_discapacidad_fr;
            foreach($detalle as $item) {
                $campo=$item->detalle->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            $excel->es_victima = $fila->es_victima==1 ? 1 : 0;
            $excel->es_testigo = $fila->es_testigo==1 ? 1 : 0;
            $excel->relato = $fila->sintesis_relato;
            $excel->insert_id_entrevistador = $fila->insert_ent;
            if(!is_null($fila->insert_fh)) {
                $fecha = Carbon::createFromFormat('Y-m-d H:i:s',$fila->insert_fh);
            }
            else {
                $fecha = Carbon::createFromFormat('Y-m-d H:i:s','2019-01-01 00:00:00');
            }
            $excel->insert_fecha_hora = $fecha->format('Y-m-d H:i:s');
            $excel->insert_fecha = $fecha->format('Y-m-d');
            $excel->insert_fecha_mes = $fecha->format('Y-m');
            $excel->update_id_entrevistador = $fila->update_ent;
            if(!is_null($fila->update_fh)) {
                $fecha = Carbon::createFromFormat('Y-m-d H:i:s',$fila->update_fh);
                $excel->update_fecha_hora = $fecha->format('Y-m-d H:i:s');
            }
            else {
                if(!is_null($fila->insert_fh)) {
                    $fecha = Carbon::createFromFormat('Y-m-d H:i:s',$fila->insert_fh);
                }
                else {
                    $fecha = Carbon::createFromFormat('Y-m-d H:i:s','2019-01-01 00:00:00');
                }
                $excel->update_fecha_hora = $fecha->format('Y-m-d H:i:s');
            }
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-persona entrevistada: ".$e->getMessage());
            }
        }
        //Registrar el fin del proceso
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_errores = $total_errores;
        $respuesta->total_filas = $total_filas;

        Log::info("ETL de analitica-personas entrevistadas: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-personas entrevistadas finalizada con  $total_errores errores");
        }

        return $respuesta;

    }



}
