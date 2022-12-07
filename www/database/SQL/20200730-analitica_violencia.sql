drop table if exists  analitica.violencia;
create table if not exists analitica.violencia
(
	id_hecho integer not null
		constraint violencia_pk
			primary key,
	id_entrevista integer,
	codigo_entrevista varchar(20),
	victimas_total integer,
	victimas_identificadas integer,
	responsables_identificados integer,
	cantidad_muertos integer,
	fecha_inicio varchar(25),
	fecha_fin varchar(25),
	hechos_continuan integer default 0,
	lugar_codigo varchar(25),
	lugar_n1_codigo varchar(25),
	lugar_n1_txt text,
	lugar_n2_codigo varchar(25),
	lugar_n2_txt text,
	lugar_n3_codigo varchar(25),
	lugar_n3_txt text,
	lugar_n3_lat varchar(25),
	lugar_n3_lon varchar(25),
	lugar_sitio text,
	lugar_zona text,
	v_m_homicidio integer default 0,
	v_m_masacre integer default 0,
	v_m_combates integer default 0,
	v_m_minas integer default 0,
	v_m_atentado_bombas integer default 0,
	v_m_ataque_bienes integer default 0,
	v_m_sevicia integer default 0,
	v_at_herido integer default 0,
	v_at_sin_lesiones integer default 0,
	v_at_civil_herido_combate integer default 0,
	v_at_civil_herido_bomba integer default 0,
	v_at_civil_minas integer default 0,
	v_at_civil_ataque_bienes integer default 0,
	v_amenaza integer default 0,
	v_amenaza_mecanismos text,
	v_amenaza_ind_col text,
	v_desaparicion_forzada integer default 0,
	v_desaparicion_forzada_mecanismos text,
	v_tortura_fisica integer default 0,
	v_tortura_fisica_mecanismos text,
	v_tortura_fisica_ind_col text,
	v_tortura_fisica_publico text,
	v_tortura_psicologica integer default 0,
	v_tortura_psicologica_mecanismos text,
	v_tortura_psicologica_ind_col text,
	v_tortura_psicologica_publico text,
	v_vs_violacion_sexual integer default 0,
	v_vs_violacion_sexual_ind_col text,
	v_vs_violacion_sexual_publico text,
	v_vs_violacion_sexual_multiple_responsable text,
	v_vs_violacion_sexual_embarazo text,
	v_vs_violacion_sexual_embarazo_nacimiento text,
	v_vs_embarazo_forzado integer default 0,
	v_vs_embarazo_forzado_ind_col text,
	v_vs_embarazo_forzado_publico text,
	v_vs_embarazo_forzado_multiple_responsable  text,
	v_vs_embarazo_forzado_embarazo  text,
	v_vs_embarazo_forzado_embarazo_nacimiento  text,
	v_vs_amenaza integer default 0,
	v_vs_amenaza_ind_col text,
	v_vs_amenaza_publico text,
	v_vs_amenaza_multiple_responsable text,
	v_vs_amenaza_embarazo text,
	v_vs_amenaza_embarazo_nacimiento text,
	v_vs_anticoncepcion integer default 0,
	v_vs_anticoncepcion_ind_col text,
	v_vs_anticoncepcion_publico text,
	v_vs_anticoncepcion_multiple_responsable text,
	v_vs_anticoncepcion_embarazo text,
	v_vs_anticoncepcion_embarazo_nacimiento text,
	v_vs_trata_personas integer default 0,
	v_vs_trata_personas_ind_col text,
	v_vs_trata_personas_publico text,
	v_vs_trata_personas_multiple_responsable  text,
	v_vs_trata_personas_embarazo text,
	v_vs_trata_personas_embarazo_nacimiento  text,
	v_vs_prostitucion_forzada integer default 0,
	v_vs_prostitucion_forzada_ind_col text,
	v_vs_prostitucion_forzada_publico  text,
	v_vs_prostitucion_forzada_multiple_responsable text,
	v_vs_prostitucion_forzada_embarazo text,
	v_vs_prostitucion_forzada_embarazo_nacimiento text,
	v_vs_tortura_embarazo integer default 0,
	v_vs_tortura_embarazo_ind_col text,
	v_vs_tortura_embarazo_publico  text,
	v_vs_tortura_embarazo_multiple_responsable text,
	v_vs_tortura_embarazo_embarazo  text,
	v_vs_tortura_embarazo_embarazo_nacimiento text,
	v_vs_mutilacion integer default 0,
	v_vs_mutilacion_ind_col text,
	v_vs_mutilacion_publico text,
	v_vs_mutilacion_multiple_responsable  text,
	v_vs_mutilacion_embarazo text,
	v_vs_mutilacion_embarazo_nacimiento text,
	v_vs_enamoramiento integer default 0,
	v_vs_enamoramiento_ind_col text,
	v_vs_enamoramiento_publico text,
	v_vs_enamoramiento_multiple_responsable text,
	v_vs_enamoramiento_embarazo text,
	v_vs_enamoramiento_embarazo_nacimiento text,
	v_vs_acoso_sexual integer default 0,
	v_vs_acoso_sexual_ind_col text,
	v_vs_acoso_sexual_publico  text,
	v_vs_acoso_sexual_multiple_responsable text,
	v_vs_acoso_sexual_embarazo  text,
	v_vs_acoso_sexual_embarazo_nacimiento text,
	v_vs_aborto_forzado integer default 0,
	v_vs_aborto_forzado_ind_col text,
	v_vs_aborto_forzado_publico text,
	v_vs_aborto_forzado_multiple_responsable text,
	v_vs_aborto_forzado_embarazo text,
	v_vs_aborto_forzado_embarazo_nacimiento  text,
	v_vs_obligar_presenciar integer default 0,
	v_vs_obligar_presenciar_ind_col text,
	v_vs_obligar_presenciar_publico text,
	v_vs_obligar_presenciar_multiple_responsable  text,
	v_vs_obligar_presenciar_embarazo  text,
	v_vs_obligar_presenciar_embarazo_nacimiento text,
	v_vs_obligar_realizar integer default 0,
	v_vs_obligar_realizar_ind_col text,
	v_vs_obligar_realizar_publico text,
	v_vs_obligar_realizar_multiple_responsable text,
	v_vs_obligar_realizar_embarazo  text,
	v_vs_obligar_realizar_embarazo_nacimiento text,
	v_vs_cambios_forzados integer default 0,
	v_vs_cambios_forzados_ind_col text,
	v_vs_cambios_forzados_publico  text,
	v_vs_cambios_forzados_multiple_responsable text,
	v_vs_cambios_forzados_embarazo  text,
	v_vs_cambios_forzados_embarazo_nacimiento text,
	v_vs_esclavitud integer default 0,
	v_vs_esclavitud_ind_col text,
	v_vs_esclavitud_publico text,
	v_vs_esclavitud_multiple_responsable text,
	v_vs_esclavitud_embarazo text,
	v_vs_esclavitud_embarazo_nacimiento text,
	v_vs_desnudez_forzada integer default 0,
	v_vs_desnudez_forzada_ind_col text,
	v_vs_desnudez_forzada_publico text,
	v_vs_desnudez_forzada_multiple_responsable text,
	v_vs_desnudez_forzada_embarazo text,
	v_vs_desnudez_forzada_embarazo_nacimiento text,
	v_vs_maternidad_forzada integer default 0,
	v_vs_maternidad_forzada_ind_col text,
	v_vs_maternidad_forzada_publico text,
	v_vs_maternidad_forzada_multiple_responsable text,
	v_vs_maternidad_forzada_embarazo text,
	v_vs_maternidad_forzada_embarazo_nacimiento text,
	v_vs_cohabitacion_forzada integer default 0,
	v_vs_cohabitacion_forzada_ind_col text,
	v_vs_cohabitacion_forzada_publico text,
	v_vs_cohabitacion_forzada_multiple_responsable text,
	v_vs_cohabitacion_forzada_embarazo  text,
	v_vs_cohabitacion_forzada_embarazo_nacimiento text,
	v_vs_otra_forma integer default 0,
	v_vs_otra_forma_ind_col text,
	v_vs_otra_forma_publico  text,
	v_vs_otra_forma_multiple_responsable  text,
	v_vs_otra_forma_embarazo text,
	v_vs_otra_forma_embarazo_nacimiento text,
	v_esclavitud_no_sexual integer default 0,
	v_esclavitud_no_sexual_publico text,
	v_reclutamiento integer default 0,
	v_reclutamiento_publico text,
	v_reclutamiento_ind_col text,
	v_reclutamiento_mecanismos text,
	v_detencion integer default 0,
	v_detencion_ind_col text,
	v_secuestro integer default 0,
	v_secuestro_ind_col text,
	v_secuestro_publico text,
	v_confinamiento integer default 0,
	v_confinamiento_ind_col text,
	v_pillaje integer default 0,
	v_extorsion integer default 0,
	v_abp_civil integer default 0,
	v_abp_sanitario integer default 0,
	v_abp_religioso integer default 0,
	v_abp_sagrado integer default 0,
	v_abp_cultural integer default 0,
	v_abp_peligroso integer,
	v_abp_medioambiente integer default 0,
	v_ataque_indiscriminado integer default 0,
	v_despojo integer default 0,
	v_despojo_modalidad text,
	v_despojo_ind_col text,
	v_despojo_hectareas text,
	v_despojo_recupero_tierras text,
	v_despojo_recupero_derechos text,
	v_desplazamiento integer default 0,
	v_desplazamiento_ind_col text,
	v_desplazamiento_origen_n1_codigo varchar(20),
	v_desplazamiento_origen_n1_txt text,
	v_desplazamiento_origen_n2_codigo varchar(20),
	v_desplazamiento_origen_n2_txt text,
	v_desplazamiento_origen_n3_codigo varchar(20),
	v_desplazamiento_origen_n3_txt text,
	v_desplazamiento_origen_codigo varchar(20),
	v_desplazamiento_origen_n3_lat varchar(20),
	v_desplazamiento_origen_n3_lon varchar(20),
	v_desplazamiento_llegada_codigo varchar(20),
	v_desplazamiento_llegada_n1_codigo varchar(20),
	v_desplazamiento_llegada_n1_txt text,
	v_desplazamiento_llegada_n2_codigo varchar(20),
	v_desplazamiento_llegada_n2_txt text,
	v_desplazamiento_llegada_n3_codigo varchar(20),
	v_desplazamiento_llegada_n3_txt text,
	v_desplazamiento_llegada_n3_lat varchar(20),
	v_desplazamiento_llegada_n3_lon varchar(20),
	v_desplazamiento_sentido text,
	v_desplazamiento_retorno text,
	v_desplazamiento_retorno_ind_col text,
	v_exilio integer default 0,
	aa_p_grupo_paramilitar integer default 0,
	aa_p_grupo_paramilitar_detalle text,
	aa_p_ns_nr integer default 0,
	aa_p_ns_nr_detalle text,
	aa_g_farc integer default 0,
	aa_g_farc_detalle text,
	aa_g_eln integer default 0,
	aa_g_eln_detalle text,
	aa_g_otro integer default 0,
	aa_g_otro_detalle text,
	aa_g_ns_nr integer default 0,
	aa_g_ns_nr_detalle text,
	aa_fp_ejercito integer default 0,
	aa_fp_ejercito_detalle text,
	aa_fp_armada integer default 0,
	aa_fp_armada_detalle text,
	aa_fp_fuerza_aerea integer default 0,
	aa_fp_fuerza_aerea_detalle text,
	aa_fp_policia integer default 0,
	aa_fp_policia_detalle text,
	aa_oga_otro_grupo_armado integer default 0,
	aa_oga_otro_grupo_armado_detalle text,
	aa_oga_otro_pais integer default 0,
	aa_oga_otro_pais_detalle text,
	aa_ns_nr integer default 0,
	aa_ns_nr_detalle text,
	tc_tc_politico integer default 0,
	tc_tc_politico_detalle text,
	tc_tc_medios_comunicacion integer default 0,
	tc_tc_medios_comunicacion_detalle text,
	tc_tc_social_comunitario integer default 0,
	tc_tc_social_comunitario_detalle text,
	tc_tc_academico integer default 0,
	tc_tc_academico_detalle text,
	tc_tc_religioso integer default 0,
	tc_tc_religioso_detalle text,
	tc_tc_econcomico integer default 0,
	tc_tc_econcomico_detalle text,
	tc_tc_otros integer default 0,
	tc_tc_otros_detalle text,
	tc_oae_ejecutivo_legislativo integer default 0,
	tc_oae_ejecutivo_legislativo_detalle text,
	tc_oae_organos_control integer default 0,
	tc_oae_organos_control_detalle text,
	tc_oae_justicia integer default 0,
	tc_oae_justicia_detalle text,
	tc_oae_inteligencia integer default 0,
	tc_oae_inteligencia_detalle text,
	tc_oae_otro integer default 0,
	tc_oae_otro_detalle text,
	tc_int_gobierno_extranjero integer default 0,
	tc_int_gobierno_extranjero_detalle text,
	tc_int_empresa_transnacional integer default 0,
	tc_int_empresa_transnacional_detalle text,
	tc_int_otros integer default 0,
	tc_int_otros_detalle text,
	tc_otro_actor integer default 0,
	tc_otro_actor_detalle text,
	creacion_fh text,
	creacion_fecha text,
	creacion_mes text
);

