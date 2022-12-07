create table sim.entrevista_victima
(
	id_entrevista_victima serial not null
		constraint entrevista_victima_pk
			primary key,
	titulo varchar(200),
	creador varchar(100),
	fecha_inicio_entrevista varchar(20),
	fecha_fin_entrevista varchar(20),
	tipo_recurso text,
	identificador varchar(20),
	nivel_descripcion text,
	derechos_acceso integer default 4,
	fecha_carga varchar(20),
	cobertura_temporal_inicio varchar(20),
	cobertura_temporal_fin varchar(20),
	cobertura_geografica text,
	lugar_entrevista text,
	poblacion varchar(100),
	derechos text,
	actores_conflicto text,
	hecho_victimizante text,
	territorio text,
	areas_interes text,
	adjuntos text,
	transcripcion text,
	transcripcion_txt text,
	etiquetado_json text,
	titulo_entrevista text,
	sintesis_entrevista text,
	otros_datos text
);

comment on table sim.entrevista_victima is 'Tabla para integración de datos';

comment on column sim.entrevista_victima.id_entrevista_victima is 'Autoincrimental, llave primaria';

comment on column sim.entrevista_victima.titulo is 'Código de la entrevista';

comment on column sim.entrevista_victima.creador is 'Código del entrevistador';

comment on column sim.entrevista_victima.fecha_inicio_entrevista is 'Fecha de la entrevista';

comment on column sim.entrevista_victima.fecha_fin_entrevista is 'Fecha de la entrevista';

comment on column sim.entrevista_victima.tipo_recurso is 'Texto predefinido';

comment on column sim.entrevista_victima.identificador is 'Permite rastrear de regreso hacia el sistema.  Código de la entrevista';

comment on column sim.entrevista_victima.nivel_descripcion is 'Texto predefinido';

comment on column sim.entrevista_victima.derechos_acceso is 'Nivel de clasificación';

comment on column sim.entrevista_victima.fecha_carga is 'Fecha de creación en el sistema';

comment on column sim.entrevista_victima.cobertura_temporal_inicio is 'Utiliza anyo de inicio de los hechos';

comment on column sim.entrevista_victima.cobertura_temporal_fin is 'Utiliza anyo de finalización de los hechos';

comment on column sim.entrevista_victima.cobertura_geografica is 'json con los tres niveles';

comment on column sim.entrevista_victima.lugar_entrevista is 'json con lugar de la entrevista';

comment on column sim.entrevista_victima.poblacion is 'Sector con que identifica la persona entrevistada';

comment on column sim.entrevista_victima.derechos is 'Texto predefinido';

comment on column sim.entrevista_victima.actores_conflicto is 'json con codigo y descripción de actores';

comment on column sim.entrevista_victima.hecho_victimizante is 'json con id y descripcion de violaciones';

comment on column sim.entrevista_victima.territorio is 'json con id, macro y territorio';

comment on column sim.entrevista_victima.areas_interes is 'json con arreglo de nucleos, areas y puntos del mandato';

comment on column sim.entrevista_victima.adjuntos is 'JSON con ubicación de archivos adjuntos';

comment on column sim.entrevista_victima.transcripcion is 'JSON del otranscribe';
comment on column sim.entrevista_victima.etiquetado_json is 'JSON del dataturks';

comment on column sim.entrevista_victima.transcripcion_txt is 'Transcripcion en texto plano, sin html ni json';

alter table sim.entrevista_victima owner to dba;


--


