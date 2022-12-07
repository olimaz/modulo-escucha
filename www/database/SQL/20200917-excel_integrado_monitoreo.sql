drop table if exists esclarecimiento.excel_integrado_monitoreo;
create table esclarecimiento.excel_integrado_monitoreo
(
    id serial not null
        constraint excel_integrado_monitoreo_pkey
            primary key,
    estado_actual text,
    personas_entrevistadas integer default 1,
    tipo_entrevista text,
    codigo_entrevista text,
    es_virtual integer default 0,
    avance_actual text default 'Finalizada'::text,
    clasificacion integer default 3,
    macroterritorio text,
    territorio text,
    codigo_entrevistador text,
    grupo_entrevistador text,
    entrevista_fecha text,
    entrevista_mes text,
    tiempo_entrevista integer default 0,
    entrevista_lugar_n1 text,
    entrevista_lugar_n2 text,
    entrevista_lugar_n3 text,
    hechos_anio_del text,
    hechos_anio_al text,
    sector_entrevistado text,
    titulo text,
    transcrita integer default 0,
    transcrita_fecha text,
    transcrita_fecha_a text,
    transcrita_fecha_m text,
    etiquetada integer default 0,
    etiquetada_fecha text,
    etiquetada_fecha_a text,
    etiquetada_fecha_m text,
    entrevista_lat double precision,
    entrevista_lon double precision,
    fecha_carga text,
    mes_carga text,
    fecha_ultima_actualizacion text,
    mes_ultima_actualizacion text,
    id_entrevistador integer
);

alter table esclarecimiento.excel_integrado_monitoreo owner to dba;
grant select on esclarecimiento.excel_integrado_monitoreo to solo_lectura;

create index excel_integrado_monitoreo_codigo_entrevista_index
    on esclarecimiento.excel_integrado_monitoreo (codigo_entrevista);

create index excel_integrado_monitoreo_id_entrevistador_index
    on esclarecimiento.excel_integrado_monitoreo (id_entrevistador);

comment on table esclarecimiento.excel_integrado_monitoreo is 'Para rendicion de cuentas, incluye entrevistas anuladas';
comment on column esclarecimiento.excel_integrado_monitoreo.estado_actual is 'Identifica las entrevistas anuladas';
comment on column esclarecimiento.excel_integrado_monitoreo.avance_actual is 'Identifica las entrevistas que se encuentran en proceso';
comment on column esclarecimiento.excel_integrado_monitoreo.clasificacion is 'Especifica el nivel de acceso';
comment on column esclarecimiento.excel_integrado_monitoreo.fecha_ultima_actualizacion is 'Para las entrevistas anuladas, establece la fecha de anulación';
comment on column esclarecimiento.excel_integrado_monitoreo.mes_ultima_actualizacion is 'Para las entrevistas anuladas, establece el mes de anulación';

