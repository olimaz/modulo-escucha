<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_excel_ficha_victima
 * @property int $id_entrevista
 * @property int $id_persona
 * @property int $id_victima
 * @property string $codigo_entrevista
 * @property string $nombre
 * @property string $apellido
 * @property string $otros_nombres
 * @property int $fec_nac_anio
 * @property int $fec_nac_mes
 * @property int $fec_nac_dia
 * @property string $lugar_nac_codigo
 * @property string $lugar_nac_n1
 * @property string $lugar_nac_n2
 * @property string $lugar_nac_n3
 * @property string $lugar_nac_n3_lat
 * @property string $lugar_nac_n3_lon
 * @property string $sexo
 * @property string $orientacion_sexual
 * @property string $identidad_genero
 * @property string $pertenencia_etnica
 * @property string $pertenencia_indigena
 * @property string $nacionalidad
 * @property string $estado_civil
 * @property string $educacion_formal
 * @property string $lugar_residencia_codigo
 * @property string $lugar_residencia_n1
 * @property string $lugar_residencia_n2
 * @property string $lugar_residencia_n3
 * @property string $lugar_residencia_n3_lat
 * @property string $lugar_residencia_n3_lon
 * @property string $lugar_residencia_zona
 * @property string $profesion
 * @property string $ocupacion_actual
 * @property int $cargo_publico
 * @property string $cargo_publico_cual
 * @property string $fuerza_publica_miembro
 * @property string $fuerza_publica_estado
 * @property string $actor_armado_ilegal
 * @property int $organizacion_colectivo_participa
 * @property string $discapacidad
 */
