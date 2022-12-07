<?php

setlocale(LC_TIME, 'es_CO.utf8','es_GT.UTF-8','es_ES.UTF-8','es_GT.ISO-8859-1','es_GT','es_ES','es_ES','spanish');
//Carbon
use App\Http\Controllers\fichasController;
use App\Models\entrevista_individual_adjunto;
use App\Models\entrevista_profundidad_adjunto;
use App\Models\exilio;
use Carbon\Carbon;
Carbon::setLocale('es');
Carbon::setWeekStartsAt(Carbon::MONDAY);
Carbon::setWeekEndsAt(Carbon::SUNDAY);


Route::get('/test/ldap','statController@test_ldap');
Route::get('/test/ldap/{usr}/{clave}','statController@test_ldap2');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Pagina inicial
Route::get('/', 'HomeController@index');
Route::get('inicio', 'HomeController@index');
Route::get('home', 'HomeController@index');



//Login local
Route::post('/login/portable', 'Auth\LoginController@login_portable');

//Acerca de
Route::get('about', function () {
    return view('pages.about');
});






//Autenticacion con google
Route::get('/redirect', 'Auth\LoginController@redirectToProvider');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/forzar/{id}','Auth\LoginController@forzar_login');
Route::get('/correo_negado', function () {
    return view('pages.correo_negado');
});

//Usuario deshabilitado
Route::get('/deshabilitado','entrevistadorController@deshabilitado');

//Sobreescribir login y register  para que unicamente se autentique con google
/*
Route::get('login', function () {
    return redirect('/');
})->name('login');
Route::get('register', function () {
    return redirect('/');
});
*/

//Auth::routes();
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('login2', 'Auth\LoginController@show_formulario_credenciales')->name('login2');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('logout', 'Auth\LoginController@logout')->name('logout_get');


//ABC de perfiles, tiene que estar autenticado
Route::group(['middleware' => ['auth','impersonate']], function () {
    //Gestión de entrevistadores
    Route::resource('entrevistadors', 'entrevistadorController');
    // Cambio de clave
    Route::get('cambio_clave','entrevistadorController@frm_cambiar_clave');
    Route::patch('cambio_clave','entrevistadorController@cambiar_clave');

    //Revisar que haya completado su perfil
    Route::get('/llenar_perfil','entrevistadorController@create')->name('llenar_perfil');
    //
    Route::get('autenticado', function () {
        dd("Autenticado.  tiene perfil: ".\Auth::user()->tiene_perfil());
    });

    //Listados de referencia
    Route::get('listados/{id}', 'cat_itemController@listados');
    Route::get('/listado_geo', 'geoController@index');
    Route::get('/listado_geo_cev', 'cevController@index');



    //Resultados de la busqueda rapida
    Route::get('brapida','statController@busqueda_rapida');
    //Ubicar un expediente
    Route::get('ubicar/{codigo}','statController@ubicar');



});


