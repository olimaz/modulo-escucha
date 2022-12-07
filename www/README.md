<p align="center"><img src="https://comisiondelaverdad.co/templates/cev-template/images/logo-cev.svg"></p>


## Módulo de escucha

El módulo de escucha es una aplicación web, que puede ser accedida desde cualquier parte del mundo, con altos niveles de seguridad, que permite resguardar todas las entrevistas realizadas por los compañeros de la Comisión de la Verdad a lo largo y ancho de Colombia, y alrededor del mundo.

### Funciones que el sistema proporciona
- La recolección de entrevistas: cargar entrevistas, metadatos (de identificación: fecha, lugar, duración, etc.; clasificación: núcleo, sector, etc.); y anexos (consentimientos informados, fichas, fotografías, recortes de prensa, etc.), todo lo cual consolida los datos cualitativos.

- Gestión transcripciones: permite distribuir el trabajo para el equipo de transcripción y etiquetado (tiene toda una lógica para la asignación y el seguimiento).

- Ficha digital: permite diligenciar la ficha de víctimas. Este instrumento, creado desde el equipo de esclarecimiento, contiene diferentes datos de la entrevista a víctimas susceptibles de ser cuantificados. El diligenciamiento se realiza posterior al trabajo de creación de entrevista que realizan los entrevistadores; es decir, posterior a la carga de la entrevista, los adjuntos y los metadatos.

- Repositorio de casos e informes: repositorio que permite almacenar documentos que otras entidades han aportado a la Comisión de la Verdad.

- Casos transversales: construcción de espacios compartidos y colaborativos para unificar consultas y documentos relacionados con un caso especial. Es una herramienta para los investigadores, con el fin de generar un inventario de los casos que lleva la Comisión.

- Los archivos en el exilio: inventario de los archivos que se encuentran por el resto del mundo, con el fin de saber en qué lugar se encuentran.


### Lenguajes de programación y versiones

- Lenguaje de programación PHP; versión 7.3

- Frameworks Laravel; versión 5.5

- jQuery (frontend); versión 3.5.1

- PostgreSQL (backend); versión 11.12

- Bootstrap (librería CSS); versión 4.6

# Notas del equipo de desarrollo
- No se utiliza el branch "master" como rama principal, sino que se utiliza "main" como branch principal
# Notas sobre la versión liviana
- La versión liviana se encuentra contenerizada con tecnología docker.  
- Para iniciarlo: docker-composer up -d
- docker exec -it cev-app /bin/bash
- \App\User::reset_clave_admin_local()
- Los archivos de la base de datos se mapean a la carpeta my-data
- Los archivos anexos, se enlazan con symlink 