<?php

namespace App\Models;

use App\Interfaces\EntrevistaIndividual;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\EntrevistaRol;

class persona_responsable extends Model implements EntrevistaIndividual, EntrevistaRol
{
    protected $table = "fichas.persona_responsable";
    protected $primaryKey = 'id_persona_responsable';
    protected $fillable = [
    'id_e_ind_fvt',
    'id_persona',
    'id_edad_aproximada',
    'id_rango_cargo',
    'id_grupo_paramilitar',
    'id_guerrilla',
    'id_fuerza_publica',
    'id_otro',
    //'presunta_responsabilidad',
    'nombre_superior',
    'conoce_info',
    'que_hace',
    'donde_esta',
    'otros_hechos',
    'nombre_indigena',
    'cuales',
    'insert_ent',
    'insert_fh',
    'insert_ip',
    'update_ent',
    'update_fh',
    'update_ip',
    'id_entrevista_etnica'
    ];

    public static $rules = [
        'nombre_superior' => 'max:200',
        'conoce_info' => 'max:200',
        'que_hace' => 'max:200',
        'donde_esta' => 'max:200',
        'otros_hechos' => 'max:200',
        'cuales' => 'max:200'
    ];


    public function __construct($att=[]) {

        parent::__construct($att);
    }



    public function persona() {
        return $this->belongsTo(persona::class, 'id_persona', 'id_persona');
    }

    //cambia el -1 a null
    public function setIdEtniaAttribute($val) {
      $val = $val > 0 ? $val : null;
      $this->attributes['id_etnia']=$val;
    }
    //cambia el -1 a null
    public function setIdEdadAproximadaAttribute($val) {
      $val = $val > 0 ? $val : null;
      $this->attributes['id_edad_aproximada']=$val;
    }
    //cambia el -1 a null
    public function setIdRangoCargoAttribute($val) {
      $val = $val > 0 ? $val : null;
      $this->attributes['id_rango_cargo']=$val;
    }

    //cambia el -1 a null
    public function setIdGrupoParamilitarAttribute($val) {
      $val = $val > 0 ? $val : null;
      $this->attributes['id_grupo_paramilitar']=$val;
    }
    //cambia el -1 a null
    public function setIdGuerrillaAttribute($val) {
      $val = $val > 0 ? $val : null;
      $this->attributes['id_guerrilla']=$val;
    }
    //cambia el -1 a null
    public function setIdFuerzaPublicaAttribute($val) {
      $val = $val > 0 ? $val : null;
      $this->attributes['id_fuerza_publica']=$val;
    }
    //cambia el -1 a null
    public function setIdOtroAttribute($val) {
      $val = $val > 0 ? $val : null;
      $this->attributes['id_otro']=$val;
    }



    public function rel_responsabilidad() {
        return $this->hasMany(persona_responsable_responsabilidades::class,'id_persona_responsable','id_persona_responsable');
    }





    public function guardarInformacionParticular(persona $persona, $parametros=[]) {

          if ($persona->agregarPersonaResponsable($parametros))
        {$persona->agregarResponsabilidades($parametros);}

    }

    public function existeEntrevistaIndividual(int $id_e_ind_fvt) {

        $persona_responsable = persona_responsable::where('id_e_ind_fvt', $id_e_ind_fvt)->first();

        if (is_object($persona_responsable)) {
            $persona = persona::where('id_e_ind_fvt', $id_e_ind_fvt)->first();
            return $persona;
        }

        return null;
    }
    public static function scopeOrdenar($query) {
        $query->join('fichas.persona','persona.id_persona','=','persona_responsable.id_persona')
                ->orderby('apellido')
                ->orderby('nombre');

    }

    public static function scopeEntrevista($query, $id_e_ind_fvt=0) {
        $query->where('persona_responsable.id_e_ind_fvt',$id_e_ind_fvt);

    }

    // Procesa el request y crea los registros en persona_responsable_responsabilidades
    public function grabar_responsabilidades($listado) {
        persona_responsable_responsabilidades::where('id_persona_responsable',$this->id_persona_responsable)->delete();
        if($listado){
          foreach($listado as $id_responsabilidad) {
            $nuevo = new persona_responsable_responsabilidades();
            $nuevo->id_persona_responsable = $this->id_persona_responsable;
            $nuevo->id_responsabilidad = $id_responsabilidad;
            $nuevo->save();
          }
          }

    }


