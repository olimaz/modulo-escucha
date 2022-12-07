-- territorios
INSERT INTO "catalogos"."criterio_fijo_grupo" ("id_grupo", "descripcion") VALUES (6, 'Clasificacion territorios');
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (6, 1, 'Casa', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (6, 2, 'Enlace', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (6, 3, 'Equipo', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (6, 4, 'Oficina macroterritorial', DEFAULT);
-- cambios menores
alter table esclarecimiento.entrevistador alter column id_nivel set default 99;
DELETE FROM "catalogos"."geo" WHERE "id_geo" = 9182;

-- tabla de territorios
create table catalogos.cev
(
    id_geo      serial            not null
        constraint cev_pk
        primary key,
    id_padre    integer,
    nivel       integer default 0 not null,
    descripcion varchar(100)      not null,
    id_tipo     integer,
    codigo      varchar(10)
);

comment on table catalogos.cev is 'Catálogo de territorios multinivel, igual a geo';
comment on column catalogos.cev.id_tipo is 'criterio fijo 6';

alter table catalogos.cev
    owner to dba;

-- macros

ALTER SEQUENCE catalogos.cev_id_geo_seq RESTART WITH 100;
-- macros
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Caribe Insular','CI');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Antioquia y Eje Cafetero','AE');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Pacífico ','PA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Magadalena Medio','MM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Nororiente ','NO');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Bogotá ','BS');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Centroandina ','CA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Surandina ','SU');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Orinoquia ','OR');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Amazonia ','AM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Internacional','IN');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Dirección de territorios','DT');
-- oficinas de macros
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,4,'Macroterritorial Caribe Insular','CI');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,4,'Macroterritorial Antioquia y Eje Cafetero','AE');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,4,'Macroterritorial Pacífico ','PA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,4,'Macroterritorial Magadalena Medio','MM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,4,'Macroterritorial Nororiente ','NO');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,4,'Macroterritorial Bogotá ','BS');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,4,'Macroterritorial Centroandina ','CA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,4,'Macroterritorial Surandina ','SU');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,4,'Macroterritorial Orinoquia ','OR');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,4,'Macroterritorial Amazonia ','AM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,4,'Macroterritorial Internacional','IN');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,4,'Dirección de territorios','DT');
-- territorios
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Santa Marta ','CI');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Barranquilla ','CI');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Valledupar ','CI');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Sincelejo ','CI');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Monteria ','CI');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Apartadó ','AE');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Medellín ','AE');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Pereira ','AE');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Quibdó ','PA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Buenaventura ','PA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Tumaco ','PA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Barrancabermeja ','MM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Aguachica','MM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'La Dorada ','MM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Cucuta ','NO');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Arauca ','NO');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Bucaramanga','NO');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Bogotá ','BS');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Ibagué ','CA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Tunja ','CA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Neiva','CA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Cali ','SU');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Popayán ','SU');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Puerto Asís ','SU');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Mocoa ','SU');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Pasto','SU');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Villavicencio ','OR');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'San José del Guaviare','OR');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,1,'Florencia ','OR');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Yopal ','OR');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Inirida ','AM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,3,'Europa','IN');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,3,'Equipos Móviles','DT');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,3,'Equipo Étnico','DT');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Equipo Nacional / Sede Central','SC');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,4,'Macroterritorial Equipo Nacional / Sede Central','SC');
-- Actualizar id_padre
update catalogos.cev as hijo
set id_padre =padre.id_geo
    from catalogos.cev as padre
where hijo.codigo = padre.codigo
    and hijo.nivel=2 and hijo.id_padre is null;

-- por si acaso
update catalogos.cev set descripcion=trim(descripcion);


-- Equivalencias
update catalogos.cat_item
set texto = id_geo
    from catalogos.cev
where id_cat=3 and trim(abreviado)=trim(codigo) and id_tipo=4;

-- Actualizar entrevistadores
alter table esclarecimiento.entrevistador
    add id_territorio int;

create index entrevistador_id_territorio_index
    on esclarecimiento.entrevistador (id_territorio);

alter table esclarecimiento.entrevistador
    add constraint entrevistador_cev_id_geo_fk
        foreign key (id_territorio) references catalogos.cev
            on update cascade on delete restrict;

-- actualizar los entrevistadores
update esclarecimiento.entrevistador
set id_territorio = texto::integer
from catalogos.cat_item
where id_macroterritorio=id_item;

update esclarecimiento.entrevistador
set id_macroterritorio=id_padre
    from catalogos.cev
where id_territorio=id_geo;


-- Actualizar las entrevistas
alter table esclarecimiento.e_ind_fvt
    add id_territorio int;

create index e_ind_fvt_id_territorio_index
    on esclarecimiento.e_ind_fvt (id_territorio);


alter table esclarecimiento.e_ind_fvt
    add constraint e_ind_fvt_cev_id_geo_fk
        foreign key (id_territorio) references catalogos.cev
            on update cascade on delete restrict;

-- actualizar las entrevistas
update esclarecimiento.e_ind_fvt
set id_territorio = texto::integer
from catalogos.cat_item
where id_macroterritorio=id_item;

alter table esclarecimiento.e_ind_fvt drop constraint e_ind_fvt_cat_item_id_item_fk;

update esclarecimiento.e_ind_fvt
set id_macroterritorio=id_padre
    from catalogos.cev
where id_territorio=id_geo;

alter table esclarecimiento.e_ind_fvt
    add constraint e_ind_fvt_cev_id_geo_fk_2
        foreign key (id_macroterritorio) references catalogos.cev
            on update cascade on delete restrict;


-- Cambiar la tabla de casos e informes
alter table esclarecimiento.casos_informes
    add id_territorio int;

create index casos_informes_id_territorio_index
    on esclarecimiento.casos_informes (id_territorio);

alter table esclarecimiento.casos_informes
    add constraint casos_informes_cev_id_geo_fk
        foreign key (id_macroterritorio) references catalogos.cev;

alter table esclarecimiento.casos_informes
    add constraint casos_informes_cev_id_geo_fk_2
        foreign key (id_territorio) references catalogos.cev;


-- Criterio fijo: nuevo perfil
UPDATE "catalogos"."criterio_fijo" SET "id_opcion" = 5 WHERE "id_grupo" = 4 AND "id_opcion" = 4;
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (4, 4, 'Coordinador/a de territorio', DEFAULT)






