-- Tipo de entrevista
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 1, 'Mis Casos', 'MC', null, 12, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
-- Tipo de objeto en la traza de seguridad
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (22, 15, 'Mis Casos', DEFAULT);
-- SEcciones para las pestañas del show
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (100, 'Secciones de mis casos', 'Para agrupar los documentos en pestañas', 1);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 100, 'Documentación', null, null, 1, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 100, 'Bibliografía', null, null, 2, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 100, 'Borradores', null, null, 3, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);

-- Tablas
create table esclarecimiento.mis_casos
(
	id_mis_casos serial not null
		constraint mis_casos_pk
			primary key,
	id_macroterritorio integer
		constraint mis_casos_cev_id_geo_fk
			references catalogos.cev
				on update cascade on delete restrict,
	id_territorio integer
		constraint mis_casos_cev_id_geo_fk_2
			references catalogos.cev,
	id_entrevistador integer
		constraint mis_casos_entrevistador_id_entrevistador_fk
			references esclarecimiento.entrevistador
				on update cascade on delete restrict,
	entrevista_correlativo integer,
	entrevista_numero integer,
	entrevista_codigo varchar(20),
	nombre text,
	descripcion text,
	id_activo integer default 1,
	fts text,
	id_usuario integer
		constraint mis_casos_users_id_fk
			references users
				on update cascade on delete restrict,
	created_at timestamp default now(),
	updated_at timestamp
);

comment on table esclarecimiento.mis_casos is 'Tabla para casos de investigación';

comment on column esclarecimiento.mis_casos.id_activo is 'Para el softdelete. cualquier valor distinto a 1 se considera como borrado';

comment on column esclarecimiento.mis_casos.fts is 'Datos para el full text search';

alter table esclarecimiento.mis_casos owner to dba;

create index mis_casos_entrevista_codigo_index
	on esclarecimiento.mis_casos (entrevista_codigo);

create index mis_casos_entrevista_correlativo_index
	on esclarecimiento.mis_casos (entrevista_correlativo);

create index mis_casos_entrevista_numero_index
	on esclarecimiento.mis_casos (entrevista_numero);

create table esclarecimiento.mis_casos_adjunto
(
	id_mis_casos_adjunto serial not null
		constraint mis_casos_adjunto_pk
			primary key,
	id_mis_casos integer not null
		constraint mis_casos_adjunto_mis_casos_id_mis_casos_fk
			references esclarecimiento.mis_casos
				on update cascade on delete cascade,
	id_seccion integer
		constraint mis_casos_adjunto_cat_item_id_item_fk
			references catalogos.cat_item
				on update cascade on delete restrict,
	descripcion varchar(200) not null,
	id_adjunto integer not null
		constraint mis_casos_adjunto_adjunto_id_adjunto_fk
			references esclarecimiento.adjunto
				on update cascade on delete restrict,
	fh_insert timestamp default now()
);

comment on table esclarecimiento.mis_casos_adjunto is 'Adjuntos a Mis Casos';

comment on column esclarecimiento.mis_casos_adjunto.id_seccion is 'Catalogo 100';

alter table esclarecimiento.mis_casos_adjunto owner to dba;

create index mis_casos_adjunto_descripcion_index
	on esclarecimiento.mis_casos_adjunto (descripcion);

create index mis_casos_adjunto_id_adjunto_index
	on esclarecimiento.mis_casos_adjunto (id_adjunto);

create index mis_casos_adjunto_id_mis_casos_index
	on esclarecimiento.mis_casos_adjunto (id_mis_casos);

create index mis_casos_adjunto_id_seccion_index
	on esclarecimiento.mis_casos_adjunto (id_seccion);



create index mis_casos_id_activo_index
	on esclarecimiento.mis_casos (id_activo);

create index mis_casos_id_entrevistador_index
	on esclarecimiento.mis_casos (id_entrevistador);

create index mis_casos_id_macroterritorio_index
	on esclarecimiento.mis_casos (id_macroterritorio);

create index mis_casos_id_territorio_index
	on esclarecimiento.mis_casos (id_territorio);

create index mis_casos_id_usuario_index
	on esclarecimiento.mis_casos (id_usuario);

create index mis_casos_nombre_index
	on esclarecimiento.mis_casos (nombre);

drop index esclarecimiento.mis_casos_entrevista_codigo_index;

create unique index mis_casos_entrevista_codigo_uindex
	on esclarecimiento.mis_casos (entrevista_codigo);

-- Actualizar .env
select * from catalogos.cat_item
    where id_cat=1
    order by id_item desc;


-- Cambios 15-jun
update catalogos.cat_item
    set abreviado='CT'
    where id_cat=1 and abreviado='MC';

update catalogos.cat_item
    set descripcion='Casos Transversales'
    where id_cat=1 and abreviado='CT';

INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (101, 'Tipo de víctima en casos transversales', 'Para clasificar los casos transversales', DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 101, 'Individual', null, null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 101, 'Colectivo', null, null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 101, 'Sujeto Colectivo', null, null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);

INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (102, 'Ambito territorial', 'Usado en casos transversales', DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 102, 'Internacional', null, null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 102, 'Nacional', null, null, DEFAULT, 1, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 102, 'Regional', null, null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 102, 'Departamental', null, null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 102, 'Municipal', null, null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);

alter table esclarecimiento.mis_casos
	add id_tipo_victima int;

comment on column esclarecimiento.mis_casos.id_tipo_victima is 'id_cat=101';

alter table esclarecimiento.mis_casos
	add anyo_inicio int;

alter table esclarecimiento.mis_casos
	add anyo_fin int;

