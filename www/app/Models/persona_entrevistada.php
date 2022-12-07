<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Flash\Flash;

/**
 * @property int $id_persona_entrevistada
 * @property int $id_persona
 * @property int $id_e_ind_fvt
 * @property int $es_victima
 * @property int $es_testigo
 * @property string $created_at
 * @property string $updated_at
 * @property int $insert_ent
 * @property string $insert_ip
 * @property string $insert_fh
 * @property int $update_ent
 * @property string $update_ip
 * @property string $update_fh
 * @property string $sintesis_relato
 * @property int $edad
 * @property int $id_entrevista_profundidad
 * @property int $id_historia_vida
 * @property Esclarecimiento.eIndFvt $esclarecimiento.eIndFvt
 * @property Fichas.persona $fichas.persona
 * @property Fichas.perEntRelVictima[] $fichas.perEntRelVictimas
 */
class persona_entrevistada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.persona_entrevistada';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_persona_entrevistada';

    /**
     * @var array
     */
    protected $fillable = ['id_persona', 'id_e_ind_fvt', 'es_victima', 'es_testigo', 'created_at', 'updated_at', 'insert_ent', 'insert_ip', 'insert_fh', 'update_ent', 'update_ip', 'update_fh', 'sintesis_relato', 'edad', 'id_entrevista_profundidad', 'id_historia_vida'];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_e_ind_fvt()
    {
        return $this->belongsTo(entrevista_individual::class, 'id_e_ind_fvt', 'id_e_ind_fvt');
    }
    public function rel_id_entrevista_profundidad()
    {
        return $this->belongsTo(entrevista_profundidad::class, 'id_entrevista_profundidad', 'id_entrevista_profundidad');
    }
    public function rel_id_historia_vida()
    {
        return $this->belongsTo(historia_vida::class, 'id_historia_vida', 'id_historia_vida');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_persona()
    {
        return $this->belongsTo(persona::class, 'id_persona', 'id_persona');
    }

    /**
     * De Abi
     */
    public function __construct($att=[]) {
        parent::__construct($att);
    }

    public function setRelacionVictima($relacion) {
        $this->relacion = $relacion;
    }

    public function rel_per_ent_rel_victima() {
        return $this->hasMany(relacion_victima::class, 'id_persona_entrevistada', 'id_persona_entrevistada');
    }


    public function agregarRelacionConLaVictima($id_rel_victima, $id_victima)
    {
        $relacion_victima = relacion_victima::firstOrNew(['id_persona_entrevistada' => $this->id_persona_entrevistada, 'id_victima' => $id_victima]);
        $relacion_victima->id_persona_entrevistada = $this->id_persona_entrevistada;
        $relacion_victima->id_rel_victima = $id_rel_victima;
        $relacion_victima->id_victima = $id_victima;
        $relacion_victima->save();
    }

    public function getFmtEsVictimaAttribute() {
        return criterio_fijo::describir(2,$this->es_victima);
    }
    public function getFmtEsTestigoAttribute() {
        return criterio_fijo::describir(2,$this->es_testigo);
    }


    public static function no_tiene_condiciones_acordadas_entrevista($id_e_ind_fvt)
    {
        $entrevista = entrevista::where('id_e_ind_fvt', '=', $id_e_ind_fvt)->first();

        if (!empty($entrevista))
        {
            if (count($entrevista->arreglo_acompanamiento) == 0)
            {
                return 1;
            }

            return 0;
        }

        return 1;
    }

    public function completar_traza_insert() {
        $this->insert_ent = \Auth::user()->rel_entrevistador->id_entrevistador;
        $this->insert_fh = \Carbon\Carbon::now();
        $this->insert_ip = \Request::ip();
    }

    public function completar_traza_update() {
        $this->update_ent = \Auth::user()->rel_entrevistador->id_entrevistador;
        $this->update_fh = \Carbon\Carbon::now();
        $this->update_ip = \Request::ip();
    }
    public function calcular_edad() {
        $persona = $this->rel_id_persona;
        if($this->id_e_ind_fvt > 0) {
            $e = $this->rel_id_e_ind_fvt;
            return $persona->calcular_edad($e->entrevista_fecha);
        }
        elseif($this->id_entrevista_profundidad > 0) {
            $e = $this->rel_id_entrevista_profundidad;
            return $persona->calcular_edad($e->entrevista_fecha_inicio);
        }
        elseif($this->id_historia_vida > 0) {
            $e = $this->rel_id_historia_vida;
            return $persona->calcular_edad($e->entrevista_fecha_inicio);
        }
        else {
            return null;
        }

    }

    //Este procedimiento es para actualizar las edades de las personas entrevistas
    //usado en el cambio del 1-jun-20
    public static function actualizar_todas_edades() {
        $listado = persona_entrevistada::wherenull('edad')->orderby('id_persona_entrevistada')->get();
        $i=0;
        foreach ($listado as $item) {
            $item->edad = $item->calcular_edad();
            $item->save();
            $i++;
        }
        return "$i edades actualizadas";
    }
    /*
     * Fin del bloque de Abi, empieza el código nuevo, versión 2021
     */


    /**
     * procesa los datos de persona y persona entrevistada
     * Define si es insert o update
     */
    //Determinar la entrevista
    public function getEntrevistaAttribute() {
        if($this->id_e_ind_fvt > 0) {
            $e = $this->rel_id_e_ind_fvt;
        }
        elseif($this->id_entrevista_profundidad > 0) {
            $e = $this->rel_id_entrevista_profundidad;
        }
        elseif($this->id_historia_vida > 0) {
            $e = $this->rel_id_historia_vida;
        }
        else {
            $e = false;
        }
        return $e;

    }
    public static function procesar_request($request) {
        //dd($request);
        //Actualizar consentimiento informado
        if($request->id_entrevista > 0) {
            $consentimiento = entrevista::find($request->id_entrevista);
            if (!$consentimiento) {
                Flash::error("problemas con el consentimiento informado: no existe el identificador $request->id_entrevista.");
                return false;
            }
            else {
                $consentimiento->update_ent = \Auth::user()->id_entrevistador;
                $consentimiento->update_ip =\Request::ip();
                $consentimiento->update_fh = \Carbon\Carbon::now();
            }
        }
        else {
            $consentimiento = new entrevista();
            $consentimiento->insert_ent = \Auth::user()->id_entrevistador;
            $consentimiento->insert_ip =\Request::ip();
            $consentimiento->insert_fh = \Carbon\Carbon::now();

        }
        //Actualizar la información respectiva
        $consentimiento->fill($request->all());
        if($request->id_e_ind_fvt > 0 ) {
            $consentimiento->id_e_ind_fvt = $request->id_e_ind_fvt;
            $entrevista = entrevista_individual::find($consentimiento->id_e_ind_fvt);
        }
        elseif($request->id_entrevista_profundidad > 0 ) {
            $consentimiento->id_entrevista_profundidad = $request->id_entrevista_profundidad;
            $entrevista = entrevista_profundidad::find($consentimiento->id_entrevista_profundidad);
        }
        elseif($request->id_historia_vida > 0 ) {
            $consentimiento->id_historia_vida = $request->id_historia_vida;
            $entrevista = historia_vida::find($consentimiento->id_historia_vida);
        }
        else {
            Flash::error("No se especifica el tipo de entrevista");
            return false;
        }
        //Persistir a la BD
        $consentimiento->save();

        //Actualizar datos de persona
        if($request->id_persona > 0) {
            $persona = persona::find($request->id_persona);
            if(!$persona) {
                Flash::error("Problemas con id_persona no existente: $request->id_persona");
                return false;
            }
            else {
                $persona->update_ent = \Auth::user()->id_entrevistador;
                $persona->update_ip =\Request::ip();
                $persona->update_fh = \Carbon\Carbon::now();
            }
        }
        else {
            $persona = new persona();
            $persona->insert_ent = \Auth::user()->id_entrevistador;
            $persona->insert_ip =\Request::ip();
            $persona->insert_fh = \Carbon\Carbon::now();
        }
        //Actualizar el modelo
        $persona->fill($request->all());
        $persona->save();
        //Actualizar datos de autoridad etnico territorial
        $persona->rel_autoridad_etnico_territorial_fr()->delete();
        if(is_array($request->autoridad_etno_territorial)) {
            foreach($request->autoridad_etno_territorial as $valor) {
                if($valor>0) {
                    $persona->rel_autoridad_etnico_territorial_fr()->save(new persona_aut_etnico_ter(['id_aut_etnico_ter' => $valor]));
                }
            }
        }
        //Actualizar detalle de discapacidad
        $persona->rel_discapacidad_fr()->delete();
        if(is_array($request->discapacidad)) {
            foreach($request->discapacidad as $valor) {
                if($valor > 0) {
                    $persona->rel_discapacidad_fr()->save( new persona_discapacidad(['id_discapacidad'=>$valor]));
                }
            }
        }

        //Actualizar datos de participación en organizaciones
        $persona->rel_persona_organizacion()->delete();
        if(is_array($request->organizacion_tipo)) {
            //dd($request);
            foreach ($request->organizacion_tipo as $index => $val) {
                $att['id_tipo_organizacion'] = $val;
                $att['nombre'] = $request->organizacion_nombre[$index];
                $att['rol'] = $request->organizacion_rol[$index];
                $persona->rel_persona_organizacion()->save(new persona_organizacion($att));
            }
        }




        //Actualizar datos de persona_entrevistada
        if($request->id_persona_entrevistada > 0 ) {
            $persona_entrevistada = persona_entrevistada::find($request->id_persona_entrevistada);
            if(!$persona_entrevistada) {
                Flash::error("Problemas con id_persona_entrevistada no existente: $request->id_persona_entrevistada");
                return false;
            }
            else {
                $persona_entrevistada->update_ent = \Auth::user()->id_entrevistador;
                $persona_entrevistada->update_ip =\Request::ip();
                $persona_entrevistada->update_fh = \Carbon\Carbon::now();
                traza_actividad::create(['id_objeto'=>103, 'id_accion'=>4, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$persona_entrevistada->id_persona_entrevistada]);

            }
        }
        else {
            $persona_entrevistada = new persona_entrevistada();
            $persona_entrevistada->insert_ent = \Auth::user()->id_entrevistador;
            $persona_entrevistada->insert_ip =\Request::ip();
            $persona_entrevistada->insert_fh = \Carbon\Carbon::now();
            traza_actividad::create(['id_objeto'=>103, 'id_accion'=>3, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$persona_entrevistada->id_persona_entrevistada]);
        }
        $persona_entrevistada->fill($request->all());
        $persona_entrevistada->id_persona = $persona->id_persona;
        $persona_entrevistada->edad = $persona_entrevistada->calcular_edad();
        //Aprovecho que ya lo ubiqué en el bloque anterior
        $persona_entrevistada->id_e_ind_fvt = $consentimiento->id_e_ind_fvt;
        $persona_entrevistada->id_entrevista_profundidad = $consentimiento->id_entrevista_profundidad;
        $persona_entrevistada->id_historia_vida = $consentimiento->id_historia_vida;

        $persona_entrevistada->save();

        //Fin: devolver persona entrevistada para que lo usen en el show
        return $persona_entrevistada;
    }

    /**
     * Scopes y lógica del panel de exploración de fichas
     */


    /**
     * Criterios de filtrado
     * @param null $request
     * @return \stdClass
     */
    public static function filtros_default($request = null) {
        $fecha = Carbon::now();
        //Valores por defecto
        $filtro =new \stdClass();
        $filtro->nombre = null;
        $filtro->apellido = null;
        $filtro->alias = null;
        $filtro->edad_del = "";
        $filtro->edad_al = "";
        $filtro->id_lugar_nacimiento = -1;
        $filtro->id_lugar_residencia=-1;
        $filtro->id_sexo = -1;
        $filtro->id_orientacion = -1;
        $filtro->id_identidad = -1;
        $filtro->id_etnia = -1;
        $filtro->id_discapacidad=-1;
        $filtro->id_etnia_indigena=-1;
        $filtro->id_nacionalidad=-1;
        $filtro->id_estado_civil=-1;
        $filtro->id_edu_formal=-1;
        $filtro->profesion=-1;
        $filtro->ocupacion_actual=null;
        $filtro->es_victima=null;
        $filtro->es_testigo=null;
        //Buscadora
        $filtro->fts=null;
        $filtro->id_tesauro=-1;
        //Filtros de participación social
        $filtro->cargo_publico=-1;  //Cargo Publico
        $filtro->cargo_publico_cual=null;
        $filtro->autoridad_etnico_territorial=-1; //Autoridad etnica
        $filtro->id_fuerza_publica=-1; //Fuerza publica
        $filtro->id_fuerza_publica_estado=-1;
        $filtro->fuerza_publica_especificar="";
        $filtro->id_actor_armado=-1; //Actor armado
        $filtro->actor_armado_especificar="";
        $filtro->organizacion_colectivo=-1; //ORganizacion o colectivo
        $filtro->id_tipo_organizacion="";
        $filtro->organizacion_nombre="";
        $filtro->rol="";
        $filtro->id_rel_victima=-1;
        $filtro->es_declarante=-1;
        $filtro->id_territorio=-1;
        $filtro->id_territorio_macro=-1;  //tomado del nombre que usa el control
        $filtro->id_entrevista_lugar=-1;
        //Filtros por violencia
        $filtro->violencia_anio_del="";
        $filtro->violencia_anio_al="";
        $filtro->violencia_id_lugar="";
        $filtro->violencia_id_zona="";
        $filtro->violencia_id_subtipo_violencia="";  //subtipo de violencia
        $filtro->violencia_id_subtipo_aa="";  //subtipo de AA
        $filtro->violencia_id_subtipo_tc="";  //Subtipo de TC
        $filtro->violencia_id_subtipo_violencia_depto="";  //control para tipo de violencia
        $filtro->violencia_id_subtipo_aa_depto="";  //control para tipo de AA
        $filtro->violencia_id_subtipo_tc_depto=""; //Control para tipo de TC
        $filtro->identifica_pri=-1;
        $filtro->hay_ficha_exilio=-1;
        //Contexto
        $filtro->id_contexto=array();
        //Impactos
        $filtro->id_impacto=array();
        $filtro->impacto_transgeneracional=null;
        //Metadatos
        $filtro->entrevista_codigo=null;
        $filtro->id_territorio=-1;
        $filtro->id_territorio_macro=-1;
        $filtro->id_entrevista_lugar=-1;
        $filtro->id_etnico=-1;
        $filtro->id_sector=-1;
        $filtro->interes=-1;
        $filtro->interes_area=-1;
        $filtro->mandato=-1;
        $filtro->marca=array();
        $filtro->id_excel_listados=-1;
        $filtro->titulo="";
        $filtro->dinamica="";
        //Priorizacion
        $filtro->fluidez=-1;
        $filtro->cierre=-1;
        $filtro->d_hecho=-1;
        $filtro->d_contexto=-1;
        $filtro->d_impacto=-1;
        $filtro->d_justicia=-1;

        //Alternar entre listado de victimas o personas
        $filtro->id_tipo_listado=1;  //victimas por defecto


        // Actualizar valores del REQUEST
        foreach($filtro as $var => $val) {
            $filtro->$var = isset($request->$var) ? $request->$var : $filtro->$var;
        }
        //Valores geograficos: buscar depto y muni si no hay lugar poblado
        $filtro->id_lugar_nacimiento = victima::determinar_geo($request,'id_lugar_nacimiento');
        $filtro->id_lugar_residencia = victima::determinar_geo($request,'id_lugar_residencia');
        $filtro->id_entrevista_lugar = victima::determinar_geo($request,'id_entrevista_lugar');
        $filtro->violencia_id_lugar = victima::determinar_geo($request,'violencia_id_lugar');
        $filtro->id_tesauro = victima::determinar_geo($request,'id_tesauro');

        //Para poder usar los filtros de entrevista individual
        $filtro->id_macroterriotorio = $filtro->id_territorio_macro;




        //Filtro de seguridad
        if(\Auth::check()) {
            //$usuario =\Auth::user();
        }

        //Para poder agregar el query string a a los links por GET
        if(is_object($request)) {
            if(method_exists($request,'fullUrl')) {
                $url = $request->fullUrl();
                $pedazos = explode("?",$url);
                if(isset($pedazos[1])) {
                    $filtro->url = $pedazos[1]."&";

                }
                else {
                    $filtro->url="?";
                }
            }
        }

        //ultima propiedad.  Actualizada en los scopeXYZ
        $filtro->hay_filtro=0;

        return $filtro;
    }

    //Cuando exporto, necesito saber si debo pasar un arreglo con id_hecho o no.
    //si no hay filtros por violencia, no se aplica filtro por id_hecho
    public static function hay_filtro_hechos($filtro) {
        $hay_filtro=false;
        if(strlen($filtro->violencia_anio_del)>0) {
            $hay_filtro=true;

        }
        if(strlen($filtro->violencia_anio_al)>0) {
            $hay_filtro=true;

        }
        if($filtro->violencia_id_lugar > 0) {
            $hay_filtro=true;

        }
        if(strlen($filtro->violencia_id_zona)>0) {
            $hay_filtro=true;


        }
        if($filtro->violencia_id_subtipo_violencia > 0) {
            $hay_filtro=true;

        }
        if($filtro->violencia_id_subtipo_aa > 0) {
            $hay_filtro=true;
        }
        if($filtro->violencia_id_subtipo_tc > 0) {
            $hay_filtro=true;
        }
        if($filtro->violencia_id_subtipo_violencia_depto > 0) {
            $hay_filtro=true;
        }
        if($filtro->violencia_id_subtipo_aa_depto > 0) {
            $hay_filtro=true;
        }
        if($filtro->violencia_id_subtipo_tc_depto > 0) {
            $hay_filtro=true;
        }
        if($filtro->identifica_pri > -1) {
            $hay_filtro=true;
        }

        return $hay_filtro;
    }

    //Para parametrizar los campos seleccionados.
    public static function scopeSeleccionar($query, $id_tipo_listado=1) {
        if($id_tipo_listado==1) {  //Mostrar datos de persona entrevistada
            $query->selectraw(\DB::raw('distinct persona_entrevistada.*,  persona.*,  e_ind_fvt.id_e_ind_fvt, e_ind_fvt.id_subserie, e_ind_fvt.clasifica_nivel, e_ind_fvt.entrevista_codigo'));
        }
        else {  //mostrar las entrevistas
            $query->selectraw(\DB::raw('distinct persona_entrevistada.id_e_ind_fvt, e_ind_fvt.entrevista_correlativo'));
        }

    }
    //Ordenar
    public static function scopeOrdenar_busqueda($query, $id_tipo_listado=1) {
        if($id_tipo_listado==1) {  //persona entrevistada
            $query->orderby('apellido_buscable')
                ->orderby('nombre_buscable')
                ->orderby('alias')
                ->orderby('fec_nac_a')
                ->orderby('fec_nac_m')
                ->orderby('fec_nac_d')
                ->orderby('id_sexo')
                ;
        }
        else {  //Entrevistas
            $query->orderby('entrevista_correlativo');
        }

    }
    //Aplicar todos los filtros
    public static function scopeFiltrar($query,$criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }

        //QUery base: hace todos los join necearios: a persona, hecho, hecho_victima, hecho_violencia, hecho_responsabilidad
        $query->join('esclarecimiento.e_ind_fvt','persona_entrevistada.id_e_ind_fvt','=','e_ind_fvt.id_e_ind_fvt')
            ->join('fichas.persona','persona_entrevistada.id_persona','persona.id_persona')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'));
        //Parametrizable en .env
        if(config('expedientes.buscar_fichas_incompletas')==false) {
            $query->where('e_ind_fvt.fichas_estado',1);
        }

        $query->apellido($criterios->apellido, $criterios)
            ->nombre($criterios->nombre, $criterios)
            ->alias($criterios->alias, $criterios)
            ->id_sexo($criterios->id_sexo, $criterios)
            ->id_orientacion($criterios->id_orientacion, $criterios)
            ->id_identidad($criterios->id_identidad, $criterios)
            ->edad_del($criterios->edad_del, $criterios)
            ->edad_al($criterios->edad_al, $criterios)
            ->id_nacionalidad($criterios->id_nacionalidad, $criterios)
            ->id_estado_civil($criterios->id_estado_civil, $criterios)
            ->id_discapacidad($criterios->id_discapacidad, $criterios)
            ->id_edu_formal($criterios->id_edu_formal, $criterios)
            //->es_declarante($criterios->es_declarante, $criterios)
            ->id_etnia($criterios->id_etnia, $criterios)
            ->id_etnia_indigena($criterios->id_etnia_indigena, $criterios)
            //->id_rel_victima($criterios->id_rel_victima, $criterios) //se usa en víctima
            ->es_victima($criterios->es_victima, $criterios)
            ->es_testigo($criterios->es_testigo, $criterios)
            //Buscadora
            ->fts($criterios->fts, $criterios)
            ->tesauro($criterios->id_tesauro, $criterios)
            //Filtros de participación social
            ->cargo_publico($criterios->cargo_publico, $criterios)  //Cargo Publico
            ->cargo_publico_cual($criterios->cargo_publico_cual, $criterios)
            ->autoridad_etnico_territorial($criterios->autoridad_etnico_territorial, $criterios)
            ->id_fuerza_publica($criterios->id_fuerza_publica, $criterios)
            ->id_fuerza_publica_estado($criterios->id_fuerza_publica_estado, $criterios)
            ->fuerza_publica_especificar($criterios->fuerza_publica_especificar, $criterios)
            ->id_actor_armado($criterios->id_actor_armado, $criterios)
            ->actor_armado_especificar($criterios->actor_armado_especificar, $criterios)
            ->organizacion_colectivo($criterios->organizacion_colectivo, $criterios)
            ->id_tipo_organizacion($criterios->id_tipo_organizacion, $criterios)
            ->organizacion_nombre($criterios->organizacion_nombre, $criterios)
            ->rol($criterios->rol, $criterios)
            //Filtros por violencia
            ->violencia_anio_del($criterios->violencia_anio_del, $criterios)
            ->violencia_anio_al($criterios->violencia_anio_al, $criterios)
            ->violencia_id_lugar($criterios->violencia_id_lugar, $criterios)
            ->violencia_id_tipo_violencia($criterios->violencia_id_subtipo_violencia_depto, $criterios)
            ->violencia_id_subtipo_violencia($criterios->violencia_id_subtipo_violencia, $criterios)
            ->violencia_id_tipo_aa($criterios->violencia_id_subtipo_aa_depto, $criterios)
            ->violencia_id_subtipo_aa($criterios->violencia_id_subtipo_aa, $criterios)
            ->violencia_id_tipo_tc($criterios->violencia_id_subtipo_tc_depto, $criterios)
            ->violencia_id_subtipo_tc($criterios->violencia_id_subtipo_tc, $criterios)
            ->identifica_pri($criterios->identifica_pri, $criterios)
            ->hay_ficha_exilio($criterios->hay_ficha_exilio, $criterios)
            //Contexto e impactos
            ->id_contexto($criterios->id_contexto, $criterios)
            ->id_impacto($criterios->id_impacto, $criterios)
            ->impacto_transgeneracional($criterios->impacto_transgeneracional, $criterios)
            //metadatos
            //->id_territorio($criterios->id_territorio, $criterios)
            //->id_macroterritorio($criterios->id_territorio_macro, $criterios)
            //->id_entrevista_lugar($criterios->id_entrevista_lugar, $criterios)
            ->metadatos($criterios);

        ;

    }

    // SCOPES PARA CADA FILTRO
    //Trampa: aplico los filtros de metadatos como un wherein para no repetir los where de c/u
    public static function scopeMetadatos($query, $filtros=null) {
        $filtros_entrevista = entrevista_individual::filtros_default($filtros);
        $universo = entrevista_individual::filtrar($filtros_entrevista)->pluck('e_ind_fvt.id_e_ind_fvt');
        $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
        //Para conteo de filtros
        //dd($filtros);
        if($filtros->id_territorio>0) $filtros->hay_filtro++;
        if($filtros->id_territorio_macro>0) $filtros->hay_filtro++;
        if($filtros->id_entrevista_lugar>0) $filtros->hay_filtro++;
        if($filtros->id_etnico>0) $filtros->hay_filtro++;
        if(is_array($filtros->id_sector)) $filtros->hay_filtro++;
        if(is_array($filtros->interes)) $filtros->hay_filtro++;
        if(is_array($filtros->interes_area)) $filtros->hay_filtro++;
        if(is_array($filtros->mandato)) $filtros->hay_filtro++;
        //dd($filtros);
        if($filtros->fluidez >-1) $filtros->hay_filtro++;
        if($filtros->cierre >-1) $filtros->hay_filtro++;
        if($filtros->d_hecho>0) $filtros->hay_filtro++;
        if($filtros->d_contexto>0) $filtros->hay_filtro++;
        if($filtros->d_impacto>0) $filtros->hay_filtro++;
        if($filtros->d_justicia>0) $filtros->hay_filtro++;
        //
        if($filtros->id_excel_listados>0) $filtros->hay_filtro++;
        if($filtros->entrevista_codigo>0) $filtros->hay_filtro++;
        if(count($filtros->marca)>0) $filtros->hay_filtro++;
        //
        if(strlen($filtros->titulo)>0) $filtros->hay_filtro++;
        if(strlen($filtros->dinamica)>0) $filtros->hay_filtro++;
    }
    public static function scopeNombre($query, $criterio, $filtros=null) {
        $criterio = victima::limpiar_texto_like($criterio);
        if(strlen($criterio)>0) {
            $query->where('persona.nombre_buscable','like',"%$criterio%");  //ojo que nombre_buscable usa indices gist+trigram, no reqiere ilike
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
    }
    public static function scopeApellido($query, $criterio, $filtros=null) {
        $criterio = victima::limpiar_texto_like($criterio);
        if(strlen($criterio)>0) {
            $query->where('persona.apellido_buscable','like',"%$criterio%");  //ojo que este campo  usa indices gist+trigram, no reqiere ilike
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
    }
    public static function scopeAlias($query, $criterio=null, $filtros=null) {
        $criterio = victima::limpiar_texto_like($criterio);
        if(strlen($criterio)>0) {
            $query->where('persona.alias_buscable','like',"%$criterio%");   //ojo que este campo  usa indices gist+trigram, no reqiere ilike
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
    }
    public static function scopeId_sexo($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('persona.id_sexo',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('persona.id_sexo',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeEs_Victima($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('persona_entrevistada.es_victima',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('persona_entrevistada.es_victima',$criterio);
                //dd(entrevista_individual::debug_query($query));
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeEs_Testigo($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('persona_entrevistada.es_testigo',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('persona_entrevistada.es_testigo',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_orientacion($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('id_orientacion',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('id_orientacion',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_identidad($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('id_identidad',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('id_identidad',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeEdad_Del($query, $criterio, $filtros=null) {
        if(strlen($criterio)>0) {
            if($criterio>=0) {
                $query->where('hecho_victima.edad','>=',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeEdad_Al($query, $criterio, $filtros=null) {
        if(strlen($criterio)>0) {
            if($criterio>=0) {
                $query->where('hecho_victima.edad','<=',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_etnia($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('id_etnia',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('id_etnia',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_etnia_indigena($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('id_etnia_indigena',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('id_etnia_indigena',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_nacionalidad($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $in=implode(",",$criterio);
                $query->whereRaw( \DB::raw("(id_nacionalidad in ($in) or id_otra_nacionalidad in ($in))") );
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->whereRaw( \DB::raw("(id_nacionalidad=$criterio or id_otra_nacionalidad=$criterio)") );
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_estado_civil($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('id_estado_civil',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('id_estado_civil',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_discapacidad($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('fichas.persona_discapacidad','persona.id_persona','persona_discapacidad.id_persona');
                $query->wherein('persona_discapacidad.id_discapacidad',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->join('fichas.persona_discapacidad','persona.id_persona','persona_discapacidad.id_persona');
                $query->where('persona_discapacidad.id_discapacidad',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_edu_formal($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('id_edu_formal',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('id_edu_formal',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }


    //filtros de participación social
    public static function scopeCargo_publico($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('persona.cargo_publico',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('persona.cargo_publico',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeCargo_publico_cual($query, $criterio, $filtros=null) {
        $criterio = victima::limpiar_texto_like($criterio);
        if(strlen($criterio)>0) {
            $query->where('cargo_publico_cual','ilike',"%$criterio%");  //ojo que nombre_buscable usa indices gist+trigram, no reqiere ilike
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
    }
    public static function scopeAutoridad_etnico_territorial($query, $criterio, $filtros=null) {
        $universo=false;
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $universo = persona_aut_etnico_ter::wherein('persona_aut_etnico_ter.id_aut_etnico_ter',$criterio);
            }
        }
        else {
            if($criterio>0) {
                $universo = persona_aut_etnico_ter::where('persona_aut_etnico_ter.id_aut_etnico_ter',$criterio);
            }
        }
        if($universo) {
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
            $cuales = $universo->pluck('id_persona');
            $query->wherein('persona.id_persona',$cuales);
        }
    }
    public static function scopeId_Fuerza_publica($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('persona.id_fuerza_publica',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('persona.id_fuerza_publica',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_Fuerza_publica_estado($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('persona.id_fuerza_publica_estado',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('persona.id_fuerza_publica_estado',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeFuerza_publica_especificar($query, $criterio, $filtros=null) {
        $criterio = victima::limpiar_texto_like($criterio);
        if(strlen($criterio)>0) {
            $query->where('fuerza_publica_especificar','ilike',"%$criterio%");
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
    }
    public static function scopeId_actor_armado($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('persona.id_actor_armado',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('persona.id_actor_armado',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeActor_armado_especificar($query, $criterio, $filtros=null) {
        $criterio = victima::limpiar_texto_like($criterio);
        if(strlen($criterio)>0) {
            $query->where('actor_armado_especificar','ilike',"%$criterio%");  //ojo que nombre_buscable usa indices gist+trigram, no reqiere ilike
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
    }
    public static function scopeOrganizacion_colectivo($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('persona.organizacion_colectivo',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('persona.organizacion_colectivo',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_tipo_organizacion($query, $criterio, $filtros=null) {
        $universo=false;
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $universo=persona_organizacion::wherein('id_tipo_organizacion',$criterio);
            }
        }
        else {
            if($criterio>0) {
                $universo=persona_organizacion::wherein('id_tipo_organizacion',$criterio);

            }
        }
        if($universo) {  //Aplicar filtro con wherein para evitar join
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
            $cuales = $universo->pluck('id_persona');
            $query->wherein('persona.id_persona',$cuales);
        }
    }
    public static function scopeOrganizacion_nombre($query, $criterio, $filtros=null) {
        $criterio = victima::limpiar_texto_like($criterio);
        if(strlen($criterio)>0) {
            $universo = persona_organizacion::where('persona_organizacion.nombre_buscable','ilike',"%$criterio%")->pluck('id_persona');
            $query->wherein('persona.id_persona',$universo);
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
    }
    public static function scopeRol($query, $criterio, $filtros=null) {
        $criterio = victima::limpiar_texto_like($criterio);
        if(strlen($criterio)>0) {
            $universo = persona_organizacion::where('persona_organizacion.rol','ilike',"%$criterio%")->pluck('id_persona');
            $query->wherein('persona.id_persona',$universo);  //Aplicar con wherein para evitar join
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
    }



    // ------- FILTROS por violencia
    public static function scopeViolencia_anio_del($query, $criterio, $filtros=null) {
        if(strlen($criterio)>0) {
            if($criterio>=0) {
                $universo = hecho::where('hecho.fecha_ocurrencia_a','>=',$criterio)
                                ->pluck('hecho.id_e_ind_fvt');
                $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeViolencia_anio_al($query, $criterio, $filtros=null) {
        if(strlen($criterio)>0) {
            if($criterio>=0) {
                $universo = hecho::where('hecho.fecha_ocurrencia_a','<=',$criterio)
                                ->pluck('hecho.id_e_ind_fvt');
                $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeViolencia_id_lugar($query,$id_geo=-1, $filtros=null) {
        if($id_geo>0) {
            $universo = hecho::wherein('hecho.id_lugar',geo::arreglo_contenidos($id_geo))
                                ->pluck('hecho.id_e_ind_fvt');
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
    }
    //Tipo y subtipo de violencia
    public static function scopeViolencia_id_tipo_violencia($query, $criterio, $filtros=null) {
        if(is_numeric($criterio)) {
            if($criterio > 0) {
                $criterio = array($criterio);
            }
        }
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $universo = hecho::join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
                            ->wherein('hecho_violencia.id_tipo_violencia',$criterio)
                            ->pluck('hecho.id_e_ind_fvt');
                $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeViolencia_id_subtipo_violencia($query, $criterio, $filtros=null) {
        if(is_numeric($criterio)) {
            if($criterio > 0) {
                $criterio = array($criterio);
            }
        }
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $universo = hecho::join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
                                ->wherein('hecho_violencia.id_subtipo_violencia',$criterio)
                                ->pluck('hecho.id_e_ind_fvt');
                $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }

    }


    //Tipo y subtipo de AA
    public static function scopeViolencia_id_tipo_aa($query, $criterio, $filtros=null) {
        if(is_numeric($criterio)) {
            if($criterio > 0) {
                $criterio = array($criterio);
            }
        }
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $universo = hecho::join('fichas.hecho_responsabilidad','hecho.id_hecho','hecho_responsabilidad.id_hecho')
                                    ->wherein('hecho_responsabilidad.aa_id_tipo',$criterio)
                                    ->pluck('hecho.id_e_ind_fvt');
                $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }

    }
    public static function scopeViolencia_id_subtipo_aa($query, $criterio, $filtros=null) {
        if(is_numeric($criterio)) {
            if($criterio > 0) {
                $criterio = array($criterio);
            }
        }
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $universo = hecho::join('fichas.hecho_responsabilidad','hecho.id_hecho','hecho_responsabilidad.id_hecho')
                    ->wherein('hecho_responsabilidad.aa_id_subtipo',$criterio)
                    ->pluck('hecho.id_e_ind_fvt');
                $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }

    }

    //Tipo y subtipo de TC
    public static function scopeViolencia_id_tipo_tc($query, $criterio, $filtros=null) {
        if(is_numeric($criterio)) {
            if($criterio > 0) {
                $criterio = array($criterio);
            }
        }
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $universo = hecho::join('fichas.hecho_responsabilidad','hecho.id_hecho','hecho_responsabilidad.id_hecho')
                    ->wherein('hecho_responsabilidad.tc_id_tipo',$criterio)
                    ->pluck('hecho.id_e_ind_fvt');
                $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }

    }
    public static function scopeViolencia_id_subtipo_tc($query, $criterio, $filtros=null) {
        if(is_numeric($criterio)) {
            if($criterio > 0) {
                $criterio = array($criterio);
            }
        }
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $universo = hecho::join('fichas.hecho_responsabilidad','hecho.id_hecho','hecho_responsabilidad.id_hecho')
                    ->wherein('hecho_responsabilidad.tc_id_subtipo',$criterio)
                    ->pluck('hecho.id_e_ind_fvt');
                $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }

    public static function scopeIdentifica_pri($query, $criterio, $filtros=null) {
        if($criterio==1) {
            $universo = hecho::join('fichas.hecho_responsable','hecho.id_hecho','hecho_responsable.id_hecho')
                ->pluck('hecho.id_e_ind_fvt');
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
        elseif($criterio==2) {
            $universo = hecho::leftjoin('fichas.hecho_responsable','hecho.id_hecho','hecho_responsable.id_hecho')
                ->whereNull('hecho_responsable.id_persona_responsable')
                ->pluck('hecho.id_e_ind_fvt');
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
    }
    public static function scopeHay_ficha_exilio($query, $criterio, $filtros=null) {
        if($criterio==1) {
            $universo = entrevista_individual::LeftJoin('fichas.exilio','e_ind_fvt.id_e_ind_fvt','exilio.id_e_ind_fvt')
                ->whereNotNull('exilio.id_exilio')
                ->pluck('e_ind_fvt.id_e_ind_fvt');
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);  //query por wherein para evitar join

            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
        elseif($criterio==2) {
            $universo = entrevista_individual::LeftJoin('fichas.exilio','e_ind_fvt.id_e_ind_fvt','exilio.id_e_ind_fvt')
                ->whereNull('exilio.id_exilio')
                ->pluck('e_ind_fvt.id_e_ind_fvt');
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);  //query por wherein para evitar join

            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
    }

    //Buscadora
    //Busqueda de full text search
    public static function scopeFTS($query, $criterio="", $filtros=null)  {
        $buscar = entrevista_individual::procesar_texto_fts($criterio);  //Agrega conectores logicos, quita caracteres especiales, etc.
        if(strlen($buscar)>0) {
            $query->addSelect(\DB::raw("ts_rank('fts', to_tsquery('pg_catalog.spanish',unaccent('$buscar'))) as rank1, e_ind_fvt.id_e_ind_fvt"));
            $query->whereraw(\DB::raw("fts @@ to_tsquery('pg_catalog.spanish',unaccent('$buscar'))"));
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }

        }
    }
    //Buscar en tesauro.  Recibe id_geo
    public static function scopeTesauro($query, $criterio=-1, $filtros=null) {
        //dd($criterio);
        if($criterio > 0) {
            $id_subserie = array(config('expedientes.vi'),config('expedientes.aa'), config('expedientes.tc') );
            $contenidos = tesauro::find($criterio)->arreglo_incluidos();

            $universo =  etiqueta_entrevista::wherein('id_subserie',$id_subserie)
                ->join('catalogos.tesauro as ft','etiqueta_entrevista.id_etiqueta','=','ft.id_etiqueta')
                ->wherein('ft.id_geo',$contenidos)
                ->distinct()
                ->pluck('id_entrevista');
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }

        }
    }

    //Contexto
    public static function scopeId_contexto($query, $criterio, $filtros=null) {
        if(is_numeric($criterio)) {  //truquito para ahorrarme codigo
            if($criterio>0) {
                $criterio = [$criterio];
            }
        }
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)) {
                    foreach($criterio as $especifico) {  //Uno por cada uno, para que sea AND en lugar de OR
                        $universo = hecho::join('fichas.hecho_contexto','hecho.id_hecho','hecho_contexto.id_hecho')
                                    ->where('id_contexto', $especifico)
                                    ->pluck('id_e_ind_fvt');
                        $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
                    }
                    if (is_object($filtros)) {

                        $catalogos = cat_item::distinct()
                            ->wherein('id_item', $criterio)
                            ->pluck('id_cat');
                        $conteo = $catalogos->count();
                        $filtros->hay_filtro += $conteo;
                    }
                }
            }
        }

    }
    //Impactos
    public static function scopeId_impacto($query, $criterio, $filtros=null) {
        if(is_numeric($criterio)) {  //truquito para ahorrarme codigo
            if($criterio>0) {
                $criterio = [$criterio];
            }
        }
        if(is_array($criterio)) {
            if (count($criterio) > 0) {
                if(!in_array(-1,$criterio)) {
                    foreach($criterio as $especifico) {  //Uno por cada uno, para que sea AND en lugar de OR
                        $universo = entrevista_impacto::where('id_impacto', $especifico)->pluck('id_e_ind_fvt');
                        $query->wherein('e_ind_fvt.id_e_ind_fvt', $universo);  //Wherein para evitar join
                    }


                    if (is_object($filtros)) {
                        $catalogos = cat_cat::join('catalogos.cat_item', 'cat_cat.id_cat', 'cat_item.id_cat')
                            ->distinct()
                            ->wherein('id_item', $criterio)
                            ->pluck('cat_cat.id_cat');
                        $conteo = $catalogos->count();


                        $filtros->hay_filtro += $conteo;
                    }
                }
            }
        }
    }
    public static function scopeImpacto_transgeneracional($query, $criterio, $filtros=null) {
        $criterio = str_replace(" ","%",trim($criterio));
        if(strlen($criterio) > 0) {
            $cuales = entrevista_impacto::where('transgeneracionales','ilike',"%$criterio%")->pluck('id_e_ind_fvt')->toArray();
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$cuales);
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
    }






    /*
     * Formatos generados a partir del query de filtrado, incluye campos que no están en la tabla, pero sí en el select
     */

    //Sexo
    public function getFmtIdSexoAttribute() {
        return cat_item::describir($this->id_sexo);
    }
    //Fecha entrevista
    public function getFmtFechaEntrevistaAttribute() {
        $e = entrevista_individual::find($this->id_e_ind_fvt);
        return $e->fmt_entrevista_fecha;

    }
    //Lugar entrevista
    public function getFmtLugarEntrevistaAttribute() {
        $e = entrevista_individual::find($this->id_e_ind_fvt);
        return $e->fmt_entrevista_lugar;
    }
    //Territorio
    public function getFmtIdTerritorioAttribute() {
        $e = entrevista_individual::find($this->id_e_ind_fvt);
        return $e->fmt_id_territorio;
    }
    public function getFmtIdMacroTerritorioAttribute() {
        $e = entrevista_individual::find($this->id_e_ind_fvt);
        return $e->fmt_id_macroterritorio;
    }



    //Para facilitar el despliegue de prioridad
    //Desplegar prioridad

    //Prioridad
    public function rel_prioridad() {
        return $this->hasMany(prioridad::class,'id_entrevista','id_e_ind_fvt')->where('id_subserie',$this->id_subserie);
    }


}
