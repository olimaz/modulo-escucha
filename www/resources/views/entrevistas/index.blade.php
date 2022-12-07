@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Entrevistas</h1>
        <h1 class="pull-right"></h1>

           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="/entrevistas/create/83">Nueva Entrevista</a>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('entrevistas.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection
