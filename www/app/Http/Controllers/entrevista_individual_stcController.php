<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createentrevista_individual_stcRequest;
use App\Http\Requests\Updateentrevista_individual_stcRequest;
use App\Repositories\entrevista_individual_stcRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class entrevista_individual_stcController extends AppBaseController
{
    /** @var  entrevista_individual_stcRepository */
    private $entrevistaIndividualStcRepository;

    public function __construct(entrevista_individual_stcRepository $entrevistaIndividualStcRepo)
    {
        $this->entrevistaIndividualStcRepository = $entrevistaIndividualStcRepo;
    }

    /**
     * Display a listing of the entrevista_individual_stc.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->entrevistaIndividualStcRepository->pushCriteria(new RequestCriteria($request));
        $entrevistaIndividualStcs = $this->entrevistaIndividualStcRepository->all();

        return view('entrevista_individual_stcs.index')
            ->with('entrevistaIndividualStcs', $entrevistaIndividualStcs);
    }

    /**
     * Show the form for creating a new entrevista_individual_stc.
     *
     * @return Response
     */
    public function create()
    {
        return view('entrevista_individual_stcs.create');
    }

    /**
     * Store a newly created entrevista_individual_stc in storage.
     *
     * @param Createentrevista_individual_stcRequest $request
     *
     * @return Response
     */
    public function store(Createentrevista_individual_stcRequest $request)
    {
        $input = $request->all();

        $entrevistaIndividualStc = $this->entrevistaIndividualStcRepository->create($input);

        Flash::success('Entrevista Individual Stc saved successfully.');

        return redirect(route('entrevistaIndividualStcs.index'));
    }

    /**
     * Display the specified entrevista_individual_stc.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $entrevistaIndividualStc = $this->entrevistaIndividualStcRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualStc)) {
            Flash::error('Entrevista Individual Stc not found');

            return redirect(route('entrevistaIndividualStcs.index'));
        }

        return view('entrevista_individual_stcs.show')->with('entrevistaIndividualStc', $entrevistaIndividualStc);
    }

    /**
     * Show the form for editing the specified entrevista_individual_stc.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $entrevistaIndividualStc = $this->entrevistaIndividualStcRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualStc)) {
            Flash::error('Entrevista Individual Stc not found');

            return redirect(route('entrevistaIndividualStcs.index'));
        }

        return view('entrevista_individual_stcs.edit')->with('entrevistaIndividualStc', $entrevistaIndividualStc);
    }

    /**
     * Update the specified entrevista_individual_stc in storage.
     *
     * @param  int              $id
     * @param Updateentrevista_individual_stcRequest $request
     *
     * @return Response
     */
    public function update($id, Updateentrevista_individual_stcRequest $request)
    {
        $entrevistaIndividualStc = $this->entrevistaIndividualStcRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualStc)) {
            Flash::error('Entrevista Individual Stc not found');

            return redirect(route('entrevistaIndividualStcs.index'));
        }

        $entrevistaIndividualStc = $this->entrevistaIndividualStcRepository->update($request->all(), $id);

        Flash::success('Entrevista Individual Stc updated successfully.');

        return redirect(route('entrevistaIndividualStcs.index'));
    }

    /**
     * Remove the specified entrevista_individual_stc from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $entrevistaIndividualStc = $this->entrevistaIndividualStcRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualStc)) {
            Flash::error('Entrevista Individual Stc not found');

            return redirect(route('entrevistaIndividualStcs.index'));
        }

        $this->entrevistaIndividualStcRepository->delete($id);

        Flash::success('Entrevista Individual Stc deleted successfully.');

        return redirect(route('entrevistaIndividualStcs.index'));
    }
}
