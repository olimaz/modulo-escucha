@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Responsable
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('responsables.show_fields')
                    <a href="{!! route('responsables.index') !!}" class="btn btn-default pull-right">Cancelar y volver</a>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
