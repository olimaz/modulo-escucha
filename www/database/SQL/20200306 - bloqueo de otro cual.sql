
-- Nueva tabla
create table catalogos.lista_negra
(
    id_lista_negra serial not null
        constraint lista_negra_pk
            primary key,
    id_entrevistador integer not null
        constraint lista_negra_entrevistador_id_entrevistador_fk
            references esclarecimiento.entrevistador
            on update cascade on delete cascade,
    id_activo integer default 1,
    comentarios text,
    fh_insert timestamp default now() not null,
    fh_update timestamp
);

comment on table catalogos.lista_negra is 'Usuarios a los que se deshabilita la opción de "otro,cual?"';

alter table catalogos.lista_negra owner to dba;

create index lista_negra_id_activo_index
    on catalogos.lista_negra (id_activo);

create index lista_negra_id_entrevistador_index
    on catalogos.lista_negra (id_entrevistador);

create unique index lista_negra_id_entrevistador_uindex
    on catalogos.lista_negra (id_entrevistador);

