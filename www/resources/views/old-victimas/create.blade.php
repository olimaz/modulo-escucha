@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Datos de la Víctima
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::model($victima,['action' => ['victimaController@store',$expediente->id_e_ind_fvt]]) !!}

                        @include('victimas.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
