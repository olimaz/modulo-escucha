<div class="table-responsive">
    <table class="table" id="problemas-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Fecha</th>
                <th>Responsable</th>
                <th>Procesamiento finalizado</th>
                <th>Anotaciones</th>
                <th>Tipo de seguimiento</th>
                <th>Descripción</th>
                <th>Seguimiento realizado</th>
                @can('sistema-abierto')
                    @can('revisar-m-nivel',[[1,2,10,11]])
                        @can('escritura')
                            <th>Actualizar seguimiento</th>
                        @endcan
                    @endcan
                @endcan
            </tr>
        </thead>
        <tbody>
        @php($i = $listado->firstItem())
            @foreach($listado as $fila)
                <tr>
                    <td> {{ $i++ }} </td>
                    <td> {!! $fila->fmt_entrevista_codigo !!}</td>
                    <td> {{ $fila->fmt_fecha_hora }}</td>
                    <td> {{ $fila->fmt_id_entrevistador }}</td>
                    <td class="text-center"> {{ $fila->fmt_id_cerrado }}</td>
                    <td> {!!   nl2br($fila->anotaciones) !!}</td>
                    <td> @if(is_null($fila->id_tipo_problema))
                             -
                        @else
                             <span class="text-danger">
                                {{ \App\Models\cat_item::describir($fila->id_tipo_problema)  }}
                             </span>
                         @endif
                    </td>
                    <td> {!!   nl2br($fila->descripcion) !!}</td>
                    <td> @if(is_null($fila->id_tipo_problema))
                            -
                        @else
                             <span title="{{ $fila->cerrado_anotaciones }}" data-toggle="tooltip">
                            {{ \App\Models\criterio_fijo::describir(2,$fila->cerrado_id_estado) }}
                             </span>
                         @endif
                    </td>
                    @can('sistema-abierto')
                    @can('revisar-m-nivel',[[1,2,10,11]])
                        @can('escritura')
                            <td>
                                @if($fila->id_seguimiento_problema > 0)

                                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_problema_{{ $fila->id_seguimiento_problema  }}">
                                        <i class="fa fa-check-square-o text-primary" aria-hidden="true"></i>
                                    </button>

                                @endif
                            </td>
                        @endcan
                    @endcan
                        {{-- formulario para resolver --}}
                        @if($fila->id_seguimiento_problema > 0)
                            @include("seguimiento.resuelto")
                        @endif
                    @endcan
                </tr>
            @endforeach

        </tbody>
    </table>
</div>