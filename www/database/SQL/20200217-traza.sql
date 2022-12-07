drop table if exists  excel_traza_actividad;
create table excel_traza_actividad
(
    id_excel_traza_actividad serial not null
        constraint excel_traza_actividad_pk
            primary key,
    fecha_hora varchar(100),
    fecha_hora_anyo varchar(20),
    fecha_hora_mes varchar(20),
    fecha_hora_dia varchar(20),
    fecha_hora_hora varchar(20),
    fecha_hora_min varchar(20),
    usuario varchar(200),
    accion varchar(100),
    destino varchar(200),
    codigo varchar(100),
    referencia text,
    id_usuario integer
);

comment on table excel_traza_actividad is 'Para descargar la traza de actividad';

alter table excel_traza_actividad owner to dba;

create index excel_traza_actividad_id_usuario_index
    on excel_traza_actividad (id_usuario);

