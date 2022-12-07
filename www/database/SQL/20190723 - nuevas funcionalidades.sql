-- Mejorar los adjuntos, para preservar el nombre original
alter table esclarecimiento.adjunto
	add nombre_original text;

alter table esclarecimiento.adjunto
	add fh_insert timestamp default current_timestamp;


-- Catalogo 18 para entrevistas colectivas
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (18, 'Sectores entrevistados', 'Utilizado en la entrevista colectiva', DEFAULT);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (18,'Víctimas',1);
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Líderes sociales');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Empresarios');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Sindicalistas');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Actores armados');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Comerciantes');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Industriales');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Políticos');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Comunidad indígena');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Jóvenes');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Mujeres');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Niñez y adolescencia');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Académicos');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Religiosos');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Periodistas');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Funcionarios públicos');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Familiares de ex combatientes');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Integrantes de comunidad');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Juntas de acción comunal');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Campesinos');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Ex combatientes ');
insert into catalogos.cat_item(id_cat,descripcion) values (18,'Salud y servicio sanitario');
insert into catalogos.cat_item(id_cat,descripcion, orden) values (18,'Otros',99);

-- Tipo de adjunto: relatoria
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (1, 11, 'Relatoría', 11);

-- Para la traza de auditoria
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(22,10,'Entrevista colectiva');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(22,11,'Entrevista profundidad');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(22,12,'Historia de vida');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(22,13,'Diagnostico comunitario');

-- Nuevas tablas
create table esclarecimiento.diagnostico_comunitario
(
    id_diagnostico_comunitario serial            not null
        constraint diagnostico_comunitario_pkey
            primary key,
    id_macroterritorio         integer           not null
        constraint esclarecimiento_diagnostico_comunitario_id_macroterritorio_fore
            references catalogos.cev
            on update cascade on delete restrict,
    id_territorio              integer           not null
        constraint esclarecimiento_diagnostico_comunitario_id_territorio_foreign
            references catalogos.cev
            on update cascade on delete restrict,
    id_entrevistador           integer           not null
        constraint esclarecimiento_diagnostico_comunitario_id_entrevistador_foreig
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    numero_entrevistador       integer           not null,
    entrevista_codigo          varchar(20)       not null,
    entrevista_correlativo     integer           not null,
    entrevista_numero          integer           not null,
    entrevista_lugar           integer           not null
        constraint esclarecimiento_diagnostico_comunitario_entrevista_lugar_foreig
            references catalogos.geo
            on update cascade on delete restrict,
    entrevista_fecha           timestamp(0)      not null,
    equipo_facilitador         varchar(255)      not null,
    equipo_relator             varchar(255)      not null,
    equipo_memorista           varchar(255)      not null,
    equipo_otros               text,
    tema_comunidad             text              not null,
    tema_objetivo              text              not null,
    tema_del                   timestamp(0)      not null,
    tema_al                    timestamp(0)      not null,
    tema_lugar                 integer           not null
        constraint esclarecimiento_diagnostico_comunitario_tema_lugar_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    cantidad_participantes     integer           not null,
    id_sector                  integer           not null
        constraint esclarecimiento_diagnostico_comunitario_id_sector_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    tema_dinamica              text              not null,
    observaciones              text,
    clasificacion_nna          integer default 1 not null,
    clasificacion_sex          integer default 1 not null,
    clasificacion_res          integer default 1 not null,
    clasificacion_nivel        integer default 3 not null,
    id_usuario                 integer           not null
        constraint esclarecimiento_diagnostico_comunitario_id_usuario_foreign
            references users
            on update cascade on delete restrict,
    created_at                 timestamp(0),
    updated_at                 timestamp(0)
);

alter table esclarecimiento.diagnostico_comunitario
    owner to dba;

create index esclarecimiento_diagnostico_comunitario_id_macroterritorio_inde
    on esclarecimiento.diagnostico_comunitario (id_macroterritorio);

create index esclarecimiento_diagnostico_comunitario_id_territorio_index
    on esclarecimiento.diagnostico_comunitario (id_territorio);

create index esclarecimiento_diagnostico_comunitario_id_entrevistador_index
    on esclarecimiento.diagnostico_comunitario (id_entrevistador);

create index esclarecimiento_diagnostico_comunitario_entrevista_codigo_index
    on esclarecimiento.diagnostico_comunitario (entrevista_codigo);

create index esclarecimiento_diagnostico_comunitario_entrevista_correlativo_
    on esclarecimiento.diagnostico_comunitario (entrevista_correlativo);

create index esclarecimiento_diagnostico_comunitario_entrevista_numero_index
    on esclarecimiento.diagnostico_comunitario (entrevista_numero);

create index esclarecimiento_diagnostico_comunitario_entrevista_lugar_index
    on esclarecimiento.diagnostico_comunitario (entrevista_lugar);

create index esclarecimiento_diagnostico_comunitario_entrevista_fecha_index
    on esclarecimiento.diagnostico_comunitario (entrevista_fecha);

create index esclarecimiento_diagnostico_comunitario_tema_del_index
    on esclarecimiento.diagnostico_comunitario (tema_del);

create index esclarecimiento_diagnostico_comunitario_tema_al_index
    on esclarecimiento.diagnostico_comunitario (tema_al);

create index esclarecimiento_diagnostico_comunitario_clasificacion_nivel_ind
    on esclarecimiento.diagnostico_comunitario (clasificacion_nivel);

create index esclarecimiento_diagnostico_comunitario_id_usuario_index
    on esclarecimiento.diagnostico_comunitario (id_usuario);

create table esclarecimiento.diagnostico_comunitario_adjunto
(
    id_diagnostico_comunitario_adjunto serial  not null
        constraint diagnostico_comunitario_adjunto_pkey
            primary key,
    id_diagnostico_comunitario         integer not null
        constraint esclarecimiento_diagnostico_comunitario_adjunto_id_diagnostico_
            references esclarecimiento.diagnostico_comunitario
            on update cascade on delete cascade,
    id_adjunto                         integer not null
        constraint esclarecimiento_diagnostico_comunitario_adjunto_id_adjunto_fore
            references esclarecimiento.adjunto
            on update cascade on delete restrict,
    id_tipo                            integer not null,
    id_usuario                         integer not null,
    created_at                         timestamp(0),
    updated_at                         timestamp(0)
);

alter table esclarecimiento.diagnostico_comunitario_adjunto
    owner to dba;

create index esclarecimiento_diagnostico_comunitario_adjunto_id_diagnostico_
    on esclarecimiento.diagnostico_comunitario_adjunto (id_diagnostico_comunitario);

create index esclarecimiento_diagnostico_comunitario_adjunto_id_adjunto_inde
    on esclarecimiento.diagnostico_comunitario_adjunto (id_adjunto);

