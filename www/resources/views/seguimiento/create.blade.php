@extends('layouts.app')

@section('content_header')
@endsection


@section('content')
    @include('flash::message')
    <h1>Seguimiento a entrevista {!! $seguimiento->fmt_entrevista_codigo !!}</h1>

    @if(count($listado)>0)
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        Problemas reportados previamente
                    </h3>

                </div>
                <div class="table-responsive">
                    @include("seguimiento.table")
                </div>
            </div>
        </div>
    @endif


    <div class="col-sm-12">
        {!! Form::open(['action' => 'seguimientoController@store']) !!}
        {!! Form::hidden('id_subserie',$seguimiento->id_subserie) !!}
        {!! Form::hidden('id_entrevista',$seguimiento->id_entrevista) !!}
        {!! Form::hidden('id_cerrado',2) !!}
        {!! Form::hidden('devolver',$seguimiento->id_entrevista) !!}

        <div class="box box-default box-solid">
            <div class="box-header">
                <h3 class="box-title">Reportar problemas / realizar seguimiento a la entrevista</h3>
            </div>
            <div class="box-body">

                    @php($ocultar_cierre = \Gate::denies('nivel-10'))
                    @include('seguimiento.fields')
            </div>
            <div class="box-footer">
                <div class="form-group col-sm-12">
                    <a  href="#"  class="btn btn-default pull-right" onclick="history.go(-1)">Cancelar</a>
                    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}
                </div>

            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection