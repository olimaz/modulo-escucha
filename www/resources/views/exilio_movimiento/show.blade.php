@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            {{ $exilio->rel_id_e_ind_fvt->entrevista_codigo }} - Ficha de exilio
            <div class="pull-right">
                <a href="{!! action('entrevista_individualController@fichas',$exilio->id_e_ind_fvt) !!}" class="btn btn-default">Volver</a>
            </div>
        </h1>
    </section>
    <div class="content">
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    1. Ficha de primera salida
                </h3>
            </div>

            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('exilios.show_fields')
                </div>
            </div>
            <div class="box-footer">
                <a href="{!! action('exilioController@edit',$exilio->id_exilio) !!}" class="btn btn-default">Modificar esta sección</a>
            </div>
        </div>
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title">
                    2. Reasentamientos
                </h3>
            </div>
            <div class="box-body">
                <div class="row" style="padding-left: 20px">

                </div>
            </div>
            <div class="box-footer">
                <a href="{{ action('exilio_movimientoController@create',$exilio->id_exilio) }}?id_tipo_movimiento=2" class="btn btn-primary">Agregar reasentamiento</a>
            </div>
        </div>
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title">
                    3. Impactos y afrontamientos específicos del exilio
                </h3>
            </div>
            <div class="box-body">
                <div class="row" style="padding-left: 20px">

                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary">Diligenciar ficha</button>
            </div>
        </div>
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title">
                    4. Retorno
                </h3>
            </div>
            <div class="box-body">
                <div class="row" style="padding-left: 20px">

                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary">Diligenciar ficha</button>
            </div>
        </div>

    </div>
@endsection
