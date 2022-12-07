@extends('layouts.app')

@section('content')

<h1 class="page-header">Preguntas más frecuentes (P+F) <br><small>Módulo de carga de entrevistas</small></h1>

<a href="https://capacitacion.comisiondelaverdad.co/sim/captura.html" class="btn btn-success">
    <i class="fa fa-hand-o-right" aria-hidden="true"></i> Video tutoriales de ayuda y referencia
</a>
<br>
<br>
<br>
<dl>
    <dt>Necesito ayuda, ¿con quién me puedo comunicar?</dt>
    <dd>Puede escribir un correo a <a href="mailto:ayuda.SIM@comisiondelaverdad.co" class="text-primary">ayuda.SIM@comisiondelaverdad.co</a> o comunicarse por Whatsapp al 350-524-6095. </dd>
    <dt> ¿Cuál es mi número de entrevistador/a? </dt>
    <dd>
        El sistema asigna el número de entrevistador/a conforme los entrevistadores/as se registran en el aplicativo y completan su perfil.  Al completar el perfil, se muestra una confirmación en la que se indica el número de entrevistadora.
        Adicionalmente, puede consultarse de dos formas:
        <ul>
            <li>En la esquina superior derecha, donde se muestra el nombre del usuario, al
                desplegar el menú, en la parte final izquierda se indica el número de
                entrevistador/a.</li>
            <li>En el menú lateral, en la opción <a href="{{ url("/ver_perfil") }}">“Mi perfil”</a> se puede acceder a todos los detalles del usuario, incluyendo el número de entrevistador asignado.</li>
        </ul>
    </dd>
    <dt>Acabo de registrarme, ¿Por qué no veo ninguna entrevista?</dt>
    <dd>El auto registro inicial otorga inicialmente el perfil de entrevistador (ver matriz de perfiles al final de esta página).   Si desea ampliar este acceso debe comunicarse con  <a href="mailto:leonardo.sarmiento@comisiondelaverdad.co" class="text-primary">Leonardo.Sarmiento@comisiondelaverdad.co</a> y solicitar el perfil que le corresponda.</dd>

    <dt>Deseo acceder a alguna entrevista R3 o R2, ¿qué hago?</dt>
    <dd>Comunicarse por correo con <a href="mailto:leonardo.sarmiento@comisiondelaverdad.co" class="text-primary">Leonardo.Sarmiento@comisiondelaverdad.co</a> y solicitar instrucciones. </dd>


    <dt>¿Puedo agregar más de dos documentos para un mismo tipo de archivo?</dt>
    <dd>Sí.  En la creación  de la entrevista se puede cargar un archivo por cada tipo de adjunto. Al finalizar la creación de la entrevista con sus archivos iniciales, se puede utilizar la opción de “Gestionar archivos adjuntos” (disponible en el listado de entrevistas como un botón con un ícono de clip), en el cual se pueden adjuntar todos los archivos se consideren necesarios.</dd>

    <dt>¿Puedo crear un entrevista sin todos los  adjuntos? </dt>
    <dd>Sí, aunque no es lo recomendable.  El sistema emite una alerta la cual deberá confirmarse y se procede a crear la entrevista. Posteriormente se pueden adicionar archivos mediante la opción “Gestionar archivos adjuntos” (disponible en el listado de entrevistas como un botón con un ícono de clip). </dd>

    <dt>¿Cuál es mi usuario y mi clave? </dt>
    <dd>El sistema utiliza sus credenciales del correo institucional para identificarle.  Debe ingresar al correo para autenticarse y posteriormente, el aplicativo solicitará su autorización para acceder a sus datos del correo institucional.  No se requiere de clave, ya que se utilizan sus credenciales del correo.  Si desea cerrar sesión en el aplicativo, deberá cerrar sesión en el correo institucional. </dd>

    <dt>¿Puedo borrar un entrevista ya creada?</dt>
    <dd>No.  todas las entrevistas creadas se graban para siempre.  Esto es debido a que es importante mantener un registro del número correlativo asignado a cada entevista.  Los usuarios con permisos de supervisores, tienen la opción de anular una entrevista.</dd>

    <dt>Si por error ingresé un anexo dentro del entrevista ¿Qué puedo hacer? </dt>
    <dd>En el listado de entrevistas se encuentra la opción de "Gestionar archivos adjuntos", la cual permite además de agregar nuevos adjuntos, eliminar alguno de los archivos anexos. </dd>

    <dt>¿Puedo llenar la ficha en diferentes momentos sin perder la información ya cargada?</dt>
    <dd>No.  La ficha debe completarse en un sólo momento y queda almacenada hasta que se presiona el botón "Grabar ficha".  Posteriormente puede modificarla o agregar/quitar archivos anexos.</dd>

    <dt>¿Puedo seleccionar varios actores o tipos de violencia?</dt>
    <dd>Sí.  Simplemente seleccione cuantos actores considere necesario y el control se irá llenando con los elegidos.</dd>

    <dt>¿Cómo es la seguridad del sistema?</dt>
    <dd>El aplicativo funciona en base a roles de usuario.  Todos los usuarios que se registran, reciben el rol con el menor nivel de permisos: el de estadística, quien únicamente puede consultar las cifras del sistema y algunos documentos de referencia. Todos los usuarios nuevos deben solicitar el cambio de su perfil, de acuerdo al rol que le corresponda.</dd>



</dl>




@include("entrevistadors.privilegios")

<div class="clearfix"></div>
<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">
            Tabla de clasificación de expedientes
        </h3>
    </div>
    <div class="box-body">
        <p>Todas las entrevistas son consieradas como información reservada.  Para uso interno de la comisión, esta reserva se clasifica como  R-2, R-3 o R-4 con el objetivo de <span class="text-danger">proteger la identidad de las personas entrevistadas</span>.</p>
        <p>Para acceder a entrevistas R-3 y R-2 se cuenta con procedimientos normados por el Grupo de Acceso a la Información y para efectos del presente sistema, son implementados por el equipo de monitoreo.</p>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Nivel</th>
                <th>Descripción</th>
                <th>Uso</th>
            </tr>
            </thead>
            <tbody>

            <tr>
                <td>R-2</td>
                <td>Reserva judicial</td>
                <td>
                    <ul>
                        <li>Expedientes con reserva judicial</li>
                        <li>Reconocimiento de responsabilidades</li>
                    </ul>
                </td>

            </tr>
            <tr>
                <td>R-3</td>
                <td>Violencia sexual y NNA</td>
                <td>
                    <ul>
                        <li>Entrevista NNA</li>
                        <li>Entrevista de violencia sexual</li>
                    </ul>
                </td>

            </tr>
            <tr>
                <td>R-4</td>
                <td>Acceso general</td>
                <td>
                    <ul>
                        <li>Nivel mínimo de clasificación</li>
                        <li>Aplica a las entrevistas que no se encuentran en las anteriores excepciones</li>

                    </ul>
                </td>

            </tr>
            </tbody>
        </table>

    </div>
</div>
<h3></h3>



<p class="text-right"><i>Aplicativo elaborado por Oliver Mazariegos, con la colaboración (y paciencia) de <span title="I.C." data-toggle="tooltip">Liliana Rincón</span>.</i></p>

@endsection