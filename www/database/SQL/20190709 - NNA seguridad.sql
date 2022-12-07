-- Catalogos
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES (16, 'NNA: Quien refiere', 'Opciones del formulario de evaluación de seguridad', DEFAULT);
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES (17, 'NNA: Información ofrecida ', 'Opciones del formualrio de evaluación de seguridad', DEFAULT);

-- opciones C16
INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (DEFAULT, 16, 'Padre y/o madre o representante legal', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (DEFAULT, 16, 'Organización social', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (DEFAULT, 16, 'Líder o lideresa comunitario o religioso', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (DEFAULT, 16, 'El propio niño, niña o adolescente', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (DEFAULT, 16, 'Otro ', null, null, DEFAULT, DEFAULT, null, DEFAULT)

-- opciones C17
insert into catalogos.cat_item (id_cat,descripcion) values (17,'El mandato de la Comisión de la verdad');
insert into catalogos.cat_item (id_cat,descripcion) values (17,'Proceso de toma de testimonio');
insert into catalogos.cat_item (id_cat,descripcion) values (17,'Encuentros por la Verdad');
insert into catalogos.cat_item (id_cat,descripcion) values (17,'Apoyo psicosocial disponible');
insert into catalogos.cat_item (id_cat,descripcion) values (17,'Presencia del representante legal');
insert into catalogos.cat_item (id_cat,descripcion) values (17,'Limitaciones del apoyo por parte de la Comisión ');
insert into catalogos.cat_item (id_cat,descripcion) values (17,'Confidencialidad');
insert into catalogos.cat_item (id_cat,descripcion) values (17,'Voluntariedad');
insert into catalogos.cat_item (id_cat,descripcion) values (17,'Consentimiento informado');

-- Tabla principal
create table esclarecimiento.nna_seguridad
(
    id_nna_seguridad         serial            not null
        constraint nna_seguridad_pkey
            primary key,
    id_nna_vulnerabilidad    integer           not null,
    id_entrevistador         integer           not null
        constraint esclarecimiento_nna_seguridad_id_entrevistador_foreign
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    id_macroterritorio       integer           not null
        constraint esclarecimiento_nna_seguridad_id_macroterritorio_foreign
            references catalogos.cev
            on update cascade on delete restrict,
    id_territorio            integer           not null
        constraint esclarecimiento_nna_seguridad_id_territorio_foreign
            references catalogos.cev
            on update cascade on delete restrict,
    correlativo              integer           not null,
    codigo                   varchar(20)       not null,
    dictamen                 integer default 2 not null,
    fecha_evaluacion         timestamp(0)      not null,
    id_quien_refiere         integer
        constraint esclarecimiento_nna_seguridad_id_quien_refiere_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_quien_refiere_otro    varchar(200),
    revisar_proceso          integer default 2 not null,
    firma_consentimiento     integer default 2 not null,
    existe_entidad           integer default 2 not null,
    lugar_privado            integer default 2 not null,
    alguien_acompana         integer default 2 not null,
    alguien_acompana_padre   integer default 2 not null,
    alguien_acompana_ts      integer default 2 not null,
    alguien_acompana_otro    integer default 2 not null,
    apoyo_identificado       integer default 2 not null,
    informado_presencia      integer default 2 not null,
    informado_cev            integer default 2 not null,
    entrevista_cierre        integer default 2 not null,
    entrevista_cierre_porque text,
    entrevista_seguimiento   integer default 2 not null,
    observaciones            text,
    created_at               timestamp(0),
    updated_at               timestamp(0)
);

alter table esclarecimiento.nna_seguridad
    owner to dba;

create index esclarecimiento_nna_seguridad_id_nna_vulnerabilidad_index
    on esclarecimiento.nna_seguridad (id_nna_vulnerabilidad);

create index esclarecimiento_nna_seguridad_correlativo_index
    on esclarecimiento.nna_seguridad (correlativo);

create index esclarecimiento_nna_seguridad_codigo_index
    on esclarecimiento.nna_seguridad (codigo);

create index esclarecimiento_nna_seguridad_id_entrevistador_index
    on esclarecimiento.nna_seguridad (id_entrevistador);

create index esclarecimiento_nna_seguridad_id_macroterritorio_index
    on esclarecimiento.nna_seguridad (id_macroterritorio);

create index esclarecimiento_nna_seguridad_id_territorio_index
    on esclarecimiento.nna_seguridad (id_territorio);

create index esclarecimiento_nna_seguridad_dictamen_index
    on esclarecimiento.nna_seguridad (dictamen);

create index esclarecimiento_nna_seguridad_fecha_evaluacion_index
    on esclarecimiento.nna_seguridad (fecha_evaluacion);

-- tabla secundaria
create table esclarecimiento.nna_seguridad_info
(
    id_nna_seguridad_info serial  not null
        constraint nna_seguridad_info_pkey
            primary key,
    id_nna_seguridad      integer not null
        constraint esclarecimiento_nna_seguridad_info_id_nna_seguridad_foreign
            references esclarecimiento.nna_seguridad
            on update cascade on delete cascade,
    id_info               integer not null
        constraint esclarecimiento_nna_seguridad_info_id_info_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    constraint esclarecimiento_nna_seguridad_info_id_info_id_nna_seguridad_uni
        unique (id_info, id_nna_seguridad)
);

alter table esclarecimiento.nna_seguridad_info
    owner to dba;

create index esclarecimiento_nna_seguridad_info_id_nna_seguridad_index
    on esclarecimiento.nna_seguridad_info (id_nna_seguridad);

create index esclarecimiento_nna_seguridad_info_id_info_index
    on esclarecimiento.nna_seguridad_info (id_info);

