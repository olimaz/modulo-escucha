{{-- Modal para calificar un adjunto --}}
<div class="modal fade" id="modal_califica_{{ $adjunto['adjunto']->id_adjunto }}" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ $expediente->entrevista_codigo }} - Calificar acceso al adjunto </h4>
            </div>
            {!! Form::open(['action' => 'adjuntoController@calificar','id'=>"frm_califica_".$adjunto['adjunto']->id_adjunto]) !!}
            {!! Form::hidden('id_adjunto', $adjunto['adjunto']->id_adjunto ) !!}
            <div class="modal-body">

                <dl>
                    <dt>Tipo:</dt>
                    <dd>{{$adjunto['tipo']}}</dd>
                </dl>
                <div class="col-sm-12">
                    <div class="form-group">
                        @include('controles.criterio_fijo', ['control_control' => 'id_calificacion'
                                               , 'control_id' => 'id_calificacion_'.$adjunto['adjunto']->id_adjunto
                                               ,'control_grupo'=>125
                                               , 'control_default'=>$adjunto['adjunto']->id_calificacion ?? 1
                                               ,'control_texto'=>'Calificación del acceso:'])
                    </div>
                </div>
                <div class="col-sm-12 hidden" id="div_126_{{ $adjunto['adjunto']->id_adjunto  }}">
                    <div class="form-group">
                        @include('controles.criterio_fijo', ['control_control' => 'id_justificacion_126'
                                               , 'control_id' => 'id_justificacion_126_'.$adjunto['adjunto']->id_adjunto
                                               ,'control_grupo'=>126
                                               , 'control_excepcion_entrevista' => true
                                               , 'control_default' => $adjunto['adjunto']->id_calificacion==2 ? $adjunto['adjunto']->arreglo_justificacion : []
                                               , 'control_multiple' => true
                                               ,'control_texto'=>'Justificaciones para "Pública Clasificada":'])
                    </div>
                </div>
                <div class="col-sm-12 hidden" id="div_127_{{ $adjunto['adjunto']->id_adjunto  }}">
                    <div class="form-group">
                        @include('controles.criterio_fijo', ['control_control' => 'id_justificacion_127'
                                               , 'control_id' => 'id_justificacion_127_'.$adjunto['adjunto']->id_adjunto
                                               ,'control_grupo'=>127
                                               , 'control_excepcion_entrevista' => true
                                               , 'control_default' => $adjunto['adjunto']->id_calificacion==3 ? $adjunto['adjunto']->arreglo_justificacion : []
                                               , 'control_multiple' => true
                                               ,'control_texto'=>'Justificaciones para "Pública Reservada":'])
                    </div>
                </div>
                <div class="col-sm-12 hidden" id="div_128_{{ $adjunto['adjunto']->id_adjunto  }}">
                    <div class="form-group" >
                        @include('controles.criterio_fijo', ['control_control' => 'id_justificacion_128'
                                               ,'control_grupo'=>128
                                               , 'control_multiple' => false
                                               , 'control_default' => $adjunto['adjunto']->justificacion
                                               , 'control_id' => 'id_justificacion_128_'.$adjunto['adjunto']->id_adjunto
                                               ,'control_texto'=>'Justificación para "Inteligencia y Contrainteligencia":' ])
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Grabar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('js')
    <script>
        //Estado inicial
        @if($adjunto['adjunto']->id_calificacion == 2)
            $('#div_126_{{ $adjunto['adjunto']->id_adjunto  }}').removeClass('hidden');
        @elseif($adjunto['adjunto']->id_calificacion == 3)
            $('#div_127_{{ $adjunto['adjunto']->id_adjunto  }}').removeClass('hidden');
        @elseif($adjunto['adjunto']->id_calificacion == 4)
            $('#div_128_{{ $adjunto['adjunto']->id_adjunto  }}').removeClass('hidden');
        @endif


        //Listener a la calificacion para saber cual justificacion mostrar
        $('#{{ 'id_calificacion_'.$adjunto['adjunto']->id_adjunto }}').on('select2:select', function (e) {
            var data = e.params.data;

            //Ocultar los controles
            $('#div_126_{{ $adjunto['adjunto']->id_adjunto  }}').addClass('hidden');
            $('#div_127_{{ $adjunto['adjunto']->id_adjunto  }}').addClass('hidden');
            $('#div_128_{{ $adjunto['adjunto']->id_adjunto  }}').addClass('hidden');


            if(data.element.value==2) {
                $('#div_126_{{ $adjunto['adjunto']->id_adjunto  }}').removeClass('hidden');
            }
            if(data.element.value==3) {
                $('#div_127_{{ $adjunto['adjunto']->id_adjunto  }}').removeClass('hidden');
            }
            if(data.element.value==4) {
                $('#div_128_{{ $adjunto['adjunto']->id_adjunto  }}').removeClass('hidden');
            }
        });
        //Validar que no olviden la justificacion
        $('#frm_califica_{{ $adjunto['adjunto']->id_adjunto }}').submit(function() {
            let arreglo =  $('#{{ 'id_calificacion_'.$adjunto['adjunto']->id_adjunto }}').select2('data');
            let calificacion = arreglo[0].id;
            //Verificar que hayan justificado

            if(calificacion >=2) {
                let justificacion =[];
                if(calificacion==2) {
                    justificacion= $('#{{ 'id_justificacion_126_'.$adjunto['adjunto']->id_adjunto }}').select2('data');
                }
                if(calificacion==3) {
                    justificacion= $('#{{ 'id_justificacion_127_'.$adjunto['adjunto']->id_adjunto }}').select2('data');
                }
                if(calificacion==4) {
                    justificacion= $('#{{ 'id_justificacion_128_'.$adjunto['adjunto']->id_adjunto }}').select2('data');
                }
                if(justificacion.length==0) {
                    alert('Antes de continuar, favor de justificar la calificacion');
                    return false;
                }
                else {
                    return true;
                }
            }
        });
    </script>
@endpush
