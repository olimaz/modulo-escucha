drop table if exists esclarecimiento.casos_informes_geo;
create table esclarecimiento.casos_informes_geo
(
    id_casos_informes_geo serial
        constraint casos_informes_geo_pk
            primary key,
    id_casos_informes integer
        constraint casos_informes_geo_casos_informes_id_casos_informes_fk
            references esclarecimiento.casos_informes
            on update cascade on delete cascade,
    id_geo integer
        constraint casos_informes_geo_geo_id_geo_fk
            references catalogos.geo
            on update cascade on delete restrict,
    insert_fh timestamp with time zone default now(),
    insert_id_entrevistador integer
        constraint casos_informes_geo_entrevistador_id_entrevistador_fk
            references esclarecimiento.entrevistador
            on update cascade on delete restrict
);

comment on table esclarecimiento.casos_informes_geo is 'Opciones para cobertura geográfica';
comment on column esclarecimiento.casos_informes_geo.id_casos_informes is 'Llave foranea a casos e informes';
comment on column esclarecimiento.casos_informes_geo.id_geo is 'llave foranea a catalogo geográfico';
comment on column esclarecimiento.casos_informes_geo.insert_fh is 'Marca de fecha y hora en que se agregó el dato';
comment on column esclarecimiento.casos_informes_geo.insert_id_entrevistador is 'Registro del usuario que agregó el registro';
alter table esclarecimiento.casos_informes_geo owner to dba;
create unique index casos_informes_geo_id_casos_informes_id_geo_uindex
    on esclarecimiento.casos_informes_geo (id_casos_informes, id_geo);
create index casos_informes_geo_insert_id_entrevistador_index
    on esclarecimiento.casos_informes_geo (insert_id_entrevistador);

