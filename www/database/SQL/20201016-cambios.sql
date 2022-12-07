alter table traza_actividad
    add id_personificador int;

comment on column traza_actividad.id_personificador is 'Registra cuando un administrador actúa a nombre de otro usuario';

create index traza_actividad_id_personificador_index
    on traza_actividad (id_personificador);

-- Traza
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (21, 25, 'Actuar a nombre de otro usuario: inicio', DEFAULT);
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (21, 26, 'Actuar a nombre de otro usuario: fin', DEFAULT);
