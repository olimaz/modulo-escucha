<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_excel_listados_codigos
 * @property int $id_excel_listados
 * @property string $codigo
 * @property int $valido
 * @property int $fila
 */
class excel_listados_codigos extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sim.excel_listados_codigos';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_excel_listados_codigos';

    /**
     * @var array
     */
    protected $fillable = ['id_excel_listados', 'codigo', 'valido','fila'];

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

    public function rel_id_excel_listados() {
        return $this->belongsTo(excel_listados::class,'id_excel_listados','id_excel_listados');
    }

    //Logica interna
    public function getEstadoFichasAttribute() {
        if($this->valido==1) {
            $e = entrevista_individual::where('entrevista_codigo',$this->codigo)->where('id_activo',1)->first();
            if($e) {
                return $e->fmt_fichas_estado;
            }
            else {
                return "Sin fichas diligenciadas";
            }
        }
        else
            return "Sin fichas diligenciadas";
    }
    public function getFmtValidoAttribute() {
        return $this->valido==1 ? "Código válido" : "Código no válido";
    }




}
