<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateenlaceRequest;
use App\Http\Requests\UpdateenlaceRequest;
use App\Models\enlace;
use App\Models\traza_actividad;
use App\Repositories\enlaceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class enlaceController extends AppBaseController
{
    /** @var  enlaceRepository */
    private $enlaceRepository;

    public function __construct(enlaceRepository $enlaceRepo)
    {
        $this->enlaceRepository = $enlaceRepo;
    }

    /**
     * Display a listing of the enlace.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //return redirect("/");
        //$this->enlaceRepository->pushCriteria(new RequestCriteria($request));
        $this->authorize('nivel-1');
        $enlaces = enlace::ordenar()->activos()->get();

        return view('enlaces.index')
            ->with('enlaces', $enlaces);
    }

    /**
     * Show the form for creating a new enlace.
     *
     * @return Response
     */
    public function create()
    {
        return redirect("/");
        return view('enlaces.create');
    }

    /**
     * Store a newly created enlace in storage.
     *
     * @param CreateenlaceRequest $request
     *
     * @return Response
     */
    public function store(CreateenlaceRequest $request)
    {
        $input = $request->all();

        $res=enlace::crear_nuevo($input);

        if($res->exito) {
            $enlace = $res->enlace;
            Flash::success($res->mensaje);
            $buscar = enlace::buscar_llaves($enlace->id_subserie, $enlace->id_primaria);
            $destino = enlace::buscar_llaves($enlace->id_subserie_e, $enlace->id_primaria_e);
            //Traza
            $id_objeto = traza_actividad::de_subserie_a_traza($request->id_subserie);
            traza_actividad::create(['id_objeto'=>$id_objeto, 'id_accion'=>31, 'codigo'=>$buscar->codigo, 'id_primaria'=>$request->id_primaria, 'referencia'=>"enlazada con $destino->codigo"]);
            return redirect()->action('statController@ubicar',$buscar->codigo);
        }
        else {
            Flash::warning($res->mensaje);
            return redirect()->back();
        }

    }

    /**
     * Display the specified enlace.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return redirect("/");
        $enlace = $this->enlaceRepository->findWithoutFail($id);

        if (empty($enlace)) {
            Flash::error('Enlace not found');

            return redirect(route('enlaces.index'));
        }

        return view('enlaces.show')->with('enlace', $enlace);
    }

    /**
     * Show the form for editing the specified enlace.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        return redirect("/");
        $enlace = $this->enlaceRepository->findWithoutFail($id);

        if (empty($enlace)) {
            Flash::error('Enlace not found');

            return redirect(route('enlaces.index'));
        }

        return view('enlaces.edit')->with('enlace', $enlace);
    }

    /**
     * Update the specified enlace in storage.
     *
     * @param  int              $id
     * @param UpdateenlaceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateenlaceRequest $request)
    {
        return redirect("/");
        $enlace = $this->enlaceRepository->findWithoutFail($id);

        if (empty($enlace)) {
            Flash::error('Enlace not found');

            return redirect(route('enlaces.index'));
        }

        $enlace = $this->enlaceRepository->update($request->all(), $id);

        Flash::success('Enlace updated successfully.');

        return redirect(route('enlaces.index'));
    }

    /**
     * Remove the specified enlace from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->authorize('nivel-10'); //Administrador y jefe de transcriptores
        $enlace = $this->enlaceRepository->findWithoutFail($id);

        if (empty($enlace)) {
            Flash::error('Enlace no encontrado');
            return redirect()->back();
        }
        $enlace->borrar(); //Logica de borrar un enlace

        //Traza
        $buscar = enlace::buscar_llaves($enlace->id_subserie, $enlace->id_primaria);
        $destino = enlace::buscar_llaves($enlace->id_subserie_e, $enlace->id_primaria_e);

        $id_objeto = traza_actividad::de_subserie_a_traza($enlace->id_subserie);
        traza_actividad::create(['id_objeto'=>$id_objeto, 'id_accion'=>32, 'codigo'=>$buscar->codigo, 'id_primaria'=>$enlace->id_primaria, 'referencia'=>"enlazada con $destino->codigo"]);

        Flash::success('Enlace eliminado');

        return redirect()->back();
    }
}