create table esclarecimiento.diagnostico_comunitario_mandato
(
    id_diagnostico_comunitario_mandato serial  not null
        constraint diagnostico_comunitario_mandato_pkey
            primary key,
    id_diagnostico_comunitario         integer not null
        constraint esclarecimiento_diagnostico_comunitario_mandato_id_diagnostico_
            references esclarecimiento.diagnostico_comunitario
            on update cascade on delete cascade,
    id_mandato                         integer not null
        constraint esclarecimiento_diagnostico_comunitario_mandato_id_mandato_fore
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_usuario                         integer not null,
    created_at                         timestamp(0),
    updated_at                         timestamp(0)
);

alter table esclarecimiento.diagnostico_comunitario_mandato
    owner to dba;

create index esclarecimiento_diagnostico_comunitario_mandato_id_diagnostico_
    on esclarecimiento.diagnostico_comunitario_mandato (id_diagnostico_comunitario);

create index esclarecimiento_diagnostico_comunitario_mandato_id_mandato_inde
    on esclarecimiento.diagnostico_comunitario_mandato (id_mandato);

create table esclarecimiento.entrevista_colectiva
(
    id_entrevista_colectiva serial            not null
        constraint entrevista_colectiva_pkey
            primary key,
    id_macroterritorio      integer           not null
        constraint esclarecimiento_entrevista_colectiva_id_macroterritorio_foreign
            references catalogos.cev
            on update cascade on delete restrict,
    id_territorio           integer           not null
        constraint esclarecimiento_entrevista_colectiva_id_territorio_foreign
            references catalogos.cev
            on update cascade on delete restrict,
    id_entrevistador        integer           not null
        constraint esclarecimiento_entrevista_colectiva_id_entrevistador_foreign
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    numero_entrevistador    integer           not null,
    entrevista_codigo       varchar(20)       not null,
    entrevista_correlativo  integer           not null,
    entrevista_numero       integer           not null,
    entrevista_lugar        integer           not null
        constraint esclarecimiento_entrevista_colectiva_entrevista_lugar_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    entrevista_fecha        timestamp(0)      not null,
    equipo_facilitador      varchar(255)      not null,
    equipo_memorista        varchar(255)      not null,
    equipo_otros            text,
    tema_descripcion        text              not null,
    tema_objetivo           text              not null,
    tema_del                timestamp(0)      not null,
    tema_al                 timestamp(0)      not null,
    tema_lugar              integer           not null
        constraint esclarecimiento_entrevista_colectiva_tema_lugar_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    cantidad_participantes  integer           not null,
    id_sector               integer           not null
        constraint esclarecimiento_entrevista_colectiva_id_sector_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    eventos_descripcion     text              not null,
    observaciones           text,
    clasificacion_nna       integer default 1 not null,
    clasificacion_sex       integer default 1 not null,
    clasificacion_res       integer default 1 not null,
    clasificacion_nivel     integer default 3 not null,
    id_usuario              integer           not null
        constraint esclarecimiento_entrevista_colectiva_id_usuario_foreign
            references users
            on update cascade on delete restrict,
    created_at              timestamp(0),
    updated_at              timestamp(0)
);

alter table esclarecimiento.entrevista_colectiva
    owner to dba;

create index esclarecimiento_entrevista_colectiva_id_macroterritorio_index
    on esclarecimiento.entrevista_colectiva (id_macroterritorio);

create index esclarecimiento_entrevista_colectiva_id_territorio_index
    on esclarecimiento.entrevista_colectiva (id_territorio);

create index esclarecimiento_entrevista_colectiva_id_entrevistador_index
    on esclarecimiento.entrevista_colectiva (id_entrevistador);

create index esclarecimiento_entrevista_colectiva_entrevista_codigo_index
    on esclarecimiento.entrevista_colectiva (entrevista_codigo);

create index esclarecimiento_entrevista_colectiva_entrevista_correlativo_ind
    on esclarecimiento.entrevista_colectiva (entrevista_correlativo);

create index esclarecimiento_entrevista_colectiva_entrevista_numero_index
    on esclarecimiento.entrevista_colectiva (entrevista_numero);

create index esclarecimiento_entrevista_colectiva_entrevista_lugar_index
    on esclarecimiento.entrevista_colectiva (entrevista_lugar);

create index esclarecimiento_entrevista_colectiva_entrevista_fecha_index
    on esclarecimiento.entrevista_colectiva (entrevista_fecha);

create index esclarecimiento_entrevista_colectiva_tema_del_index
    on esclarecimiento.entrevista_colectiva (tema_del);

create index esclarecimiento_entrevista_colectiva_tema_al_index
    on esclarecimiento.entrevista_colectiva (tema_al);

create index esclarecimiento_entrevista_colectiva_tema_lugar_index
    on esclarecimiento.entrevista_colectiva (tema_lugar);

create index esclarecimiento_entrevista_colectiva_clasificacion_nivel_index
    on esclarecimiento.entrevista_colectiva (clasificacion_nivel);

create index esclarecimiento_entrevista_colectiva_id_sector_index
    on esclarecimiento.entrevista_colectiva (id_sector);

create index esclarecimiento_entrevista_colectiva_id_usuario_index
    on esclarecimiento.entrevista_colectiva (id_usuario);

create table esclarecimiento.entrevista_colectiva_adjunto
(
    id_entrevista_colectiva_adjunto serial  not null
        constraint entrevista_colectiva_adjunto_pkey
            primary key,
    id_entrevista_colectiva         integer not null
        constraint esclarecimiento_entrevista_colectiva_adjunto_id_entrevista_cole
            references esclarecimiento.entrevista_colectiva
            on update cascade on delete cascade,
    id_adjunto                      integer not null
        constraint esclarecimiento_entrevista_colectiva_adjunto_id_adjunto_foreign
            references esclarecimiento.adjunto
            on update cascade on delete restrict,
    id_tipo                         integer not null,
    id_usuario                      integer not null,
    created_at                      timestamp(0),
    updated_at                      timestamp(0)
);

alter table esclarecimiento.entrevista_colectiva_adjunto
    owner to dba;

create index esclarecimiento_entrevista_colectiva_adjunto_id_entrevista_cole
    on esclarecimiento.entrevista_colectiva_adjunto (id_entrevista_colectiva);

create index esclarecimiento_entrevista_colectiva_adjunto_id_adjunto_index
    on esclarecimiento.entrevista_colectiva_adjunto (id_adjunto);

create table esclarecimiento.entrevista_colectiva_mandato
(
    id_entrevista_colectiva_mandato serial  not null
        constraint entrevista_colectiva_mandato_pkey
            primary key,
    id_entrevista_colectiva         integer not null
        constraint esclarecimiento_entrevista_colectiva_mandato_id_entrevista_cole
            references esclarecimiento.entrevista_colectiva
            on update cascade on delete cascade,
    id_mandato                      integer not null
        constraint esclarecimiento_entrevista_colectiva_mandato_id_mandato_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_usuario                      integer not null,
    created_at                      timestamp(0),
    updated_at                      timestamp(0)
);

