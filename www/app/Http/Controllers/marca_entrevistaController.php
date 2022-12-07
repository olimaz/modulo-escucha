<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createmarca_entrevistaRequest;
use App\Http\Requests\Updatemarca_entrevistaRequest;
use App\Models\marca;
use App\Models\marca_entrevista;
use App\Repositories\marca_entrevistaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class marca_entrevistaController extends AppBaseController
{
    /** @var  marca_entrevistaRepository */
    private $marcaEntrevistaRepository;

    public function __construct(marca_entrevistaRepository $marcaEntrevistaRepo)
    {
        $this->marcaEntrevistaRepository = $marcaEntrevistaRepo;
    }

    /**
     * Display a listing of the marca_entrevista.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->marcaEntrevistaRepository->pushCriteria(new RequestCriteria($request));
        $marcaEntrevistas = $this->marcaEntrevistaRepository->all();

        return view('marca_entrevistas.index')
            ->with('marcaEntrevistas', $marcaEntrevistas);
    }

    /**
     * Show the form for creating a new marca_entrevista.
     *
     * @return Response
     */
    public function create()
    {
        return view('marca_entrevistas.create');
    }

    /**
     * Store a newly created marca_entrevista in storage.
     *
     * @param Createmarca_entrevistaRequest $request
     *
     * @return Response
     */
    public function store(Createmarca_entrevistaRequest $request)
    {
        //$input = $request->all();
        //dd($request);

        marca_entrevista::procesar_marcas($request);



        //$marcaEntrevista = $this->marcaEntrevistaRepository->create($input);

        //Flash::success('Marca Entrevista saved successfully.');

        return redirect()->back();
    }

    /**
     * Display the specified marca_entrevista.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $marcaEntrevista = $this->marcaEntrevistaRepository->findWithoutFail($id);

        if (empty($marcaEntrevista)) {
            Flash::error('Marca Entrevista not found');

            return redirect(route('marcaEntrevistas.index'));
        }

        return view('marca_entrevistas.show')->with('marcaEntrevista', $marcaEntrevista);
    }

    /**
     * Show the form for editing the specified marca_entrevista.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $marcaEntrevista = $this->marcaEntrevistaRepository->findWithoutFail($id);

        if (empty($marcaEntrevista)) {
            Flash::error('Marca Entrevista not found');

            return redirect(route('marcaEntrevistas.index'));
        }

        return view('marca_entrevistas.edit')->with('marcaEntrevista', $marcaEntrevista);
    }

    /**
     * Update the specified marca_entrevista in storage.
     *
     * @param  int              $id
     * @param Updatemarca_entrevistaRequest $request
     *
     * @return Response
     */
    public function update($id, Updatemarca_entrevistaRequest $request)
    {
        $marcaEntrevista = $this->marcaEntrevistaRepository->findWithoutFail($id);

        if (empty($marcaEntrevista)) {
            Flash::error('Marca Entrevista not found');

            return redirect(route('marcaEntrevistas.index'));
        }

        $marcaEntrevista = $this->marcaEntrevistaRepository->update($request->all(), $id);

        Flash::success('Marca Entrevista updated successfully.');

        return redirect(route('marcaEntrevistas.index'));
    }

    /**
     * Remove the specified marca_entrevista from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $marcaEntrevista = $this->marcaEntrevistaRepository->findWithoutFail($id);

        if (empty($marcaEntrevista)) {
            Flash::error('Marca Entrevista not found');

            return redirect(route('marcaEntrevistas.index'));
        }

        $this->marcaEntrevistaRepository->delete($id);

        Flash::success('Marca Entrevista deleted successfully.');

        return redirect(route('marcaEntrevistas.index'));
    }
}
