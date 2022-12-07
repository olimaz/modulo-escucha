@php
    $editar = isset($editar) ? $editar : false;

@endphp

<table class="table table-condensed table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Tipo</th>
            <th>Código</th>
            <th>Titulo</th>
            <th>Anotaciones del enlace</th>
            @can('sistema-abierto')
            @if(Gate::allows('nivel-1'))
                <th>Quitar</th>
            @endif
            @endcan
        </tr>
    </thead>
    <tbody>
    @php($i=1)
    @foreach($listado_enlaces as $enlace)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{!! $enlace->enlace->fmt_id_tipo !!}</td>
            @if($enlace->enlace->id_tipo==1)
                <td><a href="{{ $enlace->link }}">{{ $enlace->codigo }}</a></td>
            @else
                <td>{{ $enlace->codigo }}</td>
            @endif
            <td>{{ $enlace->titulo }}</td>
            <td>{{ $enlace->anotaciones }}</td>
            @can('sistema-abierto')
                @can('nivel-1')
                <td>
                    {!! Form::open(['route' => ['enlaces.destroy', $enlace->id_enlace], 'method' => 'delete']) !!}
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Está segura?')"]) !!}
                    {!! Form::close() !!}
                </td>
                @endcan
            @endcan
        </tr>
    @endforeach
    </tbody>

</table>