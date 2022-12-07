<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createentrevista_individual_aaRequest;
use App\Http\Requests\Updateentrevista_individual_aaRequest;
use App\Repositories\entrevista_individual_aaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class entrevista_individual_aaController extends AppBaseController
{
    /** @var  entrevista_individual_aaRepository */
    private $entrevistaIndividualAaRepository;

    public function __construct(entrevista_individual_aaRepository $entrevistaIndividualAaRepo)
    {
        $this->entrevistaIndividualAaRepository = $entrevistaIndividualAaRepo;
    }

    /**
     * Display a listing of the entrevista_individual_aa.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->entrevistaIndividualAaRepository->pushCriteria(new RequestCriteria($request));
        $entrevistaIndividualAas = $this->entrevistaIndividualAaRepository->all();

        return view('entrevista_individual_aas.index')
            ->with('entrevistaIndividualAas', $entrevistaIndividualAas);
    }

    /**
     * Show the form for creating a new entrevista_individual_aa.
     *
     * @return Response
     */
    public function create()
    {
        return view('entrevista_individual_aas.create');
    }

    /**
     * Store a newly created entrevista_individual_aa in storage.
     *
     * @param Createentrevista_individual_aaRequest $request
     *
     * @return Response
     */
    public function store(Createentrevista_individual_aaRequest $request)
    {
        $input = $request->all();

        $entrevistaIndividualAa = $this->entrevistaIndividualAaRepository->create($input);

        Flash::success('Entrevista Individual Aa saved successfully.');

        return redirect(route('entrevistaIndividualAas.index'));
    }

    /**
     * Display the specified entrevista_individual_aa.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $entrevistaIndividualAa = $this->entrevistaIndividualAaRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualAa)) {
            Flash::error('Entrevista Individual Aa not found');

            return redirect(route('entrevistaIndividualAas.index'));
        }

        return view('entrevista_individual_aas.show')->with('entrevistaIndividualAa', $entrevistaIndividualAa);
    }

    /**
     * Show the form for editing the specified entrevista_individual_aa.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $entrevistaIndividualAa = $this->entrevistaIndividualAaRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualAa)) {
            Flash::error('Entrevista Individual Aa not found');

            return redirect(route('entrevistaIndividualAas.index'));
        }

        return view('entrevista_individual_aas.edit')->with('entrevistaIndividualAa', $entrevistaIndividualAa);
    }

    /**
     * Update the specified entrevista_individual_aa in storage.
     *
     * @param  int              $id
     * @param Updateentrevista_individual_aaRequest $request
     *
     * @return Response
     */
    public function update($id, Updateentrevista_individual_aaRequest $request)
    {
        $entrevistaIndividualAa = $this->entrevistaIndividualAaRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualAa)) {
            Flash::error('Entrevista Individual Aa not found');

            return redirect(route('entrevistaIndividualAas.index'));
        }

        $entrevistaIndividualAa = $this->entrevistaIndividualAaRepository->update($request->all(), $id);

        Flash::success('Entrevista Individual Aa updated successfully.');

        return redirect(route('entrevistaIndividualAas.index'));
    }

    /**
     * Remove the specified entrevista_individual_aa from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $entrevistaIndividualAa = $this->entrevistaIndividualAaRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualAa)) {
            Flash::error('Entrevista Individual Aa not found');

            return redirect(route('entrevistaIndividualAas.index'));
        }

        $this->entrevistaIndividualAaRepository->delete($id);

        Flash::success('Entrevista Individual Aa deleted successfully.');

        return redirect(route('entrevistaIndividualAas.index'));
    }
}
