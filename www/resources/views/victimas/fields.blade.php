<!-- Es Victima Field -->



    <h4 class="form-group col-sm-12 " style="margin-bottom: 1%"><b>Información Personal</b></h4>
    <div class="form-group col-sm-12 seccion" >
    <!-- Nombre Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('nombre', '1. Nombres') !!}
        {!! Form::text('nombre', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
    </div>

    <!-- Apellido Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('apellido', '2. Apellidos') !!}
        {!! Form::text('apellido', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
    </div>

    <!-- Alias Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('alias', '3. Nombre identitario, otros nombres, apodo') !!}
        {!! Form::text('alias', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
    </div>


    <div class="form-group col-sm-4">
        @include('controles.catalogo', ['control_control' => 'id_rel_victima'
                                        ,'control_id_cat'=>52
                                        , 'control_default'=>$persona->arreglo_relacion_victimas
                                        //, 'control_multiple' => true
                                        , 'control_otro' => true
                                        , 'control_requerido' => false
                                        , 'control_vacio' => '[Ninguno]'
                                        , 'control_texto'=>'Parentesco con la persona entrevistada'])
    <p>(Esta víctima es _____________ de la persona entrevistada)</p>
    </div>
    
    

<div class="clearfix form-group col-sm-12"></div>
<!-- Fec Nac A Field -->

<div class="form-group col-sm-6">
    @include('controles.fecha_incompleta', ['control_control' => 'fec_nac'
                                         , 'control_default'=>$persona->editar_fecha_nacimiento
                                         , 'control_vacio' => '[Ninguno]'
                                         , 'control_texto'=>'4. Fecha de nacimiento'
                                         , 'required'])
</div>

{{-- 
<div class="form-group col-sm-6">
    {!! Form::label('edad_aprox', 'Edad aproximada al momento de los hechos') !!}
    {!! Form::text('edad_aprox', $persona->victima_edad_aproximada, ['class' => 'form-control']) !!}
</div>
--}}

<div class="clearfix form-group col-sm-6"></div>

<!-- Id Lugar Nacimiento Field -->
<div class="form-group col-md-6 col-sm-12" style="margin-top: -2.4%;">
    @include('controles.geo2', ['control_control' => 'id_lugar_nacimiento'
                             , 'control_default'=> $persona->id_lugar_nacimiento > 0 ? $persona->id_lugar_nacimiento : $persona->id_lugar_nacimiento_depto
                             , 'control_vacio' => '[Ninguno]'
                             , 'control_texto' => '5. Lugar de nacimiento'])                                         
</div>

<!-- Id Sexo Field -->
<div class="clearfix"></div>
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_sexo'
                                    ,'control_default' => $persona->id_sexo
                                    ,'control_id_cat' => 24
                                    ,'control_vacio' => '[Ninguno]'
                                    ,'control_texto'=>'6. Sexo (asignado al nacer)'])
</div>

<!-- Id Orientacion Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_orientacion'
                                    ,'control_default' => $persona->id_orientacion
                                    ,'control_id_cat' => 25
                                    ,'control_vacio' => '[Ninguno]'
                                    ,'control_texto'=>'7. Orientación sexual (se siente atraído por)'])
</div>

<!-- Id Identidad Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_identidad'
                                    ,'control_default' => $persona->id_identidad
                                    ,'control_id_cat' => 26
                                    , 'control_multiple' => false
                                    , 'control_requerido' => false
                                    , 'control_otro' => true
                                    ,'control_vacio' => '[Ninguno]'
                                    ,'control_texto'=>'8. Identidad de género (¿cómo se identifica?)'])

</div>

<div class="clearfix"></div>
<!-- Id Etnia Field -->
<div class="form-group col-sm-6">
        
    @include('controles.catalogo', ['control_control' => 'id_etnia'
                                    ,'control_default' => (empty($persona->id_etnia) ? -1 : $persona->id_etnia)
                                    ,'control_id_cat' => 27
                                    ,'control_vacio' => '[Ninguno]'
                                    ,'control_otro' => true
                                    ,'control_texto'=>'9. Pertenencia étnico-racial'])
</div>

<div id ="campoIndigena" class="form-group col-sm-6" style="display:none">
        @include('controles.catalogo', ['control_control' => 'id_etnia_indigena'
                                        ,'control_default' => $persona->id_etnia_indigena
                                        ,'control_id_cat' => 28
                                        , 'control_multiple' => false
                                        , 'control_requerido' => false
                                        //, 'control_otro' => true
                                        ,'control_vacio' => '[Ninguno]'
                                        ,'control_texto'=>'¿A cuál étnia indígena pertenece?'])
    
    </div>



