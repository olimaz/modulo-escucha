{{-- Modal para trasladar PR a CO --}}
<div class="modal fade" id="modal_traslada_ee_{{ $id_entrevista }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Trasladar entrevista {{ $codigo_entrevista }} a Entrevista a Sujeto Colectivo</h4>
            </div>

            <div class="modal-body">
                <p>Por medio de este formulario, confirme el traslado hacia una nueva entrevista a sujeto colectivo:</p>
                <div class="text-muted"><i class="fa fa-hand-o-right"></i> Esta acción anula la entrevista {{ $codigo_entrevista }} y crea una nueva entrevista a sujeto colectivo. </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a href="{{ action('entrevista_colectivaController@trasladar_ee',$id_entrevista) }}"  class="btn btn-primary">Trasladar entrevista</a>
            </div>

        </div>
    </div>
</div>
