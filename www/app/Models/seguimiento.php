<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Flash\Flash;
use mysql_xdevapi\Exception;

/**
 * @property int $id_seguimiento
 * @property int $id_entrevistador
 * @property int $id_entrevista
 * @property int $id_subserie
 * @property int $id_cerrado
 * @property string $anotaciones
 * @property string $fecha_hora
 * @property Esclarecimiento.entrevistador $esclarecimiento.entrevistador
 * @property SeguimientoProblema[] $seguimientoProblemas
 */
class seguimiento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'seguimiento';
    protected $primaryKey = 'id_seguimiento';
    protected $fillable = ['id_entrevistador', 'id_entrevista', 'id_subserie', 'id_cerrado', 'anotaciones', 'fecha_hora'];
    public $timestamps = false;
    protected $dateFormat = 'U';

    /*
     * RELACIONES
     */
    public function rel_seguimiento_problema() {
        return $this->hasMany(seguimiento_problema::class, 'id_seguimiento', 'id_seguimiento');
    }
    public function rel_id_entrevistador() {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador', 'id_entrevistador');
    }

    /*
     * FORMATOS
     */
    public function getFmtIdEntrevistadorAttribute() {
        $cual=$this->rel_id_entrevistador;
        if($cual) {
            return $cual->fmt_numero_entrevistador." - ".$cual->fmt_nombre;
        }
        else {
            return "Desconocido";
        }
    }

    public function getFmtFechaHoraAttribute() {
        try {
            $fecha=Carbon::createFromFormat('Y-m-d H:i:s.u',$this->fecha_hora);
            return $fecha->format("d-m-Y");
        }
        catch (\Exception $e) {
            return $this->fecha_hora;
        }
    }

    public function getFmtIdCerradoAttribute() {
        return $this->id_cerrado == 1 ? "Sí" : "No";
    }


    // URL para el show.
    public  function getEntrevistaAttribute() {

        $r=new \stdClass();
        $r->url="Desconocido";
        $r->entrevista=false;

        if($this->id_subserie==config('expedientes.vi')) {
            $r->url=action('entrevista_individualController@show',$this->id_entrevista);
            $r->entrevista= entrevista_individual::find($this->id_entrevista);
        }
        elseif($this->id_subserie==config('expedientes.aa')) {
            $r->url=action('entrevista_individualController@show',$this->id_entrevista);
            $r->entrevista= entrevista_individual::find($this->id_entrevista);
        }
        elseif($this->id_subserie==config('expedientes.tc')) {
            $r->url=action('entrevista_individualController@show',$this->id_entrevista);
            $r->entrevista= entrevista_individual::find($this->id_entrevista);
        }
        elseif($this->id_subserie==config('expedientes.co')) {
            $r->url=action('entrevista_colectivaController@show',$this->id_entrevista);
            $r->entrevista = entrevista_colectiva::find($this->id_entrevista);
        }
        elseif($this->id_subserie==config('expedientes.ee')) {
            $r->url=action('entrevista_etnicaController@show',$this->id_entrevista);
            $r->entrevista = entrevista_etnica::find($this->id_entrevista);
        }
        elseif($this->id_subserie==config('expedientes.pr')) {
            $r->url=action('entrevista_profundidadController@show',$this->id_entrevista);
            $r->entrevista = entrevista_profundidad::find($this->id_entrevista);
        }
        elseif($this->id_subserie==config('expedientes.dc')) {
            $r->url=action('diagnostico_comunitarioController@show',$this->id_entrevista);
            $r->entrevista = diagnostico_comunitario::find($this->id_entrevista);
        }
        elseif($this->id_subserie==config('expedientes.hv')) {
            $r->url=action('historia_vidaController@show',$this->id_entrevista);
            $r->entrevista = historia_vida::find($this->id_entrevista);
        }
        elseif($this->id_subserie==config('expedientes.ci')) {
            $r->url=action('casos_informesController@show',$this->id_entrevista);
            $r->entrevista = casos_informes::find($this->id_entrevista);
        }
        return $r;
    }

    // Me ahorra trabajo en la vista
    public function getFmtEntrevistaCodigoAttribute() {
        $e = $this->entrevista;
        if($e->entrevista) {
            //dd($e);
            $url = $e->url;
            $cod = $e->entrevista->entrevista_codigo;
            $link = "<a href='$url' target='_blank'> $cod</a>";
            return $link;
        }
        else {
            return "XX";
        }
    }


    /*
    * FILTROS y criterios de buscado
    */
    public static function filtros_default($request = null) {
        //Valores por defecto
        $filtro =new \stdClass();
        $filtro->id_subserie = -1;
        $filtro->id_entrevista = -1;
        $filtro->id_cerrado = -1;
        $filtro->id_entrevistador = -1;
        $filtro->anotaciones = null;

        //Detalle de problemas
        $filtro->tiene_problema = -1;
        $filtro->id_tipo_problema = -1;
        $filtro->descripcion = null;
        $filtro->cerrado_id_estado = 2;

        //Por codigo
        $filtro->entrevista_codigo = null;


        // Actualizar valores del REQUEST
        $filtro->id_subserie = isset($request->id_subserie) ? $request->id_subserie : $filtro->id_subserie;
        $filtro->id_entrevista = isset($request->id_entrevista) ? $request->id_entrevista : $filtro->id_entrevista;
        $filtro->id_entrevistador = isset($request->id_entrevistador) ? $request->id_entrevistador : $filtro->id_entrevistador;
        $filtro->id_cerrado = isset($request->id_cerrado) ? $request->id_cerrado : $filtro->id_cerrado;
        $filtro->anotaciones = isset($request->anotaciones) ? $request->anotaciones : $filtro->anotaciones;
        $filtro->tiene_problema = isset($request->tiene_problema) ? $request->tiene_problema : $filtro->tiene_problema;
        $filtro->id_tipo_problema = isset($request->id_tipo_problema) ? $request->id_tipo_problema : $filtro->id_tipo_problema;
        $filtro->descripcion = isset($request->descripcion) ? $request->descripcion : $filtro->descripcion;
        $filtro->cerrado_id_estado = isset($request->cerrado_id_estado) ? $request->cerrado_id_estado : $filtro->cerrado_id_estado;
        $filtro->entrevista_codigo = isset($request->entrevista_codigo) ? $request->entrevista_codigo : $filtro->entrevista_codigo;





        //Administradores
        if(\Gate::allows('nivel-1-2')) {
            //no pasa nada, son administradores o supervisores
        }
        elseif(\Gate::allows('nivel-10')) {
            // No pasa nada, es el jefe de transcripcion
        }
        elseif(\Gate::allows('nivel-6')) {
            //No pasa nada, es comisionado
        }
        else {
            if(\Gate::denies('permisos-legado')) {
                if(\Auth::check()) {
                    $filtro->id_entrevistador = \Auth::user()->id_entrevistador;
                }
            }
        }

        //Para poder agregar el query string a a los links por GET
        if(is_object($request)) {
            $url = $request->fullUrl();
            $pedazos = explode("?",$url);
            if(isset($pedazos[1])) {
                $filtro->url = $pedazos[1]."&";
            }
            else {
                $filtro->url="";
            }
        }

        return $filtro;
    }

    //Criterios de filtrado
    public static function scopeOrdenar($query) {
        $query->orderby('seguimiento.id_subserie')
                ->orderby('seguimiento.id_entrevista')
                ->orderby('seguimiento.fecha_hora');

    }
    public static function scopeId_Subserie($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('seguimiento.id_subserie',$criterio);
        }
    }
    public static function scopeId_Entrevista($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('seguimiento.id_entrevista',$criterio);
        }
    }
    public static function scopeId_Entrevistador($query, $criterio=-1) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                $query->wherein('seguimiento.id_entrevistador',$criterio);
            }
        }
        elseif($criterio>0) {
            $query->where('seguimiento.id_entrevistador',$criterio);
        }
    }
    public static function scopeId_Cerrado($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('seguimiento.id_cerrado',$criterio);
        }
    }


    public static function scopeAnotaciones($query, $txt=null) {
        $txt=trim($txt);
        if(strlen($txt)>0) {
            $query->where('anotaciones','ilike',"%$txt%");
        }
    }
    //Codigo de entrevista
    public static function scopeEntrevista_codigo($query, $criterio="") {
        if(strlen($criterio) > 0) {
            $criterio = mb_strtoupper($criterio);
            $truco="x$criterio";

            if(strpos($truco,"VI") > 0 || strpos($truco,"AA") > 0  || strpos($truco,"TC") > 0 ) {
                $query->join('esclarecimiento.e_ind_fvt as e','seguimiento.id_entrevista','=','e.id_e_ind_fvt')
                    ->where('seguimiento.id_subserie',config('expedientes.vi')) // Ojo que para todos se usa el de VI
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }

            elseif(strpos($truco,"CO") > 0) {
                $query->join('esclarecimiento.entrevista_colectiva as e','seguimiento.id_entrevista','=','e.id_entrevista_colectiva')
                    ->where('seguimiento.id_subserie',config('expedientes.co'))
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }
            elseif(strpos($truco,"EE") > 0) {
                $query->join('esclarecimiento.entrevista_etnica as e','seguimiento.id_entrevista','=','e.id_entrevista_etnica')
                    ->where('seguimiento.id_subserie',config('expedientes.ee'))
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }
            elseif(strpos($truco,"PR") > 0) {
                $query->join('esclarecimiento.entrevista_profundidad as e','seguimiento.id_entrevista','=','e.id_entrevista_profundidad')
                    ->where('seguimiento.id_subserie',config('expedientes.pr'))
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }
            elseif(strpos($truco,"DC") > 0) {
                $query->join('esclarecimiento.diagnostico_comunitario as e','seguimiento.id_entrevista','=','e.id_diagnostico_comunitario')
                    ->where('seguimiento.id_subserie',config('expedientes.dc'))
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }
            elseif(strpos($truco,"HV") > 0) {
                $query->join('esclarecimiento.historia_vida as e','seguimiento.id_entrevista','=','e.id_historia_vida')
                    ->where('seguimiento.id_subserie',config('expedientes.hv'))
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }

        }
    }

    public static function scopeTiene_problema($query, $criterio=-1) {
        if($criterio == 1) {
            $query->whereNotnull('seguimiento_problema.id_seguimiento');
        }
        elseif($criterio == 2) {
            $query->wherenull('seguimiento_problema.id_seguimiento');
        }
    }

    //Problemas
    public static function scopeId_Tipo_Problema($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                $query->wherein('seguimiento_problema.id_tipo_problema',$criterio);
            }
        }
        elseif($criterio > 0) {
            $query->where('seguimiento_problema.id_tipo_problema',$criterio);
        }
    }
    public static function scopeDescripcion($query, $txt=null) {
        $txt=trim($txt);
        if(strlen($txt)>0) {
            $query->where('seguimiento_problema.descripcion','ilike',"%$txt%");
        }
    }
    public static function scopeCerrado_id_estado($query, $criterio=-1) {

        if($criterio > 0) {
            $query->where('seguimiento_problema.cerrado_id_estado','=',$criterio);
        }
    }

    //Aplicar todos los filtros
    public static function scopeFiltrar($query, $criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }


        $query->id_subserie($criterios->id_subserie)
            ->id_entrevista($criterios->id_entrevista)
            ->id_entrevistador($criterios->id_entrevistador)
            ->id_cerrado($criterios->id_cerrado)
            ->anotaciones($criterios->anotaciones)
            ->entrevista_codigo($criterios->entrevista_codigo)
            ->tiene_problema($criterios->tiene_problema)
            ->id_tipo_problema($criterios->id_tipo_problema)
            ->descripcion($criterios->descripcion)
            ->cerrado_id_estado($criterios->cerrado_id_estado)
             ;
        // Siempre halar los problemas, si los hubiera
        if($criterios->id_tipo_problema <= 0 &&  strlen($criterios->descripcion)==0 && $criterios->tiene_problema <= 0 &&  $criterios->cerrado_id_estado <= 0) {
            $query->leftjoin('seguimiento_problema','seguimiento.id_seguimiento','=','seguimiento_problema.id_seguimiento');
        }
        else {
            $query->join('seguimiento_problema','seguimiento.id_seguimiento','=','seguimiento_problema.id_seguimiento');
        }

    }

    /*
     * LOGICA del modelo
     */
    //Para el formulario de cierre de transcribir/etiquetar
    public static function procesar_request($request, $llave_foranea) {
        $id_entrevistador = \Auth::check() ? \Auth::user()->id_entrevistador : null;

        $info['id_entrevista']=$llave_foranea->id_entrevista;
        $info['id_subserie']=$llave_foranea->id_subserie;
        $info['id_entrevistador']=$id_entrevistador;
        $info['id_cerrado'] = isset($request->id_cerrado) ? $request->id_cerrado : 2;
        $info['anotaciones'] = $request->anotaciones;

        $seguimiento = seguimiento::create($info);

        //Cerrar/Abrir expediente
        if(isset($request->id_cerrado)) {
            if($request->id_cerrado==1) {
               //Verificar que sea cerrable
                $cerrar = $seguimiento->puede_ser_cerrada();
                if($cerrar->puede) {
                    $e = $seguimiento->entrevista->entrevista;
                    $e->id_cerrado = $request->id_cerrado;
                    $e->save();
                }
                else {
                    Flash::error("No se cerró la entrevista: ".implode("; ",$cerrar->porque));
                }
            }
            else { //Abrir la entrevista
                $e = $seguimiento->entrevista->entrevista;
                $e->id_cerrado = $request->id_cerrado;
                $e->save();
            }

        }


        //Buscar problemas
        foreach($request->all() as $var => $val) {
            if(substr($var,0,16)=='id_tipo_problema') {
                if($val==1) {
                    $p = new seguimiento_problema();
                    $p->id_seguimiento = $seguimiento->id_seguimiento;
                    $p->id_tipo_problema = substr($var,17);
                    $especifique="problema_".$p->id_tipo_problema."_especifique";
                    $p->descripcion = $request->$especifique;
                    $p->save();
                }
            }
        }

        return $seguimiento;

    }


    //Determinar si la entrevista es cerrable
    public function puede_ser_cerrada() {
        $res= new \stdClass();
        $res->puede=true;
        $res->porque=array();
        //
        $e = $this->entrevista->entrevista;
        if($e) {
            if(empty($e->html_transcripcion)) {
                $res->puede=false;
                $res->porque[]="Entrevista sin transcripción";
            }
            if(empty($e->json_etiquetado)) {
                $res->puede=false;
                $res->porque[]="Entrevista sin etiquetado";
            }
            if(isset($e->id_subserie)) {
                if($e->id_subserie==config('expedientes.vi')) {
                    if($e->fichas_estado <> 1) {
                        $res->puede = false;
                        $res->porque[]="Fichas pendientes de ser diligenciadas";
                    }
                }
            }
        }
        else {
            $res->puede=false;
            $res->porque[]="Entrevista no existe ($this->id_subserie,$this->id_entrevista)";
        }
        return $res;
    }

}
