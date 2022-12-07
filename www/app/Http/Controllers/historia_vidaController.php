<?php

namespace App\Http\Controllers;

use App\Exports\excel_dcExport;
use App\Exports\excel_hvExport;
use App\Http\Requests\Createhistoria_vidaRequest;
use App\Http\Requests\Updatehistoria_vidaRequest;
use App\Models\diagnostico_comunitario;
use App\Models\entrevista;
use App\Models\entrevista_colectiva;
use App\Models\entrevistador;
use App\Models\historia_vida;
use App\Models\historia_vida_dinamica;
use App\Models\historia_vida_interes;
use App\Models\historia_vida_mandato;
use App\Models\historia_vida_tema;
use App\Models\traza_actividad;
use App\Repositories\historia_vidaRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class historia_vidaController extends AppBaseController
{
    /** @var  historia_vidaRepository */
    private $historiaVidaRepository;

    public function __construct(historia_vidaRepository $historiaVidaRepo)
    {
        $this->historiaVidaRepository = $historiaVidaRepo;
    }

    /**
     * Display a listing of the historia_vida.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $filtros = historia_vida::filtros_default($request);

        $query = historia_vida::filtrar($filtros)->ordenar();
        //$debug['sql']= nl2br($query->toSql());
        //$debug['criterios']=$query->getBindings();
        //dd($debug);
        $historiaVidas = $query->select(\DB::raw('historia_vida.*'))->paginate();
        $total_entrevistas = $historiaVidas->total();  //Para el formulario de filtros


        $txt_titulo = "Historia Vida";
        return view('historia_vidas.index')
            ->with('historiaVidas', $historiaVidas)
            ->with('total_entrevistas', $total_entrevistas)
            ->with('txt_titulo',$txt_titulo)
            ->with('filtros', $filtros);
    }

    /**
     * Show the form for creating a new historia_vida.
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
        $historiaVida = new historia_vida();
        $historiaVida->valores_iniciales($id_entrevistador);
        return view('historia_vidas.create')->with('historiaVida', $historiaVida);
    }

    /**
     * Store a newly created historia_vida in storage.
     *
     * @param Createhistoria_vidaRequest $request
     *
     * @return Response
     */
    public function store(Createhistoria_vidaRequest $request)
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
        $existe = historia_vida::where('id_entrevistador',$id_entrevistador)
            ->where('entrevista_numero',$entrevista_numero)
            ->first();
        if(!empty($existe)) {
            Flash::error("Número de entrevista en uso.  No puede duplicar el número $request->entrevista_numero");
            return redirect()->back()->withInput($request->all());
        }

        //Calcular el código
        $entrevista = new historia_vida();
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
            $nueva = new historia_vida();
            $nueva->fill($input);
            $nueva->clasificar_acceso();
            $nueva->save();
            //Consentimiento informado
            $nueva->procesar_consentimiento($request);

            //Mandato
            if (!is_array($request->mandato)) {
                $request->mandato = array($request->mandato);
            }
            foreach ($request->mandato as $id) {
                $tmp['id_historia_vida'] = $nueva->id_historia_vida;
                $tmp['id_mandato'] = $id;
                historia_vida_mandato::create($tmp);
            }
            //Temas
            if(!is_array($request->tema)) {
                $request->tema=array($request->tema);
            }
            foreach($request->tema as $txt) {
                if(strlen($txt)>0) {
                    $tmp['id_historia_vida'] = $nueva->id_historia_vida;
                    $tmp['tema']=trim($txt);
                    historia_vida_tema::create($tmp);
                }
            }
            //Interes
            if(!is_array($request->interes)) {
                $request->interes=array($request->interes);
            }
            foreach($request->interes as $id_interes) {
                if($id_interes>0) {
                    $tmp['id_historia_vida'] = $nueva->id_historia_vida;
                    $tmp['id_interes']=$id_interes;
                    historia_vida_interes::create($tmp);
                }
            }
            //Dinamica
            if(!is_array($request->dinamica)) {
                $request->dinamica=array($request->dinamica);
            }
            foreach($request->dinamica as $txt) {
                if(strlen($txt)>0) {
                    $tmp['id_historia_vida'] = $nueva->id_historia_vida;
                    $tmp['dinamica']=trim($txt);
                    historia_vida_dinamica::create($tmp);
                }
            }

            //Traza de seguridad
            traza_actividad::create(['id_objeto'=>12, 'id_accion'=>3, 'codigo'=>$codigo, 'id_primaria'=>$nueva->id_historia_vida]);

            return redirect()->action('historia_vidaController@gestionar_adjuntos',$nueva->id_historia_vida);
        }
        catch (\Exception $e) {
                Flash::error('Problemas al grabar la información: '.$e->getMessage());
                return redirect()->back()->withInput($request->all());
        }



    }

    /**
     * Display the specified historia_vida.
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
        $historiaVida = $this->historiaVidaRepository->findWithoutFail($id);
        if (empty($historiaVida)) {
            Flash::error('Historia Vida no existe');
            return redirect(route('historiaVidas.index'));
        }

        //2: Confirmar acceso del usuario a la entrevista
        if(!$historiaVida->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta historia de vida");
        }



        //Registrar traza
        traza_actividad::create(['id_objeto'=>12, 'id_accion'=>6, 'codigo'=>$historiaVida->entrevista_codigo, 'id_primaria'=>$id]);

        $txt_titulo = "H/V ".$historiaVida->entrevista_codigo;
        return view('historia_vidas.show')->with('historiaVida', $historiaVida)->with('txt_titulo',$txt_titulo);
    }

    /**
     * Show the form for editing the specified historia_vida.
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
        $historiaVida = historia_vida::find($id);
        if (empty($historiaVida)) {
            Flash::error('Historia de vida  no existe');
            return redirect(action('historia_vidaController@index'));
        }
        if(!$historiaVida->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Permisos de escritura
        if(!$historiaVida->puede_modificar_entrevista()) {
            abort(403,"No puede modificar esta  historia de vida");
        }



        return view('historia_vidas.edit')->with('historiaVida', $historiaVida);
    }

    /**
     * Update the specified historia_vida in storage.
     *
     * @param  int              $id
     * @param Updatehistoria_vidaRequest $request
     *
     * @return Response
     */
    public function update($id, Updatehistoria_vidaRequest $request) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $entrevista = historia_vida::find($id);
        if (empty($entrevista)) {
            Flash::error("Historia de vida ($id) no existe");
            return redirect(action('historia_vidaController@index'));
        }
        //Leer el request y meterlo a un arreglo
        $input = $request->all();

        //Revisar que el número no se duplique
        $existe = historia_vida::where('id_entrevistador',$request->id_entrevistador)
            ->where('entrevista_numero',$request->entrevista_numero)
            ->where('id_historia_vida','<>',$id)
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
            $tmp['id_historia_vida'] = $entrevista->id_historia_vida;
            $tmp['id_mandato']=$id;
            $registro = historia_vida_mandato::create($tmp);
        }


        //Temas
        $entrevista->rel_tema()->delete();
        if(!is_array($request->tema)) {
            $request->tema=array($request->tema);
        }
        foreach($request->tema as $txt) {
            if(strlen($txt)>0) {
                $tmp['id_historia_vida'] = $entrevista->id_historia_vida;
                $tmp['tema']=trim($txt);
                historia_vida_tema::create($tmp);
            }
        }
        $entrevista->rel_dinamica()->delete();
        if(!is_array($request->dinamica)) {
            $request->dinamica=array($request->dinamica);
        }
        foreach($request->dinamica as $txt) {
            if(strlen($txt)>0) {
                $tmp['id_historia_vida'] = $entrevista->id_historia_vida;
                $tmp['dinamica']=trim($txt);
                historia_vida_dinamica::create($tmp);
            }
        }
        $entrevista->rel_interes()->delete();
        if(!is_array($request->interes)) {
            $request->interes=array($request->interes);
        }
        foreach($request->interes as $id) {
                $tmp['id_historia_vida'] = $entrevista->id_historia_vida;
                $tmp['id_interes']=$id;
                historia_vida_interes::create($tmp);
        }

        //Registrar traza
        traza_actividad::create(['id_objeto'=>12, 'id_accion'=>4, 'codigo'=>$entrevista->entrevista_codigo , 'id_primaria'=>$entrevista->id_historia_vida]);
        // Notificar y redirigir
        Flash::success('Historia de vida actualizada.');
        return redirect(action("historia_vidaController@show",$entrevista->id_historia_vida));

    }

    /**
     * Remove the specified historia_vida from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
        abort(403,"No se vale borrar");
        $historiaVida = $this->historiaVidaRepository->findWithoutFail($id);

        if (empty($historiaVida)) {
            Flash::error('Historia Vida not found');

            return redirect(route('historiaVidas.index'));
        }

        $this->historiaVidaRepository->delete($id);

        Flash::success('Historia Vida deleted successfully.');

        return redirect(route('historiaVidas.index'));
    }

    //Para la gestión de adjuntos
    public function gestionar_adjuntos($id) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        $entrevista = historia_vida::find($id);


        if (empty($entrevista)) {
            Flash::error("Hisotria de vida no existe($id)");
            return redirect(route('historia_vidaController@index'));
        }


        //Ver que tenga permisos
        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta historia de vida");
        }


        //Permisos de escritura
        if(!$entrevista->puede_modificar_entrevista()) {
            abort(403,"No puede modificar esta historia de vida");
        }


        //Segundo chequeo: reservado-3
        if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
        }


        return view('historia_vidas.gestionar_adjuntos')->with('historiaVida', $entrevista);
    }


    //Para refrescar por ajax la tabla luego del upload
    public function tabla_adjuntos($id) {
        $entrevista = historia_vida::find($id);
        if(!$entrevista) {
            abort(403,"Historia de vida ($id) no existe");
        }

        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }


        return view('historia_vidas.tabla_adjuntos')->with('historiaVida', $entrevista);
    }


    //PAra los autofill
    public function autofill_nombres(Request $request) {
        return historia_vida::listar_opciones_campo('entrevistado_nombres',$request->texto);
    }
    public function autofill_apellidos(Request $request) {
        return historia_vida::listar_opciones_campo('entrevistado_apellidos',$request->texto);
    }
    public function autofill_otros_nombres(Request $request) {
        return historia_vida::listar_opciones_campo('entrevistado_otros_nombres',$request->texto);
    }
    public function autofill_entrevista_objetivo(Request $request) {
        return historia_vida::listar_opciones_campo('entrevista_objetivo',$request->texto);
    }
    public function autofill_tema(Request $request) {
        return historia_vida::listar_opciones_tema($request->texto);
    }
    public function autofill_titulo(Request $request) {
        return historia_vida::listar_opciones_campo('titulo',$request->texto);
    }
    public function autofill_dinamica(Request $request) {
        return historia_vida::listar_opciones_dinamica($request->texto);
    }
    public function autofill_observaciones(Request $request) {
        return historia_vida::listar_opciones_campo('observaciones',$request->texto);
    }

    //Autorizar acceso a R3 y R4
    public function desclasificar($id)
    {
        //Negar acceso a los de solo estadistica
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        //1: Confirmar que  que exista
        $historiaVida =historia_vida::find($id);
        if (empty($historiaVida)) {
            abort(403, "No existe la entrevista indicada:$id");
        }

        //2: Confirmar acceso del usuario a la entrevista
        if(!$historiaVida->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        //Revisar privilegios de R3
        if(!$historiaVida->puede_desclasificar_entrevista()) {
            abort(403, "No puede modificar la entrevista.");
        }

        //Revisar que requiera clasificacion
        if($historiaVida->clasificacion_nivel > 3 ) {
            abort(403, "Esta es una entrevista clasificacion R-$historiaVida->clasificacion_nivel.");
        }



        return view('historia_vidas.desclasificar',compact('historiaVida'));
    }

    // Anular/recuperar una entrevista
    public  function anular($id) {
        $this->authorize('nivel-1');
        $expediente = historia_vida::find($id);
        $expediente->id_activo = $expediente->id_activo == 1 ? 2 : 1 ;
        $expediente->save();
        $codigo = $expediente->entrevista_codigo;
        $verbo = $expediente->id_activo == 1 ? "recuperado" : "anulado";
        traza_actividad::create(['id_objeto'=>12, 'id_accion'=>10, 'referencia'=>$verbo ,'codigo'=>$expediente->entrevista_codigo, 'id_primaria'=>$id]);

        return redirect(action('historia_vidaController@show',$id));
        //return ("Expediente $codigo $verbo");

    }

    //Mostrar el formulario de consentimiento informado
    public function frm_ci($id) {
        $historiaVida = historia_vida::find($id);

        if (empty($historiaVida)) {
            Flash::error('Historia de Vida no existe');
            return redirect(route('historiaVidas.index'));
        }

        if(!$historiaVida->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }

        $consentimiento = entrevista::where('id_historia_vida',$id)->first();
        if(!$consentimiento) {
            $consentimiento = new entrevista();
        }


        $txt_titulo = $historiaVida->entrevista_codigo;
        $entrevista = $historiaVida;
        return view('historia_vidas.consentimiento')
            ->with('historiaVida', $historiaVida)
            ->with('entrevista', $entrevista)
            ->with('consentimiento', $consentimiento)
            ->with('txt_titulo',$txt_titulo);
    }


    //Descargar tabla plana para resultados específicos
    public function generar_excel_filtrado(Request $request) {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $filtros = historia_vida::filtros_default($request);
        //dd($filtros);
        $query = historia_vida::filtrar($filtros);
        //$debug['sql']= nl2br($query->toSql());
        //$debug['criterios']=$query->getBindings();
        //dd($debug);
        //$cantidad = $filtros->id_entrevistador == optional(\Auth::user())->id_entrevistador ? 30 : 15;
        $arreglo = $query->orderby('historia_vida.id_historia_vida')->pluck('historia_vida.id_historia_vida')->toArray();

        //$this->authorize('nivel-1-2');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>12, 'id_accion'=>8]);

        $anonimo = \Gate::denies('nivel-1');
        $txt = $anonimo ? '_anom_' : '_';

        return Excel::download(new excel_hvExport($arreglo,$anonimo),"historia_vida$txt$fecha.xlsx");
    }
}
