@extends('layouts.app')
@section('content_header')

    @can('login-local')
        @include('entrevistadors.filtros_local')
    @else
        @include('entrevistadors.filtros')
    @endcan


@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Listado de entrevistadores registrados en el sistema <small>{{ $entrevistadors->total() }} en total</small></h1>
        @can('login-local')
            <div class="pull-right">
                <a href="{{ action('entrevistadorController@create') }}" class="btn btn-primary">Agregar nuevo usuario</a>
            </div>
        @endcan
    </section>
    <div class="clearfix"></div>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body table-responsive">
                @can('login-local')
                    @include('entrevistadors.table_local')
                @else
                    @include('entrevistadors.table')
                @endcan
            </div>
        </div>
        <div class="text-center">
            {!! $entrevistadors->appends(Request::all())->render() !!}
        </div>
    </div>
@endsection

