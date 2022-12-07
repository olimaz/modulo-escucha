-- Cambios en tabla entrevistador
alter table esclarecimiento.entrevistador
    add compromiso_reserva int default 0;

create index entrevistador_compromiso_reserva_index
    on esclarecimiento.entrevistador (compromiso_reserva);


-- Tabla para registrar el compromiso
create table esclarecimiento.entrevistador_compromiso
(
    id_entrevistador_compromiso serial not null
        constraint entrevistador_compromiso_pk
            primary key,
    id_entrevistador integer not null
        constraint entrevistador_compromiso_entrevistador_id_entrevistador_fk
            references esclarecimiento.entrevistador
            on update cascade on delete cascade,
    fh_aceptacion timestamp with time zone default now() not null
);

comment on table esclarecimiento.entrevistador_compromiso is 'Registro de aceptación de compromiso de reserva de la información';

alter table esclarecimiento.entrevistador_compromiso owner to dba;

create index entrevistador_compromiso_fh_aceptacion_index
    on esclarecimiento.entrevistador_compromiso (fh_aceptacion);

create index entrevistador_compromiso_id_entrevistador_index
    on esclarecimiento.entrevistador_compromiso (id_entrevistador);

