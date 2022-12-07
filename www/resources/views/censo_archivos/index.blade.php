@extends('layouts.app')

@section('content')

    <h3 class="pull-left">Censo de archivos en el exilio
            <small>{{ $censoArchivos->total() }} en total</small></h3>



        @can('sistema-abierto')
            @php($otros = \Auth::user()->rel_entrevistador->listado_items("",false))
            @if(count($otros) > 0 && \Gate::allows('escritura'))
                <!-- Single button -->
                    <div class="btn-group no-print pull-right">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Agregar nuevo registro <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{!! action('censo_archivosController@create') !!}">{{ \Auth::user()->name }}</a></li>
                            <li role="separator" class="divider"></li>
                            @foreach($otros as $id=>$quien)
                                <li><a href="{!! action('censo_archivosController@create') !!}?id_entrevistador={{ $id }}">{{ $quien }}</a></li>
                            @endforeach
                        </ul>
                    </div>

            @else
                <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! action('censo_archivosController@create') !!}">Agregar nuevo registro</a>
            @endcan
        @endcan

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('censo_archivos.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>

@endsection

