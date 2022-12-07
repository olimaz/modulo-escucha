<link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
<table class="table table-responsive table-condensed table-bordered">
    <thead>
        <tr>
            @foreach($info->encabezado as $id=>$texto)
                @if(is_array($texto))
                    <th colspan="{{ count($info->a_cat[$info->mapa[$id]]) }}"> {{ isset($info->mapa_titulo[$id]) ?  $info->mapa_titulo[$id] : "" }} {{ \App\Models\cat_cat::find($info->mapa[$id])->nombre }}</th>
                @else
                    <th ></th>
                @endif
            @endforeach
        </tr>
        <tr>
            @foreach($info->encabezado as $id=>$texto)
                    @if(is_array($texto))
                        @if(count($info->a_cat[$info->mapa[$id]]) == 0)
                            <td>-</td>
                        @else
                            @foreach($info->a_cat[$info->mapa[$id]] as $id_item => $txt_item)
                                <td> {{ $txt_item }}</td>
                            @endforeach
                        @endif
                    @else
                    <th >{{ $texto }}</th>
                    @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($info->detalle as $fila)
            <tr>
                @foreach($info->encabezado as $id => $texto)
                    @if(is_array($texto))
                        @if(count($info->a_cat[$info->mapa[$id]])==0)
                            <td>-</td>
                        @else
                            @foreach($info->a_cat[$info->mapa[$id]] as $id_item => $txt_item)
                                <td> {{ isset($fila[$id][$id_item]) ? $fila[$id][$id_item] : 0  }}</td>
                            @endforeach
                        @endif
                    @else
                        <td>{{ isset($fila[$id]) ? $fila[$id] : 'N/A' }}</td>
                    @endif

                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>