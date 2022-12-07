@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Asignar transcripción
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::model($transcribirAsignacion,['route' => 'transcribirAsignacions.store', 'id'=>'frm_abc']) !!}

                        {!! Form::hidden('id_e_ind_fvt',null,['id'=>'id_e_ind_fvt']) !!}
                        {!! Form::hidden('id_entrevista_profundidad',null,['id'=>'id_entrevista_profundidad']) !!}
                        {!! Form::hidden('id_entrevista_colectiva',null,['id'=>'id_entrevista_colectiva']) !!}
                        {!! Form::hidden('id_entrevista_etnica',null,['id'=>'id_entrevista_etnica']) !!}
                        {!! Form::hidden('id_diagnostico_comunitario',null,['id'=>'id_diagnostico_comunitario']) !!}
                        {!! Form::hidden('id_historia_vida',null,['id'=>'id_historia_vida']) !!}

                        @include('transcribir_asignacions.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
