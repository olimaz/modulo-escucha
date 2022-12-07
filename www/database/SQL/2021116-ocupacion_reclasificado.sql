-- eliminar ocupacion_actual de victima para evitar confusiones
alter table analitica.victima drop column ocupacion_actual;
alter table esclarecimiento.excel_ficha_victima drop column ocupacion_actual;

-- Campo normalizado en victima_violencia
drop materialized view analitica.concurrencia_victima;
drop materialized view analitica.concurrencia_entrevista;
drop materialized view analitica.concurrencia_responsabilidad_victima;

drop table if exists analitica.victima_violencia;
drop table if exists analitica.victima_violencia;
create table analitica.victima_violencia
(
    id serial
        constraint victima_violencia_pk
            primary key,
    id_hecho integer not null,
    id_victima integer not null,
    edad integer,
    ocupacion_momento_hechos text,
    ocupacion_momento_hechos_reclasificado text,
    lugar_res_codigo varchar(25),
    lugar_res_n1_codigo varchar(25),
    lugar_res_n1_txt text,
    lugar_res_n2_codigo varchar(25),
    lugar_res_n2_txt text,
    lugar_res_n3_codigo varchar(25),
    lugar_res_n3_txt text,
    lugar_res_n3_lat varchar(25),
    lugar_res_n3_lon varchar(25),
    lugar_res_zona_id integer,
    lugar_res_zona_txt text
);

comment on table analitica.victima_violencia is 'Enlace entre datos de víctima y datos de la violencia.';

comment on column analitica.victima_violencia.id is 'Llave primaria de la tabla';

comment on column analitica.victima_violencia.id_hecho is 'Enlace a tabla analitica.violencia';

comment on column analitica.victima_violencia.id_victima is 'Enlace a tabla analitica.victima';

comment on column analitica.victima_violencia.edad is 'Edad al momento de los hechos';

comment on column analitica.victima_violencia.ocupacion_momento_hechos is 'Ubicacion al momento de los hechos';
comment on column analitica.victima_violencia.ocupacion_momento_hechos_reclasificado is 'Ubicacion al momento de los hechos, dato reclasificado';

comment on column analitica.victima_violencia.lugar_res_codigo is 'Lugar de residencia al momento de los hechos, código';

comment on column analitica.victima_violencia.lugar_res_n1_codigo is 'Lugar de residencia al momento de los hechos, departamento, codigo';

comment on column analitica.victima_violencia.lugar_res_n1_txt is 'Lugar de residencia al momento de los hechos, departamento, nombre';

comment on column analitica.victima_violencia.lugar_res_n2_codigo is 'Lugar de residencia al momento de los hechos, municipio, codigo';

comment on column analitica.victima_violencia.lugar_res_n2_txt is 'Lugar de residencia al momento de los hechos, municipio, nombre';

comment on column analitica.victima_violencia.lugar_res_n3_codigo is 'Lugar de residencia al momento de los hechos, vereda, codigo';

comment on column analitica.victima_violencia.lugar_res_n3_txt is 'Lugar de residencia al momento de los hechos, vereda, nombre';

comment on column analitica.victima_violencia.lugar_res_n3_lat is 'Lugar de residencia al momento de los hechos, vereda, latitud';

comment on column analitica.victima_violencia.lugar_res_n3_lon is 'Lugar de residencia al momento de los hechos, vereda, longitud';

comment on column analitica.victima_violencia.lugar_res_zona_id is 'Lugar de residencia al momento de los hechos, vereda, tipo de zona, identificador';

comment on column analitica.victima_violencia.lugar_res_zona_txt is 'Lugar de residencia al momento de los hechos, vereda, tipo de zona, descripcion';

alter table analitica.victima_violencia owner to dba;

create unique index victima_violencia_id_hecho_id_victima_uindex
    on analitica.victima_violencia (id_hecho, id_victima);

grant select on analitica.victima_violencia to solo_lectura;

-- campo normalizado en persona_entrevistada
drop table if exists analitica.persona_entrevistada;
create table analitica.persona_entrevistada
(
    id_persona_entrevistada integer not null
        constraint analitica_persona_entrevistada_pk
            primary key,
    id_entrevista integer,
    id_persona integer,
    codigo_entrevista varchar(100),
    es_victima integer,
    es_testigo integer,
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
    sexo_id integer,
    sexo_txt text,
    edad integer,
    grupo_etario text,
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
    ocupacion_actual_reclasificado text,
    d_sensorial integer default 0,
    d_intelectual integer default 0,
    d_psicosocial integer default 0,
    d_fisica integer default 0,
    cargo_publico integer,
    cargo_publico_cual text,
    fuerza_publica_miembro text,
    fuerza_publica_estado text,
    fuerza_publica_especificar text,
    actor_armado_ilegal text,
    actor_armado_ilegal_especificar text,
    organizacion_colectivo_participa integer,
    relato text,
    insert_id_entrevistador integer,
    insert_fecha_hora text,
    insert_fecha text,
    insert_fecha_mes text,
    update_id_entrevistador integer,
    update_fecha_hora text
);

comment on column analitica.persona_entrevistada.d_sensorial is 'Discapacidad sensorial';

comment on column analitica.persona_entrevistada.d_intelectual is 'Discapacidad intelectual / cognitiva';

comment on column analitica.persona_entrevistada.d_psicosocial is 'Discapacidad psicosocial';

comment on column analitica.persona_entrevistada.d_fisica is 'Discapacidad física';

alter table analitica.persona_entrevistada owner to dba;

create index analitica_persona_entrevistada_id_entrevista_index
    on analitica.persona_entrevistada (id_entrevista);

create index analitica_persona_entrevistada_id_persona_entrevistada_index
    on analitica.persona_entrevistada (id_persona_entrevistada);

create index eanalitica_persona_entrevistada_id_persona_index
    on analitica.persona_entrevistada (id_persona);

create index persona_entrevistada_codigo_entrevista_index
    on analitica.persona_entrevistada (codigo_entrevista);

grant select on analitica.persona_entrevistada to solo_lectura;


