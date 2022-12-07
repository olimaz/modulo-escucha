<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepersonaRequest;
use App\Http\Requests\UpdatepersonaRequest;
use App\Models\hecho;
use App\Repositories\personaRepository;
use App\Http\Controllers\AppBaseController;
use App\Interfaces\EntrevistaRol;
use App\Models\entrevista_etnica;
use App\Models\entrevista_individual;
use App\Models\persona;
use App\Models\persona_responsable;
use App\Models\Victima;
use App\Models\entrevistador;
use App\Models\traza_actividad;
use App\Models\hecho_responsable;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Log;

class persona_responsableController extends Controller
{
    private $personaRepository;
    private $vista = 'persona_responsable';

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

          $personas = persona::personas_responsables_bak();
        // $personas = $persona->personas_responsables_bak();

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
        $tipo_entrevista = 'individual';
        $id_entrevista = 0;
        $id_entrevista = $this->validarEntrevista();
        $entrevista = null;

        // $id_e_ind_fvt = $this->validarEntrevista();

        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $id_entrevistador=\Auth::user()->id_entrevistador;

        if (isset($_GET['id_e_ind_fvt'])) {

            $entrevista = entrevista_individual::find($id_entrevista);

        } else if (isset($_GET['id_entrevista_etnica'])) {

            $entrevista = entrevista_etnica::find($id_entrevista);
            $tipo_entrevista = 'etnica';
        }

