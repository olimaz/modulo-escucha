@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Datos de la persona entrevistada - {!! $entrevista->entrevista_codigo !!} - {{ $entrevista->fmt_nombre_entrevistado }}

        </h1>        
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')

       {!! Form::model($persona_entrevistada->rel_id_persona, ['action' => 'persona_entrevistadaController@store']) !!}

            {{-- Campos de control --}}
            {!! Form::hidden('id_persona_entrevistada',$persona_entrevistada->id_persona_entrevistada) !!}
            {!! Form::hidden('id_persona',$persona_entrevistada->id_persona) !!}
            {!! Form::hidden('id_entrevista',$consentimiento->id_entrevista) !!}
            {!! Form::hidden('id_e_ind_fvt',$entrevista->id_e_ind_fvt) !!}
            {!! Form::hidden('id_entrevista_profundidad',$entrevista->id_entrevista_profundidad) !!}
            {!! Form::hidden('id_historia_vida',$entrevista->id_historia_vida) !!}

            {{-- Consentimiento informado --}}
            @include('partials.consentimiento')
           {{-- Persona entrevistada --}}
           <div class="box box-primary">
               <div class="box-body">
                   <div class="row">
                       @include('persona_entrevistada.fields')
                   </div>
               </div>
           </div>



           {!! Form::close() !!}

   </div>
@endsection