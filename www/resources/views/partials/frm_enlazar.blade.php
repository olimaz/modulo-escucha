{{-- Modal para enlazar 2 entrevistas --}}
<div class="modal fade" id="modal_enlaza_{{ $id_entrevista }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Enlazar entrevista {{ $codigo_entrevista }}</h4>
            </div>
            {!! Form::open(['action' => 'enlaceController@store','id'=>"frm_enlaza_$id_entrevista"]) !!}
            <div class="modal-body">
                <p>Por medio de este formulario, se establece un enlace con la siguiente entrevista:</p>

                {!! Form::hidden('id_subserie', $id_subserie) !!}
                {!! Form::hidden('id_primaria', $id_entrevista) !!}
                {!! Form::hidden('id_tipo', 1) !!} {{-- 1: enlazar --}}

                <div class="col-sm-12">
                    <div class="form-group ">
                        {!! Form::label('codigo', 'Código de la entrevista a enlazar: ') !!}
                        {!! Form::text('codigo', null, ['class' => 'form-control','required'=>'required','minlength'=>12,'data-toggle'=>"tooltip" , 'placeholder'=>'123-XX-12345']) !!}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group ">
                        {!! Form::label('anotaciones', 'Explicar por qué se establece el enlace:') !!}
                        {!! Form::textarea('anotaciones', null, ['class' => 'form-control','rows'=>'3','required'=>'required']) !!}
                    </div>
                    <div class="text-muted"><i class="fa fa-hand-o-right"></i> Esta acción permite relacionar dos entrevistas: ambas siguen vigentes y sirve para ambos sentidos. </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Grabar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
