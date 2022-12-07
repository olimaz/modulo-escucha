<div class="modal fade" id="modal_problema_{{ $fila->id_seguimiento_problema }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Seguimiento a problema con expediente {!! $fila->fmt_entrevista_codigo !!}</h4>
            </div>
            {!! Form::open(['action' => 'seguimientoController@actualizar_problema']) !!}
            <input type="hidden" name="id_seguimiento_problema" id="id_seguimiento_problema_{{ $fila->id_seguimiento_problema }}" value="{{ $fila->id_seguimiento_problema }}">
            <div class="modal-body">
                <div class="col-md-13">
                    <h3 class="text-info">Reporte</h3>
                </div>
                <div class="col-md-4">
                    <label>Tipo de problema:</label>
                    <p>{{ \App\Models\cat_item::describir($fila->id_tipo_problema)  }}</p>
                </div>
                <div class="col-md-8">
                    <label>Descripción:</label>
                    <p>{{ nl2br($fila->descripcion) }}</p>
                </div>
                <div class="col-md-13">
                    <h3 class="text-primary">Seguimiento</h3>
                </div>
                <div class="col-md-4">
                    @include('controles.criterio_fijo', ['control_control' => 'id_resolvible'
                                                ,'control_id' => 'cerrado_id_estado_'.$fila->id_resolvible
                                                ,'control_default' => $fila->id_resolvible
                                                ,'control_grupo' => 12
                                                ,'control_texto'=>'El problema puede ser resuelto'])
                </div>
                <div class="col-md-8">
                    <div class="form-group ">
                        {!! Form::label('sugerencia', "Resolución sugerida:") !!}
                        {!! Form::textarea('sugerencia',$fila->sugerencia, ['class'=>'form-control','rows'=>3,'id'=>'c_a_'.$fila->id_seguimiento_problema]) !!}
                    </div>
                </div>
                <div class="col-md-13">
                    <h3 class="text-success">Resolución</h3>
                </div>
                <div class="col-md-4">
                    @include('controles.criterio_fijo', ['control_control' => 'cerrado_id_estado'
                                                ,'control_id' => 'cerrado_id_estado_'.$fila->id_seguimiento_problema
                                                ,'control_default' => $fila->cerrado_id_estado
                                                ,'control_grupo' => 2
                                                ,'control_texto'=>'El problema ha sido resuelto'])
                </div>
                <div class="col-md-8">
                    <div class="form-group ">
                        {!! Form::label('cerrado_anotaciones', "Anotaciones:") !!}
                        {!! Form::textarea('cerrado_anotaciones',$fila->cerrado_anotaciones, ['class'=>'form-control','rows'=>3,'id'=>'c_a_'.$fila->id_seguimiento_problema]) !!}
                    </div>
                </div>
                <div class="clearfix"></div>


            </div>
            <div class="modal-footer">
                <span class="text-muted pull-left">Actualización registrada por {{ \Auth::user()->name }}</span>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>