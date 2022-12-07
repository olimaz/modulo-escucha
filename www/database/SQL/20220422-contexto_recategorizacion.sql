drop table if exists analitica.violencia_contexto;
create table if not exists analitica.violencia_contexto
(
    id serial
        constraint analitica_violencia_contexto_pk
            primary key,
    id_hecho integer,
    grupo text,
    contexto text,
    recategorizado text
);

alter table analitica.violencia_contexto owner to dba;

create index if not exists violencia_contexto_id_hecho_index
    on analitica.violencia_contexto (id_hecho);

grant select on analitica.violencia_contexto to solo_lectura;

