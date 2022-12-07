@extends('layouts.app')

@section('content_header')
  <h1 class="page-header">
      Ver: PERSONA RESPONSABLE
      <small class="text-primary">
              Código entrevista: {{$entrevista->entrevista_codigo}}
      </small>
  </h1>
  <div class='pull-right'>
    @if ($persona->id_hecho && $persona->edicion)
    <a href="{!! route('victimas.volver')."?id_hecho=$persona->id_hecho"."&edicion=$persona->edicion" !!}" class="btn btn-default">Volver</a>
    @elseif($persona->id_hecho && isset($volver_ficha_show_fs_i) && $volver_ficha_show_fs_i=="")
    {{-- Aqui2 --}}
    <a href="{!! route('victimas.volver')."?id_hecho=$persona->id_hecho" !!}" class="btn btn-default">Volver</a>
    @else
        @if ($tipo_entrevista == 'individual')
            <a  href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default">Volver</a>    
        @else
            @if (isset($volver_ficha_show) && $volver_ficha_show=='fs')
            {{-- Aqui3 --}}
                <a  href="{!! route('entrevistaEtnica.fichas_show', [$entrevista->id_entrevista_etnica]) !!}?fs" class="btn btn-default">Volver</a>            
            @else
                @if (isset($volver_ficha_show_fs_i) && $volver_ficha_show_fs_i=='fs_i')
                    {{-- Aqui4 --}}

                    <a href="{!! action('hechoController@show', [$persona->id_hecho]) !!}?fs" class='btn btn-default'>Volver</a>        
                    {{-- <a  href="{!! route('entrevistaEtnica.fichas_show', [$entrevista->id_entrevista_etnica]) !!}?fs" class="btn btn-default">Volver</a>             --}}
                @else
                    <a  href="{!! route('entrevistaEtnica.fichas', [$entrevista->id_entrevista_etnica]) !!}" class="btn btn-default">Volver</a>    
                @endif 
            @endif            
        @endif
    
    @endif




  </div>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary box-solid">
            <div class="box-body" style="padding-left:4%">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <h4><b>{{$persona->nombre_completo}}</b></h4>
                    </div>

                    <!-- Es Testigo Field -->
                    @include('persona_responsable.show_fields')


                </div>
            </div>
        </div>
    </div>

    @if($hecho)
        <div class="clearfix"></div>
        <div class="col-sm-12">
            @include("persona_responsable.show_hecho")
        </div>
    @endif


</div>
<div class="clearfix"></div>






@endsection
