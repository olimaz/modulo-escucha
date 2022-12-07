<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Eloquent as Model;
use Flash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

/**
 * Class mis_casos
 * @package App\Models
 * @version June 12, 2020, 12:11 pm -05
 *
 * @property \App\Models\Catalogos.cev idMacroterritorio
 * @property \App\Models\Catalogos.cev idTerritorio
 * @property \App\Models\Esclarecimiento.entrevistador idEntrevistador
 * @property \App\Models\Esclarecimiento.entrevistador idEntrevistador
 * @property \App\Models\User idUsuario
 * @property integer id_mis_casos
 * @property integer id_macroterritorio
 * @property integer id_territorio
 * @property integer id_entrevistador
 * @property integer entrevista_correlativo
 * @property integer entrevista_numero
 * @property string entrevista_codigo
 * @property string nombre
 * @property string descripcion
 * @property integer id_activo
 * @property integer id_cerrado
 * @property string fts
 * @property integer id_usuario
 * @property integer id_tipo_victima
 * @property integer id_ambito
 * @property integer anyo_inicio
 * @property integer anyo_fin
 * @property string territorio
 * @property string observaciones
 * @property string investigacion_judicial
 * @property string medidas_reparacion
 * @property integer id_avance
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class mis_casos extends Model
{

    public $table = 'esclarecimiento.mis_casos';
    
    public $timestamps = false;



    protected $primaryKey = 'id_mis_casos';

    public $fillable = [
        'id_macroterritorio',
        'id_territorio',
        'id_entrevistador',
        'entrevista_correlativo',
        'entrevista_numero',
        'entrevista_codigo',
        'nombre',
        'descripcion',
        'id_activo',
        'id_cerrado',
        'fts',
        'id_usuario',
        'created_at',
        'updated_at'
        , 'id_tipo_victima'
        , 'anyo_inicio'
        , 'anyo_fin'
        , 'id_ambito'
        , 'territorio'
        , 'investigacion_judicial'
        , 'medidas_reparacion'
        , 'observaciones'
        , 'id_avance'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_mis_casos' => 'integer',
        'id_macroterritorio' => 'integer',
        'id_territorio' => 'integer',
        'id_entrevistador' => 'integer',
        'entrevista_correlativo' => 'integer',
        'entrevista_numero' => 'integer',
        'entrevista_codigo' => 'string',
        'nombre' => 'string',
        'descripcion' => 'string',
        'id_activo' => 'integer',
        'id_cerrado' => 'integer',
        'fts' => 'string',
        'id_usuario' => 'integer'
        ,'id_avance' => 'integer'
        //'created_at' => 'datetime',
        //'updated_at' => 'datetime'
        , 'id_tipo_victima' => 'integer'
        , 'anyo_inicio' => 'integer'
        , 'anyo_fin' => 'integer'
        , 'id_ambito' => 'integer'
        , 'territorio' => 'string'
        , 'investigacion_judicial' => 'string'
        , 'medidas_reparacion' => 'string'
        , 'observaciones' => 'string'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_macroterritorio()
    {
        return $this->belongsTo(cev::class, 'id_macroterritorio','id_geo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_territorio()
    {
        return $this->belongsTo(cev::class, 'id_territorio','id_geo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_entrevistador()
    {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador','id_entrevistador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario','id');
    }
    public function rel_id_tipo_victima() {
        return $this->belongsTo(cat_item::class, 'id_tipo_victima','id)item');
    }
    public function rel_id_ambito() {
        return $this->belongsTo(cat_item::class, 'id_ambito','id)item');
    }
    ///Adjuntos
    public function rel_adjuntos() {
        return $this->hasMany(mis_casos_adjunto::class,'id_mis_casos','id_mis_casos');
    }
    //Detalle
    public function rel_detalle() {
        return $this->hasMany(mis_casos_detalle::class,'id_mis_casos','id_mis_casos');
    }
    //Tareas (to-do)
    public function rel_tareas() {
        return $this->hasMany(mis_casos_tareas::class,'id_mis_casos','id_mis_casos')
                ->orderby('realizado','desc')
                ->orderby('id_mis_casos_tareas');
    }
    //Personas
    public function rel_personas() {
        return $this->hasMany(mis_casos_persona::class,'id_mis_casos','id_mis_casos')
            ->orderby('nombre');
    }
    //Blog
    public function rel_blog() {
        return $this->hasMany(mis_casos_blog::class,'id_mis_casos','id_mis_casos');
    }
    //Permisos de acceso
    public function rel_permisos() {
        return $this->hasMany(mis_casos_entrevistador::class, 'id_mis_casos','id_mis_casos');
    }

    // Para la tabla de adjuntos
    public function getAdjuntosAttribute() {
        return mis_casos::listado_adjuntos($this->id_mis_casos);
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
        elseif(Gate::check('nivel-1')) { //Cambio el 3-jun-22
            return 3;
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
    //////////////////////Getters
    ///
    public function getFmtIdAvanceAttribute() {
        return criterio_fijo::describir(52,$this->id_avance);
    }
    public function getFmtIdEntrevistadorAttribute() {
        $item = $this->rel_id_entrevistador;
        if($item) {
            return $item->fmt_nombre;
        }
        else {
            return "Desconocido ($this->id_entrevistador)";
        }
    }
    public function getFmtIdCerradoAttribute() {
        $str="";
        if($this->id_cerrado==1) {
            $str = '<i class="fa fa-lock"  title="Procesamiento finalizado" data-toggle="tooltip" aria-hidden="true"></i>';
        }
        return $str;
    }
    public function getFmtIdMacroterritorioAttribute() {
        return cev::nombre_completo($this->id_macroterritorio);
    }
    public function getFmtIdTerritorioAttribute() {
        return cev::nombre_completo($this->id_territorio);
    }
    public function getFmtIdTipoVictimaAttribute() {
        return cat_item::describir($this->id_tipo_victima);
    }
    public function getFmtIdAmbitoAttribute() {
        return cat_item::describir($this->id_ambito);
    }
    //Mostrar parcialmente
    public function getFmtDescripcionAttribute() {
        $html = nl2br($this->descripcion);

        $pos = strpos($html,"<br />");
        if($pos > 10) {
            $primero = substr($html,0,$pos);
            $segundo = substr($html,$pos+6);
            $id=$this->id_mis_casos;
            $btn_mostrar = "<button class='btn btn-xs btn-default' id='btn_mas_$id' onclick='$(\"#div_resto_$id\").removeClass(\"hidden\");$(\"#btn_mas_$id\").addClass(\"hidden\");'>Mostrar texto completo</button>";
            $btn_ocultar = "<button class='btn btn-xs btn-default' id='btn_menos_$id' onclick='$(\"#div_resto_$id\").addClass(\"hidden\");$(\"#btn_mas_$id\").removeClass(\"hidden\");'>Recortar</button>";

            $nuevo = $primero.$btn_mostrar;
            $nuevo.="<div id='div_resto_$id' class='hidden'>$segundo $btn_ocultar</div>";
            return $nuevo;
        }
        else {
            return $html;
        }

    }

    //Logica interna

    //Calculo de codigo que le toca, usado en insert
    public function asignar_codigo($id_entrevistador=0) {
        $id_subserie=config('expedientes.mc');
        $correlativo=correlativo::cual_toca($id_subserie);
        $this->entrevista_correlativo =$correlativo;
        $corr = str_pad($this->entrevista_numero,5,"0",STR_PAD_LEFT);
        if($id_entrevistador > 0) {
            $this->id_entrevistador=$id_entrevistador;
        }
        $txt = $this->prefijo_codigo();
        $codigo = $txt.$corr;
        $this->entrevista_codigo = $codigo;
        return $codigo;
    }
    //Calcula el prefijo del código según la serie y el entrevistador
    public function prefijo_codigo() {
        $id_subserie=config('expedientes.mc');
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
    //Con los datos que tiene, calcula el código. Usado en udpate
    public function calcular_codigo() {
        $txt = $this->prefijo_codigo();
        $corr = str_pad($this->entrevista_numero,5,"0",STR_PAD_LEFT);
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
    }

    //Logica sacada del Controller@store
    public static function crear_nuevo($request) {
        //Respuesta para el controlador
        $res= new \stdClass();
        $res->mensaje="";
        $res->exito=false;
        $res->nuevo = new mis_casos();

        //Procesar el request
        $id_entrevistador=intval($request->id_entrevistador);
        //Validar número de entrevista
        $entrevista_numero = intval($request->entrevista_numero);
        $existe = mis_casos::where('id_entrevistador',$id_entrevistador)
            ->where('entrevista_numero',$entrevista_numero)
            ->first();
        if(!empty($existe)) {
            $res->mensaje = "Número de caso en uso.  No puede duplicar el número $request->entrevista_numero";
            $res->exito = false;
            return $res;
        }

        //Calcular el código
        $entrevista = new mis_casos();
        $entrevista->id_entrevistador=$id_entrevistador;
        $entrevista->entrevista_numero = $request->entrevista_numero;
        $codigo = $entrevista->asignar_codigo($id_entrevistador);  //asigna correlativo y codigo


        $input = $request->all();
        //Datos calculados
        $input['entrevista_correlativo']=$entrevista->entrevista_correlativo;
        $input['entrevista_codigo']=$codigo;
        $input['id_entrevistador']=$id_entrevistador;
        $input['id_macroterritorio']=$request->id_territorio_macro;
        $input['id_usuario']=\Auth::user()->id;
        $input['numero_entrevistador']=entrevistador::find($id_entrevistador)->numero_entrevistador;

        try {
            $nueva = new mis_casos();
            $nueva->fill($input);
            $nueva->id_avance = 1; //default
            $nueva->save();
            //Procesar marcas
            //$nueva->registrar_marcas($request->id_marca);
            //Agregar entrevistas por marca.
            //$nueva->agregar_entrevistas_por_marca($request->id_marca);
            //Procesar detalle
            $nueva->registrar_detalle($request);

            //Traza de seguridad
            traza_actividad::create(['id_objeto'=>15, 'id_accion'=>3, 'codigo'=>$codigo, 'id_primaria'=>$nueva->id_mis_casos]);

            $res->mensaje = "Caso creado";
            $res->exito = true;
            $res->nuevo = $nueva;
            return $res;

        }

        catch (\Exception $e) {
            $res->mensaje = 'Problemas al grabar la información: '.$e->getMessage();
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

        //Revisar que el número no se duplique
        $existe = mis_casos::where('id_entrevistador',$request->id_entrevistador)
            ->where('entrevista_numero',$request->entrevista_numero)
            ->where('id_mis_casos','<>',$this->id_mis_casos)
            ->first();

        if($existe) {
            $res->mensaje = "Número de caso en uso.  No puede duplicar el número $request->entrevista_numero";
            $res->exito = false;
            return $res;
        }
        //Leer el request y meterlo a un arreglo
        $input = $request->all();
        //El correlativo no puede cambiar
        unset($input['entrevista_correlativo']);
        //El entrevistador no puede cambiar
        unset($input['id_entrevistador']);
        //El numero de entrevistador no puede cambiar
        unset($input['numero_entrevistador']);
        //Macroterritorio
        $input['id_macroterritorio'] = $request->id_territorio_macro;

        //Persistir a la BD
        try {
            $this->fill($input);
            $this->entrevista_codigo = $this->calcular_codigo();
            $this->updated_at=Carbon::now();
            $this->save();
            //Marcas
            //$this->registrar_marcas($request->id_marca);
            //$this->agregar_entrevistas_por_marca($request->id_marca);
            //Procesar detalle

            $this->registrar_detalle($request);


            //Registrar traza
            traza_actividad::create(['id_objeto'=>15, 'id_accion'=>4, 'codigo'=>$this->entrevista_codigo , 'id_primaria'=>$this->id_mis_casos]);
            $res->exito=true;
            $res->mensaje= "Caso actualizado";
            return $res;
        }
        catch (\Exception $e) {
            $res->exito=false;
            $res->mensaje = "Problemas al actualizar la base de datos: ".$e->getMessage();
            return $res;
        }

    }
    //Grabar marcas asociadas
    public function registrar_marcas($arreglo) {
        marca_entrevista::where('id_subserie',config('expedientes.mc'))->where('id_entrevista',$this->id_mis_casos)->delete();
        if(is_array($arreglo)) {
            foreach($arreglo as $id_marca) {
                $marca = new marca_entrevista();
                $marca->id_subserie=config('expedientes.mc');
                $marca->id_entrevista=$this->id_mis_casos;
                $marca->id_marca = $id_marca;
                $marca->id_entrevistador = $this->id_entrevistador;
                $marca->save();
            }

        }
        $this->actualizar_nivel_avance();
    }
    //Mejora: las entrevistas se asocian por marca generando un registro, de forma que la asociación es estática
    //Este proceso no es tán dinámico, pero es mucho más eficiente.
    public function agregar_entrevistas_por_marca($arreglo=[]) {

        //Listado por marcas
        $filtros = marca_entrevista::filtros_default();
        $a_marcas = $arreglo;
        if(count($a_marcas)==0) {
            $a_marcas[]=-1;  //Para que no hale todas las entrevistas (por no haber marcas), le meto una marca que no existe
        }
        $filtros->id_marca = $a_marcas;
        if(\Auth::user()) {
            $filtros->id_entrevistador=\Auth::user()->id_entrevistador;
        }


        $por_marca = marca_entrevista::filtrar($filtros)
            ->where('id_subserie','<>',config('expedientes.mc'))
            ->join('catalogos.cat_item','id_subserie','=','id_item') //Para el orden
            ->distinct()
            ->select(\DB::raw('cat_item.orden, id_subserie, id_entrevista '))->get();
        //dd($por_marca);

        $si=[];
        $no=[];
        foreach($por_marca as $marca_entrevista) {
            $input =  array();
            $input['id_mis_casos'] = $this->id_mis_casos;
            $input['id_entrevista']=$marca_entrevista->id_entrevista;
            $input['id_subserie']=$marca_entrevista->id_subserie;
            $input['id_entrevistador']=$this->id_entrevistador;
            $tmp = new acceso_edicion();
            $tmp->id_subserie = $marca_entrevista->id_subserie;
            $tmp->id_entrevista = $marca_entrevista->id_entrevista;
            $e = $tmp->entrevista;
            if(isset($e->entrevista_codigo)) {
                $input['codigo']=$e->entrevista_codigo;
                try {
                    mis_casos_entrevista::create($input);
                    $si[]=$e->entrevista_codigo;
                }
                catch (\Exception $e) {
                    //$no[] = $codigo.": ".$e->getMessage();
                    //$no[] = $e->entrevista_codigo.": duplicado";
                    $no[] = "Duplicada id_s:$marca_entrevista->id_subserie. id_e: $marca_entrevista->id_entrevista ";
                }
            }
            else {
                $no[] = "No existe id_s:$marca_entrevista->id_subserie. id_e: $marca_entrevista->id_entrevista ";
            }
        }
        $res = new \stdClass();
        $res->si=$si;
        $res->no=$no;
        //dd($res);
        return $res;
    }



    //Grabar detalle asociado
    public function registrar_detalle($request) {
        $this->rel_detalle()->delete();
        $a_detalle=array();
        if(is_array($request->id_violencia)) {
            $a_detalle = array_merge($a_detalle,$request->id_violencia);
        }
        if(is_array($request->id_fr)) {
            $a_detalle = array_merge($a_detalle,$request->id_fr);
        }
        if(is_array($request->id_tc)) {
            $a_detalle = array_merge($a_detalle,$request->id_tc);
        }
        if(is_array($request->id_sector)) {
            $a_detalle = array_merge($a_detalle,$request->id_sector);
        }
        if(is_array($request->id_patron)) {
            $a_detalle = array_merge($a_detalle,$request->id_patron);
        }


        $conteo=0;
        if(is_array($a_detalle)) {
            foreach($a_detalle as $id_detalle) {
                $nuevo = new mis_casos_detalle();
                $nuevo->id_mis_casos = $this->id_mis_casos;
                $nuevo->id_detalle = $id_detalle;
                $nuevo->save();
                $conteo++;
            }
        }
        return $conteo;
    }


    //Para la edicion del control
    public function arreglo_marcas(){
        return marca_entrevista::where('id_subserie',config('expedientes.mc'))
                        ->where('id_entrevista',$this->id_mis_casos)
                        ->pluck('id_marca')
                        ->toArray();
    }

    //Cambiar de dinámicas a estaticas
    public function cambiar_marcas() {
        $arreglo = $this->arreglo_marcas();
        $this->agregar_entrevistas_por_marca($arreglo);
        marca_entrevista::where('id_subserie',config('expedientes.mc'))
            ->where('id_entrevista',$this->id_mis_casos)
            ->delete();
    }
    //Para la edicion de los detalles
    public function arreglo_detalle($id_cat=5) {
        return $this->rel_detalle()->join('catalogos.cat_item', 'id_detalle','=', 'id_item')
                                    ->where('id_cat','=',$id_cat)
                                    ->pluck('id_detalle');
    }

    //Para la gestión de adjuntos
    public static function listado_adjuntos($id_entrevista) {
        $q = mis_casos_adjunto::where('id_mis_casos',$id_entrevista)
            ->join('esclarecimiento.adjunto','mis_casos_adjunto.id_adjunto','=','adjunto.id_adjunto') //Para no halar datos inconsistentes
            ->join('catalogos.cat_item','id_categoria','=','id_item')

            ->orderby('cat_item.descripcion')
            ->orderby('mis_casos_adjunto.descripcion');
        $listado = $q->get();

        $arreglo=array();
        $entrevista = mis_casos::find($id_entrevista);
        foreach($listado as $archivo) {
            $adjunto = adjunto::find($archivo->id_adjunto);
            $item= array();
            $item['id_mis_casos_adjunto']=$archivo->id_mis_casos_adjunto;
            $item['id_adjunto']=$adjunto->id_adjunto;
            $item['adjunto']=$adjunto;
            $item['nombre']=$adjunto->nombre_mc;
            $item['tipo']=$archivo->fmt_id_categoria;
            $item['id_tipo']=$archivo->id_seccion;
            $item['id_transcripcion']=$archivo->id_transcripcion;
            $item['transcrito']=$archivo->fmt_transcrito;
            $item['existe']=$adjunto->existe;
            $item['url_stream']=$archivo->url_stream;
            $item['url_stream_corto']=$archivo->url_stream_corto;

            $ubica="public/".$adjunto->ubicacion;
            if(Storage::exists($ubica)) {
                $url = action('adjuntoController@show_mc',$adjunto->id_adjunto);
                /*
                $visor = $adjunto->url_visor();
                if($visor) {
                    $url=$visor;
                }
                else {
                    $url = action('adjuntoController@show_hv',$adjunto->id_adjunto);
                }
                */

                $item['url']="<a target='_blank' href='".$url."'>$adjunto->nombre_mc</a>";

            }
            else {
                $item['url']="$adjunto->nombre_mc";
            }
            /*
            if($archivo->id_tipo ==2) { //Audio
                if(\Auth::user()->cannot('es-propio',$entrevista->id_entrevistador)) {
                    if(\Auth::user()->can('solo-lectura')) {
                        $item['url']="<i class='text-warning'>Acceso restringido por perfil del usuario</i>";
                        $item['url_stream']=""; //Para que no lo muestre la tabla
                    }
                }
            }
            */
            $item['tamano']=$adjunto->tamano;
            $item['fecha']=$adjunto->fecha;
            //$arreglo[]=$item;
            if($item['id_tipo']==16) { //otranscribe
                if(\Gate::allows('nivel-10-al-11')) {
                    $arreglo[]=$item;
                }
            }
            else {
                $arreglo[]=$item;
            }
        }

        return $arreglo;
    }



    //Para persistir el blog.
    public function getBlogAttribute() {
        return $this->listado_blog();
    }
    //PAra mostrar el blog
    public  function listado_blog() {
        $listado = blog::join('esclarecimiento.mis_casos_blog','blog.id_blog','=','mis_casos_blog.id_blog')
                        ->where('mis_casos_blog.id_mis_casos',$this->id_mis_casos)
                        ->where('id_activo',1)
                        ->orderby('fecha_hora','desc')
                        ->get();
        return $listado;

    }

    //Para mostrar secciones según el perfil
    public  function secciones_permitidas() {
        $arreglo = \App\Models\criterio_fijo::listado_items(50);
        $nivel = $this->privilegios;
        if($nivel==1) { //Propietario
            //No hacer nada
        }
        elseif($nivel==3) { //Administrador
            unset($arreglo[2]); //Solicitudes
            unset($arreglo[3]); //Diseño metodológico
        }
        elseif($nivel==5) { //Colaborador
            unset($arreglo[2]); //Solicitudes
            unset($arreglo[4]); //Análisis y seguimeinto
        }
        else { //Acceso general
            unset($arreglo[2]); //Solicitudes
            unset($arreglo[3]); //Diseño metodológico
            //unset($arreglo[4]); //Análisis y seguimeinto
        }
        return $arreglo;


    }


    //Para el show del caso
    public function listar_seccion($id_seccion=0) {
        $q = mis_casos_adjunto::where('id_mis_casos',$this->id_mis_casos)
            ->join('esclarecimiento.adjunto','mis_casos_adjunto.id_adjunto','=','adjunto.id_adjunto') //Para no halar datos inconsistentes
            ->join('catalogos.cat_item','id_categoria','=','id_item')
            ->where('id_seccion',$id_seccion)
            ->orderby('cat_item.descripcion')
            ->orderby('mis_casos_adjunto.descripcion');

        //Se muestran todos, pero se limita la descarga
//        if(in_array($this->privilegios,[1,3])) {
//            //Sin restricciones para el propietario
//        }
//        elseif(in_array($this->privilegios,[5])) { //Colaborador
//            $q->where('mis_casos_adjunto.clasificacion_nivel','>=',2);
//        }
//        else { //Resto de usuarios.  Acceso general
//            $q->where('mis_casos_adjunto.clasificacion_nivel','>=',4);
//        }

        $listado = $q->selectraw(\DB::raw('mis_casos_adjunto.*'))->get();
        return $listado;

    }

    //Listado de entrevistas asociadas por marca
    public function listar_entrevistas() {

        /*
        //Listado por marcas
        $filtros = marca_entrevista::filtros_default();
        $a_marcas = $this->arreglo_marcas();
        if(count($a_marcas)==0) {
            $a_marcas[]=-1;  //Para que no hale todas las entrevistas (por no haber marcas), le meto una marca que no existe
        }
        $filtros->id_marca = $a_marcas;
        $filtros->id_entrevistador=-1;


        $por_marca = marca_entrevista::filtrar($filtros)
            ->where('id_subserie','<>',config('expedientes.mc'))
            ->join('catalogos.cat_item','id_subserie','=','id_item')
            ->distinct()
            ->select(\DB::raw('id_subserie,id_entrevista, 0 as id_mis_casos_entrevista, cat_item.orden'));
        */
        $agregadas = mis_casos_entrevista::where('id_mis_casos',$this->id_mis_casos)
                        ->distinct()
                        ->join('catalogos.cat_item','id_subserie','=','id_item')
                        ->select(\DB::raw('id_subserie,id_entrevista,  id_mis_casos_entrevista, cat_item.orden'));

        //dd($por_marca->paginate()->first());

        /*
         $listado = $por_marca->union($agregadas)
                            ->orderby('orden')
                            ->orderby('id_entrevista')
                            ->get();
        */
        $listado = $agregadas->orderby('orden')
            ->orderby('id_entrevista')
            ->get();
        //Convierto a objeto tipo marca_entrevista, para tener la funcionalidad de ubicar entrevista, link al show,  etc.
        $arreglo = array();
        foreach($listado as $fila) {
            $x = new marca_entrevista();
            $x->id_subserie=$fila->id_subserie;
            $x->id_entrevista=$fila->id_entrevista;
            $x->id_mis_casos_entrevista=$fila->id_mis_casos_entrevista; //PAra que sepa que fue agregada estáticamente
            $arreglo[]=$x;
        }
        //dd($listado);
        return $arreglo;
    }

    //Para persistir el listado
    public function getListadoEntrevistasAttribute() {
        return $this->listar_entrevistas();
    }

    //Para mostrar los usuarios en orden alfabetico
    public function getListadoUsuariosAttribute() {
        $listado = mis_casos_entrevistador::join('esclarecimiento.entrevistador','mis_casos_entrevistador.id_entrevistador','=','entrevistador.id_entrevistador')
                                        ->join('users','entrevistador.id_usuario','=','users.id')
                                        ->where('id_mis_casos',$this->id_mis_casos)
                                        ->orderby('users.name')
                                        ->get();
        return $listado;
    }

    ////// SCOPES para las busquedas y filtrados
    public static function filtros_default($request = null) {
        $fecha = Carbon::now();
        //Valores por defecto
        $filtro =new \stdClass();
        $filtro->id_entrevistador = -1;
        $filtro->id_grupo = -1;
        $filtro->id_macroterritorio = -1;
        $filtro->id_territorio = -1;
        $filtro->entrevista_correlativo=null;
        $filtro->entrevista_codigo=null;
        $filtro->br="";
        $filtro->id_activo = 1;
        //Propias del instrumento
        $filtro->nombre = null;
        $filtro->descripcion = null;
        //
        $filtro->id_subserie = config('expedientes.mc'); //PAra el autofill
        //
        //Nuevos
        $filtro->del = "";
        $filtro->al="";
        $filtro->id_avance=-1;
        $filtro->id_sector=-1;
        $filtro->id_tipo_victima=-1;
        $filtro->id_violencia=-1;
        $filtro->id_fr=-1;
        $filtro->id_tc=-1;
        $filtro->id_patron=-1;


        // Actualizar valores del REQUEST
        $filtro->id_entrevistador = isset($request->id_entrevistador) ? $request->id_entrevistador : $filtro->id_entrevistador;
        $filtro->id_grupo = isset($request->id_grupo) ? $request->id_grupo : $filtro->id_grupo;
        //Determinar si es macro o territorio
        if(isset($request->id_territorio)) {
            if($request->id_territorio>0) {
                $filtro->id_territorio=$request->id_territorio;
                if(isset($request->id_territorio_macro)) {
                    $filtro->id_macroterritorio = $request->id_territorio_macro;
                }
            }
            else {
                if(isset($request->id_territorio_macro)) {
                    if($request->id_territorio_macro > 0) {
                        $filtro->id_macroterritorio=$request->id_territorio_macro;
                    }
                }

            }
        }
        else {  //Llamada directa desde una grafica
            if(isset($request->id_territorio_macro)) {
                $filtro->id_macroterritorio=$request->id_territorio_macro;
            }
        }
        $filtro->entrevista_correlativo = isset($request->entrevista_correlativo) ? $request->entrevista_correlativo : $filtro->entrevista_correlativo;
        $filtro->entrevista_codigo = isset($request->entrevista_codigo) ? $request->entrevista_codigo : $filtro->entrevista_codigo;
        $filtro->br = isset($request->br) ? $request->br : $filtro->br;
        $filtro->id_activo = isset($request->id_activo) ? $request->id_activo : $filtro->id_activo;

        $filtro->nombre = isset($request->nombre) ? $request->nombre : $filtro->nombre;
        $filtro->descripcion = isset($request->descripcion) ? $request->descripcion : $filtro->descripcion;

        $filtro->id_avance = isset($request->id_avance) ? $request->id_avance : $filtro->id_avance;
        $filtro->id_sector = isset($request->id_sector) ? $request->id_sector : $filtro->id_sector;
        $filtro->del = isset($request->del) ? $request->del : $filtro->del;
        $filtro->al = isset($request->al) ? $request->al : $filtro->al;
        $filtro->id_tipo_victima = isset($request->id_tipo_victima) ? $request->id_tipo_victima : $filtro->id_tipo_victima;
        $filtro->id_violencia = isset($request->id_violencia) ? $request->id_violencia : $filtro->id_violencia;
        $filtro->id_fr = isset($request->id_fr) ? $request->id_fr : $filtro->id_fr;
        $filtro->id_tc = isset($request->id_tc) ? $request->id_tc : $filtro->id_tc;
        $filtro->id_patron = isset($request->id_patron) ? $request->id_patron : $filtro->id_patron;



        //Filtro por grupo del entrevistador
        if(\Auth::check()) {
            $usuario =\Auth::user();
            //Aplicar filtros por grupo
            if(in_array($usuario->id_nivel,[2,3,4])) {  //Que no sea admin
                if($usuario->id_grupo <> 1) { //Que no sea grupo CEV
                    $filtro->id_grupo = $usuario->id_grupo;
                }
            }
        }

        //Para poder agregar el query string a a los links por GET
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
    //Criterios de filtrado
    public static function scopeOrdenar($query) {
        $query->orderby('mis_casos.entrevista_correlativo');
    }
    //Softdelete
    public static function scopeId_activo($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('mis_casos.id_activo',$criterio);
        }
    }
    // Entrevistador
    public static function scopeId_entrevistador($query,$criterio=-1) {
        if(is_array($criterio)) {
            $query->wherein('mis_casos.id_entrevistador',$criterio);
        }
        elseif($criterio>0) {
            $query->where('mis_casos.id_entrevistador',$criterio);
        }
    }
    //Filtro según el grupo al que pertenece
    public static function scopeId_grupo($query,$criterio=-1) {
        if($criterio>0) {
            $query->join('esclarecimiento.entrevistador as fe','mis_casos.id_entrevistador','=','fe.id_entrevistador')
                ->where('fe.id_grupo',$criterio);
        }
    }
    //Macroterritorio
    public static function scopeId_macroterritorio($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('mis_casos.id_macroterritorio',$criterio);
        }
    }
    //Territorio
    public static function scopeId_territorio($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('mis_casos.id_territorio',$criterio);
        }
    }
    //correlativo
    public static function scopeEntrevista_correlativo($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('mis_casos.entrevista_correlativo',$criterio);
        }
    }
    //codigo
    public static function scopeEntrevista_codigo($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('mis_casos.entrevista_codigo','ilike',"%$criterio%");
        }
    }
    //Nombre
    public static function scopeNombre($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('mis_casos.nombre','ilike',"%$criterio%");
        }
    }
    //Descripcion
    public static function scopeDescripcion($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('mis_casos.descripcion','ilike',"%$criterio%");
        }
    }
    //Busqueda rapida
    public static function scopeBR($query,$criterio="") {
        $criterio=trim($criterio);
        if(is_numeric($criterio) and intval($criterio)>0) {
            $query->where('entrevista_correlativo',$criterio);
        }
        elseif(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $where[]="mis_casos.nombre ilike '%$criterio%'";
            $where[]="mis_casos.descripcion ilike '%$criterio%'";
            $where[]="mis_casos.entrevista_codigo ilike '$criterio%'";
            $str_where=implode(" or ",$where);
            $query->whereraw(" ( $str_where )");
        }
    }
    //Busqueda de full text search todo: pendiente de implementar
    public static function scopeFTS($query,$criterio="")  {
        $buscar = entrevista_individual::procesar_texto_fts($criterio);  //Agrega conectores logicos, quita caracteres especiales, etc.
        if(strlen($buscar)>0) {
            $query->addSelect(\DB::raw("ts_rank('fts', to_tsquery('pg_catalog.spanish',unaccent('$buscar'))) as rank"));
            $query->whereraw(\DB::raw("fts @@ to_tsquery('pg_catalog.spanish',unaccent('$buscar'))"));
        }
    }
    public static function scopeId_avance($query, $criterio) {
        if($criterio > 0) {
            $query->where('id_avance',$criterio);
        }
    }
    public static function scopeId_sector($query,$criterio) {
        //Convertirlo en arreglo si es entero mayor que cero
        if(!is_array($criterio)) {
            $criterio=intval($criterio);
            if($criterio>0) {
                $criterio = array($criterio);
            }
        }
        if(is_array($criterio)) {
            $cuales = mis_casos_detalle::wherein('id_detalle',$criterio)->pluck('id_mis_casos');
            $query->wherein('mis_casos.id_mis_casos',$cuales);
        }
    }
    public static function scopeId_tipo_victima($query,$criterio) {
        //Convertirlo en arreglo si es entero mayor que cero
        if(!is_array($criterio)) {
            $criterio=intval($criterio);
            if($criterio>0) {
                $criterio = array($criterio);
            }
        }
        if($criterio > 0) {
            $query->where('id_tipo_victima',$criterio);
        }
    }
    public static function scopeDel($query,$criterio) {
        $criterio = intval($criterio);
        if($criterio > 0) {
            $query->where('anyo_inicio','>=',$criterio);
        }
    }
    public static function scopeAl($query,$criterio) {
        $criterio = intval($criterio);
        if($criterio > 0) {
            $query->where('anyo_fin','<=',$criterio);
        }
    }
    public static function scopeId_violencia($query,$criterio) {
        //Convertirlo en arreglo si es entero mayor que cero
        if(!is_array($criterio)) {
            $criterio=intval($criterio);
            if($criterio>0) {
                $criterio = array($criterio);
            }
        }
        if(is_array($criterio)) {
            $cuales = mis_casos_detalle::wherein('id_detalle',$criterio)->pluck('id_mis_casos');
            $query->wherein('mis_casos.id_mis_casos',$cuales);
        }
    }
    public static function scopeId_Fr($query,$criterio) {
        //Convertirlo en arreglo si es entero mayor que cero
        if(!is_array($criterio)) {
            $criterio=intval($criterio);
            if($criterio>0) {
                $criterio = array($criterio);
            }
        }
        if(is_array($criterio)) {
            $cuales = mis_casos_detalle::wherein('id_detalle',$criterio)->pluck('id_mis_casos');
            $query->wherein('mis_casos.id_mis_casos',$cuales);
        }
    }
    public static function scopeId_tc($query,$criterio) {
        //Convertirlo en arreglo si es entero mayor que cero
        if(!is_array($criterio)) {
            $criterio=intval($criterio);
            if($criterio>0) {
                $criterio = array($criterio);
            }
        }
        if(is_array($criterio)) {
            $cuales = mis_casos_detalle::wherein('id_detalle',$criterio)->pluck('id_mis_casos');
            $query->wherein('mis_casos.id_mis_casos',$cuales);

        }
    }
    public static function scopeId_Patron($query,$criterio) {
        //Convertirlo en arreglo si es entero mayor que cero
        if(!is_array($criterio)) {
            $criterio=intval($criterio);
            if($criterio>0) {
                $criterio = array($criterio);
            }
        }
        if(is_array($criterio)) {
            $cuales = mis_casos_detalle::wherein('id_detalle',$criterio)->pluck('id_mis_casos');
            $query->wherein('mis_casos.id_mis_casos',$cuales);

        }
    }

    //Aplicar todos los criterios de filtrado
    //Aplicar todos los filtros
    public static function scopeFiltrar($query, $criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }

        $query->id_macroterritorio($criterios->id_macroterritorio)
            ->id_territorio($criterios->id_territorio)
            ->id_entrevistador($criterios->id_entrevistador)
            ->id_grupo($criterios->id_grupo)
            ->entrevista_correlativo($criterios->entrevista_correlativo)
            ->entrevista_codigo($criterios->entrevista_codigo)
            ->nombre($criterios->nombre)
            ->descripcion($criterios->descripcion)
            ->id_avance($criterios->id_avance)
            ->id_sector($criterios->id_sector)
            ->del($criterios->del)
            ->al($criterios->al)
            ->id_tipo_victima($criterios->id_tipo_victima)
            ->id_violencia($criterios->id_violencia)
            ->id_fr($criterios->id_fr)
            ->id_tc($criterios->id_tc)
            ->id_patron($criterios->id_patron)
            ->br($criterios->br)
            //Logica interna
            ->id_activo($criterios->id_activo)
            //Seguridad
            ->permisos();

    }


    //De acuerdo al perfil, aplica los permisos.  Nueva versión de acuerdo al perfil
    /* LOGICA:
     * 1. Determina el acceso según el nivel (entrevistador, coord. territorio, coord. macro, etc.)
     * 2. Quita confidenciales  (ajenos)
     * 3. aplica filtro por grupo  (solo ruta pacifica, oim, etc.)
     */
    public static function scopePermisos($query) {
        /*
        if(Gate::allows('revisar-nivel',1) ) { //Administrador
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',2) ) { //Esclarecimiento
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',3) ) { //Coordinador Macro
            $asignadas = mis_casos::arreglo_asignaciones();
            $id_macroterritorio=\Auth::user()->id_macroterritorio;
            if(count($asignadas) > 0) {
                $asignadas_where=implode(",",$asignadas);
                $query->whereraw(DB::raw("( mis_casos.id_macroterritorio = $id_macroterritorio  OR mis_casos.id_mis_casos in ($asignadas_where) )"));
            }
            else {
                $query->where('mis_casos.id_macroterritorio',$id_macroterritorio);
            }
        }
        elseif(Gate::allows('revisar-nivel',4) ) { //Coordinador territorio
            $asignadas = mis_casos::arreglo_asignaciones();
            $id_territorio=\Auth::user()->id_territorio;
            if(count($asignadas) > 0) {
                $asignadas_where=implode(",",$asignadas);
                $query->whereraw(DB::raw("( mis_casos.id_territorio = $id_territorio  OR mis_casos.id_mis_casos in ($asignadas_where) )"));
            }
            else {
                $query->where('mis_casos.id_territorio',$id_territorio);
            }

        }
        elseif(Gate::allows('revisar-nivel',5) ) { //Entrevistador
            $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas(); //Asignación de otros entrevistadores
            $asignadas = mis_casos::arreglo_asignaciones();
            if(count($asignadas) > 0) {
                $asignadas_where=implode(",",$asignadas); //Arreglo de entrevistas asignadas
                $entrevistadores_where = implode(",", $arreglo_entrevistadores);  //Arreglo de entrevistadores asignados
                $query->whereraw(DB::raw("( mis_casos.id_entrevistador in ($entrevistadores_where)  OR mis_casos.id_mis_casos in ($asignadas_where) )"));
            }
            else {
                $query->wherein('mis_casos.id_entrevistador',$arreglo_entrevistadores);
            }

        }
        elseif(Gate::allows('revisar-nivel',6) ) { //Confidencial
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',7) ) { //Estadistico
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',10) ) { //Coordinador transcriptores
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',11) ) { //Transcriptores
            $asignadas = mis_casos::arreglo_asignaciones();
            $query->wherein('mis_casos.id_mis_casos',$asignadas);

        }
        else {  //Otros, incluye deshabilitados.  Por defecto ninguno
            $query->where('mis_casos.id_entrevistador',-1); //Ninguno
        }

        //$debug['sql']= nl2br($query->toSql());
        //$debug['criterios']=$query->getBindings();
        //dd($debug);

        //Si es de un grupo ajeno, agregar el filtro del grupo  (ruta pacifica, oim, etc)
        if(Gate::allows('grupo-ajeno')) {
            $query->join('esclarecimiento.entrevistador as fsg','mis_casos.id_entrevistador','=','fsg.id_entrevistador')
                ->where('fsg.id_grupo',\Auth::user()->id_grupo);
        }
        */
    }

    //Listado de marcas asociadas
    public function listar_marcas_asociadas() {
        $query = marca_entrevista:: id_subserie(config('expedientes.mc'))
            ->id_entrevista($this->id_mis_casos)
            ->join('esclarecimiento.marca as m','marca_entrevista.id_marca','=','m.id_marca')
            ->join('esclarecimiento.entrevistador','marca_entrevista.id_entrevistador','=','entrevistador.id_entrevistador')
            ->join('users','entrevistador.id_usuario','=','users.id')
            ->orderBy('texto');
        $listado = $query->get();

        $url= action('statController@buscadora');
        $link=array();
        foreach($listado as $fila) {
            $link[]="<a href='$url?marca[]=$fila->id_marca'>$fila->texto</a>";
        }
        return $link;
    }




    //Funcion para el controller, me permite determinar si se puede acceder o no a la entrevista en sí (usado en show y edit)
    public function getPuedeAccederEntrevistaAttribute() {
        //return entrevista_individual::revisar_acceso_a_entrevista($this);
        return true;
    }

    //Basado en puede_acceder, encapsula todas las revisiones por hacer respecto a R2, R3, R4
    public function puede_acceder_adjuntos() {
        return true;
        //return entrevista_individual::revisar_acceso_adjuntos($this);
    }

    ////PAra el controller, me permite determinar si puede modificar la entrevista.  Lo uso en la vista para ocultar botones de edición
    public function puede_modificar_entrevista() {
        $puede=false;  //Predeterminado
        if(in_array($this->privilegios,[1])) {
            $puede=true;
        }
        if(Gate::check('sistema-cerrado')) {
            $puede=false;
        }
        //Sin otras validaciones
        return $puede;
    }
    //Para persistir el permiso
    public function getPuedeModificarAttribute() {
        return $this->puede_modificar_entrevista();
    }

    //Devuelve true/false para determinar si el usuario activo puede agregar/quitar adjuntos
    public function puede_modificar_adjuntos($id_seccion=0) {
        $puede=false;
        if(in_array($this->privilegios,[1])) {
            $puede=true;
        }
        elseif(in_array($this->privilegios,[5])) {
            if(in_array($id_seccion,[0])) {  //En ninguna
                $puede=true;
            }
        }

        if(Gate::check('sistema-cerrado')) {
            $puede=false;
        }

        //De momento no hay validaciones a nivel de sección, pero la función está lista por si cambian de parecer
        return $puede;
    }


    //Ver si fue asignada para transcribir
    public function revisar_asignacion() {
        if(\Auth::check()) {
            $usuario=\Auth::user();
        }
        else {
            return false;
        }
        $asignaciones = $this->arreglo_asignaciones();
        return in_array($this->id_mis_casos,$asignaciones);
    }

    //Para el scope de permisos.
    public static function arreglo_asignaciones($id_subserie=0,$llave_primaria="") {

        if(\Auth::check()) {
            $usuario=\Auth::user();
        }
        else {
            return false;
        }
        $id_subserie = $id_subserie > 0 ? $id_subserie : config("expedientes.mc");
        $llave_primaria = strlen($llave_primaria) > 0 ? $llave_primaria : 'id_mis_casos';


        $asignadas_m = acceso_edicion::where('id_autorizado',$usuario->id_entrevistador)
            ->where('id_situacion',1)
            ->where('id_subserie',$id_subserie)
            ->pluck('id_entrevista')->toArray();

        $asignaciones = array_merge( $asignadas_m);
        //Eliminar los valores no validos como null
        $limpio=array();
        foreach($asignaciones as $val) {
            if($val > 0) {
                $limpio[]=$val;
            }
        }
        return $limpio;
    }

    ////// FIN DE LOS CONTROLES DE SEGURIDAD
    ///
    // Actualizar el nivel de avance
    public function actualizar_nivel_avance() {
        $nivel=1;  //Default
        if(count($this->listado_entrevistas) > 0) {
            $nivel=2;
            $q = mis_casos_adjunto::where('id_mis_casos',$this->id_mis_casos)
                ->join('esclarecimiento.adjunto','mis_casos_adjunto.id_adjunto','=','adjunto.id_adjunto') //Para no halar datos inconsistentes
                ->join('catalogos.cat_item','id_categoria','=','id_item')
                ->where('id_seccion',3)
                ->orderby('cat_item.descripcion')
                ->orderby('mis_casos_adjunto.descripcion')
                ->count();

           if($q > 0) {
               $nivel=3;
           }
            $q = mis_casos_adjunto::where('id_mis_casos',$this->id_mis_casos)
                ->join('esclarecimiento.adjunto','mis_casos_adjunto.id_adjunto','=','adjunto.id_adjunto') //Para no halar datos inconsistentes
                ->join('catalogos.cat_item','id_categoria','=','id_item')
                ->where('id_seccion',4)
                ->orderby('cat_item.descripcion')
                ->orderby('mis_casos_adjunto.descripcion')
                ->count();
            if($q > 0) {
                $nivel=4;
            }


        }
        $this->id_avance = $nivel;
        $this->save();
    }

    //Para actualizar id_avance en todos los casos.  Para la primera vez
    public static function actualizar_avance_en_todos() {
        $listado=mis_casos::orderby('id_mis_casos')->get();
        $a_avance[1]=0;
        $a_avance[2]=0;
        $a_avance[3]=0;
        $a_avance[4]=0;
        foreach($listado as $caso) {
            $caso->actualizar_nivel_avance();
            $a_avance[$caso->id_avance]++;

        }
        return $a_avance;
    }


    //Para listar los accesos otorgados a archivos especificos
    public function listado_adjuntos_compartidos($conmigo=false) {
        $query = mis_casos_adjunto_compartir::join('esclarecimiento.mis_casos_adjunto','mis_casos_adjunto.id_mis_casos_adjunto','mis_casos_adjunto_compartir.id_mis_casos_adjunto')
                                ->where('mis_casos_adjunto.id_mis_casos',$this->id_mis_casos)
                                ->orderby('mis_casos_adjunto_compartir.id_autorizado')
                                ->orderby('mis_casos_adjunto.descripcion')
                                ->selectraw(\DB::raw('mis_casos_adjunto_compartir.*'));
        if($conmigo) {
            $query->where('id_autorizado',\Auth::user()->id_entrevistador);
            $query->where('id_situacion',1);
        }
        $listado=$query->get();
        //$listado = mis_casos_adjunto_compartir::wherein('id_mis_casos_adjunto_compartir',$cuales)->get();
        return $listado;
    }

    public static function cambiar_entrevistas_a_estaticas() {
        $listado = self::get();
        $total=0;
        foreach($listado as $mi_caso) {
            $mi_caso->cambiar_marcas();
            $total++;
        }
        return $total;
    }


}
