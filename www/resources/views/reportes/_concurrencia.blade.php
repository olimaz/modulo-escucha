@php($prefijo= isset($prefijo) ? $prefijo : "victima")
@section('content')
    <div class="box">
        <div class="box-header">
            <h1 class="box-title">Matriz</h1>
            <br>
            <a class='btn btn-info btn-xs ' href="#" id="b1"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-condensed" id="t1">
                <thead>
                <tr class="text-center">
                    <th>Violencia</th>

                    @foreach($datos['campos'] as $campo  )
                        <th> {{ $campo }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($datos['tabla'] as $x=>$fila)
                    <tr class="text-center">
                        <td class="text-left">{{ $x }}</td>
                        @foreach($datos['campos'] as $campo  )
                            @if(isset($fila[$campo]))
                                <td>{{ $fila[$campo] }}</td>
                            @else
                                <td class="bg-gray">-</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>


    <div class="box">
        <div class="box-header">
            <h1 class="box-title">Pares</h1>
            <br>
            <a class='btn btn-info btn-xs ' href="#" id="b2"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered" id="t2">
                <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Viol 1</th>
                    <th>Viol 2</th>
                    <th>Combinaciones</th>
                </tr>
                </thead>
                <tbody>
                @php($x='maiz')
                @php($y='maiz')
                @php($i=1)
                @foreach($datos['pares'] as $fila)
                    @if($fila['conteo']>0)
                        @if($x<> $fila['y'] && $y<>$fila['x'])
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$fila['x']}}</td>
                                <td>{{$fila['y']}}</td>
                                <td class="text-center">{{$fila['conteo']}}</td>
                            </tr>
                            @php($x=$fila['x'])
                            @php($y=$fila['y'])
                        @endif
                    @endif
                @endforeach
                </tbody>

            </table>
        </div>
    </div>



@endsection


@push('js')
    <script>
        // This must be a hyperlink
        $("#b1").on('click', function(event) {
            $("#t1").table2excel({
                name: "CEV",
                filename: "datos_concurrencia_{{ $prefijo }}_matriz_" + new Date().toLocaleString("en-GB", {timeZone: "America/Bogota"}).replace(/[\-\:\.]/g, "").substring(0,10)+ ".xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });

        // This must be a hyperlink
        $("#b2").on('click', function(event) {
            $("#t2").table2excel({
                name: "CEV",
                filename: "datos_concurrencia_{{ $prefijo }}_pares_" + new Date().toLocaleString("en-GB", {timeZone: "America/Bogota"}).replace(/[\-\:\.]/g, "").substring(0,10)+ ".xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });


    </script>
@endpush
