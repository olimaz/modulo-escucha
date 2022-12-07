<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreategeoRequest;
use App\Http\Requests\UpdategeoRequest;
use App\Models\geo;
use App\Repositories\geoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class geoController extends AppBaseController
{
    /** @var  geoRepository */
    private $geoRepository;

    public function __construct(geoRepository $geoRepo)
    {
        $this->geoRepository = $geoRepo;
    }

    /**
     * Display a listing of the geo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {


        return view('geos.index');
    }

    /**
     * Show the form for creating a new geo.
     *
     * @return Response
     */
    public function create()
    {
        return view('geos.create');
    }

    /**
     * Store a newly created geo in storage.
     *
     * @param CreategeoRequest $request
     *
     * @return Response
     */
    public function store(CreategeoRequest $request)
    {
        $input = $request->all();

        $geo = $this->geoRepository->create($input);

        Flash::success('Geo saved successfully.');

        return redirect(route('geos.index'));
    }

    /**
     * Display the specified geo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $geo = $this->geoRepository->findWithoutFail($id);

        if (empty($geo)) {
            Flash::error('Geo not found');

            return redirect(route('geos.index'));
        }

        return view('geos.show')->with('geo', $geo);
    }

    /**
     * Show the form for editing the specified geo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $geo = $this->geoRepository->findWithoutFail($id);

        if (empty($geo)) {
            Flash::error('Geo not found');

            return redirect(route('geos.index'));
        }

        return view('geos.edit')->with('geo', $geo);
    }

    /**
     * Update the specified geo in storage.
     *
     * @param  int              $id
     * @param UpdategeoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdategeoRequest $request)
    {
        $geo = $this->geoRepository->findWithoutFail($id);

        if (empty($geo)) {
            Flash::error('Geo not found');

            return redirect(route('geos.index'));
        }

        $geo = $this->geoRepository->update($request->all(), $id);

        Flash::success('Geo updated successfully.');

        return redirect(route('geos.index'));
    }

    /**
     * Remove the specified geo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $geo = $this->geoRepository->findWithoutFail($id);

        if (empty($geo)) {
            Flash::error('Geo not found');

            return redirect(route('geos.index'));
        }

        $this->geoRepository->delete($id);

        Flash::success('Geo deleted successfully.');

        return redirect(route('geos.index'));
    }


    //PAra el JSON del control dependiente
    public function mostrar_hijos(Request $request) {
        $id_padre = isset($request->depdrop_parents[0]) ? $request->depdrop_parents[0] : 0 ;
        $default = isset($request->depdrop_params[0]) ? $request->depdrop_params[0] : 0;
        return  \App\Models\geo::json_select($id_padre,$default);
        //return  \App\Models\geo::json_select();
    }

    //Permitir agregar otro en el tercer nivel
    public function mostrar_hijos_otro_cual(Request $request) {
        $id_padre = isset($request->depdrop_parents[0]) ? $request->depdrop_parents[0] : 0 ;
        $default = isset($request->depdrop_params[0]) ? $request->depdrop_params[0] : 0;
        return  \App\Models\geo::json_select($id_padre,$default,"",true);
        //return  \App\Models\geo::json_select();
    }

    public function mostrar_hijos_con_todo(Request $request) {

        $id_padre = isset($request->depdrop_parents[0]) ? $request->depdrop_parents[0] : 0 ;
        $default = isset($request->depdrop_params[0]) ? $request->depdrop_params[0] : 0;
        $vacio = $request->depdrop_params[0] ?? "(Mostrar todos)";
        return  \App\Models\geo::json_select($id_padre,$default,$vacio);
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


        $id_padre=$request->id_padre;
        $txt=$request->texto;


        if(strlen($txt)<=0) {
            $respuesta->mensaje="Texto en blanco";
            $respuesta->exito=false;
        }
        else {
            if($id_padre > 0) {
                try {
                    $nuevo = new geo();
                    $nuevo->id_padre=$id_padre;
                    //$nuevo->pendiente_revisar=1;
                    $nuevo->descripcion=$txt;
                    $nuevo->nivel=3;
                    $nuevo->codigo='revisar';
                    if(\Auth::check()) {
                        $nuevo->id_entrevistador=\Auth::user()->id_entrevistador;
                    }
                    $nuevo->save();
                    $respuesta->exito=true;
                    $respuesta->item = $nuevo;
                    $respuesta->mensaje="Ciudad agregada exitosamente";
                }
                catch(\Exception $e) {
                    $respuesta->mensaje="BD: ".$e->getMessage();
                }

            }
            else {
                $respuesta->mensaje="No se detecta el id_padre";
                $respuesta->exito=false;
            }
        }


        return response()->json($respuesta);

    }


}
