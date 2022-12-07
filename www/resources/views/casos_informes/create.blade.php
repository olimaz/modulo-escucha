@extends('layouts.app')
@section('content_header')
    <section class="content-header">
        <h1 class="page-header">
            Nueva caracterización: {{ \App\Models\cat_item::find($casosInformes->id_subserie)->descripcion }}
            <small class="text-success">
                {{ \App\Models\entrevistador::find($casosInformes->id_entrevistador)->fmt_numero_nombre }}
            </small>
        </h1>
    </section>
@endsection
@section('content')

    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::model($casosInformes,['route' => 'casosInformes.store']) !!}

                    @include('casos_informes.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
