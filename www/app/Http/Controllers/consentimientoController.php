<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateconsentimientoRequest;
use App\Http\Requests\UpdateconsentimientoRequest;
use App\Repositories\consentimientoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class consentimientoController extends AppBaseController
{
    /** @var  consentimientoRepository */
    private $consentimientoRepository;

    public function __construct(consentimientoRepository $consentimientoRepo)
    {
        $this->consentimientoRepository = $consentimientoRepo;
    }

    /**
     * Display a listing of the consentimiento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->consentimientoRepository->pushCriteria(new RequestCriteria($request));
        $consentimientos = $this->consentimientoRepository->all();

        return view('consentimientos.index')
            ->with('consentimientos', $consentimientos);
    }

    /**
     * Show the form for creating a new consentimiento.
     *
     * @return Response
     */
    public function create()
    {
        return view('consentimientos.create');
    }

    /**
     * Store a newly created consentimiento in storage.
     *
     * @param CreateconsentimientoRequest $request
     *
     * @return Response
     */
    public function store(CreateconsentimientoRequest $request)
    {
        $input = $request->all();

        $consentimiento = $this->consentimientoRepository->create($input);

        Flash::success('Consentimiento saved successfully.');

        return redirect(route('consentimientos.index'));
    }

    /**
     * Display the specified consentimiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $consentimiento = $this->consentimientoRepository->findWithoutFail($id);

        if (empty($consentimiento)) {
            Flash::error('Consentimiento not found');

            return redirect(route('consentimientos.index'));
        }

        return view('consentimientos.show')->with('consentimiento', $consentimiento);
    }

    /**
     * Show the form for editing the specified consentimiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $consentimiento = $this->consentimientoRepository->findWithoutFail($id);

        if (empty($consentimiento)) {
            Flash::error('Consentimiento not found');

            return redirect(route('consentimientos.index'));
        }

        return view('consentimientos.edit')->with('consentimiento', $consentimiento);
    }

    /**
     * Update the specified consentimiento in storage.
     *
     * @param  int              $id
     * @param UpdateconsentimientoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateconsentimientoRequest $request)
    {
        $consentimiento = $this->consentimientoRepository->findWithoutFail($id);

        if (empty($consentimiento)) {
            Flash::error('Consentimiento not found');

            return redirect(route('consentimientos.index'));
        }

        $consentimiento = $this->consentimientoRepository->update($request->all(), $id);

        Flash::success('Consentimiento updated successfully.');

        return redirect(route('consentimientos.index'));
    }

    /**
     * Remove the specified consentimiento from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $consentimiento = $this->consentimientoRepository->findWithoutFail($id);

        if (empty($consentimiento)) {
            Flash::error('Consentimiento not found');

            return redirect(route('consentimientos.index'));
        }

        $this->consentimientoRepository->delete($id);

        Flash::success('Consentimiento deleted successfully.');

        return redirect(route('consentimientos.index'));
    }
}