comment on table analitica.violencia is 'Hechos y violaciones';

comment on column analitica.violencia.id_hecho is 'Evento con misma violencia, mismo lugar, misma fecha a mismas victimas';

comment on column analitica.violencia.id_entrevista is 'llave primaria para ubicar la entrevista';

comment on column analitica.violencia.codigo_entrevista is 'Para facilitar los vínculos entre vistas';

comment on column analitica.violencia.victimas_total is 'Cantidad de víctimas que sufrieron la violencia';

comment on column analitica.violencia.victimas_identificadas is 'Cantidad de víctimas que tienen ficha de víctima con datos personales';

comment on column analitica.violencia.responsables_identificados is 'Cantidad de presunto responsable individual que tiene ficha con datos personales';

comment on column analitica.violencia.cantidad_muertos is 'Aplica para masacres';

comment on column analitica.violencia.fecha_inicio is 'Fecha de los hechos';

comment on column analitica.violencia.fecha_fin is 'Si los hechos duraron más de un día, fecha en que terminaron';

comment on column analitica.violencia.hechos_continuan is 'Los hechos aún continúan?';

comment on column analitica.violencia.lugar_codigo is 'Código geográfico del lugar de los hechos';

comment on column analitica.violencia.lugar_n1_codigo is 'Código geográfico del departamento';

