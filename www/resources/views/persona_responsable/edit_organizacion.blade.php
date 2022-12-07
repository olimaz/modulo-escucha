
@if ($persona->rel_persona_organizacion->count() > 0)
    @foreach ($persona->rel_persona_organizacion as $organizacion)

    <div id="organizacionFamilia">
        <div class="col-sm-4">
            @include('controles.catalogo', ['control_control' => 'organizacion_tipo[]'
                                                        , 'control_id_cat'=>51
                                                        , 'control_default'=>$organizacion->id_tipo_organizacion                                                       
                                                        , 'control_vacio' => '[Ninguno]'
                                                        , 'control_id' => 'organizacion_tipo'.$persona->id_persona.$organizacion->id_persona_organizacion
                                                        , 'control_otro' => true
                                                        , 'control_texto'=>'Tipo de organización / sector'])
        </div>
        
        <div class="form-group col-sm-4 nombreOrganizacion" style="margin-top: 5px;">
            {!! Form::label(' ', ' ') !!}
            {!! Form::text('organizacion_nombre[]', $organizacion->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre de la Organización']) !!}
        </div>
        
        <div class="form-group col-sm-4 rolOrganizacion" style="margin-top: 5px;">
            {!! Form::label('rol', ' ') !!}
            {!! Form::text('organizacion_rol[]', $organizacion->rol, ['class' => 'form-control', 'placeholder' => 'Rol dentro de la Organización']) !!}
        </div>
    </div>
    @endforeach

@endif

@for($i=0; $i <5; $i++)  

@php 
    $display = ($i == 0 ? 'block' : 'none');

    if($persona->id_persona != "")
        $display = 'none';
@endphp

<div id="organizacionFamilia{{$i}}" style="display:{{$display}}">
        <div class="col-sm-4">
            
                @include('controles.catalogo', ['control_control' => 'organizacion_tipo[]'                                                        
                , 'control_id_cat'=>51                                                        
                , 'control_vacio' => '[Ninguno]'
                , 'control_id' => 'organizacion_tipo'.$i
                , 'control_otro' => true
                , 'control_texto'=>'Tipo de organización / sector'])
        </div>
        
        <div class="form-group col-sm-4 nombreOrganizacion" style="margin-top: 5px;">
            {!! Form::label(' ', ' ') !!}
            {!! Form::text('organizacion_nombre[]', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la Organización']) !!}
        </div>
        
        <div class="form-group col-sm-4 rolOrganizacion" style="margin-top: 5px;">
            {!! Form::label('rol', ' ') !!}
            {!! Form::text('organizacion_rol[]', null, ['class' => 'form-control', 'placeholder' => 'Rol dentro de la Organización']) !!}
        </div>
    </div>
@endfor        

