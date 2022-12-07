drop table if exists esclarecimiento.excel_control_adjuntos;
create table if not exists esclarecimiento.excel_control_adjuntos
(
    id_excel_control_adjuntos serial
        constraint excel_control_adjuntos_pk
            primary key,
    id_entrevista integer not null,
    id_adjunto integer not null,
    tipo_entrevista varchar(10),
    codigo_entrevista varchar(20),
    consecutivo integer not null,
    nombre_original text,
    tipo_adjunto varchar(200) not null,
    archivo_encontrado text default null,
    calificacion text,
    conteo_justificaciones integer default 0,
    justificaciones varchar(100),
    justificacion_01 text,
    justificacion_02 text,
    justificacion_03 text,
    justificacion_04 text,
    justificacion_05 text,
    justificacion_06 text,
    justificacion_07 text,
    justificacion_08 text,
    justificacion_09 text,
    justificacion_10 text
);

comment on table esclarecimiento.excel_control_adjuntos is 'Control de calificación de acceso a los adjuntos';

alter table esclarecimiento.excel_control_adjuntos owner to dba;

create index if not exists excel_control_adjuntos_calificacion_index
    on esclarecimiento.excel_control_adjuntos (calificacion);

create index if not exists excel_codigo_index
    on esclarecimiento.excel_control_adjuntos (codigo_entrevista);

create index if not exists excel_control_adjuntos_id_adjunto_index
    on esclarecimiento.excel_control_adjuntos (id_adjunto);

create index if not exists excel_control_adjuntos_id_entrevista_index
    on esclarecimiento.excel_control_adjuntos (id_entrevista);

create index if not exists excel_control_adjuntos_tipo_adjunto_index
    on esclarecimiento.excel_control_adjuntos (tipo_adjunto);

create index if not exists excel_control_adjuntos_tipo_entrevista_index
    on esclarecimiento.excel_control_adjuntos (tipo_entrevista);

