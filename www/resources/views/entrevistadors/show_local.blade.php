@extends('layouts.app')

@section('content_header')
    <h1 class="page-header">
        Perfil del usuario #{!! $entrevistador->numero_entrevistador !!}
    </h1>
@endsection
@section('content')
    {{--  TOP --}}





    {{-- Detalles y privilegios--}}
    <div class="content">
        <div class="col-sm-6">
            @include("entrevistadors.ficha_local",['usuario'=>$entrevistador->rel_usuario])
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-sm-12">
                @if($entrevistador->compromiso_reserva <= 0)
                    <div class="callout callout-warning">
                        <h4><i class="icon fa fa-warning"></i> Compromiso con la reserva no aceptado</h4>

                        <p>El usuario no ha aceptado el compromiso con la reserva de la información </p>
                    </div>
                @else
                    <div class="callout callout-success">
                        <h4><i class="icon fa fa-info-circle"></i> Compromiso con la reserva aceptado</h4>

                        <p>El usuario aceptó el compromiso con la reserva de la información.  Este es el registro de aceptación: </p>
                        <ul>
                            @foreach($entrevistador->rel_compromiso()->orderby('fh_aceptacion')->get() as $compromiso)
                                <li> {{ $compromiso->fh_aceptacion->formatLocalized("%a %d-%b-%Y %H:%M hrs.") }}</li>
                            @endforeach

                        </ul>
                    </div>
                @endif
            </div>
        </div>


        <div class="clearfix"></div>

    </div>
    <div class="clearfix"></div>


    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Compromiso de reserva</h3>
        </div>
        <div class="box-body">
            @include('pages.compromiso_reserva_txt')

        </div>

    </div>
    <div class="clearfix"></div>



@endsection

