@extends('layouts.app')

@php
$flag = false;

$flag = (!isset($m_aut) ||  $m_aut == "") ? true : false;
@endphp

@section('content_header')
    <h1 class="page-header">
            Nueva: entrevista a sujeto colectivo 
            <small class="text-primary">
                {{ \App\Models\entrevistador::find($entrevistaEtnica->id_entrevistador)->fmt_numero_nombre }}
            </small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"> 1. <i class="fa fa-folder-open-o"></i> Metadatos</li>
            <li>2. Adjuntos</li>
            <li>3. Fichas</li>
        </ol>    
@endsection
@section('content')

        @include('adminlte-templates::common.errors')

        {!! Form::model($entrevistaEtnica,['route' => 'entrevistaEtnicas.store','id'=>'frm_abc']) !!}
        @include('entrevista_individuals.fields_concentimiento')

        <div id='ocultar_entrevista'>
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        {!! Form::model($entrevistaEtnica,['route' => 'entrevistaEtnicas.store','id'=>'frm_abc']) !!}
                        

                            @include('entrevista_etnicas.fields')
                            {{-- @include('entrevista_etnicas.fields_especs') --}}

                            <!-- Submit Field -->
                            <div class="form-group col-sm-12">
                                {!! Form::submit('Grabar', ['class' => 'btn btn-primary', 'id' => 'btn_grabar']) !!}                
                                <a href="{!! action('entrevista_etnicaController@index') !!}" class="btn btn-default">Cancelar</a>
                            </div>                                
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
@endsection
