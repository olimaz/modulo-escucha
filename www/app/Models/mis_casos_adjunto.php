<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id_mis_casos_adjunto
 * @property int $id_mis_casos
 * @property int $id_seccion
 * @property int $id_categoria
 * @property int $clasificacion_nivel
 * @property int $id_adjunto
 * @property string $descripcion
 * @property string $anotaciones
 * @property string $fh_insert
 * @property int $correlativo_caso
 * @property string codigo_adjunto
 *
 * @property Esclarecimiento.misCaso $esclarecimiento.misCaso
 * @property Catalogos.catItem $catalogos.catItem
 * @property Esclarecimiento.adjunto $esclarecimiento.adjunto
 */
class mis_casos_adjunto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.mis_casos_adjunto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_mis_casos_adjunto';

    /**
     * @var array
     */
    protected $fillable = ['id_mis_casos', 'id_seccion', 'id_categoria', 'clasificacion_nivel', 'id_adjunto', 'descripcion', 'fh_insert','anotaciones'];

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
    public function rel_id_mis_casos()
    {
        return $this->belongsTo(mis_casos::class, 'id_mis_casos', 'id_mis_casos');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_seccion()
    {
        return $this->belongsTo(cat_item::class, 'id_seccion', 'id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_adjunto()
    {
        return $this->belongsTo(adjunto::class, 'id_adjunto', 'id_adjunto');
    }


    //Getters
    public function getFmtIdSeccionAttribute() {
        return cat_item::describir($this->id_seccion);
    }
    public function getFmtIdCategoriaAttribute() {
        return cat_item::describir($this->id_categoria);
    }
    public function getFmtClasificacionNivelAttribute() {
        return "[R-$this->clasificacion_nivel]";
    }
    public function getLinkAttribute() {
        $adjunto = $this->rel_id_adjunto;
        if($adjunto) {
            $nombre = $adjunto->nombre_mc;
            $nombre_descarga = $adjunto->nombre_descarga($nombre); //Le agrega el nombre original
            $ubica="public/".$adjunto->ubicacion;
            if(Storage::exists($ubica)) {
                if($this->clasificacion_nivel==4) {
                    $link = action('adjuntoController@show_mc',$adjunto->id_adjunto);
                    $url = "<a target='_blank' href='".$link."'>$adjunto->nombre_original</a>";
                }
                else {
                    if(in_array($this->rel_id_mis_casos->privilegios,[1,3])) {  //Propietario o administrador
                        $link = action('adjuntoController@show_mc',$adjunto->id_adjunto);
                        $url = "<a target='_blank' href='".$link."'>$adjunto->nombre_original</a>";
                    }
                    else {
                        $url = "(Acceso restringido $adjunto->clasificacion_nivel)";
                    }
                }
            }
            else {
                $url = $nombre;
            }
        }
        else {
            $url = "Adjunto ($this->id_adjunto) no encontrado";
        }
        return $url;
    }
    //Para la edicion, determinar id_categoria a partir de id_seccion
    public function cual_categoria() {
        $seccion=criterio_fijo::where('id_grupo',50)->where('id_opcion',$this->id_seccion)->first();
        //$seccion=cat_item::find($this->id_seccion);
        if($seccion) {
            $id_categoria = $seccion->texto;
        }
        return $id_categoria;
    }
    //Para la edicion
    public function getNombreArchivoAttribute() {
        $existe=$this->rel_id_adjunto;
        if($existe) {
            return $existe->ubicacion;
        }
        else {
            return null;
        }
    }

    //Para la creacion de uno nuevo
    public  function valores_predeterminados() {
        $this->clasificacion_nivel=4;
    }

    //Saber que tipos de documento se reciben en cada sección
    public static function catalogo_seccion($id_seccion) {
        $c[1]=103;
        $c[2]=104;
        $c[3]=106;
        $c[4]=105;
        return $c[$id_seccion];
    }

    //Correlativo para el adjunto
    public function cual_toca() {
        $max=self::where('id_mis_casos',$this->id_mis_casos)
            ->max('correlativo_caso');
        $nuevo=intval($max)+1;
        return $nuevo;
    }
    public function calcular_codigo() {
        if(intval($this->correlativo_caso) == 0) {
            $this->correlativo_caso = $this->cual_toca();
        }
        $caso = $this->rel_id_mis_casos;
        $codigo = $caso->entrevista_codigo."-".str_pad($this->correlativo_caso,5,"0",STR_PAD_LEFT);
        return $codigo;
    }

    public static function calcular_codigos() {
        $listado = self::orderby('id_mis_casos_adjunto')->get();
        $total=0;
        foreach($listado as $fila) {
            $fila->correlativo_caso=0;
            $fila->codigo_adjunto = $fila->calcular_codigo();
            $fila->save();
            $total++;
        }
        return $total;
    }

    //Calificar según el nivel
    public function calificar() {
        //Niveles de calificacion según el nivel de clasificacion
        $calificacion[1]=3;  // los R-1 se considerar publicos reservados
        $calificacion[2]=2; // los R-2 se considerar publicos clasificados
        $calificacion[3]=2;  // Los R-3 se consdieran publicos clasificados
        $calificacion[4]=1; // Los R-4 se consideran públicos
        //Justificaciones
        $justificacion[4]=[]; //No requiere justificacion
        $justificacion[3]=[1,2,3];
        $justificacion[2]=[1,2,3];
        $justificacion[1]=[6,10];
        //Calificar adjunto
        $adjunto = adjunto::find($this->id_adjunto);
        $adjunto->id_calificacion = $calificacion[$this->clasificacion_nivel];
        $adjunto->save();
        foreach($justificacion[$this->clasificacion_nivel] as $id_justificacion) {
            $tmp = new adjunto_justificacion();
            $tmp->id_adjunto = $this->id_adjunto;
            $tmp->id_justificacion=$id_justificacion;
            $tmp->save();
        }
        return $calificacion[$this->clasificacion_nivel];
    }
}
