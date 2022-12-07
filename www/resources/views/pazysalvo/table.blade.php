<div class="table-responsive">
    <table class="table" id="censoArchivos-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Codigo</th>
                <th class="text-center">Consentimiento informado</th>
                <th class="text-center">Audio</th>
                <th class="text-center">Relatoría</th>
                <th class="text-center">Ficha corta</th>
                <th class="text-center">¿Está completa?</th>
            </tr>
        </thead>
        <tbody>
        @php
            $i=1;
        @endphp
        @foreach($datos->entrevistas as $serie => $listado)
            @foreach($listado as $id=>$codigo)
                @php
                    $estado = $datos->verificacion[$serie][$id];
                @endphp

                @if($filtros->id_completo<1 || $filtros->id_completo==$estado['completo'])
                <tr>
                    <td>{{ $i++ }}</td>
                    <td> <a href="{{ url('ubicar')."/".$codigo }}" target="_blank">
                        {{ $codigo }}
                        </a>
                    </td>

                    @foreach($datos->criterios as $chequeo)
                        <td class="text-center">
                            @if($estado[$chequeo]==1)
                                @include('pazysalvo._si')
                            @elseif($estado[$chequeo]==2)
                                @include('pazysalvo._no')
                            @else
                                @include('pazysalvo._na')
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endif

            @endforeach
        @endforeach

        </tbody>
    </table>
</div>
