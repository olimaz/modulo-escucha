@extends('layouts.app')
@section('content_header')
    @include("mis_casos.frm_filtro")
@endsection
@section('content')
    <h3 class="pull-left">
        Listado de Casos Transversales
        <small>{{ $misCasos->total() }} en total</small></h3>

    @can('sistema-abierto')
        @php($otros = \Auth::user()->rel_entrevistador->listado_items("",false))
        @if(count($otros) > 0 && \Gate::allows('escritura'))
            <!-- Single button -->
            <div class="btn-group no-print pull-right">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Crear nuevo caso <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{!! action('mis_casosController@create') !!}">{{ \Auth::user()->name }}</a></li>
                    <li role="separator" class="divider"></li>
                    @foreach($otros as $id=>$quien)
                        <li><a href="{!! action('mis_casosController@create') !!}?id_entrevistador={{ $id }}">{{ $quien }}</a></li>
                    @endforeach
                </ul>
            </div>

        @else
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! action('mis_casosController@create') !!}">Crear nuevo caso</a>
        @endcan
    @endcan
    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-body">
            @include('mis_casos.table')
        </div>
    </div>
    <div class="text-center">
        <div class="no-print">
            {!! $misCasos->appends(Request::all())->render() !!}
        </div>
    </div>
@endsection

