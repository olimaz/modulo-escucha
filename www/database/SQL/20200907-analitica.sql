-- Violencia_contexto
drop table if exists analitica.violencia_contexto;
create table if not exists analitica.violencia_contexto
(
    id serial
        constraint analitica_violencia_contexto_pk
            primary key,
    id_hecho integer,
    grupo text,
    contexto text

);

alter table analitica.violencia_contexto owner to dba;
GRANT SELECT ON analitica.violencia_contexto  TO solo_lectura;

create index if not exists violencia_contexto_id_hecho_index
    on analitica.violencia_contexto (id_hecho);


-- entrevista_impactos
drop table if exists analitica.entrevista_impactos;
create table if not exists analitica.entrevista_impactos
(
    id serial
        constraint analitica_entrevista_impactos_pk
            primary key,
    id_entrevista integer,
    grupo text,
    seccion text,
    impacto text

);

alter table analitica.entrevista_impactos owner to dba;
GRANT SELECT ON analitica.entrevista_impactos  TO solo_lectura;

create index if not exists entrevista_impactos_id_entrevista_index
    on analitica.entrevista_impactos (id_entrevista);


-- entrevista_afrontamiento
drop table if exists analitica.entrevista_afrontamientos;
create table if not exists analitica.entrevista_afrontamientos
(
    id serial
        constraint analitica_entrevista_afrontamientos_pk
            primary key,
    id_entrevista integer,
    grupo text,
    seccion text,
    afrontamiento text

);

alter table analitica.entrevista_afrontamientos owner to dba;
GRANT SELECT ON analitica.entrevista_afrontamientos  TO solo_lectura;

create index if not exists entrevista_afrontamientos_id_entrevista_index
    on analitica.entrevista_afrontamientos (id_entrevista);


-- ----------------------------- ACCESO A LA JUSTICIA

-- entrevista_acceso_justicia
drop table if exists analitica.entrevista_acceso_justicia;
create table if not exists analitica.entrevista_acceso_justicia
(
    id serial
        constraint analitica_entrevista_acceso_justicia_pk
            primary key,
    id_entrevista integer,
    conocimiento text,
    porque_no text,
    ha_recibido_apoyo text,
    medidas_reparacion_adecuadas text
);

alter table analitica.entrevista_acceso_justicia owner to dba;
GRANT SELECT ON analitica.entrevista_acceso_justicia  TO solo_lectura;

create index if not exists entrevista_acceso_justicia_id_entrevista_index
    on analitica.entrevista_acceso_justicia (id_entrevista);

comment on column analitica.entrevista_acceso_justicia.conocimiento is '1. ¿Puso en conocimiento a alguna entidad o autoridad?';
comment on column analitica.entrevista_acceso_justicia.porque_no is '1. ¿Puso en conocimiento a alguna entidad o autoridad?, Por qué no?';
comment on column analitica.entrevista_acceso_justicia.ha_recibido_apoyo is '2. ¿Ha recibido apoyo para su caso?';
comment on column analitica.entrevista_acceso_justicia.medidas_reparacion_adecuadas is '6. Las medidas de reparación, ¿han sido adecuadas?';



-- entrevista_acceso_justicia_avances
drop table if exists analitica.entrevista_acceso_justicia_avances;
create table if not exists analitica.entrevista_acceso_justicia_avances
(
    id serial
        constraint entrevista_acceso_justicia_avances_pk
            primary key,
    id_entrevista integer,
    grupo text,
    avance text
);

alter table analitica.entrevista_acceso_justicia_avances owner to dba;
GRANT SELECT ON analitica.entrevista_acceso_justicia_avances  TO solo_lectura;

create index if not exists entrevista_acceso_justicia_avances_id_entrevista_index
    on analitica.entrevista_acceso_justicia_avances (id_entrevista);


-- entrevista_acceso_justicia_no_adecuadas
drop table if exists analitica.entrevista_acceso_justicia_medidas_no_adecuadas;
create table if not exists analitica.entrevista_acceso_justicia_medidas_no_adecuadas
(
    id serial
        constraint entrevista_acceso_justicia_medidas_no_adecuadas_pk
            primary key,
    id_entrevista integer,
    porque_no text
);

alter table analitica.entrevista_acceso_justicia_medidas_no_adecuadas owner to dba;
GRANT SELECT ON analitica.entrevista_acceso_justicia_medidas_no_adecuadas  TO solo_lectura;

create index if not exists acceso_justicia_medidas_no_adecuadas_id_entrevista_index
    on analitica.entrevista_acceso_justicia_medidas_no_adecuadas (id_entrevista);


