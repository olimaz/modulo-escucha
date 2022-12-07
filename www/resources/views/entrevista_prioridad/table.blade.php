
<table class="table table-responsive table-hover table-condensed table-bordered" id="entrevistaIndividuals-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Código entrevista</th>
            <th title="Clasificación" data-toggle="tooltip">Clas.</th>
            <th>Territorio</th>
            <th>Transcrita</th>
            <th>Etiquetada</th>
            <th>Hechos</th>
            <th>Contexo</th>
            <th>Impactos</th>
            <th>Justicia</th>
            <th>Prioridad</th>
            @can('nivel-10')
                <th>Transcribir</th>
                <th>Etiquetar</th>
            @endcan
        </tr>
    </thead>
    <tbody>
    @php($i=1)
    @foreach($listado as $entrevista)
        @php($url = \App\Models\entrevista_prioridad::url_show($entrevista))
        @php($link = "style='cursor: pointer;' onclick='window.location.href=".'"'.$url.'"'.";'")
        <tr >
            <td {!! $link !!}>{{ $i++ }}</td>
            <td {!! $link !!}> {{ $entrevista->entrevista_codigo }}</td>
            <td {!! $link !!}> R-{{ $entrevista->nivel }}</td>
            <td {!! $link !!}> {{ $entrevista->fmt_id_territorio }}</td>
            <td {!! $link !!} class="text-center">
                {!!   \App\Models\entrevista_prioridad::estado_transcripcion($entrevista) !!}
                @can('nivel-10')
                @php($quien = \App\Models\entrevista_prioridad::quien_transcribe($entrevista))
                    {!! $quien ? " / $quien" : "" !!}
                @endcan
            </td>
            <td {!! $link !!} class="text-center"> {!!   \App\Models\entrevista_prioridad::estado_etiquetado($entrevista) !!}</td>

            <td {!! $link !!} class="text-center"> {{ $entrevista->d_hecho }}</td>
            <td {!! $link !!} class="text-center"> {{ $entrevista->d_contexto }}</td>
            <td {!! $link !!} class="text-center"> {{ $entrevista->d_impacto }}</td>
            <td {!! $link !!} class="text-center"> {{ $entrevista->d_justicia }}</td>
            <td class="text-center"> {{ $entrevista->ponderacion }}</td>
            @can('nivel-10')
                <td class="text-center"> {!! \App\Models\entrevista_prioridad::link_asignar_transcripcion($entrevista) !!} </td>
                <td class="text-center">     {!! \App\Models\entrevista_prioridad::link_asignar_etiquetado($entrevista) !!}</td>
            @endcan
        </tr>
    @endforeach
    </tbody>
</table>