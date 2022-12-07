<table class="table table-striped table-condensed table-bordered text-sm">
    <thead>
    <tr>
        <th>#</th>
        <th>Apellidos, Nombres (otros nombres)</th>
        <th>Sexo</th>
        <th>Edad</th>
        <th>Actor Armado</th>
        <th>Violencia atribuida</th>
        <th width="200px">Detalles</th>
        <th width="100px">Marcas</th>


    </tr>
    </thead>
    <tbody>
        @php($i=$listado->firstItem())
        @foreach($listado as $fila)
            <tr>
                <td>{{ $i++ }}</td>
                <td>
                    @if(empty($fila->apellido) && empty($fila->nombre))

                    @else
                        {{ $fila->apellido }}, {{ $fila->nombre }}
                    @endif
                    @if(strlen($fila->alias)>0)
                        ({{ $fila->alias }})
                    @endif
                </td>
                <td>
                    {{ \App\Models\cat_item::describir($fila->id_sexo) }}
                </td>
                <td>
                    {{ \App\Models\cat_item::describir($fila->id_edad_aproximada) }}
                </td>
                <td>
                    {{ \App\Models\cat_item::describir($fila->id_rango_cargo) }}
                    @if($fila->id_grupo_paramilitar > 0)
                        ({{ \App\Models\cat_item::describir($fila->id_grupo_paramilitar) }})
                    @elseif($fila->id_guerrilla > 0)
                        ({{ \App\Models\cat_item::describir($fila->id_guerrilla) }})
                    @elseif($fila->id_fuerza_publica > 0)
                        ({{ \App\Models\cat_item::describir($fila->id_fuerza_publica) }})
                    @endif
                </td>
                <td>
                    @php( $hecho = \App\Models\hecho::find($fila->id_hecho) )


                    <ul>
                        @foreach($hecho->rel_violencia as $violencia)
                            <li> {{ $violencia->fmt_violencia }}</li>
                        @endforeach
                    </ul>

                </td>


                {{-- Detalles --}}
                <td class="text-center">
                    <a href="{{ action('entrevista_individualController@fichas_show',$fila->id_e_ind_fvt) }}?volver=0" class="btn btn-info btn-sm" data-toggle="tooltip" title="Ver línea de tiempo y consultar fichas">
                        {{ $fila->entrevista_codigo }}
                    </a>

                    <a href=" {{ url("/persona_responsable/show/$fila->id_persona/entrevista/$fila->id_e_ind_fvt?id_hecho=$fila->id_hecho") }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Ver ficha de presunto responsable individual"><i class="fa fa-user-check"></i></i></a>



                    {{-- Priorización --}}
                    {!! \App\Models\entrevista_individual::ico_prioridad_read_only($fila) !!}

                    <br>

                    <span title="Clasificación del nivel de acceso" data-toggle="tooltip">
                    (R-{{ $fila->clasifica_nivel }})</span>  <i data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario">
                        ({{ \App\Models\entrevista_individual::conteo_hits($fila) }})
                    </i>
                </td>
                {{-- Marcas --}}
                <td>
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