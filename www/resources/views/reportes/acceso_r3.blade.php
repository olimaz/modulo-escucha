@extends('layouts.app')
@section('content_header')
    @include('entrevista_individuals.filtros')
@endsection
@section('content')
    <section >
        <h3 >
            @if($filtros->id_subserie>0)
                {{ \App\Models\cat_item::find($filtros->id_subserie)->descripcion }}
            @else
                Listado de Entrevistas
            @endif

            <small>{{ $entrevistaIndividuals->total() }} en total</small>


            @php($otros = \App\Models\entrevistador::listado_items("",false))
            @if(count($otros) > 0)
            <!-- Single button -->
                <div class="btn-group no-print pull-right">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Cargar nueva entrevista <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="{!! route('entrevistaIndividuals.create') !!}?id_subserie={{ $filtros->id_subserie }}">{{ \Auth::user()->name }}</a></li>
                        <li role="separator" class="divider"></li>
                        @foreach($otros as $id=>$quien)
                            <li><a href="{!! route('entrevistaIndividuals.create') !!}?id_entrevistador={{ $id }}&id_subserie={{ $filtros->id_subserie }}">{{ $quien }}</a></li>
                        @endforeach
                    </ul>
                </div>

            @else
                <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('entrevistaIndividuals.create') !!}?id_subserie={{ $filtros->id_subserie }}">Cargar nueva entrevista</a>
            @endcan
        </h3>
    </section>
    <br>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('entrevista_individuals.table')
            </div>
        </div>
        <div class="no-print">
            {!! $entrevistaIndividuals->appends(Request::all())->render() !!}
        </div>



    </div>
@endsection