<div class="clearfix"></div>

<!-- Id Tipo Documento Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_tipo_documento'
                                    ,'control_default' => $persona->id_tipo_documento
                                    ,'control_id_cat' => 41
                                    , 'control_multiple' => false
                                    , 'control_requerido' => false
                                    , 'control_otro' => true
                                    ,'control_vacio' => '[Ninguno]'
                                    ,'control_texto'=>'10. Tipo de documento de identidad'])

</div>

<!-- Num Documento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('num_documento', '10.1 Número de documento') !!}
    {!! Form::text('num_documento', $persona->num_documento, ['class' => 'form-control', 'maxlength' => 20]) !!}
</div>
<div class="clearfix"></div>
<!-- Id Nacionalidad Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_nacionalidad'
                                    ,'control_default' => $persona->id_nacionalidad
                                    ,'control_id_cat' => 42
                                    ,'control_vacio' => '[Ninguno]'
                                    , 'control_otro' => true
                                    ,'control_texto'=>'11. Nacionalidad'])
</div>


<div class="form-group col-sm-6">
        @include('controles.catalogo', ['control_control' => 'id_otra_nacionalidad'
                                        ,'control_default' => $persona->id_otra_nacionalidad
                                        ,'control_id_cat' => 42
                                        ,'control_vacio' => '[Ninguno]'
                                        , 'control_otro' => true
                                        ,'control_texto'=>'11.1 Otra nacionalidad'])
    </div>

<!-- Id Estado Civil Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_estado_civil'
                                    ,'control_default' => $persona->id_estado_civil
                                    ,'control_id_cat' => 43
                                    , 'control_requerido' => false
                                    , 'control_otro' => true
                                    ,'control_vacio' => '[Ninguno]'
                                    ,'control_texto'=>'12. Estado civil'])
                                    
</div>

<div class="col-sm-6">
    @include('controles.catalogo', ['control_control' => 'discapacidad'
                                        ,'control_id_cat'=>44
                                        , 'control_default'=>$persona->arreglo_discapacidad
                                        , 'control_multiple' => true
                                        , 'control_requerido' => false
                                        //, 'control_vacio' => '[Ninguno]'
                                        , 'control_texto'=>'13. Condición de discapacidad'])
</div>


<div class="clearfix"></div>
<!-- Id Lugar Residencia Field -->
<div class="form-group col-md-6 col-sm-12">

    @include('controles.geo3', ['control_control' => 'id_lugar_residencia'
                            , 'control_default'=>$persona->halar_id_lugar_residencia()
                            , 'control_vacio' => '[Ninguno]'
                            , 'control_texto' => 'Lugar de residencia'])

</div>
<!-- Id Zona Field -->
<div class="form-group col-sm-6">
    <br>
    @include('controles.catalogo', ['control_control' => 'id_zona'
                                    ,'control_default' => $persona->id_zona
                                    ,'control_id_cat' => 45
                                    ,'control_vacio' => '[Ninguno]'
                                    ,'control_texto'=>'Zona'])
</div>
<div class="clearfix"></div>
<div class="col-xs-12">
    <h5>14. Forma de contacto</h5>
</div>
<!-- Telefono Field -->
<div class="form-group col-sm-6">
    {!! Form::label('telefono', '14.1 Telefono:') !!}
    {!! Form::text('telefono', $persona->telefono, ['class' => 'form-control', 'maxlength' => 20, 'min'=>0] ) !!}
</div>

<!-- Correo Electronico Field -->
<div class="form-group col-sm-6">
    {!! Form::label('correo_electronico', '14.2 Correo Electrónico:') !!}
    {!! Form::email('correo_electronico', $persona->correo_electronico, ['class' => 'form-control', 'maxlength' => 200]) !!}
</div>
<div class="clearfix"></div>



<!-- Id Edu Formal Field -->
<div class="form-group col-sm-6">    
    @include('controles.catalogo', ['control_control' => 'id_edu_formal'
                                    ,'control_default' => $persona->id_edu_formal
                                    ,'control_id_cat' => 46
                                    , 'control_requerido' => false
                                    , 'control_otro' => true
                                    ,'control_vacio' => '[Ninguno]'
                                    ,'control_texto'=>'15. Educación formal'])    
