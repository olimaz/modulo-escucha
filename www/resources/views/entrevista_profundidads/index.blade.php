@extends('layouts.app')

@section('content_header')
    @include("entrevista_profundidads.frm_filtro")
@endsection

@section('content')
    <h3 class="pull-left">
        Listado de Entrevistas a Profundidad -PR-
        <small>{{ $entrevistaProfundidads->total() }} en total</small>
    </h3>

    @can('sistema-abierto')
        @php($otros = \Auth::user()->rel_entrevistador->listado_items("",false))
        @if(count($otros) > 0 && \Gate::allows('escritura'))
            <!-- Single button -->
            <div class="btn-group no-print pull-right">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cargar nueva entrevista <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{!! route('entrevistaProfundidads.create') !!}">{{ \Auth::user()->name }}</a></li>
                    <li role="separator" class="divider"></li>
                    @foreach($otros as $id=>$quien)
                        <li><a href="{!! route('entrevistaProfundidads.create') !!}?id_entrevistador={{ $id }}">{{ $quien }}</a></li>
                    @endforeach
                </ul>
            </div>

        @else
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('entrevistaProfundidads.create') !!}">Cargar nueva entrevista</a>
        @endcan
    @endcan
    <div class="clearfix"></div>
    <div class="text-right">
        @include("entrevista_profundidads.boton_descargar")
    </div>
    <div class="clearfix"></div>
    <p class="text-right"><i class="fa fa-fw fa-hand-o-right"></i>Plantilla: {!! \App\Models\entrevista_profundidad::enlace_plantilla() !!}</p>
        @include('flash::message')

        <div class="box box-primary">
            <div class="box-body table-responsive">
                    @include('entrevista_profundidads.table')
            </div>
        </div>
    <div class="text-center">
        <div class="no-print">
            {!! $entrevistaProfundidads->appends(Request::all())->render() !!}
        </div>
    </div>

@endsection

