INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion) VALUES (75, 'tipos de problema en seguimiento de transcriptores','Usado en seguimiento_problema');
INSERT INTO catalogos.cat_item (id_cat, descripcion) VALUES (75, 'Archivos duplicados');
INSERT INTO catalogos.cat_item (id_cat, descripcion) VALUES (75, 'Calidad técnica');
INSERT INTO catalogos.cat_item (id_cat, descripcion) VALUES (75, 'Consentimiento informado');
INSERT INTO catalogos.cat_item (id_cat, descripcion) VALUES (75, 'Faltan archivos');
INSERT INTO catalogos.cat_item (id_cat, descripcion) VALUES (75, 'Se propone unir la entrevista con otra');
INSERT INTO catalogos.cat_item (id_cat, descripcion) VALUES (75, 'Se propone cambiar el tipo de entrevista a otra');



insert into catalogos.criterio_fijo_grupo (id_grupo,descripcion) values (25,'Priorización - fluidez');
insert into catalogos.criterio_fijo_grupo (id_grupo,descripcion) values (26,'Priorización - detalle');


insert into catalogos.criterio_fijo (id_grupo,id_opcion,descripcion) values (25,1,'Sí');
insert into catalogos.criterio_fijo (id_grupo,id_opcion,descripcion) values (25,0,'No');

insert into catalogos.criterio_fijo (id_grupo,id_opcion,descripcion) values (26,1,'1. Hace mención');
insert into catalogos.criterio_fijo (id_grupo,id_opcion,descripcion) values (26,2,'2. Detalle bajo');
insert into catalogos.criterio_fijo (id_grupo,id_opcion,descripcion) values (26,3,'3. Describe datos mínimos');
insert into catalogos.criterio_fijo (id_grupo,id_opcion,descripcion) values (26,4,'4. Detalle de la información alto');
insert into catalogos.criterio_fijo (id_grupo,id_opcion,descripcion) values (26,5,'5. Ofrece explicaciones');

-- Tablas nuevas
create table procesamiento_tiempo
(
	id_procesamiento_tiempo serial not null
		constraint procesamiento_tiempo_pk
			primary key,
	id_entrevista integer not null,
	id_subserie integer not null,
	id_tipo_medicion integer default 1 not null,
	tiempo_minutos integer default 0 not null,
	id_transcribir_asignacion integer,
	id_etiquetar_asignacion integer
);

comment on table procesamiento_tiempo is 'Tiempo consumido en el procesamiento';

comment on column procesamiento_tiempo.id_tipo_medicion is 'transcripcion, etiquetado, diligenciada';

alter table procesamiento_tiempo owner to dba;

create index procesamiento_tiempo_id_tipo_medicion_index
	on procesamiento_tiempo (id_tipo_medicion);

create unique index procesamiento_tiempo_id_entrevista_id_subserie_id_tipo_medicion
	on procesamiento_tiempo (id_entrevista, id_subserie, id_tipo_medicion);

create table seguimiento
(
	id_seguimiento serial not null
		constraint seguimiento_pk
			primary key,
	id_entrevista integer not null,
	id_subserie integer not null,
	id_entrevistador integer
		constraint seguimiento_entrevistador_id_entrevistador_fk
			references esclarecimiento.entrevistador
				on update restrict on delete restrict,
	id_cerrado integer default 2,
	anotaciones text,
	fecha_hora timestamp default now()
);

comment on table seguimiento is 'Seguimiento a las entrevistas';

alter table seguimiento owner to dba;

create index seguimiento_id_cerrado_index
	on seguimiento (id_cerrado);

create index seguimiento_id_entrevista_index
	on seguimiento (id_entrevista);

create index seguimiento_id_entrevistador_index
	on seguimiento (id_entrevistador);

create index seguimiento_id_subserie_index
	on seguimiento (id_subserie);

create table seguimiento_problema
(
	id_seguimiento_problema serial not null
		constraint seguimiento_problema_pk
			primary key,
	id_seguimiento integer
		constraint seguimiento_problema_seguimiento_id_seguimiento_fk
			references seguimiento
				on update restrict on delete restrict,
	id_tipo_problema integer
		constraint seguimiento_problema_cat_item_id_item_fk
			references catalogos.cat_item
				on update restrict on delete restrict,
	descripcion text
);

comment on table seguimiento_problema is 'Problemas detectados por los transcriptores';

alter table seguimiento_problema owner to dba;

create index seguimiento_problema_id_seguimiento_index
	on seguimiento_problema (id_seguimiento);

create index seguimiento_problema_id_tipo_problema_index
	on seguimiento_problema (id_tipo_problema);


