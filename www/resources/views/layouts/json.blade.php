@extends('layouts.app')

@section("content_header")
<h1 class="page-header">{!! $titulo !!} </h1>
@endsection

@section('content')
    <div class="form-group">
        <label for="txt_json">Respuesta JSON:</label>
        <textarea id="txt_json" class="form-control">{{ json_encode($info->objeto) }}</textarea>
    </div>
    <div>
        <br> <button type="button"  id='btn_copy' class="btn btn-primary">Copiar texto JSON</button>
        <br>
        <br>Visor de JSON en línea: <a href="http://jsonviewer.stack.hu/" target="_blank">Visor en linea</a>

    </div>

    <h3>Visualizar el JSON:</h3>

    @php
        dump($info->objeto);
    @endphp
@endsection

@push("js")
    <script>
        $("#btn_copy").click(function(){
            $("#txt_json").select();
            document.execCommand('copy');
            //Alerta
            let timerInterval
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Texto copiado',
                showConfirmButton: false,
                timer: 1500
            })
        });
    </script>


@endpush