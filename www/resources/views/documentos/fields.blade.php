
{{-- Esta seccion se muestra solo en el create, no en el update --}}
<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_7'

                                            ,'control_default' => $documento->nombre_archivo
                                               , 'control_texto'=>"<i class='fa fa-pencil-square-o' aria-hidden='true'></i> Adjunto"])
</div>
@include('controles.js_carga_archivo')
<div class="clearfix"></div>
<!-- Id Objetivo Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_objetivo'
                                           ,'control_id_cat'=>6
                                           , 'control_default'=>$documento->id_objetivo
                                           //, 'control_vacio' => '[Mostrar todos]'
                                           ,'control_texto'=>'Objetivo'])
</div>

<!-- Id Instrumento Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_instrumento'
                                           ,'control_id_cat'=>7
                                           , 'control_default'=>$documento->id_instrumento
                                           //, 'control_vacio' => '[Mostrar todos]'
                                           ,'control_texto'=>'Instrumento'])
</div>

<!-- Orden Field -->
<div class="form-group col-sm-6">
    {!! Form::label('orden', 'Orden:') !!}
    {!! Form::number('orden', null, ['class' => 'form-control']) !!}
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control','required'=>'required']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('documentos.index') !!}" class="btn btn-default">Cancelar</a>
</div>



@push('js')
    <script>
        $('#frm_nuevo').submit(function() {
            var pendientes = false;
            if($("#archivo_7_filename").val().length < 1) {
                pendientes = true;
            }
            if(pendientes) {
                alert("No cargó el archivo.  Antes de grabar debe especificar el archivo a mostrar");
                return false;
            }
            else {
                $("#modal_paciencia").modal({backdrop: 'static', keyboard: false});
                return true;
            }
        });
    </script>
@endpush