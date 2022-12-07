<div class="clearfix"></div>
<div class="col-sm-12">
    <div class="box {{ count($hecho->rel_victima) == 0 ? ' box-danger ' : ' box-success ' }} box-solid">
        <div class="box-header ">
            <h3 class="box-title">3. Víctimas de este hecho</h3>
        </div>
        <div class="box-body no-padding">
            @if(count($hecho->rel_victima) == 0)
                <div class="text-yellow text-center">
                    <h4><i class="icon fa fa-warning"></i> Atención</h4>
                    No se ha seleccionado ninguna ficha de víctima
                </div>
            @else

                @include('hechos.t_victima')
{{--
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Otros nombres</th>
                        <th>Edad</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @include('hechos.t_victima')
                    </tbody>
                </table>
        --}}
            @endif

        </div>
        <div class="box-footer text-center">
            @if(count($hecho->rel_id_e_ind_fvt->arreglo_victimas()) > 0)
                <a href="#" class="btn btn-success" onclick="mostrar_agregar_victima()"><i class="fa fa-tag" aria-hidden="true"></i> Seleccionar víctima</a>
            @else
                <button type="button" class="btn btn-default" disabled="disabled">No hay información de víctimas</button>
            @endif
        </div>
    </div>
</div>
<div class="clearfix"></div>





{{-- Formulario para agregar una víctima --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_victima">
    <div class="modal-dialog " role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Añadir víctima al hecho</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        {!! Form::label('id_victima', 'Seleccione la víctima:') !!}
                        {!! Form::select('id_victima', $hecho->rel_id_e_ind_fvt->arreglo_victimas(true), null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-7">
{{--                        {!! Form::label('ocupacion', 'Ocupación al momento de los hechos:') !!}--}}
{{--                        {!! Form::text('ocupacion', null, ['class' => 'form-control']) !!}--}}
                        @include('controles.catalogo', ['control_control' => 'id_ocupacion'
                                        ,'control_default' => null
                                        ,'control_id_cat' => 500
                                        , 'control_requerido' => false
                                        , 'control_otro' => false
                                        ,'control_vacio' => '[Sin especificar]'
                                        ,'control_texto'=>'Ocupación al momento de los hechos:'])
                    </div>
                    <div class="form-group col-sm-5">
                        {!! Form::label('edad', 'Edad al momento de los hechos:') !!}
                        {!! Form::number('edad', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        @include('controles.geo3', ['control_control' => 'id_lugar_residencia'
                                    ,'control_texto' => 'Lugar de residencia en el momento de los hechos:'
                                    ,'control_select_2' => false
                                    , 'control_vacio' => '[Sin especificar]'
                                    , 'control_default'=>$hecho->id_lugar])
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        @include('controles.catalogo', ['control_control' => 'id_lugar_residencia_tipo'
                                                               ,'control_id_cat'=>45
                                                               , 'control_default'=>$hecho->id_lugar_residencia_tipo
                                                               , 'control_multiple' => false
                                                               , 'control_requerido' => true
                                                               ,'control_texto'=>'Zona:'])

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ url("victimas/create?id_e_ind_fvt=$hecho->id_e_ind_fvt&id_hecho=$hecho->id_hecho") }}" class="btn btn-default pull-left">Nueva víctima</a>
                <button type="button" class="btn btn-primary" onclick="agregar_victima()">Añadir al presente hecho</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="clearfix"></div>


@push("js")
    <script>
        function mostrar_agregar_victima() {
            $('#modal_victima').modal('show')
        }
        function agregar_victima() {
            if($("#id_lugar_residencia_tipo").val()==null) {
                alert("Debe especifidar la zona del lugar de residencia");
                return false;
            }
            var form_data = new FormData();
            form_data.append('id_hecho', {{$hecho->id_hecho}});
            form_data.append('id_victima', $("#id_victima").val());
            form_data.append('edad', $("#edad").val());
            //form_data.append('ocupacion', $("#ocupacion").val());
            form_data.append('id_ocupacion', $("#id_ocupacion").val());
            form_data.append('id_lugar_residencia', $("#id_lugar_residencia").val());
            form_data.append('id_lugar_residencia_depto', $("#id_lugar_residencia_depto").val());
            form_data.append('id_lugar_residencia_muni', $("#id_lugar_residencia_muni").val());
            form_data.append('id_lugar_residencia_tipo', $("#id_lugar_residencia_tipo").val());
            form_data.append('_token', '{{csrf_token()}}');
            $.ajax({
                url: "{{url('hecho/victima/agregar')}}",
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