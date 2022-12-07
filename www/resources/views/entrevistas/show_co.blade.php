@extends('layouts.app')

@section('content')


    @if(!empty($msg))
        <div class="alert alert-danger">{{$msg}}</div>
    @endif
    <section class="content-header">
        <h1 class="page-header">
            Entrevista {{ $entrevista->rel_id_entrevista_colectiva->entrevista_codigo }}
            <small class="text-primary">
                Consentimiento informado
            </small>
        </h1>
    </section>

    <div class="row" style="padding-left: 20px">

        <a href="{!! action('entrevista_colectivaController@show',$entrevista->id_entrevista_colectiva ) !!}"
           class="btn btn-default pull-right" style="margin-right:2%">Volver</a>
    </div>



    <div>
        @include('entrevistas._consentimiento')
    </div>




@endsection
