<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\EntrevistaIndividual;
use App\Interfaces\EntrevistaRol;
use Eloquent as Model;
Use Log;

/**
 * Class persona
 * @package App\Models
 * @version September 24, 2019, 4:54 pm -05
 *
 * @property \App\Models\Catalogos.geo idLugarNacimiento
 * @property \App\Models\Catalogos.catItem idSexo
 * @property \App\Models\Catalogos.catItem identidad
 * @property \App\Models\Catalogos.catItem idOrientacion
 * @property \App\Models\Catalogos.catItem idEtnia
 * @property \App\Models\Catalogos.catItem idTipoDocumento
 * @property \App\Models\Catalogos.catItem idNacionalidad
 * @property \App\Models\Catalogos.catItem idEstadoCivil
 * @property \App\Models\Catalogos.geo idLugarResidencia
 * @property \App\Models\Catalogos.catItem idZona
 * @property \App\Models\Catalogos.catItem idEduFormal
 * @property \App\Models\Catalogos.catItem idFuerzaPublicaEstado
 * @property \App\Models\Catalogos.catItem idFuerzaPublica
 * @property \App\Models\Catalogos.catItem idActorArmado
 * @property string nombre
 * @property string apellido
 * @property string alias
 * @property integer fec_nac_a
 * @property integer fec_nac_m
 * @property integer fec_nac_d
 * @property integer id_lugar_nacimiento
 * @property integer id_sexo
 * @property integer id_orientacion
 * @property integer id_identidad
 * @property integer id_etnia
 * @property integer id_etnia_indigena
 * @property integer id_tipo_documento
 * @property string num_documento
 * @property integer id_nacionalidad
 * @property integer id_otra_nacionalidad
 * @property integer id_estado_civil
 * @property integer id_lugar_residencia
 * @property integer lugar_residencia_nombre_vereda
 * @property string telefono
 * @property string correo_electronico
 * @property integer id_zona
 * @property integer id_edu_formal
 * @property string profesion
 * @property string ocupacion_actual
 * @property integer id_ocupacion_actual
 * @property integer cargo_publico
 * @property string cargo_publico_cual
 * @property integer id_fuerza_publica_estado
 * @property integer fuerza_publica_especificar
 * @property integer id_fuerza_publica
 * @property integer id_actor_armado
 * @property integer actor_armado_especificar
 * @property integer organizacion_colectivo
 * @property integer id_discapacidad
 * @property string nombre_organizacion
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */

// public function existeEntrevistaIndividual(int $id_e_ent_fvt);

class persona extends Model implements EntrevistaIndividual, EntrevistaRol
{

    public $table = 'fichas.persona';

    protected $primaryKey = 'id_persona';

    public $timestamps = true;

