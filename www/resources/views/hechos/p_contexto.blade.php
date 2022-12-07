<div class="clearfix"></div>
<div class="col-sm-12">
    <div class="box {{ count($hecho->rel_contexto)>0 ? ' box-success ' : ' box-danger ' }} box-solid">
        <div class="box-header">
            <h3 class="box-title">
                @if ($hecho->tipo_expendiente=='individual')
                    5. Contexto (explicaciones, dinámicas y finalidades de las violencias)
                @else 
                    3. Contexto (explicaciones, dinámicas y finalidades de las violencias)
                @endif                
            </h3>

        </div>
        <div class="box-body">
            @include('hechos.p_contexto_detalle')
        </div>
        <div class="box-footer text-center">
            @if(count($hecho->rel_contexto)>0)
                <button class="btn btn-default" onclick="$('#modal_contexto').modal('show')">Modificar contexto</button>
            @else
                <button class="btn btn-primary" onclick="$('#modal_contexto').modal('show')">Especificar contexto</button>
            @endif
        </div>
    </div>
</div>
<div class="clearfix"></div>




{{-- Contexto --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_contexto">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_contextoController@grabar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Contexto </h4>
            </div>

            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_contexto'
                                                              ,'control_id'=>'id_contexto_1'
                                                              ,'control_id_cat'=>127
                                                              , 'control_multiple' => true
                                                              , 'control_requerido' => false
                                                              , 'control_default' => $hecho->arreglo_contexto(127)
                                                              , 'control_vacio' => '[Ninguno / No aplica]'
                                                              , 'control_otro' => false //actualizado 17/abr
                                                              ,'control_texto'=>'1. Motivos específicos por los cuales cree que ocurrieron los hechos:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_contexto'
                                                              ,'control_id'=>'id_contexto_2'
                                                              ,'control_id_cat'=>128
                                                              , 'control_multiple' => true
                                                              , 'control_requerido' => false
                                                              , 'control_default' => $hecho->arreglo_contexto(128)
                                                              , 'control_vacio' => '[Ninguno / No aplica]'
                                                              , 'control_otro' => true
                                                              ,'control_texto'=>'2. Contexto de control territorial y/o de la población:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_contexto'
                                                              ,'control_id'=>'id_contexto_3'
                                                              ,'control_id_cat'=>129
                                                              , 'control_multiple' => true
                                                              , 'control_requerido' => false
                                                              , 'control_default' => $hecho->arreglo_contexto(129)
                                                              , 'control_vacio' => '[Ninguno / No aplica]'
                                                              , 'control_otro' => false //Ajuste del 17/abr
                                                              ,'control_texto'=>'3. Si los hechos ocurrieron en lugares públicos, indique si dicho espacio es significativo para:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_contexto'
                                                              ,'control_id'=>'id_contexto_4'
                                                              ,'control_id_cat'=>130
                                                              , 'control_multiple' => true
                                                              , 'control_requerido' => false
                                                              , 'control_default' => $hecho->arreglo_contexto(130)
                                                              , 'control_vacio' => '[Ninguno / No aplica]'
                                                              , 'control_otro' => false
                                                              ,'control_texto'=>'4. Factores externos que influenciaron en los hechos:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_contexto'
                                                              ,'control_id'=>'id_contexto_5'
                                                              ,'control_id_cat'=>131
                                                              , 'control_multiple' => true
                                                              , 'control_requerido' => false
                                                              , 'control_default' => $hecho->arreglo_contexto(131)
                                                              , 'control_vacio' => '[Ninguno / No aplica]'
                                                              , 'control_otro' => true
                                                              ,'control_texto'=>'5. La persona entrevistada considera que estos hechos violentos beneficiaron a:'])
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
        {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->