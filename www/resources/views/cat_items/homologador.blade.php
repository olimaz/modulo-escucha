{{-- Permite corregir preguntas abiertas --}}

@extends('layouts.app')

@section("content_header")
    <h1 class="page-header">
        Homologación de respuestas a preguntas derivadas
    </h1>
    <h4>La homologación sustituye un valor por otro y es una acción irreversible</h4>

@endsection

@section('content')
    <div class="box box-default">
        <div class="box-header">
            <form method="get" action="#" id="frm_select">

                <div class="form-group col-sm-6">
                    @include('controles.criterio_fijo', ['control_control' => 'id_campo'
                                                           ,'control_default' => $id_campo
                                                           ,'control_grupo' => 75
                                                           //,'control_vacio' => '[Ninguno]'
                                                           ,'control_texto'=>'Seleccione el campo a homologar:'])
                </div>
                <div class="form-group col-sm-6">
                    {!! Form::label('fecha', 'Mostrar valores ingresados a partir de esta fecha:') !!}
                    {!! Form::text('fecha' , $fecha, ['class' => 'form-control pull-right datepicker2','data-value'=>$fecha]) !!}

                </div>
            </form>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th width="20px">#</th>
                        <th>Respuesta </th>
                        <th width="50px">Ocurrencias</th>
                        @can('sistema-abierto')
                            <th width="50px">Acción</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @php($i = $listado->firstItem())
                    @foreach($listado as $fila)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $fila->campo }}</td>
                            <td class="text-center">{{ $fila->conteo }}</td>
                            @can('sistema-abierto')
                            <td><button class="btn btn-primary" type="button" onclick = "modificar('{{ addslashes($fila->campo) }}')">Modificar</button></td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="no-print">
                {!! $listado->appends(Request::all())->render() !!}
            </div>
        </div>
    </div>

    {{-- POPUP --}}
    <div class="modal fade" id="modal_homologar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open( ['action' => ['cat_catController@homologar_update',$id_campo],'id'=>'frm_filtro']) !!}
                <input type="hidden" name="antiguo" id="antiguo" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modificar todas las ocurrencias de una respuesta  </h4>
                    </div>
                    <div class="modal-body">


                        <div class="form-group col-sm-12">
                            <label for="antiguo_2">Valor actual</label>
                            <input type="text" name="antiguo_2" id="antiguo_2" value="" disabled class="form-control">
                        </div>
                        <div class="form-group col-sm-12">
                            @include('controles.autofill', ['control_control' => 'nuevo'
                                           ,'control_url' => $ruta_ajax
                                           ,'control_requerido' => true
                                           ,'control_resaltar' => false
                                           ,'control_max' => 250
                                           ,'control_texto'=>'Sustituirlo por este valor:'])

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Aplicar este cambio, que es irreversible</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>





@endsection

@push("js")
    <script>
        var control = $('#id_campo').select2();
        control.on('select2:select', function (e) {
            $("#frm_select").submit();
            //console.log("Toma!");
        });

        function modificar(texto) {
            $("#antiguo").val(texto);
            $("#antiguo_2").val(texto);
            $("#nuevo").val(null);
            $('#modal_homologar').modal('show')
        }
    </script>

    <script>
        const onChange = formattedValue => {
            console.log('New value:', formattedValue)
        }
        $( document ).ready(function() {
            $("#fecha").on('pickadate:onSet', onChange)
        });
    </script>


    @push("js")
        <script>
            var tmp_fecha =
                $('#fecha').pickadate({
                    onSet: function(context) {
                        $("#frm_select").submit();
                    },
                    selectMonths: true // Creates a dropdown to control month
                    , selectYears: 75 // Creates a dropdown of 15 years to control year
                    //The format to show on the `input` element
                    , format: 'dd-mmmm-yyyy'   //Como se muestra al usuario
                    , formatSubmit: 'yyyy-mm-dd',  //IMPORTANTE: para el submit
                    //The title label to use for the month nav buttons
                    labelMonthNext: 'Mes siguiente',
                    labelMonthPrev: 'Mes anterior',
                    //The title label to use for the dropdown selectors
                    labelMonthSelect: 'Elegir mes',
                    labelYearSelect: 'Elegir año',
                    //Months and weekdays
                    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                    //Materialize modified
                    weekdaysLetter: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                    //Today and clear
                    today: 'Hoy',
                    clear: 'Limpiar',
                    close: 'Cerrar',
                    //Limites
            });

            var picker_fecha = tmp_fecha.pickadate('picker');



        </script>
    @endpush
@endpush