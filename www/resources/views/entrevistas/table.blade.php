<div class="table-responsive">
    <table class="table" id="entrevistas-table">
        <thead>
            <tr>
        <th>Código entrevista individual</th>
        <!-- <th>Id Idioma</th> -->
        <!-- <th>Id Nativo</th> -->
        <th>Acompañamiento</th>
        <th>Nombre Interprete</th>
        <th>Documentacion Aporta</th>
        <!-- <th>Documentacion Especificar</th> -->
        <th>Identifica Testigos</th>
        <th>Ampliar Relato</th>
        <!-- <th>Ampliar Relato Temas</th> -->
        <th>Priorizar Entrevista</th>
        <!-- <th>Priorizar Entrevista Asuntos</th> -->
        <th>Contiene Patrones</th>
        <!-- <th>Contiene Patrones Cuales</th> -->
        <!-- <th>Indicaciones Transcripcion</th> -->
        <!-- <th>Observaciones</th> -->
        <!-- <th>Created At</th> -->
        <!-- <th>Updated At</th> -->
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($entrevistas as $entrevista)
            <tr>
            <td>{!! $entrevista->fmt_id_e_ind_fvt !!}</td>
            <!-- <td>{!! $entrevista->fmt_id_idioma !!}</td> -->
            <!-- <td>{!! $entrevista->fmt_id_nativo !!}</td> -->
            <td>{!! $entrevista->fmt_entrevista_condiciones !!}</td>
            <td>{!! $entrevista->nombre_interprete !!}</td>
            <td>{!! $entrevista->fmt_documentacion_aporta !!}</td>
            <!-- <td>{!! $entrevista->documentacion_especificar !!}</td> -->
            <td>{!! $entrevista->fmt_identifica_testigos !!}</td>
            <td>{!! $entrevista->fmt_ampliar_relato !!}</td>
            <!-- <td>{!! $entrevista->ampliar_relato_temas !!}</td> -->
            <td>{!! $entrevista->fmt_priorizar_entrevista !!}</td>
            <!-- <td>{!! $entrevista->priorizar_entrevista_asuntos !!}</td> -->
            <td>{!! $entrevista->fmt_contiene_patrones !!}</td>
            <!-- <td>{!! $entrevista->contiene_patrones_cuales !!}</td> -->
            <!-- <td>{!! $entrevista->indicaciones_transcripcion !!}</td> -->
            <!-- <td>{!! $entrevista->observaciones !!}</td> -->
            <!-- <td>{!! $entrevista->created_at !!}</td> -->
            <!-- <td>{!! $entrevista->updated_at !!}</td> -->
                <td>
                    {!! Form::open(['route' => ['entrevistas.destroy', $entrevista->id_entrevista], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('entrevistas.show', [$entrevista->id_entrevista]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('entrevistas.edit', [$entrevista->id_entrevista]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        <!-- {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} -->
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
