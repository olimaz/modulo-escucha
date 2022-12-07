@extends('layouts.app')
@section('content_header')
    <h1>
        Entrevista a sujeto colectivo {{ $entrevistaEtnica->entrevista_codigo }}
    </h1>
    <ol class="breadcrumb">
        {{-- <li class="active">1. Metadatos</li> --}}
        @if ($conteos->entrevista == 0)
            <li><a href="{{ action('entrevista_etnicaController@edit',$entrevistaEtnica->id_entrevista_etnica) }}"> 
                1. Metadatos
                </a>
            </li>
        @else
            <li class="active">1. Metadatos</li>
        @endif        

        <li><a href="{{ action('entrevista_etnicaController@gestionar_adjuntos',$entrevistaEtnica->id_entrevista_etnica) }}"> 2. Adjuntos</a></li>
        <li><a href="{{ action('entrevista_etnicaController@fichas',$entrevistaEtnica->id_entrevista_etnica) }}">3. Fichas</a></li>
    </ol>    
@endsection
@section('content')

@php
$flag = false;

$flag = (!isset($m_aut) ||  $m_aut == "") ? true : false;
@endphp

   <div class="content">
       @include('adminlte-templates::common.errors')

       {!! Form::model($entrevistaEtnica, ['route' => ['entrevistaEtnicas.update', $entrevistaEtnica->id_entrevista_etnica], 'method' => 'patch']) !!}

       @if (isset($hecho_id) && $hecho_id > 0)
            <input type="hidden" name="id_hecho" value="{{ $hecho_id }}">
       @endif
       

       @include('entrevista_individuals.fields_concentimiento')

       <div id='ocultar_entrevista'>
        
        @if ($flag)
        <div class="box box-primary">
        @endif
            <div class="box-body">
                <div class="row">
                    {!! Form::model($entrevistaEtnica, ['route' => ['entrevistaEtnicas.update', $entrevistaEtnica->id_entrevista_etnica], 'method' => 'patch','id'=>'frm_abc']) !!}
                    <input type="hidden" name="m_aut" id="m_aut" value="{{$m_aut}}">

                            {{-- @if (!isset($m_aut) ||  $m_aut == "") --}}
                            @if ($flag)
                                @include('entrevista_etnicas.fields')


                                <div class="form-group col-sm-12">
                                    {!! Form::submit('Actualizar expediente', ['class' => 'btn btn-primary', 'id' => 'btn_grabar']) !!}
                                    
                                    <a href="{!! action('entrevista_etnicaController@index') !!}" class="btn btn-default">Cancelar</a>
                                </div>
                            @endif 
                            {{-- @include('entrevista_etnicas.fields_especs') --}}
                            



                           {{-- comentado por oliver el 20-abr
                            @include('entrevista_etnicas.fields_especs')
                           --}}


                    {!! Form::close() !!}
                </div>
            </div>

            @if ($flag)
            </div> {{--  Cierra el box box-primary --}}
            @endif 
       </div>
   </div>
@endsection