//Para la funcionalidad general, todos tienen que haber llenado el perfil
Route::group(['middleware' => ['revisar_perfil','impersonate']], function () {

    Route::get('ver_perfil', function () {
        return redirect(action('entrevistadorController@show',\Auth::user()->id_entrevistador));
    });
    //Visor de PDF
    Route::get('visor/pdf/{id_adjunto}','adjuntoController@pdf_viewer');
    Route::get('pdf/{id_adjunto}','adjuntoController@entregar_pdf');

    //Habilitar las rutas conforme las necesite
    Route::resource('catItems', 'cat_itemController');
    //Route::resource('catCats', 'cat_catController');
    //Route::resource('criterioFijos', 'criterio_fijoController');
    //Route::resource('geos', 'geoController');
    //Tablas de esclarecimiento, pendiente meterlas al middleware de con-perfil
    Route::resource('entrevistaIndividuals', 'entrevista_individualController');
    Route::resource('entrevistaIndividualAdjuntos', 'entrevista_individual_adjuntoController');
    Route::resource('entrevistaProfundidadAdjuntos', 'entrevista_profundidad_adjuntoController');
    //Descargar excel con resultados
    Route::get("entrevista_victima/generar_excel_filtrado",'entrevista_individualController@generar_excel_filtrado');
    Route::get("entrevista_victima/generar_excel_filtrado_victima",'entrevista_individualController@generar_excel_filtrado_victima');
    Route::get("entrevista_profundidad/generar_excel_filtrado",'entrevista_profundidadController@generar_excel_filtrado');
    Route::get("entrevista_etnica/generar_excel_filtrado",'entrevista_etnicaController@generar_excel_filtrado');
    Route::get("entrevista_colectiva/generar_excel_filtrado",'entrevista_colectivaController@generar_excel_filtrado');
    Route::get("diagnostico_comuntiario/generar_excel_filtrado",'diagnostico_comunitarioController@generar_excel_filtrado');
    Route::get("historia_vida/generar_excel_filtrado",'historia_vidaController@generar_excel_filtrado');
    Route::get("etiquetado/generar_excel_filtrado",'statController@descargar_etiquetado');
    //Explorar fichas
    Route::get("entrevista_victima/generar_excel_filtrado_pe",'entrevista_individualController@generar_excel_filtrado_pe');
    Route::get("entrevista_victima/generar_excel_filtrado_pr",'entrevista_individualController@generar_excel_filtrado_pr');



    //Traslado de VI a otras entrevistas
    Route::get("individual/{id}/traslado_pr",'entrevista_individualController@trasladar_pr');
    Route::get("individual/{id}/traslado_hv",'entrevista_individualController@trasladar_hv');
    Route::get("individual/{id}/traslado_co",'entrevista_individualController@trasladar_co');
    //Traslado de PR a otras entrevistas
    Route::get("profundidad/{id}/traslado_co",'entrevista_profundidadController@trasladar_co');
    //Traslado de CO a otras entrevistas
    Route::get("colectiva/{id}/traslado_ee",'entrevista_colectivaController@trasladar_ee');
    //Traslado de DC a otras entrevistas
    Route::get("diagnostico/{id}/traslado_ee",'diagnostico_comunitarioController@trasladar_ee');


    //Transcribir con google
    Route::get('entrevistaIndividualAdjuntos/{id}/trans','entrevista_individual_adjuntoController@trans');
    Route::get('entrevistaIndividualAdjuntos/{id}/trans_revisar','entrevista_individual_adjuntoController@trans_revisar');
    Route::get('entrevistaProfundidadAdjuntos/{id}/trans','entrevista_profundidad_adjuntoController@trans');
    Route::get('entrevistaProfundidadAdjuntos/{id}/trans_revisar','entrevista_profundidad_adjuntoController@trans_revisar');
    Route::get('entrevistaEtnicaAdjuntos/{id}/trans','entrevista_etnica_adjuntoController@trans');
    Route::get('entrevistaEtnicaAdjuntos/{id}/trans_revisar','entrevista_etnica_adjuntoController@trans_revisar');



    Route::resource('adjuntos', 'adjuntoController');
    Route::get('adjunto_guia/{id}','adjuntoController@show_guia');
    Route::get('adjunto_autoriza/{id}','adjuntoController@show_autoriza');
    //Gestion de adjuntos
    Route::get('gestionar_adjuntos/{id}','entrevista_individualController@gestionar_adjuntos');
    Route::post('gestionar_adjuntos/{id}','entrevista_individualController@agregar_adjuntos');
    Route::get('tabla_adjuntos/{id}','entrevista_individualController@tabla_adjuntos');
    Route::resource('casosInformesAdjuntos', 'casos_informes_adjuntoController');
    Route::post('adjuntos_entrevista_vi/quitar/', 'entrevista_individual_adjuntoController@quitar');


    Route::get('entrevistadors/{id}/nivel','entrevistadorController@frm_nivel');
    Route::post('entrevistadors/{id}/nivel','entrevistadorController@cambiar_nivel');

    Route::get('dash','statController@dash_metadatos');
    Route::get('dash/fichas_vi','statController@stats_diligenciada_vi');
    Route::get('pre/dash/fichas_vi','statController@pre_stats_diligenciada_vi');

    //Ajax de c/seccion de las estadisticas
    Route::get('dash/json/procesamiento','statController@ajax_procesamiento');
    Route::get('dash/json/entrevistada','statController@ajax_entrevistada');
    Route::get('dash/json/victima','statController@ajax_victima');
    Route::get('dash/json/pri','statController@ajax_pri');
    Route::get('dash/json/violencia','statController@ajax_violencia');
    Route::get('dash/json/exilio','statController@ajax_exilio');

    Route::get('faq', function () {
        return view('pages.faq');
    });

    Route::resource('documentos', 'documentoController');

    //Revisar catalogo
    Route::resource('revisar_catalogo', 'revisar_catalogoController');
    Route::match(['get', 'post'], 'revisar_catalogo/aprobar/{id_item}', 'revisar_catalogoController@aprobar')->name('aprobar_catalogo');
    Route::match(['get', 'post'], 'revisar_catalogo/reasignar', 'revisar_catalogoController@reasignar')->name('reasignar_catalogo');
    Route::match(['get', 'post'], 'revisar_catalogo/editar_item', 'revisar_catalogoController@editar_item')->name('editar_item');
    // Route::resource('revisar_catalogo/reasignar', 'revisar_catalogoController');

    //Homologar preguntas derivadas
    Route::get('homologador','cat_catController@homologar_index');
    Route::post('homologador/{id}','cat_catController@homologar_update');

    Route::resource('trazaCatalogos', 'traza_catalogoController');
    Route::resource('directorioCatalogos', 'directorio_catalogoController');


    //Casos e informes
    Route::resource('casosInformes', 'casos_informesController');
    Route::match(['get', 'post'], 'upload', 'UploadController@ajaxImage');
    Route::post( 'upload_adjuntar', 'UploadController@cargarAdjuntar');
    Route::post( 'upload_adjuntar_caso_informe', 'UploadController@cargarAdjuntarCasoInforme');

    //Gestion de adjuntos
    Route::get('gestionar_adjuntos_casos/{id}','casos_informesController@gestionar_adjuntos');
    Route::post('gestionar_adjuntos_casos/{id}','casos_informesController@agregar_adjuntos');
    Route::get('tabla_adjuntos_casos/{id}','casos_informesController@tabla_adjuntos');
    Route::post('calificar_adjuntos','adjuntoController@calificar');

    //Casos e Informes
    Route::resource('casosInformes', 'casos_informesController');


    //Descargar excel
    Route::get('excel/entrevistas_fvt','entrevista_individualController@excel_plano'); //Genera la descarga
    Route::get('excel/entrevistas_fvt/anonimo','entrevista_individualController@excel_plano_anonimo'); //Genera la descarga
    Route::get('excel/dinamicas_fvt','entrevista_individualController@excel_dinamica'); //Genera la descarga
    Route::get('excel/entrevistas_integrado','entrevista_individualController@excel_integrado'); //Genera la descarga
    Route::get('excel/entrevistas_integrado/anonimo','entrevista_individualController@excel_integrado_anonimo'); //Genera la descarga
    Route::get('excel/entrevistas_integrado_monitoreo','entrevista_individualController@excel_integrado_monitoreo'); //Genera la descarga
    Route::get('excel/descarga','excel_entrevistaController@index');  //Pantalla de descarga
    Route::get('excel/exilio_salida','exilioController@descargar_exilio_salida');  //Pantalla de descarga

    Route::get('excel/entrevistas_pr','entrevista_profundidadController@excel_plano'); //Genera la descarga
    Route::get('excel/entrevistas_pr/anonimo','entrevista_profundidadController@excel_plano_anonimo'); //Genera la descarga
    //
    Route::get('excel/ficha_persona_entrevistada','entrevista_individualController@descargar_excel_ficha_persona_entrevistada'); //Genera la descarga
    Route::get('excel/ficha_persona_entrevistada/anonimo','entrevista_individualController@descargar_excel_ficha_persona_entrevistada_anonimo'); //Genera la descarga
    Route::get('excel/ficha_victima','entrevista_individualController@descargar_excel_ficha_victima'); //Genera la descarga
    Route::get('excel/ficha_victima/anonimo','entrevista_individualController@descargar_excel_ficha_victima_anonimo'); //Genera la descarga

    Route::get('excel/casos_informes','casos_informesController@excel_plano');

    Route::get('excel/seguimiento','entrevista_individualController@descargar_excel_seguminiento');
    //Clasificador para nvivo
    Route::get('excel/nvivo','excel_entrevistaController@descargar_excel_nvivo');
    //Entrevistas a sujeto colectvo
    Route::get('excel/sujeto_colectivo','entrevista_etnicaController@descargar_excel');
    Route::get('excel/sujeto_colectivo/anonimo','entrevista_etnicaController@descargar_excel_anonimo');

    //Uso del tesauro
    Route::get('excel/uso_tesauro','statController@descargar_uso_tesauro');

    //Usuario del sistema
    Route::get('excel/entrevistadores','entrevistadorController@descargar_excel');

    //Calificacion de adjuntos
    Route::get('excel/adjuntos_calificacion','adjuntoController@excel_calificacion');









    //Catalogos
    Route::get('catalogos',['as'=> 'catalogos.index', 'uses' => 'cat_itemController@index']);
    Route::get('catalogos/agregar/{id_cat}',['as'=> 'catalogos.create', 'uses' => 'cat_itemController@create']);
    Route::post('catalogos/agregar/{id_cat}',['as'=> 'catalogos.store', 'uses' => 'cat_itemController@store']);
    Route::get('catalogos/editar/{id_item}',['as'=> 'catalogos.edit', 'uses' => 'cat_itemController@edit']);
    Route::post('catalogos/actualizar/{id_item}',['as'=> 'catalogos.update', 'uses' => 'cat_itemController@update']);
    Route::delete('catalogos/elimiar/{id_item}',['as'=> 'catalogos.destroy', 'uses' => 'cat_itemController@destroy']);
    //Reclasificacion
    Route::get('reclasificacion','cat_itemController@index_reclasificar');
    Route::get('reclasificacion/{cat_item}/editar','cat_itemController@frm_editar');
    Route::post('reclasificacion/{cat_item}/editar','cat_itemController@editar');
    Route::get('reclasificacion/{cat_item}/reclasificar','cat_itemController@frm_reclasificar');
    Route::post('reclasificacion/{cat_item}/reclasificar','cat_itemController@reclasificar');


    //NNA
    Route::resource('nnaVulnerabiliads', 'nna_vulnerabiliadController');
    Route::get('json/vulnerabilidad/{correlativo}','nna_vulnerabiliadController@json');
    Route::resource('nnaSeguridads', 'nna_seguridadController');

    //Traza de actividad
    Route::resource('trazaActividads', 'traza_actividadController');

    //Entrevistas Colectivas
    Route::resource('entrevistaColectivas', 'entrevista_colectivaController');
    Route::get('gestionar_adjuntos_colectiva/{id}','entrevista_colectivaController@gestionar_adjuntos');
    Route::get('tabla_adjuntos_colectiva/{id}','entrevista_colectivaController@tabla_adjuntos');
    Route::get('adjunto_colectiva/{id}','adjuntoController@show_co');
    Route::post( 'upload_adjuntar_co', 'UploadController@cargarAdjuntarEntrevistaColectiva');
    Route::post('entrevista_colectiva_adjunto/quitar/', 'entrevista_colectiva_adjuntoController@quitar');

//Entrevistas a Profundidad
    Route::resource('entrevistaProfundidads', 'entrevista_profundidadController');
    Route::get('gestionar_adjuntos_pr/{id}','entrevista_profundidadController@gestionar_adjuntos');
    Route::get('tabla_adjuntos_pr/{id}','entrevista_profundidadController@tabla_adjuntos');
    Route::get('adjunto_pr/{id}','adjuntoController@show_pr');
    Route::post('upload_adjuntar_pr', 'UploadController@cargarAdjuntarEntrevistaProfundidad');
    Route::post('entrevista_pr_adjunto/quitar/', 'entrevista_profundidad_adjuntoController@quitar');
    //Consentimiento
    Route::get('entrevista_pr/{id}/consentimiento','entrevista_profundidadController@frm_ci');
    Route::post('entrevista_pr/{id}/consentimiento','entrevistaController@crear_actualizar_ci');

//Historias de Vida
    Route::resource('historiaVidas', 'historia_vidaController');
    Route::get('gestionar_adjuntos_hv/{id}','historia_vidaController@gestionar_adjuntos');
    Route::get('tabla_adjuntos_hv/{id}','historia_vidaController@tabla_adjuntos');
    Route::get('adjunto_hv/{id}','adjuntoController@show_hv');
    Route::post( 'upload_adjuntar_hv', 'UploadController@cargarAdjuntarHistoriaVida');
    Route::post('hoja_vida_adjunto/quitar/', 'historia_vida_adjuntoController@quitar');
    //Consentimiento
    Route::get('historia_vida/{id}/consentimiento','historia_vidaController@frm_ci');
    Route::post('historia_vida/{id}/consentimiento','entrevistaController@crear_actualizar_ci');

// Diagnósticos Comunitarios
    Route::resource('diagnosticoComunitarios', 'diagnostico_comunitarioController');
    Route::get('gestionar_adjuntos_dc/{id}','diagnostico_comunitarioController@gestionar_adjuntos');
    Route::get('tabla_adjuntos_dc/{id}','diagnostico_comunitarioController@tabla_adjuntos');
    Route::get('adjunto_dc/{id}','adjuntoController@show_dc');
    Route::post( 'upload_adjuntar_dc', 'UploadController@cargarAdjuntarDiagnosticoComunitario');
    Route::post('diagnostico_comunitario_adjunto/quitar/', 'diagnostico_comunitario_adjuntoController@quitar');

//Etnrevistas etnicas
    Route::resource('entrevistaEtnicas', 'entrevista_etnicaController');
    Route::get('gestionar_adjuntos_ee/{id}','entrevista_etnicaController@gestionar_adjuntos');
    Route::get('tabla_adjuntos_ee/{id}','entrevista_etnicaController@tabla_adjuntos');
    Route::get('adjunto_ee/{id}','adjuntoController@show_ee');
    Route::post( 'upload_adjuntar_ee', 'UploadController@cargarAdjuntarEntrevistaEtnica');
    Route::post('entrevista_etnica_adjunto/quitar/', 'entrevista_etnica_adjuntoController@quitar');

//Mis casos
    Route::resource('misCasos', 'mis_casosController');
    //adjuntos
    Route::get('misCasos/{id}/gestionar_adjuntos','mis_casosController@gestionar_adjuntos');
    Route::get('misCasos/{id}/tabla_adjuntos','mis_casosController@tabla_adjuntos');
    Route::get('adjunto_mc/{id}','adjuntoController@show_mc');
    Route::post('upload_adjuntar_mc', 'UploadController@cargarAdjuntarMC');
    Route::post('mis_casos_adjunto/quitar/', 'mis_casosController@quitar_adjunto');
    Route::post('mis_casos_adjunto/agregar/', 'mis_casosController@crear_adjunto');
    //Tareas
    Route::post('mis_casos_tareas/store','mis_casos_tareasController@store');
    Route::post('mis_casos_tareas/{id}/update','mis_casos_tareasController@update');
    Route::post('mis_casos_tareas/{id}/destroy','mis_casos_tareasController@destroy');
    //Personas
    Route::resource('misCasosPersonas', 'mis_casos_personaController');
    Route::post('misCasosPersonas/{id}/update_contactada','mis_casos_personaController@update_contactada');
    Route::post('misCasosPersonas/{id}/update_entrevistada','mis_casos_personaController@update_entrevistada');
    //Entrevistas
    Route::post('mis_casos_entrevsita/agregar','mis_casos_entrevistaController@agregar');
    Route::get('mis_casos_entrevsita/quitar/{id}','mis_casos_entrevistaController@quitar');

// Desclasificar
    Route::resource('desclasificars', 'desclasificarController');
// Enlazar entrevistas
    Route::resource('enlaces', 'enlaceController');

//Dar permisos
    Route::post('dar_acceso/create','reservado_accesoController@store');
    Route::delete('dar_acceso/{id}','reservado_accesoController@destroy');
    Route::get('accesos_r3','reservado_accesoController@index');

    //MApa
    Route::get('mapa/e_ind_fvt','mapController@entrevista')->name('mapa.e_ind_fvt');

    Route::get('json/e_ind_fvt/entrevista','entrevista_individualController@json_entrevista')->name('json.e_ind_fvt_entrevista');
    Route::get('json/e_ind_fvt/hechos','entrevista_individualController@json_hechos')->name('json.e_ind_fvt_hechos');

    //Streaming
    Route::get('transmitir/{id}', 'adjuntoController@transmitir');
    Route::get('transmitir2/{id}', 'adjuntoController@transmitir2');
    Route::get('transmitir_co/{id}', 'adjuntoController@transmitir_co');
    Route::get('transmitir_pr/{id}', 'adjuntoController@transmitir_pr');
    Route::get('transmitir_hv/{id}', 'adjuntoController@transmitir_hv');
    Route::get('transmitir_dc/{id}', 'adjuntoController@transmitir_dc');
    Route::get('transmitir_ee/{id}', 'adjuntoController@transmitir_ee');

    //Control de transcripcion
    Route::resource('transcribirAsignacions', 'transcribir_asignacionController');
    Route::get('transcripciones/cuadro_resumen', 'transcribir_asignacionController@cuadro_resumen');
    Route::get('entrevistador/json','entrevistadorController@json_numero');
    Route::get('entrevista/json','entrevista_individualController@json_numero');

    //Control de etiquetado
    Route::resource('etiquetarAsignacions', 'etiquetar_asignacionController');
    Route::get('etiquetado/cuadro_resumen', 'etiquetar_asignacionController@cuadro_resumen');
    Route::get('etiquetado/enviar_dataturk','etiquetar_asignacionController@enviar_dataturk');

    //Fichas de responsables

    Route::resource('persona_responsable', 'persona_responsableController');
    Route::get('persona_responsable/create/{id_e_ind_fvt}','persona_responsableController@create');
    Route::get('persona_responsable/show/{id}/entrevista/{id_e_ind_fvt}','persona_responsableController@show')->name('persona_responsable.show');
    Route::get('persona_responsable/edit/{id}/entrevista/{id_e_ind_fvt}','persona_responsableController@edit')->name('persona_responsable.edit');


    //Agregar nueva opción al catálogo
    Route::post('/cat/create','cat_itemController@store_otro');

    //Agregar nueva opción al catálogo geográfico
    Route::post('/geo/create','geoController@store_otro');


    /*
     * DILIGENCIAR FICHAS
     */

    //  Diligenciar fichas entrevistas_etnicas
    Route::get('entrevistaEtnica/{id}/fichas','entrevista_etnicaController@fichas')->name('entrevistaEtnica.fichas');
    // Ver fichas diligenciadas
    Route::get('entrevistaEtnica/{id}/fichas_show','entrevista_etnicaController@fichas_show')->name('entrevistaEtnica.fichas_show');


    // Diligenciar fichas
    Route::get('entrevistaIndividuals/{id}/fichas','entrevista_individualController@fichas')->name('entrevistaindividual.fichas');
    // Ver fichas diligenciadas
    Route::get('entrevistaIndividuals/{id}/fichas_show','entrevista_individualController@fichas_show')->name('entrevistaindividual.fichas_show');

    //Agregar comentarios de la diligenciada
    Route::post('entrevistaIndividuals/comentarios_diligenciada','entrevista_individualController@grabar_comentarios');
    Route::post('entrevistaEtnica/comentarios_diligenciada','entrevista_etnicaController@grabar_comentarios');


    Route::resource('entrevistas', 'entrevistaController')->except([
        'create'
    ]);

    Route::get('entrevistas/create/{id}','entrevistaController@create')->name('entrevistas.create');

    Route::resource('personas', 'personaController');
    Route::get('personas/create/{id_e_ind_fvt}','personaController@create');
    Route::get('personas/show/{id}/entrevista/{id_e_ind_fvt}','personaController@show')->name('personas.show');
    Route::get('personas/edit/{id}/entrevista/{id_e_ind_fvt}','personaController@edit')->name('personas.edit');

    Route::resource('victimas', 'victimaController');
    Route::get('victimas/create/{id_e_ind_fvt}','victimaController@create');
    Route::get('victimas/show/{id}/entrevista/{id_e_ind_fvt}','victimaController@show')->name('victimas.show');
    Route::get('victimas/edit/{id}/entrevista/{id_e_ind_fvt}','victimaController@edit')->name('victimas.edit');

    //Consentimiento informado
    Route::resource('f_entrevistas', 'f_entrevistaController');

    //BLog, usado en mis_Casos
    Route::resource('blogs', 'blogController');
    Route::get('blogs/{id}/anular','blogController@anular');
    //Editar adjuntos de mis-casos
    Route::get('mis_casos/adjunto/{id_mis_casos_adjunto}/edit','mis_casos_adjuntoController@edit');
    Route::post('mis_casos/adjunto/{id_mis_casos_adjunto}/edit','mis_casos_adjuntoController@update');



    /*
     * Lógica del formulario de hecho
     */
//Gestión de hechos
    Route::resource('hechos', 'hechoController');
    Route::get('hechos/detallar/{id}', 'hechoController@detallar');
//Agregar y quitar victimas a un hecho
    Route::post('hecho/victima/agregar','hecho_victimaController@agregar');
    Route::post('hecho/victima/quitar/{id}','hecho_victimaController@quitar');
//Agregar y quitar responsable a un hecho
    Route::post('hecho/responsable/agregar','hecho_responsableController@agregar');
    Route::post('hecho/responsable/quitar/{id}','hecho_responsableController@quitar');
//Agregar y quitar tipos de violencia a un hecho
    Route::post('hecho/violencia/agregar','hecho_violenciaController@agregar');
    Route::post('hecho/violencia/quitar/{id}','hecho_violenciaController@quitar');
//Agregar y quitar tipos de violencia a un hecho
    Route::post('hecho/responsabilidad/agregar','hecho_responsabilidadController@agregar');
    Route::post('hecho/responsabilidad/quitar/{id}','hecho_responsabilidadController@quitar');
//Contexto de c/hecho
    Route::post('hecho/contexto/grabar','hecho_contextoController@grabar');
//Ficha de impactos, acceso a la justicia y NR
    Route::get('entrevista/impactos/{id}','entrevista_impactoController@especificar');
    Route::post('entrevista/impactos/{id}','entrevista_impactoController@grabar');
    Route::get('entrevista/impactos/{id_e_ind_fvt}/show','entrevista_impactoController@show');


    Route::resource('exilios', 'exilioController');
    Route::get('exilios/{id_exilio}/lectura','exilioController@show_lectura')->name('exilios.show_lectura');


//Reasentamientos y retornos
    Route::get('exilio_movimiento/{id_exilio}/create','exilio_movimientoController@create');
    Route::post('exilio_movimiento/{id_exilio}/create','exilio_movimientoController@store');
    Route::get('exilio_movimiento/{id}/edit','exilio_movimientoController@edit');
    Route::patch('exilio_movimiento/{id}/edit','exilio_movimientoController@update');
    Route::delete('exilio_movimiento/{id}','exilio_movimientoController@destroy');

    Route::get('exilio_impacto/{id_exilio}/edit','exilio_impactoController@edit');
    Route::patch('exilio_impacto/{id_exilio}/edit','exilio_impactoController@update');


    /*
     * BUSQUEDAS
     */

    // Buscador de posibles duplicados de victimas
    Route::post('victimas/buscar_duplicado', 'victimaController@buscar_duplicados')->name('victimas.buscar_duplicado');
    Route::post('victima/vincular_duplicado', 'victimaController@vincular_duplicado')->name('victimas.vincular_duplicado');
    Route::get('victimas', 'victimaController@volver')->name('victimas.volver');
    Route::post('persona_entrevistada/entrevista/consentimiento', 'personaController@guardar_consentimiento')->name('persona_entrevistada.consentimiento');

    // Buscador de victimas
    Route::get('/buscar/persona','personaController@buscar_persona');
    Route::get('/buscar/victima','victimaController@buscar_victima')->name('buscar_victimas');

    //
    Route::post('persona_entrevistada/entrevista/consentimiento', 'personaController@guardar_consentimiento')->name('persona_entrevistada.consentimiento');

    // Otras cosas
    Route::get('victimas', 'victimaController@volver')->name('victimas.volver');
    Route::post('persona_entrevistada/entrevista/consentimiento', 'personaController@guardar_consentimiento')->name('persona_entrevistada.consentimiento');

    //Prueba de buscador
    Route::get('/buscar/persona','personaController@buscar_persona');


//Autofill
    Route::get('autofill/vi_prioridad','entrevista_individualController@autofill_prioritario');
    Route::get('autofill/vi_titulo','entrevista_individualController@autofill_titulo');
    Route::get('autofill/vi_dinamica','entrevista_individualController@autofill_dinamica');
    Route::get('autofill/vi_anotaciones','entrevista_individualController@autofill_anotaciones');
    Route::get('autofill/vi_observaciones_diligenciada','entrevista_individualController@autofill_observaciones_diligenciada');

    Route::get('autofill/co_titulo','entrevista_colectivaController@autofill_titulo');
    Route::get('autofill/co_dinamica','entrevista_colectivaController@autofill_dinamica');
    Route::get('autofill/co_tema_descripcion','entrevista_colectivaController@autofill_tema_descripcion');
    Route::get('autofill/co_tema_objetivo','entrevista_colectivaController@autofill_tema_objetivo');
    Route::get('autofill/co_eventos_descripcion','entrevista_colectivaController@autofill_eventos_descripcion');
    Route::get('autofill/co_observaciones','entrevista_colectivaController@autofill_observaciones');

    Route::get('autofill/ee_titulo','entrevista_etnicaController@autofill_titulo');
    Route::get('autofill/ee_dinamica','entrevista_etnicaController@autofill_dinamica');
    Route::get('autofill/ee_tema_descripcion','entrevista_etnicaController@autofill_tema_descripcion');
    Route::get('autofill/ee_tema_objetivo','entrevista_etnicaController@autofill_tema_objetivo');
    Route::get('autofill/ee_eventos_descripcion','entrevista_etnicaController@autofill_eventos_descripcion');
    Route::get('autofill/ee_observaciones','entrevista_etnicaController@autofill_observaciones');

    Route::get('autofill/pr_titulo','entrevista_profundidadController@autofill_titulo');
    Route::get('autofill/pr_dinamica','entrevista_profundidadController@autofill_dinamica');
    Route::get('autofill/pr_observaciones','entrevista_profundidadController@autofill_observaciones');
    Route::get('autofill/pr_entrevista_objetivo','entrevista_profundidadController@autofill_entrevista_objetivo');
    Route::get('autofill/pr_nombres','entrevista_profundidadController@autofill_nombres');
    Route::get('autofill/pr_apellidos','entrevista_profundidadController@autofill_apellidos');
    Route::get('autofill/pr_tema','entrevista_profundidadController@autofill_tema');

    Route::get('autofill/dc_tema_comunidad','diagnostico_comunitarioController@autofill_tema_comunidad');
    Route::get('autofill/dc_tema_objetivo','diagnostico_comunitarioController@autofill_tema_objetivo');
    Route::get('autofill/dc_tema_dinamica','diagnostico_comunitarioController@autofill_tema_dinamica');
    Route::get('autofill/dc_titulo','diagnostico_comunitarioController@autofill_titulo');
    Route::get('autofill/dc_dinamica','diagnostico_comunitarioController@autofill_dinamica');
    Route::get('autofill/dc_observaciones','diagnostico_comunitarioController@autofill_observaciones');

    Route::get('autofill/hv_nombres','historia_vidaController@autofill_nombres');
    Route::get('autofill/hv_apellidos','historia_vidaController@autofill_apellidos');
    Route::get('autofill/hv_otros_nombres','historia_vidaController@autofill_otros_nombres');
    Route::get('autofill/hv_entrevista_objetivo','historia_vidaController@autofill_entrevista_objetivo');
    Route::get('autofill/hv_titulo','historia_vidaController@autofill_titulo');
    Route::get('autofill/hv_dinamica','historia_vidaController@autofill_dinamica');
    Route::get('autofill/hv_tema','historia_vidaController@autofill_tema');
    Route::get('autofill/hv_observaciones','historia_vidaController@autofill_observaciones');

    //Personas (victima/entrevistada)
    Route::get('autofill/persona_cargo_publico','personaController@autofill_cargo_publico');
    Route::get('autofill/persona_fuerza_publica','personaController@autofill_fuerza_publica');
    Route::get('autofill/persona_actor_armado','personaController@autofill_actor_armado');
    Route::get('autofill/persona_nombre_organizacion','personaController@autofill_nombre_organizacion');
    Route::get('autofill/persona_rol_organizacion','personaController@autofill_rol_organizacion');

    //Impactos transgeneracionales
    Route::get('autofill/impactos_transgeneracionales','personaController@autofill_impactos_transgeneracionales');



    //Prioridad
    Route::get('autofill/{id_subserie}/pri_comprendo','entrevista_prioridadController@autofill_comprendo');
    Route::get('autofill/{id_subserie}/pri_cambio','entrevista_prioridadController@autofill_cambio');


    //Buscador
    Route::get('buscador','statController@buscadora');
    //Descargar transcripciones
    Route::get('buscadora/descarga_acepto','statController@descarga_acepto');
    Route::post('buscadora/descarga','statController@descargar_transcripciones');



    // Otorgar acceso de edicion
    Route::resource('accesoEdicions', 'acceso_edicionController');


    //Marcar entrevistas
    Route::resource('marcaEntrevistas', 'marca_entrevistaController');

    //Desclasificar entrevistas individuales
    Route::get('desclasificar/vi/{id}','entrevista_individualController@desclasificar');
    Route::get('desclasificar/co/{id}','entrevista_colectivaController@desclasificar');
    Route::get('desclasificar/ee/{id}','entrevista_etnicaController@desclasificar');
    Route::get('desclasificar/pr/{id}','entrevista_profundidadController@desclasificar');
    Route::get('desclasificar/dc/{id}','diagnostico_comunitarioController@desclasificar');
    Route::get('desclasificar/hv/{id}','historia_vidaController@desclasificar');


    //Asignar por prioridad
    Route::get('procesamiento/prioridad','entrevista_prioridadController@index');



    //Impersonalizar: https://github.com/404labfr/laravel-impersonate
    Route::get('actuar_como/{id_entrevistador}','entrevistadorController@como_otro');
    //Para ya no impersonalizar
    Route::get('ya_no_actuar_como','entrevistadorController@ya_no');


    //Reporte de personas entrevistadas
    Route::get('reporte/entrevistados','statController@reporte_entrevistados');
    Route::get("reporte/entrevistados/excel",'statController@generar_excel_personas_entrevistadas');
    Route::get("reporte/entrevistados/excel/anonimo",'statController@generar_excel_personas_entrevistadas_anonimo');


    //Seguimiento a entrevistas
    Route::get('seguimiento','seguimientoController@index');
    Route::post('problema_actualizar','seguimientoController@actualizar_problema');
    Route::get('seguimiento/new','seguimientoController@create');
    Route::post('seguimiento/new','seguimientoController@store');
    //Grabar la priorizacion
    Route::post('entrevista/priorizar','seguimientoController@grabar_priorizacion');

    //Chapuz para re-procesar audios
    Route::get('cifrar/{id}','adjuntoController@cifrar');

    //Anular entrevistas
    Route::get('entrevistaIndividuals/{id}/anular','entrevista_individualController@anular');
    Route::get('entrevistaColectivas/{id}/anular','entrevista_colectivaController@anular');
    Route::get('entrevistaEtnicas/{id}/anular','entrevista_etnicaController@anular');
    Route::get('entrevistaProfundidads/{id}/anular','entrevista_profundidadController@anular');
    Route::get('diagnosticoComunitarios/{id}/anular','diagnostico_comunitarioController@anular');
    Route::get('historiaVidas/{id}/anular','historia_vidaController@anular');
    Route::get('casosInformes/{id}/anular','casos_informesController@anular');



    Route::get('tesauro/completo','tesauroController@reporte_completo');
    Route::get('tesauro/comparativo','tesauroController@reporte_comparativo');
    //Circulitos de tesauro
    Route::get('tesauro/circulos','statController@tesauro_circulos');
    //Relaciones del tesauro
    Route::get('violencia/relaciones','statController@violencia_relaciones');

    //Retroalimentación del etiquetado
    Route::post('retroalimentacion','retroalimentacion_etiquetadoController@store');

    Route::resource('misCasosEntrevistadors', 'mis_casos_entrevistadorController');

    Route::resource('misCasosAdjuntoCompartirs', 'mis_casos_adjunto_compartirController');

    //(intentar) Registrar fallas en la carga de archivos
    Route::get('falla/carga','UploadController@registrar_falla');

    //Panel para explorar fichas
    Route::get('fichas/dash','fichasController@dash');
    Route::get('fichas/victimas','fichasController@victimas');
    Route::get('fichas/persona_entrevistada','fichasController@persona_entrevistada');
    Route::get('fichas/pri','fichasController@pri');
    Route::get('fichas/stats','fichasController@stats');
    Route::get('fichas/about','fichasController@about');
    Route::get('fichas/stats_comprension','fichasController@stats_comprension');
    //Exportar victimas
    Route::get('fichas/exportar/victima','fichasController@exportar_victima');
    Route::get('fichas/exportar/victima_persona','fichasController@exportar_victima_persona');
    //Exportar persona entrevistada
    Route::get('fichas/exportar/persona_entrevistada','fichasController@exportar_persona_entrevistada');
    //Exportar PRI
    Route::get('fichas/exportar/pri','fichasController@exportar_pri');
    //En construccion
    Route::get('fichas/en_construccion','fichasController@en_construccion');

    //Nuevo formulario para persona entrevistada en PR, AA, TC y HV.
    Route::get('fichas/pe/nuevo','persona_entrevistadaController@create');
    Route::post('fichas/pe','persona_entrevistadaController@store');
    Route::get('fichas/pe/{id}','persona_entrevistadaController@show');

    //Censo de archivos en el exilio
    Route::resource('censoArchivos', 'censo_archivosController');
    //adjuntos
    Route::get('censoArchivos/{id}/gestionar_adjuntos','censo_archivosController@gestionar_adjuntos');
    Route::get('censoArchivos/{id}/tabla_adjuntos','censo_archivosController@tabla_adjuntos');
    Route::get('adjunto_ca/{id}','adjuntoController@show_ca');
    Route::post('censo_archivos_adjunto/quitar/', 'censo_archivosController@quitar_adjunto');
    Route::post('censo_archivos_adjunto/agregar/', 'censo_archivosController@crear_adjunto');
    //Editar adjuntos de archivos en el exilio
    Route::get('censo_archivos/adjunto/{id}/edit','censo_archivos_adjuntoController@edit');
    Route::post('censo_archivos/adjunto/{id}/edit','censo_archivos_adjuntoController@update');
    //Permisos de archivos en el exilio
    Route::resource('censoArchivosPermisos', 'censo_archivos_permisosController');


    //Filtros por listados de excel.
    Route::resource('excelListados', 'excel_listadosController');
    Route::get('excelListados/{id}/descarga','adjuntoController@show_excel');

    //Mapa del panel de estadisticas
    Route::get('fichas/mapa','statController@mapa');
    Route::get('json/mapa/hechos_ficha','entrevista_individualController@json_hechos_ficha');
    Route::get('json/mapa/hechos_ficha_v2','entrevista_individualController@json_hechos_ficha_v2');

    //Concurrencia de impactos
    Route::get('fichas/concurrencia/impactos','fichasController@json_concurrencia_impactos');


    //Visualizar el archivo de SPSS
    Route::get('spss/visualizar','fichasController@spss_vista');

    //Formato para NVIVO
    Route::get('test/nvivo','statController@test_nvivo');

    //Compromiso de confidencialidad
    Route::get('compromiso','entrevistadorController@solicitar_compromiso');
    Route::post('compromiso','entrevistadorController@registrar_compromiso');

    //Prueba de seguridad
    Route::get('des_ad/{id}','adjuntoController@descarga_directa');


    //concurrencia de violencia a nivel de victima
    Route::get('concurrencia/victima','statController@concurrencia_victima');
    Route::get('concurrencia/entrevista','statController@concurrencia_entrevista');
    Route::get('concurrencia/responsabilidad_victima','statController@concurrencia_responsabilidad_victima');


    //Generar JSON para dublin core
    Route::get('casosInformes/{caso}/json/dublin','casos_informesController@json_dublin');

    //Paz y Salvo: revisar que las entrevistas estén completas
    Route::get('/pys/','entrevistadorController@paz_y_salvo');



});