</div>

<!-- Profesion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('profesion', '16. Profesión u oficio') !!}
    {!! Form::text('profesion', $persona->profesion, ['class' => 'form-control', 'maxlength' => 100]) !!}
</div>

<!-- Ocupacion Actual Field -->
{{-- <div class="clearfix"></div>
    <div class="form-group col-sm-6">
        {!! Form::label('ocupacion_actual', '16.1 Ocupación al momento de los hechos') !!}
        {!! Form::text('ocupacion_actual', $persona->ocupacion_actual, ['class' => 'form-control', 'maxlength' => 100]) !!}
    </div>

</div> --}}

<h4 class="form-group col-sm-12 " style="margin-bottom: 1%"><b>Información Adicional</b></h4>
    <div class="form-group col-sm-12 seccion" >
<!-- Cargo Publico Field -->
<div class="clearfix"></div>
<div class="form-group col-sm-6 .col-xs-12">
                                    
    @include('controles.radio_si_no_div', ['control_control' => 'cargo_publico'
                                    ,'control_default' => $persona->cargo_publico
                                    ,'control_div' =>'div_cargo_publico_cual'
                                    ,'control_texto'=>"17. Ejerce autoridad o cargo público"])                                    
</div>

<!-- Cargo Publico Cual Field -->
<div class="form-group col-sm-6" id="div_cargo_publico_cual">
    @include('controles.autofill', ['control_control' => 'cargo_publico_cual'
                                       ,'control_url' => 'autofill/persona_cargo_publico'
                                       ,'control_default' => $persona->cargo_publico_cual
                                       ,'control_resaltar' => false
                                       ,'control_max' =>100
                                       ,'control_texto'=>'¿Cuál?'])

</div>
<div class="clearfix"></div>
<div class="col-sm-6">
    @include('controles.catalogo', ['control_control' => 'autoridad_etno_territorial'
                                        ,'control_id_cat'=>47
                                        , 'control_default'=>$persona->arreglo_autoridad_etnico_territorial
                                        , 'control_multiple' => true
                                        , 'control_requerido' => false
                                        , 'control_otro' => true
                                        ,'control_texto'=>'17.1 Es autoridad étnico territorial'])
</div>


<div class="clearfix"></div>
<!-- Id Fuerza Publica Estado Field -->
<div class="form-group col-sm-4">
        @include('controles.catalogo', ['control_control' => 'id_fuerza_publica'
        ,'control_default' => $persona->id_fuerza_publica
        ,'control_id_cat' => 49
        ,'control_vacio' => '[Ninguno]'
        , 'control_otro' => true
        ,'control_texto'=>'18. Es miembro de la fuerza pública'])
</div>

<div class="form-gruop col-sm-4" id="id_fuerza_publica_especificar" style="display:none">
    @include('controles.autofill', ['control_control' => 'fuerza_publica_especificar'
                                       ,'control_url' => 'autofill/persona_fuerza_publica'
                                       ,'control_default' => $persona->fuerza_publica_especificar
                                       ,'control_resaltar' => false
                                       ,'control_max' =>250
                                       ,'control_texto'=>'Especificar:'])
</div>



<div class="form-group col-sm-4">
    @include('controles.catalogo', ['control_control' => 'id_fuerza_publica_estado'
                                    ,'control_default' => $persona->id_fuerza_publica_estado
                                    ,'control_id_cat' => 48
                                    ,'control_vacio' => '[Ninguno]'
                                    ,'control_texto'=>'Estado'])
</div>


<!-- Id Actor Armado Field -->
<div class="clearfix"></div>
<div class="form-group col-sm-4">
    @include('controles.catalogo', ['control_control' => 'id_actor_armado'
                                    ,'control_default' => $persona->id_actor_armado
                                    ,'control_id_cat' => 50
                                    ,'control_vacio' => '[Ninguno]'
                                    , 'control_otro' => true
                                    ,'control_texto'=>'19. Fue miembro de un actor armado ilegal'])
</div>

<div class="form-gruop col-sm-4" id="id_actor_armado_especificar" style="display:none">
    @include('controles.autofill', ['control_control' => 'actor_armado_especificar'
                                       ,'control_url' => 'autofill/persona_actor_armado'
                                       ,'control_default' => $persona->actor_armado_especificar
                                       ,'control_resaltar' => false
                                       ,'control_max' =>250
                                       ,'control_texto'=>'Especificar:'])
