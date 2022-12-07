<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createacceso_edicionRequest;
use App\Http\Requests\Updateacceso_edicionRequest;
use App\Models\acceso_edicion;
use App\Models\entrevistador;
use App\Models\transcribir_asignacion;
use App\Models\traza_actividad;
use App\Repositories\acceso_edicionRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class acceso_edicionController extends AppBaseController
{
    /** @var  acceso_edicionRepository */
    private $accesoEdicionRepository;

    public function __construct(acceso_edicionRepository $accesoEdicionRepo)
    {
        $this->accesoEdicionRepository = $accesoEdicionRepo;
    }

    /**
     * Display a listing of the acceso_edicion.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = acceso_edicion::filtros_default($request);
        $accesoEdicions = acceso_edicion::filtrar($filtros)->ordenar()->paginate();

        return view('acceso_edicions.index')
            ->with('filtros', $filtros)
            ->with('accesoEdicions', $accesoEdicions);
    }

    /**
     * Show the form for creating a new acceso_edicion.
     *
     * @return Response
     */
    public function create(Request $request)
    {


        if(isset($request->id_subserie)) {
            $id_subserie = $request->id_subserie;
        }
        else {
            Flash::error('Debe especificar el tipo de entrevista');
            return redirect()->back();
        }
        if(isset($request->id_entrevista)) {
            $id_entrevista = $request->id_entrevista;
        }
        else {
            Flash::error('Debe especificar el identificador de entrevista');
            return redirect()->back();
        }

        $asignacion = new acceso_edicion();
        $asignacion->id_subserie=$id_subserie;
        $asignacion->id_entrevista=$id_entrevista;
        $asignacion->id_autoriza = \Auth::user()->id_entrevistador;



        if(!$asignacion->codigo_entrevista) {
            Flash::error("Entrevista indicada, no existe ($id_subserie, $id_entrevista)");
            return redirect()->back();
        }
        if(!$asignacion->puede_conceder_acceso) {
            Flash::error("No puede otorgar privilegios a la entrevista $asignacion->codigo_entrevista");
            return redirect()->back();
        }



        return view('acceso_edicions.create', compact('asignacion'));
    }

    /**
     * Store a newly created acceso_edicion in storage.
     *
     * @param Createacceso_edicionRequest $request
     *
     * @return Response
     */
    public function store(Createacceso_edicionRequest $request)
    {
        $input = $request->all();
        $asignacion = new acceso_edicion();
        $asignacion->id_subserie=$request->id_subserie;
        $asignacion->id_entrevista=$request->id_entrevista;
        $asignacion->id_autoriza = \Auth::user()->id_entrevistador;
        $asignacion->id_autorizado = $request->id_autorizado;
        $asignacion->id_autorizado = $request->id_autorizado;
        $asignacion->observaciones = $request->observaciones;
        $asignacion->fh_autorizado = Carbon::now();
        $asignacion->save();

        //Traza de actividad
        try {
            $e = $asignacion->entrevista;
            $id_objeto   = traza_actividad::de_subserie_a_traza($asignacion->id_subserie);
            $id_primaria = $asignacion->id_entrevista;
            $referencia = $asignacion->fmt_id_autorizado;
            traza_actividad::create(['id_objeto'=>$id_objeto, 'id_accion'=>27, 'codigo'=>$e->entrevista_codigo, 'referencia'=>$referencia , 'id_primaria'=>$id_primaria]);
        }
        catch(\Exception $e) {
            Log::error("Problemas al registrar la traza de compartir".PHP_EOL.json_encode($asignacion));
        }


        //$accesoEdicion = $this->accesoEdicionRepository->create($input);

        Flash::success('Acceso otorgado');

        return redirect(route('accesoEdicions.index'));
    }

    /**
     * Display the specified acceso_edicion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        abort(403);
        $accesoEdicion = $this->accesoEdicionRepository->findWithoutFail($id);

        if (empty($accesoEdicion)) {
            Flash::error('Acceso Edicion not found');

            return redirect(route('accesoEdicions.index'));
        }

        return view('acceso_edicions.show')->with('accesoEdicion', $accesoEdicion);
    }

    /**
     * Show the form for editing the specified acceso_edicion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        abort(403);
        $accesoEdicion = $this->accesoEdicionRepository->findWithoutFail($id);

        if (empty($accesoEdicion)) {
            Flash::error('Acceso Edicion not found');

            return redirect(route('accesoEdicions.index'));
        }

        return view('acceso_edicions.edit')->with('accesoEdicion', $accesoEdicion);
    }

    /**
     * Update the specified acceso_edicion in storage.
     *
     * @param  int              $id
     * @param Updateacceso_edicionRequest $request
     *
     * @return Response
     */
    public function update($id, Updateacceso_edicionRequest $request)
    {
        abort(403);
        $accesoEdicion = $this->accesoEdicionRepository->findWithoutFail($id);

        if (empty($accesoEdicion)) {
            Flash::error('Acceso Edicion not found');
            return redirect(route('accesoEdicions.index'));
        }

        $accesoEdicion = $this->accesoEdicionRepository->update($request->all(), $id);



        Flash::success('Acceso Edicion updated successfully.');

        return redirect(route('accesoEdicions.index'));
    }

    /**
     * Remove the specified acceso_edicion from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $accesoEdicion = $this->accesoEdicionRepository->findWithoutFail($id);

        if (empty($accesoEdicion)) {
            Flash::error('Acceso no encontrado');
            return redirect(route('accesoEdicions.index'));
        }


        if(!$accesoEdicion->puede_conceder_acceso) {
            Flash::error("No puede otorgar privilegios a la entrevista $asignacion->codigo_entrevista");
            return redirect()->back();
        }

        $accesoEdicion->id_revocado = \Auth::user()->id_entrevistador;
        $accesoEdicion->id_situacion = 2;
        $accesoEdicion->fh_revocado = Carbon::now();
        $accesoEdicion->save();

        //Traza de actividad
        try {
            $asignacion = $accesoEdicion;
            $e = $asignacion->entrevista;
            $id_objeto   = traza_actividad::de_subserie_a_traza($asignacion->id_subserie);
            $id_primaria = $asignacion->id_entrevista;
            $referencia = $asignacion->fmt_id_autorizado;
            traza_actividad::create(['id_objeto'=>$id_objeto, 'id_accion'=>28, 'codigo'=>$e->entrevista_codigo, 'referencia'=>$referencia , 'id_primaria'=>$id_primaria]);
        }
        catch(\Exception $e) {
            Log::error("Problemas al registrar la traza de compartir".PHP_EOL.json_encode($asignacion));
        }


        //Flash::success('Acceso Edicion deleted successfully.');

        return redirect(route('accesoEdicions.index'));
    }
}
