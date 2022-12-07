-- Referencia a archivo de transcripción
alter table esclarecimiento.e_ind_fvt_adjunto
	add id_transcripcion int;

-- Control de transcripcion
INSERT INTO "catalogos"."criterio_fijo_grupo" ("id_grupo", "descripcion") VALUES (7, 'Control de transcripcion');
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (7, 1, 'Sin transcripcion', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (7, 2, 'Transcripcion solicitada', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (7, 3, 'Transcripcion exitosa', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (7, 4, 'Error en la transcripcion', DEFAULT);

-- Tabla de control de transcripcion
create table control_transcripcion
(
    id_control_transcripcion serial       not null
        constraint control_transcripcion_pkey
            primary key,
    fh_inicio                timestamp(0) not null,
    fh_fin                   timestamp(0),
    id_primaria              integer      not null,
    id_subserie              integer      not null,
    nombre_archivo           varchar(255) not null,
    id_adjunto_nuevo         integer,
    id_estado                integer      not null,
    created_at               timestamp(0),
    updated_at               timestamp(0)
);

alter table control_transcripcion
    owner to dba;

create index public_control_transcripcion_fh_inicio_index
    on control_transcripcion (fh_inicio);

create index public_control_transcripcion_id_primaria_index
    on control_transcripcion (id_primaria);

create index public_control_transcripcion_id_subserie_index
    on control_transcripcion (id_subserie);

create index public_control_transcripcion_id_adjunto_nuevo_index
    on control_transcripcion (id_adjunto_nuevo);

create index public_control_transcripcion_id_estado_index
    on control_transcripcion (id_estado);


alter table control_transcripcion
    add nombre_archivo_transcripcion varchar(255);
