{{--

Selector de tres niveles para codigos geograficos
    Parametros:
    $control_control: nombre del control/variable  (name='xxx')
    $control_id: identificador del control para javascript.
    $control_texto: Etiqueta a desplegar
    $control_default: valor pre-seleccionado
    $control_vacio: Si se desea crear una opción con valor cero, en esta variable se coloca el texto a mostrar

    $control_resaltar: falso/verdadero.  si es verdadero muestra en otro color si tiene algo seleccionado (usado para los formularios de busqueda)

    //IMPORTANTE: el request del json es POST, por lo que es necesaria una excepción para el csrftoken
    // Mas info: https://stackoverflow.com/questions/46141705/the-page-has-expired-due-to-inactivity-laravel-5-5

--}}


{{-- DEFAULTS --}}
<?php
        //Para la programación de agregar otro
        $control_control = $control_control ?? 'geo3';
        $control_id = $control_id ?? $control_control;
        $control_otro = isset($control_otro) ? $control_otro : false; //Agregar otro a internacional

        $control_select_2 = isset($control_select_2) ? $control_select_2 : true;

        $con_llaves = strpos($control_control,"[]")>0;


        if(!isset($control_default)) {
            if(!isset($control_vacio)) {
                $control_default=2016; //bogota
            }
            else {
                $control_default=-1;
            }
        }
        else {
            if($control_default<=0) {
                if(!isset($control_vacio)) {
                    $control_default=2016; //bogota
                }
                else {
                    $control_default=-1;
                }
            }
        };
        if(!isset($control_texto)) {
            $control_texto=null;
        };
        if(!isset($control_vacio)) {
            $control_vacio=null;
        };

        //Esta primera parte me sirve para el despliegue inicial
        $tmp_id_depto=-1;
        $tmp_id_muni=-1;
        $tmp_id_lp=-1;

        if($control_default>0) {
            $tmp_info=\App\Models\geo::find($control_default);
            if(!empty($tmp_info)) {
                if($tmp_info->nivel==1) {
                    $tmp_id_depto=$control_default;
                    $tmp_id_muni=-1;
                    $tmp_id_lp=-1;
                }
                elseif($tmp_info->nivel==2) {
                    $tmp_id_depto=$tmp_info->id_padre;
                    $tmp_id_muni=$control_default;
                    $tmp_id_lp=-1;

                }
                else {
                    $tmp_id_lp=$control_default;
                    $tmp_id_muni=$tmp_info->id_padre;
                    $muni=\App\Models\geo::find($tmp_info->id_padre);
                    if(!empty($muni)) {
                        $tmp_id_depto=$muni->id_padre;
                    }
                    else { //No hay abuelo, todos a cero
                        $tmp_id_depto=-1;
                        $tmp_id_muni=-1;
                        $tmp_id_lp=-1;
                    }
                }
            }
        }
        else {
            if(!$control_vacio) {
                $l1 = \App\Models\tesauro::listar_hijos(null,$control_vacio,$control_otro);
                $tmp_id_depto = array_key_first($l1);

                $l2 = \App\Models\tesauro::listar_hijos($tmp_id_depto,$control_vacio,$control_otro);
                $tmp_id_muni = array_key_first($l2);


                $l3 = \App\Models\tesauro::listar_hijos($tmp_id_muni,$control_vacio,$control_otro);
                $tmp_id_lp = array_key_first($l3);
            }
            else {

            }
        }
        //dd("d: $tmp_id_depto, m:$tmp_id_muni, l:$tmp_id_lp");
        //Resaltar el control con 'has-success'
        $control_resaltar = isset($control_resaltar) ? $control_resaltar : false;
        $texto_resaltar_n1='';
        $texto_resaltar_n2='';
        $texto_resaltar_n3='';
        if($control_resaltar) {
            $texto_resaltar_n1 = $tmp_id_depto > 0 ? ' has-success text-success' : ' ';
            $texto_resaltar_n2 = $tmp_id_muni > 0 ? ' has-success text-success' : ' ';
            $texto_resaltar_n3 = $tmp_id_lp > 0 ? ' has-success text-success' : ' ';
        }


?>

{{-- HTML de los select --}}
<div class="row">
{{-- Desplegar los controles --}}
    <div class="col-xs-12">
        <label>{!! $control_texto !!}  </label>
    </div>

