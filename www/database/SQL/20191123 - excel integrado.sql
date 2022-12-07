
-- Dinamicas
drop table if exists esclarecimiento.excel_entrevista_integrado;


create table esclarecimiento.excel_entrevista_integrado
(
	id serial not null
		constraint excel_entrevista_integrado_pkey
			primary key,
	personas_entrevistadas  integer default 1,
	tipo_entrevista    text,
	codigo_entrevista text,
	clasificacion integer default 3,
	macroterritorio text,
	territorio text,
	codigo_entrevistador text,
	grupo_entrevistador text,
	entrevista_fecha text,
	entrevista_mes text,
	tiempo_entrevista integer default 0,
	entrevista_lugar_n1 text,
	entrevista_lugar_n2 text,
	entrevista_lugar_n3 text,
	hechos_anio_del text,
	hechos_anio_al text,
	sector_entrevistado text,
	i_objetivo_esclarecimiento integer default 0,
	i_objetivo_reconocimiento integer default 0,
	i_objetivo_convivencia integer default 0,
	i_objetivo_no_repeticion integer default 0,
	i_enfoque_genero integer default 0,
	i_enfoque_psicosocial integer default 0,
	i_enfoque_curso_vida integer default 0,
	i_direccion_investigacion integer default 0,
	i_direccion_territorios integer default 0,
	i_direccion_etnica integer default 0,
	i_comisionados integer default 0,
	i_estrategia_arte integer default 0,
	i_estrategia_comunicacion integer default 0,
	i_estrategia_participacion integer default 0,
	i_estrategia_pedagogia integer default 0,
	i_grupo_acceso_informacion integer default 0,
	i_presidencia integer default 0,
	i_otra integer default 0,
	i_enlace integer default 0,
	i_sistema_informacion integer default 0,
	ia_pueblo_etnico integer default 0,
	ia_dialogo_social integer default 0,
	ia_genero integer default 0,
	ia_enfoque_ps integer default 0,
	ia_curso_vida integer default 0,
	nucleo_01 integer default 0,
	nucleo_02 integer default 0,
	nucleo_03 integer default 0,
	nucleo_04 integer default 0,
	nucleo_05 integer default 0,
	nucleo_06 integer default 0,
	nucleo_07 integer default 0,
	nucleo_08 integer default 0,
	nucleo_09 integer default 0,
	nucleo_10 integer default 0,
	mandato_01 integer default 0,
	mandato_02 integer default 0,
	mandato_03 integer default 0,
	mandato_04 integer default 0,
	mandato_05 integer default 0,
	mandato_06 integer default 0,
	mandato_07 integer default 0,
	mandato_08 integer default 0,
	mandato_09 integer default 0,
	mandato_10 integer default 0,
	mandato_11 integer default 0,
	mandato_12 integer default 0,
	mandato_13 integer default 0,

	a_consentimiento integer default 0,
	a_audio integer default 0,
	a_ficha_corta integer default 0,
	a_ficha_larga integer default 0,
	a_relatoria integer default 0,
	a_otros integer default 0,
	a_transcripcion_preliminar integer default 0,
	a_transcripcion_final integer default 0,
	a_retroalimentacion integer default 0,
	entrevista_lat double precision,
	entrevista_lon double precision,
	fecha_carga text,
	mes_carga text,
	id_entrevistador integer default null

);

alter table esclarecimiento.excel_entrevista_integrado owner to dba;



GRANT SELECT ON esclarecimiento.excel_entrevista_integrado TO solo_lectura;

create index excel_entrevista_integrado_codigo_entrevista_index
	on esclarecimiento.excel_entrevista_integrado (codigo_entrevista);

create index excel_entrevista_integrado_id_entrevistador_index
	on esclarecimiento.excel_entrevista_integrado (id_entrevistador);


