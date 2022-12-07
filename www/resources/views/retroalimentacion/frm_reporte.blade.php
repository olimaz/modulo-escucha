<!-- Button trigger modal -->
<span title="Reportar uso inadecuado de esta etiqueta" data-toggle="tooltip">
    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal_{{ $fila->id_etiqueta_entrevista }}">
        <i class="fa fa-info-circle "></i>
    </button>
</span>

<!-- Modal -->
{!! Form::open(['action'=>'retroalimentacion_etiquetadoController@store']) !!}
<div class="modal fade" id="modal_{{ $fila->id_etiqueta_entrevista }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Recomendar uso apropiado de una etiqueta</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Etiqueta:</label>
                    <p class="text-primary">{!! $fila->fmt_id_etiqueta !!}</p>
                </div>
                <div class="form-group">
                    <label>Texto etiquetado:</label>
                    <p ><i>{{ $fila->texto }}</i></p>
                </div>
                <div class="form-group">
                    <label>¿Porqué cree que esta etiqueta está mal aplicada? ¿Cuál es su sugerencia?</label>
                    <textarea id="comentarios_{{ $fila->id_etiqueta_entrevista }}" name="comentarios" rows="3" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <p>

                </p>
                <div>
                    <input type="hidden" name="id_etiqueta_entrevista" value="{{ $fila->id_etiqueta_entrevista }}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar sugerencia</button>
                </div>

            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}