comment on column analitica.violencia.lugar_n1_txt is 'Nombre del departamento';

comment on column analitica.violencia.lugar_n2_codigo is 'Código geográfico del municipio';

comment on column analitica.violencia.lugar_n2_txt is 'Nombre del municipio';

comment on column analitica.violencia.lugar_n3_codigo is 'Código de la vereda';

comment on column analitica.violencia.lugar_n3_txt is 'Nombre de la vereda';

comment on column analitica.violencia.lugar_n3_lat is 'Latitud de la vereda';

comment on column analitica.violencia.lugar_n3_lon is 'longitud de la vereda';

comment on column analitica.violencia.lugar_sitio is 'Sitio específico donde ocurrieron los hechos';

comment on column analitica.violencia.lugar_zona is 'Urbano/Rural';

comment on column analitica.violencia.v_m_homicidio is 'Homicidio/Ejecución extrajudicial';

comment on column analitica.violencia.v_m_masacre is 'Masacre (varias muertes)';

comment on column analitica.violencia.v_m_combates is 'Muerte de civiles en medio de combates';

comment on column analitica.violencia.v_m_minas is 'Muerte de persona por activación de explosivos o minas';

comment on column analitica.violencia.v_m_atentado_bombas is 'Muerte de civiles en atentados con bombas';