//Generar excel de SPSS
Route::get('spss/exportar','fichasController@spss_exportar');
Route::get('spss/exportar_csv','fichasController@spss_exportar_csv');

//Generar excel plano
Route::get('excel_generar/entrevistas_fvt','entrevista_individualController@generar_excel_plano'); //Genera el archivo de entrevistas individuales: vi,aa,tc
Route::get('excel_generar/dinamicas_fvt','entrevista_individualController@generar_excel_dinamica'); //Genera el archivo de dinamicas
Route::get('excel_generar/entrevistas_integrado','entrevista_individualController@generar_excel_integrado'); //Genera el archivo integrado de todas las entrevistas
Route::get('excel_generar/entrevistas_pr','entrevista_profundidadController@generar_excel_plano'); //Genera el archivo de entrevistas a profundidad
Route::get('excel_generar/entrevistas_ee','entrevista_etnicaController@generar_excel_plano'); //Genera el archivo de entrevistas etnicas.  Incluye el excel de CO, DC y HV

//Generar tablas para intercambios de datos
Route::get('sim_generar/victimas','entrevista_individualController@generar_sim_victima'); //Genera la descarga

//Generar tablas de las fichas
Route::get('excel_generar/fichas_persona_entrevistada','entrevista_individualController@generar_excel_ficha_persona_entrevistada'); //Personas entrevistadas
Route::get('excel_generar/fichas_victima','entrevista_individualController@generar_excel_ficha_victima'); //Personas entrevistadas
Route::get('excel_generar/exilio','exilioController@exportar_exilio');

