drop table if exists sim.legado;
create table if not exists sim.legado
(
    id_legado serial
        constraint legado_pk
            primary key,
    carpeta_1 varchar(10),
    carpeta_2 varchar(10),
    carpeta_3 varchar(10),
    carpeta_4 varchar(10),
    carpeta_5 varchar(10),
    carpeta_completa varchar(60) not null,
    archivo varchar(150) ,
    created_at timestamp with time zone default now(),
    codigo_entrevista varchar(25) not null,
    id_adjunto integer not null,
    archivo_original_ubicacion varchar(200) not null,
    archivo_original_tamano bigint not null,
    archivo_original_nombre varchar(200),
    archivo_original_md5 text ,
    archivo_liviano_nombre varchar(200),
    archivo_liviano_tamano bigint,
    archivo_liviano_tamano_md5 text,
    clasificacion integer not null,
    codigo_subserie integer not null,
    tipo_archivo varchar(200) not null,
    codigo_archivo varchar(2) not null
);

comment on table sim.legado is 'Estructura de archivos para legado';

alter table sim.legado owner to dba;

--Cambio de nombre
alter table sim.legado rename column archivo_liviano_tamano_md5 to archivo_liviano_md5;

--Indices
create index legado_archivo_index
    on sim.legado (archivo);

create index legado_archivo_liviano_md5_index
    on sim.legado (archivo_liviano_md5);

create index legado_archivo_liviano_nombre_index
    on sim.legado (archivo_liviano_nombre);

create index legado_archivo_original_nombre_index
    on sim.legado (archivo_original_nombre);

create index legado_codigo_archivo_index
    on sim.legado (codigo_archivo);

create index legado_codigo_entrevista_index
    on sim.legado (codigo_entrevista);

create index legado_id_adjunto_index
    on sim.legado (id_adjunto);