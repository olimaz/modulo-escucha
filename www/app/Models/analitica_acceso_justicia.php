<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property int $id_entrevista
 * @property string $conocimiento
 * @property string $porque_no
 * @property string $ha_recibido_apoyo
 * @property string $medidas_reparacion_adecuadas
 */
class analitica_acceso_justicia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.entrevista_acceso_justicia';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'conocimiento', 'porque_no', 'ha_recibido_apoyo', 'medidas_reparacion_adecuadas'];

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

    //Esta funcion integra acceso a justicia y No repeticion
    public static function generar_plana() {
        $inicio = Carbon::now();
        //Registrar el evento
        Log::notice("ETL de analitica-acceso_justicia: inicio del proceso");
        //Inicializar la tabla
        analitica_acceso_justicia::truncate();
        analitica_acceso_justicia_denuncia_entidad::truncate();
        analitica_acceso_justicia_denuncia_objetivo::truncate();
        analitica_acceso_justicia_denuncia_por_que::truncate();
        analitica_acceso_justicia_apoyo::truncate();
        analitica_acceso_justicia_avances::truncate();
        analitica_acceso_justicia_medidas_no_adecuadas::truncate();
        analitica_entrevista_no_repeticion::truncate();


        $total_filas=0;
        $total_errores=0;

        // Información general
        $generales = self::datos_generales();
        $total_filas += $generales['si'];
        $total_errores += $generales['no'];

        //Entidades a las que ha denunciado
        $denuncia = self::denuncia();
        $total_filas   += $denuncia['si'];
        $total_errores += $denuncia['no'];

        //Quien le ha apoyado
        $apoyo = self::apoyo();
        $total_filas   += $apoyo['si'];
        $total_errores += $apoyo['no'];

        //Avances de su caso
        $avances = self::avances();
        $total_filas   += $avances['si'];
        $total_errores += $avances['no'];

        //Medidas de repración individual/colectiva
        $medidas = self::medidas_reparacion();
        $total_filas   += $medidas['si'];
        $total_errores += $medidas['no'];

        //Porque no han sido adecuadas
        $no_adecuadas = self::no_adecuadas();
        $total_filas   += $no_adecuadas['si'];
        $total_errores += $no_adecuadas['no'];


        //No repeticion
        $no_repeticion = self::no_repeticion();
        $total_filas   += $no_repeticion['si'];
        $total_errores += $no_repeticion['no'];


        //Registrar el fin del proceso
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_errores = $total_errores;
        $respuesta->total_filas = $total_filas;

        Log::info("ETL de analitica-acceso_justicia: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-acceso_justicia finalizada con  $total_errores errores");
        }

        return $respuesta;

    }

    public static function datos_generales() {
        $total_filas=0;
        $total_errores=0;
        //Impactos individuales
        $listado = entrevista_justicia::join('esclarecimiento.e_ind_fvt','entrevista_justicia.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->orderby('entrevista_justicia.id_e_ind_fvt')
            ->get();
        //$listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_acceso_justicia();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->conocimiento = $fila->id_denuncio == 1 ? 1 :0 ;
            $excel->porque_no = $fila->porque_no;
            $excel->ha_recibido_apoyo = $fila->id_apoyo == 1 ? 1 :0 ;
            $excel->medidas_reparacion_adecuadas = $fila->id_adecuado == 1 ? 1 :0 ;
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica_acceso_justicia: ".PHP_EOL.$e->getMessage());
            }
        }

        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;


    }

    /**
     * Procesa institucion, porqué y objetivo
     * @return mixed
     */
    public static function denuncia() {
        $total_filas=0;
        $total_errores=0;
        $a_tipo_institucion[1]='Estatal';
        $a_tipo_institucion[2]='Comunitario';
        $a_tipo_institucion[3]='Internacional';
        //Instituciones
        $query = justicia_institucion::join('esclarecimiento.e_ind_fvt','justicia_institucion.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','justicia_institucion.id_institucion','=','cat_item.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->orderby('e_ind_fvt.id_e_ind_fvt')
            ->orderby('justicia_institucion.id_tipo')
            ->orderby('justicia_institucion.id_institucion')
            ->selectraw(\DB::raw('justicia_institucion.*, cat_item.descripcion'));

        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_acceso_justicia_denuncia_entidad();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->tipo_entidad = $a_tipo_institucion[$fila->id_tipo];
            $excel->entidad = $fila->descripcion;
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica_acceso_justicia_denuncia_institucion: ".PHP_EOL.$e->getMessage());
            }
        }
        //Por qué accedio
        $query = justicia_porque::join('esclarecimiento.e_ind_fvt','justicia_porque.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','justicia_porque.id_porque','=','cat_item.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->orderby('e_ind_fvt.id_e_ind_fvt')
            ->orderby('justicia_porque.id_tipo')
            ->orderby('cat_item.descripcion')
            ->selectraw(\DB::raw('justicia_porque.*, cat_item.descripcion'));

        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_acceso_justicia_denuncia_por_que();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->tipo_entidad = $a_tipo_institucion[$fila->id_tipo];
            $excel->por_que = $fila->descripcion;
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica_acceso_justicia_denuncia_por_que: ".PHP_EOL.$e->getMessage());
            }
        }
        //Cual era su objetivo
        $query = justicia_objetivo::join('esclarecimiento.e_ind_fvt','justicia_objetivo.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','justicia_objetivo.id_objetivo','=','cat_item.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->orderby('e_ind_fvt.id_e_ind_fvt')
            ->orderby('justicia_objetivo.id_tipo')
            ->orderby('cat_item.descripcion')
            ->selectraw(\DB::raw('justicia_objetivo.*, cat_item.descripcion'));

        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_acceso_justicia_denuncia_objetivo();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->tipo_entidad = $a_tipo_institucion[$fila->id_tipo];
            $excel->objetivo = $fila->descripcion;
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica_acceso_justicia_denuncia_objetivo: ".PHP_EOL.$e->getMessage());
            }
        }

        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;


    }

    public static function apoyo() {


        $total_filas=0;
        $total_errores=0;

        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherein('cat_cat.id_cat',[155])
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.id_e_ind_fvt, cat_item.descripcion as quien_apoya "));

        //dd($query->toSql());

        $listado = $query->get();


        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_acceso_justicia_apoyo();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->quien_apoya = $fila->quien_apoya;
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-entrevista_acceso_justicia_apoyo: ".PHP_EOL.$e->getMessage());
            }
        }

        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;

    }

    //Avances en su caso
    public static function avances() {

        $total_filas=0;
        $total_errores=0;

        //que avances ha tenido su caso
        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherein('cat_cat.id_cat',[160,161,162,163])
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('cat_cat.nombre')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, cat_item.descripcion as avance, cat_cat.nombre as seccion, 'Que avances ha tenido su caso' as grupo "));
        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_acceso_justicia_avances();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->grupo = $fila->grupo;
            $excel->seccion = $fila->seccion;
            $excel->avance = $fila->avance;
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-entrevista_acceso_justicia_avances: ".PHP_EOL.$e->getMessage());
            }
        }

        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;

    }

    //Medidas de reparación
    public static function medidas_reparacion() {

        $total_filas=0;
        $total_errores=0;

        //¿QUÉ MEDIDAS DE REPARACIÓN INDIVIDUAL HA RECIBIDO?
        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherein('cat_cat.id_cat',[164,165,166,167,168])
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('cat_cat.nombre')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, cat_item.descripcion as avance, cat_cat.nombre as seccion, '¿QUÉ MEDIDAS DE REPARACIÓN INDIVIDUAL HA RECIBIDO?' as grupo "));
        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_acceso_justicia_avances();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->grupo = $fila->grupo;
            $excel->seccion = $fila->seccion;
            $excel->avance = $fila->avance;
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-entrevista_acceso_justicia_avances: ".PHP_EOL.$e->getMessage());
            }
        }

        //Estado de avance de reparación colectiva
        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherein('cat_cat.id_cat',[169])
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('cat_cat.nombre')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, cat_item.descripcion as avance, cat_cat.nombre as seccion, 'ESTADO DE AVANCE DE LA REPARACIÓN COLECTIVA' as grupo "));
        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_acceso_justicia_avances();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->grupo = $fila->grupo;
            $excel->seccion = $fila->seccion;
            $excel->avance = $fila->avance;
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-entrevista_acceso_justicia_avances: ".PHP_EOL.$e->getMessage());
            }
        }

        $res['si']=$total_filas;
        $res['no']=$total_errores;


        return $res;

    }

    //Porqué no han sido adecuadas
    public static function no_adecuadas() {
        $total_filas=0;
        $total_errores=0;

        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherein('cat_cat.id_cat',[170])
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, cat_item.descripcion as porque_no "));
        $listado = $query->get();

        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_acceso_justicia_medidas_no_adecuadas();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->porque_no = $fila->porque_no;
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-entrevista_acceso_justicia_no_adecuadas: ".PHP_EOL.$e->getMessage());
            }
        }

        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;

    }

    //Iniciativas de no repeticion
    public static function no_repeticion() {
        $total_filas=0;
        $total_errores=0;

        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->leftJoin('catalogos.cat_item as recategorizado','cat_item.id_reclasificado','recategorizado.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherein('cat_cat.id_cat',[171])
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, cat_item.id_reclasificado, recategorizado.descripcion as recategorizado, cat_item.descripcion as iniciativa "));
        $listado = $query->get();

        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_entrevista_no_repeticion();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->iniciativa = $fila->iniciativa;
            if($fila->id_reclasificado==-1) {
                $excel->recategorizado = "(Opción inválida: ignorar)";
            }
            elseif(is_null($fila->id_reclasificado)) {
                $excel->recategorizado = "(Pendiente reclasificar)";
            }
            else {
                $excel->recategorizado = $fila->recategorizado;
            }
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-entrevista_no_repeticion: ".PHP_EOL.$e->getMessage());
            }
        }

        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;

    }





    public static function generar_plana_binarizada() {
        $inicio = Carbon::now();
        $log[]=array();
        $problema=array();

        $prefijo[1]='_est_';
        $prefijo[2]='_com_';
        $prefijo[3]='_int_';
        //Registrar el evento
        Log::notice("ETL de analitica-acceso_justicia binarizada: inicio del proceso");
        //Inicializar la tabla
        analitica_acceso_justicia_binarizado::truncate();

        //Listado: Denuncia ante instituciones.  El porqué y objetivo se derivan de esta
        $query = justicia_institucion::join('esclarecimiento.e_ind_fvt','justicia_institucion.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','justicia_institucion.id_institucion','=','cat_item.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            //->orderby('e_ind_fvt.id_e_ind_fvt')
            ->orderby('e_ind_fvt.id_e_ind_fvt')
            ->orderby('cat_item.otro')
            ->select(\DB::raw('distinct e_ind_fvt.id_e_ind_fvt, e_ind_fvt.entrevista_codigo, justicia_institucion.*, cat_item.otro as campo'));


        $listado = $query->get();


        //dd($query->toSql());
        $total_filas=0;
        $total_errores=0;
        $id_entrevista=0; //Para identificar salto de hecho

        $log[]= "Inicio.  id_entrevista: $id_entrevista";
        foreach($listado as $fila) {
            if($id_entrevista==0) {  //Primera fila
                $id_entrevista=$fila->id_e_ind_fvt;
                $log[]="Primera fila. id_entrevista: $id_entrevista";
                $nuevo = new analitica_acceso_justicia_binarizado();
                $nuevo->id_entrevista = $id_entrevista;
                $nuevo->codigo_entrevista = $fila->entrevista_codigo;
            }

            if($id_entrevista <> $fila->id_e_ind_fvt) {  //Cambio de entrevista
                //Explorar los porqué
                $query = justicia_porque::join('esclarecimiento.e_ind_fvt','justicia_porque.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
                    ->join('catalogos.cat_item','justicia_porque.id_porque','=','cat_item.id_item')
                    ->where('e_ind_fvt.id_e_ind_fvt',$id_entrevista)
                    ->orderby('cat_item.otro')
                    ->selectRaw(\DB::raw('distinct justicia_porque.*, cat_item.otro as campo'));

                $listado_dos = $query->get();
                foreach($listado_dos as $detalle_dos) {
                    if(strlen($detalle_dos->campo)>0) {
                        $campo="pq";
                        $campo.=$prefijo[$detalle_dos->id_tipo];
                        $campo.=$detalle_dos->campo;
                        $nuevo->$campo=1;
                    }
                    else {  //Registrar que no se considera
                        if(isset($problema[$fila->id_porque])) {
                            $problema[$fila->id_porque]++;
                        }
                        else {
                            $problema[$fila->id_porque]=1;
                        }
                    }
                }

                //Explorar los objetivos
                $query = justicia_objetivo::join('esclarecimiento.e_ind_fvt','justicia_objetivo.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
                    ->join('catalogos.cat_item','justicia_objetivo.id_objetivo','=','cat_item.id_item')
                    ->where('e_ind_fvt.id_e_ind_fvt',$id_entrevista)
                    ->orderby('cat_item.otro')
                    ->selectRaw(\DB::raw('distinct justicia_objetivo.*, cat_item.otro as campo'));

                $listado_dos = $query->get();
                foreach($listado_dos as $detalle_dos) {
                    if(strlen($detalle_dos->campo)>0) {
                        $campo="obj";
                        $campo.=$prefijo[$detalle_dos->id_tipo];
                        $campo.=$detalle_dos->campo;
                        $nuevo->$campo=1;
                    }
                    else {  //Registrar que no se considera
                        if(isset($problema[$fila->id_objetivo])) {
                            $problema[$fila->id_objetivo]++;
                        }
                        else {
                            $problema[$fila->id_objetivo]=1;
                        }
                    }
                }
                //Grabar
                try {
                    $log[]="Grabar nueva fila.  id_entrevista: $id_entrevista";
                    $nuevo->save();
                    $total_filas++;
                    //Crear nuevo registro
                    $id_hecho=$fila->id_hecho;
                    $nuevo = new analitica_acceso_justicia_binarizado();
                    $nuevo->id_entrevista = $id_entrevista;
                    $nuevo->codigo_entrevista = $fila->entrevista_codigo;
                }
                catch(\Exception $e) {
                    $total_errores++;
                    Log::debug("Error en generar registro de analitica-acceso_justicia binarizada:  ".PHP_EOL.$e->getMessage());
                }
            }

            $campo = $fila->campo;  //Asignar valor 1 al campo
            if(strlen($campo)>0) {
                $nombre_campo = "inst";
                $nombre_campo.=$prefijo[$fila->id_tipo];
                $nombre_campo.=$campo;
                $nuevo->$nombre_campo=1;
            }
            else {  //Registrar que no se considera
                if(isset($problema[$fila->id_institucion])) {
                    $problema[$fila->id_institucion]++;
                }
                else {
                    $problema[$fila->id_institucion]=1;
                }
            }

        }
        //Grabar el último registro
        try {
            $log[]= "Ultimo registro.  id_entrevista: $id_entrevista";
            $nuevo->save();
            $total_filas++;
        }
        catch(\Exception $e) {
            $total_errores++;
            Log::debug("Error en generar registro de analitica-acceso_justicia binarizada:  ".PHP_EOL.$e->getMessage());
        }

        //Registrar el fin del proceso
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_errores = $total_errores;
        $respuesta->total_filas = $total_filas;
        //$respuesta->log = $log;

        Log::info("ETL de analitica-acceso_justicia binarizada: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if(count($problema)>0) {
            Log::warning("identificadores no considerado en binarización de acceso a la justicia. ".PHP_EOL.http_build_query($problema));
            $respuesta->advertencias = count($problema);
        }
        if($total_errores>0) {
            Log::error("ETL de analitica-acceso_justicia binarizada finalizada con  $total_errores errores");
        }

        return $respuesta;

    }
    //Version binarizada





}
