@extends('layouts.app')


@section('content')
    {{-- Entrevistas anuladas --}}
    @if($casosInformes->id_activo <> 1)
        @include("partials.anulada")
    @endif

        <h1 class="page-title">
            Casos e informes, # {{ $casosInformes->correlativo }}. <small>Caracterización {!! $casosInformes->codigo !!} [R-{{ $casosInformes->clasifica_nivel }}]</small>
            @can('sistema-abierto')
                @if(Gate::check('escritura') or Gate::check('es-propio',$casosInformes->id_entrevistador))
                    <a data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('casos_informesController@gestionar_adjuntos', [$casosInformes->id_casos_informes]) !!}" class='btn btn-default pull-right no-print'><i class="glyphicon glyphicon-paperclip"></i></a>
                @endif
            @endcan
            {{-- Anular caso --}}
            @php($anular_id= $casosInformes->id_casos_informes)
            @php($anular_url = action('casos_informesController@anular',$anular_id))
            @include("partials.anular")
        </h1>


    @include('casos_informes.show_fields')
    @include('casos_informes.tabla_accesos')

        <div class="clearfix"></div>


    @include('traza_actividads.por_expediente',['control_codigo'=>$casosInformes->entrevista_codigo])





@endsection
