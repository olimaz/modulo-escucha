<?php

namespace App\Models;

use App\Interfaces\EntrevistaIndividual;
use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Support\Facades\Log;

/**
 * Class entrevista
 * @package App\Models
 * @version September 20, 2019, 3:55 pm -05
 *
 * @property \App\Models\Esclarecimiento.eIndFvt idEIndFvt
 * @property \App\Models\Catalogos.catItem idioma
 * @property \App\Models\Catalogos.catItem idNativo
 * @property \Illuminate\Database\Eloquent\Collection catalogos.catItem2s
 * @property \Illuminate\Database\Eloquent\Collection fichas.entrevistaTestigos
 * @property integer id_e_ind_fvt
 * @property integer id_entrevista_etnica
 * @property integer id_entrevista_profundidad
 * @property integer id_historia_vida
 * @property integer id_idioma
 * @property integer id_nativo
 * @property string nombre_interprete
 * @property integer documentacion_aporta
 * @property string documentacion_especificar
 * @property integer identifica_testigos
 * @property integer ampliar_relato
 * @property string ampliar_relato_temas
 * @property integer priorizar_entrevista
 * @property string priorizar_entrevista_asuntos
 * @property integer contiene_patrones
 * @property string contiene_patrones_cuales
 * @property string indicaciones_transcripcion
 * @property string observaciones
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 * @property string|\Carbon\Carbon update_fh
 * @property string|\Carbon\Carbon insert_fh
 * @property integer insert_ent
 * @property strint insert_ip
 * @property integer update_ent
 * @property strint update_ip
 */
class entrevista extends Model implements EntrevistaIndividual
{

    public $table = 'fichas.entrevista';

    protected $primaryKey = 'id_entrevista';

    public $timestamps = false;



    public $fillable = [
        'id_e_ind_fvt',
        'id_idioma',
        'id_nativo',
        'nombre_interprete',
        'documentacion_aporta',
        'documentacion_especificar',
        'identifica_testigos',
        'ampliar_relato',
        'ampliar_relato_temas',
        'priorizar_entrevista',
        'priorizar_entrevista_asuntos',
        'contiene_patrones',
        'contiene_patrones_cuales',
        'indicaciones_transcripcion',
        'observaciones',
        'identificacion_consentimiento',
        'conceder_entrevista',
        'grabar_audio',
        'elaborar_informe',
        'tratamiento_datos_analizar',
        'tratamiento_datos_analizar_sensible',
        'tratamiento_datos_utilizar',
        'tratamiento_datos_utilizar_sensible',
        'tratamiento_datos_publicar',
        'created_at',
        'updated_at',
        'insert_ent',
        'insert_fh',
        'insert_ip',
        'update_ent',
        'update_fh',
        'update_ip',
        'id_entrevista_etnica',
        'id_entrevista_profundidad',
        'id_historia_vida',
        'nombre_autoridad_etnica',
        'nombre_identitario',
        'pueblo_representado',
        'id_pueblo_representado',
        'grabar_video',
        'tomar_fotografia'
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_entrevista' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_entrevista_etnica' => 'integer',
        'id_entrevista_profundidad' => 'integer',
        'id_historia_vida' => 'integer',
        'id_idioma' => 'integer',
        'id_nativo' => 'integer',
        'nombre_interprete' => 'string',
        'documentacion_aporta' => 'integer',
        'documentacion_especificar' => 'string',
        'identifica_testigos' => 'integer',
        'ampliar_relato' => 'integer',
        'ampliar_relato_temas' => 'string',
        'priorizar_entrevista' => 'integer',
        'priorizar_entrevista_asuntos' => 'string',
        'contiene_patrones' => 'integer',
        'contiene_patrones_cuales' => 'string',
        'indicaciones_transcripcion' => 'string',
        'observaciones' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'nombre_autoridad_etnica' => 'string',
        'nombre_identitario' => 'string',
        'pueblo_representado' => 'string',
        'id_pueblo_representado' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //'id_e_ind_fvt' => 'required',
        'nombre_interprete' => 'max:200',
        'id_idioma' => 'required',
        'documentacion_aporta' => 'required',
        'identifica_testigos' => 'required',
        'ampliar_relato' => 'required',
        'priorizar_entrevista' => 'required',
        'contiene_patrones' => 'required'
    ];


