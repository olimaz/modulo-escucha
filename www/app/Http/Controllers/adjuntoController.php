<?php

namespace App\Http\Controllers;

use App\Exports\entrevista_prExport;
use App\Exports\excel_control_adjuntosExport;
use App\Http\Requests\CreateadjuntoRequest;
use App\Http\Requests\UpdateadjuntoRequest;
use App\Models\adjunto;
use App\Models\adjunto_justificacion;
use App\Models\casos_informes;
use App\Models\diagnostico_comunitario;
use App\Models\documento;
use App\Models\entrevista_colectiva;
use App\Models\entrevista_etnica;
use App\Models\entrevista_individual;
use App\Models\entrevista_profundidad;
use App\Models\entrevistador;
use App\Models\excel_control_adjuntos;
use App\Models\historia_vida;
use App\Models\reservado_acceso;
use App\Models\traza_actividad;
use App\Repositories\adjuntoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class adjuntoController extends AppBaseController
{
    /** @var  adjuntoRepository */
    private $adjuntoRepository;

    public function __construct(adjuntoRepository $adjuntoRepo)
    {
        $this->adjuntoRepository = $adjuntoRepo;
    }

    /**
     * Display a listing of the adjunto.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->authorize('nivel-1');
        $this->adjuntoRepository->pushCriteria(new RequestCriteria($request));
        $adjuntos = $this->adjuntoRepository->all();

        return view('adjuntos.index')
            ->with('adjuntos', $adjuntos);
    }

    /**
     * Show the form for creating a new adjunto.
     *
     * @return Response
     */
    public function create()
    {
        return view('adjuntos.create');
    }

    /**
     * Store a newly created adjunto in storage.
     *
     * @param CreateadjuntoRequest $request
     *
     * @return Response
     */
    public function store(CreateadjuntoRequest $request)
    {
        $input = $request->all();

        $adjunto = $this->adjuntoRepository->create($input);

        Flash::success('Adjunto saved successfully.');

        return redirect(route('adjuntos.index'));
    }

    /**
     * Display the specified adjunto.
     *
     * @param  int $id
     *
     * @return Response
     */

    //Mostrar adjuntos (usado para entrevistas_individuales y casos_informes
    public function show($id)
    {
        //CHEQUEOS DE SEGURIDAD
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $adjunto = adjunto::find($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }
        $codigo="XXX";
        //Buscar la entrevista a travez del adjuntado
        $adjuntado =  $adjunto->rel_entrevista;
        $es_caso=false;
        if(!$adjuntado) { //Adjunto a caso o informe
            $donde = $adjunto->rel_caso;
            if(!empty($donde)) {
                $padre = casos_informes::find($donde->id_casos_informes);
                $entrevista = clone $padre; //Para la seguridad
                $codigo=$padre->codigo;
                $id_primaria=$padre->id_casos_informes; //para la traza
                $puede = $padre->puede_acceder();
                if(!$puede) {
                    abort(403,'Acceso denegado, no cuenta con autorización para acceder a este archivo');
                }
                $es_caso=true;
            }
            else {
                $debug['id_usuario'] = \Auth::id();
                $debug['id_entrevistador'] = \Auth::user()->id_entrevistador;
                $debug['email'] = \Auth::user()->email;
                $debug['name'] = \Auth::user()->name;
                $debug['username'] = \Auth::user()->username;
                $debug['url'] = url()->current();
                Log::error("revisar adjuntoController@show para el id ($id)".PHP_EOL.\GuzzleHttp\json_encode($debug));
                abort(403,'Acceso denegado, no es posible identificar el caso/informe asociado');
            }
            //$id_primaria=null;
        }
        else { //Chequeos de seguridad
            $entrevista = $adjunto->rel_entrevista->rel_id_e_ind_fvt;
            $puede = $entrevista->puede_acceder_adjuntos();
            if(!$puede) {
                abort(403,'Acceso denegado, no cuenta con autorización para acceder a este archivo');
            }
            $codigo      = $entrevista->entrevista_codigo;
            $id_primaria = $entrevista->id_e_ind_fvt;
        }

        // fIN DE LOS CHEQUEOS DE SEGURIDAD

        //Para la traza de seguridad




        //Como se nombra el archivo a descargar
        $nombre = $adjunto->nombre;
        $nombre_descarga = $adjunto->nombre_descarga($nombre);  //Le agrega el nombre original al nombre del archivo





        //Marca de agua, si procede
        $info=pathinfo($adjunto->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = "txt";
        }
        //dd($ext);
        //Traza
        //Registrar traza
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>6, 'codigo'=>$codigo , 'id_primaria'=>$id_primaria]);

        return $this->entregar_archivo($adjunto, $nombre_descarga, $entrevista);
        /*

        if($ext=="pdf" && !$es_caso) {  //Aplicar marca de agua
            $texto = \Auth::user()->fmt_numero_entrevistador. " - Entrevistador # ". \Auth::user()->fmt_numero_entrevistador;
            try {
                $marcado = adjunto::marca_agua($adjunto->ubicacion,$texto);
                return Storage::download('public/'.$marcado->pdf_destino,$nombre_descarga);
            }
            catch(\Exception $e) {
                //dd("problema");
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }

        }
        elseif($ext=="html") {


            $html= Storage::get('public/'.$adjunto->ubicacion);
            $estilizado = self::agregar_css($html);


            return $estilizado->final;

        }
        elseif($adjunto->hay_cifrado()) {
            if(\Gate::allows('nivel-1') || \Gate::allows('es-propio',$entrevista->id_entrevistador) || \Gate::allows('rol-descarga')) {
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }
            else {
                return Storage::download('public/'.$adjunto->hay_cifrado(),$nombre_descarga.".gpg");
            }
        }
        else {
            $habilitado = entrevista_individual::puede_descargar($entrevista->id_entrevistador) || $es_caso;
            if(!$habilitado) {
                abort(403,"Por seguridad, la descarga de archivos se encuentra bloqueada. ");
            }
            return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
        }
        */

    }

    //Mostrar adjuntos de entrevista colectiva
    public function show_co($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //Ver que exista
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }


        $codigo="";
        $adjuntado = $adjunto->rel_entrevista_colectiva;
        if($adjuntado) {
            $entrevista = $adjuntado->rel_id_entrevista_colectiva;
            if($entrevista) {
                $codigo=$entrevista->entrevista_codigo;
                $id_primaria = $entrevista->id_entrevista_colectiva;
                //Primer chequeo: ¿puede acceder a la entrevista?
                if(!$entrevista->puede_acceder_entrevista) {
                    abort(403,"No puede consultar esta entrevista");
                }

                //Segundo chequeo: reservado-3
                if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
                    abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
                }

            }
            else {
                abort(403,"No existe la entrevista a profundidad especificada al adjunto");
            }
        }
        else {
            abort(403,"Adjunto no pertenece a la entrevista a profundidad");
        }

        //Como se nombra el archivo a descargar
        $nombre = $adjunto->nombre_co;
        $nombre_descarga = $adjunto->nombre_descarga($nombre);  //Le agrega el nombre original al nombre del archivo
        //quitar noASCII
        $nombre_descarga=filter_var($nombre_descarga, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);


        //Marca de agua, si procede
        $info=pathinfo($adjunto->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = "txt";
        }
        //dd($ext);
        //Traza
        //Registrar traza
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>6, 'codigo'=>$codigo , 'id_primaria'=>$id_primaria]);

        return $this->entregar_archivo($adjunto, $nombre_descarga, $entrevista);
        /*

        if($ext=="pdf") {  //Aplicar marca de agua
            $texto = \Auth::user()->fmt_numero_entrevistador. " - Entrevistador # ". \Auth::user()->fmt_numero_entrevistador;
            try {
                $marcado = adjunto::marca_agua($adjunto->ubicacion,$texto);
                return Storage::download('public/'.$marcado->pdf_destino,$nombre_descarga);
            }
            catch(\Exception $e) {
                //dd("problema");
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }
        }
        elseif($ext=="html") {
            //return Storage::get('public/'.$adjunto->ubicacion);
            $html= Storage::get('public/'.$adjunto->ubicacion);
            $estilizado = self::agregar_css($html);
            return $estilizado->final;

        }
        elseif($adjunto->hay_cifrado()) {
            if(\Gate::allows('nivel-1') || \Gate::allows('es-propio',$entrevista->id_entrevistador) || \Gate::allows('rol-descarga')) {
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }
            else {
                return Storage::download('public/'.$adjunto->hay_cifrado(),$nombre_descarga.".gpg");
            }

        }
        else {
            $habilitado = entrevista_individual::puede_descargar($entrevista->id_entrevistador);
            if(!$habilitado) {
                abort(403,"Por seguridad, la descarga de archivos se encuentra bloqueada. ");
            }
            return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
        }
        */
    }

    //Mostrar adjuntos de entrevista etnica
    public function show_ee($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //Ver que exista
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }


        $codigo="";
        $adjuntado = $adjunto->rel_entrevista_etnica;
        if($adjuntado) {
            $entrevista = $adjuntado->rel_id_entrevista_etnica;
            if($entrevista) {
                $codigo=$entrevista->entrevista_codigo;
                $id_primaria = $entrevista->id_entrevista_etnica;
                //Primer chequeo: ¿puede acceder a la entrevista?
                if(!$entrevista->puede_acceder_entrevista) {
                    abort(403,"No puede consultar esta entrevista");
                }

                //Segundo chequeo: reservado-3
                if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
                    abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
                }

            }
            else {
                abort(403,"No existe la entrevista a profundidad especificada al adjunto");
            }
        }
        else {
            abort(403,"Adjunto no pertenece a la entrevista a profundidad");
        }



        //Como se nombra el archivo a descargar
        $nombre = $adjunto->nombre_ee;
        $nombre_descarga = $adjunto->nombre_descarga($nombre);  //Le agrega el nombre original al nombre del archivo
        //quitar noASCII
        $nombre_descarga=filter_var($nombre_descarga, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);


        //Marca de agua, si procede
        $info=pathinfo($adjunto->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = "txt";
        }
        //dd($ext);
        //Traza
        //Registrar traza
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>6, 'codigo'=>$codigo , 'id_primaria'=>$id_primaria]);

        return $this->entregar_archivo($adjunto, $nombre_descarga, $entrevista);
        /*
        if($ext=="pdf") {  //Aplicar marca de agua
            $texto = \Auth::user()->fmt_numero_entrevistador. " - Entrevistador # ". \Auth::user()->fmt_numero_entrevistador;
            try {
                $marcado = adjunto::marca_agua($adjunto->ubicacion,$texto);
                return Storage::download('public/'.$marcado->pdf_destino,$nombre_descarga);
            }
            catch(\Exception $e) {
                //dd("problema");
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }
        }
        elseif($ext=="html") {
            //return Storage::get('public/'.$adjunto->ubicacion);
            $html= Storage::get('public/'.$adjunto->ubicacion);
            $estilizado = self::agregar_css($html);
            return $estilizado->final;

        }
        elseif($adjunto->hay_cifrado()) {
            if(\Gate::allows('nivel-1') || \Gate::allows('es-propio',$entrevista->id_entrevistador)  || \Gate::allows('rol-descarga')) {
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }
            else {
                return Storage::download('public/'.$adjunto->hay_cifrado(),$nombre_descarga.".gpg");
            }

        }
        else {
            //Revisar parametro de bloqueo de descargas
            $habilitado = entrevista_individual::puede_descargar($entrevista->id_entrevistador);
            if(!$habilitado) {
                abort(403,"Por seguridad, la descarga de archivos se encuentra bloqueada. ");
            }
            return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
        }
        */
    }

    //Mostrar adjuntos de entrevista profundidad
    public function show_pr($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //Ver que exista
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }


        $codigo="";
        $adjuntado = $adjunto->rel_entrevista_profundidad;
        if($adjuntado) {
            $entrevista = $adjuntado->rel_id_entrevista_profundidad;
            if($entrevista) {
                $codigo=$entrevista->entrevista_codigo;
                $id_primaria=$entrevista->id_entrevista_profundidad; //para la traza
                //Primer chequeo: ¿puede acceder a la entrevista?
                if(!$entrevista->puede_acceder_entrevista) {
                    abort(403,"No puede consultar esta entrevista");
                }

                //Segundo chequeo: reservado-3
                if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
                    abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
                }

            }
            else {
                abort(403,"No existe la entrevista a profundidad especificada al adjunto");
            }
        }
        else {
            abort(403,"Adjunto no pertenece a la entrevista a profundidad");
        }





        //Como se nombra el archivo a descargar
        $nombre = $adjunto->nombre;
        $nombre_descarga = $adjunto->nombre_descarga($nombre);  //Le agrega el nombre original al nombre del archivo

        //quitar noASCII
        $nombre_descarga=filter_var($nombre_descarga, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);


        //Marca de agua, si procede
        $info=pathinfo($adjunto->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = "txt";
        }
        //dd($ext);
        //Traza
        //Registrar traza
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>6, 'codigo'=>$codigo , 'id_primaria'=>$id_primaria]);

        return $this->entregar_archivo($adjunto, $nombre_descarga, $entrevista);

        /*
        if($ext=="pdf") {  //Aplicar marca de agua
            $texto = \Auth::user()->fmt_numero_entrevistador. " - Entrevistador # ". \Auth::user()->fmt_numero_entrevistador;
            try {
                $marcado = adjunto::marca_agua($adjunto->ubicacion,$texto);
                return Storage::download('public/'.$marcado->pdf_destino,$nombre_descarga);
            }
            catch(\Exception $e) {
                //dd("problema");
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }

        }
        elseif($ext=="html") {
            //return Storage::get('public/'.$adjunto->ubicacion);
            $html= Storage::get('public/'.$adjunto->ubicacion);
            $estilizado = self::agregar_css($html);
            return $estilizado->final;

        }
        elseif($adjunto->hay_cifrado()) {
            if(\Gate::allows('nivel-1') || \Gate::allows('es-propio',$entrevista->id_entrevistador)  || \Gate::allows('rol-descarga')) {
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }
            else {
                return Storage::download('public/'.$adjunto->hay_cifrado(),$nombre_descarga.".gpg");
            }

        }
        else {
            //Revisar parametro de bloqueo de descargas
            $habilitado = entrevista_individual::puede_descargar($entrevista->id_entrevistador);
            if(!$habilitado) {
                abort(403,"Por seguridad, la descarga de archivos se encuentra bloqueada. ");
            }
            return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
        }
        */
        //////////
    }
    //Mostrar adjuntos de historia de vida
    public function show_hv($id)
    {
        //CHEQUEOS DE SEGURIDAD
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $adjunto = adjunto::find($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }
        //Buscar la entrevista a travez del adjuntado
        $entrevista = $adjunto->rel_historia_vida->rel_id_historia_vida;

        $puede = $entrevista->puede_acceder_adjuntos();
        if(!$puede) {
            abort(403,'Acceso denegado, no cuenta con autorización para acceder a este archivo');
        }
        // fIN DE LOS CHEQUEOS DE SEGURIDAD

        //Para la traza de seguridad
        $codigo      = $entrevista->entrevista_codigo;
        $id_primaria = $entrevista->id_historia_vida;



        //Como se nombra el archivo a descargar
        $nombre = $adjunto->nombre_hv;
        $nombre_descarga = $adjunto->nombre_descarga($nombre);  //Le agrega el nombre original al nombre del archivo
        //quitar noASCII
        $nombre_descarga=filter_var($nombre_descarga, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);


        //Marca de agua, si procede
        $info=pathinfo($adjunto->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = "txt";
        }
        //dd($ext);
        //Traza
        //Registrar traza
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>6, 'codigo'=>$codigo , 'id_primaria'=>$id_primaria]);

        return $this->entregar_archivo($adjunto, $nombre_descarga, $entrevista);
        /*
        if($ext=="pdf") {  //Aplicar marca de agua
            $texto = \Auth::user()->fmt_numero_entrevistador. " - Entrevistador # ". \Auth::user()->fmt_numero_entrevistador;
            try {
                $marcado = adjunto::marca_agua($adjunto->ubicacion,$texto);
                return Storage::download('public/'.$marcado->pdf_destino,$nombre_descarga);
            }
            catch(\Exception $e) {
                //dd("problema");
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }

        }
        elseif($ext=="html") {
            //return Storage::get('public/'.$adjunto->ubicacion);
            $html= Storage::get('public/'.$adjunto->ubicacion);
            $estilizado = self::agregar_css($html);
            return $estilizado->final;

        }
        elseif($adjunto->hay_cifrado()) {
            if(\Gate::allows('nivel-1') || \Gate::allows('es-propio',$entrevista->id_entrevistador)) {
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }
            else {
                return Storage::download('public/'.$adjunto->hay_cifrado(),$nombre_descarga.".gpg");
            }

        }
        else {
            //Revisar parametro de bloqueo de descargas
            $habilitado = entrevista_individual::puede_descargar($entrevista->id_entrevistador);
            if(!$habilitado) {
                abort(403,"Por seguridad, la descarga de archivos se encuentra bloqueada. ");
            }
            return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
        }
        */
    }

    //Mostrar adjuntos de diagnostico comunitario
    public function show_dc($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //Ver que exista
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }


        $codigo="";
        $adjuntado = $adjunto->rel_diagnostico_comunitario;
        if($adjuntado) {
            $entrevista = $adjuntado->rel_id_diagnostico_comunitario;
            if($entrevista) {
                $codigo=$entrevista->entrevista_codigo;
                $id_primaria = $entrevista->id_diagnostico_comunitario;
                //Primer chequeo: ¿puede acceder a la entrevista?
                if(!$entrevista->puede_acceder_entrevista) {
                    abort(403,"No puede consultar esta entrevista");
                }

                //Segundo chequeo: reservado-3
                if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
                    abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
                }

            }
            else {
                abort(403,"No existe la entrevista a profundidad especificada al adjunto");
            }
        }
        else {
            abort(403,"Adjunto no pertenece a la entrevista a profundidad");
        }




        //Como se nombra el archivo a descargar
        $nombre = $adjunto->nombre_dc;
        $nombre_descarga = $adjunto->nombre_descarga($nombre);  //Le agrega el nombre original al nombre del archivo
        //quitar noASCII
        $nombre_descarga=filter_var($nombre_descarga, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);


        //Marca de agua, si procede
        $info=pathinfo($adjunto->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = "txt";
        }
        //dd($ext);
        //Traza
        //Registrar traza
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>6, 'codigo'=>$codigo , 'id_primaria'=>$id_primaria]);

        return $this->entregar_archivo($adjunto, $nombre_descarga, $entrevista);
        /*

        if($ext=="pdf") {  //Aplicar marca de agua
            $texto = \Auth::user()->fmt_numero_entrevistador. " - Entrevistador # ". \Auth::user()->fmt_numero_entrevistador;
            try {
                $marcado = adjunto::marca_agua($adjunto->ubicacion,$texto);
                return Storage::download('public/'.$marcado->pdf_destino,$nombre_descarga);
            }
            catch(\Exception $e) {
                //dd("problema");
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }
        }
        elseif($ext=="html") {
            //return Storage::get('public/'.$adjunto->ubicacion);
            $html= Storage::get('public/'.$adjunto->ubicacion);
            $estilizado = self::agregar_css($html);
            return $estilizado->final;

        }
        elseif($adjunto->hay_cifrado()) {
            if(\Gate::allows('nivel-1') || \Gate::allows('es-propio',$entrevista->id_entrevistador)) {
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }
            else {
                return Storage::download('public/'.$adjunto->hay_cifrado(),$nombre_descarga.".gpg");
            }

        }
        else {
            //Revisar parametro de bloqueo de descargas
            $habilitado = entrevista_individual::puede_descargar($entrevista->id_entrevistador);
            if(!$habilitado) {
                abort(403,"Por seguridad, la descarga de archivos se encuentra bloqueada. ");
            }
            return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
        }
        */
    }

    //Mostrar adjuntos de mis casos
    public function show_mc($id)
    {
        //CHEQUEOS DE SEGURIDAD
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $adjunto = adjunto::find($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }
        //Buscar la entrevista a travez del adjuntado
        $entrevista = $adjunto->rel_mis_casos->rel_id_mis_casos;
        //Para la traza
        $adjuntado = $adjunto->rel_mis_casos;
        $descripcion = $adjuntado->descripcion;

        $puede = $entrevista->puede_acceder_adjuntos();
        if(!$puede) {
            abort(403,'Acceso denegado, no cuenta con autorización para acceder a este archivo');
        }
        // fIN DE LOS CHEQUEOS DE SEGURIDAD

        //Para la traza de seguridad
        $codigo      = $entrevista->entrevista_codigo;
        $id_primaria = $entrevista->id_mis_casos;

        //Como se nombra el archivo a descargar
        $nombre = $adjunto->nombre_mc;
        $nombre_descarga = $adjunto->nombre_descarga($nombre);  //Le agrega el nombre original al nombre del archivo
        //quitar noASCII
        $nombre_descarga=filter_var($nombre_descarga, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);


        //Marca de agua, si procede
        $info=pathinfo($adjunto->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = "txt";
        }
        //dd($ext);
        //Traza
        //Registrar traza
        traza_actividad::create(['id_objeto'=>20, 'id_accion'=>6, 'codigo'=>$codigo , 'id_primaria'=>$id_primaria, 'referencia'=>$descripcion]);

        //Sin transformación
        return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);

        //-- Dejo esto por si quieren transforar algo
        /*

        if($ext=="pdf") {  //Aplicar marca de agua
            $texto = \Auth::user()->fmt_numero_entrevistador. " - Entrevistador # ". \Auth::user()->fmt_numero_entrevistador;
            try {
                $marcado = adjunto::marca_agua($adjunto->ubicacion,$texto);
                return Storage::download('public/'.$marcado->pdf_destino,$nombre_descarga);
            }
            catch(\Exception $e) {
                //dd("problema");
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }

        }
        elseif($ext=="html") {
            //return Storage::get('public/'.$adjunto->ubicacion);
            $html= Storage::get('public/'.$adjunto->ubicacion);
            $estilizado = self::agregar_css($html);
            return $estilizado->final;

        }
        elseif($adjunto->hay_cifrado()) {
            if(\Gate::allows('nivel-1')) {
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }
            else {
                return Storage::download('public/'.$adjunto->hay_cifrado(),$nombre_descarga.".gpg");
            }

        }
        else {
            //Revisar parametro de bloqueo de descargas
            $habilitado = entrevista_individual::puede_descargar($entrevista->id_entrevistador);
            if(!$habilitado) {
                abort(403,"Por seguridad, la descarga de archivos se encuentra bloqueada. ");
            }
            return Storage::download('public/'.$adjunto->ubicacion,$nombre);
        }
        */
    }

    //Mostrar adjuntos de censo de archivos en el exilio
    public function show_ca($id)
    {
        //CHEQUEOS DE SEGURIDAD
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $adjunto = adjunto::find($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }
        //Buscar la entrevista a travez del adjuntado
        $entrevista = $adjunto->rel_censo_archivos->rel_id_censo_archivos;
        //Para la traza
        $adjuntado = $adjunto->rel_censo_archivos;
        $descripcion = $adjuntado->descripcion;

        $puede = $entrevista->puede_acceder_adjuntos();
        if(!$puede) {
            abort(403,'Acceso denegado, no cuenta con autorización para acceder a este archivo');
        }
        // fIN DE LOS CHEQUEOS DE SEGURIDAD

        //Para la traza de seguridad
        $codigo      = $entrevista->entrevista_codigo;
        $id_primaria = $entrevista->id_censo_archivos;

        //Como se nombra el archivo a descargar
        $nombre = $adjunto->nombre_ca;
        $nombre_descarga = $adjunto->nombre_descarga($nombre);  //Le agrega el nombre original al nombre del archivo
        //quitar noASCII
        $nombre_descarga=filter_var($nombre_descarga, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);


        //Marca de agua, si procede
        $info=pathinfo($adjunto->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = "txt";
        }
        //dd($ext);
        //Traza
        //Registrar traza
        traza_actividad::create(['id_objeto'=>26, 'id_accion'=>6, 'codigo'=>$codigo , 'id_primaria'=>$id_primaria, 'referencia'=>$descripcion]);

        //Sin transformación
        return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);


    }

    //Para mostrar las guias y documentos, otro esquema de seguridad
    public function show_guia($id)
    {
        //Que exista
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        if($adjunto) {
            //Que sea de las guias
            $es_guia = documento::where('id_adjunto',$id)->first();
            if(!$es_guia) {
                abort(404);
            }
        }
        else {
            abort(404);
        }

        $archivo=$adjunto->ubicacion;
        //$contents = Storage::get('public'.$archivo);
        //dd($contents);
        $nombre = $adjunto->nombre;
        return Storage::download('public/'.$adjunto->ubicacion,$nombre);
    }
    //Mostrar adjuntos de autorizaciones a R-3
    public function show_autoriza($id)
    {
        //Que exista
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        //Que sea una autorización
        if($adjunto) {
            $es_guia = reservado_acceso::where('id_adjunto',$id)->first();
            if(!$es_guia) {
                abort(404);
            }
        }
        else {
            abort(404);
        }

        $nombre = $adjunto->nombre_adjunto;
        return Storage::download('public/'.$adjunto->ubicacion,$nombre);
    }

    //Exceles con listado de codigos
    //Mostrar adjuntos de censo de archivos en el exilio
    public function show_excel($id)
    {
        //CHEQUEOS DE SEGURIDAD
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $adjunto = adjunto::find($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }
        //Buscar la entrevista a travez del adjuntado
        $excel = $adjunto->rel_excel_listados;
        //Para la traza


        //Para la traza de seguridad
        $codigo      = null;
        $id_primaria = $excel->id_excel_listados;
        $referencia = $excel->descripcion;

        //Como se nombra el archivo a descargar
        $nombre = $adjunto->nombre_excel;
        $nombre_descarga = $adjunto->nombre_descarga($nombre);  //Le agrega el nombre original al nombre del archivo
        //quitar noASCII
        $nombre_descarga=filter_var($nombre_descarga, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);


        //Registrar traza
        traza_actividad::create(['id_objeto'=>30, 'id_accion'=>6, 'codigo'=>$codigo , 'id_primaria'=>$id_primaria, 'referencia'=>$referencia]);

        //Sin transformación
        return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);


    }



    /**
     * Show the form for editing the specified adjunto.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        abort(403);
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);

        if (empty($adjunto)) {
            Flash::error('Adjunto not found');

            return redirect(route('adjuntos.index'));
        }

        return view('adjuntos.edit')->with('adjunto', $adjunto);
    }

    /**
     * Update the specified adjunto in storage.
     *
     * @param  int              $id
     * @param UpdateadjuntoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateadjuntoRequest $request)
    {
        abort(403);
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);

        if (empty($adjunto)) {
            Flash::error('Adjunto not found');

            return redirect(route('adjuntos.index'));
        }

        $adjunto = $this->adjuntoRepository->update($request->all(), $id);

        Flash::success('Adjunto updated successfully.');

        return redirect(route('adjuntos.index'));
    }

    /**
     * Remove the specified adjunto from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        abort(403);
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);

        if (empty($adjunto)) {
            Flash::error('Adjunto not found');

            return redirect(route('adjuntos.index'));
        }

        $this->adjuntoRepository->delete($id);

        Flash::success('Adjunto deleted successfully.');

        return redirect(route('adjuntos.index'));
    }


    //Transmitir adjunto de entrevista individual
    public function transmitir_original($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //Ver que exista
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }


        $codigo="";
        $adjuntado = $adjunto->rel_entrevista_individual;
        //dd($adjunto);
        if($adjuntado) {
            $entrevista = $adjuntado->rel_id_e_ind_fvt;
            if($entrevista) {
                $codigo=$entrevista->entrevista_codigo;
                $id_primaria=$entrevista->id_entrevista_profundidad; //para la traza
                //Primer chequeo: ¿puede acceder a la entrevista?
                if(!$entrevista->puede_acceder_entrevista) {
                    abort(403,"No puede consultar esta entrevista");
                }

                //Segundo chequeo: reservado-3
                if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
                    abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
                }

            }
            else {
                abort(403,"No existe la entrevista  especificada al adjunto");
            }
        }
        else {
            abort(403,"Adjunto no pertenece a entrevista a individual");
        }





        $archivo=$adjunto->ubicacion;
        $contents = Storage::get('public'.$archivo);
        $filename = Storage::url('public'.$archivo);
        $filesize = (int)Storage::size('public'.$archivo);

        $nombre = $adjunto->nombre;


        $response = Response::make($contents, 200);
        $response->header('Content-Type', 'audio/mpeg');
        $response->header('Content-Length', $filesize);
        $response->header('Accept-Ranges', 'bytes');
        $response->header('Content-Range', 'bytes 0-'.$filesize.'/'.$filesize);

        //Traza de actividad
        //traza_actividad::create(['id_objeto'=>2, 'id_accion'=>16, 'codigo'=>$codigo , 'id_primaria'=>$id_primaria]);

        return $response;

    }

    //Transmitir adjunto de entrevista individual
    public function transmitir($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //Ver que exista
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }


        $codigo="";
        $entrevista = $adjunto->entrevista;
        if(!$entrevista) {
            abort(403,"No existe la entrevista  especificada al adjunto");
        }
        //Primer chequeo: ¿puede acceder a la entrevista?
        if(!$entrevista->puede_acceder_entrevista) {
            abort(403,"No puede consultar esta entrevista");
        }
        //Segundo chequeo: reservado-3
        if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
            abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
        }

        $archivo=$adjunto->ubicacion;

        return $this->transmision_eficiente($archivo);

    }

    //Transmitir adjunto de entrevista colectiva
    public function transmitir_co($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //Ver que exista
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }



        $adjuntado = $adjunto->rel_entrevista_colectiva;
        //dd($adjunto);
        if($adjuntado) {
            $entrevista = $adjuntado->rel_id_entrevista_colectiva;
            if($entrevista) {
                //Primer chequeo: ¿puede acceder a la entrevista?
                if(!$entrevista->puede_acceder_entrevista) {
                    abort(403,"No puede consultar esta entrevista");
                }

                //Segundo chequeo: reservado-3
                if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
                    abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
                }

            }
            else {
                abort(403,"No existe la entrevista  especificada al adjunto");
            }
        }
        else {
            abort(403,"Adjunto no pertenece a entrevista a individual");
        }

        $archivo=$adjunto->ubicacion;
        return $this->transmision_eficiente($archivo);
    }

    //Transmitir adjunto de entrevista etnica
    public function transmitir_ee($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //Ver que exista
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }



        $adjuntado = $adjunto->rel_entrevista_etnica;
        //dd($adjunto);
        if($adjuntado) {
            $entrevista = $adjuntado->rel_id_entrevista_etnica;
            if($entrevista) {
                //Primer chequeo: ¿puede acceder a la entrevista?
                if(!$entrevista->puede_acceder_entrevista) {
                    abort(403,"No puede consultar esta entrevista");
                }
                //Segundo chequeo: reservado-3
                if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
                    abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
                }
            }
            else {
                abort(403,"No existe la entrevista  especificada al adjunto");
            }
        }
        else {
            abort(403,"Adjunto no pertenece a entrevista a individual");
        }

        $archivo=$adjunto->ubicacion;
        return $this->transmision_eficiente($archivo);
    }

    //Transmitir adjunto de entrevista profundidad
    public function transmitir_pr($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //Ver que exista
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }



        $adjuntado = $adjunto->rel_entrevista_profundidad;
        //dd($adjunto);
        if($adjuntado) {
            $entrevista = $adjuntado->rel_id_entrevista_profundidad;
            if($entrevista) {
                //Primer chequeo: ¿puede acceder a la entrevista?
                if(!$entrevista->puede_acceder_entrevista) {
                    abort(403,"No puede consultar esta entrevista");
                }
                //Segundo chequeo: reservado-3
                if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
                    abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
                }
            }
            else {
                abort(403,"No existe la entrevista  especificada al adjunto");
            }
        }
        else {
            abort(403,"Adjunto no pertenece a entrevista a individual");
        }

        $archivo=$adjunto->ubicacion;
        return $this->transmision_eficiente($archivo);
    }

    //Transmitir adjunto de diagnostico comunitario
    public function transmitir_dc($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //Ver que exista
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }



        $adjuntado = $adjunto->rel_diagnostico_comunitario;
        //dd($adjunto);
        if($adjuntado) {
            $entrevista = $adjuntado->rel_id_diagnostico_comunitario;
            if($entrevista) {
                //Primer chequeo: ¿puede acceder a la entrevista?
                if(!$entrevista->puede_acceder_entrevista) {
                    abort(403,"No puede consultar esta entrevista");
                }

                //Segundo chequeo: reservado-3
                if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
                    abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
                }

            }
            else {
                abort(403,"No existe la entrevista  especificada al adjunto");
            }
        }
        else {
            abort(403,"Adjunto no pertenece a entrevista a individual");
        }



        $archivo=$adjunto->ubicacion;
        return $this->transmision_eficiente($archivo);
    }

    //Transmitir adjunto de historia de vida
    public function transmitir_hv($id)
    {
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }
        //Ver que exista
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }

        $adjuntado = $adjunto->rel_historia_vida;
        //dd($adjunto);
        if($adjuntado) {
            $entrevista = $adjuntado->rel_id_historia_vida;
            if($entrevista) {
                //Primer chequeo: ¿puede acceder a la entrevista?
                if(!$entrevista->puede_acceder_entrevista) {
                    abort(403,"No puede consultar esta entrevista");
                }
                //Segundo chequeo: reservado-3
                if(!$entrevista->puede_acceder_adjuntos()) { //R3 y R2
                    abort(403, "No puede consultar adjuntos para un expediente RESERVADO");
                }
            }
            else {
                abort(403,"No existe la entrevista  especificada al adjunto");
            }
        }
        else {
            abort(403,"Adjunto no pertenece a entrevista a individual");
        }


        $archivo=$adjunto->ubicacion;
        return $this->transmision_eficiente($archivo);
    }


    public function transmitir_eduar($id)
    {
        if($id<>66) {
            abort(403, "Solo se vale con el 66");
        }

        //Que no vean los ajenos
        $adjunto = $this->adjuntoRepository->findWithoutFail($id);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id");
        }



        $archivo=$adjunto->ubicacion;
        return $this->transmision_eficiente($archivo);

    }

    public static function agregar_css($html) {

        //Quitar doble enter que meten los transcriptores (lili, 20/1/20)
        $quitar= '<p><span> </span></p>';
        $limpio = str_ireplace($quitar,'',$html);

        //Edición de 6-dic-22: quitar marca de agua
        //Marca de agua
        //$texto = \Auth::user()->fmt_numero_entrevistador. " - Entrevistador # ". \Auth::user()->fmt_numero_entrevistador;
        //$png = adjunto::generar_png2($texto,\Auth::user()->fmt_numero_entrevistador.".png");
        //dd($png);
        //$fondo = url('storage/'.$png);
        $fondo = '';
        //dd($fondo);

        //Agregar CSS minimo
        $css ="<link rel='stylesheet' href='".asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') ."'>";
        $css.="<link rel='stylesheet' href='".asset('vendor/adminlte/dist/css/AdminLTE.min.css') ."'>";
        $css.="<style>
                    p {
                          text-align: justify;
                          /*
                          line-height: normal;
                          margin-bottom: 0px;
                          */
                        }
                    body {
                        padding: 10px;
                        background-image: url('$fondo') !important;;
                       
                    }
                   @media print {
                          body {
                            -webkit-print-color-adjust: exact;
                            background-image: url('$fondo');
                          }
                          /*
                            body:before { 
                                        content: url('$fondo');
                                        position: absolute; 
                            }
                            
                           */
                            * {
                                -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
                                color-adjust: exact !important;  /*Firefox*/
                              }
                            }
                        }
                    @page {
                            size:letter portrait;
                            margin-left: 0px;
                            margin-right: 0px;
                            margin-top: 0px;
                            margin-bottom: 0px;
                            margin: 0;
                            -webkit-print-color-adjust: exact;
                        }
                        @media screen {
                          div.divFooter {
                            display: none;
                            color: green;
                            background-color:red;
                          }
                        }
                        @media print {
                          div.divFooter {
                            position: fixed;
                            bottom: 0;
                            margin-top: 25px; 
                            color: green;
                            background-color:red;
                          }
                        }
    
                </style>";

        $pie=\Auth::user()->fmt_numero_entrevistador;
        $final = str_ireplace("</head>",$css."</head><div class='divFooter'>E#$pie</div>",$limpio);




        //Dar respuesta con todos los valores utilizados
        $res=new \stdClass();
        $res->css=$css;
        $res->html=$html;
        $res->limpio=$limpio;
        $res->final = $final;
        return $res;
    }


    public function transmision_eficiente($archivo) {
        $fs = Storage::disk('local')->getDriver();
        $filename  = '/public'.$archivo;

        //Buscar la version degradada
        $otro = substr($filename,0,-4);
        $otro = $otro . "_64k.mp3";
        if(Storage::exists($otro)) {
            $filename=$otro;
        }
        $filesize = (int)Storage::size($filename);

        //Pruebas
        $path = storage_path()."/app".$filename;
        //dd($filesize);
        $headers = array(
            'Accept-Ranges: 0-' . ($filesize -1) ,

            //'Content-Length:'.filesize($file),
            //'Content-Type:' . $mime_type,
            //'Content-Disposition: inline; filename="'.$filename.'"'

        );
        $response = new BinaryFileResponse($path,200,$headers);
        BinaryFileResponse::trustXSendfileTypeHeader();
        return $response;
        //-------------

        //$filesize = (int)$fs->size($filename);


        if($filesize > env('expedientes.stream_max')) {
            //Transmitir conforme se lee
            $stream = $fs->readStream($filename);

            if (ob_get_level()) ob_end_clean();
            return response()->stream(
                function () use ($stream) {
                    fpassthru($stream);
                },
                200,
                [
                    'Content-Type' => 'audio/mpeg',
                    'Accept-Ranges' =>'bytes' ,
                    'Content-Range' =>  'bytes 0-'.$filesize.'/'.$filesize
                ]);
        }
        else {
            //Leer primero y transmitir por completo
            $contents = $fs->get($filename);
            //
            $response = Response::make($contents, 200);
            $response->header('Content-Type', 'audio/mpeg');
            $response->header('Content-Length', $filesize);
            $response->header('Accept-Ranges', 'bytes');
            $response->header('Content-Range', 'bytes 0-'.$filesize.'/'.$filesize);
            //
            return $response;
        }
    }

    public function pdf_viewer($id_adjunto, $texto_titulo="") {


        /*
         * SEGURIDAD
         */
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $adjunto = adjunto::find($id_adjunto);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id_adjunto");
        }

        $entrevista = $adjunto->entrevista;
        //dd($entrevista);

        //Revisar que tenga acceso a la entrevista
        $puede = $entrevista->puede_acceder_entrevista;
        if(!$puede) {
            abort(403,'Acceso denegado, no cuenta con autorización para acceder a esta entrevista');
        }

        //Revisar que tenga acceso a los adjuntos
        $puede = $entrevista->puede_acceder_adjuntos();
        if(!$puede) {
            abort(403,'Acceso denegado, no cuenta con autorización para acceder a este archivo');
        }
        // fIN DE LOS CHEQUEOS DE SEGURIDAD

        /*
         * VISOR
         */


        $adjunto = adjunto::find($id_adjunto);

        //VAlidar: existe el adjunto
        if(!$adjunto) {
            Flash::error("No existe el adjunto indicado $id_adjunto");
            return redirect()->back();
        }

        //Nombre del archivo ////////////////
        $archivo=$adjunto->ubicacion;
        ///////////////////////////////////

        //Validar que sea pdf
        $info=pathinfo($adjunto->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = "txt";
        }
        $ext = mb_strtolower($ext);
        if($ext <> 'pdf') {
            Flash::error("El archivo especificado no es un pdf ($ext)");
            return redirect()->back();
        }

        //Validar que exista
        $existe = Storage::exists('public'.$archivo);

        if(!$existe) {
            Flash::error("No se encontró el archivo ($archivo)");
            return redirect()->back();
        }

        //Validaciones finalizadas
        $texto = \Auth::user()->fmt_numero_entrevistador. " - Entrevistador # ". \Auth::user()->fmt_numero_entrevistador;
        $nombre_imagen = \Auth::user()->fmt_numero_entrevistador.".png";
        $png = adjunto::generar_png3($texto,$nombre_imagen);
        $piezas = explode("/",$png);
        foreach($piezas as $x) {
            $marca_agua = $x;
        }
        $marca_agua = url('storage/'.$marca_agua);
        //$ubicacion = Storage::url('public'.$archivo);
        $ubicacion = url("pdf/$id_adjunto");
        return view('pages.visor_pdf',compact('ubicacion','marca_agua','adjunto'));



    }


    //Entrega el contenido de un PDF.  Me evita mostrar la ruta exacta del archivo
    // USADO en el visor inline
    public function entregar_pdf($id_adjunto) {
        /*
         * SEGURIDAD
         */
        if(\Gate::allows('solo-estadistica')) {
            abort(403,"El perfil del usuario no permite acceder a esta parte del sistema");
        }

        $adjunto = adjunto::find($id_adjunto);
        if (empty($adjunto)) {
            abort(403,"Archivo adjunto no existe: $id_adjunto");
        }

        $entrevista = $adjunto->entrevista;
        if(!$entrevista) {
            abort(403,"Archivo adjunto especificado ya no cuenta con entrevista asociada");
        }
        //dd($entrevista);

        //Revisar que tenga acceso a la entrevista
        $puede = $entrevista->puede_acceder_entrevista;
        if(!$puede) {
            abort(403,'Acceso denegado, no cuenta con autorización para acceder a esta entrevista');
        }

        //Revisar que tenga acceso a los adjuntos
        $puede = $entrevista->puede_acceder_adjuntos();
        if(!$puede) {
            abort(403,'Acceso denegado, no cuenta con autorización para acceder a este archivo');
        }
        // fIN DE LOS CHEQUEOS DE SEGURIDAD

        //Para la traza de seguridad
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>6, 'codigo'=>$entrevista->entrevista_codigo , 'id_primaria'=>$id_adjunto, 'referencia'=>'Visor PDF']);


        /*
         * Entrega del adjunto
         */

        $adjunto = adjunto::find($id_adjunto);
        $pdf = Storage::get('public/'.$adjunto->ubicacion);
        return Storage::download('public/'.$adjunto->ubicacion,"archivo.pdf");
    }


    public function cifrar($id) {

        $this->authorize('nivel-1');
        $cual = adjunto::find($id);
        $codigo = "desconocido";
        if($cual) {
            $codigo = $cual->entrevista->entrevista_codigo;
            $res = $cual->cifrar();
        }
        else {
            $res = "No existe el adjunto $cual";
        }

        return view('pages.comandos')->with('listado',$res)->with('id',$id)->with('codigo',$codigo);

    }

    //Codigo común luego de la traza de los show() de c/tipo de entrevista
    public function entregar_archivo($adjunto, $nombre_descarga, $entrevista){

        //Determinar la extensión del archivo
        $info=pathinfo($adjunto->ubicacion);
        if(isset($info['extension'])) {
            $ext = $info['extension'];
        }
        else {
            $ext = "txt";
        }



        if($ext=="pdf") {  //Aplicar marca de agua
            $texto = \Auth::user()->fmt_numero_entrevistador. " - Entrevistador # ". \Auth::user()->fmt_numero_entrevistador;
            try {
                $marcado = adjunto::marca_agua($adjunto->ubicacion,$texto);
                return Storage::download('public/'.$marcado->pdf_destino,$nombre_descarga);
            }
            catch(\Exception $e) {
                Log::warning('Problemas con la marca de agua: '.$e->getMessage());
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }
        }
        elseif($ext=="html") { //Aplicar formato CSS
            //return Storage::get('public/'.$adjunto->ubicacion);
            $html= Storage::get('public/'.$adjunto->ubicacion);
            $estilizado = self::agregar_css($html);
            return $estilizado->final;

        }
        elseif($adjunto->hay_cifrado()) {  //Descarga del cifrado
            if(\Gate::allows('nivel-1') || \Gate::allows('es-propio',$entrevista->id_entrevistador) || \Gate::allows('rol-descarga')) {
                return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
            }
            else {
                return Storage::download('public/'.$adjunto->hay_cifrado(),$nombre_descarga.".gpg");
            }

        }
        else {  //Descargar el archivo como recurso final
            $habilitado=false;
            //Excepción para casos einformes
            if(isset($entrevista->id_casos_informes)) {
                if($entrevista->id_casos_informes > 0) {
                    $habilitado=true;
                }
            }
            //Detectar si fue compartida para editar.
            $compartido = entrevista_individual::compartido_edicion($entrevista);
            if($compartido){
                $habilitado = true;
            }
            //Detectar si puede descargarla por reglas del perfil
            if(!$habilitado) {
                $habilitado = entrevista_individual::puede_descargar($entrevista->id_entrevistador);
            }

            if(!$habilitado) {
                abort(403,"Por seguridad, la descarga de archivos se encuentra bloqueada. ");
            }
            return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
        }

    }

    //Para pruebas
    //Mostrar adjuntos de entrevista profundidad
    public function descarga_directa($id)
    {
        $this->authorize('nivel-1');  //Solo admin
        $adjunto = adjunto::find($id);
        if(!$adjunto) {
            abort(403,"Archivo adjunto no existe: $id");
        }

        $nombre_descarga = $adjunto->nombre_original;

        //quitar noASCII
        $nombre_descarga=filter_var($nombre_descarga, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        return Storage::download('public/'.$adjunto->ubicacion,$nombre_descarga);
    }


    public function calificar(Request $request) {
        $adjunto = adjunto::find($request->id_adjunto);
        if(!$adjunto) {
            abort(404);
        }
        else {
            //Calificacion
            $adjunto->id_calificacion=intval($request->id_calificacion);
            $adjunto->save();
            //Justificacion
            $adjunto->rel_justificacion()->delete();
            $calificacion[2]=126;
            $calificacion[3]=127;

            if(in_array($adjunto->id_calificacion,[2,3])) { //Opciones multiples
                $var='id_justificacion_'.$calificacion[$adjunto->id_calificacion];
                foreach($request->$var as $id_justificacion){
                    $tmp = new adjunto_justificacion();
                    $tmp->id_adjunto=$adjunto->id_adjunto;
                    $tmp->id_justificacion=$id_justificacion;
                    $tmp->insert_id_entrevistador = \Auth::user()->id_entrevistador;
                    $tmp->save();
                }
            }
            elseif($adjunto->id_calificacion==4) { //Una única opcion
                $tmp = new adjunto_justificacion();
                $tmp->id_adjunto=$adjunto->id_adjunto;
                $tmp->id_justificacion=$request->id_justificacion_128;
                $tmp->insert_id_entrevistador = \Auth::user()->id_entrevistador;
                $tmp->save();
            }

            //Traza en bitácora
            $entrevista = $adjunto->entrevista;
            traza_actividad::create(['id_objeto'=>2, 'id_accion'=>75, 'codigo'=>$entrevista->entrevista_codigo , 'id_primaria'=>$adjunto->id_adjunto,'referencia'=>'Adjunto calificado como '.$adjunto->fmt_id_calificacion]);
            //Fin: de regreso  a la tabla
            return redirect()->back();
        }
    }



    // Control de calificacion: ETL que actualiza la tabla
    public function etl_excel_calificacion() {
        $revision = adjunto::revisar_existe();
        $respuesta = excel_control_adjuntos::generar_plana();
        $respuesta->revision = $revision;
        return response()->json($respuesta);
    }

    //Control de calificacion: descargar excel
    public function excel_calificacion() {
        $this->authorize('nivel-1');
        $fecha=date("Y-m-d");
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>8]);
        return Excel::download(new excel_control_adjuntosExport(),"adjuntos_calificacion_$fecha.xlsx");
    }


    //Revisar que el adjunto existea
    public function revisar_existencia() {
        return adjunto::revisar_existe();
    }






}
