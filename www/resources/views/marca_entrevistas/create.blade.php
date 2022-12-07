@if('sistema-abierto')
{{-- igual que create, pero se usa en buscador de etiquetado --}}
<div class="modal fade" id="modal_marca_{{ $id_subserie }}_{{ $id_entrevista }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Marcar entrevista {{ $codigo_entrevista }}</h4>
            </div>
            {!! Form::open(['action' => 'marca_entrevistaController@store','id'=>"frm_marca_".$id_subserie."_".$id_entrevista]) !!}
            <div class="modal-body">
                <p>Puede seleccionar marcas existentes o agregar marcas nuevas, escribiendolas y separandolas por comas.</p>

                    {!! Form::hidden('id_subserie', $id_subserie) !!}
                    {!! Form::hidden('id_entrevista', $id_entrevista) !!}

                    <div class="col-sm-12">
                        @include('controles.marca', ['control_control' => 'marca'
                                                        , 'control_id'=>"marca_".$id_subserie."_".$id_entrevista
                                                        ,'control_resaltar' => false
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
@endif