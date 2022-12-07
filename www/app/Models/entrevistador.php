<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Support\Facades\Request;

/**
 * Class entrevistador
 * @package App\Models
 * @version April 12, 2019, 8:40 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection esclarecimiento.eIndFvts
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_entrevistador
 * @property integer id_macroterritorio
 * @property integer id_territorio
 * @property integer id_usuario
 * @property integer numero_entrevistador
 * @property integer id_ubicacion
 * @property integer id_grupo
 * @property integer id_nivel
 * @property integer solo_lectura
 */
class entrevistador extends Model
{

    public $table = 'esclarecimiento.entrevistador';
    protected $primaryKey = 'id_entrevistador';
    
    public $timestamps = false;



    public $fillable = [
        'id_macroterritorio',
        'id_territorio',
        'id_usuario',
        'numero_entrevistador',
        'id_ubicacion',
        'id_grupo',
        'id_nivel',
        'solo_lectura'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_entrevistador' => 'integer',
        'id_macroterritorio' => 'integer',
        'id_territorio' => 'integer',
        'id_usuario' => 'integer',
        'numero_entrevistador' => 'integer',
        'id_ubicacion' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

        'id_territorio' => 'required',
        //'numero_entrevistador' => 'required|min:1',
        'id_ubicacion' => 'required'
    ];

    //Para la autenticacion local
    public static $rules_local = [
        'name' => 'required',
        'email' => 'required|email',
        'id_nivel' => 'required',
        'password' => 'required|min:6'
    ];


    //Relaciones
    public function rel_usuario() {
        return $this->belongsTo(User::class,'id_usuario','id');
    }
    public function rel_macroterritorio() {
        return $this->belongsTo(cev::class,'id_macroterritorio','id_geo');
    }
    public function rel_territorio() {
        return $this->belongsTo(cev::class,'id_territorio','id_geo');
    }
    public function rel_geo() {
        return $this->belongsTo(geo::class,'id_ubicacion','id_geo');
    }
    public function rel_grupo() {
        return $this->belongsTo(criterio_fijo::class,'id_grupo','id_opcion')->where('criterio_fijo.id_grupo',5);
    }
    public function rel_acceso() {
        return $this->hasMany(entrevistador_acceso::class,'id_entrevistador','id_entrevistador');
    }
    //Asignación de transcripciones
    public function rel_asignacion() {
        return $this->hasMany(transcribir_asignacion::class,'id_transcriptor','id_entrevistador');
    }
    //Asignación de transcripciones
    public function rel_asignacion_etiquetado() {
        return $this->hasMany(etiquetar_asignacion::class,'id_transcriptor','id_entrevistador');
    }
    //Registro de aceptación de compromiso con la reserva
    public function rel_compromiso() {
        return $this->hasMany(entrevistador_compromiso::class,'id_entrevistador','id_entrevistador');
    }

    //Formatos
    //Para el dataturk, me dice el correo asociado, lo inventa si es necesario
    public function getCorreoAttribute() {
        $u = $this->rel_usuario;
        $correo=null;
        if(empty($u->email)) {
            $correo = $u->username."@comisiondelaverdad.co";
        }
        else {
            $correo = $u->email;
        }
        return $correo;
    }
    //Para cuando necesite desplegar el nombre
    public function getNombreAttribute() {
        $u = $this->rel_usuario;
        return $u->name;

    }

    public function getFmtIdMacroterritorioAttribute() {
        $cual =$this->rel_macroterritorio;
        if($cual){
            return $cual->descripcion;
        }
        else {
            return "Sin Especificar";
        }
    }
    public function getFmtIdTerritorioAttribute() {
        $cual =$this->rel_territorio;
        if($cual){
            return $cual->descripcion;
        }
        else {
            return "Sin Especificar";
        }
    }
    public function getFmtIdNivelAttribute() {
        $niveles = \Gate::check('login-local') ? 400 : 4 ;
        $cual = criterio_fijo::where('id_grupo',$niveles)->where('id_opcion',$this->id_nivel)->first();
        if($cual){
            return $cual->descripcion;
        }
        else {
            return "Sin Especificar";
        }
    }
    public function getFmtIdGrupoAttribute() {
        return criterio_fijo::describir(5,$this->id_grupo);
    }
    public function getFmtIdUbicacionAttribute() {
        $cual =$this->rel_macroterritorio;
        if($cual){
            return geo::nombre_completo($this->id_ubicacion);
        }
        else {
            return "Sin Especificar";
        }
    }

    public function getFmtNumeroEntrevistadorAttribute() {
        return  str_pad(intval($this->numero_entrevistador), 3, "0", STR_PAD_LEFT);
    }
    public function getFmtNombreAttribute(){
        $usuario=$this->rel_usuario;
        if($usuario) {
            return $this->rel_usuario->name;
        }
        else {
            return "Sin Especificar";
        }
    }
    public function getFmtNumeroNombreAttribute(){
        $usuario=$this->rel_usuario;
        if($usuario) {
            return $this->fmt_numero_entrevistador." - ".$this->rel_usuario->name;
        }
        else {
            return "Sin Especificar";
        }
    }
    public static function describir($id_entrevistador) {
        $quien = self::find($id_entrevistador);
        if($quien) {
            return $quien->fmt_numero_nombre;
        }
        else {
            return "Entrevistador ($id_entrevistador) desconocido";
        }
    }
    public function getFmtCorreoAttribute(){
        $usuario=$this->rel_usuario;
        if($usuario) {
            return $this->rel_usuario->email;
        }
        else {
            return "Desconocido";
        }

    }
    public function getFmtGrupoAttribute(){
        $detalle=$this->rel_grupo;
        if($detalle) {
            return $detalle->descripcion;
        }
        else {
            return "Desconocido ($this->id_grupo)";
        }

    }

