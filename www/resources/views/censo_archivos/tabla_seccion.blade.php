@php($mostrar=$expediente->puede_acceder_adjuntos())
@php($edicion = $expediente->puede_modificar_adjuntos())

@if(count($listado_adjuntos)>0)

<table class="table table-bordered table-condensed table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Código</th>
        <th>Descripción</th>
        <th>Enlace</th>
        @if($edicion)
            <th width="120px">Acciones</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($listado_adjuntos as $i=>$adjunto)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $adjunto->codigo_adjunto }}</td>
            <td>{!! $adjunto->descripcion !!}</td>
            <td> {!! $adjunto->link !!} </td>



            {{-- Modificar o eliminar --}}
            @if($edicion)
                <td class="text-center">
                    <div class="btn-group">
                        <a  class="btn btn-warning btn-sm" href="{{ action('censo_archivos_adjuntoController@edit',$adjunto[$llave_primaria]) }}"><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['onClick' => 'confirmar('.$adjunto[$llave_primaria].')', 'class' => 'btn btn-danger btn-sm']) !!}
                    </div>
                </td>

            @endif
        </tr>
    @endforeach
    </tbody>
</table>
@else
    <div class="col-sm-12 text-center">
        <h3 class="text-warning">No se han adjuntado archivos para esta sección</h3>
    </div>
@endif

<div class="clearfix"></div>



@push("js")
    <script>

        function confirmar(id) {
            Swal.fire({
                title: '¿Está segura que desea eliminar el adjunto?',
                text: "Esta acción es irreversible",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, quiero eliminar el adjunto',
                cancelButtonText: 'No.'
            }).then((result) => {
                //console.log(result);
                if (result.value) {
                    eliminar(id);
                }
            });
        }

        function eliminar(id) {
            var form_data = new FormData();
            form_data.append('id', id);
            form_data.append('_token', '{{csrf_token()}}');
            $.ajax({
                url: "{{ action($action) }}",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.fail) {
                        console.log("problema");
                    }
                    else {
                        console.log("exito");
                        document.location.reload();
                    }
                },
                error: function (xhr, status, error) {
                    console.log("error");
                }
            });
        }



    </script>
@endpush

