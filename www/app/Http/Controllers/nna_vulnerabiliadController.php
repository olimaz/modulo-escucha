<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createnna_vulnerabiliadRequest;
use App\Http\Requests\Updatenna_vulnerabiliadRequest;
use App\Models\entrevistador;
use App\Models\nna_vulnerabiliad;
use App\Models\traza_actividad;
use App\Repositories\nna_vulnerabiliadRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class nna_vulnerabiliadController extends AppBaseController
{
    /** @var  nna_vulnerabiliadRepository */
    private $nnaVulnerabiliadRepository;

    public function __construct(nna_vulnerabiliadRepository $nnaVulnerabiliadRepo)
    {
        $this->nnaVulnerabiliadRepository = $nnaVulnerabiliadRepo;
    }

    /**
     * Display a listing of the nna_vulnerabiliad.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $filtros = nna_vulnerabiliad::filtros_default($request);
        $query = nna_vulnerabiliad::filtrar($filtros)->ordenar();
        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();
        //dd($debug);
        $listado = $query->paginate();


        return view('nna_vulnerabiliads.index')
            ->with('filtros', $filtros)
            ->with('nnaVulnerabiliads', $listado);
    }

    /**
     * Show the form for creating a new nna_vulnerabiliad.
     *
     * @return Response
     */
    public function create()
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $nnaVulnerabiliad = new nna_vulnerabiliad();
        return view('nna_vulnerabiliads.create', compact('nnaVulnerabiliad'));
    }

    /**
     * Store a newly created nna_vulnerabiliad in storage.
     *
     * @param Createnna_vulnerabiliadRequest $request
     *
     * @return Response
     */
    public function store(Createnna_vulnerabiliadRequest $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $id_entrevistador=\Auth::user()->id_entrevistador;
        if(isset($request->id_entrevistador)) {
            $permitidos = entrevistador::permitidos_acceso_entrevistas();
            if(in_array($request->id_entrevistador,$permitidos)) {
                $id_entrevistador=intval($request->id_entrevistador);
            }
            else {
                $quien = entrevistador::find($request->id_entrevistador);
                $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,5,'0',STR_PAD_LEFT) : "[desconocido]";
                abort(403,"No puede ingresar casos/informes para el entrevistador especificado: $numero");
            }
        }

        //Calcular el código según función de entrevista_individual
        $item = new  nna_vulnerabiliad();
        $item->id_entrevistador=$id_entrevistador;
        $codigo = $item->asignar_codigo();  //asigna correlativo y codigo


        $input = $request->all();
        //Datos calculados
        $input['correlativo']=$item->correlativo;
        $input['codigo']=$item->codigo;
        $input['id_entrevistador']=$id_entrevistador;
        $input['id_macroterritorio']=$request->id_territorio_macro;
        //Manejo de fechas
        $input['fecha_evaluacion']=$request->fecha_evaluacion_submit;
        //dd($input);


        try {
            $nueva = new nna_vulnerabiliad();
            $nueva->fill($input);
            //dd($nueva);
            $nueva->dictamen = $nueva->calcular_dictamen();
            $nueva->save();

            Flash::success('Información almacenada exitosamente.');
            //Traza de seguridad
            traza_actividad::create(['id_objeto'=>7, 'id_accion'=>3, 'codigo'=>$nueva->codigo, 'id_primaria'=>$nueva->id_nna_vulnerabilidad]);
            return redirect()->action('nna_vulnerabiliadController@show',$nueva->id_nna_vulnerabilidad);

        }
        catch (\Exception $e) {
            Flash::error('Problemas al grabar la información: '.$e->getMessage());
            return redirect(action('nna_vulnerabiliadController@index'));
        }

    }

    /**
     * Display the specified nna_vulnerabiliad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $nnaVulnerabiliad = $this->nnaVulnerabiliadRepository->findWithoutFail($id);


        if (empty($nnaVulnerabiliad)) {
            Flash::error('Nna Vulnerabiliad not found');
            return redirect(route('nnaVulnerabiliads.index'));
        }

        if(\Gate::check('permisos-legado')) {
            //Siempre permitir
        }
        else {
            if(!\Gate::allows('es-propio',$nnaVulnerabiliad->id_entrevistador)) {
                $id_entrevistador=$nnaVulnerabiliad->id_entrevistador;
                $permitidos = entrevistador::permitidos_acceso_entrevistas();
                if(!in_array($id_entrevistador,$permitidos)) {
                    //$quien = entrevistador::find($request->id_entrevistador);
                    $quien = $nnaVulnerabiliad->rel_id_entrevistador;
                    $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,5,'0',STR_PAD_LEFT) : "[desconocido]";
                    abort(403,"No puede consultar evaluaciones para el entrevistador especificado: $numero");
                }
            }
        }




        traza_actividad::create(['id_objeto'=>7, 'id_accion'=>6, 'codigo'=>$nnaVulnerabiliad->codigo, 'id_primaria'=>$nnaVulnerabiliad->id_nna_vulnerabilidad]);
        return view('nna_vulnerabiliads.show')->with('nnaVulnerabiliad', $nnaVulnerabiliad);
    }

    /**
     * Show the form for editing the specified nna_vulnerabiliad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        abort(403);
        $nnaVulnerabiliad = $this->nnaVulnerabiliadRepository->findWithoutFail($id);

        if (empty($nnaVulnerabiliad)) {
            Flash::error('Nna Vulnerabiliad not found');

            return redirect(route('nnaVulnerabiliads.index'));
        }

        return view('nna_vulnerabiliads.edit')->with('nnaVulnerabiliad', $nnaVulnerabiliad);
    }

    /**
     * Update the specified nna_vulnerabiliad in storage.
     *
     * @param  int              $id
     * @param Updatenna_vulnerabiliadRequest $request
     *
     * @return Response
     */
    public function update($id, Updatenna_vulnerabiliadRequest $request)
    {
        abort(403);
        $nnaVulnerabiliad = $this->nnaVulnerabiliadRepository->findWithoutFail($id);

        if (empty($nnaVulnerabiliad)) {
            Flash::error('Nna Vulnerabiliad not found');

            return redirect(route('nnaVulnerabiliads.index'));
        }

        $nnaVulnerabiliad = $this->nnaVulnerabiliadRepository->update($request->all(), $id);

        Flash::success('Nna Vulnerabiliad updated successfully.');
        traza_actividad::create(['id_objeto'=>7, 'id_accion'=>4, 'codigo'=>$nnaVulnerabiliad->codigo, 'id_primaria'=>$nnaVulnerabiliad->id_nna_vulnerabilidad]);

        return redirect(route('nnaVulnerabiliads.index'));
    }

    /**
     * Remove the specified nna_vulnerabiliad from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        abort(403);
        $nnaVulnerabiliad = $this->nnaVulnerabiliadRepository->findWithoutFail($id);

        if (empty($nnaVulnerabiliad)) {
            Flash::error('Nna Vulnerabiliad not found');

            return redirect(route('nnaVulnerabiliads.index'));
        }

        $this->nnaVulnerabiliadRepository->delete($id);

        Flash::success('Nna Vulnerabiliad deleted successfully.');

        return redirect(route('nnaVulnerabiliads.index'));
    }

    //Busca el correlativo y devuelve el id y el codigo
    public function json($correlativo) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $respuesta = new \stdClass();
        $respuesta->id_nna_vulnerabilidad=0;
        $respuesta->dictamen=2;
        $respuesta->codigo=0;

        $existe = nna_vulnerabiliad::where('correlativo',$correlativo)->first();

        if($existe) {
            $respuesta->id_nna_vulnerabilidad=$existe->id_nna_vulnerabilidad;
            $respuesta->codigo=$existe->codigo;
            $respuesta->dictamen=$existe->dictamen;
        }
        return json_encode($respuesta);

    }
}
