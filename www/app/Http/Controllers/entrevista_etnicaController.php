<?php

namespace App\Http\Controllers;

use App\Exports\entrevista_resultadosExport;
use App\Exports\entrevistaExport;
use App\Exports\excel_ee_filtradoExport;
use App\Exports\excel_sujeto_colectivoExport;
use App\Http\Requests\Createentrevista_etnicaRequest;
use App\Http\Requests\Updateentrevista_etnicaRequest;
use App\Models\entrevista_colectiva;
use App\Models\entrevista_etnica;
use App\Models\entrevista_etnica_dinamica;
use App\Models\entrevista_etnica_indigena;
use App\Models\entrevista_etnica_interes;
use App\Models\entrevista_etnica_mandato;
use App\Models\entrevista_etnica_narf;
use App\Models\entrevista_etnica_rrom;
use App\Models\entrevista_individual;
use App\Models\entrevistador;
use App\Models\excel_co;
use App\Models\excel_dc;
use App\Models\excel_hv;
use App\Models\excel_sujeto_colectivo;
use App\Models\traza_actividad;
use App\Repositories\entrevista_etnicaRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\entrevista;
use App\Models\hecho;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\entrevista_justicia;
use App\Models\entrevista_impacto;

class entrevista_etnicaController extends AppBaseController
{
    /** @var  entrevista_etnicaRepository */
    private $entrevistaEtnicaRepository;

    public function __construct(entrevista_etnicaRepository $entrevistaEtnicaRepo)
    {
        $this->entrevistaEtnicaRepository = $entrevistaEtnicaRepo;
    }

