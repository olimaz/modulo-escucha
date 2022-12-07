@extends('layouts.app')

@section('content_header')
    <h1>
        Nueva Entrevista Colectiva
        <small><i class="fa fa-fw fa-hand-o-right"></i> {!! \App\Models\entrevista_colectiva::enlace_plantilla() !!}</small>
    </h1>
@endsection
@section('content')

        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($entrevistaColectiva,['route' => 'entrevistaColectivas.store','id'=>'frm_abc']) !!}

                        @include('entrevista_colectivas.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

@endsection