alter table esclarecimiento.entrevista_colectiva_mandato
    owner to dba;

create index esclarecimiento_entrevista_colectiva_mandato_id_entrevista_cole
    on esclarecimiento.entrevista_colectiva_mandato (id_entrevista_colectiva);

create index esclarecimiento_entrevista_colectiva_mandato_id_mandato_index
    on esclarecimiento.entrevista_colectiva_mandato (id_mandato);

create table esclarecimiento.entrevista_profundidad
(
    id_entrevista_profundidad serial            not null
        constraint entrevista_profundidad_pkey
            primary key,
    id_macroterritorio        integer           not null
        constraint esclarecimiento_entrevista_profundidad_id_macroterritorio_forei
            references catalogos.cev
            on update cascade on delete restrict,
    id_territorio             integer           not null
        constraint esclarecimiento_entrevista_profundidad_id_territorio_foreign
            references catalogos.cev
            on update cascade on delete restrict,
    id_entrevistador          integer           not null
        constraint esclarecimiento_entrevista_profundidad_id_entrevistador_foreign
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    numero_entrevistador      integer           not null,
    entrevista_codigo         varchar(20)       not null,
    entrevista_correlativo    integer           not null,
    entrevista_numero         integer           not null,
    entrevista_lugar          integer           not null
        constraint esclarecimiento_entrevista_profundidad_entrevista_lugar_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    entrevista_fecha          timestamp(0)      not null,
    entrevista_objetivo       text              not null,
    entrevistado_nombres      varchar(255)      not null,
    entrevistado_apellidos    varchar(255)      not null,
    id_sector                 integer           not null
        constraint esclarecimiento_entrevista_profundidad_id_sector_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    observaciones             text,
    clasificacion_nna         integer default 1 not null,
    clasificacion_sex         integer default 1 not null,
    clasificacion_res         integer default 1 not null,
    clasificacion_nivel       integer default 3 not null,
    id_usuario                integer           not null
        constraint esclarecimiento_entrevista_profundidad_id_usuario_foreign
            references users
            on update cascade on delete restrict,
    created_at                timestamp(0),
    updated_at                timestamp(0)
);

alter table esclarecimiento.entrevista_profundidad
    owner to dba;

create index esclarecimiento_entrevista_profundidad_id_macroterritorio_index
    on esclarecimiento.entrevista_profundidad (id_macroterritorio);

create index esclarecimiento_entrevista_profundidad_id_territorio_index
    on esclarecimiento.entrevista_profundidad (id_territorio);

create index esclarecimiento_entrevista_profundidad_id_entrevistador_index
    on esclarecimiento.entrevista_profundidad (id_entrevistador);

create index esclarecimiento_entrevista_profundidad_entrevista_codigo_index
    on esclarecimiento.entrevista_profundidad (entrevista_codigo);

create index esclarecimiento_entrevista_profundidad_entrevista_correlativo_i
    on esclarecimiento.entrevista_profundidad (entrevista_correlativo);

create index esclarecimiento_entrevista_profundidad_entrevista_numero_index
    on esclarecimiento.entrevista_profundidad (entrevista_numero);

create index esclarecimiento_entrevista_profundidad_entrevista_lugar_index
    on esclarecimiento.entrevista_profundidad (entrevista_lugar);

create index esclarecimiento_entrevista_profundidad_entrevista_fecha_index
    on esclarecimiento.entrevista_profundidad (entrevista_fecha);

create index esclarecimiento_entrevista_profundidad_id_sector_index
    on esclarecimiento.entrevista_profundidad (id_sector);

create index esclarecimiento_entrevista_profundidad_clasificacion_nivel_inde
    on esclarecimiento.entrevista_profundidad (clasificacion_nivel);

create index esclarecimiento_entrevista_profundidad_id_usuario_index
    on esclarecimiento.entrevista_profundidad (id_usuario);

create table esclarecimiento.entrevista_profundidad_adjunto
(
    id_entrevista_profundidad_adjunto serial  not null
        constraint entrevista_profundidad_adjunto_pkey
            primary key,
    id_entrevista_profundidad         integer not null
        constraint esclarecimiento_entrevista_profundidad_adjunto_id_entrevista_pr
            references esclarecimiento.entrevista_profundidad
            on update cascade on delete cascade,
    id_adjunto                        integer not null
        constraint esclarecimiento_entrevista_profundidad_adjunto_id_adjunto_forei
            references esclarecimiento.adjunto
            on update cascade on delete restrict,
    id_tipo                           integer not null,
    id_usuario                        integer not null,
    created_at                        timestamp(0),
    updated_at                        timestamp(0)
);

alter table esclarecimiento.entrevista_profundidad_adjunto
    owner to dba;

create index esclarecimiento_entrevista_profundidad_adjunto_id_entrevista_pr
    on esclarecimiento.entrevista_profundidad_adjunto (id_entrevista_profundidad);

create index esclarecimiento_entrevista_profundidad_adjunto_id_adjunto_index
    on esclarecimiento.entrevista_profundidad_adjunto (id_adjunto);

create table esclarecimiento.entrevista_profundidad_mandato
(
    id_entrevista_profundidad_mandato serial  not null
        constraint entrevista_profundidad_mandato_pkey
            primary key,
    id_entrevista_profundidad         integer not null
        constraint esclarecimiento_entrevista_profundidad_mandato_id_entrevista_pr
            references esclarecimiento.entrevista_profundidad
            on update cascade on delete cascade,
    id_mandato                        integer not null
        constraint esclarecimiento_entrevista_profundidad_mandato_id_mandato_forei
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_usuario                        integer not null,
    created_at                        timestamp(0),
    updated_at                        timestamp(0)
);

alter table esclarecimiento.entrevista_profundidad_mandato
    owner to dba;

create index esclarecimiento_entrevista_profundidad_mandato_id_entrevista_pr
    on esclarecimiento.entrevista_profundidad_mandato (id_entrevista_profundidad);

create index esclarecimiento_entrevista_profundidad_mandato_id_mandato_index
    on esclarecimiento.entrevista_profundidad_mandato (id_mandato);

create table esclarecimiento.entrevista_profundidad_tema
(
    id_entrevista_profundidad_tema serial  not null
        constraint entrevista_profundidad_tema_pkey
            primary key,
    id_entrevista_profundidad      integer not null
        constraint esclarecimiento_entrevista_profundidad_tema_id_entrevista_profu
            references esclarecimiento.entrevista_profundidad
            on update cascade on delete cascade,
    tema                           text    not null,
    id_usuario                     integer not null,
    created_at                     timestamp(0),
    updated_at                     timestamp(0)
);

alter table esclarecimiento.entrevista_profundidad_tema
    owner to dba;

create index esclarecimiento_entrevista_profundidad_tema_id_entrevista_profu
    on esclarecimiento.entrevista_profundidad_tema (id_entrevista_profundidad);

