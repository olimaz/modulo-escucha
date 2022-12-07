<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use setasign\FpdiProtection\FpdiProtection;
use Uvinum\PDFWatermark\Pdf;
use Uvinum\PDFWatermark\Watermark;
use Uvinum\PDFWatermark\FpdiPdfWatermarker as PDFWatermarker;
use Uvinum\PDFWatermark\Position;

use GuzzleHttp\Client;


/**
 * Class adjunto
 * @package App\Models
 * @version April 17, 2019, 5:25 pm -05
 *
 * @property \Illuminate\Database\Eloquent\Collection esclarecimiento.eIndFvtAdjuntos
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property string ubicacion
 * @property number id_calificacion
 * @property string nombre_original
 * @property string md5
 */
class adjunto extends Model
{

    public $table = 'esclarecimiento.adjunto';
    protected $primaryKey = 'id_adjunto';
    
    public $timestamps = false;



    public $fillable = [
        'ubicacion','nombre_original','id_calificacion'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_adjunto' => 'integer',
        'ubicacion' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_adjunto' => 'required'
    ];

    //Detalles
    public function rel_entrevista() {
        return $this->belongsTo(entrevista_individual_adjunto::class,'id_adjunto','id_adjunto');
    }
    public function rel_entrevista_individual() {
        return $this->belongsTo(entrevista_individual_adjunto::class,'id_adjunto','id_adjunto');
    }
    public function rel_caso() {
        return $this->belongsTo(casos_informes_adjunto::class,'id_adjunto','id_adjunto');
    }
    public function rel_entrevista_colectiva() {
        return $this->belongsTo(entrevista_colectiva_adjunto::class,'id_adjunto','id_adjunto');
    }
    public function rel_entrevista_profundidad() {
        return $this->belongsTo(entrevista_profundidad_adjunto::class,'id_adjunto','id_adjunto');
    }
    public function rel_historia_vida() {
        return $this->belongsTo(historia_vida_adjunto::class,'id_adjunto','id_adjunto');
    }
    public function rel_diagnostico_comunitario() {
        return $this->belongsTo(diagnostico_comunitario_adjunto::class,'id_adjunto','id_adjunto');
    }
    public function rel_entrevista_etnica() {
        return $this->belongsTo(entrevista_etnica_adjunto::class,'id_adjunto','id_adjunto');
    }
    public function rel_mis_casos() {
        return $this->belongsTo(mis_casos_adjunto::class,'id_adjunto','id_adjunto');
    }
    public function rel_censo_archivos() {
        return $this->belongsTo(censo_archivos_adjunto::class,'id_adjunto','id_adjunto');
    }
    public function rel_excel_listados() {
        return $this->belongsTo(excel_listados::class,'id_adjunto','id_adjunto');
    }
    public function rel_documento() {
        return $this->belongsTo(documento::class, 'id_adjunto','id_adjunto');
    }
    public function rel_reservado_acceso() {
        return $this->belongsTo(reservado_acceso::class, 'id_adjunto','id_adjunto');
    }
    //Calificacion de acceso
    public function rel_id_calificacion() {
        return $this->belongsTo(criterio_fijo::class,'id_calificacion','id_opcion')->where('id_grupo',125);
    }
    public function rel_justificacion() {
        return $this->hasMany(adjunto_justificacion::class,'id_adjunto','id_adjunto')->orderBy('id_justificacion');
    }

    public function getArregloJustificacionAttribute() {
        return  $this->rel_justificacion()->pluck('id_justificacion')->toArray();
    }
    //Igual que el anterior, pero para inteligencia no es un arreglo, sino que un valor
    public function getJustificacionAttribute() {
        $arreglo = $this->arreglo_justificacion;
        if(count($arreglo)>0) {
            return $arreglo[0];
        }
    }



    public function getEntrevistaAttribute() {
        //Individual
        $e = $this->rel_entrevista_individual;
        if($e) {
            $r = $e->rel_id_e_ind_fvt;

            return $r;
        }
        //Colectiva
        $e = $this->rel_entrevista_colectiva;
        if($e) {
            $r = $e->rel_id_entrevista_colectiva;
            $r->id_subserie=config('expedientes.co');
            return $r;
        }
        //Etnica
        $e = $this->rel_entrevista_etnica;
        if($e) {
            $r = $e->rel_id_entrevista_etnica;
            $r->id_subserie=config('expedientes.ee');
            return $r;
        }
        //Profundidad
        $e = $this->rel_entrevista_profundidad;
        if($e) {
            $r= $e->rel_id_entrevista_profundidad;
            $r->id_subserie=config('expedientes.pr');
            return $r;
        }
        //Diagnostico
        $e = $this->rel_diagnostico_comunitario;
        if($e) {
            $r= $e->rel_id_diagnostico_comunitario;
            $r->id_subserie=config('expedientes.dc');
            return $r;
        }
        //HistoriaVida
        $e = $this->rel_historia_vida;
        if($e) {
            $r= $e->rel_id_historia_vida;
            $r->id_subserie=config('expedientes.hv');
            return $r;
        }
        //CasosInformes
        $e = $this->rel_caso;
        if($e) {
            $r= $e->rel_id_casos_informes;
            $r->id_subserie=config('expedientes.ci');
            return $r;
        }
        //Casos transversales
        $e = $this->rel_mis_casos;
        if($e) {
            $r= $e->rel_id_mis_casos;
            $r->id_subserie=config('expedientes.mc');
            return $r;
        }
        //archivos en el exilio
        $e = $this->rel_censo_archivos;
        if($e) {
            $r= $e->rel_id_censo_archivos;
            $r->id_subserie=config('expedientes.ca');
            return $r;
        }

        //Documentos de referencia
        $e = $this->rel_documento;
        if($e) {
            $r = $e;
            $r->id_subserie = '1';
            return $r;
        }

        //Autorizacion de acceso
        $e = $this->rel_reservado_acceso;
        if($e) {
            $e->id_subserie='2';
            return  $e;
        }


        return false;

    }

    public function getTipoAdjuntoAttribute() {
        //Individual
        $e = $this->rel_entrevista_individual;
        if($e) {
            return criterio_fijo::describir(1,$e->id_tipo);
        }
        //Colectiva
        $e = $this->rel_entrevista_colectiva;
        if($e) {
            return criterio_fijo::describir(1,$e->id_tipo);
        }
        //Etnica
        $e = $this->rel_entrevista_etnica;
        if($e) {
            return criterio_fijo::describir(1,$e->id_tipo);
        }
        //Profundidad
        $e = $this->rel_entrevista_profundidad;
        if($e) {
            return criterio_fijo::describir(1,$e->id_tipo);
        }
        //Diagnostico
        $e = $this->rel_diagnostico_comunitario;
        if($e) {
            return criterio_fijo::describir(1,$e->id_tipo);
        }
        //HistoriaVida
        $e = $this->rel_historia_vida;
        if($e) {
            return criterio_fijo::describir(1,$e->id_tipo);
        }
        //CasosInformes
        $e = $this->rel_caso;
        if($e) {
            return criterio_fijo::describir(1,$e->id_tipo);
        }

        //Mis casos
        $e = $this->rel_mis_casos;
        if($e) {
            return $e->fmt_id_categoria;
        }

        //Archivos en el exilio
        $e = $this->rel_censo_archivos;
        if($e) {
            return criterio_fijo::describir(1,$e->id_tipo);
        }

        //Documentos
        $e = $this->rel_documento;
        if($e) {
            return "Documento de referencia";
        }


        return "Desconocido";

    }

    //Para el legado
    public function getCodigoAdjuntoAttribute() {
        $legado = new legado();
        //Individual
        $e = $this->rel_entrevista_individual;
        if($e) {
            return $legado->a_codigos[$e->id_tipo] ?? $e->id_tipo;
        }
        //Colectiva
        $e = $this->rel_entrevista_colectiva;
        if($e) {
            return $legado->a_codigos[$e->id_tipo] ?? $e->id_tipo;
        }
        //Etnica
        $e = $this->rel_entrevista_etnica;
        if($e) {
            return isset($legado->a_codigos[$e->id_tipo])  ? $legado->a_codigos[$e->id_tipo] : $e->id_tipo;
        }
        //Profundidad
        $e = $this->rel_entrevista_profundidad;
        if($e) {
            return $legado->a_codigos[$e->id_tipo] ?? $e->id_tipo;
        }
        //Diagnostico
        $e = $this->rel_diagnostico_comunitario;
        if($e) {
            return $legado->a_codigos[$e->id_tipo] ?? $e->id_tipo;
        }
        //HistoriaVida
        $e = $this->rel_historia_vida;
        if($e) {
            return $legado->a_codigos[$e->id_tipo] ?? $e->id_tipo;
        }
        //CasosInformes
        $e = $this->rel_caso;
        if($e) {
            return $legado->a_codigos[$e->id_tipo] ?? $e->id_tipo;
        }

        //Mis casos
        $e = $this->rel_mis_casos;
        if($e) {
            return 'CI';
        }

        //Archivos en el exilio
        $e = $this->rel_censo_archivos;
        if($e) {
            return "CA";
        }

        //Documentos
        $e = $this->rel_documento;
        if($e) {
            return "DOC";
        }
        $e = $this->rel_reservado_acceso;
        if($e) {
            return "AUT";
        }



        return "DESC";

    }


