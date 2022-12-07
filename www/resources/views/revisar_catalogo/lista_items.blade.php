<div class="modal fade" id="listar{!! $catalogo->id_item !!}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                </button>
                <h3>{!! $catalogo->FmtIdCatRevisar !!} : </h3>

            </div>
            <div class="modal-body">
                <h4>Sustituir "<b>{!! $catalogo->descripcion !!}</b>", con la siguiente opción :</h4>

              {!! Form::model($catalogo, ['route' => ['reasignar_catalogo'], 'method' => 'patch']) !!}


              <div class="form-group">
                <select class="form-control" name="id_item_asignar" id="id_item_asignar" required>
                  <option value selected>Seleccionar</option>
                  @foreach($catalogo->opciones as $opcion)
                    <option value="{{$opcion->id_item}}">{{$opcion->descripcion}}</option>
                  @endforeach
                </select>
              </div>
                <input type="hidden" name="id_cat" id="id_cat" value="{!! $catalogo->id_cat !!}">
                <input type="hidden" name="id_item" id="id_item" value="{!! $catalogo->id_item !!}">
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Asignar">
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
