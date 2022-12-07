@extends('layouts.app')

@section('content_header')
    <h1>
        Nuevo Diagnóstico Comunitario <small><i class="fa fa-fw fa-hand-o-right"></i> {!! \App\Models\diagnostico_comunitario::enlace_plantilla() !!}</small>
    </h1>
@endsection
@section('content')

        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($diagnosticoComunitario,['route' => 'diagnosticoComunitarios.store','id'=>'frm_abc']) !!}

                        @include('diagnostico_comunitarios.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

@endsection
