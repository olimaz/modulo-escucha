@extends('layouts.app')

@section('content_header')
    @include('seguimiento.frm_filtro')
    @include('flash::message')
@endsection


@section('content')


    {{--
    {{ $debug['sql'] }}
    <br>
    {!! implode("<br>",$debug['criterios']) !!}
    --}}

    <h1 >Seguimiento a entrevistas <small> Mostrando datos para un total de {{ number_format($listado->total()) }} items.</small></h1>


    <div class="box box-primary">
        <div class="box-body">
            @include('seguimiento.table')
        </div>
        <div class="box-footer">
            <div class="no-print">
                {!! $listado->appends(Request::all())->render() !!}
            </div>
        </div>
    </div>

@endsection