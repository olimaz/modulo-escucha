<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_excel_ficha_persona_entrevistada
 * @property int $id_entrevista
 * @property int $id_persona
 * @property int $id_persona_entrevistada
 * @property string $codigo_entrevista
 * @property string $nombre
 * @property string $apellido
 * @property string $otros_nombres
 * @property int $fec_nac_anio
 * @property int $fec_nac_mes
 * @property int $fec_nac_dia
 * @property string $lugar_nac_n1
 * @property string $lugar_nac_n2
 * @property string $lugar_nac_n3
 * @property int $edad
 * @property string $sexo
 * @property string $orientacion_sexual
 * @property string $identidad_genero
 * @property string $nacionalidad
 * @property string $estado_civil
 * @property string $educacion_formal
 * @property string $lugar_residencia_n1
 * @property string $lugar_residencia_n2
 * @property string $lugar_residencia_n3
 * @property string $lugar_residencia_zona
 * @property string $profesion
 * @property string $ocupacion_actual
 * @property int $cargo_publico
 * @property string $cargo_publico_cual
 * @property int $fuerza_publica_miembro
 * @property string $fuerza_publica_estado
 * @property string $actor_armado_ilegal
 * @property int $organizacion_colectivo_participa
 * @property int $discapacidad
 * @property int $es_victima
 * @property int $es_testigo
 * @property string $macroterritorio
 * @property string $territorio
 * @property string $lugar_entrevista_n1
 * @property string $lugar_entrevista_n2
 * @property string $lugar_entrevista_n3
 * @property string fecha_entrevista_anio
 * @property string fecha_entrevista_mes
 * @property string fecha_entrevista
 * @property int interes_etnico
 * @property string sector
 * @property int transcrita
 * @property int etiquetada
 * @property int clasificacion_acceso
 *
 */
class excel_ficha_persona_entrevistada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.excel_ficha_persona_entrevistada';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_excel_ficha_persona_entrevistada';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'id_persona', 'id_persona_entrevistada', 'codigo_entrevista', 'nombre', 'apellido', 'otros_nombres', 'fec_nac_anio', 'fec_nac_mes', 'fec_nac_dia', 'lugar_nac_n1', 'lugar_nac_n2', 'lugar_nac_n3', 'sexo', 'orientacion_sexual', 'identidad_genero', 'nacionalidad', 'estado_civil', 'educacion_formal', 'lugar_residencia_n1', 'lugar_residencia_n2', 'lugar_residencia_n3', 'lugar_residencia_zona', 'profesion', 'ocupacion_actual', 'cargo_publico', 'cargo_publico_cual', 'fuerza_publica_miembro', 'fuerza_publica_estado', 'actor_armado_ilegal', 'organizacion_colectivo_participa', 'discapacidad', 'es_victima', 'es_testigo', 'relato'];

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
        $total_filas=0;
        $total_errores=0;
        $inicio = Carbon::now();
        //Registrar el evento
        Log::notice("ETL de fichas de personas entrevistadas: inicio del proceso");
        //Inicializar la tabla
        excel_ficha_persona_entrevistada::truncate();

        //Listado: no borrados (id_activo=1) que tengan ficha de persona entrevsitada
        $listado = persona_entrevistada::join('esclarecimiento.e_ind_fvt','persona_entrevistada.id_e_ind_fvt','=','e_ind_fvt.id_e_ind_fvt')
                                ->join('fichas.persona','persona_entrevistada.id_persona','=','persona.id_persona')
                                ->where('e_ind_fvt.id_activo',1)
                                ->orderby('e_ind_fvt.entrevista_codigo')
                                ->select(DB::raw('persona_entrevistada.*'))
                                ->get();

        foreach($listado as $fila) {
            $excel = new excel_ficha_persona_entrevistada();
            $persona = persona::find($fila->id_persona);
            $entrevista = entrevista_individual::find($fila->id_e_ind_fvt);


            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->id_persona = $fila->id_persona;
            $excel->id_persona_entrevistada = $fila->id_persona_entrevistada;
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
            $excel->ocupacion_actual = $persona->ocupacion_actual;
            $excel->cargo_publico = $persona->cargo_publico==1 ? 1 : 0;
            $excel->cargo_publico_cual = $persona->cargo_publico_cual;
            $excel->fuerza_publica_miembro = cat_item::describir($persona->id_fuerza_publica);
            $excel->fuerza_publica_estado = cat_item::describir($persona->id_fuerza_publica_estado);
            $excel->actor_armado_ilegal = cat_item::describir($persona->id_actor_armado);
            $excel->organizacion_colectivo_participa =$persona->organizacion_colectivo==1 ? 1 : 0;
            if(count($persona->fmt_discapacidad)==0) {
                $excel->discapacidad = "Sin especificar";
            }
            else {
                $excel->discapacidad = implode(" | ",$persona->fmt_discapacidad);
            }
            $excel->es_victima = $fila->es_victima==1 ? 1 : 0;
            $excel->es_testigo = $fila->es_testigo==1 ? 1 : 0;
            $excel->relato = $fila->sintesis_relato;

            //Nuevos campos
            $excel->edad = $persona->calcular_edad($entrevista->entrevista_fecha);
            $excel->grupo_etario = persona::calcular_grupo_etario($excel->edad);
            if($excel->edad==-99) {
                $excel->edad = $fila->edad;
            }
            $excel->macroterritorio = $entrevista->fmt_id_macroterritorio;
            $excel->territorio = $entrevista->fmt_id_territorio;
            $geo = geo::find($entrevista->entrevista_lugar);
            if($geo) {
                $n[1]='xx';
                $n[2]=null;
                $n[3]=null;
                $n[$geo->nivel]=$geo->descripcion;
                while($geo = geo::find($geo->id_padre)) {
                    if($geo->nivel > 0 && $geo->nivel < 4) {
                        $n[$geo->nivel]=$geo->descripcion;
                    }
                }
                foreach($n as $id_nivel => $texto) {
                    $campo='lugar_entrevista_n'.$id_nivel;
                    $excel->$campo = $texto;
                   ;
                }
            }

            $excel->fecha_entrevista = substr($entrevista->entrevista_fecha,0,10);
            $excel->fecha_entrevista_mes = substr($entrevista->entrevista_fecha,0,7);
            $excel->fecha_entrevista_anio = substr($entrevista->entrevista_fecha,0,4);
            $excel->interes_etnico = $entrevista->id_etnico==1 ? 1 : 0;
            $excel->sector = $entrevista->fmt_id_sector;
            $excel->transcrita = empty($entrevista->html_transcripcion) ? 0 : 1;
            $excel->etiquetada = empty($entrevista->json_etiquetado) ? 0 : 1;
            $excel->clasificacion_acceso = $entrevista->clasifica_nivel;
            //
            try {
                $excel->save();
                $total_filas++;
            }
            catch (\Exception $e) {
                $total_errores++;
                Log::error("Problemas con el ETL de excel_personas_entrevistadass:".PHP_EOL.$e->getMessage());
            }
        }
        //Registrar el fin del proceso
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;
        $respuesta->tota_errores = $total_errores;

        Log::info("ETL de fichas de personas entrevistadas: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");

        return $respuesta;

    }

    public static function scopePermisos($query) {
        $arreglo_entrevistas = entrevista_individual::permisos()->pluck('id_e_ind_fvt');
        $query->wherein('id_entrevista',$arreglo_entrevistas);
    }

}
