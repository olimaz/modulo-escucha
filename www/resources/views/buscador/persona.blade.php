@extends('layouts.app')
@section('content_header')
    {{-- <h1>Resultados de la búsqueda: {{ $listado->total() }} registros</h1> --}}

    <div class="box box-default box-solid">
        <div class="box-header">
            <h3 class="box-title">
                Víctimas: Filtrar la información visualizada
            </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-plus"></i>
                </button>
            </div>            
        </div>

        <div class="box-body">

            {!! Form::model($filtros,['url'=>"#",'method'=>'get']) !!}

            <div class="form-group col-sm-4">
                {!! Form::label('nombre', 'Nombres') !!}
                {!! Form::text('nombre', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
            </div>
            
            <div class="form-group col-sm-4">
                {!! Form::label('apellido', 'Apellidos') !!}
                {!! Form::text('apellido', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
            </div>            

            <div class="form-group col-sm-4">
                {!! Form::label('alias', 'Nombre identitario, otros nombres, apodo') !!}
                {!! Form::text('alias', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
            </div>            


            <!-- Id Tipo Documento Field -->
            <div class="form-group col-sm-4">
                @include('controles.catalogo', ['control_control' => 'id_tipo_documento'
                                                ,'control_default' => $filtros->id_tipo_documento
                                                ,'control_id_cat' => 41
                                                , 'control_multiple' => false
                                                , 'control_requerido' => false
                                                ,'control_vacio' => '[Ninguno]'
                                                ,'control_texto'=>'Tipo de documento de identidad'])

            </div>

            <!-- Num Documento Field -->
            <div class="form-group col-sm-4">
                {!! Form::label('num_documento', 'Número de documento') !!}
                {!! Form::text('num_documento', $filtros->num_documento, ['class' => 'form-control', 'maxlength' => 20]) !!}
            </div>            

            <div class="form-group col-sm-4">
                {!! Form::label('correo_electronico', 'Correo Electrónico:') !!}
                {!! Form::email('correo_electronico', $filtros->correo_electronico, ['class' => 'form-control', 'maxlength' => 200]) !!}
            </div> 

            <div class="clearfix"></div>

            <div class="form-group col-sm-4">
                @include('controles.catalogo', ['control_control' => 'id_sexo'
                                                ,'control_default' => $filtros->id_sexo
                                                ,'control_id_cat' => 24
                                                ,'control_vacio' => '[Mostrar todos]'
                                                ,'control_texto'=>'Sexo (asignado al nacer)'])
            </div>
            
            <div class="form-group col-sm-4">
                @include('controles.catalogo', ['control_control' => 'id_orientacion'
                                                ,'control_default' => null
                                                ,'control_id_cat' => 25
                                                ,'control_vacio' => '[Ninguno]'
                                                ,'control_texto'=>'Orientación sexual (se siente atraído por)'])
            </div>

            <div class="form-group col-sm-4">
                @include('controles.catalogo', ['control_control' => 'id_identidad'
                                                ,'control_default' => null
                                                ,'control_id_cat' => 26
                                                , 'control_multiple' => false
                                                , 'control_requerido' => false
                                                ,'control_vacio' => '[Ninguno]'
                                                ,'control_texto'=>'Identidad de género (¿cómo se identifica?)'])
            
            </div>

            <div class="clearfix"></div>
            
            <div class="form-group col-sm-4">    
                @include('controles.catalogo', ['control_control' => 'id_edu_formal'
                                                ,'control_default' => $filtros->id_edu_formal
                                                ,'control_id_cat' => 46
                                                , 'control_requerido' => false                                                    
                                                ,'control_vacio' => '[Ninguno]'
                                                ,'control_texto'=>'Educación formal'])    
            </div>  

            <div class="form-group col-sm-4">
                {!! Form::label('profesion', 'Profesión') !!}
                {!! Form::text('profesion', $filtros->profesion, ['class' => 'form-control', 'maxlength' => 100]) !!}
            </div>

            <div class="form-group col-sm-4">
                {!! Form::label('ocupacion_actual', 'Ocupación actual') !!}
                {!! Form::text('ocupacion_actual', $filtros->ocupacion_actual, ['class' => 'form-control', 'maxlength' => 100]) !!}
            </div>

            <div class="clearfix"></div>

            <div class="form-group col-sm-4">
                @include('controles.catalogo', ['control_control' => 'id_estado_civil'
                                                ,'control_default' => $filtros->id_estado_civil
                                                ,'control_id_cat' => 43
                                                , 'control_requerido' => false
                                                //, 'control_otro' => true
                                                ,'control_vacio' => '[Ninguno]'
                                                ,'control_texto'=>'Estado civil'])
                                                
            </div>

            <div class="col-sm-4">
                @include('controles.catalogo', ['control_control' => 'discapacidad'
                                                    ,'control_id_cat'=>44
                                                    , 'control_default'=>null
                                                    , 'control_multiple' => true
                                                    , 'control_requerido' => false
                                                    //, 'control_vacio' => '[Ninguno]'
                                                    , 'control_texto'=>'Condición de discapacidad'])
            </div>            

            <div class="clearfix"></div>
            
            <div class="form-group col-md-6 col-sm-12">
                @include('controles.geo2', ['control_control' => 'id_lugar_nacimiento'
                                            , 'control_default'=>$filtros->id_lugar_nacimiento
                                            , 'control_vacio' => '[Ninguno]'
                                            , 'control_texto' => 'Lugar de nacimiento'])                                         
            </div>            

            <div class="form-group col-md-6" style="margin-top:1.6%">
                @include('controles.fecha_incompleta', ['control_control' => 'fec_nac'
                                                     , 'control_default'=>null
                                                     , 'control_vacio' => '[Ninguno]'
                                                     , 'control_texto'=>'Fecha de nacimiento'
                                                     ])
            </div>

            <div class="clearfix"></div>

            <div class="form-group col-sm-6">
                @include('controles.catalogo', ['control_control' => 'id_nacionalidad'
                                                ,'control_default' => $filtros->id_nacionalidad
                                                ,'control_id_cat' => 42
                                                ,'control_vacio' => '[Ninguno]'
                                                 , 'control_otro' => true
                                                ,'control_texto'=>'Nacionalidad'])
            </div>

            <div class="form-group col-sm-6">
                @include('controles.catalogo', ['control_control' => 'id_otra_nacionalidad'
                                                ,'control_default' => $filtros->id_otra_nacionalidad
                                                ,'control_id_cat' => 42
                                                ,'control_vacio' => '[Ninguno]'
                                                 , 'control_otro' => true
                                                ,'control_texto'=>'Otra nacionalidad'])
            </div>
            
            <div class="clearfix"></div>

            <div class="form-group col-md-6">
                @include('controles.geo3', ['control_control' => 'id_lugar_residencia'
                                        , 'control_default'=>$filtros->id_lugar_residencia
                                        , 'control_vacio' => '[Ninguno]'
                                        , 'control_texto' => 'Lugar de residencia'])
            
            </div>

            <div class="form-group col-sm-6" style="margin-top:1.6%">
                @include('controles.catalogo', ['control_control' => 'id_zona'
                                                ,'control_default' => $filtros->id_zona
                                                ,'control_id_cat' => 45
                                                ,'control_vacio' => '[Ninguno]'
                                                ,'control_texto'=>'Zona'])
            </div>

            <div class="clearfix"></div>

            <div class="form-group col-sm-4">                    
                {!! Form::label('Ejerce autoridad o cargo público', 'Ejerce autoridad o cargo público:') !!}
                {!! Form::select('cargo_publico', ['1'=>'Si', '2'=>'No', '-1'=>'[Ninguno]'], null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-sm-4">
                    @include('controles.catalogo', ['control_control' => 'id_fuerza_publica'
                    ,'control_default' => $filtros->id_fuerza_publica
                    ,'control_id_cat' => 49
                    ,'control_vacio' => '[Ninguno]'                        
                    ,'control_texto'=>'Es miembro de la fuerza pública'])
            </div>            

            <div class="form-group col-sm-4">
                @include('controles.catalogo', ['control_control' => 'id_fuerza_publica_estado'
                                                ,'control_default' => $filtros->id_fuerza_publica_estado
                                                ,'control_id_cat' => 48
                                                ,'control_vacio' => '[Ninguno]'
                                                ,'control_texto'=>'Estado'])
            </div>
            
            <div class="clearfix"></div>

            <div class="form-group col-sm-4">
                @include('controles.catalogo', ['control_control' => 'id_actor_armado'
                                                ,'control_default' => $filtros->id_actor_armado
                                                ,'control_id_cat' => 50
                                                ,'control_vacio' => '[Ninguno]'
                                                ,'control_texto'=>'Fue miembro de un actor armado ilegal'])
            </div>            

            <div class="form-group col-sm-4">
                @include('controles.catalogo', ['control_control' => 'id_etnia'
                                                ,'control_default' => $filtros->id_etnia
                                                ,'control_id_cat' => 27
                                                ,'control_vacio' => '[Ninguno]'
                                                ,'control_otro' => true
                                                ,'control_texto'=>'Pertenencia étnico-racial'])
            </div>

            <div id ="campoIndigena" class="form-group col-sm-4" style="display:none">
                @include('controles.catalogo', ['control_control' => 'id_etnia_indigena'
                                                ,'control_default' => null
                                                ,'control_id_cat' => 28
                                                , 'control_multiple' => false
                                                , 'control_requerido' => false
                                                //, 'control_otro' => true
                                                ,'control_vacio' => '[Ninguno]'
                                                ,'control_texto'=>'¿A cuál étnia indígena pertenece?'])
            
            </div>                              
      
                
            <div class="clearfix"></div>
            <div class="text-right">
                <button type="submit" class="btn btn-success">Aplicar filtro</button>
            </div>            

            {!! Form::close() !!}

        </div>      

    </div>
@endsection

@section('content')

    <div class="box box-primary">
        <div class="box-header text-right">
            Resultados de la búsqueda: {{ $listado->total() }} registros
        </div>
        <div class="box-body">
            <table class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>id_sexo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listado as $fila)
                        <tr>
                            <td>
                                {{ $fila->nombre }}
                            </td>
                            <td>
                                {{ $fila->apellido }}
                            </td>
                            <td>
                                {{ $fila->sexo }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        <div class="box-footer">
            {!! $listado->appends(Request::all())->render() !!}
        </div>
    </div>

@endsection

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script>
$( document).ready(function(){
    $("#id_etnia").change(function(){            
        if($(this).val()== {{ config('expedientes.indigena') }}){
            $("#campoIndigena").show(200);
        }else{
            $("#campoIndigena").hide(200);
            $("#id_etnia_indigena").val("-1");
        }
    });

    @if($filtros->id_etnia == 196)
            $("#campoIndigena").show(200);
    @endif    
});    

</script>