//Actualizar vista de bitácora
Route::get('excel_generar/traza','traza_actividadController@actualizar_vista');
//Route::get('excel_generar/traza_buscadora','traza_actividadController@actualizar_vista_buscadora');
//Actualizar vista de casos e informes
Route::get('excel_generar/casos','casos_informesController@actualizar_vista');

//Vistas de procesamiento
Route::get('excel_generar/transcribir_asignacion','transcribir_asignacionController@generar_excel_plano');
Route::get('excel_generar/etiquetar_asignacion','etiquetar_asignacionController@generar_excel_plano');
Route::get('excel_generar/seguimiento','entrevista_individualController@generar_excel_seguimiento');
Route::get('excel_generar/usuarios','entrevistadorController@generar_excel');
//Vistas para analitica
Route::get('analitica_generar/metadatos','analiticaController@metadatos');
Route::get('analitica_generar/persona_entrevistada','analiticaController@persona_entrevistada');
Route::get('analitica_generar/victima','analiticaController@victima');
Route::get('analitica_generar/violencia','analiticaController@violencia');
Route::get('analitica_generar/exilio_salida','analiticaController@exilio_salida');
Route::get('analitica_generar/contexto','analiticaController@contexto_impactos_afrontamientos_justicia');

//Vistas para Eduar
Route::get('sim_generar/datos_persona','analiticaController@datos_persona');

