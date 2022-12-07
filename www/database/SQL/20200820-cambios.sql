drop table if exists analitica.exilio_salida;
create table analitica.exilio_salida
(
    id_exilio_movimiento integer not null
        constraint exilio_salida_pk
            primary key,
    id_exilio integer,
    id_entrevista integer,
    codigo_entrevista varchar(20),
    macroterritorio_id integer,
    macroterritorio_txt text,
    territorio_id integer,
    territorio_txt text,
    salida_fecha text,
    salida_anio text,
    salida_mes text,
    salida_lugar_codigo text,
    salida_lugar_n1_codigo text,
    salida_lugar_n1_txt text,
    salida_lugar_n2_codigo text,
    salida_lugar_n2_txt text,
    salida_lugar_n3_codigo text,
    salida_lugar_n3_txt text,
    salida_lugar_n3_lat text,
    salida_lugar_n3_lon text,
    llegada_fecha text,
    llegada_anio text,
    llegada_mes text,
    llegada_lugar_codigo text,
    llegada_lugar_n1_codigo text,
    llegada_lugar_n1_txt text,
    llegada_lugar_n2_codigo text,
    llegada_lugar_n2_txt text,
    llegada_lugar_n3_codigo text,
    llegada_lugar_n3_txt text,
    llegada_lugar_n3_lat text,
    llegada_lugar_n3_lon text,
    llegada_lugar_descripcion text,
    asentamiento_especificado integer,
    asentamiento_fecha text,
    asentamiento_anio text,
    asentamiento_mes text,
    asentamiento_lugar_codigo text,
    asentamiento_lugar_n1_codigo text,
    asentamiento_lugar_n1_txt text,
    asentamiento_lugar_n2_codigo text,
    asentamiento_lugar_n2_txt text,
    asentamiento_lugar_n3_codigo text,
    asentamiento_lugar_n3_txt text,
    asentamiento_lugar_n3__lat text,
    asentamiento_lugar_n3_lon text,
    asentamiento_lugar_descripcion text,
    modalidad_salida_id integer,
    modalidad_salida_txt text,
    cantidad_personas_salieron integer,
    cantidad_personas_nucleo_salieron integer,
    cantidad_personas_nucleo_quedaron integer,
    proteccion_aprobada_id integer,
    proteccion_aprobada_txt text,
    proteccion_denegada_id integer,
    proteccion_denegada_txt text,
    ha_obtenido_residencia_id integer,
    ha_obtenido_residencia_txt text,
    ha_sufrido_expulsion_id integer,
    ha_sufrido_expulsion_txt text,
    cantidad_reasentamientos integer,
    tiene_datos_retorno integer,
    ha_retornado integer default '-99'::integer,
    otro_exilio integer default '-99'::integer,
    created_at varchar(20),
    created_at_fecha varchar(20),
    created_at_mes varchar(20),
    updated_at varchar(20),
    updated_at_fecha varchar(20),
    updated_at_mes varchar(20)
);

comment on table analitica.exilio_salida is 'Datos de la primera salida';

alter table analitica.exilio_salida owner to dba;
GRANT SELECT ON analitica.exilio_salida  TO solo_lectura;

create index exilio_salida_codigo_entrevista_index
    on analitica.exilio_salida (codigo_entrevista);

