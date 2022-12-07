<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createmis_casos_personaRequest;
use App\Http\Requests\Updatemis_casos_personaRequest;
use App\Models\mis_casos_persona;
use App\Models\traza_actividad;
use App\Repositories\mis_casos_personaRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use mysql_xdevapi\Exception;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class mis_casos_personaController extends AppBaseController
{
    /** @var  mis_casos_personaRepository */
    private $misCasosPersonaRepository;

    public function __construct(mis_casos_personaRepository $misCasosPersonaRepo)
    {
        $this->misCasosPersonaRepository = $misCasosPersonaRepo;
    }

    /**
     * Display a listing of the mis_casos_persona.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->misCasosPersonaRepository->pushCriteria(new RequestCriteria($request));
        $misCasosPersonas = $this->misCasosPersonaRepository->all();

        return view('mis_casos_personas.index')
            ->with('misCasosPersonas', $misCasosPersonas);
    }

    /**
     * Show the form for creating a new mis_casos_persona.
     *
     * @return Response
     */
    public function create()
    {
        return view('mis_casos_personas.create');
    }

    /**
     * Store a newly created mis_casos_persona in storage.
     *
     * @param Createmis_casos_personaRequest $request
     *
     * @return Response
     */
    public function store(Createmis_casos_personaRequest $request)
    {
        $input = $request->all();

        //Unificar fecha y hora
        $input['entrevista_fecha_hora'] = mis_casos_persona::procesar_fecha_hora($request);


        //dd($input);


        $misCasosPersona = $this->misCasosPersonaRepository->create($input);
        //Traza
        $caso = $misCasosPersona->rel_id_mis_casos;
        $t = traza_actividad::create(['id_objeto'=>17, 'id_accion'=>3, 'codigo'=>$caso->entrevista_codigo, 'id_primaria'=>$caso->id_mis_casos_persona]);

        //Flash::success('Mis Casos Persona saved successfully.');

        $url =action('mis_casosController@show',$misCasosPersona->id_mis_casos)."?activar=p";
        return redirect($url);
    }

    /**
     * Display the specified mis_casos_persona.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $misCasosPersona = $this->misCasosPersonaRepository->findWithoutFail($id);
        if (empty($misCasosPersona)) {
            Flash::error('Mis Casos Persona no existe');
            return redirect(route('mis_casosController@index'));
        }
        $url =action('mis_casosController@show',$misCasosPersona->id_mis_casos)."?activar=p";
        return redirect($url);
    }

    /**
     * Show the form for editing the specified mis_casos_persona.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $misCasosPersona = $this->misCasosPersonaRepository->findWithoutFail($id);

        if (empty($misCasosPersona)) {
            Flash::error('Mis Casos Persona no existe');
            return redirect(route('mis_casosController@index'));
        }

        return view('mis_casos_personas.edit')->with('misCasosPersona', $misCasosPersona);
    }

    /**
     * Update the specified mis_casos_persona in storage.
     *
     * @param  int              $id
     * @param Updatemis_casos_personaRequest $request
     *
     * @return Response
     */
    public function update($id, Updatemis_casos_personaRequest $request)
    {
        $misCasosPersona = $this->misCasosPersonaRepository->findWithoutFail($id);

        if (empty($misCasosPersona)) {
            Flash::error('Mis Casos Persona no existe');
            return redirect(route('mis_casosController@index'));
        }
        $input = $request->all();
        unset($input['id_mis_casos']);//por si las moscas
        //Unificar fecha y hora
        $input['entrevista_fecha_hora'] = mis_casos_persona::procesar_fecha_hora($request);
        //Persistir a la BD
        $misCasosPersona = $this->misCasosPersonaRepository->update($input, $id);

        //Traza
        $caso = $misCasosPersona->rel_id_mis_casos;
        traza_actividad::create(['id_objeto'=>17, 'id_accion'=>4, 'codigo'=>$caso->entrevista_codigo, 'id_primaria'=>$misCasosPersona->id_mis_casos_persona]);

        $url =action('mis_casosController@show',$misCasosPersona->id_mis_casos)."?activar=p";
        return redirect($url);
    }

    /**
     * Remove the specified mis_casos_persona from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $misCasosPersona = $this->misCasosPersonaRepository->findWithoutFail($id);

        if (empty($misCasosPersona)) {
            Flash::error('Mis Casos Persona no existe');
            return redirect(action('mis_casosController@index'));
        }

        //$this->misCasosPersonaRepository->delete($id);
        $misCasosPersona->id_activo=2;
        $misCasosPersona->save();
        $entrevista = $misCasosPersona->rel_id_mis_casos;
        //Registrar traza
        traza_actividad::create(['id_objeto'=>17, 'id_accion'=>10, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$misCasosPersona->id_mis_casos_persona]);
        $url=action('mis_casosController@show',$misCasosPersona->id_mis_casos)."?activar=p";
        return redirect($url);

    }

    //Ya fue contactado
    public function update_contactada($id, Request $request) {
            $persona = mis_casos_persona::find($id);
            if($persona) {
                $persona->id_contactado = isset($request->id_contactado) ? 1 : 2;
                $persona->fh_update=Carbon::now();
                $persona->save();
                //Registrar traza
                $entrevista = $persona->rel_id_mis_casos;
                traza_actividad::create(['id_objeto'=>17, 'id_accion'=>4, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$persona->id_mis_casos_persona]);
            }
            else {
                Flash::error('Mis Casos Persona no existe');
                return redirect(route('mis_casosController@index'));
            }
        $url =action('mis_casosController@show',$persona->id_mis_casos)."?activar=p";
        return redirect($url);
    }
    //Ya fue contactado
    public function update_entrevistada($id, Request $request) {
        $persona = mis_casos_persona::find($id);
        if($persona) {
            $persona->id_entrevistado = isset($request->id_entrevistado) ? 1 : 2;
            $persona->fh_update=Carbon::now();
            $persona->save();
            //Registrar traza
            $entrevista = $persona->rel_id_mis_casos;
            traza_actividad::create(['id_objeto'=>17, 'id_accion'=>4, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$persona->id_mis_casos_persona]);
        }
        else {
            Flash::error('Mis Casos Persona no existe');
            return redirect(route('mis_casosController@index'));
        }
        $url =action('mis_casosController@show',$persona->id_mis_casos)."?activar=p";
        return redirect($url);

    }
}
