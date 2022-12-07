<table class="table table-striped table-condensed table-bordered text-sm">
    <thead>
    <tr>
        <th>#</th>
        <th>Apellidos, Nombres (otros nombres)</th>
        <th>Edad</th>
        <th>Fecha entrevista</th>
        <th>Lugar entrevista</th>
        <th>Territorio</th>
        <th width="200px">Detalles</th>
        <th width="100px">Marcas</th>


    </tr>
    </thead>
    <tbody>
        @php($i=$listado->firstItem())
        @foreach($listado as $fila)
            <tr>
                <td>{{ $i++ }}</td>
                @if($fila->edad >=18 || $fila->edad == -99)  {{-- <0 para los desconocidos(-99) --}}
                    <td>
                        @php($entrevista = \App\Models\entrevista_individual::find($fila->id_e_ind_fvt))
                        @if(\App\Models\entrevista_individual::revisar_acceso_adjuntos($entrevista))
                            {{ $fila->apellido }}, {{ $fila->nombre }}
                            @if(strlen($fila->alias)>0)
                                ({{ $fila->alias }})
                            @endif
                        @else
                            <span class="text-warning">
                                Entrevista R-{{$fila->clasifica_nivel}}
                            </span>
                        @endif
                    </td>
                @else
                    <td class="text-red">Menor de edad</td>
                @endif
                <td class="text-center {{ $fila->edad >=18 || $fila->edad == -99  ? '': 'text-danger' }}">
                    @if($fila->edad > 0)
                        {{ $fila->edad }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-center">{{ $fila->fmt_fecha_entrevista }}</td>
                <td>{{ $fila->fmt_lugar_entrevista }}</td>
                <td>{{ $fila->fmt_id_territorio }}, {{ $fila->fmt_id_macroterritorio }}</td>


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