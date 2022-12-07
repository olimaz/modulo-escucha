<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Flash\Flash;
use mysql_xdevapi\Exception;

/**
 * @property int $id_mis_casos_entrevista
 * @property int $id_entrevistador
 * @property int $id_mis_casos
 * @property int $id_subserie
 * @property int $id_entrevista
 * @property string $codigo
 * @property string $fecha_hora
 * @property Esclarecimiento.entrevistador $esclarecimiento.entrevistador
 */
class mis_casos_entrevista extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.mis_casos_entrevista';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_mis_casos_entrevista';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevistador', 'id_subserie', 'id_entrevista', 'codigo', 'fecha_hora','id_mis_casos'];

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
    public function rel_id_entrevistador()
    {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador', 'id_entrevistador');
    }
    public function rel_id_mis_casos() {
        return $this->belongsTo(mis_casos::class,'id_mis_casos','id_mis_casos');
    }


    //Procesar el request
    public static function agregar_entrevistas($request) {
        $r=new \stdClass();
        $r->si=null;
        $r->no=null;
        $r->codigos=null;
        $r->id_mis_casos=null;
        $si=array();
        $no=array();


        $caso = mis_casos::find($request->id_mis_casos);
        if(!$caso) {
            Flash::error("No existe el caso transversal $request->id_mis_casos");
            return $r;
        }
        else {
            $r->id_mis_casos=$request->id_mis_casos;
        }
        //Agregar por código
        if(strlen(trim($request->listado_codigos))>0) {
            $r->codigos=$request->listado_codigos;
            $listado_codigos =  $r->codigos;
            $listado_codigos = str_replace(","," ",$listado_codigos);
            $listado_codigos = str_replace(";"," ",$listado_codigos);
            $listado_codigos = str_replace("."," ",$listado_codigos);
            $arreglo = explode(" ",$listado_codigos);
            //Procesar los códigos
            foreach($arreglo as $codigo) {
                $codigo=trim($codigo);
                if(strlen($codigo)>0) {
                    $existe = desclasificar::buscar_entrevista($codigo);
                    $puede = false;  //Valor por defecto, por si acaso
                    if($existe->id_primaria > 0) {
                        $puede = true;
                    }
                    else {
                        $puede=false;
                        $no[] = $codigo. " (inexistente)";
                    }

                    if($puede) {
                        $input['id_mis_casos'] = $r->id_mis_casos;
                        $input['id_entrevista']=$existe->id_primaria;
                        $input['id_subserie']=$existe->id_subserie;
                        $input['id_entrevistador']=\Auth::user()->id_entrevistador;
                        $input['codigo']=$codigo;
                        try {
                            mis_casos_entrevista::create($input);
                            $si[]=$codigo;
                        }
                        catch (\Exception $e) {
                            //$no[] = $codigo.": ".$e->getMessage();
                            $no[] = $codigo.": duplicado";
                        }
                    }

                }

            }
        }
        if(isset($request->id_marca)) {
            if(count($request->id_marca)) {
                $res = $caso->agregar_entrevistas_por_marca($request->id_marca);
                array_merge($si,$res->si);
                array_merge($no,$res->no);
            }
        }



        $r->si = implode(", ",$si);
        $r->no = implode(", ",$no);
        return $r;

    }
}