create index esclarecimiento_entrevista_profundidad_tema_tema_index
    on esclarecimiento.entrevista_profundidad_tema (tema);

create table esclarecimiento.historia_vida
(
    id_historia_vida           serial            not null
        constraint historia_vida_pkey
            primary key,
    id_macroterritorio         integer           not null
        constraint esclarecimiento_historia_vida_id_macroterritorio_foreign
            references catalogos.cev
            on update cascade on delete restrict,
    id_territorio              integer           not null
        constraint esclarecimiento_historia_vida_id_territorio_foreign
            references catalogos.cev
            on update cascade on delete restrict,
    id_entrevistador           integer           not null
        constraint esclarecimiento_historia_vida_id_entrevistador_foreign
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    numero_entrevistador       integer           not null,
    entrevista_codigo          varchar(20)       not null,
    entrevista_correlativo     integer           not null,
    entrevista_numero          integer           not null,
    entrevista_lugar           integer           not null
        constraint esclarecimiento_historia_vida_entrevista_lugar_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    entrevista_fecha           timestamp(0)      not null,
    entrevista_objetivo        text              not null,
    entrevistado_nombres       varchar(255),
    entrevistado_apellidos     varchar(255),
    entrevistado_otros_nombres varchar(255),
    id_sector                  integer           not null
        constraint esclarecimiento_historia_vida_id_sector_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    observaciones              text,
    clasificacion_nna          integer default 1 not null,
    clasificacion_sex          integer default 1 not null,
    clasificacion_res          integer default 1 not null,
    clasificacion_nivel        integer default 3 not null,
    id_usuario                 integer           not null
        constraint esclarecimiento_historia_vida_id_usuario_foreign
            references users
            on update cascade on delete restrict,
    created_at                 timestamp(0),
    updated_at                 timestamp(0)
);

alter table esclarecimiento.historia_vida
    owner to dba;

create index esclarecimiento_historia_vida_id_macroterritorio_index
    on esclarecimiento.historia_vida (id_macroterritorio);

create index esclarecimiento_historia_vida_id_territorio_index
    on esclarecimiento.historia_vida (id_territorio);

create index esclarecimiento_historia_vida_id_entrevistador_index
    on esclarecimiento.historia_vida (id_entrevistador);

create index esclarecimiento_historia_vida_entrevista_codigo_index
    on esclarecimiento.historia_vida (entrevista_codigo);

create index esclarecimiento_historia_vida_entrevista_correlativo_index
    on esclarecimiento.historia_vida (entrevista_correlativo);

create index esclarecimiento_historia_vida_entrevista_numero_index
    on esclarecimiento.historia_vida (entrevista_numero);

create index esclarecimiento_historia_vida_entrevista_lugar_index
    on esclarecimiento.historia_vida (entrevista_lugar);

create index esclarecimiento_historia_vida_entrevista_fecha_index
    on esclarecimiento.historia_vida (entrevista_fecha);

create index esclarecimiento_historia_vida_id_sector_index
    on esclarecimiento.historia_vida (id_sector);

create index esclarecimiento_historia_vida_clasificacion_nivel_index
    on esclarecimiento.historia_vida (clasificacion_nivel);

create index esclarecimiento_historia_vida_id_usuario_index
    on esclarecimiento.historia_vida (id_usuario);

create table esclarecimiento.historia_vida_adjunto
(
    id_historia_vida_adjunto serial  not null
        constraint historia_vida_adjunto_pkey
            primary key,
    id_historia_vida         integer not null
        constraint esclarecimiento_historia_vida_adjunto_id_historia_vida_foreign
            references esclarecimiento.historia_vida
            on update cascade on delete cascade,
    id_adjunto               integer not null
        constraint esclarecimiento_historia_vida_adjunto_id_adjunto_foreign
            references esclarecimiento.adjunto
            on update cascade on delete restrict,
    id_tipo                  integer not null,
    id_usuario               integer not null,
    created_at               timestamp(0),
    updated_at               timestamp(0)
);

alter table esclarecimiento.historia_vida_adjunto
    owner to dba;

create index esclarecimiento_historia_vida_adjunto_id_historia_vida_index
    on esclarecimiento.historia_vida_adjunto (id_historia_vida);

create index esclarecimiento_historia_vida_adjunto_id_adjunto_index
    on esclarecimiento.historia_vida_adjunto (id_adjunto);

create table esclarecimiento.historia_vida_mandato
(
    id_historia_vida_mandato serial  not null
        constraint historia_vida_mandato_pkey
            primary key,
    id_historia_vida         integer not null
        constraint esclarecimiento_historia_vida_mandato_id_historia_vida_foreign
            references esclarecimiento.historia_vida
            on update cascade on delete cascade,
    id_mandato               integer not null
        constraint esclarecimiento_historia_vida_mandato_id_mandato_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_usuario               integer not null,
    created_at               timestamp(0),
    updated_at               timestamp(0)
);

alter table esclarecimiento.historia_vida_mandato
    owner to dba;

create index esclarecimiento_historia_vida_mandato_id_historia_vida_index
    on esclarecimiento.historia_vida_mandato (id_historia_vida);

create index esclarecimiento_historia_vida_mandato_id_mandato_index
    on esclarecimiento.historia_vida_mandato (id_mandato);

create table esclarecimiento.historia_vida_tema
(
    id_historia_vida_tema serial  not null
        constraint historia_vida_tema_pkey
            primary key,
    id_historia_vida      integer not null
        constraint esclarecimiento_historia_vida_tema_id_historia_vida_foreign
            references esclarecimiento.historia_vida
            on update cascade on delete cascade,
    tema                  text    not null,
    id_usuario            integer not null,
    created_at            timestamp(0),
    updated_at            timestamp(0)
);

alter table esclarecimiento.historia_vida_tema
    owner to dba;

create index esclarecimiento_historia_vida_tema_id_historia_vida_index
    on esclarecimiento.historia_vida_tema (id_historia_vida);

create index esclarecimiento_historia_vida_tema_tema_index
    on esclarecimiento.historia_vida_tema (tema);



-- -----------------------------------------------------------------
-- Cambios al 7-Ago-19
delete from esclarecimiento.entrevista_colectiva;

alter table esclarecimiento.entrevista_colectiva
	add entrevista_fecha_inicio timestamp not null;

alter table esclarecimiento.entrevista_colectiva
	add entrevista_fecha_final timestamp;

alter table esclarecimiento.entrevista_colectiva
	add entrevista_avance int;

alter table esclarecimiento.entrevista_colectiva
	add titulo text;

drop index esclarecimiento.esclarecimiento_entrevista_colectiva_entrevista_fecha_index;

alter table esclarecimiento.entrevista_colectiva drop column entrevista_fecha;



create index entrevista_colectiva_entrevista_avance_index
	on esclarecimiento.entrevista_colectiva (entrevista_avance);

