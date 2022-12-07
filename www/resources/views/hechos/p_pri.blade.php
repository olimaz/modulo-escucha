<div class="clearfix"></div>
<div class="col-sm-12">
    <div class="box box-solid box-success">
        <div class="box-header ">
            @if ($hecho->tipo_expendiente=='individual')
                <h3 class="box-title">4a. Presuntos responsables individuales de este hecho</h3>
            @else
                <h3 class="box-title">2a. Presuntos responsables individuales de este hecho</h3>     
            @endif            
        </div>
        <div class="box-body no-padding">
            @if(count($hecho->rel_responsable) == 0)
                <div class="text-yellow text-center">
                    <h4><i class="icon fa fa-warning"></i> Atención</h4>
                    No se ha seleccionado ninguna ficha de presunto responsable individual
                </div>
            @else
                @include("hechos.p_responsable")
            @endif

        </div>
        <div class="box-footer text-center">
            {{-- @if(count($hecho->rel_id_e_ind_fvt->arreglo_responsables()) > 0) --}}
            @if(count($hecho->expediente()->arreglo_responsables()) > 0)            
                <a href="#" class="btn btn-success" onclick="mostrar_agregar_responsable()"><i class="fa fa-tag" aria-hidden="true"></i> Seleccionar presunto responsable</a>
            @endif            
                <a href="{{ url('persona_responsable/create')."?$hecho->campo_id_tipo_entrevista=$hecho->id_entrevista&id_hecho=$hecho->id_hecho" }}" class="btn btn-default "><i class="fa fa-user-secret"></i> Agregar presunto responsable individual</a>
                {{-- <a href="{{ url('persona_responsable/create')."?id_e_ind_fvt=$hecho->id_e_ind_fvt&id_hecho=$hecho->id_hecho" }}" class="btn btn-default "><i class="fa fa-user-secret"></i> Agregar presunto responsable individual</a> --}}
        </div>
    </div>
</div>
<div class="clearfix"></div>


{{-- Formulario para agregar una víctima --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_responsable">
    <div class="modal-dialog " role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Añadir presunto responsable individual al hecho</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        {!! Form::label('id_persona_responsable', 'Seleccione el presunto responsable individual:') !!}
                        {{-- {!! Form::select('id_persona_responsable', $hecho->rel_id_e_ind_fvt->arreglo_responsables(), null, ['class' => 'form-control']) !!} --}}
                        {!! Form::select('id_persona_responsable', $hecho->expediente()->arreglo_responsables(), null, ['class' => 'form-control']) !!}
                        
                    </div>

                </div>
            </div>
            <div class="modal-footer">                
                <a href="{{ url("persona_responsable/create?$hecho->campo_id_tipo_entrevista=$hecho->id_entrevista&id_hecho=$hecho->id_hecho") }}" class="btn btn-default ">Agregar nuevo responsable</a>
                {{-- <a href="{{ url("persona_responsable/create?id_e_ind_fvt=$hecho->id_e_ind_fvt&id_hecho=$hecho->id_hecho") }}" class="btn btn-default ">Agregar nuevo responsable</a> --}}
                <button type="button" class="btn btn-primary pull-left" onclick="agregar_responable()">Añadir al presente hecho</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="clearfix"></div>



@push("js")
    <script>
        function mostrar_agregar_responsable() {
            $('#modal_responsable').modal('show')
        }
        function agregar_responable() {
            var form_data = new FormData();
            form_data.append('id_hecho', {{$hecho->id_hecho}});
            form_data.append('id_persona_responsable', $("#id_persona_responsable").val());
            form_data.append('_token', '{{csrf_token()}}');
            $.ajax({
                url: "{{url('hecho/responsable/agregar')}}",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data) {
                    document.location.reload();
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>
@endpush
