@extends('layouts.app')
@section('content')
<div class="content">

    <h1 class="page-title">
        Datos de la persona entrevistada - {!! $entrevistaIndividual->entrevista_codigo !!}
        <div class="pull-right">
            @if (isset($ficha_show) && $ficha_show==1)
                <a  href="{!! route('entrevistaindividual.fichas_show', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default">Volver</a>
            @else
                <a  href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default">Volver</a>
            @endif            
        </div>                      
        </h1>

    <div class="box box-primary box-solid">
        <div class="box-header">
            <h1 class="box-title">
                    Código de entrevista: {{$persona->fmt_id_e_ind_fvt}}                     
            </h1>
        </div>        
    
        <div class="box-body" style="padding-left:4%">
            <div class="row">
                <div class="form-group col-sm-6"><h4><b>{{$persona->nombre_completo}}</b> - {{$persona->documento_identidad}}</h4></div>
                <div class="form-group col-sm-2" style="margin-top: 10px;">
                          
                        <p> <b>¿Es Víctima?</b> {!! ($persona->es_victima == 1 ? 'Sí': 'No') !!}</p>
                    </div>
                    
                    <div class="form-group col-sm-3 " style="margin-top: 10px;">
                        <p><b>¿Ha sido testigo presencial de los hechos? </b>{!! ($persona->es_testigo == 1 ? 'Sí':'No') !!}</p>
                    </div>
                    {{--<div class="form-group col-sm-1 " style="margin-top: 10px;">
                    <a  href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default">Volver</a> 
                    </div>     --}}
                    <!-- Es Testigo Field -->
                @include('personas.show_fields')
                <div class="form-group col-sm-12 ">
                    @if (isset($ficha_show) && $ficha_show==1)
                        <a  href="{!! route('entrevistaindividual.fichas_show', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default">Volver</a>
                    @else
                        <a  href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default">Volver</a>
                    @endif
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection