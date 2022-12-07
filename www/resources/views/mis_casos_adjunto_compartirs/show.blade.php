@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Mis Casos Adjunto Compartir
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('mis_casos_adjunto_compartirs.show_fields')
                    <a href="{{ route('misCasosAdjuntoCompartirs.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
