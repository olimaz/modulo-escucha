<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\CodeCoverage\Report\PHP;

/**
 * Class cat_item
 * @package App\Models
 * @version April 15, 2019, 4:40 pm UTC
 *
 * @property \App\Models\Catalogos.catCat idCat

 * @property integer id_cat
 * @property integer id_item
 * @property string descripcion
 * @property string abreviado
 * @property string texto
 * @property integer orden
 * @property integer predeterminado
 * @property string otro
 * @property integer habilitado
 * @property integer pendiente_revisar
 * @property integer id_entrevistador
 */
class cat_item extends Model
{

    public $table = 'catalogos.cat_item';
    protected $primaryKey = 'id_item';

    public $timestamps = false;



    public $fillable = [
        'id_cat',
        'descripcion',
        'abreviado',
        'texto',
        'orden',
        'predeterminado',
        'otro',
        'habilitado',
        'id_entrevistador',
        'pendiente_revisar',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_item' => 'integer',
        'id_cat' => 'integer',
        'habilitado' => 'integer',
        'descripcion' => 'string',
        'abreviado' => 'string',
        'texto' => 'string',
        'orden' => 'integer',
        'predeterminado' => 'integer',
        'id_entrevistador' => 'integer',
        'pendiente_revisar' => 'integer',
        'otro' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //'id_item' => 'required',
        //'id_cat' => 'required',
        'descripcion' => 'required',
        'orden' => 'required',
        'predeterminado' => 'required'
    ];

    public function rel_id_cat() {
        return $this->belongsTo(cat_cat::class,'id_cat','id_cat');
    }
    public function rel_id_reclasificado() {
        return $this->belongsTo(cat_item::class, 'id_reclasificado','id_item');
    }

    //Proceso de reclasificacion
    public function getFmtIdRelacionadoAttribute() {
        if($this->id_reclasificado == -1) {
            return "Opción inválida, no será tomada en cuenta en la reclasificación";
        }

        $reclasificado = $this->rel_id_reclasificado;

        if($reclasificado) {
            return $reclasificado->descripcion;
        }
        else {
            //return "Sin reclasificación:  se mantiene el valor original";
            return "<span class='text-danger'>Pendiente de reclasificar</span>";
        }
    }


    public static function listado_items($id_catalogo=1, $vacio="", $nulo="") {
        if(is_numeric($id_catalogo)) {
            $listado=self::where('id_cat',$id_catalogo)
                ->habilitado()
                ->ordenar()
                ->pluck('descripcion','id_item')
                ->toArray();
        }
        if(is_array($id_catalogo)) {
            $listado=self::wherein('id_cat',$id_catalogo)
                ->habilitado()
                ->ordenar()
                ->pluck('descripcion','id_item')
                ->toArray();
        }



        if(strlen($nulo)>0) {
            $listado = [null=>$nulo] + $listado;
            //$listado->prepend($nulo,null);
        }
        if(strlen($vacio)>0) {
            $listado = [-1=>$vacio] + $listado;
            //$listado->prepend($vacio,-1);
        }
        return $listado;
    }

    //Igual que listado_items() pero muestra entre paréntesis las opciones agregadas por el usuario
    public static function listado_items_nuevo($id_catalogo=1, $vacio="", $nulo="") {
        $listado=[];
        if(is_numeric($id_catalogo)) {
            $listado=self::where('id_cat',$id_catalogo)
                ->habilitado()
                ->ordenarotros()->get();

        }
        if(is_array($id_catalogo)) {
            $listado=self::wherein('id_cat',$id_catalogo)
                ->habilitado()
                ->ordenarotros()
                ->get();
        }

        //dd($listado->toArray());



        $opciones=array();
        $grupos=array();

        if(strlen($vacio)>0) {
            $opciones[2][-1]=$vacio;
            $grupos[2]=2;
        }
        if(strlen($nulo)>0) {
            $opciones[2][null]=$nulo;
            $grupos[2]=2;
        }

        //Detectar si hay pendientes de revisar

        $respuesta=array();
        foreach($listado as $registro) {
            $txt=$registro->descripcion;
            if($registro->pendiente_revisar==1) {
                $txt .= " (pendiente de revisar)";
            }
            $grupo = $registro->pendiente_revisar==1 ? 1 : 2;
            $opciones[$grupo][$registro->id_item]=$txt;
            $grupos[$grupo]=$grupo;
        }
        if(count($grupos)==1) {
            foreach($grupos as $id) {
                //dd($grupos);
                $respuesta = $opciones[$id];

            }
        }
        else {
            $listado=array();
            foreach ($grupos as $id_grupo) {
                $grupo = $id_grupo==1 ?  "Otras opciones" :  "Seleccione una opción" ;
                foreach($opciones[$id_grupo] as $id => $txt) {
                    $listado[$grupo][$id]=$txt;
                }
                $respuesta= $listado;
            }
        }

        //->pluck('descripcion','id_item');

        //dd($respuesta);
        return $respuesta;



        //return $opciones;
    }

