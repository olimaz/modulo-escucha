<div class="modal fade" id="editar{!! $catalogo->id_item !!}">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">
                  <span>×</span>
              </button>
              <h3>Editar descripción del item : <b>{!! $catalogo->descripcion !!}</b></h3>
          </div>
            <div class="modal-body">


              {!! Form::open(array('route' => 'editar_item')) !!}


                  {!! Form::text('nuevo_nombre', $catalogo->descripcion, ['class' => 'form-control', 'maxlength' => 150]) !!}
    
                <input type="hidden" name="id_cat" id="id_cat" value="{!! $catalogo->id_cat !!}">
                <input type="hidden" name="id_item" id="id_item" value="{!! $catalogo->id_item !!}">


            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Guardar">
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
