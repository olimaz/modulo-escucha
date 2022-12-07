<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_etiqueta
 * @property int $id_subserie
 * @property int $id_etiqueta_entrevista
 * @property int $id_entrevista
 * @property string $texto
 * @property int $del
 * @property int $al
 * @property string $codigo
 * @property Sim.etiquetum $sim.etiquetum
 * @property Catalogos.catItem $catalogos.catItem
 */
class etiqueta_entrevista extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sim.etiqueta_entrevista';
    protected $primaryKey = 'id_etiqueta_entrevista';

    /**
     * @var array
     */
    protected $fillable = ['id_etiqueta', 'id_subserie', 'id_etiqueta_entrevista', 'id_entrevista', 'texto', 'del', 'al','codigo'];

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

    public function rel_id_etiqueta() {
        return $this->belongsTo(etiqueta::class,'id_etiqueta','id_etiqueta');
    }
    public function getFmtTextoAttribute() {
        $etiqueta = $this->rel_id_etiqueta;
        if($etiqueta) {
            return $etiqueta->texto;
        }
        else {
            return "Etiqueta desconocida";
        }
    }
    //Obtener el texto de la etiqueta.  Puede ser el texto de la etiqueta o el del tesauro si aplica
    public function getFmtEtiquetaAttribute() {
        $etiqueta = $this->rel_id_etiqueta;
        if($etiqueta) {
            return $etiqueta->texto;
        }
        else {
            return "Etiqueta desconocida";
        }
    }

    /*
     * FILTROS especificos
     */
    //Editqueta exacta
    public static function scopeId_Etiqueta_Exacta($query,$criterio=0) {
        if($criterio>0) {
            $query->where('id_etiqueta',$criterio);
        }
    }
    //Hijos y nietos de la etiqueta
    public static function scopeId_etiqueta_contenida($query, $criterio=0) {
        if($criterio > 0) {
            $contenidos = array();
            $tes = tesauro::id_etiqueta($criterio)->first();
            if($tes) {
                $contenidos = $tes->arreglo_incluidos();
            }
            $query->join('catalogos.tesauro as ft','etiqueta_entrevista.id_etiqueta','=','ft.id_etiqueta')
                ->wherein('ft.id_geo',$contenidos);
        }
    }

    //Igual que id_Etiqueta_exacta, pero con campo id_geo
    public static function scopeId_Geo_Exacta($query,$criterio=0) {
        if($criterio>0) {
            $query->join('catalogos.tesauro as ft','ft.id_etiqueta','=','etiqueta_entrevista.id_etiqueta')
                ->where('ft.id_geo',$criterio);
        }
    }
    //Hijos y nietos de la etiqueta, usando id_geo
    public static function scopeId_Geo_Contenida($query,$criterio) {
        if($criterio > 0) {
            $contenidos = array();
            $tes = tesauro::find($criterio);
            if($tes) {
                $contenidos = $tes->arreglo_incluidos();
            }

            $query->join('catalogos.tesauro as ft','etiqueta_entrevista.id_etiqueta','=','ft.id_etiqueta')
                        ->wherein('ft.id_geo',$contenidos);



        }
    }

    public static function scopeOrdenar($query){
        $query->orderby('etiqueta_entrevista.id_subserie')->orderby('etiqueta_entrevista.id_entrevista')->orderby('etiqueta_entrevista.del');
    }

    //filtros propios de las entrevistas
    public static function scopeOtros_Filtros($query,$filtros) {
        $query->mandato($filtros->mandato)
                ->interes($filtros->interes)
                ->id_sector($filtros->id_sector)
                ->d_hecho_min($filtros->d_hecho_min)
                ->d_contexto_min($filtros->d_contexto_min)
                ->d_impacto_min($filtros->d_impacto_min)
                ->d_justicia_min($filtros->d_justicia_min)
                ->id_etnico($filtros->id_etnico)
                ;
    }
    public function scopeMandato($query, $id_criterio=-1) {
        $filtrar=false;
        if(is_array($id_criterio)) {
            if (!in_array(-1, $id_criterio)) {
                $filtrar = true;
            }
        }
        else {
            if($id_criterio>0) {
                $filtrar = true;
            }
        }
        if($filtrar) {
            $a_ind = entrevista_individual::mandato($id_criterio)->id_activo(1)->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $a_co = entrevista_colectiva::mandato($id_criterio)->id_activo(1)->pluck('entrevista_colectiva.id_entrevista_colectiva')->toArray();
            $a_ee = entrevista_etnica::mandato($id_criterio)->id_activo(1)->pluck('entrevista_etnica.id_entrevista_etnica')->toArray();
            $a_pr = entrevista_profundidad::mandato($id_criterio)->id_activo(1)->pluck('entrevista_profundidad.id_entrevista_profundidad')->toArray();
            $a_dc = diagnostico_comunitario::mandato($id_criterio)->id_activo(1)->pluck('diagnostico_comunitario.id_diagnostico_comunitario')->toArray();
            $a_hv = historia_vida::mandato($id_criterio)->id_activo(1)->pluck('historia_vida.id_historia_vida')->toArray();
            $s_ind[]=config('expedientes.vi');
            $s_ind[]=config('expedientes.aa');
            $s_ind[]=config('expedientes.tc');
            $txt_s_ind = implode(",",$s_ind);
            $txt_s_co = config('expedientes.co');
            $txt_s_ee = config('expedientes.ee');
            $txt_s_pr = config('expedientes.pr');
            $txt_s_dc = config('expedientes.dc');
            $txt_s_hv = config('expedientes.hv');
            $txt_a_ind = count($a_ind)>0 ? implode(",",$a_ind) : "0";
            $txt_a_co = count($a_co)>0 ? implode(",",$a_co) : "0";
            $txt_a_ee = count($a_ee)>0 ? implode(",",$a_ee) : "0";
            $txt_a_pr = count($a_pr)>0 ? implode(",",$a_pr) : "0";
            $txt_a_dc = count($a_dc)>0 ? implode(",",$a_dc) : "0";
            $txt_a_hv = count($a_hv)>0 ? implode(",",$a_hv) : "0";

            $query->whereRaw(\DB::raw("
                        (
                            (id_subserie in ($txt_s_ind) and id_entrevista in ($txt_a_ind))
                            or
                            (id_subserie in ($txt_s_co) and id_entrevista in ($txt_a_co))
                            or
                            (id_subserie in ($txt_s_ee) and id_entrevista in ($txt_a_ee))
                            or
                            (id_subserie in ($txt_s_pr) and id_entrevista in ($txt_a_pr))
                            or
                            (id_subserie in ($txt_s_dc) and id_entrevista in ($txt_a_dc))
                            or
                            (id_subserie in ($txt_s_hv) and id_entrevista in ($txt_a_hv))
                        )
                    "));
        }

    }
    public function scopeInteres($query, $id_criterio=-1) {
        $filtrar=false;
        if(is_array($id_criterio)) {
            if (!in_array(-1, $id_criterio)) {
                $filtrar = true;
            }
        }
        else {
            if($id_criterio>0) {
                $filtrar = true;
            }
        }
        if($filtrar) {
            $a_ind = entrevista_individual::interes($id_criterio)->id_activo(1)->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $a_co = entrevista_colectiva::interes($id_criterio)->id_activo(1)->pluck('entrevista_colectiva.id_entrevista_colectiva')->toArray();
            $a_ee = entrevista_etnica::interes($id_criterio)->id_activo(1)->pluck('entrevista_etnica.id_entrevista_etnica')->toArray();
            $a_pr = entrevista_profundidad::interes($id_criterio)->id_activo(1)->pluck('entrevista_profundidad.id_entrevista_profundidad')->toArray();
            $a_dc = diagnostico_comunitario::interes($id_criterio)->id_activo(1)->pluck('diagnostico_comunitario.id_diagnostico_comunitario')->toArray();
            $a_hv = historia_vida::interes($id_criterio)->id_activo(1)->pluck('historia_vida.id_historia_vida')->toArray();
            $s_ind[]=config('expedientes.vi');
            $s_ind[]=config('expedientes.aa');
            $s_ind[]=config('expedientes.tc');
            $txt_s_ind = implode(",",$s_ind);
            $txt_s_co = config('expedientes.co');
            $txt_s_ee = config('expedientes.ee');
            $txt_s_pr = config('expedientes.pr');
            $txt_s_dc = config('expedientes.dc');
            $txt_s_hv = config('expedientes.hv');
            $txt_a_ind = count($a_ind)>0 ? implode(",",$a_ind) : "0";
            $txt_a_co = count($a_co)>0 ? implode(",",$a_co) : "0";
            $txt_a_ee = count($a_ee)>0 ? implode(",",$a_ee) : "0";
            $txt_a_pr = count($a_pr)>0 ? implode(",",$a_pr) : "0";
            $txt_a_dc = count($a_dc)>0 ? implode(",",$a_dc) : "0";
            $txt_a_hv = count($a_hv)>0 ? implode(",",$a_hv) : "0";

            $query->whereRaw(\DB::raw("
                        (
                            (id_subserie in ($txt_s_ind) and id_entrevista in ($txt_a_ind))
                            or
                            (id_subserie in ($txt_s_co) and id_entrevista in ($txt_a_co))
                            or
                            (id_subserie in ($txt_s_ee) and id_entrevista in ($txt_a_ee))
                            or
                            (id_subserie in ($txt_s_pr) and id_entrevista in ($txt_a_pr))
                            or
                            (id_subserie in ($txt_s_dc) and id_entrevista in ($txt_a_dc))
                            or
                            (id_subserie in ($txt_s_hv) and id_entrevista in ($txt_a_hv))
                        )
                    "));
        }

    }
    public function scopeId_sector($query, $id_criterio=-1) {
        $filtrar=false;
        if(is_array($id_criterio)) {
            if (!in_array(-1, $id_criterio)) {
                $filtrar = true;
            }
        }
        else {
            if($id_criterio>0) {
                $filtrar = true;
            }
        }
        if($filtrar) {
            $a_ind = entrevista_individual::id_sector($id_criterio)->id_activo(1)->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $a_co = entrevista_colectiva::Id_sector($id_criterio)->id_activo(1)->pluck('entrevista_colectiva.id_entrevista_colectiva')->toArray();
            $a_ee = entrevista_etnica::id_sector($id_criterio)->id_activo(1)->pluck('entrevista_etnica.id_entrevista_etnica')->toArray();
            $a_pr = entrevista_profundidad::id_sector($id_criterio)->id_activo(1)->pluck('entrevista_profundidad.id_entrevista_profundidad')->toArray();
            $a_dc = diagnostico_comunitario::id_sector($id_criterio)->id_activo(1)->pluck('diagnostico_comunitario.id_diagnostico_comunitario')->toArray();
            $a_hv = historia_vida::id_sector($id_criterio)->id_activo(1)->pluck('historia_vida.id_historia_vida')->toArray();
            $s_ind[]=config('expedientes.vi');
            $s_ind[]=config('expedientes.aa');
            $s_ind[]=config('expedientes.tc');
            $txt_s_ind = implode(",",$s_ind);
            $txt_s_co = config('expedientes.co');
            $txt_s_ee = config('expedientes.ee');
            $txt_s_pr = config('expedientes.pr');
            $txt_s_dc = config('expedientes.dc');
            $txt_s_hv = config('expedientes.hv');
            $txt_a_ind = count($a_ind)>0 ? implode(",",$a_ind) : "0";
            $txt_a_co = count($a_co)>0 ? implode(",",$a_co) : "0";
            $txt_a_ee = count($a_ee)>0 ? implode(",",$a_ee) : "0";
            $txt_a_pr = count($a_pr)>0 ? implode(",",$a_pr) : "0";
            $txt_a_dc = count($a_dc)>0 ? implode(",",$a_dc) : "0";
            $txt_a_hv = count($a_hv)>0 ? implode(",",$a_hv) : "0";

            $query->whereRaw(\DB::raw("
                        (
                            (id_subserie in ($txt_s_ind) and id_entrevista in ($txt_a_ind))
                            or
                            (id_subserie in ($txt_s_co) and id_entrevista in ($txt_a_co))
                            or
                            (id_subserie in ($txt_s_ee) and id_entrevista in ($txt_a_ee))
                            or
                            (id_subserie in ($txt_s_pr) and id_entrevista in ($txt_a_pr))
                            or
                            (id_subserie in ($txt_s_dc) and id_entrevista in ($txt_a_dc))
                            or
                            (id_subserie in ($txt_s_hv) and id_entrevista in ($txt_a_hv))
                        )
                    "));
        }

    }
    public function scopeD_hecho_min($query, $id_criterio=-1) {
        $filtrar=false;
        if(is_array($id_criterio)) {
            if (!in_array(-1, $id_criterio)) {
                $filtrar = true;
            }
        }
        else {
            if($id_criterio>0) {
                $filtrar = true;
            }
        }
        if($filtrar) {
            $a_ind = entrevista_individual::d_hecho_min($id_criterio)->id_activo(1)->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $a_co = entrevista_colectiva::d_hecho_min($id_criterio)->id_activo(1)->pluck('entrevista_colectiva.id_entrevista_colectiva')->toArray();
            $a_ee = entrevista_etnica::d_hecho_min($id_criterio)->id_activo(1)->pluck('entrevista_etnica.id_entrevista_etnica')->toArray();
            $a_pr = entrevista_profundidad::d_hecho_min($id_criterio)->id_activo(1)->pluck('entrevista_profundidad.id_entrevista_profundidad')->toArray();
            $a_dc = diagnostico_comunitario::d_hecho_min($id_criterio)->id_activo(1)->pluck('diagnostico_comunitario.id_diagnostico_comunitario')->toArray();
            $a_hv = historia_vida::d_hecho_min($id_criterio)->id_activo(1)->pluck('historia_vida.id_historia_vida')->toArray();
            $s_ind[]=config('expedientes.vi');
            $s_ind[]=config('expedientes.aa');
            $s_ind[]=config('expedientes.tc');
            $txt_s_ind = implode(",",$s_ind);
            $txt_s_co = config('expedientes.co');
            $txt_s_ee = config('expedientes.ee');
            $txt_s_pr = config('expedientes.pr');
            $txt_s_dc = config('expedientes.dc');
            $txt_s_hv = config('expedientes.hv');
            $txt_a_ind = count($a_ind)>0 ? implode(",",$a_ind) : "0";
            $txt_a_co = count($a_co)>0 ? implode(",",$a_co) : "0";
            $txt_a_ee = count($a_ee)>0 ? implode(",",$a_ee) : "0";
            $txt_a_pr = count($a_pr)>0 ? implode(",",$a_pr) : "0";
            $txt_a_dc = count($a_dc)>0 ? implode(",",$a_dc) : "0";
            $txt_a_hv = count($a_hv)>0 ? implode(",",$a_hv) : "0";

            $query->whereRaw(\DB::raw("
                        (
                            (id_subserie in ($txt_s_ind) and id_entrevista in ($txt_a_ind))
                            or
                            (id_subserie in ($txt_s_co) and id_entrevista in ($txt_a_co))
                            or
                            (id_subserie in ($txt_s_ee) and id_entrevista in ($txt_a_ee))
                            or
                            (id_subserie in ($txt_s_pr) and id_entrevista in ($txt_a_pr))
                            or
                            (id_subserie in ($txt_s_dc) and id_entrevista in ($txt_a_dc))
                            or
                            (id_subserie in ($txt_s_hv) and id_entrevista in ($txt_a_hv))
                        )
                    "));
        }

    }
    public function scopeD_contexto_min($query, $id_criterio=-1) {
        $filtrar=false;
        if(is_array($id_criterio)) {
            if (!in_array(-1, $id_criterio)) {
                $filtrar = true;
            }
        }
        else {
            if($id_criterio>0) {
                $filtrar = true;
            }
        }
        if($filtrar) {
            $a_ind = entrevista_individual::d_contexto_min($id_criterio)->id_activo(1)->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $a_co = entrevista_colectiva::d_contexto_min($id_criterio)->id_activo(1)->pluck('entrevista_colectiva.id_entrevista_colectiva')->toArray();
            $a_ee = entrevista_etnica::d_contexto_min($id_criterio)->id_activo(1)->pluck('entrevista_etnica.id_entrevista_etnica')->toArray();
            $a_pr = entrevista_profundidad::d_contexto_min($id_criterio)->id_activo(1)->pluck('entrevista_profundidad.id_entrevista_profundidad')->toArray();
            $a_dc = diagnostico_comunitario::d_contexto_min($id_criterio)->id_activo(1)->pluck('diagnostico_comunitario.id_diagnostico_comunitario')->toArray();
            $a_hv = historia_vida::d_contexto_min($id_criterio)->id_activo(1)->pluck('historia_vida.id_historia_vida')->toArray();
            $s_ind[]=config('expedientes.vi');
            $s_ind[]=config('expedientes.aa');
            $s_ind[]=config('expedientes.tc');
            $txt_s_ind = implode(",",$s_ind);
            $txt_s_co = config('expedientes.co');
            $txt_s_ee = config('expedientes.ee');
            $txt_s_pr = config('expedientes.pr');
            $txt_s_dc = config('expedientes.dc');
            $txt_s_hv = config('expedientes.hv');
            $txt_a_ind = count($a_ind)>0 ? implode(",",$a_ind) : "0";
            $txt_a_co = count($a_co)>0 ? implode(",",$a_co) : "0";
            $txt_a_ee = count($a_ee)>0 ? implode(",",$a_ee) : "0";
            $txt_a_pr = count($a_pr)>0 ? implode(",",$a_pr) : "0";
            $txt_a_dc = count($a_dc)>0 ? implode(",",$a_dc) : "0";
            $txt_a_hv = count($a_hv)>0 ? implode(",",$a_hv) : "0";

            $query->whereRaw(\DB::raw("
                        (
                            (id_subserie in ($txt_s_ind) and id_entrevista in ($txt_a_ind))
                            or
                            (id_subserie in ($txt_s_co) and id_entrevista in ($txt_a_co))
                            or
                            (id_subserie in ($txt_s_ee) and id_entrevista in ($txt_a_ee))
                            or
                            (id_subserie in ($txt_s_pr) and id_entrevista in ($txt_a_pr))
                            or
                            (id_subserie in ($txt_s_dc) and id_entrevista in ($txt_a_dc))
                            or
                            (id_subserie in ($txt_s_hv) and id_entrevista in ($txt_a_hv))
                        )
                    "));
        }

    }
    public function scopeD_impacto_min($query, $id_criterio=-1) {
        $filtrar=false;
        if(is_array($id_criterio)) {
            if (!in_array(-1, $id_criterio)) {
                $filtrar = true;
            }
        }
        else {
            if($id_criterio>0) {
                $filtrar = true;
            }
        }
        if($filtrar) {
            $a_ind = entrevista_individual::d_impacto_min($id_criterio)->id_activo(1)->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $a_co = entrevista_colectiva::d_impacto_min($id_criterio)->id_activo(1)->pluck('entrevista_colectiva.id_entrevista_colectiva')->toArray();
            $a_ee = entrevista_etnica::d_impacto_min($id_criterio)->id_activo(1)->pluck('entrevista_etnica.id_entrevista_etnica')->toArray();
            $a_pr = entrevista_profundidad::d_impacto_min($id_criterio)->id_activo(1)->pluck('entrevista_profundidad.id_entrevista_profundidad')->toArray();
            $a_dc = diagnostico_comunitario::d_impacto_min($id_criterio)->id_activo(1)->pluck('diagnostico_comunitario.id_diagnostico_comunitario')->toArray();
            $a_hv = historia_vida::d_impacto_min($id_criterio)->id_activo(1)->pluck('historia_vida.id_historia_vida')->toArray();
            $s_ind[]=config('expedientes.vi');
            $s_ind[]=config('expedientes.aa');
            $s_ind[]=config('expedientes.tc');
            $txt_s_ind = implode(",",$s_ind);
            $txt_s_co = config('expedientes.co');
            $txt_s_ee = config('expedientes.ee');
            $txt_s_pr = config('expedientes.pr');
            $txt_s_dc = config('expedientes.dc');
            $txt_s_hv = config('expedientes.hv');
            $txt_a_ind = count($a_ind)>0 ? implode(",",$a_ind) : "0";
            $txt_a_co = count($a_co)>0 ? implode(",",$a_co) : "0";
            $txt_a_ee = count($a_ee)>0 ? implode(",",$a_ee) : "0";
            $txt_a_pr = count($a_pr)>0 ? implode(",",$a_pr) : "0";
            $txt_a_dc = count($a_dc)>0 ? implode(",",$a_dc) : "0";
            $txt_a_hv = count($a_hv)>0 ? implode(",",$a_hv) : "0";

            $query->whereRaw(\DB::raw("
                        (
                            (id_subserie in ($txt_s_ind) and id_entrevista in ($txt_a_ind))
                            or
                            (id_subserie in ($txt_s_co) and id_entrevista in ($txt_a_co))
                            or
                            (id_subserie in ($txt_s_ee) and id_entrevista in ($txt_a_ee))
                            or
                            (id_subserie in ($txt_s_pr) and id_entrevista in ($txt_a_pr))
                            or
                            (id_subserie in ($txt_s_dc) and id_entrevista in ($txt_a_dc))
                            or
                            (id_subserie in ($txt_s_hv) and id_entrevista in ($txt_a_hv))
                        )
                    "));
        }

    }
    public function scopeD_justicia_min($query, $id_criterio=-1) {
        $filtrar=false;
        if(is_array($id_criterio)) {
            if (!in_array(-1, $id_criterio)) {
                $filtrar = true;
            }
        }
        else {
            if($id_criterio>0) {
                $filtrar = true;
            }
        }
        if($filtrar) {
            $a_ind = entrevista_individual::d_justicia_min($id_criterio)->id_activo(1)->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $a_co = entrevista_colectiva::d_justicia_min($id_criterio)->id_activo(1)->pluck('entrevista_colectiva.id_entrevista_colectiva')->toArray();
            $a_ee = entrevista_etnica::d_justicia_min($id_criterio)->id_activo(1)->pluck('entrevista_etnica.id_entrevista_etnica')->toArray();
            $a_pr = entrevista_profundidad::d_justicia_min($id_criterio)->id_activo(1)->pluck('entrevista_profundidad.id_entrevista_profundidad')->toArray();
            $a_dc = diagnostico_comunitario::d_justicia_min($id_criterio)->id_activo(1)->pluck('diagnostico_comunitario.id_diagnostico_comunitario')->toArray();
            $a_hv = historia_vida::d_justicia_min($id_criterio)->id_activo(1)->pluck('historia_vida.id_historia_vida')->toArray();
            $s_ind[]=config('expedientes.vi');
            $s_ind[]=config('expedientes.aa');
            $s_ind[]=config('expedientes.tc');
            $txt_s_ind = implode(",",$s_ind);
            $txt_s_co = config('expedientes.co');
            $txt_s_ee = config('expedientes.ee');
            $txt_s_pr = config('expedientes.pr');
            $txt_s_dc = config('expedientes.dc');
            $txt_s_hv = config('expedientes.hv');
            $txt_a_ind = count($a_ind)>0 ? implode(",",$a_ind) : "0";
            $txt_a_co = count($a_co)>0 ? implode(",",$a_co) : "0";
            $txt_a_ee = count($a_ee)>0 ? implode(",",$a_ee) : "0";
            $txt_a_pr = count($a_pr)>0 ? implode(",",$a_pr) : "0";
            $txt_a_dc = count($a_dc)>0 ? implode(",",$a_dc) : "0";
            $txt_a_hv = count($a_hv)>0 ? implode(",",$a_hv) : "0";

            $query->whereRaw(\DB::raw("
                        (
                            (id_subserie in ($txt_s_ind) and id_entrevista in ($txt_a_ind))
                            or
                            (id_subserie in ($txt_s_co) and id_entrevista in ($txt_a_co))
                            or
                            (id_subserie in ($txt_s_ee) and id_entrevista in ($txt_a_ee))
                            or
                            (id_subserie in ($txt_s_pr) and id_entrevista in ($txt_a_pr))
                            or
                            (id_subserie in ($txt_s_dc) and id_entrevista in ($txt_a_dc))
                            or
                            (id_subserie in ($txt_s_hv) and id_entrevista in ($txt_a_hv))
                        )
                    "));
        }

    }

    public function scopeId_etnico($query, $id_criterio=-1) {
        //Este criterio aplica únicamente a entrevistas VI, CO, TC
        if($id_criterio > 0) {
            $a_ind = entrevista_individual::id_etnico($id_criterio)->id_activo(1)->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $txt_a_ind = count($a_ind)>0 ? implode(",",$a_ind) : "0";

            $s_ind[]=config('expedientes.vi');
            $s_ind[]=config('expedientes.aa');
            $s_ind[]=config('expedientes.tc');
            $txt_s_ind = implode(",",$s_ind);
            $s_otros[] = config('expedientes.co');
            $s_otros[] = config('expedientes.ee');
            $s_otros[] = config('expedientes.pr');
            $s_otros[] = config('expedientes.dc');
            $s_otros[] = config('expedientes.hv');
            $txt_s_otros = implode(",",$s_otros);



            $query->whereRaw(\DB::raw("
                        (
                            (id_subserie in ($txt_s_ind) and id_entrevista in ($txt_a_ind))
                            or
                            (id_subserie in ($txt_s_otros))                           
                        )
                    "));
        }

    }

    // URL para el show.  Lo uso en la tabla de prioridades
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
    public function getEntrevistaCodigoAttribute() {
        $e = $this->entrevista;
        if($e) {
            //dd($e);
            $url = $e->url;
            $cod = $e->entrevista->entrevista_codigo;
            $link = "<a href='$url' target='_blank'>$cod</a>";
            return $link;
        }
        else {
            return "XX";
        }
    }

    public function getFmtIdEtiquetaAttribute() {
        $t = tesauro::id_etiqueta($this->id_etiqueta)->first();
        return tesauro::nombre_completo($t->id_geo, true);
    }

    //Visualización de packed circles
    public static function json_jerarquico($quitar_entidades=false) {

        $query = tesauro::where('nivel',1);
        if($quitar_entidades) {
            $query->where('codigo', '<>', '000000');
        }
        $n1 = $query->get();
        //dd($n1);
        $estructura=array();  //Arreglo de datos final
        //Nodo raiz
        $nodo = new \stdClass();
        $nodo->id = 1;
        $nodo->name = "Tesauro";
        $estructura[]=$nodo;
        //Primer nivel
        foreach($n1 as $fila_n1) {
            $nodo = new \stdClass();
            $nodo->id = $fila_n1->id_geo;
            $nodo->name = $fila_n1->etiqueta;
            $nodo->parent = 1;
            $estructura[]=$nodo;
            ///Hijos
            $hijos = tesauro::where('id_padre',$fila_n1->id_geo)->get();
            foreach($hijos as $fila_n2) {
                $nodo = new \stdClass();
                $nodo->id = $fila_n2->id_geo;
                $nodo->name = $fila_n2->etiqueta;
                $nodo->parent = $fila_n2->id_padre;
                $entrevistas = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','=','tesauro.id_etiqueta')
                                    ->where('tesauro.id_geo',$fila_n2->id_geo)
                                    ->selectraw(\DB::raw('distinct id_subserie, id_entrevista'))->get();
                $nodo->size =  count($entrevistas);
                $estructura[]=$nodo;
                //Nietos
                $nietos = tesauro::where('id_padre',$fila_n2->id_geo)->get();
                foreach($nietos as $fila_n3) {
                    $nodo = new \stdClass();
                    $nodo->id = $fila_n3->id_geo;
                    $nodo->name = $fila_n3->etiqueta;
                    $nodo->parent = $fila_n3->id_padre;
                    $entrevistas = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','=','tesauro.id_etiqueta')
                        ->where('tesauro.id_geo',$fila_n3->id_geo)
                        ->selectraw(\DB::raw('distinct id_subserie, id_entrevista'))
                        ->get();
                    $nodo->size =  count($entrevistas);
                        $estructura[]=$nodo;



                }
            }
        }
        return $estructura;
    }

    /**
     * Aprovecha los conteos realizados para el tesauro comparativo en la generación del gráfico
     * @param false $quitar_entidades
     * @param $conteos
     * @return array
     */
    public static function json_jerarquico_comparado($quitar_entidades=false, $conteos) {

        $query = tesauro::where('nivel',1);
        if($quitar_entidades) {
            $query->where('codigo', '<>', '000000');
        }
        $n1 = $query->get();
        //dd($n1);
        $estructura=array();  //Arreglo de datos final
        //Nodo raiz
        $nodo = new \stdClass();
        $nodo->id = 1;
        $nodo->name = "Tesauro";
        $estructura[]=$nodo;
        //Primer nivel
        foreach($n1 as $fila_n1) {
            $nodo = new \stdClass();
            $nodo->id = $fila_n1->id_geo;
            $nodo->name = $fila_n1->etiqueta;
            $nodo->parent = 1;
            $aplicaciones=isset($conteos[$fila_n1->id_etiqueta]) ?  $conteos[$fila_n1->id_etiqueta] : 0;
            $nodo->size =  $aplicaciones;
            $estructura[]=$nodo;
            ///Hijos
            $hijos = tesauro::where('id_padre',$fila_n1->id_geo)->get();
            foreach($hijos as $fila_n2) {
                $nodo = new \stdClass();
                $nodo->id = $fila_n2->id_geo;
                $nodo->name = $fila_n2->etiqueta;
                $nodo->parent = $fila_n2->id_padre;
                $aplicaciones=isset($conteos[$fila_n2->id_etiqueta]) ?  $conteos[$fila_n2->id_etiqueta] : 0;
                $nodo->size =  $aplicaciones;
                $estructura[]=$nodo;
                //Nietos
                $nietos = tesauro::where('id_padre',$fila_n2->id_geo)->get();
                foreach($nietos as $fila_n3) {
                    $nodo = new \stdClass();
                    $nodo->id = $fila_n3->id_geo;
                    $nodo->name = $fila_n3->etiqueta;
                    $nodo->parent = $fila_n3->id_padre;
                    $aplicaciones=isset($conteos[$fila_n3->id_etiqueta]) ?  $conteos[$fila_n3->id_etiqueta] : 0;
                    $nodo->size =  $aplicaciones;
                    $estructura[]=$nodo;
                }
            }
        }
        return $estructura;
    }

    //Visualización de packed circles po entrevista
    public static function json_jerarquico_entrevista_ok( $id_subserie=0, $id_entrevista=0, $quitar_entidades=true) {

        $query = tesauro::where('nivel',1)->orderby('codigo');
        if($quitar_entidades) {
            $query->where('codigo', '<>', '000000');
        }
        $n1 = $query->get();
        //dd($n1);
        $estructura=array();  //Arreglo de datos final
        //Nodo raiz
        $nodo = new \stdClass();
        $nodo->id = 1;
        $nodo->name = "Tesauro";
        $estructura[]=$nodo;
        //Primer nivel
        foreach($n1 as $fila_n1) {
            $nodo = new \stdClass();
            $nodo->id = $fila_n1->id_geo;
            $nodo->name = $fila_n1->etiqueta;
            $nodo->parent = 1;
            //Peso de todos los hijos y nietos
            $codigo=substr($fila_n1->codigo,0,2);
            $conteo = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','=','tesauro.id_etiqueta')
                                                ->where('etiqueta_entrevista.id_subserie',$id_subserie)
                                                ->where('etiqueta_entrevista.id_entrevista',$id_entrevista)
                                                ->where('tesauro.codigo','ilike',"$codigo%")
                                                ->count();
            $nodo->size = $conteo;
            $estructura[]=$nodo;
            ///Hijos
            $hijos = tesauro::where('id_padre',$fila_n1->id_geo)->orderby('codigo')->get();
            foreach($hijos as $fila_n2) {
                $nodo = new \stdClass();
                $nodo->id = $fila_n2->id_geo;
                $nodo->name = $fila_n2->etiqueta;
                $nodo->parent = $fila_n2->id_padre;
                $entrevistas = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','=','tesauro.id_etiqueta')
                                ->where('etiqueta_entrevista.id_subserie',$id_subserie)
                                ->where('etiqueta_entrevista.id_entrevista',$id_entrevista)
                    ->where('tesauro.id_geo',$fila_n2->id_geo)
                    ->get();
                $nodo->size =  count($entrevistas);
                $estructura[]=$nodo;
                //Nietos
                $nietos = tesauro::where('id_padre',$fila_n2->id_geo)->orderby('codigo')->get();
                foreach($nietos as $fila_n3) {
                    $nodo = new \stdClass();
                    $nodo->id = $fila_n3->id_geo;
                    $nodo->name = $fila_n3->etiqueta;
                    $nodo->parent = $fila_n3->id_padre;
                    $entrevistas = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','=','tesauro.id_etiqueta')
                        ->where('tesauro.id_geo',$fila_n3->id_geo)
                        ->where('etiqueta_entrevista.id_subserie',$id_subserie)
                        ->where('etiqueta_entrevista.id_entrevista',$id_entrevista)
                        ->get();
                    $nodo->size =  count($entrevistas);
                    $estructura[]=$nodo;



                }
            }
        }
        //dd($estructura);
        return json_encode($estructura);
    }

    //Visualización de packed circles por entrevista.  Versión mejorada: produce estructura reducida
    public static function json_jerarquico_entrevista( $id_subserie=0, $id_entrevista=0, $quitar_entidades=true) {

        $n1_usados=array();
        $n2_usados=array();
        $n3_usados=array();

        //dd($n1);
        $estructura=array();  //Arreglo de datos final
        //Nodo raiz
        $nodo = new \stdClass();
        $nodo->id = 1;
        $nodo->name = "Árbol de etiquetas";
        $estructura[]=$nodo;
        //Primer nivel: determinar cuales son necesarios
        $listado_n1 = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','=','tesauro.id_etiqueta')
            ->where('etiqueta_entrevista.id_subserie',$id_subserie)
            ->where('etiqueta_entrevista.id_entrevista',$id_entrevista)
            ->distinct()
            ->select(\DB::raw("substr(tesauro.codigo,1,2) as codigo") )
            ->get();
        $filtro=array();
        foreach($listado_n1 as $fila) {
            $filtro[]=$fila->codigo."0000";
        }
        //dd($filtro);
        $query = tesauro::where('nivel',1)->wherein('codigo',$filtro)->orderby('codigo');
        if($quitar_entidades) {
            $query->where('codigo', '<>', '000000');
        }
        $n1_usados = $query->pluck('id_geo');
        //Segundo nivel: determinar cuales son necesarios
        $listado_n2 = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','=','tesauro.id_etiqueta')
            ->where('etiqueta_entrevista.id_subserie',$id_subserie)
            ->where('etiqueta_entrevista.id_entrevista',$id_entrevista)
            ->distinct()
            ->select(\DB::raw("substr(tesauro.codigo,1,4) as codigo") )
            ->get();
        $filtro=array();
        foreach($listado_n2 as $fila) {
            $filtro[]=$fila->codigo."00";
        }
        //dd($filtro);
        $query = tesauro::where('nivel',2)->wherein('codigo',$filtro)->orderby('codigo');
        if($quitar_entidades) {
            $query->where('codigo', '<>', '000000');
        }
        $n2_usados = $query->pluck('id_geo');
        //dd($n2_usados);
        //Tercer nivel: determinar cuales son necesarios
        $n3_usados = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','=','tesauro.id_etiqueta')
            ->where('etiqueta_entrevista.id_subserie',$id_subserie)
            ->where('etiqueta_entrevista.id_entrevista',$id_entrevista)
            ->distinct()
            ->where('nivel',3)
            ->pluck('tesauro.codigo');

        //dd($n3_usados);



        $n1 = tesauro::wherein('id_geo',$n1_usados)->orderby('codigo')->get();

        foreach($n1 as $fila_n1) {
            $nodo = new \stdClass();
            $nodo->id = $fila_n1->id_geo;
            $nodo->name = $fila_n1->etiqueta;
            $nodo->parent = 1;
            //Peso
            //$codigo=substr($fila_n1->codigo,0,2);
            $conteo = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','=','tesauro.id_etiqueta')
                ->where('etiqueta_entrevista.id_subserie',$id_subserie)
                ->where('etiqueta_entrevista.id_entrevista',$id_entrevista)
                //->where('tesauro.codigo','ilike',"$codigo%")
                ->where('tesauro.id_geo','=',$fila_n1->id_geo)
                ->count();
            $nodo->size = $conteo;
            $estructura[]=$nodo;
            ///Hijos
            $hijos = tesauro::where('id_padre',$fila_n1->id_geo)->wherein('id_geo',$n2_usados)->orderby('codigo')->get();
            foreach($hijos as $fila_n2) {
                $nodo = new \stdClass();
                $nodo->id = $fila_n2->id_geo;
                $nodo->name = $fila_n2->etiqueta;
                $nodo->parent = $fila_n2->id_padre;
                $conteo = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','=','tesauro.id_etiqueta')
                    ->where('etiqueta_entrevista.id_subserie',$id_subserie)
                    ->where('etiqueta_entrevista.id_entrevista',$id_entrevista)
                    ->where('tesauro.id_geo',$fila_n2->id_geo)
                    ->count();
                $nodo->size =  $conteo;
                $estructura[]=$nodo;
                //Nietos
                $nietos = tesauro::where('id_padre',$fila_n2->id_geo)->wherein('id_geo',$n3_usados)->orderby('codigo')->get();
                foreach($nietos as $fila_n3) {
                    $nodo = new \stdClass();
                    $nodo->id = $fila_n3->id_geo;
                    $nodo->name = $fila_n3->etiqueta;
                    $nodo->parent = $fila_n3->id_padre;
                    $entrevistas = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','=','tesauro.id_etiqueta')
                        ->where('tesauro.id_geo',$fila_n3->id_geo)
                        ->where('etiqueta_entrevista.id_subserie',$id_subserie)
                        ->where('etiqueta_entrevista.id_entrevista',$id_entrevista)
                        ->get();
                    $nodo->size =  count($entrevistas);
                    $estructura[]=$nodo;



                }
            }
        }
        //dd($estructura);
        return json_encode($estructura);
    }


    //Para el excel integrado
    public static function conteo_etiquetas($fila) {
        return etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','tesauro.id_etiqueta')
                            ->where('etiqueta_entrevista.codigo',$fila->entrevista_codigo)
                            ->count();
    }

}
