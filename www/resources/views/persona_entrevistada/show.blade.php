@extends('layouts.app')
@section('content-header')
    <h1 class="page-title">
        Datos de la persona entrevistada - {!! $entrevista->entrevista_codigo !!}
    </h1>
@endsection
@section('content')

    @include('partials.consentimiento_show')




    <div class="box box-primary box-solid">
        <div class="box-header">
            <h1 class="box-title">
                    Información de la persona entrevistada
            </h1>
        </div>        
    
        <div class="box-body" style="padding-left:4%">
            <div class="row">
                <div class="form-group col-sm-6"><h4><b>{{$persona->nombre_completo}}</b> - {{$persona->documento_identidad}}</h4>
                    @if($persona_entrevistada->edad > 0)

                        Edad: {{ $persona_entrevistada->edad }} años al momento de la entrevista

                    @endif
                </div>
                <div class="form-group col-sm-6" style="margin-top: 10px;">
                          
                        <p> <b>¿Es Víctima?</b> {!! ($persona->es_victima == 1 ? 'Sí': 'No') !!}</p>
                        <p><b>¿Ha sido testigo presencial de los hechos? </b>{!! ($persona->es_testigo == 1 ? 'Sí':'No') !!}</p>
                    </div>
                    
                    <div class="form-group col-sm-3 " style="margin-top: 10px;">

                    </div>
                    {{--<div class="form-group col-sm-1 " style="margin-top: 10px;">
                    <a  href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default">Volver</a> 
                    </div>     --}}
                    <!-- Es Testigo Field -->
                @include('personas.show_fields')

            </div>
        </div>
    </div>
</div>
@endsection