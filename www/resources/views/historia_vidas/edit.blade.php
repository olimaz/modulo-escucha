@extends('layouts.app')

@section('content_header')
    <h1>
        Modificar Historia de Vida {{ $historiaVida->entrevista_codigo }}
    </h1>
@endsection

@section('content')
    {!! Form::model($historiaVida, ['route' => ['historiaVidas.update', $historiaVida->id_historia_vida], 'method' => 'patch','id'=>'frm_abc']) !!}
        @php($entrevista = $historiaVida)
        @php($consentimiento = $historiaVida->consentimiento)
        @php($mostrar_btn_grabar = false)
        @include('partials.consentimiento')

       @include('adminlte-templates::common.errors')
        <div id='ocultar_entrevista'>
           <div class="box box-primary">
               <div class="box-body">
                   <div class="row">
                        @include('historia_vidas.fields')
                   </div>
               </div>
           </div>
        </div>
    {!! Form::close() !!}

@endsection