@extends('layouts.app')

@section('content_header')
    <h1>
        Nueva Entrevista a Profundidad
    </h1>
    <h1 class="pull-right">
        <small><i class="fa fa-fw fa-hand-o-right"></i> {!! \App\Models\entrevista_profundidad::enlace_plantilla() !!}</small>
    </h1>
@endsection

@section('content')
    {!! Form::model($entrevistaProfundidad,['route' => 'entrevistaProfundidads.store','id'=>'frm_abc']) !!}
        @php($entrevista = $entrevistaProfundidad)
        @php($consentimiento = new \App\Models\entrevista())
        @php($mostrar_btn_grabar = false)
        @include('partials.consentimiento')
        @include('adminlte-templates::common.errors')
        <div id='ocultar_entrevista'>
            <div class="box box-primary">

                <div class="box-body">
                    <div class="row">


                            @include('entrevista_profundidads.fields')


                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

@endsection
