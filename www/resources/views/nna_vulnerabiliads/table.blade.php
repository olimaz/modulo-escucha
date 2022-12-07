<div class="table-responsive">
    <table class="table" id="nnaVulnerabiliads-table">
        <thead>
            <tr>
                <th>Correlativo</th>
                <th>Código</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Dictamen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($nnaVulnerabiliads as $nnaVulnerabiliad)
            <tr>

            <td>{!! $nnaVulnerabiliad->correlativo !!}</td>
            <td>{!! $nnaVulnerabiliad->codigo !!}</td>
            <td>{!! $nnaVulnerabiliad->fmt_nombres !!}</td>
            <td>{!! $nnaVulnerabiliad->fmt_apellidos !!}</td>
            <td>{!! $nnaVulnerabiliad->fmt_dictamen_corto !!}</td>

                <td>
                    {!! Form::open(['route' => ['nnaVulnerabiliads.destroy', $nnaVulnerabiliad->id_nna_vulnerabilidad], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('nnaVulnerabiliads.show', [$nnaVulnerabiliad->id_nna_vulnerabilidad]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        {{--
                        <a href="{!! route('nnaVulnerabiliads.edit', [$nnaVulnerabiliad->id_nna_vulnerabilidad]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        --}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
