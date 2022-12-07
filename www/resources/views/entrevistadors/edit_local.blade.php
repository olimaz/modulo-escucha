@extends('layouts.app')

@include("entrevistadors._estilo")

@section('content')
    <section class="content-header">
        <h1>
            Actualizar información del usuario #{!! $entrevistador->numero_entrevistador !!}
        </h1>
    </section>
    <div class="content">


        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($entrevistador, ['action' => ['entrevistadorController@update', $entrevistador->id_entrevistador], 'method' => 'patch','id'=>'frm_abc']) !!}
                    <div class="form-group col-sm-12">
                        {!! Form::label('name', 'Nombre: ') !!}
                        {!! Form::text('name', null, ['class' => 'form-control','maxlength'=>100, 'title'=>'¿Cómo se llama?','data-toggle'=>"tooltip" , "required"=>"required"]) !!}
                    </div>

                    <div class="form-group col-sm-12">
                        {!! Form::label('email', 'Correo electrónico: ') !!}
                        {!! Form::email('email', null, ['class' => 'form-control','disabled'=>'disabled','maxlength'=>100, 'title'=>'Con este se identificará ante el sistema','data-toggle'=>"tooltip" ]) !!}
                    </div>

                    <div class="form-group col-sm-12">
                        {!! Form::label('password', 'Nueva contraseña: (Si deja este espacio en blanco, se mantiene la contraseña actual) ') !!}
                        {!! Form::text('password', null, ['class' => 'form-control pr-password','autocomplete'=>'off','maxlength'=>100, 'title'=>'El usuario puede cambiarla luego','data-toggle'=>"tooltip" ]) !!}
                    </div>
                    <div class="col-sm-12">
                        @include('controles.criterio_fijo', ['control_control' => 'id_nivel'
                                                            ,'control_grupo'=>400
                                                            , 'control_default'=>$entrevistador->id_nivel
                                                            , 'control_multiple' => false
                                                            , 'control_requerido' => true
                                                            //, 'control_vacio' => '[Mostrar todos]'
                                                            ,'control_texto'=>'Nivel de acceso:'])
                    </div>

                    <div class="form-group col-sm-12">
                        <a class="btn btn-default" href="{{ action('entrevistadorController@index') }}">Cancelar</a>
                        {!! Form::submit('Actualizar información del usuario', ['class' => 'btn btn-primary pull-right']) !!}


                    </div>


                    {!! Form::close() !!}

                </div>
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
            if($('#password').val().length > 0) {
                if ($('#password').attr('data-passwordStrengthForcer_AllGood') !='1'){
                    alert("La clave especificada no cumple con los requisitos indicados");
                    $('#password').focus();
                    return false;
                }
            }
        })


    </script>


@endpush