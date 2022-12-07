<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createentrevista_individual_tvRequest;
use App\Http\Requests\Updateentrevista_individual_tvRequest;
use App\Repositories\entrevista_individual_tvRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class entrevista_individual_tvController extends AppBaseController
{
    /** @var  entrevista_individual_tvRepository */
    private $entrevistaIndividualTvRepository;

    public function __construct(entrevista_individual_tvRepository $entrevistaIndividualTvRepo)
    {
        $this->entrevistaIndividualTvRepository = $entrevistaIndividualTvRepo;
    }

    /**
     * Display a listing of the entrevista_individual_tv.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->entrevistaIndividualTvRepository->pushCriteria(new RequestCriteria($request));
        $entrevistaIndividualTvs = $this->entrevistaIndividualTvRepository->all();

        return view('entrevista_individual_tvs.index')
            ->with('entrevistaIndividualTvs', $entrevistaIndividualTvs);
    }

    /**
     * Show the form for creating a new entrevista_individual_tv.
     *
     * @return Response
     */
    public function create()
    {
        return view('entrevista_individual_tvs.create');
    }

    /**
     * Store a newly created entrevista_individual_tv in storage.
     *
     * @param Createentrevista_individual_tvRequest $request
     *
     * @return Response
     */
    public function store(Createentrevista_individual_tvRequest $request)
    {
        $input = $request->all();

        $entrevistaIndividualTv = $this->entrevistaIndividualTvRepository->create($input);

        Flash::success('Entrevista Individual Tv saved successfully.');

        return redirect(route('entrevistaIndividualTvs.index'));
    }

    /**
     * Display the specified entrevista_individual_tv.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $entrevistaIndividualTv = $this->entrevistaIndividualTvRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualTv)) {
            Flash::error('Entrevista Individual Tv not found');

            return redirect(route('entrevistaIndividualTvs.index'));
        }

        return view('entrevista_individual_tvs.show')->with('entrevistaIndividualTv', $entrevistaIndividualTv);
    }

    /**
     * Show the form for editing the specified entrevista_individual_tv.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $entrevistaIndividualTv = $this->entrevistaIndividualTvRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualTv)) {
            Flash::error('Entrevista Individual Tv not found');

            return redirect(route('entrevistaIndividualTvs.index'));
        }

        return view('entrevista_individual_tvs.edit')->with('entrevistaIndividualTv', $entrevistaIndividualTv);
    }

    /**
     * Update the specified entrevista_individual_tv in storage.
     *
     * @param  int              $id
     * @param Updateentrevista_individual_tvRequest $request
     *
     * @return Response
     */
    public function update($id, Updateentrevista_individual_tvRequest $request)
    {
        $entrevistaIndividualTv = $this->entrevistaIndividualTvRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualTv)) {
            Flash::error('Entrevista Individual Tv not found');

            return redirect(route('entrevistaIndividualTvs.index'));
        }

        $entrevistaIndividualTv = $this->entrevistaIndividualTvRepository->update($request->all(), $id);

        Flash::success('Entrevista Individual Tv updated successfully.');

        return redirect(route('entrevistaIndividualTvs.index'));
    }

    /**
     * Remove the specified entrevista_individual_tv from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $entrevistaIndividualTv = $this->entrevistaIndividualTvRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualTv)) {
            Flash::error('Entrevista Individual Tv not found');

            return redirect(route('entrevistaIndividualTvs.index'));
        }

        $this->entrevistaIndividualTvRepository->delete($id);

        Flash::success('Entrevista Individual Tv deleted successfully.');

        return redirect(route('entrevistaIndividualTvs.index'));
    }
}