</div>

<div class="clearfix"></div>
<!-- Organizacion Colectivo Field -->


<div class="form-group col-sm-6" style="margin-bottom:5px">
    @include('controles.radio_si_no_div', ['control_control' => 'organizacion_colectivo'
                                        ,'control_default' => $persona->organizacion_colectivo
                                        ,'control_div' =>'s-organizacion'
                                        ,'control_texto'=>"20. Participa o participaba en alguna organización/colectivo/grupo/pueblo"])        
</div>

<div class="clearfix"></div>

<div id="s-organizacion">

    <div id="organizacion"> 
            @include('personas.edit_organizacion')
        </div>    

        <div class="clearfix"></div>

        <div class="col-sm-12" style="margin-bottom:1%">
            <div id="mas">+</div>
            <p id ="otraOrganizacion">Otra Organización</p> 
        </div> 

</div>


    
{!! Form::hidden('id_e_ind_fvt', null, ['class' => 'form-control']) !!}
<input type="hidden" name="es_victima" id="es_victima" value="1">
<input type="hidden" name="es_testigo" id="es_testigo" value="2">
<input type="hidden" name="id_hecho" id="id_hecho" value="{{(isset($_GET['id_hecho']) ? $_GET['id_hecho'] : '')}}">
<input type="hidden" name="edicion" id="edicion" value="{{(isset($_GET['edicion']) ? $_GET['edicion'] : '')}}">
<input type="hidden" name="search" id="search" value="{{isset($search) ? $search : ''}}">

</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary', 'id'=>'btnGuardar']) !!}    
    
    @if(isset($id_hecho) && isset($view_create))
        <a href="{!! route('victimas.volver')."?id_hecho=$id_hecho"."&edicion=$edicion"."&view_create=$view_create" !!}" class="btn btn-default">Volver</a>
    @elseif (isset($id_hecho) && isset($edicion))
        <a href="{!! route('victimas.volver')."?id_hecho=$id_hecho"."&edicion=$edicion" !!}" class="btn btn-default">Volver</a>    
    @elseif(isset($id_hecho))
        <a href="{!! route('victimas.volver')."?id_hecho=$id_hecho" !!}" class="btn btn-default">Volver</a>
    @elseif(isset($search) && $search)
        <a href="{!! route('buscar_victimas') !!}" class="btn btn-default">Volver</a>        
    @else
        <a href="{!! route('victimas.volver')."?id_e_ind_fvt=$persona->id_e_ind_fvt" !!}" class="btn btn-default">Volver</a>
    @endif      
    
</div>