    //Encapasula la funcionalidad de habilitar/deshabilitar
    public function scopeHabilitado($query,$criterio=1){  //El default es para compatibilidad con versiones antiguas
        if($criterio>0) {
            $query->where('habilitado', $criterio);
        }
    }

    //Mostrar solo los pendientes de reclasificar, 1 equivale a filtrarlos
    public function scopeReclasificacion($query,$criterio=0) {
        if($criterio==1) {
            $query->whereNull('id_reclasificado');
        }
    }

    public function scopePendiente_Revisar($query,$criterio=0){
        if($criterio>0) {
            $query->where('pendiente_revisar',$criterio);
        }
    }

    //Para que siempre orden por orden y descripcion
    public function scopeOrdenar($query) {
        $query->orderby('id_cat')    //Para cuando mezclo mas de un catalogo
                ->orderby('orden')
                ->orderby('descripcion');
    }
    //Ordena colocando los "otros, cual" de último
    public function scopeOrdenarOtros($query) {
        $query->orderby('id_cat')    //Para cuando mezclo mas de un catalogo
                ->orderby('pendiente_revisar','desc')
                ->orderby('orden')
            ->orderby('descripcion');
    }
    //Para un catalogo especifico
    public function scopeId_Cat($query,$id_cat=0) {
        if($id_cat >0) {
            $query->where('id_cat',$id_cat);
        }
    }


    //Helper function
    public static function describir($id_item=null) {
        if($id_item <= 0) return "Sin Especificar";
        $existe = self::find($id_item);
        if(empty($existe)) {
            return "Desconocido ($id_item)";
        }
        else {
            return $existe->descripcion;
        }
    }

    public static function describir_reclasificado($cual) {
        if($cual <= 0) return "Sin Especificar";
        $existe = self::find($cual);
        if(!$existe) {
            return "Desconocido ($cual)";
        }
        if($existe->id_reclasificado == -1) {
            return false;
        }
        elseif($existe->id_reclasificado > 0) {
            return $existe->fmt_id_relacionado;
        }
        else {
            return $existe->descripcion;
        }

    }


    //Para saber el código de la entrevista
    public static function codigo_vi($id_entrevistador=0) {
        //Defaults, si no está autenticado (para pruebas)
        $txt="XX";
        $entrev="eee";

        $cual = self::find(config('expedientes.vi'));
        if($cual) {
            $txt= $cual->abreviado;
        }
        if($id_entrevistador==0) {
            if(\Auth::check()) {
                if(\Auth::user()->tiene_perfil()) {
                    $entrev =\Auth::user()->rel_entrevistador->fmt_numero_entrevistador;
                }
            }
        }
        else {
            $entrev = entrevistador::find($id_entrevistador)->fmt_numero_entrevistador;
        }


        $codigo = $entrev."-".$txt."-";
        return $codigo;
    }

    //Obtener el nombre del catalogo
    public function getFmtIdCatAttribute() {
        $catalogo=\DB::select("select * from cat_cat where id_cat=$this->id_cat");
        $datos=$catalogo[0];
        return $datos->nombre;
    }


    public function getFmtIdCatRevisarAttribute() {
        $catalogo=cat_cat::where('id_cat',$this->id_cat)->first();
        // $datos=$catalogo[0];
        return $catalogo->nombre;
    }

    public function getFmtPredeterminadoAttribute() {
        return $this->predeterminado == 1 ? "Sí" : "No";
    }

    public function getFmtHabilitadoAttribute() {
        return $this->habilitado==1 ? "Habilitado" : "<span class='text-red'>Deshabilitado</span>";
    }