    public function rel_id_pueblo_representado()
    {
        return $this->belongsTo(cat_item::class, 'id_pueblo_representado');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_e_ind_fvt()
    {
        return $this->belongsTo(entrevista_individual::class, 'id_e_ind_fvt');
    }

    /**


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_idioma()
    {
        return $this->belongsTo(cat_item::class, 'id_idioma','id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_nativo()
    {
        return $this->belongsTo(cat_item::class, 'id_nativo','id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function rel_entrevista_condiciones()
    {
        return $this->hasMany(entrevista_condiciones::class, 'id_entrevista','id_entrevista');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function rel_entrevista_testigo()
    {
        return $this->hasMany(entrevista_testigo::class, 'id_entrevista','id_entrevista')->orderBy('id_entrevista_testigo');
    }

    public function valores_iniciales()
    {
        $this->documentacion_aporta=2;
        $this->ampliar_relato=2;
        $this->priorizar_entrevista=2;
        $this->contiene_patrones=2;
        $this->identifica_testigos=2;
    }

    //Procesa el request y pobla tabla testigos
    public function almacenar_testigos($request)
    {        
      entrevista_testigo::where('id_entrevista',$this->id_entrevista)->delete();
        foreach($request->testigo_nombre as $id=>$valor) {
            if (!empty(trim($valor))){
                $nuevo = new entrevista_testigo();
                $nuevo->id_entrevista = $this->id_entrevista;
                $nuevo->nombre = $valor;
                $nuevo->contacto = $request->testigo_contacto[$id];
                $nuevo->save();
            }
        }

    }

    public function getArregloTestigoAttribute()
    {

        $arreglo=array();

        foreach ($this->rel_entrevista_testigo as $detalle)
        {
            $arreglo[]=$detalle;
        }
        $conteo=count($arreglo);
        for($i=$conteo;$i<2;$i++)
        {
            $vacio = new \stdClass();
            $vacio->nombre="";
            $vacio->contacto="";
            $arreglo[$i]=$vacio;
        }
        return $arreglo;
    }

    // Edición del control multiple
    public function getArregloAcompanamientoAttribute()
    {
        $arreglo=array();
        foreach ($this->rel_entrevista_condiciones as $detalle)
        {
            $arreglo[]=$detalle->id_condicion;
        }
        return $arreglo;
    }

    //Procesa el request y pobla tabla testigos
    public function almacenar_acompanamiento($request)
    {
        entrevista_condiciones::where('id_entrevista',$this->id_entrevista)->delete();
        if($request->id_condicion)
        {
          foreach($request->id_condicion as $id) {
              if ($id>0){
                  $nuevo = new entrevista_condiciones();
                  $nuevo->id_entrevista = $this->id_entrevista;
                  $nuevo->id_condicion = $id;
                  $nuevo->save();
              }
          }
        }

    }


    public function getfmtideindfvtAttribute()
    {
        return entrevista_individual::codigo($this->id_e_ind_fvt);
    }

    public function getfmtididiomaAttribute()
    {
        return cat_item::describir($this->id_idioma);
    }

    public function getfmtidnativoAttribute()
    {
        return cat_item::describir($this->id_nativo);
    }

    public function getfmtdocumentacionaportaAttribute()
    {
        return $this->documentacion_aporta==1 ? "Sí" : "No";
    }

    public function getfmtidentificatestigosAttribute()
    {
        return $this->identifica_testigos==1 ? "Sí" : "No";
    }

    public function getfmtampliarrelatoAttribute()
    {
        return $this->ampliar_relato==1 ? "Sí" : "No";
    }

    public function getfmtpriorizarentrevistaAttribute()
    {
        return $this->priorizar_entrevista==1 ? "Sí" : "No";
    }

    public function getfmtcontienepatronesAttribute()
    {
        return $this->contiene_patrones==1 ? "Sí" : "No";
    }

    public function getEnlaceEntrevistaAttribute() {
        $url="";
        if($this->id_e_ind_fvt>0) {
            $url=action('entrevista_individualController@show',$this->id_e_ind_fvt);
        }
        elseif($this->id_entrevista_profundidad > 0) {
            $url=action('entrevista_profundidadController@show',$this->id_entrevista_profundidad);
        }
        elseif($this->id_historia_vida > 0) {
            $url=action('historia_vidaController@show',$this->id_historia_vida);
        }
        return $url;

    }

    //CONSENTIMIENTO INFORMADO

    public function getfmtconcederentrevistaAttribute()
    {
        return $this->conceder_entrevista==1 ? "Sí" : "No";
    }
    public function getfmtgrabaraudioAttribute()
    {
        return $this->grabar_audio==1 ? "Sí" : "No";
    }
    public function getfmtelaborarinformeAttribute()
    {
        return $this->elaborar_informe==1 ? "Sí" : "No";
    }
    public function getfmttratamientodatosanalizarAttribute()
    {
        return $this->tratamiento_datos_analizar==1 ? "Sí" : "No";
    }
    public function getfmttratamientodatosanalizarsensibleAttribute()
    {
        return $this->tratamiento_datos_analizar_sensible==1 ? "Sí" : "No";
    }
    public function getfmttratamientodatosutilizarAttribute()
    {
        return $this->tratamiento_datos_utilizar==1 ? "Sí" : "No";
    }
    public function getfmttratamientodatosutilizarsensibleAttribute()
    {
        return $this->tratamiento_datos_utilizar_sensible==1 ? "Sí" : "No";
    }
    public function getfmttratamientodatospublicarAttribute()
    {
        return $this->tratamiento_datos_publicar==1 ? "Sí" : "No";
    }
    //Nuevos campos, 30-jun-22
    public function getFmtDivulgarMaterialAttribute()
    {
        return $this->divulgar_material==1 ? "Sí" : "No";
    }
    public function getFmtTrasladoInfoAttribute()
    {
        return $this->traslado_info==1 ? "Sí" : "No";
    }
    public function getFmtCompartirInfoAttribute()
    {
        return $this->compartir_info==1 ? "Sí" : "No";
    }
    //
    public function getfmtentrevistacondicionesAttribute()
    {
      $arreglo=array();
      foreach($this->rel_entrevista_condiciones as $condicion) {
        // Log::info($condicion);
          $arreglo[]=cat_item::describir($condicion->id_condicion);
      }
      if(count($arreglo)==0) {
          $str="Sin especificar.";
      }
      else {
          $str=implode(", ",$arreglo);
      }
      return $str;
    }

    public function getfmtentrevistatestigoAttribute()
    {
      $arreglo=array();
      foreach($this->rel_entrevista_testigo as $testigo) {
        // Log::info($condicion);
          $arreglo[]="<td>".$testigo->nombre."</td>"."<td>".$testigo->contacto."</td>";
      }
      if(count($arreglo)==0) {
          $str="Sin especificar.";
      }
      else {
        $str="<tr>";
         $str.=implode("<tr>",$arreglo);
         $str.="</tr>";
     }
      return $str;
    }

    public function existeEntrevistaIndividual(int $id_e_ind_fvt) {

        $entrevista = entrevista::where('id_e_ind_fvt', $id_e_ind_fvt)->first();

        if (is_object($entrevista))
            return $entrevista;

        return null;
    }




    /*
     * Filtrado y ordenado
     */

    //Busca por id_e_ind_fvt
    public function scopeId_e_ind_fvt($query,$id=0) {
        if($id > 0) {
            $query->where('id_e_ind_fvt',$id);
        }
    }
    //ordena por codigo de la entrevista
    public function scopeOrdenar($query) {
        $query->join('esclarecimiento.e_ind_fvt as o','entrevista.id_end_fvt','=','o.e_ind_fvt')
                ->ordrby('o.entrevista_codigo');
    }

    //Versión sustituida el 25/nov/2020
    public static function nuevo_procesar_request_bak($request){

       if (isset($request->id_e_ind_fvt) && $request->id_e_ind_fvt >0) {
           
            $insert_traza=entrevista::where("id_e_ind_fvt", $request->id_e_ind_fvt)->orderby('id_entrevista')->first();

        } elseif(isset($request->id_entrevista_etnica) && $request->id_entrevista_etnica>0) {

            $insert_traza=entrevista::where("id_entrevista_etnica",$request->id_entrevista_etnica)->orderby('id_entrevista')->first();
        }

      if (is_object($insert_traza))
      {
            $insert_ent=$insert_traza->insert_ent;
            $insert_fh=$insert_traza->insert_fh;
            $insert_ip=$insert_traza->insert_ip;

      }

        /*
      if (isset($request->id_e_ind_fvt) && $request->id_e_ind_fvt >0) {

            entrevista::where("id_e_ind_fvt", $request->id_e_ind_fvt)->whereNull('id_entrevista_etnica')->delete();

      } elseif (isset($request->id_entrevista_etnica) && $request->id_entrevista_etnica>0){

            entrevista::where("id_entrevista_etnica", $request->id_entrevista_etnica)->whereNull('id_e_ind_fvt')->delete();
      }
        */

      //Detectar si se trata de una entrevista individual
      if(isset($request->id_e_ind_fvt)) {
          //Validar que sea mayor que cero, para no borrar todas las entrevistas individuales, que traen este valor cero
          if(($request->id_e_ind_fvt >0)) {
              entrevista::where("id_e_ind_fvt", $request->id_e_ind_fvt)->whereNull('id_entrevista_etnica')->whereNull('id_entrevista_profundidad')->delete();
          }
      }
      //Detectar si se trata de una entrevista etnica
      if (isset($request->id_entrevista_etnica) ) {
          //Revisar que tenga valor superior a cero, de lo contrario borraria todas las entrevistas individuales
          if($request->id_entrevista_etnica>0) {
              entrevista::where("id_entrevista_etnica", $request->id_entrevista_etnica)->whereNull('id_e_ind_fvt')->whereNull('id_entrevista_profundidad')->delete();
          }
      }





      $input = $request->all();
      
      $nuevo = new entrevista();
      $nuevo->fill($input);




      //$nuevo->id_e_ind_fvt = $this->id_e_ind_fvt;

      if (is_object($insert_traza))
      {
        $nuevo->update_ent = \Auth::user()->id_entrevistador;
        $nuevo->update_fh = \Carbon\Carbon::now();
        $nuevo->update_ip = \Request::ip();
        $nuevo->insert_ent = $insert_ent;
        $nuevo->insert_fh = $insert_fh;
        $nuevo->insert_ip = $insert_ip;
      }
      else
      {
        $nuevo->insert_ent = \Auth::user()->id_entrevistador;
        $nuevo->insert_fh = \Carbon\Carbon::now();
        $nuevo->insert_ip = \Request::ip();
      }



      $nuevo->save();

      //Traza de actividad
        $e=false;
        if($nuevo->id_e_ind_fvt > 0) {
            $e = entrevista_individual::find($nuevo->id_e_ind_fvt);
        }
        elseif($nuevo->id_entrevista_etnica > 0) {
            $e = entrevista_etnica::find($nuevo->id_entrevista_etnica);
        }
        if($e) {
            traza_actividad::create(['id_objeto'=>105, 'id_accion'=>3, 'codigo'=>$e->entrevista_codigo, 'referencia'=>'VI / EE' , 'id_primaria'=>$nuevo->id_entrevista]);
        }
        else {
            Log::warning("No se pudo registrar la traza de un consentimiento informado".PHP_EOL.\GuzzleHttp\json_encode($nuevo));
        }

      $request->id_entrevista = $nuevo->id_entrevista;

      if (!is_null($request->testigo_nombre)) {

          $nuevo->almacenar_testigos($request);
      }

      $nuevo->almacenar_acompanamiento($request);
      //Procesar la Responsabilidad
      //$nuevo->grabar_responsabilidades($request->presunta_responsabilidad);
      return $nuevo;
    }

    //Versión mejorada el 25/nov/2020
    public static function nuevo_procesar_request($request){
        $existe = false;
        $consentimiento = false;
        if(isset($request->id_e_ind_fvt)) {
            if($request->id_e_ind_fvt > 0) {
                $existe = entrevista::where("id_e_ind_fvt", $request->id_e_ind_fvt)->orderby('id_entrevista')->first();
            }
            if(!$existe) {
                $consentimiento = new entrevista();
                $consentimiento->id_e_ind_fvt = $request->id_e_ind_fvt;
            }
            else {
                $consentimiento = $existe;
            }
        }
        elseif(isset($request->id_entrevista_etnica)) {
            if($request->id_entrevista_etnica > 0) {
                $existe = entrevista::where("id_entrevista_etnica", $request->id_entrevista_etnica)->orderby('id_entrevista')->first();
            }
            if(!$existe) {
                $consentimiento = new entrevista();
                $consentimiento->id_entrevista_etnica = $request->id_entrevista_etnica;
            }
            else {
                $consentimiento = $existe;
            }
        }

        //Encontrado o creado
        if($consentimiento) {
            $consentimiento->fill($request->all());
            if($consentimiento->id_entrevista > 0) {
                $consentimiento->update_ent = \Auth::user()->id_entrevistador;
                $consentimiento->update_fh = \Carbon\Carbon::now();
                $consentimiento->update_ip = \Request::ip();
                $id_accion=4;  //update
            }
            else {
                $consentimiento->insert_ent = \Auth::user()->id_entrevistador;
                $consentimiento->insert_fh = \Carbon\Carbon::now();
                $consentimiento->insert_ip = \Request::ip();
                $id_accion=3;  //insert
            }
            $consentimiento->save();
            //Traza
            if($consentimiento->id_e_ind_fvt > 0) {
                $e = entrevista_individual::find($consentimiento->id_e_ind_fvt);
            }
            elseif($consentimiento->id_entrevista_etnica > 0) {
                $e = entrevista_etnica::find($consentimiento->id_entrevista_etnica);
            }
            if($e) {
                traza_actividad::create(['id_objeto'=>105, 'id_accion'=>$id_accion, 'codigo'=>$e->entrevista_codigo, 'referencia'=>'VI / EE' , 'id_primaria'=>$consentimiento->id_entrevista]);
            }
            else {
                Log::warning("No se pudo registrar la traza de un consentimiento informado".PHP_EOL.\GuzzleHttp\json_encode($nuevo));
            }
        }



        $request->id_entrevista = $consentimiento->id_entrevista;

        if (!is_null($request->testigo_nombre)) {
            $consentimiento->almacenar_testigos($request);
        }

        $consentimiento->almacenar_acompanamiento($request);
        //Procesar la Responsabilidad
        //$nuevo->grabar_responsabilidades($request->presunta_responsabilidad);
        return $consentimiento;
    }

    public static function actualiza_procesar_request($request){

        if (isset($request->id_e_ind_fvt)) {

            if ($request->id_e_ind_fvt > 0) {

                $actualiza = entrevista::where("id_e_ind_fvt",$request->id_e_ind_fvt)->first();
            }
            
        } elseif (isset($request->id_entrevista_etnica)){            

            if ($request->id_entrevista_etnica > 0) {

                $actualiza = entrevista::where("id_entrevista_etnica",$request->id_entrevista_etnica)->first();

                if ($actualiza == null) {
                    $actualiza = new entrevista($request->all());                
                    $actualiza->save();
                }
            }
            
        }

      $input = $request->all();
      $actualiza->fill($input);

      if (!is_null($request->testigo_nombre)) {

         $actualiza->almacenar_testigos($request);
      }
     
      $actualiza->almacenar_acompanamiento($request);

      $actualiza->update();
      //$request->id_entrevista = $actualiza->id_entrevista;

      $actualiza->update_ent = \Auth::user()->id_entrevistador;
      $actualiza->update_fh = \Carbon\Carbon::now();
      $actualiza->update_ip = \Request::ip();
      //Procesar la Responsabilidad
      //$nuevo->grabar_responsabilidades($request->presunta_responsabilidad);
      return $actualiza;
    }


    // Identifica si es una entrevista etnica o individual
    public function tipo_entrevista() {

        if (!is_null($this->id_entrevista_etnica)) {

            if ($this->id_entrevista_etnica>=0) {

                return 'etnica';
            }
                
        } else if (!is_null($this->id_e_ind_fvt)) {

            if ($this->id_e_ind_fvt >0) {

                return 'individual';
            }
        } 

        return 'Error';
    }


    public function getfmtnombreautoridadetnicaAttribute()
    {
        if (!empty($this->nombre_autoridad_etnica))
            return $this->nombre_autoridad_etnica;

        return "No registra";
    }

    public function getfmtnombreidentitarioAttribute()
    {
        if (!empty($this->nombre_identitario))
            return $this->nombre_identitario;
            
        return "No registra";
    }    

    public function getfmtgrabarvideoAttribute()
    {
        return $this->grabar_video==1 ? "Sí" : "No";
    }

    public function getfmttomarfotografiaAttribute()
    {
        return $this->tomar_fotografia==1 ? "Sí" : "No";
    }

    public function getfmtidpueblorepresentadoAttribute() {

        if(!empty($this->id_pueblo_representado)) {
            return $this->rel_id_pueblo_representado->descripcion;
        }
        return "No registra";
    }


    //Consentimeinto informado de CO
    public function rel_id_entrevista_colectiva() {
        return $this->belongsTo(entrevista_colectiva::class,'id_entrevista_colectiva','id_entrevista_colectiva');
    }
    //Consentimeinto informado de EE
    public function rel_id_entrevista_etnica() {
        return $this->belongsTo(entrevista_etnica::class,'id_entrevista_etnica','id_entrevista_etnica');
    }
    //Consentimeinto informado de DC
    public function rel_id_diagnostico_comunitario() {
        return $this->belongsTo(diagnostico_comunitario::class,'id_diagnostico_comunitario','id_diagnostico_comunitario');
    }


    //En jul-22 hubo valores duplicados en las fichas de monitoreo
    // este procedimiento las identifica y marca
    public static function marcar_duplicados() {
        $inicio = Carbon::now();
        Log::notice("Marcar consentimientos duplicados: inicio del proceso");
        $total_casos=0;
        ///---------

        // Buscar duplicados
        $sql = "select id_e_ind_fvt
                    , id_entrevista_colectiva
                    , id_entrevista_etnica
                    , id_entrevista_profundidad
                    , id_diagnostico_comunitario
                    , id_historia_vida
                    , consentimiento_nombres
                    , consentimiento_apellidos
                    , count(1) as conteo
                    from fichas.entrevista
                where consentimiento_nombres is not null
                group by 1,2,3,4,5,6,7,8
                having count(1) > 1
                order by consentimiento_nombres, consentimiento_apellidos";
        $listado = \DB::select(\DB::raw($sql));
        $total_casos = count($listado);

        //Evaluar cada caso
        foreach($listado as $revision) {
            $duplicados = entrevista::where('id_e_ind_fvt',$revision->id_e_ind_fvt)
                                    ->where('id_entrevista_colectiva',$revision->id_entrevista_colectiva)
                                    ->where('id_entrevista_etnica',$revision->id_entrevista_etnica)
                                    ->where('id_entrevista_profundidad',$revision->id_entrevista_profundidad)
                                    ->where('id_diagnostico_comunitario',$revision->id_diagnostico_comunitario)
                                    ->where('id_historia_vida',$revision->id_historia_vida)
                                    ->where('consentimiento_nombres',$revision->consentimiento_nombres)
                                    ->where('consentimiento_apellidos',$revision->consentimiento_apellidos)
                                    ->get();
            $caso=[];
            foreach($duplicados as $item) {
                $caso[$item->id_entrevista]=0;
                //Punto por tener sexo
                if($item->consentimiento_sexo > 0) {
                    $caso[$item->id_entrevista]++;
                }
                // Punto por ser consentimiento y no lista de asistencia
                if($item->asistencia <> 1) {
                    $caso[$item->id_entrevista]++;
                }
                // Punto por ser mas restrictiva
                if($item->restrictiva == 1) {
                    $caso[$item->id_entrevista]++;
                }
            }

            //Ordenar el arreglo de casos de mayor a menor
            arsort($caso);
            $primero=false;
            foreach($caso as $id_entrevista=>$punteo) {
                if(!$primero) {
                    $valor=2;
                    $primero=true;
                }
                else {
                    $valor=1;
                }
                entrevista::where('id_entrevista',$id_entrevista)->update(['borrable'=>$valor]);
            }
        }




        //Cierre
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_casos = $total_casos;


        Log::info("Marcar consentimientos duplicados: fin del proceso, $total_casos casos identificados. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }
}