//Clasificador de NVIVO
Route::get('excel_generar/nvivo','excel_entrevistaController@generar_nvivo');

//excel de etiquetado
Route::get('excel_generar/etiquetado','excel_entrevistaController@generar_etiquetad');

//excel de control de calificacion
Route::get('excel_generar/control_calificacion','adjuntoController@etl_excel_calificacion');



//Verificar el Excel de exilio como html
Route::get('test/excel','exilioController@excel_exilio');




/*
Route::get('transmitir_eduar/{id}', 'adjuntoController@transmitir_eduar');
*/

//Uso general
//Controles geograficos
Route::get('json/geo','geoController@mostrar_hijos');
Route::post('json/geo','geoController@mostrar_hijos');
Route::post('json/geo_otro','geoController@mostrar_hijos_otro_cual');
Route::post('json/geo_todo','geoController@mostrar_hijos_con_todo');
Route::get('json/geo_todo','geoController@mostrar_hijos_con_todo'); //para debugear
// Territorios y macroterritorios
Route::get('json/geo_cev','cevController@mostrar_hijos');
Route::post('json/geo_cev','cevController@mostrar_hijos');
Route::post('json/geo_todo_cev','cevController@mostrar_hijos_con_todo');
// actores armados
Route::get('json/geo_aa','aaController@mostrar_hijos');
Route::post('json/geo_aa','aaController@mostrar_hijos');
Route::post('json/geo_todo_aa','aaController@mostrar_hijos_con_todo');
// Terceros civiles
Route::get('json/geo_tc','tcController@mostrar_hijos');
Route::post('json/geo_tc','tcController@mostrar_hijos');
Route::post('json/geo_todo_tc','tcController@mostrar_hijos_con_todo');
// Tipos de violencia
Route::get('json/geo_violencia','violenciaController@mostrar_hijos');
Route::post('json/geo_violencia','violenciaController@mostrar_hijos');
Route::post('json/geo_todo_violencia','violenciaController@mostrar_hijos_con_todo');
//Tesauro
Route::get('json/geo_tesauro','tesauroController@mostrar_hijos');
Route::post('json/geo_tesauro','tesauroController@mostrar_hijos');
Route::post('json/geo_todo_tesauro','tesauroController@mostrar_hijos_con_todo');

