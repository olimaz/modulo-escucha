@extends('layouts.app')


@section('content')

<h1 class="page-header">Criterios de priorización para la transcripción de entrevistas</h1>

<p>
    Con el fin de identificar el orden de transcripción de las entrevistas realizadas por la Comisión de la Verdad en los distintos lugares del país y nodos establecidos en el exterior; se ha dispuesto un mecanismo que permite ordenarlas y priorizarlas de acuerdo al nivel de detalle que tengan las entrevistas a criterio del documentador/a que realizó la entrevista.
</p>
<p>
    La priorización es un número que indica el nivel de detalle de las entrevistas respecto a 6 aspectos.  Este número tiene un valor máximo de 100 puntos, el cual es calculado según los siguientes criterios.
</p>

<ol>
    <li>Fluidez: 10%</li>
    <li>Detalle de los hechos: 20%</li>
    <li>Detalle del contexto: 20%</li>
    <li>Detalle de los impactos: 20%</li>
    <li>Detalle de acceso a la justicia e iniciativas de no repetición: 20%</li>
    <li>Cierre final: 10%</li>
</ol>

Una puntuación de 100 indica prioridad alta, mientras que una puntuación de 0 indica baja prioridad. Estos son los criterios utilizados:
<br>
<br>
<dl>
    <dt>Fluidez</dt>
    <dd>A partir de la experiencia del entrevistador/a se busca identificar aquellas entrevistas en las cuales el diálogo con la persona intrevistada haya sido fluido permitiendo un relato amplio de la experiencia. </dd>
    <dd>Opciones:
        <ul>
            <li>Sí: 10 puntos</li>
            <li>No: 0 puntos</li>
        </ul>
    </dd>

    <dt>Detalle de los hechos</dt>
    <dd>A partir de la experiencia del entrevistador/a se busca identificar aquellas entrevistas que contengan mayor nivel de detalle respecto a los hechos. </dd>
    <dd>Opciones:
        <ul>
            <li>Hace mención. 1 punto.</li>
            <li>Detalle bajo. 2 puntos.</li>
            <li>Describe datos mínimos. 3 puntos.</li>
            <li>Detalle de la información alto. 4 puntos.</li>
            <li>Ofrece explicaciones. 5 puntos</li>
        </ul>
    </dd>


    <dt>Detalle del contexto</dt>
    <dd>A partir de la experiencia del entrevistador/a se busca identificar aquellas entrevistas que contengan mayor nivel de detalle respecto al contexto en el que ocurrieron los hechos víctimizantes.</dd>

    <dd>Opciones:
        <ul>
            <li>Hace mención. 1 punto.</li>
            <li>Detalle bajo. 2 puntos.</li>
            <li>Describe datos mínimos. 3 puntos.</li>
            <li>Detalle de la información alto. 4 puntos.</li>
            <li>Ofrece explicaciones. 5 puntos</li>
        </ul>
    </dd>

    <dt>Detalle de los impactos</dt>
    <dd>A partir de la experiencia del entrevistador/a se busca identificar aquellas entrevistas que contengan mayor nivel de detalle respecto a los impactos generados por los hechos víctimizantes y/o sobre el afrontamiento de la experiencia victimizante. </dd>
    <dd>Opciones:
        <ul>
            <li>Hace mención. 1 punto.</li>
            <li>Detalle bajo. 2 puntos.</li>
            <li>Describe datos mínimos. 3 puntos.</li>
            <li>Detalle de la información alto. 4 puntos.</li>
            <li>Ofrece explicaciones. 5 puntos</li>
        </ul>
    </dd>

    <dt>Detalle de acceso a la justicia e iniciativas de no repetición</dt>
    <dd>A partir de la experiencia del entrevistador/a se busca identificar aquellas entrevistas que contengan mayor nivel de detalle respecto a los temas de garantías de no repetición y acceso a la justicia.</dd>
    <dd>Opciones:
        <ul>
            <li>Hace mención. 1 punto.</li>
            <li>Detalle bajo. 2 puntos.</li>
            <li>Describe datos mínimos. 3 puntos.</li>
            <li>Detalle de la información alto. 4 puntos.</li>
            <li>Ofrece explicaciones. 5 puntos</li>
        </ul>
    </dd>

    <dt>Cierre final</dt>
    <dd>A partir de la experiencia del entrevistador/a se busca identificar aquellas entrevistas en las cuales se haya realizado un cierre tranquilo y positivo para la persona entrevistada</dd>
    <dd>Opciones:
        <ul>
            <li>Sí: 10 puntos</li>
            <li>No: 0 puntos</li>
        </ul>
    </dd>
</dl>



@endsection