comment on column analitica.violencia.v_m_ataque_bienes is 'Muerte de civiles causada por ataques a bienes civiles';

comment on column analitica.violencia.v_m_sevicia is 'Muerte con sevicia o violencia contra el puerto (post-mortem)';

comment on column analitica.violencia.v_at_herido is 'Herido en atentado';

comment on column analitica.violencia.v_at_sin_lesiones is 'Víctima de atentado sin lesiones';

comment on column analitica.violencia.v_at_civil_herido_combate is 'Civil herido en medio de combate';

comment on column analitica.violencia.v_at_civil_herido_bomba is 'Civil herido en atentado con bomba';

comment on column analitica.violencia.v_at_civil_minas is 'Persona herida por activación de explosivos o minas';

comment on column analitica.violencia.v_at_civil_ataque_bienes is 'Civil herido en medio de ataques a bienes civiles';

comment on column analitica.violencia.v_amenaza is 'Amenaza al derecho a la vida';

comment on column analitica.violencia.v_amenaza_mecanismos is 'JSON con mecanismos utilizados';

comment on column analitica.violencia.v_desaparicion_forzada is 'Desaparición forzada';

comment on column analitica.violencia.v_tortura_fisica_mecanismos is 'JSON con mecanismos utilizados';

comment on column analitica.violencia.v_tortura_psicologica is 'Tortura psicológica';

comment on column analitica.violencia.v_tortura_psicologica_mecanismos is 'JSON con mecanismos utilizados';

comment on column analitica.violencia.v_vs_violacion_sexual is 'Violación sexual';