    //Filtrado
    public static function filtros_default($request = null)
    {
        //Valores por defecto
        $filtro = new \stdClass();
        $filtro->id_cat = null;
        $filtro->habilitado = -1;
        $filtro->pendiente_revisar = -1;
        //
        $filtro->id_cat = isset($request->id_cat) ? $request->id_cat : $filtro->id_cat;
        $filtro->habilitado = isset($request->habilitado) ? $request->habilitado : $filtro->habilitado;
        $filtro->pendiente_revisar = isset($request->pendiente_revisar) ? $request->pendiente_revisar : $filtro->pendiente_revisar;
        //
        return $filtro;
    }
    public static function scopeFiltrar($query, $criterios)
    {
        if (!is_object($criterios)) {
            $criterios = self::filtros_default();
        }

        $query = $query->id_cat($criterios->id_cat)
            ->habilitado($criterios->habilitado)
            ->pendiente_revisar($criterios->pendiente_revisar);
    }
    //Usado en la nube de palabras
    public static function terminos_bloqueados() {
        $a = self::where('id_cat',333)->orderby('descripcion')->pluck('descripcion')->toArray();
        $todas = implode(",",$a);
        return "$todas";
    }

    //Para la grafica de relaciones entre violencia y afrontamientos/efectos
    public static function json_jerarquia_contexto() {
        $catalogos = [127,128,129,130,131];
        $estructura = array();
        $nodo = new \stdClass();
        $nodo->id= 200000;
        $nodo->name = "Contexto";
        $nodo->parent = 1;
        $estructura[]=$nodo;
        $lis_cat=cat_cat::wherein('id_cat',$catalogos)->get();
        foreach($lis_cat as $fila) {
            $nodo = new \stdClass();
            $nodo->id= $fila->id_cat;
            $nodo->name = $fila->nombre;
            $nodo->parent =  200000;
            $estructura[]=$nodo;
        }
        //El top 5 de c/u
        $top =5;
        $validos=array();

        foreach($lis_cat as $fila_cat) {
            $top = hecho_contexto::join('catalogos.cat_item','id_contexto','id_item')
                        ->selectraw(\DB::raw('id_item, count(1) as conteo'))
                        ->where('id_cat',$fila_cat->id_cat)
                        ->groupby('id_item')
                        ->orderby('conteo','desc')
                        ->take($top)
                        ->pluck('id_item')
                        ->toArray();
            $validos = array_merge($validos,$top);
            $datos = cat_item::wherein('id_item',$top)->get();
            foreach($datos as $fila) {
                $nodo = new \stdClass();
                $nodo->id= $fila->id_item;
                $nodo->name = $fila_cat->nombre.": ".$fila->descripcion;
                $nodo->parent =  $fila->id_cat;
                $estructura[]=$nodo;
            }
        }
        $res = new \stdClass();
        $res->estructura = $estructura;
        $res->validos = $validos;

        return $res;
    }