</div>
<div class="row">
    <!-- Departamento -->
    <div class="col-sm-4">
        <div class="form-group {{ $texto_resaltar_n1 }}">
            {!! Form::label(str_replace("[]","",$control_control)."_depto".($con_llaves ? '[]':'') , "Departamento",['class'=>$texto_resaltar_n1]) !!}<br>
            {!! Form::select(str_replace("[]","",$control_control)."_depto".($con_llaves ? '[]':''), \App\Models\geo::listar_hijos(null,$control_vacio), $tmp_id_depto,['class' => 'form-control','style'=>'width:100% !important','id'=>$control_id."_depto"]) !!}
        </div>

    </div>
    <!-- Municipio -->
    <div class="col-sm-4">
        <div class="form-group {{ $texto_resaltar_n2 }}">
            {!! Form::label(str_replace("[]","",$control_control)."_muni".($con_llaves ? '[]':'') , "Municipio",['id'=>$control_id."_label_muni", 'class'=>$texto_resaltar_n2]) !!} <br>
            {!! Form::select(str_replace("[]","",$control_control)."_muni".($con_llaves ? '[]':'') , \App\Models\geo::listar_hijos($tmp_id_depto,$control_vacio), $tmp_id_muni,['class' => 'form-control','style'=>'width:100% !important','id'=>$control_id."_muni"]) !!}
        </div>
    </div>
    <!-- Lugar Poblado -->
    <div class="col-sm-4">
        <div class="form-group {{ $texto_resaltar_n3 }}">
            {!! Form::label($control_control, "Vereda o equivalente",['id'=>$control_id."_label", 'class'=>$texto_resaltar_n3]) !!}<br>
            {!! Form::select($control_control, \App\Models\geo::listar_hijos($tmp_id_muni,$control_vacio, $control_otro), $tmp_id_lp,['class' => 'form-control','style'=>'width:100% !important','id'=>$control_id]) !!}
        </div>
    </div>
    {{-- Para utilizarlo en params --}}
    @if(strlen($control_vacio)>0)
        <input type="hidden" id="{{ $control_id }}_vacio" value="{{ $control_vacio }}">
    @endif
</div>

{{-- Javascript para controles dependientes --}}
@push('js')
    {{--
        Convertirlo en controles dependientes con depdrop() https://plugins.krajee.com/dependent-dropdown
       La llamada al controller del JSON depende de si pide "Mostrar todos" o no
    --}}
    @if(strlen($control_vacio)>0)
        <script>
            // Controles dependientes, con 'mostrar todos'. Campo {{ $control_control  }}
            //Municipio
            $("#{{ $control_id }}_muni").depdrop({
                url: '{{ url('json/geo_todo') }}',
                depends: ['{{ $control_id }}_depto'],
                params: [ '{{ $control_id }}_vacio'],
                loadingText:'Cargando datos...',
                placeholder:false,
                emptyMsg:'Sin datos :-('
            });
            // Lugar poblado
            $("#{{ $control_id }}").depdrop({
                url: '{{ url('json/geo_todo') }}',
                depends: ['{{ $control_id }}_muni'],
                params: [ '{{ $control_id }}_vacio'],
                loadingText:'Cargando datos...',
                placeholder:false,
                emptyMsg:'Sin datos :-('
            });
        </script>
    @else
        <script>
            // Controles dependientes, sin 'mostrar todos'.  Campo {{ $control_control  }}
            //Municipio
            $("#{{ $control_control }}_muni").depdrop({
                url: '{{ url($control_otro ? 'json/geo_otro' : 'json/geo') }}',
                depends: ['{{ $control_control }}_depto'],
                initialize: {{ $tmp_id_depto==-1 ? "true" : "false" }}, //Si tienen valor predeterminado, se cargan con dichos valores, De lo contrario, initialize=true para que cargue los valores iniciales
                loadingText:'Cargando datos...',
                placeholder:false,
                emptyMsg:'Sin datos :-('
            });
            // Lugar poblado
            $("#{{ $control_control }}").depdrop({
                url: '{{ url($control_otro ? 'json/geo_otro' : 'json/geo') }}',
                depends: ['{{ $control_control }}_muni'],
                initialize: {{ $tmp_id_muni==-1 ? "true" : "false" }}, //Si tienen valor predeterminado, se cargan con dichos valores, De lo contrario, initialize=true para que cargue los valores iniciales
                loadingText:'Cargando datos...',
                placeholder:false,
                emptyMsg:'Sin datos :-('
            });

            @if($tmp_id_muni == -1)
                    $(function () {
                        //console.log('inicializar');
                        $("#{{ $control_control }}").depdrop('init');
                    });
            @endif
        </script>
    @endif

    {{-- convertirlo en select_2 para que sean mas chileros --}}
    @if($control_select_2)
        <script>
            var control ='#{!! $control_id !!}_depto';
            $(control).select2();
            var control ='#{!! $control_id !!}_muni';
            $(control).select2();
            var control ='#{!! $control_id !!}';
            $(control).select2();
        </script>
    @endif

    {{--
    Javascript para cambiar rotulo de "Departamento" a "Pais" en internacional
     --}}
    <script>
        //Valores iniciales de los controles
        var {!! $control_id !!}_n2_label = $("#{!! $control_id !!}_label_muni").html();
        var {!! $control_id !!}_n3_label = $("#{!! $control_id !!}_label").html();


        function {!! $control_id !!}_cambiar_etiquetas() {
            let elegido = $('#{!! $control_id !!}_depto').val();
            let texto_n2 = {!! $control_id !!}_n2_label;
            let texto_n3 = {!! $control_id !!}_n3_label;
            if(elegido=={{ config('expedientes.internacional',9176) }}) {
                texto_n2 = 'País';
                texto_n3 = 'Ciudad';
            }
            $("#{!! $control_id !!}_label_muni").html(texto_n2);
            $("#{!! $control_id !!}_label").html(texto_n3);
        }
        // Listener
        var control ='#{!! $control_id !!}_depto';
        $(control).change(function() {
            {!! $control_id !!}_cambiar_etiquetas();
        });

    </script>

