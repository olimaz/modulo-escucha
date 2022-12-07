{{-- Para escoger el listado a mostrar --}}
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-primary {{ $filtros->id_tipo_listado==1 ? ' active ' : '' }}"  title="Muestra datos personales los presuntos responsables individuales" data-toggle="tooltip">
            <input type="radio" name="options" id="option_a1" autocomplete="off" onclick="cambiar_tipo_listado(1)"  {{ $filtros->id_tipo_listado==1 ? ' checked="" ' : '' }} > Mostrar listado de presuntos responsables
        </label>
        <label class="btn btn-primary {{ $filtros->id_tipo_listado==2 ? ' active ' : '' }}" title="Muestra metadatos de las entrevistas" data-toggle="tooltip">
            <input type="radio" name="options" id="option_a2" autocomplete="off" onclick="cambiar_tipo_listado(2)" {{ $filtros->id_tipo_listado==2 ? ' checked="" ' : '' }} > Mostrar listado de entrevistas
        </label>
    </div>