    //Para la grafica de relaciones entre violencia y afrontamientos/efectos
    public static function json_jerarquia_impactos() {

        $estructura = array();
        $nodo = new \stdClass();
        $nodo->id= 300000;
        $nodo->name = "Impactos";
        $nodo->parent = 1;
        $estructura[]=$nodo;

        //El top 5 de c/u
        $top =5;

        //Individuales
        $nodo = new \stdClass();
        $nodo->id= 300001;
        $nodo->name = "Individuales";
        $nodo->parent = 300000;
        $estructura[]=$nodo;
        $catalogos = [132,133,134];
        $lis_cat=cat_cat::wherein('id_cat',$catalogos)->orderby('id_cat')->get();
        foreach($lis_cat as $fila) {
            $nodo = new \stdClass();
            $nodo->id= $fila->id_cat;
            $nodo->name = $fila->nombre;
            $nodo->parent =  300001;
            $estructura[]=$nodo;
        }
        $validos=array();
        foreach($lis_cat as $fila_cat) {
            $top = entrevista_individual::where('id_activo',1)
                ->join('fichas.entrevista_impacto','e_ind_fvt.id_e_ind_fvt','=','entrevista_impacto.id_e_ind_fvt')
                ->join('catalogos.cat_item','id_impacto','id_item')
                ->selectraw(\DB::raw('id_item, count(1) as conteo'))
                ->where('id_cat',$fila_cat->id_cat)
                ->groupby('id_item')
                ->orderby('conteo','desc')
                ->take($top)
                ->pluck('id_item')
                ->toArray();
            $validos = array_merge($validos,$top);
            $datos = cat_item::wherein('id_item',$top)->get();
            foreach($datos as $fila) {
                $nodo = new \stdClass();
                $nodo->id= $fila->id_item;
                $nodo->name = $fila_cat->nombre.": ".$fila->descripcion;
                $nodo->parent =  $fila->id_cat;
                $estructura[]=$nodo;
            }
        }


        //RElacionaes
        $nodo = new \stdClass();
        $nodo->id= 300002;
        $nodo->name = "Relacionaes";
        $nodo->parent = 300000;
        $estructura[]=$nodo;
        $catalogos = [135,136,137];
        $lis_cat=cat_cat::wherein('id_cat',$catalogos)->orderby('id_cat')->get();
        foreach($lis_cat as $fila) {
            $nodo = new \stdClass();
            $nodo->id= $fila->id_cat;
            $nodo->name = $fila->nombre;
            $nodo->parent =  300002;
            $estructura[]=$nodo;
        }
        //El top 5 de c/u
        foreach($lis_cat as $fila_cat) {
            $top = entrevista_individual::where('id_activo',1)
                ->join('fichas.entrevista_impacto','e_ind_fvt.id_e_ind_fvt','=','entrevista_impacto.id_e_ind_fvt')
                ->join('catalogos.cat_item','id_impacto','id_item')
                ->selectraw(\DB::raw('id_item, count(1) as conteo'))
                ->where('id_cat',$fila_cat->id_cat)
                ->groupby('id_item')
                ->orderby('conteo','desc')
                ->take($top)
                ->pluck('id_item')
                ->toArray();
            $validos = array_merge($validos,$top);
            $datos = cat_item::wherein('id_item',$top)->get();
            foreach($datos as $fila) {
                $nodo = new \stdClass();
                $nodo->id= $fila->id_item;
                $nodo->name = $fila_cat->nombre.": ".$fila->descripcion;
                $nodo->parent =  $fila->id_cat;
                $estructura[]=$nodo;
            }
        }

        //Colectivos
        $nodo = new \stdClass();
        $nodo->id= 300003;
        $nodo->name = "Colectivos";
        $nodo->parent = 300000;
        $estructura[]=$nodo;
        $catalogos = [138,139,140,141,142,143];
        $lis_cat=cat_cat::wherein('id_cat',$catalogos)->orderby('id_cat')->get();
        foreach($lis_cat as $fila) {
            $nodo = new \stdClass();
            $nodo->id= $fila->id_cat;
            $nodo->name = $fila->nombre;
            $nodo->parent =  300003;
            $estructura[]=$nodo;
        }
        //El top 5 de c/u
        foreach($lis_cat as $fila_cat) {
            $top = entrevista_individual::where('id_activo',1)
                ->join('fichas.entrevista_impacto','e_ind_fvt.id_e_ind_fvt','=','entrevista_impacto.id_e_ind_fvt')
                ->join('catalogos.cat_item','id_impacto','id_item')
                ->selectraw(\DB::raw('id_item, count(1) as conteo'))
                ->where('id_cat',$fila_cat->id_cat)
                ->groupby('id_item')
                ->orderby('conteo','desc')
                ->take($top)
                ->pluck('id_item')
                ->toArray();
            $validos = array_merge($validos,$top);
            $datos = cat_item::wherein('id_item',$top)->get();
            foreach($datos as $fila) {
                $nodo = new \stdClass();
                $nodo->id= $fila->id_item;
                $nodo->name = $fila_cat->nombre.": ".$fila->descripcion;
                $nodo->parent =  $fila->id_cat;
                $estructura[]=$nodo;
            }
        }

        //dd($validos);
        $res = new \stdClass();
        $res->estructura = $estructura;
        $res->validos = $validos;
        return $res;

    }

