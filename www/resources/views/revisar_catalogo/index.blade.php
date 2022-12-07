@extends('layouts.app')

@section('content_header')
    <h1 class="page-header">Revisar opciones agregadas a los listados</h1>
    <h4>En estos listados se muestran respuestas agregadas por los usuarios por medio de la opción "Otro, ¿cuál?"</h4>
@endsection

@section('content')


    <div class="col-xs-12">
        {!! Form::open( ['url' => "#", 'method'=>'GET'])  !!}
        <div class="form-group">
            {!! Form::label('id_cat',"Listado a revisar") !!}
            {!! Form::select('id_cat', $listado_catalogos, $id_cat, ["class"=>"form-control","onchange"=>"submit()"]) !!}
        </div>
        {!! Form::close() !!}
    </div>


        <div class="clearfix"></div>
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-body">
                    @include('revisar_catalogo.table')
            </div>
        </div>

@endsection



@push("js")
    <script>
        $(function() {
            $("#id_cat").select2({
                placeholder: 'Seleccione una opción'
            });
        });


    </script>
@endpush