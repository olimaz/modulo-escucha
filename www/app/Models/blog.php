<?php

namespace App\Models;

use Eloquent as Model;
use Html2Text\Html2Text;
use Stevebauman\Purify\Facades\Purify;


/**
 * Class blog
 * @package App\Models
 * @version June 19, 2020, 12:24 pm -05
 *
 * @property \App\Models\Esclarecimiento.entrevistador idEntrevistador
 * @property \Illuminate\Database\Eloquent\Collection esclarecimiento.misCasos
 * @property integer id_entrevistador
 * @property string|\Carbon\Carbon fecha_hora
 * @property string titulo
 * @property string html
 * @property string texto
 * @property integer id_activo
 * @property integer id_blog_respondido
 * @property string|\Carbon\Carbon fh_update
 */
class blog extends Model
{

    public $table = 'esclarecimiento.blog';
    
    public $timestamps = false;

    protected $dateFormat = 'Y-m-d H:i:s.u';



    protected $primaryKey = 'id_blog';

    public $fillable = [
        'id_entrevistador',
        'fecha_hora',
        'titulo',
        'html',
        'texto',
        'id_activo',
        'id_blog_respondido',
        'fh_update'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_blog' => 'integer',
        'id_entrevistador' => 'integer',
        'fecha_hora' => 'datetime',
        'titulo' => 'string',
        'html' => 'string',
        'texto' => 'string',
        'id_activo' => 'integer',
        'id_blog_respondido' => 'integer',
        'fh_update' => 'datetime'
    ];


    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'html' => 'required',
        'titulo' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_entrevistador()
    {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador','id_entrevistador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function rel_mis_casos()
    {
        return $this->belongsToMany(mis_casos_blog::class, 'id_blog','id_blog');
    }

    public  static function extraer_texto($html) {
        $html = new Html2Text($html,['width'=>0]);
        $txt = $html->getText(0);
        return $txt;
    }

    public function getFmtFechaAttribute() {
        return $this->fecha_hora->formatLocalized("%a %d-%B-%Y");
    }
    public function getFmtHoraAttribute() {

        return $this->fecha_hora->format("H:i");
    }
    public function getFmtIdEntrevistadorAttribute() {
        $quien = $this->rel_id_entrevistador;
        if($quien) {
            return $quien->nombre;
        }
        else {
            return "Desconocido";
        }
    }

    //Limpiar el html
    public function setHtmlAttribute($val) {
        $this->attributes['html']=blog::limpiar_html($val);
    }

    public static function limpiar_html($html="") {
        $limpio=$html;
        //$limpio = html_entity_decode($html); //Laravel hace un encode
        //$limpio =  preg_replace('/<!--(.|\s)*?-->/', '', $limpio);
        //$limpio = Purify::clean($limpio);
        return $limpio;
    }
}
