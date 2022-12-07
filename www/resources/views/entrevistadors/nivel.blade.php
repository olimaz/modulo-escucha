@extends('layouts.app')

@section('content_header')
    <h1 class="page-header">
        Perfil del entrevistador #{!! $entrevistador->numero_entrevistador !!}
    </h1>
@endsection
@section('content')
    @include("entrevistadors.ficha",['usuario'=>$entrevistador->rel_usuario])
    <div class="content">
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title">Asignar nuevos privilegios al usuario</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['action'=>['entrevistadorController@cambiar_nivel',$entrevistador->id_entrevistador]]) !!}
                <div class="col-sm-12">
                    <div class="col-sm-4">
                        <div class="form-group">
                            @include('controles.privilegios', ['control_control' => 'id_nivel'
                                                , 'control_default'=>$entrevistador->id_nivel
                                                ,'control_texto'=>'Privilegios del usuario'])
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            @include('controles.criterio_fijo', ['control_control' => 'id_grupo'
                                                ,'control_grupo'=>5
                                                , 'control_default'=>$entrevistador->id_grupo
                                                //, 'control_vacio' => '[Mostrar todos]'
                                                ,'control_texto'=>'Grupo al que pertenece'])
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            @include('controles.criterio_fijo', ['control_control' => 'solo_lectura'
                                                ,'control_grupo'=>2
                                                , 'control_default'=>$entrevistador->solo_lectura
                                                //, 'control_vacio' => '[Mostrar todos]'
                                                ,'control_texto'=>'Restringir como investigador'])
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <hr>
                    <h4>Permisos especiales de acceso a documentos adjuntos a entrevistas R-3</h4>
                    <div class="col-sm-4">
                        <div class="form-group">
                            @include('controles.criterio_fijo', ['control_control' => 'r3_nna'
                                               ,'control_grupo'=>2
                                               , 'control_default'=>$entrevistador->r3_nna
                                               //, 'control_vacio' => '[Mostrar todos]'
                                               ,'control_texto'=>'Acceder entrevistas NNA:'])
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            @include('controles.criterio_fijo', ['control_control' => 'r3_vs'
                                               ,'control_grupo'=>2
                                               , 'control_default'=>$entrevistador->r3_vs
                                               //, 'control_vacio' => '[Mostrar todos]'
                                               ,'control_texto'=>'Acceder entrevistas que incluyen Violencia Sexual:'])
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            @include('controles.criterio_fijo', ['control_control' => 'r3_ri'
                                               ,'control_grupo'=>2
                                               , 'control_default'=>$entrevistador->r3_nna
                                               //, 'control_vacio' => '[Mostrar todos]'
                                               ,'control_texto'=>'Acceder entrevistas que incluyen reconocimiento de responsabilidades:'])
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            @include('controles.criterio_fijo', ['control_control' => 'r3_aa'
                                               ,'control_grupo'=>2
                                               , 'control_default'=>$entrevistador->r3_aa
                                               //, 'control_vacio' => '[Mostrar todos]'
                                               ,'control_texto'=>'Acceder entrevistas a Actores Armados o Terceros Civiles:'])
                        </div>
                    </div>

                    <hr>
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <h4>Si es entrevistador, permitirle cargar entrevistas a nombre de otras personas</h4>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            @include('controles.criterio_fijo', ['control_control' => 'id_grupo_acceso'
                                                ,'control_grupo'=>5
                                                ,'control_multiple'=>true
                                                , 'control_default'=>$entrevistador->id_grupo_acceso_arreglo
                                                , 'control_vacio' => '[Ninguno]'
                                                ,'control_texto'=>'Facilitar acceso a estos grupos:'])
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('id_nivel_acceso', 'Los grupos son accesibles a nivel de:') !!}
                            {!! Form::select('id_nivel_acceso',[2=>'Todo el grupo',3=>'Mismo macroterritorio',4=>'Mismo territorio'],$entrevistador->id_nivel_acceso,['class' => 'form-control','id'=>'id_nivel_acceso','style'=>'width:100%']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary">Aplicar cambios</button>
                    <a href="{{ action("entrevistadorController@index") }}" class="btn btn-default">Cancelar</a>
                </div>



                {!! Form::close() !!}
            </div>


        </div>

        <div class="clearfix"></div>

        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row" style="padding-left: 20px">
                        @include('entrevistadors.show_fields')
                    </div>
                </div>
                <div class="box-footer">
                    <a class="btn btn-default" href="{{ action("entrevistadorController@edit",$entrevistador->id_entrevistador) }}">Modificar territorio o ubicación</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            @include("entrevistadors.privilegios")
        </div>
    </div>
    <div class="clearfix"></div>


@endsection
