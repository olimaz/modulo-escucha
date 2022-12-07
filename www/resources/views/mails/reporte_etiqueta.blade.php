<h2>Reporte de etiqueta mal aplicada</h2>
<p>Este es un mensaje enviado desde el módulo de captura, para informar de un hallazgo identificado por el usuario <strong>{{ $nombre }}</strong>.</p>
<h3>Reporte:</h3>

<ul>
    <li>Etiqueta aplicada: <span style="color:blue">{!! $etiqueta !!}</span> </li>
    <li>Párrafo referido: <span style="color:blue">{!! nl2br($parrafo) !!} </span></li>
    <li>Sugerencia del usuario: <span style="color:blue"> <i>{!! nl2br($comentarios) !!}</i></span></li>
</ul>
<br>
<hr>
<p>
    <b>Nota: </b>Debido a la limitada capacidad de reprocesamiento del SIM, el envío de este mensaje no implica que la etiqueta sea corregida; sin embargo este reporte es de suma utilidad para corregir malas interpretaciones y evitar que este tipo de errores se repitan en el futuro.
</p>