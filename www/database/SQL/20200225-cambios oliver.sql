alter table esclarecimiento.entrevista_profundidad
    add id_activo int default 1 not null;

create index entrevista_profundidad_id_activo_index
    on esclarecimiento.entrevista_profundidad (id_activo);
