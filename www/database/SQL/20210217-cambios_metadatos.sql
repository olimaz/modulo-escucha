drop table if exists analitica.metadatos;
create table analitica.metadatos
(
    id_entrevista integer not null
        constraint analitica_metadatos_pkey
        primary key,
    id_entrevistador integer,
    tipo_entrevista text,
    codigo_entrevista text,
    clasificacion_r1 integer default 0,
    clasificacion_r2 integer default 0,
    clasificacion_nna integer default 0,
    clasificacion_sex integer default 0,
    clasificacion_res integer default 0,
    clasificacion_nivel integer default '-99'::integer,
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
    entrevista_lat double precision,
    entrevista_lon double precision,
    hechos_lugar_n1_codigo text,
    hechos_lugar_n1_txt text,
    hechos_lugar_n2_codigo text,
    hechos_lugar_n2_txt text,
    hechos_lugar_n3_codigo text,
    hechos_lugar_n3_txt text,
    hechos_lat double precision,
    hechos_lon double precision,
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
    fichas_diligenciadas text,
    titulo text,
    dinamica_1 text,
    dinamica_2 text,
    dinamica_3 text,
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
    transcripcion_html text,
    etiquetado_json text,
    created_at timestamp(0),
    created_at_month varchar(20),
    updated_at timestamp(0),
    id_ficha_entrevista integer default '-99'::integer,
    idioma_id integer default '-99'::integer,
    idioma_txt text,
    idioma_nativo_id integer default '-99'::integer,
    idioma_nativo_txt text,
    nombre_interprete text,
    documentacion_aporta integer default '-99'::integer,
    documentacion_especificar text,
    identifica_testigos integer default '-99'::integer,
    ampliar_relato integer default '-99'::integer,
    ampliar_relato_temas text,
    priorizar_entrevista integer default '-99'::integer,
    priorizar_entrevista_asuntos text,
    contiene_patrones integer default '-99'::integer,
    contiene_patrones_cuales text,
    indicaciones_transcripcion text,
    observaciones text,
    ci_identificacion text,
    ci_conceder_entrevista integer default '-99'::integer,
    ci_grabar_audio integer default '-99'::integer,
    ci_elaborar_informe integer default '-99'::integer,
    ci_tratamiento_datos_analizar integer default '-99'::integer,
    ci_tratamiento_datos_analizar_sensible integer default '-99'::integer,
    ci_tratamiento_datos_utilizar integer default '-99'::integer,
    ci_tratamiento_datos_utilizar_sensible integer default '-99'::integer,
    ci_tratamiento_datos_publicar integer default '-99'::integer,
    ficha_entrevista_created_at text,
    ficha_entrevista_created_at_fecha text,
    ficha_entrevista_created_at_mes text,
    ficha_entrevista_updated_at text,
    id_prioridad integer default '-99'::integer,
    prioridad_tipo text,
    prioridad_fluidez integer default '-99'::integer,
    prioridad_d_hecho integer default '-99'::integer,
    prioridad_d_contexto integer default '-99'::integer,
    prioridad_d_impacto integer default '-99'::integer,
    prioridad_d_justicia integer default '-99'::integer,
    prioridad_cierre integer default '-99'::integer,
    prioridad_ponderacion integer default '-99'::integer,
    prioridad_ahora_entiendo text,
    prioridad_cambio_perspectiva text,
    prioridad_fecha_hora text,
    prioridad_fecha text,
    prioridad_mes text
);

alter table analitica.metadatos owner to dba;

grant select on analitica.metadatos to solo_lectura;

create index analitica_metadatos_codigo_entrevista_index
    on analitica.metadatos (codigo_entrevista);

create index analitica_metadatos_fvt_id_entrevistador_index
    on analitica.metadatos (id_entrevistador);

