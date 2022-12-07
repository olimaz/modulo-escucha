<?php

namespace App\Http\Controllers;

use App\Models\entrevista_individual;
use App\Models\traza_actividad;
use Illuminate\Http\Request;

class mapController extends Controller
{
    //
    public function entrevista(Request $request) {
        $filtros = entrevista_individual::filtros_default($request);
        $filtros->id_subserie=config('expedientes.vi');
        $conteo = entrevista_individual::filtrar($filtros)->count();

        $txt_titulo = "Mapa";
        traza_actividad::create(['id_objeto'=>1, 'id_accion'=>21, 'codigo'=>'mapa', 'id_primaria'=>null]);
        return view('mapa.entrevistas_fvt',compact('filtros','conteo','txt_titulo'));
    }

    public function json_deptos() {
        $data = file_get_contents(public_path('maps/deptos.geojson'));
        return response()->json(json_decode($data));
    }
    public function json_mupios() {
        $data = file_get_contents(public_path('maps/mupios.geojson'));
        return response()->json(json_decode($data));
    }
}
