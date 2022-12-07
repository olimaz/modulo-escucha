

<div class="col-xs-12">
    <h3>{{ \App\Models\criterio_fijo::describir(30,$movimiento->id_tipo_movimiento) }}</h3>

</div>


@if($movimiento->id_tipo_movimiento == 2)
    <div class="form-group col-sm-12">
        @include('controles.catalogo', ['control_control' => 'id_motivo'
                                                ,'control_id_cat'=>207
                                                , 'control_default'=>$movimiento->arreglo_motivo(207)
                                                , 'control_multiple' => true
                                                , 'control_requerido' => true
                                                , 'control_otro' => true
                                                ,'control_texto'=>'Motivos de la salida del país del anterior asentamiento:'])
    </div>

@else
    <div class="form-group col-sm-12" >
        @include('controles.radio_si_no_div', ['control_control' => 'id_ha_tenido_retorno'
                                                ,'control_div'=>'div_retorno'
                                                , 'control_default'=>$exilio->id_ha_tenido_retorno
                                                ,'control_texto'=>'¿Ha tenido uno o más procesos de retorno?:'])
    </div>
    <div class="form-group col-sm-6  {{ $exilio->id_ha_tenido_retorno == 1 ? '' : 'hidden' }}" id="div_motivo_si">
        @include('controles.catalogo', ['control_control' => 'id_motivo'
                                                ,'control_id'=>'id_motivo_si'
                                                ,'control_id_cat'=>212
                                                , 'control_default'=>$movimiento->arreglo_motivo(212)
                                                , 'control_multiple' => true
                                                , 'control_vacio' => '[No aplica] No ha tenido proceso de retorno'
                                                , 'control_otro' => true
                                                ,'control_texto'=>'Si ha tenido procesos de retorno, ¿Por qué retornó?'])
    </div>
    <div class="form-group col-sm-6 {{ $exilio->id_ha_tenido_retorno == 1 ? 'hidden' : '' }}" id="div_motivo_no">
        @include('controles.catalogo', ['control_control' => 'id_motivo'
                                                ,'control_id'=>'id_motivo_no'
                                                ,'control_id_cat'=>213
                                                , 'control_default'=>$movimiento->arreglo_motivo(213)
                                                , 'control_multiple' => true
                                                , 'control_vacio' => '[No aplica] Tuvo proceso de retorno'
                                                , 'control_otro' => true
                                                ,'control_texto'=>'Si no ha tenido proceso de retorno, ¿Por qué NO ha retornado?'])
    </div>


