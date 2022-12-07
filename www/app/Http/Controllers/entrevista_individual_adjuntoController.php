<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createentrevista_individual_adjuntoRequest;
use App\Http\Requests\Updateentrevista_individual_adjuntoRequest;
use App\Models\casos_informes;
use App\Models\entrevista_individual;
use App\Models\entrevista_individual_adjunto;
use App\Models\traza_actividad;
use App\Repositories\entrevista_individual_adjuntoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class entrevista_individual_adjuntoController extends AppBaseController
{
    /** @var  entrevista_individual_adjuntoRepository */
    private $entrevistaIndividualAdjuntoRepository;

    public function __construct(entrevista_individual_adjuntoRepository $entrevistaIndividualAdjuntoRepo)
    {
        $this->entrevistaIndividualAdjuntoRepository = $entrevistaIndividualAdjuntoRepo;
    }

    /**
     * Display a listing of the entrevista_individual_adjunto.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->entrevistaIndividualAdjuntoRepository->pushCriteria(new RequestCriteria($request));
        $entrevistaIndividualAdjuntos = $this->entrevistaIndividualAdjuntoRepository->all();

        return view('entrevista_individual_adjuntos.index')
            ->with('entrevistaIndividualAdjuntos', $entrevistaIndividualAdjuntos);
    }

    /**
     * Show the form for creating a new entrevista_individual_adjunto.
     *
     * @return Response
     */
    public function create()
    {
        return view('entrevista_individual_adjuntos.create');
    }

    /**
     * Store a newly created entrevista_individual_adjunto in storage.
     *
     * @param Createentrevista_individual_adjuntoRequest $request
     *
     * @return Response
     */
    public function store(Createentrevista_individual_adjuntoRequest $request)
    {
        $input = $request->all();

        $entrevistaIndividualAdjunto = $this->entrevistaIndividualAdjuntoRepository->create($input);

        Flash::success('Entrevista Individual Adjunto saved successfully.');

        return redirect(route('entrevistaIndividualAdjuntos.index'));
    }

    /**
     * Display the specified entrevista_individual_adjunto.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $entrevistaIndividualAdjunto = $this->entrevistaIndividualAdjuntoRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualAdjunto)) {
            Flash::error('Entrevista Individual Adjunto not found');

            return redirect(route('entrevistaIndividualAdjuntos.index'));
        }

        return view('entrevista_individual_adjuntos.show')->with('entrevistaIndividualAdjunto', $entrevistaIndividualAdjunto);
    }

    /**
     * Show the form for editing the specified entrevista_individual_adjunto.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $entrevistaIndividualAdjunto = $this->entrevistaIndividualAdjuntoRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualAdjunto)) {
            Flash::error('Entrevista Individual Adjunto not found');

            return redirect(route('entrevistaIndividualAdjuntos.index'));
        }

        return view('entrevista_individual_adjuntos.edit')->with('entrevistaIndividualAdjunto', $entrevistaIndividualAdjunto);
    }

    /**
     * Update the specified entrevista_individual_adjunto in storage.
     *
     * @param  int              $id
     * @param Updateentrevista_individual_adjuntoRequest $request
     *
     * @return Response
     */
    public function update($id, Updateentrevista_individual_adjuntoRequest $request)
    {
        $entrevistaIndividualAdjunto = $this->entrevistaIndividualAdjuntoRepository->findWithoutFail($id);

        if (empty($entrevistaIndividualAdjunto)) {
            Flash::error('Entrevista Individual Adjunto not found');

            return redirect(route('entrevistaIndividualAdjuntos.index'));
        }

        $entrevistaIndividualAdjunto = $this->entrevistaIndividualAdjuntoRepository->update($request->all(), $id);

        Flash::success('Entrevista Individual Adjunto updated successfully.');

        return redirect(route('entrevistaIndividualAdjuntos.index'));
    }

    /**
     * Remove the specified entrevista_individual_adjunto from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $entrevistaIndividualAdjunto = $this->entrevistaIndividualAdjuntoRepository->findWithoutFail($id);
        $id_entrevista = $entrevistaIndividualAdjunto->id_e_ind_fvt;
        $id_adjunto = $entrevistaIndividualAdjunto->id_adjunto;

        if (empty($entrevistaIndividualAdjunto)) {
            Flash::error('Entrevista Individual Adjunto not found');

            return redirect(route('entrevistaIndividualAdjuntos.index'));
        }

        $this->entrevistaIndividualAdjuntoRepository->delete($id);

        Flash::success('Archivo adjunto eliminado.');
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>10, 'codigo'=>entrevista_individual::find($id_entrevista)->entrevista_codigo, 'id_primaria'=>$id_adjunto,'referencia'=>"id_entrevista:$id_entrevista"]);
        return redirect()->back();
        //return redirect(action('entrevista_individualController@gestionar_adjuntos',$id_entrevista));
    }

    //envía a cola de transcripción
    public function trans($id) {
        $cual=entrevista_individual_adjunto::find($id);
        $respuesta = $cual->transcribir();
        return response()->json($respuesta);
    }
    //Revisa la cola de transcripcion
    public function trans_revisar($id) {
        $cual=entrevista_individual_adjunto::find($id);
        $respuesta = $cual->transcribir_revisar();
        return response()->json($respuesta);
    }
    public function quitar(Request $request)
    {
        $id=$request->id;
        $entrevista_adjunto = entrevista_individual_adjunto::find($id);
        if (empty($entrevista_adjunto)) {
            Flash::error('Adjunto no existe');
            return redirect(action('entrevista_individualController@index'));
        }
        $id_entrevista = $entrevista_adjunto->id_e_ind_fvt;
        $id_adjunto    = $entrevista_adjunto->id_adjunto;

        $entrevista_adjunto->delete();

        Flash::success('Archivo adjunto eliminado.');
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>10, 'codigo'=>entrevista_individual::find($id_entrevista)->entrevista_codigo, 'id_primaria'=>$id_adjunto,'referencia'=>"id_entrevista:$id_entrevista"]);

        $respuesta=true;
        return response()->json($respuesta);

    }
}
