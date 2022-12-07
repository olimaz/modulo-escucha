@extends('layouts.app')

@include("entrevistadors._estilo")

@section('content')
    <section class="content-header">
        <h1>
            Cambiar clave del usuario #{!! $entrevistador->numero_entrevistador !!}
        </h1>
   </section>
   <div class="content">


       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($entrevistador, ['action' => ['entrevistadorController@cambiar_clave'], 'method' => 'patch','id'=>'frm_abc']) !!}
                   <div class="form-group col-sm-12">
                       {!! Form::label('name', 'Nombre: ') !!}
                       <p class="text-primary">{{ $entrevistador->name }}</p>

                   </div>

                   <div class="form-group col-sm-12">
                       {!! Form::label('email', 'Correo electrónico: ') !!}
                       <p class="text-primary">{{ $entrevistador->email }}</p>
                   </div>

                   <div class="form-group col-sm-12">
                       {!! Form::label('password_old', 'Contraseña actual:  ') !!}
                       {!! Form::password('password_old', ['class' => 'form-control','required'=>'required','autocomplete'=>'off','maxlength'=>100, 'title'=>'Si no la recuerda, comuníquese con el administrador','data-toggle'=>"tooltip" ]) !!}
                   </div>

                   <div class="form-group col-sm-12">
                       {!! Form::label('password', 'Nueva contraseña:  ') !!}
                       {!! Form::password('password', ['class' => 'form-control pr-password','autocomplete'=>'off','maxlength'=>100, 'title'=>'Facil de recordar, difícil de adivinar','data-toggle'=>"tooltip" ,'required'=>'required' ]) !!}
                   </div>


                   <div class="form-group col-sm-12">
                       <a class="btn btn-default" href="{{ url('ver_perfil') }}">Cancelar</a>
                       {!! Form::submit('Actualizar mi contraseña', ['class' => 'btn btn-primary pull-right']) !!}


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
            if ($('#password').attr('data-passwordStrengthForcer_AllGood') !='1'){
                alert("La clave nueva no cumple con los requisitos indicados.");
                $('#password').focus();
                return false;
            }
        })


    </script>


@endpush