    public function getFmtInvestigadorAttribute() {
        return $this->solo_lectura == 1 ? "Sí" : "No";
    }
    //Entrevistas realizadas
    public function getConteoEntrevistasAttribute() {
        return intval(entrevista_individual::id_entrevistador($this->id_entrevistador)->id_subserie(config('expedientes.vi'))->id_activo(1)->count());
    }
    public function getConteoEntrevistasAAAttribute() {
        return intval(entrevista_individual::id_entrevistador($this->id_entrevistador)->id_subserie(config('expedientes.aa'))->id_activo(1)->count());
    }
    public function getConteoEntrevistasTCAttribute() {
        return intval(entrevista_individual::id_entrevistador($this->id_entrevistador)->id_subserie(config('expedientes.tc'))->id_activo(1)->count());
    }
    public function getConteoEntrevistasCOAttribute() {
        return intval(entrevista_colectiva::id_entrevistador($this->id_entrevistador)->id_activo(1)->count());
    }
    public function getConteoEntrevistasEEAttribute() {
        return intval(entrevista_etnica::id_entrevistador($this->id_entrevistador)->id_activo(1)->count());
    }
    public function getConteoEntrevistasPRAttribute() {
        return intval(entrevista_profundidad::id_entrevistador($this->id_entrevistador)->id_activo(1)->count());
    }
    public function getConteoEntrevistasDCAttribute() {
        return intval(diagnostico_comunitario::id_entrevistador($this->id_entrevistador)->id_activo(1)->count());
    }
    public function getConteoEntrevistasHVAttribute() {
        return intval(historia_vida::id_entrevistador($this->id_entrevistador)->id_activo(1)->count());
    }

    //Para la edición
    public function getIdGrupoAccesoArregloAttribute() {
        $arreglo=array();
        foreach($this->rel_acceso as $acceso) {
            $arreglo[]=$acceso->id_grupo_acceso;
        }
        return $arreglo;
    }
    //Para el formulario que asigna accesos a otros grupos (nivel)
    public function getIdNivelAccesoAttribute() {
        //Ver si ya tiene acceso
        $hijo = $this->rel_acceso()->first();
        if(isset($hijo->id_nivel)) {
            return $hijo->id_nivel;
        }
        if($this->id_nivel<=2) {
            return 2;
        }
        elseif($this->id_nivel==3) {
            return 3;
        }
        else {
            return 4;
        }
    }

    //Busqueda rapida
    public static function scopeBR($query,$criterio="") {
        $criterio=trim($criterio);
        if(is_numeric($criterio) and intval($criterio)>0) {
            $query->where('numero_entrevistador',$criterio);
        }
        elseif(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $where[]="users.email ilike '%$criterio%'";
            $where[]="users.username ilike '%$criterio%'";
            $where[]="users.name ilike '%$criterio%'";

            $str_where=implode(" or ",$where);
            $query->join('users','entrevistador.id_usuario','=','users.id')
                ->whereraw("( $str_where )");

        }
    }


    //Scopes
    public static function scopeOrdenar($query) {
        $query->join('users as uo','esclarecimiento.entrevistador.id_usuario','=','uo.id')
                ->orderby('uo.name');
    }
    // Para mostrar un listado de usuarios, me sirve mostrar los habilitados.
    // Pero para mostrar un listado de entrevista, no importa si el usuario está habilitado
    // Con el segundo parámetro, se facilita programar esta excepción
    // Para el listado de usuarios de administrador, sirve mostrar todos, incluso los confidenciales.
    //  Para el listado de entrevistas sirve mostrar todos, pero no lo confidenciales
    public static function scopeHabilitados($query, $todos=false, $confidenciales=false, $confidenciales_ajenos=false) {

        $par['todos']=$todos;
        $par['conf']=$confidenciales;
        $par['conf_ajenos']=$confidenciales_ajenos;

        //dd($par);
        //Nunca los confidenciales
        if(!$confidenciales) {
            $query->where('id_nivel','<>',6);
        }
        else {  //Solo los confidenciales propios
            if(!$confidenciales_ajenos) {
                $yo = \Auth::user()->id_entrevistador;
                $otros_confidenciales=entrevistador::where('id_nivel',6)
                    ->where('id_entrevistador','<>',\Auth::user()->id_entrevistador)
                    ->pluck('id_entrevistador')->toArray();
                $query->whereNotIn('id_entrevistador',$otros_confidenciales);
            }

        }

        if(!$todos) {
            $query->where('id_nivel','<>',99);
        }
    }
    //Para aplicar filtros según el prefil
    public static function scopePermitidos($query) {
        $nivel=99;
        if(\Auth::check()) {
            $logeado = \Auth::user();
            if($logeado->rel_entrevistador) {
                $nivel=$logeado->rel_entrevistador->id_nivel;
            }

            //Aplicar reglas
            if($nivel>=5 && $nivel<=6) { //Entrevistador/confidencial
                $query->where('id_entrevistador',$logeado->rel_entrevistador->id_entrevistador);
            }
            elseif($nivel==4) { //Territorio
                $query->where('id_territorio',$logeado->rel_entrevistador->id_territorio);
            }
            elseif($nivel==3) { //Supervisor: del mismo grupo
                $query->where('id_macroterritorio',$logeado->rel_entrevistador->id_macroterritorio);
            }
            elseif($nivel==1 || $nivel==2 || $nivel==7) {
                // no hay filtros para administrador/esclarecimiento/estadistica
            }
        }
        else {
            $query->where('id_entrevistador',-1); //ninguno
        }

    }


