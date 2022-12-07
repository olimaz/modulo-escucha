


<div class="col-xs-4">
    <div class="form-group ">
        @include('controles.carga_archivo', ['control_control' => 'archivo_30'
                                            ,'control_default' => $excelListados->nombre_archivo
                                            , 'control_requerido' => true
                                               , 'control_texto'=>"<i class='fa fa-file-excel-o' aria-hidden='true'></i> Adjuntar archivo de  excel"])
        <br>

    </div>
</div>

<div class="col-sm-8">
    <br>
    <br>
    <br>
    <br>
    <div class="form-group col-xs-12">
        {!! Form::label('descripcion', 'Descripción para este archivo:') !!}
        {!! Form::text('descripcion', null, ['class' => 'form-control ','required'=>'required','maxlength'=>190]) !!}
    </div>
    <div class="col-xs-12">
        @include('controles.radio_si_no', ['control_control' => 'id_acceso_publico'
                                  ,'control_default' => $excelListados->id_acceso_publico
                                  ,'control_texto'=>"Permitir que otros usuarios utilicen este listado de códigos:"])
    </div>
    <br>
    <br>
</div>


@include("partials.paciencia")

@include("controles.js_carga_archivo")
@push('js')
    <script>
        $('#frm_adjunto').submit(function() {
            //Ver que haya cargado algo
            var pendientes = false;
            if($("#archivo_30_filename").val().length < 1) {
                pendientes = true;
            }
            if(pendientes) {
                alert("No cargó el archivo.  Antes de grabar el adjunto, debe cargar el archivo");
                return false;
            }
            else {
                $('#modal_paciencia').modal('show');
                return true;
            }
        });
    </script>
@endpush


