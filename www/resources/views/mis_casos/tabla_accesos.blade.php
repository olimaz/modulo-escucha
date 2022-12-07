<h4>Accesos a este caso</h4>
<div class="col-sm-6">
    <div class="box box-info">
        <div class="box-body table-responsive no-padding">
            @if(count($misCasos->listado_usuarios) > 0)
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Perfil</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i=1)
                    @foreach($misCasos->listado_usuarios as $fila)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $fila->fmt_id_entrevistador }}</td>
                            <td>{{ $fila->fmt_id_perfil }}</td>
                            <td>
                                {!! Form::open(['route' => ['misCasosEntrevistadors.destroy', $fila->id_mis_casos_entrevistador], 'method' => 'delete']) !!}
                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Segura?')"]) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>

            @else
                <h4 class="text-primary">No existen usuarios autorizados a acceder con privilegios especiales.<br><small><i class="fa fa-hand-o-right"></i>Todos los usuarios del sistema pueden acceder a este caso con los privilegios de "Acceso General".</small></h4>
            @endif
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="box box-warning">
        <div class="box-body">
            @include("mis_casos_entrevistadors.create")
        </div>
    </div>

</div>
<div class="clearfix"></div>

@include("mis_casos.perfiles")

@if(count($misCasos->listado_adjuntos_compartidos()) > 0 )
    <h4>Accesos otorgados a archivos anexos</h4>
    @php($misCasosAdjuntoCompartirs = $misCasos->listado_adjuntos_compartidos())
    <div class="col-sm-12">
        <div class="box box-default">
            <div class="box-body">
                @include("mis_casos_adjunto_compartirs.table")
            </div>
        </div>
    </div>
@endif

<div class="clearfix"></div>


