<!-- Es Victima Field -->

<style>
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

<div class=" ">
    <div class="form-group col-sm-6">
        {!! Form::label('nombre', 'Nombres') !!}
        <p>{!! $persona->nombre !!}</p>
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('nombre', 'Apellidos') !!}
        <p>{!! $persona->apellido !!}</p>
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('alias', 'Nombre identitario/otros nombres/apodo') !!}
        <p>{!! $persona->alias !!}</p>
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('alias', 'Documento de identidad') !!}
        <p>{!! $persona->documento_identidad !!}</p>
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('fmt_parentezco', 'Relación con la víctima') !!}
        @php($victima = \App\Models\victima::find($persona->id_victima))
        <p>{!! $victima->fmt_parentezco !!}</p>
    </div>


</div>




<div class="form-group col-sm-12 seccion" >

<!-- Alias Field -->



<!-- Fec Nac M Field -->
<div class="form-group col-sm-6">    
    {!! Form::label('f_nac', 'Fecha de nacimiento') !!}
    <p>{!! $persona->fecha_nacimiento !!}</p>
</div>

<!-- Id Lugar Nacimiento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_lugar_nacimiento', 'Lugar Nacimiento:') !!}
    <p>{!! $persona->lugar_nacimiento !!}, {!! $persona->lugar_nacimiento_depto!!}</p>
</div>
{{--
<div class="form-group col-sm-6">
    {!! Form::label('edad_aprox', 'Edad aproximada al momento de los hechos') !!}
    <p>{!! $persona->victima_edad_aproximada !!}</p>
</div>
--}}
<div class="form-group col-sm-12 borderinferior"></div>
<!-- Id Sexo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_sexo', 'Sexo (asignado al nacer)') !!}
    <p>{!! $persona->sexo !!}</p>
</div>

<!-- Id Orientacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_orientacion', 'Orientación sexual (se siente atraído por):') !!}
    <p>{!! $persona->orientacion !!}</p>
</div>

<!-- Id Identidad Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_identidad', 'Identidad de género (cómo se identifica):') !!}
    <p>{!! $persona->identidad !!}</p>
</div>
    <div class="form-group col-sm-6">
        {!! Form::label('id_estado_civil', 'Estado Civil') !!}
        <p>{!! $persona->estado_civil !!}</p>
    </div>
<div class="clearfix"></div>
<hr>
<!-- Id Etnia Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_etnia', 'Pertenencia étnico-racial') !!}
    <p>{!! $persona->etnia !!}</p>
</div>

@if (isset($persona->rel_id_etnia) && $persona->rel_id_etnia->descripcion == 'Indígena')

    <div class="form-group col-sm-6">
        {!! Form::label('id_etnia', 'Grupo indígena') !!}
        <p>{!! isset($persona->rel_id_etnia_indigena) ? $persona->rel_id_etnia_indigena->descripcion : '-' !!}</p>
    </div>

@endif
<div class="form-group col-sm-12 borderinferior"></div>
<!-- Id Nacionalidad Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_nacionalidad', 'Nacionalidad') !!}
    <p>{!! $persona->nacionalidad !!}</p>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('id_nacionalidad', 'Otra nacionalidad') !!}
    <p>{!! $persona->otra_nacionalidad !!}</p>
</div>

<div class="form-group col-sm-12 borderinferior"></div>

<!-- Condicion de discapacidad -->
<div class="form-group col-sm-12">
    {!! Form::label('id_discapacidad', 'Condición de discapacidad') !!}
    <p>{!! $persona->discapacidad !!}</p>
</div>
<div class="form-group col-sm-12 borderinferior"></div>
<!-- Id Lugar Residencia Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_lugar_residencia', 'Lugar Residencia') !!}
    <p>{!! $persona->lugar_residencia !!} ({!! $persona->lugar_residencia_muni !!} / {!! $persona->lugar_residencia_depto !!})</p>
</div>

<!-- Id Zona Field -->
<div class="form-group col-sm-6">
        {!! Form::label('id_zona', 'Zona') !!}
        <p>{!! $persona->zona !!}</p>
    </div>

<!-- Telefono Field -->
<div class="form-group col-sm-6">
    {!! Form::label('telefono', 'Teléfono') !!}
    <p>{!! $persona->telefono !!}</p>
</div>

<!-- Correo Electronico Field -->
<div class="form-group col-sm-6">
    {!! Form::label('correo_electronico', 'Correo Electrónico:') !!}
    <p>{!! $persona->correo_electronico !!}</p>
</div>
<div class="form-group col-sm-12 borderinferior"></div>


<!-- Id Edu Formal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_edu_formal', 'Educación Formal') !!}
    <p>{!! $persona->educacion_formal !!}</p>
</div>

<!-- Profesion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('profesion', 'Profesión u oficio') !!}
    <p>{!! $persona->profesion !!}</p>
</div>
{{-- <div class="form-group col-sm-12 borderinferior"></div>
<div class="form-group col-sm-6">
        {!! Form::label('ocupacion_actual', 'Ocupación actual') !!}
        <p>{!! $persona->ocupacion_actual !!}</p>
</div> --}}

{{-- <div class="form-group col-sm-6">
    {!! Form::label('edad_aprox', 'Ocupación al momento de los hechos') !!}
    <p>{!! $persona->victima_ocupacion_hechos !!}</p>
</div> --}}

</div>
<h4 class="form-group col-sm-12 complementaria"><b>Información complementaria</b></h4>
<div class="form-group col-sm-12 seccion" >
<!-- Ocupacion Actual Field -->


<!-- Cargo Publico Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cargo_publico', 'Ejerce autoridad o cargo público') !!}
    <p>{{$persona->cargo_publico_completo}}</p>
</div>

<!-- Es autoridad etnico-territorial -->
<div class="form-group col-sm-6">
        {!! Form::label('id_discapacidad', 'Es autoridad étnico-territorial') !!}        
        {!! $persona->autoridad_etnico_territorial !!}
</div>

<div class="form-group col-sm-12 borderinferior"></div>

<!-- Id Fuerza Publica Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_fuerza_publica', '¿Es miembro de la fuerza pública?') !!}
    <p>{{$persona->fuerza_publica_completo}}</p>

    @if (!empty($persona->fuerza_publica_especificar))
        {!! Form::label('fuerza_publica_especificar', 'detalle:') !!}
        <p>{{$persona->fuerza_publica_especificar}}</p>        
    @endif

</div>


<!-- Relación con la victima -->

{{-- 
<div class="form-group col-sm-6">
    {!! Form::label('id_tipo_organizacion', 'Relación con la víctima') !!}
    {!! $persona->relacion_con_victimas!!}            
</div>
--}}

<!-- Id Actor Armado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_actor_armado', '¿Fue miembro de un actor armado ilegal?') !!}
    <p>{{$persona->actor_armado_completo}}</p>    

    @if (!empty($persona->actor_armado_especificar))
        {!! Form::label('fuerza_publica_especificar', 'detalle:') !!}
        <p>{{$persona->actor_armado_especificar}}</p>        
    @endif

</div>

<div class="form-group col-sm-12 borderinferior"></div>

<!-- Organizacion Colectivo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre_organizacion', 'Participa o participaba en alguna organización/colectivo/grupo/pueblo ') !!}    
    <p>
        {!! $persona->organizacion_colectivo_completo!!}
    </p>
</div>





</div>



