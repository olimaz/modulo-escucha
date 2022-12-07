<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatehechoRequest;
use App\Http\Requests\UpdatehechoRequest;
use App\Models\entrevista_individual;
use App\Models\hecho;
use App\Repositories\hechoRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\entrevista_etnica;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class hechoController extends AppBaseController
{
    /** @var  hechoRepository */
    private $hechoRepository;

    public function __construct(hechoRepository $hechoRepo)
    {
        $this->hechoRepository = $hechoRepo;
    }

    /**
     * Display a listing of the hecho.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        abort(403);
        //$this->hechoRepository->pushCriteria(new RequestCriteria($request));
        $hechos = hecho::all();

        return view('hechos.index')
            ->with('hechos', $hechos);
    }

    /**
     * Show the form for creating a new hecho.
     *
     * @return Response
     */
    public function create_original(Request $request)
    {
        if(!isset($request->id_e_ind_fvt)) {
            abort(403,'Debe especificar la entrevista a la que se adicionará el hecho');
        }
        else {
            $entrevista=entrevista_individual::find($request->id_e_ind_fvt);
            if(!$entrevista) {
                abort(403,"No existe la entrevista con el id $request->id_e_ind_fvt");
            }
        }
        $hecho = new hecho();
        $hecho->valores_predeterminados($entrevista);
        return view('hechos.create',compact('hecho','entrevista'));
    }

    public function create(Request $request)
    {
        $bandera = 0;
        
        if (isset($request->id_e_ind_fvt))
            $bandera = 1;
        elseif (isset($request->id_entrevista_etnica)){
            $bandera = 2;
        } else {            
            Flash::error("La entrevista consultada no existe"); // Redireccionar a la lista de entrevistas
            abort(403,'La entrevista consultada no existe.');
        }

        if ($bandera == 1) { // Si existe la entrevista individual: victimas, familiares o testigos
            
            $entrevista=entrevista_individual::find($request->id_e_ind_fvt);
            
            if(!$entrevista) {
                abort(403,"No existe la entrevista con el id $request->id_e_ind_fvt");
            } 

        } elseif ($bandera == 2) { // Si existe la entrevista sujeto colectivo

            $entrevista=entrevista_etnica::find($request->id_entrevista_etnica);
            
            if(!$entrevista) {
                abort(403,"No existe la entrevista con el id $request->id_entrevista_etnica");
            }                        

        } else {
            abort(403,'Debe especificar la entrevista a la que se adicionará el hecho');
        }
        
        // if(!isset($request->id_e_ind_fvt)) {
        //     abort(403,'Debe especificar la entrevista a la que se adicionará el hecho');
        // }
        // else {
        //     $entrevista=entrevista_individual::find($request->id_e_ind_fvt);
        //     if(!$entrevista) {
        //         abort(403,"No existe la entrevista con el id $request->id_e_ind_fvt");
        //     }
        // }

        

        $hecho = new hecho();
        $hecho->valores_predeterminados($entrevista);        
        $hecho->save();
        
        return redirect()->action('hechoController@edit',$hecho->id_hecho);
        //return view('hechos.edit')->with('hecho', $hecho);
        //return view('hechos.create',compact('hecho','entrevista'));
    }

    /**
     * Store a newly created hecho in storage.
     *
     * @param CreatehechoRequest $request
     *
     * @return Response
     */
    public function store(CreatehechoRequest $request)
    {


        $input = $request->all();
        //dd($input);
        $hecho = $this->hechoRepository->create($input);
        //dd($hecho);
        //Flash::success('Hecho saved successfully.');
        //return redirect(action('entrevista_individualController@fichas',$hecho->id_e_ind_fvt));

        return redirect(action('hechoController@detallar',$hecho->id_hecho));
    }


    // Agregar violencias, victimas, responsables, contexto
    public function detallar($id)
    {
        $hecho = $this->hechoRepository->findWithoutFail($id);

        if (empty($hecho)) {
            abort(403,"Hecho no existe ($id)");
            //Flash::error("Hecho no existe ($id)");
            return redirect(route('hechos.index'));
        }

        return view('hechos.detallar_2')->with('hecho', $hecho);
    }

    /**
     * Display the specified hecho.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, Request $request)
    {
        $hecho = $this->hechoRepository->findWithoutFail($id);

        if (empty($hecho)) {
            abort(403,"Hecho no existe ($id)");
            //Flash::error("Hecho ($id) no encontrado para mostrar");
            return redirect(route('hechos.index'));
        }
        $edicion = isset($request->edicion) ? $request->edicion : 2;
        $volver_ficha_show = isset($_GET['fs']) ? 'fs' : "";

        $expediente = ($hecho->tipo_expediente()=='individual' ? $hecho->rel_id_e_ind_fvt : $hecho->rel_id_entrevista_etnica);

        $permisos = $expediente->permitir_ver_fichas();
        if($permisos->permitido) {
                        
            return view('hechos.show_2')->with('hecho', $hecho)->with('edicion', $edicion)->with('volver_ficha_show', $volver_ficha_show);
        }
        else {
            abort(403,$permisos->texto);
        }



    }

    /**
     * Show the form for editing the specified hecho.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $hecho = $this->hechoRepository->findWithoutFail($id);
        if (empty($hecho)) {
            abort(403,"Hecho no existe ($id)");
            return redirect(route('hechos.index'));
        }

        // Ajuste para integración modulo entrevista etnica
        $expediente = $hecho->expediente();

        // $expediente  = $hecho->rel_id_e_ind_fvt;
        $permisos = $expediente->permitir_modificar_fichas();
        if($permisos->permitido) {
            $conteos = $expediente->conteo_fichas();

            // Si es un hecho de una entrevista etnica y no ha llenado el consentimiento obliga a llenarlo
            // if ($hecho->tipo_expediente()=='etnica' && $conteos->entrevista == 0) {
                
            //     return redirect()->action(
            //         'entrevista_etnicaController@edit', ['id' => $expediente->id_entrevista_etnica]
            //     )->with('id_hecho', $id);
            // }

            return view('hechos.edit')->with('hecho', $hecho)->with('conteos',$conteos)->with('expediente',$expediente);
        }
        else {
            abort(403,$permisos->texto);
        }


    }

    /**
     * Update the specified hecho in storage.
     *
     * @param  int              $id
     * @param UpdatehechoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatehechoRequest $request)
    {
        //dd("Mirame");
    
        $hecho = $this->hechoRepository->findWithoutFail($id);

        if (empty($hecho)) {
            abort(403,"Hecho no existe ($id)");
            //Flash::error("Hecho ($id) no encontrado para actualizar");

            return redirect(action('entrevista_individualController@fichas',$hecho->id_e_ind_fvt));
        }

        $tipo_expendiente = $hecho->tipo_expediente();

        $input = $request->all();
        
        if ($tipo_expendiente=='individual') {
            //Lugar incompleto
            if($request->id_lugar<=0) {

                if($request->id_lugar_muni >0) {
                    //dd("mirame");
                    $input['id_lugar'] = $request->id_lugar_muni;
                }
                elseif($request->id_lugar_depto > 0) {
                    $input['id_lugar'] = $request->id_lugar_depto;
                }
                else {
                    Flash::error("Debe especificar como mínimo el departamento de los hechos");
                    return redirect()->back()->withInput($request->all());
                }
            }
        }

        $hecho->fill($input);
        $hecho->update_ip=\Request::ip();
        $hecho->update_ent=\Auth::user()->id_entrevistador;
        $hecho->update_fh=\Carbon\Carbon::now();
        $hecho->save();

        //$hecho = $this->hechoRepository->update($request->all(), $id);


        //return redirect(action('hechoController@detallar',$hecho->id_hecho));
        $fin = isset($request->fin) ? $request->fin : 0;
        if($fin==1) {

            if ($tipo_expendiente=='individual')
                return redirect(action('entrevista_individualController@fichas',$hecho->id_e_ind_fvt));
            else
                return redirect(action('entrevista_etnicaController@fichas',$hecho->id_entrevista_etnica));
        }
        else {
            return redirect()->back();
        }

    }

    /**
     * Remove the specified hecho from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        // dd("Mirame $id");
        $hecho = hecho::find($id);
        
        if($hecho) {

            // Cambio marzo: Obtiene el expediente dependient del tipo de hecho: individual o sujeto colectivo etnico
            $expediente = $hecho->expediente();

            // $expediente  = $hecho->rel_id_e_ind_fvt;

            $permisos = $expediente->permitir_modificar_fichas();

            if($permisos->permitido) {
                
                // $id_e_ind_fvt = $hecho->id_e_ind_fvt;

                $hecho->delete();

                return redirect()->action($hecho->controller.'@fichas',$hecho->id_entrevista);
                // return redirect()->action('entrevista_individualController@fichas',$id_e_ind_fvt);
            }
            else {
                abort(403,$permisos->texto);
            }

        }
        else {
            abort(403,"Hecho no existe ($id)");
        }

        return redirect()->back();

    }
}
