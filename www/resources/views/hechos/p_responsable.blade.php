<table class="table table-condensed table-hover">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Otros nombres</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    @foreach($hecho->rel_responsable as $res)
        <tr>
            <td>{{ $res->rel_id_persona_responsable->persona->nombre_completo }}</td>
            <td>{{ $res->rel_id_persona_responsable->persona->alias }}</td>
            <td>

                {!! Form::open(['action' => ['hecho_responsableController@quitar', $res->id_hecho_responsable]]) !!}
                <div class='btn-group'>

                    @if(isset($no_editar))                    
                        {{-- <i href="{!! route('persona_responsable.show', [$res->rel_id_persona_responsable->id_persona, $res->rel_id_persona_responsable->id_e_ind_fvt]) !!}?id_hecho={{ $hecho->id_hecho }}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></i> --}}
                        @if (isset($volver_ficha_show) && $volver_ficha_show=='fs')
                         {{-- entra 1 --}}
                            <a href="{!! route('persona_responsable.show', [$res->rel_id_persona_responsable->id_persona, $res->id_entrevista]) !!}?id_hecho={{ $hecho->id_hecho }}&fs_i" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>  
                        @else
                           {{-- entra 2 --}}
                            <a href="{!! route('persona_responsable.show', [$res->rel_id_persona_responsable->id_persona, $res->id_entrevista]) !!}?id_hecho={{ $hecho->id_hecho }}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                        @endif
                        
                        
                    @else
                        {{-- <i href="{!! route('persona_responsable.show', [$res->rel_id_persona_responsable->id_persona, $res->rel_id_persona_responsable->id_e_ind_fvt]) !!}?id_hecho={{ $hecho->id_hecho }}&edicion=1" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></i> --}}
                        <a href="{!! route('persona_responsable.show', [$res->rel_id_persona_responsable->id_persona, $res->id_entrevista]) !!}?id_hecho={{ $hecho->id_hecho }}&edicion=1" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>

                        {{-- <i href="{!! route('persona_responsable.edit', [$res->rel_id_persona_responsable->id_persona, $res->rel_id_persona_responsable->id_e_ind_fvt]) !!}?id_hecho={{ $hecho->id_hecho }}&edicion=1" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></i> --}}
                        <a href="{!! route('persona_responsable.edit', [$res->rel_id_persona_responsable->id_persona, $res->id_entrevista]) !!}?id_hecho={{ $hecho->id_hecho }}&edicion=1" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                        <button type="submit"  class="btn btn-danger btn-sm" onclick = "return confirm('¿Segura?')">Quitar</button>
                    @endif
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

