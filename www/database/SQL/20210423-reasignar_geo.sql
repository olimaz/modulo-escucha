create table catalogos.geo_reasignar
(
    id_geo_reasignar serial
        constraint geo_reasignar_pk
            primary key,
    esquema varchar(200),
    tabla varchar(200),
    campo varchar(200)
);

comment on table catalogos.geo_reasignar is 'Campos afectados por reasignacion de codigos geográficos';

create unique index geo_reasignar_esquema_tabla_campo_uindex
    on catalogos.geo_reasignar (esquema, tabla, campo);

alter table catalogos.geo_reasignar owner to dba;


-- Traza de seguridad
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (22, 31, 'Catalogo geografico', DEFAULT);

-- Campos a actualizar
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('esclarecimiento','casos_informes','entrega_id_geo');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('esclarecimiento','censo_archivos','id_geo');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('esclarecimiento','diagnostico_comunitario','entrevista_lugar');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('esclarecimiento','diagnostico_comunitario','tema_lugar');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('esclarecimiento','e_ind_fvt','entrevista_lugar');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('esclarecimiento','e_ind_fvt','hechos_lugar');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('esclarecimiento','entrevista_colectiva','entrevista_lugar');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('esclarecimiento','entrevista_colectiva','tema_lugar');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('esclarecimiento','entrevista_etnica','entrevista_lugar');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('esclarecimiento','entrevista_etnica','tema_lugar');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('esclarecimiento','entrevista_profundidad','entrevista_lugar');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('esclarecimiento','excel_personas_entrevistadas','id_entrevista_lugar');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('esclarecimiento','historia_vida','entrevista_lugar');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('fichas','exilio_movimiento','id_lugar_llegada');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('fichas','exilio_movimiento','id_lugar_llegada_2');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('fichas','exilio_movimiento','id_lugar_salida');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('fichas','hecho','id_lugar');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('fichas','hecho_victima','id_lugar_residencia');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('fichas','hecho_violencia','id_lugar_llegada');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('fichas','hecho_violencia','id_lugar_llegada_2');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('fichas','hecho_violencia','id_lugar_salida');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('fichas','persona','id_lugar_nacimiento');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('fichas','persona','id_lugar_nacimiento_depto');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('fichas','persona','id_lugar_residencia');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('fichas','persona','id_lugar_residencia_depto');
insert into catalogos.geo_reasignar(esquema,tabla,campo) values ('fichas','persona','id_lugar_residencia_muni');