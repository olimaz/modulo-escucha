<?php

namespace App\Http\Controllers;

use App\Exports\analitica_exilio_salidaExport;
use App\Exports\excel_entrevista_seguimientoExport;
use App\Exports\exilioExport;
use App\Http\Requests\CreateexilioRequest;
use App\Http\Requests\UpdateexilioRequest;
use App\Models\entrevista_individual;
use App\Models\exilio;
use App\Models\exilio_movimiento;
use App\Models\traza_actividad;
use App\Repositories\exilioRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class exilioController extends AppBaseController
{
    /** @var  exilioRepository */
    private $exilioRepository;

    public function __construct(exilioRepository $exilioRepo)
    {
        $this->exilioRepository = $exilioRepo;
    }

    /**
     * Display a listing of the exilio.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->exilioRepository->pushCriteria(new RequestCriteria($request));
        $exilios = $this->exilioRepository->all();

        return view('exilios.index')
            ->with('exilios', $exilios);
    }

    /**
     * Show the form for creating a new exilio.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $expediente = entrevista_individual::find($request->id_e_ind_fvt);
        if($expediente) {
            $exilio = new exilio();
            $movimiento = new exilio_movimiento();
            $movimiento->id_lugar_llegada=9176; //Internacional
            $movimiento->id_lugar_llegada_2=9176; //Internacional
            // Para regresar a la pantalla de hechos y no la de fichas
            $id_hecho = isset($request->id_hecho) ? $request->id_hecho : 0;

            return view('exilios.create',compact('expediente','exilio','movimiento','id_hecho'));
        }
        else {
            abort(403,"Debe indicar la entrevista a la que se adiciona la ficha");
        }
    }


    /**
     * Store a newly created exilio in storage.
     *
     * @param CreateexilioRequest $request
     *
     * @return Response
     */
    public function store(CreateexilioRequest $request)
    {
        $input = $request->all();
        $existe = entrevista_individual::find($request->id_e_ind_fvt);
        if(!$existe) {
            abort(403,'No existe la entrevista indicada');
        }
        else {
            $exilio = new exilio();
            $exilio->id_e_ind_fvt = $request->id_e_ind_fvt;
            $exilio->completar_traza_insert();
            $exilio->save();
            traza_actividad::create(['id_objeto'=>110, 'id_accion'=>3, 'codigo'=>$existe->entrevista_codigo,  'id_primaria'=>$exilio->id_exilio]);
            $exilio->procesar_detalle($request);
            $exilio->crear_movimiento($request);
        }

        $url=action('exilioController@show',$exilio->id_exilio);
        $url = $url."?id_hecho=$request->id_hecho&edicion=1";
        return redirect($url);

        //return redirect()->action('exilioController@show',$exilio->id_exilio);
    }

    /**
     * Display the specified exilio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, Request $request)
    {
        //$exilio = $this->exilioRepository->findWithoutFail($id);
        $exilio = exilio::find($id);

        if (empty($exilio)) {
            Flash::error('Exilio no existe');

            return redirect()->back();
        }
        $salida = $exilio->primera_salida();
        // Para regresar a la pantalla de hechos y no la de fichas
        $id_hecho = isset($request->id_hecho) ? $request->id_hecho : 0;
        //Para regresar al hechoController@show o @edit
        $edicion = isset($request->edicion) ? $request->edicion : 2;

        return view('exilios.show')->with('exilio', $exilio)
                                        ->with('salida',$salida)
                                        ->with('id_hecho',$id_hecho)
                                        ->with('edicion',$edicion);
    }

    //El show se usa para editar, este es igual que el show, sin botones de edicon
    public function show_lectura($id, Request $request)
    {
        $exilio = exilio::find($id);

        if (empty($exilio)) {
            Flash::error('Exilio no existe..');

            return redirect()->back();
        }
        $salida = $exilio->primera_salida();
        // Para regresar a la pantalla de hechos y no la de fichas
        $id_hecho = isset($request->id_hecho) ? $request->id_hecho : 0;
        //Para regresar al hechoController@show o @edit
        $edicion = isset($request->edicion) ? $request->edicion : 2;

        return view('exilios.show')->with('exilio', $exilio)
            ->with('salida',$salida)
            ->with('id_hecho',$id_hecho)
            ->with('edicion',$edicion)
            ->with('no_editar',true);
    }

    /**
     * Show the form for editing the specified exilio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id, Request $request)
    {
        $exilio = $this->exilioRepository->findWithoutFail($id);

        if (empty($exilio)) {
            Flash::error('Exilio not found');

            return redirect(route('exilios.index'));
        }
        $movimiento = $exilio->primera_salida();
        $expediente = $exilio->rel_id_e_ind_fvt;

        // Para regresar a la pantalla de hechos y no la de fichas
        $id_hecho = isset($request->id_hecho) ? $request->id_hecho : 0;


        return view('exilios.edit')->with('exilio', $exilio)->with('movimiento',$movimiento)->with('expediente',$expediente)->with('id_hecho',$id_hecho);
    }

    /**
     * Update the specified exilio in storage.
     *
     * @param  int              $id
     * @param UpdateexilioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateexilioRequest $request)
    {
        $exilio = $this->exilioRepository->findWithoutFail($id);

        if (empty($exilio)) {
            Flash::error('Exilio not found');
            return redirect(route('exilios.index'));
        }
        $exilio->completar_traza_update();
        $exilio->save();
        //
        $entrevista = entrevista_individual::find($exilio->id_e_ind_fvt);
        traza_actividad::create(['id_objeto'=>110, 'id_accion'=>4, 'codigo'=>$entrevista->entrevista_codigo,  'id_primaria'=>$exilio->id_exilio]);


        $exilio = $this->exilioRepository->update($request->all(), $id);
        $exilio->procesar_detalle($request);
        $exilio->actualizar_movimiento($request);

        //return redirect()->action('entrevista_individualController@fichas',$exilio->id_e_ind_fvt);
        if($request->id_hecho > 0) {
            return redirect()->action('hechoController@edit',$request->id_hecho);
        }
        else {
            return redirect()->action('exilioController@show',$exilio->id_exilio);
        }




        //return redirect(route('exilios.index'));
    }

    /**
     * Remove the specified exilio from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $exilio = $this->exilioRepository->findWithoutFail($id);

        if (empty($exilio)) {
            Flash::error('Exilio not found');

            return redirect(route('exilios.index'));
        }

        $this->exilioRepository->delete($id);

        return redirect()->back();
    }


    public static function exportar_exilio() {
        $inicio = \Carbon\Carbon::now();
        //$archivo =  base_path('public/fichas_exilio.xlsx');
        $archivo =  'public/fichas_exilio.xlsx';
        //$archivo =  Storage::url('fichas_exilio.xlsx');

        $res = Excel::store(new exilioExport(), $archivo);
        $fin= \Carbon\Carbon::now();
        $tiempo = $inicio->diffForHumans($fin);
        $respuesta=new \stdClass();
        $respuesta->inicio=$inicio;
        $respuesta->fin=$fin;
        $respuesta->tiempo=$tiempo;
        $respuesta->resultado=$res;
        $respuesta->archivo=$archivo;
        //$respuesta->total=$archivo;

        return response()->json($respuesta);

        // return redirect(url("/"));

    }


    //Para ver el excel como vista y no como archivo descargable.
    public static function excel_exilio() {
        $info = exilio::exportar_excel();
        return view('exilios.excel',compact('info'));
    }

    public static function descargar_exilio_salida() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>111, 'id_accion'=>8]);
        return Excel::download(new analitica_exilio_salidaExport(),"exilio_salida_$fecha.xlsx");
    }

}
