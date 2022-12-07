<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatecorrelativoRequest;
use App\Http\Requests\UpdatecorrelativoRequest;
use App\Repositories\correlativoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class correlativoController extends AppBaseController
{
    /** @var  correlativoRepository */
    private $correlativoRepository;

    public function __construct(correlativoRepository $correlativoRepo)
    {
        $this->correlativoRepository = $correlativoRepo;
    }

    /**
     * Display a listing of the correlativo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->correlativoRepository->pushCriteria(new RequestCriteria($request));
        $correlativos = $this->correlativoRepository->all();

        return view('correlativos.index')
            ->with('correlativos', $correlativos);
    }

    /**
     * Show the form for creating a new correlativo.
     *
     * @return Response
     */
    public function create()
    {
        return view('correlativos.create');
    }

    /**
     * Store a newly created correlativo in storage.
     *
     * @param CreatecorrelativoRequest $request
     *
     * @return Response
     */
    public function store(CreatecorrelativoRequest $request)
    {
        $input = $request->all();

        $correlativo = $this->correlativoRepository->create($input);

        Flash::success('Correlativo saved successfully.');

        return redirect(route('correlativos.index'));
    }

    /**
     * Display the specified correlativo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $correlativo = $this->correlativoRepository->findWithoutFail($id);

        if (empty($correlativo)) {
            Flash::error('Correlativo not found');

            return redirect(route('correlativos.index'));
        }

        return view('correlativos.show')->with('correlativo', $correlativo);
    }

    /**
     * Show the form for editing the specified correlativo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $correlativo = $this->correlativoRepository->findWithoutFail($id);

        if (empty($correlativo)) {
            Flash::error('Correlativo not found');

            return redirect(route('correlativos.index'));
        }

        return view('correlativos.edit')->with('correlativo', $correlativo);
    }

    /**
     * Update the specified correlativo in storage.
     *
     * @param  int              $id
     * @param UpdatecorrelativoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecorrelativoRequest $request)
    {
        $correlativo = $this->correlativoRepository->findWithoutFail($id);

        if (empty($correlativo)) {
            Flash::error('Correlativo not found');

            return redirect(route('correlativos.index'));
        }

        $correlativo = $this->correlativoRepository->update($request->all(), $id);

        Flash::success('Correlativo updated successfully.');

        return redirect(route('correlativos.index'));
    }

    /**
     * Remove the specified correlativo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $correlativo = $this->correlativoRepository->findWithoutFail($id);

        if (empty($correlativo)) {
            Flash::error('Correlativo not found');

            return redirect(route('correlativos.index'));
        }

        $this->correlativoRepository->delete($id);

        Flash::success('Correlativo deleted successfully.');

        return redirect(route('correlativos.index'));
    }
}
