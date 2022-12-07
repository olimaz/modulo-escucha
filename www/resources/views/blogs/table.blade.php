<div class="table-responsive">
    <table class="table" id="blogs-table">
        <thead>
            <tr>
                <th>Id Entrevistador</th>
        <th>Fecha Hora</th>
        <th>Titulo</th>
        <th>Html</th>
        <th>Texto</th>
        <th>Id Activo</th>
        <th>Id Blog Respondido</th>
        <th>Fh Update</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($blogs as $blog)
            <tr>
                <td>{{ $blog->id_entrevistador }}</td>
            <td>{{ $blog->fecha_hora }}</td>
            <td>{{ $blog->titulo }}</td>
            <td>{{ $blog->html }}</td>
            <td>{{ $blog->texto }}</td>
            <td>{{ $blog->id_activo }}</td>
            <td>{{ $blog->id_blog_respondido }}</td>
            <td>{{ $blog->fh_update }}</td>
                <td>
                    {!! Form::open(['route' => ['blogs.destroy', $blog->id_blog], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('blogs.show', [$blog->id_blog]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('blogs.edit', [$blog->id_blog]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
