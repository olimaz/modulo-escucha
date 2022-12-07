<?php

/*
 * Para compartir funcionalidades con AA, TC, PR y HV
 */

namespace App\Http\Controllers;

use App\Models\entrevista;
use App\Models\entrevista_individual;
use App\Models\entrevista_profundidad;
use App\Models\historia_vida;
use App\Models\persona_entrevistada;
use App\Models\traza_actividad;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class persona_entrevistadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $id_e_ind_fvt = isset($request->id_e_ind_fvt) ? $request->id_e_ind_fvt : 0;
        $id_entrevista_profundidad = isset($request->id_entrevista_profundidad) ? $request->id_entrevista_profundidad : 0;
        $id_historia_vida = isset($request->id_historia_vida) ? $request->id_historia_vida : 0;
        //Para el formulario
        $mostrar_btn_grabar = false;

        if($id_e_ind_fvt>0) {
            $entrevista = entrevista_individual::find($id_e_ind_fvt);
            $consentimiento = entrevista::where('id_e_ind_fvt',$id_e_ind_fvt)->first();
            $persona_entrevistada = persona_entrevistada::where('id_e_ind_fvt',$id_e_ind_fvt)->first();
        }
        elseif($id_entrevista_profundidad>0) {
            $entrevista = entrevista_profundidad::find($id_entrevista_profundidad);
            $consentimiento = entrevista::where('id_entrevista_profundidad',$id_entrevista_profundidad)->first();
            $persona_entrevistada = persona_entrevistada::where('id_entrevista_profundidad',$id_entrevista_profundidad)->first();
        }
        elseif($id_historia_vida > 0) {
            $entrevista = historia_vida::find($id_historia_vida);
            $consentimiento = entrevista::where('id_historia_vida',$id_historia_vida)->first();
            $persona_entrevistada = persona_entrevistada::where('id_historia_vida',$id_historia_vida)->first();
        }
        else {
            abort(403,'Error: Debe especificar la entrevista a diligenciar');
        }
        if(!$entrevista) {
            abort(403,'Error: entrevista no identificada');
        }
        if(!$entrevista->puede_modificar_entrevista()) {
            abort(403,"Acceso denegado: no tiene privilegios para modificar la entrevista $entrevista->entrevista_codigo");
        }
        if(!$consentimiento) {
            $consentimiento = new entrevista();
            $consentimiento->valores_iniciales();
        }
        //Crear o editar
        if(!$persona_entrevistada) {
            //Crear persona entrevistada con nombres y apellidos a partir de metadatos
            if($id_entrevista_profundidad > 0) {
                $persona_entrevistada = $entrevista->crear_persona_entrevistada();
                traza_actividad::create(['id_objeto'=>103, 'id_accion'=>3, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$persona_entrevistada->id_persona_entrevistada]);
                return view('persona_entrevistada.edit', compact('consentimiento','entrevista','persona_entrevistada','mostrar_btn_grabar'));
            }
            elseif($id_historia_vida > 0) {
                $persona_entrevistada = $entrevista->crear_persona_entrevistada();
                traza_actividad::create(['id_objeto'=>103, 'id_accion'=>3, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$persona_entrevistada->id_persona_entrevistada]);
                return view('persona_entrevistada.edit', compact('consentimiento','entrevista','persona_entrevistada','mostrar_btn_grabar'));
            }
            elseif($id_e_ind_fvt > 0) {
                $persona_entrevistada = new \App\Models\persona_entrevistada();

                return view('persona_entrevistada.edit', compact('consentimiento','entrevista','persona_entrevistada','mostrar_btn_grabar'));
            }
        }
        else {
            return view('persona_entrevistada.edit', compact('consentimiento','entrevista','persona_entrevistada','mostrar_btn_grabar'));
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $persona_entrevistada = persona_entrevistada::procesar_request($request);

        if(!$persona_entrevistada) {
            Flash::error('Problemas con los datos de persona entrevistada');
            return redirect()->back();
        }
        else {
            //dd($persona_entrevistadarsona);
            return redirect()->action('persona_entrevistadaController@show',$persona_entrevistada->id_persona_entrevistada);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $persona_entrevistada = persona_entrevistada::find($id);
        $persona = $persona_entrevistada->rel_id_persona;
        $entrevista = $persona_entrevistada->entrevista;
        //dd($entrevista);
        $consentimiento = $entrevista->rel_consentimiento;
        if(!$consentimiento) {
            $consentimiento = new entrevista();
        }
        return view('persona_entrevistada.show', compact('persona_entrevistada','persona','entrevista','consentimiento'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
