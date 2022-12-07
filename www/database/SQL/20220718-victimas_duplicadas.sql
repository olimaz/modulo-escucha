alter table fichas.victima
    add id_duplicado int default null;

create index victima_id_duplicado_index
    on fichas.victima (id_duplicado);


-- Default
update fichas.victima set id_duplicado=id_victima;