    public $fillable = [
        'nombre',
        'apellido',
        'alias',
        'fec_nac_a',
        'fec_nac_m',
        'fec_nac_d',
        'id_lugar_nacimiento',
        'id_sexo',
        'id_orientacion',
        'id_identidad',
        'id_etnia',
        'id_tipo_documento',
        'num_documento',
        'id_nacionalidad',
        'id_estado_civil',
        'id_lugar_residencia',
        'telefono',
        'correo_electronico',
        'id_zona',
        'id_edu_formal',
        'profesion',
        'ocupacion_actual',
        'id_ocupacion_actual',
        'cargo_publico',
        'cargo_publico_cual',
        'id_fuerza_publica_estado',
        'id_fuerza_publica',
        'id_actor_armado',
        'organizacion_colectivo',
        'id_discapacidad',
        'nombre_organizacion',
        'created_at',
        'updated_at',
        'id_etnia_indigena',
        'id_e_ind_fvt',
        'id_otra_nacionalidad',
        'id_lugar_residencia_depto',
        'id_lugar_residencia_muni',
        'id_lugar_nacimiento_depto',
        'fuerza_publica_especificar',
        'actor_armado_especificar'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'es_testigo' => 'integer',
        'nombre' => 'string',
        'apellido' => 'string',
        'alias' => 'string',
        'fec_nac_a' => 'integer',
        'fec_nac_m' => 'integer',
        'fec_nac_d' => 'integer',
        'id_lugar_nacimiento' => 'integer',
        'id_sexo' => 'integer',
        'id_orientacion' => 'integer',
        'id_identidad' => 'integer',
        'id_etnia' => 'integer',
        'id_tipo_documento' => 'integer',
        'num_documento' => 'string',
        'id_nacionalidad' => 'integer',
        'id_estado_civil' => 'integer',
        'id_lugar_residencia' => 'integer',
        'telefono' => 'string',
        'correo_electronico' => 'string',
        'id_zona' => 'integer',
        'id_edu_formal' => 'integer',
        'profesion' => 'string',
        'ocupacion_actual' => 'string',
        'cargo_publico' => 'integer',
        'cargo_publico_cual' => 'string',
        'id_fuerza_publica_estado' => 'integer',
        'id_fuerza_publica' => 'integer',
        'id_actor_armado' => 'integer',
        'organizacion_colectivo' => 'integer',
        'nombre_organizacion' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'id_e_ind_fvt' => 'integer',
        'id_otra_nacionalidad' => 'integer',
        'id_lugar_residencia_depto' => 'integer',
        'id_lugar_residencia_muni' => 'integer',
        'id_lugar_nacimiento_depto' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'num_documento' => 'max:20',
        'telefono' => 'max:20',
        'profesion' => 'max:100',
        'ocupacion_actual' => 'max:100',
        'cargo_publico_cual' => 'max:100',
        'nombre' => 'max:200',
        'apellido' => 'max:200',
        'alias' => 'max:200',
        'correo_electronico' => 'max:200',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_lugar_nacimiento()
    {
        return $this->belongsTo(geo::class, 'id_lugar_nacimiento');
    }

    public function rel_id_lugar_nacimiento_depto()
    {
        return $this->belongsTo(geo::class, 'id_lugar_nacimiento_depto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_sexo()
    {
        return $this->belongsTo(cat_item::class, 'id_sexo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_edu_formal()
    {
        return $this->belongsTo(cat_item::class, 'id_edu_formal');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_identidad()
    {
        return $this->belongsTo(cat_item::class, 'id_identidad');
    }

    /**clear
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToclear
     **/
    public function rel_id_orientacion()
    {
        return $this->belongsTo(cat_item::class, 'id_orientacion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_etnia()
    {
        return $this->belongsTo(cat_item::class, 'id_etnia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_tipo_documento()
    {
        return $this->belongsTo(cat_item::class, 'id_tipo_documento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_nacionalidad()
    {
        return $this->belongsTo(cat_item::class, 'id_nacionalidad');
    }

    public function rel_id_otra_nacionalidad()
    {
        return $this->belongsTo(cat_item::class, 'id_otra_nacionalidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_estado_civil()
    {
        return $this->belongsTo(cat_item::class, 'id_estado_civil');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_lugar_residencia()
    {
        return $this->belongsTo(geo::class, 'id_lugar_residencia');
    }

    public function rel_id_lugar_residencia_depto()
    {
        return $this->belongsTo(geo::class, 'id_lugar_residencia_depto');
    }

    public function rel_id_lugar_residencia_muni()
    {
        return $this->belongsTo(geo::class, 'id_lugar_residencia_muni');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_zona()
    {
        return $this->belongsTo(cat_item::class, 'id_zona');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_etnia_indigena() {
        return $this->belongsTo(cat_item::class, 'id_etnia_indigena');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_fuerza_publica_estado()
    {
        return $this->belongsTo(cat_item::class, 'id_fuerza_publica_estado');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_fuerza_publica()
    {
        return $this->belongsTo(cat_item::class, 'id_fuerza_publica');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_actor_armado()
    {
        return $this->belongsTo(cat_item::class, 'id_actor_armado');
    }

    public function rel_discapacidad_fr() {
        return $this->hasMany(persona_discapacidad::class,'id_persona','id_persona');
    }

    public function rel_responsabilidad_fr() {
        return $this->hasMany(persona_responsable_responsabilidades::class,'id_persona_responsable','id_persona_responsable');
    }

    public function rel_autoridad_etnico_territorial_fr() {
        return $this->hasMany(persona_aut_etnico_ter::class, 'id_persona', 'id_persona');
    }

    public function rel_persona_organizacion() {
        return $this->hasMany(persona_organizacion::class, 'id_persona', 'id_persona');
    }

    public function rel_persona_entrevistada() {
        return $this->hasOne(persona_entrevistada::class, 'id_persona', 'id_persona');
    }

    public function rel_persona_victima() {
        return $this->hasOne(victima::class, 'id_persona', 'id_persona');
    }

    public function rel_persona_responsable() {
        return $this->hasOne(persona_responsable::class, 'id_persona', 'id_persona');
    }

    //RELACIONES PERSONA RESPONSABLE

    public function rel_id_edad_aproximada()
    {
        return $this->belongsTo(cat_item::class, 'id_edad_aproximada','id_item');
    }

    public function rel_id_rango_cargo()
    {
        return $this->belongsTo(cat_item::class, 'id_rango_cargo','id_item');
    }

    public function rel_id_grupo_paramilitar()
    {
        return $this->belongsTo(cat_item::class, 'id_grupo_paramilitar','id_item');
    }

    public function rel_id_guerrilla()
    {
        return $this->belongsTo(cat_item::class, 'id_guerrilla','id_item');
    }

    public function rel_id_presunta_responsabilidad()
    {
        return $this->belongsTo(cat_item::class, 'id_presunta_responsabilidad','id_item');
    }
    public function rel_id_ocupacion_actual() {
        return $this->belongsTo(cat_item::class,'id_ocupacion_actual','id_item');
    }

    // FIN RELACIONES PERSONA RESPONSABLE


    public static function victimas() {
        $victimas = persona::join('fichas.victima', 'victima.id_persona', '=', 'persona.id_persona');
        return $victimas;
    }

    public static function personas_entrevistadas() {
        $personas_entrevistadas = persona::join('fichas.persona_entrevistada', 'persona_entrevistada.id_persona', '=', 'persona.id_persona');
        return $personas_entrevistadas;
    }

    public static function personas_responsables_bak() {
        $responsables = persona::join('fichas.persona_responsable', 'persona_responsable.id_persona', '=', 'persona.id_persona')->get();
        return $responsables;
    }

    public function personas_responsables() {
        $listado = persona::where('persona.id_persona',$this->id_persona)->join('fichas.persona_responsable', 'persona_responsable.id_persona', '=', 'persona.id_persona')->get();
        return $listado;
    }

    // Formatos para personas $responsables
    public function getfmtidpresuntaresponsabilidadAttribute()
    {
        return cat_item::describir($this->id_presunta_responsabilidad);
    }

    public function getfmtidedadaproximadaAttribute()
    {
        return cat_item::describir($this->id_edad_aproximada);
    }
    public function getfmtidrangocargoAttribute()
    {
        return cat_item::describir($this->id_rango_cargo);
    }
    public function getfmtidgrupoparamilitarAttribute()
    {
        return cat_item::describir($this->id_grupo_paramilitar);
    }
    public function getfmtidguerrillaAttribute()
    {
        return cat_item::describir($this->id_guerrilla);
    }
    public function getfmtidfuerzapublicaAttribute()
    {
        return cat_item::describir($this->id_fuerza_publica);
    }
    public function getFmtIdOcupacionActualAttribute() {
        return cat_item::describir($this->id_ocupacion_actual);
    }
    public function getFmtIdOcupacionActualReclasificadoAttribute() {
        return cat_item::describir_reclasificado($this->id_ocupacion_actual);
    }

    public function getfmtconoceinfoAttribute() {
        return $this->conoce_info==1 ? "Sí" : "No";
    }

    public function getfmtotroshechosAttribute() {
        return $this->otros_hechos==1 ? "Sí" : "No";
    }

    //Fecha de nacimiento concatenada
    public function getFmtFechaNacimientoCompletaAttribute() {
        $fecha=array();
        if($this->fec_nac_a>0) {
            $fecha[]=$this->fec_nac_a;
        }
        if($this->fec_nac_m>0) {
            $fecha[]=$this->fec_nac_m;
        }
        if($this->fec_nac_d>0) {
            $fecha[]=$this->fec_nac_d;
        }
        $fecha_completa = implode("-",$fecha);
        return $fecha_completa;
    }

    public function getFmtDiscapacidadAttribute() {

       return  persona_discapacidad::where('id_persona',$this->id_persona)
                                        ->join('catalogos.cat_item','id_discapacidad','id_item')
                                        ->orderby('cat_item.descripcion')
                                        ->pluck('cat_item.descripcion')
                                        ->toArray();
    }

    /*
     * Para mostrar los hechos de una victima
     */

    public function listado_hechos() {
        return hecho::join('fichas.hecho_victima','hecho.id_hecho','hecho_victima.id_hecho')
                ->join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
                ->where('victima.id_persona',$this->id_persona)
                ->orderby('hecho.fecha_ocurrencia_a')
                ->orderby('hecho.fecha_ocurrencia_m')
                ->orderby('hecho.fecha_ocurrencia_d')
                ->pluck('hecho.id_hecho')
                ->toArray();

    }

    /** / Persona Responsable */
    /** Get Attribute */

    public function getVictimaEdadAproximadaAttribute() {

        if (!empty($this->rel_persona_victima)) {
            return $this->rel_persona_victima->edad_aprox;
        }

        return "";
    }

    public function getVictimaOcupacionHechosAttribute() {

        if (!empty($this->rel_persona_victima)){
            return $this->rel_persona_victima->ocupacion_hechos;
        }

        return "";
    }

    public function getFechaNacimientoAttribute() {
        return hecho::mostrar_fecha_incompleta($this->fec_nac_d, $this->fec_nac_m, $this->fec_nac_a);
    }

    public function getEditarFechaNacimientoAttribute() {
        return hecho::editar_fecha_incompleta($this->fec_nac_d, $this->fec_nac_m, $this->fec_nac_a);
    }

    public function getDocumentoIdentidadAttribute() {

        $num_documento = $this->num_documento;
        $sw_num_doc = true;
        $sw_num_tipo_doc = true;

        if (empty($num_documento))
            $sw_num_doc = false;

        if (empty($this->rel_id_tipo_documento))
            $sw_num_tipo_doc = false;

        if ($sw_num_doc && $sw_num_tipo_doc)
            return $this->rel_id_tipo_documento->descripcion . " " . $num_documento;
        else if ($sw_num_doc)
            return $num_documento;

        return "Sin documento";
    }

    public function agregarCondicionDiscapacidad($input=[]) {

        $discapacidad = (isset($input['discapacidad']) ? $input['discapacidad'] : []);


        $this->rel_discapacidad_fr()->delete();

        foreach($discapacidad as $valor)
            $this->rel_discapacidad_fr()->save(new persona_discapacidad(['id_discapacidad'=>$valor]));
    }

    public function agregarResponsabilidades($input=[]) {

        $responsabilidad = (isset($input['presunta_responsabilidad']) ? $input['presunta_responsabilidad'] : []);


        $this->rel_responsabilidad_fr()->delete();

        foreach($responsabilidad as $valor)
            $this->rel_responsabilidad_fr()->save(new persona_responsable_responsabilidades(['id_responsabilidad'=>$valor]));
    }

    public function agregarAutoridadEtnicoTerritorial($input=[]) {

        $autoridad_etno_territorial = (isset($input['autoridad_etno_territorial']) ? $input['autoridad_etno_territorial'] : []);

        $this->rel_autoridad_etnico_territorial_fr()->delete();

        foreach($autoridad_etno_territorial as $valor) {
            if($valor>0)
                $this->rel_autoridad_etnico_territorial_fr()->save(new persona_aut_etnico_ter(['id_aut_etnico_ter' => $valor]));
        }

    }

    public function agregarOrganizacion($datos=[]) {

        $this->rel_persona_organizacion()->delete();
        $organizacion_tipo = isset($datos['organizacion_tipo']) ? $datos['organizacion_tipo'] : [];
        $organizacion_nombre = isset($datos['organizacion_nombre']) ? $datos['organizacion_nombre'] : [];
        $organizacion_rol = isset($datos['organizacion_rol']) ? $datos['organizacion_rol'] : [];

        foreach ($organizacion_tipo as $index => $val) {

            if ($organizacion_tipo[$index] > -1 && !empty($organizacion_nombre[$index])) {
                $att = ['nombre' => $organizacion_nombre[$index], 'rol' => $organizacion_rol[$index], 'id_tipo_organizacion' => $organizacion_tipo[$index]];
                $this->rel_persona_organizacion()->save(new persona_organizacion($att));
            }

        }
    }

    public function agregarPersonaVictima($datos) {

       $victima = victima::where('id_persona', $this->id_persona)->where('id_e_ind_fvt', $this->id_e_ind_fvt)->first();

        // Si no existe la victima relacionada a esta persona
        if (is_null($victima)) {

            $victima = new victima($datos);
            $victima->completar_traza_insert();

        } else {

            $victima->id_e_ind_fvt = $datos['id_e_ind_fvt'];
            $victima->completar_traza_update();
        }

        $this->rel_persona_victima()->save($victima);

        return $victima;
    }

    public function agregarPersonaResponsable($datos) {

      $persona_responsable = persona_responsable::where('id_persona', $this->id_persona)->where('id_e_ind_fvt', $this->id_e_ind_fvt)->first();
      // $persona_responsable = persona_responsable::firstOrNew(['id_e_ind_fvt' => $datos['id_e_ind_fvt']]);

        // Si no existe la victima relacionada a esta persona
        if (is_null($persona_responsable)) {

            $persona_responsable = new persona_responsable($datos);
        } else {
            $persona_responsable->id_edad_aproximada = $datos['id_edad_aproximada'];
            $persona_responsable->id_rango_cargo = $datos['id_rango_cargo'];
            $persona_responsable->id_grupo_paramilitar = $datos['id_grupo_paramilitar'];
            $persona_responsable->id_guerrilla = $datos['id_guerrilla'];
            $persona_responsable->id_fuerza_publica = $datos['id_fuerza_publica'];
            // $persona_responsable->presunta_responsabilidad = $datos['presunta_responsabilidad'];
            $persona_responsable->nombre_superior = $datos['nombre_superior'];
            $persona_responsable->conoce_info = $datos['conoce_info'];
            $persona_responsable->que_hace = $datos['que_hace'];
            $persona_responsable->donde_esta = $datos['donde_esta'];
            $persona_responsable->otros_hechos = $datos['otros_hechos'];
            $persona_responsable->cuales = $datos['cuales'];

          }
            $this->rel_persona_responsable()->save($persona_responsable);
            return true;

    }

    // Edición del control multiple - Discapacidad
    public function getArregloDiscapacidadAttribute()
    {
        $arreglo=array();
        foreach ($this->rel_discapacidad_fr as $detalle)
        {
            $arreglo[]=$detalle->id_discapacidad;
        }
        return $arreglo;
    }

    // Edición del control multiple - Responsabilidad
    public function getfmtArregloResponsabilidadAttribute()
    {
        $arreglo=array();
        foreach ($this->rel_responsabilidad_fr as $detalle)
        {
            $arreglo[]=$detalle->id_responsabilidad;
        }
        return $arreglo;
    }

    // Edición del control multiple - Autoridad Etnico Territorial
    public function getArregloAutoridadEtnicoTerritorialAttribute()
    {
        $arreglo=array();
        foreach ($this->rel_autoridad_etnico_territorial_fr as $detalle)
        {
            $arreglo[]=$detalle->id_aut_etnico_ter;
        }
        return $arreglo;
    }

    // Edicion del control multiple - Relacion con las victimas

    public function getArregloRelacionVictimasAttribute() {

        $arreglo=array();

        $persona_entrevistada = persona_entrevistada::where('id_e_ind_fvt', '=', $this->id_e_ind_fvt)->first();

        if (!empty($persona_entrevistada))
        {
            if(isset($this->rel_persona_victima))
            {
                $relacion_con_victima = $persona_entrevistada->rel_per_ent_rel_victima()
                ->where('per_ent_rel_victima.id_victima', '=',  $this->rel_persona_victima->id_victima)->get();

                foreach($relacion_con_victima as $victima) {
                    $arreglo[]=$victima->id_rel_victima;
                }
            }
        }

        return $arreglo;
    }

    public function getNombreCompletoAttribute() {
        $pedazos=array();
        if(!empty($this->nombre)) {
            $pedazos[]=$this->nombre;
        }

        if(!empty($this->apellido)) {
            $pedazos[]=$this->apellido;
        }
        if(!empty($this->alias)) {
            $pedazos[]="($this->alias)";
        }
        //Es declarante NNAJ?
        $menor=false;
        foreach($this->rel_persona_entrevistada()->get() as $pe) {
            if($pe) {
                if($pe->edad <18 && $pe->edad>0) {
                    $menor=true;
                }
            }

        }
        if($menor) {  //Sobreescribir cualquier valor previo
            unset($pedazos);
            $pedazos[]="(menor de edad)";
        }


        if(count($pedazos)==0) {
            return "No registra nombre";
        }
        else {
            return implode(" ",$pedazos);
        }
        /*

        if(!empty($this->nombre)) {
              return $this->nombre." ".$this->apellido;
        }
        return "No registra nombre";*/
    }


    public function getEsVictimaAttribute() {

        if (!empty($this->rel_persona_entrevistada) )
            return $this->rel_persona_entrevistada->es_victima;

        return 2;
    }

    public function getEsTestigoAttribute() {

        if (!empty($this->rel_persona_entrevistada) )
            return $this->rel_persona_entrevistada->es_testigo;

        return 2;
    }

    public function existeEntrevistaIndividual(int $id_e_ind_fvt) {

        $persona = persona::where('id_e_ind_fvt', $id_e_ind_fvt)->first();

        if (is_object($persona))
            return $persona;

        return null;
    }

    public function getfmtideindfvtAttribute($id_entrevista_etnica=-1)
    {
        return entrevista_individual::codigo($this->id_e_ind_fvt);
    }

    public function getSexoAttribute() {

        if(!empty($this->rel_id_sexo)) {
            return $this->rel_id_sexo->descripcion;
        }
        return "No registra";
    }

    public function getOrientacionAttribute() {

        if(!empty($this->rel_id_orientacion)) {
            return $this->rel_id_orientacion->descripcion;
        }
        return "No registra";
    }

    public function getIdentidadAttribute() {

        if(!empty($this->rel_id_identidad)) {
            return $this->rel_id_identidad->descripcion;
        }
        return "No registra";
    }

    public function getNacionalidadAttribute() {

        if(!empty($this->rel_id_nacionalidad)) {
            return $this->rel_id_nacionalidad->descripcion;
        }
        return "No registra";
    }

    public function getOtraNacionalidadAttribute() {
        return cat_item::describir($this->id_otra_nacionalidad);
    }

    public function getEstadoCivilAttribute() {

        if(!empty($this->rel_id_estado_civil)) {
            return $this->rel_id_estado_civil->descripcion;
        }
        return "No registra";
    }

    public function getLugarNacimientoAttribute() {

        if(!empty($this->rel_id_lugar_nacimiento)) {
            return $this->rel_id_lugar_nacimiento->descripcion;
        }
        return "No registra";
    }

    public function getLugarNacimientoDeptoAttribute() {

        if(!empty($this->rel_id_lugar_nacimiento_depto)) {
            return $this->rel_id_lugar_nacimiento_depto->descripcion;
        }
        return "No registra";
    }

    public function getEtniaAttribute() {

        if(!empty($this->rel_id_etnia)) {
            return $this->rel_id_etnia->descripcion;
        }
        return "No registra";
    }

    public function getLugarResidenciaAttribute() {

        if(!empty($this->rel_id_lugar_residencia)) {
            return $this->rel_id_lugar_residencia->descripcion;
        }
        return "No registra";
    }

    public function getLugarResidenciaDeptoAttribute() {

        if(!empty($this->rel_id_lugar_residencia_depto)) {
            return $this->rel_id_lugar_residencia_depto->descripcion;
        }
        return "No registra";
    }

    public function getLugarResidenciaMuniAttribute() {

        if(!empty($this->rel_id_lugar_residencia_muni)) {
            return $this->rel_id_lugar_residencia_muni->descripcion;
        }
        return "No registra";
    }

    public function getZonaAttribute() {

        if(!empty($this->rel_id_zona)) {
            return $this->rel_id_zona->descripcion;
        }
        return "No registra";
    }


    public function getEducacionFormalAttribute() {

        if(!empty($this->rel_id_edu_formal)) {
            return $this->rel_id_edu_formal->descripcion;
        }
        return "No registra";
    }

    public function getCargoPublicoCompletoAttribute() {

        $bandera = ($this->cargo_publico == 1 ? 'Sí':'No');

        if ($bandera == 'Sí')
            return $bandera . ', ' . $this->cargo_publico_cual;

        return $bandera;
    }

    public function getFuerzaPublicaCompletoAttribute() {

        $mensaje = "";
        if(!empty($this->rel_id_fuerza_publica)) {
            $mensaje = 'Sí, ' . $this->rel_id_fuerza_publica->descripcion;

            if(!empty($this->rel_id_fuerza_publica_estado)) {
                $mensaje.= ' (' . $this->rel_id_fuerza_publica_estado->descripcion .')';
            }

            return $mensaje;
        }

        return 'No';
    }

    public function getActorArmadoCompletoAttribute() {

        if(!empty($this->rel_id_actor_armado))
            return 'Sí, ' . $this->rel_id_actor_armado->descripcion;
        return 'No';
    }

    public function getAutoridadEtnicoTerritorialAttribute() {

        $html = '';

        if($this->rel_autoridad_etnico_territorial_fr->count() > 0){
            $html.='<ul>';
                foreach ($this->rel_autoridad_etnico_territorial_fr as $item)
                    $html.='<li>' . $item->detalle->descripcion . '</li>';
            $html.='</ul>';
        }  else {
            $html.= '<p>No es autoridad étnico-territorial</p>';
        }

        return $html;
    }

    public function getRelacionConVictimasAttribute() {

        $html = '';

        $persona_entrevistada = persona_entrevistada::where('id_e_ind_fvt', '=', $this->id_e_ind_fvt)->first();

        if (!empty($persona_entrevistada))
        {
            if(isset($this->rel_persona_victima))
            {
                $relacion_con_victima = $persona_entrevistada->rel_per_ent_rel_victima()
                ->where('per_ent_rel_victima.id_victima', '=',  $this->rel_persona_victima->id_victima)->get();

                if ($relacion_con_victima->count() > 0)
                {
                    foreach($relacion_con_victima as $victima) {
                        $html.='<ul>';
                            $html.='<li>' . $victima->detalle->descripcion . '</li>';
                        $html.='</ul>';
                    }
                } elseif ($persona_entrevistada->id_persona == $this->id_persona) {
                    $html.= '<p>Es la misma persona entrevistada.</p>';
                } else {
                    $html.= '<p>No registra relación con la persona entrevistada.</p>';
                }
            }
        }
        else
        {
            $html.= '<p>No registra relación con la persona entrevistada.</p>';
        }

        return $html;
    }

    public function getOrganizacionColectivoCompletoAttribute() {

        $html = '';
        $bandera = ($this->organizacion_colectivo == 1 ? 'Sí':'No');

        if ($bandera == 'Sí') {
            $html.= $bandera . ', participó de las siguientes organizaciones:';
            $html.='<ul>';
                foreach ($this->rel_persona_organizacion as $organizacion)
                $html.='<li>' . $organizacion->nombre . '(' . $organizacion->detalle->descripcion . '/' . $organizacion->rol .')</li>';

            $html.='</ul>';
        }
        else
            $html.= $bandera;

        return $html;
    }

    public function getDiscapacidadAttribute() {

        $html = '';

        if($this->rel_discapacidad_fr->count() > 0){
            $html.='<ul>';
                foreach ($this->rel_discapacidad_fr as $item)
                    $html.='<li>' . $item->detalle->descripcion . '</li>';
            $html.='</ul>';
        } else {
            $html.= '<p>No</p>';
        }

        return $html;
    }

    public function getfmtResponsabilidadAttribute()
    {

        $asignaciones = persona_responsable::where('id_persona', $this->id_persona)->get();

        $a_responsabilidades = array();
        foreach ($asignaciones as $persona_responsable) {
            foreach ($persona_responsable->rel_responsabilidad as $responsabilidad) {
                $a_responsabilidades[] = $responsabilidad->id_responsabilidad;
            }
        }

        $html = '';
        if(count($a_responsabilidades) > 0 ) {
            $html.='<ul>' ;
            foreach($a_responsabilidades as $tmp) {
                $html.="<li>".cat_item::describir($tmp)."</li>";
            }
            $html.='</ul>';
        }
        else {
            $html.= '<p>No.</p>';
        }




        return $html;
    }


    public function guardarInformacionParticular(persona $persona, $parametros=[]) {

        $persona_entrevistada = persona_entrevistada::firstOrNew(['id_e_ind_fvt' => $parametros['id_e_ind_fvt']]);
        $persona_entrevistada->es_victima = $parametros['es_victima'];
        $persona_entrevistada->es_testigo = $parametros['es_testigo'];
        $persona_entrevistada->sintesis_relato = $parametros['sintesis_relato'];

        if ($persona_entrevistada->id_persona_entrevistada == "")
        {
            $persona_entrevistada->completar_traza_insert();
        }
        else
        {
            $persona_entrevistada->completar_traza_update();
        }


        $pe = $persona->rel_persona_entrevistada()->save($persona_entrevistada);
        $pe->edad = $pe->calcular_edad();
        $pe->save();

        if (isset($parametros['id_rel_victima'])) {

            $persona_entrevistada->setRelacionVictima($parametros['id_rel_victima']);

            if ($persona->rel_persona_entrevistada()->save($persona_entrevistada)) {

                $persona_entrevistada->agregarRelacionConLaVictima();
            }
        }

        $persona->agregarCondicionDiscapacidad($parametros);

        $persona->agregarAutoridadEtnicoTerritorial($parametros);

        // La persona entrevistada indica que participa en alguna organizacion

        if ($parametros['organizacion_colectivo'] == 1) {
            $persona->agregarOrganizacion($parametros);
        } else {
            $persona->rel_persona_organizacion()->delete();
        }

        // si en el formulario indica que es una víctima crea el registro en la tabla victima
        if ($parametros['es_victima']==1)
            $persona->agregarPersonaVictima($parametros);
        else {
            $victima = victima::where('id_persona', $persona->id_persona)->where('id_e_ind_fvt', $persona->id_e_ind_fvt)->first();
            if (is_object($victima))
                $victima->delete();
        }


    }


    public function getFmtIdLugarNacimientoAttribute() {
        return geo::nombre_completo($this->id_lugar_nacimiento);
    }

    //Para editar el lugar de residencia
    public function halar_id_lugar_residencia() {
        $lugar=null;
        if($this->id_lugar_residencia>0) {
            $lugar = $this->id_lugar_residencia;
        }
        elseif($this->id_lugar_residencia_muni >0) {
            $lugar = $this->id_lugar_residencia_muni;
        }
        elseif($this->id_lugar_residencia_depto >0) {
            $lugar = $this->id_lugar_residencia_depto;
        }
        return $lugar;
    }

    public static function iniciar_variables_a_null($input = []) {

        foreach ($input as $key => $value) {
            if ($value=='-1') {
                 $input[$key] = null;
            }
        }

        if(isset($input['id_lugar_residencia']) && isset($input['id_lugar_residencia_muni']) && isset($input['id_lugar_residencia+depto'])) {
            if ($input['id_lugar_residencia']==null) {

                if ($input['id_lugar_residencia_muni'] != null && $input['id_lugar_residencia_muni']>0) {

                    $input['id_lugar_residencia'] = $input['id_lugar_residencia_muni'];

                } elseif ($input['id_lugar_residencia_depto'] != null && $input['id_lugar_residencia_depto']>0) {

                    $input['id_lugar_residencia'] = $input['id_lugar_residencia_depto'];
                }
            }
        }



        return $input;
    }

    public function guardar_datos_responsable($request) {

      persona_responsable::where("id_e_ind_fvt",$request->id_e_ind_fvt)->where("id_persona",$this->id_persona)->delete();

      $input = $request->all();

      $nuevo = new persona_responsable();
      $nuevo->fill($input);

      $nuevo->id_persona = $this->id_persona;

      $nuevo->insert_ent = \Auth::user()->id_entrevistador;
      $nuevo->insert_fh = \Carbon\Carbon::now();
      $nuevo->insert_ip = \Request::ip();




      $nuevo->save();

      //Procesar la Responsabilidad
      $nuevo->grabar_responsabilidades($request->presunta_responsabilidad);
      return $nuevo;
    }

    public function actualizar_datos_responsable($request) {
      $input = $request->all();


      $actualiza = persona_responsable::where("id_e_ind_fvt",$request->id_e_ind_fvt)->where("id_persona",$this->id_persona)->first();

      //$actualiza = new persona_responsable();
      $actualiza->fill($input);

       $actualiza->id_persona = $this->id_persona;

        $actualiza->update_ent = \Auth::user()->id_entrevistador;
        $actualiza->update_fh = \Carbon\Carbon::now();
        $actualiza->update_ip = \Request::ip();



              $actualiza->update();

      //Procesar la Responsabilidad
      $actualiza->grabar_responsabilidades($request->presunta_responsabilidad);
      return $actualiza;
    }

    public static function listar_responsables_entrevista($id_e_ind_fvt)
    {
      $listado=persona::join("fichas.persona_responsable","persona.id_persona","=","persona_responsable.id_persona")
                        ->where("persona_responsable.id_e_ind_fvt","=",$id_e_ind_fvt)->get();
      return $listado;
    }

    public static function listar_responsables_entrevista_etnica($id_entrevista_etnica) {

        $listado=persona::join("fichas.persona_responsable","persona.id_persona","=","persona_responsable.id_persona")
                            ->where("persona_responsable.id_entrevista_etnica","=",$id_entrevista_etnica)->get();

        return $listado;
    }

    //Hechos en los que ha participado
    public function getResponsableHechosAttribute() {
        return persona::join("fichas.persona_responsable","persona.id_persona","=","persona_responsable.id_persona")
                                    ->where("persona_responsable.id_persona","=",$this->id_persona)
                                    ->join('fichas.hecho_responsable','persona_responsable.id_persona_responsable','=','hecho_responsable.id_persona_responsable')
                                    ->select(\DB::raw('hecho_responsable.*'))
                                    ->get();
    }



    public function valores_iniciales()
    {
        $this->id_edad_aproximada=-1;
        $this->id_rango_cargo=-1;
        $this->id_etnia=-1;
    }

    public static function listar_victimas_entrevista($id_e_ind_fvt)
    {
      $listado=persona::join("fichas.victima","persona.id_persona","=","victima.id_persona")
                        ->where("victima.id_e_ind_fvt","=",$id_e_ind_fvt)->orderBy('persona.nombre')->get();
      return $listado;
    }

    public static function personas_vinculadas_a_duplicado(int $id_e_inv_fvt_nueva)
    {
        return persona::join('fichas.victima', 'persona.id_persona', '=', 'victima.id_persona')
                    ->join('fichas.victima_duplicada', 'victima_duplicada.id_victima', '=', 'victima.id_victima')
                    ->where('victima_duplicada.id_e_inv_fvt_nueva', '=',  $id_e_inv_fvt_nueva)
                    ->where('victima_duplicada.estado', '=',  true)
                    ->get(['persona.nombre',
                            'persona.apellido',
                            'persona.id_tipo_documento',
                            'persona.num_documento',
                            'persona.alias',
                            'persona.id_sexo',
                            'victima.id_victima',
                            'victima.id_e_ind_fvt',
                            'persona.id_persona',
                            'victima_duplicada.estado',
                            'victima.id_e_ind_fvt']);
    }

    public function getfmtEsPersonaEntrevistadaAttribute()
    {
        $persona_entrevistada = persona_entrevistada::where('id_e_ind_fvt', '=', $this->id_e_ind_fvt)->first();

        if (!empty($persona_entrevistada))
        {
            if(isset($this->rel_persona_victima))
            {
                $relacion_con_victima = $persona_entrevistada->rel_per_ent_rel_victima()
                ->where('per_ent_rel_victima.id_victima', '=',  $this->rel_persona_victima->id_victima)->get();

                if ($relacion_con_victima->count() > 0)  return false;
                else if ($persona_entrevistada->id_persona == $this->id_persona) return true;
                else return false;

            } else return false;

        }

        return false;
    }

    public function getfmtSintesisDelRelatoAttribute()
    {
        if (empty($this->sintesis_relato)) {
            return "No redacta síntesis";
        }

        return $this->sintesis_relato;
    }

    public function completar_traza_insert() {
        $this->insert_ent = \Auth::user()->rel_entrevistador->id_entrevistador;
        $this->insert_fh = \Carbon\Carbon::now();
        $this->insert_ip = \Request::ip();
        $this->save();
    }

    public function completar_traza_update() {
        $this->update_ent = \Auth::user()->rel_entrevistador->id_entrevistador;
        $this->update_fh = \Carbon\Carbon::now();
        $this->update_ip = \Request::ip();
        $this->save();
    }


    public static function criterios_default($request=null) {
        $criterio = new \stdClass();
        $criterio->nombre="";
        $criterio->apellido="";
        $criterio->id_sexo=-1;
        $criterio->organizacion_nombre="";
        $criterio->es_victima=false;
        $criterio->es_entrevistado=false;
        $criterio->id_orientacion=-1;
        $criterio->id_identidad=-1;
        $criterio->id_etnia=-1;
        $criterio->id_tipo_documento=-1;
        $criterio->id_nacionalidad=-1;
        $criterio->id_otra_nacionalidad=-1;
        $criterio->id_zona=-1;
        $criterio->id_edu_formal=-1;
        $criterio->cargo_publico=-1;
        $criterio->id_fuerza_publica=-1;
        $criterio->id_actor_armado=-1;
        $criterio->alias="";
        $criterio->fec_nac=-1;
        $criterio->fec_nac_d=-1;
        $criterio->fec_nac_m=-1;
        $criterio->fec_nac_a=-1;
        $criterio->id_lugar_nacimiento_depto=-1;
        $criterio->id_lugar_nacimiento=-1;
        $criterio->num_documento="";
        $criterio->id_estado_civil=-1;
        $criterio->id_lugar_residencia_depto=-1;
        $criterio->id_lugar_residencia_muni=-1;
        $criterio->id_lugar_residencia=-1;
        $criterio->correo_electronico="";
        $criterio->profesion="";
        $criterio->ocupacion_actual="";
        $criterio->cargo_publico=-1;
        $criterio->id_fuerza_publica_estado=-1;
        $criterio->id_etnia_indigena=-1;
        $criterio->discapacidad=[];

        //
        if(is_object($request)) {
            $criterio->nombre = isset($request->nombre) ? $request->nombre : $criterio->nombre;
            $criterio->apellido = isset($request->apellido) ? $request->apellido : $criterio->apellido;
            $criterio->id_sexo = isset($request->id_sexo) ? $request->id_sexo : $criterio->id_sexo;
            $criterio->id_orientacion = isset($request->id_orientacion) ? $request->id_orientacion : $criterio->id_orientacion;
            $criterio->id_identidad = isset($request->id_identidad) ? $request->id_identidad : $criterio->id_identidad;
            $criterio->id_etnia = isset($request->id_etnia) ? $request->id_etnia : $criterio->id_etnia;
            $criterio->id_tipo_documento = isset($request->id_tipo_documento) ? $request->id_tipo_documento : $criterio->id_tipo_documento;
            $criterio->id_nacionalidad = isset($request->id_nacionalidad) ? $request->id_nacionalidad : $criterio->id_nacionalidad;
            $criterio->id_otra_nacionalidad = isset($request->id_otra_nacionalidad) ? $request->id_otra_nacionalidad : $criterio->id_otra_nacionalidad;
            $criterio->id_zona = isset($request->id_zona) ? $request->id_zona : $criterio->id_zona;
            $criterio->id_edu_formal = isset($request->id_edu_formal) ? $request->id_edu_formal : $criterio->id_edu_formal;
            $criterio->cargo_publico = isset($request->cargo_publico) ? $request->cargo_publico: $criterio->cargo_publico;
            $criterio->id_fuerza_publica = isset($request->id_fuerza_publica) ? $request->id_fuerza_publica : $criterio->id_fuerza_publica;
            $criterio->id_actor_armado = isset($request->id_actor_armado) ? $request->id_actor_armado : $criterio->id_actor_armado;
            $criterio->organizacion_nombre = isset($request->organizacion_nombre) ? $request->organizacion_nombre : $criterio->organizacion_nombre;
            $criterio->alias = isset($request->alias) ? $request->alias : $criterio->alias;
            $criterio->fec_nac_d = ($request->fec_nac_d > -1) ? $request->fec_nac_d : $criterio->fec_nac_d;
            $criterio->fec_nac_m = ($request->fec_nac_m > -1 ) ? $request->fec_nac_m : $criterio->fec_nac_m;
            $criterio->fec_nac_a = ($request->fec_nac_a > -1) ? $request->fec_nac_a : $criterio->fec_nac_a;
            $criterio->fec_nac = ($request->fec_nac > -1) ? $request->fec_nac : $criterio->fec_nac;
            $criterio->id_lugar_nacimiento_depto = isset($request->id_lugar_nacimiento_depto) ? $request->id_lugar_nacimiento_depto : $criterio->id_lugar_nacimiento_depto;
            $criterio->id_lugar_nacimiento = isset($request->id_lugar_nacimiento) ? $request->id_lugar_nacimiento : $criterio->id_lugar_nacimiento;
            $criterio->num_documento = isset($request->num_documento) ? $request->num_documento : $criterio->num_documento;
            $criterio->id_estado_civil = isset($request->id_estado_civil) ? $request->id_estado_civil : $criterio->id_estado_civil;
            $criterio->id_lugar_residencia_depto = isset($request->id_lugar_residencia_depto) ? $request->id_lugar_residencia_depto : $criterio->id_lugar_residencia_depto;
            $criterio->id_lugar_residencia_muni = isset($request->id_lugar_residencia_muni) ? $request->id_lugar_residencia_muni : $criterio->id_lugar_residencia_muni;
            $criterio->id_lugar_residencia = isset($request->id_lugar_residencia) ? $request->id_lugar_residencia : $criterio->id_lugar_residencia;
            $criterio->correo_electronico = isset($request->correo_electronico) ? $request->correo_electronico : $criterio->correo_electronico;
            $criterio->profesion = isset($request->profesion) ? $request->profesion : $criterio->profesion;
            $criterio->ocupacion_actual = isset($request->ocupacion_actual) ? $request->ocupacion_actual : $criterio->ocupacion_actual;
            $criterio->cargo_publico = isset($request->cargo_publico) ? $request->cargo_publico : $criterio->cargo_publico;
            $criterio->id_fuerza_publica_estado = isset($request->id_fuerza_publica_estado) ? $request->id_fuerza_publica_estado : $criterio->id_fuerza_publica_estado;
            $criterio->id_etnia_indigena = isset($request->id_etnia_indigena) ? $request->id_etnia_indigena : $criterio->id_etnia_indigena;
            $criterio->discapacidad = isset($request->discapacidad) ? $request->discapacidad : $criterio->discapacidad;


            $criterio->es_victima = isset($request->es_victima);
            $criterio->es_entrevistado = isset($request->es_entrevistado);
        }

        return $criterio;

    }


    //Logica de la busqueda
    public static function scopeNombre($query, $texto='') {
        //$texto = persona::sustituir_tildes($texto);
        $texto = trim($texto);
        if(strlen($texto)>0) {
            $query->where('nombre','ilike',"%$texto%");
            // $query->whereRaw(\DB::raw("translate(lower(nombre), 'áéíóú', 'aeiou') ilike '%$texto%'"));
        }

    }
    public static function scopeApellido($query,$texto='') {
        //$texto = persona::sustituir_tildes($texto);
        $texto = trim($texto);
        if(strlen($texto)>0) {
            $query->where('apellido', 'ilike', "%$texto%");
            //$query->whereRaw(\DB::raw("translate(lower(apellido), 'áéíóú', 'aeiou') ilike '%$texto%'"));
        }
    }


    public static function scopeAlias($query,$texto='') {
        //$texto = persona::sustituir_tildes($texto);
        $texto = trim($texto);
        if(strlen($texto)>0) {
            $query->where('alias', 'ilike', "%$texto%");
            //$query->whereRaw(\DB::raw("translate(lower(alias), 'áéíóú', 'aeiou') ilike '%$texto%'"));
        }
    }

    public static function scopeId_sexo($query,$id_sexo=-1) {
        if($id_sexo==0) {
            $query->wherenull('id_sexo');
        }
        elseif($id_sexo > 0) {
            $query->where('id_sexo','=',$id_sexo);
        }
    }

    // Orientacion sexual
    public static function scopeId_orientacion($query, $id_orientacion=-1) {

        if ($id_orientacion == 0) {
            $query->wherenull('id_orientacion');
        } elseif ($id_orientacion > 0) {
            $query->where('id_orientacion', '=', $id_orientacion);
        }
    }

    // Identidad de género
    public static function scopeId_identidad($query, $id_identidad=-1) {

        if ($id_identidad == 0) {
            $query->wherenull('id_identidad');
        } elseif ($id_identidad > 0) {
            $query->where('id_identidad', '=', $id_identidad);
        }
    }

    //pertenencia etnico-racial
    public static function scopeId_etnia($query, $id_etnia=-1) {

        if ($id_etnia == 0) {
            $query->wherenull('id_etnia');
        } elseif ($id_etnia > 0) {
            $query->where('id_etnia', '=', $id_etnia);
        }
    }

    // Tipo de documento
    public static function scopeId_tipo_documento($query, $id_tipo_documento=-1) {

        if ($id_tipo_documento == 0) {
            $query->wherenull('id_tipo_documento');
        } elseif ($id_tipo_documento > 0) {
            $query->where('id_tipo_documento', '=', $id_tipo_documento);
        }
    }

    // Nacionalidad
    public static function scopeId_nacionalidad($query, $id_nacionalidad=-1) {

        if ($id_nacionalidad == 0) {
            $query->wherenull('id_nacionalidad');
        } elseif ($id_nacionalidad > 0) {
            $query->where('id_nacionalidad', '=', $id_nacionalidad);
        }
    }

    // Otra nacionalidad
    public static function scopeId_otra_nacionalidad($query, $id_otra_nacionalidad=-1) {

        if ($id_otra_nacionalidad == 0) {
            $query->wherenull('id_otra_nacionalidad');
        } elseif ($id_otra_nacionalidad > 0) {
            $query->where('id_otra_nacionalidad', '=', $id_otra_nacionalidad);
        }
    }

    // Zona
    public static function scopeId_zona($query, $id_zona) {

        if ($id_zona == 0) {
            $query->wherenull('id_zona');
        } elseif ($id_zona > 0) {
            $query->where('id_zona', '=', $id_zona);
        }
    }

    // Educacion formal
    public static function scopeId_edu_formal($query, $id_edu_formal=-1) {

        if ($id_edu_formal == 0) {
            $query->wherenull('id_edu_formal');
        } elseif ($id_edu_formal > 0) {
            $query->where('id_edu_formal', '=', $id_edu_formal);
        }
    }

    // Ejerce cargo público
    public static function scopeId_cargo_publico($query, $cargo_publico=-1) {

        if ($cargo_publico == 0) {
            $query->wherenull('cargo_publico');
        } elseif ($cargo_publico > 0) {
            $query->where('cargo_publico', '=', $cargo_publico);
        }
    }

    // Estado cargo publico
    public static function scopeId_fuerza_publica($query, $id_fuerza_publica=-1) {

        if ($id_fuerza_publica == 0) {
            $query->wherenull('id_fuerza_publica');
        } elseif ($id_fuerza_publica > 0) {
            $query->where('id_fuerza_publica', '=', $id_fuerza_publica);
        }
    }

    // Fue miembro de un actor armado ilegal
    public static function scopeId_actor_armado($query, $id_actor_armado=-1) {

        if ($id_actor_armado == 0) {
            $query->wherenull('id_actor_armado');
        } elseif ($id_actor_armado > 0) {
            $query->where('id_actor_armado', '=', $id_actor_armado);
        }
    }

    // Participa en alguna organizacion
    public static function  scopeId_organizacion_colectivo($query, $organizacion_colectivo=-1) {

        if ($organizacion_colectivo == 0) {
            $query->wherenull('organizacion_colectivo');
        } elseif ($organizacion_colectivo > 0) {
            $query->where('organizacion_colectivo', '=', $organizacion_colectivo);
        }
    }

    // Condicion de discapacidad
    public static function scopeCondicion_discapacidad($query, $discapacidad=[]) {

        if(sizeof($discapacidad) > 0) {
            $query->join('fichas.persona_discapacidad as fpd','persona.id_persona','=','fpd.id_persona')
                    ->whereIn('fpd.id_discapacidad', $discapacidad);

        }
    }

    // dia fecha nacimiento
    public static function scopeFec_nac_d($query, $fec_nac_d=-1) {
        if($fec_nac_d>0) {
            $query->where('fec_nac_d', '=', $fec_nac_d);
        }
    }

    // mes fecha nacimiento
    public static function scopeFec_nac_m($query, $fec_nac_m=-1) {
        if($fec_nac_m>0) {
            $query->where('fec_nac_m', '=', $fec_nac_m);
        }
    }

    // año fecha nacimiento
    public static function scopeFec_nac_a($query, $fec_nac_a=-1) {
        if($fec_nac_a>0) {
            $query->where('fec_nac_a', '=', $fec_nac_a);
        }
    }

    // departamento de nacimiento
    public static function scopeId_lugar_nacimiento_depto($query, $id_lugar_nacimiento_depto=-1) {

        if ($id_lugar_nacimiento_depto == 0) {
            $query->wherenull('id_lugar_nacimiento_depto');
        } elseif ($id_lugar_nacimiento_depto > 0) {
            $query->where('id_lugar_nacimiento_depto', '=', $id_lugar_nacimiento_depto);
        }
    }

    // Municipio de nacimiento
    public static function scopeId_lugar_nacimiento($query, $id_lugar_nacimiento=-1) {

        if ($id_lugar_nacimiento == 0) {
            $query->wherenull('id_lugar_nacimiento');
        } elseif ($id_lugar_nacimiento > 0) {
            $query->where('id_lugar_nacimiento', '=', $id_lugar_nacimiento);
        }
    }

    // numero documento
    public static function scopeNum_documento($query, $texto='') {
        //$texto = persona::sustituir_tildes($texto);
        $texto = trim($texto);
        if(strlen($texto)>0) {
            $query->where('num_documento','ilike',$texto);
            //$query->whereRaw(\DB::raw("translate(lower(num_documento), 'áéíóú', 'aeiou') like '%$texto%'"));
        }
    }

    // Estado civil
    public static function scopeId_estado_civil($query, $id_estado_civil=-1) {

        if ($id_estado_civil == 0) {
            $query->wherenull('id_estado_civil');
        } elseif ($id_estado_civil > 0) {
            $query->where('id_estado_civil', '=', $id_estado_civil);
        }
    }

    // Departamento de residencia
    public static function scopeId_lugar_residencia_depto($query, $id_lugar_residencia_depto=-1) {
        if ($id_lugar_residencia_depto == 0) {
            $query->wherenull('id_lugar_residencia_depto');
        } elseif ($id_lugar_residencia_depto > 0) {
            $query->where('id_lugar_residencia_depto', '=', $id_lugar_residencia_depto);
        }
    }

    // Municipio de residencia
    public static function scopeId_lugar_residencia_muni($query, $id_lugar_residencia_muni=-1) {
        if ($id_lugar_residencia_muni == 0) {
            $query->wherenull('id_lugar_residencia_muni');
        } elseif ($id_lugar_residencia_muni > 0) {
            $query->where('id_lugar_residencia_muni', '=', $id_lugar_residencia_muni);
        }
    }

    // Vereda/corregimiento/etc de residencia
    public static function scopeId_lugar_residencia($query, $id_lugar_residencia=-1) {
        if ($id_lugar_residencia == 0) {
            $query->wherenull('id_lugar_residencia');
        } elseif ($id_lugar_residencia > 0) {
            $query->where('id_lugar_residencia', '=', $id_lugar_residencia);
        }
    }

    // correo_electronico
    public static function scopeCorreo_electronico($query, $texto='') {
        //$texto = persona::sustituir_tildes($texto);
        $texto = trim($texto);
        if(strlen($texto)>0) {
            $query->where('correo_electronico','=',$texto);
        }
    }

    // profesion
    public static function scopeProfesion($query, $texto='') {
        //$texto = persona::sustituir_tildes($texto);
        $texto = trim($texto);
        if(strlen($texto)>0) {
            $query->where('profesion','ilike',"%$texto%");
            //$query->whereRaw(\DB::raw("translate(lower(profesion), 'áéíóú', 'aeiou') like '%$texto%'"));
        }
    }

    // ocupacion_actual
    public static function scopeOcupacion_actual($query, $texto='') {
        // $texto = persona::sustituir_tildes($texto);
        $texto = trim($texto);
        if(strlen($texto)>0) {
            $query->where('ocupacion_actual','ilike',"%$texto%");
            //$query->whereRaw(\DB::raw("translate(lower(ocupacion_actual), 'áéíóú', 'aeiou') like '%$texto%'"));
        }
    }

    // Estado si pertenece a fuerza publica
    public static function scopeId_fuerza_publica_estado($query, $id_fuerza_publica_estado=-1) {
        if ($id_fuerza_publica_estado == 0) {
            $query->wherenull('id_fuerza_publica_estado');
        } elseif ($id_fuerza_publica_estado > 0) {
            $query->where('id_fuerza_publica_estado', '=', $id_fuerza_publica_estado);
        }
    }

    // Cuál étnia indígena -
    public static function scopeId_etnia_indigena($query, $id_etnia_indigena=-1) {
        if ($id_etnia_indigena == 0) {
            $query->wherenull('id_etnia_indigena');
        } elseif ($id_etnia_indigena > 0) {
            $query->where('id_etnia_indigena', '=', $id_etnia_indigena);
        }
    }

    //Aplicar permisos
    public static function scopeVictima_permitidos($query) {
        $query->join('fichas.victima as fil_per_v','persona.id_persona','=','fil_per_v.id_persona')
                ->join('esclarecimiento.e_ind_fvt as fil_per','fil_per_v.id_e_ind_fvt','=','fil_per.id_e_ind_fvt')
                ->wherein('fil_per.id_entrevistador',entrevistador::permitidos_acceso_entrevistas());
        //$query->wherein()
    }

    public static function scopeBuscar($query,$persona) {
        $query->nombre($persona->nombre)
              ->apellido($persona->apellido)
              ->id_sexo($persona->id_sexo)
              ->organizacion_nombre($persona->organizacion_nombre)
              ->es_entrevistado($persona->es_entrevistado)
              ->es_victima($persona->es_victima)
              ->id_orientacion($persona->id_orientacion)
              ->id_identidad($persona->id_identidad)
              ->id_etnia($persona->id_etnia)
              ->id_tipo_documento($persona->id_tipo_documento)
              ->id_nacionalidad($persona->id_nacionalidad)
              ->id_zona($persona->id_zona)
              ->id_edu_formal($persona->id_edu_formal)
              ->id_cargo_publico($persona->cargo_publico)
              ->id_fuerza_publica($persona->id_fuerza_publica)
              ->id_actor_armado($persona->id_actor_armado)
              ->fec_nac_d($persona->fec_nac_d)
              ->fec_nac_m($persona->fec_nac_m)
              ->fec_nac_a($persona->fec_nac_a)
              ->id_lugar_nacimiento_depto($persona->id_lugar_nacimiento_depto)
              ->id_lugar_nacimiento($persona->id_lugar_nacimiento)
              ->num_documento($persona->num_documento)
              ->id_otra_nacionalidad($persona->id_otra_nacionalidad)
              ->id_estado_civil($persona->id_estado_civil)
              ->id_lugar_residencia_depto($persona->id_lugar_residencia_depto)
              ->id_lugar_residencia_muni($persona->id_lugar_residencia_muni)
              ->correo_electronico($persona->correo_electronico)
              ->profesion($persona->profesion)
              ->ocupacion_actual($persona->ocupacion_actual)
              ->id_fuerza_publica_estado($persona->id_fuerza_publica_estado)
              ->alias($persona->alias)
              ->condicion_discapacidad($persona->discapacidad)
                ->victima_permitidos();

    }

    public static function scopeOrdenar($query) {
        $query->orderby('persona.nombre')->orderby('persona.apellido');
    }


    public static function scopeOrganizacion_nombre($query, $texto) {
        $texto = persona::sustituir_tildes($texto);
        if(strlen($texto)>0) {
            $query->join('fichas.persona_organizacion as fpo','persona.id_persona','=','fpo.id_persona')
                    //->where('fpo.nombre','ilike',"%$texto%");
                    ->whereRaw(\DB::raw("translate(lower(fpo.nombre), 'áéíóú', 'aeiou') ilike '%$texto%'"));

        }
    }

    public static function scopeEs_Victima($query,$criterio=false) {
        if($criterio) {
            $query->join('fichas.victima as fv','persona.id_persona','=','fv.id_persona');
        }
    }
    public static function scopeEs_Entrevistado($query,$criterio=false) {
        if($criterio) {
            $query->join('fichas.persona_entrevistada as fpe','persona.id_persona','=','fpe.id_persona');
        }
    }

    public static function sustituir_tildes($texto="") {
        $texto = trim($texto);
        $texto = str_replace('á', 'a', $texto);
        $texto = str_replace('é', 'e', $texto);
        $texto = str_replace('í', 'i', $texto);
        $texto = str_replace('ó', 'o', $texto);
        $texto = str_replace('ú', 'u', $texto);
        $texto = str_replace('Á', 'A', $texto);
        $texto = str_replace('É', 'E', $texto);
        $texto = str_replace('Í', 'I', $texto);
        $texto = str_replace('Ó', 'O', $texto);
        $texto = str_replace('Ú', 'U', $texto);

        $texto = strtolower($texto);

        return $texto;
    }

    //\App\Models\persona::buscar($criterio)->select(\DB::raw('id_sexo, count(1) as conteo'))->groupby('id_sexo')->get()

    public static function sustituye() {
        $arreglo[0]['id_catalogo']=24;
        $arreglo[0]['tabla']='fichas.persona';
        $arreglo[0]['campo']='id_sexo';

        $queries=array();
        foreach($arreglo as $fila) {
            $queries[] = "update ".$fila['tabla']. " set ". $fila['campo']. " = ".  $fila['campo']." where ".  $fila['campo']. " = ".  $fila['campo'];
        }

        foreach($queries as $q) {
            echo $q;
            \DB::raw($q);
        }

        return $queries;
    }

    //Recibe una fecha yyyy-mm-dd que puede ser incompleta
    public function calcular_edad($referencia='') {
        $edad=-99;
        if($this->fec_nac_a > 0) {
            try {
                //Si ambas son fechas completas, calcular edad exacta
                $fecha = str_pad($this->fec_nac_a,4,"0",STR_PAD_LEFT);
                if($this->fec_nac_m > 0) {
                    $fecha.= "-".str_pad($this->fec_nac_m,2,"0",STR_PAD_LEFT);
                    if($this->fec_nac_d > 0) {
                        $fecha.= "-".str_pad($this->fec_nac_d,2,"0",STR_PAD_LEFT);
                    }
                }

                $f_nac = Carbon::createFromFormat("Y-m-d",$fecha);
                //dd($f_nac);
                $f_relativa = Carbon::createFromFormat("Y-m-d",$referencia);
                //dd($f_relativa);
                $edad = $f_nac->diffInYears($f_relativa);
            }
            catch (\Exception $e) {
                $a2 = (integer)substr($referencia,0,4);
                $a1 = $this->fec_nac_a;
                //echo "a1:$a2 - $a2:$a2";
                if($a1 > 1900 && $a2 > 1900) {
                    $edad = $a2-$a1;
                }
            }
        }


        return $edad;
    }
    //Actualizar edad del declarante

    //AutoFill
    public static function listar_opciones_campo($campo,$criterio="") {
        $criterio=trim($criterio);
        $criterio = str_replace(" ","%",$criterio);
        $opciones= self::where($campo,'ilike',"%$criterio%")->distinct()->limit(30)->orderby($campo)->pluck($campo)->toArray();
        return $opciones;
    }

    //Homologar campos abiertos
    public static function listado_respuestas($id_campo=1,$fecha="2019-01-01") {
        $campo[1] = "fuerza_publica_especificar";
        $campo[2] = "actor_armado_especificar";
        $campo[3] = "cargo_publico_cual";
        $campo[4] = "nombre";
        $fecha.=" 00:00:00";

        if(in_array($id_campo,[1,2,3])) {
                $listado=persona::wherenotnull($campo[$id_campo])
                                ->orderby($campo[$id_campo])
                                ->selectraw(\DB::raw('distinct '.$campo[$id_campo]. ' as campo, count(1) as conteo'))
                                ->groupby($campo[$id_campo])
                                ->where('created_at','>=',$fecha)
                                ->paginate(50);
        }
        elseif(in_array($id_campo,[4])) {
            $listado=persona_organizacion::wherenotnull($campo[$id_campo])
                ->orderby($campo[$id_campo])
                ->selectraw(\DB::raw('distinct '.$campo[$id_campo]. ' as campo, count(1) as conteo'))
                ->groupby($campo[$id_campo])
                ->where('created_at','>=',$fecha)
                ->paginate(50);
        }
        else {
            return false;
        }
        return $listado;
    }
    public static function listar_rutas_ajax_homologar($id_campo) {
        $ruta[1]='autofill/persona_fuerza_publica';
        $ruta[2]='autofill/persona_actor_armado';
        $ruta[3]='autofill/persona_cargo_publico';
        $ruta[4]='autofill/persona_nombre_organizacion';
        return isset($ruta[$id_campo]) ? $ruta[$id_campo] : false;
    }

    //Recibe el post del formulario
    public static function aplicar_homologacion($id_campo, $request) {
        $nuevo= $request->nuevo;
        $viejo= $request->antiguo;
        $campo[1] = "fuerza_publica_especificar";
        $campo[2] = "actor_armado_especificar";
        $campo[3] = "cargo_publico_cual";
        $campo[4] = "nombre";
        $cual_campo = $campo[$id_campo];
        if(in_array($id_campo,[1,2,3])) {
            $conteo=persona::where($cual_campo,$viejo)
                            ->update([$cual_campo=>$nuevo]);
        }
        elseif(in_array($id_campo,[4])) {
            $conteo=persona_organizacion::where($cual_campo,$viejo)
                            ->update([$cual_campo=>$nuevo]);

        }
        else {
            return 0;
        }
        return $conteo;



    }

    public static function calcular_grupo_etario($edad=null) {
        $nivel=0;
        $a_niveles[0]="Desconocido";
        $a_niveles[1]="NNA (0-17)";
        $a_niveles[2]="Joven (18-26)";
        $a_niveles[3]="Adulto (27-59)";
        $a_niveles[4]="Persona mayor (60 en adelante)";
        if(is_null($edad)) {
            $nivel=0;
        }
        elseif($edad < 0) {
            $nivel=0;
        }
        elseif(empty($edad)) {
            $nivel=0;
        }
        elseif($edad>=0 and $edad<=17) {
            $nivel=1;
        }
        elseif($edad>=18 and $edad<=26) {
            $nivel=2;
        }
        elseif($edad>=27 and $edad <=59) {
            $nivel=3;
        }
        elseif($edad>=60) {
            $nivel=4;
        }
        else {
             return "Edad: $edad";
        }
        return $a_niveles[$nivel];
    }

    //Funciones para evitar valores inválidos
    public function setFecNacAAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['fec_nac_a']=$val;
    }
    public function setFecNacMAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['fec_nac_m']=$val;
    }
    public function setFecNacDAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['fec_nac_d']=$val;
    }
    public function setIdLugarNacimientoAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_lugar_nacimiento']=$val;
    }
    public function setIdSexoAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_sexo']=$val;
    }
    public function setIdOrientacionAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_orientacion']=$val;
    }
    public function setIdIdentidadAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_identidad']=$val;
    }
    public function setIdEtniaAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_etnia']=$val;
    }
    public function setIdTipoDocumentoAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_tipo_documento']=$val;
    }

    public function setIdNacionalidadAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_nacionalidad']=$val;
    }
    public function setIdEstadoCivilAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_estado_civil'] = $val;
    }
    public function setIdLugarResidenciaAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_lugar_residencia'] = $val;
    }
    public function setIdZonaAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_zona']=$val;
    }
    public function setIdEduFormalAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_edu_formal']=$val;
    }
    public function setCargoPublicoAttribute($val) {
        $val = $val > 0 ? $val : 2 ;
        $this->attributes['cargo_publico'] = $val;
    }
    public function setIdFuerzaPublicaEstadoAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_fuerza_publica_estado']=$val;
    }
    public function setIdFuerzaPublicaAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_fuerza_publica']=$val;
    }
    public function setIdActorArmadoAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_actor_armado']=$val;
    }
    public function setOrganizacionColectivoAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['organizacion_colectivo']=$val;
    }
    public function setIdDiscapacidadAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_discapacidad']=$val;

    }
    public function setIdEtniaIndigenaAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_etnia_indigena']=$val;
    }
    public function setIdOtraNacionalidadAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_otra_nacionalidad']=$val;
    }
    public function setIdLugarResidenciaDeptoAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_lugar_residencia_depto']=$val;
    }
    public function setIdLugarResidenciaMuniAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_lugar_residencia_muni']=$val;
    }
    public function setIdLugarNacimientoDeptoAttribute($val) {
        $val = $val > 0 ? $val : null ;
        $this->attributes['id_lugar_nacimiento_depto']=$val;
    }



}
