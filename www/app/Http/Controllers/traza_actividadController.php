<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createtraza_actividadRequest;
use App\Http\Requests\Updatetraza_actividadRequest;
use App\Models\excel_traza_actividad;
use App\Models\excel_traza_buscadora;
use App\Models\traza_actividad;
use App\Repositories\traza_actividadRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class traza_actividadController extends AppBaseController
{
    /** @var  traza_actividadRepository */
    private $trazaActividadRepository;

    public function __construct(traza_actividadRepository $trazaActividadRepo)
    {
        $this->trazaActividadRepository = $trazaActividadRepo;
    }

    /**
     * Display a listing of the traza_actividad.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->authorize('nivel-1');
        $filtros = traza_actividad::filtros_default($request);
        $query = traza_actividad::filtrar($filtros)->ordenar();
        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();
        //dd($debug);
        $listado = $query->paginate(100);

        $txt_titulo = "Traza de actividad";

        return view('traza_actividads.index')
            ->with('filtros',$filtros)
            ->with('txt_titulo',$txt_titulo)
            ->with('trazaActividads', $listado);
    }

    /**
     * Show the form for creating a new traza_actividad.
     *
     * @return Response
     */
    public function create()
    {
        abort(403);
        return view('traza_actividads.create');
    }

    /**
     * Store a newly created traza_actividad in storage.
     *
     * @param Createtraza_actividadRequest $request
     *
     * @return Response
     */
    public function store(Createtraza_actividadRequest $request)
    {
        abort(403);
        $input = $request->all();

        $trazaActividad = $this->trazaActividadRepository->create($input);

        Flash::success('Traza Actividad saved successfully.');

        return redirect(route('trazaActividads.index'));
    }

    /**
     * Display the specified traza_actividad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        abort(403);
        $trazaActividad = $this->trazaActividadRepository->findWithoutFail($id);

        if (empty($trazaActividad)) {
            Flash::error('Traza Actividad not found');

            return redirect(route('trazaActividads.index'));
        }

        return view('traza_actividads.show')->with('trazaActividad', $trazaActividad);
    }

    /**
     * Show the form for editing the specified traza_actividad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        abort(403);
        $trazaActividad = $this->trazaActividadRepository->findWithoutFail($id);

        if (empty($trazaActividad)) {
            Flash::error('Traza Actividad not found');

            return redirect(route('trazaActividads.index'));
        }

        return view('traza_actividads.edit')->with('trazaActividad', $trazaActividad);
    }

    /**
     * Update the specified traza_actividad in storage.
     *
     * @param  int              $id
     * @param Updatetraza_actividadRequest $request
     *
     * @return Response
     */
    public function update($id, Updatetraza_actividadRequest $request)
    {
        abort(403);
        $trazaActividad = $this->trazaActividadRepository->findWithoutFail($id);

        if (empty($trazaActividad)) {
            Flash::error('Traza Actividad not found');

            return redirect(route('trazaActividads.index'));
        }

        $trazaActividad = $this->trazaActividadRepository->update($request->all(), $id);

        Flash::success('Traza Actividad updated successfully.');

        return redirect(route('trazaActividads.index'));
    }

    /**
     * Remove the specified traza_actividad from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        abort(403);
        $trazaActividad = $this->trazaActividadRepository->findWithoutFail($id);

        if (empty($trazaActividad)) {
            Flash::error('Traza Actividad not found');

            return redirect(route('trazaActividads.index'));
        }

        $this->trazaActividadRepository->delete($id);

        Flash::success('Traza Actividad deleted successfully.');

        return redirect(route('trazaActividads.index'));
    }

    public function actualizar_vista() {
        $respuesta = new \stdClass();
        $respuesta->actividad = excel_traza_actividad::generar_plana();
        $respuesta->buscadora = excel_traza_buscadora::generar_plana();
        return response()->json($respuesta);
    }

}
