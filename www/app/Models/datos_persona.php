<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_datos_persona
 * @property int $id_persona
 * @property string $codigo_entrevista
 * @property string $informacion_personal
 * @property string $persona_entrevistada
 * @property string $victima_violencia

 */
class datos_persona extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sim.datos_persona';
    protected $primaryKey = 'id_datos_persona';

    /**
     * @var array
     */
    protected $fillable = ['id_datos_persona', 'id_persona', 'codigo_entrevista', 'informacion_personal', 'persona_entrevistada', 'victima_violencia'];

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
        Log::notice("ETL de sim_persona: inicio del proceso");
        //Inicializar la tabla
        datos_persona::truncate();

        //Listado: Todas las entrevistas activas
        $listado = entrevista_individual::where('e_ind_fvt.id_activo',1)
            ->orderby('e_ind_fvt.id_e_ind_fvt')
            ->select('id_e_ind_fvt','entrevista_codigo')
            ->get();

        $total_filas=0;
        $total_entrevistas=0;
        $total_errores=0;

        foreach($listado as $entrevista) {
            $total_entrevistas++;
            //Detectar si tiene ficha de persona entrevistada
            $entrevistada = persona_entrevistada::where('id_e_ind_fvt',$entrevista->id_e_ind_fvt)->first();
            $id_persona=0;
            if($entrevistada) {
                $etl = new datos_persona();
                $etl->codigo_entrevista=$entrevista->entrevista_codigo;
                $etl->id_persona = $entrevistada->id_persona;
                $etl->id_entrevista = $entrevista->id_e_ind_fvt;
                $id_persona = $etl->id_persona; //Para ya no incluirlo en la exploración de victimas
                //Datos personales

                $etl->informacion_personal = json_encode(self::procesar_datos_personales($etl->id_persona));

                //Datos de persona entrevistada
                $etl->persona_entrevistada = json_encode(self::procesar_datos_entrevistada($entrevistada));
                //Datos de victima
                $etl->victima_violencia = json_encode(self::procesar_datos_victima($etl->id_persona));
                //Persistir a la BD
                try {
                    $etl->save();
                    $total_filas++;
                }
                catch(\Exception $e) {
                    $total_errores++;
                    Log::debug("Error en persistir registro de sim_persona (entrevistada): ".$e->getMessage());
                }
            }
            //Detectar fichas de victima, que no sean la persona entrevistada
            $listado_victimas = victima::where('id_e_ind_fvt',$entrevista->id_e_ind_fvt)->where('id_persona','<>',$id_persona)->orderby('id_persona')->distinct()->get();
            foreach($listado_victimas as $victima) {
                $etl = new datos_persona();
                $etl->codigo_entrevista=$entrevista->entrevista_codigo;
                $etl->id_persona = $victima->id_persona;
                $etl->id_entrevista = $entrevista->id_e_ind_fvt;
                //Datos personales
                $etl->informacion_personal = json_encode(self::procesar_datos_personales($etl->id_persona));
                //Datos de victima
                $etl->victima_violencia = json_encode(self::procesar_datos_victima($etl->id_persona));

                //Persistir a la BD
                try {
                    $etl->save();
                    $total_filas++;
                }
                catch(\Exception $e) {
                    $total_errores++;
                    Log::debug("Error en persistir registro de sim_persona (victima): ".$e->getMessage());
                }
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
        $respuesta->total_entrevistas = $total_entrevistas;

        Log::info("ETL de sim_persona: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de sim_persona finalizada con  $total_errores errores");
        }

        return $respuesta;

    }

    //Extrae información de la tabla persona
    public static function procesar_datos_personales($id_persona) {
        $persona = persona::find($id_persona);
        //Crear objeto
        $respuesta = new \stdClass();
        $respuesta->id_persona = $persona->id_persona;
        $respuesta->nombres = $persona->nombre;
        $respuesta->apellidos = $persona->apellido;
        $respuesta->otros_nombres = $persona->alias;
        $respuesta->fecha_nacimiento_anyo = $persona->fec_nac_a;
        $respuesta->fecha_nacimiento_mes = $persona->fec_nac_m;
        $respuesta->fecha_nacimiento_dia = $persona->fec_nac_d;
        if(!is_null($persona->id_lugar_nacimiento)) {
            $respuesta->lugar_nacimiento = self::procesar_datos_geograficos($persona->id_lugar_nacimiento);
        }
        elseif(!is_null($persona->id_lugar_nacimiento_depto)) {
            $respuesta->lugar_nacimiento = self::procesar_datos_geograficos($persona->id_lugar_nacimiento_depto);
        }

        $respuesta->sexo = cat_item::describir($persona->id_sexo);
        $respuesta->orientacion_sexual = cat_item::describir($persona->id_orientacion);
        $respuesta->identidad_genero = cat_item::describir($persona->id_identidad);
        $respuesta->pertenencia_etnica = cat_item::describir($persona->id_etnia);
        if($persona->id_etnia_indigena > 0) {
            $respuesta->pertenencia_indigena = cat_item::describir($persona->id_etnia_indigena);
        }
        $respuesta->pertenencia_indigena = cat_item::describir($persona->id_etnia_indigena);
        $respuesta->documento_identidad_tipo = cat_item::describir($persona->id_tipo_documento);
        $respuesta->documento_identidad_numero = $persona->num_documento;
        $respuesta->nacionalidad = cat_item::describir($persona->id_nacionalidad);
        $respuesta->otra_nacionalidad = cat_item::describir($persona->id_otra_nacionalidad);
        $respuesta->estado_civil = cat_item::describir($persona->id_estado_civil);
        if(!is_null($persona->id_lugar_residencia)) {
            $respuesta->lugar_residencia = self::procesar_datos_geograficos($persona->id_lugar_residencia);
        }
        elseif(!is_null($persona->id_lugar_residencia_muni)){
            $respuesta->lugar_residencia = self::procesar_datos_geograficos($persona->id_lugar_residencia_muni);
        }
        elseif(!is_null($persona->id_lugar_residencia_depto)){
            $respuesta->lugar_residencia = self::procesar_datos_geograficos($persona->lugar_residencia_depto);
        }
        $respuesta->lugar_residencia_zona = cat_item::describir($persona->id_zona);
        $respuesta->lugar_residencia_ubicacion = $persona->lugar_residencia_nombre_vereda;
        $respuesta->telefono = $persona->telefono;
        $respuesta->correo_electronico = $persona->correo_electronico;
        $respuesta->educacion_formal = cat_item::describir($persona->id_edu_formal);
        $respuesta->profesion = $persona->profesion;
        $respuesta->ocupacion_actual = $persona->ocupacion_actual;
        //Cargo publico
        if($persona->cargo_publico==1) {
            $respuesta->ejerce_autoridad = new \stdClass();
            $respuesta->ejerce_autoridad->respuesta = "Sí";
            $respuesta->ejerce_autoridad->especificar = $persona->cargo_publico_cual;
        }

        //Fuerza publica
        if($persona->id_fuerza_publica > 0) {
            $respuesta->miembro_fuerza_publica = new \stdClass();
            $respuesta->miembro_fuerza_publica->respuesta = "Sí";
            $respuesta->miembro_fuerza_publica->especificar = $persona->fuerza_publica_especificar;
            $respuesta->miembro_fuerza_publica->estado_actual = cat_item::describir($persona->id_fuerza_publica_estado);
        }

        //Actor armado ilegal
        if($persona->id_actor_armado > 0) {
            $respuesta->actor_armado_ilegal = new \stdClass();
            $respuesta->actor_armado_ilegal->respuesta = "Sí";
            $respuesta->actor_armado_ilegal->especificar = $persona->actor_armado_especificar;
        }
        //Participa en alguna organizacion o colectivo
        if( $persona->organizacion_colectivo==1 ) {
            $respuesta->participa_colectivo = new \stdClass();
            $respuesta->participa_colectivo->respuesta = "Sí";
            $respuesta->participa_colectivo->detalle = array();

            $listado_organizaciones = persona_organizacion::where('id_persona',$id_persona)->get();
            foreach($listado_organizaciones as $participacion) {
                $tmp = new \stdClass();
                $tmp->tipo = cat_item::describir($participacion->id_tipo_organizacion);
                $tmp->nombre = $participacion->nombre;
                $tmp->rol = $participacion->rol;
                $respuesta->participa_colectivo->detalle[]=$tmp;
            }
        }
        //Autoridad etnica
        $tmp = array();
        $listado_autoridad = persona_aut_etnico_ter::where('id_persona',$id_persona)->get();
        foreach($listado_autoridad as $autoridad) {
            $tmp[]=cat_item::describir($autoridad->id_aut_etnico_ter);
        }
        if(count($tmp)>0) {
            $respuesta->autoridad_etnico_territorial = $tmp;
        }

        //Discapacidad
        $tmp = array();
        $listado_discapacidad = $persona->rel_discapacidad_fr;
        foreach($listado_discapacidad as $item) {
            $tmp[] = $item->detalle->descripcion;
        }
        if(count($tmp)>0) {
            $respuesta->discapacidad = $tmp;
        }

        //Traza de seguridad
        $traza = new \stdClass();
        if(!is_null($persona->insert_fh)) {
            $traza->insert = new \stdClass();
            $traza->insert->fecha = $persona->insert_fh;
            $traza->insert->ip = $persona->insert_ip;
            $quien = entrevistador::find($persona->insert_ent);
            if($quien) {
                $traza->insert->entrevistador = $quien->fmt_numero_entrevistador;
            }
        }
        if(!is_null($persona->update_fh)) {
            $traza->update = new \stdClass();
            $traza->update->fecha = $persona->update_fh;
            $traza->update->ip = $persona->update_ip;
            $quien = entrevistador::find($persona->update_ent);
            if($quien) {
                $traza->update->entrevistador = $quien->fmt_numero_entrevistador;
            }
        }
        $respuesta->traza = $traza;
        return $respuesta;

    }
    //Extrae información de la tabla persona_entrevistada.  Recibe el registro entero, para evitar doble lectura a la BD
    public static function procesar_datos_entrevistada($persona_entrevistada) {
        $respuesta = new \stdClass();
        $respuesta->id_persona_entrevistada = $persona_entrevistada->id_persona_entrevistada;
        $respuesta->es_victima = $persona_entrevistada->es_victima == 1 ? "Sí" : "No";
        $respuesta->es_testigo = $persona_entrevistada->es_victima == 1 ? "Sí" : "No";
        $respuesta->edad = $persona_entrevistada->edad;
        $respuesta->sintesis_relato = $persona_entrevistada->sintesis_relato;
        return $respuesta;

    }
    //Extrae información de la tabla victima.  Busca todos los hechos y extrae información de la violencia
    public static function procesar_datos_victima($id_persona) {
        //Buscar su referencia en hechos
        $listado_hechos = hecho::join('fichas.hecho_victima','hecho.id_hecho','hecho_victima.id_hecho')
                ->join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
                ->where('victima.id_persona',$id_persona)
                ->selectraw(\DB::raw("hecho.*, hecho_victima.id_hecho_victima, hecho_victima.id_victima, hecho_victima.edad, hecho_victima.id_lugar_residencia, hecho_victima.id_lugar_residencia_tipo, hecho_victima.ocupacion"))
                ->get();
        $res=array();
        //Violencia
        foreach($listado_hechos as $hecho) {
            $evento = new \stdClass();
            //Datos de la víctima al momento de los hechos
            $evento->victima= new \stdClass();
            $evento->victima->id_victima = $hecho->id_victima;
            $evento->victima->id_hecho_victima = $hecho->id_hecho_victima;
            $evento->victima->edad = $hecho->edad;
            $evento->victima->lugar_residencia = self::procesar_datos_geograficos($hecho->id_lugar_residencia);
            $evento->victima->lugar_residencia_zona = cat_item::describir($hecho->id_lugar_residencia_tipo);
            $evento->victima->ocupacion = $hecho->ocupacion;
            $victima = victima::find($hecho->id_victima);
            $evento->victima->relacion_persona_entrevistada = $victima->fmt_parentezco;
            //Datos de los hechos
            $evento->victima->hechos = new \stdClass();
            $evento->victima->hechos->id_hecho = $hecho->id_hecho;
            $evento->victima->hechos->cantidad_victimas = $hecho->cantidad_victimas;
            $evento->victima->hechos->lugar = self::procesar_datos_geograficos($hecho->id_lugar);
            $evento->victima->hechos->sitio_especifico = $hecho->sitio_especifico;
            $evento->victima->hechos->tipo_zona = cat_item::describir($hecho->id_lugar_tipo);
            $evento->victima->hechos->fecha_ocurrencia_anyo = $hecho->fecha_ocurrencia_a;
            $evento->victima->hechos->fecha_ocurrencia_mes = $hecho->fecha_ocurrencia_m;
            $evento->victima->hechos->fecha_ocurrencia_dia = $hecho->fecha_ocurrencia_d;
            if($hecho->fecha_fin_a > 0){
                $evento->victima->hechos->fecha_finalizacion_anyo =  $hecho->fecha_fin_a;
                $evento->victima->hechos->fecha_finalizacion_mes =  $hecho->fecha_fin_m;
                $evento->victima->hechos->fecha_finalizacion_dia =  $hecho->fecha_fin_d;
            }
            if($hecho->aun_continuan == 1) {
                $evento->victima->hechos->hechos_aun_continuan="Sí";
            }
            $evento->victima->hechos->observaciones = $hecho->observaciones;
            $evento->victima->hechos->traza = self::extraer_traza($hecho);
            //Violencia
            $a_violencia = array();
            foreach($hecho->rel_violencia as $violencia) {
                $tmp = new \stdClass();
                $tmp->tipo = tipo_violencia::find($violencia->id_tipo_violencia)->descripcion;
                $tmp->subtipo = tipo_violencia::find($violencia->id_subtipo_violencia)->descripcion;
                foreach($violencia->rel_mecanismo as $mecanismo) {
                    $tmp->mecanismos[] = cat_item::describir($mecanismo->id_mecanismo);
                }
                if($violencia->cantidad_muertos > 0) {
                    $tmp->cantidad_muertos = $violencia->cantidad_muertos;
                }
                if($violencia->id_individual_colectiva > 0){
                    $tmp->individual_colectiva = cat_item::describir($violencia->id_individual_colectiva);
                }
                if($violencia->id_frente_otros > 0){
                    $tmp->frente_otros = $violencia->id_frente_otros==1 ? "Sí" : "No";
                }
                if($violencia->id_cometido_varios > 0){
                    $tmp->cometido_por_varios = $violencia->id_cometido_varios==1 ? "Sí" : "No";
                }
                if($violencia->id_hubo_embarazo > 0){
                    $tmp->hubo_embarazo = $violencia->id_hubo_embarazo==1 ? "Sí" : "No";
                }
                if($violencia->id_hubo_nacimiento > 0){
                    $tmp->hubo_nacimiento = $violencia->id_hubo_nacimiento==1 ? "Sí" : "No";
                }
                if($violencia->id_ind_fam_col > 0){
                    $tmp->individual_familiar_colectiva = cat_item::describir($violencia->id_ind_fam_col);
                }
                if($violencia->despojo_hectareas > 0){
                    $tmp->hectareas_despojadas = $violencia->despojo_hectareas;
                }
                if($violencia->despojo_recupero_tierras > 0){
                    $tmp->recupero_tierras = criterio_fijo::describir(10,$violencia->despojo_recupero_tierras);
                }
                if($violencia->despojo_recupero_derechos > 0){
                    $tmp->recupero_derechos = criterio_fijo::describir(10,$violencia->despojo_recupero_derechos);
                }
                if($violencia->id_lugar_salida > 0) {
                    $tmp->lugar_salida = self::procesar_datos_geograficos($violencia->id_lugar_salida);
                }
                if($violencia->id_lugar_llegada > 0) {
                    $tmp->lugar_llegada = self::procesar_datos_geograficos($violencia->id_lugar_llegada);
                }
                if($violencia->id_lugar_llegada_tipo > 0) {
                    $tmp->lugar_llegada_tipo = cat_item::describir($violencia->id_lugar_llegada_tipo);
                }
                if($violencia->id_sentido_desplazamiento > 0) {
                    $tmp->sentido_desplazamiento = cat_item::describir($violencia->id_sentido_desplazamiento);
                }
                if($violencia->id_tuvo_retorno > 0) {
                    $tmp->tuvo_retorno = $violencia->id_tuvo_retorno==1 ? "Sí" : "No";
                    $tmp->tuvo_retorno_tipo = cat_item::describir($violencia->id_tuvo_retorno_tipo);
                }
                if($violencia->id_tuvo_otros_desplazamientos > 0) {
                    $tmp->tuvo_otros_desplazamientos = $violencia->id_tuvo_otros_desplazamientos==1 ? "Sí" : "No";
                }
                $a_violencia[]= clone $tmp;

            }
            $evento->victima->hechos->violencia = $a_violencia;
            //Responsabilidad colectiva
            $a_respo = array();
            foreach($hecho->rel_responsabilidad as $responsabilidad) {
                $tmp = new \stdClass();
                if($responsabilidad->aa_id_tipo > 0) {
                    $aa = tipo_aa::find($responsabilidad->aa_id_tipo);
                    if($aa) {
                        $tmp->actor_armado = new \stdClass();
                        $tmp->actor_armado->tipo = tipo_aa::find($responsabilidad->aa_id_tipo)->descripcion;
                        $tmp->actor_armado->subtipo = tipo_aa::find($responsabilidad->aa_id_subtipo)->descripcion;
                        $tmp->actor_armado->nombre_grupo = $responsabilidad->aa_nombre_grupo;
                        $tmp->actor_armado->aa_bloque = $responsabilidad->aa_bloque;
                        $tmp->actor_armado->aa_frente = $responsabilidad->aa_frente;
                        $tmp->actor_armado->aa_unidad = $responsabilidad->aa_unidad;
                        if(strlen($responsabilidad->aa_otro_cual)>0) {
                            $tmp->actor_armado->otro_cual = $responsabilidad->aa_otro_cual;
                        }
                    }

                }
                if($responsabilidad->tc_id_tipo > 0) {
                    $tercero = tipo_tc::find($responsabilidad->tc_id_tipo);
                    if($tercero) {
                        $tmp->tercero_civil = new \stdClass();
                        $tmp->tercero_civil->tipo = tipo_tc::find($responsabilidad->tc_id_tipo)->descripcion;
                        $tmp->tercero_civil->subtipo = tipo_tc::find($responsabilidad->tc_id_subtipo)->descripcion;
                        $tmp->tercero_civil->nombre_grupo = $responsabilidad->tc_detalle;
                        if(strlen($responsabilidad->tc_otro_cual)>0) {
                            $tmp->tercero_civil->otro_cual = $responsabilidad->tc_otro_cual;
                        }
                    }

                }
                if(strlen($responsabilidad->otro_actor_cual)>0) {
                    $tmp->otro_actor = $responsabilidad->otro_actor_cual;
                }
                $a_respo[]= clone $tmp;
            }
            $evento->victima->hechos->responsabilidad=$a_respo;
            //Responsabilidad individual
            $a_pri = array();
            foreach($hecho->rel_responsable as $responsable){
                $persona_responable = $responsable->rel_id_persona_responsable;
                $persona = $persona_responable->persona;
                $tmp = new \stdClass();
                $tmp->id_persona_responsable = $persona_responable->id_persona_responsable;
                $tmp->nombres = $persona->nombre;
                $tmp->apellidos = $persona->apellido;
                $tmp->otros_nombres = $persona->alias;
                $tmp->sexo = cat_item::describir($persona->id_sexo);
                $tmp->pertenencia_etnico_racial = cat_item::describir($persona->id_etnia);
                $tmp->edad_aproximada = cat_item::describir($persona_responable->id_edad_aproximada);
                $tmp->actor_armado = cat_item::describir($persona_responable->id_rango_cargo);
                if($persona_responable->id_grupo_paramilitar > 0 ) {
                    $tmp->rango_cargo = cat_item::describir($persona_responable->id_grupo_paramilitar);
                }
                elseif($persona_responable->id_guerrila > 0 ) {
                    $tmp->rango_cargo = cat_item::describir($persona_responable->id_guerrila);
                }
                elseif($persona_responable->id_fuerza_publica > 0 ) {
                    $tmp->rango_cargo = cat_item::describir($persona_responable->id_fuerza_publica);
                }
                $tmp->nombre_del_superior = $persona_responable->nombre_superior;
                $tmp->sabe_que_hace_ahora = $persona_responable->conoce_info==1 ? "Sí" : "No";
                if(strlen($persona_responable->que_hace)>0) {
                    $tmp->que_hace = $persona_responable->que_hace;
                }
                if(strlen($persona_responable->donde_esta)>0) {
                    $tmp->donde_esta = $persona_responable->donde_esta;
                }
                $tmp->sabe_otros_hechos = $persona_responable->otros_hechos==1 ? "Sí" : "No";
                if(strlen($persona_responable->cuales)>0) {
                    $tmp->sabe_otros_hechos_cuales = $persona_responable->cuales;
                }
                $tmp->responsabilidad = array();
                foreach($persona_responable->rel_responsabilidad as $responsabilidad){
                    $tmp->responsabilidad[] = cat_item::describir($responsabilidad->id_responsabilidad);
                }

                $a_pri[] = clone $tmp;

            }
            $evento->victima->hechos->presunto_responsable_individual = $a_pri;

            $res[] = clone $evento;


        }

        return $res;

    }


    public static function procesar_datos_geograficos($id_geo) {
        $ubicacion = new \stdClass();
        $ubicacion->nivel = array();
        $que_nivel[1]="Departamento";
        $que_nivel[2]="Municipio";
        $que_nivel[3]="Vereda";

        while($id_geo > 0) {
            $geo = geo::find($id_geo);
            $tmp = new \stdClass();
            $tmp->nivel = $que_nivel[$geo->nivel];
            $tmp->codigo = $geo->codigo;
            $tmp->descripcion = $geo->descripcion;
            $tmp->lat = $geo->lat;
            $tmp->lon = $geo->lon;

            $ubicacion->nivel[] = $tmp;
            //Nivel superior
            $id_geo=$geo->id_padre;
        }
        return $ubicacion->nivel;

    }

    //Traza de seguridad
    public static function extraer_traza($fila) {
        $traza = new \stdClass();
        if(!is_null($fila->insert_fh)) {
            $traza->insert = new \stdClass();
            $traza->insert->fecha = $fila->insert_fh;
            $traza->insert->ip = $fila->insert_ip;
            $quien = entrevistador::find($fila->insert_ent);
            if($quien) {
                $traza->insert->entrevistador = $quien->fmt_numero_entrevistador;
            }
        }
        if(!is_null($fila->update_fh)) {
            $traza->update = new \stdClass();
            $traza->update->fecha = $fila->update_fh;
            $traza->update->ip = $fila->update_ip;
            $quien = entrevistador::find($fila->update_ent);
            if($quien) {
                $traza->update->entrevistador = $quien->fmt_numero_entrevistador;
            }
        }
        return $traza;
    }


}
