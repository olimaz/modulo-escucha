@extends('layouts.app')

@section('content_header')
    @include("historia_vidas.frm_filtro")
@endsection

@section('content')
    <h3 >
        Listado de Historias de Vida
        <small>{{ $historiaVidas->total() }} en total</small>

        @can('sistema-abierto')
            @php($otros = \Auth::user()->rel_entrevistador->listado_items("",false))
            @if(count($otros) > 0 && \Gate::allows('escritura'))
                <!-- Single button -->
                <div class="btn-group no-print pull-right">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Cargar nueva entrevista <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="{!! route('historiaVidas.create') !!}">{{ \Auth::user()->name }}</a></li>
                        <li role="separator" class="divider"></li>
                        @foreach($otros as $id=>$quien)
                            <li><a href="{!! route('historiaVidas.create') !!}?id_entrevistador={{ $id }}">{{ $quien }}</a></li>
                        @endforeach
                    </ul>
                </div>

            @else
                <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('historiaVidas.create') !!}">Cargar nueva entrevista</a>
            @endcan
        @endcan
    </h3>

    <div class="pull-right">
        @include("historia_vidas.boton_descargar")
    </div>
    <div class="clearfix"></div>
    @include('flash::message')
    <div class="clearfix"></div>
    <p class="text-right"><i class="fa fa-fw fa-hand-o-right"></i>Plantilla: {!! \App\Models\historia_vida::enlace_plantilla() !!}</p>
    <div class="box box-primary">
        <div class="box-body">
                @include('historia_vidas.table')
        </div>
    </div>
    <div class="text-center">
        <div class="no-print">
            {!! $historiaVidas->appends(Request::all())->render() !!}
        </div>
    </div>
@endsection

