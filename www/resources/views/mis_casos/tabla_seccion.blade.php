@php($mostrar=$expediente->puede_acceder_adjuntos())
@php($edicion = $expediente->puede_modificar_adjuntos($id_seccion))

@if(count($listado_adjuntos)>0)

<table class="table table-bordered table-condensed table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Código</th>
        <th>Categoría</th>
        <th>Clasificación</th>
        <th>Descripción</th>
        <th>Enlace</th>
        <th>Anotaciones</th>
        <th>Calificación</th>
        <th>Justificación</th>

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
            <td>{!! $adjunto->fmt_id_categoria !!}</td>
            <td class="text-center">{!! $adjunto->fmt_clasificacion_nivel !!}</td>
            <td>{!! $adjunto->descripcion !!}</td>

            <td> {!! $adjunto->link !!} </td>
            <td>
                {!! nl2br($adjunto->anotaciones) !!}
            </td>

            <td>
                {{ $adjunto->rel_id_adjunto->fmt_id_calificacion }}
            </td>
            <td class="text-center">
                {!! $adjunto->rel_id_adjunto->ico_justificacion() !!}

            </td>


            {{-- Modificar o eliminar --}}
            @if($edicion)
                <td class="text-center">
                    <div class="btn-group">

                        @if(in_array($misCasos->privilegios,[1,5]))
                            <a href="#"  onclick="compartir({{ $adjunto[$llave_primaria] }},'{{ $adjunto->descripcion }}')" class="btn btn-primary btn-sm"><i class="fa fa-share-alt" title="Autorizar acceso a este archivo" data-toggle="tooltip"></i></a>

                        @endif
                        <a  class="btn btn-warning btn-sm" href="{{ action('mis_casos_adjuntoController@edit',$adjunto[$llave_primaria]) }}"><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['onClick' => 'confirmar('.$adjunto[$llave_primaria].')', 'class' => 'btn btn-danger btn-sm']) !!}
                    </div>

                    {{-- Calificar --}}
                    <span data-toggle="tooltip" title="Calificar acceso">
                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_califica_{{ $adjunto->id_adjunto  }}">
                            <i class="fa fa-eye-slash text-primary " aria-hidden="true"></i>
                        </button>
                    </span>

                </td>
                @include('partials.frm_calificar_mis_casos')

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

