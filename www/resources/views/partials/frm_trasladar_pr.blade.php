{{-- Modal para trasladar a PR --}}
<div class="modal fade" id="modal_traslada_{{ $id_entrevista }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Trasladar entrevista {{ $codigo_entrevista }} a entrevistas a profundidad</h4>
            </div>

            <div class="modal-body">
                <p>Por medio de este formulario, se transforma una entrevista en entrevista a profundidad:</p>
                <div class="text-muted"><i class="fa fa-hand-o-right"></i> Esta acción anula la entrevista {{ $codigo_entrevista }} y crea una nueva entrevista a profundidad. </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a href="{{ action('entrevista_individualController@trasladar_pr',$id_entrevista) }}"  class="btn btn-primary">Trasladar entrevista</a>
            </div>

        </div>
    </div>
</div>
