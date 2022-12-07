<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepersonaRequest;
use App\Http\Requests\UpdatepersonaRequest;
use App\Repositories\personaRepository;
use App\Http\Controllers\AppBaseController;
use App\Interfaces\EntrevistaRol;
use App\Models\entrevista_individual;
use App\Models\persona;
use App\Models\victima;
use App\Models\victima_duplicada;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\entrevistador;
use App\Models\traza_actividad;

use Illuminate\Support\Facades\Auth;

class victimaController extends Controller
{
    private $personaRepository;
    private $vista = 'victimas';

    public function __construct(personaRepository $personaRepo)
    {
        $this->personaRepository = $personaRepo;
    }

    /**
     * Display a listing of the persona.
     *
     * @param Request $request
     * @return Response
     */

    public function index(Request $request)
    {
        // $this->personaRepository->pushCriteria(new RequestCriteria($request));
        // $personas = $this->personaRepository->all();

        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $personas = persona::victimas();

        //$personas_duplicadas = $this->personas_vinculadas_a_duplicado($id_e_inv_fvt_nueva);

        return view($this->vista.'.index', compact('personas'));
    }

    /**
     * Show the form for creating a new persona.
     *
     * @return Response
     */
    public function create()
    {
        $id_e_ind_fvt = $this->validarEntrevista();
        $persona = new Persona();
        $view_create = 1;

        if (!is_object($id_e_ind_fvt))
            $persona->id_e_ind_fvt = $id_e_ind_fvt;


        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $id_entrevistador=\Auth::user()->id_entrevistador;
        // A nombre de otro

        $entrevistaIndividual = entrevista_individual::find($id_e_ind_fvt);

        //Seguridad
        //Ver que tenga permisos de acceso a la entrevista
        if(!$entrevistaIndividual->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Segundo chequeo: reservado-3
        if(!$entrevistaIndividual->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO.");
        }

        //Ver que tenga permisos de modificar la ficha
        $permisos = $entrevistaIndividual->permitir_modificar_fichas();

        if(!$permisos->permitido) {
            $quien = entrevistador::find($entrevistaIndividual->id_entrevistador);
            $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,3,'0',STR_PAD_LEFT) : "[desconocido]";
            abort(403,"No puede ingresar fichas para el entrevistador especificado: $numero");
        }

        //return view($this->vista.'.create', compact('persona', 'id_e_ind_fvt', 'entrevistaIndividual'));

        $id_hecho = isset($_GET['id_hecho']) ? $_GET['id_hecho'] : "";
        $edicion = isset($_GET['edicion']) ? $_GET['edicion'] : "";

        if ($id_hecho == "")
        {
            return view('victimas.create', compact('persona', 'id_e_ind_fvt', 'entrevistaIndividual', 'view_create'));
        }
        else
        {
            if ($this->es_numero_entero($id_hecho) && $id_hecho > 0)
            {
                if ($this->es_numero_entero($edicion) && $edicion == 1)
                {
                    return view('victimas.create', compact('persona','entrevistaIndividual', 'id_e_ind_fvt', 'id_hecho', 'edicion', 'view_create'));
                }
                else
                {
                    return view('victimas.create', compact('persona','entrevistaIndividual', 'id_e_ind_fvt', 'id_hecho', 'edicion', 'view_create'));
                }

            }

            return redirect(url('entrevistaIndividuals'));
            //abort(503, 'No existe el hecho');
        }


    }

    /**
     * Verifica si existe una entrevista y si está asociada a una persona entrevistada
     */

    public function validarEntrevista() {

        $id_e_ind_fvt = isset($_GET['id_e_ind_fvt']) && is_numeric($_GET['id_e_ind_fvt']) ? $_GET['id_e_ind_fvt'] : 0;
        // $persona = null;

        if(!entrevista_individual::existeEntrevista($id_e_ind_fvt))
             return redirect(url('entrevistaIndividuals'));
           // abort(503);

        // $persona = entrevista_individual::validarExistenciaEntrevistaEnLaFicha(new Victima(), $id_e_ind_fvt);

        // if (is_object($persona))
        //    return view($this->vista.'.show')->with('persona', $persona);

        return $id_e_ind_fvt;
    }

