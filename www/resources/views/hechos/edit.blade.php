@php($colapsar_menu=true)
@extends('layouts.app')
@include('layouts.js_contrae')

@section('content_header')
    <h1>
        {{-- Ficha de hechos y tipos de violencia.  {{ $hecho->rel_id_e_ind_fvt->entrevista_codigo }} --}}        
        Ficha de hechos y tipos de violencia.  {{ $hecho->expediente()->entrevista_codigo }}
        <div class="pull-right">
            @if($hecho->control_calidad->violencia > 0)
                {{-- <a href="{!! action('entrevista_individualController@fichas',$hecho->id_e_ind_fvt) !!}" class="btn btn-default pull-right">Cancelar y volver</a> --}}
                <a href="{!! action($hecho->controller.'@fichas',$hecho->id_entrevista) !!}" class="btn btn-default pull-right">Cancelar y volver</a>
            @else
                {!! Form::open(['action' => ['hechoController@destroy', $hecho->id_hecho], 'method' => 'delete','id'=>'frm_fecha_hecho']) !!}
                {!! Form::button('Cancelar y volver', ['type' => 'submit', 'class' => 'btn btn-default', 'id'=>'btn_grabar_hecho']) !!}
                {!! Form::close() !!}
            @endif
        </div>
    </h1>
    <p><span class="text-bold">Importante:</span> en cada hecho se agrupan eventos que comparten: misma violencia, misma fecha, mismo lugar, mismas víctimas.</p>
@endsection

@section('content')
    @include('adminlte-templates::common.errors')

    @if ($hecho->tipo_expediente() == 'individual')

        @include('hechos.p_frm_fecha')    
    @else 

        {!! Form::model($hecho, ['route' => ['hechos.update', $hecho->id_hecho], 'method' => 'patch', 'id'=>'frm_abc_hecho']) !!}
        {{-- Usado por el botón grabar y finalizar en entrevista étnica que no tiene la sección de fecha y lugar --}}
        <input type="hidden" name="fin" id="fin" value="0">
        <input type="hidden" name="etnica" id="etnica" value="0">
        {!! Form::close() !!}    
    @endif
    


    @include('hechos.p_violencia')

    {{--
    @if($hecho->control_calidad->hay_exilio)
        @include('hechos.p_exilio')
    @endif
    --}}

    @if ($hecho->tipo_expediente() == 'individual')

        @if($hecho->control_calidad->violencia >0 )
            @include('hechos.p_victima')
        @endif

    @endif

    @if ($hecho->tipo_expediente() == 'individual')

        @if($hecho->control_calidad->victima >0 )
            @include('hechos.p_responsabilidad_colectiva')
            <div id="div_pri">
                @include("hechos.p_pri")
            </div>
        @endif

    @else {{-- Responsabilidad colectiva de hechos sujeto colectivo étnico  --}}
        @include('hechos.p_responsabilidad_colectiva')
        <div id="div_pri">
            @include("hechos.p_pri")
        </div>    
    @endif




    @if($hecho->control_calidad->responsabilidad >0 )
        @include("hechos.p_contexto")
    @endif







    {{-- Control de Calidad y Estadísticas --}}
    <div class="clearfix"></div>
    @if(!$hecho->control_calidad->completo)

        <div class="callout callout-warning">
            <h4>Ficha incompleta</h4>
            <ul>
                @foreach($hecho->control_calidad->alarma as $txt)
                    <li>{{ $txt }}</li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="form-group col-sm-12 text-center">
            <button class="btn btn-primary btn-lg" onclick="$('#fin').val(1); $('#frm_abc_hecho').submit()">Grabar y finalizar</button>
        </div>


    @endif
    <div class="clearfix"></div>

@endsection