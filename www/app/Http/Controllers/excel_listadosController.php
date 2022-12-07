<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createexcel_listadosRequest;
use App\Http\Requests\Updateexcel_listadosRequest;
use App\Models\excel_listados;
use App\Models\traza_actividad;
use App\Repositories\excel_listadosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class excel_listadosController extends AppBaseController
{
    /** @var  excel_listadosRepository */
    private $excelListadosRepository;

    public function __construct(excel_listadosRepository $excelListadosRepo)
    {
        $this->excelListadosRepository = $excelListadosRepo;
    }

    /**
     * Display a listing of the excel_listados.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->excelListadosRepository->pushCriteria(new RequestCriteria($request));
        if(\Gate::allows('nivel-1')) {
            $excelListados = excel_listados::ordenar()->get();
        }
        else {
            $excelListados = excel_listados::disponibles()->ordenar()->get();
        }


        return view('excel_listados.index')
            ->with('excelListados', $excelListados);
    }

    /**
     * Show the form for creating a new excel_listados.
     *
     * @return Response
     */
    public function create()
    {
        return view('excel_listados.create');
    }

    /**
     * Store a newly created excel_listados in storage.
     *
     * @param Createexcel_listadosRequest $request
     *
     * @return Response
     */
    public function store(Createexcel_listadosRequest $request)
    {
        $input = $request->all();
        if(\Auth::check()) {
            $input['id_entrevistador']=\Auth::user()->id_entrevistador;
        }
        $nuevo = new excel_listados();
        $nuevo->fill($input);
        $nuevo->save();

        $res = $nuevo->cargar_adjunto($request);
        $si=$nuevo->cantidad_codigos_si;

        Flash::success("Archivo cargado exitosamente: $si códigos válidos encontrados");

        traza_actividad::create(['id_objeto'=>30, 'id_accion'=>3, 'codigo'=>'Carga de excel', 'id_primaria'=>$nuevo->id_censo_archivos_adjunto, 'referencia'=>$nuevo->descripcion]);

        return redirect(route('excelListados.index'));
    }

    /**
     * Display the specified excel_listados.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $excelListados = $this->excelListadosRepository->findWithoutFail($id);

        if (empty($excelListados)) {
            Flash::error("Identificador no encontrado:$id.");

            return redirect(route('excelListados.index'));
        }

        return view('excel_listados.show')->with('excelListados', $excelListados);
    }

    /**
     * Show the form for editing the specified excel_listados.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $excelListados = $this->excelListadosRepository->findWithoutFail($id);

        if (empty($excelListados)) {
            Flash::error("Identificador no encontrado:$id.");

            return redirect(route('excelListados.index'));
        }

        return view('excel_listados.edit')->with('excelListados', $excelListados);
    }

    /**
     * Update the specified excel_listados in storage.
     *
     * @param  int              $id
     * @param Updateexcel_listadosRequest $request
     *
     * @return Response
     */
    public function update($id, Updateexcel_listadosRequest $request)
    {
        $excelListados = $this->excelListadosRepository->findWithoutFail($id);

        if (empty($excelListados)) {
            Flash::error("Identificador no encontrado:$id.");

            return redirect(route('excelListados.index'));
        }

        $excelListados = $this->excelListadosRepository->update($request->all(), $id);

        $res = $excelListados->actualizar_adjunto($request);


        //Flash::success('Información actualizada.');

        traza_actividad::create(['id_objeto'=>30, 'id_accion'=>4, 'codigo'=>'Carga de excel', 'id_primaria'=>$excelListados->id_censo_archivos_adjunto, 'referencia'=>$excelListados->descripcion]);

        return redirect(action('excel_listadosController@show',$excelListados->id_excel_listados));
    }

    /**
     * Remove the specified excel_listados from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $excelListados = $this->excelListadosRepository->findWithoutFail($id);

        if (empty($excelListados)) {
            Flash::error("Identificador no encontrado:$id.");

            return redirect(route('excelListados.index'));
        }

        $estado = $excelListados->id_activo==1 ? 2 : 1;
        $excelListados->id_estado = $estado;
        $excelListados->save();

        Flash::success('Archivo actualizado');

        return redirect(route('excelListados.index'));
    }
}
