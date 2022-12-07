<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createf_entrevistaRequest;
use App\Http\Requests\Updatef_entrevistaRequest;
use App\Models\entrevista;
use App\Models\entrevista_individual;
use App\Repositories\f_entrevistaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class f_entrevistaController extends AppBaseController
{
    /** @var  f_entrevistaRepository */
    private $fEntrevistaRepository;

    public function __construct(f_entrevistaRepository $fEntrevistaRepo)
    {
        $this->fEntrevistaRepository = $fEntrevistaRepo;
    }

    /**
     * Display a listing of the f_entrevista.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        return redirect('/');
        $this->fEntrevistaRepository->pushCriteria(new RequestCriteria($request));
        $fEntrevistas = $this->fEntrevistaRepository->all();

        return view('f_entrevistas.index')
            ->with('fEntrevistas', $fEntrevistas);
    }

    /**
     * Show the form for creating a new f_entrevista.
     *
     * @return Response
     */
    public function create(Request $request)
    {

        if(isset($request->id_e_ind_fvt)) {
            $entrevistaIndividual = entrevista_individual::find($request->id_e_ind_fvt);
            if(!$entrevistaIndividual) {
                Flash::error("No existe la entrevsita especificada ($request->id_e_ind_fvt)");
                return redirect()->back();
            }
            //Permisos
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
                abort(403,$permisos->texto);
            }
            //Fin de la revisión


            $entrevista = entrevista::where('id_e_ind_fvt',$request->id_e_ind_fvt)->first();
            if($entrevista) {
                return redirect()->action('f_entrevistaController@edit',$entrevista->id_entrevista);
            }
            else {
                $entrevista = new entrevista();
                $entrevista->valores_iniciales();
                return view('f_entrevistas.create',compact('request','entrevistaIndividual','entrevista'));
            }

        }
        //Aquí se podría meter de las otras entrevistas
        return redirect()->back();

    }

    /**
     * Store a newly created f_entrevista in storage.
     *
     * @param Createf_entrevistaRequest $request
     *
     * @return Response
     */
    public function store(Createf_entrevistaRequest $request)
    {
        if(isset($request->id_e_ind_fvt)) {
            $entrevistaIndividual = entrevista_individual::find($request->id_e_ind_fvt);
            if(!$entrevistaIndividual) {
                Flash::error("No existe la entrevista indicada ($request->id_e_ind_fvt)");
                return redirect()->back();
            }
            //Actualizar la BD
            $request['id_e_ind_fvt'] = $request->id_e_ind_fvt; //
            $nuevo = entrevista::nuevo_procesar_request($request);

            //Actualiar si la entrevista menciona temas con escasa documentación
            $entrevistaIndividual->id_prioritario = $request->id_prioritario;
            $entrevistaIndividual->prioritario_tema = $request->prioritario_tema;
            $entrevistaIndividual->save();
            return redirect()->action('entrevista_individualController@fichas', $entrevistaIndividual->id_e_ind_fvt);

        }
        else {
            Flash::error("No se especificó la entrevista asociada");
            return redirect()->back();
        }
        $entrevista = entrevista::find($id);

        if (empty($entrevista)) {
            Flash::error('No existe el identificador especificado');
            return redirect(route('f_entrevistas.index'));
        }
        //Entrevista individual
        if($entrevista->id_e_ind_fvt > 0) {
            $entrevistaIndividual = entrevista_individual::find($entrevista->id_e_ind_fvt);
            if($entrevistaIndividual) {
                //dd($entrevista);
                return view('f_entrevistas.edit')
                    ->with('fEntrevista', $entrevista)
                    ->with('entrevista',$entrevista)
                    ->with('entrevistaIndividual',$entrevistaIndividual);
            }
            else {
                Flash::warning('No corresponde a entrevsita especificada');
                return redirect()->back();
            }

        }
        else {
            Flash::warning('Corresponde a una entrevista distinta');
            return redirect()->back();
        }


        $input = $request->all();

        $fEntrevista = $this->fEntrevistaRepository->create($input);

        Flash::success('F Entrevista saved successfully.');

        return redirect(route('fEntrevistas.index'));
    }

    /**
     * Display the specified f_entrevista.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return redirect('/');
        $fEntrevista = $this->fEntrevistaRepository->findWithoutFail($id);

        if (empty($fEntrevista)) {
            Flash::error('F Entrevista not found');

            return redirect(route('fEntrevistas.index'));
        }

        return view('f_entrevistas.show')->with('fEntrevista', $fEntrevista);
    }

    /**
     * Show the form for editing the specified f_entrevista.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $entrevista = entrevista::find($id);

        if (empty($entrevista)) {
            Flash::error('No existe el identificador especificado');
            return redirect(route('f_entrevistas.index'));
        }
        //Entrevista individual
        if($entrevista->id_e_ind_fvt > 0) {
            $entrevistaIndividual = entrevista_individual::find($entrevista->id_e_ind_fvt);
            //Permisos
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
                abort(403,$permisos->texto);
            }
            //Fin de la revisión

            if($entrevistaIndividual) {
                //dd($entrevista);
                return view('f_entrevistas.edit')
                    ->with('fEntrevista', $entrevista)
                    ->with('entrevista',$entrevista)
                    ->with('entrevistaIndividual',$entrevistaIndividual);
            }
            else {
                Flash::warning('No corresponde a entrevsita especificada');
                return redirect()->back();
            }

        }
        else {
            Flash::warning('Corresponde a una entrevista distinta');
            return redirect()->back();
        }


    }

    /**
     * Update the specified f_entrevista in storage.
     *
     * @param  int              $id
     * @param Updatef_entrevistaRequest $request
     *
     * @return Response
     */
    public function update($id, Updatef_entrevistaRequest $request)
    {
        $entrevista = entrevista::find($id);

        if(empty($entrevista)) {
            Flash::error("No existe la ficha $id.");
            return redirect()->back();
        }
        //$id_e_ind_fvt = $entrevista->id_e_ind_fvt;

        //Actualizar la BD
        $request->id_e_ind_fvt = $entrevista->id_e_ind_fvt;
        $request['id_e_ind_fvt'] = $entrevista->id_e_ind_fvt; //
        $nuevo = entrevista::nuevo_procesar_request($request);

        //Actualiar si la entrevista menciona temas con escasa documentación
        $ei = entrevista_individual::find($nuevo->id_e_ind_fvt);
        if($ei) {
            $ei->id_prioritario = $request->id_prioritario;
            $ei->prioritario_tema = $request->prioritario_tema;
            $ei->save();
        }

        return redirect()->action('entrevista_individualController@fichas', $nuevo->id_e_ind_fvt);
    }

    /**
     * Remove the specified f_entrevista from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        return redirect('/');
        $fEntrevista = $this->fEntrevistaRepository->findWithoutFail($id);

        if (empty($fEntrevista)) {
            Flash::error('F Entrevista not found');

            return redirect(route('fEntrevistas.index'));
        }

        $this->fEntrevistaRepository->delete($id);

        Flash::success('F Entrevista deleted successfully.');

        return redirect(route('fEntrevistas.index'));
    }
}