@endpush


{{-- Modal para agregar otro --}}
@if($control_otro)

    <div class="modal fade" id="ModalOtro_{{ $control_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalOtroLabel">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Agregar nueva opción en '<span id="span_pais"> pais</span>'</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-xs-12">
                            {!! Form::label('txt_', 'Nueva Opción:') !!}
                            {!! Form::text('txt_'.$control_id, null, ['class' => 'form-control','id'=>'txt_'.$control_id]) !!}
                        </div>
                        <div class="col-xs-12">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#{{$control_id}}').val($('#{{$control_control}} option:first').val()).trigger('change');">Cancelar</button>
                            <button type="button" class="btn btn-primary pull-right" onclick="post_agregar_{{ $control_id }}($('#{{$control_id}}_muni').val())">Agregar</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-xs-12 text-left">
                        <span class="text-danger">Atención:</span> Si en el actual formulario hay otros controles como éste, esta nueva opción no se mostrará en dichos controles de forma inmediata.  Para poderla elegir en otros controles,  es necesario seleccionar de nuevo el nivel anterior (país o departamento) para que  se refresque el listado de veredas o ciudades de dicho control.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


@push('js')
    {{-- Enviar datos al backend para actualizar la BD --}}
    <script>
        function post_agregar_{{ $control_id }}(id_pais) {
            var control = 'txt_' + '{{$control_id}}';
            //alert('postback con el valor de '+control+ ': '+$('#'+control).val());

            var datos = {
                id_padre : id_pais,
                texto:$('#'+control).val(),
                _token : "{{ csrf_token() }}"
            };

            var url = '{{ action('geoController@store_otro') }}';
            //console.log(datos);

            var posting = $.post( url, datos );

            posting.done(function( data ) {
                //console.log('actualizar control');
                if(data.exito) {
                    var select ='#{!! $control_id !!}';
                    var newOption = new Option(data.item.descripcion, data.item.id_geo, false, true);
                    $(select).append(newOption).trigger('change');
                }
                else {
                    console.log("Error de la base de datos:");
                    console.log(data.mensaje)
                    Swal.fire({
                        type: 'error',
                        title: 'Opción no agregada',
                        text: 'Revisar consola para los detalles del error'
                    })
                    $('#{{$control_id}}').val($('#{{$control_id}} option:first').val()).trigger('change');
                }

                $("#ModalOtro_{{ $control_id }}").modal('hide');
            });
        }

    </script>

    {{-- Listener para cuando escogen "otro, cual" --}}
    <script>
        $(function() {
            var control ='#{!! $control_id !!}';
            $(control).change(function() {
                if($(this).val() == -99) {
                    var pais = $('#{!! $control_id !!}_muni option:selected').text();
                    $("#span_pais").html(pais);
                    //Mostrar el formulario modal
                    $("#ModalOtro_{{ $control_id }}").modal('show');
                }
            });

        });

    </script>
@endpush