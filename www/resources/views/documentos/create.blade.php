@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Agregar nuevo documento
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::model($documento,['route' => 'documentos.store','id'=>'frm_nuevo']) !!}

                        @include('documentos.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include("pages.paciencia")
@endsection


