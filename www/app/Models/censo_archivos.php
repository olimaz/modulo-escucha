<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

/**
 * Class censo_archivos
 * @package App\Models
 * @version February 18, 2021, 8:30 pm -05
 *
 * @property integer id_censo_archivos
 * @property integer id_tipo
 * @property integer id_macroterritorio
 * @property integer id_territorio,
 * @property integer id_entrevistador
 * @property integer numero_entrevistador
 * @property integer id_subserie
 * @property string entrevista_codigo
 * @property integer entrevista_correlativo
 * @property integer entrevista_numero
 * @property string custodio
 * @property string direccion
 * @property integer id_geo
 * @property string contacto_nombre
 * @property string contacto_correo
 * @property string contacto_telefono
 * @property string contacto_url
 * @property integer archivo_fisico
 * @property string archivo_fisico_volumen
 * @property string archivo_fisico_ubicacion
 * @property integer archivo_electronico
 * @property string archivo_electronico_volumen
 * @property string archivo_electronico_ubicacion
 * @property integer archivo_virtual
 * @property string archivo_virtual_volumen
 * @property string archivo_virutal_ubicacion
 * @property integer acceso_publico
 * @property string acceso_publico_volumen
 * @property string acceso_publico_descripcion
 * @property integer acceso_clasificado
 * @property string acceso_clasificado_volumen
 * @property string acceso_clasificado_descripcion
 * @property integer acceso_reservado
 * @property string acceso_reservado_volumen
 * @property string acceso_reservado_descripcion
 * @property string anotaciones
 * @property string ficha_diligenciada_nombre
 * @property string ficha_diligenciada_telefono
 * @property string ficha_diligenciada_correo
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 * @property string perfil_productor
 * @property integer id_nivel_organizacion
 * @property string indice
 * @property string contenido_tematico
 * @property string sintesis
 * @property integer consentimiento_repositorio
 * @property integer consentimiento_publicar
 * @property string cobertura_geografica
 * @property integer anio_del
 * @property integer anio_al
 *
 *
 */
class censo_archivos extends Model
{

    public $table = 'esclarecimiento.censo_archivos';
    protected $primaryKey = 'id_censo_archivos';
    public $timestamps = true;