//Chequeo de adjuntos
Route::get('revisar/existencia_adjunto','adjuntoController@revisar_existencia');

// Control de catalogo
Route::get('json/cat/{id}','cat_itemController@json_opciones');


// Catálogo geográfico
Route::get('json/deptos','mapController@json_deptos');
Route::get('json/mupios','mapController@json_mupios');



//Criterios de priorizacion
Route::get('explicar/prioridad',function()   {
    //dd("Mirame");
    return view('pages.priorizacion');
});




/*
 * Pruebas
 */


Route::get('test/png','adjuntoController@crear_png');
Route::get('test/marca_agua','adjuntoController@marca_agua');

Route::get('mapa/prueba',function() {
    return view('mapa.base');
});


Route::get('test/select',function() {
    return view('controles.prueba');
});




/*
Route::get('mapa/base',function() {
   return view('mapa.base');
});

//PRUEBAS DE TRANSCRIPCION
Route::get('prueba', function () {

    $archivo = "/var/www/html/expedientes/storage/app/public/201908/5d5349d5581eb.m4a";
    $client = new Client();
    $url = config('expedientes.ws_transcriptor_revisar');
    $response = $client->post($url, [
        RequestOptions::JSON => ['fileIn' => $archivo]
    ]);
    $respuesta_servicio = json_decode($response->getBody()->getContents(),true);
    dd(Carbon::createFromTimestamp($respuesta_servicio['date']['queue']['$date'] / 1000)->toDateTimeString());

    $adjunto =   \App\Models\adjunto::find(207);
    $resultado = $adjunto->transcribir_revisar();
    dd($resultado);


    $path = pathinfo($archivo);
    $destino= storage_path()."/app/public/".$path['filename'];
    //$res = copy($archivo,$destino);
    $debug['archivo']=$archivo;
    $debug['destino']=$destino;
    dd($debug);
});

*/

