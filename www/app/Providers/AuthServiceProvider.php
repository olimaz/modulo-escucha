<?php

namespace App\Providers;

use App\Models\rol_entrevistador;
use App\Models\transcribir_asignacion;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('nivel-1', function ($user) {
            return $user->id_nivel == 1 ;
        });
        Gate::define('nivel-2', function ($user) {
            return $user->id_nivel == 2;
        });
        Gate::define('nivel-3', function ($user) {
            return $user->id_nivel == 3;
        });
        Gate::define('nivel-4', function ($user) {
            return $user->id_nivel == 4;
        });
        Gate::define('nivel-5', function ($user) {
            return $user->id_nivel == 5;
        });
        Gate::define('nivel-6', function ($user) {
            return $user->id_nivel == 6;
        });
        Gate::define('revisar-nivel', function ($user,$nivel) {
            return $user->id_nivel == $nivel;
        });

        Gate::define('revisar-m-nivel', function ($user,$a_nivel=array()) {
            return in_array($user->id_nivel, $a_nivel) ;
        });

        //Para el menu
        Gate::define('nivel-1-2', function ($user) {
            return in_array($user->id_nivel,[1,2]);
        });
        //Para el menu
        Gate::define('nivel-jefes', function ($user) {
            return in_array($user->id_nivel,[1,2,10]);
        });
        //Sin restricciones de investigador
        Gate::define('nivel-1-2-super', function ($user) {
            $entrevistador = $user->rel_entrevistador;
            if($entrevistador) {
                if(in_array($user->id_nivel,[1,2])) {
                    return $entrevistador->solo_lectura == 2;
                }
            }
            else {
                return false;
            }

        });
        //Para los filtros
        Gate::define('nivel-1-2-3', function ($user) {
            return in_array($user->id_nivel,[1,2,3]);
        });
        //Para los niveles 3 y 4
        Gate::define('es-propio', function ($user,$id) {
            if($user->id_entrevistador == $id) {  //Respuesta automática
                return true;
            }
            else {
                $entrevistador = $user->rel_entrevistador;
                if($entrevistador) {
                    //dd(in_array($id,$entrevistador->a_nombre_de));
                    return in_array($id,$entrevistador->a_nombre_de);
                }
            }
            return false;
        });
        Gate::define('misma-macro', function ($user,$id) {
            return $user->id_macroterritorio == $id;
        });
        Gate::define('misma-territorial', function ($user,$id) {
            return $user->id_territorio == $id;
        });

        Gate::define('mismo-grupo', function ($user,$id) {
            if($user->id_grupo > 1) {
                return $user->id_grupo==$id;
            }
        });
        Gate::define('grupo-cev', function ($user) {
            return $user->id_grupo == 1;
        });
        //Afirmativo para niveles 1,2,3,4
        Gate::define('nivel-superior', function ($user) {
            return in_array($user->id_nivel,[1,2,3,4]);
        });
        //Para el boton de agregar en nombre de otro, aplica a niveles 3y4
        Gate::define('coordinador', function ($user) {
            return in_array($user->id_nivel,[3,4]);
        });
        //Para que no modifiquen usuarios de niveles superiores
        Gate::define('nivel-igual-inferior', function ($user,$id) {
            return $user->id_nivel <= $id;
        });
        //Perfil de investigador, usado en el can del config  adminlte
        Gate::define('solo-lectura', function ($user) {
            return $user->solo_lectura==1;
        });
        //Para los authorize de los controles
        Gate::define('escritura', function ($user) {
            return $user->solo_lectura<>1;
        });

        //Para los usuarios tipo 7 que solo miran estadisticas y no pueden hacer nada mas
        Gate::define('solo-estadistica', function ($user) {
            return $user->id_nivel == 7;
        });
        //Para el menu
        Gate::define('nivel-1-al-6', function ($user) { //Todos menos estadistica
            if(config('expedientes.permisos_legado')) {
                return true;
            }
            else {
                return in_array($user->id_nivel,[1,2,3,4,5,6]);
            }

        });
        Gate::define('nivel-1-al-6-trans', function ($user) { //Todos menos estadistica, con transcriptores
            if(config('expedientes.permisos_legado')) {
                return true;
            }
            else {
                return in_array($user->id_nivel, [1, 2, 3, 4, 5, 6, 10, 11]);
            }
        });
        Gate::define('procesamiento', function ($user) { //Para las opciones del menú de procesamiento
            if(config('expedientes.sistema_abierto')) {
                return in_array($user->id_nivel,[1,2,3,4,5,6,10,11]);
            }
            else {
                return false;
            }

        });

        //Para el menu
        Gate::define('nivel-10-al-11', function ($user) { //Transcriptores
            return in_array($user->id_nivel,[1,10,11]);
        });
        //Para bloquear descargas
        Gate::define('puede-descargar', function ($user) {
            return in_array($user->id_nivel,[1,6,10,11]);  //Admin, transcriptores, comisionados
        });
        Gate::define('nivel-10', function ($user) { //Jefe de Transcriptores
            return in_array($user->id_nivel,[1,10]);
        });
        Gate::define('seguimiento', function ($user) { //Jefe de Transcriptores
            //return in_array($user->id_nivel,[1,10]);
            $entrevistador = $user->rel_entrevistador;
            if($entrevistador) {
                if(in_array($user->id_nivel,[1,2])) {
                    return $entrevistador->solo_lectura == 2;
                }
                else {
                    return in_array($user->id_nivel,[10,11]);
                }
            }
            else {
                return false;
            }
        });


        Gate::define('nivel-11', function ($user) { //Transcriptorer
            return in_array($user->id_nivel,[11]);
        });


        Gate::define('transcriptor', function ($user) { //Transcriptorer
            return in_array($user->id_nivel,[11]);
        });


        Gate::define('investigador', function ($user) { //Enrevistadores
            return $user->solo_lectura == 1;
        });



        Gate::define('grupo-ajeno', function ($user) { //Miembros de ruta pacifica, oim, etc.
            return $user->id_grupo > 1;
        });

        Gate::define('comisionado', function ($user) { //Enrevistadores
            return $user->id_nivel == 6;
        });

        //Temporal, para ocultar la funcionalidad de casos
        Gate::define('mis-casos', function ($user) { //Enrevistadores
            //return in_array($user->id_entrevistador, config('expedientes.mis_casos'));
            return true;  //todos tienen acceso desde el 27/ago

        });
        Gate::define('rol-tesauro', function ($user) { //Enrevistadores
            if($user->id_nivel == 1) { //los administradores, siempre
                return true;
            }
            else {
                return rol_entrevistador::tiene_rol($user->id_entrevistador,1);
            }
        });
        Gate::define('rol-reporte-entrevistados', function ($user) { //Enrevistadores

            //Pruebas: filtrar solo los propios
            //return true;
            //
            if($user->id_nivel == 1) { //los administradores, siempre
                return true;
            }
            elseif($user->id_nivel == 6) { //los comisionados, siempre
                return true;
            }
            else {
                return rol_entrevistador::tiene_rol($user->id_entrevistador,2);
            }
        });
        Gate::define('rol-descarga', function ($user) { //Rol para los chicos de OIM que puedan descargar
            if($user->id_nivel == 1) { //los administradores, siempre
                return true;
            }
            elseif($user->id_nivel == 10) { //Coordinador de transcriptores
                return true;
            }
            else {
                return rol_entrevistador::tiene_rol($user->id_entrevistador,3);
            }
        });

        //Descarga de transcripciones, botón ubicado hasta abajo de los resultados de la buscadora
        Gate::define('rol-descarga-transcripciones', function ($user) { //Rol para los chicos de OIM que puedan descargar
            return rol_entrevistador::tiene_rol($user->id_entrevistador,5);
        });

        Gate::define('crear-R1', function ($user) { //Rol para los chicos de OIM que puedan descargar
            if($user->id_nivel == 1) { //los administradores, siempre
                return true;
            }
            elseif($user->id_nivel == 6) { //los comisionados, siempre
                return true;
            }

            return false;

        });

        //Para pruebas iniciales
        Gate::define('rol-censo', function ($user) { //Enrevistadores
            if($user->id_nivel == 1) { //los administradores, siempre
                return true;
            }
            else {
                return rol_entrevistador::tiene_rol($user->id_entrevistador,4);
            }
        });

        //Para los gestores de datos, que necesitan reproducir audios de entrevistas transcritas
        Gate::define('rol-reproduccion', function ($user) { //Enrevistadores
            if($user->id_nivel == 1) { //los administradores, siempre
                return true;
            }
            else {
                return rol_entrevistador::tiene_rol($user->id_entrevistador,6);
            }
        });


        //WRAPER, cierre del sistema
        Gate::define('sistema-abierto', function () { //Enrevistadores
            return config('expedientes.sistema_abierto');
        });
        //Para no estar negando, mejor uso este gate que es más explícito
        Gate::define('sistema-cerrado', function () { //Enrevistadores
            return !config('expedientes.sistema_abierto');
        });
        //Para el login
        Gate::define('login-local', function () { //Utilizar active directory/gmail
            return config('expedientes.login_local');
        });
        //Para los permisos de legado
        Gate::define('permisos-legado', function () { //Permisos basados en calificación de anexos
            return config('expedientes.permisos_legado');
        });
        //Acceder adjunto
        Gate::define('permiso-acceso', function ($user,$adjunto) { //Enrevistadores
            if($user->id_nivel==1) {
                return true;
            }
            elseif($user->id_nivel==101) {
                if($adjunto->id_calificacion==1) {
                    return true;
                }
                else {
                    return false;
                }
            }
            elseif($user->id_nivel==102) {
                if($adjunto->id_calificacion <= 2) {
                    return true;
                }
                else {
                    return false;
                }
            }
            elseif($user->id_nivel==103) {
                if($adjunto->id_calificacion <= 3) {
                    return true;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        });


    }
}
