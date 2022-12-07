

<div class="col-xs-4">
    <div class="form-group ">
        @if($ultimo->id_adjunto > 0)
            {!! Form::hidden('id_adjunto',$ultimo->id_adjunto) !!}
            @include('controles.carga_archivo', ['control_control' => 'archivo_20'
                                , 'control_default' => $ultimo->fmt_edita_soporte
                                   , 'control_texto'=>"<i class='fa fa-file-pdf-o' aria-hidden='true'></i> Soporte/Autorización "])
        @else

            @include('controles.carga_archivo', ['control_control' => 'archivo_20'
                                   , 'control_texto'=>"<i class='fa fa-file-pdf-o' aria-hidden='true'></i> Soporte/Autorización"])
        @endif
    </div>
</div>
<div class="col-xs-8">
    <!-- Id Autorizador Field -->


    <div class="form-group col-xs-12">
        @include('controles.entrevistador_todos', ['control_control' => 'id_autorizado'
                            , 'control_mi_mismo'=>false
                            ,'control_texto'=>'Se autoriza el acceso al siguiente entrevistador:'])
    </div>
    <div class="form-group col-xs-12">
        @include('controles.fecha_rango_futuro', ['control_control' => 'fecha_rango'
                                        ,'control_default' => $ultimo->fecha_rango
                                        ,'control_requerido' => true
                                        ,'control_texto'=>'Período en que autoriza el acceso (se incluyen los extremos):'])
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('id_autorizador', 'Nombre de quien autoriza') !!}
        <br>
        {{ \Auth::user()->name }}
    </div>

    <div class="form-group col-xs-6">
        {!! Form::label('entrevista_codigo', 'Código de la entrevista:') !!}
        {!! Form::text('entrevista_codigo', null, ['class' => 'form-control ','required'=>'required','minlength'=>12]) !!}

    </div>
    <div class="form-group col-xs-12 text-center">
        <button type="submit" class="btn btn-success">Autorizar acceso</button>
    </div>

</div>

<div class="clearfix"></div>



@push("js")
    <script>
        $( "#id_autorizado" ).change(function() {
            document.location = '{{ Request::url() }}' + '?id_autorizado=' + $("#id_autorizado").val();
        });
    </script>

@endpush



@include("partials.js_frm_reservado_acceso")