drop table if exists esclarecimiento.excel_entrevista_fvt;
create table esclarecimiento.excel_entrevista_fvt
(
	id_e_ind_fvt integer not null
		constraint excel_entrevista_fvt_pkey
			primary key,
	tipo_entrevista text,
	correlativo integer,
	clasificacion integer default 3,
	codigo_entrevista text,
	codigo_entrevistador text,
	macroterritorio_id integer,
	macroterritorio_txt text,
	territorio_id integer,
	territorio_txt text,
	grupo_id integer,
	grupo_txt text,
	entrevista_fecha text,
	tiempo_entrevista integer default 0,
	entrevista_lugar_n1_codigo text,
	entrevista_lugar_n1_txt text,
	entrevista_lugar_n2_codigo text,
	entrevista_lugar_n2_txt text,
	entrevista_lugar_n3_codigo text,
	entrevista_lugar_n3_txt text,
	titulo text,
	hechos_lugar_n1_codigo text,
	hechos_lugar_n1_txt text,
	hechos_lugar_n2_codigo text,
	hechos_lugar_n2_txt text,
	hechos_lugar_n3_codigo text,
	hechos_lugar_n3_txt text,
	hechos_del text,
	hechos_al text,
	anotaciones text,
	es_prioritario integer default 0,
	prioritario_tema text,
	sector_victima text,
	interes_etnico integer default 0,
	remitido text,
	transcrita text,
	transcripcion_fecha text,
	transcripcion_fecha_a text,
	transcripcion_fecha_m text,
	etiquetada text,
	etiquetado_fecha text,
	etiquetado_fecha_a text,
	etiquetado_fecha_m text,
	aa_paramilitar integer default 0,
	aa_guerrilla integer default 0,
	aa_fuerza_publica integer default 0,
	aa_terceros_civiles integer default 0,
	aa_otro_grupo_armado integer default 0,
	aa_otro_agente_estado integer default 0,
	aa_otro_actor integer default 0,
	aa_ns_nr integer default 0,
	aa_internacional integer default 0,
	viol_homicidio integer default 0,
	viol_atentado_vida integer default 0,
	viol_amenaza_vida integer default 0,
	viol_desaparicion_f integer default 0,
	viol_tortura integer default 0,
	viol_violencia_sexual integer default 0,
	viol_esclavitud integer default 0,
	viol_reclutamiento integer default 0,
	viol_detencion_arbitraria integer default 0,
	viol_secuestro integer default 0,
	viol_confinamiento integer default 0,
	viol_pillaje integer default 0,
	viol_extorsion integer default 0,
	viol_ataque_bien_protegido integer default 0,
	viol_ataque_indiscriminado integer default 0,
	viol_despojo_tierras integer default 0,
	viol_desplazamiento_forzado integer default 0,
	viol_exilio integer default 0,
	i_objetivo_esclarecimiento integer default 0,
	i_objetivo_reconocimiento integer default 0,
	i_objetivo_convivencia integer default 0,
	i_objetivo_no_repeticion integer default 0,
	i_enfoque_genero integer default 0,
	i_enfoque_psicosocial integer default 0,
	i_enfoque_curso_vida integer default 0,
	i_direccion_investigacion integer default 0,
	i_direccion_territorios integer default 0,
	i_direccion_etnica integer default 0,
	i_comisionados integer default 0,
	i_estrategia_arte integer default 0,
	i_estrategia_comunicacion integer default 0,
	i_estrategia_participacion integer default 0,
	i_estrategia_pedagogia integer default 0,
	i_grupo_acceso_informacion integer default 0,
	i_presidencia integer default 0,
	i_otra integer default 0,
	i_enlace integer default 0,
	i_sistema_informacion integer default 0,
	ia_pueblo_etnico integer default 0,
	ia_dialogo_social integer default 0,
	ia_ds_o_convivencia integer default 0,
	ia_ds_o_reconocimiento integer default 0,
	ia_ds_o_no_repeticion integer default 0,
	ia_genero integer default 0,
	ia_enfoque_ps integer default 0,
	ia_curso_vida integer default 0,
	nucleo_01 integer default 0,
	nucleo_02 integer default 0,
	nucleo_03 integer default 0,
	nucleo_04 integer default 0,
	nucleo_05 integer default 0,
	nucleo_06 integer default 0,
	nucleo_07 integer default 0,
	nucleo_08 integer default 0,
	nucleo_09 integer default 0,
	nucleo_10 integer default 0,
	mandato_01 integer default 0,
	mandato_02 integer default 0,
	mandato_03 integer default 0,
	mandato_04 integer default 0,
	mandato_05 integer default 0,
	mandato_06 integer default 0,
	mandato_07 integer default 0,
	mandato_08 integer default 0,
	mandato_09 integer default 0,
	mandato_10 integer default 0,
	mandato_11 integer default 0,
	mandato_12 integer default 0,
	mandato_13 integer default 0,
	dinamica_1 text,
	dinamica_2 text,
	dinamica_3 text,
	a_consentimiento integer default 0,
	a_audio integer default 0,
	a_ficha_corta integer default 0,
	a_ficha_larga integer default 0,
	a_otros integer default 0,
	a_transcripcion_preliminar integer default 0,
	a_transcripcion_final integer default 0,
	a_etiquetado integer default 0,
	a_retroalimentacion integer default 0,
	a_relatoria integer default 0,
	a_certificacion_inicial integer default 0,
	a_certificacion_final integer default 0,
	a_plan_trabajo integer default 0,
	a_valoracion integer default 0,
	entrevista_lat double precision,
	entrevista_lon double precision,
	hechos_lat double precision,
	hechos_lon double precision,
	transcripcion_html text,

	etiquetado_json text,

	created_at timestamp(0) not null,
	updated_at timestamp(0),
	id_entrevistador integer,
	sintesis_relato text,
	ficha_priorizar_entrevista integer default '-99'::integer,
	ficha_priorizar_entrevista_asuntos text,
	ficha_contiene_patrones integer default '-99'::integer,
	ficha_contiene_patrones_cuales text,
	ci_conceder_entrevista integer default '-99'::integer,
	ci_grabar_audio integer default '-99'::integer,
	ci_elaborar_informe integer default '-99'::integer,
	ci_tratamiento_datos_analizar integer default '-99'::integer,
	ci_tratamiento_datos_analizar_sensible integer default '-99'::integer,
	ci_tratamiento_datos_utilizar integer default '-99'::integer,
	ci_tratamiento_datos_utilizar_sensible integer default '-99'::integer,
	ci_tratamiento_datos_publicar integer default '-99'::integer,
	persona_entrevistada_sexo text default '(No diligenciado)'::text,
	persona_entrevistada_es_victima integer default '-99'::integer,
	persona_entrevistada_es_testigo integer default '-99'::integer,
	cantidad_fichas_victima integer default '-99'::integer,
	cantidad_fichas_exilio integer default '-99'::integer,
	prioridad_fluidez integer default -99,
	prioridad_d_hecho integer default -99,
	prioridad_d_contexto integer default -99,
	prioridad_d_impacto integer default -99,
	prioridad_d_justicia integer default -99,
	prioridad_cierre integer default -99,
	prioridad_ponderacion integer default -99,
	prioridad_ahora_entiendo text,
	prioridad_cambio_perspectiva text


);

alter table esclarecimiento.excel_entrevista_fvt owner to dba;

create index excel_entrevista_fvt_codigo_entrevista_index
	on esclarecimiento.excel_entrevista_fvt (codigo_entrevista);

create index excel_entrevista_fvt_id_entrevistador_index
	on esclarecimiento.excel_entrevista_fvt (id_entrevistador);


