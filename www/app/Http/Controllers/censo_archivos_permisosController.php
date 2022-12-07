<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createcenso_archivos_permisosRequest;
use App\Http\Requests\Updatecenso_archivos_permisosRequest;
use App\Models\censo_archivos_permisos;
use App\Models\traza_actividad;
use App\Repositories\censo_archivos_permisosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class censo_archivos_permisosController extends AppBaseController
{
    /** @var  censo_archivos_permisosRepository */
    private $censoArchivosPermisosRepository;

    public function __construct(censo_archivos_permisosRepository $censoArchivosPermisosRepo)
    {
        $this->censoArchivosPermisosRepository = $censoArchivosPermisosRepo;
    }

    /**
     * Display a listing of the censo_archivos_permisos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        abort(403);
        $this->censoArchivosPermisosRepository->pushCriteria(new RequestCriteria($request));
        $censoArchivosPermisos = $this->censoArchivosPermisosRepository->all();

        return view('censo_archivos_permisos.index')
            ->with('censoArchivosPermisos', $censoArchivosPermisos);
    }

    /**
     * Show the form for creating a new censo_archivos_permisos.
     *
     * @return Response
     */
    public function create()
    {
        return view('censo_archivos_permisos.create');
    }

    /**
     * Store a newly created censo_archivos_permisos in storage.
     *
     * @param Createcenso_archivos_permisosRequest $request
     *
     * @return Response
     */
    public function store(Createcenso_archivos_permisosRequest $request)
    {
        $input = $request->all();

        try {
            $nuevo = new censo_archivos_permisos();
            $nuevo->fill($input);
            $nuevo->save();
            //Registrar traza
            $entrevista = $nuevo->rel_id_censo_archivos;
            traza_actividad::create(['id_objeto'=>22, 'id_accion'=>3, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$nuevo->id_censo_archivos_permisos]);
            return redirect(action('censo_archivosController@show',$nuevo->id_censo_archivos)."?activar=a");
        }
        catch(\Exception $e) {
            //No pasa nada seguro es un entrevistador duplicado
            return redirect()->back();
        }
    }

    /**
     * Display the specified censo_archivos_permisos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        abort(403);
        $censoArchivosPermisos = $this->censoArchivosPermisosRepository->findWithoutFail($id);

        if (empty($censoArchivosPermisos)) {
            Flash::error('Censo Archivos Permisos not found');

            return redirect(route('censoArchivosPermisos.index'));
        }

        return view('censo_archivos_permisos.show')->with('censoArchivosPermisos', $censoArchivosPermisos);
    }

    /**
     * Show the form for editing the specified censo_archivos_permisos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        abort(403);
        $censoArchivosPermisos = $this->censoArchivosPermisosRepository->findWithoutFail($id);

        if (empty($censoArchivosPermisos)) {
            Flash::error('Censo Archivos Permisos not found');

            return redirect(route('censoArchivosPermisos.index'));
        }

        return view('censo_archivos_permisos.edit')->with('censoArchivosPermisos', $censoArchivosPermisos);
    }

    /**
     * Update the specified censo_archivos_permisos in storage.
     *
     * @param  int              $id
     * @param Updatecenso_archivos_permisosRequest $request
     *
     * @return Response
     */
    public function update($id, Updatecenso_archivos_permisosRequest $request)
    {
        abort(403);
        $censoArchivosPermisos = $this->censoArchivosPermisosRepository->findWithoutFail($id);

        if (empty($censoArchivosPermisos)) {
            Flash::error('Censo Archivos Permisos not found');

            return redirect(route('censoArchivosPermisos.index'));
        }

        $censoArchivosPermisos = $this->censoArchivosPermisosRepository->update($request->all(), $id);

        Flash::success('Censo Archivos Permisos updated successfully.');

        return redirect(route('censoArchivosPermisos.index'));
    }

    /**
     * Remove the specified censo_archivos_permisos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $permiso = censo_archivos_permisos::find($id);

        if (empty($permiso)) {
            Flash::error('Registro no existe');
            return redirect()->back();
        }
        //Registrar traza
        $id_censo_archivos = $permiso->id_censo_archivos;
        $entrevista = $permiso->rel_id_censo_archivos;
        traza_actividad::create(['id_objeto'=>22, 'id_accion'=>10, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$permiso->id_censo_archivos_permisos, 'referencia'=>"id_entrevistador=$permiso->id_entrevistador"]);

        $permiso->delete();

        return redirect(action('censo_archivosController@show',$entrevista->id_censo_archivos)."?activar=a");
    }
}
