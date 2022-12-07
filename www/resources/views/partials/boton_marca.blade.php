{{--  --}}
{{--
Botón para aplicar marcas

Espera los siguientes parámetros:
$id_subserie : para detectar el tipo de entrevista
$id_entrevista: llave primaria de la entrevista
$codigo_entrevista: para mostrarlo en el formulario

--}}
@can('sistema-abierto')
<button type="button" class="btn btn-default " data-toggle="modal" data-target="#modal_marca_{{ $id_subserie }}_{{ $id_entrevista  }}">
    <i class="fa fa-flag text-primary" aria-hidden="true"></i>
</button>
@include('marca_entrevistas.create')
@endcan

