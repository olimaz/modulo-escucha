@extends('layouts.app')
@section('content_header')
    @include("acceso_edicions.frm_filtros")
@endsection

@section('content')

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('acceso_edicions.table')
            </div>
        </div>
        <div class="text-center">
            {!! $accesoEdicions->appends(Request::all())->render() !!}
        </div>

@endsection

