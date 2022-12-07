<?php

namespace App\Http\Controllers;

use App\Models\analitica_acceso_justicia;
use App\Models\analitica_entrevista_afrontamientos;
use App\Models\analitica_entrevista_impactos;
use App\Models\analitica_exilio_acompanamiento;
use App\Models\analitica_exilio_impacto_afrontamiento;
use App\Models\analitica_exilio_reasentamiento;
use App\Models\analitica_exilio_retorno;
use App\Models\analitica_exilio_salida;
use App\Models\analitica_metadatos;
use App\Models\analitica_persona_autoridad_etnica;
use App\Models\analitica_persona_entrevistada;
use App\Models\analitica_persona_organizacion;
use App\Models\analitica_pri;
use App\Models\analitica_victima;
use App\Models\analitica_victima_violencia;
use App\Models\analitica_violencia;
use App\Models\analitica_violencia_contexto;
use App\Models\datos_persona;
use stdClass;

class analiticaController extends Controller
{
    //
    public function metadatos() {
        $respuesta = analitica_metadatos::generar_plana();
        return response()->json($respuesta);
    }
    public function persona_entrevistada() {
        $respuesta = analitica_persona_entrevistada::generar_plana();
        return response()->json($respuesta);
    }
    public function victima() {
        $respuesta = new stdClass();
        $respuesta->victima = analitica_victima::generar_plana();
        $respuesta->persona_organizacion = analitica_persona_organizacion::generar_plana();
        $respuesta->persona_autoridad_etnica = analitica_persona_autoridad_etnica::generar_plana();
        return response()->json($respuesta);
    }

    //Actualizar tablas de analitica
    public function exilio_salida() {
        $respuesta = new stdClass();
        $respuesta->salida = analitica_exilio_salida::generar_plana();
        $respuesta->reasentamiento = analitica_exilio_reasentamiento::generar_plana();
        $respuesta->retorno = analitica_exilio_retorno::generar_plana();
        $respuesta->acompanamiento = analitica_exilio_acompanamiento::generar_plana();
        $respuesta->impactos_afrontamientos = analitica_exilio_impacto_afrontamiento::generar_plana();
        $respuesta->victimas = analitica_victima::generar_plana();
        return response()->json($respuesta);
    }
    public function violencia() {
        $respuesta = new stdClass();
        $respuesta->violencia = analitica_violencia::generar_plana();
        $respuesta->victima_violencia = analitica_victima_violencia::generar_plana(); //Genero los dos de una vez
        return response()->json($respuesta);
    }
    //Todos de un solo, para que sea más eficiente. 30 minutos aprox.
    public function contexto_impactos_afrontamientos_justicia() {
        $respuesta = new stdClass();
        $respuesta->contexto = analitica_violencia_contexto::generar_plana();
        $respuesta->contexto_binarizada = analitica_violencia_contexto::generar_plana_binarizada();
        $respuesta->impactos = analitica_entrevista_impactos::generar_plana();
        $respuesta->afrontamientos = analitica_entrevista_afrontamientos::generar_plana();
        $respuesta->justicia_acceso = analitica_acceso_justicia::generar_plana();
        $respuesta->justicia_acceso_binarizada = analitica_acceso_justicia::generar_plana_binarizada();
        $respuesta->pri = analitica_pri::generar_plana();

        return response()->json($respuesta);
    }

    //Vistas para Eduar
    public function datos_persona() {
        $respuesta = datos_persona::generar_plana();
        return response()->json($respuesta);
    }

}
