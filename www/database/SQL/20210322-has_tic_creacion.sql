create table sim.hash_tic
(
    id_hash_tic serial not null,
    nombre_archivo text,
    ubicacion_archivo text,
    md5 varchar(50),
    fecha_creado varchar(200),
    fecha_modificado varchar(200),
    tamano bigint,
    extension varchar(10)
);

comment on table sim.hash_tic is 'Archivos en file server';

alter table sim.hash_tic owner to dba;

create index hash_tic_md5_index
	on sim.hash_tic (md5);

create index hash_tic_nombre_archivo_index
	on sim.hash_tic (nombre_archivo);

create index hash_tic_ubicacion_archivo_index
	on sim.hash_tic (ubicacion_archivo);

