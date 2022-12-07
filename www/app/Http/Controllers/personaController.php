<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepersonaRequest;
use App\Http\Requests\UpdatepersonaRequest;
use App\Models\entrevista_impacto;
use App\Models\persona_organizacion;
use App\Repositories\personaRepository;
use App\Http\Controllers\AppBaseController;
use App\Interfaces\EntrevistaRol;
use App\Models\entrevista;
use App\Models\entrevista_individual;
use App\Models\persona;
use App\Models\persona_entrevistada;
use App\Models\victima;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\entrevistador;
use App\Models\traza_actividad;
use Illuminate\Support\Facades\Auth;

class personaController extends AppBaseController
{
    /** @var  personaRepository */
    private $personaRepository;
    private $vista = 'personas';

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
        //$this->personaRepository->pushCriteria(new RequestCriteria($request));
        //$personas = $this->personaRepository->all();

        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $personas = persona::personas_entrevistadas();

        return view($this->vista.'.index')
            ->with('personas', $personas);
    }

    /**
     * Show the form for creating a new persona.
     *
     * @return Response
     */
    public function create()
    {
        $id_e_ind_fvt = $this->validarEntrevista();
        $persona = new persona();

        if (!is_object($id_e_ind_fvt)) {
            $persona->id_e_ind_fvt = $id_e_ind_fvt;
        }

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


        $pendiente_entrevista = persona_entrevistada::no_tiene_condiciones_acordadas_entrevista($id_e_ind_fvt);

        $entrevista = entrevista::where('id_e_ind_fvt', '=', $id_e_ind_fvt)->first();   
        
        if(empty($entrevista)) {
            $entrevista = new entrevista();
            $entrevista->valores_iniciales();
        }        

        return view($this->vista.'.create', compact('persona','id_e_ind_fvt', 'entrevistaIndividual', 'pendiente_entrevista', 'entrevista'));
    }

    /**
     * Verifica si existe una entrevista y si está asociada a una persona entrevistada
     */

    public function validarEntrevista() {

        $id_e_ind_fvt = isset($_GET['id_e_ind_fvt']) && is_numeric($_GET['id_e_ind_fvt']) ? $_GET['id_e_ind_fvt'] : 0;

        if(!entrevista_individual::existeEntrevista($id_e_ind_fvt))
        return redirect(url('entrevistaIndividuals'));    
        //abort(503);

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
        $id_entrevistador=\Auth::user()->id_entrevistador;
        
        $entrevistaIndividual = entrevista_individual::find($request->id_e_ind_fvt);



        $input = persona::iniciar_variables_a_null($request->all());
        $persona = $this->personaRepository->create($input);

        $persona->completar_traza_insert();

        if (!empty($persona))
            $this->guardarInformacionParticular(new persona, $persona, $input);

        if (isset($request['pendiente_entrevista']) && $request['pendiente_entrevista'] == 1)
        {
            entrevista::nuevo_procesar_request($request);
        }



        Flash::success('Persona saved successfully.');

        traza_actividad::create(['id_objeto'=>103, 'id_accion'=>3, 'codigo'=>$persona->fmtideindfvt, 'id_primaria'=>$persona->id_e_ind_fvt]);        

        //return redirect(route($this->vista.'.index'));
        return redirect(route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]));
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

        $persona = persona::personas_entrevistadas()->where('persona.id_persona', $id)->where('persona.id_e_ind_fvt', $id_e_ind_fvt)->first();
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

