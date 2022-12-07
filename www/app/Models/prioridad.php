<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_prioridad
 * @property int $id_entrevista
 * @property int $id_subserie
 * @property int $id_tipo
 * @property int $fluidez
 * @property int $d_hecho
 * @property int $d_contexto
 * @property int $d_impacto
 * @property int $d_justicia
 * @property int $cierre
 * @property int $ponderacion
 * @property string $observaciones
 * @property string $ahora_entiendo
 * @property string $cambio_perspectiva
 * @property string $fecha_hora
 * @property string $codigo
 */
class prioridad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'prioridad';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_prioridad';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'id_subserie', 'id_tipo', 'fluidez', 'd_hecho', 'd_contexto', 'd_impacto', 'd_justicia', 'cierre', 'ponderacion', 'observaciones', 'ahora_entiendo', 'cambio_perspectiva', 'fecha_hora', 'codigo'];

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



    //////////
    public function getArregloTiposAttribute() {
        $tipo['vi']=config('expedientes.vi');
        $tipo['aa']=config('expedientes.aa');
        $tipo['tc']=config('expedientes.tc');
        $tipo['co']=config('expedientes.co');
        $tipo['ee']=config('expedientes.ee');
        $tipo['pr']=config('expedientes.pr');
        $tipo['dc']=config('expedientes.dc');
        $tipo['hv']=config('expedientes.hv');
        return $tipo;
    }

    public function calcular_ponderacion() {
        $total = ($this->fluidez * 10) + ($this->d_hecho*4) + ($this->d_contexto*4) + ($this->d_impacto*4) +($this->d_justicia*4) + ($this->cierre*10);
        return $total;
    }


    //Para el formulario de cierre de transcribir/etiquetar
    public static function procesar_request($request, $llave_foranea) {
        $info['id_entrevista']=$llave_foranea->id_entrevista;
        $info['id_subserie']=$llave_foranea->id_subserie;
        $info['id_tipo']=2; //Del transcriptor

        $prioridad = prioridad::FirstOrNew($info);

        $prioridad->fluidez = $request->fluidez;
        $prioridad->d_hecho = $request->d_hecho;
        $prioridad->d_contexto = $request->d_contexto;
        $prioridad->d_impacto = $request->d_impacto;
        $prioridad->d_justicia = $request->d_justicia;
        $prioridad->cierre = $request->cierre;
        $prioridad->ponderacion = $prioridad->calcular_ponderacion();
        $prioridad->ahora_entiendo = $request->ahora_entiendo;
        $prioridad->cambio_perspectiva = $request->cambio_perspectiva;
        $prioridad->save();
        return $prioridad;

    }

    //Formatos
    public function getFmtIdTipoAttribute() {
        return $this->id_tipo==2  ? "Transcriptor" :   "Entrevistador";
    }
    public function getFmtFluidezAttribute() {
        return criterio_fijo::describir(25,$this->fluidez);
    }
    public function getFmtDHechoAttribute() {
        return criterio_fijo::describir(26,$this->d_hecho);
    }
    public function getFmtDContextoAttribute() {
        return criterio_fijo::describir(26,$this->d_contexto);
    }
    public function getFmtDImpactoAttribute() {
        return criterio_fijo::describir(26,$this->d_impacto);
    }
    public function getFmtDJusticiaAttribute() {
        return criterio_fijo::describir(26,$this->d_justicia);
    }
    public function getFmtCierreAttribute() {
        return criterio_fijo::describir(25,$this->cierre);
    }


    //Autofill de un campo de la tabla
    public static function listar_opciones_campo($campo,$id_subserie=0, $criterio="") {
        $criterio=trim($criterio);
        //$filtros = self::filtros_default();  //solo entrevistas permitidas
        $criterio = str_replace(" ","%",$criterio);
        //Usado en opciones avanzadas de la buscadora
        if($id_subserie==99) {
            $a_id_subserie[]=config('expedientes.vi');
            $a_id_subserie[]=config('expedientes.aa');
            $a_id_subserie[]=config('expedientes.tc');
            $a_id_subserie[]=config('expedientes.pr');
        }
        else {
            //Para que siempre sea un arreglo
            $a_id_subserie=array_wrap($id_subserie);
        }



        $query = self::where($campo,'ilike',"%$criterio%")->wherein('id_subserie',$a_id_subserie)->where('id_entrevista','>',0)->distinct()->limit(30)->orderby($campo);
            //$debug['sql']= nl2br($query->toSql());
            //$debug['criterios']=$query->getBindings();
            //dd($debug);
        $opciones = $query->pluck($campo)->toArray();
        return $opciones;
    }


}
