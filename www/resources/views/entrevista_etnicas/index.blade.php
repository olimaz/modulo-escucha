@extends('layouts.app')

@section('content_header')
    @include("entrevista_etnicas.frm_filtro")
@endsection

@section('content')
    <section >
    <h3 >
        Listado de entrevistas a sujetos colectivos
        <small>{{ $entrevistaEtnicas->total() }} en total</small>

        @can('sistema-abierto')
            @php($otros = \Auth::user()->rel_entrevistador->listado_items("",false))
            @if(count($otros) > 0 && \Gate::allows('escritura')  )
                <!-- Single button -->
                <div class="btn-group no-print pull-right">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Cargar nueva entrevista <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="{!! route('entrevistaEtnicas.create') !!}">{{ \Auth::user()->name }}</a></li>
                        <li role="separator" class="divider"></li>
                        @foreach($otros as $id=>$quien)
                            <li><a href="{!! route('entrevistaEtnicas.create') !!}?id_entrevistador={{ $id }}">{{ $quien }}</a></li>
                        @endforeach
                    </ul>
                </div>

            @else
                <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('entrevistaEtnicas.create') !!}">Cargar nueva entrevista</a>
            @endif
        @endcan
    </h3>
        <div class="text-right">
            @include("entrevista_etnicas.boton_descargar")
        </div>
    </section>
    <br>
    <div class="clearfix"></div>

    @include('flash::message')
    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
                @include('entrevista_etnicas.table')
        </div>
    </div>
    <div class="text-center">
        <div class="no-print">
            {!! $entrevistaEtnicas->appends(Request::all())->render() !!}
        </div>
    </div>
@endsection