comment on column analitica.violencia.v_vs_embarazo_forzado is 'Embarazo forzado';

comment on column analitica.violencia.v_vs_amenaza is 'Amenaza de violación y/o violencia sexual';

comment on column analitica.violencia.v_vs_anticoncepcion is 'Anticoncepción y esterilización forzada';

comment on column analitica.violencia.v_vs_trata_personas is 'Trata de personas con fines de explotación sexual';

comment on column analitica.violencia.v_vs_prostitucion_forzada is 'Prostitución forzada';

comment on column analitica.violencia.v_vs_tortura_embarazo is 'Tortura durante el embarazo';

comment on column analitica.violencia.v_vs_mutilacion is 'Mutilización de órganos sexuales';

comment on column analitica.violencia.v_vs_enamoramiento is 'Enamoramiento como estrategia de guerra';

comment on column analitica.violencia.v_vs_acoso_sexual is 'Acoso sexual';

comment on column analitica.violencia.v_vs_aborto_forzado is 'Aborto forzado';

comment on column analitica.violencia.v_vs_obligar_presenciar is 'Obligación de presenciar actos sexuales';

comment on column analitica.violencia.v_vs_obligar_realizar is 'Obligación de realizar actos sexuales';

comment on column analitica.violencia.v_vs_cambios_forzados is 'Cambios forzados en la corporalidad y la perfomatividadd del género';

comment on column analitica.violencia.v_vs_otra_forma is 'Otra forma de violencia sexual';

comment on column analitica.violencia.v_vs_esclavitud is 'Esclavitud sexual';

comment on column analitica.violencia.v_vs_desnudez_forzada is 'Desnudez forzada';

comment on column analitica.violencia.v_vs_maternidad_forzada is 'Maternidad forzada';

comment on column analitica.violencia.v_vs_cohabitacion_forzada is 'Cohabitación forzada';

comment on column analitica.violencia.v_esclavitud_no_sexual is 'Esclavitud / Trabajo forzoso sin fines sexuales';

comment on column analitica.violencia.v_desaparicion_forzada_mecanismos is 'JSON especificaciones de la desaparición forzada';

comment on column analitica.violencia.v_amenaza_ind_col is 'Amenaza individual o colectiva';

comment on column analitica.violencia.v_tortura_fisica_ind_col is 'Tortura física individual o colectiva';

comment on column analitica.violencia.v_tortura_fisica_publico is 'Tortura fisica cometida frente a otras personas';

comment on column analitica.violencia.v_tortura_psicologica_ind_col is 'tortura psicológica individual o colectiva';

comment on column analitica.violencia.v_tortura_psicologica_publico is 'Tortura cometida frete a otras personas';


comment on column analitica.violencia.v_esclavitud_no_sexual_publico is 'La esclavitud fué cometida frente a otras personas';

comment on column analitica.violencia.v_reclutamiento is 'Recultamiento de niños, niñas y adolescentes';

comment on column analitica.violencia.v_reclutamiento_publico is 'El reclutamiento fue cometido frente ao otras personas';

comment on column analitica.violencia.v_reclutamiento_ind_col is 'El reclutamiento fué individual o colectivo';

comment on column analitica.violencia.v_secuestro is 'Secuestro / Toma de rehenes';

comment on column analitica.violencia.v_secuestro_ind_col is 'Secuestro individual, familiar o colectivo';

comment on column analitica.violencia.v_detencion is 'Detención arbitraria';

comment on column analitica.violencia.v_detencion_ind_col is 'Detención individual, familiar o colectiva';

comment on column analitica.violencia.v_secuestro_publico is 'Secuestro cometido frente a otras personas';

comment on column analitica.violencia.v_confinamiento is 'Confinamiento';

comment on column analitica.violencia.v_confinamiento_ind_col is 'Confinamiento individual,familiar o colectivo';

comment on column analitica.violencia.v_pillaje is 'Pillaje';

comment on column analitica.violencia.v_extorsion is 'Extorsión';

comment on column analitica.violencia.v_abp_civil is 'Ataque a bien protegido: Bien civil';

comment on column analitica.violencia.v_abp_religioso is 'Ataque a bien protegido: Bien religioso';

comment on column analitica.violencia.v_abp_sagrado is 'Ataque a bien protegido: Lugar sagrado';

comment on column analitica.violencia.v_abp_cultural is 'Ataque a bien protegido: Bien cultural / educativo';

comment on column analitica.violencia.v_abp_peligroso is 'Ataque a bien protegido: Obras e instalaciones que contentan fuerzas peligrosas';