        //Seguridad
        //Ver que tenga permisos de acceso a la entrevista
        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Segundo chequeo: reservado-3
        if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO.");
        }

        //Ver que tenga permisos de modificar la ficha
        $permisos = $entrevista->permitir_modificar_fichas();

        if(!$permisos->permitido) {
            $quien = entrevistador::find($entrevista->id_entrevistador);
            $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,3,'0',STR_PAD_LEFT) : "[desconocido]";
            abort(403,"No puede ingresar fichas para el entrevistador especificado: $numero");
        }

        $persona = new Persona();
        $persona->valores_iniciales();
        if (!is_object($id_entrevista)) {
            $persona->id_e_ind_fvt = $id_entrevista;
        }
        $id_hecho = isset($_GET['id_hecho']) && is_numeric($_GET['id_hecho']) ? $_GET['id_hecho'] : 0;

        if($id_hecho)
        {
            $persona->id_hecho = $id_hecho;
        //   return view($this->vista.'.create', compact('persona', 'id_e_ind_fvt','id_hecho'));
            return view($this->vista.'.create', compact('persona', 'entrevista', 'id_entrevista','id_hecho', 'tipo_entrevista'));

        } else {
            // return view($this->vista.'.create', compact('persona', 'id_e_ind_fvt'));
            return view($this->vista.'.create', compact('persona', 'entrevista', 'id_entrevista', 'tipo_entrevista'));
        }

    }

    /**
     * Verifica si existe una entrevista y si está asociada a una persona entrevistada
     */

    public function validarEntrevista() {

        if (isset($_GET['id_entrevista_etnica'])) {
            $id_entrevista_etnica = $_GET['id_entrevista_etnica'];

            if (empty(entrevista_etnica::find($id_entrevista_etnica)))
                abort(503);

            return $id_entrevista_etnica;
        }

        $id_e_ind_fvt = isset($_GET['id_e_ind_fvt']) && is_numeric($_GET['id_e_ind_fvt']) ? $_GET['id_e_ind_fvt'] : 0;
        // $persona = null;

        if(!entrevista_individual::existeEntrevista($id_e_ind_fvt))
            abort(503);

        // $persona = entrevista_individual::validarExistenciaEntrevistaEnLaFicha(new personas_responsables(), $id_e_ind_fvt);
        //
        // if (is_object($persona))
        //     return view($this->vista.'.show')->with('persona', $persona);


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
        $entrevista  = null;

        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $id_entrevistador=\Auth::user()->id_entrevistador;


        if ($request->tipo_entrevista == 'individual') {
            $entrevista = entrevista_individual::find($request->id_e_ind_fvt);
        } else {
            $entrevista = entrevista_etnica::find($request->id_entrevista_etnica);
        }



        $input = $request->all();
        $input = $this->iniciar_variables_a_null($input);
        $persona = $this->personaRepository->create($input);

        if (!empty($persona))
            //$this->guardarInformacionParticular(new persona_responsable, $persona, $input);
            $persona_responsable = $persona->guardar_datos_responsable($request);

            $hecho_responsable = new hecho_responsable();
            $hecho_responsable->id_hecho=$request->id_hecho;
            $hecho_responsable->id_persona_responsable=$persona_responsable->id_persona_responsable;
            $hecho_responsable->save();

        Flash::success('Persona Responsable guardada satisfactoriamente.');

        if ($request->tipo_entrevista == 'individual') {
            traza_actividad::create(['id_objeto'=>102, 'id_accion'=>3, 'codigo'=>$persona->fmtideindfvt, 'id_primaria'=>$persona_responsable->id_e_ind_fvt]);
        } else {
            traza_actividad::create(['id_objeto'=>102, 'id_accion'=>3, 'codigo'=>$persona->id_entrevista_etnica, 'id_primaria'=>$persona_responsable->id_entrevista_etnica]);
        }

        if($request->id_hecho)
        {
            return redirect(action('hechoController@edit', [$request->id_hecho]));
        }
        else
        {
            return redirect(route('entrevistaindividual.fichas', [$persona_responsable->id_e_ind_fvt]));
        }

    }


    /**
     * Display the specified persona.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, $id_e_ind_fvt, Request $request)
    {
      $entrevista = null;
      $tipo_entrevista = 'individual';

      if(\Gate::allows('solo-estadistica')) {
          abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
      }

      $quien = persona::find($id);
      $persona = $quien->personas_responsables()->where('id_e_ind_fvt',$id_e_ind_fvt)->first();

      if (empty($persona)) {

        $persona = $quien->personas_responsables()->where('id_entrevista_etnica',$id_e_ind_fvt)->first();

        if (!empty($persona)) {
            $tipo_entrevista = 'etnica';
            $entrevista = entrevista_etnica::find($id_e_ind_fvt);
        }

      } else {
        $entrevista = entrevista_individual::find($id_e_ind_fvt);
      }


      //$persona = persona::personas_responsables()->where('id_persona', $id)->where('persona_responsable.id_e_ind_fvt', $id_e_ind_fvt)->first();

    //   $entrevistaIndividual = entrevista_individual::find($id_e_ind_fvt);

      if (empty($entrevista)) {
          Flash::error("La entrevista no existe($id_e_ind_fvt)");
          return redirect(route('entrevistaIndividuals.index'));
      }

        //Seguridad
        //Ver que tenga permisos de acceso a la entrevista
        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Segundo chequeo: reservado-3
        if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO.");
        }

        //Ver que tenga permisos de modificar la ficha
        $permisos = $entrevista->permitir_modificar_fichas();

        if(!$permisos->permitido) {
            $quien = entrevistador::find($entrevista->id_entrevistador);
            $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,3,'0',STR_PAD_LEFT) : "[desconocido]";
            abort(403,"No puede ingresar fichas para el entrevistador especificado: $numero");
        }
        // $persona = $this->personaRepository->findWithoutFail($id);

        if (empty($persona)) {

            Flash::error('Persona not found');
            return redirect(route($this->vista.'.index'));
        }

        if ($tipo_entrevista=='individual') {
            traza_actividad::create(['id_objeto'=>102, 'id_accion'=>6, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$entrevista->id_e_ind_fvt]);
        } else {
            traza_actividad::create(['id_objeto'=>102, 'id_accion'=>6, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$entrevista->id_entrevista_etnica]);
        }

        //Mostrar información del hecho
        $id_hecho = isset($request->id_hecho) && is_numeric($request->id_hecho) ? $request->id_hecho : 0;
        $hecho = null;
        $expediente = null;
        $edicion = isset($request->edicion) ? $request->edicion : 2;
        if($id_hecho > 0) {
            $hecho = hecho::find($id_hecho);
            if($hecho) {
                $expediente = $entrevista;

            }
        }


        //$id_hecho = isset($_GET['id_hecho']) ? $_GET['id_hecho'] : "";
        // dd($_GET);
        $volver_ficha_show = isset($_GET['fs']) ? 'fs' : "";
        $volver_ficha_show_fs_i = isset($_GET['fs_i']) ? 'fs_i' : "";
        
        
        $edicion = isset($_GET['edicion']) ? $_GET['edicion'] : "";

        // if ($id_hecho == "")
        // return view($this->vista.'.show', compact('persona','entrevistaIndividual'));
        // else
        // return view($this->vista.'.show', compact('persona','entrevistaIndividual', 'id_hecho', 'edicion'));

        if($id_hecho)
        {
            $persona->id_hecho = $id_hecho;
        }

        if($edicion)
        {
            $persona->edicion = $edicion;
        }

        return view($this->vista.'.show')->with(compact('persona', 'entrevista', 'tipo_entrevista', 'volver_ficha_show', 'volver_ficha_show_fs_i', 'hecho','edicion','id_hecho'));

        //  return redirect(route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]));
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
        $entrevista = null;
        $tipo_entrevista = 'individual';
        $persona = null;

      // $persona = persona::personas_responsables()->where('id_persona', $id)->where('id_e_ind_fvt', $id_e_ind_fvt)->first();
     
        $quien = persona::find($id);
            
        if (!empty($quien))  {
          
            // Comprueba si la persona es un responsable de una entrevista individual
            if (!is_null($quien->id_e_ind_fvt)) {
                
                $persona = $quien->personas_responsables()->where('id_e_ind_fvt',$id_e_ind_fvt)->first();
                $entrevista = entrevista_individual::find($id_e_ind_fvt);
            } else {
                
                // Comprueba si la persoana es un responsable de una entrevista etnica
                $persona = $quien->personas_responsables()->where('id_persona',$id)->first();

                if (!empty($persona)) {
                   
                    if (!is_null($persona->rel_persona_responsable->id_entrevista_etnica)) {

                        $persona = $quien->personas_responsables()->where('id_entrevista_etnica',$id_e_ind_fvt)->first();
                        $entrevista = entrevista_etnica::find($id_e_ind_fvt);
                        $tipo_entrevista = 'etnica';
                    }
                }

            }
        }

        // Asigna valor -1 para cuando la opción seleccionada es ninguno. Necesario para el correcto funcionamiento de los controles de vista (select y select2). 
        if (!is_null($persona)) {

            $persona->id_etnia = $persona->id_etnia == null ? -1 : $persona->id_etnia;
            $persona->id_edad_aproximada = $persona->id_edad_aproximada == null ? -1 : $persona->id_edad_aproximada;         

        }


      if(\Gate::allows('solo-estadistica')) {
          abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
      }
    //   $entrevistaIndividual =  entrevista_individual::find($id_e_ind_fvt);

      if (empty($entrevista)) {
          Flash::error('Entrevista Individual no existe');
          return redirect(route('entrevistaIndividuals.index'));
      }
        //Seguridad
        //Ver que tenga permisos de acceso a la entrevista
        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Segundo chequeo: reservado-3
        if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO.");
        }

        //Ver que tenga permisos de modificar la ficha
        $permisos = $entrevista->permitir_modificar_fichas();

        if(!$permisos->permitido) {
            $quien = entrevistador::find($entrevista->id_entrevistador);
            $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,3,'0',STR_PAD_LEFT) : "[desconocido]";
            abort(403,"No puede ingresar fichas para el entrevistador especificado: $numero");
        }

        // $persona = $this->personaRepository->findWithoutFail($id);

        if (empty($persona)) {
            Flash::error('Persona not found');

            return redirect(route($this->vista.'.index'));
        }
        $id_hecho = isset($_GET['id_hecho']) && is_numeric($_GET['id_hecho']) ? $_GET['id_hecho'] : 0;
        if($id_hecho) {
            $persona->id_hecho = $id_hecho;
            return view($this->vista.'.edit')->with(compact('persona', 'entrevista', 'id_hecho', 'tipo_entrevista'));
        } else {
              return view($this->vista.'.edit')->with(compact('persona', 'entrevista', 'tipo_entrevista'));
        }



        // return view($this->vista.'.edit')->with('persona', $persona)->with('id_e_ind_fvt',$id_e_ind_fvt);
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

        $input = $request->input();

        $input = $this->iniciar_variables_a_null($input);

        $persona = $this->personaRepository->update($input, $id);

        $persona_responsable = $persona->actualizar_datos_responsable($request);

       // $persona_responsable = $persona->grabar_responsabilidades($request->presunta_responsabilidad);

       // grabar_resonsabilidades($request->presunta_responsabilidad);

        // $this->guardarInformacionParticular(new persona_responsable, $persona, $input);

        Flash::success('Persona updated successfully.');
        //Log::info($request);
        if ($request->tipo_entrevista == 'individual') {
            traza_actividad::create(['id_objeto'=>102, 'id_accion'=>4, 'codigo'=>$persona->fmtideindfvt , 'id_primaria'=>$persona->id_e_ind_fvt]);
        } else {
            traza_actividad::create(['id_objeto'=>102, 'id_accion'=>4, 'codigo'=>$request->id_entrvista_etnica , 'id_primaria'=>$request->id_entrvista_etnica]);
        }


        // return redirect(route($this->vista.'.index'));
        if($request->id_hecho) {

            return redirect(action('hechoController@edit', [$request->id_hecho]));

        } else {

            if ($request->tipo_entrevista == 'individual') {

                return redirect(route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]));
            } else {
                return redirect(route('entrevistaEtnica.fichas', [$request->id_entrevista_etnica]));
            }

        }


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
        // dd('Llega a este método');
        $ruta = 'entrevistaindividual.fichas';

        $id_entrevista = isset($_POST['id_e_ind_fvt']) && $_POST['id_e_ind_fvt']>0 ? $_POST['id_e_ind_fvt'] : 0;

        $persona_responsable = persona_responsable::where('id_persona', $id)->where('id_e_ind_fvt', $id_entrevista)->first();

        if (empty($persona_responsable)) {

                $id_entrevista = isset($_POST['id_entrevista_etnica']) && $_POST['id_entrevista_etnica']>0 ? $_POST['id_entrevista_etnica'] : 0;

                $persona_responsable = persona_responsable::where('id_persona', $id)->where('id_entrevista_etnica', $id_entrevista)->first();

                $ruta = 'entrevistaEtnica.fichas';
        }



        // $persona = $this->personaRepository->findWithoutFail($id);

        if (empty($persona_responsable)) {
            Flash::error('Persona responsable no encontrada');

            return redirect(route($ruta, [$id_entrevista]));
        }

        $persona_responsable->delete();

        Flash::success('Persona responsable borrada.');

        //   return redirect(route('entrevistaindividual.fichas', [$id_entrevista]));
        return redirect(route($ruta, [$id_entrevista]));

    }


    public function guardarInformacionParticular(EntrevistaRol $modelo, persona $persona, $parametros=[]) {

        return $modelo->guardarInformacionParticular($persona, $parametros);
    }


    public function iniciar_variables_a_null($input = []) {

      if (isset($input['id_fuerza_publica_estado']) && $input['id_fuerza_publica_estado']<0)
          $input['id_fuerza_publica_estado'] = null;

      if (isset($input['id_fuerza_publica']) && $input['id_fuerza_publica']<0)
          $input['id_fuerza_publica'] = null;

      if (isset($input['id_actor_armado']) && $input['id_actor_armado']<0)
          $input['id_actor_armado'] = null;

      if (isset($input['id_etnia_indigena']) && $input['id_etnia_indigena']<0)
          $input['id_etnia_indigena'] = null;

      if (isset($input['fec_nac_a']) && $input['fec_nac_a'] < 1)
          $input['fec_nac_a'] = null;

      if (isset($input['fec_nac_m']) && $input['fec_nac_m'] < 1)
          $input['fec_nac_m'] = null;

      if (isset($input['fec_nac_d']) && $input['fec_nac_d'] < 1)
          $input['fec_nac_d'] = null;

      if (isset($input['id_sexo']) && $input['id_sexo']<0)
          $input['id_sexo'] = null;

      if (isset($input['id_orientacion']) && $input['id_orientacion']<0)
          $input['id_orientacion'] = null;

      if (isset($input['id_identidad']) && $input['id_identidad']<0)
          $input['id_identidad'] = null;

      if (isset($input['id_etnia']) && $input['id_etnia']<0)
          $input['id_etnia'] = null;

      if (isset($input['id_tipo_documento']) && $input['id_tipo_documento']<0)
          $input['id_tipo_documento'] = null;

      if (isset($input['id_nacionalidad']) && $input['id_nacionalidad']<0)
          $input['id_nacionalidad'] = null;

      if (isset($input['id_estado_civil']) && $input['id_estado_civil']<0)
          $input['id_estado_civil'] = null;

      if (isset($input['id_otra_nacionalidad']) && $input['id_otra_nacionalidad']<0)
          $input['id_otra_nacionalidad'] = null;

      if (isset($input['id_lugar_residencia']) && $input['id_lugar_residencia']<0)
          $input['id_lugar_residencia'] = null;

      if (isset($input['id_lugar_nacimiento']) && $input['id_lugar_nacimiento']<0)
          $input['id_lugar_nacimiento'] = null;

      if (isset($input['id_lugar_residencia_depto']) && $input['id_lugar_residencia_depto']<0)
          $input['id_lugar_residencia_depto'] = null;

      if (isset($input['id_lugar_residencia_muni']) && $input['id_lugar_residencia_muni']<0)
          $input['id_lugar_residencia_muni'] = null;

      if (isset($input['id_lugar_nacimiento_depto']) && $input['id_lugar_nacimiento_depto']<0)
          $input['id_lugar_nacimiento_depto'] = null;

      if (isset($input['id_edad_aproximada']) && $input['id_edad_aproximada']<0)
          $input['id_edad_aproximada'] = null;

      if (isset($input['id_rango_cargo']) && $input['id_rango_cargo']<0)
          $input['id_rango_cargo'] = null;

      if (isset($input['id_grupo_paramilitar']) && $input['id_grupo_paramilitar']<0)
          $input['id_grupo_paramilitar'] = null;

      if (isset($input['id_guerrilla']) && $input['id_guerrilla']<0)
          $input['id_guerrilla'] = null;

          if (isset($input['id_presunta_responsabilidad']) && $input['id_presunta_responsabilidad']<0)
          $input['id_presunta_responsabilidad'] = null;



      return $input;
    }
}
