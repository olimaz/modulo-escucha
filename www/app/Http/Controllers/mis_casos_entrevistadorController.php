<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createmis_casos_entrevistadorRequest;
use App\Http\Requests\Updatemis_casos_entrevistadorRequest;
use App\Models\traza_actividad;
use App\Repositories\mis_casos_entrevistadorRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class mis_casos_entrevistadorController extends AppBaseController
{
    /** @var  mis_casos_entrevistadorRepository */
    private $misCasosEntrevistadorRepository;

    public function __construct(mis_casos_entrevistadorRepository $misCasosEntrevistadorRepo)
    {
        $this->misCasosEntrevistadorRepository = $misCasosEntrevistadorRepo;
    }

    /**
     * Display a listing of the mis_casos_entrevistador.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->misCasosEntrevistadorRepository->pushCriteria(new RequestCriteria($request));
        $misCasosEntrevistadors = $this->misCasosEntrevistadorRepository->all();

        return view('mis_casos_entrevistadors.index')
            ->with('misCasosEntrevistadors', $misCasosEntrevistadors);
    }

    /**
     * Show the form for creating a new mis_casos_entrevistador.
     *
     * @return Response
     */
    public function create()
    {
        return view('mis_casos_entrevistadors.create');
    }

    /**
     * Store a newly created mis_casos_entrevistador in storage.
     *
     * @param Createmis_casos_entrevistadorRequest $request
     *
     * @return Response
     */
    public function store(Createmis_casos_entrevistadorRequest $request)
    {
        $input = $request->all();

        try {
            $misCasosEntrevistador = $this->misCasosEntrevistadorRepository->create($input);
            //Registrar traza
            $entrevista = $misCasosEntrevistador->rel_id_mis_casos;
            traza_actividad::create(['id_objeto'=>21, 'id_accion'=>3, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$misCasosEntrevistador->id_mis_casos_entrevistador]);
            return redirect(action('mis_casosController@show',$misCasosEntrevistador->id_mis_casos)."?activar=a");
        }
        catch(\Exception $e) {
            //No pasa nada seguro es un entrevistador duplicado
            return redirect()->back();
        }

    }

    /**
     * Display the specified mis_casos_entrevistador.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $misCasosEntrevistador = $this->misCasosEntrevistadorRepository->findWithoutFail($id);

        if (empty($misCasosEntrevistador)) {
            Flash::error('Mis Casos Entrevistador not found');

            return redirect(route('misCasosEntrevistadors.index'));
        }

        return view('mis_casos_entrevistadors.show')->with('misCasosEntrevistador', $misCasosEntrevistador);
    }

    /**
     * Show the form for editing the specified mis_casos_entrevistador.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        abort(403);
        $misCasosEntrevistador = $this->misCasosEntrevistadorRepository->findWithoutFail($id);

        if (empty($misCasosEntrevistador)) {
            Flash::error('Mis Casos Entrevistador not found');

            return redirect(route('misCasosEntrevistadors.index'));
        }

        return view('mis_casos_entrevistadors.edit')->with('misCasosEntrevistador', $misCasosEntrevistador);
    }

    /**
     * Update the specified mis_casos_entrevistador in storage.
     *
     * @param  int              $id
     * @param Updatemis_casos_entrevistadorRequest $request
     *
     * @return Response
     */
    public function update($id, Updatemis_casos_entrevistadorRequest $request)
    {
        abort(403);
        $misCasosEntrevistador = $this->misCasosEntrevistadorRepository->findWithoutFail($id);

        if (empty($misCasosEntrevistador)) {
            Flash::error('Mis Casos Entrevistador not found');

            return redirect(route('misCasosEntrevistadors.index'));
        }

        $misCasosEntrevistador = $this->misCasosEntrevistadorRepository->update($request->all(), $id);

        Flash::success('Mis Casos Entrevistador updated successfully.');

        return redirect(route('misCasosEntrevistadors.index'));
    }

    /**
     * Remove the specified mis_casos_entrevistador from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {

        $misCasosEntrevistador = $this->misCasosEntrevistadorRepository->findWithoutFail($id);

        if (empty($misCasosEntrevistador)) {
            Flash::error('Registro no existe');
            return redirect()->back();
        }
        $id_mis_casos = $misCasosEntrevistador->id_mis_casos;
        //Registrar traza
        $entrevista = $misCasosEntrevistador->rel_id_mis_casos;
        traza_actividad::create(['id_objeto'=>21, 'id_accion'=>10, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$misCasosEntrevistador->id_mis_casos, 'referencia'=>"id_entrevistador=$misCasosEntrevistador->id_entrevistador"]);

        $this->misCasosEntrevistadorRepository->delete($id);

        return redirect(action('mis_casosController@show',$id_mis_casos)."?activar=a");
    }
}
