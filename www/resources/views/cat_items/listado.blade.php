@extends('layouts.app')


@section('content')
    <section class="content-header">
        <h1 >{{ $titulo }}</h1>

        <h4>Estas opciones se utilizan en los metadatos de las entrevistas y casos e informes</h4>

    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('cat_items.table_listado')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

