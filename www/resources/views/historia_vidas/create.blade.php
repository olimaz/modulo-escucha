@extends('layouts.app')

@section('content_header')
    <h1>
        Nueva Historia de vida <small><i class="fa fa-fw fa-hand-o-right"></i> {!! \App\Models\historia_vida::enlace_plantilla() !!}</small>
    </h1>
@endsection

@section('content')
    {!! Form::model($historiaVida,['route' => 'historiaVidas.store','id'=>'frm_abc']) !!}
        @php($entrevista = $historiaVida)
        @php($consentimiento = new \App\Models\entrevista())
        @php($mostrar_btn_grabar = false)
        @include('partials.consentimiento')
            @include('adminlte-templates::common.errors')
            <div id='ocultar_entrevista'>
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                                @include('historia_vidas.fields')
                        </div>
                    </div>
                </div>
            </div>
    {!! Form::close() !!}

@endsection