    //Me devuelve un arreglo con id_entrevistador permitido
    // Utilizado para el scopeAcceso y para otras validaciones, como el listado items.
    //  Este arreglo es la base de todos los permisos
    public static function permitidos_acceso_old($id_usuario=null) {
        if(is_null($id_usuario)) {
            $usuario=\Auth::user();
        }
        else {
            $usuario=User::find($id_usuario);
        }
        $nivel=99;
        $arreglo_entrevistadores=array();
        if(isset($usuario->id)) {
            $entrevistador = $usuario->rel_entrevistador;
            //Identificar los que le tocan según su nivel y grupo
            if (in_array($entrevistador->id_nivel, [1,2,3,7,6]) ) {
                if($entrevistador->id_nivel == 6) {
                    //$listado = entrevistador::habilitados(true,true);
                }
                else {
                    $listado = entrevistador::habilitados(true,false);  //este parametro hace la diferencia para que se muestren incluso los deshabilitdados
                }
                $listado = entrevistador::where('id_nivel', '>=', $entrevistador->id_nivel);  //todos los del mismo nivel o menor
                if ($entrevistador->id_grupo > 1) {
                    $listado->where('id_grupo', $usuario->id_grupo);
                }
                $arreglo_entrevistadores = $listado->pluck('id_entrevistador')->toArray();
            } elseif ($entrevistador->id_nivel == 3) {
                $listado = entrevistador::habilitados()
                    ->where('id_macroterritorio', $usuario->id_macroterritorio);
                if ($entrevistador->id_grupo > 1) {
                    $listado->where('id_grupo', $usuario->id_grupo);
                }
                $arreglo_entrevistadores = $listado->pluck('id_entrevistador')->toArray();
            } elseif ($entrevistador->id_nivel == 4) {
                $listado = entrevistador::habilitados()
                    ->where('id_territorio', $usuario->id_territorio);
                if ($entrevistador->id_grupo > 1) {
                    $listado->where('id_grupo', $usuario->id_grupo);
                }
                $arreglo_entrevistadores = $listado->pluck('id_entrevistador')->toArray();
            } elseif (in_array($entrevistador->id_nivel, [5,6])) {
                $arreglo_entrevistadores = [$entrevistador->id_entrevistador];
            }


            // Identificar los que le tocan si tiene acceso a grupo  (esta condición no restringe, sino que amplía)
            foreach ($entrevistador->rel_acceso as $grupo) {
                if ($grupo->id_nivel==2 ) {  //Grupo entero
                    $criterios = entrevistador::habilitados()
                        ->where('id_entrevistador', '<>', $entrevistador->id_entrevistador)
                        ->where('id_grupo', $grupo->id_grupo_acceso);

                    $listado = $criterios->pluck('id_entrevistador')->toArray();
                    $arreglo_entrevistadores = array_merge($listado, $arreglo_entrevistadores);
                }
                elseif ($grupo->id_nivel == 3) {  //Mismo macroterritorio
                    $criterios = entrevistador::habilitados()
                        ->where('id_macroterritorio', $usuario->id_macroterritorio)
                        ->where('id_entrevistador', '<>', $entrevistador->id_entrevistador)
                        ->where('id_grupo', $grupo->id_grupo_acceso);

                    $listado = $criterios->pluck('id_entrevistador')->toArray();
                    $arreglo_entrevistadores = array_merge($listado, $arreglo_entrevistadores);
                }
                elseif ($grupo->id_nivel == 4 ) {  //Mismo territorio
                    $criterios = entrevistador::habilitados()
                        ->where('id_territorio', $usuario->id_territorio)
                        ->where('id_entrevistador', '<>', $entrevistador->id_entrevistador)
                        ->where('id_grupo', $grupo->id_grupo_acceso);
                    $listado = $criterios->pluck('id_entrevistador')->toArray();
                    $arreglo_entrevistadores = array_merge($listado, $arreglo_entrevistadores);

                }
            }
        }

        return $arreglo_entrevistadores;
    }
    //Versión simplificada
    public static function permitidos_acceso($id_usuario=null) {
        if(is_null($id_usuario)) {
            $usuario=\Auth::user();
        }
        else {
            $usuario=User::find($id_usuario);
        }
        $nivel=99;
        $arreglo_entrevistadores=array();
        if(isset($usuario->id)) {

            //Filtros por macro, territorio, etc.
            $entrevistador = $usuario->rel_entrevistador;
            if (in_array($entrevistador->id_nivel, [1,2]) && $entrevistador->solo_lectura <> 1) {
                $listado = entrevistador::habilitados(true,true);
            }
            elseif($entrevistador->id_nivel == 3 && $entrevistador->solo_lectura <> 1) {
                $listado = entrevistador::habilitados()
                    ->where('id_macroterritorio', $usuario->id_macroterritorio);
            }
            elseif($entrevistador->id_nivel == 4 && $entrevistador->solo_lectura <> 1) {
                $listado = entrevistador::habilitados()
                    ->where('id_territorio', $usuario->id_territorio);
            }
            else {  //Solo el entrevistador
                $listado = entrevistador::habilitados()
                    ->where('id_entrevistador', $usuario->id_entrevistador);
            }

            //Filtro por grupo
            if ($entrevistador->id_grupo > 1) {
                $listado->where('id_grupo', $usuario->id_grupo);
            }

            //Sacar el listado
            $arreglo_entrevistadores = $listado->pluck('id_entrevistador')->toArray();


            //Ampliar el listado con los grupos a los que se les dió acceso (ruta pacifica, etc.)

            //dd($entrevistador);
            //dd($entrevistador->rel_acceso);

            // Identificar los que le tocan si tiene acceso a grupo  (esta condición no restringe, sino que amplía)
            foreach ($entrevistador->rel_acceso as $grupo) {
                if ($grupo->id_nivel==2 ) {  //Grupo entero
                    $criterios = entrevistador::habilitados()
                        ->where('id_entrevistador', '<>', $entrevistador->id_entrevistador)
                        ->where('id_grupo', $grupo->id_grupo_acceso);

                    $listado = $criterios->pluck('id_entrevistador')->toArray();
                    //dd($listado);
                    $arreglo_entrevistadores = array_merge($listado, $arreglo_entrevistadores);
                }
                elseif ($grupo->id_nivel == 3) {  //Mismo macroterritorio
                    $criterios = entrevistador::habilitados()
                        ->where('id_macroterritorio', $usuario->id_macroterritorio)
                        ->where('id_entrevistador', '<>', $entrevistador->id_entrevistador)
                        ->where('id_grupo', $grupo->id_grupo_acceso);

                    $listado = $criterios->pluck('id_entrevistador')->toArray();
                    $arreglo_entrevistadores = array_merge($listado, $arreglo_entrevistadores);
                }
                elseif ($grupo->id_nivel == 4 ) {  //Mismo territorio
                    $criterios = entrevistador::habilitados()
                        ->where('id_territorio', $usuario->id_territorio)
                        ->where('id_entrevistador', '<>', $entrevistador->id_entrevistador)
                        ->where('id_grupo', $grupo->id_grupo_acceso);
                    $listado = $criterios->pluck('id_entrevistador')->toArray();
                    $arreglo_entrevistadores = array_merge($listado, $arreglo_entrevistadores);

                }
            }
        }

        return $arreglo_entrevistadores;
    }
    // Igual que el anterior, pero no considera habilitados()
    //Sirve para mostrar las entrevistas que hayan, aunque el usuario no esté habilitado
    public static function permitidos_acceso_entrevistas($id_usuario=null) {
        if(is_null($id_usuario)) {
            $usuario=\Auth::user();
        }
        else {
            $usuario=User::find($id_usuario);
        }
        $nivel=99;
        $arreglo_entrevistadores=array();
        if(isset($usuario->id)) {
            $entrevistador = $usuario->rel_entrevistador;
            //Identificar los que le tocan según su nivel y grupo
            if (in_array($entrevistador->id_nivel, [1,2,7,10,11,6])) { //10 y 11: transcriptores, no aplicar filtro por entrevistador
                if($entrevistador->id_nivel == 6) {
                    $listado = entrevistador::habilitados(true,true);
                }
                elseif($entrevistador->id_nivel == 1) {
                    $listado = entrevistador::habilitados(true,true,true);
                }
                else {
                    $listado = entrevistador::habilitados(true);  //este parametro hace la diferencia para que se muestren incluso los deshabilitdados
                }

                    //->where('id_nivel', '>=', $entrevistador->id_nivel);  //todos los del mismo nivel o menor
                if ($entrevistador->id_grupo > 1) {
                    $listado->where('id_grupo', $usuario->id_grupo);
                }
                $arreglo_entrevistadores = $listado->pluck('id_entrevistador')->toArray();
            } elseif ($entrevistador->id_nivel == 3) {
                $listado = entrevistador::habilitados(true)
                    ->where('id_macroterritorio', $usuario->id_macroterritorio);
                if ($entrevistador->id_grupo > 1) {
                    $listado->where('id_grupo', $usuario->id_grupo);
                }
                $arreglo_entrevistadores = $listado->pluck('id_entrevistador')->toArray();
            } elseif ($entrevistador->id_nivel == 4) {
                $listado = entrevistador::habilitados(true)
                    ->where('id_territorio', $usuario->id_territorio);
                if ($entrevistador->id_grupo > 1) {
                    $listado->where('id_grupo', $usuario->id_grupo);
                }
                $arreglo_entrevistadores = $listado->pluck('id_entrevistador')->toArray();
            } elseif (in_array($entrevistador->id_nivel, [5])) {
                $arreglo_entrevistadores = [$entrevistador->id_entrevistador];
            }


            // Identificar los que le tocan si tiene acceso a grupo  (esta condición no restringe, sino que amplía)
            foreach ($entrevistador->rel_acceso as $grupo) {
                if ($grupo->id_nivel==2 ) {  //Grupo entero
                    $criterios = entrevistador::habilitados(true)
                        ->where('id_entrevistador', '<>', $entrevistador->id_entrevistador)
                        ->where('id_grupo', $grupo->id_grupo_acceso);

                    $listado = $criterios->pluck('id_entrevistador')->toArray();
                    $arreglo_entrevistadores = array_merge($listado, $arreglo_entrevistadores);
                }
                elseif ($grupo->id_nivel == 3) {  //Mismo macroterritorio
                    $criterios = entrevistador::habilitados(true)
                        ->where('id_macroterritorio', $usuario->id_macroterritorio)
                        ->where('id_entrevistador', '<>', $entrevistador->id_entrevistador)
                        ->where('id_grupo', $grupo->id_grupo_acceso);

                    $listado = $criterios->pluck('id_entrevistador')->toArray();
                    $arreglo_entrevistadores = array_merge($listado, $arreglo_entrevistadores);
                }
                elseif ($grupo->id_nivel == 4 ) {  //Mismo territorio
                    $criterios = entrevistador::habilitados(true)
                        ->where('id_territorio', $usuario->id_territorio)
                        ->where('id_entrevistador', '<>', $entrevistador->id_entrevistador)
                        ->where('id_grupo', $grupo->id_grupo_acceso);
                    $listado = $criterios->pluck('id_entrevistador')->toArray();
                    $arreglo_entrevistadores = array_merge($listado, $arreglo_entrevistadores);

                }
            }
        }
        return $arreglo_entrevistadores;
    }

