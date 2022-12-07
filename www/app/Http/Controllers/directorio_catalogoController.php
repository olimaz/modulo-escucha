<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createdirectorio_catalogoRequest;
use App\Http\Requests\Updatedirectorio_catalogoRequest;
use App\Repositories\directorio_catalogoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class directorio_catalogoController extends AppBaseController
{
    /** @var  directorio_catalogoRepository */
    private $directorioCatalogoRepository;

    public function __construct(directorio_catalogoRepository $directorioCatalogoRepo)
    {
        $this->directorioCatalogoRepository = $directorioCatalogoRepo;
    }

    /**
     * Display a listing of the directorio_catalogo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->directorioCatalogoRepository->pushCriteria(new RequestCriteria($request));
        $directorioCatalogos = $this->directorioCatalogoRepository->all();

        return view('directorio_catalogos.index')
            ->with('directorioCatalogos', $directorioCatalogos);
    }

    /**
     * Show the form for creating a new directorio_catalogo.
     *
     * @return Response
     */
    public function create()
    {
        return view('directorio_catalogos.create');
    }

    /**
     * Store a newly created directorio_catalogo in storage.
     *
     * @param Createdirectorio_catalogoRequest $request
     *
     * @return Response
     */
    public function store(Createdirectorio_catalogoRequest $request)
    {
        $input = $request->all();

        $directorioCatalogo = $this->directorioCatalogoRepository->create($input);

        Flash::success('Directorio Catalogo saved successfully.');

        return redirect(route('directorioCatalogos.index'));
    }

    /**
     * Display the specified directorio_catalogo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $directorioCatalogo = $this->directorioCatalogoRepository->findWithoutFail($id);

        if (empty($directorioCatalogo)) {
            Flash::error('Directorio Catalogo not found');

            return redirect(route('directorioCatalogos.index'));
        }

        return view('directorio_catalogos.show')->with('directorioCatalogo', $directorioCatalogo);
    }

    /**
     * Show the form for editing the specified directorio_catalogo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $directorioCatalogo = $this->directorioCatalogoRepository->findWithoutFail($id);

        if (empty($directorioCatalogo)) {
            Flash::error('Directorio Catalogo not found');

            return redirect(route('directorioCatalogos.index'));
        }

        return view('directorio_catalogos.edit')->with('directorioCatalogo', $directorioCatalogo);
    }

    /**
     * Update the specified directorio_catalogo in storage.
     *
     * @param  int              $id
     * @param Updatedirectorio_catalogoRequest $request
     *
     * @return Response
     */
    public function update($id, Updatedirectorio_catalogoRequest $request)
    {
        $directorioCatalogo = $this->directorioCatalogoRepository->findWithoutFail($id);

        if (empty($directorioCatalogo)) {
            Flash::error('Directorio Catalogo not found');

            return redirect(route('directorioCatalogos.index'));
        }

        $directorioCatalogo = $this->directorioCatalogoRepository->update($request->all(), $id);

        Flash::success('Directorio Catalogo updated successfully.');

        return redirect(route('directorioCatalogos.index'));
    }

    /**
     * Remove the specified directorio_catalogo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $directorioCatalogo = $this->directorioCatalogoRepository->findWithoutFail($id);

        if (empty($directorioCatalogo)) {
            Flash::error('Directorio Catalogo not found');

            return redirect(route('directorioCatalogos.index'));
        }

        $this->directorioCatalogoRepository->delete($id);

        Flash::success('Directorio Catalogo deleted successfully.');

        return redirect(route('directorioCatalogos.index'));
    }
}
