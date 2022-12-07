@extends('layouts.app')

@include("entrevistadors._estilo")

@section('content_header')
    <h1>Agregar un nuevo usuario</h1>

    <p>Favor de completar la siguiente información</p>
@endsection



@section('content')
    @include('adminlte-templates::common.errors')

    <div >
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h1 class="box-title">Datos del nuevo usuario</h1>
            </div>
            <div class="box-body ">
                {!! Form::open(['route' => 'entrevistadors.store','id'=>'frm_abc']) !!}
                <div class="form-group col-sm-12">
                    {!! Form::label('name', 'Nombre: ') !!}
                    {!! Form::text('name', null, ['class' => 'form-control','required'=>'required','maxlength'=>100, 'title'=>'¿Cómo se llama?','data-toggle'=>"tooltip" ]) !!}
                </div>

                <div class="form-group col-sm-12">
                    {!! Form::label('email', 'Correo electrónico: ') !!}
                    {!! Form::email('email', null, ['class' => 'form-control','required'=>'required','maxlength'=>100, 'title'=>'Con este se identificará ante el sistema','data-toggle'=>"tooltip" ]) !!}
                </div>

                <div class="form-group col-sm-12">
                    {!! Form::label('password', 'Contraseña inicial: ') !!}
                    {!! Form::text('password', null, ['class' => 'form-control pr-password','autocomplete'=>'off','required'=>'required','minlength'=>6,'maxlength'=>100, 'title'=>'El usuario puede cambiarla luego','data-toggle'=>"tooltip" ]) !!}
                </div>
                <div class="col-sm-12">
                    @include('controles.criterio_fijo', ['control_control' => 'id_nivel'
                                                        ,'control_grupo'=>400
                                                        , 'control_default'=>101
                                                        , 'control_multiple' => false
                                                        , 'control_requerido' => true
                                                        //, 'control_vacio' => '[Mostrar todos]'
                                                        ,'control_texto'=>'Nivel de acceso:'])
                </div>

                <div class="form-group col-sm-12">
                    <a class="btn btn-default" href="{{ action('entrevistadorController@index') }}">Cancelar</a>
                    {!! Form::submit('Crear nuevo usuario', ['class' => 'btn btn-primary pull-right']) !!}


                </div>

                {!! Form::close() !!}
            </div>

        </div>
    </div>


@endsection

@push('js')
    {{--
        Tomado de https://www.jqueryscript.net/form/password-strength-forcer.html
        Cambié el JS para unos chapuces que necesitaba
     --}}
    <script src="{{ url('vendor/password-strength-forcer/jquery.passwordStrengthForcer.js') }}"></script>
    <script>
        $("#password").passwordStrengthForcer({
            minlength: 6,
            maxlength: 0,
            numuppercaserequired: 1,
            numdigitsrequired: 1,
            numspecialrequired: 1,
        });
        $('#frm_abc').on('submit',function(){
            if ($('#password').attr('data-passwordStrengthForcer_AllGood') !='1'){
                alert("La clave especificada no cumple con los requisitos indicados");
                $('#password').focus();
                return false;
            }
        })


    </script>


@endpush
