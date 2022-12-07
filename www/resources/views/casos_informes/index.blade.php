@extends('layouts.app')
@section('content_header')
    @include('casos_informes.filtros')

@endsection
@section('content')

        <h3 >Casos e informes <small>{{ $casosInformes->total() }} en total</small>
            @can('sistema-abierto')
                <a class="btn btn-primary pull-right no-print" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('casosInformes.create') !!}">Agregar nuevo</a>
            @endcan
        </h3>



        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body table-responsive">
                    @include('casos_informes.table')
            </div>
        </div>
        <div class=" no-print">
            {!! $casosInformes->appends(Request::all())->render() !!}
        </div>


@endsection