//        //Ver que tenga permisos de modificar la ficha  (no aplica, este es show)
//        $permisos = $entrevistaIndividual->permitir_modificar_fichas();
//
//        if(!$permisos->permitido) {
//            $quien = entrevistador::find($entrevistaIndividual->id_entrevistador);
//            $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,3,'0',STR_PAD_LEFT) : "[desconocido]";
//            abort(403,"No puede ingresar fichas para el entrevistador especificado: $numero ($permisos->texto)");
//        }


        if (empty($persona)) {

            Flash::error('Persona not found');
            return redirect(route($this->vista.'.index'));
        }       

        $ficha_show = (isset($_GET['ficha_show']) ? 1 : 0);

        return view('personas.show', compact('entrevistaIndividual', 'persona', 'ficha_show'));
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
        $persona = persona::personas_entrevistadas()->where('persona.id_persona', $id)->where('persona.id_e_ind_fvt', $id_e_ind_fvt)->first();
        
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $entrevistaIndividual = entrevista_individual::find($id_e_ind_fvt);

        if (empty($entrevistaIndividual)) {
            Flash::error('Entrevista Individual no existe');
            return redirect(route('entrevistaIndividuals.index'));
        }

        $permisos = $entrevistaIndividual->permitir_modificar_fichas();
        if(!$permisos->permitido) {
            abort(403,$permisos->texto);
        }


        $pendiente_entrevista = persona_entrevistada::no_tiene_condiciones_acordadas_entrevista($id_e_ind_fvt);

        $entrevista = entrevista::where('id_e_ind_fvt', '=', $id_e_ind_fvt)->first();

        if(empty($entrevista)) {
            $entrevista = new entrevista();
            $entrevista->valores_iniciales();
        }

        if (empty($persona)) {
            Flash::error('Persona not found');
            return redirect(route('entrevistaindividual.fichas', [$id_e_ind_fvt]));
            //return redirect(route($this->vista.'.index'));
        }

        return view('personas.edit', compact('entrevistaIndividual', 'persona', 'pendiente_entrevista', 'entrevista'));
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
            return redirect(route('personas.index'));
        }


        $input = persona::iniciar_variables_a_null($request->all());

        $persona = $this->personaRepository->update($input, $id);

        $this->guardarInformacionParticular(new persona, $persona, $input);

        
        if (isset($request['pendiente_entrevista']) && $request['pendiente_entrevista'] == 1)
        {
            entrevista::nuevo_procesar_request($request);
        }

        Flash::success('Persona updated successfully.');
        traza_actividad::create(['id_objeto'=>103, 'id_accion'=>4, 'codigo'=>$persona->fmtideindfvt , 'id_primaria'=>$persona->id_e_ind_fvt]);

        
        $persona->completar_traza_update();  

        return redirect(route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]));
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
        
        $persona_entrevistada = persona_entrevistada::where('id_persona', $id)->where('id_e_ind_fvt', $id_e_ind_fvt)->first();        
        
        if (empty($persona_entrevistada)) {
            Flash::error('Persona not found');

            return redirect(route($this->vista.'.index'));
        }

        $persona_entrevistada->delete();

        Flash::success('Persona deleted successfully.');

        return redirect(route('entrevistaindividual.fichas', [$id_e_ind_fvt]));
    }


    public function guardarInformacionParticular(EntrevistaRol $modelo, persona $persona, $parametros=[]) {

        return $modelo->guardarInformacionParticular($persona, $parametros);
    }

    public function guardar_consentimiento(Request $request) {

        entrevista::nuevo_procesar_request($request);    
    }


    public function buscar_persona(Request $request) {
        $filtros = persona::criterios_default($request);
        $mago = persona::buscar($filtros)->ordenar()->select(\DB::raw('fichas.persona.*'));

        $debug['sql']= nl2br($mago->toSql());
        $debug['criterios']=$mago->getBindings();
        //dd($debug);

        $listado = $mago->paginate();



        return view('buscador.persona',compact('listado','mago','filtros'));

    }

    //PAra los autofill
    public function autofill_cargo_publico(Request $request) {
        return persona::listar_opciones_campo('cargo_publico_cual',$request->texto);
    }
    public function autofill_fuerza_publica(Request $request) {
        return persona::listar_opciones_campo('fuerza_publica_especificar',$request->texto);
    }
    public function autofill_actor_armado(Request $request) {
        return persona::listar_opciones_campo('actor_armado_especificar',$request->texto);
    }
    public function autofill_nombre_organizacion(Request $request) {
        return persona_organizacion::listar_opciones_campo('nombre',$request->texto);
    }
    public function autofill_rol_organizacion(Request $request) {
        return persona_organizacion::listar_opciones_campo('rol',$request->texto);
    }

    //Para impactos transgeneracionales
    public function autofill_impactos_transgeneracionales(Request $request) {
        return entrevista_impacto::listar_opciones_campo('transgeneracionales',$request->texto);
    }



}
