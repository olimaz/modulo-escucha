@extends('layouts.app')

@section('content')

     <div class="content">
        @include('adminlte-templates::common.errors')
        <section class="content-header">
                <h1 class="page-header">
                    Nueva: ESPECIFICACIONES de la Entrevista
                    <small class="text-primary">
                            Código entrevista: {{$entrevista->fmtideindfvt}}
                    </small>
                </h1>
            </section>
        <!-- <div class="box box-primary">

            <div class="box-body">
                <div class="row"> -->
                    {!! Form::Model($entrevista,['route' => 'entrevistas.store']) !!}

                        <input type="hidden" name="id_e_ind_fvt" value="{{$id}}">

                        @include('entrevistas.fields')

                    {!! Form::close() !!}
                <!-- </div>
            </div>
        </div> -->
    </div>
@endsection
