<div class="table-responsive">
    <table class="table" id="fEntrevistas-table">
        <thead>
            <tr>
                <th>Id E Ind Fvt</th>
        <th>Id Idioma</th>
        <th>Id Nativo</th>
        <th>Nombre Interprete</th>
        <th>Documentacion Aporta</th>
        <th>Documentacion Especificar</th>
        <th>Identifica Testigos</th>
        <th>Ampliar Relato</th>
        <th>Ampliar Relato Temas</th>
        <th>Priorizar Entrevista</th>
        <th>Priorizar Entrevista Asuntos</th>
        <th>Contiene Patrones</th>
        <th>Contiene Patrones Cuales</th>
        <th>Indicaciones Transcripcion</th>
        <th>Observaciones</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th>Identificacion Consentimiento</th>
        <th>Conceder Entrevista</th>
        <th>Grabar Audio</th>
        <th>Elaborar Informe</th>
        <th>Tratamiento Datos Analizar</th>
        <th>Tratamiento Datos Analizar Sensible</th>
        <th>Tratamiento Datos Utilizar</th>
        <th>Tratamiento Datos Utilizar Sensible</th>
        <th>Tratamiento Datos Publicar</th>
        <th>Insert Ent</th>
        <th>Insert Ip</th>
        <th>Insert Fh</th>
        <th>Update Ent</th>
        <th>Update Ip</th>
        <th>Update Fh</th>
        <th>Id Entrevista Etnica</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($fEntrevistas as $fEntrevista)
            <tr>
                <td>{{ $fEntrevista->id_e_ind_fvt }}</td>
            <td>{{ $fEntrevista->id_idioma }}</td>
            <td>{{ $fEntrevista->id_nativo }}</td>
            <td>{{ $fEntrevista->nombre_interprete }}</td>
            <td>{{ $fEntrevista->documentacion_aporta }}</td>
            <td>{{ $fEntrevista->documentacion_especificar }}</td>
            <td>{{ $fEntrevista->identifica_testigos }}</td>
            <td>{{ $fEntrevista->ampliar_relato }}</td>
            <td>{{ $fEntrevista->ampliar_relato_temas }}</td>
            <td>{{ $fEntrevista->priorizar_entrevista }}</td>
            <td>{{ $fEntrevista->priorizar_entrevista_asuntos }}</td>
            <td>{{ $fEntrevista->contiene_patrones }}</td>
            <td>{{ $fEntrevista->contiene_patrones_cuales }}</td>
            <td>{{ $fEntrevista->indicaciones_transcripcion }}</td>
            <td>{{ $fEntrevista->observaciones }}</td>
            <td>{{ $fEntrevista->created_at }}</td>
            <td>{{ $fEntrevista->updated_at }}</td>
            <td>{{ $fEntrevista->identificacion_consentimiento }}</td>
            <td>{{ $fEntrevista->conceder_entrevista }}</td>
            <td>{{ $fEntrevista->grabar_audio }}</td>
            <td>{{ $fEntrevista->elaborar_informe }}</td>
            <td>{{ $fEntrevista->tratamiento_datos_analizar }}</td>
            <td>{{ $fEntrevista->tratamiento_datos_analizar_sensible }}</td>
            <td>{{ $fEntrevista->tratamiento_datos_utilizar }}</td>
            <td>{{ $fEntrevista->tratamiento_datos_utilizar_sensible }}</td>
            <td>{{ $fEntrevista->tratamiento_datos_publicar }}</td>
            <td>{{ $fEntrevista->insert_ent }}</td>
            <td>{{ $fEntrevista->insert_ip }}</td>
            <td>{{ $fEntrevista->insert_fh }}</td>
            <td>{{ $fEntrevista->update_ent }}</td>
            <td>{{ $fEntrevista->update_ip }}</td>
            <td>{{ $fEntrevista->update_fh }}</td>
            <td>{{ $fEntrevista->id_entrevista_etnica }}</td>
                <td>
                    {!! Form::open(['route' => ['f_entrevistas.destroy', $fEntrevista->id_entrevista], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('f_entrevistas.show', [$fEntrevista->id_entrevista]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('f_entrevistas.edit', [$fEntrevista->id_entrevista]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
