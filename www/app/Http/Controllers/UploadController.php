<?php

namespace App\Http\Controllers;

use App\Models\casos_informes;
use App\Models\casos_informes_adjunto;
use App\Models\criterio_fijo;
use App\Models\diagnostico_comunitario;
use App\Models\diagnostico_comunitario_adjunto;
use App\Models\entrevista;
use App\Models\entrevista_colectiva;
use App\Models\entrevista_colectiva_adjunto;
use App\Models\entrevista_etnica;
use App\Models\entrevista_etnica_adjunto;
use App\Models\entrevista_individual;
use App\Models\entrevista_individual_adjunto;
use App\Models\entrevista_profundidad;
use App\Models\entrevista_profundidad_adjunto;
use App\Models\historia_vida;
use App\Models\historia_vida_adjunto;
use App\Models\traza_actividad;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;

class UploadController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.upload');
    }


    protected function get_file_size($file_path, $clear_stat_cache = false) {
        if ($clear_stat_cache) {
            if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                clearstatcache(true, $file_path);
            } else {
                clearstatcache();
            }
        }
        return $this->fix_integer_overflow(filesize($file_path));
    }

    protected function fix_integer_overflow($size) {
        if ($size < 0) {
            $size += 2.0 * (PHP_INT_MAX + 1);
        }
        return $size;
    }






    ///Carga simple
    public function ajaxImage(Request $request)
    {
        if ($request->isMethod('get'))
            return view('pages.upload');
        else {

            $this->validate($request, [
                'file'=>'required',
            ]);

            $tipo = entrevista_individual_adjunto::determinar_tipo($request->control);
            $validar=0;
            if(in_array($tipo,[1,3,8])){  //No audio
                $validar=2;
            }
            elseif($tipo==25) { //Etiquetado
                $validar=25;
            }
            elseif($tipo==6) { //OTR para transcripcion final
                $validar=6;
            }
            elseif(in_array($tipo,[2])) {//Audio
                $validar=1;
            }
            elseif(in_array($tipo,[30])) {//Audio
                $validar=30;
            }

            $respuesta=$this->cargar_archivo($request,$validar);


            return response()->json($respuesta) ;
        }
    }

    // Utiliza la respuesta de $this->cargar_archivo()
    public function procesar_otr($respuesta){
        $respuesta->otr=false;  //Banderita que me dice si hubo otr o no
        $respuesta->html=null; //Para saber si debo actualizar la entrevista
        if($respuesta->extension=='otr') {
            $contenido = Storage::get($respuesta->archivo);
            try {
                //$contenido=utf8_encode($contenido);
                $json = \GuzzleHttp\json_decode($contenido);
                if(isset($json->text)) {
                    if(strlen($json->text)>0) {
                        $mes=date("Ym");
                        $nuevo_nombre = uniqid() . '.html';
                        $html = "<!DOCTYPE html><html><head><meta charset='utf-8'></head><body>".$json->text."</body></html>";
                        //$html=$json->text;

                        $destino= "public/$mes"."/".$nuevo_nombre;
                        $destino_url = Storage::url($destino);
                        \Storage::put($destino,$html);

                        $respuesta->otr_url=$destino_url;
                        $respuesta->otr_archivo="/$mes"."/".$nuevo_nombre;
                        $respuesta->otr=true;
                        $respuesta->otr_error="";
                        $respuesta->html = $html;
                    }
                }
            }
            catch (\Exception $e) {
                $respuesta->otr_error=$e->getMessage();
                \Log::warning("Problemas con el OTR: ".$e->getMessage());

            }
        }
    }

    //Carga el archivo y lo adjunta al una entrevista individual (con if para docs de referencia)
    public function cargarAdjuntar(Request $request)
    {
        $tipo = entrevista_individual_adjunto::determinar_tipo($request->control);
        $validar=0;
        if(in_array($tipo,[1,3,8])){  //No audio
            $validar=2;
        }
        elseif($tipo==25) { //Etiquetado
            $validar=25;
        }
        elseif($tipo==6) { //OTR para transcripcion final
            $validar=6;
        }
        elseif(in_array($tipo,[2])) {//Audio
            $validar=1;
        }

        $respuesta = $this->cargar_archivo($request,$validar);
        $respuesta->html=null; //Si hay otr, esta variable recibe el contenido de la transcripcion
        if($respuesta->exito == 1) {
            //Buscar OTR
            $this->procesar_otr($respuesta);
            $otr_url = $respuesta->otr ? $respuesta->otr_url : '';  //url del OTR, para pasarlo a la función de adjuntar_archivo
            //Adjuntarlo
            $id_expediente = $request->id_expediente;
            $control = $request->control;
            $filename = $respuesta->url;
            $adjuntado=entrevista_individual_adjunto::adjuntar_archivo($id_expediente, $filename, $control, $respuesta->nombre_original,$otr_url);
            $respuesta->adjunto=$adjuntado;
            $respuesta->id_expediente=$id_expediente;
            $respuesta->control=$control;
            //Registrar traza
            $ref = criterio_fijo::describir(1,$tipo);
            traza_actividad::create(['id_objeto'=>2, 'id_accion'=>3, 'codigo'=>entrevista_individual::find($id_expediente)->entrevista_codigo, 'id_primaria'=>$adjuntado->id_adjunto,'referencia'=>"Tipo: $ref"]);
            //Actualizar la transcripcion
            if(strlen($respuesta->html)>0) {
                $e = entrevista_individual::find($id_expediente);
                $e->html_transcripcion =$respuesta->html;
                $e->save();
            }

            if($tipo==25) {
                $procesar_json = $adjuntado->procesar_etiquetas();
            }

        }
        else {

        }
        return response()->json($respuesta) ;
    }


    //Carga el archivo y lo adjunta al entrevista_colectiva
    public function cargarAdjuntarEntrevistaColectiva(Request $request)
    {
        $tipo = entrevista_individual_adjunto::determinar_tipo($request->control);
        $validar=0;
        if(in_array($tipo,[1,3,8])){  //No audio
            $validar=2;
        }
        elseif(in_array($tipo,[2])) {//Audio
            $validar=1;
        }
        elseif($tipo==25) { //Etiquetado
            $validar=25;
        }
        elseif($tipo==6) { //OTR para transcripcion final
            $validar=6;
        }
        elseif(in_array($tipo,[11])) { //Relatoria
            $validar=3;
        }

        $respuesta = $this->cargar_archivo($request,$validar);
        if($respuesta->exito == 1) {
            //Buscar OTR
            $this->procesar_otr($respuesta);
            $otr_url = $respuesta->otr ? $respuesta->otr_url : '';  //url del OTR, para pasarlo a la función de adjuntar_archivo
            //Adjuntarlo
            $id = $request->id_expediente;
            $control = $request->control;
            $filename = $respuesta->url;
            $adjunto = entrevista_colectiva_adjunto::adjuntar_archivo($id, $filename, $control, $respuesta->nombre_original,$otr_url);
            $respuesta->adjunto=$adjunto;
            $respuesta->id_expediente=$id;
            $respuesta->control=$control;
            //Traza
            $ref = criterio_fijo::describir(1,$tipo);
            traza_actividad::create(['id_objeto'=>2, 'id_accion'=>3, 'codigo'=>entrevista_colectiva::find($id)->entrevista_codigo, 'id_primaria'=>$adjunto->id_adjunto,'referencia'=>"id_entrevista_colectiva:$id. $ref"]);
            //Actualizar la transcripcion
            if(strlen($respuesta->html)>0) {
                $e = entrevista_colectiva::find($id);
                $e->html_transcripcion =$respuesta->html;
                $e->save();
            }
            if($tipo==25) {
                $procesar_json = $adjunto->procesar_etiquetas();
            }
        }
        return response()->json($respuesta) ;

    }
    //Carga el archivo y lo adjunta a Entrevista Etnica
    public function cargarAdjuntarEntrevistaEtnica(Request $request)
    {
        $tipo = entrevista_etnica_adjunto::determinar_tipo($request->control);
        $validar=0;
        if(in_array($tipo,[1,3,8])){  //No audio
            $validar=2;
        }
        elseif(in_array($tipo,[2])) {//Audio
            $validar=1;
        }
        elseif($tipo==25) { //Etiquetado
            $validar=25;
        }
        elseif($tipo==6) { //OTR para transcripcion final
            $validar=6;
        }
        elseif(in_array($tipo,[11])) { //Relatoria
            $validar=3;
        }

        $respuesta = $this->cargar_archivo($request,$validar);
        if($respuesta->exito == 1) {
            //Buscar OTR
            $this->procesar_otr($respuesta);
            $otr_url = $respuesta->otr ? $respuesta->otr_url : '';  //url del OTR, para pasarlo a la función de adjuntar_archivo
            //Adjuntarlo
            $id = $request->id_expediente;
            $control = $request->control;
            $filename = $respuesta->url;
            $adjunto = entrevista_etnica_adjunto::adjuntar_archivo($id, $filename, $control, $respuesta->nombre_original,$otr_url);
            $respuesta->adjunto=$adjunto;
            $respuesta->id_expediente=$id;
            $respuesta->control=$control;
            //Traza
            $ref = criterio_fijo::describir(1,$tipo);
            traza_actividad::create(['id_objeto'=>2, 'id_accion'=>3, 'codigo'=>entrevista_etnica::find($id)->entrevista_codigo, 'id_primaria'=>$adjunto->id_adjunto,'referencia'=>"id_entrevista_etnica:$id. $ref"]);
            //Actualizar la transcripcion
            if(strlen($respuesta->html)>0) {
                $e = entrevista_etnica::find($id);
                $e->html_transcripcion =$respuesta->html;
                $e->save();
            }
            if($tipo==25) {
                $procesar_json = $adjunto->procesar_etiquetas();
            }
        }
        return response()->json($respuesta) ;

    }
    //Carga el archivo y lo adjunta al entrevista_colectiva
    public function cargarAdjuntarEntrevistaProfundidad(Request $request)
    {
        $tipo = entrevista_individual_adjunto::determinar_tipo($request->control);
        $validar=0;
        if(in_array($tipo,[1,3,8])){  //No audio
            $validar=2;
        }
        elseif(in_array($tipo,[2])) {//Audio
            $validar=1;
        }
        elseif($tipo==25) { //Etiquetado
            $validar=25;
        }
        elseif($tipo==23) { //Etiquetado
            $validar=23;
        }
        elseif($tipo==6) { //OTR para transcripcion final
            $validar=6;
        }
        elseif(in_array($tipo,[11])) { //Relatoria
            $validar=3;
        }

        $respuesta = $this->cargar_archivo($request,$validar);
        if($respuesta->exito == 1) {
            //Buscar OTR
            $this->procesar_otr($respuesta);
            $otr_url = $respuesta->otr ? $respuesta->otr_url : '';  //url del OTR, para pasarlo a la función de adjuntar_archivo
            //Adjuntarlo
            $id = $request->id_expediente;
            $control = $request->control;
            $filename = $respuesta->url;
            $adjunto = entrevista_profundidad_adjunto::adjuntar_archivo($id, $filename, $control, $respuesta->nombre_original,$otr_url);
            $respuesta->adjunto=$adjunto;
            $respuesta->id_expediente=$id;
            $respuesta->control=$control;
            //Traza
            $ref = criterio_fijo::describir(1,$tipo);
            traza_actividad::create(['id_objeto'=>2, 'id_accion'=>3, 'codigo'=>entrevista_profundidad::find($id)->entrevista_codigo, 'id_primaria'=>$adjunto->id_adjunto,'referencia'=>"id_entrevista_profundidad:$id. $ref"]);
            if(strlen($respuesta->html)>0) {
                $e = entrevista_profundidad::find($id);
                $e->html_transcripcion =$respuesta->html;
                $e->save();
            }
            if($tipo==25) {
                $procesar_json = $adjunto->procesar_etiquetas();
            }
        }
        return response()->json($respuesta) ;

    }
    //Carga el archivo y lo adjunta a diagnostico comunitario
    public function cargarAdjuntarDiagnosticoComunitario(Request $request)
    {
        $tipo = entrevista_individual_adjunto::determinar_tipo($request->control);
        $validar=0;
        if(in_array($tipo,[1,3,8])){  //No audio
            $validar=2;
        }
        elseif(in_array($tipo,[2])) {//Audio
            $validar=1;
        }
        elseif($tipo==25) { //Etiquetado
            $validar=25;
        }
        elseif($tipo==6) { //OTR para transcripcion final
            $validar=6;
        }
        elseif(in_array($tipo,[11])) { //Relatoria
            $validar=3;
        }

        $respuesta = $this->cargar_archivo($request,$validar);
        if($respuesta->exito == 1) {
            //Buscar OTR
            $this->procesar_otr($respuesta);
            $otr_url = $respuesta->otr ? $respuesta->otr_url : '';  //url del OTR, para pasarlo a la función de adjuntar_archivo
            //Adjuntarlo
            $id = $request->id_expediente;
            $control = $request->control;
            $filename = $respuesta->url;
            $adjunto = diagnostico_comunitario_adjunto::adjuntar_archivo($id, $filename, $control, $respuesta->nombre_original,$otr_url);
            $respuesta->adjunto=$adjunto;
            $respuesta->id_expediente=$id;
            $respuesta->control=$control;
            //Traza
            $ref = criterio_fijo::describir(1,$tipo);
            traza_actividad::create(['id_objeto'=>2, 'id_accion'=>3, 'codigo'=>diagnostico_comunitario::find($id)->entrevista_codigo, 'id_primaria'=>$adjunto->id_adjunto,'referencia'=>"id_diagnostico_comunitario:$id. $ref"]);
            //Actualizar la transcripcion
            if(strlen($respuesta->html)>0) {
                $e = diagnostico_comunitario::find($id);
                $e->html_transcripcion =$respuesta->html;
                $e->save();
            }
            if($tipo==25) {
                $procesar_json = $adjunto->procesar_etiquetas();
            }
        }
        return response()->json($respuesta) ;

    }
    //Carga el archivo y lo adjunta a un caso/informe
    public function cargarAdjuntarCasoInforme(Request $request)
    {
        $respuesta = $this->cargar_archivo($request);

        if($respuesta->exito == 1) {
            //Buscar OTR
            $this->procesar_otr($respuesta);
            $otr_url = $respuesta->otr ? $respuesta->otr_url : '';  //url del OTR, para pasarlo a la función de adjuntar_archivo
            //Adjuntarlo
            $id_expediente = $request->id_expediente;
            $control = $request->control;
            $filename = $respuesta->url;
            $adjunto = casos_informes_adjunto::adjuntar_archivo($id_expediente, $filename, $control, $respuesta->nombre_original,$otr_url);
            $respuesta->adjunto=$adjunto;
            $respuesta->id_expediente=$id_expediente;
            $respuesta->control=$control;
            //Traza
            $tipo = entrevista_individual_adjunto::determinar_tipo($request->control);
            $ref = criterio_fijo::describir(1,$tipo);
            traza_actividad::create(['id_objeto'=>2, 'id_accion'=>3, 'codigo'=>casos_informes::find($id_expediente)->codigo, 'id_primaria'=>$adjunto->id_adjunto,'referencia'=>"id_caso_informe:$id_expediente. $ref"]);
        }

        return response()->json($respuesta) ;
    }
    //Carga el archivo y lo adjunta a historia de vida
    public function cargarAdjuntarHistoriaVida(Request $request)
    {
        $tipo = entrevista_individual_adjunto::determinar_tipo($request->control);
        $validar=0;
        if(in_array($tipo,[1,3,8])){  //No audio
            $validar=2;
        }
        elseif(in_array($tipo,[2])) {//Audio
            $validar=1;
        }
        elseif($tipo==25) { //Etiquetado
            $validar=25;
        }
        elseif($tipo==6) { //OTR para transcripcion final
            $validar=6;
        }
        elseif(in_array($tipo,[11])) { //Relatoria
            $validar=3;
        }

        $respuesta = $this->cargar_archivo($request,$validar);
        if($respuesta->exito == 1) {
            //Buscar OTR
            $this->procesar_otr($respuesta);
            $otr_url = $respuesta->otr ? $respuesta->otr_url : '';  //url del OTR, para pasarlo a la función de adjuntar_archivo
            //Adjuntarlo
            $id = $request->id_expediente;
            $control = $request->control;
            $filename = $respuesta->url;
            $adjunto = historia_vida_adjunto::adjuntar_archivo($id, $filename, $control, $respuesta->nombre_original,$otr_url);
            $respuesta->adjunto=$adjunto;
            $respuesta->id_expediente=$id;
            $respuesta->control=$control;
            //Traza
            $ref = criterio_fijo::describir(1,$tipo);
            traza_actividad::create(['id_objeto'=>2, 'id_accion'=>3, 'codigo'=>historia_vida::find($id)->entrevista_codigo, 'id_primaria'=>$adjunto->id_adjunto,'referencia'=>"id_historia_vida:$id. $ref"]);
            //Actualizar la transcripcion
            if(strlen($respuesta->html)>0) {
                $e = historia_vida::find($id);
                $e->html_transcripcion =$respuesta->html;
                $e->save();
            }
            if($tipo==25) {
                $procesar_json = $adjunto->procesar_etiquetas();
            }
        }
        return response()->json($respuesta) ;

    }



    public static function convert_filesize($bytes, $decimals = 2){
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) ." ". @$size[$factor];
    }

    //Proceso de carga de archivo, validación y grabado en disco
    //0: cualquiera, 1: audio, 2: no audio
    public function cargar_archivo(Request $request, $tipo=0) {

        $respuesta = new \stdClass();
        $respuesta->nombre_original="";
        $respuesta->exito=0;
        $respuesta->archivo="";
        $respuesta->url = "";
        $respuesta->tamano=0;
        $respuesta->extension="";
        $respuesta->mensaje="";

        if($request->hasFile('file')) {


            $extensiones_validas = ['pdf', 'jpg', 'jpeg', 'tiff', 'png', 'bmp', 'gif', 'wav', 'aiff', 'pcm', 'flac', 'wma', 'mp3', 'aac', 'm4a', 'doc', 'docx', 'odt' ,'xls', 'xlsx', 'otr','ppt','pptx','mp4','zip','json'];
            if ($tipo == 1) { //Audio
                $extensiones_validas = ['wav', 'aiff', 'pcm', 'flac', 'wma', 'mp3', 'aac', 'm4a','mp4'];
            }
            if ($tipo == 2) { //No audio
                $extensiones_validas = ['pdf', 'jpg', 'jpeg', 'tiff', 'png', 'bmp', 'gif', 'doc', 'docx', 'odt', 'xls', 'xlsx', 'otr','ppt','pptx','zip'];
            }
            if ($tipo == 3) { //Word o PDF
                $extensiones_validas = ['pdf', 'doc', 'docx', 'odt', 'otr'];
            }
            if ($tipo == 25) { //Word o PDF
                $extensiones_validas = ['json'];
            }
            if($tipo == 6 ) {  //Transcripcion
                $extensiones_validas = ['otr'];
            }
            if($tipo == 23 ) {  //Comunicacion oficial
                $extensiones_validas = ['pdf'];
            }
            if($tipo == 30 ) {  //Exceles con codigos de entrevista
                $extensiones_validas = ['xls', 'xlsx'];
            }


            $nombre = $request->file('file')->getClientOriginalName();
            $nombre = mb_strtolower($nombre);
            $info = pathinfo($nombre);

            try {
                $ext = $info['extension'];
            } catch (\Exception $e) {
                $ext = "sin extensión";
            }


            $respuesta->nombre_original=$nombre;
            $respuesta->extension=$ext;

            //$tipo=$request->file('file')->getClientMimeType();
            if (!in_array($ext, $extensiones_validas)) {
                $respuesta->mensaje = "Tipo de archivo (.$ext) no válido.  Debe especificar archivos del siguiente tipo: " . implode(", ", $extensiones_validas);
                $respuesta->exito = 2;
            } else {
                $respuesta->exito = 1;
            }

            if( $respuesta->exito==1) {
                $archivo = $request->file;
                $mes = date("Ym");
                $nuevo_nombre = uniqid() . '.' . $ext;

                //$filename = $archivo->store("public/$mes");
                try {
                    //Crear carpeta
                    $con_mes =  "public/$mes";
                    //File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                    if(!File::exists($con_mes)) {

                        Storage::makeDirectory($con_mes, 0777, true, true);
                    }



                    $filename = $archivo->storeAs(
                        "public/$mes", $nuevo_nombre
                    );
                    $size = $request->file('file')->getSize();
                    $url = Storage::url($filename);
                    $respuesta->exito = 1;
                    $respuesta->mensaje="Archivo cargado con éxito";
                    $respuesta->archivo=$filename;
                    $respuesta->url = $url;
                    $respuesta->tamano=self::convert_filesize($size);
                } catch (\Exception $e) {
                    $respuesta->exito = 2;
                    $respuesta->mensaje = "Error al cargar el archivo '$nuevo_nombre', favor de reportar este problema.";
                }
            }
        }
        else {
            $respuesta->exito=2;

        }

        return $respuesta;
    }


    public function registrar_falla(Request $request) {
        $codigo = $request->codigo;
        $id_primaria = $request->id_primaria;

        $id_tipo = entrevista_individual_adjunto::determinar_tipo($request->control);
        $tipo_archivo = criterio_fijo::describir(1,$id_tipo);

        $exito = traza_actividad::create(['id_objeto'=>2, 'id_accion'=>30, 'codigo'=>$codigo, 'id_primaria'=>$id_primaria,'referencia'=>"tipo de archivo: $tipo_archivo"]);
        return \GuzzleHttp\json_encode($exito);

    }
}