/*
use Illuminate\Support\Facades\Log;

Route::get('test/log',function() {
    // Lets add some logs.
    Log::alert("This is a new Alert!");
    Log::critical("This is a critical error message");
    Log::debug("This is a debug message");
    Log::emergency("There is an emergency! Help!?!?!?!");
    Log::error("Houston, we have an error");
    Log::info("An informative message");
    Log::notice("Notice!");
    Log::warning("Be warned, be very warned");
    return redirect(url('log-viewer'));
});
*/

//Probar servicio de transcripcion automática
use App\Models\adjunto;
$archivo[1]='/var/www/html/expedientes/storage/app/public/201910/5d9a878d9f47b.mp3';
$archivo[2]='/var/www/html/expedientes/storage/app/public/201904/5cc7d34301520.wav';
$archivo[3]='/var/www/html/expedientes/storage/app/public/201911/corto.m4a';
$archivo[4]='/archivo/que/no/existe.wav';

Route::get('test/transcribir/enviar/{id}',function($cual) use($archivo)  {
    //$audio = $cual==1 ? $archivo_1 : $archivo_2;
    $audio = $archivo[$cual];
    $prueba = new adjunto();
    $resultado = $prueba->ws_transcribir($audio,'Pruebas de Oliver');
    dd($resultado);
});