    /**
     * Display a listing of the entrevista_etnica.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        
        $filtros = entrevista_etnica::filtros_default($request);

        $query = entrevista_etnica::select(\DB::raw('entrevista_etnica.*'))->filtrar($filtros)->ordenar();

        // $debug['sql']= nl2br($query->toSql());
        // $debug['criterios']=$query->getBindings();
        // dd($debug);
        $entrevistaEtnicas = $query->paginate();        

        $total_entrevistas = $entrevistaEtnicas->total();  //Para el formulario de filtros

        $txt_titulo = "Entrevistas EE";
        return view('entrevista_etnicas.index')
            ->with('entrevistaEtnicas', $entrevistaEtnicas)
            ->with('total_entrevistas', $total_entrevistas)
            ->with('txt_titulo',$txt_titulo)
            ->with('filtros', $filtros);
    }

    /**
     * Show the form for creating a new entrevista_etnica.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $id_entrevistador=\Auth::user()->id_entrevistador;
        // A nombre de otro
        if(isset($request->id_entrevistador)) {
            $permitidos = entrevistador::permitidos_acceso_entrevistas();
            if(in_array($request->id_entrevistador,$permitidos)) {
                $id_entrevistador=intval($request->id_entrevistador);
            }
            else {
                $quien = entrevistador::find($request->id_entrevistador);
                $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,5,'0',STR_PAD_LEFT) : "[desconocido]";
                abort(403,"No puede ingresar entrevistas para el entrevistador especificado: $numero");
            }
        }

        //Por defecto, entrevista étnica
        $id_subserie = isset($request->id_subserie) ? $request->id_subserie : config('expedientes.ee');
        $id_subserie = $id_subserie < 1 ? config('expedientes.ee') : $id_subserie;

        $entrevistaEtnica = new entrevista_etnica();
        $entrevistaEtnica->id_subserie=$id_subserie;
        $entrevistaEtnica->valores_iniciales($id_entrevistador);

        
        // $entrevista = entrevista::where('id_entrevista_etnica', $id)->first();

        // if(!is_object($entrevista))
        // {
          $entrevista=new entrevista();
          $entrevista->id_entrevista_etnica=0;
          $entrevista->valores_iniciales();
        // }

        return view('entrevista_etnicas.create', compact('entrevistaEtnica', 'entrevista'));
    }

    /**
     * Store a newly created entrevista_etnica in storage.
     *
     * @param Createentrevista_etnicaRequest $request
     *
     * @return Response
     */
    public function store(Createentrevista_etnicaRequest $request)
    {        
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $id_entrevistador=intval($request->id_entrevistador);

        //Validar número de entrevista
        $entrevista_numero = intval($request->entrevista_numero);
        $existe = entrevista_etnica::where('id_entrevistador',$id_entrevistador)
            ->where('entrevista_numero',$entrevista_numero)
            ->first();
        if(!empty($existe)) {
            Flash::error("Número de entrevista en uso.  No puede duplicar el número $request->entrevista_numero");
            return redirect()->back()->withInput($request->all());
        }

        //Calcular el código
        $entrevista = new entrevista_etnica();
        $entrevista->id_entrevistador=$id_entrevistador;
        $codigo = $entrevista->asignar_codigo($id_entrevistador);  //asigna correlativo y codigo


        $input = $request->all();
        
        //Datos calculados
        $input['entrevista_correlativo']=$entrevista->entrevista_correlativo;
        $input['entrevista_codigo']=$codigo;
        $input['id_entrevistador']=$id_entrevistador;
        $input['id_subserie']=$request->id_subserie;
        $input['id_macroterritorio']=$request->id_territorio_macro;
        $input['id_usuario']=\Auth::user()->id;
        $input['numero_entrevistador']=entrevistador::find($id_entrevistador)->numero_entrevistador;

        //Manejo de fechas
        $input['entrevista_fecha_inicio']=$request->entrevista_fecha_inicio_submit;
        $input['entrevista_fecha_final']=$request->entrevista_fecha_final_submit;
        //$f_hechos=explode(" - ",$request->tema_rango);
        $input['tema_del'] = Carbon::createFromFormat("Y/m/d",$request->tema_anio_del."/01/01")->format("Y-m-d");
        $input['tema_al']  = Carbon::createFromFormat("Y/m/d",$request->tema_anio_al."/12/31")->format("Y-m-d");

        // Idioma Español por defecto
        $request['id_idioma']=177;

        try {
            $nueva = new entrevista_etnica();
            $nueva->fill($input);
            $nueva->clasificar_acceso();
            $nueva->save();

            //Mandato
            if(!is_array($request->mandato)) {
                $request->mandato=array($request->mandato);
            }
            foreach($request->mandato as $id) {
                $tmp['id_entrevista_etnica'] = $nueva->id_entrevista_etnica;
                $tmp['id_mandato']=$id;
                entrevista_etnica_mandato::create($tmp);
            }
            // Nucleos tematicos
            if(!is_array($request->interes)) {
                $request->interes=array($request->interes);
            }
            foreach($request->interes as $id) {
                $tmp['id_entrevista_etnica'] = $nueva->id_entrevista_etnica;
                $tmp['id_interes']=$id;
                entrevista_etnica_interes::create($tmp);
            }
            //Dinámicas
            if(!is_array($request->dinamica)) {
                $request->dinamica=array($request->dinamica);
            }
            foreach($request->dinamica as $txt) {
                if(strlen($txt)>0) {
                    $tmp['id_entrevista_etnica'] = $nueva->id_entrevista_etnica;
                    $tmp['dinamica'] = $txt;
                    entrevista_etnica_dinamica::create($tmp);
                }
            }

            //Pueblos indigenas
            if(!is_array($request->indigena)) {
                $request->indigena=array($request->indigena);
            }
            foreach($request->indigena as $id) {
                if($id>0) {
                    $tmp['id_entrevista_etnica'] = $nueva->id_entrevista_etnica;
                    $tmp['id_indigena'] = $id;
                    entrevista_etnica_indigena::create($tmp);
                }
            }
            //Pueblos afro
            if(!is_array($request->narp)) {
                $request->narp=array($request->narp);
            }
            foreach($request->narp as $id) {
                if($id>0) {
                    $tmp['id_entrevista_etnica'] = $nueva->id_entrevista_etnica;
                    $tmp['id_narf'] = $id;
                    entrevista_etnica_narf::create($tmp);
                }
            }
            //Pueblos rrom
            if(!is_array($request->rrom)) {
                $request->rrom=array($request->rrom);
            }
            foreach($request->rrom as $id) {
                if($id>0) {
                    $tmp['id_entrevista_etnica'] = $nueva->id_entrevista_etnica;
                    $tmp['id_rrom'] = $id;
                    entrevista_etnica_rrom::create($tmp);
                }
            }

            // Consentimiento informado
            $request['id_entrevista_etnica']=$nueva->id_entrevista_etnica;            
            entrevista::nuevo_procesar_request($request);


            Flash::success('Información almacenada exitosamente.');
            //Traza de seguridad
            traza_actividad::create(['id_objeto'=>14, 'id_accion'=>3, 'codigo'=>$codigo, 'id_primaria'=>$nueva->id_entrevista_etnica]);

            return redirect()->action('entrevista_etnicaController@gestionar_adjuntos',$nueva->id_entrevista_etnica);

        }
        catch (\Exception $e) {
            Flash::error('Problemas al grabar la información: '.$e->getMessage());
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified entrevista_etnica.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //Negar acceso a los de solo estadistica
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        //1: Confirmar que  que exista
        $entrevistaEtnica = $this->entrevistaEtnicaRepository->findWithoutFail($id);
        if (empty($entrevistaEtnica)) {
            Flash::error("Entrevista etnica no existe($id)");
            return redirect(action('entrevista_etnicaController@index'));
        }

        //2: Confirmar acceso del usuario a la entrevista
        if(!$entrevistaEtnica->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Registrar traza
        traza_actividad::create(['id_objeto'=>14, 'id_accion'=>6, 'codigo'=>$entrevistaEtnica->entrevista_codigo, 'id_primaria'=>$id]);


        //Para el navegador
        $txt_titulo = "Ent. ".$entrevistaEtnica->entrevista_codigo;

        return view('entrevista_etnicas.show')->with('entrevistaEtnica', $entrevistaEtnica)->with('txt_titulo',$txt_titulo);
    }

    /**
     * Show the form for editing the specified entrevista_etnica.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {   
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $entrevistaEtnica = entrevista_etnica::find($id);
        if (empty($entrevistaEtnica)) {
            Flash::error('Entrevista etnica no existe');
            return redirect(action('entrevista_etnicaController@index'));
        }
        if(!$entrevistaEtnica->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }
        //Permisos de escritura
        if(!$entrevistaEtnica->puede_modificar_entrevista()) {
            abort(403,"No puede modificar esta entrevista");
        }

        $entrevista = entrevista::where('id_entrevista_etnica', $id)->orderby('id_entrevista')->first();
        //dd($entrevista);

        if(!is_object($entrevista))
        {
          $entrevista=new entrevista();
          $entrevista->valores_iniciales();
          $entrevista->id_entrevista_etnica = $id;
        }

        $conteos = $entrevistaEtnica->conteo_fichas();

        $m_aut = "";

        if (isset($_GET) && count($_GET) > 0) {

            $m_aut = (isset($_GET['m_aut']) && $_GET['m_aut']=="") ? "edt_ci" : "error";
        }
        

        $hecho_id = (isset($_GET['id_hecho'])) ? 0 : "";
        
        if (\Session::get('id_hecho')) {
            
            $hecho_id = \Session::get('id_hecho');
        }

        if ($m_aut == "error") {
            return redirect()->action(
                'entrevista_etnicaController@fichas', ['id' => $id]
            );      
        }
        
        return view('entrevista_etnicas.edit')->with(compact('entrevistaEtnica', 'entrevista', 'conteos', 'hecho_id', 'm_aut'));
    }

    /**
     * Update the specified entrevista_etnica in storage.
     *
     * @param  int              $id
     * @param Updateentrevista_etnicaRequest $request
     *
     * @return Response
     */
    public function update($id, Updateentrevista_etnicaRequest $request)
    {        
        
        $entrevista = entrevista_etnica::find($id);
        // Idioma Español por defecto
        $request['id_idioma']=177;

        if (empty($entrevista)) {
            Flash::error("Entrevista etnica ($id) no existe");
            return redirect(action('entrevista_etnicaController@index'));
        }
        //Leer el request y meterlo a un arreglo
        $input = $request->all();

        //Revisar que el número no se duplique
        $existe = entrevista_etnica::where('id_entrevistador',$request->id_entrevistador)
            ->where('entrevista_numero',$request->entrevista_numero)
            ->where('id_entrevista_etnica','<>',$id)
            ->first();
        if(!empty($existe)) {
            Flash::error("Número de entrevista en uso.  No puede duplicar el número $request->entrevista_numero");
            return redirect()->back()->withInput($request->all());
        }
        //Datos Calculados
        //El correlativo no puede cambiar
        unset($input['entrevista_correlativo']);
        //El entrevistador no puede cambiar
        unset($input['id_entrevistador']);
        //El numero de entrevistador no puede cambiar
        unset($input['numero_entrevistador']);


        if ($entrevista::si_valida_campos()) {

            //Macroterritorio
            $input['id_macroterritorio'] = $request->id_territorio_macro;
            //Fechas
            $input['entrevista_fecha_inicio']=$request->entrevista_fecha_inicio_submit;        
            $input['entrevista_fecha_final']=$request->entrevista_fecha_final_submit;
            $input['tema_del'] = Carbon::createFromFormat("Y/m/d",$request->tema_anio_del."/01/01")->format("Y-m-d");
            $input['tema_al']  = Carbon::createFromFormat("Y/m/d",$request->tema_anio_al."/12/31")->format("Y-m-d");
        }


        // dd($input);

        //Actualizar la BD
        $entrevista->fill($input);
        
        //Clasificar reservada-3 o reservada-4
        $entrevista->clasificar_acceso();
        //Recalcular el código, usar el entrevistador que tiene, no el logueado por aquello que otro lo modifique
        $entrevista->entrevista_codigo = $entrevista->calcular_codigo();
        //Grabar en la BD
        $entrevista->save();


        if ($entrevista::si_valida_campos()) {

        //Entidades débiles
            $entrevista->rel_mandato()->delete();
            if (!is_array($request->mandato)) {
                $request->mandato=array($request->mandato);
            }
            foreach ($request->mandato as $id) {
                $tmp['id_entrevista_etnica'] = $entrevista->id_entrevista_etnica;
                $tmp['id_mandato']=$id;
                $registro = entrevista_etnica_mandato::create($tmp);
            }
            // Nucleos tematicos
            $entrevista->rel_interes()->delete();
            if (!is_array($request->interes)) {
                $request->interes=array($request->interes);
            }
            foreach ($request->interes as $id) {
                $tmp['id_entrevista_etnica'] = $entrevista->id_entrevista_etnica;
                $tmp['id_interes']=$id;
                entrevista_etnica_interes::create($tmp);
            }
            //Dinámicas
            $entrevista->rel_dinamica()->delete();
            if (!is_array($request->dinamica)) {
                $request->dinamica=array($request->dinamica);
            }
            foreach ($request->dinamica as $txt) {
                if (strlen($txt)>0) {
                    $tmp['id_entrevista_etnica'] = $entrevista->id_entrevista_etnica;
                    $tmp['dinamica'] = $txt;
                    entrevista_etnica_dinamica::create($tmp);
                }
            }

            //Pueblos indigenas
            $entrevista->rel_indigena()->delete();
            if (!is_array($request->indigena)) {
                $request->indigena=array($request->indigena);
            }
            foreach ($request->indigena as $id) {
                if ($id>0) {
                    $tmp['id_entrevista_etnica'] = $entrevista->id_entrevista_etnica;
                    $tmp['id_indigena']=$id;
                    entrevista_etnica_indigena::create($tmp);
                }
            }
            //Pueblos afro
            $entrevista->rel_narp()->delete();
            if (!is_array($request->narp)) {
                $request->narp=array($request->narp);
            }
            foreach ($request->narp as $id) {
                if ($id>0) {
                    $tmp['id_entrevista_etnica'] = $entrevista->id_entrevista_etnica;
                    $tmp['id_narf'] = $id;
                    entrevista_etnica_narf::create($tmp);
                }
            }
            //Pueblos rrom
            $entrevista->rel_rrom()->delete();
            if (!is_array($request->rrom)) {
                $request->rrom=array($request->rrom);
            }
            foreach ($request->rrom as $id) {
                if ($id>0) {
                    $tmp['id_entrevista_etnica'] = $entrevista->id_entrevista_etnica;
                    $tmp['id_rrom'] = $id;
                    entrevista_etnica_rrom::create($tmp);
                }
            }
        }

        $request['id_entrevista_etnica']=$entrevista->id_entrevista_etnica;

        //  Log::info($request);
        // entrevista::nuevo_procesar_request($request);
        
        // $actualiza = entrevista::where("id_entrevista_etnica",$request->id_entrevista_etnica)->first();

        //entrevista::actualiza_procesar_request($request);
        $con_infor = entrevista::nuevo_procesar_request($request);
        //dd($con_infor);

        //Registrar traza
        traza_actividad::create(['id_objeto'=>14, 'id_accion'=>4, 'codigo'=>$entrevista->entrevista_codigo , 'id_primaria'=>$entrevista->id_entrevista_etnica]);
        // Notificar y redirigir
        Flash::success('Entrevista actualizada.');



        // Si viene la variable id_hecho actualiza el consentimiento informado y redirige a la ficha de hechos
        if (isset($request['id_hecho']) && $request['id_hecho'] > 0) {

            $hecho = hecho::find($request['id_hecho']);
            if(!empty($hecho)) {

                if ($hecho->tipo_expediente()=='etnica') {

                    return redirect()->action(
                        'hechoController@edit', ['id' => $hecho->id_hecho]
                    );
                }
            }
                

        }
        

        if (!$entrevista::si_valida_campos()) {

            return redirect()->action(
                'entrevista_etnicaController@fichas', ['id' => $entrevista->id_entrevista_etnica]
            );                    
        }

        return redirect(action("entrevista_etnicaController@show",$entrevista->id_entrevista_etnica));


    }

    /**
     * Remove the specified entrevista_etnica from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        abort(403);
        $entrevistaEtnica = $this->entrevistaEtnicaRepository->findWithoutFail($id);

        if (empty($entrevistaEtnica)) {
            Flash::error('Entrevista Etnica not found');

            return redirect(route('entrevistaEtnicas.index'));
        }

        $this->entrevistaEtnicaRepository->delete($id);

        Flash::success('Entrevista Etnica deleted successfully.');

        return redirect(route('entrevistaEtnicas.index'));
    }


    //Para la gestión de adjuntos
    public function gestionar_adjuntos($id) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        //Revisar que exista
        $entrevista = entrevista_etnica::find($id);
        if (empty($entrevista)) {
            Flash::error("Entrevista colectiva no existe($id)");
            return redirect(route('entrevista_colectivaController@index'));
        }

        if (empty($entrevista)) {
            Flash::error("Entrevista colectiva no existe($id)");
            return redirect(route('entrevista_colectivaController@index'));
        }


        //Ver que tenga permisos
        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Permisos de escritura
        if(!$entrevista->puede_modificar_entrevista()) {
            abort(403,"No puede modificar esta entrevista");
        }


        //Segundo chequeo: reservado-3
        if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
        }

        $conteos = $entrevista->conteo_fichas();


        return view('entrevista_etnicas.gestionar_adjuntos')->with('entrevistaEtnica', $entrevista)->with('conteos', $conteos);
    }


    //Para refrescar por ajax la tabla luego del upload
    public function tabla_adjuntos($id) {
        $entrevista = entrevista_etnica::find($id);
        if(!$entrevista) {
            abort(403,"Entrevista ($id) no existe");
        }

        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }
        return view('entrevista_etnicas.tabla_adjuntos')->with('entrevistaEtnica', $entrevista);
    }

    //PAra los autofill
    public function autofill_tema_descripcion(Request $request) {
        return entrevista_etnica::listar_opciones_campo('tema_descripcion',$request->texto);
    }
    public function autofill_tema_objetivo(Request $request) {
        return entrevista_etnica::listar_opciones_campo('tema_objetivo',$request->texto);
    }
    public function autofill_eventos_descripcion(Request $request) {
        return entrevista_etnica::listar_opciones_campo('eventos_descripcion',$request->texto);
    }
    public function autofill_observaciones(Request $request) {
        return entrevista_etnica::listar_opciones_campo('observaciones',$request->texto);
    }
    public function autofill_titulo(Request $request) {
        return entrevista_etnica::listar_opciones_campo('titulo',$request->texto);
    }
    public function autofill_dinamica(Request $request) {
        return entrevista_etnica::listar_opciones_dinamica($request->texto);
    }

    //Autorizar acceso a R3 y R4
    public function desclasificar($id)
    {
        //Negar acceso a los de solo estadistica
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        //1: Confirmar que  que exista
        $entrevistaEtnica =entrevista_etnica::find($id);
        if (empty($entrevistaEtnica)) {
            abort(403, "No existe la entrevista indicada:$id");
        }

        //2: Confirmar acceso del usuario a la entrevista
        if(!$entrevistaEtnica->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Revisar privilegios de R3
        if(!$entrevistaEtnica->puede_desclasificar_entrevista()) {
            abort(403, "No puede modificar la entrevista.");
        }

        //Revisar que requiera clasificacion
        if($entrevistaEtnica->clasificacion_nivel > 3 ) {
            abort(403, "Esta es una entrevista clasificacion R-$entrevistaEtnica->clasificacion_nivel.");
        }



        return view('entrevista_etnicas.desclasificar',compact('entrevistaEtnica'));
    }

    //Diligenciar los formularios
    public  function fichas($id) {
        
        $expediente = entrevista_etnica::find($id);

        if (empty($expediente)) {
            Flash::error("Entrevista a sujeto colectivo no existe($id)");
            return redirect(route('entrevistaEtnicas.index'));
        }

        //Ver que tenga permisos de acceso a la entrevista
        if(!$expediente->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Segundo chequeo: reservado-3
        if(!$expediente->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO.");
        }

        //Ver que tenga permisos de modificar la ficha
        $permisos = $expediente->permitir_modificar_fichas();
        if($permisos->permitido) {
            $conteos = $expediente->conteo_fichas();           

            // Busca datos de la entrevista
            $entrevista = entrevista::where('id_entrevista_etnica', $expediente->id_entrevista_etnica)->first();

            if (is_null($entrevista)) {
                $entrevista = new entrevista();
            }
            
            return view("entrevista_etnicas.fichas",compact('expediente', 'conteos', 'entrevista'));
        }
        else {
            abort(403,$permisos->texto);
        }

    }    

        // Grabar comentarios de la diligenciada
        public function grabar_comentarios(Request $request) {

            $entrevista = entrevista_etnica::find($request->id_entrevista_etnica);
            if($entrevista) {
                $entrevista->observaciones_diligenciada = $request->observaciones_diligenciada;
                $entrevista->save();
            }
            return redirect()->back();
        }



    //Mostar los formularios
    public  function fichas_show($id) {

        $show = "show";
        $expediente = entrevista_etnica::find($id);

        if (empty($expediente)) {
            Flash::error("Entrevista étnica no existe (fsh)($id)");
            return redirect(route('entrevistaEtnica.index'));
        }

        //Ver que tenga permisos de acceso a la entrevista
        if(!$expediente->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Segundo chequeo: reservado-3
        if(!$expediente->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
        }


        //Ver que tenga permisos de consultar la ficha
        $permisos = $expediente->permitir_ver_fichas();
        if($permisos->permitido) {
            $conteos = $expediente->conteo_fichas();
            $no_editar=true;

            // Para mostrar los impactos
            $hay_justicia = entrevista_justicia::entrevista($id)->first();
            $entrevista_justicia = $hay_justicia ? $hay_justicia : new entrevista_justicia();

            $hay_encabezado = entrevista_impacto::entrevista($id)->wherenull('id_impacto')->first();
            if($hay_encabezado) {
                $impacto =$hay_encabezado;
            }
            else {
                $impacto=new \stdClass();
                $impacto->transgeneracionales="";
                $impacto->afrentamiento_proceso="";
            }

            $entrevista = entrevista::where('id_entrevista_etnica', $expediente->id_entrevista_etnica)->first();

            return view("entrevista_etnicas.fichas",compact('expediente','conteos','no_editar','entrevista_justicia','impacto', 'entrevista', 'show'));
        }
        else {
            abort(403,$permisos->texto);
        }

    }        

    // Anular/recuperar una entrevista
    public  function anular($id) {
        $this->authorize('nivel-1');
        $expediente = entrevista_etnica::find($id);
        $expediente->id_activo = $expediente->id_activo == 1 ? 2 : 1 ;
        $expediente->save();
        $codigo = $expediente->entrevista_codigo;
        $verbo = $expediente->id_activo == 1 ? "recuperado" : "anulado";
        traza_actividad::create(['id_objeto'=>14, 'id_accion'=>10, 'referencia'=>$verbo ,'codigo'=>$expediente->entrevista_codigo, 'id_primaria'=>$id]);

        return redirect(action('entrevista_etnicaController@show',$id));
        //return ("Expediente $codigo $verbo");

    }

    //Generar tabla plana
    public function generar_excel_plano() {
        $respuesta = new \stdClass();
        $respuesta->ee = excel_sujeto_colectivo::generar_plana();
        $respuesta->co = excel_co::generar_plana();
        $respuesta->dc = excel_dc::generar_plana();
        $respuesta->hv = excel_hv::generar_plana();
        return response()->json($respuesta);
    }
    //Descargar tabla plana
    public function descargar_excel() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>14, 'id_accion'=>8]);
        return Excel::download(new excel_sujeto_colectivoExport(),"entrevistas_sujeto_colectivo_$fecha.xlsx");
    }
    public function descargar_excel_anonimo() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>14, 'id_accion'=>8]);
        return Excel::download(new excel_sujeto_colectivoExport(true),"entrevistas_sujeto_colectivo_anonimo_$fecha.xlsx");
    }

    //Descargar tabla plana para resultados específicos
    public function generar_excel_filtrado(Request $request) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $filtros = entrevista_etnica::filtros_default($request);
        //dd($filtros);
        $query = entrevista_etnica::filtrar($filtros);
        //$debug['sql']= nl2br($query->toSql());
        //$debug['criterios']=$query->getBindings();
        //dd($debug);
        //$cantidad = $filtros->id_entrevistador == optional(\Auth::user())->id_entrevistador ? 30 : 15;
        $arreglo = $query->orderby('entrevista_etnica.id_entrevista_etnica')->pluck('entrevista_etnica.id_entrevista_etnica')->toArray();

        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>14, 'id_accion'=>8]);

        $anonimo = \Gate::denies('nivel-1');
        $txt = $anonimo ? '_anom_' : '_';

        return Excel::download(new excel_ee_filtradoExport($arreglo,$anonimo),"entrevistas_sujeto_colectivo_res$txt$fecha.xlsx");
    }


}
