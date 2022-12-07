@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Desclasificar: Autorizar acceso a documentos adjuntos
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($ultimo,['action' => 'desclasificarController@store','id'=>'frm_acceso','files' => true]) !!}

                        @include('desclasificars.fields')

                    {!! Form::close() !!}
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
        @if(count($listado)>0)
            <div class="box box-default box-solid">
                <div class=" box-header">
                    <h3 class="box-title">
                        Accesos otorgados
                    </h3>
                </div>
                <div class="box-body no-padding table-responsive">
                    @php($desclasificars = $listado)
                    @include("desclasificars.table")
                </div>
            </div>
        @endif
    </div>
    <div class="clearfix"></div>
@endsection
