@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Ficha de Presunto responsable individual
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::model($responsable,['action' => ['responsableController@store',$expediente->id_e_ind_fvt]]) !!}
                        @include('responsables.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
