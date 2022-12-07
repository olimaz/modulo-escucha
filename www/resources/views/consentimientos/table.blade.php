{{-- Revisar si puede acceder adjuntos --}}
@php($puede_adjuntos = \App\Models\entrevista_individual::revisar_acceso_adjuntos($entrevista))
@php($puede_modificar = \App\Models\entrevista_individual::revisar_modificar_entrevista($entrevista))


<div class="box box-warning box-solid collapsed-box">
    <div class="box-header">
        <h3 class="box-title"> Consentimientos informados</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="row" style="padding-left: 20px">
            <div class="table-responsive">
                <table class="table" id="consentimientos-table">
                    <thead>
                    <tr>
                        <th colspan="5">
                            Datos personales
                        </th>
                        <th colspan="3">
                            Consentimiento informado
                        </th>
                        <th colspan="5">
                            Tratamiento de datos personales y sensibles
                        </th>
                    </tr>
                    <tr>
                        <th># Persona</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Nombre Identitario</th>
                        <th>Identificación</th>
                        {{-- consentimiento informado --}}
                        <th data-toggle="tooltip" title="¿Está de acuerdo en conceder entrevistas a la comisión de la verdad?">
                            Conceder entrevista
                        </th>
                        <th data-toggle="tooltip" title="¿Está de acuerdo en que la comisión grabe el audio de la entrevista?">
                            Grabar audio
                        </th>
                        <th data-toggle="tooltip" title="¿Está de acuerdo en que su entrevista se utilizada para elaborar el informe final?">
                            Informe final
                        </th>
                        {{-- Tratamiento de datos --}}
                        <th data-toggle="tooltip" title="Datos personales  - Autorización para analizarlos, compararlos, contrastarlos con otros datos e información recolectada">
                            Personales: análisis
                        </th>
                        <th data-toggle="tooltip" title="Datos sensibles:  Autorización para analizarlos, compararlos, contrastarlos con otros datos e información recolectada">
                            Sensibles: análisis
                        </th>
                        <th data-toggle="tooltip" title="Datos personales: Autorización para utilizarlos para la elaboración del informe final	">
                            Personales: uso en informe
                        </th>
                        <th data-toggle="tooltip" title="Datos sensibles: Autorización para utilizarlos para la elaboración del informe final	">
                            Sensibles: uso en informe
                        </th>
                        <th data-toggle="tooltip" title="Datos personales: Autorización para publicar su nombre en el informe final">
                            Publicar su nombre
                        </th>
                        <th >&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($consentimientos as $consentimiento)
                        <tr>
                            @if(!$puede_adjuntos)
                                <td colspan="5" class="text-center">
                                    Perfil de usuario sin acceso a estos datos
                                </td>

                            @else
                                <td>{!! $consentimiento->consentimiento_correlativo !!}</td>
                                <td>
                                    @if(empty($consentimiento->consentimiento_nombres))
                                        (En blanco)
                                    @else
                                        {!! $consentimiento->consentimiento_nombres !!}
                                    @endif
                                </td>
                                <td>
                                    @if(empty($consentimiento->consentimiento_apellidos))
                                        (En blanco)
                                @else
                                    {!! $consentimiento->consentimiento_apellidos !!}
                                @endif

                                <td>
                                    @if(empty($consentimiento->nombre_identitario))
                                        -
                                    @else
                                        {!! $consentimiento->nombre_identitario !!}
                                    @endif
                                </td>
                                <td>{!! $consentimiento->identificacion_consentimiento !!}</td>
                            @endif

                            @if($consentimiento->asistencia==1)
                                <td colspan="8">
                                    Listado de asistencia
                                </td>
                            @else

                                <td>{!! $consentimiento->fmt_conceder_entrevista !!}</td>
                                <td>{!! $consentimiento->fmt_grabar_audio !!}</td>
                                <td>{!! $consentimiento->fmt_elaborar_informe   !!}</td>

                                <td>{!! $consentimiento->fmt_tratamiento_datos_analizar !!}</td>
                                <td>{!! $consentimiento->fmt_tratamiento_datos_analizar_sensible !!}</td>
                                <td>{!! $consentimiento->fmt_tratamiento_datos_utilizar !!}</td>
                                <td>{!! $consentimiento->fmt_tratamiento_datos_utilizar_sensible !!}</td>
                                <td>{!! $consentimiento->fmt_tratamiento_datos_publicar !!}</td>
                            @endif
                            <td>
                                <div class='btn-group'>
                                    @if( $puede_adjuntos)
                                        <a href="{!! action('entrevistaController@show', [$consentimiento->id_entrevista]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                        {{-- de momento, no hay edicion de consentimiento informado --}}
                                        @if($puede_modificar and false )
                                            {!! Form::open(['action' => ['entrevistaController@destroy', $consentimiento->id_entrevista]]) !!}
                                            <a href="{!! action('entrevistaController@edit', [$consentimiento->id_entrevista]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Confirme que desea eliminar el consentimiento')"]) !!}
                                            {!! Form::close() !!}
                                        @endif
                                    @endif
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


