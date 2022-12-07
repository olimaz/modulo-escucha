-- tipo de adjunto
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (1, 30, 'Excel de listado de codigos', 30);

-- traza de actividad
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (22, 30, 'Excel con listado de codigos', 0);

-- TABLAS
create table if not exists sim.excel_listados
(
    id_excel_listados serial not null
        constraint excel_listados_pk
            primary key,
    id_entrevistador integer
        constraint excel_listados_entrevistador_id_entrevistador_fk
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    id_activo integer default 1,
    id_acceso_publico integer default 1,
    id_adjunto integer
        constraint excel_listados_adjunto_id_adjunto_fk
            references esclarecimiento.adjunto
            on update cascade on delete restrict,
    descripcion varchar(200),
    cantidad_codigos_si integer,
    cantidad_codigos_no integer,
    created_at timestamp default now()
);

comment on table sim.excel_listados is 'Listados de codigos de entrevistas.  utilizado en filtros por listado en estadisticas';

comment on column sim.excel_listados.id_entrevistador is 'quien carga el excel';

comment on column sim.excel_listados.id_activo is 'Para soft delete';

comment on column sim.excel_listados.id_acceso_publico is '1: acceso publico. Cualquier otro valor=privado';

comment on column sim.excel_listados.id_adjunto is 'relacion al archivo cargado';

comment on column sim.excel_listados.descripcion is 'Para ubicar el archivo';

alter table sim.excel_listados owner to dba;

create index if not exists excel_listados_descripcion_index
    on sim.excel_listados (descripcion);

create index if not exists excel_listados_id_activo_index
    on sim.excel_listados (id_activo);

create index if not exists excel_listados_id_adjunto_index
    on sim.excel_listados (id_adjunto);

create index if not exists excel_listados_id_entrevistador_index
    on sim.excel_listados (id_entrevistador);

create index if not exists excel_listados_id_acceso_publico_index
    on sim.excel_listados (id_acceso_publico);

create table if not exists sim.excel_listados_codigos
(
    id_excel_listados_codigos serial not null
        constraint excel_listados_codigos_pk
            primary key,
    id_excel_listados integer,
    codigo varchar(100),
    valido integer default 2
);

comment on table sim.excel_listados_codigos is 'Detalle de la tabla excel_listados';

alter table sim.excel_listados_codigos owner to dba;

create index if not exists excel_listados_codigos_codigo_index
    on sim.excel_listados_codigos (codigo);

create index if not exists excel_listados_codigos_id_excel_listados_index
    on sim.excel_listados_codigos (id_excel_listados);

create index if not exists excel_listados_codigos_valido_index
    on sim.excel_listados_codigos (valido);

