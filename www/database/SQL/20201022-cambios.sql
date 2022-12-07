-- Nuevos campos
drop table if exists public.excel_traza_actividad;
create table public.excel_traza_actividad
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
    id_usuario integer,
    numero_entrevistador integer,
    territorio varchar(200),
    macroterritorio varchar(200),
    grupo varchar(200),
    perfil varchar(200)
);

comment on table public.excel_traza_actividad is 'Para descargar la traza de actividad';

alter table public.excel_traza_actividad owner to dba;
GRANT SELECT ON public.excel_traza_actividad TO solo_lectura;


create index excel_traza_actividad_id_usuario_index
    on public.excel_traza_actividad (id_usuario);

-- Traza buscadora
drop table if exists public.excel_traza_buscadora;
create table public.excel_traza_buscadora
(
    id_excel_traza_buscadora serial not null
        constraint excel_traza_buscadora_pk
            primary key,
    id_traza integer,
    id_entrevistador integer,
    tipo_busqueda varchar(100),
    criterio_busqueda varchar(200),
    numero_entrevistador integer,
    nombre_entrevistador varchar(200),
    territorio varchar(200),
    macroterritorio varchar(200),
    grupo varchar(200),
    perfil varchar(200),
    fecha_hora varchar(100),
    fecha_hora_anyo varchar(20),
    fecha_hora_mes varchar(20),
    fecha_hora_dia varchar(20),
    fecha_hora_dia_semana varchar(20),
    fecha_hora_hora varchar(20),
    fecha_hora_min varchar(20)
);

comment on table public.excel_traza_buscadora is 'Para descargar la traza de la buscadora';

alter table public.excel_traza_buscadora owner to dba;
GRANT SELECT ON public.excel_traza_buscadora TO solo_lectura;


create index excel_traza_buscadora_id_traza_index
    on public.excel_traza_buscadora (id_traza);

create index excel_traza_buscadora_id_etrevistador_index
    on public.excel_traza_buscadora (id_entrevistador);

