<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createtraza_catalogoRequest;
use App\Http\Requests\Updatetraza_catalogoRequest;
use App\Repositories\traza_catalogoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class traza_catalogoController extends AppBaseController
{
    /** @var  traza_catalogoRepository */
    private $trazaCatalogoRepository;

    public function __construct(traza_catalogoRepository $trazaCatalogoRepo)
    {
        $this->trazaCatalogoRepository = $trazaCatalogoRepo;
    }

    /**
     * Display a listing of the traza_catalogo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->trazaCatalogoRepository->pushCriteria(new RequestCriteria($request));
        $trazaCatalogos = $this->trazaCatalogoRepository->all();

        return view('traza_catalogos.index')
            ->with('trazaCatalogos', $trazaCatalogos);
    }

    /**
     * Show the form for creating a new traza_catalogo.
     *
     * @return Response
     */
    public function create()
    {
        return view('traza_catalogos.create');
    }

    /**
     * Store a newly created traza_catalogo in storage.
     *
     * @param Createtraza_catalogoRequest $request
     *
     * @return Response
     */
    public function store(Createtraza_catalogoRequest $request)
    {
        $input = $request->all();

        $trazaCatalogo = $this->trazaCatalogoRepository->create($input);

        Flash::success('Traza Catalogo saved successfully.');

        //return redirect(route('trazaCatalogos.index'));
    }

    /**
     * Display the specified traza_catalogo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $trazaCatalogo = $this->trazaCatalogoRepository->findWithoutFail($id);

        if (empty($trazaCatalogo)) {
            Flash::error('Traza Catalogo not found');

            return redirect(route('trazaCatalogos.index'));
        }

        return view('traza_catalogos.show')->with('trazaCatalogo', $trazaCatalogo);
    }

    /**
     * Show the form for editing the specified traza_catalogo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $trazaCatalogo = $this->trazaCatalogoRepository->findWithoutFail($id);

        if (empty($trazaCatalogo)) {
            Flash::error('Traza Catalogo not found');

            return redirect(route('trazaCatalogos.index'));
        }

        return view('traza_catalogos.edit')->with('trazaCatalogo', $trazaCatalogo);
    }

    /**
     * Update the specified traza_catalogo in storage.
     *
     * @param  int              $id
     * @param Updatetraza_catalogoRequest $request
     *
     * @return Response
     */
    public function update($id, Updatetraza_catalogoRequest $request)
    {
        $trazaCatalogo = $this->trazaCatalogoRepository->findWithoutFail($id);

        if (empty($trazaCatalogo)) {
            Flash::error('Traza Catalogo not found');

            return redirect(route('trazaCatalogos.index'));
        }

        $trazaCatalogo = $this->trazaCatalogoRepository->update($request->all(), $id);

        Flash::success('Traza Catalogo updated successfully.');

        return redirect(route('trazaCatalogos.index'));
    }

    /**
     * Remove the specified traza_catalogo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $trazaCatalogo = $this->trazaCatalogoRepository->findWithoutFail($id);

        if (empty($trazaCatalogo)) {
            Flash::error('Traza Catalogo not found');

            return redirect(route('trazaCatalogos.index'));
        }

        $this->trazaCatalogoRepository->delete($id);

        Flash::success('Traza Catalogo deleted successfully.');

        return redirect(route('trazaCatalogos.index'));
    }
}
