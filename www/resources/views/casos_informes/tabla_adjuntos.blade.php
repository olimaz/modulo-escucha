@php
    $edicion = isset($edicion) ? $edicion : true;
    $mostrar=$casosInformes->puede_acceder_adjuntos();
@endphp

@can('permisos-legado')
    @include('casos_informes.tabla_adjuntos_legado')
@else
    <div class="box box-info box-solid">
        <div class="box-header">
            <h3 class="box-title">
                Archivos adjuntos al caso/informe {{ $casosInformes->codigo }}
            </h3>
        </div>
        <div class="box-body">
            <!-- Archivos adjuntos -->
            <div class="form-group  col-sm-12">
                @if(!$mostrar)
                    <div class="text-yellow text-center">
                        <h4><i class="icon fa fa-warning"></i> Acceso restringido</h4>
                        <p>Expediente clasificado como <span
                                    class="text-bold">RESERVADO-{{ $casosInformes->clasifica_nivel }}</span></p>
                        <br>
                        @if($casosInformes->clasificacion_nivel == 1)
                            <p><i class="fa fa-hand-o-right"></i> El acceso a los anexos de una entrevista R-1
                                únicamente puede ser autorizado por el responsable de la entrevista.</p>
                        @else
                            <p><i class="fa fa-hand-o-right"></i> El acceso a los anexos debe ser autorizado por Comité
                                de Acceso a la Información.</p>
                        @endif
                    </div>
                @else
                    {!! Form::label('adjuntos', 'Archivos adjuntos:') !!}
                    <table class="table table-bordered table-condensed table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Tipo</th>
                            <th>Enlace</th>
                            <th>Calificación de acceso</th>
                            <th>Justificación</th>
                            <th>Fecha Carga</th>
                            <th>Tamaño</th>
                            @if($edicion)
                                <th>Acciones</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($casosInformes->adjuntos as $i=>$adjunto)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{!! $adjunto['tipo'] !!}</td>
                                <td>{!! $adjunto['url'] !!}</td>
                                {{-- Calificación de acceso --}}
                                <td>
                                    {{ $adjunto['adjunto']->fmt_id_calificacion }}
                                </td>
                                <td>
                                    @if(count($adjunto['adjunto']->rel_justificacion)>0)
                                        <ul>
                                            @foreach($adjunto['adjunto']->rel_justificacion as $justificacion)
                                                <li> {{ $justificacion->fmt_id_justificacion }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                </td>
                                <td>{!! $adjunto['fecha'] !!}</td>
                                <td>{!! $adjunto['tamano'] !!}</td>
                                @if($edicion)
                                    <td>
                                        <div>
                                            <div class="col-xs-6 text-center">
                                                {!! Form::open(['action' => ['casos_informes_adjuntoController@destroy', $adjunto['id_casos_informes_adjunto']], 'method' => 'delete']) !!}
                                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Seguro que desea eliminar el adjunto?')"]) !!}
                                                {!! Form::close()  !!}
                                            </div>
                                            <div class="col-xs-6 text-center">
                                                {{-- Calificar --}}
                                                <span data-toggle="tooltip" title="Calificar acceso">
                                                <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                                        data-target="#modal_califica_{{ $adjunto['adjunto']->id_adjunto  }}">
                                                    <i class="fa fa-eye-slash text-primary " aria-hidden="true"></i>
                                                </button>
                                            </span>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @php
                                $expediente = $casosInformes;
                            @endphp
                            @include('partials.frm_calificar_casos_informes')
                        @endforeach


                        </tbody>


                    </table>
                @endif

            </div>

        </div>
    </div>
@endcan