-- entrevista_acceso_justicia_denuncia_entidad
drop table if exists analitica.entrevista_acceso_justicia_denuncia;
drop table if exists analitica.entrevista_acceso_justicia_denuncia_entidad;
create table if not exists analitica.entrevista_acceso_justicia_denuncia_entidad
(
    id serial
        constraint entrevista_acceso_justicia_denuncia_entidad_pk
            primary key,
    id_entrevista integer,
    tipo_entidad text,
    entidad text
    --por_que text,
    --objetivo text
);

alter table analitica.entrevista_acceso_justicia_denuncia_entidad owner to dba;
GRANT SELECT ON analitica.entrevista_acceso_justicia_denuncia_entidad  TO solo_lectura;

create index if not exists entrevista_acceso_justicia_denuncia_entidad_id_entrevista_index
    on analitica.entrevista_acceso_justicia_denuncia_entidad (id_entrevista);

-- entrevista_acceso_justicia_denuncia_por_que
drop table if exists analitica.entrevista_acceso_justicia_denuncia_por_que;
create table if not exists analitica.entrevista_acceso_justicia_denuncia_por_que
(
    id serial
        constraint entrevista_acceso_justicia_denuncia_por_que_pk
            primary key,
    id_entrevista integer,
    tipo_entidad text,
    por_que text
    --objetivo text
);

alter table analitica.entrevista_acceso_justicia_denuncia_por_que owner to dba;
GRANT SELECT ON analitica.entrevista_acceso_justicia_denuncia_por_que  TO solo_lectura;

create index if not exists entrevista_acceso_justicia_denuncia_por_que_id_entrevista_index
    on analitica.entrevista_acceso_justicia_denuncia_por_que (id_entrevista);

-- entrevista_acceso_justicia_denuncia_objetivo
drop table if exists analitica.entrevista_acceso_justicia_denuncia_objetivo;
create table if not exists analitica.entrevista_acceso_justicia_denuncia_objetivo
(
    id serial
        constraint entrevista_acceso_justicia_denuncia_objetivo_pk
            primary key,
    id_entrevista integer,
    tipo_entidad text,
    objetivo text
);

alter table analitica.entrevista_acceso_justicia_denuncia_objetivo owner to dba;
GRANT SELECT ON analitica.entrevista_acceso_justicia_denuncia_objetivo TO solo_lectura;

create index if not exists acceso_justicia_denuncia_objetivo_id_entrevista_index
    on analitica.entrevista_acceso_justicia_denuncia_objetivo (id_entrevista);

-- entrevista_acceso_justicia_apoyo
drop table if exists analitica.entrevista_acceso_justicia_apoyo;
create table if not exists analitica.entrevista_acceso_justicia_apoyo
(
    id serial
        constraint entrevista_acceso_justicia_apoyo_pk
            primary key,
    id_entrevista integer,
    quien_apoya text
);

alter table analitica.entrevista_acceso_justicia_apoyo owner to dba;
GRANT SELECT ON analitica.entrevista_acceso_justicia_apoyo  TO solo_lectura;

create index if not exists entrevista_acceso_justicia_apoyo_id_entrevista_index
    on analitica.entrevista_acceso_justicia_apoyo (id_entrevista);

-- entrevista_no_repeticion
drop table if exists analitica.entrevista_no_repeticion;
create table if not exists analitica.entrevista_no_repeticion
(
    id serial
        constraint entrevista_no_repeticion_pk
            primary key,
    id_entrevista integer,
    iniciativa text
);

alter table analitica.entrevista_no_repeticion owner to dba;
GRANT SELECT ON analitica.entrevista_no_repeticion  TO solo_lectura;

create index if not exists entrevista_no_repeticion_id_entrevista_index
    on analitica.entrevista_no_repeticion (id_entrevista);

-- Comentarios a tablas
comment on table analitica.entrevista_acceso_justicia is 'Información general del acceso a la justicia';
comment on table analitica.entrevista_acceso_justicia_apoyo is 'Especifique quien le ha brindado apoyo para su caso';
comment on table analitica.entrevista_acceso_justicia_avances is '¿Qué avances ha tenido su caso?';
comment on table analitica.entrevista_acceso_justicia_denuncia_entidad is 'Si puso en conocimiento a alguna entidad o autoridad, sobre su caso.  Entidad o autoridad a la que acudió';
comment on table analitica.entrevista_acceso_justicia_denuncia_objetivo is 'Si puso en conocimiento a alguna entidad o autoridad, sobre su caso.  ¿Cuál era su objetivo principal al acceder a esta vía?';
comment on table analitica.entrevista_acceso_justicia_denuncia_por_que is 'Si puso en conocimiento a alguna entidad o autoridad, sobre su caso.  ¿Por qué accedió a esta entidad o autoridad?';
comment on table analitica.entrevista_acceso_justicia_medidas_no_adecuadas is 'Las medidas de reparación, ¿por qué no han sido adecuadas? ';