@push("js")
    <script src="{{ asset('js/validar_persona.js') }}"></script>
    <script>

        if ($("#id_fuerza_publica").val()>0) {
            $("#id_fuerza_publica_especificar").show();
            $("#fuerza_publica_especificar").prop('required',true);
        }

        if ($("#id_actor_armado").val()>0) {
            $("#id_actor_armado_especificar").show();
            $("#actor_armado_especificar").prop('required',true);
        }


        var contador = 0;
        $( document).ready(function(){
            $("#mas").click(function(){
                 contador++;

                 if(contador==5){
                     $(this).hide(200);
                     $("#otraOrganizacion").hide(200);
                 }else{
                    $("#organizacionFamilia" + contador).show(100);
                    $("#nombre_org"+contador).prop('required',true);
                  //  $("#rol_org"+contador).prop('required',true);
                }


            });
            $("#id_etnia").change(function(){

                if($(this).val()== {{ config('expedientes.indigena') }}){
                    $("#campoIndigena").show(200);
                }else{
                    $("#campoIndigena").hide(200);
                    $("#id_etnia_indigena").val("-1");
                }

            });

            $("#id_fuerza_publica").change(function(){

                if ($(this).val()>0) {
                    $("#id_fuerza_publica_especificar").show(200);
                    $("#fuerza_publica_especificar").prop('required',true);
                } else {
                    $("#id_fuerza_publica_especificar").hide(200);
                    $("#fuerza_publica_especificar").val("");
                    $("#fuerza_publica_especificar").removeAttr('required');
                }
            });


            $("#id_actor_armado").change(function(){

                if ($(this).val()>0) {
                    $("#id_actor_armado_especificar").show(200);
                    $("#actor_armado_especificar").prop('required',true);
                } else {
                    $("#id_actor_armado_especificar").hide(200);
                    $("#actor_armado_especificar").val("");
                    $("#actor_armado_especificar").removeAttr('required');
                }
            });

            $("#btnGuardar").click(function(){

                if ($("#nombre").val().length === 0 && $("#apellido").val().length === 0 && $("#id_sexo").val()==-1) {
                    alert('Favor indicar al menos uno de estos datos: nombre, apellido o sexo.');
                    return false;
                }

                if ($("#correo_electronico").val().length > 0) {
                    if (!validarEmail($("#correo_electronico").val())) {
                        alert('Correo electrónico no válido');
                        $("#correo_electronico").closest('.form-group').addClass('has-error');
                        $("#correo_electronico").focus();
                        return false;
                    }
                }

                if ($("#telefono").val().length > 0) {
                    if (!esNumero($("#telefono").val())) {
                        alert('Número de teléfono no válido, utilizar sólo números.');
                        $("#telefono").closest('.form-group').addClass('has-error');
                        $("#telefono").focus();
                        return false;
                    }
                }

                var si = $('#organizacion_colectivo_1').iCheck('update')[0].checked;
                if (si) {
                    if(!tiene_datos_participacion_organizacion()) {
                        alert('Si ha participado de una organización por favor ingrese la información la misma.');
                        return false;
                    }
                }

                if ($("#ampliar_relato_temas").length >0) {
                    $("#ampliar_relato_temas").removeAttr('required');
                }

                if ($("#priorizar_entrevista_asuntos").length >0) {
                    $("#priorizar_entrevista_asuntos").removeAttr('required');
                }

                return true;
            });

            $('.icheck').on('ifChanged', habilitar_required_participacion_organizacion);

            @if($persona->id_etnia == 196)
                    $("#campoIndigena").show(200);
            @endif
        });

        function quitarOrganizacion(index) {
            if (confirm('¿Desea borrar la organización de participación?')) {
                $("#organizacionFamilia"+index).hide(200);
                var input = "#organizacion_tipo"+index;
                $(input).val(-1).attr('selected', true);
                $("#nombre_org"+index).val("");
                $("#rol_org"+index).val("");

                $(input).removeAttr('required');
                $("#nombre_org"+index).removeAttr('required');
                $("#rol_org"+index).removeAttr('required');
            }
        }

        function habilitar_required_participacion_organizacion() {
            var si = $('#organizacion_colectivo_1').iCheck('update')[0].checked;
            attr = $("#nombre_org0").attr('required');
            id = $('#nombre_org0').length;
            if (si) {

                if (attr !== undefined)
                    $("#nombre_org0").prop('required',true);
                else if (id > 0 && attr === undefined) {
                    if ($("#organizacionFamilia0").css('display')=='block') {
                        $("#nombre_org0").prop('required',true);
                    }
                }
            } else if (typeof attr !== typeof undefined && attr !== false) {
                $("#nombre_org0").prop('required',false);
            }
        }

        function tiene_datos_participacion_organizacion()
        {
            for(index=0 ; index<5; index++)
            {
                var disp = $("#organizacionFamilia"+index).css('display');
                res = disp.valueOf();
                console.log('Validacion ==> ' + res);
                if(res=="block")
                {
                   return true;
                }
            }
            return false;
        }
     </script>

@endpush


@push("head")

            <style>

                #mas
                {
                    background-color: #3c8dbc;
                    font-size: 2rem;
                    color: white;
                    font-weight: bold;
                    width: 40px;
                    height: 40px;
                    margin-bottom: 0;
                    float:left;
                    border-radius: 10px;
                    text-align: center;
                    padding-top: 6px;
                    cursor: pointer;
                }
                #otraOrganizacion{
                    width:10%;
                    float:left;
                    margin-left:1%;
                    padding-top: 9px;

                }
                .seccion{
                    background-color: #fafafa;
                    border-radius: 10px;
                    padding-top: 1%;
                }
                @media screen and (min-width: 800px) {
                    .seccion{
                        width: 97%;
                    }
                    .complementaria{
                        margin-top:2%;
                        margin-bottom: 1%;
                    }
                }
                @media screen and (max-width: 800px) {
                    .seccion{
                        width: 89%;
                        margin-left:4%;
                    }

                    .complementaria{
                        margin-top:10%;
                        margin-bottom: 4%;
                    }
                }
                .borderinferior{
                    border-bottom: 1px #EEE solid;
                }

            </style>

@endpush