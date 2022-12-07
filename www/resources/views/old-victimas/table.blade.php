<div class="table-responsive">
    <table class="table table-striped table-hover table-condensed table-bordered " id="victimas-table">
        <thead>
            <tr>
                <th>Declarante</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Otros Nombres</th>
                <th>Fecha Nacimiento</th>
                {{--
                <th>Acciones</th>
                 --}}
            </tr>
        </thead>
        <tbody>
        @foreach($victimas as $victima)
            <tr>
                <td>{!! $victima->fmt_es_declarante !!}</td>
                <td>{!! $victima->nombres !!}</td>
                <td>{!! $victima->apellidos !!}</td>
                <td>{!! $victima->otros_nombres !!}</td>
                <td>{!! $victima->fmt_nacimiento_fecha !!}</td>
                {{--
                <td>
                    {!! Form::open(['route' => ['victimas.destroy', $victima->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('victimas.show', [$victima->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('victimas.edit', [$victima->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
                --}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
