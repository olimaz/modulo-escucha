@extends('layouts.app')



@section('content')
<h1>Comandos a ejecutar: adjunto # {{ $id }} - {{ $codigo }}</h1>

    @foreach($listado as $id=>$comando)
        <input type="text" name="comando_{{ $id }}" id="comando_{{ $id }}" value="{{ $comando }}">
        <button class="btn btn-success" type="button" onclick="copiar('comando_{{ $id }}')">Copiar</button>
        <div class="clearfix"></div>
    @endforeach
<hr>
Nuevo id: <input type="text" name="buscar" id="buscar" >
<button class="btn btn-primary" type="button" onclick="reenviar()">Dame los comandos!</button>
<div class="clearfix"></div>
Nuevo código: <input type="text" name="codigo" id="codigo" >
<button class="btn btn-primary" type="button" onclick="ubicar()">Buscala!</button>



<div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Exito! </strong> Texto copiado: <span id="txt_copiado"></span>
</div>


@endsection

@push("js")
    <script>
        $(document).ready(function() {
            $("#success-alert").hide();
            $("#myWish").click(function showAlert() {
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });
            });
        });
        function reenviar(){
            var numerito=$("#buscar").val();
            window.location.href="{{ url('cifrar') }}"+ "/"+numerito;
        }
        function ubicar() {
            var numerito=$("#codigo").val();
            let url="{{ url('ubicar') }}"+ "/"+numerito;

            window.open(url,'_blank');
        }
        function copiar(control) {
            /* Get the text field */
            var copyText = document.getElementById(control);

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /*For mobile devices*/

            /* Copy the text inside the text field */
            document.execCommand("copy");
            $("#txt_copiado").html(copyText.value);

            /* Alert the copied text */
            //alert("Texto copiado: " + copyText.value);
            $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                $("#success-alert").slideUp(500);
            });
        }
    </script>


@endpush