create index entrevista_colectiva_entrevista_fecha_final_index
	on esclarecimiento.entrevista_colectiva (entrevista_fecha_final);

create index entrevista_colectiva_entrevista_fecha_inicio_index
	on esclarecimiento.entrevista_colectiva (entrevista_fecha_inicio);

-- Nucleos temáticos
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (19, 'Nucleos temáticos', 'Temas del área de investigación', DEFAULT);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (19,'1. Democracia y conflicto armado.',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (19,'2. El Estado y sus responsabilidades en el conflicto armado.',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (19,'3: Relación entre las estructuras del estado y actores armados ilegales.',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (19,'4: Modelos de desarrollo/dinámicas económicas y conflicto armado/economía y conflicto armado.',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (19,'5: Despojo de tierras y desplazamiento forzado.',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (19,'6: Coca, narcotráfico y conflicto armado.',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (19,'7: Resistencia, luchas y transformaciones sociales.',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (19,'8: Impactos sobre la integridad cultural y territorial de las comunidades étnicas.',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (19,'9: Dimensiones internacionales del conflicto armado y exilio.',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (19,'10: Conflicto armado, sociedad y cultura.',10);

INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (20, 'Avance de las entrevistas', 'Usado en entrevistas colectivas, profundidad, diagnosticos comunitarios e historias de vida', DEFAULT);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (20,'En proceso.',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (20,'Finalizada.',2);

-- Para mostrar la referenica
INSERT INTO "catalogos"."parametro" ("id_parametro", "nombre", "descripcion", "valor") VALUES (3, 'ID documento entrevista colectiva', 'id_documento para mostrarlo como referencia', '20');
INSERT INTO "catalogos"."parametro" ("id_parametro", "nombre", "descripcion", "valor") VALUES (4, 'ID documento entrevista profunidad', 'id_documento para mostrarlo como referencia', '21');
INSERT INTO "catalogos"."parametro" ("id_parametro", "nombre", "descripcion", "valor") VALUES (5, 'ID documento historia de vida', 'id_documento para mostrarlo como referencia', '22');
INSERT INTO "catalogos"."parametro" ("id_parametro", "nombre", "descripcion", "valor") VALUES (6, 'ID documento de Diagnostico Comunitario', 'id_documento para mostrarlo como referencia', '23');
INSERT INTO "catalogos"."parametro" ("id_parametro", "nombre", "descripcion", "valor") VALUES (7, 'ID documento de entrevista profundidad a responsables', 'id_documento para mostrarlo como referencia', '24');


-- Entrevistas a profundidad
delete from esclarecimiento.entrevista_profundidad;
alter table esclarecimiento.entrevista_profundidad
	add entrevista_fecha_inicio timestamp not null;

alter table esclarecimiento.entrevista_profundidad
	add entrevista_fecha_final timestamp;

alter table esclarecimiento.entrevista_profundidad
	add entrevista_avance int;

alter table esclarecimiento.entrevista_profundidad
	add titulo text not null;

drop index esclarecimiento.esclarecimiento_entrevista_profundidad_entrevista_fecha_index;

alter table esclarecimiento.entrevista_profundidad drop column entrevista_fecha;

create index entrevista_profundidad_entrevista_avance_index
	on esclarecimiento.entrevista_profundidad (entrevista_avance);

create index entrevista_profundidad_entrevista_fecha_final_index
	on esclarecimiento.entrevista_profundidad (entrevista_fecha_final);

create index entrevista_profundidad_entrevista_fecha_inicio_index
	on esclarecimiento.entrevista_profundidad (entrevista_fecha_inicio);

create index entrevista_profundidad_titulo_index
	on esclarecimiento.entrevista_profundidad (titulo);

alter table esclarecimiento.entrevista_profundidad
	add constraint entrevista_profundidad_cat_item_id_item_fk
		foreign key (entrevista_avance) references catalogos.cat_item
			on update cascade on delete restrict;

--
create table esclarecimiento.entrevista_profundidad_interes
(
    id_entrevista_profundidad_interes serial not null
        constraint entrevista_profundidad_interes_pk
            primary key,
    id_entrevista_profundidad         integer
        constraint entrevista_profundidad_interes_entrevista_profundidad_id_entrev
            references esclarecimiento.entrevista_profundidad
            on update cascade on delete cascade,
    id_interes                        integer
        constraint entrevista_profundidad_interes_cat_item_id_item_fk
            references catalogos.cat_item
            on update cascade on delete restrict
);

comment on table esclarecimiento.entrevista_profundidad_interes is 'nucleos temáticos';

alter table esclarecimiento.entrevista_profundidad_interes
    owner to dba;

create unique index entrevista_profundidad_interes_id_entrevista_profundidad_id_int
    on esclarecimiento.entrevista_profundidad_interes (id_entrevista_profundidad, id_interes);

create index entrevista_profundidad_interes_id_entrevista_profundidad_index
    on esclarecimiento.entrevista_profundidad_interes (id_entrevista_profundidad);

create index entrevista_profundidad_interes_id_interes_index
    on esclarecimiento.entrevista_profundidad_interes (id_interes);


-- dinamicas
create table esclarecimiento.entrevista_profundidad_dinamica
(
    id_entrevista_profundidad_dinamica serial not null
        constraint entrevista_profundidad_dinamica_pk
            primary key,
    id_entrevista_profundidad          integer
        constraint entrevista_profundidad_dinamica_entrevista_profundidad_id_entre
            references esclarecimiento.entrevista_profundidad
            on update cascade on delete cascade,
    dinamica                           text,
    id_dinamica                        integer
        constraint entrevista_profundidad_dinamica_cat_item_id_item_fk
            references catalogos.cat_item
            on update cascade on delete restrict
);

comment on table esclarecimiento.entrevista_profundidad_dinamica is 'Dinámicas identificadas';

alter table esclarecimiento.entrevista_profundidad_dinamica
    owner to dba;

create index entrevista_profundidad_dinamica_dinamica_index
    on esclarecimiento.entrevista_profundidad_dinamica (dinamica);

create index entrevista_profundidad_dinamica_id_dinamica_index
    on esclarecimiento.entrevista_profundidad_dinamica (id_dinamica);

create index entrevista_profundidad_dinamica_id_entrevista_profundidad_index
    on esclarecimiento.entrevista_profundidad_dinamica (id_entrevista_profundidad);

-- historia de vida

delete  from esclarecimiento.historia_vida;
alter table esclarecimiento.historia_vida
	add entrevista_fecha_inicio timestamp not null;

alter table esclarecimiento.historia_vida
	add entrevista_fecha_final timestamp;

alter table esclarecimiento.historia_vida
	add entrevista_avance int;

alter table esclarecimiento.historia_vida
	add titulo text;

drop index esclarecimiento.esclarecimiento_historia_vida_entrevista_fecha_index;

alter table esclarecimiento.historia_vida drop column entrevista_fecha;

create index historia_vida_entrevista_avance_index
	on esclarecimiento.historia_vida (entrevista_avance);

create index historia_vida_entrevista_fecha_final_index
	on esclarecimiento.historia_vida (entrevista_fecha_final);

create index historia_vida_entrevista_fecha_inicio_index
	on esclarecimiento.historia_vida (entrevista_fecha_inicio);

create index historia_vida_titulo_index
	on esclarecimiento.historia_vida (titulo);

alter table esclarecimiento.historia_vida
	add constraint historia_vida_cat_item_id_item_fk
		foreign key (entrevista_avance) references catalogos.cat_item
			on update cascade on delete restrict;

-- nucleos tematicos
create table esclarecimiento.historia_vida_interes
(
    id_historia_vida_interes serial  not null
        constraint historia_vida_interes_pk
            primary key,
    id_historia_vida         integer not null
        constraint historia_vida_interes_historia_vida_id_historia_vida_fk
            references esclarecimiento.historia_vida
            on update cascade on delete cascade,
    id_interes               integer not null
        constraint historia_vida_interes_cat_item_id_item_fk
            references catalogos.cat_item
            on update cascade on delete restrict
);

alter table esclarecimiento.historia_vida_interes
    owner to dba;

create index historia_vida_interes_id_historia_vida_index
    on esclarecimiento.historia_vida_interes (id_historia_vida);

create index historia_vida_interes_id_interes_index
    on esclarecimiento.historia_vida_interes (id_interes);

-- dinamicas
create table esclarecimiento.historia_vida_dinamica
(
    id_historia_vida_dinamica serial not null
        constraint historia_vida_dinamica_pk
            primary key,
    id_historia_vida          integer
        constraint historia_vida_dinamica_historia_vida_id_historia_vida_fk
            references esclarecimiento.historia_vida
            on update cascade on delete cascade,
    id_dinamica               integer
        constraint historia_vida_dinamica_cat_item_id_item_fk
            references catalogos.cat_item
            on update cascade on delete restrict,
    dinamica                  text   not null
);

comment on table esclarecimiento.historia_vida_dinamica is 'Dinámicas identificadas';

alter table esclarecimiento.historia_vida_dinamica
    owner to dba;

create index historia_vida_dinamica_id_dinamica_index
    on esclarecimiento.historia_vida_dinamica (id_dinamica);

create index historia_vida_dinamica_id_historia_vida_index
    on esclarecimiento.historia_vida_dinamica (id_historia_vida);

-- campos nuevs\os
alter table esclarecimiento.historia_vida
	add id_sexo int;

alter table esclarecimiento.historia_vida
	add id_orientacion_sexual int;

alter table esclarecimiento.historia_vida
	add id_identidad_genero int;

alter table esclarecimiento.historia_vida
	add id_pertenencia_etnico_racial int;

create index historia_vida_id_identidad_genero_index
	on esclarecimiento.historia_vida (id_identidad_genero);

create index historia_vida_id_orientacion_sexual_index
	on esclarecimiento.historia_vida (id_orientacion_sexual);

create index historia_vida_id_pertenencia_etnico_racial_index
	on esclarecimiento.historia_vida (id_pertenencia_etnico_racial);

create index historia_vida_id_sexo_index
	on esclarecimiento.historia_vida (id_sexo);

alter table esclarecimiento.historia_vida
	add constraint historia_vida_cat_item_id_item_fk_2
		foreign key (id_sexo) references catalogos.cat_item
			on update cascade on delete restrict;

alter table esclarecimiento.historia_vida
	add constraint historia_vida_cat_item_id_item_fk_3
		foreign key (id_orientacion_sexual) references catalogos.cat_item
			on update cascade on delete restrict;

alter table esclarecimiento.historia_vida
	add constraint historia_vida_cat_item_id_item_fk_4
		foreign key (id_identidad_genero) references catalogos.cat_item
			on update cascade on delete restrict;

alter table esclarecimiento.historia_vida
	add constraint historia_vida_cat_item_id_item_fk_5
		foreign key (id_pertenencia_etnico_racial) references catalogos.cat_item
			on update cascade on delete restrict;

-- Diagnostico Comunitario
delete from esclarecimiento.diagnostico_comunitario;
alter table esclarecimiento.diagnostico_comunitario drop column entrevista_fecha;

alter table esclarecimiento.diagnostico_comunitario
	add entrevista_fecha_inicio timestamp not null;

alter table esclarecimiento.diagnostico_comunitario
	add entrevista_fecha_final timestamp;

alter table esclarecimiento.diagnostico_comunitario
	add entrevista_avance int;

alter table esclarecimiento.diagnostico_comunitario
	add titulo text not null;

create index diagnostico_comunitario_entrevista_avance_index
	on esclarecimiento.diagnostico_comunitario (entrevista_avance);

create index diagnostico_comunitario_entrevista_fecha_final_index
	on esclarecimiento.diagnostico_comunitario (entrevista_fecha_final);

create index diagnostico_comunitario_entrevista_fecha_inicio_index
	on esclarecimiento.diagnostico_comunitario (entrevista_fecha_inicio);

create index diagnostico_comunitario_titulo_index
	on esclarecimiento.diagnostico_comunitario (titulo);

alter table esclarecimiento.diagnostico_comunitario
	add constraint diagnostico_comunitario_cat_item_id_item_fk
		foreign key (entrevista_avance) references catalogos.cat_item
			on update cascade on delete restrict;

-- diamica
create table esclarecimiento.diagnostico_comunitario_dinamica
(
    id_diagnostico_comunitario_dinamica serial not null
        constraint diagnostico_comunitario_dinamica_pk
            primary key
        constraint diagnostico_comunitario_dinamica_diagnostico_comunitario_id_dia
            references esclarecimiento.diagnostico_comunitario
            on update cascade on delete cascade,
    id_diagnostico_comunitario          integer,
    id_dinamica                         integer
        constraint diagnostico_comunitario_dinamica___fk
            references catalogos.cat_item
            on update cascade on delete restrict,
    dinamica                            text   not null
);

alter table esclarecimiento.diagnostico_comunitario_dinamica
    owner to dba;

create index diagnostico_comunitario_dinamica__indexd
    on esclarecimiento.diagnostico_comunitario_dinamica (dinamica);

create index diagnostico_comunitario_dinamica_id_diagnostico_comunitario_ind
    on esclarecimiento.diagnostico_comunitario_dinamica (id_diagnostico_comunitario_dinamica);

create index diagnostico_comunitario_dinamica_id_dinamica_index
    on esclarecimiento.diagnostico_comunitario_dinamica (id_dinamica);

-- interes
create table esclarecimiento.diagnostico_comunitario_interes
(
    id_diagnostico_comunitario_interes serial not null
        constraint diagnostico_comunitario_interes_pk
            primary key,
    id_diagnostico_comunitario         integer
        constraint diagnostico_comunitario_interes_diagnostico_comunitario_id_diag
            references esclarecimiento.diagnostico_comunitario
            on update cascade on delete cascade,
    id_interes                         integer
        constraint diagnostico_comunitario_interes_cat_item_id_item_fk
            references catalogos.cat_item
            on update cascade on delete restrict
);

alter table esclarecimiento.diagnostico_comunitario_interes
    owner to dba;

create unique index diagnostico_comunitario_interes_id_diagnostico_comunitario_id_i
    on esclarecimiento.diagnostico_comunitario_interes (id_diagnostico_comunitario, id_interes);

create index diagnostico_comunitario_interes_id_diagnostico_comunitario_inde
    on esclarecimiento.diagnostico_comunitario_interes (id_diagnostico_comunitario);

create index diagnostico_comunitario_interes_id_interes_index
    on esclarecimiento.diagnostico_comunitario_interes (id_interes);

-- Correccion
alter table esclarecimiento.diagnostico_comunitario_dinamica drop constraint diagnostico_comunitario_dinamica_diagnostico_comunitario_id_dia;
--  COLECTIVA
create table esclarecimiento.entrevista_colectiva_dinamica
(
    id_entrevista_colectiva_dinamica serial not null
        constraint entrevista_colectiva_dinamica_pk
            primary key,
    id_entrevista_colectiva          integer
        constraint entrevista_colectiva_dinamica_entrevista_colectiva_id_entrevist
            references esclarecimiento.entrevista_colectiva
            on update cascade on delete cascade,
    dinamica                         text   not null,
    id_dinamica                      integer
        constraint entrevista_colectiva_dinamica_cat_item_id_item_fk
            references catalogos.cat_item
            on update cascade on delete restrict
);

comment on table esclarecimiento.entrevista_colectiva_dinamica is 'Dinamicas identificadas';

alter table esclarecimiento.entrevista_colectiva_dinamica
    owner to dba;

create index entrevista_colectiva_dinamica_dinamica_index
    on esclarecimiento.entrevista_colectiva_dinamica (dinamica);

create index entrevista_colectiva_dinamica_id_dinamica_index
    on esclarecimiento.entrevista_colectiva_dinamica (id_dinamica);

create index entrevista_colectiva_dinamica_id_entrevista_colectiva_index
    on esclarecimiento.entrevista_colectiva_dinamica (id_entrevista_colectiva);

-- interes
create table esclarecimiento.entrevista_colectiva_interes
(
    id_entrevista_colectiva_interes serial not null
        constraint entrevista_colectiva_interes_pk
            primary key,
    id_entrevista_colectiva         integer
        constraint entrevista_colectiva_interes_entrevista_colectiva_id_entrevista
            references esclarecimiento.entrevista_colectiva
            on update cascade on delete cascade,
    id_interes                      integer
        constraint entrevista_colectiva_interes_cat_item_id_item_fk
            references catalogos.cat_item
            on update cascade on delete restrict
);

comment on table esclarecimiento.entrevista_colectiva_interes is 'Nucleos temáticos de interés';

alter table esclarecimiento.entrevista_colectiva_interes
    owner to dba;

create unique index entrevista_colectiva_interes_id_entrevista_colectiva_id_interes
    on esclarecimiento.entrevista_colectiva_interes (id_entrevista_colectiva, id_interes);

create index entrevista_colectiva_interes_id_entrevista_colectiva_index
    on esclarecimiento.entrevista_colectiva_interes (id_entrevista_colectiva);

create index entrevista_colectiva_interes_id_interes_index
    on esclarecimiento.entrevista_colectiva_interes (id_interes);


update catalogos.cat_item set orden=99 where descripcion ilike 'otro%';
alter table esclarecimiento.diagnostico_comunitario alter column equipo_memorista drop not null;


-- Correcciones al 12-ago
alter table esclarecimiento.entrevista_profundidad alter column entrevistado_nombres drop not null;

alter table esclarecimiento.entrevista_profundidad alter column entrevistado_apellidos drop not null;

-- Exceles
drop table if exists esclarecimiento.excel_entrevista_dinamica;
create table esclarecimiento.excel_entrevista_dinamica
(
    id_dinamica                 serial not null
        constraint excel_entrevista_dinamica_pkey
            primary key,
    id_e_ind_fvt                integer,
    correlativo                 integer,
    dinamica                    text,
    codigo_entrevista           text,
    codigo_entrevistador        text,
    macroterritorio_id          integer,
    macroterritorio_txt         text,
    territorio_id               integer,
    territorio_txt              text,
    entrevista_fecha            text,
    entrevista_lugar_n1_codigo  text,
    entrevista_lugar_n1_txt     text,
    entrevista_lugar_n2_codigo  text,
    entrevista_lugar_n2_txt     text,
    entrevista_lugar_n3_codigo  text,
    entrevista_lugar_n3_txt     text,
    titulo                      text,
    hechos_lugar_n1_codigo      text,
    hechos_lugar_n1_txt         text,
    hechos_lugar_n2_codigo      text,
    hechos_lugar_n2_txt         text,
    hechos_lugar_n3_codigo      text,
    hechos_lugar_n3_txt         text,
    hechos_del                  text,
    hechos_al                   text,
    anotaciones                 text,
    aa_paramilitar              integer default 0,
    aa_guerrilla                integer default 0,
    aa_fuerza_publica           integer default 0,
    aa_terceros_civiles         integer default 0,
    aa_otro_grupo_armado        integer default 0,
    aa_otro_agente_estado       integer default 0,
    aa_otro_actor               integer default 0,
    aa_ns_nr                    integer default 0,
    aa_internacional            integer default 0,
    viol_homicidio              integer default 0,
    viol_atentado_vida          integer default 0,
    viol_amenaza_vida           integer default 0,
    viol_desaparicion_f         integer default 0,
    viol_tortura                integer default 0,
    viol_violencia_sexual       integer default 0,
    viol_esclavitud             integer default 0,
    viol_reclutamiento          integer default 0,
    viol_detencion_arbitraria   integer default 0,
    viol_secuestro              integer default 0,
    viol_confinamiento          integer default 0,
    viol_pillaje                integer default 0,
    viol_extorsion              integer default 0,
    viol_ataque_bien_protegido  integer default 0,
    viol_ataque_indiscriminado  integer default 0,
    viol_despojo_tierras        integer default 0,
    viol_desplazamiento_forzado integer default 0,
    viol_exilio                 integer default 0,
    i_objetivo_esclarecimiento  integer default 0,
    i_objetivo_reconocimiento   integer default 0,
    i_objetivo_convivencia      integer default 0,
    i_objetivo_no_repeticion    integer default 0,
    i_enfoque_genero            integer default 0,
    i_enfoque_psicosocial       integer default 0,
    i_enfoque_curso_vida        integer default 0,
    i_direccion_investigacion   integer default 0,
    i_direccion_territorios     integer default 0,
    i_direccion_etnica          integer default 0,
    i_comisionados              integer default 0,
    i_estrategia_arte           integer default 0,
    i_estrategia_comunicacion   integer default 0,
    i_estrategia_participacion  integer default 0,
    i_estrategia_pedagogia      integer default 0,
    i_grupo_acceso_informacion  integer default 0,
    i_presidencia               integer default 0,
    i_otra                      integer default 0,
    i_enlace                    integer default 0,
    i_sistema_informacion       integer default 0,
    nucleo_01                   integer default 0,
    nucleo_02                   integer default 0,
    nucleo_03                   integer default 0,
    nucleo_04                   integer default 0,
    nucleo_05                   integer default 0,
    nucleo_06                   integer default 0,
    nucleo_07                   integer default 0,
    nucleo_08                   integer default 0,
    nucleo_09                   integer default 0,
    nucleo_10                   integer default 0,
    mandato_01                  integer default 0,
    mandato_02                  integer default 0,
    mandato_03                  integer default 0,
    mandato_04                  integer default 0,
    mandato_05                  integer default 0,
    mandato_06                  integer default 0,
    mandato_07                  integer default 0,
    mandato_08                  integer default 0,
    mandato_09                  integer default 0,
    mandato_10                  integer default 0,
    mandato_11                  integer default 0,
    mandato_12                  integer default 0,
    mandato_13                  integer default 0,
    dinamica_1                  text,
    dinamica_2                  text,
    dinamica_3                  text,
    a_consentimiento            text    default '0'::text,
    a_audio                     text    default '0'::text,
    a_ficha_corta               text    default '0'::text,
    a_ficha_larga               text    default '0'::text,
    a_otros                     text    default '0'::text,
    a_transcripcion_preliminar  text    default '0'::text,
    a_transcripcion_final       text    default '0'::text,
    a_retroalimentacion         text    default '0'::text,
    created_at                  timestamp(0),
    updated_at                  timestamp(0)
);

alter table esclarecimiento.excel_entrevista_dinamica
    owner to dba;


alter table esclarecimiento.excel_entrevista_dinamica
    owner to dba;

drop table if exists esclarecimiento.excel_entrevista_fvt;
create table esclarecimiento.excel_entrevista_fvt
(
    id_e_ind_fvt                integer not null
        constraint excel_entrevista_fvt_pkey
            primary key,
    correlativo                 integer,
    codigo_entrevista           text,
    codigo_entrevistador        text,
    macroterritorio_id          integer,
    macroterritorio_txt         text,
    territorio_id               integer,
    territorio_txt              text,
    entrevista_fecha            text,
    entrevista_lugar_n1_codigo  text,
    entrevista_lugar_n1_txt     text,
    entrevista_lugar_n2_codigo  text,
    entrevista_lugar_n2_txt     text,
    entrevista_lugar_n3_codigo  text,
    entrevista_lugar_n3_txt     text,
    titulo                      text,
    hechos_lugar_n1_codigo      text,
    hechos_lugar_n1_txt         text,
    hechos_lugar_n2_codigo      text,
    hechos_lugar_n2_txt         text,
    hechos_lugar_n3_codigo      text,
    hechos_lugar_n3_txt         text,
    hechos_del                  text,
    hechos_al                   text,
    anotaciones                 text,
    aa_paramilitar              integer default 0,
    aa_guerrilla                integer default 0,
    aa_fuerza_publica           integer default 0,
    aa_terceros_civiles         integer default 0,
    aa_otro_grupo_armado        integer default 0,
    aa_otro_agente_estado       integer default 0,
    aa_otro_actor               integer default 0,
    aa_ns_nr                    integer default 0,
    aa_internacional            integer default 0,
    viol_homicidio              integer default 0,
    viol_atentado_vida          integer default 0,
    viol_amenaza_vida           integer default 0,
    viol_desaparicion_f         integer default 0,
    viol_tortura                integer default 0,
    viol_violencia_sexual       integer default 0,
    viol_esclavitud             integer default 0,
    viol_reclutamiento          integer default 0,
    viol_detencion_arbitraria   integer default 0,
    viol_secuestro              integer default 0,
    viol_confinamiento          integer default 0,
    viol_pillaje                integer default 0,
    viol_extorsion              integer default 0,
    viol_ataque_bien_protegido  integer default 0,
    viol_ataque_indiscriminado  integer default 0,
    viol_despojo_tierras        integer default 0,
    viol_desplazamiento_forzado integer default 0,
    viol_exilio                 integer default 0,
    i_objetivo_esclarecimiento  integer default 0,
    i_objetivo_reconocimiento   integer default 0,
    i_objetivo_convivencia      integer default 0,
    i_objetivo_no_repeticion    integer default 0,
    i_enfoque_genero            integer default 0,
    i_enfoque_psicosocial       integer default 0,
    i_enfoque_curso_vida        integer default 0,
    i_direccion_investigacion   integer default 0,
    i_direccion_territorios     integer default 0,
    i_direccion_etnica          integer default 0,
    i_comisionados              integer default 0,
    i_estrategia_arte           integer default 0,
    i_estrategia_comunicacion   integer default 0,
    i_estrategia_participacion  integer default 0,
    i_estrategia_pedagogia      integer default 0,
    i_grupo_acceso_informacion  integer default 0,
    i_presidencia               integer default 0,
    i_otra                      integer default 0,
    i_enlace                    integer default 0,
    i_sistema_informacion       integer default 0,
    nucleo_01                   integer default 0,
    nucleo_02                   integer default 0,
    nucleo_03                   integer default 0,
    nucleo_04                   integer default 0,
    nucleo_05                   integer default 0,
    nucleo_06                   integer default 0,
    nucleo_07                   integer default 0,
    nucleo_08                   integer default 0,
    nucleo_09                   integer default 0,
    nucleo_10                   integer default 0,
    mandato_01                  integer default 0,
    mandato_02                  integer default 0,
    mandato_03                  integer default 0,
    mandato_04                  integer default 0,
    mandato_05                  integer default 0,
    mandato_06                  integer default 0,
    mandato_07                  integer default 0,
    mandato_08                  integer default 0,
    mandato_09                  integer default 0,
    mandato_10                  integer default 0,
    mandato_11                  integer default 0,
    mandato_12                  integer default 0,
    mandato_13                  integer default 0,
    dinamica_1                  text,
    dinamica_2                  text,
    dinamica_3                  text,
    a_consentimiento            text    default '0'::text,
    a_audio                     text    default '0'::text,
    a_ficha_corta               text    default '0'::text,
    a_ficha_larga               text    default '0'::text,
    a_otros                     text    default '0'::text,
    a_transcripcion_preliminar  text    default '0'::text,
    a_transcripcion_final       text    default '0'::text,
    a_retroalimentacion         text    default '0'::text,
    created_at                  timestamp(0),
    updated_at                  timestamp(0)
);

alter table esclarecimiento.excel_entrevista_fvt
    owner to dba;

