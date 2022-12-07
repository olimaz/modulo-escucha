<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createcriterio_fijoRequest;
use App\Http\Requests\Updatecriterio_fijoRequest;
use App\Repositories\criterio_fijoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class criterio_fijoController extends AppBaseController
{
    /** @var  criterio_fijoRepository */
    private $criterioFijoRepository;

    public function __construct(criterio_fijoRepository $criterioFijoRepo)
    {
        $this->criterioFijoRepository = $criterioFijoRepo;
    }

    /**
     * Display a listing of the criterio_fijo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->criterioFijoRepository->pushCriteria(new RequestCriteria($request));
        $criterioFijos = $this->criterioFijoRepository->all();

        return view('criterio_fijos.index')
            ->with('criterioFijos', $criterioFijos);
    }

    /**
     * Show the form for creating a new criterio_fijo.
     *
     * @return Response
     */
    public function create()
    {
        return view('criterio_fijos.create');
    }

    /**
     * Store a newly created criterio_fijo in storage.
     *
     * @param Createcriterio_fijoRequest $request
     *
     * @return Response
     */
    public function store(Createcriterio_fijoRequest $request)
    {
        $input = $request->all();

        $criterioFijo = $this->criterioFijoRepository->create($input);

        Flash::success('Criterio Fijo saved successfully.');

        return redirect(route('criterioFijos.index'));
    }

    /**
     * Display the specified criterio_fijo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $criterioFijo = $this->criterioFijoRepository->findWithoutFail($id);

        if (empty($criterioFijo)) {
            Flash::error('Criterio Fijo not found');

            return redirect(route('criterioFijos.index'));
        }

        return view('criterio_fijos.show')->with('criterioFijo', $criterioFijo);
    }

    /**
     * Show the form for editing the specified criterio_fijo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $criterioFijo = $this->criterioFijoRepository->findWithoutFail($id);

        if (empty($criterioFijo)) {
            Flash::error('Criterio Fijo not found');

            return redirect(route('criterioFijos.index'));
        }

        return view('criterio_fijos.edit')->with('criterioFijo', $criterioFijo);
    }

    /**
     * Update the specified criterio_fijo in storage.
     *
     * @param  int              $id
     * @param Updatecriterio_fijoRequest $request
     *
     * @return Response
     */
    public function update($id, Updatecriterio_fijoRequest $request)
    {
        $criterioFijo = $this->criterioFijoRepository->findWithoutFail($id);

        if (empty($criterioFijo)) {
            Flash::error('Criterio Fijo not found');

            return redirect(route('criterioFijos.index'));
        }

        $criterioFijo = $this->criterioFijoRepository->update($request->all(), $id);

        Flash::success('Criterio Fijo updated successfully.');

        return redirect(route('criterioFijos.index'));
    }

    /**
     * Remove the specified criterio_fijo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $criterioFijo = $this->criterioFijoRepository->findWithoutFail($id);

        if (empty($criterioFijo)) {
            Flash::error('Criterio Fijo not found');

            return redirect(route('criterioFijos.index'));
        }

        $this->criterioFijoRepository->delete($id);

        Flash::success('Criterio Fijo deleted successfully.');

        return redirect(route('criterioFijos.index'));
    }
}
