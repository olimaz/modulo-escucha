<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id_excel_personas_entrevistadas
 * @property string $nombres
 * @property string $apellidos
 * @property string $otros_nombres
 * @property string $sexo
 * @property int $edad
 * @property string $grupo_etario
 * @property int $anio_nacimiento
 * @property string $sector
 * @property int $clasificacion_nivel
 * @property string $codigo_entrevista
 * @property string $tipo_entrevista
 * @property string $macroterritorio
 * @property string $territorio
 * @property string $entrevista_fecha
 * @property string $entrevista_lugar_n1_codigo
 * @property string $entrevista_lugar_n1_txt
 * @property string $entrevista_lugar_n2_codigo
 * @property string $entrevista_lugar_n2_txt
 * @property string $entrevista_lugar_n3_codigo
 * @property string $entrevista_lugar_n3_txt
 * @property string $entrevista_lugar_n3_lat
 * @property string $entrevista_lugar_n3_lon
 -- para filtros
 * @property int $id_sexo
 * @property int $id_sector
 * @property int $id_macroterritorio
 * @property int $id_territorio
 * @property int $id_entrevista_lugar
 * @property string $fts
-- llave foranea
 * @property int $id_subserie
 * @property int $id_entrevista
 */
class excel_personas_entrevistadas extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.excel_personas_entrevistadas';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_excel_personas_entrevistadas';

    /**
     * @var array
     */
    protected $fillable = ['nombres', 'apellidos', 'otros_nombres', 'id_sexo', 'anio_nacimiento', 'codigo_entrevista', 'clasificacion_nivel', 'id_subserie', 'id_entrevista', 'fts'];

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



    public static function generar_plana() {
        $inicio = Carbon::now();
        Log::notice("ETL de excel_personas_entrevistadas: inicio del proceso");

        excel_personas_entrevistadas::truncate();
        $total_filas=0;
        $total_errores=0;
        // 1. Entrevista individual  (VI, AA, TC)
        $vi = self::cargar_individuales();
        $total_filas += $vi->total_filas;
        $total_errores += $vi->total_errores;


        // 2. Entrevistas a profunidad
        $pr = self::cargar_pr();
        $total_filas   += $pr->total_filas;
        $total_errores += $pr->total_errores;


        // 3. Historia de Vida
        $hv = self::cargar_hv();
        $total_filas   += $hv->total_filas;
        $total_errores += $hv->total_errores;

        //4. Entrevistas colectivas: se extrae la información de los consentimientos informados
        $co = self::cargar_co();
        $total_filas   += $co->total_filas;
        $total_errores += $co->total_errores;

        //5.Entrevistas etnica: a partir de los consentimientos informados
        $ee = self::cargar_ee();
        $total_filas   += $ee->total_filas;
        $total_errores += $ee->total_errores;

        //6.Diagnosticos comunitarios: a partir de los consentimientos informados
        $dc = self::cargar_dc();
        $total_filas   += $dc->total_filas;
        $total_errores += $dc->total_errores;


        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->vi = $vi;
        $respuesta->pr = $pr;
        $respuesta->hv = $hv;
        $respuesta->co = $co;
        $respuesta->ee = $ee;
        $respuesta->dc = $dc;
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;
        $respuesta->total_errores = $total_errores;

        Log::info("ETL de excel_personas_entrevistadas: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }

    // Individuales: VI
    public static function cargar_individuales() {
        $total_filas=0;
        $total_errores=0;

        // Entrevistas a víctimas
        //$id_subserie=config('expedientes.vi');
        $vi = \DB::table('esclarecimiento.e_ind_fvt')
            ->join('fichas.persona_entrevistada','e_ind_fvt.id_e_ind_fvt','=','persona_entrevistada.id_e_ind_fvt')
            ->join('fichas.persona','persona_entrevistada.id_persona','=','persona.id_persona')
            ->where('e_ind_fvt.id_activo',1)  //No anuladas
            ->selectraw(\DB::raw("e_ind_fvt.id_e_ind_fvt as id_entrevista, persona.id_persona,  id_subserie, nombre, apellido, alias, id_sexo, persona_entrevistada.edad, fec_nac_a, e_ind_fvt.entrevista_codigo, id_sector, clasifica_nivel as clasificacion_nivel,  entrevista_lugar, id_macroterritorio, id_territorio, entrevista_fecha "))
        ;


        $listado = $vi->get();



        foreach($listado as $fila) {
            $excel = new excel_personas_entrevistadas();
            $consentimiento = entrevista::where('id_e_ind_fvt',$fila->id_entrevista)->first();
            $persona = persona::find($fila->id_persona);
            $e = entrevista_individual::find($fila->id_entrevista);
            if($consentimiento) {
                $excel->cedula = $consentimiento->identificacion_consentimiento;
            }
            $excel->id_persona = $fila->id_persona;


            $excel->id_sexo = $fila->id_sexo;
            $excel->edad = $persona->calcular_edad($e->entrevista_fecha);
            if($excel->edad==-99) {
                $excel->edad = $fila->edad;
            }
            //Ocultar nombres de NNA
            if($excel->edad > 0 && $excel->edad < 18) {
                $excel->nombres = "(Menor de edad)";
                $excel->apellidos = "(Menor de edad)";
                $excel->otros_nombres = "(Menor de edad)";
            }
            else {
                $excel->nombres = $fila->nombre;
                $excel->apellidos = $fila->apellido;
                $excel->otros_nombres = $fila->alias;
            }


            $excel->grupo_etario = persona::calcular_grupo_etario($excel->edad);
            $excel->anio_nacimiento = $fila->fec_nac_a;
            $excel->id_sector = $fila->id_sector;
            $excel->clasificacion_nivel = $fila->clasificacion_nivel;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            //
            $excel->id_subserie=$fila->id_subserie;
            $excel->id_entrevista=$fila->id_entrevista;
            //Nuevos campos
            $excel->tipo_entrevista = entrevista_individual::subserie_tipo_entrevista($fila->id_subserie);
            $excel->id_macroterritorio = $fila->id_macroterritorio;
            $excel->id_territorio = $fila->id_territorio;
            $excel->id_entrevista_lugar = $fila->entrevista_lugar;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha,0,10);
            //Campos calculados
            $excel->sexo = cat_item::describir($excel->id_sexo);
            $excel->sector = cat_item::describir($excel->id_sector);
            $excel->macroterritorio = cev::describir($excel->id_macroterritorio);
            $excel->territorio = cev::describir($excel->id_territorio);
            $geo = geo::find($excel->id_entrevista_lugar);
            if($geo) {
                $excel->entrevista_lugar_n3_codigo = $geo->codigo;
                $excel->entrevista_lugar_n3_txt = $geo->descripcion;
                $excel->entrevista_lugar_n3_lat = $geo->lat;
                $excel->entrevista_lugar_n3_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2_codigo = $geo->codigo;
                    $excel->entrevista_lugar_n2_txt = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1_codigo = $geo->codigo;
                        $excel->entrevista_lugar_n1_txt = $geo->descripcion;
                    }
                }
            }

            try {
                $excel->save();
                $total_filas++;
            }
            catch (\Exception $e) {
                $total_errores++;
                Log::error("Problemas con el ETL de excel_personas_entrevistadas:".PHP_EOL.$e->getMessage());
            }


        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
    }

    //Profundidad. 2021-ago-02
    public static function cargar_pr() {
        $total_filas=0;
        $total_errores=0;

        // Entrevistas a víctimas
        //$id_subserie=config('expedientes.vi');

        $lis_pe = \DB::table('esclarecimiento.entrevista_profundidad')
            ->join('fichas.persona_entrevistada','entrevista_profundidad.id_entrevista_profundidad','=','persona_entrevistada.id_entrevista_profundidad')
            ->join('fichas.persona','persona_entrevistada.id_persona','=','persona.id_persona')
            ->where('entrevista_profundidad.id_activo',1)  //No anuladas
            ->selectraw(\DB::raw("entrevista_profundidad.id_entrevista_profundidad as id_entrevista, persona.id_persona, nombre, apellido, alias, id_sexo, persona_entrevistada.edad, fec_nac_a, entrevista_codigo, id_sector,  clasificacion_nivel,  entrevista_lugar, id_macroterritorio, id_territorio, entrevista_fecha_inicio "))
        ;

        $listado = $lis_pe->get();
        foreach($listado as $fila) {
            $excel = new excel_personas_entrevistadas();
            $consentimiento = entrevista::where('id_entrevista_profundidad',$fila->id_entrevista)->first();
            $persona = persona::find($fila->id_persona);
            $e = entrevista_profundidad::find($fila->id_entrevista);
            if($consentimiento) {
                $excel->cedula = $consentimiento->identificacion_consentimiento;
            }
            $excel->id_persona = $fila->id_persona;


            $excel->id_sexo = $fila->id_sexo;
            $excel->edad = $persona->calcular_edad($e->entrevista_fecha_inicio);
            if($excel->edad==-99) {
                $excel->edad = $fila->edad;
            }
            //Ocultar nombres de NNA
            if($excel->edad > 0 && $excel->edad < 18) {
                $excel->nombres = "(Menor de edad)";
                $excel->apellidos = "(Menor de edad)";
                $excel->otros_nombres = "(Menor de edad)";
            }
            else {
                $excel->nombres = $fila->nombre;
                $excel->apellidos = $fila->apellido;
                $excel->otros_nombres = $fila->alias;
            }


            $excel->grupo_etario = persona::calcular_grupo_etario($excel->edad);
            $excel->anio_nacimiento = $fila->fec_nac_a;
            $excel->id_sector = $fila->id_sector;
            $excel->clasificacion_nivel = $fila->clasificacion_nivel;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            //
            $excel->id_subserie=config('expedientes.pr');
            $excel->id_entrevista=$fila->id_entrevista;
            //Nuevos campos
            $excel->tipo_entrevista = 'PR';
            $excel->id_macroterritorio = $fila->id_macroterritorio;
            $excel->id_territorio = $fila->id_territorio;
            $excel->id_entrevista_lugar = $fila->entrevista_lugar;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha_inicio,0,10);
            //Campos calculados
            $excel->sexo = cat_item::describir($excel->id_sexo);
            $excel->sector = cat_item::describir($excel->id_sector);
            $excel->macroterritorio = cev::describir($excel->id_macroterritorio);
            $excel->territorio = cev::describir($excel->id_territorio);
            $geo = geo::find($excel->id_entrevista_lugar);
            if($geo) {
                $excel->entrevista_lugar_n3_codigo = $geo->codigo;
                $excel->entrevista_lugar_n3_txt = $geo->descripcion;
                $excel->entrevista_lugar_n3_lat = $geo->lat;
                $excel->entrevista_lugar_n3_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2_codigo = $geo->codigo;
                    $excel->entrevista_lugar_n2_txt = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1_codigo = $geo->codigo;
                        $excel->entrevista_lugar_n1_txt = $geo->descripcion;
                    }
                }
            }

            try {
                $excel->save();
                $total_filas++;
            }
            catch (\Exception $e) {
                $total_errores++;
                Log::error("Problemas con el ETL de excel_personas_entrevistadas(PR):".PHP_EOL.$e->getMessage());
            }


        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
    }
    // Profundidad: esta versión es antes de que se cargaran fichas de personas entrevistadas
    public static function cargar_profundidad_old() {
        $total_filas=0;
        $total_errores=0;


        $id_subserie=config('expedientes.pr');
        $pr = \DB::table('esclarecimiento.entrevista_profundidad')
            ->where('entrevista_profundidad.id_activo',1)
            ->selectraw(\DB::raw("entrevista_profundidad.id_entrevista_profundidad as id_entrevista, $id_subserie as id_subserie, entrevistado_nombres as nombre, '' as apellido, entrevistado_apellidos as alias, 0 as id_sexo, 0 as fec_nac_a, entrevista_codigo, id_sector, clasificacion_nivel, entrevista_lugar, id_macroterritorio, id_territorio, entrevista_fecha_inicio as entrevista_fecha "));



        $listado = $pr->get();



        foreach($listado as $fila) {
            $excel = new excel_personas_entrevistadas();
            $consentimiento = entrevista::where('id_entrevista_profundidad',$fila->id_entrevista)->first();
            if($consentimiento) {
                $excel->cedula = $consentimiento->identificacion_entrevista;
            }

            $excel->nombres = $fila->nombre;
            $excel->apellidos = $fila->apellido;
            $excel->otros_nombres = $fila->alias;
            $excel->id_sexo = $fila->id_sexo;
            $excel->anio_nacimiento = $fila->fec_nac_a;
            $excel->id_sector = $fila->id_sector;
            $excel->clasificacion_nivel = $fila->clasificacion_nivel;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            //
            $excel->id_subserie=$fila->id_subserie;
            $excel->id_entrevista=$fila->id_entrevista;

            //Nuevos campos
            $excel->tipo_entrevista = "PR";
            $excel->id_macroterritorio = $fila->id_macroterritorio;
            $excel->id_territorio = $fila->id_territorio;
            $excel->id_entrevista_lugar = $fila->entrevista_lugar;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha,0,10);
            //Campos calculados
            $excel->sexo = cat_item::describir($excel->id_sexo);
            $excel->edad = -99;
            $excel->grupo_etario = persona::calcular_grupo_etario($excel->edad);
            $excel->sector = cat_item::describir($excel->id_sector);
            $excel->macroterritorio = cev::describir($excel->id_macroterritorio);
            $excel->territorio = cev::describir($excel->id_territorio);
            $geo = geo::find($excel->id_entrevista_lugar);
            if($geo) {
                $excel->entrevista_lugar_n3_codigo = $geo->codigo;
                $excel->entrevista_lugar_n3_txt = $geo->descripcion;
                $excel->entrevista_lugar_n3_lat = $geo->lat;
                $excel->entrevista_lugar_n3_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2_codigo = $geo->codigo;
                    $excel->entrevista_lugar_n2_txt = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1_codigo = $geo->codigo;
                        $excel->entrevista_lugar_n1_txt = $geo->descripcion;
                    }
                }
            }

            //Si hay ficha de persona entrevistada, sobreescribir la anterior información que sale de los metadatos


            try {
                $excel->save();
                $total_filas++;
            }
            catch (\Exception $e) {
                $total_errores++;
                Log::error("Problemas con el ETL de excel_personas_entrevistadas:".PHP_EOL.$e->getMessage());
            }


        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
    }

    //Historias Vicda. 2021-ago-02
    public static function cargar_hv() {
        $total_filas=0;
        $total_errores=0;

        // Entrevistas a víctimas
        //$id_subserie=config('expedientes.vi');

        $lis_pe = \DB::table('esclarecimiento.historia_vida')
            ->join('fichas.persona_entrevistada','historia_vida.id_historia_vida','=','persona_entrevistada.id_historia_vida')
            ->join('fichas.persona','persona_entrevistada.id_persona','=','persona.id_persona')
            ->where('historia_vida.id_activo',1)  //No anuladas
            ->selectraw(\DB::raw("historia_vida.id_historia_vida as id_entrevista, persona.id_persona, nombre, apellido, alias, persona.id_sexo, persona_entrevistada.edad, fec_nac_a, entrevista_codigo, id_sector,  clasificacion_nivel,  entrevista_lugar, id_macroterritorio, id_territorio, entrevista_fecha_inicio "))
        ;

        $listado = $lis_pe->get();
        foreach($listado as $fila) {
            $excel = new excel_personas_entrevistadas();
            $consentimiento = entrevista::where('id_historia_vida',$fila->id_entrevista)->first();
            $persona = persona::find($fila->id_persona);
            $e = historia_vida::find($fila->id_entrevista);
            if($consentimiento) {
                $excel->cedula = $consentimiento->identificacion_consentimiento;
            }
            $excel->id_persona = $fila->id_persona;


            $excel->id_sexo = $fila->id_sexo;
            $excel->edad = $persona->calcular_edad($e->entrevista_fecha_inicio);
            if($excel->edad==-99) {
                $excel->edad = $fila->edad;
            }
            //Ocultar nombres de NNA
            if($excel->edad > 0 && $excel->edad < 18) {
                $excel->nombres = "(Menor de edad)";
                $excel->apellidos = "(Menor de edad)";
                $excel->otros_nombres = "(Menor de edad)";
            }
            else {
                $excel->nombres = $fila->nombre;
                $excel->apellidos = $fila->apellido;
                $excel->otros_nombres = $fila->alias;
            }


            $excel->grupo_etario = persona::calcular_grupo_etario($excel->edad);
            $excel->anio_nacimiento = $fila->fec_nac_a;
            $excel->id_sector = $fila->id_sector;
            $excel->clasificacion_nivel = $fila->clasificacion_nivel;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            //
            $excel->id_subserie=config('expedientes.hv');
            $excel->id_entrevista=$fila->id_entrevista;
            //Nuevos campos
            $excel->tipo_entrevista = 'HV';
            $excel->id_macroterritorio = $fila->id_macroterritorio;
            $excel->id_territorio = $fila->id_territorio;
            $excel->id_entrevista_lugar = $fila->entrevista_lugar;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha_inicio,0,10);
            //Campos calculados
            $excel->sexo = cat_item::describir($excel->id_sexo);
            $excel->sector = cat_item::describir($excel->id_sector);
            $excel->macroterritorio = cev::describir($excel->id_macroterritorio);
            $excel->territorio = cev::describir($excel->id_territorio);
            $geo = geo::find($excel->id_entrevista_lugar);
            if($geo) {
                $excel->entrevista_lugar_n3_codigo = $geo->codigo;
                $excel->entrevista_lugar_n3_txt = $geo->descripcion;
                $excel->entrevista_lugar_n3_lat = $geo->lat;
                $excel->entrevista_lugar_n3_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2_codigo = $geo->codigo;
                    $excel->entrevista_lugar_n2_txt = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1_codigo = $geo->codigo;
                        $excel->entrevista_lugar_n1_txt = $geo->descripcion;
                    }
                }
            }

            try {
                $excel->save();
                $total_filas++;
            }
            catch (\Exception $e) {
                $total_errores++;
                Log::error("Problemas con el ETL de excel_personas_entrevistadas(HV):".PHP_EOL.$e->getMessage());
            }


        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
    }
    // Historias de vida
    public static function cargar_hv_old() {
        $total_filas=0;
        $total_errores=0;



        $id_subserie=config('expedientes.hv');
        $hv = \DB::table('esclarecimiento.historia_vida')
            ->where('historia_vida.id_activo',1)
            ->selectraw(\DB::raw("historia_vida.id_historia_vida as id_entrevista, $id_subserie as id_subserie, entrevistado_nombres as nombre, entrevistado_apellidos as apellido, entrevistado_otros_nombres as alias, id_sexo as id_sexo, 0 as fec_nac_a, entrevista_codigo, id_sector, clasificacion_nivel, entrevista_lugar, id_macroterritorio, id_territorio, entrevista_fecha_inicio as entrevista_fecha "));


        $listado = $hv->get();


        foreach($listado as $fila) {
            $excel = new excel_personas_entrevistadas();
            $consentimiento = entrevista::where('id_historia_vida',$fila->id_entrevista)->first();
            if($consentimiento) {
                $excel->cedula = $consentimiento->identificacion_entrevista;
            }

            $excel->nombres = $fila->nombre;
            $excel->apellidos = $fila->apellido;
            $excel->otros_nombres = $fila->alias;
            $excel->id_sexo = $fila->id_sexo;
            $excel->anio_nacimiento = $fila->fec_nac_a;
            $excel->id_sector = $fila->id_sector;
            $excel->clasificacion_nivel = $fila->clasificacion_nivel;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            //
            $excel->id_subserie=$fila->id_subserie;
            $excel->id_entrevista=$fila->id_entrevista;
            //Nuevos campos
            $excel->tipo_entrevista = "HV";
            $excel->id_macroterritorio = $fila->id_macroterritorio;
            $excel->id_territorio = $fila->id_territorio;
            $excel->id_entrevista_lugar = $fila->entrevista_lugar;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha,0,10);
            //Campos calculados
            $excel->sexo = cat_item::describir($excel->id_sexo);
            $excel->edad = -99;
            $excel->grupo_etario = persona::calcular_grupo_etario($excel->edad);
            $excel->sector = cat_item::describir($excel->id_sector);
            $excel->macroterritorio = cev::describir($excel->id_macroterritorio);
            $excel->territorio = cev::describir($excel->id_territorio);
            $geo = geo::find($excel->id_entrevista_lugar);
            if($geo) {
                $excel->entrevista_lugar_n3_codigo = $geo->codigo;
                $excel->entrevista_lugar_n3_txt = $geo->descripcion;
                $excel->entrevista_lugar_n3_lat = $geo->lat;
                $excel->entrevista_lugar_n3_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2_codigo = $geo->codigo;
                    $excel->entrevista_lugar_n2_txt = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1_codigo = $geo->codigo;
                        $excel->entrevista_lugar_n1_txt = $geo->descripcion;
                    }
                }
            }

            try {
                $excel->save();
                $total_filas++;
            }
            catch (\Exception $e) {
                $total_errores++;
                Log::error("Problemas con el ETL de excel_personas_entrevistadass:".PHP_EOL.$e->getMessage());
            }


        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
    }


    //Entrevistas colectivas. 2022-may-25.
    // A diferencia de las otras entrevistas, la info se extrae del consentimiento informado
    public static function cargar_co() {
        $total_filas=0;
        $total_errores=0;

        // Entrevistas a víctimas
        //$id_subserie=config('expedientes.vi');

        $lis_pe = \DB::table('esclarecimiento.entrevista_colectiva')
            ->join('fichas.entrevista','entrevista_colectiva.id_entrevista_colectiva','=','entrevista.id_entrevista_colectiva')
            ->where('entrevista_colectiva.id_activo',1)  //No anuladas
            ->where('borrable','<>',1) //Duplicadas
            ->selectraw(\DB::raw("entrevista_colectiva.id_entrevista_colectiva as id_entrevista, entrevista_colectiva.id_sector, consentimiento_nombres as nombre, consentimiento_apellidos as apellido, nombre_identitario as  alias, consentimiento_sexo as id_sexo,  identificacion_consentimiento, entrevista_codigo, id_sector,  clasificacion_nivel,  entrevista_lugar, id_macroterritorio, id_territorio, entrevista_fecha_inicio, entrevista.id_entrevista  as id_consentimiento"))
        ;

        $listado = $lis_pe->get();
        foreach($listado as $fila) {
            $excel = new excel_personas_entrevistadas();
            $excel->id_persona = null;
            $excel->id_sexo = $fila->id_sexo;
            $excel->edad = -99;
            $excel->nombres = $fila->nombre;
            $excel->apellidos = $fila->apellido;
            $excel->otros_nombres = $fila->alias;
            $excel->grupo_etario = persona::calcular_grupo_etario($excel->edad);
            $excel->anio_nacimiento = 0;
            $excel->id_sector = $fila->id_sector;
            $excel->clasificacion_nivel = $fila->clasificacion_nivel;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->cedula = $fila->identificacion_consentimiento;
            //
            $excel->id_subserie=config('expedientes.co');
            $excel->id_entrevista=$fila->id_entrevista;
            $excel->id_consentimiento=$fila->id_consentimiento;
            //Nuevos campos
            $excel->tipo_entrevista = 'CO';
            $excel->id_macroterritorio = $fila->id_macroterritorio;
            $excel->id_territorio = $fila->id_territorio;
            $excel->id_entrevista_lugar = $fila->entrevista_lugar;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha_inicio,0,10);
            //Campos calculados
            $excel->sexo = cat_item::describir($excel->id_sexo);
            $excel->sector = cat_item::describir($excel->id_sector);
            $excel->macroterritorio = cev::describir($excel->id_macroterritorio);
            $excel->territorio = cev::describir($excel->id_territorio);
            $geo = geo::find($excel->id_entrevista_lugar);
            if($geo) {
                $excel->entrevista_lugar_n3_codigo = $geo->codigo;
                $excel->entrevista_lugar_n3_txt = $geo->descripcion;
                $excel->entrevista_lugar_n3_lat = $geo->lat;
                $excel->entrevista_lugar_n3_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2_codigo = $geo->codigo;
                    $excel->entrevista_lugar_n2_txt = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1_codigo = $geo->codigo;
                        $excel->entrevista_lugar_n1_txt = $geo->descripcion;
                    }
                }
            }

            try {
                $excel->save();
                $total_filas++;
            }
            catch (\Exception $e) {
                $total_errores++;
                Log::error("Problemas con el ETL de excel_personas_entrevistadas(CO):".PHP_EOL.$e->getMessage());
            }


        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
    }

    // Etnicas: igual que CO, a partir de los consentimientos
    public static function cargar_ee() {
        $total_filas=0;
        $total_errores=0;


        //$id_subserie=config('expedientes.vi');

        $lis_pe = \DB::table('esclarecimiento.entrevista_etnica')
            ->join('fichas.entrevista','entrevista_etnica.id_entrevista_etnica','=','entrevista.id_entrevista_etnica')
            ->where('entrevista_etnica.id_activo',1)  //No anuladas
            ->where('borrable','<>',1) //duplicadas
            ->selectraw(\DB::raw("entrevista_etnica.id_entrevista_etnica as id_entrevista, entrevista_etnica.id_sector, consentimiento_nombres as nombre, consentimiento_apellidos as apellido, nombre_identitario as  alias, consentimiento_sexo as id_sexo,  identificacion_consentimiento, entrevista_codigo, id_sector,  clasificacion_nivel,  entrevista_lugar, id_macroterritorio, id_territorio, entrevista_fecha_inicio, entrevista.id_entrevista  as id_consentimiento "))
        ;

        $listado = $lis_pe->get();
        foreach($listado as $fila) {
            $excel = new excel_personas_entrevistadas();
            $excel->id_persona = null;
            $excel->id_sexo = $fila->id_sexo;
            $excel->edad = -99;
            $excel->nombres = $fila->nombre;
            $excel->apellidos = $fila->apellido;
            $excel->otros_nombres = $fila->alias;
            $excel->grupo_etario = persona::calcular_grupo_etario($excel->edad);
            $excel->anio_nacimiento = 0;
            $excel->id_sector = $fila->id_sector;
            $excel->clasificacion_nivel = $fila->clasificacion_nivel;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->cedula = $fila->identificacion_consentimiento;
            //
            $excel->id_subserie=config('expedientes.ee');
            $excel->id_entrevista=$fila->id_entrevista;
            $excel->id_consentimiento=$fila->id_consentimiento;
            //Nuevos campos
            $excel->tipo_entrevista = 'EE';
            $excel->id_macroterritorio = $fila->id_macroterritorio;
            $excel->id_territorio = $fila->id_territorio;
            $excel->id_entrevista_lugar = $fila->entrevista_lugar;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha_inicio,0,10);
            //Campos calculados
            $excel->sexo = cat_item::describir($excel->id_sexo);
            $excel->sector = cat_item::describir($excel->id_sector);
            $excel->macroterritorio = cev::describir($excel->id_macroterritorio);
            $excel->territorio = cev::describir($excel->id_territorio);
            $geo = geo::find($excel->id_entrevista_lugar);
            if($geo) {
                $excel->entrevista_lugar_n3_codigo = $geo->codigo;
                $excel->entrevista_lugar_n3_txt = $geo->descripcion;
                $excel->entrevista_lugar_n3_lat = $geo->lat;
                $excel->entrevista_lugar_n3_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2_codigo = $geo->codigo;
                    $excel->entrevista_lugar_n2_txt = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1_codigo = $geo->codigo;
                        $excel->entrevista_lugar_n1_txt = $geo->descripcion;
                    }
                }
            }

            try {
                $excel->save();
                $total_filas++;
            }
            catch (\Exception $e) {
                $total_errores++;
                Log::error("Problemas con el ETL de excel_personas_entrevistadas(EE):".PHP_EOL.$e->getMessage());
            }


        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
    }

    // Diagnostico Comunitario: igual que CO, a partir de los consentimientos
    public static function cargar_dc() {
        $total_filas=0;
        $total_errores=0;


        //$id_subserie=config('expedientes.vi');

        $lis_pe = \DB::table('esclarecimiento.diagnostico_comunitario')
            ->join('fichas.entrevista','diagnostico_comunitario.id_diagnostico_comunitario','=','entrevista.id_diagnostico_comunitario')
            ->where('diagnostico_comunitario.id_activo',1)  //No anuladas
            ->where('borrable','<>',1) //duplicadas
            ->selectraw(\DB::raw("diagnostico_comunitario.id_diagnostico_comunitario as id_entrevista, diagnostico_comunitario.id_sector, consentimiento_nombres as nombre, consentimiento_apellidos as apellido, nombre_identitario as  alias, consentimiento_sexo as id_sexo,  identificacion_consentimiento, entrevista_codigo, id_sector,  clasificacion_nivel,  entrevista_lugar, id_macroterritorio, id_territorio, entrevista_fecha_inicio, entrevista.id_entrevista  as id_consentimiento "))
        ;

        $listado = $lis_pe->get();
        foreach($listado as $fila) {
            $excel = new excel_personas_entrevistadas();
            $excel->id_persona = null;
            $excel->id_sexo = $fila->id_sexo;
            $excel->edad = -99;
            $excel->nombres = $fila->nombre;
            $excel->apellidos = $fila->apellido;
            $excel->otros_nombres = $fila->alias;
            $excel->grupo_etario = persona::calcular_grupo_etario($excel->edad);
            $excel->anio_nacimiento = 0;
            $excel->id_sector = $fila->id_sector;
            $excel->clasificacion_nivel = $fila->clasificacion_nivel;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->cedula = $fila->identificacion_consentimiento;
            //
            $excel->id_subserie=config('expedientes.dc');
            $excel->id_entrevista=$fila->id_entrevista;
            $excel->id_consentimiento=$fila->id_consentimiento;
            //Nuevos campos
            $excel->tipo_entrevista = 'DC';
            $excel->id_macroterritorio = $fila->id_macroterritorio;
            $excel->id_territorio = $fila->id_territorio;
            $excel->id_entrevista_lugar = $fila->entrevista_lugar;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha_inicio,0,10);
            //Campos calculados
            $excel->sexo = cat_item::describir($excel->id_sexo);
            $excel->sector = cat_item::describir($excel->id_sector);
            $excel->macroterritorio = cev::describir($excel->id_macroterritorio);
            $excel->territorio = cev::describir($excel->id_territorio);
            $geo = geo::find($excel->id_entrevista_lugar);
            if($geo) {
                $excel->entrevista_lugar_n3_codigo = $geo->codigo;
                $excel->entrevista_lugar_n3_txt = $geo->descripcion;
                $excel->entrevista_lugar_n3_lat = $geo->lat;
                $excel->entrevista_lugar_n3_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2_codigo = $geo->codigo;
                    $excel->entrevista_lugar_n2_txt = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1_codigo = $geo->codigo;
                        $excel->entrevista_lugar_n1_txt = $geo->descripcion;
                    }
                }
            }

            try {
                $excel->save();
                $total_filas++;
            }
            catch (\Exception $e) {
                $total_errores++;
                Log::error("Problemas con el ETL de excel_personas_entrevistadas(EE):".PHP_EOL.$e->getMessage());
            }


        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
    }


    //Formatos
    public function getFmtNombreCompletoAttribute() {
        return $this->nombres." ".$this->apellidos;
    }
    public function getFmtIdSexoAttribute() {
        if($this->id_sexo >0 ) {
            return cat_item::describir($this->id_sexo);
        }
        else {
            return "Sin especificar";
        }

    }
    public function getFmtAnioNacimientoAttribute() {
        if(intval($this->anio_nacimiento) >1800 ) {
            return $this->anio_nacimiento;
        }
        else {
            return "Sin especificar";
        }
    }
    public function getFmtIdSectorAttribute() {
        return cat_item::describir($this->id_sector);
    }

    public function getFmtIdSubserieAttribute() {
        if($this->id_subserie == config('expedientes.pr')) {
            return "Profundidad";
        }
        elseif($this->id_subserie == config('expedientes.hv')) {
            return "Historia de vida";
        }
        elseif($this->id_subserie == config('expedientes.co')) {
            return "Entrevista colectiva";
        }
        else {
            return "Víctimas";
        }
    }
    public function getFmtNivelClasificacionAttribute() {
        return criterio_fijo::describir(13,$this->clasificacion_nivel);
    }

    public function getEnlaceAttribute() {
        if($this->id_subserie == config('expedientes.pr')) {
            $action = 'entrevista_profundidadController@show';
        }
        elseif($this->id_subserie == config('expedientes.hv')) {
            $action = 'historia_vidaController@show';
        }
        elseif($this->id_subserie == config('expedientes.co')) {
            $action = 'entrevista_colectivaController@show';
        }
        else {
            $action = 'entrevista_individualController@show';
        }
        $url = action($action,$this->id_entrevista);
        $btn = "<a class='btn btn-sm btn-primary btn-block' target='_blank' href='$url'>$this->codigo_entrevista</a>";
        return $btn;
    }

    //Criterios para filtrar
    public static function filtros_default($request = null)
    {
        $filtro = new \stdClass();
        $filtro->nombre = "";
        $filtro->id_sexo = -1;
        $filtro->id_sector = -1;
        $filtro->id_macroterritorio = -1;
        $filtro->id_territorio = -1;
        $filtro->anio_nacimiento="";
        $filtro->codigo_entrevista="";
        $filtro->clasificacion_nivel=-1;
        //Asigar del request
        foreach($filtro as $var=>$val) {
            $filtro->$var = isset($request->$var) ? $request->$var : $val;
        }
        if($request->id_territorio_macro > 0) {
            $filtro->id_macroterritorio=$request->id_territorio_macro;
        }

        //Seguridad: Si NO es administrador/comisionado, solo los propios
        if(\Gate::denies('revisar-m-nivel',[[1,6]])) {
            if(\Auth::check()) {
                $codigo = \Auth::user()->fmt_numero_entrevistador;
            }
            else {
                $codigo="XXX-";
            }
            $filtro->codigo_entrevista=$codigo."-";
        }


        //Logica interna
        if(is_object($request)) {
            if(method_exists($request,'fullUrl')) {
                $url = $request->fullUrl();
                $pedazos = explode("?",$url);
                if(isset($pedazos[1])) {
                    $filtro->url = $pedazos[1]."&";

                }
                else {
                    $filtro->url="";
                }
            }
        }

        return $filtro;
    }
    //Filtros
    public static  function scopeOrdenar($query) {
        $query->orderby('nombres')->orderby('apellidos')->orderby('otros_nombres')->orderby('anio_nacimiento');
    }

    public static  function scopeId_Sexo($query, $criterio=-1) {
        if(is_array($criterio)) {
            $query->wherein('id_sexo',$criterio);
        }
        else {
            if($criterio==0) {
                $query->whereNull('id_sexo');
            }
            elseif($criterio > 0) {
                $query->where('id_sexo',$criterio);
            }
        }
    }
    public static  function scopeId_sector($query, $criterio=-1) {
        if(is_array($criterio)) {
            $query->wherein('id_sector',$criterio);
        }
        else {
            if($criterio==0) {
                $query->whereNull('id_sector');
            }
            elseif($criterio > 0) {
                $query->where('id_sector',$criterio);
            }
        }
    }
    public static  function scopeClasificacion_nivel($query, $criterio=-1) {
        if(is_array($criterio)) {
            $query->wherein('clasificacion_nivel',$criterio);
        }
        else {
            if($criterio==0) {
                $query->whereNull('clasificacion_nivel');
            }
            elseif($criterio > 0) {
                $query->where('clasificacion_nivel',$criterio);
            }
        }
    }
    public static function scopeCodigo_Entrevista($query, $criterio=null) {
        if(!is_null($criterio)) {
            $criterio=trim($criterio);
            if(strlen($criterio)>0) {
                $query->where('codigo_entrevista','ilike',"$criterio%");
            }
        }
    }
    //Full text search
    public static function scopeFts($query, $criterio=null) {
        $buscar = entrevista_individual::procesar_texto_fts($criterio);  //Agrega conectores logicos, quita caracteres especiales, etc.
        if(strlen($buscar)>0) {
            $query->addSelect(\DB::raw("ts_rank('fts', to_tsquery('pg_catalog.spanish',unaccent('$buscar'))) as rank1"));
            $query->whereraw(\DB::raw("fts @@ to_tsquery('pg_catalog.spanish',unaccent('$buscar'))"));
        }
    }

    //Macroterriotrio
    public static  function scopeId_Macroterritorio($query, $criterio=-1) {
        if(is_array($criterio)) {
            $query->wherein('id_macroterritorio',$criterio);
        }
        elseif($criterio > 0) {
            $query->where('id_macroterritorio',$criterio);
        }
    }
    //Macroterriotrio
    public static  function scopeId_Territorio($query, $criterio=-1) {
        if(is_array($criterio)) {
            $query->wherein('id_territorio',$criterio);
        }
        elseif($criterio > 0) {
            $query->where('id_territorio',$criterio);
        }
    }

    public static function scopeFiltrar($query,$criterios) {
        if(!is_object($criterios)) {
            $criterios=excel_personas_entrevistadas::filtros_default();
        }

        $query->fts($criterios->nombre)
            ->id_sexo($criterios->id_sexo)
            ->id_macroterritorio($criterios->id_macroterritorio)
            ->id_territorio($criterios->id_territorio)
            ->id_sector($criterios->id_sector)
            ->clasificacion_nivel($criterios->clasificacion_nivel)
            ->codigo_entrevista($criterios->codigo_entrevista);
    }

}
