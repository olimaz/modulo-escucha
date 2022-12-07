@extends('layouts.app')
@section('content_header')
  <h1 class="page-header">
    <h1 class="page-header">
        Modificar: PERSONA RESPONSABLE
        <small class="text-primary">
                Código entrevista: {{$entrevista->entrevista_codigo}}
        </small>
    </h1>
  </h1>

@endsection


@section('content')

       @include('adminlte-templates::common.errors')
       <div class='col-sm-12'>
         <div class="box box-primary">
             <div class="box-body ">

                     {!! Form::model($persona, ['route' => ['persona_responsable.update', $persona->id_persona], 'method' => 'patch']) !!}
                     <input type="hidden" id="id_hecho" name="tipo_entrevista" value="{{$tipo_entrevista}}">
                     @if(!empty($id_hecho))
                     <input type="hidden" id="id_hecho" name="id_hecho" value="{{$id_hecho}}">
                     @endif
                     <input name="id_e_ind_fvt" type="hidden" value="{{$entrevista->id_e_ind_fvt}}">
                     <input name="id_entrevista_etnica" type="hidden" value="{{$entrevista->id_entrevista_etnica}}">

                          @include('persona_responsable.fields')

                     {!! Form::close() !!}

             </div>
         </div>
       </div>


@endsection
