{{-- Datos generales --}}

<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'id_categoria'
                                            ,'control_id_cat'=>201
                                            , 'control_default'=>$exilio->arreglo_id_categoria
                                            , 'control_multiple' => true
                                            , 'control_requerido' => true
                                            , 'control_otro' => true
                                            ,'control_texto'=>'Se reconoce en una o varias de las siguientes categorías:'])
</div>

{{-- PRIMERA SALIDA --}}
<div class="col-xs-12">
    <h3>1. Primera salida</h3>
</div>

<input type="hidden" name="id_tipo_movimiento" value="1">

<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'id_motivo'
                                            ,'control_id_cat'=>202
                                            , 'control_default'=>$movimiento->arreglo_id_motivo
                                            , 'control_multiple' => true
                                            , 'control_requerido' => true
                                            , 'control_otro' => true
                                            ,'control_texto'=>'Motivos de la salida del país:'])
</div>
<div class="clearfix"></div>
{{-- SALIDA --}}
<div class="col-sm-6">
    <div class="box box-solid box-info">
        <div class="box-header">
            <h3 class="box-title">Información de la salida</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-12">
                @include('controles.fecha_incompleta', ['control_control' => 'fecha_salida'
                                         , 'control_default'=>$movimiento->fecha_salida
                                         , 'control_texto'=>'Fecha de salida:'
                                         , 'required'])
            </div>
            <div class="col-xs-12">
                @include('controles.geo3', ['control_control' => 'id_lugar_salida'
                                ,'control_texto' => 'Lugar salida (en Colombia):'
                                , 'control_default'=>$movimiento->id_lugar_salida])
            </div>
            <div class="form-group col-xs-12">
                @include('controles.catalogo', ['control_control' => 'id_proteccion'
                                                        ,'control_id'=>'id_acompanamiento'
                                                        ,'control_id_cat'=>218
                                                        , 'control_default'=>$movimiento->arreglo_id_acompanamiento
                                                        , 'control_multiple' => true
                                                        , 'control_requerido' => false
                                                        , 'control_otro' => true
                                                        ,'control_texto'=>'Acompañamiento:'])
            </div>

        </div>
    </div>

</div>
{{-- LLEGADA --}}
<div class="col-sm-6">
    <div class="box box-solid box-info">
        <div class="box-header">
            <h3 class="box-title">Información de la llegada</h3>
        </div>
        <div class="box-body">

            <div class="col-sm-12">
                @include('controles.fecha_incompleta', ['control_control' => 'fecha_llegada'
                                         , 'control_default'=>$movimiento->fecha_llegada
                                         , 'control_texto'=>'Fecha de llegada:'
                                         , 'required'])
            </div>
            <div class="form-group col-sm-12">
                @include('controles.fecha_incompleta', ['control_control' => 'fecha_asentamiento'
                                        , 'control_default'=>$movimiento->fecha_asentamiento
                                        , 'control_texto'=>'Fecha de llegada al lugar de asentamiento   :'
                                        , 'required'])
            </div>
            <div class="col-xs-12">
                <h4>Lugar de llegada inicial</h4>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    @include('controles.geo3', ['control_control' => 'id_lugar_llegada'
                       ,'control_texto' => 'Lugar de llegada:'
                        ,'control_otro' => true
                       , 'control_default'=>$movimiento->id_lugar_llegada])
                </div>
            </div>
            {{--

            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('llegada_pais', 'País:') !!}
                    {!! Form::text('llegada_pais', $movimiento->llegada_pais, ['class' => 'form-control','maxlength'=>200,'required'=>'required']) !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('llegada_estado', 'Departamento/Estado:') !!}
                    {!! Form::text('llegada_estado', $movimiento->llegada_estado, ['class' => 'form-control','maxlength'=>200]) !!}
                </div>
            </div>
            --}}
            <div class="col-xs-12">
                <div class="form-group">
                    {!! Form::label('llegada_ciudad', 'Lugar específico:') !!}
                    {!! Form::text('llegada_ciudad', $movimiento->llegada_ciudad, ['class' => 'form-control','maxlength'=>200]) !!}
                </div>
            </div>


            <div class="col-xs-12">
                <h5>Si fue temporal, indique el lugar de asentamiento posterior</h5>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    @include('controles.geo3', ['control_control' => 'id_lugar_llegada_2'
                       ,'control_texto' => 'Lugar de llegada:'
                       ,'control_vacio' => 'Sin especificar'
                        ,'control_otro' => true
                       , 'control_default'=>$movimiento->id_lugar_llegada_2])
                </div>
            </div>
            {{--

            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('llegada_2_pais', 'País:') !!}
                    {!! Form::text('llegada_2_pais', $movimiento->llegada_2_pais, ['class' => 'form-control','maxlength'=>200]) !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('llegada_2_estado', 'Departamento/Estado:') !!}
                    {!! Form::text('llegada_2_estado', $movimiento->llegada_2_estado, ['class' => 'form-control','maxlength'=>200]) !!}
                </div>
            </div>
            --}}
            <div class="col-xs-12">
                <div class="form-group">
                    {!! Form::label('llegada_2_ciudad', 'Lugar específico:') !!}
                    {!! Form::text('llegada_2_ciudad', $movimiento->llegada_2_ciudad, ['class' => 'form-control','maxlength'=>200]) !!}
                </div>
            </div>




        </div>
    </div>
