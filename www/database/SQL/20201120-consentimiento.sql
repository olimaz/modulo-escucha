alter table fichas.entrevista
    add id_entrevista_profundidad int;

comment on column fichas.entrevista.id_entrevista_profundidad is 'Llave foranea a entrevista a profundidad';

alter table fichas.entrevista
    add id_historia_vida int;

comment on column fichas.entrevista.id_historia_vida is 'llave foranea a historia de vida';

create index entrevista_id_entrevista_profundidad_index
    on fichas.entrevista (id_entrevista_profundidad);

create index entrevista_id_historia_vida_index
    on fichas.entrevista (id_historia_vida);

alter table fichas.entrevista alter column id_idioma drop not null;

alter table fichas.entrevista alter column created_at set default now();

alter table fichas.entrevista alter column insert_fh set default now();


INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion) VALUES (22, 105, 'Consentimiento informado');