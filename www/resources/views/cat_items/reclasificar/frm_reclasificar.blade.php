@extends('layouts.app')
@section('content_header')
    <h1 class="page-header">Reclasificar opciones de una lista</h1>
@endsection
@section('content')
    @include('adminlte-templates::common.errors')

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">
                Listado al que pertence esta opción: <span class="text-primary">{{ $cat_item->rel_id_cat->nombre }}</span>
            </h3>
        </div>
        <div class="box-body">

                <div class="form-group">
                    <label for="antiguo">Opción actual que desea reclasificar:</label><br>
                    <span class="text-danger text-bold">{{ $cat_item->descripcion }}</span>
                </div>

                <div class="form-group">
                    <label for="antiguo">Para la reclasificación, ¿Desea crear una nueva categoría o utilizar alguna existente?:</label><br>
                    <label class="radio-inline icheck icheck_accion">
                        <input class='opcion' type="radio" name="accion" id="accion_1" value="1"    {{ !$hay_lista ? "checked" : "" }} >
                        Crear una nueva categoría
                    </label>
                    <label class="radio-inline icheck icheck_accion">
                        <input class='opcion' type="radio" name="accion" id="accion_2" value="2"    {{ !$hay_lista ? "disabled" : "checked" }} >
                        Utilizar una categoría existente
                    </label>
                    <label class="radio-inline icheck icheck_accion">
                        <input class='opcion' type="radio" name="accion" id="accion_3" value="3"    >
                        Ignorar: esta opción es inválida y no debe ser tomada en cuenta
                    </label>
                </div>

                {{-- Formulario de crear una nueva --}}
                <div id="opcion_1" class="row hidden">
                    {!! Form::open(['action'=>['cat_itemController@reclasificar',$cat_item->id_item]]) !!}
                        <input type="hidden" name="filtrar" value="{{ $request->filtrar }}">
                        <input type="hidden" name="page" value="{{ $request->page }}">
                        <div class="col-sm-8">
                            <label>Especifique el texto de la nueva categoría:</label>
                            <div class="input-group">

                                    <input type="text" class="form-control" name="nuevo" id="nuevo" value="{{ $cat_item->descripcion }}" maxlength="200">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">Crear nueva categoría</button>
                                    </span>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                    {!! Form::close() !!}
                </div>
                {{-- Formulario de seleccionar opción --}}
                <div id="opcion_2" class="row hidden">
                    {!! Form::open(['action'=>['cat_itemController@reclasificar',$cat_item->id_item]]) !!}
                        <input type="hidden" name="filtrar" value="{{ $request->filtrar }}">
                        <input type="hidden" name="page" value="{{ $request->page }}">
                        <div class="col-sm-8">
                            <div class="input-group">
                                @include('controles.catalogo', ['control_control' => 'id_nuevo'
                                             ,'control_id_cat'=>$cat_cat->id_reclasificado
                                             ,'control_texto'=>'Seleccione la opción con la cual se sustituye:'])
                                <span class="input-group-btn" >
                                        <button class="btn btn-primary" type="submit" style="margin-top: 10px">Seleccionar esta opción </button>
                                </span>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                {{-- Formulario de ignorar opción --}}
                <div id="opcion_3" class="row hidden">
                    {!! Form::open(['action'=>['cat_itemController@reclasificar',$cat_item->id_item]]) !!}
                        <input type="hidden" name="filtrar" value="{{ $request->filtrar }}">
                        <input type="hidden" name="page" value="{{ $request->page }}">
                        <div class="col-sm-8">
                            <div class="form-group text-center">
                                <input type="hidden" name="id_nuevo" value="-1">
                                <button class="btn btn-primary" type="submit" style="margin-top: 10px">No reclasificar e ignorar esta opción </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>

        </div>


    </div>



@endsection

@push('js')
    <script>
        $(document).ready(function(){
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_square',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });

            $('.icheck').on('ifChanged', mostrar_ocultar);

            function mostrar_ocultar() {
                var op_1 = $('#accion_1').iCheck('update')[0].checked;
                var op_2 = $('#accion_2').iCheck('update')[0].checked;
                var op_3 = $('#accion_3').iCheck('update')[0].checked;

                $('#opcion_1').addClass('hidden')
                $('#opcion_2').addClass('hidden')
                $('#opcion_3').addClass('hidden')

                if(op_1) {
                    $('#opcion_1').removeClass('hidden')
                }
                if(op_2) {
                    $('#opcion_2').removeClass('hidden')
                }
                if(op_3) {
                    $('#opcion_3').removeClass('hidden')
                }

            }
            mostrar_ocultar();
        });





    </script>
@endpush