<?php

namespace App\Http\Controllers;

use App\Models\entrevista_individual;
use App\Models\exilio;
use App\Models\exilio_movimiento;
use Illuminate\Http\Request;

class exilio_movimientoController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_exilio, Request $request)
    {
        $exilio = exilio::find($id_exilio);
        if($exilio) {
            //Si es retorno, solo puede haber uno
            if($request->id_tipo_movimiento == 3) {
                $existe=$exilio->retorno();

                if($existe) {
                    return redirect()->action('exilio_movimientoController@edit',$existe->id_exilio_movimiento);
                }
            }
            $expediente = $exilio->rel_id_e_ind_fvt;
            $movimiento = new exilio_movimiento();
            $movimiento->id_tipo_movimiento = $request->id_tipo_movimiento;
            if($movimiento->id_tipo_movimiento==2) {
                $movimiento->id_lugar_salida=9176;
                $movimiento->id_lugar_llegada=9176;
                $movimiento->id_lugar_llegada_2=9176;
            }
            if($movimiento->id_tipo_movimiento==3) {
                $movimiento->id_lugar_salida=9176;

            }
            //dd($movimiento);

            return view('exilio_movimiento.create',compact('expediente','exilio','movimiento'));
        }
        else {
            abort(403,'No existe la ficha de exilio indicada');
        }
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id_exilio, Request $request)
    {
        $exilio = exilio::find($id_exilio);

        if($exilio) {
            //Cuando es retorno, hay que actualizar ciertas cosas
            if($request->id_tipo_movimiento == 3) {
                $exilio->actualizar_retorno($request);
            }

            //Crear el movimiento
            $exilio->crear_movimiento($request);
            return redirect()->action('exilioController@show',$exilio->id_exilio);
        }
        else {
            abort(403,'No existe la ficha de exilio indicada');
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
        $movimiento = exilio_movimiento::find($id);
        $exilio = $movimiento->rel_id_exilio;
        if($exilio) {
            $expediente = $exilio->rel_id_e_ind_fvt;
            if($movimiento->id_tipo_movimiento > 1) {
                return view('exilio_movimiento.edit',compact('expediente','exilio','movimiento'));
            }
            else {
                return redirect()->action('exilioController@edit',$exilio->id_exilio);
            }

        }
        else {
            abort(403,'No existe la ficha de exilio_movimiento indicada');
        }
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
        $movimiento = exilio_movimiento::find($id);
        //dd($request);

        if($movimiento) {
            $exilio = $movimiento->rel_id_exilio;

            $input = $request->all();

            //Lugar de salida
            if (isset($request->id_lugar_salida)) {
                if ($request->id_lugar_salida < 1) {
                    if ($request->id_lugar_salida_muni > 0) {
                        $input['id_lugar_salida'] = $request->id_lugar_salida_muni;
                    } elseif ($request->id_lugar_salida_depto > 0) {
                        $input['id_lugar_salida'] = $request->id_lugar_salida_depto;
                    }
                }
            }
            //Lugar de llegada
            if (isset($request->id_lugar_llegada)) {
                if ($request->id_lugar_llegada < 1) {
                    if ($request->id_lugar_llegada_muni > 0) {
                        $input['id_lugar_llegada'] = $request->id_lugar_llegada_muni;
                    } elseif ($request->id_lugar_salida_depto > 0) {
                        $input['id_lugar_llegada'] = $request->id_lugar_llegada_depto;
                    }
                }
            }
            // Lugar de asentamiento
            if (isset($request->id_lugar_llegada_2)) {
                if ($request->id_lugar_llegada_2 < 1) {
                    if ($request->id_lugar_llegada_2_muni > 0) {
                        $input['id_lugar_llegada_2'] = $request->id_lugar_llegada_2_muni;
                    } elseif ($request->id_lugar_llegada_2_depto > 0) {
                        $input['id_lugar_llegada_2'] = $request->id_lugar_llegada_2_depto;
                    }
                }
            }



            $movimiento->fill($input);
            $movimiento->completar_traza_update();
            $movimiento->save();
            $movimiento->procesar_detalle($request);
            //Cuando es retorno, hay que actualizar ciertas cosas
            if($movimiento->id_tipo_movimiento == 3) {
                $exilio->actualizar_retorno($request);
                $exilio->procesar_detalle_retorno($request);
            }
            return redirect()->action('exilioController@show',$exilio->id_exilio);
        }
        else {
            abort(403,'No existe la ficha de exilio_movimiento indicada');
        }
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
        $movimiento = exilio_movimiento::find($id);
        if($movimiento) {
            $movimiento->delete();
        }
        return redirect()->back();
    }
}
