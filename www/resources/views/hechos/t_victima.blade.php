<table class="table table-condensed table-hover table-bordered">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Otros nombres</th>
        <th>Edad</th>
        <th>Parentezco</th>
        <th>Acciones</th>

    </tr>
    </thead>
    <tbody>
    @foreach($hecho->rel_victima as $vic)

        <tr>
            @if($vic->rel_id_victima->es_declarante_menor())
                <td>(menor de edad)</td>
                <td>(menor de edad)</td>
            @else
                <td>{{ $vic->rel_id_victima->persona->nombre_completo }} </td>
                <td>{{ $vic->rel_id_victima->persona->alias }}</td>
            @endif
            <td>{{ $vic->edad }}</td>
            <td>{{ $vic->rel_id_victima->fmt_parentezco }}</td>
            <td>

                <div class='btn-group'>

                    @if(isset($no_editar))
                        <a href="{!! route('victimas.show', [$vic->rel_id_victima->id_persona, $vic->rel_id_victima->id_e_ind_fvt]) !!}?id_hecho={{ $hecho->id_hecho }}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                    @else
                        {!! Form::open(['action' => ['hecho_victimaController@quitar', $vic->id_hecho_victima]]) !!}
                            <a href="{!! route('victimas.show', [$vic->rel_id_victima->id_persona, $vic->rel_id_victima->id_e_ind_fvt]) !!}?id_hecho={{ $hecho->id_hecho }}&edicion=1" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{!! route('victimas.edit', [$vic->rel_id_victima->id_persona, $vic->rel_id_victima->id_e_ind_fvt]) !!}?id_hecho={{ $hecho->id_hecho }}&edicion=1" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                            <button type="submit"  class="btn btn-danger btn-sm" onclick = "return confirm('¿Segura?')">Quitar</button>
                        {!! Form::close() !!}
                    @endif
                </div>


            </td>
        </tr>
    @endforeach
    </tbody>
</table>
