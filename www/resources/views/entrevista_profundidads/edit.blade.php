@extends('layouts.app')

@section('content_header')
    <h1>
        Modificar entrevista a profundidad {{ $entrevistaProfundidad->entrevista_codigo }}
    </h1>
@endsection

@section('content')
    {!! Form::model($entrevistaProfundidad, ['route' => ['entrevistaProfundidads.update', $entrevistaProfundidad->id_entrevista_profundidad], 'method' => 'patch','id'=>'frm_abc']) !!}
    @php($entrevista = $entrevistaProfundidad)
    @php($consentimiento = $entrevistaProfundidad->consentimiento)
    @php($mostrar_btn_grabar = false)
    @include('partials.consentimiento')

    @include('adminlte-templates::common.errors')

    <div id='ocultar_entrevista'>
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">


                        @include('entrevista_profundidads.fields')


               </div>
           </div>
       </div>
    </div>
    {!! Form::close() !!}
@endsection