    //Para cualquier adjunto, sin saber a donde está adjuntado
    public function getNombreAdjuntoAttribute() {
        $nombre= $this->nombre_original ? $this->nombre_original : substr($this->ubicacion,8);

        //$nombre = $codigo;
        $nombre = self::stripAccents($nombre);
        return $nombre;
    }

    //Nombrar el adjunto con codigo, tipo, id. Entrevistas VI y Casos Informes
    public function getNombreAttribute() {
        $codigo="eee-VI-00000";
        $tipo="desconocido";
        $donde = entrevista_individual_adjunto::where('id_adjunto',$this->id_adjunto)->first();
        if($donde) {
            $entrevista = $donde->rel_id_e_ind_fvt;
            $codigo=$entrevista->entrevista_codigo;
            $tipo=criterio_fijo::describir(1,$donde->id_tipo);
        }
        else {

            $donde = casos_informes_adjunto::where('id_adjunto',$this->id_adjunto)->first();

            if($donde) {
                $caso = $donde->rel_id_casos_informes;
                $codigo=$caso->codigo;
                $tipo=criterio_fijo::describir(1,$donde->id_tipo);
            }
            else {
                $doc = documento::where('id_adjunto',$this->id_adjunto)->first();
                if($doc) {
                    $codigo = "ref";
                    $tipo=$doc->descripcion;
                }
                else {
                    $donde = entrevista_profundidad_adjunto::where('id_adjunto',$this->id_adjunto)->first();
                    if($donde) {
                        $entrevista = $donde->rel_id_entrevista_profundidad;
                        $codigo=$entrevista->entrevista_codigo;
                        $tipo=criterio_fijo::describir(1,$donde->id_tipo);
                    }
                    else {
                        $donde = entrevista_etnica_adjunto::where('id_adjunto',$this->id_adjunto)->first();
                        if($donde) {
                            $entrevista = $donde->rel_id_entrevista_etnica;
                            $codigo=$entrevista->entrevista_codigo;
                            $tipo=criterio_fijo::describir(1,$donde->id_tipo);
                        }
                    }
                }

            }
        }

        $info=pathinfo($this->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = ".txt";
        }

        $nombre = $codigo."_(".$this->id_adjunto.")_".$tipo.".".$ext;
        $nombre = self::stripAccents($nombre);

        return $nombre;

    }

    //Nombrar el adjunto con codigo, tipo, id. Entrevistas CO
    public function getNombreCoAttribute() {
        $codigo="EEE-CO-xxxxx";
        $tipo="desconocido";
        $donde = entrevista_colectiva_adjunto::where('id_adjunto',$this->id_adjunto)->first();
        if($donde) {
            $entrevista = $donde->rel_id_entrevista_colectiva;
            $codigo=$entrevista->entrevista_codigo;
            $tipo=criterio_fijo::describir(1,$donde->id_tipo);
        }
        $info=pathinfo($this->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = ".txt";
        }

        $nombre = $codigo."_(".$this->id_adjunto.")_".$tipo.".".$ext;
        $nombre = self::stripAccents($nombre);

        return $nombre;
    }

    //Nombrar el adjunto con codigo, tipo, id. Entrevistas EE
    public function getNombreEeAttribute() {
        $codigo="eee-EE-xxxxx";
        $tipo="desconocido";
        $donde = entrevista_etnica_adjunto::where('id_adjunto',$this->id_adjunto)->first();
        if($donde) {
            $entrevista = $donde->rel_id_entrevista_etnica;
            $codigo=$entrevista->entrevista_codigo;
            $tipo=criterio_fijo::describir(1,$donde->id_tipo);
        }
        $info=pathinfo($this->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = ".txt";
        }
        $nombre = $codigo."_(".$this->id_adjunto.")_".$tipo.".".$ext;
        $nombre = self::stripAccents($nombre);
        return $nombre;
    }

    //Nombrar el adjunto con codigo, tipo, id. Entrevistas PR
    public function getNombrePrAttribute() {
        $codigo="EEE-PR-xxxxx";
        $tipo="desconocido";
        $donde = entrevista_profundidad_adjunto::where('id_adjunto',$this->id_adjunto)->first();
        if($donde) {
            $entrevista = $donde->rel_id_entrevista_profundidad;
            $codigo=$entrevista->entrevista_codigo;
            $tipo=criterio_fijo::describir(1,$donde->id_tipo);
        }
        $info=pathinfo($this->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = ".txt";
        }
        $nombre = $codigo."_(".$this->id_adjunto.")_".$tipo.".".$ext;
        $nombre = self::stripAccents($nombre);
        return $nombre;
    }

    //Nombrar el adjunto con codigo, tipo, id. Entrevistas DC
    public function getNombreDcAttribute() {
        $codigo="eee-DC-xxxxx";
        $tipo="desconocido";
        $donde = diagnostico_comunitario_adjunto::where('id_adjunto',$this->id_adjunto)->first();
        if($donde) {
            $entrevista = $donde->rel_id_diagnostico_comunitario;
            $codigo=$entrevista->entrevista_codigo;
            $tipo=criterio_fijo::describir(1,$donde->id_tipo);
        }
        $info=pathinfo($this->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = ".txt";
        }
        $nombre = $codigo."_(".$this->id_adjunto.")_".$tipo.".".$ext;
        $nombre = self::stripAccents($nombre);
        return $nombre;
    }

    //Nombrar el adjunto con codigo, tipo, id. Entrevistas HV
    public function getNombreHvAttribute() {
        $codigo="eee-HV-xxxxx";
        $tipo="desconocido";
        $donde = historia_vida_adjunto::where('id_adjunto',$this->id_adjunto)->first();
        if($donde) {
            $entrevista = $donde->rel_id_historia_vida;
            $codigo=$entrevista->entrevista_codigo;
            $tipo=criterio_fijo::describir(1,$donde->id_tipo);
        }
        $info=pathinfo($this->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = ".txt";
        }
        $nombre = $codigo."_(".$this->id_adjunto.")_".$tipo.".".$ext;
        $nombre = self::stripAccents($nombre);

        return $nombre;
    }

    //Nombrar el adjunto con codigo, tipo, id. Mis Casos
    public function getNombreMcAttribute() {
        $codigo="eee-MC-xxxxx";
        $tipo="desconocido";
        $donde = mis_casos_adjunto::where('id_adjunto',$this->id_adjunto)->first();
        if($donde) {
            $entrevista = $donde->rel_id_mis_casos;
            $codigo=$entrevista->entrevista_codigo;
            $tipo=cat_item::describir($donde->id_seccion);
        }
        $info=pathinfo($this->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = ".txt";
        }
        $nombre = $codigo."_(".$this->id_adjunto.")_".$tipo.".".$ext;
        $nombre = self::stripAccents($nombre);


        return $nombre;
    }
    //Nombrar el adjunto con codigo, tipo, censo_archivos
    public function getNombreCaAttribute() {
        $codigo="eee-CA-xxxxx";

        $donde = censo_archivos_adjunto::where('id_adjunto',$this->id_adjunto)->first();
        if($donde) {
            $entrevista = $donde->rel_id_censo_archivos;
            //$codigo=$entrevista->entrevista_codigo;
            $codigo=$donde->codigo_adjunto;
        }
        $info=pathinfo($this->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = ".txt";
        }
        $nombre = $codigo."_(".$this->id_adjunto.")_".".".$ext;
        $nombre = self::stripAccents($nombre);
        return $nombre;
    }
    //Nombrar el adjunto a un excel con condigos
    public function getNombreExcelAttribute() {
        $codigo="excel_codigos";


        $info=pathinfo($this->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = ".txt";
        }
        $nombre = $codigo."_(".$this->id_adjunto.")_".".".$ext;
        $nombre = self::stripAccents($nombre);
        return $nombre;
    }


