<?php

namespace App\Http\Controllers;

use App\Models\prioridad;
use App\Models\seguimiento;
use App\Models\seguimiento_problema;
use App\Models\traza_actividad;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class seguimientoController extends Controller
{
    //
    public function index(Request $request) {
        $filtros = seguimiento::filtros_default($request);

        $query = seguimiento::filtrar($filtros);
            $debug['sql']= nl2br($query->toSql());
            $debug['criterios']=$query->getBindings();


        $listado = $query->ordenar()->paginate();



        return view('seguimiento.index',compact('filtros','listado','debug'));
    }

    public function actualizar_problema(Request $request) {
        $existe=seguimiento_problema::find($request->id_seguimiento_problema);

        if($existe) {
            //Solucionado?
            $existe->cerrado_anotaciones=$request->cerrado_anotaciones;
            if($request->cerrado_id_estado == 1 && $existe->cerrado_id_estado==2) {  //Registrar cuando cambia
                if(is_null( $existe->cerrado_fecha_hora)) {
                    $existe->cerrado_fecha_hora = \Carbon\Carbon::now();
                    $existe->cerrado_id_entrevistador = \Auth::user()->id_entrevistador;
                }
            }
            $existe->cerrado_id_estado=$request->cerrado_id_estado;

            //Solucionable?
            $existe->id_resolvible = $request->id_resolvible;
            if(strlen($request->sugerencia) > 0) {
                if(strlen($existe->sugerencia) <= 0) {  //Se registran los datos de la primera sugerencia
                    $existe->sugerencia_fh = \Carbon\Carbon::now();
                    $existe->sugerencia_id_entrevistador = \Auth::user()->id_entrevistador;
                }
            }
            $existe->sugerencia = $request->sugerencia;
            $existe->save();
            \Flash::success("Problema actualizado");
        }
        else {
            \Flash::error("No existe el item especificado($request->id_seguimiento_problema)");
        }
        return redirect()->back();
    }

    public function create(Request $request) {
        $seguimiento = new seguimiento();
        $seguimiento->id_subserie = $request->id_subserie;
        $seguimiento->id_entrevista = $request->id_entrevista;
        $entrevista = $seguimiento->entrevista->entrevista;

        //Para que regrese al listado al final de toda la vuelta
        $devolver=$request->devolver;

        //Listado de seguimientos existentes
        $filtros = seguimiento::filtros_default($request);
        $query = seguimiento::filtrar($filtros);
            $debug['sql']= nl2br($query->toSql());
            $debug['criterios']=$query->getBindings();

        $listado = $query->ordenar()->paginate();

        //dd($entrevista);
        if($entrevista) {
            return view('seguimiento.create', compact('seguimiento','listado','devolver'));
        }
        else {
            \Flash::error("No existe la entrevista indicada");
            return redirect()->back();
        }

    }
    public function store(Request $request) {

        $llave_foranea = new \stdClass();
        $llave_foranea->id_subserie=$request->id_subserie;
        $llave_foranea->id_entrevista=$request->id_entrevista;



        $seguimiento = seguimiento::procesar_request($request, $llave_foranea);
        if($seguimiento) {
            \Flash::success("Seguimiento almacenado");
        }
        return redirect(url($request->devolver));
    }

    //Para el popup de priorizar
    public function grabar_priorizacion(Request $request) {
        $nuevo = new prioridad();
        $nuevo->fill($request->toArray());
        $nuevo->id_tipo=1;
        $nuevo->ponderacion = $nuevo->calcular_ponderacion();
        try {
            $nuevo->save();
            //Registrar traza
            $id_objeto = traza_actividad::de_subserie_a_traza($nuevo->id_subserie);
            traza_actividad::create(['id_objeto'=>$id_objeto, 'id_accion'=>29, 'codigo'=>$nuevo->codigo, 'id_primaria'=>$nuevo->id_entrevista, 'referencia'=>"Ponderación:  $nuevo->ponderacion"]);
            Flash::success("Priorización guardada");
        }
        catch(\Exception $e) {
            Flash::warning("Problemas al grabar la priorización: ".$e->getMessage());
        }
        return redirect()->back();

    }
}