    /**
     * LOGICA PARA EXPLORAR FICHAS DE PRI
     */
    /**
     * Criterios de filtrado
     * @param null $request
     * @return \stdClass
     */
    public static function filtros_default($request = null) {
        $fecha = Carbon::now();
        //Datos personales
        $filtro =new \stdClass();
        $filtro->nombre = null;
        $filtro->apellido = null;
        $filtro->alias = null;
        $filtro->id_edad_aproximada = -1;
        $filtro->id_sexo = -1;
        $filtro->id_etnia = -1;
        $filtro->id_etnia_indigena=-1;
        //Pertenencia y rango
        $filtro->id_rango_cargo=-1;// Actor que hacia parte
        $filtro->id_grupo_paramilitar=-1; //rango en paramilitares
        $filtro->id_guerrilla=-1; //rango en guerrilla
        $filtro->id_fuerza_publica=-1; //rango en fuerza publica
        $filtro->id_otro=-1; //rango en otra fuerza
        $filtro->id_responsabilidad=array();//Responsabilidad en el hecho
        $filtro->nombre_superior=null;//Responsabilidad en el hecho
        $filtro->conoce_info=-1;//Sabe que hace y donde está
        $filtro->otros_hechos=-1;//Sabe si participó en otros hechos de violencia

        //Buscadora
        $filtro->fts=null;
        $filtro->id_tesauro=-1;

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

        //Alternar entre listado de pri o entrevistas
        $filtro->id_tipo_listado=1;  //pri por defecto
        //Explorar pri
        $filtro->entrevista_codigo=null;
        $filtro->id_excel_listados=-1; //Filtro por listado de códigos


        // Actualizar valores del REQUEST
        foreach($filtro as $var => $val) {
            $filtro->$var = isset($request->$var) ? $request->$var : $filtro->$var;
        }
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



    //Para parametrizar los campos seleccionados.
    public static function scopeSeleccionar($query, $id_tipo_listado=1) {
        if($id_tipo_listado==1) {  //Mostrar pri junto a la violencia.
            $query->selectraw(\DB::raw('distinct persona_responsable.*,  persona.*, hecho.*, e_ind_fvt.id_e_ind_fvt, e_ind_fvt.id_subserie, e_ind_fvt.clasifica_nivel, e_ind_fvt.entrevista_codigo'));
        }
        else {  //mostrar las entrevistas
            $query->selectraw(\DB::raw('distinct persona_responsable.id_e_ind_fvt, e_ind_fvt.entrevista_correlativo'));
        }

    }
    //Ordenar
    public static function scopeOrdenar_busqueda($query, $id_tipo_listado=1) {
        if($id_tipo_listado==1) {  //victimas: duplica según violencia
            $query->orderby('persona.apellido')
                ->orderby('persona.nombre')
                ->orderby('persona.alias')
                ->orderby('hecho.fecha_ocurrencia_a')
                ->orderby('hecho.fecha_ocurrencia_m')
                ->orderby('hecho.fecha_ocurrencia_d')
                ->orderby('hecho.id_hecho');
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
        $query->join('fichas.hecho_responsable','persona_responsable.id_persona_responsable','=','hecho_responsable.id_persona_responsable')
                ->join('fichas.persona','persona_responsable.id_persona','persona.id_persona')
                ->join('fichas.hecho','hecho_responsable.id_hecho','hecho.id_hecho')
                ->join('esclarecimiento.e_ind_fvt','hecho.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
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
            ->id_edad_aproximada($criterios->id_edad_aproximada, $criterios)
            ->id_etnia($criterios->id_etnia, $criterios)
            ->id_etnia_indigena($criterios->id_etnia_indigena, $criterios)

            ->id_rango_cargo($criterios->id_rango_cargo, $criterios)
            ->id_grupo_paramilitar($criterios->id_grupo_paramilitar, $criterios)
            ->id_guerrilla($criterios->id_guerrilla, $criterios)
            ->id_fuerza_publica($criterios->id_fuerza_publica, $criterios)
            ->id_otro($criterios->id_otro, $criterios)
            ->id_responsabilidad($criterios->id_responsabilidad, $criterios)
            ->nombre_superior($criterios->nombre_superior, $criterios)
            ->conoce_info($criterios->conoce_info, $criterios)
            ->otros_hechos($criterios->otros_hechos, $criterios)
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
            //->identifica_pri($criterios->identifica_pri, $criterios)
            ->hay_ficha_exilio($criterios->hay_ficha_exilio, $criterios)
            //Contexto e impactos
            ->id_contexto($criterios->id_contexto, $criterios)
            ->id_impacto($criterios->id_impacto, $criterios)
            ->impacto_transgeneracional($criterios->impacto_transgeneracional, $criterios)
            //metadatos
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
        if(strlen($filtros->fts)>0) $filtros->hay_filtro++;
        if($filtros->id_tesauro > 0) $filtros->hay_filtro++;
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
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
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
    public static function scopeId_edad_aproximada($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
                $query->wherein('persona_responsable.id_edad_aproximada',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('persona_responsable.id_edad_aproximada',$criterio);
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
    public static function scopeId_rango_cargo($query, $criterio, $filtros=null) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
                $query->wherein('persona_responsable.id_rango_cargo',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where('persona_responsable.id_rango_cargo',$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_grupo_paramilitar($query, $criterio, $filtros=null) {
        $campo='persona_responsable.id_grupo_paramilitar';
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
                $query->wherein($campo,$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where($campo,$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_guerrilla($query, $criterio, $filtros=null) {
        $campo='persona_responsable.id_guerrilla';
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
                $query->wherein($campo,$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where($campo,$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_fuerza_publica($query, $criterio, $filtros=null) {
        $campo='persona_responsable.id_fuerza_publica';
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
                $query->wherein($campo,$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where($campo,$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_otro($query, $criterio, $filtros=null) {
        $campo='persona_responsable.id_otro';
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
                $query->wherein($campo,$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where($campo,$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeId_responsabilidad($query, $criterio, $filtros=null) {
        if(is_numeric(($criterio))) {
            $criterio =array($criterio);
        }
        //Uso whereIn para evitar que se dupliquen por c/responsabilidad asignada
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio) && count($criterio)>0) {
                $universo = persona_responsable_responsabilidades::wherein('id_responsabilidad',$criterio)->pluck('id_persona_responsable');
                $query->wherein('persona_responsable.id_persona_responsable',$universo);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }

    }

    public static function scopeConoce_info($query, $criterio, $filtros=null) {
        $campo='persona_responsable.conoce_info';
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
                $query->wherein($campo,$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where($campo,$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }
    public static function scopeOtros_hechos($query, $criterio, $filtros=null) {
        $campo='persona_responsable.otros_hechos';
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
                $query->wherein($campo,$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
        else {
            if($criterio>0) {
                $query->where($campo,$criterio);
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
            }
        }
    }

    public static function scopeNombre_superior($query, $criterio, $filtros=null) {
        $criterio = victima::limpiar_texto_like($criterio);
        if(strlen($criterio)>0) {
            $query->where('persona_responsable.nombre_superior','ilike',"%$criterio%");
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
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
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
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
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
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
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
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
                $universo = hecho_responsabilidad::wherein('hecho_responsabilidad.aa_id_subtipo',$criterio)->pluck('id_hecho');
                $query->wherein('hecho.id_hecho',$universo);  //Query por wherein para evitar join
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
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
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
            if(!in_array(-1,$criterio)  && count($criterio)>0) {
                $universo = hecho_responsabilidad::wherein('hecho_responsabilidad.tc_id_subtipo',$criterio)->pluck('id_hecho');
                $query->wherein('hecho.id_hecho',$universo);  //Query por wherein para evitar join
                if(is_object($filtros)) {
                    $filtros->hay_filtro++;
                }
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



    //Contexto
    public static function scopeId_contexto($query, $criterio, $filtros=null) {
        if(is_numeric($criterio)) {  //truquito para ahorrarme codigo
            if($criterio>0) {
                $criterio = [$criterio];
            }
        }
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)  && count($criterio)>0) {
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
                if(!in_array(-1,$criterio)  && count($criterio)>0) {
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
    public function getFmtIdEdadAproximadaAttribute() {
        return cat_item::describir($this->id_edad_aproximada);
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
        $conteo = hecho_responsabilidad::join('fichas.hecho_violencia','hecho_responsable.id_hecho','=','hecho_violencia.id_hecho')
            ->where('id_persona_responsable',$this->id_persona_responsable)->count();
        return $conteo;
    }

    //Para facilitar el despliegue de prioridad
    //Desplegar prioridad

    //Prioridad
    public function rel_prioridad() {
        return $this->hasMany(prioridad::class,'id_entrevista','id_e_ind_fvt')->where('id_subserie',$this->id_subserie);
    }



}
