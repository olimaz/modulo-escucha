# Acerca de
Elaborado con [Docker](https://docs.docker.com/), este repositorio contiene todo lo necesario para implementar una versión funcional del "Módulo de Escucha" utilizado por la Comisión de la Verdad de Colombia para el resguardo y gestión de sus entrevistas.

La imagen incluye todo lo necesario para implementar el aplicativo web mencionado sin necesidad de realizar instalaciones o configuraciones especiales.  El contenedor incluye lo siguiente:

- Servidor Web
- Servidor de Base de Datos
- Aplicativo
- Base de datos con información mínima

## ¿que es el módulo de escucha?
- Es un aplicativo elaborado para el resguardo y la gestión de las entrevistas realizadas por la Comisión de la Verdad.

- La documentación publicada por la Comisión de la Verdad se encuentra disponible en https://www.comisiondelaverdad.co/modulo-de-escucha

- La presente imagen se construye a partir del código fuente publicado en: https://gitlab.com/comisiondelaverdad/modulo-de-captura 

## Primeros pasos
Después de iniciar el contenedor docker, el usuario puede acceder al aplicativo con un navegador web, utilizando la siguiente dirección:

- http://localhost:8000/ 

La base de datos incluida contiene los datos mínimos para comprender el funcionamiento del aplicativo y de cuenta con un único usuario con privilegios de administrador que permite acceder a todas las funcionalidades disponible.  

Estas son las credenciales:
- usuario: ___sim@comisiondelaverdad.co___
- contraseña: ___123___

## Tecnología y componentes
Esta imagen ha sido creada con Docker y contiene lo siguiente:
1. Base de datos: Postgres 11
2. App Server: nginx
3. Lenguage: PHP v7.4
4. Framework:  Laravel versión 5.5

## Requisitos
Por tratarse de un contenedor Docker elaborado con teconologías Linux, la solución no requiere de mayores requisitos para una exploración inicial y podría funcionar en computadoras con prestaciones de uso común que como mínimo deberían cumplir con los requisitos que establece el propio Docker para su funcionamiento. Como referencia, la imagen fué creada y probada en una computadora Apple Machintosh con chip M1 y 16 GB RAM.

Sin embargo, para implementaciones de uso en producción, es importante comprender la cantidad de información a cargar y procesar y dimensionar los servidores de acuerdo a dichas consideraciones. 


## Algunos comandos útiles
1. ¿cómo iniciar todo?
- `docker-compose up -d` 
2. Para interactuar con el servidor de aplicaciones, (por ejemplo, correr comandos "php artisan"): 
- `docker exec -it cev-app /bin/bash`  


## Otras referencias
- Se incluye un archivo de transcripción como ejemplo del formato esperado.  Este archivo es generado a partir del aplicativo [oTranscribe](https://otranscribe.com/)
- También se incluye un archivo de etiquetado, el cual se genera desde el aplicativo [Dataturks](https://docs.dataturks.com/) 

## Anotaciones del creador
- Se agrega un archivo php.ini local para personalizaciones que pudieran ser necesarias
- Para aumentar el upload_size, tambien modificar el archivo de configuracion de nginx
- Se modificación del código fuente para deshabilitar la funcionalidad que agrega un marca de agua a los PDF
- Cambio en .env para deshabilitar el visor interno de pdf
- Se eliminó la referencia al repositorio del código fuente, para que se incluyan las librerías y todas las dependiencias necesarias sin necesidad de comandos especiales (composer update, npm install, etc.)



***

___imagen elaborada por oliver.mazariegos@gmail.com___