</div>
<div class="clearfix"></div>

{{-- Modalidad --}}
<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'id_modalidad'
                                            ,'control_id_cat'=>149
                                            , 'control_default'=>$movimiento->id_modalidad
                                            , 'control_multiple' => false
                                            , 'control_requerido' => true
                                            , 'control_otro' => false
                                            ,'control_texto'=>'Modalidad de la primera salida del país:'])
</div>

{{-- Cantidades --}}
<div class="clearfix"></div>
    <div class="form-group col-sm-4">
        {!! Form::label('cant_personas_salieron', 'Cantidad de personas que salieron:') !!}
        {!! Form::number('cant_personas_salieron', $movimiento->cant_personas_salieron, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-4">
        {!! Form::label('cant_personas_familia_salieron', 'Cant. de personas del núcleo familiar que salieron:') !!}
        {!! Form::number('cant_personas_familia_salieron',  $movimiento->cant_personas_familia_salieron, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-4">
        {!! Form::label('cant_personas_familia_quedaron', 'Cant. de personas del núcleo familiar que se quedaron:') !!}
        {!! Form::number('cant_personas_familia_quedaron', $movimiento->cant_personas_familia_quedaron, ['class' => 'form-control']) !!}
    </div>

<div class="clearfix"></div>

<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_proteccion'
                                            ,'control_id_cat'=>203
                                            , 'control_default'=>$movimiento->arreglo_proteccion(203)
                                            , 'control_multiple' => true
                                            , 'control_requerido' => true
                                            , 'control_vacio' => 'No'
                                            ,'control_texto'=>'¿Ha solicitado estatus de protección internacional o del país de acogida?:'])

</div>
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_estado_proteccion'
                                            ,'control_id_cat'=>204
                                            , 'control_default'=>$movimiento->id_estado_proteccion
                                            , 'control_multiple' => false
                                            , 'control_requerido' => true
                                            , 'control_otro' => false
                                            , 'control_vacio' => '[No aplica] No ha solicitado estatus de protección'
                                            ,'control_texto'=>'Estado de la solicitud:'])
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_aprobada_proteccion'
                                            ,'control_id_cat'=>205
                                            , 'control_default'=>$movimiento->id_aprobada_proteccion
                                            , 'control_multiple' => false
                                            , 'control_requerido' => true
                                            , 'control_otro' => false
                                            , 'control_vacio' => '[No aprobada]'
                                            ,'control_texto'=>'Si aprobada, por:'])
</div>
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_denegada_proteccion'
                                            ,'control_id_cat'=>206
                                            , 'control_default'=>$movimiento->id_denegada_proteccion
                                            , 'control_multiple' => false
                                            , 'control_requerido' => true
                                            , 'control_otro' => false
                                            , 'control_vacio' => '[No denegada]'
                                            ,'control_texto'=>'Si denegada, ¿en qué condición se encuentra la persona?'])
</div>

<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_residencia_proteccion'
                                            ,'control_id_cat'=>217
                                            , 'control_default'=>$movimiento->id_residencia_proteccion
                                            , 'control_multiple' => false
                                            , 'control_requerido' => true
                                            , 'control_otro' => false
                                            , 'control_vacio' => '[No ha obtenido]'
                                            ,'control_texto'=>'¿Ha obtenido residencia en el país de acogida?'])
</div>
<div class="form-group col-sm-6">
    @include('controles.radio_si_no', ['control_control' => 'id_expulsion'
                                            , 'control_default'=>$movimiento->id_expulsion
                                            ,'control_texto'=>'¿Ha sufrido un proceso de expulsión, deportación y/o devolución?'])
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}
</div>


@include("exilios.js_anios")