comment on column analitica.violencia.v_abp_medioambiente is 'Medioambiente';

comment on column analitica.violencia.v_ataque_indiscriminado is 'Ataque indiscriminado';

comment on column analitica.violencia.v_despojo is 'Despojo / Abandono de tierras';

comment on column analitica.violencia.v_despojo_modalidad is 'JSON con modalidades utilizadas';

comment on column analitica.violencia.v_despojo_ind_col is 'Despojo individual, familiar, colectivo';

comment on column analitica.violencia.v_despojo_hectareas is 'hectáreas despojadas';

comment on column analitica.violencia.v_despojo_recupero_tierras is 'Recuperó sus tierras';

comment on column analitica.violencia.v_despojo_recupero_derechos is 'Recuperó sus derechos territoriales';

comment on column analitica.violencia.v_desplazamiento is 'Desplazamiento forzado';

comment on column analitica.violencia.v_desplazamiento_ind_col is 'Desplazamiento individual, familiar o colectivo';

comment on column analitica.violencia.v_desplazamiento_origen_n1_codigo is 'Lugar de origen, departamento, codigo';

comment on column analitica.violencia.v_desplazamiento_origen_n1_txt is 'Lugar de origen, departamento, nombre';

comment on column analitica.violencia.v_desplazamiento_origen_n2_codigo is 'Lugar de origen, municipio, codigo';

comment on column analitica.violencia.v_desplazamiento_origen_n2_txt is 'Lugar de origen, municipio,nombre';

comment on column analitica.violencia.v_desplazamiento_origen_n3_codigo is 'Lugar de origen, vereda, codigo';

comment on column analitica.violencia.v_desplazamiento_origen_n3_txt is 'Lugar de origen, vereda, nombre';

comment on column analitica.violencia.v_desplazamiento_origen_codigo is 'Lugar de origen, codigo ';

comment on column analitica.violencia.v_desplazamiento_origen_n3_lat is 'Lugar de origen, vereda, latitud';

comment on column analitica.violencia.v_desplazamiento_origen_n3_lon is 'Lugar de origen, vereda, longitud';

comment on column analitica.violencia.v_desplazamiento_llegada_codigo is 'Lugar de llegada, codigo ';

comment on column analitica.violencia.v_desplazamiento_llegada_n1_codigo is 'Lugar de llegada, departamento, codigo';

comment on column analitica.violencia.v_desplazamiento_llegada_n1_txt is 'Lugar de llegada, departamento, nombre';

comment on column analitica.violencia.v_desplazamiento_llegada_n2_codigo is 'Lugar de llegada, municipio, codigo';

comment on column analitica.violencia.v_desplazamiento_llegada_n2_txt is 'Lugar de llegada, municipio, nombre';

comment on column analitica.violencia.v_desplazamiento_llegada_n3_codigo is 'Lugar de llegada, vereda, codigo ';

comment on column analitica.violencia.v_desplazamiento_llegada_n3_txt is 'Lugar de llegada, vereda, nombre';

comment on column analitica.violencia.v_desplazamiento_llegada_n3_lat is 'Lugar de llegada, vereda, latitud';

comment on column analitica.violencia.v_desplazamiento_llegada_n3_lon is 'Lugar de llegada, vereda, longitud';

comment on column analitica.violencia.v_desplazamiento_sentido is 'Sentido del desplazamiento';

comment on column analitica.violencia.v_desplazamiento_retorno is '¿La persona ha tenido un proceso de retorno?';

comment on column analitica.violencia.v_desplazamiento_retorno_ind_col is 'Si tuvo proceso de retorno, especifique el tipo';

comment on column analitica.violencia.v_exilio is 'Exilio';

comment on column analitica.violencia.aa_p_grupo_paramilitar is 'Actor Armado, Paramilitar: grupo paramilitar';

comment on column analitica.violencia.aa_p_ns_nr is 'Actor Armado, Paramilitar: no sabe no responde';

comment on column analitica.violencia.aa_g_farc is 'Actor Armado, Guerrilla: FARC-EP';

comment on column analitica.violencia.aa_g_eln is 'Actor Armado, Guerrilla: ELN';

comment on column analitica.violencia.aa_g_otro is 'Actor Armado, Guerrilla: otros';

comment on column analitica.violencia.aa_g_ns_nr is 'Actor Armado, Guerrilla: no sabe no responde';

comment on column analitica.violencia.aa_fp_ejercito is 'Actor Armado, Fuerza pública: ejército ';

