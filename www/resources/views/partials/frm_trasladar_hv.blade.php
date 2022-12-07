{{-- Modal para trasladar a PR --}}
<div class="modal fade" id="modal_traslada_hv_{{ $id_entrevista }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Trasladar entrevista {{ $codigo_entrevista }} a Historia de Vida</h4>
            </div>

            <div class="modal-body">
                <p>Por medio de este formulario, se transforma una entrevista en Historia de Vida:</p>
                <div class="text-muted"><i class="fa fa-hand-o-right"></i> Esta acción anula la entrevista {{ $codigo_entrevista }} y crea una nueva Historia de Vida. </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a href="{{ action('entrevista_individualController@trasladar_hv',$id_entrevista) }}"  class="btn btn-primary">Trasladar entrevista</a>
            </div>

        </div>
    </div>
</div>
