{{-- Para escoger el listado a mostrar --}}

    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-primary {{ $filtros->id_tipo_listado==1 ? ' active ' : '' }}"  title="Muestra los nombres duplicados cuando existen múltiples violencias" data-toggle="tooltip">
            <input type="radio" name="options" id="option_a1" autocomplete="off" onclick="cambiar_tipo_listado(1)"  {{ $filtros->id_tipo_listado==1 ? ' checked="" ' : '' }} > Mostrar listado de victimizaciones
        </label>
        <label class="btn btn-primary {{ $filtros->id_tipo_listado==2 ? ' active ' : '' }}" title="Evita los nombres duplicados por múltiples violencias" data-toggle="tooltip">
            <input type="radio" name="options" id="option_a2" autocomplete="off" onclick="cambiar_tipo_listado(2)" {{ $filtros->id_tipo_listado==2 ? ' checked="" ' : '' }} > Mostrar listado de personas

        </label>
        <label class="btn btn-primary {{ $filtros->id_tipo_listado==3 ? ' active ' : '' }}" title="Muestra las entrevistas en que se encuentran las víctimas que cumplen con los criterios de filtrado" data-toggle="tooltip">
            <input type="radio" name="options" id="option_a3" autocomplete="off"  onclick="cambiar_tipo_listado(3)" {{ $filtros->id_tipo_listado==3 ? ' checked="" ' : '' }} > Mostrar listado de entrevistas
        </label>
    </div>
