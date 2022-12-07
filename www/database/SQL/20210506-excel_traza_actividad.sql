drop table if  exists excel_traza_actividad;
create table if not exists excel_traza_actividad
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
    tipo_entrevista varchar(2),
    correlativo integer,
    referencia text,
    id_usuario integer,
    numero_entrevistador integer,
    territorio varchar(200),
    macroterritorio varchar(200),
    grupo varchar(200),
    perfil varchar(200)
);

comment on table excel_traza_actividad is 'Para descargar la traza de actividad';

alter table excel_traza_actividad owner to dba;

create index if not exists excel_traza_actividad_id_usuario_index
    on excel_traza_actividad (id_usuario);

grant select on excel_traza_actividad to solo_lectura;

