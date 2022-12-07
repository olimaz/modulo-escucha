<?php


use App\Models\parametro;

return [

/*
|--------------------------------------------------------------------------
| Tipo de expediente
|--------------------------------------------------------------------------
|
| id_item de expedientes de entrevista individual a V,F,T (catalogo 1)
|
*/
    'aa' => env('E_AA'),
    'ci' => env('E_CI'),
    'co' => env('E_CO'),
    'dc' => env('E_DC'),
    'hv' => env('E_HV'),
    'pr' => env('E_PR'),
    'tc' => env('E_TC'),
    'vi' => env('E_VI'),
    'ee' => env('E_EE'),


    //NNA
    'nev' => env('NEV'),
    'nes' => env('NES'),
    //Mis casos
    'mc' => env('E_MC'),
    //Censo de archivos
    'ca' => env('E_CA'),

    //id_item de violencia sexual
    'vs' => env('VS'),
    //'vs' =>parametro::find(2)->valor,
    'ws_transcriptor' => env('WS_TRANSCRIBE','http://192.168.1.20:5000/api/transcription'),
    'ws_transcriptor_revisar' => env('WS_TRANSCRIBE_REVISA','http://192.168.1.20:5000/api/transcription/status'),

    'etiquetas_depto'=>612,  // otros valores: 612,350
    'etiquetas_muni'=>350,  //otros valores: 250,350, 612,1223
    'url_clave' => env('URL_CLAVE','https://gc.comisiondelaverdad.co/RDWeb/Pages/en-US/password.aspx'),
    'ad_vence' => env('AD_VENCE',45),  //duracion de la clave en días
    'ad_avisa' =>env('AD_AVISA',5),   //días que faltan para avisar del cambio de clave

    //ABC de responsables, permite mostrar los rangos según la fuerza
    'aa_gp' =>env('AA_GP',0),
    'aa_gu' =>env('AA_GU',0),
    'aa_fp' =>env('AA_FP',0),
    'internacional' => env('INTERNACIONAL',9176),
    'cantidad_transcribir' => env('CANTIDAD_TRANSCRIBIR',10),
    'indigena' => env('INDIGENA',196),
    'idioma_nativo' => env('IDIOMA_NATIVO',178),
    'idioma_espanol' => env('IDIOMA_ESPANOL',177)

    //Servicios de data turk
    , 'turk_key' => env('TURK_KEY','b722de5c-cf62-4b6a-bcd6-b55758f18ad1')
    , 'turk_secret' => env('TURK_SECRET','i6eZL5HsfKHQvOmFWO1TsOpaW7EB6XCVt3xpuBdIn33ouVNoIw8EM8GJHBns6Ur7')
    , 'turk_url' => env('TURK_URL','https://etiquetado.comisiondelaverdad.co/dtAPI/v1/sim/')
    , 'turk_limit' => env('TURK_LIMIT',65535) //tamanyo máximo de texto que se puede enviar

    ,'primer_registro' =>env('PRIMER_REGISTRO',5) //id_nivel que se asigna a los usuarios nuevos
    , 'visor_pdf' => env('VISOR_PDF',true)
    , 'ocultar_stream_wav' => env('OCULTAR_STREAM_WAV',true)
    , 'stream_max' => env('STREAM_MAX',201551319)  //Tamaño del archivo que se carga por completo en lugar de por pocos
    , 'transcribir_google' => env('TRANSCRIBIR_GOOGLE',false)
    ,'mis_casos' => explode(',',env('MIS_CASOS','11,20,135,192'))  //Valores de producción para Lili, Oliver, CMB y Myriam Loaiza

    //Servicio de etiquetado de etiquetas de Eduar
    , 'url_pre_etiquetado' => env('URL_PRE_ETIQUETADO','http://192.168.1.46:8888/api')
    , 'pre_etiquetar' => env('PRE_ETIQUETAR',false) //Banderita para activar/desactivar el pre_etiquetado
    , 'no_descargas' => env('NO_DESCARGAS',true) //Banderita para activar/desactivar el pre_etiquetado
    , 'correo_reportes' => env('CORREO_ETIQUETADO','oliver.mazariegos@comisiondelaverdad.co')
    , 'correo_reportes_cc' => env('CORREO_ETIQUETADO_CC',null)
    , 'correo_reportes_from' => env('MAIL_USERNAME','sim.etiquetado@gmail.com')
    //Traslado a entrevistas a profundidad
    , 'pr_cerrada' => env('PR_CERRADA',247)  //estado=terminada
    , 'pr_sector' => env('PR_SECTOR',218)  //sector=victimas
    ,'caso_comision' => env('CASO_COMISION',90)  //Caso para la comisión. 90 es el valor en produccion
    //Exploracion de fichas
    ,'buscar_fichas_incompletas' => env('BUSCAR_FICHAS_INCOMPLETAS',true)
    ,'ws_nvivo' =>env('URL_NVIVO','http://192.168.4.21:8000/api/generate/')  //Web Service que devuelve qdpx
    //Solicitar compromiso de reserva
    , 'solicitar_compromiso' => env('SOLICITAR_COMPROMISO',false)

    //SWITCH GENERAL PARA CERRAR EL SISTEMA
    , 'sistema_abierto' => env('SISTEMA_ABIERTO',true)
    //SWITCH PARA AUTENTICARSE CONTRA TABLA DE USUARIOS Y ELIMINAR LA AUTENTICACIÓN DE ACTIVE DIRECTORY/GOOGLE
    , 'login_local' => env('LOGIN_LOCAL',false)
    //SWITHC PARA PERMISOS BASADOS EN CALIFICACIÓN (PUBLICO) Y NO EN CLASIFICACIÓN (R-2)
    , 'permisos_legado' => env('PERMISOS_LEGADO',false)

];
