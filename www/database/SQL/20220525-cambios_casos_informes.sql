-- Nuevo campo en Casos e informes
alter table esclarecimiento.casos_informes
    add autor_id_tipo_organizacion int;

comment on column esclarecimiento.casos_informes.autor_id_tipo_organizacion is 'Catalogo 12';

create index casos_informes_autor_id_tipo_organizacion_index
    on esclarecimiento.casos_informes (autor_id_tipo_organizacion);

alter table esclarecimiento.casos_informes
    add constraint casos_informes_cat_item_id_item_fk
        foreign key (autor_id_tipo_organizacion) references catalogos.cat_item
            on update cascade on delete restrict;

-- Cambios en excel que se descarga
drop table if exists esclarecimiento.excel_casos_informes;
create table if not exists esclarecimiento.excel_casos_informes
(
    id_casos_informes integer not null
        constraint excel_casos_informes_pkey
            primary key,
    id_entrevistador integer,
    codigo text,
    tipo text,
    cantidad_casos text,
    macroterritorio text,
    territorio text,
    fecha_registro text,
    fecha_registro_a text,
    fecha_registro_m text,
    fecha_recepcion text,
    fecha_recepcion_a text,
    fecha_recepcion_m text,
    titulo text,
    autor text,
    autor_tipo_organizacion text,
    descripcion text,
    conteo_consultas integer,
    tipo_soporte text,
    contenido_texto text,
    contenido_audiovisual text,
    contenido_fotografia text,
    contenido_sonoro text,
    contenido_base_datos text,
    contenido_otros text,
    contenido_volumen text,
    remitente_nombre text,
    remitente_organizacion text,
    remitente_tipo_organizacion text,
    remitente_correo text,
    remitente_telefono text,
    remitente_cedula text,
    entrega_lugar_n1_codigo text,
    entrega_lugar_n1_txt text,
    entrega_lugar_n2_codigo text,
    entrega_lugar_n2_txt text,
    entrega_lugar_n3_codigo text,
    entrega_lugar_n3_txt text,
    entrega_lugar_especifico text,
    tiene_consentimiento text,
    tiene_tratamiento text,
    receptor_nombre text,
    receptor_area text,
    ubicacion_resguardo text,
    receptor_anotaciones text,
    caracterizacion_fecha text,
    caracterizacion_fecha_a text,
    caracterizacion_fecha_m text,
    elaboracion_fecha text,
    elaboracion_fecha_a text,
    elaboracion_fecha_m text,
    publicacion text,
    publicacion_a text,
    publicacion_m text,
    cobertura_tiempo text,
    cobertura_geo text,
    cobertura_geo_normalizada text,
    cobertura_geo_normalizada_codigos text,
    sectores_incluye text,
    sectores_incluye_aa text,
    sectores_incluye_poblaciones text,
    sectores_incluye_ocupaciones text,
    i_objetivo_esclarecimiento integer default 0,
    i_objetivo_reconocimiento integer default 0,
    i_objetivo_convivencia integer default 0,
    i_objetivo_no_repeticion integer default 0,
    i_enfoque_genero integer default 0,
    i_enfoque_psicosocial integer default 0,
    i_enfoque_curso_vida integer default 0,
    i_direccion_investigacion integer default 0,
    i_direccion_territorios integer default 0,
    i_direccion_etnica integer default 0,
    i_comisionados integer default 0,
    i_estrategia_arte integer default 0,
    i_estrategia_comunicacion integer default 0,
    i_estrategia_participacion integer default 0,
    i_estrategia_pedagogia integer default 0,
    i_grupo_acceso_informacion integer default 0,
    i_presidencia integer default 0,
    i_otra integer default 0,
    i_enlace integer default 0,
    i_sistema_informacion integer default 0,
    ia_pueblo_etnico integer default 0,
    ia_dialogo_social integer default 0,
    ia_ds_o_convivencia integer default 0,
    ia_ds_o_reconocimiento integer default 0,
    ia_ds_o_no_repeticion integer default 0,
    ia_genero integer default 0,
    ia_enfoque_ps integer default 0,
    ia_curso_vida integer default 0,
    nucleo_01 integer default 0,
    nucleo_02 integer default 0,
    nucleo_03 integer default 0,
    nucleo_04 integer default 0,
    nucleo_05 integer default 0,
    nucleo_06 integer default 0,
    nucleo_07 integer default 0,
    nucleo_08 integer default 0,
    nucleo_09 integer default 0,
    nucleo_10 integer default 0,
    mandato_01 integer default 0,
    mandato_02 integer default 0,
    mandato_03 integer default 0,
    mandato_04 integer default 0,
    mandato_05 integer default 0,
    mandato_06 integer default 0,
    mandato_07 integer default 0,
    mandato_08 integer default 0,
    mandato_09 integer default 0,
    mandato_10 integer default 0,
    mandato_11 integer default 0,
    mandato_12 integer default 0,
    mandato_13 integer default 0,
    a_consentimiento integer default 0,
    a_caso_informe integer default 0,
    a_otros integer default 0,
    json_adjuntos text,
    json_interes text,
    json_mandato text,
    clasificacion_nivel integer default 0,
    clasificacion_nna integer default 0,
    clasificacion_sex integer default 0,
    clasificacion_res integer default 0,
    clasificacion_r2 integer default 0,
    entrega_lat double precision,
    entrega_lon double precision,
    created_at timestamp(0) not null,
    updated_at timestamp(0)
);

alter table esclarecimiento.excel_casos_informes owner to dba;

create index if not exists excel_casos_informes_codigo_entrevista_index
    on esclarecimiento.excel_casos_informes (codigo);

create index if not exists excel_casos_informes_id_entrevistador_index
    on esclarecimiento.excel_casos_informes (id_entrevistador);

grant select on esclarecimiento.excel_casos_informes to solo_lectura;

