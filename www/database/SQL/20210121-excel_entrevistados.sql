drop table if exists esclarecimiento.excel_ficha_persona_entrevistada;
create table esclarecimiento.excel_ficha_persona_entrevistada
(
    id_excel_ficha_persona_entrevistada serial not null
        constraint excel_ficha_persona_entrevistada_pk
        primary key,
    id_entrevista integer,
    id_persona integer,
    id_persona_entrevistada integer,
    codigo_entrevista varchar(100),
    macroterritorio text,
    territorio text,
    lugar_entrevista_n1 text,
    lugar_entrevista_n2 text,
    lugar_entrevista_n3 text,
    fecha_entrevista_anio text,
    fecha_entrevista_mes text,
    fecha_entrevista text,
    interes_etnico integer,
    sector text,
    transcrita integer,
    etiquetada integer,
    clasificacion_acceso integer,
    nombre text,
    apellido text,
    otros_nombres text,
    fec_nac_anio integer,
    fec_nac_mes integer,
    fec_nac_dia integer,
    lugar_nac_codigo text,
    lugar_nac_n1 text,
    lugar_nac_n2 text,
    lugar_nac_n3 text,
    lugar_nac_n3_lat text,
    lugar_nac_n3_lon text,
    edad   integer,
    grupo_etario text,
    sexo varchar(200),
    orientacion_sexual varchar(200),
    identidad_genero varchar(200),
    pertenencia_etnica varchar(200),
    pertenencia_indigena varchar(200),
    nacionalidad varchar(200),
    estado_civil varchar(200),
    educacion_formal varchar(200),
    lugar_residencia_codigo text,
    lugar_residencia_n1 text,
    lugar_residencia_n2 text,
    lugar_residencia_n3 text,
    lugar_residencia_n3_lat text,
    lugar_residencia_n3_lon text,
    lugar_residencia_zona varchar(200),
    profesion text,
    ocupacion_actual text,
    cargo_publico integer,
    cargo_publico_cual text,
    fuerza_publica_miembro text,
    fuerza_publica_estado varchar(200),
    actor_armado_ilegal text,
    organizacion_colectivo_participa integer,
    discapacidad text,
    es_victima integer,
    es_testigo integer,
    relato text
);

alter table esclarecimiento.excel_ficha_persona_entrevistada owner to dba;

grant select on esclarecimiento.excel_ficha_persona_entrevistada to solo_lectura;

create index excel_ficha_persona_entrevistada_id_entrevista_index
    on esclarecimiento.excel_ficha_persona_entrevistada (id_entrevista);

create index excel_ficha_persona_entrevistada_id_persona_entrevistada_index
    on esclarecimiento.excel_ficha_persona_entrevistada (id_persona_entrevistada);

create index excel_ficha_persona_entrevistada_id_persona_index
    on esclarecimiento.excel_ficha_persona_entrevistada (id_persona);

create index excel_ficha_persona_entrevistada_codigo_entrevista_index
    on esclarecimiento.excel_ficha_persona_entrevistada (codigo_entrevista);

