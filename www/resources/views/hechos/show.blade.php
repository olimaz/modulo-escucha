@extends('layouts.app')

@section('content_header')
    <h1 class="page-title">
        Hechos y tipos de violencia - {{ $entrevista->entrevista_codigo }}
        <div class="pull-right">
            <a href="{!! action('entrevista_individualController@fichas',$hecho->id_e_ind_fvt) !!}" class="btn btn-default pull-right">Cancelar y volver</a>
        </div>
    </h1>
@endsection

@section('content')

    <div class="col-sm-6">

    </div>

    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('hechos.show_fields')
                    <a href="{!! route('hechos.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
