@extends('layouts.app')
@section('content_header')
    @include("pazysalvo.frm_filtro")
@endsection

@section('content')

    <h2 >
        Revisión de entrevistas  <small> {{ \App\Models\entrevistador::describir($filtros->id_entrevistador) }}</small>
    </h2>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-4 ">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-flag-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Entrevistas en el sistema</span>
                    <span class="info-box-number">{{ $datos->conteos->total }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-4 ">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-flag-checkered"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Entrevistas completas</span>
                    <span class="info-box-number">{{ $datos->conteos->completas }}</span>
                </div>
            </div>
        </div>



        <div class="col-md-4 ">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-bell-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Entrevistas incompletas</span>
                    <span class="info-box-number">{{ $datos->conteos->incompletas }}</span>
                </div>
            </div>
        </div>


    </div>
    <div class="clearfix"></div>




    <div class="box box-primary box-solid">

        <div class="box-body">
            @include("pazysalvo.table")
        </div>
    </div>


@endsection

