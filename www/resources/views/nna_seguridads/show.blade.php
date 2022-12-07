@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            NNA: Evaluación de seguridad
        </h1>
    </section>
    <div class="content">
        @include('nna_seguridads.show_fields')
        <a href="{!! route('nnaSeguridads.index') !!}" class="btn btn-default">Regresar</a>
    </div>
@endsection
