@php($mostrar=$expediente->puede_acceder_adjuntos())
@php($edicion = isset($edicion) ? $edicion : true)

@can('permisos-legado')
    @include('partials.tabla_adjuntos_legado')
@else

    <div class="box box-info box-solid">
        <div class="box-header">
            <h3 class="box-title">
                Archivos adjuntos a la entrevista {{ $expediente->entrevista_codigo }}
            </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_ret"><i
                            class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body table-responsive">
            @if(!$mostrar)

                <div class="text-yellow text-center">
                    <h4><i class="icon fa fa-warning"></i> Acceso restringido a los archivos anexos</h4>
                    <p>Expediente clasificado como <span
                                class="text-bold">RESERVADO-{{ $expediente->clasificacion_nivel }}</span></p>
                    <br>

                    @if($expediente->clasificacion_nivel == 1)
                        <p><i class="fa fa-hand-o-right"></i> El acceso a los anexos de una entrevista R-1 únicamente
                            puede ser autorizado por el responsable de la entrevista.</p>
                    @else
                        <p><i class="fa fa-hand-o-right"></i> El acceso a los anexos debe ser autorizado por Comité de
                            Acceso a la Información.</p>
                    @endif
                </div>
            @else
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
                        @if(config('expedientes.transcribir_google'))
                            <th>Transcrito google</th>
                        @endif
                        @if($edicion)
                            @if(config('expedientes.transcribir_google'))
                                @can('nivel-1')
                                    <th>Transcripción google</th>
                                @endcan
                            @endif
                            <th>Acciones</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expediente->adjuntos as $i=>$adjunto)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{!! $adjunto['tipo'] !!}</td>
                            <td>
                                @if(!$adjunto['adjunto']->existe)
                                    (Archivo no disponible)
                                @else
                                    @if(strlen($adjunto['url_stream'])>0)


                                        @if(is_null($expediente->html_transcripcion))

                                            <audio controls controlsList="nodownload">
                                                <source src="{!! $adjunto['url_stream'] !!}" type="audio/mpeg">
                                                Su navegador no permite transmitir audio.
                                            </audio>
                                            <br>{!! $adjunto['url_stream_corto'] !!}

                                        @else
                                            @can('es-propio',$expediente->id_entrevistador)  {{-- El propietario siempre puede escuchar y descargar --}}

                                            <audio controls controlsList="nodownload">
                                                <source src="{!! $adjunto['url_stream'] !!}" type="audio/mpeg">
                                                Su navegador no permite transmitir audio.
                                            </audio>
                                            <br>{!! $adjunto['url_stream_corto'] !!}
                                            @elsecan('rol-reproduccion',$expediente->id_entrevistador)  {{-- excepción para  Gestores de información --}}
                                            <audio controls controlsList="nodownload">
                                                <source src="{!! $adjunto['url_stream'] !!}" type="audio/mpeg">
                                                Su navegador no permite transmitir audio.
                                            </audio>
                                            <br>{!! $adjunto['url_stream_corto'] !!}
                                            @elsecan('revisar-m-nivel', [[1,10]])   {{-- admin y jefe trans --}}
                                            <audio controls controlsList="nodownload">
                                                <source src="{!! $adjunto['url_stream'] !!}" type="audio/mpeg">
                                                Su navegador no permite transmitir audio.
                                            </audio>
                                            <br>{!! $adjunto['url_stream_corto'] !!}
                                            @else
                                                @if($expediente->revisar_asignacion()) {{-- Revisar asignaciones para transcribir, etiquetar, editar --}}
                                                <audio controls controlsList="nodownload">
                                                    <source src="{!! $adjunto['url_stream'] !!}" type="audio/mpeg">
                                                    Su navegador no permite transmitir audio.
                                                </audio>
                                                <br>{!! $adjunto['url_stream_corto'] !!}
                                                @else

                                                    <span class="text-warning">
                                                <i class="fa fa-warning "></i> Audio bloqueado: entrevista transcrita.
                                                </span>
                                                @endif
                                            @endcan


                                        @endif

                                        @can('es-propio',$expediente->id_entrevistador)
                                            <br>{!! $adjunto['url'] !!}
                                        @else
                                            <br>
                                            @if($adjunto['adjunto']->hay_cifrado())
                                                {!! $adjunto['url'] !!}
                                            @else
                                                {{-- no hay cifrado --}}

                                                @if(\App\Models\entrevista_individual::compartido_edicion($expediente))
                                                    <br>{!! $adjunto['url'] !!}
                                                @endif
                                            @endif
                                        @endcan
                                    @else
                                        {!! $adjunto['url'] !!}
                                    @endif
                                @endif
                            </td>
                            {{-- Calificación de acceso --}}
                            <td>
                                {{ $adjunto['adjunto']->fmt_id_calificacion }}
                            </td>
                            <td class="text-center">
                                {!! $adjunto['adjunto']->ico_justificacion() !!}

                            </td>
                            <td>
                                @if(empty($adjunto['adjunto']->duplicados))
                                    {!! $adjunto['fecha'] !!}
                                @else
                                    <span class="text-danger">Advertencia.  Este mismo archivo se encuentra anexado en las siguientes entrevistas: </span>
                                    {!! implode(", ",$adjunto['adjunto']->duplicados) !!}
                                @endif
                            </td>
                            <td>{!! $adjunto['tamano'] !!}</td>
                            @if(config('expedientes.transcribir_google'))
                                <td> {!!   $adjunto['transcrito'] !!}</td>
                            @endif
                            @if($edicion)
                                @if(config('expedientes.transcribir_google'))
                                    @can('nivel-1')
                                        <td class="text-center">

                                            @if($adjunto['id_tipo']==2)
                                                @if(is_null($adjunto['id_transcripcion']) || $adjunto['id_transcripcion']==-1)
                                                    <button type="button" class="btn btn-success"
                                                            onclick="transcribir({{ $adjunto[$llave_primaria]  }})">
                                                        Enviar a transcripción
                                                    </button>
                                                @elseif($adjunto['id_transcripcion']==0)
                                                    <button type="button" class="btn btn-success"
                                                            onclick="transcribir_revisar({{ $adjunto[$llave_primaria] }})">
                                                        Revisar el proceso de transcripcion
                                                    </button>
                                                @else
                                                    <i>No aplica</i>
                                                @endif
                                            @else
                                                <i>No aplica</i>
                                            @endif
                                        </td>
                                    @endcan
                                @endif
                                <td class="text-center">

                                    {{-- Calificar --}}
                                    <span data-toggle="tooltip" title="Calificar acceso">
                                    <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                            data-target="#modal_califica_{{ $adjunto['adjunto']->id_adjunto  }}">
                                        <i class="fa fa-eye-slash text-primary " aria-hidden="true"></i>
                                    </button>
                                </span>
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['onClick' => 'confirmar('.$adjunto[$llave_primaria].')', 'class' => 'btn btn-danger btn-xs']) !!}
                                </td>
                            @endif
                        </tr>
                        @include('partials.frm_calificar')
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endcan
<div class="clearfix"></div>

@can('sistema-abierto')
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
                        } else {
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
@endcan
