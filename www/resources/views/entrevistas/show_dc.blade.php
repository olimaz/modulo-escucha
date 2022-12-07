@extends('layouts.app')

@section('content')


    @if(!empty($msg))
        <div class="alert alert-danger">{{$msg}}</div>
    @endif
    <section class="content-header">
        <h1 class="page-header">
            Diagnóstico comunitario {{ $entrevista->rel_id_diagnostico_comunitario->entrevista_codigo }}
            <small class="text-primary">
                Consentimiento informado
            </small>
        </h1>
    </section>

    <div class="row" style="padding-left: 20px">

        <a href="{!! action('diagnostico_comunitarioController@show',$entrevista->id_diagnostico_comunitario ) !!}"
           class="btn btn-default pull-right" style="margin-right:2%">Volver</a>
    </div>



    <div>
        @include('entrevistas._consentimiento')
    </div>




@endsection
