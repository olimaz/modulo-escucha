<?php

namespace App\Http\Controllers;

use App\Models\exilio;
use Illuminate\Http\Request;

class exilio_impactoController extends Controller
{


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_exilio)
    {
        //
        $exilio = exilio::find($id_exilio);
        if($exilio) {
            $expediente = $exilio->rel_id_e_ind_fvt;
            return view('exilio_impacto.edit',compact('exilio','expediente'));
        }
        else {
            abort(403,'No existe la ficha de exilio indicada');
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
        //
        $exilio = exilio::find($id);
        if($exilio) {
            $exilio->procesar_impactos($request);
            return redirect()->action('exilioController@show',$exilio->id_exilio);
        }
        else {
            abort(403,'No existe la ficha de exilio indicada');
        }
    }


}
