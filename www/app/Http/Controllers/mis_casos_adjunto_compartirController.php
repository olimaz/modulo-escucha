<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createmis_casos_adjunto_compartirRequest;
use App\Http\Requests\Updatemis_casos_adjunto_compartirRequest;
use App\Models\traza_actividad;
use App\Repositories\mis_casos_adjunto_compartirRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class mis_casos_adjunto_compartirController extends AppBaseController
{
    /** @var  mis_casos_adjunto_compartirRepository */
    private $misCasosAdjuntoCompartirRepository;

    public function __construct(mis_casos_adjunto_compartirRepository $misCasosAdjuntoCompartirRepo)
    {
        $this->misCasosAdjuntoCompartirRepository = $misCasosAdjuntoCompartirRepo;
    }

    /**
     * Display a listing of the mis_casos_adjunto_compartir.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return redirect()->back();
        $this->misCasosAdjuntoCompartirRepository->pushCriteria(new RequestCriteria($request));
        $misCasosAdjuntoCompartirs = $this->misCasosAdjuntoCompartirRepository->all();

        return view('mis_casos_adjunto_compartirs.index')
            ->with('misCasosAdjuntoCompartirs', $misCasosAdjuntoCompartirs);
    }

    /**
     * Show the form for creating a new mis_casos_adjunto_compartir.
     *
     * @return Response
     */
    public function create()
    {
        return redirect()->back();
        return view('mis_casos_adjunto_compartirs.create');
    }

    /**
     * Store a newly created mis_casos_adjunto_compartir in storage.
     *
     * @param Createmis_casos_adjunto_compartirRequest $request
     *
     * @return Response
     */
    public function store(Createmis_casos_adjunto_compartirRequest $request)
    {
        $input = $request->all();
        $input['id_autorizador']=\Auth::user()->id_entrevistador;

        $misCasosAdjuntoCompartir = $this->misCasosAdjuntoCompartirRepository->create($input);
        Flash::success('Autorización registrada.');

        $compartido =  $misCasosAdjuntoCompartir->rel_id_mis_casos_adjunto;
        $caso = $compartido->rel_id_mis_casos;
        traza_actividad::create(['id_objeto'=>20, 'id_accion'=>9, 'codigo'=>$caso->entrevista_codigo, 'id_primaria'=>$misCasosAdjuntoCompartir->id_mis_casos_adjunto_compartir, 'referencia'=>"id_adjunto=$compartido->id_adjunto. $compartido->descripcion"]);

        return redirect()->back();
    }

    /**
     * Display the specified mis_casos_adjunto_compartir.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return redirect()->back();
        $misCasosAdjuntoCompartir = $this->misCasosAdjuntoCompartirRepository->findWithoutFail($id);

        if (empty($misCasosAdjuntoCompartir)) {
            Flash::error('Mis Casos Adjunto Compartir not found');

            return redirect(route('misCasosAdjuntoCompartirs.index'));
        }

        return view('mis_casos_adjunto_compartirs.show')->with('misCasosAdjuntoCompartir', $misCasosAdjuntoCompartir);
    }

    /**
     * Show the form for editing the specified mis_casos_adjunto_compartir.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        return redirect()->back();
        $misCasosAdjuntoCompartir = $this->misCasosAdjuntoCompartirRepository->findWithoutFail($id);

        if (empty($misCasosAdjuntoCompartir)) {
            Flash::error('Mis Casos Adjunto Compartir not found');

            return redirect(route('misCasosAdjuntoCompartirs.index'));
        }

        return view('mis_casos_adjunto_compartirs.edit')->with('misCasosAdjuntoCompartir', $misCasosAdjuntoCompartir);
    }

    /**
     * Update the specified mis_casos_adjunto_compartir in storage.
     *
     * @param  int              $id
     * @param Updatemis_casos_adjunto_compartirRequest $request
     *
     * @return Response
     */
    public function update($id, Updatemis_casos_adjunto_compartirRequest $request)
    {
        return redirect()->back();
        $misCasosAdjuntoCompartir = $this->misCasosAdjuntoCompartirRepository->findWithoutFail($id);

        if (empty($misCasosAdjuntoCompartir)) {
            Flash::error('Mis Casos Adjunto Compartir not found');

            return redirect(route('misCasosAdjuntoCompartirs.index'));
        }

        $misCasosAdjuntoCompartir = $this->misCasosAdjuntoCompartirRepository->update($request->all(), $id);

        Flash::success('Mis Casos Adjunto Compartir updated successfully.');

        return redirect(route('misCasosAdjuntoCompartirs.index'));
    }

    /**
     * Remove the specified mis_casos_adjunto_compartir from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $misCasosAdjuntoCompartir = $this->misCasosAdjuntoCompartirRepository->findWithoutFail($id);

        if (empty($misCasosAdjuntoCompartir)) {
            Flash::error('Autorización no encontrada');
            return redirect()->back();
        }
        $misCasosAdjuntoCompartir->id_situacion=2;
        $misCasosAdjuntoCompartir->fh_revocado=Carbon::now();
        $misCasosAdjuntoCompartir->save();
        Flash::success('Acceso revocado.');

        $compartido =  $misCasosAdjuntoCompartir->rel_id_mis_casos_adjunto;
        $caso = $compartido->rel_id_mis_casos;
        traza_actividad::create(['id_objeto'=>20, 'id_accion'=>24, 'codigo'=>$caso->entrevista_codigo, 'id_primaria'=>$misCasosAdjuntoCompartir->id_mis_casos_adjunto_compartir, 'referencia'=>"id_adjunto=$compartido->id_adjunto. $compartido->descripcion"]);
        return redirect()->back();
    }
}
