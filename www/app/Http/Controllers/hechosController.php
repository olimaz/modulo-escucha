<?php

//DEMO.  Versión de pruebas

namespace App\Http\Controllers;

use App\Http\Requests\CreatehechosRequest;
use App\Http\Requests\UpdatehechosRequest;
use App\Models\entrevista;
use App\Models\entrevista_individual;
use App\Models\hechos;
use App\Models\hechos_fuerza;
use App\Models\hechos_responsable;
use App\Models\hechos_victima;
use App\Models\hechos_violacion;
use App\Models\victima;
use App\Repositories\hechosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class hechosController extends AppBaseController
{
    /** @var  hechosRepository */
    private $hechosRepository;

    public function __construct(hechosRepository $hechosRepo)
    {
        $this->hechosRepository = $hechosRepo;
    }

    /**
     * Display a listing of the hechos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->hechosRepository->pushCriteria(new RequestCriteria($request));
        $hechos = $this->hechosRepository->all();

        return view('hechos.index')
            ->with('hechos', $hechos);
    }

    /**
     * Show the form for creating a new hechos.
     *
     * @return Response
     */
    public function create($id_expediente)
    {
        $expediente = entrevista_individual::find($id_expediente);
        if($expediente) {
            $hechos = new hechos();
            //$entrevista->fecha = $expediente->entrevista_fecha;
            //$entrevista->id_lugar=$expediente->entrevista_lugar;
            return view('hechos.create', compact('expediente','hechos'));
        }
        else {
            return redirect()->action('entrevista_individualController@index');
        }
    }

    /**
     * Store a newly created hechos in storage.
     *
     * @param CreatehechosRequest $request
     *
     * @return Response
     */
    public function store($id, CreatehechosRequest $request)
    {
        $input = $request->all();
        $input['id_e_ind_fvt']=$id;
        $input['id_usuario']=\Auth::user()->id;
        $input['hechos_fecha'] = $request->hechos_fecha_submit;
        $input['id_entrevista']=entrevista::where('id_e_ind_fvt',$id)->first()->id_entrevista;

        //$hechos = hechos::create($input);  //Los default no permiten esto
        $hechos = new hechos();
        $hechos->fill($input);
        $hechos->save();

        //Adjuntar entidades debiles
        foreach($request->id_victima as $id_victima) {
            hechos_victima::create(['id_hechos'=>$hechos->id_hechos, 'id_victima'=>$id_victima, 'id_e_ind_fvt'=>$id,'id_usuario'=>$input['id_usuario']]);
        }
        if(is_array($request->id_responsable)) {
            foreach($request->id_responsable as $id_responsable) {
                hechos_responsable::create(['id_hechos'=>$hechos->id_hechos, 'id_responsable'=>$id_responsable, 'id_e_ind_fvt'=>$id,'id_usuario'=>$input['id_usuario']]);
            }
        }

        foreach($request->id_violacion as $id_violacion) {
            hechos_violacion::create(['id_hechos'=>$hechos->id_hechos, 'id_violacion'=>$id_violacion, 'id_e_ind_fvt'=>$id,'id_usuario'=>$input['id_usuario']]);
        }
        foreach($request->id_fuerza as $id_fuerza) {
            hechos_fuerza::create(['id_hechos'=>$hechos->id_hechos, 'id_fuerza'=>$id_fuerza, 'id_e_ind_fvt'=>$id,'id_usuario'=>$input['id_usuario']]);
        }

        return redirect(action('entrevista_individualController@fichas',$id));
    }

    /**
     * Display the specified hechos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $hechos = $this->hechosRepository->findWithoutFail($id);

        if (empty($hechos)) {
            Flash::error('Hechos not found');

            return redirect(route('hechos.index'));
        }

        return view('hechos.show')->with('hechos', $hechos);
    }

    /**
     * Show the form for editing the specified hechos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $hechos = $this->hechosRepository->findWithoutFail($id);

        if (empty($hechos)) {
            Flash::error('Hechos not found');

            return redirect(route('hechos.index'));
        }

        return view('hechos.edit')->with('hechos', $hechos);
    }

    /**
     * Update the specified hechos in storage.
     *
     * @param  int              $id
     * @param UpdatehechosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatehechosRequest $request)
    {
        $hechos = $this->hechosRepository->findWithoutFail($id);

        if (empty($hechos)) {
            Flash::error('Hechos not found');

            return redirect(route('hechos.index'));
        }

        $hechos = $this->hechosRepository->update($request->all(), $id);

        Flash::success('Hechos updated successfully.');

        return redirect(route('hechos.index'));
    }

    /**
     * Remove the specified hechos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $hechos = $this->hechosRepository->findWithoutFail($id);

        if (empty($hechos)) {
            Flash::error('Hechos not found');

            return redirect(route('hechos.index'));
        }

        $this->hechosRepository->delete($id);

        Flash::success('Hechos deleted successfully.');

        return redirect(route('hechos.index'));
    }
}
