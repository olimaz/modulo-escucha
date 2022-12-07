@extends('layouts.app3')

@section('content_header')

    <h1 class="page-header"></h1>

@endsection

@section('content')
    <div class="container">
        <h3 class="page-header"> Módulo de exploración de fichas</h3>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-primary">Presentación </h4>
                        <br>
                        <p class="card-text">La presente herramienta permite a los usuarios explorar las <b>fichas de entrevistas a víctimas</b> que fueron diligenciadas por cada una de las entrevistas realizadas y  procesadas por el SIM.  A enero del 2021, de un total de 12631 entrevistas registradas en el sistema, 9482 son entrevistas a víctimas familiares o testigos.
                        <p class="card-text">Tenga en cuenta que es posible que por una entrevista se haya registrado en el sistema más de una ficha, por lo cual, el número de fichas supera el número de entrevistas totales registradas en el sistema. </p>
                        <p class="card-text">La <span class="text-primary">exploración de fichas</span> es un complemento del Módulo de Captura que permite explorar directamente los <span class="text-primary">datos</span> que se extraen a partir de las fichas de entrevista a víctimas.  A través del uso de filtros el/la usuario/a puede explorar por cada ficha electrónica de víctimas, las siguientes secciones:</p>
                        <ol>
                            <li>Sección de la información de víctimas</li>
                            <li>Sección de la información de personas entrevistadas</li>
                            <li>Sección de la información de presuntos responsables individuales</li>
                        </ol>
                        <p class="card-text">La exploración que permite este módulo es de carácter cualitativo y específico. Para realizar análisis globales sobre el total de la información registrada en las fichas,  se sugiere consultar la sección <a href="{{ action('fichasController@stats') }}">estadísticas</a> o consultar directamente al equipo de analítica para que brinde el apoyo técnico requerido de acuerdo a las necesidades de la exploración de las entrevistas.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0 text-primary">Recomendaciones prácticas</h5>
                    </div>
                    <div class="card-body">

                        <p class="card-text">Dado el alcance del presente módulo, es importante tener presente los siguientes aspectos:</p>
                        <ol>
                            <li>Se recomienda comprender la diferencia entre cuantificaciones de víctimas, personas o hechos, para ello, puede utilizar  <a href="{{ action('fichasController@stats_comprension') }}" >la guía de explicación.</a></li>
                            <li>Este módulo se limita a las fichas de entrevistas a víctimas, por lo que no incluye el resto de entrevistas (AA, TC, PR, CO, EE, DC, HV).</li>
                            <li>Todas las entrevistas tienen metadatos, sin embargo, a la fecha (enero 2021) 1962 entrevistas (20%) no cuentan con ficha.  El equipo del SIM trabaja de manera constante para terminar el diligenciamiento de las fichas faltantes. La información sobre el avance de este proceso se puede consultar en la sección de <a href="{{ action('fichasController@stats') }}">estadísticas</a>.

                            </li>

                            <li>La especifidad de los <span class="text-success ">datos de las fichas</span> es superior a la información consignada en los <span class="text-success ">metadatos</span>. Por ejemplo:
                                <ul>
                                    <li>
                                        El lugar de los hechos en metadatos es una referencia general a la zona donde ocurrió el hecho/s narrado/s en el testimonio, mientras que, la ficha de la entrevista registra de manera específica el lugar por cada uno de los hechos concretos mencionados en el relato.
                                    </li>
                                    <li>
                                        El tipo de violencia en los metadatos es una referencia genérica a los tipos de violencia mencionados en  la entrevista; mientras que, en los datos de la ficha de la entrevista, ya se puede consultar los tipos y subtipos de violencia  por cada uno de los hechos narrados en el testimonio, especificando  el lugar y la fecha de ocurrencia, el nombre y cantidad de víctimas y las responsabilidades asociadas.
                                    </li>
                                    <li>
                                        En los metadatos, los actores armados son una referencia que permite conocer si son mencionados en el relato. En los datos, se especifica responsabilidad  por cada uno de hechos que son identificados con fechas y lugares específicos.
                                    </li>
                                </ul>
                            </li>
                        </ol>


                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col text-right">
            <i class="text-muted text-sm">
                Aplicativo elaborado por Oliver Mazariegos, con la colaboración (y paciencia) de Liliana Rincón.
            </i>

        </div>
    </div>
@endsection