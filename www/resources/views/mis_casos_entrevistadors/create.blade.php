<div class="row">
    @include('adminlte-templates::common.errors')
    {!! Form::open(['route' => 'misCasosEntrevistadors.store']) !!}
    {!! Form::hidden('id_mis_casos', $misCasos->id_mis_casos) !!}
    @include('mis_casos_entrevistadors.fields')
    {!! Form::close() !!}
</div>
