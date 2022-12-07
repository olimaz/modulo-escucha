<div class="table-responsive">
    <table class="table" id="misCasosAdjuntoCompartirs-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Autorizado por</th>
                <th>Autorizado a</th>
                <th>Adjunto</th>
                <th>Anotaciones</th>
                <th>Estado</th>
                <th>Revocar</th>
            </tr>
        </thead>
        <tbody>
        @php($i=1)
        @foreach($misCasosAdjuntoCompartirs as $misCasosAdjuntoCompartir)
            <tr >
                <td >{{ $i++ }}</td>
                <td>{{ $misCasosAdjuntoCompartir->fmt_id_autorizador }}</td>
                <td class="text-primary">{{ $misCasosAdjuntoCompartir->fmt_id_autorizado }}</td>
                <td class="text-primary">{{ $misCasosAdjuntoCompartir->rel_id_mis_casos_adjunto->descripcion }}</td>
                <td>{!! nl2br($misCasosAdjuntoCompartir->anotaciones) !!}</td>
                <td>{!! $misCasosAdjuntoCompartir->fmt_id_situacion !!}</td>
                <td>
                    @if($misCasosAdjuntoCompartir->id_situacion == 1)
                        {!! Form::open(['route' => ['misCasosAdjuntoCompartirs.destroy', $misCasosAdjuntoCompartir->id_mis_casos_adjunto_compartir], 'method' => 'delete']) !!}
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Segura que desea revocar el acceso?')",'title'=>'Desactivar el acceso otorgado','data-toggle'=>'tooltip']) !!}
                        {!! Form::close() !!}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
