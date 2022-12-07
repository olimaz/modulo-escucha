<!-- Id E Ind Fvt Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_e_ind_fvt', 'Id E Ind Fvt:') !!}
    {!! Form::number('id_e_ind_fvt', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Idioma Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_idioma', 'Id Idioma:') !!}
    {!! Form::number('id_idioma', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Nativo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_nativo', 'Id Nativo:') !!}
    {!! Form::number('id_nativo', null, ['class' => 'form-control']) !!}
</div>

<!-- Nombre Interprete Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre_interprete', 'Nombre Interprete:') !!}
    {!! Form::text('nombre_interprete', null, ['class' => 'form-control']) !!}
</div>

<!-- Documentacion Aporta Field -->
<div class="form-group col-sm-6">
    {!! Form::label('documentacion_aporta', 'Documentacion Aporta:') !!}
    {!! Form::number('documentacion_aporta', null, ['class' => 'form-control']) !!}
</div>

<!-- Documentacion Especificar Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('documentacion_especificar', 'Documentacion Especificar:') !!}
    {!! Form::textarea('documentacion_especificar', null, ['class' => 'form-control']) !!}
</div>

<!-- Identifica Testigos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('identifica_testigos', 'Identifica Testigos:') !!}
    {!! Form::number('identifica_testigos', null, ['class' => 'form-control']) !!}
</div>

<!-- Ampliar Relato Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ampliar_relato', 'Ampliar Relato:') !!}
    {!! Form::number('ampliar_relato', null, ['class' => 'form-control']) !!}
</div>

<!-- Ampliar Relato Temas Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('ampliar_relato_temas', 'Ampliar Relato Temas:') !!}
    {!! Form::textarea('ampliar_relato_temas', null, ['class' => 'form-control']) !!}
</div>

<!-- Priorizar Entrevista Field -->
<div class="form-group col-sm-6">
    {!! Form::label('priorizar_entrevista', 'Priorizar Entrevista:') !!}
    {!! Form::number('priorizar_entrevista', null, ['class' => 'form-control']) !!}
</div>

<!-- Priorizar Entrevista Asuntos Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('priorizar_entrevista_asuntos', 'Priorizar Entrevista Asuntos:') !!}
    {!! Form::textarea('priorizar_entrevista_asuntos', null, ['class' => 'form-control']) !!}
</div>

<!-- Contiene Patrones Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contiene_patrones', 'Contiene Patrones:') !!}
    {!! Form::number('contiene_patrones', null, ['class' => 'form-control']) !!}
</div>

<!-- Contiene Patrones Cuales Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('contiene_patrones_cuales', 'Contiene Patrones Cuales:') !!}
    {!! Form::textarea('contiene_patrones_cuales', null, ['class' => 'form-control']) !!}
</div>

<!-- Indicaciones Transcripcion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('indicaciones_transcripcion', 'Indicaciones Transcripcion:') !!}
    {!! Form::textarea('indicaciones_transcripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control']) !!}
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'Created At:') !!}
    {!! Form::date('created_at', null, ['class' => 'form-control','id'=>'created_at']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#created_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Updated At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('updated_at', 'Updated At:') !!}
    {!! Form::date('updated_at', null, ['class' => 'form-control','id'=>'updated_at']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#updated_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Identificacion Consentimiento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('identificacion_consentimiento', 'Identificacion Consentimiento:') !!}
    {!! Form::text('identificacion_consentimiento', null, ['class' => 'form-control']) !!}
</div>

<!-- Conceder Entrevista Field -->
<div class="form-group col-sm-6">
    {!! Form::label('conceder_entrevista', 'Conceder Entrevista:') !!}
    {!! Form::number('conceder_entrevista', null, ['class' => 'form-control']) !!}
</div>

<!-- Grabar Audio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('grabar_audio', 'Grabar Audio:') !!}
    {!! Form::number('grabar_audio', null, ['class' => 'form-control']) !!}
</div>

<!-- Elaborar Informe Field -->
<div class="form-group col-sm-6">
    {!! Form::label('elaborar_informe', 'Elaborar Informe:') !!}
    {!! Form::number('elaborar_informe', null, ['class' => 'form-control']) !!}
</div>

<!-- Tratamiento Datos Analizar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tratamiento_datos_analizar', 'Tratamiento Datos Analizar:') !!}
    {!! Form::number('tratamiento_datos_analizar', null, ['class' => 'form-control']) !!}
</div>

<!-- Tratamiento Datos Analizar Sensible Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tratamiento_datos_analizar_sensible', 'Tratamiento Datos Analizar Sensible:') !!}
    {!! Form::number('tratamiento_datos_analizar_sensible', null, ['class' => 'form-control']) !!}
</div>

<!-- Tratamiento Datos Utilizar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tratamiento_datos_utilizar', 'Tratamiento Datos Utilizar:') !!}
    {!! Form::number('tratamiento_datos_utilizar', null, ['class' => 'form-control']) !!}
</div>

<!-- Tratamiento Datos Utilizar Sensible Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tratamiento_datos_utilizar_sensible', 'Tratamiento Datos Utilizar Sensible:') !!}
    {!! Form::number('tratamiento_datos_utilizar_sensible', null, ['class' => 'form-control']) !!}
</div>

<!-- Tratamiento Datos Publicar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tratamiento_datos_publicar', 'Tratamiento Datos Publicar:') !!}
    {!! Form::number('tratamiento_datos_publicar', null, ['class' => 'form-control']) !!}
</div>

<!-- Insert Ent Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insert_ent', 'Insert Ent:') !!}
    {!! Form::number('insert_ent', null, ['class' => 'form-control']) !!}
</div>

<!-- Insert Ip Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insert_ip', 'Insert Ip:') !!}
    {!! Form::text('insert_ip', null, ['class' => 'form-control']) !!}
</div>

<!-- Insert Fh Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insert_fh', 'Insert Fh:') !!}
    {!! Form::date('insert_fh', null, ['class' => 'form-control','id'=>'insert_fh']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#insert_fh').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Update Ent Field -->
<div class="form-group col-sm-6">
    {!! Form::label('update_ent', 'Update Ent:') !!}
    {!! Form::number('update_ent', null, ['class' => 'form-control']) !!}
</div>

<!-- Update Ip Field -->
<div class="form-group col-sm-6">
    {!! Form::label('update_ip', 'Update Ip:') !!}
    {!! Form::text('update_ip', null, ['class' => 'form-control']) !!}
</div>

<!-- Update Fh Field -->
<div class="form-group col-sm-6">
    {!! Form::label('update_fh', 'Update Fh:') !!}
    {!! Form::date('update_fh', null, ['class' => 'form-control','id'=>'update_fh']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#update_fh').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Id Entrevista Etnica Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_entrevista_etnica', 'Id Entrevista Etnica:') !!}
    {!! Form::number('id_entrevista_etnica', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('f_entrevistas.index') }}" class="btn btn-default">Cancel</a>
</div>
