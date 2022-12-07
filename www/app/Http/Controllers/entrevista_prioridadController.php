<?php

namespace App\Http\Controllers;

use App\Models\entrevista_prioridad;
use App\Models\prioridad;
use Illuminate\Http\Request;

class entrevista_prioridadController extends Controller
{
    //
    public function index(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }



        $filtros = entrevista_prioridad::filtros_default($request);

        $query = entrevista_prioridad::filtrar($filtros);
            //$debug['sql']= nl2br($query->toSql());
            //$debug['criterios']=$query->getBindings();
            //dd($debug);
        $listado = $query->get();

        //dd("hola munedo:");


        $txt_titulo = "Asignaciones por prioridad";
        return view('entrevista_prioridad.index')
            ->with('listado', $listado)
            ->with('txt_titulo',$txt_titulo)
            ->with('filtros', $filtros);
    }


    public function autofill_comprendo($id_subserie, Request $request) {
        return prioridad::listar_opciones_campo('ahora_entiendo',$id_subserie,$request->texto);
    }
    public function autofill_cambio($id_subserie, Request $request) {
        return prioridad::listar_opciones_campo('cambio_perspectiva',$id_subserie,$request->texto);
    }
}
