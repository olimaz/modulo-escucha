@extends('layouts.app')
@section('content_header')
    <h2>
        Descargar información en formato de  MS Excel
    </h2>
    <h4>Genera archivo de excel con metadatos obtenidos a partir de la información disponible en el sistema</h4>
@endsection

@section('content')
        @include('flash::message')
            <div class="col-xs-12">


                <table class="table table-bordered">
                    <tr>
                        <td colspan="2">
                            <h4>Metadatos de entrevistas</h4>
                        </td>
                    </tr>
                    @can('nivel-1')
                        <tr style="vertical-align: center">
                            <td> <a id='descarga_vi' href="{{ action('entrevista_individualController@excel_plano') }}" class="btn btn-lg btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Entrevistas individuales</a></td>

                            <td ><span class="text-primary">Cada fila es una entrevista. <br> Se incluyen las entrevistas a Víctimas Familiares y Testigos (VI), Actores Armados (AA) y Terceros Civiles (TC).</span></td>

                        </tr>
                    @endcan
                    <tr style="vertical-align: center">

                        <td> <a id='descarga_vi_anom' href="{{ action('entrevista_individualController@excel_plano_anonimo') }}" class="btn btn-lg btn-default"><i class="fa fa-download" aria-hidden="true"></i> Entrevistas individuales (anonimizado)</a></td>

                        <td ><span class="text-primary">Cada fila es una entrevista. <br> Se incluyen las entrevistas a Víctimas Familiares y Testigos (VI), Actores Armados (AA) y Terceros Civiles (TC). Se ocultan ciertas columnas para garantizar la anonimización de los datos.</span></td>

                    </tr>
                    {{--
                    <tr style="vertical-align: center">
                        <td>
                            <a id='descarga_2' href="{{ action('entrevista_individualController@excel_dinamica') }}" class="btn btn-lg btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Dinámicas</a>
                        </td>
                        <td>
                            <span class="text-primary">Cada fila es una dinámica; una entrevista puede duplicarse según la cantidad de dinámicas identificadas en la misma.</span>
                        </td>

                    </tr>
                    --}}
                    @can('nivel-1')
                        <tr style="vertical-align: center">
                            <td >
                                <a id='descarga_pr' href="{{ action('entrevista_profundidadController@excel_plano') }}" class="btn btn-lg btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Entrevistas a profundidad</a>
                            </td>
                            <td style="vertical-align: center"><span class="text-primary">Cada fila es una entrevista.</span></td>

                        </tr>
                    @endcan
                    <tr style="vertical-align: center">
                        <td >
                            <a id='descarga_pr_anom' href="{{ action('entrevista_profundidadController@excel_plano_anonimo') }}" class="btn btn-lg btn-default"><i class="fa fa-download" aria-hidden="true"></i> Entrevistas a profundidad (anonimizado)</a>
                        </td>
                        <td style="vertical-align: center"><span class="text-primary">Cada fila es una entrevista. Se ocultan ciertas columnas para garantizar la anonimización de los datos.</span></td>

                    </tr>
                    @can('nivel-1')
                        <tr>
                            <td >
                                <a id='descarga_ee' href="{{ action('entrevista_etnicaController@descargar_excel') }}" class="btn btn-lg btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Entrevistas a sujeto colectivo</a>
                            </td>
                            <td style="vertical-align: center"><span class="text-primary">Cada fila es una entrevista.</span></td>

                        </tr>
                    @endcan
                    <tr>
                        <td >
                            <a id='descarga_ee_anom' href="{{ action('entrevista_etnicaController@descargar_excel_anonimo') }}" class="btn btn-lg btn-default"><i class="fa fa-download" aria-hidden="true"></i> Entrevistas a sujeto colectivo (anonimizado)</a>
                        </td>
                        <td style="vertical-align: center"><span class="text-primary">Cada fila es una entrevista. Se ocultan ciertas columnas para garantizar la anonimización de los datos.</span></td>

                    </tr>
                    <tr>
                        <td >
                            <a id='descarga_ci' href="{{ action('casos_informesController@excel_plano') }}" class="btn btn-lg btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Casos e informes</a>
                        </td>
                        <td ><span class="text-primary">Cada fila es un caso o informe</span></td>

                    </tr>
                    @can('nivel-1')
                    <tr>
                        <td >
                            <a id='descarga_todo' href="{{ action('entrevista_individualController@excel_integrado') }}" class="btn btn-lg btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Integrado de todas las entrevistas</a>
                        </td>
                        <td ><span class="text-primary">Se incluyen los 8 instrumentos en una sola tabla. <br>Cada fila es una entrevista.</span></td>

                    </tr>
                    @endcan
                    <tr>
                        <td >
                            <a id='descarga_todo_anonimo' href="{{ action('entrevista_individualController@excel_integrado_anonimo') }}" class="btn btn-lg btn-default"><i class="fa fa-download" aria-hidden="true"></i> Integrado de todas las entrevistas (anonimizado)</a>
                        </td>
                        <td ><span class="text-primary">Se incluyen los 8 instrumentos en una sola tabla. <br>Cada fila es una entrevista. Se ocultan ciertas columnas para garantizar la anonimización de los datos.</span></td>

                    </tr>
                    @can('sistema-abierto')
                    @can('nivel-1')
                        <tr>
                            <td >
                                <a id='descarga_todo_anulados' href="{{ action('entrevista_individualController@excel_integrado_monitoreo') }}" class="btn btn-lg btn-danger"><i class="fa fa-download" aria-hidden="true"></i> Integrado de todas las entrevistas</a>
                            </td>
                            <td ><span class="text-primary">Para uso de monitoreo, se incluyen las entrevistas anuladas.  <br>Se incluyen los 8 instrumentos.</span></td>

                        </tr>
                    @endcan
                    @endcan
                    <tr>
                        <td colspan="2">
                            <h4>Fichas</h4>
                        </td>
                    </tr>

                    @can('nivel-1')
                        <tr>
                            <td >
                                <a  href="{{ action('entrevista_individualController@descargar_excel_ficha_persona_entrevistada') }}" class="btn btn-lg btn-info"><i class="fa fa-download" aria-hidden="true"></i> Fichas de personas entrevistadas</a>
                            </td>
                            <td ><span class="text-primary">Disponible para entrevistas que se ha diligenciado la información. Cada fila es una entrevista.</span></td>

                        </tr>
                    @endcan
                        <tr>
                            <td >
                                <a  href="{{ action('entrevista_individualController@descargar_excel_ficha_persona_entrevistada_anonimo') }}" class="btn btn-lg btn-default"><i class="fa fa-download" aria-hidden="true"></i> Fichas de personas entrevistadas (anonimizado)</a>
                            </td>
                            <td ><span class="text-primary">Disponible para entrevistas que se ha diligenciado la información. Cada fila es una entrevista.</span></td>

                        </tr>
                    @can('nivel-1')
                    <tr>
                        <td >
                            <a  href="{{ action('entrevista_individualController@descargar_excel_ficha_victima') }}" class="btn btn-lg btn-info"><i class="fa fa-download" aria-hidden="true"></i> Fichas de víctima</a>
                        </td>
                        <td ><span class="text-primary">Disponible para entrevistas que se ha diligenciado la información. Cada fila es una víctima,</span> <span class="text-danger">de momento no incluye información del hecho.</span></td>
                    </tr>
                    @endcan
                    <tr>
                        <td >
                            <a  href="{{ action('entrevista_individualController@descargar_excel_ficha_victima_anonimo') }}" class="btn btn-lg btn-default"><i class="fa fa-download" aria-hidden="true"></i> Fichas de víctima (anonimizado)</a>
                        </td>
                        <td ><span class="text-primary">Disponible para entrevistas que se ha diligenciado la información. Cada fila es una víctima,</span> <span class="text-danger">de momento no incluye información del hecho.</span></td>
                    </tr>
                    <tr>
                        <td >
                            <a  href="{{ url('storage/fichas_exilio.xlsx')  }}" class="btn btn-lg btn-info"><i class="fa fa-download" aria-hidden="true"></i> Información de exilio</a>
                        </td>
                        <td ><span class="text-primary">Disponible para entrevistas que se ha diligenciado la información del exilio. Cada fila es un evento de exilio.</span></td>
                    </tr>
                    <tr>
                        <td >
                            <a  href="{{ action('exilioController@descargar_exilio_salida') }}" class="btn btn-lg btn-info"><i class="fa fa-download" aria-hidden="true"></i> Información de exilio: primera salida</a>
                        </td>
                        <td ><span class="text-primary">Disponible para entrevistas que se ha diligenciado la información. Cada fila corresponde a una salida del país.</span> </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <h4>Otros</h4>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <a  href="{{ action('excel_entrevistaController@descargar_excel_nvivo') }}" class="btn btn-lg btn-success"><i class="fa fa-download" aria-hidden="true"></i> Clasificador para NVIVO</a>
                        </td>
                        <td ><span class="text-primary">Similar al integrado de entrevistas, con formato para su uso en NVIVO</td>
                    </tr>


                        <tr>
                            <td >
                                <a id='descarga_ut' href="{{ action('statController@descargar_uso_tesauro') }}" class="btn btn-lg btn-success"><i class="fa fa-download" aria-hidden="true"></i> Aplicación del etiquetado</a>
                            </td>
                            <td ><span class="text-primary">Por cada entrevista, se indica la cantidad de veces que se aplica una etiqueta en particular. Cada fila es un una entrevista</span></td>

                        </tr>


                    @can('sistema-abierto')
                        <tr>
                            <td >
                                <a id='descarga_6' href="{{ action('entrevista_individualController@descargar_excel_seguminiento') }}" class="btn btn-lg btn-warning"><i class="fa fa-download" aria-hidden="true"></i> Seguimiento a entrevistas</a>
                            </td>
                            <td ><span class="text-primary">Cada fila es un reporte de seguimiento a entrevistas</span></td>

                        </tr>


                        @can('nivel-1')
                        <tr>
                            <td >
                                <a id='descarga_7' href="{{ action('entrevistadorController@descargar_excel') }}" class="btn btn-lg btn-warning"><i class="fa fa-users" aria-hidden="true"></i> Usuarios del sistema</a>
                            </td>
                            <td ><span class="text-primary">Se incluyen todos los usuarios y sus respectivos perfiles</span></td>

                        </tr>
                        @endcan

                        <tr>
                            <td >
                                <a id='descarga_11' href="{{ action('adjuntoController@excel_calificacion') }}" class="btn btn-lg btn-info"><i class="fa fa-paperclip" aria-hidden="true"></i> Calificación de adjuntos</a>
                            </td>
                            <td ><span class="text-primary">Se incluyen todos los archivos adjuntos para entrevistas y casos e informes</span></td>

                        </tr>
                    @endcan




                </table>
                <br>
                <br>
                <p><b>Nota: </b>El contenido de las descargas puede diferir levemente con los últimos datos cargados en el sistema, ya que los  exceles son calculados y generados en procesos nocturnos.</p>
            </div>


@endsection
