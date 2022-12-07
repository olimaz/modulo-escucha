@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            NNA: Evaluación de vulnerabilidad
        </h1>
    </section>
    <div class="content">

                    @include('nna_vulnerabiliads.show_fields')
                    <a href="{!! route('nnaVulnerabiliads.index') !!}" class="btn btn-default">Regresar</a>


    </div>
@endsection
