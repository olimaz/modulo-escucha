@extends('layouts.app3')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="far fa-lightbulb"></i> Víctimas, hechos, personas:  Diferentes unidades de conteo, diferentes cifras.
            </h2>
        </div>
        <div class="card-body">
            <h5 class="text-primary">Las estadísticas del módulo de captura</h5>
            <p>
                Las estadísticas de datos extraidos a partir de la fichas de entrevistas a víctimas familiares o testigos,  presentadas en el módulo de captura se construyen a partir de la <span class="text-primary bg-yellow">cantidad de víctimas cuyos datos son conocidos</span>.  La razón de esta elección es reducir -en la medida de lo posible- la cantidad de datos desconocidos registrados en las distribuciones estadísticas.
            </p>
            <p>
                A pesar de que se utiliza la cifra correspondiente a víctimas de datos conocidas, puede que haya datos que permanezcan sin especificarse al momento de diligenciar las fichas (ejemplo: edad al momento de los hechos), por lo que es de esperar que inclusive a pesar de utilizar los datos de víctima conocidas, en las tablas de datos se muestre información correspondiente a categorías especificadas como "Sin especificar" o "Desconocido.
            </p>
            <p>
                <strong class="text-danger">Importante: </strong>En todo momento debe considerarse que las cifras presentadas en este espacio son preliminares ya que son obtenidas con los datos recién capturados, por lo que no deben ser consideradas como definitivas, ya que pueden presentar algunos cambios respecto a las cifras presentadas por el grupo de analítica, como consecuencia del proceso estadístico de limpieza y depuración de datos.  Adicionalmente, las cifras de analítica generalmente se realizan sobre información disponible a una fecha específica, generalmente el final del mes anterior (fecha de corte).

            </p>
            <h5>Diferentes cifras, diferentes cálculos</h5>
            <p>Debido a que existen diferentes unidades de conteo (hechos, víctimas, personas), es importante que quien realice análisis cuantitativos tenga presente en todo momento a qué tipo de unidad se refiere y las implicaciones del mismo.</p>
            <p>Mantener presente la diferencia entre cada valor es importante cuando se realizan análisis cuantitativos.</p>

            <h5 class="text-primary">¿Por qué estas cifras son diferentes?, ¿Es lo mismo hechos, víctimas y personas?</h5>
            <p>Conceptualmente, no es lo mismo contar eventos de violencia (hechos), victimizaciones (personas que sufren una violencia específica) o personas, por lo que estas cifras no representan necesariamente lo mismo.
            Para comprender mejor esta diferencia, consideremos la siguiente síntesis de un relato ficticio:</p>

            <p><i>
                    Vicente relata cómo él y un grupo de amigos fueron torturados y  amenazados de muerte en mayo de 2010, por parte de un grupo armado debido a su participación en un sindicato particular.
                    Vicente relata que en ese entonces se amenazó específicamente a un grupo de 10 personas (él incluido), aunque Vicente recuerda únicamente algunos datos personales de 2 de ellos (Fernando y Lucía).
                    <br>
                    En el año 2012, debido a que continuó con su actividad sindical, fue víctima de acoso (seguimientos intensos en su vida diaria) especialmente en el mes de octubre y en noviembre, un grupo desconocido lo golpeó, lo ató de pies y manos y lo sumergió en un tanque de agua; luego de esto, lo dejaron abandonado, creyendo que había muerto.
                    El 10 de diciembre de ese mismo año, temiendo por su vida, se desplazó a otra región del país junto a Vilma (esposa), Virgilio (hijo) y Margarita (hija). <br>
                </i>
            </p>
            <br>
            <h5>De este relato, se extraen las siguientes cifras:</h5>
            <div class="container">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                    <tr>
                        <th>Unidad de conteo</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Desglose</th>
                        <th>Distribución por sexo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Personas entrevistadas</td>
                        <td>Cantidad de personas que presentaron un relato a la Comisión.</td>
                        <td class="text-center">1</td>
                        <td>Vicente</td>
                        <td>
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <td>Masculino</td>
                                    <td>1</td>
                                    <td>100%</td>

                                </tr>
                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td>Hechos de violencia</td>
                        <td>Cantidad de eventos de violencia, ocurridos en la misma fecha, lugar y a las mismas víctimas. </td>
                        <td class="text-center">4</td>
                        <td>
                            <ol>
                                <li>Tortura física y amenaza de muerte a los sindicalistas en mayo del 2010</li>
                                <li>Tortura psicológica a Vicente en octubre del 2012</li>
                                <li>Tortura física a Vicente en noviembre del 2012</li>
                                <li>Desplazamiento de la familia de Viciente el  10 de diciembre del 2012</li>
                            </ol>
                        </td>
                        <td> Los hechos no pueden especificarse por sexo.  Lo que se clasifica por sexo son las victimizaciones (ver siguientes unidades de conteo).  </td>
                    </tr>
                    <tr>
                        <td>Cantidad de víctimas (victimizaciones)</td>
                        <td>Cantidad de violencia ejercida contra personas específicas.</td>
                        <td class="text-center">26</td>
                        <td>
                            <ul>
                                <li>10 víctimas de  amenza al derecho a la vida en el 2010</li>
                                <li>10 víctimas de  tortura física en el 2010</li>
                                <li>1 víctima de  tortura psicológica en octubre 2012</li>
                                <li>1 víctima de  tortura física en noviembre 2012</li>
                                <li>4 víctimas de  desplazamiento forzado en diciembre del 2012</li>
                            </ul>
                        </td>
                        <td>
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <td>Masculino</td>
                                    <td>8</td>
                                    <td>31%</td>

                                </tr>
                                <tr>
                                    <td>Femenino</td>
                                    <td>4</td>
                                    <td>15%</td>

                                </tr>
                                <tr>
                                    <td>Desconocido</td>
                                    <td>14 </td>
                                    <td>54%</td>

                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>26</td>
                                    <td>100%</td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td ><span class="text-primary">Cantidad de víctimas cuyos datos son conocidos</span></td>
                        <td>Cantidad de violencia ejercida contra personas específicas y respecto de las cuales las narraciones hechas a la Comisión constantan datos personales de las víctimas, tales como nombre, edad, sexo, entre otros. </td>
                        <td class="text-center">12</td>
                        <td>
                            <ul>
                                <li>6 víctimas de  amenza y tortura del 2010 (Vicente y los dos nombres que recuerda)</li>
                                <li>1 víctima de  tortura psicológica en octubre 2012 (Vicente)</li>
                                <li>1 víctima de  tortura física en noviembre 2012 (Vicente)</li>
                                <li>4 víctimas de de desplazamiento forzado en diciembre del 2012 (Esposa e hijos de Vicente)</li>
                            </ul>
                        </td>
                        <td>
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <td>Masculino</td>
                                    <td>8</td>
                                    <td>67%</td>

                                </tr>
                                <tr>
                                    <td>Femenino</td>
                                    <td>4</td>
                                    <td>33%</td>

                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>12</td>
                                    <td>100%</td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>Personas</td>
                        <td>Diferentes individuos que sufrieron violencia </td>
                        <td class="text-center">13</td>
                        <td>
                            <ul>
                                <li>Vicente</li>
                                <li>Fernando (compañero del sindicato)</li>
                                <li>Lucía (compañero del sindicato)</li>
                                <li>otros 7 compañeros/as del sindicato cuyos datos personales son desconocidos</li>
                                <li>Vilma (esposa de Vicente)</li>
                                <li>Margarita (hija de Vicente)</li>
                                <li>Virgilio (hijo de Vicente)</li>
                            </ul>
                        </td>
                        <td>
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <td>Masculino</td>
                                    <td>3</td>
                                    <td>23%</td>

                                </tr>
                                <tr>
                                    <td>Femenino</td>
                                    <td>3</td>
                                    <td>23%</td>

                                </tr>
                                <tr>
                                    <td>Desconocido</td>
                                    <td>7 </td>
                                    <td>54%</td>

                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>13</td>
                                    <td>100%</td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    </tbody>

                </table>

            </div>
            <br>
            <br>
            <br>

            <h5>Visualmente, la línea de tiempo de este relato sería así</h5>



            {{-- Linea de tiempo: inicio --}}
            <div class="container">
                @include("pages.timeline_sample")
            </div>
            {{-- Linea de tiempo: fin --}}












        </div>
    </div>



@endsection