alter table esclarecimiento.mis_casos
	add id_ambito int;

comment on column esclarecimiento.mis_casos.id_ambito is 'id_cat=102';

alter table esclarecimiento.mis_casos
	add territorio text;

alter table esclarecimiento.mis_casos
	add investigacion_judicial text;

alter table esclarecimiento.mis_casos
	add medidas_reparacion text;

create index mis_casos_id_ambito_index
	on esclarecimiento.mis_casos (id_ambito);

create index mis_casos_id_tipo_victima_index
	on esclarecimiento.mis_casos (id_tipo_victima);

alter table esclarecimiento.mis_casos
	add constraint mis_casos_cat_item_id_item_fk
		foreign key (id_tipo_victima) references catalogos.cat_item (id_item)
			on update cascade on delete restrict;

alter table esclarecimiento.mis_casos
	add constraint mis_casos_cat_item_id_item_fk_2
		foreign key (id_ambito) references catalogos.cat_item (id_item)
			on update cascade on delete restrict;

alter table esclarecimiento.mis_casos
	add id_cerrado int default 2;

comment on column esclarecimiento.mis_casos.id_cerrado is '1:cerrado; el resto de valores se considera abierto';

create index mis_casos_id_cerrado_index
	on esclarecimiento.mis_casos (id_cerrado);

alter table esclarecimiento.mis_casos
	add observaciones text;


-- to-do
create table esclarecimiento.mis_casos_tareas
(
	id_mis_casos_tareas serial
		constraint mis_casos_tareas_pk
			primary key,
	id_mis_casos int,
	descripcion text not null,
	realizado int default 2,
	id_activo int default 1,
	fh_insert timestamp default now(),
	fh_update timestamp
);

comment on table esclarecimiento.mis_casos_tareas is 'To-do para mis casos';

comment on column esclarecimiento.mis_casos_tareas.realizado is '1:Sí;  cualquier otra cosa, NO';

comment on column esclarecimiento.mis_casos_tareas.id_activo is 'Softdelete;  1: se muestra; cualquier otra cosa se considera borrado';

create index mis_casos_tareas_descripcion_index
	on esclarecimiento.mis_casos_tareas (descripcion);

create index mis_casos_tareas_id_activo_index
	on esclarecimiento.mis_casos_tareas (id_activo);

create index mis_casos_tareas_realizado_index
	on esclarecimiento.mis_casos_tareas (realizado);

create table esclarecimiento.mis_casos_detalle
(
	id_mis_casos_detalle serial not null
		constraint mis_casos_detalle_pk
			primary key,
	id_mis_casos integer
		constraint mis_casos_detalle_mis_casos_id_mis_casos_fk
			references esclarecimiento.mis_casos
				on update cascade on delete restrict,
	id_detalle integer
		constraint mis_casos_detalle_cat_item_id_item_fk
			references catalogos.cat_item
				on update cascade on delete restrict,
	insert_fh timestamp
);

comment on table esclarecimiento.mis_casos_detalle is 'Tabla para tipos de violencia, fuerzas responsables, tereceros civiles y cualquier listado simple que apunte a cat_item ';

alter table esclarecimiento.mis_casos_detalle owner to dba;

create index mis_casos_tv_id_item_index
	on esclarecimiento.mis_casos_detalle (id_detalle);

create unique index mis_casos_tv_id_mis_casos_id_item_uindex
	on esclarecimiento.mis_casos_detalle (id_mis_casos, id_detalle);

create index mis_casos_tv_id_mis_casos_index
	on esclarecimiento.mis_casos_detalle (id_mis_casos);

--
create table esclarecimiento.mis_casos_persona
(
	id_mis_casos_persona serial not null
		constraint mis_casos_persona_pk
			primary key,
	id_mis_casos integer not null
		constraint mis_casos_persona_mis_casos_id_mis_casos_fk
			references esclarecimiento.mis_casos
				on update cascade on delete cascade,
	nombre varchar(100) not null,
	id_sexo integer
		constraint mis_casos_persona_cat_item_id_item_fk
			references catalogos.cat_item
				on update cascade on delete restrict,
	contacto text,
	id_contactado integer default 2,
	id_entrevistado integer default 2,
	id_subserie integer,
	id_entrevista integer,
	anotaciones text,
	fh_insert timestamp default now(),
	fh_update timestamp,
	id_activo integer default 1
);

comment on table esclarecimiento.mis_casos_persona is 'Personas a ser entrevistadas';

comment on column esclarecimiento.mis_casos_persona.id_sexo is 'catalogo 24';

comment on column esclarecimiento.mis_casos_persona.id_contactado is 'ya fue contactado?';

comment on column esclarecimiento.mis_casos_persona.id_entrevistado is 'ya fue entrevistado?';

comment on column esclarecimiento.mis_casos_persona.id_activo is 'softdelete; 1:activo, otro valor=borrado';

alter table esclarecimiento.mis_casos_persona owner to dba;

create index mis_casos_persona_id_contactado_index
	on esclarecimiento.mis_casos_persona (id_contactado);

create index mis_casos_persona_id_entrevistado_index
	on esclarecimiento.mis_casos_persona (id_entrevistado);

create index mis_casos_persona_id_sexo_index
	on esclarecimiento.mis_casos_persona (id_sexo);

create index mis_casos_persona_id_subserie_id_entrevista_index
	on esclarecimiento.mis_casos_persona (id_subserie, id_entrevista);

create index mis_casos_persona_nombre_index
	on esclarecimiento.mis_casos_persona (nombre);

create index mis_casos_persona_id_activo_index
	on esclarecimiento.mis_casos_persona (id_activo);

