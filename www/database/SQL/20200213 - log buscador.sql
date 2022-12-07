create table traza_buscador
(
    id_traza_buscador serial,
    id_entrevistador int,
    texto_buscado text
);

alter table traza_buscador owner to dba;

create index traza_buscador_id_entrevistador_index
    on traza_buscador (id_entrevistador);

create index traza_buscador_texto_buscado_index
    on traza_buscador (texto_buscado);

alter table traza_buscador
    add fecha_hora timestamp default current_timestamp;