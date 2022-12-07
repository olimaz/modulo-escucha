<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createnna_seguridadRequest;
use App\Http\Requests\Updatenna_seguridadRequest;
use App\Models\entrevistador;
use App\Models\nna_seguridad;
use App\Models\nna_seguridad_info;
use App\Models\traza_actividad;
use App\Repositories\nna_seguridadRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class nna_seguridadController extends AppBaseController
{
    /** @var  nna_seguridadRepository */
    private $nnaSeguridadRepository;

    public function __construct(nna_seguridadRepository $nnaSeguridadRepo)
    {
        $this->nnaSeguridadRepository = $nnaSeguridadRepo;
    }

    /**
     * Display a listing of the nna_seguridad.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $filtros = nna_seguridad::filtros_default($request);
        $query = nna_seguridad::filtrar($filtros)->ordenar();
        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();
        //dd($debug);
        $listado = $query->paginate();


        return view('nna_seguridads.index')
            ->with('filtros', $filtros)
            ->with('nnaSeguridads', $listado);
    }

    /**
     * Show the form for creating a new nna_seguridad.
     *
     * @return Response
     */
    public function create()
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $nnaSeguridad = new nna_seguridad();
        return view('nna_seguridads.create', compact('nnaSeguridad'));
    }

    /**
     * Store a newly created nna_seguridad in storage.
     *
     * @param Createnna_seguridadRequest $request
     *
     * @return Response
     */
    public function store(Createnna_seguridadRequest $request)
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
        $item = new  nna_seguridad();
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
        $input['id_nna_vulnerabilidad']=$request->id_nna_vulnerabilidad;
        //dd($input);


        try {
            $nueva = new nna_seguridad();
            $nueva->fill($input);
            $nueva->dictamen = $nueva->calcular_dictamen();
            $nueva->save();
            // Tabla de detalle
            if(!is_array($request->info)) {
                $request->info=array($request->info);
            }
            foreach($request->info as $id) {
                $tmp['id_nna_seguridad'] = $nueva->id_nna_seguridad;
                $tmp['id_info']=$id;
                nna_seguridad_info::create($tmp);
            }

            Flash::success('Información almacenada exitosamente.');
            //Traza de seguridad
            traza_actividad::create(['id_objeto'=>8, 'id_accion'=>3, 'codigo'=>$nueva->codigo, 'id_primaria'=>$nueva->id_nna_seguridad]);
            return redirect()->action('nna_seguridadController@show',$nueva->id_nna_seguridad);

        }
        catch (\Exception $e) {
            Flash::error('Problemas al grabar la información: '.$e->getMessage());
            return redirect(action('nna_seguridadController@index'));
        }

    }

    /**
     * Display the specified nna_seguridad.
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
        $nnaSeguridad = $this->nnaSeguridadRepository->findWithoutFail($id);

        if (empty($nnaSeguridad)) {
            Flash::error('Nna Seguridad not found');
            return redirect(route('nnaSeguridads.index'));
        }

        if(\Gate::denies('permisos-legado')) {
            if (!\Gate::allows('es-propio', $nnaSeguridad->id_entrevistador)) {
                $id_entrevistador = $nnaSeguridad->id_entrevistador;
                $permitidos = entrevistador::permitidos_acceso_entrevistas();
                if (!in_array($id_entrevistador, $permitidos)) {
                    //$quien = entrevistador::find($request->id_entrevistador);
                    $quien = $nnaSeguridad->rel_id_entrevistador;
                    $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador, 5, '0', STR_PAD_LEFT) : "[desconocido]";
                    abort(403, "No puede consultar evaluaciones para el entrevistador especificado: $numero");
                }
            }
        }

        traza_actividad::create(['id_objeto'=>8, 'id_accion'=>6, 'codigo'=>$nnaSeguridad->codigo, 'id_primaria'=>$nnaSeguridad->id_nna_seguridad]);

        return view('nna_seguridads.show')->with('nnaSeguridad', $nnaSeguridad);
    }

    /**
     * Show the form for editing the specified nna_seguridad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        abort(403);
        $nnaSeguridad = $this->nnaSeguridadRepository->findWithoutFail($id);

        if (empty($nnaSeguridad)) {
            Flash::error('Nna Seguridad not found');

            return redirect(route('nnaSeguridads.index'));
        }

        return view('nna_seguridads.edit')->with('nnaSeguridad', $nnaSeguridad);
    }

    /**
     * Update the specified nna_seguridad in storage.
     *
     * @param  int              $id
     * @param Updatenna_seguridadRequest $request
     *
     * @return Response
     */
    public function update($id, Updatenna_seguridadRequest $request)
    {
        abort(403);
        $nnaSeguridad = $this->nnaSeguridadRepository->findWithoutFail($id);

        if (empty($nnaSeguridad)) {
            Flash::error('Nna Seguridad not found');

            return redirect(route('nnaSeguridads.index'));
        }

        $nnaSeguridad = $this->nnaSeguridadRepository->update($request->all(), $id);

        Flash::success('Nna Seguridad updated successfully.');
        traza_actividad::create(['id_objeto'=>8, 'id_accion'=>4, 'codigo'=>$nnaSeguridad->codigo, 'id_primaria'=>$nnaSeguridad->id_nna_seguridad]);

        return redirect(route('nnaSeguridads.index'));
    }

    /**
     * Remove the specified nna_seguridad from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        abort(403);
        $nnaSeguridad = $this->nnaSeguridadRepository->findWithoutFail($id);

        if (empty($nnaSeguridad)) {
            Flash::error('Nna Seguridad not found');

            return redirect(route('nnaSeguridads.index'));
        }

        $this->nnaSeguridadRepository->delete($id);

        Flash::success('Nna Seguridad deleted successfully.');

        return redirect(route('nnaSeguridads.index'));
    }
}