    //REcibe el nombre con codigo y tipo.  Le agrega el nombre  del archivo cargado y un indicador de si es el cifrado
    public function nombre_descarga($nombre="descarga.txt") {
        $original=$this->nombre_original;
        $original = trim($original);
        if(strlen($original)>200) {
            $original=substr($original,0,200);
        }
        if(strlen($original)>0) {
            $info=pathinfo($nombre);

            $nuevo_nombre = $info['filename']."_($original)".".".$info['extension'];
            //quitar noASCII
            $nuevo_nombre=filter_var($nuevo_nombre, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            //Algunos caracteres especiales
            $nuevo_nombre = str_replace("%","_", $nuevo_nombre);
            $nuevo_nombre = str_replace("*","_", $nuevo_nombre);
            $nuevo_nombre = str_replace("?","_", $nuevo_nombre);


            return $nuevo_nombre;
        }
        else {
            return $nombre;
        }
        //$nombre = $codigo ."_(". $this->id_adjunto .")_" . $tipo ."_" . $original.".".$ext;
    }
    public function getTamanoAttribute() {
        //$archivo="public/".$this->ubicacion;
        if(empty($this->attributes['tamano'])) {
            if($this->existe) {
                $bytes = Storage::size('public/'.$this->ubicacion);
                $this->attributes['tamano']=$bytes;
                $this->save();
                return self::formatBytes($bytes);
            }
            else {
                return "Archivo no localizado";
            }
        }
        else {
            return self::formatBytes($this->attributes['tamano']);
        }

    }
    public function calcular_hash() {
        //$archivo="public/".$this->ubicacion;
        if($this->existe) {
            $ubicacion = storage_path('app/public'.$this->ubicacion);
            $result = explode("  ", exec("md5sum $ubicacion"));
            if(empty($result[0])) {
                return md5_file($ubicacion);
            }
            else {
                return $result[0];
            }

            //echo "Hash = ".$result[0]."<br />";
        }
        else {
            return "YYZ";
        }
    }
    public function getTamanoBrutoAttribute() {
        //$archivo="public/".$this->ubicacion;
        if($this->existe) {
            $bytes = Storage::size('public/'.$this->ubicacion);
            return $bytes;
        }
        else {
            return "Archivo no localizado";
        }
    }
    public function getExisteAttribute() {
        $archivo="public/".$this->ubicacion;
        $existe = false;
        $existe = Storage::exists($archivo);
        if(!$existe) {
            $archivo="public/".$this->liviano_ubicacion;
            $existe = Storage::exists($archivo);
        }
        return $existe;
    }

    public function getFechaAttribute() {
        $archivo="public/".$this->ubicacion;
        if(Storage::exists($archivo)) {
            $cuando = Storage::lastModified('public/'.$this->ubicacion);
            $fecha = Carbon::createFromTimestamp($cuando);
            return $fecha->format("d-m-Y H:i");

        }
        else {
            return "Archivo no localizado";
        }
    }

    public function getFechaRusoAttribute() {
        $archivo="public/".$this->ubicacion;
        if(Storage::exists($archivo)) {
            $cuando = Storage::lastModified('public/'.$this->ubicacion);
            $fecha = Carbon::createFromTimestamp($cuando);
            return $fecha->format("Y-m-d H:i:s");

        }
        else {
            return "Archivo no localizado";
        }
    }

    //Para convertir bytes en algo facil de leer
    public static function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return 0;
            //return $size;
        }
    }


    //Para determiinar el usuario al que pertenece (usado en seguridad)
    public function getIdEntrevistadorAttribute(){
        $id=0;
        $donde = entrevista_individual_adjunto::where('id_adjunto',$this->id_adjunto)->first();
        if($donde) {
            $entrevista = entrevista_individual::find($donde->id_e_ind_fvt);
            if($entrevista) {
                $id=$entrevista->id_entrevistador;
            }
        }
        return $id;
    }

    public function url_descarga($texto="Descargar archivo") {
        $archivo="public/".$this->ubicacion;
        if(Storage::exists($archivo)) {
            $bytes = Storage::size($archivo);
            $tamano = self::formatBytes($bytes);
            $texto.=" ($tamano)";
            $url = "<a target='_blank' href='".action('adjuntoController@show',$this->id_adjunto)."'>$texto</a>";

        }
        else {
            $url = "Archivo no disponible";
        }
        return $url;
    }
    //igual que el anterior, pero con otros perisos
    public function url_descarga_guia($texto="Descargar archivo") {
        $archivo="public/".$this->ubicacion;
        if(Storage::exists($archivo)) {
            $bytes = Storage::size($archivo);
            $tamano = self::formatBytes($bytes);
            $texto.=" ($tamano)";
            $url = "<a target='_blank' href='".action('adjuntoController@show_guia',$this->id_adjunto)."'>$texto</a>";

        }
        else {
            $url = "Archivo no disponible";
        }
        return $url;
    }

    //Asume que el formulario ya cargó el archivo, recibe el nombre del archivo en el server y con eso crear el adjunto.
    // devuelve el id_adjunto creado
    public static function crear_adjunto($archivo,$nombre_original=null){
        $archivo = str_replace("/storage/","/",$archivo);  //Quitar /storage/ al inicio que pone el control
        $adjunto = self::create(['ubicacion'=>$archivo,'nombre_original'=>$nombre_original]);
        $adjunto->tamano = $adjunto->tamano_bruto;
        $adjunto->md5 = $adjunto->calcular_hash();
        $adjunto->save();
        return $adjunto->id_adjunto;

    }

    //los nombres de archivos no pueden tener tildes
    public static function stripAccents($str) {
        $str=filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        //Algunos caracteres especiales
        $str = str_replace("%","_", $str);
        $str = str_replace("*","_", $str);
        $str = str_replace("?","_", $str);

        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }


    // Marca de agua para los PDF
    public static function generar_png($texto="Ojos claros y serenos", $corto=false) {
        //cambio del 6-dic-22: deshabilitar la marca de agua
        return "";
        /////////
        $font = 25;
        $string = $texto;
        $angle = 45;
        //$im = @imagecreatetruecolor(strlen($string) * $font / 1.5, $font);
        $im = @imagecreatetruecolor(strlen($string) * $font/1.5 , strlen($string) * $font/1.5 );
        $ttf= public_path()."/fonts/source-sans-pro-v11-latin-300.ttf";
        imagesavealpha($im, true);
        imagealphablending($im, false);
        $white = imagecolorallocatealpha($im, 255, 255, 255, 127);
        imagefill($im, 0, 0, $white);
        $lime = imagecolorallocate($im, 204, 255, 51);


        $tb = imagettfbbox( $font, $angle, $ttf, $string);

        //imagettftext($im, $font, 45, 0, $font - 3, $lime, $ttf, $string);
        imagettftext($im, $font, $angle, 15, $tb[2], $lime, $ttf, $string);
        imagettftext($im, $font, $angle, 15 + ($font*2), $tb[2]+ ($font*1), $lime, $ttf, $string);
        imagettftext($im, $font, 0, 15 + ($font*2), $tb[2]+ ($font*3), $lime, $ttf, date("Y-m-d H:i:s"));

        if(!$corto) {  //Para marcar los pdf
            $ruta = storage_path()."/app/public/$texto.png";
            @imagepng($im,$ruta);
            return $ruta;
        }
        else { //Para el canvas del visor
            $texto2=substr($texto,0,3);
            $ruta2 = storage_path()."/app/public/$texto2.png";
            @imagepng($im,$ruta2);
            return $texto2.".png";
        }
    }

    //Marca de agua para el html de la transcripcion
    public static function generar_png2($texto="Ojos claros y serenos",$archivo='fondo.png') {
        $font = 25;
        $string = $texto;
        $angle = 45;
        //$im = @imagecreatetruecolor(strlen($string) * $font / 1.5, $font);
        $im = @imagecreatetruecolor(strlen($string) * $font/1.5 , strlen($string) * $font/1.5 );
        $ttf= public_path()."/fonts/source-sans-pro-v11-latin-300.ttf";
        imagesavealpha($im, true);
        imagealphablending($im, false);
        $white = imagecolorallocatealpha($im, 255, 255, 255, 127);
        imagefill($im, 0, 0, $white);
        //$lime = imagecolorallocate($im, 204, 255, 51);
        $lime = imagecolorallocate($im, 150, 150, 150);


        $tb = imagettfbbox( $font, $angle, $ttf, $string);

        //imagettftext($im, $font, 45, 0, $font - 3, $lime, $ttf, $string);
        imagettftext($im, $font, $angle, 15, $tb[2], $lime, $ttf, $string);
        imagettftext($im, $font, $angle, 15 + ($font*2), $tb[2]+ ($font*1), $lime, $ttf, $string);
        imagettftext($im, $font, 0, 15 + ($font*2), $tb[2]+ ($font*3), $lime, $ttf, date("Y-m-d H:i:s"));
        //dd($tb);
        //$ruta = storage_path()."/app/public/$name.png";
        $ruta = storage_path()."/app/public/$archivo";
        @imagepng($im,$ruta);
        return $archivo;

    }
    //Marca de agua para el visor de pdf
    public static function generar_png3($texto="Ojos claros y serenos",$archivo='fondo.png') {
        $font = 50;
        $string = $texto;
        $angle = 45;
        //$im = @imagecreatetruecolor(strlen($string) * $font / 1.5, $font);
        $im = @imagecreatetruecolor(strlen($string) * $font/1.5 , strlen($string) * $font/1.5 );
        $ttf= public_path()."/fonts/source-sans-pro-v11-latin-900.ttf";
        imagesavealpha($im, true);
        imagealphablending($im, false);
        $white = imagecolorallocatealpha($im, 255, 255, 255, 127);
        imagefill($im, 0, 0, $white);
        //$lime = imagecolorallocate($im, 204, 255, 51);
        //$lime = imagecolorallocate($im, 150, 150, 150);
        $lime = imagecolorallocatealpha($im, 150, 150, 150, 100);


        $tb = imagettfbbox( $font, $angle, $ttf, $string);

        //imagettftext($im, $font, 45, 0, $font - 3, $lime, $ttf, $string);
        imagettftext($im, $font, $angle, 15, $tb[2], $lime, $ttf, $string);
        imagettftext($im, $font, $angle, 15 + ($font*2), $tb[2]+ ($font*1), $lime, $ttf, $string);
        imagettftext($im, $font, 0, 15 + ($font*2), $tb[2]+ ($font*3), $lime, $ttf, date("Y-m-d H:i:s"));
        //dd($tb);
        //$ruta = storage_path()."/app/public/$name.png";
        $ruta = storage_path()."/app/public/$archivo";
        @imagepng($im,$ruta);
        return $archivo;

    }



    public static function marca_agua($pdf_original="/201906/carta.pdf",$texto="Ojos claros y serenos") {

        //Para debug, creo una respuesta extensa
        $respuesta = new \stdClass();
        $respuesta->pdf_original=$pdf_original;
        $respuesta->pdf_destino="";
        $respuesta->texto=$texto;
        $respuesta->ruta_original="";
        $respuesta->ruta_destino="";
        $respuesta->png="";
        $respuesta->paginas=0;

        //Generar PNG con el texto y fondo transparente
        $png = adjunto::generar_png($texto);
        //Calcular archivo destino
        $ruta_original=storage_path()."/app/public".$pdf_original;
        $archivo_destino=str_replace(".pdf","_wm.pdf",$pdf_original);
        $ruta_destino=storage_path()."/app/public".$archivo_destino;
        //Actualizar respuesta con nuevos datos
        $respuesta->pdf_destino=$archivo_destino;
        $respuesta->ruta_original=$ruta_original;
        $respuesta->ruta_destino=$ruta_destino;
        $respuesta->png=$png;


        //Aplicar la Marca
        // Specify path to the existing pdf
        $pdf = new Pdf($ruta_original);
        // Specify path to image. The image must have a 96 DPI resolution.
        $watermark = new Watermark($png);
        // Create a new watermarker
        $watermarker = new PDFWatermarker($pdf, $watermark);
        // Save the new PDF to its specified location
        $watermarker->savePdf($ruta_destino);

        //Proteger el archivo
        $clave="Queremos Paz Para Todos =)";
        $pdf = new FpdiProtection();
        //calculate the number of pages from the original document
        $pagecount = $pdf->setSourceFile($ruta_destino);
        // copy all pages from the old unprotected pdf in the new one
        for ($loop = 1; $loop <= $pagecount; $loop++) {
            $tplidx = $pdf->importPage($loop);
            $size = $pdf->getTemplateSize($tplidx);
            $orientation = $size['orientation'];
            if ($orientation == "P") {
                $pdf->AddPage($orientation, array($size['width'], $size['height']));
            } else {
                $pdf->AddPage($orientation, array($size['height'], $size['width']));
            }

            $pdf->useTemplate($tplidx, null, null, $size['width'], $size['height'], false);
            //$pdf->useTemplate($tplidx);
        }

        $ownerPassword = $pdf->setProtection(
            array(),
            null,
            $clave
        );
        $pdf->Output($ruta_destino, 'F');
        return $respuesta;
    }

    public static function test_transcribir($audio='/var/www/html/expedientes/storage/app/public/201904/5cc7d34301520.wav') {

        $client = new Client();
        $url = config('expedientes.ws_transcriptor');

        try {
            $response = $client->post($url, [
                RequestOptions::JSON => ['fileIn' => $audio ]
            ]);
            $respuesta = json_decode($response->getBody()->getContents());
            $archivo = $respuesta->out;
            $pos = strpos($archivo,'/public/');
            $archivo = substr($archivo,$pos+7);
            return $archivo;
        }
        catch(BadResponseException $e) {
            return false;
        }


    }


    public  function transcribir($titulo='Transcripcion') {
        $respuesta = new \stdClass();
        $respuesta->exito=false;
        $respuesta->original = null;
        $respuesta->mensaje = null;
        $respuesta->json = null;

        $audio = storage_path()."/app/public".$this->ubicacion;
        $respuesta->original = $audio;

        $transcripcion = $this->ws_transcribir($audio,$titulo);
        $respuesta->json = $transcripcion;

        if($transcripcion->enviado) {
            $respuesta->exito=true;
        }
        else {
            $respuesta->exito = false;
            $respuesta->mensaje = $transcripcion->mensaje;
        }

        return $respuesta;
    }

    //Para extraer la ubicacion del archivo a partir del storage
    public static function extrae_ruta($archivo) {
        $pos = strpos($archivo,'/public/');
        $archivo = substr($archivo,$pos+7);
        return $archivo;
    }


    /*
     * TRANSCRIPCION AUTOMATICA
     */
    //Consume el web service que envía a transcribir
    public function ws_transcribir($audio='',$titulo='Titulo') {
        $respuesta = new \stdClass();
        $respuesta->mensaje = '';
        $respuesta->enviado=false;
        $respuesta->audio=null;
        $respuesta->json=new \stdClass();
        if(empty($audio)) {
            $respuesta->mensaje = 'No especificó el archivo de audio';
            $respuesta->enviado=false;
            return $respuesta;
        }

        $respuesta->audio=$audio;


        $client = new Client();
        $url = config('expedientes.ws_transcriptor');
        try {
            $response = $client->post($url, [
                RequestOptions::JSON => ['fileIn' => $audio, 'title'=>$titulo ]
            ]);
            $respuesta_servicio = json_decode($response->getBody()->getContents());
            $respuesta->json = $respuesta_servicio;
            if($respuesta_servicio->status=="ok") {
                $respuesta->enviado=true;

            }
            else {
                $respuesta->enviado=false;
                //todo: manejo de errores del servicio
                $respuesta->mensaje="El servicio de transcripción rechazó la solicitud.  Revisar respuesta.";
            }
        }
        catch(\Exception $e) {
            $respuesta->exito=false;
            $respuesta->mensaje = "Error al consultar el servicio: ".$e->getMessage();
        }

        return $respuesta;
    }

    //Consume el web service que revisa el avance de una transcripcion
    public function ws_revisar($audio='') {
        $respuesta = new \stdClass();
        $respuesta->mensaje = '';
        $respuesta->transcrito=false;
        $respuesta->error=false;
        $respuesta->audio=null;
        $respuesta->json=new \stdClass();
        $respuesta->fechas = new \stdClass();
        $respuesta->fechas_ts = new \stdClass();
        if(empty($audio)) {
            $respuesta->mensaje = 'No especificó el archivo de audio';
            $respuesta->transcrito=false;
            return $respuesta;
        }

        $respuesta->audio=$audio;


        $client = new Client();
        $url = config('expedientes.ws_transcriptor_revisar');


        try {
            $response = $client->post($url, [
                RequestOptions::JSON => ['fileIn' => $audio]
            ]);
            $json = $response->getBody()->getContents();
            $respuesta_servicio = json_decode($json);
            $respuesta->json = $respuesta_servicio;
            $fechas = json_decode($json, true);

            if(empty($respuesta_servicio)) {
                $respuesta->mensaje="El archivo no se encuentra en cola";
                $respuesta->transcrito=false;
                return $respuesta;
            }


            //dd($fechas);
            foreach($fechas['date'] as $var => $val) {
                $respuesta->fechas->$var = $val['$date'];
            }
            foreach($respuesta->fechas as $var =>$val) {
                $respuesta->fechas_ts->$var = tiempo_transcripcion::convertir_hora($val);

            }
            if($respuesta_servicio->status=="done") {
                $respuesta->transcrito = true;
                $respuesta->mensaje = "Archivo transcrito";
            }
            elseif($respuesta_servicio->status=="error") {
                $respuesta->transcrito = false;
                $respuesta->error = "Error del servicio";
            }
            else {  //Sigue pendiente
                $respuesta->transcrito = false;
                $respuesta->mensaje = "No ha sido procesado, sigue en cola";
            }
        }
        catch(\Exception $e) {
            $respuesta->transcrito = false;
            $respuesta->mensaje = "Error al consultar el servicio: ".$e->getMessage();;
            return $respuesta;
        }
        return $respuesta;
    }

    public static function actualizar_tamano() {
        $listado = adjunto::wherenull('tamano')->orderby('id_adjunto')->get();
        $conteo=0;
        foreach($listado as $registro) {
            $tamano = $registro->tamano_bruto;
            $tamano = is_numeric($tamano) ? $tamano : -1;
            $registro->tamano = $tamano;
            $registro->save();
            $conteo++;
        }
        return $conteo;
    }

    public static function actualizar_hash() {
        $listado = adjunto::wherenull('md5')->orderby('id_adjunto')->get();
        $conteo=0;
        foreach($listado as $registro) {
            $hash = $registro->calcular_hash();
            $registro->md5 = $hash;
            $registro->save();
            $conteo++;
        }
        return $conteo;
    }


    //Lee el json y lo mete a un arreglo
    public function procesar_json_etiquetado() {
        $respuesta=new \stdClass();
        $respuesta->exito=false;
        $respuesta->error='';
        $respuesta->json = '';
        $respuesta->texto = '';
        $respuesta->id_adjunto = $this->id_adjunto;
        $respuesta->adjuntado = $this->buscar_id_subserie();
        $respuesta->a_etiquetas=array();
        $respuesta->a_marcas=array();
        //
        $a_etiquetas=array();
        $a_marcas=array();

        $texto = Storage::get('public/'.$this->ubicacion);
        if($texto) {
            $respuesta->texto = $texto;
            $json=json_decode($texto);
            if(empty($json)) {
                $respuesta->exito = false;
                $respuesta->error = 'JSON mal formado';
            }
            else {
                $respuesta->json = $json;
                $respuesta->exito = true;
                if(is_array($json->annotation)) {
                    foreach($json->annotation as $marca ) {
                        $a_etiquetas[]=$marca->label[0];
                        $ocurrencia['texto']=$marca->points[0]->text;
                        $ocurrencia['inicio']=$marca->points[0]->start;
                        $ocurrencia['fin']=$marca->points[0]->end;
                        $a_marcas[$marca->label[0]][]=$ocurrencia;
                    }
                }

                $respuesta->a_etiquetas=$a_etiquetas;
                $respuesta->a_marcas=$a_marcas;
            }
        }
        else {
            $respuesta->exito = false;
            $respuesta->error = 'Archivo no encontrado';
        }
        //
        return $respuesta;
    }

    //Busca en todos los adjuntos y devuelve la entrevista respectiva
    public function buscar_id_subserie() {
        $respuesta = new \stdClass();
        $respuesta->id_subserie = -1;
        $respuesta->id_entrevista = -1;
        $respuesta->id_primaria = null;
        $respuesta->entrevista = null;
        $respuesta->entrevista_codigo=null;
        $respuesta->enlace=null;


        $e = $this->rel_entrevista_individual;
        if($e) {
            if($e->rel_id_e_ind_fvt->id_activo == 1 ) { //ignorar los anulados
                $respuesta->id_subserie = config('expedientes.vi');
                $respuesta->id_entrevista = $e->id_e_ind_fvt;
                $respuesta->entrevista = $e->rel_id_e_ind_fvt;
                $respuesta->id_primaria = "id_e_ind_fvt";
                $respuesta->entrevista_codigo = $respuesta->entrevista->entrevista_codigo;
                $url=action('entrevista_individualController@show',$respuesta->id_entrevista);
                $respuesta->enlace = "<a href='$url'>$respuesta->entrevista_codigo</a>";
            }

        }
        else {
            $e = $this->rel_entrevista_colectiva;
            if($e) {
                if($e->rel_id_entrevista_colectiva->id_activo == 1 ) { //ignorar los anulados
                    $respuesta->id_subserie = config('expedientes.co');
                    $respuesta->id_entrevista = $e->id_entrevista_colectiva;
                    $respuesta->entrevista = $e->rel_id_entrevista_colectiva;
                    $respuesta->id_primaria = "id_entrevista_colectiva";
                    $respuesta->entrevista_codigo = $respuesta->entrevista->entrevista_codigo;
                    $url = action('entrevista_colectivaController@show', $respuesta->id_entrevista);
                    $respuesta->enlace = "<a href='$url'>$respuesta->entrevista_codigo</a>";
                }
            }
            else {
                $e = $this->rel_entrevista_etnica;
                if($e) {
                    if($e->rel_id_entrevista_etnica->id_activo == 1 ) { //ignorar los anulados
                        $respuesta->id_subserie = config('expedientes.ee');
                        $respuesta->id_entrevista = $e->id_entrevista_etnica;
                        $respuesta->entrevista = $e->rel_id_entrevista_etnica;
                        $respuesta->id_primaria = "id_entrevista_etnica";
                        $respuesta->entrevista_codigo = $respuesta->entrevista->entrevista_codigo;
                        $url = action('entrevista_etnicaController@show', $respuesta->id_entrevista);
                        $respuesta->enlace = "<a href='$url'>$respuesta->entrevista_codigo</a>";
                    }
                }
                else {
                    $e = $this->rel_entrevista_profundidad;
                    if($e) {
                        if($e->rel_id_entrevista_profundidad->id_activo == 1 ) { //ignorar los anulados
                            $respuesta->id_subserie = config('expedientes.pr');
                            $respuesta->id_entrevista = $e->id_entrevista_profundidad;
                            $respuesta->entrevista = $e->rel_id_entrevista_profundidad;
                            $respuesta->id_primaria = "id_entrevista_profundidad";
                            $respuesta->entrevista_codigo = $respuesta->entrevista->entrevista_codigo;
                            $url = action('entrevista_profundidadController@show', $respuesta->id_entrevista);
                            $respuesta->enlace = "<a href='$url'>$respuesta->entrevista_codigo</a>";
                        }
                    }
                    else {
                        $e = $this->rel_diagnostico_comunitario;
                        if($e) {
                            if($e->rel_id_diagnostico_comunitario->id_activo == 1 ) { //ignorar los anulados
                                $respuesta->id_subserie = config('expedientes.dc');
                                $respuesta->id_entrevista = $e->id_diagnostico_comunitario;
                                $respuesta->entrevista = $e->rel_id_diagnostico_comunitario;
                                $respuesta->id_primaria = "id_diagnostico_comunitario";
                                $respuesta->entrevista_codigo = $respuesta->entrevista->entrevista_codigo;
                                $url = action('diagnostico_comunitarioController@show', $respuesta->id_entrevista);
                                $respuesta->enlace = "<a href='$url'>$respuesta->entrevista_codigo</a>";
                            }
                        }
                        else {
                            $e = $this->rel_historia_vida;
                            if($e) {
                                if($e->rel_id_historia_vida->id_activo == 1 ) { //ignorar los anulados
                                    $respuesta->id_subserie = config('expedientes.hv');
                                    $respuesta->id_entrevista = $e->id_historia_vida;
                                    $respuesta->entrevista = $e->rel_id_historia_vida;
                                    $respuesta->id_primaria = "id_historia_vida";
                                    $respuesta->entrevista_codigo = $respuesta->entrevista->entrevista_codigo;
                                    $url = action('historia_vidaController@show', $respuesta->id_entrevista);
                                    $respuesta->enlace = "<a href='$url'>$respuesta->entrevista_codigo</a>";
                                }
                            }
                            else {
                                //ni maiz: no esta adjuntado; adjuntado en guias y documentos
                            }
                        }
                    }
                }
            }
        }
        return $respuesta;
    }

    // recibe un contenido cualquiera y crea un archivo con el mismo
    public static function crear_archivo($contenido, $ext="json"){
        $mes=date("Ym");
        $nuevo_nombre = uniqid() . ".$ext";
        $destino= "public/$mes"."/".$nuevo_nombre;
        $destino_url = Storage::url($destino);
        \Storage::put($destino,$contenido);
        $nuevo = new adjunto();
        $nuevo->ubicacion = substr($destino,6); //Quitarle la parte de "public"
        $nuevo->save();
        return $nuevo;
    }

    //Verifica si el mismo adjunto se encuentra en otra entrevista
    public function getDuplicadosAttribute() {

        $encontrados = array();
        if(empty($this->md5)) {
            return $encontrados;
        }
        if($this->md5 == 'YYZ') {
            return $encontrados;
        }

        $listado = adjunto::where('md5',$this->md5)->where('id_adjunto','<>',$this->id_adjunto)->get();
        foreach($listado as $item) {
            $duplicado = $item->buscar_id_subserie();
            if($duplicado->entrevista_codigo) {
                $encontrados[] = $item->buscar_id_subserie();
            }
        }

        $enlaces = array();
        foreach($encontrados as $item) {
            $enlaces[] = $item->enlace;
        }
        return $enlaces;
    }

    //Si es pdf, devuelve el link al visor, sino, false
    public function url_visor() {
        if(!config('expedientes.visor_pdf')) {
            return false;
        }
        $archivo=mb_strtolower($this->ubicacion);

        //Validar que sea pdf
        $info=pathinfo($archivo);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = "txt";
        }

        $url=false;
        if(\Gate::denies('nivel-1')) { //Los administradores pueden descargar
            if ($ext == 'pdf') {
                $url = url("visor/pdf/$this->id_adjunto");
            }
        }
        return $url;

    }

    //Para los WAV. Verifica que exista un mp3 de menor peso para los wav.
    //Devuelve FALSE solo si no hay.  Si hay, o no aplica, devuelve true
    function hay_mas_liviano() {
        return $this->mas_liviano();
        if($this->extension == "wav") {
            return $this->mas_liviano();
        }
        else {
            return true;
        }
    }

    // devuelve la extensión del adjunto
    public function getExtensionAttribute() {
        $info=pathinfo($this->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = "txt";
        }
        return $ext;
    }

    //Devuelve (si lo hay) el mp3 mas liviano
    public function mas_liviano() {
        if(is_null($this->liviano_ubicacion) || $this->liviano_tamano==$this->attributes['tamano']) {
            $otro = substr($this->ubicacion,0,-4);
            $otro = $otro . "_64k.mp3";
            $ubicacion="public/$otro";
            if(Storage::exists($ubicacion)) {
                $this->liviano_ubicacion = $otro;
                $this->liviano_tamano = Storage::size($ubicacion);
                $this->liviano_md5=md5(Storage::get($ubicacion));
                $this->save();
                return $otro;
            }
            else {
                $this->liviano_ubicacion = $this->ubicacion;
                $this->liviano_tamano = $this->attributes['tamano'];
                $this->liviano_md5=$this->md5;
                $this->save();
                return false;
            }
        }
        else {
            return $this->liviano_ubicacion;
        }

    }

    //Devuelve (si lo hay) el archivo cifrado
    public function hay_cifrado() {
        $ext = substr($this->ubicacion,-4);
        $ext= mb_strtolower($ext);
        if($ext <> ".mp3") {  //Buscar conversion a mp3
            $otro = substr($this->ubicacion,0,-4);
            $otro = $otro . "_64k.mp3.gpg";
            if(Storage::exists('public/'.$otro)) {
                return $otro;
            }
            else {
                return false;
            }
        }
        else {  //mp3 nativo. Buscar version cifrada
            $otro = $this->ubicacion . ".gpg";
            if(Storage::exists('public/'.$otro)) {
                return $otro;
            }
        }
    }

    //Devuelve el url del archivo para descargarlo
    public function getCifradoAttribute() {

    }

    //Siempre ,e da el link del streaming.  Se usa en el player de html5
    //Si no hay mas liviano, no lo muestra.
    public function getUrlStreamAttribute(){
        $link=action('adjuntoController@transmitir',$this->id_adjunto);
        return $link;
    }

    //Revisa si hay un audio convertido de wav a mp3.
    //Lo uso para mostrar el enlace para los transcriptores
    public function getUrlStreamCortoAttribute(){

        if(config('expedientes.ocultar_stream_wav')) {
            $link="";
            if($this->existe) {
                if($this->hay_mas_liviano()) {
                    $link=action('adjuntoController@transmitir',$this->id_adjunto);
                }
                else {
                    $bytes = Storage::size('public/'.$this->ubicacion);

                    if($bytes > config('expedientes.stream_max') ) {
                        $max = self::formatBytes(config('expedientes.stream_max'),0);
                        $link = "(Enlace de streaming bloqueado por exeder el tamaño máximo de $max)";
                    }
                    else {
                        $link=action('adjuntoController@transmitir',$this->id_adjunto);
                    }

                }
            }
            return $link;
        }
        else {
            return action('adjuntoController@transmitir',$this->id_adjunto);
        }

    }

    //Reduce el archivo y crea un .gpg
    // Este comando usa un batch del sistema
    public function cifrar() {


        $ruta = Storage::path('public');
        $comando[] = "cd $ruta".substr($this->ubicacion,0,7);
        $comando[] = "rm  ".substr($this->ubicacion,8,-4)."*_64k*";
        $comando[] = "../php_corrige.sh ".substr($this->ubicacion,8);
        $comando[] = "chown www-data:www-data ".substr($this->ubicacion,8,-4)."*";
        $comando[] = "ls -lhtr ".substr($this->ubicacion,8,-4)."*";
        $comando[] = implode("; ",$comando);
        return $comando;

            //Primera versión, no furuló por el tiempo
        $p = Storage::path('public');
        $comando = $p."/php_corrige.sh";
        $archivo = $p.$this->ubicacion;

        $ejecutar = "$comando $archivo";
        //return $ejecutar;

        $result = exec($ejecutar);
        $res['id']=$this->id_adjunto;
        $res['comando']=$ejecutar;
        $res['resultado']=$result;
        return $res;
        //return $result;

    }

    //Actualizar el campo tamano
    public static function actualizar_tamano_pendientes() {
        $listado = self::wherenull('tamano')->orderby('id_adjunto')->get();
        $conteo=0;
        foreach($listado as $adjunto) {
            $adjunto->tamano;  //Este actualiza el registro
            $conteo++;
        }
        return $conteo;

    }

    public static function quitar_acentos($str){
        return self::stripAccents($str);
//        $str=filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
//        //Algunos caracteres especiales
//        $str = str_replace("%","_", $str);
//        $str = str_replace("*","_", $str);
//        $str = str_replace("?","_", $str);
//        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }

    //Calificacion
    public function getFmtIdCalificacionAttribute() {
        return criterio_fijo::describir(125,$this->id_calificacion);

    }


    public static function revisar_existe() {
        $inicio = Carbon::now();
        $conteo[0]=0;
        $conteo[1]=0;
        $conteo[2]=0;
        //Uso <> 1, porque puede haber valores=2 que no estaban debido al proceso de replicación
        $listado = adjunto::where('existe_archivo','<>',1)->orderby('id_adjunto')->get();
        foreach($listado as $adjunto) {
            $adjunto->existe_archivo = $adjunto->existe ? 1 : 2;
            $adjunto->save();
            $conteo[$adjunto->existe_archivo]++;
            $conteo[0]++;
        }
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->revisados = $conteo[0];
        $respuesta->encontrados = $conteo[1];
        $respuesta->con_problemas = $conteo[2];
        return $respuesta;

    }



    public static function actualizar_liviano() {
        $inicio = Carbon::now();
        Log::notice("Actualizar versiones livianas de adjuntos: inicio del proceso");
        $conteo_nuevos=0;
        $conteo_viejos=0;
        $nuevos = self::wherenull('liviano_tamano')->orderby('id_adjunto')->get();
        foreach($nuevos as $a) {
            $a->mas_liviano();
            $conteo_nuevos++;
        }
        $viejos = self::whereraw(\DB::raw(' liviano_tamano=tamano '))->orderby('id_adjunto')->get();
        foreach($viejos as $a) {
            $a->mas_liviano();
            $conteo_viejos++;
        }

        $conteo_adjuntos = self::count();

        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->conteo_nuevos = $conteo_nuevos;
        $respuesta->conteo_viejos = $conteo_viejos;
        $respuesta->total_filas = $conteo_viejos + $conteo_nuevos;
        $respuesta->total_adjuntos = $conteo_adjuntos;
        Log::info("Actualizar versiones livianas de adjuntos: fin del proceso, $respuesta->total_filas filas procesadas. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }


    public function ico_justificacion() {
        $listado=[];
        if(count($this->rel_justificacion)>0) {
            foreach($this->rel_justificacion as $item) {
                $listado[] = $item->fmt_id_justificacion;
            }
            $detalle = implode("<li>",$listado);
            $detalle="<ul><li>$detalle</ul>";
            $titulo = "Justificación";
            $ico="<a  role='button' tabindex='0' class='btn btn-sm btn-default' title='$titulo'  data-content='$detalle'   data-toggle='popover' data-trigger='focus' data-placement='left'><i class='fa fa-info-circle text-primary'></i></a>";
        }
        else {
            $ico='';
        }
        return $ico;
    }

    // 2022-06-25
    // Procesar transcripciones preliminares entregadas por el equipo de desarrollo
    public static function procesar_archivos() {
        Log::notice("Procesar archivos de transcripcion: inicio del proceso");
        //Preliminares
        $inicio = Carbon::now();
        $total_archivos_encontrados=0;
        $total_archivos_adjuntados=0;
        $lis_archivos_si=[]; //Archivos que se procesaron bien
        $lis_archivos_no=[]; //Archivos que no se procesaron
        $lis_archivos_ya=[]; //ARchivos ya procesados

        $a_tipos['VI']=config('expedientes.vi');
        $a_tipos['AA']=config('expedientes.aa');
        $a_tipos['TC']=config('expedientes.tc');
        $a_tipos['CO']=config('expedientes.co');
        $a_tipos['EE']=config('expedientes.ee');
        $a_tipos['PR']=config('expedientes.pr');
        $a_tipos['DC']=config('expedientes.dc');
        $a_tipos['HV']=config('expedientes.hv');

        $a_modelo['VI']='entrevista_individual';
        $a_modelo['AA']='entrevista_individual';
        $a_modelo['TC']='entrevista_individual';
        $a_modelo['CO']='entrevista_colectiva';
        $a_modelo['EE']='entrevista_etnica';
        $a_modelo['PR']='entrevista_profundidad';
        $a_modelo['DC']='diagnostico_comunitario';
        $a_modelo['HV']='historia_vida';

        $a_clase_adjunto['VI']='entrevista_individual_adjunto';
        $a_clase_adjunto['AA']='entrevista_individual_adjunto';
        $a_clase_adjunto['TC']='entrevista_individual_adjunto';
        $a_clase_adjunto['CO']='entrevista_colectiva_adjunto';
        $a_clase_adjunto['EE']='entrevista_etnica_adjunto';
        $a_clase_adjunto['PR']='entrevista_profundidad_adjunto';
        $a_clase_adjunto['DC']='diagnostico_comunitario_adjunto';
        $a_clase_adjunto['HV']='historia_vida_adjunto';

        $a_llave_primaria['VI']='id_e_ind_fvt';
        $a_llave_primaria['AA']='id_e_ind_fvt';
        $a_llave_primaria['TC']='id_e_ind_fvt';
        $a_llave_primaria['CO']='id_entrevista_colectiva';
        $a_llave_primaria['EE']='id_entrevista_etnica';
        $a_llave_primaria['PR']='id_entrevista_profundidad';
        $a_llave_primaria['DC']='id_diagnostico_comunitario';
        $a_llave_primaria['HV']='id_historia_vida';





        //Leer el directorio y llenar un arreglo que dirja el procesamiento de c/archivo
        $listado_archivos = Storage::disk('public')->files('transcripciones');
        echo "Se encontraron ".count($listado_archivos). " archivos";
        //$listado_archivos_recortado = array_map( function ($a) { return substr($a,16); },$listado_archivos);
        //$listado_entrevistas = array_map( function ($a) { return substr($a,0, strpos($a,'_')); },$listado_archivos_recortado);


        //Identificar el tipo de entrevista y su respectiva llave primaria, para luego procesarlo
        foreach($listado_archivos as $archivo) {
            //Ignorar archivos ya procesados

            $item = new \stdClass();
            $item->ubicacion=$archivo;
            $item->archivo = substr($archivo,16);
            $existe = adjunto::where('nombre_original',$item->archivo)->first();
            if($existe) {
                $lis_archivos_ya[]=$item;
            }
            else {
                $item->codigo_entrevista = substr($item->archivo,0, strpos($item->archivo,'_'));
                $item->codigo_entrevista = strtoupper($item->codigo_entrevista);
                $item->tipo_entrevista = substr($item->codigo_entrevista,strpos($item->codigo_entrevista,'-')+1,2);
                $tmp = $a_modelo[$item->tipo_entrevista];
                $tmp = "\\App\\Models\\$tmp";
                $buscar = new $tmp();
                $e = $buscar->where('entrevista_codigo',$item->codigo_entrevista)->first();
                if($e) {
                    $pri = $a_llave_primaria[$item->tipo_entrevista];
                    $item->id_entrevista = $e->$pri;
                    $item->clase = $a_clase_adjunto[$item->tipo_entrevista];
                    $item->pri = $pri;
                    $lis_archivos_si[]=$item;
                }
                else {
                    $lis_archivos_no[]=$item;
                }

            }

        }

        $a_adjuntado=[];

        //Procesar el listado de archivos por adjuntar:
        foreach($lis_archivos_si as $item) {
            //leer el archivo
            $contenido = Storage::disk('public')->get($item->ubicacion);
            if($contenido) {
                //Trasladar el contenido a la carpeta donde se crearía el adjunto
                $info = pathinfo($item->ubicacion);
                $ext = $info['extension'];
                $mes = date("Ym");
                $nuevo_nombre = uniqid() . '.' . $ext;
                $destino= "/$mes/$nuevo_nombre";
                Storage::disk('public')->put("/$mes/$nuevo_nombre",$contenido);

                //Adjuntar a entrevista:
                $clase = $a_clase_adjunto[$item->tipo_entrevista];
                $clase = "\\App\Models\\$clase";
                $adjuntado = new $clase();
                $final = $adjuntado->adjuntar_archivo($item->id_entrevista, $destino,'x_8' , $item->archivo); //Crea el adjunto, lo califica y completa el proceso
                $a_adjuntado[] = $final;

                //Traza de actividad
                traza_actividad::create(['id_objeto'=>2, 'id_accion'=>3, 'codigo'=>$item->codigo_entrevista, 'id_primaria'=>$final->id_adjunto,'referencia'=>"$item->pri: $item->id_entrevista"]);
            }
            else {
                dd("Problema al leer el archivo: $item->ubicacion");
            }

        }


        //Devolver el resultado
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio->format("Y-m-d H:i:s");
        $respuesta->fin = $fin->format("Y-m-d H:i:s");
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->encontrados=$listado_archivos;
        $respuesta->invalidos=$lis_archivos_no;
        $respuesta->existentes = $lis_archivos_ya;
        $respuesta->adjuntados = $lis_archivos_si;
        $respuesta->adjuntos=$a_adjuntado;

        $respuesta->conteo_archivos = count($listado_archivos);
        $respuesta->conteo_archivos_validos = count($lis_archivos_si);
        $respuesta->conteo_archivos_no_validos = count($lis_archivos_no);
        $respuesta->conteo_ya_procesados = count($lis_archivos_ya);


        //$respuesta->listado_recortado=$listado_archivos_recortado;
        //$respuesta->listado_entrevistas=$listado_entrevistas;
        if($respuesta->conteo_archivos_no_validos > 0) {
            $log = array_map( function($i) {return $i->ubicacion; },$lis_archivos_no);
            $txt_log = implode(PHP_EOL,$log);
            Log::error("Procesar archivos de transcripcion. Hubo archivos que no se procesaron por contener un código de entrevista inválido".PHP_EOL.$txt_log);
            //Log::error("Procesar archivos de transcripcion, nombres no validos".PHP_EOL.\GuzzleHttp\json_encode($log));

        }
        if($respuesta->conteo_archivos_validos > 0) {
            $log = array_map( function($i) {return $i->ubicacion; },$lis_archivos_si);
            $txt_log = implode(PHP_EOL,$log);
            Log::info('Procesar archivos de transcripción. Archivos anexados exitosamente'.PHP_EOL.$txt_log);
        }
        if($respuesta->conteo_ya_procesados > 0) {
            $log = array_map( function($i) {return $i->ubicacion; },$lis_archivos_ya);
            $txt_log = implode(PHP_EOL,$log);
            Log::info('Procesar archivos de transcripción, archivos pre existentes'.PHP_EOL.$txt_log);
        }
        //Log final
        Log::info("Procesar archivos de transcripcion: fin del proceso, $respuesta->conteo_archivos archivos encontrados, $respuesta->conteo_archivos_validos adjuntados, $respuesta->conteo_archivos_no_validos no validos y $respuesta->conteo_ya_procesados pre existentes. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }

    // Procesar transcripciones preliminares entregadas por el equipo de desarrollo
    public static function procesar_archivos_txt() {
        Log::notice("Procesar textos de transcripcion: inicio del proceso");
        //Preliminares
        $inicio = Carbon::now();
        $total_archivos_encontrados=0;
        $total_archivos_adjuntados=0;
        $lis_archivos_si=[]; //Archivos que se procesaron bien
        $lis_archivos_no=[]; //Archivos que no se procesaron
        $lis_archivos_ya=[]; //ARchivos ya procesados

        $a_tipos['VI']=config('expedientes.vi');
        $a_tipos['AA']=config('expedientes.aa');
        $a_tipos['TC']=config('expedientes.tc');
        $a_tipos['CO']=config('expedientes.co');
        $a_tipos['EE']=config('expedientes.ee');
        $a_tipos['PR']=config('expedientes.pr');
        $a_tipos['DC']=config('expedientes.dc');
        $a_tipos['HV']=config('expedientes.hv');

        $a_modelo['VI']='entrevista_individual';
        $a_modelo['AA']='entrevista_individual';
        $a_modelo['TC']='entrevista_individual';
        $a_modelo['CO']='entrevista_colectiva';
        $a_modelo['EE']='entrevista_etnica';
        $a_modelo['PR']='entrevista_profundidad';
        $a_modelo['DC']='diagnostico_comunitario';
        $a_modelo['HV']='historia_vida';

        $a_clase_adjunto['VI']='entrevista_individual_adjunto';
        $a_clase_adjunto['AA']='entrevista_individual_adjunto';
        $a_clase_adjunto['TC']='entrevista_individual_adjunto';
        $a_clase_adjunto['CO']='entrevista_colectiva_adjunto';
        $a_clase_adjunto['EE']='entrevista_etnica_adjunto';
        $a_clase_adjunto['PR']='entrevista_profundidad_adjunto';
        $a_clase_adjunto['DC']='diagnostico_comunitario_adjunto';
        $a_clase_adjunto['HV']='historia_vida_adjunto';

        $a_llave_primaria['VI']='id_e_ind_fvt';
        $a_llave_primaria['AA']='id_e_ind_fvt';
        $a_llave_primaria['TC']='id_e_ind_fvt';
        $a_llave_primaria['CO']='id_entrevista_colectiva';
        $a_llave_primaria['EE']='id_entrevista_etnica';
        $a_llave_primaria['PR']='id_entrevista_profundidad';
        $a_llave_primaria['DC']='id_diagnostico_comunitario';
        $a_llave_primaria['HV']='id_historia_vida';





        //Leer el directorio y llenar un arreglo que dirja el procesamiento de c/archivo
        $listado_archivos = Storage::disk('public')->files('transcripciones_txt');
        echo "Se encontraron ".count($listado_archivos). " archivos";


        //Identificar el tipo de entrevista y su respectiva llave primaria, para luego procesarlo
        foreach($listado_archivos as $archivo) {
            $item = new \stdClass();
            $item->ubicacion=$archivo;
            $item->archivo = substr($archivo,20);
            $item->codigo_entrevista = substr($item->archivo,0, strpos($item->archivo,'_'));
            $item->codigo_entrevista = strtoupper($item->codigo_entrevista);
            $item->tipo_entrevista = substr($item->codigo_entrevista,strpos($item->codigo_entrevista,'-')+1,2);
            if(!isset($a_modelo[$item->tipo_entrevista])) { //Archivos con nombre que tiene codigo de entrevista
                $lis_archivos_no[]=$item;
            }
            else {
                $tmp = $a_modelo[$item->tipo_entrevista];
                $tmp = "\\App\\Models\\$tmp";
                $buscar = new $tmp();
                $e = $buscar->where('entrevista_codigo',$item->codigo_entrevista)->first();
                if($e) {
                    $pri = $a_llave_primaria[$item->tipo_entrevista];
                    $item->entrevista = $e;
                    $item->id_entrevista = $e->$pri;
                    $item->clase = $a_clase_adjunto[$item->tipo_entrevista];
                    $item->pri = $pri;
                    $lis_archivos_si[]=$item;
                }
                else {
                    $lis_archivos_no[]=$item;
                }
            }


        }

        $a_procesado_si=[];
        $a_procesado_no=[];

        //Procesar el listado de archivos por adjuntar:
        foreach($lis_archivos_si as $item) {
            //Verificar que no tenga transcripcion final
            $tiene_final = $item->entrevista->rel_adjunto()->where('id_tipo',6)->count();
            if($tiene_final >0) { //Tiene transcripcion final, no procesar
                $a_procesado_no[] = $item->archivo;
            }
            else {
                //leer el archivo
                $contenido = Storage::disk('public')->get($item->ubicacion);
                $item->entrevista->refresh();
                $transcripcion = trim($item->entrevista->html_transcripcion);
                if(empty($transcripcion)) {
                    $transcripcion = $contenido;
                }
                else {
                    $transcripcion.=" ".$contenido;
                }
                $item->entrevista->html_transcripcion=$transcripcion;
                $item->entrevista->save();
                $a_procesado_si[]= $item->archivo;
            }
        }


        //Devolver el resultado
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio->format("Y-m-d H:i:s");
        $respuesta->fin = $fin->format("Y-m-d H:i:s");
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->encontrados=$listado_archivos;
        $respuesta->invalidos=$lis_archivos_no;
        $respuesta->existentes = $lis_archivos_ya;
        $respuesta->textos_si = $a_procesado_si;
        $respuesta->textos_no=$a_procesado_no;

        $respuesta->conteo_archivos = count($listado_archivos);
        $respuesta->conteo_archivos_validos = count($lis_archivos_si);
        $respuesta->conteo_archivos_no_validos = count($lis_archivos_no);
        $respuesta->conteo_textos_si = count($a_procesado_si);
        $respuesta->conteo_textos_no = count($a_procesado_no);


        //$respuesta->listado_recortado=$listado_archivos_recortado;
        //$respuesta->listado_entrevistas=$listado_entrevistas;
        if($respuesta->conteo_archivos_no_validos > 0) {
            $log = array_map( function($i) {return $i->ubicacion; },$lis_archivos_no);
            $txt_log = implode(PHP_EOL,$log);
            Log::error("Procesar textos de transcripcion. Hubo archivos que no se procesaron por contener un código de entrevista inválido".PHP_EOL.$txt_log);
            //Log::error("Procesar archivos de transcripcion, nombres no validos".PHP_EOL.\GuzzleHttp\json_encode($log));

        }
        if($respuesta->conteo_textos_si > 0) {
            $txt_log = implode(PHP_EOL,$a_procesado_si);
            Log::info('Procesar textos de transcripción. Archivos incorporados a la base de datos'.PHP_EOL.$txt_log);
        }
        if($respuesta->conteo_textos_no > 0) {
            $txt_log = implode(PHP_EOL,$a_procesado_no);
            Log::info('Procesar textos de transcripción, archivos ignorados'.PHP_EOL.$txt_log);
        }
        //Log final
        Log::info("Procesar textos de transcripcion: fin del proceso, $respuesta->conteo_archivos archivos encontrados, $respuesta->conteo_archivos_no_validos no validos (codigo no encontrado) , $respuesta->conteo_textos_si incorporados, y  $respuesta->conteo_textos_no ignorados (tienen transcripcion). Tiempo: $respuesta->duracion.");
        return $respuesta;

    }



}
