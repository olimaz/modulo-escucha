drop table if exists esclarecimiento.excel_etiquetado;
create table esclarecimiento.excel_etiquetado
(
    id serial not null
        constraint excel_etiquetado_pkey
        primary key,

    etiqueta_n1 text,
    etiqueta_n2 text,
    etiqueta_n3 text,
    texto_marcado text,
    -- datos entrevista
    codigo_entrevista text,
    tipo_entrevista text,
    personas_entrevistadas integer default 1,
    es_virtual integer default 0,
    interes_exilio integer default 0,
    sector_entrevistado text,
    situacion_actual text default 'Finalizada'::text,
    clasificacion integer default 3,
    macroterritorio text,
    territorio text,
    codigo_entrevistador text,
    grupo_entrevistador text,
    entrevista_fecha text,
    entrevista_mes text,
    tiempo_entrevista integer default 0,
    entrevista_lugar_n1 text,
    entrevista_lugar_n2 text,
    entrevista_lugar_n3 text,
    entrevista_lat double precision,
    entrevista_lon double precision,
    hechos_anio_del text,
    hechos_anio_al text,

    titulo text,
    dinamica_1 text,
    dinamica_2 text,
    dinamica_3 text,


    -- Actores Armados
    aa_paramilitar integer default 0,
    aa_guerrilla integer default 0,
    aa_fuerza_publica integer default 0,
    aa_terceros_civiles integer default 0,
    aa_otro_grupo_armado integer default 0,
    aa_otro_agente_estado integer default 0,
    aa_otro_actor integer default 0,
    aa_ns_nr integer default 0,
    aa_internacional integer default 0,
    -- Violencia
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

    -- Filtros y trazabilidad
    id_etiqueta_entrevista integer,
    id_entrevistador integer
);

alter table esclarecimiento.excel_etiquetado owner to dba;

grant select on esclarecimiento.excel_etiquetado to solo_lectura;

create index excel_etiquetado_codigo_entrevista_index
    on esclarecimiento.excel_etiquetado (codigo_entrevista);

create index excel_etiquetado_id_entrevistador_index
    on esclarecimiento.excel_etiquetado (id_entrevistador);

create index excel_etiquetado_id_etiqueta_entrevista_index
    on esclarecimiento.excel_etiquetado (id_etiqueta_entrevista);
