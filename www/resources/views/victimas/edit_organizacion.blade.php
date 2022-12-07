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
                                                        , 'control_texto'=>'21. Tipo de organización / sector'])
        </div>
        
        <div class="form-group col-sm-3 nombreOrganizacion" style="margin-top: 5px;">
            @include('controles.autofill', ['control_control' => 'organizacion_nombre[]'
                                       ,'control_id' => 'organizacion_nombre_'.$index
                                      ,'control_url' => 'autofill/persona_organizacion_nombre'
                                      ,'control_default' => $organizacion->nombre
                                      ,'control_resaltar' => false
                                      ,'control_placeholder' =>'Nombre de la Organización.'
                                      ,'control_max' =>250
                                      ,'control_texto'=>'Especificar:'])
        </div>
        
        <div class="form-group col-sm-3 rolOrganizacion" style="margin-top: 5px;">
            {!! Form::label('rol', ' ') !!}
            {!! Form::text('organizacion_rol[]', $organizacion->rol, ['class' => 'form-control', 'placeholder' => 'Rol dentro de la Organización', 'id'=>'rol_org'.$index]) !!}
        </div>
        <div class="form-group col-sm-2 btnQuitar" style="margin-top: 30px;">
            <a href="#" id="quitarOrganizacion" onclick="quitarOrganizacion('{{$index}}'); return false;" class="btn btn-danger btn-xs">x</a>
        </div>        
    </div>
    @endforeach

@endif
{{--Fin del formulario --}}


@for($i=0; $i <5; $i++)  

@php 
    $display = ($i == 0 ? 'block' : 'none');

    if($persona->id_persona != ""){
        $display = 'none';
    }

    if ($persona->id_persona != "" && $total==0 && $i == 0) {
        $display = 'block';
    }    
        
@endphp

<div id="organizacionFamilia{{$i}}" style="display:{{$display}}">
        <div class="col-sm-4">
            
                @include('controles.catalogo', ['control_control' => 'organizacion_tipo[]'                                                        
                , 'control_id_cat'=>51                                                        
                // , 'control_vacio' => '[Ninguno]'
                , 'control_id' => 'organizacion_tipo'.$i
                , 'control_otro' => true           
                , 'control_texto'=>'21. Tipo de organización / sector'])
        </div>
        
        <div class="form-group col-sm-3 nombreOrganizacion" style="margin-top: 5px;">
            {!! Form::label(' ', ' ') !!}
            {!! Form::text('organizacion_nombre[]', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la Organización', 'maxlength' => 100, 'id'=>'nombre_org'.$i]) !!}
        </div>
        
        <div class="form-group col-sm-3 rolOrganizacion" style="margin-top: 5px;">
            {!! Form::label('rol', ' ') !!}
            {!! Form::text('organizacion_rol[]', null, ['class' => 'form-control', 'placeholder' => 'Rol dentro de la Organización', 'maxlength' => 30, 'id'=>'rol_org'.$i]) !!}
        </div>
        <div class="form-group col-sm-2 btnQuitar" style="margin-top: 30px;">
            <a href="#" id="quitarOrganizacion" onclick="quitarOrganizacion('{{$i}}'); return false;" class="btn btn-danger btn-xs">x</a>
        </div>   
    </div>
@endfor        

