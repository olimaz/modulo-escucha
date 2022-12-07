-- campos para intercambio de datos
alter table sim.entrevista_victima
	add titulo_entrevista text;

alter table sim.entrevista_victima
	add sintesis_entrevista text;

-- Consentimiento informado en excel de entrevistas a victimas
alter table esclarecimiento.excel_entrevista_fvt
	add sintesis_relato text;

alter table esclarecimiento.excel_entrevista_fvt
	add ficha_priorizar_entrevista int default -99;

alter table esclarecimiento.excel_entrevista_fvt
	add ficha_priorizar_entrevista_asuntos text;

alter table esclarecimiento.excel_entrevista_fvt
	add ficha_contiene_patrones int default -99;

alter table esclarecimiento.excel_entrevista_fvt
	add ficha_contiene_patrones_cuales text;

alter table esclarecimiento.excel_entrevista_fvt
	add ci_conceder_entrevista int default -99;

alter table esclarecimiento.excel_entrevista_fvt
	add ci_grabar_audio int default -99;

alter table esclarecimiento.excel_entrevista_fvt
	add ci_elaborar_informe int default -99;

alter table esclarecimiento.excel_entrevista_fvt
	add ci_tratamiento_datos_analizar int default -99;

alter table esclarecimiento.excel_entrevista_fvt
	add ci_tratamiento_datos_analizar_sensible int default -99;

alter table esclarecimiento.excel_entrevista_fvt
	add ci_tratamiento_datos_utilizar int default -99;

alter table esclarecimiento.excel_entrevista_fvt
	add ci_tratamiento_datos_utilizar_sensible int default -99;

alter table esclarecimiento.excel_entrevista_fvt
	add ci_tratamiento_datos_publicar int default -99;

-- entrevistado
alter table esclarecimiento.excel_entrevista_fvt
	add persona_entrevistada_sexo text default '(No diligenciado)';

alter table esclarecimiento.excel_entrevista_fvt
	add persona_entrevistada_es_victima int default -99;
alter table esclarecimiento.excel_entrevista_fvt
	add persona_entrevistada_es_testigo int default -99;


-- Excel de personas entrevistadas
drop table if exists esclarecimiento.excel_ficha_persona_entrevistada;
create table esclarecimiento.excel_ficha_persona_entrevistada
(
	id_excel_ficha_persona_entrevistada serial
		constraint excel_ficha_persona_entrevistada_pk
			primary key,
	id_entrevista int,
	id_persona int,
	id_persona_entrevistada int,
	codigo_entrevista varchar(100),
	nombre text,
	apellido text,
	otros_nombres text,
	fec_nac_anio int,
	fec_nac_mes int,
	fec_nac_dia int,
	lugar_nac_codigo text,
	lugar_nac_n1 text,
	lugar_nac_n2 text,
	lugar_nac_n3 text,
	lugar_nac_n3_lat text,
	lugar_nac_n3_lon text,
	sexo varchar(200),
	orientacion_sexual varchar(200),
	identidad_genero varchar(200),
	pertenencia_etnica  varchar(200),
	pertenencia_indigena varchar(200),
	nacionalidad varchar(200),
	estado_civil varchar(200),
	educacion_formal varchar(200),
	lugar_residencia_codigo text,
	lugar_residencia_n1 text,
	lugar_residencia_n2 text,
	lugar_residencia_n3 text,
	lugar_residencia_n3_lat text,
	lugar_residencia_n3_lon text,
	lugar_residencia_zona varchar(200),
	profesion text,
	ocupacion_actual text,
	cargo_publico int,
	cargo_publico_cual text,
	fuerza_publica_miembro text,
	fuerza_publica_estado varchar(200),
	actor_armado_ilegal text,
	organizacion_colectivo_participa int,
	discapacidad text,
	es_victima int,
	es_testigo int,
	relato text
);

alter table esclarecimiento.excel_ficha_persona_entrevistada
owner to dba;

GRANT SELECT ON esclarecimiento.excel_ficha_persona_entrevistada TO solo_lectura;

create index excel_ficha_persona_entrevistada_id_entrevista_index
	on esclarecimiento.excel_ficha_persona_entrevistada (id_entrevista);

create index excel_ficha_persona_entrevistada_id_persona_entrevistada_index
	on esclarecimiento.excel_ficha_persona_entrevistada (id_persona_entrevistada);

create index excel_ficha_persona_entrevistada_id_persona_index
	on esclarecimiento.excel_ficha_persona_entrevistada (id_persona);


-- VICTIMA
drop table if exists esclarecimiento.excel_ficha_victima;
create table esclarecimiento.excel_ficha_victima
(
	id_excel_ficha_victima serial
		constraint excel_ficha_victima_pk
			primary key,
	id_entrevista int,
	id_persona int,
	id_victima int,
	codigo_entrevista varchar(100),
	nombre text,
	apellido text,
	otros_nombres text,
	fec_nac_anio int,
	fec_nac_mes int,
	fec_nac_dia int,
	lugar_nac_codigo text,
	lugar_nac_n1 text,
	lugar_nac_n2 text,
	lugar_nac_n3 text,
	lugar_nac_n3_lat text,
	lugar_nac_n3_lon text,
	sexo varchar(200),
	orientacion_sexual varchar(200),
	identidad_genero varchar(200),
	pertenencia_etnica  varchar(200),
	pertenencia_indigena varchar(200),
	nacionalidad varchar(200),
	estado_civil varchar(200),
	educacion_formal varchar(200),
	lugar_residencia_codigo text,
	lugar_residencia_n1 text,
	lugar_residencia_n2 text,
	lugar_residencia_n3 text,
	lugar_residencia_n3_lat text,
	lugar_residencia_n3_lon text,
	lugar_residencia_zona varchar(200),
	profesion text,
	ocupacion_actual text,
	cargo_publico int,
	cargo_publico_cual text,
	fuerza_publica_miembro text,
	fuerza_publica_estado varchar(200),
	actor_armado_ilegal text,
	organizacion_colectivo_participa int,
	discapacidad text
);

alter table esclarecimiento.excel_ficha_victima
owner to dba;

GRANT SELECT ON esclarecimiento.excel_ficha_victima TO solo_lectura;

create index excel_ficha_victima_id_entrevista_index
	on esclarecimiento.excel_ficha_victima (id_entrevista);

create index excel_ficha_victima_id_victima_index
	on esclarecimiento.excel_ficha_victima (id_victima);

create index excel_ficha_victima_id_persona_index
	on esclarecimiento.excel_ficha_victima (id_persona);







