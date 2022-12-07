<table class="table table-condensed">
    <tbody>
    @if ($hecho->tipo_expediente()=='individual')        
    <tr>
        <th>Cantidad de víctimas</th>
        <td>{{ $hecho->cantidad_victimas }}</td>
    </tr>
    <tr>
        <th>Víctimas identificadas</th>
        <td>{{ $hecho->rel_victima()->count() }}</td>
    </tr>
    @endif
    <tr>
        <th>Tipos de violencia</th>
        <td>{{ $hecho->rel_violencia()->count() }}</td>
    </tr>
    <tr>
        <th>Presuntos responsables</th>
        <td>{{ $hecho->rel_responsable()->count() }}</td>
    </tr>
    </tbody>
</table>