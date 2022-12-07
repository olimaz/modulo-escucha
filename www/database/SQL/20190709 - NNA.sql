insert into "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") values (default, 1, 'NNA: Evaluacion de vulnerabilidad', 'NEV', null, default, default, null, default);
insert into "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") values (default, 1, 'NNA: Evaluación de seguridad', 'NES', null, default, default, null, default);

-- Anotar los ID de los anteriores en .env:
-- NEV=150
-- NES=151


-- auto-generated definition
create table esclarecimiento.nna_vulnerabilidad
(
    id_nna_vulnerabilidad      serial                 not null
        constraint nna_vulnerabilidad_pkey
            primary key,
    id_entrevistador           integer                not null
        constraint esclarecimiento_nna_vulnerabilidad_id_entrevistador_foreign
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    id_macroterritorio         integer                not null
        constraint esclarecimiento_nna_vulnerabilidad_id_macroterritorio_foreign
            references catalogos.cev
            on update cascade on delete restrict,
    id_territorio              integer                not null
        constraint esclarecimiento_nna_vulnerabilidad_id_territorio_foreign
            references catalogos.cev
            on update cascade on delete restrict,
    correlativo                integer                not null,
    codigo                     varchar(20)            not null,
    dictamen                   integer      default 2 not null,
    fecha_evaluacion           timestamp(0)           not null,
    nombres                    varchar(100)           not null,
    apellidos                  varchar(100)           not null,
    edad                       integer      default 0 not null,
    menor_12                   integer      default 1 not null,
    vive_familia               integer      default 2 not null,
    vive_padre_madre           integer      default 2 not null,
    vive_rep_legal             integer      default 2 not null,
    vive_familia_extensa       integer      default 2 not null,
    vive_con                   text,
    pariticipa_familia         integer      default 2 not null,
    pariticipa_comunidad       integer      default 2 not null,
    escuela_asiste             integer      default 2 not null,
    escuela_nombre             varchar(100) default 'Sin especificar'::character varying,
    escuela_grado              varchar(100) default 'Sin especificar'::character varying,
    escuela_problemas          integer      default 1 not null,
    escuela_problemas_progreso integer      default 1 not null,
    abuso_exposicion           integer      default 1 not null,
    abuso_fisico               integer      default 1 not null,
    abuso_sexual               integer      default 1 not null,
    abuso_abandono             integer      default 1 not null,
    abuso_ajustes              integer      default 1 not null,
    comunidad_conocimiento     integer      default 2 not null,
    comunidad_mensajes         text         default 'Sin especificar'::text,
    comunidad_reuniones        integer      default 2 not null,
    comunidad_apoyo            integer      default 2 not null,
    observaciones              text,
    created_at                 timestamp(0),
    updated_at                 timestamp(0)
);

alter table esclarecimiento.nna_vulnerabilidad
    owner to dba;

create index esclarecimiento_nna_vulnerabilidad_correlativo_index
    on esclarecimiento.nna_vulnerabilidad (correlativo);

create index esclarecimiento_nna_vulnerabilidad_nombres_index
    on esclarecimiento.nna_vulnerabilidad (nombres);

create index esclarecimiento_nna_vulnerabilidad_apellidos_index
    on esclarecimiento.nna_vulnerabilidad (apellidos);

create index esclarecimiento_nna_vulnerabilidad_id_entrevistador_index
    on esclarecimiento.nna_vulnerabilidad (id_entrevistador);

create index esclarecimiento_nna_vulnerabilidad_id_macroterritorio_index
    on esclarecimiento.nna_vulnerabilidad (id_macroterritorio);

create index esclarecimiento_nna_vulnerabilidad_id_territorio_index
    on esclarecimiento.nna_vulnerabilidad (id_territorio);

create index esclarecimiento_nna_vulnerabilidad_fecha_evaluacion_index
    on esclarecimiento.nna_vulnerabilidad (fecha_evaluacion);

create index esclarecimiento_nna_vulnerabilidad_codigo_index
    on esclarecimiento.nna_vulnerabilidad (codigo);



