<?php

namespace App\Http\Controllers;

use App\Models\etiqueta_entrevista;
use App\Models\retroalimentacion_etiquetado;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class retroalimentacion_etiquetadoController extends Controller
{
    //Grabar nuevo reporte
    function store(Request $request) {
        $exito = retroalimentacion_etiquetado::nuevo_reporte($request);
        if($exito) {
            Flash::success("Gracias por su retroalimentación.  El mensaje ha sido enviado exitosamente ");
        }
        else {
            Flash::danger("Gracias por su retroalimentación. Por alguna extraña razón, el mensaje no pudo enviarse, aunque sí se registró su reporte.");
        }
        return redirect()->back();

    }
    //Mostrar reportes
    function index(Request  $request) {

    }
    function show($id) {

    }
}