    public $fillable = [
        'id_tipo',
        'custodio',
        'direccion',
        'id_geo',
        'id_macroterritorio',
        'id_territorio',
        'id_entrevistador',
        'contacto_nombre',
        'contacto_correo',
        'contacto_telefono',
        'contacto_url',
        'archivo_fisico',
        'archivo_fisico_volumen',
        'archivo_fisico_ubicacion',
        'archivo_electronico',
        'archivo_electronico_volumen',
        'archivo_electronico_ubicacion',
        'archivo_virtual',
        'archivo_virtual_volumen',
        'archivo_virtual_ubicacion',
        'acceso_publico',
        'acceso_publico_volumen',
        'acceso_publico_descripcion',
        'acceso_clasificado',
        'acceso_clasificado_volumen',
        'acceso_clasificado_descripcion',
        'acceso_reservado',
        'acceso_reservado_volumen',
        'acceso_reservado_descripcion',
        'anotaciones',
        'ficha_diligenciada_nombre',
        'ficha_diligenciada_telefono',
        'ficha_diligenciada_correo',
        'perfil_productor',
        'id_nivel_organizacion',
        'indice',
        'contenido_tematico',
        'sintesis',
        'consentimiento_repositorio',
        'consentimiento_publicar',
        'anio_del',
        'anio_al',
        'cobertura_geografica',

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_censo_archivos' => 'integer',
        'id_tipo' => 'integer',
        'custodio' => 'string',
        'direccion' => 'string',
        'id_geo' => 'integer',
        'contacto_correo' => 'string',
        'contacto_telefono' => 'string',
        'contacto_url' => 'string',
        'archivo_fisico' => 'integer',
        'archivo_fisico_volumen' => 'string',
        'archivo_fisico_ubicacion' => 'string',
        'archivo_electronico' => 'integer',
        'archivo_electronico_volumen' => 'string',
        'archivo_electronico_ubicacion' => 'string',
        'archivo_virtual' => 'integer',
        'archivo_virtual_volumen' => 'string',
        'archivo_virtual_ubicacion' => 'string',
        'acceso_publico' => 'integer',
        'acceso_publico_volumen' => 'string',
        'acceso_publico_descripcion' => 'string',
        'acceso_clasificado' => 'integer',
        'acceso_clasificado_volumen' => 'string',
        'acceso_clasificado_descripcion' => 'string',
        'acceso_reservado' => 'integer',
        'anio_del' => 'integer',
        'anio_al' => 'integer',
        'acceso_reservado_volumen' => 'string',
        'acceso_reservado_descripcion' => 'string',
        'anotaciones' => 'string',
        'ficha_diligenciada_nombre' => 'string',
        'ficha_diligenciada_telefono' => 'string',
        'ficha_diligenciada_correo' => 'string',
        'cobertura_geografica' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //Relaciones
    public function rel_id_tipo()
    {
        return $this->belongsTo(\App\Models\cat_item::class, 'id_tipo', 'id_item');
    }
    public function rel_id_territorio()
    {
        return $this->belongsTo(\App\Models\cev::class, 'id_territorio', 'id_geo');
    }
    public function rel_id_macroterritorio()
    {
        return $this->belongsTo(\App\Models\cev::class, 'id_macroterritorio', 'id_geo');
    }
    public function rel_id_entrevistador()
    {
        return $this->belongsTo(\App\Models\entrevistador::class, 'id_entrevistador', 'id_entrevistador');
    }


    public function rel_temas()
    {
        return $this->hasMany(\App\Models\censo_archivos_temas::class, 'id_censo_archivos','id_censo_archivos');
    }


    public function rel_detalle()
    {
        return $this->hasMany(\App\Models\censo_archivos_detalle::class, 'id_censo_archivos','id_censo_archivos');
    }

    public function rel_id_geo() {
        return $this->belongsTo(geo::class,'id_geo','id_geo');
    }

    ///Adjuntos
    public function rel_adjuntos() {
        return $this->hasMany(censo_archivos_adjunto::class,'id_censo_archivos','id_censo_archivos');
    }

    //Permisos de acceso
    public function rel_permisos() {
        return $this->hasMany(censo_archivos_permisos::class, 'id_censo_archivos','id_censo_archivos');
    }


    //Formatos
    public function getFmtIdTipoAttribute() {
        return cat_item::describir($this->id_tipo);
    }

    public function getFmtIdGeoAttribute() {
        return geo::nombre_completo($this->id_geo);
    }
    public function getFmtArchivoFisicoAttribute() {
        return criterio_fijo::describir(2,$this->archivo_fisico);
    }
    public function getFmtArchivoElectronicoAttribute() {
        return criterio_fijo::describir(2,$this->archivo_electronico);
    }
    public function getFmtArchivoVirtualAttribute() {
        return criterio_fijo::describir(2,$this->archivo_virtual);
    }
    public function getFmtAccesoPublicoAttribute() {
        return cat_item::describir($this->acceso_publico);
    }
    public function getFmtAccesoClasificadoAttribute() {
        return cat_item::describir($this->acceso_clasificado);
    }
    public function getFmtAccesoReservadoAttribute() {
        return cat_item::describir($this->acceso_reservado);
    }
    public function getFmtIdTerritorioAttribute() {
        return cev::nombre_completo($this->id_territorio);
    }
    public function getFmtIdNivelOrganizacionAttribute() {
        return cat_item::describir($this->id_nivel_organizacion);
    }
    public function getFmtConsentimientoPublicarAttribute() {
        return criterio_fijo::describir(2, $this->consentimiento_publicar);
    }
    public function getFmtConsentimientoRepositorioAttribute() {
        return criterio_fijo::describir(2, $this->consentimiento_repositorio);
    }
    //Edicion de controles de seleccion multiple
    public function elegidos($id_cat) {
        $arreglo = censo_archivos_detalle::join('catalogos.cat_item','censo_archivos_detalle.id_opcion','id_item')
                                        ->where('id_cat',$id_cat)
                                        ->where('id_censo_archivos',$this->id_censo_archivos)
                                        ->pluck('id_item')
                                        ->toArray();
        return $arreglo;
    }

    //-----   Logica interna

    //Calculo de codigo que le toca, usado en insert.  Asigna el campo correlativo, codigo, id_subserie
    public function asignar_codigo($id_entrevistador=0) {
        $id_subserie=config('expedientes.ca');
        $correlativo=correlativo::cual_toca($id_subserie);  //Calcular el consecutivo general
        $this->entrevista_correlativo =$correlativo;
        $this->id_subserie = $id_subserie;
        if($id_entrevistador > 0) {
            $this->id_entrevistador=$id_entrevistador;
        }
        //el consecutivo del entrevistador se recibe del formulario, debe ser validado
        $this->entrevista_codigo = $this->calcular_codigo();
        $this->entrevista_numero = $this->cual_toca();

        return $this->entrevista_codigo;
    }
    //Calcula el prefijo del código según la serie y el entrevistador (uso interno)
    public function prefijo_codigo() {
        $id_subserie=config('expedientes.ca');
        //Defaults, si no está autenticado (para pruebas)
        $txt="XX";
        $entrev="xxx";
        $cual = cat_item::find($id_subserie);
        if($cual) {
            if(strlen($cual->abreviado) > 0) {
                $txt= $cual->abreviado;
            }
        }
        $quien = entrevistador::find($this->id_entrevistador);
        if($quien) {
            $entrev = $quien->fmt_numero_entrevistador;
        }
        $codigo = $entrev."-".$txt."-";
        return $codigo;
    }

    //Con los datos que tiene el modelo, calcula el código. Usado en insert y update.  No calcula ningun consecutivo
    public function calcular_codigo() {
        $txt = $this->prefijo_codigo();
        $corr = str_pad($this->entrevista_correlativo,5,"0",STR_PAD_LEFT);
        return $txt.$corr;
    }
    //Para el create, establece el siguiente correlativo que le toca al entrevistador
    public function cual_toca() {
        $max=self::where('id_entrevistador',$this->id_entrevistador)
            ->max('entrevista_numero');
        $nuevo=intval($max)+1;
        return $nuevo;
    }
    //Para el create, establece los valores predeterminados
    public function valores_iniciales($id_entrevistador=0) {
        if($id_entrevistador==0) {
            $id_entrevistador = \Auth::user()->id_entrevistador;
        }
        $entrevistador = entrevistador::find($id_entrevistador);
        $this->id_entrevistador=$id_entrevistador;
        $this->entrevista_numero = $this->cual_toca();
        $this->id_territorio = $entrevistador->id_territorio;
        $this->id_macroterritorio = $entrevistador->id_macroterritorio;
    }

    //Logica sacada del Controller@store
    public static function crear_nuevo($request) {
        //Respuesta para el controlador
        $res= new \stdClass();
        $res->mensaje="";
        $res->exito=false;
        $res->nuevo = new censo_archivos();

        //Procesar el request
        $id_entrevistador=intval($request->id_entrevistador);
        //No se valida el numero de entrevista, por que no se solicita, simplemente se calcula
        //Calcular el código
        $nueva = new censo_archivos();
        $nueva->id_entrevistador=$id_entrevistador;
        $codigo = $nueva->asignar_codigo();  //asigna correlativo y codigo
        //Asignar algunos valores manualmente
        $nueva->numero_entrevistador = entrevistador::find($id_entrevistador)->numero_entrevistador;
        $nueva->id_macroterritorio = $request->id_territorio_macro;

        try {
            $input = $request->all();
            $nueva->fill($input);
            $nueva->id_activo = 1; //default
            $nueva->insert_ent = \Auth::user()->id_entrevistador;
            $nueva->insert_ip =\Request::ip();
            $nueva->insert_fh = \Carbon\Carbon::now();
            $nueva->save();


            //Registrar detalle
            $nueva->registrar_detalle($request->id_opcion);
            //Registrar temas
            //$nueva->registrar_temas($request);

            $res->mensaje = "Registro creado";
            $res->exito = true;
            $res->nuevo = $nueva;
            return $res;

        }

        catch (\Exception $e) {
            $res->mensaje = 'Problemas al grabar la información: '.$e->getMessage();
            Log::error("Problema al grabar nuevo censo de archivos".PHP_EOL.$e->getMessage());
            $res->exito = false;
            return $res;
        }
    }

    //Logica sacada del Controller@update
    public  function actualizar($request) {
        //Respuesta para el controlador
        $res= new \stdClass();
        $res->mensaje="";
        $res->exito=false;



        //Leer el request y meterlo a un arreglo
        $input = $request->all();
        //El correlativo no puede cambiar
        unset($input['entrevista_correlativo']);
        //No se valia el numero de entrevista, se queda así
        unset($input['entrevista_numero']);
        //El entrevistador no puede cambiar
        unset($input['id_entrevistador']);
        //El numero de entrevistador no puede cambiar
        unset($input['numero_entrevistador']);
        //El código no tiene porqué cambiar

        //Macroterritorio
        $input['id_macroterritorio'] = $request->id_territorio_macro;

        //Persistir a la BD
        try {
            $this->fill($input);
            //El código no tiene porqué cambiar
            //$this->entrevista_codigo = $this->calcular_codigo();
            $this->updated_at=Carbon::now();
            $this->update_ent = \Auth::user()->id_entrevistador;
            $this->update_ip =\Request::ip();
            $this->update_fh = \Carbon\Carbon::now();
            $this->save();
            //Consultado por, riesgos
            $this->registrar_detalle($request->id_opcion);


            $res->exito=true;
            $res->mensaje= "Caso actualizado";
            return $res;
        }
        catch (\Exception $e) {
            $res->exito=false;
            $res->mensaje = "Problemas al actualizar la base de datos: ".$e->getMessage();
            Log::error("Problema al modificar censo de archivos".PHP_EOL.$e->getMessage());
            return $res;
        }

    }
    //Procesar en create/update los campos multiples
    public function registrar_detalle($arreglo) {
        //dd($arreglo);
        censo_archivos_detalle::where('id_censo_archivos',$this->id_censo_archivos)->delete();
        $conteo=0;
        foreach($arreglo as $id_opcion) {
            if($id_opcion>0) {
                censo_archivos_detalle::create(['id_censo_archivos'=>$this->id_censo_archivos, 'id_opcion'=>$id_opcion]);
                $conteo++;
            }

        }
        return $conteo;
    }
    //Procesar en create/update los campos de temas, que pueden ser multiples
    public function registrar_temas($request) {
        //dd($arreglo);
        censo_archivos_temas::where('id_censo_archivos',$this->id_censo_archivos)->delete();
        $conteo=0;
        foreach($request->nombre as $id => $nombre) {
            if(strlen(trim($nombre))>0) {
                $nombre=trim($nombre);
                $tmp = new censo_archivos_temas();
                $tmp->id_censo_archivos = $this->id_censo_archivos;
                $tmp->nombre = $nombre;
                $tmp->descripcion = $request->descripcion[$id];
                $tmp->save();
                $conteo++;
            }
        }
        return $conteo;
    }


    /// scopes y filtros


    //Filtros
    public static function filtros_default($request = null) {
        $fecha = Carbon::now();
        //Valores por defecto
        $filtro =new \stdClass();
        $filtro->id_tipo = -1;
        $filtro->id_macroterritorio = -1;
        $filtro->id_territorio = -1;
        $filtro->id_entrevistador = -1;
        $filtro->entrevista_codigo = null;
        $filtro->custodio = null;
        $filtro->id_geo = -1;
        $filtro->archivo_fisico = -1;
        $filtro->archivo_electronico = -1;
        $filtro->archivo_virtual = -1;
        $filtro->tema = -1;  //Full text search en tabla hija
        $filtro->acceso_publico = -1;
        $filtro->acceso_clasificado = -1;
        $filtro->acceso_reservado = -1;
        $filtro->id_consultado = -1;
        $filtro->id_riesgo_s = -1;
        $filtro->id_riesgo_a = -1;



        // Actualizar valores del REQUEST
        foreach($filtro as $var => $val) {
            $filtro->$var = isset($request->$var) ? $request->$var : $filtro->$var;
        }
        //Valores geograficos: buscar depto y muni si no hay lugar poblado
        $filtro->id_geo = victima::determinar_geo($request,'id_geo');


        //Para poder agregar el query string a a los links por GET
        if(is_object($request)) {
            if(method_exists($request,'fullUrl')) {
                $url = $request->fullUrl();
                $pedazos = explode("?",$url);
                if(isset($pedazos[1])) {
                    $filtro->url = $pedazos[1]."&";

                }
                else {
                    $filtro->url="?";
                }
            }
        }

        //ultima propiedad.  Actualizada en los scopeXYZ
        $filtro->hay_filtro=0;

        return $filtro;
    }


    //// SEGURIDAD /////////

    //Para el show del caso
    public function listar_adjuntos() {
        $q = censo_archivos_adjunto::where('id_censo_archivos',$this->id_censo_archivos)
            ->join('esclarecimiento.adjunto','censo_archivos_adjunto.id_adjunto','=','adjunto.id_adjunto') //Para no halar datos inconsistentes
            ->orderby('censo_archivos_adjunto.descripcion');


        $listado = $q->selectraw(\DB::raw('censo_archivos_adjunto.*'))->get();
        return $listado;

    }

    //Permisos y privilegios
    //Para mostrar los usuarios en orden alfabetico
    public function getListadoUsuariosAttribute() {
        $listado = censo_archivos_permisos::join('esclarecimiento.entrevistador','censo_archivos_permisos.id_entrevistador','=','entrevistador.id_entrevistador')
            ->join('users','entrevistador.id_usuario','=','users.id')
            ->where('id_censo_archivos',$this->id_censo_archivos)
            ->orderby('users.name')
            ->get();
        return $listado;
    }
    //Para la seguridad
    public function getPrivilegiosAttribute() {
        if(\Auth::check()) {
            $id_entrevistador = \Auth::user()->id_entrevistador;
        }
        else {
            $id_entrevistador = -1;
        }
        if($this->id_entrevistador == $id_entrevistador) {
            return 1; //propietario
        }
        else {
            $existe = $this->rel_permisos()->where('id_entrevistador',$id_entrevistador)->first();
            if($existe) {
                return $existe->id_perfil;
            }
            else {
                return 10; //El nivel mas bajo
            }
        }

    }
    //Para mostrar secciones según el perfil
    public  function secciones_permitidas() {
        $arreglo = \App\Models\criterio_fijo::listado_items(50);
        $nivel = $this->privilegios;
        if($nivel==1) { //Propietario
            //No hacer nada
        }
        elseif($nivel==5) { //Colaborador
            unset($arreglo[2]); //Solicitudes
            unset($arreglo[4]); //Análisis y seguimeinto
        }
        else { //Acceso general
            unset($arreglo[2]); //Solicitudes
            unset($arreglo[3]); //Diseño metodológico
            unset($arreglo[4]); //Análisis y seguimeinto
        }
        return $arreglo;


    }
    ////PAra el controller, me permite determinar si puede modificar la entrevista.  Lo uso en la vista para ocultar botones de edición
    public function puede_modificar_entrevista() {
        if(\Gate::check('sistema-cerrado')) {
            return false;
        }
        $puede=false;  //Predeterminado
        if(in_array($this->privilegios,[1,5])) {
            $puede=true;
        }
        else {
            if(\Gate::check('es-propio',$this->id_entrevistador)) {
                $puede=true;
            }
            elseif(\Gate::check('nivel-1')) {
                $puede=true;
            }
        }
        //Sin otras validaciones
        return $puede;
    }
    //Para persistir el permiso
    public function getPuedeModificarAttribute() {
        return $this->puede_modificar_entrevista();
    }
    //Todos pueden acceder al registro
    public function getPuedeAccederEntrevistaAttribute() {
        return true;
    }


    //Devuelve true/false para determinar si el usuario activo puede agregar/quitar adjuntos
    public function puede_modificar_adjuntos() {
        //return $this->puede_modificar_entrevista();
        return in_array($this->privilegios,[1,5]);
    }
    //Basado en puede_acceder, encapsula todas las revisiones por hacer respecto a R2, R3, R4
    public function puede_acceder_adjuntos() {
        return true;
    }
}
