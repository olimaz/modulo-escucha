INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (22, 106, 'Seguimiento a entrevistas', DEFAULT);
create table sim.excel_seguimiento_entrevistas
(
	id serial not null
		constraint excel_seguimiento_entrevistas_pk
			primary key,
	id_seguimiento integer,
	id_seguimiento_problema integer,
	id_entrevistador integer,
	entrevistador_codigo varchar(10),
	codigo varchar(20),
	macroterritorio varchar(200),
	territorio varchar(200),
	grupo varchar(200),
	tipo_seguimiento varchar(200),
	descripcion text,
	puede_resolverse varchar(20),
	resolucion_sugerida text,
	ha_sido_resuelto varchar(20),
	anotaciones text,
	fecha_reportado varchar(50),
	fecha_resuelto varchar(50)
);

comment on table sim.excel_seguimiento_entrevistas is 'Tabla plana con los problemas reportados en entrevistas';

alter table sim.excel_seguimiento_entrevistas owner to dba;
GRANT SELECT ON sim.excel_seguimiento_entrevistas TO solo_lectura;

create index excel_seguimiento_entrevistas_codigo_index
	on sim.excel_seguimiento_entrevistas (codigo);

create index excel_seguimiento_entrevistas_entrevistador_codigo_index
	on sim.excel_seguimiento_entrevistas (entrevistador_codigo);

create index excel_seguimiento_entrevistas_id_entrevistador_index
	on sim.excel_seguimiento_entrevistas (id_entrevistador);

create index excel_seguimiento_entrevistas_id_seguimiento_index
	on sim.excel_seguimiento_entrevistas (id_seguimiento);

create index excel_seguimiento_entrevistas_id_seguimiento_problema_index
	on sim.excel_seguimiento_entrevistas (id_seguimiento_problema);

