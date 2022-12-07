{{-- Formulario para el botón de priorizar en  las tablas de entrevistas --}}

<div class="modal fade" id="modal_prioriza" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Establecer priorización para la  entrevista <span id="priorizar_codigo" class="text-primary">ABC</span></h4>
            </div>
            {!! Form::open(['action' => 'seguimientoController@grabar_priorizacion','id'=>"frm_priorizar"]) !!}
            <div class="modal-body">
                <input type="hidden" name="id_subserie" id="p_id_subserie" value="0">
                <input type="hidden" name="codigo" id="p_codigo" value="">
                <input type="hidden" name="id_entrevista" id="p_id_entrevista" value="0">

                @include("seguimiento.p_priorizacion")
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Grabar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push("js")
    <script>
        function mostrar_priorizacion(id_subserie, id_entrevista, codigo) {
            $("#priorizar_codigo").html(codigo);
            $("#p_id_subserie").val(id_subserie);
            $("#p_id_entrevista").val(id_entrevista);
            $("#p_codigo").val(codigo);
            $('#modal_prioriza').modal('toggle')
        }
    </script>
@endpush