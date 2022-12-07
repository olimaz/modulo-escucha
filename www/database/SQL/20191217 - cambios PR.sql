-- Ojo buscar el id_item correspondiente
select *
from catalogos.cat_item
where id_cat=33;
--Actualizarlo a nivel 2
update esclarecimiento.entrevista_profundidad
set clasificacion_nivel=2
where id_remitido=258;



-- Catálogos de rangos de c/fuerza
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (230, 'Rango, policía', 'Metadatos PR', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (231, 'Rango, paramilitar', 'Metadatos PR', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (232, 'Rango, guerrilla', 'Metadatos PR', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (233, 'Rango, fuerza aérea', 'Metadatos PR', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (234, 'Rango, fuerza naval', 'Metadatos PR', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (235, 'Rango, ejército', 'Metadatos PR', 1);

insert into catalogos.cat_item (id_cat,descripcion) values (230,'Subteniente');
insert into catalogos.cat_item (id_cat,descripcion) values (231,'Comandante');
insert into catalogos.cat_item (id_cat,descripcion) values (232,'Comandante');
insert into catalogos.cat_item (id_cat,descripcion) values (233,'Subteniente');
insert into catalogos.cat_item (id_cat,descripcion) values (234,'Subteniente');
insert into catalogos.cat_item (id_cat,descripcion) values (235,'Subteniente');

--Tipo de entrevista a profunidad
INSERT INTO "catalogos"."criterio_fijo_grupo" ("id_grupo", "descripcion") VALUES (15, 'Tipos de entrevista a profundidad');
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (15, 1, 'Experto / Testigo', 1);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (15, 2, 'Calidad múltiple: víctima y AA/TC/AE', 2);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (15, 3, 'Familiar de ex combatiente', 3);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (15, 4, 'Entrevista solicitada públicamente', 4);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (15, 5, 'COMPARECIENTE: miembro de Actor Armado (AA), Tercero Civil (TC) o Agente del Estado (AE). ', 5);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (15, 6, 'No compareciente: miembro de Actor Armado (AA), Tercero Civil (TC) o Agente del Estado (AE). ', 6);

-- Detalle de violencia sufrida
create table esclarecimiento.entrevista_profundidad_violencia_victima
(
	id_entrevista_profundidad_violencia_victima serial not null
		constraint entrevista_profundidad_violencia_victima_pk
			primary key,
	id_entrevista_profundidad         integer not null
        constraint entrevista_profundidad_violencia_victima_id_entrevista_pr
            references esclarecimiento.entrevista_profundidad
            on update cascade on delete cascade,
	id_violencia integer not null
		constraint entrevista_profundidad_violencia_victima_cat_item_id_item_fk
			references catalogos.cat_item
				on update restrict on delete restrict
);

comment on table esclarecimiento.entrevista_profundidad_violencia_victima is 'Tipos de violencia mencionados por las víctimas ';

comment on column esclarecimiento.entrevista_profundidad_violencia_victima.id_violencia is 'Catalogo 5';

alter table esclarecimiento.entrevista_profundidad_violencia_victima owner to dba;

create index entrevista_profundidad_violencia_victima_id_entrevista_profundidad_index
	on esclarecimiento.entrevista_profundidad_violencia_victima (id_entrevista_profundidad);

create index entrevista_profundidad_violencia_victima_id_violencia_index
	on esclarecimiento.entrevista_profundidad_violencia_victima (id_violencia);


--Detalle de violencia asumida
create table esclarecimiento.entrevista_profundidad_violencia_actor
(
	id_entrevista_profundidad_violencia_actor serial not null
		constraint entrevista_profundidad_violencia_actor_pk
			primary key,
	id_entrevista_profundidad         integer not null
        constraint entrevista_profundidad_violencia_actor_id_entrevista_pr
            references esclarecimiento.entrevista_profundidad
            on update cascade on delete cascade,
	id_violencia integer not null
		constraint entrevista_profundidad_violencia_actor_cat_item_id_item_fk
			references catalogos.cat_item
				on update restrict on delete restrict
);

comment on table esclarecimiento.entrevista_profundidad_violencia_actor is 'Tipos de violencia mencionados por las víctimas ';

comment on column esclarecimiento.entrevista_profundidad_violencia_actor.id_violencia is 'Catalogo 5';

alter table esclarecimiento.entrevista_profundidad_violencia_actor owner to dba;

create index entrevista_profundidad_violencia_actor_id_entrevista_profundidad_index
	on esclarecimiento.entrevista_profundidad_violencia_actor (id_entrevista_profundidad);

create index entrevista_profundidad_violencia_actor_id_violencia_index
	on esclarecimiento.entrevista_profundidad_violencia_actor (id_violencia);

-- Cambios a la tabla principal
alter table esclarecimiento.entrevista_profundidad
	add id_tipo int default 1;

comment on column esclarecimiento.entrevista_profundidad.id_tipo is 'Tipo de entrevista, criterio fijo 15';

alter table esclarecimiento.entrevista_profundidad
	add id_policia_parte int default 2;

comment on column esclarecimiento.entrevista_profundidad.id_policia_parte is 's/n';

alter table esclarecimiento.entrevista_profundidad
	add id_policia_rango int;

comment on column esclarecimiento.entrevista_profundidad.id_policia_rango is 'catalogo 230';

alter table esclarecimiento.entrevista_profundidad
	add id_paramilitar_parte int default 2;

comment on column esclarecimiento.entrevista_profundidad.id_paramilitar_parte is 'si/no';

alter table esclarecimiento.entrevista_profundidad
	add id_paramilitar_rango int;

comment on column esclarecimiento.entrevista_profundidad.id_paramilitar_rango is 'Catalogo 231';

alter table esclarecimiento.entrevista_profundidad
	add id_guerrilla_parte int default 2;

comment on column esclarecimiento.entrevista_profundidad.id_guerrilla_parte is 'Si/No';

alter table esclarecimiento.entrevista_profundidad
	add id_guerrilla_rango int;

comment on column esclarecimiento.entrevista_profundidad.id_guerrilla_rango is 'Catalogo 232';

alter table esclarecimiento.entrevista_profundidad
	add id_ejercito_parte int default 2;

comment on column esclarecimiento.entrevista_profundidad.id_ejercito_parte is 'Si/No';

alter table esclarecimiento.entrevista_profundidad
	add id_ejercito_rango int;

comment on column esclarecimiento.entrevista_profundidad.id_ejercito_rango is 'Catalogo 235';

alter table esclarecimiento.entrevista_profundidad
	add id_fuerza_aerea_parte int default 2;

comment on column esclarecimiento.entrevista_profundidad.id_fuerza_aerea_parte is 'Si/No';

alter table esclarecimiento.entrevista_profundidad
	add id_fuerza_aerea_rango int;

comment on column esclarecimiento.entrevista_profundidad.id_fuerza_aerea_rango is 'Catalogo 233';

alter table esclarecimiento.entrevista_profundidad
	add id_fuerza_naval_parte int default 2;

comment on column esclarecimiento.entrevista_profundidad.id_fuerza_naval_parte is 'Si/No';

alter table esclarecimiento.entrevista_profundidad
	add id_fuerza_naval_rango int;

comment on column esclarecimiento.entrevista_profundidad.id_fuerza_naval_rango is 'Catalogo 234';

alter table esclarecimiento.entrevista_profundidad
	add id_tercero_civil_parte int default 2;

comment on column esclarecimiento.entrevista_profundidad.id_tercero_civil_parte is 'Si/No';

alter table esclarecimiento.entrevista_profundidad
	add id_tercero_civil_cual varchar(200);

alter table esclarecimiento.entrevista_profundidad
	add id_agente_estado_parte int default 2;

comment on column esclarecimiento.entrevista_profundidad.id_agente_estado_parte is 'Si/No';

alter table esclarecimiento.entrevista_profundidad
	add id_agente_estado_cual varchar(200);

-- indices
create index entrevista_profundidad_id_agente_estado_cual_index
	on esclarecimiento.entrevista_profundidad (id_agente_estado_cual);

create index entrevista_profundidad_id_agente_estado_parte_index
	on esclarecimiento.entrevista_profundidad (id_agente_estado_parte);

create index entrevista_profundidad_id_ejercito_parte_index
	on esclarecimiento.entrevista_profundidad (id_ejercito_parte);

create index entrevista_profundidad_id_ejercito_rango_index
	on esclarecimiento.entrevista_profundidad (id_ejercito_rango);

create index entrevista_profundidad_id_fuerza_aerea_parte_index
	on esclarecimiento.entrevista_profundidad (id_fuerza_aerea_parte);

create index entrevista_profundidad_id_fuerza_aerea_rango_index
	on esclarecimiento.entrevista_profundidad (id_fuerza_aerea_rango);

create index entrevista_profundidad_id_fuerza_naval_parte_index
	on esclarecimiento.entrevista_profundidad (id_fuerza_naval_parte);

create index entrevista_profundidad_id_fuerza_naval_rango_index
	on esclarecimiento.entrevista_profundidad (id_fuerza_naval_rango);

create index entrevista_profundidad_id_guerrilla_parte_index
	on esclarecimiento.entrevista_profundidad (id_guerrilla_parte);

create index entrevista_profundidad_id_guerrilla_rango_index
	on esclarecimiento.entrevista_profundidad (id_guerrilla_rango);

create index entrevista_profundidad_id_paramilitar_parte_index
	on esclarecimiento.entrevista_profundidad (id_paramilitar_parte);

create index entrevista_profundidad_id_paramilitar_rango_index
	on esclarecimiento.entrevista_profundidad (id_paramilitar_rango);

create index entrevista_profundidad_id_policia_parte_index
	on esclarecimiento.entrevista_profundidad (id_policia_parte);

create index entrevista_profundidad_id_policia_rango_index
	on esclarecimiento.entrevista_profundidad (id_policia_rango);

create index entrevista_profundidad_id_tercero_civil_cual_index
	on esclarecimiento.entrevista_profundidad (id_tercero_civil_cual);

create index entrevista_profundidad_id_tercero_civil_parte_index
	on esclarecimiento.entrevista_profundidad (id_tercero_civil_parte);

create index entrevista_profundidad_id_tipo_index
	on esclarecimiento.entrevista_profundidad (id_tipo);

-- llaves foraneas
alter table esclarecimiento.entrevista_profundidad
	add constraint entrevista_profundidad_cat_item_id_item_fk_3
		foreign key (id_policia_rango) references catalogos.cat_item
			on update cascade on delete restrict;

alter table esclarecimiento.entrevista_profundidad
	add constraint entrevista_profundidad_cat_item_id_item_fk_4
		foreign key (id_paramilitar_rango) references catalogos.cat_item
			on update cascade on delete restrict;

alter table esclarecimiento.entrevista_profundidad
	add constraint entrevista_profundidad_cat_item_id_item_fk_5
		foreign key (id_guerrilla_rango) references catalogos.cat_item
			on update cascade on delete restrict;

alter table esclarecimiento.entrevista_profundidad
	add constraint entrevista_profundidad_cat_item_id_item_fk_6
		foreign key (id_ejercito_rango) references catalogos.cat_item
			on update cascade on delete restrict;

alter table esclarecimiento.entrevista_profundidad
	add constraint entrevista_profundidad_cat_item_id_item_fk_7
		foreign key (id_fuerza_aerea_rango) references catalogos.cat_item
			on update cascade on delete restrict;

alter table esclarecimiento.entrevista_profundidad
	add constraint entrevista_profundidad_cat_item_id_item_fk_8
		foreign key (id_fuerza_naval_rango) references catalogos.cat_item
			on update cascade on delete restrict;

-- Por si acaso: convertir en tipo 1 a todas
update esclarecimiento.entrevista_profundidad
set id_tipo=1
where id_remitido is null;

-- convertir a 'compareciente' todas las que son remitidas
update esclarecimiento.entrevista_profundidad
set id_tipo=5
where id_remitido is not null;


-- Cambio solicitado por Nohra
alter table sim.entrevista_victima
	add adjuntos text;

comment on column sim.entrevista_victima.adjuntos is 'JSON con ubicación de archivos adjuntos';












