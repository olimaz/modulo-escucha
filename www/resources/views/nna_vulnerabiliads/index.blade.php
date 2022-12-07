@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">NNA: Evaluaciones de vulnerabiliad</h1>
        @can('sistema-abierto')
            <h1 class="pull-right">
               <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('nnaVulnerabiliads.create') !!}">Nueva evaluación</a>
            </h1>
        @endcan
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('nna_vulnerabiliads.table')
            </div>
        </div>
        <div class="text-center">
            <div class="no-print">
                {!! $nnaVulnerabiliads->appends(Request::all())->render() !!}
            </div>
        </div>
    </div>
@endsection

