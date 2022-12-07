<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedesclasificarRequest;
use App\Http\Requests\UpdatedesclasificarRequest;
use App\Models\adjunto;
use App\Models\desclasificar;
use App\Models\traza_actividad;
use App\Repositories\desclasificarRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Gate;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class desclasificarController extends AppBaseController
{
    /** @var  desclasificarRepository */
    private $desclasificarRepository;

    public function __construct(desclasificarRepository $desclasificarRepo)
    {
        $this->desclasificarRepository = $desclasificarRepo;
    }

    /**
     * Display a listing of the desclasificar.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->authorize('nivel-1');

        $filtros = desclasificar::filtros_default($request);

        $query = desclasificar::filtrar($filtros);
            $debug['sql']= nl2br($query->toSql());
            $debug['criterios']=$query->getBindings();
            //dd($debug);

        $listado = $query->ordenar()->paginate(50);


        return view('desclasificars.index')
            ->with('filtros', $filtros)
            ->with('desclasificars', $listado);
    }

    /**
     * Show the form for creating a new desclasificar.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $this->authorize('nivel-1');

        if(isset($request->id_autorizado)) {
            $del=date("Y-m-d 00:00:00");
            $al=date("Y-m-d 23:59:59");
            $query= desclasificar::id_autorizado($request->id_autorizado)
                ->wherebetween('fh_insert',[$del,$al])
                ->id_activo(1)
                ->orderby('fh_insert','desc');

            $debug['sql']= nl2br($query->toSql());
            $debug['criterios']=$query->getBindings();
            //dd($debug);


            $ultimo = $query->first();
            $listado = $query->paginate(50);

            //dd($listado);

            //dd($ultimo);
            if(!$ultimo) {
                $ultimo = new desclasificar();
            }
        }
        else {
            $ultimo = new desclasificar();
            $listado=array();
        }

        //dd($ultimo->fecha_rango);
        return view('desclasificars.create',compact('ultimo','listado'));
    }

    /**
     * Store a newly created desclasificar in storage.
     *
     * @param CreatedesclasificarRequest $request
     *
     * @return Response
     */
    public function store(CreatedesclasificarRequest $request)
    {
        $input = $request->all();
        //dd($input);
        $codigo = trim($request->entrevista_codigo);
        $codigo = str_ireplace(","," ",$codigo);
        $arreglo = explode(" ",$codigo);

        $si=array();
        $no=array();
        foreach($arreglo as $codigo) {
            $codigo=trim($codigo);
            if(strlen($codigo)>0) {
                $existe = desclasificar::buscar_entrevista($codigo);
                $puede = false;  //Valor por defecto, por si acaso
                if($existe->id_primaria > 0) {
                    if($existe->nivel == 1) {
                        if(Gate::allows('es-propio',$existe->entrevista->id_entrevistador)) {
                            $puede = true;
                        }
                        else {
                            $puede = false;
                            $no[] = $codigo. " (R-$existe->nivel) no es propia ";
                        }
                    }
                    elseif(in_array($existe->nivel, [2,3])) {
                        $puede=true;
                    }
                    else {
                        $puede=false;
                        $no[] = $codigo. " (R-$existe->nivel)";

                    }
                }
                else {
                    $puede=false;
                    $no[] = $codigo. " (inexistente)";
                }

                if($puede) {
                    $input['id_primaria']=$existe->id_primaria;
                    $input['id_subserie']=$existe->id_subserie;
                    $input['id_autorizador']=\Auth::user()->id_entrevistador;
                    //Adjunto
                    if($request->hasFile('archivo_20')) {
                        $nombre_original=$request->file('archivo_20')->getClientOriginalName();
                        $input['id_adjunto'] = adjunto::crear_adjunto($request->archivo_20_filename, $nombre_original);
                    }

                    $fecha_rango=explode(" - ",$request->fecha_rango);
                    try {
                        $fh_del = Carbon::createFromFormat("d/m/Y",$fecha_rango[0])->format("Y-m-d");
                        $fh_al = Carbon::createFromFormat("d/m/Y",$fecha_rango[1])->format("Y-m-d");
                    }
                    catch(\Exception $e) {
                        Flash::error("Fecha de la autorización  inválida, favor de revisar este dato");
                        return redirect()->back()->withInput($request->all());
                    }
                    $input['fh_del']=$fh_del;
                    $input['fh_al']=$fh_al;
                    try {
                        $desclasificar = desclasificar::create($input);
                        $si[]=$codigo;
                        //Traza
                        $e = $desclasificar->entrevista->entrevista;
                        $id_objeto   = traza_actividad::de_subserie_a_traza($desclasificar->id_subserie);
                        $id_primaria = $desclasificar->id_primaria;
                        $referencia = $desclasificar->fmt_id_autorizado;
                        traza_actividad::create(['id_objeto'=>$id_objeto, 'id_accion'=>11, 'codigo'=>$e->entrevista_codigo, 'referencia'=>$referencia , 'id_primaria'=>$id_primaria]);
                    }
                    catch (\exepction $e) {
                        $no[] = $codigo.": ".$e->getMessage();
                    }
                }

            }

        }

        $cuales_si = implode(", ",$si);
        $cuales_no = implode(", ",$no);




        if(count($no)>0) {
            $texto = "No se procesaron algunos códigos: $cuales_no. ";
            Flash::error($texto);
        }
        if(count($si)>0) {
            $texto = "Se procesaron los código indicados<br> Códigos exitosos: $cuales_si. ";
            Flash::success($texto);
        }


        $url=action('desclasificarController@create');

        return redirect($url."?id_autorizado=$request->id_autorizado");
    }

    /**
     * Display the specified desclasificar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $this->authorize('nivel-1');
        $desclasificar = $this->desclasificarRepository->findWithoutFail($id);

        if (empty($desclasificar)) {
            Flash::error('Desclasificar not found');

            return redirect(route('desclasificars.index'));
        }

        return view('desclasificars.show')->with('desclasificar', $desclasificar);
    }

    /**
     * Show the form for editing the specified desclasificar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        abort(403);
        $desclasificar = $this->desclasificarRepository->findWithoutFail($id);

        if (empty($desclasificar)) {
            Flash::error('Desclasificar not found');

            return redirect(route('desclasificars.index'));
        }

        return view('desclasificars.edit')->with('desclasificar', $desclasificar);
    }

    /**
     * Update the specified desclasificar in storage.
     *
     * @param  int              $id
     * @param UpdatedesclasificarRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedesclasificarRequest $request)
    {
        abort(403);
        $desclasificar = $this->desclasificarRepository->findWithoutFail($id);

        if (empty($desclasificar)) {
            Flash::error('Desclasificar not found');

            return redirect(route('desclasificars.index'));
        }

        $desclasificar = $this->desclasificarRepository->update($request->all(), $id);

        Flash::success('Desclasificar updated successfully.');

        return redirect(route('desclasificars.index'));
    }

    /**
     * Remove the specified desclasificar from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->authorize('nivel-1');
        $desclasificar = $this->desclasificarRepository->findWithoutFail($id);

        if (empty($desclasificar)) {
            Flash::error('Desclasificar not found');
            return redirect(route('desclasificars.index'));
        }

        //Traza
        $e = $desclasificar->entrevista->entrevista;
        $id_objeto   = traza_actividad::de_subserie_a_traza($desclasificar->id_subserie);
        $id_primaria = $desclasificar->id_primaria;
        $referencia = $desclasificar->fmt_id_autorizado;
        traza_actividad::create(['id_objeto'=>$id_objeto, 'id_accion'=>12, 'codigo'=>$e->entrevista_codigo, 'referencia'=>$referencia , 'id_primaria'=>$id_primaria]);


        $this->desclasificarRepository->delete($id);

        Flash::success('Desclasificar deleted successfully.');

        return redirect(route('desclasificars.index'));
    }
}
