INSERT INTO "catalogos"."criterio_fijo_grupo" ("id_grupo", "descripcion") VALUES (20, 'Tipo de enlace entre entrevistas');
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (20, 1, 'Relacionamiento manual', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (20, 2, 'Unificación de entrevistas', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (20, 3, 'Traslado', DEFAULT);

create table esclarecimiento.enlace
(
    id_enlace        serial  not null
        constraint enlace_pk
            primary key,
    id_subserie      integer not null,
    id_primaria      integer not null,
    id_subserie_e    integer not null,
    id_primaria_e    integer not null,
    id_tipo          integer   default 1,
    id_entrevistador integer not null
        constraint enlace_entrevistador_id_entrevistador_fk
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    anotaciones      text,
    id_activo        integer   default 1,
    fh_insert        timestamp default now()
);

comment on table esclarecimiento.enlace is 'Relacionar entrevistas';

comment on column esclarecimiento.enlace.id_tipo is 'Criterio fijo 20';

comment on column esclarecimiento.enlace.id_entrevistador is 'Quien realiza el enlace';

comment on column esclarecimiento.enlace.id_activo is '1:activo; otro valor: inactivo';

alter table esclarecimiento.enlace
    owner to dba;

create index enlace_id_activo_index
    on esclarecimiento.enlace (id_activo);

create index enlace_id_entrevistador_index
    on esclarecimiento.enlace (id_entrevistador);

create index enlace_id_primaria_e_index
    on esclarecimiento.enlace (id_primaria_e);

create index enlace_id_primaria_index
    on esclarecimiento.enlace (id_primaria);

create index enlace_id_subserie_e_index
    on esclarecimiento.enlace (id_subserie_e);

create unique index enlace_id_subserie_id_primaria_id_subserie_e_id_primaria_e_uind
    on esclarecimiento.enlace (id_subserie, id_primaria, id_subserie_e, id_primaria_e);

create index enlace_id_subserie_index
    on esclarecimiento.enlace (id_subserie);

create index enlace_id_tipo_index
    on esclarecimiento.enlace (id_tipo);

-- No tiene sentido, por el id_activo. Mejor guardar el historial
drop index esclarecimiento.enlace_id_subserie_id_primaria_id_subserie_e_id_primaria_e_uind;



