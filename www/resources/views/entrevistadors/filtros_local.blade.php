<div class="box box-default  box-solid">
    <div class="box-header ">
        <h3 class="box-title"><i class="fa fa-filter" aria-hidden="true"></i> Usuarios: Filtrar la informaci&oacute;n visualizada</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        {{ Form::model($filtros,array('url' =>"#",'method' => 'get')) }}

        {{-- Correlativo, codigo, entrevistador y macro --}}
        <div class="row">
            <div class="col-md-1 ">
                <div class="form-group">
                    <label># Entrev.</label>
                    {!! Form::text('numero', null, ['class' => 'form-control','maxlength'=>5]) !!}
                </div>
            </div>
            <div class="col-md-2 ">
                <div class="form-group">
                    <label>Nombre</label>
                    {!! Form::text('nombre', null, ['class' => 'form-control','maxlength'=>50]) !!}
                </div>
            </div>

            <div class="col-sm-3">
                @include('controles.criterio_fijo', ['control_control' => 'id_nivel'
                                                    ,'control_grupo'=>400
                                                    , 'control_default'=>$filtros->id_nivel
                                                    , 'control_multiple' => false
                                                    , 'control_requerido' => false
                                                    , 'control_vacio' => '[Mostrar todos]'

                                                    ,'control_texto'=>'Privilegios:'])
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 ">
                <a href="{{ action('entrevistadorController@index') }}" class="btn btn-default">Quitar filtros y mostrar todo</a>
            </div>
            <div class="col-xs-6">
                <button type="submit" class="btn btn-success pull-right">Aplicar filtros</button>
            </div>

        </div>
        {{ Form::close() }}
    </div>
    <!-- /.box-body -->
</div>


