
<div class="row">
    @include('adminlte-templates::common.errors')
    {!! Form::open(['route' => 'censoArchivosPermisos.store']) !!}
    {!! Form::hidden('id_censo_archivos', $censoArchivos->id_censo_archivos) !!}
    @include('censo_archivos_permisos.fields')
    {!! Form::close() !!}
</div>