Route::get('test/transcribir/revisar/{id}',function($cual) use($archivo)  {
    $audio = $archivo[$cual];
    $prueba = new adjunto();
    $resultado = $prueba->ws_revisar($audio);
    dd($resultado);
});





/*
 * transcripción por cron job
 */
Route::get('google/transcribir/revisar',function()   {
    $resultado = entrevista_individual_adjunto::revisar_bloque_google();
    return response()->json($resultado);
    //dd($resultado);
});


Route::get('google/transcribir_pr/revisar',function()   {
    $resultado = entrevista_profundidad_adjunto::revisar_bloque_google(5);
    return response()->json($resultado);
});


Route::get('google/transcribir_ee/revisar',function()   {
    $resultado = \App\Models\entrevista_etnica_adjunto::revisar_bloque_google(5);
    return response()->json($resultado);
});



// Pruebas de etiquetado

Route::get('test/etiquetado/{id}',function($id)   {
    $adjunto = \App\Models\adjunto::find($id);
    $resultado = $adjunto->procesar_json_etiquetado();
    return response()->json($resultado);
});


Route::get('test/etiquetado/{id}',function($id)   {
    //$adjunto = \App\Models\entrevista_individual_adjunto::find($id);
    //$resultado = $adjunto->procesar_etiquetas();

    $entrevista = \App\Models\entrevista_individual::find($id);
    dd($entrevista->prueba_etiquetado());
});




//Dirección IP del cliente
Route::get('test/ip',function()   {
    //dd(\Request::ip());
    $red = \App\User::red_interna();
    dd($red);
});


//Pruebas de oliver con Vegas
Route::get('test/js',function()   {
    return view('pages.d3');
});


Route::get('test/adminlte3',function()   {
    return view('pages.adminlte3');
});

Route::get('test/info',function()   {
    phpinfo();
});

Route::get('test/error',function()   {
    return view('errors.500');
});





