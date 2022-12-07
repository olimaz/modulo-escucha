@extends("layouts.app")
@section('title', 'Catalogos del sistema')
@section('content_header')
    <h1>Modificar opción existente <small>opciones personalizables.</small></h1>
@stop


@section("content")
    @include("controles.errores")
    <div class="col-sm-8 col-sm-offset-2">

        {!! Form::open(['action' => ['cat_itemController@update',$item->id_item]])  !!}
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"> <b>Listado: </b>
                    {{ \App\Models\cat_cat::find($item->id_cat)->nombre }}
                </h3>
            </div>
            <div class="box-body">
                <div class="form-group col-md-6">
                    {!! Form::label('orden',"Orden/Posición:") !!}
                    {!! Form::number('orden', $item->orden, ["class"=>"form-control","required"=>"required"]) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('descripcion',"Modificar descripción:") !!}
                    {!! Form::text('descripcion', $item->descripcion, ["class"=>"form-control", "maxlength"=>100,"required"=>"required"]) !!}
                </div>
                <div class="form-group col-md-6">
                    @include('controles.radio_si_no', ['control_control' => 'predeterminado'
                                                       ,'control_opciones'=> [1=>"Sí", 2=>"No"]
                                                       , 'control_default'=>$item->predeterminado
                                                       ,'control_texto'=>'Seleccionar como predeterminado'
                                                       ])
                </div>
                <div class="form-group col-md-6">
                    @include('controles.radio_si_no', ['control_control' => 'habilitado'
                                                       ,'control_opciones'=> [1=>"Sí", 2=>"No"]
                                                       , 'control_default'=>$item->habilitado
                                                       ,'control_texto'=>'Habilitado'
                                                       ])
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Actualizar</button>
                <a href="{{ action("cat_itemController@index") }}" class="btn btn-default ">Cancelar</a>
            </div>
        </div>
        {!! Form::close()  !!}

        @include("catalogos.guia")
    </div>


    <div class="clearfix"></div>
@stop

