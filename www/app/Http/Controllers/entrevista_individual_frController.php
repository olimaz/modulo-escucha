<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createentrevista_individual_frRequest;
use App\Http\Requests\Updateentrevista_individual_frRequest;
use App\Repositories\entrevista_individual_frRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class entrevista_individual_frController extends AppBaseController
{
    /** @var  entrevista_individual_frRepository */
    private $entrevistaIndividualFrRepository;

    public function __construct(entrevista_individual_frRepository $entrevistaIndividualFrRepo)
    {
        $this->entrevistaIndividualFrRepository = $entrevistaIndividualFrRepo;
    }

    /**
     * Display a listing of the entrevista_individual_fr.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->entrevistaIndividualFrRepository->pushCriteria(new RequestCriteria($request));
        $entrevistaIndividualFrs = $this->entrevistaIndividualFrRepository->all();

        return view('entrevista_individual_frs.index')
            ->with('entrevistaIndividualFrs', $entrevistaIndividualFrs);
    }

    /**
     * Show the form for creating a new entrevista_individual_fr.
     *
     * @return Response
     */
    public function create()
    {
        return view('entrevista_individual_frs.create');
    }

    /**
     * Store a newly created entrevista_individual_fr in storage.
     *
     * @param Createentrevista_individual_frRequest $request
     *
     * @return Response
     */
    public function store(Createentrevista_individual_frRequest $request)
    {
        $input = $request->all();

        $entrevistaIndividualFr = $this->entrevistaIndividualFrRepository->create($input);

        Flash::success('Entrevista Individual Fr saved successfully.');

        return redirect(route('entrevistaIndividualFrs.index'));
    }

    /**
     * Display the specified entrevista_individual_fr.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $entrevistaIndividualFr = $this->entrevistaIndividualFrRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualFr)) {
            Flash::error('Entrevista Individual Fr not found');

            return redirect(route('entrevistaIndividualFrs.index'));
        }

        return view('entrevista_individual_frs.show')->with('entrevistaIndividualFr', $entrevistaIndividualFr);
    }

    /**
     * Show the form for editing the specified entrevista_individual_fr.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $entrevistaIndividualFr = $this->entrevistaIndividualFrRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualFr)) {
            Flash::error('Entrevista Individual Fr not found');

            return redirect(route('entrevistaIndividualFrs.index'));
        }

        return view('entrevista_individual_frs.edit')->with('entrevistaIndividualFr', $entrevistaIndividualFr);
    }

    /**
     * Update the specified entrevista_individual_fr in storage.
     *
     * @param  int              $id
     * @param Updateentrevista_individual_frRequest $request
     *
     * @return Response
     */
    public function update($id, Updateentrevista_individual_frRequest $request)
    {
        $entrevistaIndividualFr = $this->entrevistaIndividualFrRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualFr)) {
            Flash::error('Entrevista Individual Fr not found');

            return redirect(route('entrevistaIndividualFrs.index'));
        }

        $entrevistaIndividualFr = $this->entrevistaIndividualFrRepository->update($request->all(), $id);

        Flash::success('Entrevista Individual Fr updated successfully.');

        return redirect(route('entrevistaIndividualFrs.index'));
    }

    /**
     * Remove the specified entrevista_individual_fr from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $entrevistaIndividualFr = $this->entrevistaIndividualFrRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualFr)) {
            Flash::error('Entrevista Individual Fr not found');

            return redirect(route('entrevistaIndividualFrs.index'));
        }

        $this->entrevistaIndividualFrRepository->delete($id);

        Flash::success('Entrevista Individual Fr deleted successfully.');

        return redirect(route('entrevistaIndividualFrs.index'));
    }
}
