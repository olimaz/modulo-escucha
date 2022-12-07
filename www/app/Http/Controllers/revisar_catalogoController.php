<?php

namespace App\Http\Controllers;

use App\Models\cat_cat;
use App\Models\cat_item;
use App\Models\directorio_catalogo;
use App\Models\traza_catalogo;
use App\Models\revisar_catalogo;
use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use Illuminate\Http\Request;

class revisar_catalogoController extends AppBaseController
{


    public function index(Request $request)
    {
        $this->authorize('rol-tesauro');
        $listado_catalogos = cat_cat::arreglo_revisables();
        reset($listado_catalogos);
        $primero = key($listado_catalogos);

        $id_cat = isset($request->id_cat) ? $request->id_cat : $primero;

        //Pendientes de aprobar
      $catalogos=cat_item::join('catalogos.cat_cat','cat_cat.id_cat','=','cat_item.id_cat')
                            ->where('pendiente_revisar',1)
                            ->orderBy('cat_cat.descripcion')
                            ->orderBy('cat_cat.id_cat')
                            ->orderBy('cat_item.descripcion')
                            ->select(\DB::raw('cat_item.*'))
                            ->where('cat_item.id_cat',$id_cat)
                            ->where('habilitado',1)
                            ->get();
    //  dd($catalogos->id_cat  );
      foreach ($catalogos as $catalogo) {
          //Opciones aprobadas
        $catalogo->opciones=cat_item::where('id_cat',$catalogo->id_cat)
                                ->wherein("pendiente_revisar",[2,3])
                                ->where('habilitado',1)
                                ->orderby('descripcion')
                                ->get();

      }

        //dd($catalogos  );
        //dd($listado_catalogos);
      return view("revisar_catalogo.index",compact("catalogos","listado_catalogos","id_cat"));

    }

    public function aprobar($id_item)
    {
        $this->authorize('rol-tesauro');
      //dd($id_item);
      $catalogo=cat_item::where('id_item',$id_item)->first();
      //dd($catalogo);
      $catalogo->pendiente_revisar=3;
      $catalogo->habilitado=1;
      $catalogo->save();
        $url=route('revisar_catalogo.index');
        $url.="?id_cat=$catalogo->id_cat";
        return redirect($url);

      //return redirect(route('revisar_catalogo.index'));

      // App\Flight::where('active', 1)
      //           ->where('destination', 'San Diego')
      //           ->update(['delayed' => 1]);
      // //return view("revisar_catalogo.index",compact("catalogos"));

    }

    public function editar_item(Request $request)
    {
        $this->authorize('rol-tesauro');
      //dd($request);
      $catalogo=cat_item::where('id_item',$request->id_item)->first();
      //dd($catalogo);
      $catalogo->descripcion=$request->nuevo_nombre;
        try {
            $catalogo->save();
        }
        catch (\Exception $e) {
            \Flash::error('No se modificó la opción. Posiblemente ya exista una opción con ese texto.');
            Log::debug('revisar_catalogoController@editar_item: '.$e->getMessage());

            //return redirect()->back();
        }
        $url=route('revisar_catalogo.index');
        $url.="?id_cat=$request->id_cat";
        return redirect($url);
      //return redirect(route('revisar_catalogo.index'));

    }

    public function update(Request $request) {
        // dd($request);
        $this->authorize('rol-tesauro');
        $info_dir=[];
        $cont=0;
        $id_entrevistador=\Auth::user()->id_entrevistador;
        $dir_catalogo=directorio_catalogo::where('id_catalogo',$request->id_cat)->get();

        foreach ($dir_catalogo as $directorio) {
            $info_dir[$cont]["id_directorio_catalogo"]=$directorio->id_directorio_catalogo;
            $info_dir[$cont]["tabla"]=$directorio->tabla;
            $info_dir[$cont]["campo"]=$directorio->campo;
            $info_dir[$cont]["descripcion"]=$directorio->descripcion;
            $info_dir[$cont]["id_cat"]=$request->id_cat;
            $info_dir[$cont]["id_item_asignar"]=$request->id_item_asignar;
            $info_dir[$cont]["id_item"]=$request->id_item;
            $info_dir[$cont]["id_entrevistador"]=$id_entrevistador;
            $cont++;
        }
        $mensaje=revisar_catalogo::sustituye($info_dir);
        if($mensaje=="ERROR"){
            Flash::error('No se encontro un directoio para el catalogo');
        }
        else {
            Flash::success($mensaje);
            //$catalogo=cat_item::where('id_item',$request->id_item)->first();
            $catalogo=cat_item::find($request->id_item);
            //dd($catalogo);
            $catalogo->pendiente_revisar=3;
            $catalogo->habilitado=2;
            //dd($catalogo);
            $catalogo->save();
        }
        $url=route('revisar_catalogo.index');
        $url.="?id_cat=$request->id_cat";
        return redirect($url);

    }


}