    /**
     * Store a newly created persona in storage.
     *
     * @param CreatepersonaRequest $request
     *
     * @return Response
     */
    public function store(CreatepersonaRequest $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $entrevistaIndividual = entrevista_individual::find($request->id_e_ind_fvt);



        $input = persona::iniciar_variables_a_null($request->all());
        $persona = $this->personaRepository->create($input);

        if (!empty($persona))
            $this->guardarInformacionParticular(new victima, $persona, $input);

        Flash::success('Persona saved successfully.');

        $persona->completar_traza_insert();

        traza_actividad::create(['id_objeto'=>104, 'id_accion'=>3, 'codigo'=>$persona->fmtideindfvt, 'id_primaria'=>$persona->id_e_ind_fvt]);

        $id_hecho = isset($request['id_hecho']) ? $request['id_hecho'] : "";
        $view_create = isset($request['view_create']) ? $request['view_create'] : "";


        if ($id_hecho == "")
        {
            return redirect(route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]));
        }
        elseif ($this->es_numero_entero($view_create) && $view_create > 0)
        {
            return redirect(route('hechos.edit', [$id_hecho]));
        }
        else if ($this->es_numero_entero($id_hecho) && $id_hecho > 0)
        {
            return redirect(route('hechos.edit', [$id_hecho]));
        }

        return redirect(url('entrevistaIndividuals'));
        //abort(503, 'No existe el hecho');

    }


    /**
     * Display the specified persona.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, $id_e_ind_fvt)
    {

        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }


        $persona = persona::victimas()->where('persona.id_persona', $id)->where('persona.id_e_ind_fvt', $id_e_ind_fvt)->first();
        //dd($persona);
        $entrevistaIndividual = entrevista_individual::find($id_e_ind_fvt);


        //Seguridad
        //Ver que tenga permisos de acceso a la entrevista
        if(!$entrevistaIndividual->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Segundo chequeo: reservado-3
        if(!$entrevistaIndividual->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO.");
        }

        //Ver que tenga permisos de modificar la ficha
        $permisos = $entrevistaIndividual->permitir_modificar_fichas();

        if(!$permisos->permitido) {
            $quien = entrevistador::find($entrevistaIndividual->id_entrevistador);
            $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,3,'0',STR_PAD_LEFT) : "[desconocido]";
            abort(403,"No puede consultar fichas para el entrevistador especificado: $numero");
        }




        if (empty($persona)) {

            Flash::error('Persona not found');
            return redirect(route('entrevistaindividual.fichas', [$id_e_ind_fvt]));
        }

        $id_hecho = isset($_GET['id_hecho']) ? $_GET['id_hecho'] : "";
        $edicion = isset($_GET['edicion']) ? $_GET['edicion'] : "";
        $ficha_show = (isset($_GET['ficha_show']) ? 1 : 0);
        $search = isset($_GET['search']);
        
        if ($id_hecho == "")
            return view('victimas.show', compact('persona','entrevistaIndividual', 'ficha_show', 'search'));
        else
            return view('victimas.show', compact('persona','entrevistaIndividual', 'id_hecho', 'edicion', 'ficha_show', 'search'));
    }

    /**
     * Show the form for editing the specified persona.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id, $id_e_ind_fvt)
    {

        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $persona = persona::victimas()->where('persona.id_persona', $id)->where('persona.id_e_ind_fvt', $id_e_ind_fvt)->first();
        $entrevistaIndividual = entrevista_individual::find($id_e_ind_fvt);

      //  $persona = $this->personaRepository->findWithoutFail($id);

        if (empty($persona)) {
            Flash::error('Persona not found');
            return redirect(route('entrevistaindividual.fichas', [$id_e_ind_fvt]));
            //return redirect(route($this->vista.'.index'));
        }

        if(!\Gate::allows('es-propio',$entrevistaIndividual->id_entrevistador)) {
            $this->authorize('escritura');
            $id_entrevistador=$entrevistaIndividual->id_entrevistador;
            $permitidos = entrevistador::permitidos_acceso_entrevistas();
            if(!in_array($id_entrevistador,$permitidos)) {
                $quien = entrevistador::find($entrevistaIndividual->id_entrevistador);
                $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,5,'0',STR_PAD_LEFT) : "[desconocido]";
                abort(403,"No puede modificar entrevistas para el entrevistador especificado: $numero");
            }
        }

        $id_hecho = isset($_GET['id_hecho']) ? $_GET['id_hecho'] : "";
        $edicion = isset($_GET['edicion']) ? $_GET['edicion'] : "";
        $search = isset($_GET['search']);

        if ($id_hecho == "")
        {
            return view('victimas.edit', compact('persona','entrevistaIndividual', 'search'));
        }        
        else
        {
            if ($this->es_numero_entero($id_hecho) && $id_hecho > 0)
            {
                if ($this->es_numero_entero($edicion) && $edicion == 1)
                {
                    return view('victimas.edit', compact('persona','entrevistaIndividual', 'id_hecho', 'edicion', 'search'));
                }
                else
                {
                    return view('victimas.show', compact('persona','entrevistaIndividual', 'id_hecho', 'edicion', 'search'));
                }

            }

            return redirect(url('entrevistaIndividuals'));
            //abort(503, 'No existe el hecho');
        }


        //return view($this->vista.'.edit', compact('persona', 'entrevistaIndividual'));
    }

    /**
     * Update the specified persona in storage.
     *
     * @param  int              $id
     * @param UpdatepersonaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepersonaRequest $request)
    {  
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $persona = $this->personaRepository->findWithoutFail($id);

        if (empty($persona)) {
            Flash::error('Persona not found');
            return redirect(route($this->vista.'.index'));
        }

        $input = persona::iniciar_variables_a_null($request->all());

        $persona = $this->personaRepository->update($input, $id);

        $this->guardarInformacionParticular(new victima, $persona, $input);

        Flash::success('La información de la víctima ha sido actualizada exitosamente.');

        $persona->completar_traza_update();

        traza_actividad::create(['id_objeto'=>104, 'id_accion'=>4, 'codigo'=>$persona->fmtideindfvt , 'id_primaria'=>$persona->id_e_ind_fvt]);


        $id_hecho = isset($request['id_hecho']) ? $request['id_hecho'] : "";
        $edicion = isset($request['edicion']) ? $request['edicion'] : "";
        
        $entrevistaIndividual = entrevista_individual::find($persona->id_e_ind_fvt);

        if (isset($request['search']) && $request['search']){
            return redirect(route('buscar_victimas'));
        } elseif($id_hecho == "") {
            return redirect(route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]));
        } elseif ($this->es_numero_entero($id_hecho) && $id_hecho > 0) {
            return redirect(route('hechos.edit', [$id_hecho]));
        }

        return redirect(url('entrevistaIndividuals'));
        //abort(503, 'No existe el hecho');

       // return redirect(route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]));
    }

    /**
     * Remove the specified persona from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $id_e_ind_fvt = isset($_POST['id_e_ind_fvt']) && $_POST['id_e_ind_fvt']>0 ? $_POST['id_e_ind_fvt'] : 0;

        $victima = victima::where('id_persona', $id)->where('id_e_ind_fvt', $id_e_ind_fvt)->first();

        if (empty($victima)) {
            Flash::error('Persona not found');

            return redirect(route('entrevistaindividual.fichas', [$id_e_ind_fvt]));
        }

        $victima->delete();

        Flash::success('Persona deleted successfully.');

        return redirect(route('entrevistaindividual.fichas', [$id_e_ind_fvt]));
    }


    public function guardarInformacionParticular(EntrevistaRol $modelo, persona $persona, $parametros=[]) {

        return $modelo->guardarInformacionParticular($persona, $parametros);
    }

    /***
     * @param: Request
     */
    public function buscar_duplicados(Request $request) {

        $nombre = $request['nombre'];
        $apellido = $request['apellido'];
        $alias = $request['alias'];
        $num_documento = $request['num_documento'];
        $fec_nac_d = $request['fec_nac_d'];
        $fec_nac_m = $request['fec_nac_m'];
        $fec_nac_a = $request['fec_nac_a'];
        $id_e_ind_fvt_nueva = $request['id_e_ind_fvt'];

        $filtro = [];

        if ($nombre != "") array_push($filtro, ['nombre', 'ilike', '%'.$nombre.'%']);
        if ($apellido != "") array_push($filtro, ['apellido', 'ilike', '%'.$apellido.'%']);
        if ($alias != "") array_push($filtro, ['alias', 'ilike', '%'.$alias.'%']);
        if ($num_documento != "") array_push($filtro, ['num_documento', '=', $num_documento]);
        if ($fec_nac_d != "00") array_push($filtro, ['fec_nac_d', '=', $fec_nac_d]);
        if ($fec_nac_m != "00") array_push($filtro, ['fec_nac_m', '=', $fec_nac_m]);
        if ($fec_nac_a != "0") array_push($filtro, ['fec_nac_a', '=', $fec_nac_a]);

        $personas = persona::join('fichas.victima', 'victima.id_persona', '=', 'persona.id_persona')
                        ->where($filtro)
                        ->get(['persona.nombre',
                               'persona.apellido',
                               'persona.id_tipo_documento',
                               'persona.num_documento',
                               'persona.alias',
                               'persona.id_sexo',
                               'victima.id_victima',
                               'persona.id_persona',
                               'victima.id_e_ind_fvt']);

       return view('victimas.table_result_search', compact('personas', 'id_e_ind_fvt_nueva'));
    }

    public function vincular_duplicado(Request $request)
    {
        $victima_duplicada = new victima_duplicada($request->all());

        $victima_duplicada->save();

        $id_e_inv_fvt_nueva = $request['id_e_inv_fvt_nueva'];

        //$personas_duplicadas = $this->personas_vinculadas_a_duplicado($id_e_inv_fvt_nueva);

        return view('victimas.table_victimas_duplicadas', 'personas_duplicadas');
    }

    public function volver()
    {

        $id_hecho = isset($_GET['id_hecho']) ? $_GET['id_hecho'] : 0;

        if ($this->es_numero_entero($id_hecho) && $id_hecho > 0)
        {

            $edicion = isset($_GET['edicion']) ? $_GET['edicion'] : 0;
            $view_create = isset($_GET['view_create']) ? $_GET['view_create'] : 0;

            if ($this->es_numero_entero($edicion) && $edicion == 1)
            {
                return redirect(route('hechos.edit', [$id_hecho]));
            }

            if ($this->es_numero_entero($view_create) && $view_create == 1)
            {
                return redirect(route('hechos.edit', [$id_hecho]));
            }


            return redirect(route('hechos.show', [$id_hecho]));
        }

        $id_e_ind_fvt = isset($_GET['id_e_ind_fvt']) ? $_GET['id_e_ind_fvt'] : 0;


        if ($this->es_numero_entero($id_e_ind_fvt) && $id_e_ind_fvt > 0)
        {
            return redirect(route('entrevistaindividual.fichas', [$id_e_ind_fvt]));
        }

        return redirect(url('entrevistaIndividuals'));

        //abort(503, 'Ficha no encontrada');

    }

    public function es_numero_entero($valor)
    {
        if (filter_var($valor, FILTER_VALIDATE_INT))
            return true;

        return false;
    }

    public function buscar_victima(Request $request) {
        $request->es_victima = true;
        $filtros = persona::criterios_default($request);        
        $result = persona::buscar($filtros)->ordenar()->select(\DB::raw('fichas.persona.*'));

        $debug['sql']= nl2br($result->toSql());
        $debug['criterios']=$result->getBindings();
        //dd($debug);

        $listado = $result->paginate();        

        return view('buscador.search_victima',compact('listado','result','filtros'));

    }    
}
