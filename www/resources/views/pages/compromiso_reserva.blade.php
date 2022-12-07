@extends('layouts.app')

@section('content')

    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Compromiso de reserva</h3>
        </div>
        <div class="box-body">
            @include('pages.compromiso_reserva_txt')

        </div>
        <div class="box-footer">
            {!!   Form::open(['action'=>'entrevistadorController@registrar_compromiso']) !!}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="checkbox-inline icheck">
                            <input type="checkbox" name="acepto" id="acepto" value="1"  >
                            Comprendo y acepto este compromiso de reserva.
                        </label>
                    </div>
                </div>
                <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary" >Continuar</button>
                </div>





            {!! Form::close() !!}
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function(){
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });

        $(document)
            .on('click', 'form button[type=submit]', function(e) {
                var isValid = $('#acepto').iCheck('update')[0].checked;
                if(!isValid) {
                    e.preventDefault(); //evitar el submit
                    Swal.fire({
                        type: 'error',
                        title: 'Imposible continuar',
                        text: 'Debe aceptar el compromiso de reserva para poder acceder a la información de este sistema.'
                    })
                    //alert("Debe aceptar el compromiso de reserva para poder acceder a la información");
                }
                else {
                    //e.preventDefault(); //evitar el submit
                    Swal.fire(
                        '<i class="fa fa-smile-o" aria-hidden="true"></i>  Gracias por su compromiso con la reserva de información',
                        'Esta aceptación quedó registrada en el sistema.',
                        'success'
                    );


                }
            });


    </script>

@endpush