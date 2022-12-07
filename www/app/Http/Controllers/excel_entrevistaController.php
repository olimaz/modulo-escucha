<?php

namespace App\Http\Controllers;

use App\Exports\excel_entrevista_seguimientoExport;
use App\Exports\nvivo_clasificadorExport;
use App\Http\Requests\Createexcel_entrevistaRequest;
use App\Http\Requests\Updateexcel_entrevistaRequest;
use App\Models\analitica_victima;
use App\Models\analitica_victima_violencia;
use App\Models\analitica_violencia;
use App\Models\excel_etiquetado;
use App\Models\nvivo_clasificador;
use App\Models\traza_actividad;
use App\Repositories\excel_entrevistaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Maatwebsite\Excel\Facades\Excel;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class excel_entrevistaController extends AppBaseController
{
    /** @var  excel_entrevistaRepository */
    private $excelEntrevistaRepository;

    public function __construct(excel_entrevistaRepository $excelEntrevistaRepo)
    {
        $this->excelEntrevistaRepository = $excelEntrevistaRepo;
    }

    /**
     * Display a listing of the excel_entrevista.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        /*
        $this->excelEntrevistaRepository->pushCriteria(new RequestCriteria($request));
        $excelEntrevistas = $this->excelEntrevistaRepository->all();

        return view('excel_entrevistas.index')
            ->with('excelEntrevistas', $excelEntrevistas);
        */
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        return view('excel_entrevistas.index');
    }

    /**
     * Show the form for creating a new excel_entrevista.
     *
     * @return Response
     */
    public function create()
    {
        return view('excel_entrevistas.create');
    }

    /**
     * Store a newly created excel_entrevista in storage.
     *
     * @param Createexcel_entrevistaRequest $request
     *
     * @return Response
     */
    public function store(Createexcel_entrevistaRequest $request)
    {
        $input = $request->all();

        $excelEntrevista = $this->excelEntrevistaRepository->create($input);

        Flash::success('Excel Entrevista saved successfully.');

        return redirect(route('excelEntrevistas.index'));
    }

    /**
     * Display the specified excel_entrevista.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $excelEntrevista = $this->excelEntrevistaRepository->findWithoutFail($id);

        if (empty($excelEntrevista)) {
            Flash::error('Excel Entrevista not found');

            return redirect(route('excelEntrevistas.index'));
        }

        return view('excel_entrevistas.show')->with('excelEntrevista', $excelEntrevista);
    }

    /**
     * Show the form for editing the specified excel_entrevista.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $excelEntrevista = $this->excelEntrevistaRepository->findWithoutFail($id);

        if (empty($excelEntrevista)) {
            Flash::error('Excel Entrevista not found');

            return redirect(route('excelEntrevistas.index'));
        }

        return view('excel_entrevistas.edit')->with('excelEntrevista', $excelEntrevista);
    }

    /**
     * Update the specified excel_entrevista in storage.
     *
     * @param  int              $id
     * @param Updateexcel_entrevistaRequest $request
     *
     * @return Response
     */
    public function update($id, Updateexcel_entrevistaRequest $request)
    {
        $excelEntrevista = $this->excelEntrevistaRepository->findWithoutFail($id);

        if (empty($excelEntrevista)) {
            Flash::error('Excel Entrevista not found');

            return redirect(route('excelEntrevistas.index'));
        }

        $excelEntrevista = $this->excelEntrevistaRepository->update($request->all(), $id);

        Flash::success('Excel Entrevista updated successfully.');

        return redirect(route('excelEntrevistas.index'));
    }

    /**
     * Remove the specified excel_entrevista from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $excelEntrevista = $this->excelEntrevistaRepository->findWithoutFail($id);

        if (empty($excelEntrevista)) {
            Flash::error('Excel Entrevista not found');

            return redirect(route('excelEntrevistas.index'));
        }

        $this->excelEntrevistaRepository->delete($id);

        Flash::success('Excel Entrevista deleted successfully.');

        return redirect(route('excelEntrevistas.index'));
    }

    //Descargar NVIVO
    public function descargar_excel_nvivo() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>107, 'id_accion'=>8]);
        return Excel::download(new nvivo_clasificadorExport(),"clasificador_nvivo_$fecha.xlsx");
    }
    //Generar tabla de NVIVO
    public function generar_nvivo() {
        $respuesta = nvivo_clasificador::generar_plana();
        return response()->json($respuesta);
    }

    //Generar tabla de etiquetado
    public function generar_etiquetad() {
        $respuesta = excel_etiquetado::generar_plana();
        return response()->json($respuesta);
    }
}