    //Listado de entrevistadores a los que tiene acceso
    public static function entrevistadores_asignados($id_entrevistador=0) {
        $arreglo_entrevistadores=array();

        $entrevistador = entrevistador::find($id_entrevistador);
        if(!$entrevistador) {
            return $arreglo_entrevistadores;
        }

        foreach ($entrevistador->rel_acceso as $grupo) {
            if ($grupo->id_nivel==2 ) {  //Grupo entero
                $criterios = entrevistador::habilitados(true)
                    ->where('id_entrevistador', '<>', $entrevistador->id_entrevistador)
                    ->where('id_grupo', $grupo->id_grupo_acceso);

                $arreglo_entrevistadores = $criterios->pluck('id_entrevistador')->toArray();

            }
            elseif ($grupo->id_nivel == 3) {  //Mismo macroterritorio
                $criterios = entrevistador::habilitados(true)
                    ->where('id_macroterritorio', $entrevistador->id_macroterritorio)
                    ->where('id_entrevistador', '<>', $entrevistador->id_entrevistador)
                    ->where('id_grupo', $grupo->id_grupo_acceso);

                $arreglo_entrevistadores = $criterios->pluck('id_entrevistador')->toArray();

            }
            elseif ($grupo->id_nivel == 4 ) {  //Mismo territorio
                $criterios = entrevistador::habilitados(true)
                    ->where('id_territorio', $entrevistador->id_territorio)
                    ->where('id_entrevistador', '<>', $entrevistador->id_entrevistador)
                    ->where('id_grupo', $grupo->id_grupo_acceso);
                $arreglo_entrevistadores = $criterios->pluck('id_entrevistador')->toArray();
            }
        }
        return $arreglo_entrevistadores;
    }

    //Arreglo de entrevistadores a los que tiene acceso alguien de un grupo ajeno
    public function arreglo_mismo_grupo() {
        $arreglo=array();

        $listado = entrevistador::where('id_grupo',$this->id_grupo);
        if(in_array($this->id_nivel,[1,2]) ) { //Sin restriccion
            //Sin filtro por terriotrio
        }
        elseif($this->id_nivel == 3) { //Macro
            $listado->where('id_macroterritorio',$this->id_macroterritorio);
        }
        elseif($this->id_nivel == 4) { //Territorio
            $listado->where('id_territorio',$this->id_territorio);
        }
        else {  //Por defecto: yo mismo
            $listado->where('id_entrevistador',$this->id_entrevistador);
        }
        $arreglo = $listado->pluck('id_entrevistador')->toArray();
        //dd($arreglo);
        return $arreglo;
    }


