{{-- Recibe id_mis_casos_adjunto en $fila_compartir --}}


<!-- Button trigger modal -->
<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_{{ $fila_compartir->id_mis_casos_adjunto }}">
    <i class="fa fa-share-alt" title="Autorizar acceso a este archivo" data-toggle="tooltip"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="modal_{{ $fila_compartir->id_mis_casos_adjunto }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open(['action'=>'mis_casos_adjunto_compartirController@store']) !!}

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Autorizar acceso a archiv adjunto</h4>
            </div>
            <div class="modal-body text-left">
                <div class="form-group col-xs-12">
                    <label>Autorizar el acceso a este archivo:</label>
                    <p class="text-primary">[R-{{ $fila_compartir->clasificacion_nivel }}] {{ $fila_compartir->descripcion }}</p>
                    <input type="hidden" name="id_mis_casos_adjunto"  value="{{ $fila_compartir->id_mis_casos_adjunto }}">
                </div>
                <div class="form-group col-xs-6">
                    <label>Autorizado por</label>
                    <p>{{ \Auth::user()->rel_entrevistador->nombre }}</p>
                </div>
                <div class="form-group col-xs-6">

                    @include('controles.entrevistador_todos', ['control_control' => 'id_autorizado'
                                                            ,'control_id' => 'id_autorizado_'. $fila_compartir->id_mis_casos_adjunto
                                                           ,'control_default' => \Auth::user()->id_entrevistador
                                                           ,'control_texto'=>"Usuario autorizado:"])

                </div>
                <div class="form-group col-xs-12 ">
                    {!! Form::label('anotaciones', 'Observaciones / Anotaciones:') !!}
                    {!! Form::textarea('anotaciones', null, ['class' => 'form-control', 'rows'=>3]) !!}
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Autorizar acceso</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>