<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\EntrevistaIndividual;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\EntrevistaRol;

class victima extends Model implements EntrevistaIndividual, EntrevistaRol
{
    protected $table = "fichas.victima";
    protected $primaryKey = 'id_victima';
    protected $fillable = ['id_e_ind_fvt'];

    public function __construct($att=[]) {

        parent::__construct($att);
    }

    public function persona() {
        return $this->belongsTo(persona::class, 'id_persona', 'id_persona');
    }
    //Igual que el anterior, pero estandar
    public function rel_id_persona() {
        return $this->belongsTo(persona::class, 'id_persona', 'id_persona');
    }
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }

    public function rel_victima_duplicada() 
    {
        return $this->hasMany(victima_duplicada::class, 'id_victima');
    }

    public function guardarInformacionParticular(persona $persona, $parametros=[]) {
        
        $victima = $persona->agregarPersonaVictima($parametros);

        if ($victima->id_victima > 0) {
                
            $persona->agregarCondicionDiscapacidad($parametros);
    
            $persona->agregarAutoridadEtnicoTerritorial($parametros);
    
            // La victima indica que participa en alguna organizacion
            if ($parametros['organizacion_colectivo'] == 1) {                     
                $persona->agregarOrganizacion($parametros);
            } else {
                $persona->rel_persona_organizacion()->delete();
            }

            $persona_entrevistada = persona_entrevistada::where('id_e_ind_fvt', '=', $parametros['id_e_ind_fvt'])->first();

            if (isset($parametros['id_rel_victima'])) {

                if (!empty($persona_entrevistada))
                {
                    $persona_entrevistada->agregarRelacionConLaVictima($parametros['id_rel_victima'], $victima->id_victima);
                }                
            } else {
                $relacion_victima = relacion_victima::firstOrNew(['id_persona_entrevistada' => $persona_entrevistada->id_persona_entrevistada, 'id_victima' => $victima->id_victima]);
                $relacion_victima->delete();
            }
        }
    }

    public function existeEntrevistaIndividual(int $id_e_ind_fvt) {

        $victima = victima::where('id_e_ind_fvt', $id_e_ind_fvt)->first();
    
        if (is_object($victima)) {
            $persona = persona::where('id_e_ind_fvt', $id_e_ind_fvt)->first();
            return $persona;
        }
                                        
        return null;
    }

    public static function scopeOrdenar($query) {
        $query->join('fichas.persona','persona.id_persona','=','victima.id_persona')
                ->orderby('apellido')
                ->orderby('nombre');

    }

    public static function scopeEntrevista($query, $id_e_ind_fvt=0) {
        $query->where('victima.id_e_ind_fvt',$id_e_ind_fvt);

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

    //La víctima es el declarante? si sí, devolver datos del declarante
    public function es_declarante() {
        $en = $this->rel_id_e_ind_fvt;
        if($en) {
            $pe = $en->rel_persona_entrevistada;
            if($pe) {
                if($pe->id_persona == $this->id_persona) {
                    return $pe;
                }

            }
        }
        return false;
    }
    public function es_declarante_menor() {
        $pe = $this->es_declarante();
        if($pe) {
            if($pe->edad > 0 && $pe->edad < 18) {
                return true;
            }
        }
        return false;
    }

    public function getFmtParentezcoAttribute() {

        $txt="Sin especificar";
        $e = $this->rel_id_e_ind_fvt;
        if($e) {
            $persona = $e->rel_ficha_persona_entrevistada;
            if($persona) {
                if($persona->id_persona == $this->id_persona) {
                    return "La víctima es la persona entrevistada";
                }
                $id_p_e = $persona->id_persona_entrevistada;
                $rel = relacion_victima::where('id_persona_entrevistada',$id_p_e)
                    ->where('id_victima',$this->id_victima)
                    ->first();
                if($rel) {
                    $txt = cat_item::describir($rel->id_rel_victima);
                }
            }
        }
        else {
            $txt="Desconocido";
        }
        return $txt;
    }


    //Explorar fichas

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
        if($id_tipo_listado==1) {  //Mostrar victimas junto a la violencia.  Esta opción duplica las personas
            $query->selectraw(\DB::raw('distinct victima.*, hecho_victima.edad,  persona.*, hecho.*, e_ind_fvt.id_e_ind_fvt, e_ind_fvt.id_subserie, e_ind_fvt.clasifica_nivel, e_ind_fvt.entrevista_codigo'));
        }
        elseif($id_tipo_listado==2) { //Mostrar personas únicas.  Listado mas corto, pero más exacto
            $query->selectraw(\DB::raw('distinct victima.id_victima, victima.id_e_ind_fvt, e_ind_fvt.id_subserie, e_ind_fvt.entrevista_codigo, persona.*'));
        }
        else {  //mostrar las entrevistas
            $query->selectraw(\DB::raw('distinct victima.id_e_ind_fvt, e_ind_fvt.entrevista_correlativo'));
        }

    }
    //Ordenar
    public static function scopeOrdenar_busqueda($query, $id_tipo_listado=1) {
        if($id_tipo_listado==1) {  //victimas: duplica según violencia
            $query->orderby('apellido')
                ->orderby('nombre')
                ->orderby('alias')
                ->orderby('fec_nac_a')
                ->orderby('fec_nac_m')
                ->orderby('fec_nac_d')
                ->orderby('id_sexo')
                ->orderby('hecho.fecha_ocurrencia_a')
                ->orderby('hecho.fecha_ocurrencia_m')
                ->orderby('hecho.fecha_ocurrencia_d')
                ->orderby('hecho.id_hecho');
        }
        elseif($id_tipo_listado==2) {  //PErsonas: muestra personas sin duplicados
            $query->orderby('apellido')
                ->orderby('nombre')
                ->orderby('alias')
                ->orderby('fec_nac_a')
                ->orderby('fec_nac_m')
                ->orderby('fec_nac_d')
                ->orderby('id_sexo');
        }
        else {
            $query->orderby('entrevista_correlativo');
        }

    }
    //Aplicar todos los filtros
    public static function scopeFiltrar($query,$criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }

        //QUery base: hace todos los join necearios: a persona, hecho, hecho_victima, hecho_violencia, hecho_responsabilidad
        $query->join('esclarecimiento.e_ind_fvt','victima.id_e_ind_fvt','=','e_ind_fvt.id_e_ind_fvt')
                 ->join('fichas.persona','victima.id_persona','persona.id_persona')
                // ->leftjoin('fichas.persona_organizacion','persona_organizacion.id_persona','persona.id_persona')
                ->leftjoin('fichas.hecho_victima','hecho_victima.id_victima','victima.id_victima')
                ->leftjoin('fichas.hecho','hecho_victima.id_hecho','hecho.id_hecho')
                //->leftjoin('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
                //->leftjoin('fichas.hecho_responsabilidad','hecho.id_hecho','hecho_responsabilidad.id_hecho')
                //->leftJoin('fichas.hecho_responsable','hecho.id_hecho','hecho_responsable.id_hecho')
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
            ->id_rel_victima($criterios->id_rel_victima, $criterios)
            ->es_declarante($criterios->es_declarante, $criterios)
            ->id_etnia($criterios->id_etnia, $criterios)
            ->id_etnia_indigena($criterios->id_etnia_indigena, $criterios)
            //Buscadora: en filtros por metadatos
            //->fts($criterios->fts, $criterios)
            //->tesauro($criterios->id_tesauro, $criterios)
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
    public static function scopeAlias($query, $criterio=null, $filtro=null) {
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
    public static function scopeId_rel_victima($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('fichas.per_ent_rel_victima','victima.id_victima','per_ent_rel_victima.id_victima');
                $query->wherein('id_rel_victima',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->join('fichas.per_ent_rel_victima','victima.id_victima','per_ent_rel_victima.id_victima');
                $query->where('id_rel_victima',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeEs_declarante($query, $criterio, $filtros=null) {
        if($criterio==1) {
            $query->join('fichas.persona_entrevistada','hecho.id_e_ind_fvt','persona_entrevistada.id_e_ind_fvt');
            $query->whereRaw(\DB::raw('persona_entrevistada.id_persona = victima.id_persona'));
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
        elseif($criterio==2) {
            $query->join('fichas.persona_entrevistada','hecho.id_e_ind_fvt','persona_entrevistada.id_e_ind_fvt');
            $query->whereRaw(\DB::raw('persona_entrevistada.id_persona <> victima.id_persona'));
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
    }

    public static function scopeId_territorio($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('e_ind_fvt.id_territorio',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('e_ind_fvt.id_territorio',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_macroterritorio($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('e_ind_fvt.id_macroterritorio',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('e_ind_fvt.id_macroterritorio',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_entrevista_Lugar($query,$id_geo=-1, $filtros=null) {
        if($id_geo>0) {
            $query->wherein('e_ind_fvt.entrevista_lugar',geo::arreglo_contenidos($id_geo));
            $filtros->hay_filtro++;
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
                $query->where('hecho.fecha_ocurrencia_a','>=',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeViolencia_anio_al($query, $criterio, $filtros=null) {
        if(strlen($criterio)>0) {
            if($criterio>=0) {
                $query->where('hecho.fecha_ocurrencia_a','<=',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeViolencia_id_lugar($query,$id_geo=-1, $filtros=null) {
        if($id_geo>0) {
            $query->wherein('hecho.id_lugar',geo::arreglo_contenidos($id_geo));
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
                $universo = hecho_violencia::wherein('hecho_violencia.id_tipo_violencia',$criterio)->pluck('id_hecho');
                $query->wherein('hecho.id_hecho',$universo);  //Query por wherein para evitar join
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
                $universo = hecho_violencia::wherein('hecho_violencia.id_subtipo_violencia',$criterio)->pluck('id_hecho');
                $query->wherein('hecho.id_hecho',$universo);  //Query por wherein para evitar join
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
                $universo = hecho_responsabilidad::wherein('hecho_responsabilidad.aa_id_tipo',$criterio)->pluck('id_hecho');
                $query->wherein('hecho.id_hecho',$universo);  //Query por wherein para evitar join
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
                $universo = hecho_responsabilidad::wherein('hecho_responsabilidad.aa_id_subtipo',$criterio)->pluck('id_hecho');
                $query->wherein('hecho.id_hecho',$universo);  //Query por wherein para evitar join
                //$query->wherein('hecho_responsabilidad.aa_id_subtipo',$criterio);
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
                $universo = hecho_responsabilidad::wherein('hecho_responsabilidad.tc_id_tipo',$criterio)->pluck('id_hecho');
                $query->wherein('hecho.id_hecho',$universo);  //Query por wherein para evitar join
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
                $universo = hecho_responsabilidad::wherein('hecho_responsabilidad.tc_id_subtipo',$criterio)->pluck('id_hecho');
                $query->wherein('hecho.id_hecho',$universo);  //Query por wherein para evitar join
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }

    public static function scopeIdentifica_pri($query, $criterio, $filtros=null) {
        if($criterio==1) {
            $universo = hecho::join('fichas.hecho_responsable','hecho.id_hecho','hecho_responsable.id_hecho')
                            ->pluck('hecho.id_hecho');
            $query->wherein('hecho.id_hecho',$universo);  //Query por wherein para evitar join
            if(is_object($filtros)) {
                $filtros->hay_filtro++;
            }
        }
        elseif($criterio==2) {
            $universo = hecho::leftjoin('fichas.hecho_responsable','hecho.id_hecho','hecho_responsable.id_hecho')
                                ->whereNull('hecho_responsable.id_persona_responsable')
                                ->pluck('hecho.id_hecho');
            $query->wherein('hecho.id_hecho',$universo);  //Query por wherein para evitar join
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
                        $universo = hecho_contexto::where('id_contexto', $especifico)->pluck('id_hecho');
                        $query->wherein('hecho.id_hecho', $universo);  //Wherein para evitar join
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
    //Fecha ocurrencia
    public function getFmtFechaOcurrenciaAttribute() {
        $hecho = hecho::find($this->id_hecho);
        if($hecho) {
            return $hecho->fmt_fecha_ocurrencia;
        }
        else {
            return "Sin especificar";
        }

    }
    //Lugar ocurrencia
    public function getFmtLugarOcurrenciaAttribute() {
        $hecho = hecho::find($this->id_hecho);
        if($hecho) {
            return $hecho->fmt_id_lugar;
        }
        else {
            return "Sin especificar";
        }

    }


    //Arreglo de violencias según el id_hecho. Usado en tabla de victimas
    public function getDetalleViolenciaAttribute() {

        $listado = hecho_violencia::where('id_hecho',$this->id_hecho)->orderby('id_hecho_violencia')->get();
        $arreglo = array();
        foreach($listado as $detalle) {
            $arreglo[] = $detalle->fmt_violencia;
        }
        return $arreglo;

    }
    //Arreglo de violencias según el id_victima.  Usado en tabla de personas
    public function getDetalleViolenciaPersonaAttribute() {
            $arreglo=array();
            $hechos = hecho::join('fichas.hecho_victima','hecho.id_hecho','=','hecho_victima.id_hecho')
                ->where('id_victima',$this->id_victima)
                ->orderby('fecha_ocurrencia_a')
                ->orderby('fecha_ocurrencia_m')
                ->orderby('fecha_ocurrencia_d')
                ->orderby('hecho.id_hecho')
                ->get();

            foreach($hechos as $detalle) {
                $arreglo[$detalle->id_hecho]['fecha']=$detalle->fmt_fecha_ocurrencia;
                $violencia = hecho_violencia::where('id_hecho',$detalle->id_hecho)->orderby('id_hecho_violencia')->get();
                foreach($violencia as $item) {
                    $arreglo[$detalle->id_hecho]['violencia'][]=$item->fmt_violencia;
                }
            }
            $str="<ul>";
            foreach($arreglo as $hecho) {
                $str.="<li>";
                $str.=$hecho['fecha'];
                $str.="<ul>";
                foreach($hecho['violencia'] as $viol) {
                    $str.='<li>';
                    $str.=$viol;
                    $str.='</li>';
                }
                $str.="</ul>";
                $str.="</li>";
            }
            $str.="</ul>";



            return $str;


    }

    //Arreglo de fuerzas responsables según el id_hecho
    public function getDetalleResponsabilidadAttribute() {
        $listado = hecho_responsabilidad::where('id_hecho',$this->id_hecho)->orderby('id_hecho_responsabilidad')->get();
        $arreglo = array();
        foreach($listado as $detalle) {
            $arreglo[] = $detalle->fmt_responsabilidad_otro;
        }
        return $arreglo;

    }

    //Para la tabla de personas
    public function getConteoHechosAttribute() {
        $conteo = hecho_victima::where('id_victima',$this->id_victima)->count();
        return $conteo;
    }
    public function getConteoViolenciaAttribute() {
        $conteo = hecho_victima::join('fichas.hecho_violencia','hecho_victima.id_hecho','=','hecho_violencia.id_hecho')
                                ->where('id_victima',$this->id_victima)->count();
        return $conteo;
    }

    //Para facilitar el despliegue de prioridad
    //Desplegar prioridad

    //Prioridad
    public function rel_prioridad() {
        return $this->hasMany(prioridad::class,'id_entrevista','id_e_ind_fvt')->where('id_subserie',$this->id_subserie);
    }



    /*
     * Funciones estaticas de uso común
     */

    //Si no se especifica Lugar Poblado, busca Municipio o Departamento
    public static function determinar_geo($request, $nombre) {
        $res = -1;
        $n1 = $nombre."_depto";
        $n2 = $nombre."_muni";
        $n3 = $nombre;
        //Determinar si es lp, muni o depto
        if(isset($request->$n1)){
            if($request->$n1 > 0) {
                $res = $request->$n1;
            }
        }

        if(isset($request->$n2)){
            if($request->$n2 > 0) {
                $res = $request->$n2;
            }
        }
        if(isset($request->$n3)){
            if($request->$n3 > 0) {
                $res = $request->$n3;
            }
        }
        return $res;
    }

    public static function limpiar_texto_like($texto) {
        $texto = trim($texto);
        $texto = mb_strtolower($texto);
        $texto = str_replace("  "," ",$texto);
        $texto = str_replace(" ","%",$texto);
        return  strtr(utf8_decode($texto), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');

    }
}
