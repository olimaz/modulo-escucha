<?php

namespace App\Http\Controllers;

use App\Exports\excel_coExport;
use App\Exports\excel_dcExport;
use App\Http\Requests\Creatediagnostico_comunitarioRequest;
use App\Http\Requests\Updatediagnostico_comunitarioRequest;
use App\Models\diagnostico_comunitario;
use App\Models\diagnostico_comunitario_dinamica;
use App\Models\diagnostico_comunitario_interes;
use App\Models\diagnostico_comunitario_mandato;
use App\Models\entrevista_colectiva;
use App\Models\entrevista_individual;
use App\Models\entrevistador;
use App\Models\traza_actividad;
use App\Repositories\diagnostico_comunitarioRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class diagnostico_comunitarioController extends AppBaseController
{
    /** @var  diagnostico_comunitarioRepository */
    private $diagnosticoComunitarioRepository;

    public function __construct(diagnostico_comunitarioRepository $diagnosticoComunitarioRepo)
    {
        $this->diagnosticoComunitarioRepository = $diagnosticoComunitarioRepo;
    }

    /**
     * Display a listing of the diagnostico_comunitario.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $filtros = diagnostico_comunitario::filtros_default($request);

        $query = diagnostico_comunitario::filtrar($filtros)->ordenar();
            $debug['sql']= nl2br($query->toSql());
            $debug['criterios']=$query->getBindings();
            //dd($debug);
        $diagnosticoComunitarios = $query->select(\DB::raw('diagnostico_comunitario.*'))->paginate();
        $total_entrevistas = $diagnosticoComunitarios->total();  //Para el formulario de filtros


        $txt_titulo = "Diagnosticos C.";
        return view('diagnostico_comunitarios.index')
            ->with('diagnosticoComunitarios', $diagnosticoComunitarios)
            ->with('txt_titulo',$txt_titulo)
            ->with('filtros', $filtros);
    }

    /**
     * Show the form for creating a new diagnostico_comunitario.
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

        $diagnosticoComunitario = new diagnostico_comunitario();
        $diagnosticoComunitario->valores_iniciales($id_entrevistador);

        return view('diagnostico_comunitarios.create',compact('diagnosticoComunitario'));
    }

    /**
     * Store a newly created diagnostico_comunitario in storage.
     *
     * @param Creatediagnostico_comunitarioRequest $request
     *
     * @return Response
     */
    public function store(Creatediagnostico_comunitarioRequest $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
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
        $id_entrevistador=intval($request->id_entrevistador);

        //Validar número de entrevista
        $entrevista_numero = intval($request->entrevista_numero);
        $existe = diagnostico_comunitario::where('id_entrevistador',$id_entrevistador)
            ->where('entrevista_numero',$entrevista_numero)
            ->first();
        if(!empty($existe)) {
            Flash::error("Número de entrevista en uso.  No puede duplicar el número $request->entrevista_numero");
            return redirect()->back()->withInput($request->all());
        }

        //Calcular el código
        $entrevista = new diagnostico_comunitario();
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
        $input['entrevista_fecha_final']=$request->entrevista_fecha_finalsubmit;
        $input['tema_del'] = Carbon::createFromFormat("Y/m/d",$request->tema_anio_del."/01/01")->format("Y-m-d");
        $input['tema_al']  = Carbon::createFromFormat("Y/m/d",$request->tema_anio_al."/12/31")->format("Y-m-d");


        try {
            $nueva = new diagnostico_comunitario();
            $nueva->fill($input);
            $nueva->clasificar_acceso();
            $nueva->save();

            //Mandato
            if(!is_array($request->mandato)) {
                $request->mandato=array($request->mandato);
            }
            foreach($request->mandato as $id) {
                $tmp['id_diagnostico_comunitario'] = $nueva->id_diagnostico_comunitario;
                $tmp['id_mandato']=$id;
                diagnostico_comunitario_mandato::create($tmp);
            }
            //Interes
            if(!is_array($request->interes)) {
                $request->interes=array($request->interes);
            }
            foreach($request->interes as $id) {
                $tmp['id_diagnostico_comunitario'] = $nueva->id_diagnostico_comunitario;
                $tmp['id_interes']=$id;
                diagnostico_comunitario_interes::create($tmp);
            }
            //Interes
            if(!is_array($request->dinamica)) {
                $request->dinamica=array($request->dinamica);
            }
            foreach($request->dinamica as $txt) {
                if(strlen($txt)>0) {
                    $tmp['id_diagnostico_comunitario'] = $nueva->id_diagnostico_comunitario;
                    $tmp['dinamica']=$txt;
                    diagnostico_comunitario_dinamica::create($tmp);
                }

            }

            //Traza de seguridad
            traza_actividad::create(['id_objeto'=>13, 'id_accion'=>3, 'codigo'=>$codigo, 'id_primaria'=>$nueva->id_diagnostico_comunitario]);

            return redirect()->action('diagnostico_comunitarioController@gestionar_adjuntos',$nueva->id_diagnostico_comunitario);

        }
        catch (\Exception $e) {
            Flash::error('Problemas al grabar la información: '.$e->getMessage());
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified diagnostico_comunitario.
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
        $diagnosticoComunitario = $this->diagnosticoComunitarioRepository->findWithoutFail($id);
        if (empty($diagnosticoComunitario)) {
            Flash::error('Diagnostico Comunitario not existe');
            return redirect(route('diagnosticoComunitarios.index'));
        }

        //2: Confirmar acceso del usuario a la entrevista
        if(!$diagnosticoComunitario->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Registrar traza
        traza_actividad::create(['id_objeto'=>13, 'id_accion'=>6, 'codigo'=>$diagnosticoComunitario->entrevista_codigo, 'id_primaria'=>$id]);


        $txt_titulo = "D/C ".$diagnosticoComunitario->entrevista_codigo;
        return view('diagnostico_comunitarios.show')->with('diagnosticoComunitario', $diagnosticoComunitario)->with('txt_titulo',$txt_titulo);
    }

    /**
     * Show the form for editing the specified diagnostico_comunitario.
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
        $diagnosticoComunitario = diagnostico_comunitario::find($id);
        if (empty($diagnosticoComunitario)) {
            Flash::error('Diagnostico comunitario no existe');
            return redirect(action('diagnostico_comunitarioController@index'));
        }
        if(!$diagnosticoComunitario->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }
        //Permisos de escritura
        if(!$diagnosticoComunitario->puede_modificar_entrevista()) {
            abort(403,"No puede modificar esta entrevista");
        }


        
        return view('diagnostico_comunitarios.edit')->with('diagnosticoComunitario', $diagnosticoComunitario);
    }

    /**
     * Update the specified diagnostico_comunitario in storage.
     *
     * @param  int              $id
     * @param Updatediagnostico_comunitarioRequest $request
     *
     * @return Response
     */
    public function update($id, Updatediagnostico_comunitarioRequest $request) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $entrevista = diagnostico_comunitario::find($id);
        if (empty($entrevista)) {
            Flash::error("Entrevista colectiva ($id) no existe");
            return redirect(action('diagnostico_comunitarioController@index'));
        }
        //Leer el request y meterlo a un arreglo
        $input = $request->all();

        //Revisar que el número no se duplique
        $existe = diagnostico_comunitario::where('id_entrevistador',$request->id_entrevistador)
            ->where('entrevista_numero',$request->entrevista_numero)
            ->where('id_diagnostico_comunitario','<>',$id)
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
        $input['tema_del'] = Carbon::createFromFormat("Y/m/d",$request->tema_anio_del."/01/01")->format("Y-m-d");
        $input['tema_al']  = Carbon::createFromFormat("Y/m/d",$request->tema_anio_al."/12/31")->format("Y-m-d");
        //dd($input);

        //Actualizar la BD
        $entrevista->fill($input);
        //Clasificar reservada-3 o reservada-4
        $entrevista->clasificar_acceso();
        //Recalcular el código, usar el entrevistador que tiene, no el logueado por aquello que otro lo modifique
        $entrevista->entrevista_codigo = $entrevista->calcular_codigo();
        //Grabar en la BD
        $entrevista->save();

        //Entidades débiles
        $entrevista->rel_mandato()->delete();
        if(!is_array($request->mandato)) {
            $request->mandato=array($request->mandato);
        }
        foreach($request->mandato as $id) {
            $tmp['id_diagnostico_comunitario'] = $entrevista->id_diagnostico_comunitario;
            $tmp['id_mandato']=$id;
            $registro = diagnostico_comunitario_mandato::create($tmp);
        }
        //Nucleos tematicos
        $entrevista->rel_interes()->delete();
        $request->interes = array($request->interes) ? $request->interes : array($request->interes);
        foreach($request->interes as $id) {
            $tmp['id_diagnostico_comunitario'] = $entrevista->id_diagnostico_comunitario;
            $tmp['id_interes']=$id;
            $registro = diagnostico_comunitario_interes::create($tmp);
        }
        //Dinámicas
        $entrevista->rel_dinamica()->delete();
        $request->dinamica = array($request->dinamica) ? $request->dinamica : array($request->dinamica);
        foreach($request->dinamica as $txt) {
            if(strlen($txt)>0) {
                $tmp['id_diagnostico_comunitario'] = $entrevista->id_diagnostico_comunitario;
                $tmp['dinamica']=$txt;
                $registro = diagnostico_comunitario_dinamica::create($tmp);
            }

        }

        //Registrar traza
        traza_actividad::create(['id_objeto'=>13, 'id_accion'=>4, 'codigo'=>$entrevista->entrevista_codigo , 'id_primaria'=>$entrevista->id_diagnostico_comunitario]);
        // Notificar y redirigir
        Flash::success('Entrevista actualizada.');
        return redirect(action("diagnostico_comunitarioController@show",$entrevista->id_diagnostico_comunitario));
    }

    /**
     * Remove the specified diagnostico_comunitario from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        abort(403);
        $diagnosticoComunitario = $this->diagnosticoComunitarioRepository->findWithoutFail($id);

        if (empty($diagnosticoComunitario)) {
            Flash::error('Diagnostico Comunitario not found');

            return redirect(route('diagnosticoComunitarios.index'));
        }

        $this->diagnosticoComunitarioRepository->delete($id);

        Flash::success('Diagnostico Comunitario deleted successfully.');

        return redirect(route('diagnosticoComunitarios.index'));
    }

    //Para la gestión de adjuntos
    public function gestionar_adjuntos($id) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $entrevista = diagnostico_comunitario::find($id);


        if (empty($entrevista)) {
            Flash::error("Diagnostico comunitario no existe($id)");
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


        return view('diagnostico_comunitarios.gestionar_adjuntos')->with('diagnosticoComunitario', $entrevista);
    }


    //Para refrescar por ajax la tabla luego del upload
    public function tabla_adjuntos($id) {
        $entrevista = diagnostico_comunitario::find($id);
        if(!$entrevista) {
            abort(403,"Diagnóstico ($id) no existe");
        }

        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }


        return view('diagnostico_comunitarios.tabla_adjuntos')->with('diagnosticoComunitario', $entrevista);
    }


    //PAra los autofill
    public function autofill_tema_comunidad(Request $request) {
        return diagnostico_comunitario::listar_opciones_campo('tema_comunidad',$request->texto);
    }
    public function autofill_tema_objetivo(Request $request) {
        return diagnostico_comunitario::listar_opciones_campo('tema_objetivo',$request->texto);
    }
    public function autofill_tema_dinamica(Request $request) {
        return diagnostico_comunitario::listar_opciones_campo('tema_dinamica',$request->texto);
    }
    public function autofill_titulo(Request $request) {
        return diagnostico_comunitario::listar_opciones_campo('titulo',$request->texto);
    }
    public function autofill_dinamica(Request $request) {
        return diagnostico_comunitario::listar_opciones_dinamica($request->texto);
    }
    public function autofill_observaciones(Request $request) {
        return diagnostico_comunitario::listar_opciones_campo('observaciones',$request->texto);
    }

    //Autorizar acceso a R3 y R4
    public function desclasificar($id)
    {
        //Negar acceso a los de solo estadistica
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        //1: Confirmar que  que exista
        $diagnosticoComunitario =diagnostico_comunitario::find($id);
        if (empty($diagnosticoComunitario)) {
            abort(403, "No existe la entrevista indicada:$id");
        }

        //2: Confirmar acceso del usuario a la entrevista
        if(!$diagnosticoComunitario->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Revisar privilegios de R3
        if(!$diagnosticoComunitario->puede_desclasificar_entrevista()) {
            abort(403, "No puede modificar la entrevista.");
        }

        //Revisar que requiera clasificacion
        if($diagnosticoComunitario->clasificacion_nivel > 3 ) {
            abort(403, "Esta es una entrevista clasificacion R-$diagnosticoComunitario->clasificacion_nivel.");
        }



        return view('diagnostico_comunitarios.desclasificar',compact('diagnosticoComunitario'));
    }

    // Anular/recuperar una entrevista
    public  function anular($id) {
        $this->authorize('nivel-1');
        $expediente = diagnostico_comunitario::find($id);
        $expediente->id_activo = $expediente->id_activo == 1 ? 2 : 1 ;
        $expediente->save();
        $codigo = $expediente->entrevista_codigo;
        $verbo = $expediente->id_activo == 1 ? "recuperado" : "anulado";
        traza_actividad::create(['id_objeto'=>13, 'id_accion'=>10, 'referencia'=>$verbo ,'codigo'=>$expediente->entrevista_codigo, 'id_primaria'=>$id]);

        return redirect(action('diagnostico_comunitarioController@show',$id));
        //return ("Expediente $codigo $verbo");

    }


    //Descargar tabla plana para resultados específicos
    public function generar_excel_filtrado(Request $request) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $filtros = diagnostico_comunitario::filtros_default($request);
        //dd($filtros);
        $query = diagnostico_comunitario::filtrar($filtros);
        //$debug['sql']= nl2br($query->toSql());
        //$debug['criterios']=$query->getBindings();
        //dd($debug);
        //$cantidad = $filtros->id_entrevistador == optional(\Auth::user())->id_entrevistador ? 30 : 15;
        $arreglo = $query->orderby('diagnostico_comunitario.id_diagnostico_comunitario')->pluck('diagnostico_comunitario.id_diagnostico_comunitario')->toArray();

        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>13, 'id_accion'=>8]);

        $anonimo = \Gate::denies('nivel-1');
        $txt = $anonimo ? '_anom_' : '_';


        return Excel::download(new excel_dcExport($arreglo,$anonimo),"diagnostico_comunitario$txt$fecha.xlsx");
    }



    //Convierte en EE
    public static function trasladar_ee($id) {
        $existe = diagnostico_comunitario::find($id);
        if($existe) {
            $nueva = $existe->trasladar_ee();
            if($nueva) {
                Flash::success("Entrevista guardada como $nueva->entrevista_codigo");
                return redirect()->action('entrevista_etnicaController@show',$nueva->id_entrevista_etnica);
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
