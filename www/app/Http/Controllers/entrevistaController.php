<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateentrevistaRequest;
use App\Http\Requests\UpdateentrevistaRequest;
use App\Models\diagnostico_comunitario;
use App\Models\entrevista;
use App\Models\entrevista_colectiva;
use App\Models\entrevista_etnica;
use App\Models\entrevista_individual;
use App\Models\entrevista_profundidad;
use App\Models\entrevistador;
use App\Models\historia_vida;
use App\Models\traza_actividad;
use App\Repositories\entrevistaRepository;
use App\Http\Controllers\AppBaseController;
use App\User;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Log;


class entrevistaController extends AppBaseController
{
    /** @var  entrevistaRepository */
    private $entrevistaRepository;

    public function __construct(entrevistaRepository $entrevistaRepo)
    {
        $this->entrevistaRepository = $entrevistaRepo;
    }

    /**
     * Display a listing of the entrevista.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        if (\Gate::allows('solo-estadistica')) {
            abort(403, "El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $this->entrevistaRepository->pushCriteria(new RequestCriteria($request));
        $entrevistas = $this->entrevistaRepository->all();

        return view('entrevistas.index')
            ->with('entrevistas', $entrevistas);
    }

    /**
     * Show the form for creating a new entrevista.
     *
     * @return Response
     */
    public function create($id)
    {
        if (\Gate::allows('solo-estadistica')) {
            abort(403, "El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $id_entrevistador = \Auth::user()->id_entrevistador;
        // A nombre de otro
        $entrevistaIndividual = entrevista_individual::find($id);

        if (empty($entrevistaIndividual)) {
            Flash::error("Entrevista Individual no existe (c)($id)");
            return redirect(route('entrevistaIndividuals.index'));
        }

        if (isset($entrevistaIndividual->id_entrevistador)) {
            $permitidos = entrevistador::permitidos_acceso_entrevistas();
            if (in_array($entrevistaIndividual->id_entrevistador, $permitidos)) {
                $id_entrevistador = intval($entrevistaIndividual->id_entrevistador);
            } else {
                $quien = entrevistador::find($entrevistaIndividual->id_entrevistador);
                $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador, 5, '0', STR_PAD_LEFT) : "[desconocido]";
                abort(403, "No puede ingresar entrevistas para el entrevistador especificado: $numero");
            }
        }

        $id = $this->validarExistenciaEntrevista($id);
        //Log::info($_REQUEST);
        $entrevista = new entrevista();
        $entrevista->valores_iniciales();

        if (!is_object($id)) {
            $entrevista->id_e_ind_fvt = $id;
        } else {

            //Log::info($id);
        }


        return view('entrevistas.create', compact('entrevista', 'id'));
    }

    public function validarExistenciaEntrevista($id_e_ind_fvt)
    {

        // $id_e_ind_fvt = $id


        $entrevista = entrevista_individual::validarExistenciaEntrevistaEnLaFicha(new entrevista(), $id_e_ind_fvt);
        //Log::info($entrevista);

        if (is_object($entrevista)) {
            $msg = "La entrevista que intenta crear, se encuentra previamente registrada. Se muestra la información a continuación:";
            // return view('entrevistas.show')->with('entrevista', $entrevista);
            return view('entrevistas.show', ['entrevista' => $entrevista, 'msg' => $msg]);

        } else {
            $id = $id_e_ind_fvt;
            // $entrevista=new entrevista();
            // $entrevista->valores_iniciales();
            // return view('entrevistas.create',compact('entrevista','id'));
            return $id;
        }

        return $id;


    }

    /**
     * Store a newly created entrevista in storage.
     *
     * @param CreateentrevistaRequest $request
     *
     * @return Response
     */
    public function store(CreateentrevistaRequest $request)
    {

        if (\Gate::allows('solo-estadistica')) {
            abort(403, "El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $id_entrevistador = \Auth::user()->id_entrevistador;

        $entrevistaIndividual = entrevista_individual::find($request->id_e_ind_fvt);

        if (isset($entrevistaIndividual->id_entrevistador)) {
            $permitidos = entrevistador::permitidos_acceso_entrevistas();
            if (in_array($entrevistaIndividual->id_entrevistador, $permitidos)) {
                $id_entrevistador = intval($entrevistaIndividual->id_entrevistador);
            } else {
                $quien = entrevistador::find($entrevistaIndividual->id_entrevistador);
                $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador, 5, '0', STR_PAD_LEFT) : "[desconocido]";
                abort(403, "No puede ingresar entrevistas para el entrevistador especificado: $numero");
            }
        }

        $input = $request->all();

        $entrevista = $this->entrevistaRepository->create($input);

        $entrevista->almacenar_testigos($request);
        $entrevista->almacenar_acompanamiento($request);


        Flash::success('Entrevista registrada correctamente.');

        traza_actividad::create(['id_objeto' => 101, 'id_accion' => 3, 'codigo' => $entrevista->fmtideindfvt, 'id_primaria' => $entrevista->id_e_ind_fvt]);

        return redirect(route('entrevistaindividual.fichas', [$entrevista->id_e_ind_fvt]));
        // return redirect(route('entrevistas.index'));
    }

    /**
     * Display the specified entrevista.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {

        if (\Gate::allows('solo-estadistica')) {
            abort(403, "El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $entrevista = $this->entrevistaRepository->findWithoutFail($id);

        if (empty($entrevista)) {
            Flash::error("Consentimiento no existe($id)");
            return redirect()->back();
        }

        $expediente = false;
        if ($entrevista->id_e_ind_fvt > 0) {
            $expediente = entrevista_individual::find($entrevista->id_e_ind_fvt);
        }

        if ($entrevista->id_entrevista_colectiva > 0) {
            $expediente = entrevista_colectiva::find($entrevista->id_entrevista_colectiva);
        }
        if ($entrevista->id_entrevista_etnica > 0) {
            $expediente = entrevista_etnica::find($entrevista->id_entrevista_etnica);
        }
        if ($entrevista->id_diagnostico_comunitario > 0) {
            $expediente = diagnostico_comunitario::find($entrevista->id_diagnostico_comunitario);
        }

        if (!$expediente) {
            Flash::error("Entrevista  no identificada");
            return redirect()->back();
        }

        $puede = entrevista_individual::revisar_acceso_adjuntos($expediente);
        if (!$puede) {
            abort(403, "Acceso denegado al consentimiento informado");
        }


        if ($entrevista->id_e_ind_fvt > 0) {
            return view('entrevistas.show')->with('entrevista', $entrevista);
        } elseif ($entrevista->id_entrevista_colectiva > 0) {
            return view('entrevistas.show_co')->with('entrevista', $entrevista);
        } elseif ($entrevista->id_entrevista_etnica > 0) {
            return view('entrevistas.show_ee')->with('entrevista', $entrevista);
        }
        elseif ($entrevista->id_diagnostico_comunitario > 0) {
            return view('entrevistas.show_dc')->with('entrevista', $entrevista);
        }
        else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified entrevista.
     *
     * @param int $id
     *
     * @return Response
     */
    public
    function edit($id)
    {
        $entrevista = $this->entrevistaRepository->findWithoutFail($id);


        if (\Gate::allows('solo-estadistica')) {
            abort(403, "El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $entrevistaIndividual = entrevista_individual::find($entrevista->id_e_ind_fvt);

        if (empty($entrevistaIndividual)) {
            Flash::error('Entrevista Individual no existe(e)');
            return redirect(route('entrevistaIndividuals.index'));
        }
        if (!\Gate::allows('es-propio', $entrevistaIndividual->id_entrevistador)) {
            $this->authorize('escritura');
            $id_entrevistador = $entrevistaIndividual->id_entrevistador;
            $permitidos = entrevistador::permitidos_acceso_entrevistas();
            if (!in_array($id_entrevistador, $permitidos)) {
                $quien = entrevistador::find($entrevistaIndividual->id_entrevistador);
                $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador, 5, '0', STR_PAD_LEFT) : "[desconocido]";
                abort(403, "No puede modificar entrevistas para el entrevistador especificado: $numero");
            }
        }


        if (empty($entrevista)) {
            Flash::error('Entrevista not found');

            return redirect(route('entrevistas.index'));
        }

        return view('entrevistas.edit')->with('entrevista', $entrevista);
    }

    /**
     * Update the specified entrevista in storage.
     *
     * @param int $id
     * @param UpdateentrevistaRequest $request
     *
     * @return Response
     */
    public
    function update($id, UpdateentrevistaRequest $request)
    {
        if (\Gate::allows('solo-estadistica')) {
            abort(403, "El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $entrevista = $this->entrevistaRepository->findWithoutFail($id);

        if (empty($entrevista)) {
            Flash::error('Entrevista not found');

            return redirect(route('entrevistas.index'));
        }

        $entrevista = $this->entrevistaRepository->update($request->all(), $id);
        $entrevista->almacenar_testigos($request);
        $entrevista->almacenar_acompanamiento($request);
        Flash::success('Entrevista actualizada correctamente.');

        traza_actividad::create(['id_objeto' => 101, 'id_accion' => 4, 'codigo' => $entrevista->fmtideindfvt, 'id_primaria' => $entrevista->id_e_ind_fvt]);

        //return redirect(route('entrevistas.index'));
        return redirect(route('entrevistaindividual.fichas', [$entrevista->id_e_ind_fvt]));
    }

    /**
     * Remove the specified entrevista from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public
    function destroy($id)
    {
        abort(500);
        $entrevista = $this->entrevistaRepository->findWithoutFail($id);

        if (empty($entrevista)) {
            Flash::error('Entrevista not found');

            return redirect(route('entrevistas.index'));
        }

        $this->entrevistaRepository->delete($id);

        Flash::success('Entrevista borrada correctamente.');

        return redirect(route('entrevistas.index'));
    }


//Utilizado para el consentimiento informado de  PR y HV
    public
    function crear_actualizar_ci(Request $request)
    {

        if (isset($request->id_entrevista_profundidad)) {
            $campo = "id_entrevista_profundidad";
            $show = action("entrevista_profundidadController@show", $request->id_entrevista_profundidad);
            $entrevista = entrevista_profundidad::find($request->id_entrevista_profundidad);
        } elseif (isset($request->id_historia_vida)) {
            $campo = "id_historia_vida";
            $show = action("historia_vidaController@show", $request->id_historia_vida);
            $entrevista = historia_vida::find($request->id_historia_vida);
        } else {
            Flash::warning("No se especificó entrevista");
            return redirect()->back();
        }

        $entrevista->procesar_consentimiento($request);

        return redirect($show);

    }
}
