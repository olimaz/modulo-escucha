@extends('layouts.app')



@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h1 class="box-title">
                Calculando datos
            </h1>
        </div>
        <div class="box-body">
            <p>Gracias por su paciencia, en estos momentos se están calculando los datos solicitados. <br> Al finalizar el cálculo,  este mensaje desaparecerá y las información será mostrada.</p>

            <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
            <span class="sr-only">Cargando...</span>
            <div class="pull-right">
                @include('partials.timer')
            </div>
        </div>
    </div>

@endsection

@push("js")
    <script>
        window.location="{{ $destino }}";
    </script>
@endpush