@extends('layouts.app')

@section('content_header')
    @include('entrevista_individuals.filtros')


@endsection

@section('content')
    <h1 >Entrevistas individuales a víctimas, familiares o testigos <small> {{ $conteo }} entrevistas</small></h1>
        <div class="col-sm-10">
            <div class="box box-primary">
                <div class="box-body">
                    <div name='map' id='map' class="map"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="box box-primary">
                <div class="box-header">
                    Mostrar en el mapa
                </div>
                <div class="box-body">
                    <b>Lugar de la entrevista</b><br> {{-- El checked se detecta con el visible --}}
                    <label class="icheck-blue">
                        <input id="ch_entrevista" name="ch_entrevista" type="checkbox" class="minimal"  > Ubicaciones
                    </label>
                    <label class="icheck-blue">
                        <input id="ch_entrevista_cl" name="ch_entrevista_cl" type="checkbox" class="minimal"  > Agrupado
                    </label>
                    <label class="icheck-blue">
                        <input id="ch_entrevista_c" name="ch_entrevista_c" type="checkbox" class="minimal" > Mapa de calor
                    </label>

                    <hr>

                    <b>Lugar de los hechos</b><br>
                    <label class="icheck-red">
                        <input id="ch_hechos" name="ch_hechos" type="checkbox" class="minimal" > Ubicaciones
                    </label>
                    <label class="icheck-red">
                        <input id="ch_hechos_cl" name="ch_hechos_cl" type="checkbox" class="minimal"  > Agrupado
                    </label>
                    <label class="icheck-red">
                        <input id="ch_hechos_c" name="ch_hechos_c" type="checkbox" class="minimal"  > Mapa de calor
                    </label>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Información</h3>
                    <div class="box-tools pull-right">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
                        <button class="btn btn-xs btn-primary"  onclick='$("#info").html("");' >Limpiar</button>
                    </div>
                </div>
                <div class="box-body">
                    <div name='info' id='info'></div>
                </div>
            </div>
            @include("mapa.botones_capa")
        </div>

    {{-- Para el click --}}
    <div id='popup' class='ol-popup' style='width:150px'>
        <a href='#' id='popup-closer' class='ol-popup-closer'></a>
        <div id='popup-content'></div>
    </div>
@endsection

@include("mapa.js_base")


@push('js')
    @include('mapa.js_entrevistas')
    @include('mapa.js_munis')
    @include('mapa.js_deptos')
    @include('mapa.js_click')

        <script>
            $(document).ready(function(){
                $('.icheck-blue').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
                $('.icheck-red').iCheck({
                    checkboxClass: 'icheckbox_square-red',
                    radioClass: 'iradio_square-red',
                    increaseArea: '20%' // optional
                });
                //Detectar visibilidad capas de lugar de entrevsita
                if(individual_capa_entrevista.getVisible()) {
                    $("#ch_entrevista").iCheck('check');
                }
                else {
                    $("#ch_entrevista").iCheck('uncheck');
                }
                if(individual_capa_entrevista_cluster.getVisible()) {
                    $("#ch_entrevista_cl").iCheck('check');
                }
                else {
                    $("#ch_entrevista_cl").iCheck('uncheck');
                }
                if(individual_capa_entrevista_calor.getVisible()) {
                    $("#ch_entrevista_c").iCheck('check');
                }
                else {
                    $("#ch_entrevista_c").iCheck('uncheck');
                }

                //Detectar visibilidad capas de lugar de hechos
                if(individual_capa_hechos.getVisible()) {
                    $("#ch_hechos").iCheck('check');
                }
                else {
                    $("#ch_hechos").iCheck('uncheck');
                }
                if(individual_capa_hechos_cluster.getVisible()) {
                    $("#ch_hechos_cl").iCheck('check');
                }
                else {
                    $("#ch_hechos_cl").iCheck('uncheck');
                }

                if(individual_capa_hechos_calor.getVisible()) {
                    $("#ch_hechos_c").iCheck('check');
                }
                else {
                    $("#ch_hechos_c").iCheck('uncheck');
                }


                //Amarrar el icheck
                $("#ch_entrevista").on('ifToggled',function(){
                    var visible = $("#ch_entrevista").prop("checked");
                    individual_capa_entrevista.setVisible(visible);
                });
                $("#ch_entrevista_c").on('ifToggled',function(){
                    var visible = $("#ch_entrevista_c").prop("checked");
                    individual_capa_entrevista_calor.setVisible(visible);
                });
                $("#ch_entrevista_cl").on('ifToggled',function(){
                    var visible = $("#ch_entrevista_cl").prop("checked");
                    individual_capa_entrevista_cluster.setVisible(visible);
                });

                $("#ch_hechos").on('ifToggled',function(){
                    var visible = $("#ch_hechos").prop("checked");
                    individual_capa_hechos.setVisible(visible);
                });
                $("#ch_hechos_c").on('ifToggled',function(){
                    var visible = $("#ch_hechos_c").prop("checked");
                    individual_capa_hechos_calor.setVisible(visible);
                });
                $("#ch_hechos_cl").on('ifToggled',function(){
                    var visible = $("#ch_hechos_cl").prop("checked");
                    individual_capa_hechos_cluster.setVisible(visible);
                });

            });





        </script>
@endpush