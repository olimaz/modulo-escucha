create table sim.excel_asignaciones_etiquetado
(
	id serial not null
		constraint excel_asignaciones_etiquetado_pk
			primary key,
	id_asignacion integer,
	entrevista_tipo varchar(10),
	entrevista_codigo varchar(20),
	entrevista_duracion_minutos integer,
	entrevista_macroterritorio varchar(200),
	entrevista_territorio varchar(200),
	entrevista_entrevistador varchar(10),
	entrevista_entrevistador_grupo varchar(100),
	asignacion_quien_asigna_codigo varchar(10),
	asignacion_urgente varchar(10),
	asignacion_responsable_codigo varchar(10),
	asignacion_responsable_macroterritorio varchar(200),
	asignacion_responsable_territorio varchar(200),
	asignacion_responsable_grupo varchar(200),
	asignacion_responsable_perfil varchar(200),
	procesamiento_situacion varchar(200),
	procesamiento_porque_no varchar(200),
	procesamiento_observaciones text,
	fecha_asignado varchar(10),
	fecha_revocado varchar(10),
	fecha_procesado varchar(10),
	fecha_anulado varchar(10),
	tiempo_entrevista integer,
	tiempo_transcripcion integer,
	tiempo_etiquetado integer,
	tiempo_fichas integer
);

comment on table sim.excel_asignaciones_etiquetado is 'Tabla plana con datos de las asignaciones para etiquetar';

comment on column sim.excel_asignaciones_etiquetado.id_asignacion is 'Para rastrear a tabla original';

alter table sim.excel_asignaciones_etiquetado owner to dba;
GRANT SELECT ON sim.excel_asignaciones_etiquetado TO solo_lectura;

create table sim.excel_asignaciones_transcripcion
(
	id serial not null
		constraint excel_asignaciones_transcripcion_pk
			primary key,
	id_asignacion integer,
	entrevista_tipo varchar(10),
	entrevista_codigo varchar(20),
	entrevista_duracion_minutos integer,
	entrevista_macroterritorio varchar(200),
	entrevista_territorio varchar(200),
	entrevista_entrevistador varchar(10),
	entrevista_entrevistador_grupo varchar(100),
	asignacion_quien_asigna_codigo varchar(10),
	asignacion_urgente varchar(10),
	asignacion_responsable_codigo varchar(10),
	asignacion_responsable_macroterritorio varchar(200),
	asignacion_responsable_territorio varchar(200),
	asignacion_responsable_grupo varchar(200),
	asignacion_responsable_perfil varchar(200),
	procesamiento_situacion varchar(200),
	procesamiento_porque_no varchar(200),
	procesamiento_terceros varchar(10),
	procesamiento_observaciones text,
	fecha_asignado varchar(10),
	fecha_revocado varchar(10),
	fecha_procesado varchar(10),
	fecha_anulado varchar(10),
	tiempo_entrevista integer,
	tiempo_transcripcion integer,
	tiempo_etiquetado integer,
	tiempo_fichas integer
);

comment on table sim.excel_asignaciones_transcripcion is 'Tabla plana con datos de las asignaciones para transcribir';

comment on column sim.excel_asignaciones_transcripcion.id_asignacion is 'Para rastrear a tabla original';

alter table sim.excel_asignaciones_transcripcion owner to dba;
GRANT SELECT ON sim.excel_asignaciones_transcripcion TO solo_lectura;




