<table class="table table-striped table-condensed table-bordered text-sm">
    <thead>
    <tr>
        <th>#</th>
        <th>Apellidos, Nombres (otros nombres)</th>
        <th>Cantidad de hechos / Cantidad de violaciones</th>
        <th>Síntesis</th>
        <th width="200px">Detalles de la entrevista</th>
        <th width="100px">Marcas</th>
    </tr>
    </thead>
    <tbody>
        @php($i=$listado->firstItem())
        @foreach($listado as $fila)
            <tr>
                <td>{{ $i++ }}</td>
                <td>
                    @can('permisos-legado')
                        (anonimizado)
                    @else
                        {{ $fila->apellido }}, {{ $fila->nombre }}
                        @if(strlen($fila->alias)>0)
                            ({{ $fila->alias }})
                        @endif
                    @endcan
                </td>
                <td class="text-center">{{ $fila->conteo_hechos }} / {{ $fila->conteo_violencia }}</td>

                <td>
                    {!!   $fila->detalle_violencia_persona !!}
                </td>


                <td class="text-center">
                    <a href="{{ action('entrevista_individualController@fichas_show',$fila->id_e_ind_fvt) }}?volver=0" class="btn btn-info btn-sm" data-toggle="tooltip" title="Ver línea de tiempo y consultar fichas">
                        {{ $fila->entrevista_codigo }}
                    </a>




                    {{-- Priorización --}}
                    {!! \App\Models\entrevista_individual::ico_prioridad_read_only($fila) !!}

                    <br>

                    <span title="Clasificación del nivel de acceso" data-toggle="tooltip">
                    (R-{{ $fila->clasifica_nivel }})</span>  <i data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario">
                        ({{ \App\Models\entrevista_individual::conteo_hits($fila) }})
                    </i>
                </td>
                <td>
                    {{-- Aplicar marcas --}}
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ $fila->id_e_ind_fvt }}_{{ $fila->id_subserie }}">
                        <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                    </button>
                    {!!   \App\Models\marca_entrevista::listado_marcas_buscadora($fila->id_subserie,$fila->id_e_ind_fvt) !!}
                </td>
            </tr>
        @endforeach

    </tbody>
</table>

@foreach($listado as $fila)
    @php($id_subserie = $fila->id_subserie)
    @php($id_entrevista = $fila->id_e_ind_fvt)
    @php($codigo_entrevista = $fila->entrevista_codigo)
    @include('marca_entrevistas.create3')
@endforeach