@php
    $total = $persona->rel_persona_organizacion->count();
@endphp


@if ($total > 0)

    @foreach ($persona->rel_persona_organizacion as $organizacion)

    @php $index = $loop->iteration; @endphp

    <div id="organizacionFamilia{{$index}}">
        <div class="col-sm-4">
            @include('controles.catalogo', ['control_control' => 'organizacion_tipo[]'
                                                        , 'control_id_cat'=>51
                                                        , 'control_default'=>$organizacion->id_tipo_organizacion                                                       
                                                        // , 'control_vacio' => '[Ninguno]'
                                                        , 'control_id' => 'organizacion_tipo'.$index
                                                        , 'control_otro' => true
                                                        , 'required'
                                                        , 'control_texto'=>'24.2 Tipo de organización / sector'])
        </div>
        
        <div class="form-group col-sm-3 nombreOrganizacion" style="margin-top: 5px;">
            @include('controles.autofill', ['control_control' => 'organizacion_nombre[]'
                                        ,'control_id' => 'organizacion_nombre_'.$index
                                       ,'control_url' => 'autofill/persona_nombre_organizacion'
                                       ,'control_default' => $organizacion->nombre
                                       ,'control_resaltar' => false
                                       ,'control_placeholder' =>'Nombre de la Organización'
                                       ,'control_max' =>250
                                       ,'control_texto'=>'Especificar:'])
            {{--
            {!! Form::label(' ', ' ') !!}
            {!! Form::text('organizacion_nombre[]', $organizacion->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre de la Organización', 'required', 'id'=>'nombre_org'.$index]) !!}
            --}}
        </div>
        
        <div class="form-group col-sm-3 rolOrganizacion" style="margin-top: 5px;">
            @include('controles.autofill', ['control_control' => 'organizacion_rol[]'
                                        ,'control_id' => 'organizacion_rol_'.$index
                                       ,'control_url' => 'autofill/persona_rol_organizacion'
                                       ,'control_default' => $organizacion->rol
                                       ,'control_resaltar' => false
                                       ,'control_placeholder' =>'Indicar el rol'
                                       ,'control_max' =>250
                                       ,'control_texto'=>'Rol:'])
        </div>
        <div class="form-group col-sm-2 btnQuitar" style="margin-top: 30px;">
            <a href="#" id="quitarOrganizacion" onclick="quitarOrganizacion('{{$index}}'); return false;" class="btn btn-danger btn-xs">x</a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    @endforeach


@endif
{{--Fin del formulario --}}

@php
    $ciclo = $total > 0 ? $total+1 : 0
@endphp


@for($i=$ciclo; $i <6; $i++)

@php 
    $display = ($i == 0 ? 'block' : 'none');
    $required = "";

    if($persona->id_persona != ""){
        $display = 'none';
    }

    if ($persona->id_persona != "" && $total==0 && $i == 0) {
        $display = 'block';
        $required = 'required';
    }
        
@endphp

<div id="organizacionFamilia{{$i}}" style="display:{{$display}}">
        <div class="col-sm-4">
            
                @include('controles.catalogo', ['control_control' => 'organizacion_tipo[]'                                                        
                , 'control_id_cat'=>51                                                        
                // , 'control_vacio' => '[Ninguno]'
                , 'control_id' => 'organizacion_tipo'.$i
                , 'control_otro' => true           
                , 'control_texto'=>'24.2 Tipo de organización / sector'])
        </div>
        
        <div class="form-group col-sm-3 nombreOrganizacion" style="margin-top: 5px;">
            @include('controles.autofill', ['control_control' => 'organizacion_nombre[]'
                                      ,'control_id' => 'organizacion_nombre_'.$i
                                     ,'control_url' => 'autofill/persona_nombre_organizacion'
                                     ,'control_default' => null
                                     ,'control_resaltar' => false
                                     ,'control_placeholder' =>'Nombre de la Organización'
                                     ,'control_max' =>250
                                     ,'control_texto'=>'Especificar:'])

        </div>
        
        <div class="form-group col-sm-3 rolOrganizacion" style="margin-top: 5px;">
            {!! Form::label('rol', ' ') !!}
            {!! Form::text('organizacion_rol[]', null, ['class' => 'form-control', 'placeholder' => 'Rol dentro de la Organización', 'maxlength' => 30, 'id'=>'rol_org'.$i]) !!}
        </div>
        <div class="form-group col-sm-2 btnQuitar" style="margin-top: 30px;">
            <a href="#" id="quitarOrganizacion" onclick="quitarOrganizacion('{{$i}}'); return false;" class="btn btn-danger btn-xs">x</a>
        </div>
        <div class="clearfix"></div>
    </div>
@endfor        

