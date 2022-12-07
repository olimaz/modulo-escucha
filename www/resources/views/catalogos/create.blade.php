@extends("layouts.app")
@section('title', 'Catalogos del sistema')
@section('content_header')
    <h1>Agregar nueva opción <small>opciones personalizables.</small></h1>
@stop


@section("content")
    @include("controles.errores")

    <div class="col-sm-8 col-sm-offset-2">
        {!! Form::open(['action' => ['cat_itemController@store',$id_cat]])  !!}
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"> <b>Listado: </b>
                    {{ \App\Models\cat_cat::find($id_cat)->nombre }}
                </h3>
            </div>
            <div class="box-body">

                <div class="form-group col-md-6">
                    {!! Form::label('orden',"Orden/Posición:") !!}
                    {!! Form::number('orden', 0, ["class"=>"form-control","required"=>"required"]) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('descripcion',"Nueva opción:") !!}
                    {!! Form::text('descripcion', null, ["class"=>"form-control", "maxlength"=>100,"required"=>"required"]) !!}
                </div>
                <div class="form-group col-md-6">
                        @include('controles.radio_si_no', ['control_control' => 'predeterminado'
                                                           ,'control_opciones'=> [1=>"Sí", 2=>"No"]
                                                           , 'control_default'=>2
                                                           ,'control_texto'=>'Seleccionar como predeterminado'
                                                           ])
                </div>
                <div class="form-group col-md-6">
                    @include('controles.radio_si_no', ['control_control' => 'habilitado'
                                                       ,'control_opciones'=> [1=>"Sí", 2=>"No"]
                                                       , 'control_default'=>1
                                                       ,'control_texto'=>'Habilitado'
                                                       ])
                </div>


            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Agregar</button>
                <a href="{{ action("cat_itemController@index") }}" class="btn btn-default ">Cancelar</a>
            </div>
        </div>
        <input type="hidden" name="id_cat" id="id_cat" value="{{ $id_cat }}">
        {!! Form::close()  !!}

        @include("catalogos.guia")

        <div class="box box-default">
            <div class="box-header">
                <h2 class="box-title">
                    Opciones existentes
                </h2>
            </div>
            <div class="box-body">
                <ol>
                    @foreach(\App\Models\cat_item::listado_items($id_cat) as $item)
                        <li>{{ $item }}</li>
                    @endforeach

                </ol>

            </div>
        </div>
    </div>


    <div class="clearfix"></div>



@stop
