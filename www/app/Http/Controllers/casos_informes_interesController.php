<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createcasos_informes_interesRequest;
use App\Http\Requests\Updatecasos_informes_interesRequest;
use App\Repositories\casos_informes_interesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class casos_informes_interesController extends AppBaseController
{
    /** @var  casos_informes_interesRepository */
    private $casosInformesInteresRepository;

    public function __construct(casos_informes_interesRepository $casosInformesInteresRepo)
    {
        $this->casosInformesInteresRepository = $casosInformesInteresRepo;
    }

    /**
     * Display a listing of the casos_informes_interes.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->casosInformesInteresRepository->pushCriteria(new RequestCriteria($request));
        $casosInformesInteres = $this->casosInformesInteresRepository->all();

        return view('casos_informes_interes.index')
            ->with('casosInformesInteres', $casosInformesInteres);
    }

    /**
     * Show the form for creating a new casos_informes_interes.
     *
     * @return Response
     */
    public function create()
    {
        return view('casos_informes_interes.create');
    }

    /**
     * Store a newly created casos_informes_interes in storage.
     *
     * @param Createcasos_informes_interesRequest $request
     *
     * @return Response
     */
    public function store(Createcasos_informes_interesRequest $request)
    {
        $input = $request->all();

        $casosInformesInteres = $this->casosInformesInteresRepository->create($input);

        Flash::success('Casos Informes Interes saved successfully.');

        return redirect(route('casosInformesInteres.index'));
    }

    /**
     * Display the specified casos_informes_interes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $casosInformesInteres = $this->casosInformesInteresRepository->findWithoutFail($id);

        if (empty($casosInformesInteres)) {
            Flash::error('Casos Informes Interes not found');

            return redirect(route('casosInformesInteres.index'));
        }

        return view('casos_informes_interes.show')->with('casosInformesInteres', $casosInformesInteres);
    }

    /**
     * Show the form for editing the specified casos_informes_interes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $casosInformesInteres = $this->casosInformesInteresRepository->findWithoutFail($id);

        if (empty($casosInformesInteres)) {
            Flash::error('Casos Informes Interes not found');

            return redirect(route('casosInformesInteres.index'));
        }

        return view('casos_informes_interes.edit')->with('casosInformesInteres', $casosInformesInteres);
    }

    /**
     * Update the specified casos_informes_interes in storage.
     *
     * @param  int              $id
     * @param Updatecasos_informes_interesRequest $request
     *
     * @return Response
     */
    public function update($id, Updatecasos_informes_interesRequest $request)
    {
        $casosInformesInteres = $this->casosInformesInteresRepository->findWithoutFail($id);

        if (empty($casosInformesInteres)) {
            Flash::error('Casos Informes Interes not found');

            return redirect(route('casosInformesInteres.index'));
        }

        $casosInformesInteres = $this->casosInformesInteresRepository->update($request->all(), $id);

        Flash::success('Casos Informes Interes updated successfully.');

        return redirect(route('casosInformesInteres.index'));
    }

    /**
     * Remove the specified casos_informes_interes from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $casosInformesInteres = $this->casosInformesInteresRepository->findWithoutFail($id);

        if (empty($casosInformesInteres)) {
            Flash::error('Casos Informes Interes not found');

            return redirect(route('casosInformesInteres.index'));
        }

        $this->casosInformesInteresRepository->delete($id);

        Flash::success('Casos Informes Interes deleted successfully.');

        return redirect(route('casosInformesInteres.index'));
    }
}
