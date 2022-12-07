@extends('layouts.app')

@section('content_header')
    <h1 class="pull-left">Listado geográfico <small>de acuerdo a DIVIPOLA del DANE</small></h1>
@endsection
@section('content')

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('controles.geo3', ['control_control' => 'id_lp'
                                           , 'control_default'=>null])
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

