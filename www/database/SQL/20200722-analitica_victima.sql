
drop table if exists analitica.victima;
create table if not exists analitica.victima
(
    id_victima integer
        constraint analitica_victima_pk
            primary key,
    id_entrevista integer,
    id_persona integer,
    codigo_entrevista varchar(100),
    nombre text,
    apellido text,
    otros_nombres text,
    fec_nac_anio integer,
    fec_nac_mes integer,
    fec_nac_dia integer,
    lugar_nac_codigo text,
    lugar_nac_n1_codigo text,
    lugar_nac_n1_txt text,
    lugar_nac_n2_codigo text,
    lugar_nac_n2_txt text,
    lugar_nac_n3_codigo text,
    lugar_nac_n3_txt text,
    lugar_nac_n3_lat text,
    lugar_nac_n3_lon text,
    sexo_id integer,
    sexo_txt text,
    orientacion_sexual_id integer,
    orientacion_sexual_txt text,
    identidad_genero_id integer,
    identidad_genero_txt text,
    pertenencia_etnica_id integer,
    pertenencia_etnica_txt text,
    pertenencia_indigena_id integer,
    pertenencia_indigena_txt text,
    documento_identidad_tipo_id integer,
    documento_identidad_tipo_txt text,
    documento_identidad_numero text,
    nacionalidad_id integer,
    nacionalidad_txt text,
    estado_civil_id integer,
    estado_civil_txt text,
    lugar_residencia_codigo text,
    lugar_residencia_n1_codigo text,
    lugar_residencia_n1_txt text,
    lugar_residencia_n2_codigo text,
    lugar_residencia_n2_txt text,
    lugar_residencia_n3_codigo text,
    lugar_residencia_n3_txt text,
    lugar_residencia_n3_lat text,
    lugar_residencia_n3_lon text,
    lugar_residencia_zona_id integer,
    lugar_residencia_zona_txt text,
    lugar_residencia_descripcion text,
    educacion_formal_id integer,
    educacion_formal_txt text,
    profesion text,
    ocupacion_actual text,
    discapacidad_id integer,
    discapacidad_txt text,
    cargo_publico integer,
    cargo_publico_cual text,
    fuerza_publica_miembro text,
    fuerza_publica_estado text,
    fuerza_publica_especificar text,
    actor_armado_ilegal text,
    actor_armado_ilegal_especificar text,
    organizacion_colectivo_participa integer,
    insert_id_entrevistador integer,
    insert_fecha_hora text,
    insert_fecha text,
    insert_fecha_mes text,
    update_id_entrevistador integer,
    update_fecha_hora text

);

alter table analitica.victima owner to dba;
GRANT SELECT ON analitica.victima  TO solo_lectura;

create index if not exists analitica_victima_id_entrevista_index
    on analitica.victima (id_entrevista);

create index if not exists analitica_victima_id_persona_index
    on analitica.victima (id_persona);

create index if not exists excel_ficha_victima_id_victima_index
    on analitica.victima (id_victima);

