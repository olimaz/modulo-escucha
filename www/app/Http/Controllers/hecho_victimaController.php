<?php

namespace App\Http\Controllers;

use App\Models\hecho;
use App\Models\hecho_victima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class hecho_victimaController extends Controller
{
    //
    function agregar(Request $request) {
        $valores = $request->all();
        //Detectar depto/muni
        if(isset($request->id_lugar_residencia_depto)) {
            if($request->id_lugar_residencia_depto > 0) {
                $valores['id_lugar_residencia'] = $request->id_lugar_residencia_depto;
            }
        }
        if(isset($request->id_lugar_residencia_muni)) {
            if($request->id_lugar_residencia_muni > 0) {
                $valores['id_lugar_residencia'] = $request->id_lugar_residencia_muni;
            }
        }
        if(isset($request->id_lugar_residencia)) {
            if($request->id_lugar_residencia > 0) {
                $valores['id_lugar_residencia'] = $request->id_lugar_residencia;
            }
        }

        $nuevo = new hecho_victima();
        $nuevo->fill($valores);
        //Calcular edad
        if(is_null($valores['edad'])) {
            $edad = $nuevo->calcular_edad();
            if(!is_null($edad)) {
                $nuevo->edad = $edad;
            }
        }

        try {
            $nuevo->save();
            $hecho = hecho::find($request->id_hecho);
            if($hecho) {
                $conteo = $hecho->rel_victima()->count();
                if($hecho->cantidad_victimas < $conteo) {
                    $hecho->cantidad_victimas = $conteo;
                    $hecho->save();
                }
            }
        }
        catch(\Exception $e) {
            Log::warning("Problemas al agregar víctima al hecho".PHP_EOL.$e->getMessage());
            //no pasa nada, seguro era un duplicado
        }
        return $nuevo;
    }
    function quitar($id) {
        $quitar=hecho_victima::find($id);
        //dd($id);
        if($quitar) {
            $quitar->delete();
        }
        return redirect()->back();

    }
}
