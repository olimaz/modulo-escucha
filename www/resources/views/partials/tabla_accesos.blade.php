@if($entrevista->clasifica_nivel<=3)
    @if($entrevista->rel_acceso_reservado->count() > 0)
        <div class="box box-default ">
            <div class="box-header">
                <h3 class="box-title">
                    Permisos de acceso a los adjuntos, concedidos en esta entrevista.
                </h3>
            </div>
            <table class="table table-condensed table-bordered table-hover">
                <thead>
                <tr>
                    <th class="text-center">Acceso otorgado a</th>
                    <th class="text-center">Autorizado por</th>
                    <th class="text-center">Fecha gestión</th>
                    <th class="text-center">Desde</th>
                    <th class="text-center">Hasta</th>
                    <th class="text-center">Soporte</th>
                    @can('sistema-abierto')
                        @if(\Gate::check('nivel-1') || \Gate::check('es-propio',$entrevista->id_entrevistador))
                            <th class="text-center">Quitar acceso</th>
                        @endif
                    @endcan
                </tr>
                </thead>
                <tbody>
                @foreach($entrevista->rel_acceso_reservado as $permitido)
                    <tr >
                        <td>
                            <a href="{{ action('entrevistadorController@show',$permitido->rel_id_autorizado->id_entrevistador) }}">
                                {{ $permitido->rel_id_autorizado->numero_entrevistador }} - {{ $permitido->rel_id_autorizado->fmt_nombre }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ action('entrevistadorController@show',$permitido->rel_id_autorizador->id_entrevistador) }}">
                                {{ $permitido->rel_id_autorizador->numero_entrevistador }} - {{ $permitido->rel_id_autorizador->fmt_nombre }}
                            </a>
                        </td>
                        <td>{{ $permitido->fmt_fh_insert }}</td>
                        <td>{{ $permitido->fmt_fh_del }}</td>
                        <td>{{ $permitido->fmt_fh_al }}</td>
                        <td>{!!   $permitido->url !!}</td>
                        @can('sistema-abierto')
                            @if(\Gate::check('nivel-1') || \Gate::check('es-propio',$entrevista->id_entrevistador))
                                <td class="text-center">
                                    {!! Form::open(['action' => ['reservado_accesoController@destroy', $permitido->id_reservado_acceso], 'method' => 'delete']) !!}
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Seguro que desea eliminar la autorización?')"]) !!}
                                    {!! Form::close()  !!}
                                </td>
                            @endif
                        @endcan
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    @endif

    @if(\App\Models\entrevista_individual::revisar_conceder_acceso($entrevista))


        {!! Form::open(['action' => 'reservado_accesoController@store','id'=>'frm_acceso','files' => true]) !!}
        {!! Form::hidden('id_subserie',$entrevista->id_subserie) !!}
        {!! Form::hidden('id_primaria', $id_primaria) !!}
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">
                    Autorizar acceso a archivos adjuntos
                </h3>
            </div>
            <div class="box-body">
                <div class="col-xs-4">
                    <div class="form-group ">
                        @include('controles.carga_archivo', ['control_control' => 'archivo_20'
                                                   , 'control_texto'=>"<i class='fa fa-file-pdf-o' aria-hidden='true'></i> Soporte/Autorización"])
                    </div>
                </div>
                <div class="col-xs-8">
                    <div class="form-group col-xs-12">
                        @include('controles.entrevistador_todos', ['control_control' => 'id_autorizado'
                                            , 'control_mi_mismo'=>false
                                            ,'control_texto'=>'Facilitar acceso al siguiente entrevistador:'])
                    </div>
                    <div class="form-group col-xs-12">
                        {!! Form::label('fecha_rango', 'Período en que autoriza el acceso (se incluyen los extremos):') !!}
                        {!! Form::text('fecha_rango', null, ['class' => 'form-control dateRange2','required'=>'required']) !!}
                    </div>
                    <div class="form-group col-xs-12">
                        <button type="submit" class="btn btn-success">Dar acceso</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close()  !!}
    @endif
@endcan

@include("partials.js_frm_reservado_acceso")