class excel_ficha_victima extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.excel_ficha_victima';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_excel_ficha_victima';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'id_persona', 'id_victima', 'codigo_entrevista', 'nombre', 'apellido', 'otros_nombres', 'fec_nac_anio', 'fec_nac_mes', 'fec_nac_dia', 'lugar_nac_codigo', 'lugar_nac_n1', 'lugar_nac_n2', 'lugar_nac_n3', 'lugar_nac_n3_lat', 'lugar_nac_n3_lon', 'sexo', 'orientacion_sexual', 'identidad_genero', 'pertenencia_etnica', 'pertenencia_indigena', 'nacionalidad', 'estado_civil', 'educacion_formal', 'lugar_residencia_codigo', 'lugar_residencia_n1', 'lugar_residencia_n2', 'lugar_residencia_n3', 'lugar_residencia_n3_lat', 'lugar_residencia_n3_lon', 'lugar_residencia_zona', 'profesion', 'ocupacion_actual', 'cargo_publico', 'cargo_publico_cual', 'fuerza_publica_miembro', 'fuerza_publica_estado', 'actor_armado_ilegal', 'organizacion_colectivo_participa', 'discapacidad'];

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
        Log::notice("ETL de fichas de victimas: inicio del proceso");
        //Inicializar la tabla
        excel_ficha_victima::truncate();

        //Listado: no borrados (id_activo=1) que tengan ficha de persona entrevsitada
        $listado = victima::join('esclarecimiento.e_ind_fvt','victima.id_e_ind_fvt','=','e_ind_fvt.id_e_ind_fvt')
            ->join('fichas.persona','victima.id_persona','=','persona.id_persona')
            ->where('e_ind_fvt.id_activo',1)
            ->orderby('e_ind_fvt.entrevista_codigo')
            ->select(DB::raw('victima.*'))
            ->get();
        $total_filas=0;
        foreach($listado as $fila) {
            $excel = new excel_ficha_victima();
            $persona = persona::find($fila->id_persona);
            $entrevista = entrevista_individual::find($fila->id_e_ind_fvt);


            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->id_persona = $fila->id_persona;
            $excel->id_victima = $fila->id_victima;
            $excel->codigo_entrevista = $entrevista->entrevista_codigo;
            $excel->nombre = $persona->nombre;
            $excel->apellido = $persona->apellido;
            $excel->otros_nombres = $persona->alias;
            $excel->fec_nac_anio = $persona->fec_nac_a;
            $excel->fec_nac_mes = $persona->fec_nac_m;
            $excel->fec_nac_dia = $persona->fec_nac_d;
            $geo = geo::find($persona->id_lugar_nacimiento);
            if($geo) {
                $excel->lugar_nac_codigo = $geo->codigo;
                $n[1]=null;
                $n[2]=null;
                $n[3]=null;
                $n[intval($geo->nivel)]=$geo->descripcion;
                if($geo->nivel==3) {
                    $excel->lugar_nac_n3_lat=$geo->lat;
                    $excel->lugar_nac_n3_lon=$geo->lon;
                }
                while($geo = geo::find($geo->id_padre)) {
                    if($geo->nivel > 0 && $geo->nivel < 4) {
                        $n[intval($geo->nivel)]=$geo->descripcion;
                    }
                }
                foreach($n as $id_nivel => $texto) {
                    $campo='lugar_nac_n'.$id_nivel;
                    $excel->$campo = $texto;
                }
            }
            $excel->sexo = cat_item::describir($persona->id_sexo);
            $excel->orientacion_sexual = cat_item::describir($persona->id_orientacion);
            $excel->identidad_genero = cat_item::describir($persona->id_identidad);
            $excel->pertenencia_etnica = cat_item::describir($persona->id_etnia);
            $excel->pertenencia_indigena = cat_item::describir($persona->id_etnia_indigena);
            $excel->nacionalidad = cat_item::describir($persona->id_nacionalidad);
            $excel->estado_civil = cat_item::describir($persona->id_estado_civil);
            $excel->educacion_formal = cat_item::describir($persona->id_edu_formal);
            $geo = geo::find($persona->id_lugar_residencia);
            if($geo) {
                $excel->lugar_residencia_codigo = $geo->codigo;
                $n[1]=null;
                $n[2]=null;
                $n[3]=null;
                $n[$geo->nivel]=$geo->descripcion;
                if($geo->nivel==3) {
                    $excel->lugar_residencia_n3_lat=$geo->lat;
                    $excel->lugar_residencia_n3_lon=$geo->lon;
                }
                while($geo = geo::find($geo->id_padre)) {
                    if($geo->nivel > 0 && $geo->nivel < 4) {
                        $n[$geo->nivel]=$geo->descripcion;
                    }
                }

                foreach($n as $id_nivel => $texto) {
                    $campo='lugar_residencia_n'.$id_nivel;
                    $excel->$campo = $texto;
                }
            }

            $excel->lugar_residencia_zona = cat_item::describir($persona->id_zona);
            $excel->profesion = $persona->profesion;
            //$excel->ocupacion_actual = $persona->ocupacion_actual;
            $excel->cargo_publico = $persona->cargo_publico==1 ? 1 : 0;
            $excel->cargo_publico_cual = $persona->cargo_publico_cual;
            $excel->fuerza_publica_miembro = cat_item::describir($persona->id_fuerza_publica);
            $excel->fuerza_publica_estado = cat_item::describir($persona->id_fuerza_publica_estado);
            $excel->actor_armado_ilegal = cat_item::describir($persona->id_actor_armado);
            $excel->organizacion_colectivo_participa =$persona->organizacion_colectivo==1 ? 1 : 0;
            $excel->discapacidad = cat_item::describir($persona->id_discapacidad);

            $excel->save();
            $total_filas++;

        }
        $fin = Carbon::now();


        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;
        //Registrar el fin del proceso
        Log::info("ETL de fichas de victimas: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }

    public static function scopePermisos($query) {
        $arreglo_entrevistas = entrevista_individual::permisos()->pluck('id_e_ind_fvt');
        $query->wherein('id_entrevista',$arreglo_entrevistas);
    }

}