comment on column analitica.violencia.aa_fp_armada is 'Actor Armado, Fuerza pública: Armada (Naval)';

comment on column analitica.violencia.aa_fp_fuerza_aerea is 'Actor Armado, Fuerza pública: Fuerza Aérea';

comment on column analitica.violencia.aa_fp_policia is 'Actor Armado, Fuerza pública: policía';

comment on column analitica.violencia.aa_oga_otro_grupo_armado is 'Actor Armado, Otro grupo armado: otro grupo armado';

comment on column analitica.violencia.aa_oga_otro_pais is 'Actor Armado, Otro grupo armado: ejército de otro país';

comment on column analitica.violencia.aa_ns_nr is 'Actor Armado, No sabe / no responde';

comment on column analitica.violencia.tc_tc_politico is 'Terceros Civiles, Terceros civiles: sector político';

comment on column analitica.violencia.tc_tc_medios_comunicacion is 'Terceros Civiles, Terceros civiles: medios de comunicación';

comment on column analitica.violencia.tc_tc_social_comunitario is 'Terceros Civiles, Terceros civiles: sector social / comunitario';

comment on column analitica.violencia.tc_tc_academico is 'Terceros Civiles, Terceros civiles: sector académico';

comment on column analitica.violencia.tc_tc_religioso is 'Terceros Civiles, Terceros civiles: sector religioso';

comment on column analitica.violencia.tc_tc_econcomico is 'Terceros Civiles, Terceros civiles: sector económico / empresas';

comment on column analitica.violencia.tc_tc_otros is 'Terceros Civiles, Terceros civiles: otro sector ';

comment on column analitica.violencia.tc_oae_ejecutivo_legislativo is 'Terceros Civiles, Otro Agente del Estado: ejecutivo / legislativo';

comment on column analitica.violencia.tc_oae_organos_control is 'Terceros Civiles, Otro Agente del Estado: órganos de control';

comment on column analitica.violencia.tc_oae_justicia is 'Terceros Civiles, Otro Agente del Estado: Sector Justicia';

comment on column analitica.violencia.tc_oae_inteligencia is 'Terceros Civiles, Otro Agente del Estado: Organismos de seguridad e inteligencia';

comment on column analitica.violencia.tc_oae_otro is 'Terceros Civiles, Otro Agente del Estado: otros sector del estado';

comment on column analitica.violencia.tc_int_gobierno_extranjero is 'Terceros Civiles, Internacional: gobierno extranjero';

comment on column analitica.violencia.tc_int_empresa_transnacional is 'Terceros Civiles, Internacional: empresa transncional';

comment on column analitica.violencia.tc_int_otros is 'Terceros Civiles, Internacional: otro sector';

comment on column analitica.violencia.tc_otro_actor is 'Terceros Civiles, Otro actor';

comment on column analitica.violencia.creacion_fh is 'Fecha y hora de la creación del hecho en el sistema';

comment on column analitica.violencia.creacion_fecha is 'Fecha de la creación del hecho en el sistema';

comment on column analitica.violencia.creacion_mes is 'Mes de la creación del hecho en el sistema';

comment on column analitica.violencia.v_vs_violacion_sexual_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_violacion_sexual_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_violacion_sexual_multiple_responsable is 'La violencia fué cometida por varias personas';

comment on column analitica.violencia.v_vs_violacion_sexual_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_violacion_sexual_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_embarazo_forzado_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_embarazo_forzado_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_embarazo_forzado_multiple_responsable is 'La violencia fué cometida por varias personas';

comment on column analitica.violencia.v_vs_embarazo_forzado_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_amenaza_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_amenaza_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_amenaza_multiple_responsable is 'La violencia fué cometida por varias personas';

