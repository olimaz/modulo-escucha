<?php

namespace App\Http\Controllers;

use App\Exports\entrevista_prExport;
use App\Exports\entrevista_pr_resultadosExport;
use App\Exports\entrevistaExport;
use App\Http\Requests\Createentrevista_profundidadRequest;
use App\Http\Requests\Updateentrevista_profundidadRequest;
use App\Models\entrevista;
use App\Models\entrevista_etnica;
use App\Models\entrevista_individual;
use App\Models\entrevista_profundidad;
use App\Models\entrevista_profundidad_dinamica;
use App\Models\entrevista_profundidad_interes;
use App\Models\entrevista_profundidad_mandato;
use App\Models\entrevista_profundidad_tema;
use App\Models\entrevista_profundidad_violencia_actor;
use App\Models\entrevista_profundidad_violencia_victima;
use App\Models\entrevistador;
use App\Models\excel_entrevista;
use App\Models\excel_entrevista_pr;
use App\Models\traza_actividad;
use App\Repositories\entrevista_profundidadRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class entrevista_profundidadController extends AppBaseController
{
    /** @var  entrevista_profundidadRepository */
    private $entrevistaProfundidadRepository;

    public function __construct(entrevista_profundidadRepository $entrevistaProfundidadRepo)
    {
        $this->entrevistaProfundidadRepository = $entrevistaProfundidadRepo;
    }

    /**
     * Display a listing of the entrevista_profundidad.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $filtros = entrevista_profundidad::filtros_default($request);

        $query = entrevista_profundidad::filtrar($filtros)->ordenar();
        //$debug['sql']= nl2br($query->toSql());
        //$debug['criterios']=$query->getBindings();
        //dd($debug);
        $cantidad = $filtros->id_entrevistador == optional(\Auth::user())->id_entrevistador ? 30 : 15;
        $entrevistaProfundidads = $query->select(\DB::raw('entrevista_profundidad.*'))->distinct()->paginate($cantidad);
        $total_entrevistas = $entrevistaProfundidads->total();  //Para el formulario de filtros

        $txt_titulo = "Entrevistas PR";
        return view('entrevista_profundidads.index')
            ->with('entrevistaProfundidads', $entrevistaProfundidads)
            ->with('total_entrevistas', $total_entrevistas)
            ->with('txt_titulo',$txt_titulo)
            ->with('filtros', $filtros);
    }

    /**
     * Show the form for creating a new entrevista_profundidad.
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
        $entrevistaProfundidad = new entrevista_profundidad();
        $entrevistaProfundidad->valores_iniciales($id_entrevistador);
        return view('entrevista_profundidads.create',compact('entrevistaProfundidad'));
    }

    /**
     * Store a newly created entrevista_profundidad in storage.
     *
     * @param Createentrevista_profundidadRequest $request
     *
     * @return Response
     */
    public function store(Createentrevista_profundidadRequest $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $id_entrevistador=intval($request->id_entrevistador);
        /*
        $id_entrevistador=\Auth::user()->id_entrevistador;
        if(isset($request->id_entrevistador)) {
            $permitidos = entrevistador::permitidos_acceso_entrevistas();
            if(in_array($request->id_entrevistador,$permitidos)) {
                $id_entrevistador=intval($request->id_entrevistador);
            }
            else {
                $quien = entrevistador::find($request->id_entrevistador);
                $numero = isset($quien->numero_entrevistador) ? str_pad($quien->numero_entrevistador,5,'0',STR_PAD_LEFT) : "[desconocido]";
                abort(403,"No puede ingresar casos/informes para el entrevistador especificado: $numero");
            }
        }
        */

        //Validar número de entrevista
        $entrevista_numero = intval($request->entrevista_numero);
        $existe = entrevista_profundidad::where('id_entrevistador',$id_entrevistador)
            ->where('entrevista_numero',$entrevista_numero)
            ->first();
        if(!empty($existe)) {
            Flash::error("Número de entrevista en uso.  No puede duplicar el número $request->entrevista_numero");
            return redirect()->back()->withInput($request->all());
        }

        //Calcular el código
        $entrevista = new entrevista_profundidad();
        $entrevista->id_entrevistador=$id_entrevistador;
        $codigo = $entrevista->asignar_codigo($id_entrevistador);  //asigna correlativo y codigo



        $input = $request->all();
        //Datos calculados
        $input['entrevista_correlativo']=$entrevista->entrevista_correlativo;
        $input['entrevista_codigo']=$codigo;
        $input['id_entrevistador']=$id_entrevistador;
        $input['id_macroterritorio']=$request->id_territorio_macro;
        $input['id_usuario']=\Auth::user()->id;
        $input['numero_entrevistador']=entrevistador::find($id_entrevistador)->numero_entrevistador;

        //Manejo de fechas
        $input['entrevista_fecha_inicio']=$request->entrevista_fecha_inicio_submit;
        $input['entrevista_fecha_final']=$request->entrevista_fecha_final_submit;



        try {
            $nueva = new entrevista_profundidad();
            $nueva->fill($input);
            $nueva->clasificar_acceso();
            $nueva->save();
            //Consentimiento informado
            $nueva->procesar_consentimiento($request);

            //Mandato
            if(!is_array($request->mandato)) {
                $request->mandato=array($request->mandato);
            }
            foreach($request->mandato as $id) {
                $tmp['id_entrevista_profundidad'] = $nueva->id_entrevista_profundidad;
                $tmp['id_mandato']=$id;
                entrevista_profundidad_mandato::create($tmp);
            }
            //Temas
            if(!is_array($request->tema)) {
                $request->tema=array($request->tema);
            }
            foreach($request->tema as $txt) {
                if(strlen($txt)>0) {
                    $tmp['id_entrevista_profundidad'] = $nueva->id_entrevista_profundidad;
                    $tmp['tema']=trim($txt);
                    entrevista_profundidad_tema::create($tmp);
                }
            }
            //Interes
            if(!is_array($request->interes)) {
                $request->interes=array($request->interes);
            }
            foreach($request->interes as $id) {
                $tmp['id_entrevista_profundidad'] = $nueva->id_entrevista_profundidad;
                $tmp['id_interes']=$id;
                entrevista_profundidad_interes::create($tmp);
            }
            // Violencia victima
            if(!is_array($request->id_violencia_victima)) {
                $request->id_violencia_victima=array($request->id_violencia_victima);
            }
            foreach($request->id_violencia_victima as $id) {
                if($id>0) {
                    $tmp['id_entrevista_profundidad'] = $nueva->id_entrevista_profundidad;
                    $tmp['id_violencia']=$id;
                    entrevista_profundidad_violencia_victima::create($tmp);
                }

            }
            // Violencia actor
            if(!is_array($request->id_violencia_actor)) {
                $request->id_violencia_actor=array($request->id_violencia_actor);
            }
            foreach($request->id_violencia_actor as $id) {
                if($id >0 ){
                    $tmp['id_entrevista_profundidad'] = $nueva->id_entrevista_profundidad;
                    $tmp['id_violencia']=$id;
                    entrevista_profundidad_violencia_actor::create($tmp);
                }
            }


            //Dinámicas
            if(!is_array($request->dinamica)) {
                $request->dinamica=array($request->dinamica);
            }
            foreach($request->dinamica as $txt) {
                if(strlen($txt)>0) {
                    $tmp['id_entrevista_profundidad'] = $nueva->id_entrevista_profundidad;
                    $tmp['dinamica'] = $txt;
                    entrevista_profundidad_dinamica::create($tmp);
                }
            }
            //Traza de seguridad
            traza_actividad::create(['id_objeto'=>11, 'id_accion'=>3, 'codigo'=>$codigo, 'id_primaria'=>$nueva->id_entrevista_profundidad]);

            return redirect()->action('entrevista_profundidadController@gestionar_adjuntos',$nueva->id_entrevista_profundidad);

        }
        catch (\Exception $e) {
            Flash::error('Problemas al grabar la información: '.$e->getMessage());
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified entrevista_profundidad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }


        $entrevistaProfundidad = $this->entrevistaProfundidadRepository->findWithoutFail($id);

        if (empty($entrevistaProfundidad)) {
            Flash::error('Entrevista Profundidad no existe');
            return redirect(route('entrevistaProfundidads.index'));
        }

        if(!$entrevistaProfundidad->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Registrar traza
        traza_actividad::create(['id_objeto'=>11, 'id_accion'=>6, 'codigo'=>$entrevistaProfundidad->entrevista_codigo, 'id_primaria'=>$entrevistaProfundidad->id_entrevista_profundidad]);

        $txt_titulo = "Ent. ".$entrevistaProfundidad->entrevista_codigo;
        return view('entrevista_profundidads.show')->with('entrevistaProfundidad', $entrevistaProfundidad)->with('txt_titulo',$txt_titulo);
    }

    /**
     * Show the form for editing the specified entrevista_profundidad.
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
        $entrevistaProfundidad = $this->entrevistaProfundidadRepository->findWithoutFail($id);

        if (empty($entrevistaProfundidad)) {
            Flash::error('Entrevista Profundidad no existe');
            return redirect(route('entrevistaProfundidads.index'));
        }

        if(!$entrevistaProfundidad->puede_acceder_entrevista) {
            abort(403,"No puede modificar esta entrevista");
        }

        //Permisos de escritura
        if(!$entrevistaProfundidad->puede_modificar_entrevista()) {
            abort(403,"No puede modificar esta entrevista");
        }



        return view('entrevista_profundidads.edit')->with('entrevistaProfundidad', $entrevistaProfundidad);
    }

    /**
     * Update the specified entrevista_profundidad in storage.
     *
     * @param  int              $id
     * @param Updateentrevista_profundidadRequest $request
     *
     * @return Response
     */
    public function update($id, Updateentrevista_profundidadRequest $request) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $entrevista = entrevista_profundidad::find($id);
        if (empty($entrevista)) {
            Flash::error("Entrevista a profundidad ($id) no existe");
            return redirect(action('entrevista_profundidadController@index'));
        }
        //Leer el request y meterlo a un arreglo
        $input = $request->all();

        //Revisar que el número no se duplique
        $existe = entrevista_profundidad::where('id_entrevistador',$request->id_entrevistador)
            ->where('entrevista_numero',$request->entrevista_numero)
            ->where('id_entrevista_profundidad','<>',$id)
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


        //Macroterritorio
        $input['id_macroterritorio'] = $request->id_territorio_macro;
        //Fechas
        $input['entrevista_fecha_inicio']=$request->entrevista_fecha_inicio_submit;
        $input['entrevista_fecha_final']=$request->entrevista_fecha_final_submit;
        //dd($input);

        //Actualizar la BD
        $entrevista->fill($input);
        //Clasificar reservada-3 o reservada-4
        $entrevista->clasificar_acceso();
        //Recalcular el código, usar el entrevistador que tiene, no el logueado por aquello que otro lo modifique
        $entrevista->entrevista_codigo = $entrevista->calcular_codigo();
        //$codigo = $entrevista->asignar_codigo($id_entrevistador);
        //Grabar en la BD
        $entrevista->save();

        //Consentimiento informado
        $entrevista->procesar_consentimiento($request);

        //Entidades débiles
        //Mandato
        $entrevista->rel_mandato()->delete();
        if(!is_array($request->mandato)) {
            $request->mandato=array($request->mandato);
        }
        foreach($request->mandato as $id) {
            $tmp['id_entrevista_profundidad'] = $entrevista->id_entrevista_profundidad;
            $tmp['id_mandato']=$id;
            $registro = entrevista_profundidad_mandato::create($tmp);
        }


        //Temas
        $entrevista->rel_tema()->delete();
        if(!is_array($request->tema)) {
            $request->tema=array($request->tema);
        }
        foreach($request->tema as $txt) {
            if(strlen($txt)>0) {
                $tmp['id_entrevista_profundidad'] = $entrevista->id_entrevista_profundidad;
                $tmp['tema']=trim($txt);
                entrevista_profundidad_tema::create($tmp);
            }
        }
        //Nucleos temáticos
        $entrevista->rel_interes()->delete();
        if(!is_array($request->interes)) {
            $request->interes=array($request->interes);
        }
        foreach($request->interes as $id_interes) {
                $tmp['id_entrevista_profundidad'] = $entrevista->id_entrevista_profundidad;
                $tmp['id_interes']=trim($id_interes);
                entrevista_profundidad_interes::create($tmp);
        }
        // Violencia victima
        $entrevista->rel_violencia_victima()->delete();
        if(!is_array($request->id_violencia_victima)) {
            $request->id_violencia_victima=array($request->id_violencia_victima);
        }
        foreach($request->id_violencia_victima as $id) {
            if($id > 0) {
                $tmp['id_entrevista_profundidad'] = $entrevista->id_entrevista_profundidad;
                $tmp['id_violencia']=$id;
                entrevista_profundidad_violencia_victima::create($tmp);
            }

        }
        // Violencia actor
        $entrevista->rel_violencia_actor()->delete();
        if(!is_array($request->id_violencia_actor)) {
            $request->id_violencia_actor=array($request->id_violencia_actor);
        }
        foreach($request->id_violencia_actor as $id) {
            if($id>0) {
                $tmp['id_entrevista_profundidad'] = $entrevista->id_entrevista_profundidad;
                $tmp['id_violencia']=$id;
                entrevista_profundidad_violencia_actor::create($tmp);
            }

        }
        //Dinámicas
        $entrevista->rel_dinamica()->delete();
        if(!is_array($request->dinamica)) {
            $request->dinamica=array($request->dinamica);
        }
        foreach($request->dinamica as $txt) {
            if(strlen($txt)>0) {
                $tmp['id_entrevista_profundidad'] = $entrevista->id_entrevista_profundidad;
                $tmp['dinamica']=trim($txt);
                entrevista_profundidad_dinamica::create($tmp);
            }
        }

        //Registrar traza
        traza_actividad::create(['id_objeto'=>11, 'id_accion'=>4, 'codigo'=>$entrevista->entrevista_codigo , 'id_primaria'=>$entrevista->id_entrevista_profundidad]);
        // Notificar y redirigir
        Flash::success('Entrevista actualizada.');
        return redirect(action("entrevista_profundidadController@show",$entrevista->id_entrevista_profundidad));
    }

    /**
     * Remove the specified entrevista_profundidad from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        abort(403,"No se vale borrar");
        $entrevistaProfundidad = $this->entrevistaProfundidadRepository->findWithoutFail($id);

        if (empty($entrevistaProfundidad)) {
            Flash::error('Entrevista Profundidad not found');

            return redirect(route('entrevistaProfundidads.index'));
        }

        $this->entrevistaProfundidadRepository->delete($id);

        Flash::success('Entrevista Profundidad deleted successfully.');

        return redirect(route('entrevistaProfundidads.index'));
    }


    //Para la gestión de adjuntos
    public function gestionar_adjuntos($id) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $entrevista = entrevista_profundidad::find($id);
        if(!$entrevista) {
            abort(403,"Entrevista ($id) no existe");
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
        


        return view('entrevista_profundidads.gestionar_adjuntos')->with('entrevistaProfundidad', $entrevista);
    }


    //Para refrescar por ajax la tabla luego del upload
    public function tabla_adjuntos($id) {

        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $entrevista = entrevista_profundidad::find($id);
        if(!$entrevista) {
            abort(403,"Entrevista ($id) no existe");
        }


        //Ver que tenga permisos
        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }


        //Segundo chequeo: reservado-3
        if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
        }

        return view('entrevista_profundidads.tabla_adjuntos')->with('entrevistaProfundidad', $entrevista);
    }

    public function excel_plano() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>11, 'id_accion'=>8]);
        return Excel::download(new entrevista_prExport,"entrevistas_profundidad_$fecha.xlsx");
    }
    public function excel_plano_anonimo() {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>11, 'id_accion'=>8]);
        return Excel::download(new entrevista_prExport(true),"entrevistas_profundidad_anonimo_$fecha.xlsx");
    }

    public function generar_excel_plano() {
        $inicio = \Carbon\Carbon::now();
        $total = excel_entrevista_pr::generar_plana(true);
        $fin= \Carbon\Carbon::now();
        $tiempo = $inicio->diffForHumans($inicio);
        $respuesta=new \stdClass();
        $respuesta->inicio=$inicio;
        $respuesta->fin=$fin;
        $respuesta->tiempo=$tiempo;
        $respuesta->filas=$total;
        return response()->json($respuesta);
    }

    //PAra los autofill
    public function autofill_nombres(Request $request) {
        return entrevista_profundidad::listar_opciones_campo('entrevistado_nombres',$request->texto);
    }
    public function autofill_apellidos(Request $request) {
        return entrevista_profundidad::listar_opciones_campo('entrevistado_apellidos',$request->texto);
    }
    public function autofill_tema(Request $request) {
        return entrevista_profundidad::listar_opciones_tema($request->texto);
    }
    public function autofill_entrevista_objetivo(Request $request) {
        return entrevista_profundidad::listar_opciones_campo('entrevista_objetivo',$request->texto);
    }
    public function autofill_titulo(Request $request) {
        return entrevista_profundidad::listar_opciones_campo('titulo',$request->texto);
    }
    public function autofill_dinamica(Request $request) {
        return entrevista_profundidad::listar_opciones_dinamica($request->texto);
    }
    public function autofill_observaciones(Request $request) {
        return entrevista_profundidad::listar_opciones_campo('observaciones',$request->texto);
    }

    //Autorizar acceso a R3 y R4
    public function desclasificar($id)
    {
        //Negar acceso a los de solo estadistica
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        //1: Confirmar que  que exista
        $entrevistaProfundidad =entrevista_profundidad::find($id);
        if (empty($entrevistaProfundidad)) {
            abort(403, "No existe la entrevista indicada:$id");
        }

        //2: Confirmar acceso del usuario a la entrevista
        if(!$entrevistaProfundidad->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Revisar privilegios de R3
        if(!$entrevistaProfundidad->puede_desclasificar_entrevista()) {
            abort(403, "No puede modificar la entrevista.");
        }

        //Revisar que requiera clasificacion
        if($entrevistaProfundidad->clasificacion_nivel > 3 ) {
            abort(403, "Esta es una entrevista clasificacion R-$entrevistaProfundidad->clasificacion_nivel.");
        }



        return view('entrevista_profundidads.desclasificar',compact('entrevistaProfundidad'));
    }

    // Anular/recuperar una entrevista
    public  function anular($id) {
        $this->authorize('nivel-1');
        $expediente = entrevista_profundidad::find($id);
        $expediente->id_activo = $expediente->id_activo == 1 ? 2 : 1 ;
        $expediente->save();
        $codigo = $expediente->entrevista_codigo;
        $verbo = $expediente->id_activo == 1 ? "recuperado" : "anulado";
        traza_actividad::create(['id_objeto'=>11, 'id_accion'=>10, 'referencia'=>$verbo ,'codigo'=>$expediente->entrevista_codigo, 'id_primaria'=>$id]);

        return redirect(action('entrevista_profundidadController@show',$id));
        //return ("Expediente $codigo $verbo");

    }

    //Generar excel con resultados.  Este es el destino del botón.  Calcula los id_entrevista  a exportar
    public function generar_excel_filtrado(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $filtros = entrevista_profundidad::filtros_default($request);
        //dd($filtros);
        $query = entrevista_profundidad::filtrar($filtros);
        //$debug['sql']= nl2br($query->toSql());
        //$debug['criterios']=$query->getBindings();
        //dd($debug);
        //$cantidad = $filtros->id_entrevistador == optional(\Auth::user())->id_entrevistador ? 30 : 15;
        $arreglo = $query->pluck('entrevista_profundidad.id_entrevista_profundidad')->toArray();
        //dd($arreglo);

        return $this->excel_plano_resultados($arreglo);
    }
    //Llamado a partir de un filtro.  Recibe el arreglo de los id_e_ind_fvt a exportar
    public function excel_plano_resultados($arreglo) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>11, 'id_accion'=>8]);

        $anonimo = \Gate::denies('nivel-1');
        $txt = $anonimo ? '_anom_' : '_';
        return Excel::download(new entrevista_pr_resultadosExport($arreglo,$anonimo),"entrevistas_profundidad_resultado$txt$fecha.xlsx");
    }

    //Mostrar el formulario de consentimiento informado
    public function frm_ci($id) {
        $entrevistaProfundidad = entrevista_profundidad::find($id);

        if (empty($entrevistaProfundidad)) {
            Flash::error('Entrevista Profundidad no existe');
            return redirect(route('entrevistaProfundidads.index'));
        }

        if(!$entrevistaProfundidad->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        $consentimiento = entrevista::where('id_entrevista_profundidad',$id)->first();
        if(!$consentimiento) {
            $consentimiento = new entrevista();
        }



        //Registrar traza
        //traza_actividad::create(['id_objeto'=>11, 'id_accion'=>6, 'codigo'=>$entrevistaProfundidad->entrevista_codigo, 'id_primaria'=>$entrevistaProfundidad->id_entrevista_profundidad]);

        $txt_titulo = $entrevistaProfundidad->entrevista_codigo;
        $entrevista = $entrevistaProfundidad;
        return view('entrevista_profundidads.consentimiento')
            ->with('entrevistaProfundidad', $entrevistaProfundidad)
            ->with('entrevista', $entrevista)
            ->with('consentimiento', $consentimiento)
            ->with('txt_titulo',$txt_titulo);
    }


    //Convierte en CO
    public static function trasladar_co($id) {
        //dd($id);
        $existe = entrevista_profundidad::find($id);
        if($existe) {
            $nueva = $existe->trasladar_co();
            if($nueva) {
                Flash::success("Entrevista guardada como $nueva->entrevista_codigo");
                return redirect()->action('entrevista_colectivaController@show',$nueva->id_entrevista_colectiva);
            }
            else {
                Flash::error('Hubo prolemas con el traslado de la entrevista');
                return redirect()->back();
            }
        }
        else {
            Flash::error("No existe la entrevista a profundidad $id");
            return redirect()->back();
        }

    }

}
