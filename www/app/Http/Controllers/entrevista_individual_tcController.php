<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createentrevista_individual_tcRequest;
use App\Http\Requests\Updateentrevista_individual_tcRequest;
use App\Repositories\entrevista_individual_tcRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class entrevista_individual_tcController extends AppBaseController
{
    /** @var  entrevista_individual_tcRepository */
    private $entrevistaIndividualTcRepository;

    public function __construct(entrevista_individual_tcRepository $entrevistaIndividualTcRepo)
    {
        $this->entrevistaIndividualTcRepository = $entrevistaIndividualTcRepo;
    }

    /**
     * Display a listing of the entrevista_individual_tc.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->entrevistaIndividualTcRepository->pushCriteria(new RequestCriteria($request));
        $entrevistaIndividualTcs = $this->entrevistaIndividualTcRepository->all();

        return view('entrevista_individual_tcs.index')
            ->with('entrevistaIndividualTcs', $entrevistaIndividualTcs);
    }

    /**
     * Show the form for creating a new entrevista_individual_tc.
     *
     * @return Response
     */
    public function create()
    {
        return view('entrevista_individual_tcs.create');
    }

    /**
     * Store a newly created entrevista_individual_tc in storage.
     *
     * @param Createentrevista_individual_tcRequest $request
     *
     * @return Response
     */
    public function store(Createentrevista_individual_tcRequest $request)
    {
        $input = $request->all();

        $entrevistaIndividualTc = $this->entrevistaIndividualTcRepository->create($input);

        Flash::success('Entrevista Individual Tc saved successfully.');

        return redirect(route('entrevistaIndividualTcs.index'));
    }

    /**
     * Display the specified entrevista_individual_tc.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $entrevistaIndividualTc = $this->entrevistaIndividualTcRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualTc)) {
            Flash::error('Entrevista Individual Tc not found');

            return redirect(route('entrevistaIndividualTcs.index'));
        }

        return view('entrevista_individual_tcs.show')->with('entrevistaIndividualTc', $entrevistaIndividualTc);
    }

    /**
     * Show the form for editing the specified entrevista_individual_tc.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $entrevistaIndividualTc = $this->entrevistaIndividualTcRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualTc)) {
            Flash::error('Entrevista Individual Tc not found');

            return redirect(route('entrevistaIndividualTcs.index'));
        }

        return view('entrevista_individual_tcs.edit')->with('entrevistaIndividualTc', $entrevistaIndividualTc);
    }

    /**
     * Update the specified entrevista_individual_tc in storage.
     *
     * @param  int              $id
     * @param Updateentrevista_individual_tcRequest $request
     *
     * @return Response
     */
    public function update($id, Updateentrevista_individual_tcRequest $request)
    {
        $entrevistaIndividualTc = $this->entrevistaIndividualTcRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualTc)) {
            Flash::error('Entrevista Individual Tc not found');

            return redirect(route('entrevistaIndividualTcs.index'));
        }

        $entrevistaIndividualTc = $this->entrevistaIndividualTcRepository->update($request->all(), $id);

        Flash::success('Entrevista Individual Tc updated successfully.');

        return redirect(route('entrevistaIndividualTcs.index'));
    }

    /**
     * Remove the specified entrevista_individual_tc from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $entrevistaIndividualTc = $this->entrevistaIndividualTcRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualTc)) {
            Flash::error('Entrevista Individual Tc not found');

            return redirect(route('entrevistaIndividualTcs.index'));
        }

        $this->entrevistaIndividualTcRepository->delete($id);

        Flash::success('Entrevista Individual Tc deleted successfully.');

        return redirect(route('entrevistaIndividualTcs.index'));
    }
}