comment on column analitica.violencia.v_vs_amenaza_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_amenaza_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_anticoncepcion_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_anticoncepcion_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_anticoncepcion_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_anticoncepcion_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_anticoncepcion_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_trata_personas_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_trata_personas_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_trata_personas_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_trata_personas_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_prostitucion_forzada_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_prostitucion_forzada_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_prostitucion_forzada_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_prostitucion_forzada_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_prostitucion_forzada_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_tortura_embarazo_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_tortura_embarazo_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_tortura_embarazo_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_tortura_embarazo_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_tortura_embarazo_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_mutilacion_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_mutilacion_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_mutilacion_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_mutilacion_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_mutilacion_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_enamoramiento_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_enamoramiento_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_enamoramiento_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_enamoramiento_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_enamoramiento_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_acoso_sexual_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_acoso_sexual_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_acoso_sexual_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_acoso_sexual_embarazo is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_acoso_sexual_embarazo_nacimiento is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_aborto_forzado_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_aborto_forzado_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_aborto_forzado_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_aborto_forzado_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_aborto_forzado_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_obligar_presenciar_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_obligar_presenciar_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_obligar_presenciar_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_obligar_presenciar_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_obligar_presenciar_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_obligar_realizar_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_obligar_realizar_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_obligar_realizar_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_obligar_realizar_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_obligar_realizar_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_cambios_forzados_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_cambios_forzados_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_cambios_forzados_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_cambios_forzados_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_cambios_forzados_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_esclavitud_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_esclavitud_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_esclavitud_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_esclavitud_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_esclavitud_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_desnudez_forzada_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_desnudez_forzada_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_desnudez_forzada_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_desnudez_forzada_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_desnudez_forzada_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_maternidad_forzada_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_maternidad_forzada_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_maternidad_forzada_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_maternidad_forzada_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_maternidad_forzada_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_cohabitacion_forzada_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_cohabitacion_forzada_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_cohabitacion_forzada_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_cohabitacion_forzada_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

alter table analitica.violencia alter column v_vs_cohabitacion_forzada_embarazo type text using v_vs_cohabitacion_forzada_embarazo::text;

comment on column analitica.violencia.v_vs_cohabitacion_forzada_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_vs_otra_forma_ind_col is 'Violencia individual o colectiva';

comment on column analitica.violencia.v_vs_otra_forma_publico is 'La violencia se cometió frente a otras personas';

comment on column analitica.violencia.v_vs_otra_forma_multiple_responsable is 'Los hechos fueron cometidos por varias personas';

comment on column analitica.violencia.v_vs_otra_forma_embarazo is 'Hubo embarazo como consecuencia de la violencia sexual';

comment on column analitica.violencia.v_vs_otra_forma_embarazo_nacimiento is 'Si hubo embarazo, ¿nació el bebé?';

comment on column analitica.violencia.v_reclutamiento_mecanismos is 'Mecanismos utilizados en el reclutamiento';

comment on column analitica.violencia.v_abp_sanitario is 'Ataque a bien protegido: Bien sanitario';

comment on column analitica.violencia.aa_p_grupo_paramilitar_detalle is 'Nombre del actor armado';

comment on column analitica.violencia.aa_p_ns_nr_detalle is 'Nombre del actor armado';

comment on column analitica.violencia.aa_g_farc_detalle is 'Nombre del actor armado';

comment on column analitica.violencia.aa_g_eln_detalle is 'Nombre del actor armado';

comment on column analitica.violencia.aa_g_otro_detalle is 'Nombre del actor armado';

comment on column analitica.violencia.aa_g_ns_nr_detalle is 'Nombre del actor armado';

comment on column analitica.violencia.aa_fp_ejercito_detalle is 'Nombre del actor armado';

comment on column analitica.violencia.aa_fp_armada_detalle is 'Nombre del actor armado';

comment on column analitica.violencia.aa_fp_fuerza_aerea_detalle is 'Nombre del actor armado';

comment on column analitica.violencia.aa_fp_policia_detalle is 'Nombre del actor armado';

comment on column analitica.violencia.aa_oga_otro_grupo_armado_detalle is 'Nombre del actor armado';

comment on column analitica.violencia.aa_oga_otro_pais_detalle is 'Nombre del actor armado';

comment on column analitica.violencia.aa_ns_nr_detalle is 'Informacion adicional';

comment on column analitica.violencia.tc_tc_politico_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_tc_medios_comunicacion_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_tc_social_comunitario_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_tc_academico_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_tc_religioso_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_tc_econcomico_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_tc_otros_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_oae_ejecutivo_legislativo_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_oae_organos_control_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_oae_justicia_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_oae_inteligencia_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_oae_otro_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_int_gobierno_extranjero_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_int_empresa_transnacional_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_int_otros_detalle is 'Nombre del tercero civil';

comment on column analitica.violencia.tc_otro_actor_detalle is 'Nombre del tercero civil';



alter table analitica.violencia owner to dba;
grant select on analitica.violencia to solo_lectura;

create index violencia_codigo_entrevista_index
	on analitica.violencia (codigo_entrevista);

create index violencia_id_entrevista_index
	on analitica.violencia (id_entrevista);




