{{--

Control tipo dropdown de un catalogo
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_id: identificador del control (id='xx').  Si no se especifica, utiliza el valor de $control_control
$control_texto: Etiqueta a desplegar
$control_id_cat: catálogo a desplegar
$control_default: valor pre-seleccionado
$control_vacio: Si se desea crear una opción con valor cero, en esta variable se coloca el texto a mostrar
$control_nulo: Igual que control_vacio, pero con valor "null" en lugar de cero
$control_multiple: Si se acepta seleccionar más de una opcion  (true,false)
$control_requerido: falso/verdadero según se agrega "required" para html5
$control_otro: falso/verdadero.  Si es verdadero, agrega la funcionalidad de de agregar otro mediante un formulario modal
$control_resaltar: falso/verdadero.  si es verdadero muestra en otro color si tiene algo seleccionado (usado para los formularios de busqueda)
--}}


@php
        //Por si no lo definen
        use App\Models\cat_cat;
        if(!isset($control_default)) {
            $control_default=null;
        }
        if($control_default==null) {  //El valor viene de la BD
            $control_default=-1;
        }
        if(!isset($control_vacio)) {
            $control_vacio=null;
        }
        if(!isset($control_multiple)) {
            $control_multiple=false;
        }
        if(!isset($control_requerido)) {
            $control_requerido=false;
        }
         if(!isset($control_nulo)) {
            $control_nulo=null;
        }
        $control_otro = isset($control_otro) ? $control_otro : false;
        $control_resaltar = isset($control_resaltar) ? $control_resaltar : false;

        // Si se muestran multiples catalogos, nunca puede agregar opciones
        if(is_array($control_id_cat)) {
            $control_otro=false;
        }

        $control_id = isset($control_id) ? $control_id : $control_control;


        // Lista negra
        if($control_otro) {
            if(\Auth::check()) {
                $id_entrevistador  =\Auth::user()->id_entrevistador;
                $bloqueado = \App\Models\lista_negra::revisar_bloqueo($id_entrevistador);
                if($bloqueado) {
                    $control_otro=false;
                }
            }
        }

        //Revisar restricciones a nivel de bases de datos.  Esto me permite hacer un override de la programación
        if($control_otro) {
            $revisar = cat_cat::find($control_id_cat);
            if($revisar->otro_cual==2) {
                $control_otro = false;
            }
        }


        /**
         * Si no hay default, utilizar el cambpo  "predeterminado" de la tabla
         */
        //Si no tiene default, obtener el de la BD si lo hubiera


        if($control_requerido && !$control_multiple) {  //Solo cuando es requerido, sino dejarlo en blanco
            if($control_default<=0) {
                $tmp_defa=\App\Models\cat_item::habilitado()->where('id_cat',$control_id_cat)->where('predeterminado',1)->first();
                if(!empty($tmp_defa)) {
                    $control_default=$tmp_defa->id_item;
                }
                else {
                    $control_default=null; //Que tome el primero del arreglo
                }
            }
        }



        //Resaltar el control con 'has-success'
        $texto_resaltar='';
        if($control_resaltar) {
            $elegido=false;
            if(is_array($control_default)) {
                    if(count($control_default) > 0) {
                        $elegido=true;
                    }
                }
            else {
                if($control_default>0) {
                    $elegido=true;
                }
            }
            $texto_resaltar = $elegido ? ' has-success  text-success' : '';
        }

@endphp

<!-- Control SELECT  -->
<div class="form-group  {{ $errors->has($control_control) ? 'has-error' :'' }} {{ $texto_resaltar }}">
    {!! Form::label($control_control, $control_texto,['class'=>$texto_resaltar]) !!}
    @php
        $opciones = ['class' => "form-control $texto_resaltar",'id'=>$control_id,'style'=>'width:100% !important'];
        if($control_multiple) {
            $opciones['multiple']="multiple";
            if(strpos($control_control,'[]') > 0) {
                //No pasa nada, ya tiene los corchetes
            }
            else {
                $opciones['name']=$control_control."[]"; //agregarle los corchetes
            }

        }
        else {
            $opciones['name']=$control_control;
        }
        if($control_requerido) {
            $opciones['required']="required";
        }
    @endphp

    {!! Form::select($control_control, \App\Models\cat_item::listado_items_nuevo($control_id_cat,$control_vacio,$control_nulo), $control_default,$opciones) !!}

    {!! $errors->first($control_control,'<span class="help-block" style="color:red;">:message</span>') !!}