    //Devuelve un arreglo con los id_entrevistadores
    // A nombre de quienes puede cargar testimonios (caso de la ruta pacifica)
    public function getANombreDeAttribute() {
        $arreglo_entrevistadores=array();
        foreach ($this->rel_acceso as $grupo) {
            if ($grupo->id_nivel==2 ) {  //Grupo entero
                $criterios = entrevistador::habilitados(true)
                    ->where('id_entrevistador', '<>', $this->id_entrevistador)
                    ->where('id_grupo', $grupo->id_grupo_acceso);
            }
            elseif ($grupo->id_nivel == 3) {  //Mismo macroterritorio
                $criterios = entrevistador::habilitados(true)
                    ->where('id_macroterritorio', $this->id_macroterritorio)
                    ->where('id_entrevistador', '<>', $this->id_entrevistador)
                    ->where('id_grupo', $grupo->id_grupo_acceso);
            }
            elseif ($grupo->id_nivel == 4 ) {  //Mismo territorio
                $criterios = entrevistador::habilitados(true)
                    ->where('id_territorio', $this->id_territorio)
                    ->where('id_entrevistador', '<>', $this->id_entrevistador)
                    ->where('id_grupo', $grupo->id_grupo_acceso);
            }
            $listado = $criterios->pluck('id_entrevistador')->toArray();
            $arreglo_entrevistadores = array_merge($listado, $arreglo_entrevistadores);
        }
        return $arreglo_entrevistadores;



    }
    //A los que tiene acceso, deberia de sustituir a scopePermitidos
    public static function scopeAcceso($query) {
        $arreglo_entrevistadores = self::permitidos_acceso();
        //dd($arreglo_entrevistadores);
        $query->wherein('id_entrevistador',$arreglo_entrevistadores);
    }

    //Incluir  o no al propio usuario
    public static function scopeLosDemas($query, $incluirme=false) {
        if(!$incluirme) {
            if(\Auth::check()) {
                $query->where('id_entrevistador','<>',\Auth::user()->id_entrevistador);
            }
        }
    }

    public  static function scopeNumero($query,$numero_entrevistador=-1) {
        $numero_entrevistador=intval($numero_entrevistador);
        if($numero_entrevistador > 0 ) {
            $query->where('numero_entrevistador',$numero_entrevistador);
        }
    }
    public static  function scopeMacroterritorio($query,$id=-1) {
        $id=intval($id);
        if($id > 0 ) {
            $query->where('id_macroterritorio',$id);
        }
    }
    public static  function scopeTerritorio($query,$id=-1) {
        $id=intval($id);
        if($id > 0 ) {
            $query->where('id_territorio',$id);
        }
    }
    public static  function scopeGrupo($query,$id=-1) {
        $id=intval($id);
        if($id > 0 ) {
            $query->where('id_grupo',$id);
        }
        //Ocultar los de autenticacion local
        if(\Gate::denies('login-local')) {
            $query->where('id_grupo','<>',25);
        }
    }

    public static function scopePrivilegios($query,$id=-1) {
        $id=intval($id);
        if($id > 0 ) {
            $query->where('id_nivel',$id);
        }
    }
    public static function scopeNombre($query,$txt="") {
        $txt=trim($txt);
        if(strlen($txt) > 0 ) {
            $txt=str_replace(" ","%",$txt);
            $query->join('users as fn','esclarecimiento.entrevistador.id_usuario','=','fn.id')
                ->where('fn.name','ilike',"%$txt%");
        }
    }
    public static function scopeId_entrevistador($query,$id=0) {
        if(is_array($id)) {
            $query->wherein('id_entrevistador',$id);
        }
        else {
            if($id > 0 ) {
                $query->where('id_entrevistador','=',$id);
            }
        }

    }

    //Para los filtros
    public static function filtros_default($request = null) {
        //Valores por defecto
        $filtro =new \stdClass();
        $filtro->numero = null;
        $filtro->id_macroterritorio = -1;
        $filtro->id_territorio = -1;
        $filtro->id_nivel = -1;
        $filtro->nombre = "";
        $filtro->id_grupo=-1;
        $filtro->id_grupo_acceso=-1;
        $filtro->todos = false; //Para decidir si se muestran los deshabilitados
        $filtro->confidenciales = false;
        $filtro->confidenciales_ajenos = false;  //Esta excepcion es para que en el listado de entrevistadores me salgan los usuarios confidenciales.
        $filtro->incluirme = true;
        $filtro->id_entrevistador=-1;
        //Busqueda Rapida
        $filtro->br="";

        if(\Gate::allows('nivel-6')) {
            $filtro->confidenciales=true;
        }

        if(\Auth::check()) {
            if(\Auth::user()->id_nivel==1) {
                $filtro->todos=true;
            }
            //if(\Auth)
        }

        if(\Gate::check('login-local')) {
            $filtro->id_grupo=25;
        }


        $filtro->numero = isset($request->numero) ? $request->numero : $filtro->numero;
        $filtro->id_entrevistador = isset($request->id_entrevistador) ? $request->id_entrevistador : $filtro->id_entrevistador;

        $filtro->id_grupo = isset($request->id_grupo) ? $request->id_grupo : $filtro->id_grupo;
        $filtro->id_nivel = isset($request->id_nivel) ? $request->id_nivel : $filtro->id_nivel;
        $filtro->nombre = isset($request->nombre) ? $request->nombre : $filtro->nombre;
        $filtro->br = isset($request->br) ? $request->br : $filtro->br;

        //Determinar si es macro o territorio
        if(isset($request->id_territorio)) {
            if($request->id_territorio>0) {
                $filtro->id_territorio=$request->id_territorio;

            }
            else {
                if($request->id_territorio_macro > 0) {
                    $filtro->id_macroterritorio=$request->id_territorio_macro;
                }
            }
        }

        //dd($filtro);
        //Aplicar filtros por perfil


        if(\Auth::check()) {
            $usuario =\Auth::user();
            if($usuario->id_nivel==5) {
                $arreglo = entrevistador::entrevistadores_asignados($usuario->id_entrevistador);
                $arreglo[]=$usuario->id_entrevistador;
                $filtro->id_entrevistador=$arreglo;
            }
            elseif($usuario->id_nivel==4) {
                $filtro->id_territorio=$usuario->id_territorio;
            }
            elseif($usuario->id_nivel==3) {
                $filtro->id_macroterritorio=$usuario->id_macroterritorio;
            }
            //Aplicar filtros por grupo
            if($usuario->id_grupo <> 1) {
                $filtro->id_grupo = $usuario->id_grupo;
            }
            //dd($filtro);
        }





        //Para poder agregar el query string a a los links por GET
        if(is_object($request)) {
            $url = $request->fullUrl();
            $pedazos = explode("?",$url);
            if(isset($pedazos[1])) {
                $filtro->url = $pedazos[1]."&";
            }
            else {
                $filtro->url="";
            }
        }



        return $filtro;
    }

