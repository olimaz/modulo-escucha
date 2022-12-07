
<div class="form-group col-sm-8">
    {!! Form::label('c_entrevista', 'Código de entrevista:') !!}
    <div id="c_entrevista">{{ $etiquetarAsignacion->c_entrevista }}</div>
</div>




<div class="clearfix"></div>
<!-- Id Transcriptor Field -->
<div class="form-group col-sm-4">
    @include('controles.radio_si_no', ['control_control' => 'urgente'
                                        ,'control_default' => $etiquetarAsignacion->urgente
                                        ,'control_texto'=>'Etiquetado urgente'])
</div>

<div class="form-group col-sm-8">
    @include('controles.transcriptor', ['control_control' => 'id_transcriptor'
                                            ,'control_default' => $etiquetarAsignacion->id_transcriptor
                                            ,'control_texto'=>'Transcriptor asignado'])

</div>


<!-- Observaciones Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control','rows'=>3]) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Asignar', ['class' => 'btn btn-primary','id'=>'btn_asignar']) !!}
    <a href="{!! route('transcribirAsignacions.index') !!}" class="btn btn-default">Cancelar</a>
</div>

@push("js")
    <script>
        function actualizar(datos) {
            $("#id_e_ind_fvt").val(datos.id);
            $("#c_entrevista").html(datos.txt);
            console.log(datos);
            console.log(datos.id);
        }
        $(function(){
            $('#n_entrevista').change(function(resultado) {
                var url = "{{ url('entrevista/json') }}";
                var numero = $(this).val();
                $.getJSON( url, { numero: numero } )
                    .done(function( json ) {
                        actualizar(  json );
                    })
                    .fail(function( jqxhr, textStatus, error ) {
                        var err = textStatus + ", " + error;
                        console.log( "Request Failed: " + err );
                    });
            });


        })
    </script>

@endpush