</div>


{{-- Modal para agregar otro --}}
@if($control_otro)

    <div class="modal fade" id="ModalOtro_{{ $control_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalOtroLabel">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Agregar nueva opción en '{{ $control_texto }}'</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-xs-12">
                            {!! Form::label('txt_', 'Nueva Opción:') !!}
                            {!! Form::text('txt_'.$control_id, null, ['class' => 'form-control','id'=>'txt_'.$control_id]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if($control_multiple)
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="var y= $('#{{$control_id}}').val(); y.splice( $.inArray('-99', y),1); $('#{{$control_id}}').val(y).trigger('change');">Cancelar</button>
                    @else
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#{{$control_id}}').val($('#{{$control_control}} option:first').val()).trigger('change');">Cancelar</button>
                    @endif
                    <button type="button" class="btn btn-primary" onclick="post_agregar_{{ $control_id }}({{ $control_id_cat }})">Grabar</button>
                </div>
            </div>
        </div>

    </div>
@endif


@push('js')
    <script>
        function post_agregar_{{ $control_id }}(id_cat) {
            var control = 'txt_' + '{{ $control_id }}';
            //alert('postback con el valor de '+control+ ': '+$('#'+control).val());

            var datos = {
                id_cat:id_cat,
                texto:$('#'+control).val(),
                _token : "{{ csrf_token() }}"
            };

            var url = '{{ action('cat_itemController@store_otro') }}';
            //console.log(datos);

            var posting = $.post( url, datos );

            posting.done(function( data ) {
                //console.log('actualizar control');
                if(data.exito) {
                    var select ='#{!! $control_id !!}';
                    var newOption = new Option(data.item.descripcion, data.item.id_item, false, true);
                    $(select).append(newOption).trigger('change');
                    @if($control_multiple)
                        // limpiar multiple
                        var y= $('#{{$control_id}}').val();
                        y.splice( $.inArray('-99', y),1);
                        $('#{{$control_id}}').val(y).trigger('change');
                    @endif
                }
                else {
                    console.log("Error de la base de datos:");
                    console.log(data.mensaje)
                    Swal.fire({
                        type: 'error',
                        title: 'Opción no agregada',
                        text: 'Revisar consola para los detalles del error'
                    })
                    @if($control_multiple)
                        // limpiar multiple
                        var y= $('#{{$control_id}}').val();
                        y.splice( $.inArray('-99', y),1);
                        $('#{{$control_id}}').val(y).trigger('change');
                    @else
                        $('#{{$control_id}}').val($('#{{$control_id}} option:first').val()).trigger('change');
                    @endif
                }

                $("#ModalOtro_{{ $control_id }}").modal('hide');
            });
        }

    </script>
    <script>
        var control ='#{!! $control_id !!}';

        @if($control_multiple)
            $(control).select2({
                placeholder: 'Seleccione las opciones que apliquen'
            });
        @else
            $(control).select2({
                placeholder: 'Seleccione una opción'
            });
        @endif

        {{-- Para cuando son varios los seleccionados --}}
        @if(is_array($control_default))
            $("#{{ $control_id }}").val({!!   json_encode($control_default) !!});
            $("#{{ $control_id }}").trigger('change');
        @elseif(is_numeric($control_default))
            $("#{{ $control_id }}").val({{ $control_default }});
            $("#{{ $control_id }}").trigger('change');
        @endif

        {{-- Agregar opción de "Otro, ¿cual?" --}}
        @if($control_otro)
            var newOption = new Option('(Otro), ¿Cuál?', -99, false, false);
            $(control).append(newOption).trigger('change');
        @endif

        {{-- Listener de si elige otro --}}
        $(control).change(function() {
            if($.isArray($(this).val())) {
                if($.inArray("-99",$(this).val()) >= 0) {
                    agregar_otro_{{ $control_id }}();
                }
            }
            else {
                if($(this).val() == -99) {
                    agregar_otro_{{ $control_id }}();
                }
            }
        });

        function agregar_otro_{{ $control_id }}() {
            //alert('Toca agregar otro');
            $("#ModalOtro_{{ $control_id }}").modal('show');
        }

    </script>
@endpush

