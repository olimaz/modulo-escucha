<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateentrevistadoRequest;
use App\Http\Requests\UpdateentrevistadoRequest;
use App\Models\consentimiento;
use App\Models\entrevista;
use App\Models\entrevista_individual;
use App\Models\entrevistado;
use App\Models\victima;
use App\Repositories\entrevistadoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class entrevistadoController extends AppBaseController
{
    /** @var  entrevistadoRepository */
    private $entrevistadoRepository;

    public function __construct(entrevistadoRepository $entrevistadoRepo)
    {
        $this->entrevistadoRepository = $entrevistadoRepo;
    }

    /**
     * Display a listing of the entrevistado.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->entrevistadoRepository->pushCriteria(new RequestCriteria($request));
        $entrevistados = $this->entrevistadoRepository->all();

        return view('entrevistados.index')
            ->with('entrevistados', $entrevistados);
    }

    /**
     * Show the form for creating a new entrevistado.
     *
     * @return Response
     */
    public function create($id_expediente)
    {
        $expediente = entrevista_individual::find($id_expediente);
        if($expediente) {
            $entrevistado = new entrevistado();
            $entrevistado->fecha=date("Y-m-d"); //Para el consentimiento
            //$entrevista->fecha = $expediente->entrevista_fecha;
            //$entrevista->id_lugar=$expediente->entrevista_lugar;
            return view('entrevistados.create', compact('entrevistado','expediente'));
        }
        else {
            return redirect()->action('entrevista_individualController@index');
        }


    }

    /**
     * Store a newly created entrevistado in storage.
     *
     * @param CreateentrevistadoRequest $request
     *
     * @return Response
     */
    public function store($id, CreateentrevistadoRequest $request)
    {
        $input = $request->all();
        $input['id_e_ind_fvt']=$id;
        $input['id_usuario']=\Auth::user()->id;
        $input['id_entrevista']=entrevista::where('id_e_ind_fvt',$id)->first()->id_entrevista;
        $input['nacimiento_fecha'] = $request->nacimiento_fecha_submit;
        $input['fecha'] = $request->fecha_submit; //firma del consentimiento


        //dd($input);

        //No uso create porque me cambia los default con el __construct
        //$entrevistado = entrevistado::create($input);
        $entrevistado = new entrevistado();
        $entrevistado->fill($input);
        $entrevistado->save();


        $consentimiento = new consentimiento();
        $consentimiento->fill($input);
        $consentimiento->save();


        //Duplicarlo si es victima
        if($entrevistado->es_victima==1) {
            $victima = $input;
            $victima['es_declarante']=1;
            $victima['id_declarante'] = $entrevistado->id_entrevistado;
            $duplicado = new victima();
            $duplicado->fill($victima);
            $duplicado->save();
        }
        //Flash::success('Entrevistado saved successfully.');

        return redirect(action('entrevista_individualController@fichas',$id));
    }

    /**
     * Display the specified entrevistado.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $entrevistado = $this->entrevistadoRepository->findWithoutFail($id);

        if (empty($entrevistado)) {
            Flash::error('Entrevistado not found');

            return redirect(route('entrevistados.index'));
        }

        return view('entrevistados.show')->with('entrevistado', $entrevistado);
    }

    /**
     * Show the form for editing the specified entrevistado.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $entrevistado = $this->entrevistadoRepository->findWithoutFail($id);

        if (empty($entrevistado)) {
            Flash::error('Entrevistado not found');

            return redirect(route('entrevistados.index'));
        }

        return view('entrevistados.edit')->with('entrevistado', $entrevistado);
    }

    /**
     * Update the specified entrevistado in storage.
     *
     * @param  int              $id
     * @param UpdateentrevistadoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateentrevistadoRequest $request)
    {
        $entrevistado = $this->entrevistadoRepository->findWithoutFail($id);

        if (empty($entrevistado)) {
            Flash::error('Entrevistado not found');

            return redirect(route('entrevistados.index'));
        }

        $entrevistado = $this->entrevistadoRepository->update($request->all(), $id);

        Flash::success('Entrevistado updated successfully.');

        return redirect(route('entrevistados.index'));
    }

    /**
     * Remove the specified entrevistado from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $entrevistado = $this->entrevistadoRepository->findWithoutFail($id);

        if (empty($entrevistado)) {
            Flash::error('Entrevistado not found');

            return redirect(route('entrevistados.index'));
        }

        $this->entrevistadoRepository->delete($id);

        Flash::success('Entrevistado deleted successfully.');

        return redirect(route('entrevistados.index'));
    }
}