@endif
<div class="clearfix"></div>
{{-- REASENTAMIENTO --}}
@if($movimiento->id_tipo_movimiento == 2)
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
                    <div class="form-group">
                        @include('controles.geo3', ['control_control' => 'id_lugar_salida'
                           ,'control_texto' => 'Lugar de salida:'
                            ,'control_otro' => true
                           , 'control_default'=>$movimiento->id_lugar_salida])
                    </div>
                </div>
                {{--
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('salida_pais', 'País:') !!}
                        {!! Form::text('salida_pais', $movimiento->salida_pais, ['class' => 'form-control','maxlength'=>200,'required'=>'required']) !!}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('salida_estado', 'Departamento/Estado:') !!}
                        {!! Form::text('salida_estado', $movimiento->salida_estado, ['class' => 'form-control','maxlength'=>200]) !!}
                    </div>
                </div>
                --}}
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::label('salida_ciudad', 'Lugar específico:') !!}
                        {!! Form::text('salida_ciudad', $movimiento->salida_ciudad, ['class' => 'form-control','maxlength'=>200]) !!}
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_proteccion'
                                                            ,'control_id'=>'id_acompanamiento'
                                                            ,'control_id_cat'=>218
                                                            , 'control_default'=>$movimiento->arreglo_proteccion(218)
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
                           ,'control_texto' => 'Lugar de asentamiento:'
                            ,'control_otro' => true
                           ,'control_vacio' => 'Sin especificar'
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
@else
    {{-- RETORNO --}}
    <div id="div_retorno">
        <div class="col-sm-6">
            {{-- SALIDA --}}
            <div class="box box-solid box-info">
                <div class="box-header">
                    <h3 class="box-title">Información de la salida</h3>
                </div>
                <div class="box-body">
                    <div class="col-xs-12">
                        @include('controles.fecha_incompleta', ['control_control' => 'fecha_salida'
                                                 , 'control_default'=>$movimiento->fecha_salida
                                                 , 'control_texto'=>'Fecha de salida:'
                                                 ])
                    </div>
                    {{--
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('salida_pais', 'País:') !!}
                            {!! Form::text('salida_pais', $movimiento->salida_pais, ['class' => 'form-control','maxlength'=>200]) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('salida_estado', 'Departamento/Estado:') !!}
                            {!! Form::text('salida_estado', $movimiento->salida_estado, ['class' => 'form-control','maxlength'=>200]) !!}
                        </div>
                    </div>
                    --}}
                    <div class="col-xs-12">
                        <div class="form-group">
                            @include('controles.geo3', ['control_control' => 'id_lugar_salida'
                               ,'control_texto' => 'Lugar de salida:'
                                ,'control_otro' => true
                               , 'control_default'=>$movimiento->id_lugar_salida])
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            {!! Form::label('salida_ciudad', 'Lugar específico:') !!}
                            {!! Form::text('salida_ciudad', $movimiento->salida_ciudad, ['class' => 'form-control','maxlength'=>200]) !!}
                        </div>
                    </div>
                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_proteccion'
                                                                ,'control_id'=>'id_acompanamiento'
                                                                ,'control_id_cat'=>218
                                                                , 'control_default'=>$movimiento->arreglo_proteccion(218)
                                                                , 'control_multiple' => true
                                                                , 'control_requerido' => false
                                                                , 'control_otro' => true
                                                                ,'control_texto'=>'Acompañamiento en la salida:'])
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            {!! Form::label('entidad_apoyo_retorno', 'Especificar entidad:') !!}
                            {!! Form::text('entidad_apoyo_retorno', $exilio->entidad_apoyo_retorno, ['class' => 'form-control','maxlength'=>200]) !!}
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-sm-6">
            {{-- LLEGADA --}}
            <div class="box box-solid box-info">
                <div class="box-header">
                    <h3 class="box-title">Información de la llegada</h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-12">
                        @include('controles.fecha_incompleta', ['control_control' => 'fecha_llegada'
                                                 , 'control_default'=>$movimiento->fecha_llegada
                                                 , 'control_texto'=>'Fecha de llegada:'
                                                 ])
                    </div>


                    <div class="col-xs-12">
                        <div class="form-group">
                            @include('controles.geo3', ['control_control' => 'id_lugar_llegada'
                               ,'control_texto' => 'Lugar de retorno en Colombia:'
                               ,'control_otro' => false
                               , 'control_default'=>$movimiento->id_lugar_llegada])
                        </div>
                    </div>
                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_proteccion_2'
                                                                ,'control_id'=>'id_acompanamiento_2'
                                                                ,'control_id_cat'=>218
                                                                , 'control_default'=>$movimiento->arreglo_proteccion(218,2)
                                                                , 'control_multiple' => true
                                                                , 'control_requerido' => false
                                                                , 'control_otro' => true
                                                                ,'control_texto'=>'Acompañamiento en la llegada:'])
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
                                                    , 'control_requerido' => false
                                                    , 'control_otro' => false
                                                    ,'control_texto'=>'Modalidad del retorno:'])
        </div>

        {{-- Cantidades --}}
        <div class="clearfix"></div>
        <div class="form-group col-sm-4">
            {!! Form::label('cant_personas_salieron', 'Cantidad de personas que retornaron:') !!}
            {!! Form::number('cant_personas_salieron', $movimiento->cant_personas_salieron, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-sm-4">
            {!! Form::label('cant_personas_familia_salieron', 'Cant. de personas del núcleo familiar que retornaron:') !!}
            {!! Form::number('cant_personas_familia_salieron',  $movimiento->cant_personas_familia_salieron, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-sm-4">
            {!! Form::label('cant_personas_familia_quedaron', 'Cant. de personas del núcleo familiar que se quedaron:') !!}
            {!! Form::number('cant_personas_familia_quedaron', $movimiento->cant_personas_familia_quedaron, ['class' => 'form-control']) !!}
        </div>

        <div class="clearfix"></div>

        <div class="form-group col-sm-6">
            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                    ,'control_id_cat'=>214
                                                    ,'control_id'=>'id_impacto_retorno'
                                                    , 'control_default'=>$exilio->arreglo_impacto(214)
                                                    , 'control_multiple' => true
                                                    , 'control_requerido' => false
                                                    , 'control_otro' => true
                                                    ,'control_texto'=>'Impactos del retorno:'])

        </div>
        <div class="form-group col-sm-6">
            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                    ,'control_id_cat'=>215
                                                    ,'control_id'=>'id_acompa_retorno'
                                                    , 'control_default'=>$exilio->arreglo_impacto(215)
                                                    , 'control_multiple' => true
                                                    , 'control_requerido' => false
                                                    , 'control_otro' => true
                                                    ,'control_texto'=>'Afrontamientos del retorno:'])

        </div>
        <div class="form-group col-sm-6">
            @include('controles.radio_si_no_div', ['control_control' => 'id_ha_tenido_ayuda'
                                                    , 'control_default'=>$exilio->id_ha_tenido_ayuda
                                                    , 'control_div' =>'div_ayuda'
                                                    ,'control_texto'=>'Una vez retornado, ¿Tuvo ayuda de alguna institución colombiana?'])
        </div>
        <div class="clearfix"></div>
        <div id="div_ayuda">
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('institucion_ayuda', 'Institución que le ayudó:') !!}
                    {!! Form::text('institucion_ayuda', $exilio->institucion_ayuda, ['class' => 'form-control','maxlength'=>200]) !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                   ,'control_id_cat'=>216
                                                   ,'control_id'=>'id_ayuda'
                                                   , 'control_default'=>$exilio->arreglo_impacto(216)
                                                   , 'control_multiple' => true
                                                   , 'control_requerido' => false
                                                   , 'control_otro' => true
                                                   ,'control_texto'=>'Ayuda recibida:'])
                </div>
            </div>
        </div>



        <div class="clearfix"></div>
        <div class="form-group col-sm-12">
            @include('controles.radio_si_no', ['control_control' => 'id_otro_exilio'
                                                    , 'control_default'=>$exilio->id_otro_exilio
                                                    ,'control_texto'=>'Después del retorno, ¿volvió a exiliarse?'])
        </div>


    </div>
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}

</div>


@push("js")
    <script>



        function mostrar_cual_id_ha_tenido_ayuda() {
            var si = $('#id_ha_tenido_ayuda_1').iCheck('update')[0].checked;
            if(si) {
                $('#div_ayuda').removeClass('hidden');
                // $('#-1').prop('required',true);
            }
            else {
                $('#div_ayuda').addClass('hidden');
                // $('#-1').prop('required',false);
            }
            return si;
        };




        $(function() {


            $(".icheck_id_ha_tenido_retorno").on('ifChanged', function (event) {
                //console.log('cambio en tuvo retorno');
                var si = $('#id_ha_tenido_retorno_1').iCheck('update')[0].checked;
                if(si) {
                    $('#div_motivo_no').addClass('hidden');
                    $('#div_motivo_si').removeClass('hidden');
                }
                else {
                    $('#div_motivo_no').removeClass('hidden');
                    $('#div_motivo_si').addClass('hidden');
                }
            });

        });

        //$("[name='id_ha_tenido_retorno']").on('ifChanged', console.log('cambio si'));
        //$("#id_ha_tenido_retorno").on('ifChanged', console.log('cambio no'));
    </script>
@endpush

@include("exilios.js_anios")