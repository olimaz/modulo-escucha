@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Excel Listados
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($excelListados, ['route' => ['excelListados.update', $excelListados->id_excel_listados], 'method' => 'patch','id'=>'frm_adjunto','files' => true]) !!}

                        @include('excel_listados.fields')

                       <div class="form-group col-xs-12 text-center">
                           <button type="submit" class="btn btn-success">Actualizar archivo</button>
                           <a href="{{ route('excelListados.index') }}" class="btn btn-default">Cancelar</a>
                       </div>

                   {!! Form::close() !!}
               </div>
           </div>
           <div class="box-footer">
               <span class="text-danger">Atención:</span> Del archivo cargado, se procesará únicamente la primer columna de la primer hoja.  El resto del contenido puede ser aprovechado para referencia para el usuario, pero será ignorado en el proceso de  importación.
           </div>
       </div>
   </div>
@endsection