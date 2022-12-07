<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createcat_itemRequest;
use App\Http\Requests\Updatecat_itemRequest;
use App\Models\cat_cat;
use App\Models\cat_item;
use App\Models\traza_actividad;
use App\Repositories\cat_itemRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class cat_itemController extends AppBaseController
{
    /** @var  cat_itemRepository */
    private $catItemRepository;

    public function __construct(cat_itemRepository $catItemRepo)
    {
        $this->catItemRepository = $catItemRepo;


    }

    /**
     * Display a listing of the cat_item.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        //Seguridad
        //$this->authorize('nivel-1');
        //

        $filtros=cat_item::filtros_default($request);
        //dd($filtros);

        $catalogos = cat_cat::arreglo_editables();
        $id_cat = isset($request->id_cat) ? $request->id_cat : $catalogos->keys()->first();
        $filtros->id_cat = $id_cat;

        $items =cat_item::filtrar($filtros)->ordenar()->get();
        return view("catalogos.index",compact("catalogos","id_cat","items","filtros"));

    }

    /**
     * Show the form for creating a new cat_item.
     *
     * @return Response
     */
    public function create($id_cat)
    {
        //Seguridad
        $this->authorize('rol-tesauro');
        //
        $existe= cat_cat::find($id_cat);
        if($existe) {
            return view("catalogos.create",compact("id_cat"));
        }
        else {
            \Session::flash("mensaje","No existe la opción $id_cat");
            return redirect()->action("cat_itemController@index");
        }
    }

    /**
     * Store a newly created cat_item in storage.
     *
     * @param Createcat_itemRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->authorize('rol-tesauro');

        $rules= [
            "id_cat"=>"required",
            'descripcion'=>'required'
        ];

        $msg= [
            "descripcion.required"=> "Debe especificar el texto de la nueva opción"
        ];

        $this->validate($request,$rules,$msg);

        try {
            $nuevo = cat_item::create($request->all());
            if($request->predeterminado==1) {
                $sql="update catalogos.cat_item set predeterminado=2 where id_cat=$nuevo->id_cat and id_item<>$nuevo->id_item";
                \DB::update(\DB::raw($sql));
            }

            \Flash::success("Se ha grabado el nuevo ítem: $request->descripcion ");
            //Registrar traza
            traza_actividad::create(['id_objeto'=>5, 'id_accion'=>3 , 'id_primaria'=>$nuevo->id_item]);
        }
        catch(\Exception $e) {
            \Flash::warning("Nuevo valor rechazado: ya existe una opción para  $request->descripcion ");
        }




        return redirect(action("cat_itemController@index")."?id_cat=$request->id_cat");
    }

    /**
     * Display the specified cat_item.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return redirect(action("cat_itemController@index"));
    }

    /**
     * Show the form for editing the specified cat_item.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Seguridad
        $this->authorize('rol-tesauro');
        //
        $item= cat_item::find($id);
        if($item) {
            return view("catalogos.edit", compact("item"));
        }
        else {
            \Session::flash('mensaje',"Identificador ($id) no existente");
            return redirect()->action("cat_itemController@index");
        }
    }

    /**
     * Update the specified cat_item in storage.
     *
     * @param  int              $id
     * @param Updatecat_itemRequest $request
     *
     * @return Response
     */
    public function update($id, Updatecat_itemRequest $request)
    {
        //Seguridad
        $this->authorize('rol-tesauro');

        $rules= [
            'descripcion'=>'required'
        ];

        $msg= [
            "descripcion.required"=> "Debe especificar una descripción"
        ];

        $this->validate($request,$rules,$msg);

        $existe = cat_item::find($id);
        if($existe) {
            $error = $existe->editar($request);
            if($error) {
                Flash::error($error);
            }
            else {
                Flash::success("Se ha modificado el ítem: $existe->descripcion ");
            }
        }
        else {
            \Session::flash('mensaje',"No existe el ítem ($id). ");
        }

        $url=action("cat_itemController@index");

        return redirect($url);

    }

    /**
     * Remove the specified cat_item from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Seguridad
        $this->authorize('rol-tesauro');

        //
        $buscar= cat_item::find($id);
        if($buscar) {
            $buscar->habilitado = $buscar->habilitado==1 ? 2 : 1;
            $buscar->save();

            \Flash::success('mensaje',"Opción deshabilitada ");
            traza_actividad::create(['id_objeto'=>5, 'id_accion'=>10 , 'id_primaria'=>$id]);
            return redirect(action("cat_itemController@index")."?id_cat=$buscar->id_cat");
        }
        else {
            \Flash::warning("Opción  ($id) no existente ");
            return redirect(action("cat_itemController@index"));
        }
    }

    public function listados($id)
    {
        if(!in_array($id,[3,4,5])) {
            abort(404);
        }


        $catalogo = cat_cat::find($id);
        if($catalogo) {
            $titulo=$catalogo->descripcion;
            $catItems = cat_item::listado_items($id);

            return view('cat_items.listado')
                ->with('catItems', $catItems)
                ->with('titulo',$titulo);
        }
        else {
            abort(404);
        }
    }

    public function json_opciones($id){

        $catalogo=new \stdClass();
        $catalogo->id_catalogo = $id;
        $catalogo->opciones =cat_item::listado_items($id);
        return response()->json($catalogo);
    }

    /*
     * Recibe el post de agregar otro en un select
     * recibe un unico control: txt_12  (la segunda parte es el id_cat
     * devuelve el id y el texto
     */
    public function store_otro(Request $request)
    {
        $respuesta=new \stdClass();
        $respuesta->exito=false;
        $respuesta->mensaje="Valor inicial";
        $respuesta->item=0;


        $id_cat=$request->id_cat;
        $txt=$request->texto;


        if(strlen($txt)<=0) {
            $respuesta->mensaje="Texto en blanco";
            $respuesta->exito=false;
        }
        else {
            if($id_cat > 0) {
                try {
                    $nuevo = new cat_item();
                    $nuevo->id_cat=$id_cat;
                    $nuevo->pendiente_revisar=1;
                    $nuevo->orden=9999;
                    $nuevo->descripcion=$txt;
                    if(\Auth::check()) {
                        $nuevo->id_entrevistador=\Auth::user()->id_entrevistador;
                    }
                    $nuevo->save();
                    $respuesta->exito=true;
                    $respuesta->item = $nuevo;
                    $respuesta->mensaje="Opción agregada exitosamente";
                }
                catch(\Exception $e) {
                    $respuesta->mensaje="BD: ".$e->getMessage();
                }

            }
            else {
                $respuesta->mensaje="No se detecta el id_cat";
                $respuesta->exito=false;
            }
        }


        return response()->json($respuesta);

    }



    /**
     *  Proceso de reclasificación de opciones
     */
    /// Página principal: Mostrar listados reclasificables
    public function index_reclasificar(Request $request) {
        $this->authorize('rol-tesauro');
        $listado_catalogos = cat_cat::whereNotNull('id_reclasificado')->orderby('nombre')->pluck('nombre','id_cat')->toArray();

        $id_seleccionado = $request->id_seleccionado ?? array_key_first($listado_catalogos);
        $id_cambiado = $request->id_cambiado ?? 0;  //ultima opcion editada (para resaltar)
        $id_reclasificado = $request->id_reclasificado ?? 0; //última opcion reclasificada (para resaltar)
        $filtrar = $request->filtrar ?? 0; //Mostrar solo los pendientes de reclasificar
        //dd($filtrar);
        $filtrar = $filtrar==='on' ? 1 : $filtrar;
        //dd($filtrar);
        $listado_items = cat_item::id_cat($id_seleccionado)->habilitado()->reclasificacion($filtrar)->orderby('descripcion')->paginate(40);
        return view('cat_items.reclasificar.index')
            ->with(['listado_catalogos'=>$listado_catalogos])
            ->with(['listado_items'=>$listado_items])
            ->with(['id_cambiado'=>$id_cambiado])
            ->with(['id_reclasificado'=>$id_reclasificado])
            ->with(['filtrar'=>$filtrar])
            ->with(['id_seleccionado'=>$id_seleccionado]);
    }
    public function frm_editar(Request $request, cat_item $cat_item) {
        $this->authorize('rol-tesauro');
        return view('cat_items.reclasificar.frm_editar', compact('cat_item','request'));
    }
    public function editar(Request $request, cat_item $cat_item) {
        $this->authorize('rol-tesauro');
        $request->validate([
            'nuevo'=>'required|max:200'
        ]);
        if($cat_item->descripcion <> $request->nuevo) {
            $request->request->add(['descripcion'=>$request->nuevo]); //Para poder utilizar la funcionalidad de cat_item
            $error = $cat_item->editar($request);
            if($error) {
                Flash::error($error);
            }
            else {
                Flash::success("Se ha modificado el ítem: $cat_item->descripcion ");
            }
//            $antiguo=$cat_item->descripcion;
//            $cat_item->descripcion=$request->nuevo;
//            $cat_item->save();
//            Flash::success('Opción actualizada: '.$request->nuevo);
            //Traza de actividad
            //traza_actividad::create(['id_objeto'=>5, 'id_accion'=>4, 'codigo'=>$cat_item->rel_id_cat->nombre, 'id_primaria'=>$cat_item->id_item, 'referencia'=>"De:[$antiguo] a:[$cat_item->descripcion]"]);
        }
        else {
            Flash::success('Opción sin cambios: '.$request->nuevo);
        }


        $url = action('cat_itemController@index_reclasificar')."?id_seleccionado=".$cat_item->id_cat."&id_cambiado=".$cat_item->id_item."&filtrar=".$request->filtrar."&page=".$request->page ;

        return redirect($url);
    }

    public function frm_reclasificar(Request $request, cat_item $cat_item) {
        $this->authorize('rol-tesauro');
        $cat_cat_padre = $cat_item->rel_id_cat;

        //dd($cat_cat_padre);

        $hay_lista = $cat_cat_padre->rel_id_reclasificado->rel_items()->count();


        return view('cat_items.reclasificar.frm_reclasificar')
                    ->with('cat_item',$cat_item)
                    ->with('hay_lista',$hay_lista)
                    ->with('request',$request)
                    ->with('cat_cat', $cat_cat_padre);


    }
    public function reclasificar(Request $request, cat_item $cat_item) {
        $this->authorize('rol-tesauro');
        //Pendiente: validacion
        if(isset($request->nuevo)) {
            $rules=['nuevo'=>'required'];
            $messages = [
                'nuevo.required' => 'No puede dejar en blanco el nuevo texto',
            ];
        }
        else {
            $rules=['id_nuevo'=>'required'];
            $messages = [
                'id_nuevo.required' => 'Debe elegir una opción de la lista',
            ];
        }
        $request->validate($rules,$messages);

        if(isset($request->nuevo)) {
            $cat_relacionado = $cat_item->rel_id_cat->rel_id_reclasificado;
            $nuevo = new cat_item();
            $nuevo->id_cat=$cat_relacionado->id_cat;
            $nuevo->descripcion = $request->nuevo;
            $nuevo->id_entrevistador = \Auth::user()->id_entrevistador;
            try {
                $nuevo->save();
                $cat_item->id_reclasificado=$nuevo->id_item;
                $cat_item->save();
                Flash::success("Nueva categoría creada exitosamente");
                //Traza de actividad
                traza_actividad::create(['id_objeto'=>5, 'id_accion'=>70, 'codigo'=>"Catalogo $cat_item->id_cat", 'id_primaria'=>$cat_item->id_item, 'referencia'=>"De:[$cat_item->descripcion] a:[$nuevo->descripcion]"]);
            }
            catch (\Exception $e) {
                Flash::error("No se pudo crear la nueva categoría, porque ya existe una reclasificación que coincide con ese texto.");
            }


        }
        else {
            $cat_item->id_reclasificado = $request->id_nuevo;
            $cat_item->save();

            Flash::success("Reclasificación aplicada exitosamente");
            //Traza de actividad
            $nuevo = $cat_item->rel_id_reclasificado; //Para la traza
            if($nuevo) {
                traza_actividad::create(['id_objeto'=>5, 'id_accion'=>70, 'codigo'=>"Catalogo $cat_item->id_cat", 'id_primaria'=>$cat_item->id_item, 'referencia'=>"De:[$cat_item->descripcion] a:[$nuevo->descripcion]"]);
            }
            else {
                traza_actividad::create(['id_objeto'=>5, 'id_accion'=>70, 'codigo'=>"Catalogo $cat_item->id_cat", 'id_primaria'=>$cat_item->id_item, 'referencia'=>"De:[$cat_item->descripcion] a:[IGNORAR]"]);
            }

        }
        $url = action('cat_itemController@index_reclasificar')."?id_seleccionado=".$cat_item->id_cat."&id_reclasificado=".$cat_item->id_item."&filtrar=".$request->filtrar."&page=".$request->page ;
        return redirect($url);


    }

}
