@extends('layouts.app')
@section('content_header')
    <h1>
        Otorgar acceso para modificar la entrevista <span class="text-primary">{{ $asignacion->codigo_entrevista }}</span>
    </h1>
@endsection

@section('content')

        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($asignacion,['route' => 'accesoEdicions.store']) !!}

                        {!! Form::hidden('id_subserie',null) !!}
                        {!! Form::hidden('id_entrevista',null) !!}

                        @include('acceso_edicions.fields')

                    {!! Form::close() !!}
                </div>
            </div>
            <div class="box-footer">
                <b>Importante:</b> Si no desea otorgar permisos de modificar, pero sí autorizar el acceso a los adjuntos, puede utilizar la opción de "Desclasificar" que permite acceder a los adjuntos, sin otorgar permisos de edición de la entrevista.
            </div>
        </div>

@endsection