    public static function scopeFiltrar($query, $criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }
        //dd($criterios);
        $query->numero($criterios->numero)
            ->macroterritorio($criterios->id_macroterritorio)
            ->territorio($criterios->id_territorio)
            ->privilegios($criterios->id_nivel)
            ->grupo($criterios->id_grupo)
            ->habilitados($criterios->todos,$criterios->confidenciales, $criterios->confidenciales_ajenos)
            ->LosDemas($criterios->incluirme)
            ->br($criterios->br)
            ->id_entrevistador($criterios->id_entrevistador)
            ->nombre($criterios->nombre);



    }

    /// Funcionalidad propia


    // Sirve para condicionar cosas
    public function tiene_acceso_a_grupos() {
        return $this->rel_acceso()->count() > 0;
    }

    //Para los select y las validaciones, devuelve arreglo con id y nombre
    // se basa en scopeAcceso() que a su vez se basa en permitidos_acceso

    public static function listado_items_bak($vacio="",$incluirme=true,$todos=false) {
        //$filtros = self::filtros_default();
        //dd("Incluirme:$incluirme");
        //dd("Todos:$todos");


        $filtros = self::filtros_default();
        $filtros->todos=$todos;
        $filtros->incluirme=$incluirme;
        $query = self::filtrar($filtros)
                        ->acceso()
                        ->ordenar();
        //dd($filtros);

        $debug['sql']= nl2br($query->toSql());
        $debug['criterios']=$query->getBindings();
        //dd($debug);

        //dd($filtros);

        //dd($query);
        $listado = $query->pluck('uo.name','id_entrevistador');
        //dd($listado);
        //dd($listado);
        $listado = $listado->toArray();
        if(strlen($vacio)>0) {
            if(count($listado)>1) {  //Si solo hay uno (nivel mas bajo), no tiene sentido el vacío
                $listado = [-1=>$vacio] + $listado;
            }

        }

        return $listado;
    }
    //Pruebas para nueva version. De aquí saco el listado de a nombre de quien  puedo cargar entrevista
    public static function listado_items($vacio="",$incluirme=true,$todos=false) {
        //$filtros = self::filtros_default();
        //dd("Incluirme:$incluirme");
        //dd("Todos:$todos");


        $filtros = self::filtros_default();
        $filtros->todos=$todos;
        $filtros->incluirme=$incluirme;
        $query = self::filtrar($filtros)
            ->acceso()
            ->ordenar();
        //dd($filtros);

        $debug['sql']= nl2br($query->toSql());
        $debug['criterios']=$query->getBindings();
        //dd($debug);

        //dd($filtros);

        //dd($query);
        $listado=array();
        $r = $query->get();
        foreach($r as $fila) {
            $listado[$fila->id_entrevistador] = $fila->numero_entrevistador." - ".$fila->name;
        }

        if(strlen($vacio)>0) {
            if(count($listado)>1) {  //Si solo hay uno (nivel mas bajo), no tiene sentido el vacío
                $listado = [-1 => $vacio] + $listado;
            }
        }
        return $listado;

    }

    public static function listado_todos($vacio="", $incluirme=true, $deshabilitados=false, $confidenciales=false, $otros_confidenciales=false) {
        //$filtros = self::filtros_default();
        //dd("Incluirme:$incluirme");
        //dd("Todos:$todos");
        $arreglo=array();


        //$filtros = entrevistador::filtros_default();
        //$filtros->todos=true;
        //$filtros->incluirme=$incluirme;

        $listado = self::habilitados($deshabilitados,$confidenciales,$otros_confidenciales)
                        ->LosDemas($incluirme)
                        ->ordenar()
                        ->get();


        foreach($listado as $manin) {
            $arreglo[$manin->id_entrevistador] = $manin->fmt_numero_nombre  ;
        }
        if(strlen($vacio)>0) {
            if(count($listado)>1) {  //Si solo hay uno (nivel mas bajo), no tiene sentido el vacío
                $arreglo = $arreglo + [-1 => $vacio] ;
            }
        }

        return $arreglo;

    }


    public static function arreglo_permisos() {

        $permisos[1][]="Modificar las entrevistas de todo el sistema";
        $permisos[1][]="Acceso a todos los adjuntos de las entrevistas de todo el sistema";
        $permisos[1][]="Ingresar información a nombre de cualquier usuario";
        $permisos[1][]="Gestionar usuarios (cambiar perfil o deshabilitar)";
        $permisos[1][]="Gestionar catálogos (listados personalizables).";
        $permisos[1][]="Facilitar acceso para modificar una entrevista específica.";

        $permisos[2][]="Modificar las entrevistas de todo el sistema";
        $permisos[2][]="Acceso a todos los adjuntos de las entrevistas de todo el sistema";
        $permisos[2][]="Ingresar información a nombre de cualquier usuario";
        $permisos[2][]="Gestionar usuarios (cambiar perfil o deshabilitar)";
        $permisos[2][]="Facilitar acceso para modificar una entrevista específica.";

        $permisos[3][]="Acceso de consulta a todas las entrevistas disponibles en el sistema";
        $permisos[3][]="Modificar las entrevistas de su propio macroterritorio";
        $permisos[3][]="Acceso a todos los adjuntos de las entrevistas de su macroterritorio";
        $permisos[3][]="Ingresar información a nombre de cualquier usuario de su macroterritorio";
        $permisos[3][]="No puede consultar anexos de entrevistas R-3 y R-2 de otros macroterritorios";

        $permisos[4][]="Acceso de consulta a todas las entrevistas disponibles en el sistema";
        $permisos[4][]="Modificar las entrevistas de su propio territorio";
        $permisos[4][]="Acceso a todos los adjuntos de las entrevistas de su territorio";
        $permisos[4][]="Ingresar información a nombre de cualquier usuario de su territorio";
        $permisos[4][]="No puede consultar anexos de entrevistas R-3 y R-2 de otros territorios";

        $permisos[5][]="Acceso de consulta a todas las entrevistas disponibles en el sistema";
        $permisos[5][]="Modificar sus propias entrevistas";
        $permisos[5][]="Acceso a todos los adjuntos de sus propias entrevistas";
        $permisos[5][]="No puede consultar anexos de entrevistas R-3 y R-2 de otros entrevistadores";
        $permisos[5][]="Facilitar acceso para modificar sus propias entrevistas";
        $permisos[5][]="Facilitar acceso para acceder a los anexos de sus propias entrevistas";

        $permisos[6][]="Acceso de consulta a todas las entrevistas disponibles en el sistema";
        $permisos[6][]="Modificar sus propias entrevistas";
        $permisos[6][]="Acceso a todos los adjuntos de todas las entrevistas (sin restricciones de R-2 y R-3)";
        $permisos[6][]="Facilitar acceso para modificar sus propias entrevistas";
        $permisos[6][]="Facilitar acceso para acceder a los anexos de sus propias entrevistas";
        $permisos[6][]="Todas las entrevistas ingresadas por estos usuarios, se clasifican como R-2";


        $permisos[7][]="Acceder únicamente a información estadística";
        $permisos[7][]="No tiene acceso al detalle de las estadísticas, los listados o instrumentos";

        $permisos[10][]="Asignar transcripciones por realizar";
        $permisos[10][]="Revocar asignaciones de transcripciones por realizar";

        $permisos[11][]="Acceso al panel de transcripciones";
        $permisos[11][]="Acceso para modificar las entrevistas  asignadas";
        $permisos[11][]="Acceso a todos los adjuntos (incluso R-2, R-3, R-4) de las entrevistas  asignadas";



        $permisos[99][]="Usuario deshabilitado, no tiene acceso a nada";

        return $permisos;
    }

    //El usuario, es por si hay que buscarlo en codigo_predefinido que son códigos pre-asignados
    public static function determinar_correlativo($usuario=null) {
        $max=0;
        if(strlen($usuario)>0) {
            //Verificar en los codigos pre-asignados
            $existe=codigo_predefinido::where('usuario','ilike',$usuario)->first();
            if($existe) {
                $max=$existe->numero;
            }
        }
        if($max==0) {   //No apareció en los codigos pre-asignados
            $max = self::where('numero_entrevistador','>=','50')->max('numero_entrevistador');
            //return $max;
            $max=intval($max);
            if($max<50) {
                $max=50;
            }
            else {
                $max++;
            }
        }
        return $max;
    }



    public static function arreglo_transcriptores($vacio='', $el_resto=true, $con_deshabilitados=false){
        if($el_resto) {
            $listado = entrevistador::where('id_nivel','<>',99)->ordenar()->get();
        }
        else {
            $listado = entrevistador::where('id_nivel',11)->ordenar()->get();
        }



        $arreglo=array();

        if(strlen($vacio)>0) {
            $arreglo[-1] =$vacio;
        }
        foreach($listado as $manin) {
            $cuantas = $manin->rel_asignacion()->where('id_situacion',1)->count();
            $etiquetado = $manin->rel_asignacion_etiquetado()->where('id_situacion',1)->count();
            $total = $cuantas+$etiquetado;
            $arreglo[$manin->id_entrevistador] = $manin->fmt_numero_nombre . " ($total pendientes)" ;
        }

        if($con_deshabilitados) {
            //Agregar los deshabilitados, con alguna asignación
            $listado2 = entrevistador::where('id_nivel',99)
                ->join('transcribir_asignacion','id_entrevistador','id_transcriptor')
                ->ordenar()->get();
            foreach($listado2 as $manin) {
                $cuantas = $manin->rel_asignacion()->where('id_situacion',1)->count();
                $etiquetado = $manin->rel_asignacion_etiquetado()->where('id_situacion',1)->count();
                $total = $cuantas+$etiquetado;
                $arreglo[$manin->id_entrevistador] = $manin->fmt_numero_nombre. " [deshabilitado] " . " ($total pendientes)" ;
            }
        }



        return $arreglo;
    }

    public static function cual_codigo($id_entrevistador=0) {
        $q = self::find($id_entrevistador);
        if($q) {
            return $q->numero_entrevistador;
        }
        else {
            return "---";
        }
    }

    //2021-07-29: Compromiso con la reserva
    public static function registrar_compromiso() {
        if(!\Auth::check()) {
            return false;
        }
        $quien = \Auth::user();
        //Registrar la aceptación
        $compromiso = new entrevistador_compromiso();
        $compromiso->id_entrevistador = $quien->id_entrevistador;
        $compromiso->save();

        //Actualizar el registro del entrevistador para saber si ya lo aceptó
        $e = $quien->rel_entrevistador;
        if(!$e) {
            return false;
        }
        $e->compromiso_reserva++;
        $e->save();
        return $e->compromiso_reserva;




    }

    /**
     * FUNCIONES PARA EL PAZ Y SALVO
     * 17-dic-21
     */
    public static function filtros_pys( $request) {
        $criterios = new \stdClass();
        $criterios->id_entrevistador=null;
        $criterios->id_completo=-1;
        //dd($request);

        ///
        $criterios->id_entrevistador = $request->id_entrevistador ?? \Auth::user()->id_entrevistador;
        $criterios->id_completo = $request->id_completo ?? $criterios->id_completo;

        return $criterios;
    }
    public  function listado_entrevistas() {
        $listado = [];


        //VI
        $listado['vi'] = entrevista_individual::id_entrevistador($this->id_entrevistador)
                                    ->id_subserie(config('expedientes.vi'))
                                    ->id_activo(1)
                                    ->ordenar()
                                    ->pluck('entrevista_codigo','id_e_ind_fvt');
        $listado['aa'] = entrevista_individual::id_entrevistador($this->id_entrevistador)
            ->id_subserie(config('expedientes.aa'))
            ->id_activo(1)
            ->ordenar()
            ->pluck('entrevista_codigo','id_e_ind_fvt');

        $listado['tc'] = entrevista_individual::id_entrevistador($this->id_entrevistador)
            ->id_subserie(config('expedientes.tc'))
            ->id_activo(1)
            ->ordenar()
            ->pluck('entrevista_codigo','id_e_ind_fvt');

        $listado['co'] = entrevista_colectiva::id_entrevistador($this->id_entrevistador)
            ->id_activo(1)
            ->ordenar()
            ->pluck('entrevista_codigo','id_entrevista_colectiva');

        $listado['ee'] = entrevista_etnica::id_entrevistador($this->id_entrevistador)
            ->id_activo(1)
            ->ordenar()
            ->pluck('entrevista_codigo','id_entrevista_etnica');

        $listado['pr'] = entrevista_profundidad::id_entrevistador($this->id_entrevistador)
            ->id_activo(1)
            ->ordenar()
            ->pluck('entrevista_codigo','id_entrevista_profundidad');

        $listado['dc'] = diagnostico_comunitario::id_entrevistador($this->id_entrevistador)
            ->id_activo(1)
            ->ordenar()
            ->pluck('entrevista_codigo','id_diagnostico_comunitario');

        $listado['hv'] = historia_vida::id_entrevistador($this->id_entrevistador)
            ->id_activo(1)
            ->ordenar()
            ->pluck('entrevista_codigo','id_historia_vida');

        return $listado;

    }
    public function verificar_entrevistas() {
        //Preparativos e inventario inicial
        $info = new \stdClass();
        $info->entrevistas = $this->listado_entrevistas();
        $info->completas = []; //Listado de entrevistas completas
        $info->incompletas = []; //Listado de entrevistas incompletas
        $info->verificacion = [];  //Listado de que tiene/falta
        $info->criterios = ['consentimiento','audio','relatoria','ficha_entrevistado','completo']; //Para usar en la vista

        $info->conteos = new \stdClass();
        $info->conteos->total = 0;
        $info->conteos->completas = 0;
        $info->conteos->incompletas = 0;
        //Proceso de verificación
        foreach($info->entrevistas['vi'] as $id => $codigo) {
            $entrevista = entrevista_individual::find($id);
            $estado = entrevista_individual::esta_completa($entrevista);
            $info->verificacion['vi'][$id]=$estado;
            if($estado['completo']==1) {
                $info->completas['vi'][$id]=$entrevista;
            }
            else {
                $info->incompletas['vi'][$id]=$entrevista;
            }
        }
        //AA
        foreach($info->entrevistas['aa'] as $id => $codigo) {
            $entrevista = entrevista_individual::find($id);
            $estado = entrevista_individual::esta_completa($entrevista);
            $info->verificacion['aa'][$id]=$estado;
            if($estado['completo']==1) {
                $info->completas['aa'][$id]=$entrevista;
            }
            else {
                $info->incompletas['aa'][$id]=$entrevista;
            }
        }
        //TC
        foreach($info->entrevistas['tc'] as $id => $codigo) {
            $entrevista = entrevista_individual::find($id);
            $estado = entrevista_individual::esta_completa($entrevista);
            $info->verificacion['tc'][$id]=$estado;
            if($estado['completo']==1) {
                $info->completas['tc'][$id]=$entrevista;
            }
            else {
                $info->incompletas['tc'][$id]=$entrevista;
            }
        }
        //CO
        foreach($info->entrevistas['co'] as $id => $codigo) {
            $entrevista = entrevista_colectiva::find($id);
            $estado = entrevista_individual::esta_completa($entrevista);
            $info->verificacion['co'][$id]=$estado;
            if($estado['completo']==1) {
                $info->completas['co'][$id]=$entrevista;
            }
            else {
                $info->incompletas['co'][$id]=$entrevista;
            }
        }
        //EE
        foreach($info->entrevistas['ee'] as $id => $codigo) {
            $entrevista = entrevista_etnica::find($id);
            $estado = entrevista_individual::esta_completa($entrevista);
            $info->verificacion['ee'][$id]=$estado;
            if($estado['completo']==1) {
                $info->completas['ee'][$id]=$entrevista;
            }
            else {
                $info->incompletas['ee'][$id]=$entrevista;
            }
        }
        //PR
        foreach($info->entrevistas['pr'] as $id => $codigo) {
            $entrevista = entrevista_profundidad::find($id);
            $estado = entrevista_individual::esta_completa($entrevista);
            $info->verificacion['pr'][$id]=$estado;
            if($estado['completo']==1) {
                $info->completas['pr'][$id]=$entrevista;
            }
            else {
                $info->incompletas['pr'][$id]=$entrevista;
            }
        }
        //DC
        foreach($info->entrevistas['dc'] as $id => $codigo) {
            $entrevista = diagnostico_comunitario::find($id);
            $estado = entrevista_individual::esta_completa($entrevista);
            $info->verificacion['dc'][$id]=$estado;
            if($estado['completo']==1) {
                $info->completas['dc'][$id]=$entrevista;
            }
            else {
                $info->incompletas['dc'][$id]=$entrevista;
            }
        }
        //HV
        foreach($info->entrevistas['hv'] as $id => $codigo) {
            $entrevista = historia_vida::find($id);
            $estado = entrevista_individual::esta_completa($entrevista);
            $info->verificacion['hv'][$id]=$estado;
            if($estado['completo']==1) {
                $info->completas['hv'][$id]=$entrevista;
            }
            else {
                $info->incompletas['hv'][$id]=$entrevista;
            }
        }





        //Calculo de conteos, para uso de la vista
        foreach($info->entrevistas as $tipo => $listado) {
            $info->conteos->total += count($listado);
        }
        foreach($info->completas as $tipo => $listado) {
            $info->conteos->completas += count($listado);
        }
        foreach($info->incompletas as $tipo => $listado) {
            $info->conteos->incompletas += count($listado);
        }
        return $info;
    }



    /**
     * autenticacion local
     */
    //Versión liviana: formularios de edición
    public function getNameAttribute() {
        return $this->rel_usuario->name;
    }
    public function getEmailAttribute() {
        return $this->rel_usuario->email;
    }



}
