{{-- igual que create2, pero para bootstrap 4 --}}
<div class="modal fade" id="modal_marca_{{ $id_entrevista }}_{{ $id_subserie }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Marcar entrevista {{ $codigo_entrevista }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['action' => 'marca_entrevistaController@store','id'=>"frm_marca_$id_entrevista"]) !!}
            <div class="modal-body">
                <p>Puede seleccionar marcas existentes o agregar marcas nuevas, escribiendolas y separandolas por comas.</p>

                    {!! Form::hidden('id_subserie', $id_subserie) !!}
                    {!! Form::hidden('id_entrevista', $id_entrevista) !!}

                    <div class="col-sm-12">
                        @include('controles.marca', ['control_control' => 'marca'
                                                        , 'control_id'=>"marca_$id_entrevista"
                                                        , 'control_default' => \App\Models\marca_entrevista::listar_marcas_aplicadas($id_subserie, $id_entrevista)
                                                       ,'control_texto'=>'Aplicar las siguientes marcas:'])
                    </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Aplicar marcas</button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
