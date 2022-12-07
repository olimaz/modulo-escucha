@extends('layouts.app')
@section('content_header')
    <h1 class="page-header">Modificar texto de una opción</h1>
@endsection
@section('content')
    @include('adminlte-templates::common.errors')
    {!! Form::open(['action'=>['cat_itemController@editar',$cat_item->id_item], 'autocomplete'=>'off']) !!}
    {!! Form::hidden('filtrar',$request->filtrar) !!}
    {!! Form::hidden('page',$request->page) !!}

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">
                Listado al que pertence esta opción: <span class="text-primary">{{ $cat_item->rel_id_cat->nombre }}</span>
            </h3>
        </div>
        <div class="box-body">

                <div class="form-group">
                    <label for="antiguo">Texto actual:</label><br>
                    <span class="text-primary">{{ $cat_item->descripcion }}</span>
                </div>
                <div class="form-group">
                    <label for="antiguo">Nuevo texto:</label><br>
                    <input required type="text" class="form-control" name="nuevo" id="nuevo" value="{{ $cat_item->descripcion }}" maxlength="200">
                </div>
        </div>
        <div class="box-footer">
            <button class="btn btn-primary" type="submit">Aplicar el nuevo texto</button>
            <a href="{{ action('cat_itemController@index_reclasificar')."?id_seleccionado=".$cat_item->id_cat."&filtrar=".$request->filtrar."&page=".$request->page }}" class="btn btn-default">Cancelar</a>
        </div>

    </div>

    {!! Form::close() !!}

@endsection