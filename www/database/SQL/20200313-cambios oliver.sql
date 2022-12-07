alter table seguimiento_problema
    add id_activo int default 1;

create index seguimiento_problema_id_activo_index
    on seguimiento_problema (id_activo);
