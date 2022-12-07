<div class="col-xs-12 table-responsive no-padding">
    <table class="table table-condensed table-striped table-bordered table-hover ">
        <thead>
        <tr>
            <th style="width:2ch">#</th>
            <th style="width:15ch">Entrevista</th>
            <th>Prioridad</th>
            <th style="width:15vw">Título</th>
            <th style="width:20vw">Anotaciones</th>
            @can('sistema-abierto')
            <th>Marcas</th>
            @endcan
        </tr>
        </thead>
        <tbody>
        @php($i=1)
        @php($listado = $misCasos->listado_entrevistas )
        @foreach( $listado as $entrevista)
            <tr>
                <td>{{ $i++ }}
                    {{-- Enlaces y unificaciones --}}
                    @php($listado_enlaces = \App\Models\enlace::listado_enlaces($entrevista->id_subserie,$entrevista->id_entrevista))

                    @if(count($listado_enlaces)>0)
                        <a href="{{ $entrevista->entrevista_enlace->link_show }}"  target="_blank" class="btn btn-sm btn-default" data-toggle="tooltip" title="Esta entrevista tiene enlaces a otras entrevistas"><i class="fa fa-link"></i></a>
                    @endif
                </td>

                <td>
                    <a href="{{ $entrevista->entrevista_enlace->link_show }}">
                        {{ $entrevista->entrevista->entrevista_codigo }}
                    </a>

                </td>
                <td>
                    @php($prioridad = $entrevista->entrevista->prioridad)
                    @include('partials.prioridad_ico')

                </td>
                <td >
                    <span class="resaltable">{{ $entrevista->entrevista->titulo }} </span>
                    @if($entrevista->entrevista->rel_dinamica()->count() > 0)
                        <br><strong>Dinámicas:</strong>
                        <ol>
                            @foreach($entrevista->entrevista->rel_dinamica as $d)
                                <li>{{ $d->dinamica }}</li>
                            @endforeach
                        </ol>
                    @endif
                </td>
                <td class="resaltable">
                    {{ nl2br($entrevista->entrevista->observaciones) }}
                </td>
                @can('sistema-abierto')
                <td>
                    {!!   \App\Models\marca_entrevista::listado_marcas_buscadora($entrevista->id_subserie,$entrevista->id_entrevista) !!}

                    @if($entrevista->id_mis_casos_entrevista > 0)
                        @if(in_array($misCasos->privilegios,[1,5]))
                            <br>
                            <a href="{{ action('mis_casos_entrevistaController@quitar',$entrevista->id_mis_casos_entrevista) }}" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Quitar de este listado"><i class="fa fa-remove"></i></a>
                        @endif
                    @endif
                </td>
                @endcan

            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="clearfix"></div>