    /**
     * Edición de catalgos.  OJO: Devuelve si hubo un error
     * @returns string error
     */
    public function editar($request) {
        $error=false;
        //Arreglo con ID de cat_cat que sé donde impactan y que puedo reasignar en el detalle
        $arreglo_catalogos_controlados=[127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,171,500];

        //Evitar duplicación de llave primaria en cat_item
        $duplicado = self::where('descripcion','ilike',$request->descripcion)
                        ->where('id_cat',$this->id_cat)
                        ->where('id_item','<>',$this->id_item)
                        ->where('habilitado',1)
                        ->first();
        if($duplicado) { //
            //dd($duplicado);
            if(in_array($this->id_cat,$arreglo_catalogos_controlados)) {


                //Arreglar el detalle con el equivalente encontrado
                if(in_array($this->id_cat, [132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,171] )) {
                    //Deshabilitar el actual, que ya no será utilizado
                    $this->habilitado=2;
                    $this->save();
                    //Evitar duplicar el indice único
                    $ya_tienen = entrevista_impacto::where('id_impacto',$duplicado->id_item)->pluck('id_e_ind_fvt');
                    $por_cambiar = entrevista_impacto::where('id_impacto', $this->id_item)
                                                        ->wherenotin('id_e_ind_fvt',$ya_tienen)  //Aqui evito duplicar el indice unico, pero quedan los valores del id_item que deseo modificar
                                                        ->get();
                    //Crear nuevos pares, con el id_item del duplicado (antiguo: que ya existina)
                    foreach($por_cambiar as $tmp) {
                        entrevista_impacto::create(['id_e_ind_fvt'=>$tmp->id_e_ind_fvt, 'id_impacto'=>$duplicado->id_item]);
                    }

                    //Borrar pares con el item modificado (nuevo: que será reemplazado por el antiguo)
                    $borrados = entrevista_impacto::where('id_impacto', $this->id_item)->delete();
                    $error=false;
                }
                elseif(in_array($this->id_cat,[127,128,129,130,131])) {
                    //Deshabilitar el actual, que ya no será utilizado
                    $this->habilitado=2;
                    $this->save();
                    //Evitar duplicar el indice único
                    $ya_tienen = hecho_contexto::where('id_contexto',$duplicado->id_item)->pluck('id_hecho');
                    $por_cambiar = hecho_contexto::where('id_contexto',$this->id_item)
                                                    ->whereNotIn('id_hecho',$ya_tienen)
                                                    ->get();
                    //Crear nuevos pares, con el id_item del duplicado
                    foreach($por_cambiar as $tmp) {
                        hecho_contexto::create(['id_hecho'=>$tmp->id_hecho, 'id_contexto'=>$duplicado->id_item]);
                    }
                    //Borrar pares con el item modificado
                    $borrados = hecho_contexto::where('id_contexto', $this->id_item)
                                                    ->delete();

                    $error=false;
                }
                elseif($this->id_cat == 500) {
                    //Deshabilitar el actual, que ya no será utilizado
                    $this->habilitado=2;
                    $this->save();
                    $cambiados = persona::where('id_ocupacion_actual',$this->id_item)->update(['id_ocupacion_actual'=>$duplicado->id_item]);
                    $cambiados2 = hecho_victima::where('id_ocupacion',$this->id_item)->update(['id_ocupacion'=>$duplicado->id_item]);
                    $error=false;
                }
                else {
                    $error = "Error: valor duplicado.  Ya existe un elemento ($duplicado->id_item) con dicha descripción ($request->descripcion) y no se encontró el id_cat en el listado de catalogos controlados";
                    Log::error("Error en la edición de cat_item".PHP_EOL.$error);
                }
            }
            else {
                $error = "Error: valor duplicado.   Ya existe un elemento ($duplicado->id_item) con dicha descripción ($request->descripcion).";
                Log::error("Error en la edición de cat_item".PHP_EOL.$error);
            }
        }
        else {  //No hay riesgo de duplicar, proceder con la edición

            $this->fill($request->all());
            try {
                $this->save();

                if($request->predeterminado==1) {
                    $sql="update catalogos.cat_item set predeterminado=2 where id_cat=$existe->id_cat and id_item<>$existe->id_item";
                    \DB::update(\DB::raw($sql));
                }
                $error=false;
            }
            catch (\Exception $e) {
                $link = action("cat_itemController@index")."?id_cat=$this->id_cat";
                $error = "No se modificó la opción. Posiblemente ya haya una opción con ese texto  (revisar <a href='$link' target='_blank'>opciones deshabilitadas)</a>.";
                Log::error("Error en la edición de cat_item".PHP_EOL.$error.PHP_EOL.$e->getMessage());
            }
        }
        if(!$error) {
            traza_actividad::create(['id_objeto'=>5, 'id_accion'=>4 , 'id_primaria'=>$this->id_item, 'codigo'=>"Catalogo $this->id_cat"]);
        }
        return $error;
    }


}
