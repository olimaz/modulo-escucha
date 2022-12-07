
-- EXILIO
drop table if exists analitica.exilio_reasentamiento;
create table if not exists analitica.exilio_reasentamiento
(
    id_exilio_movimiento integer not null
        constraint exilio_reasentamiento_pk
            primary key,
    id_exilio integer,
    id_entrevista integer,
    codigo_entrevista varchar(20),
    macroterritorio_txt text,
    territorio_txt text,
    mot_r_conocidos integer default 0,
    mot_r_hechos_victimizantes integer default 0,
    mot_r_impactos_emocionales integer default 0,
    mot_r_impactos_familiares integer default 0,
    mot_r_facilidades integer default 0,
    mot_r_mejores_opciones integer default 0,
    mot_r_ns_nr integer default 0,
    mot_r_reagrupacion integer default 0,
    mot_r_deportacion integer default 0,
    salida_fecha text,
    salida_anio text,
    salida_mes text,
    salida_lugar_codigo text,
    salida_lugar_n1_codigo text,
    salida_lugar_n1_txt text,
    salida_lugar_n2_codigo text,
    salida_lugar_n2_txt text,
    salida_lugar_n3_codigo text,
    salida_lugar_n3_txt text,
    salida_lugar_especifico text,
    salida_lugar_n3_lat text,
    salida_lugar_n3_lon text,
    llegada_fecha text,
    llegada_anio text,
    llegada_mes text,
    llegada_lugar_codigo text,
    llegada_lugar_n1_codigo text,
    llegada_lugar_n1_txt text,
    llegada_lugar_n2_codigo text,
    llegada_lugar_n2_txt text,
    llegada_lugar_n3_codigo text,
    llegada_lugar_n3_txt text,
    llegada_lugar_especifico text,
    llegada_lugar_n3_lat text,
    llegada_lugar_n3_lon text,
    asentamiento_especificado int,
    asentamiento_fecha text,
    asentamiento_anio text,
    asentamiento_mes text,
    asentamiento_lugar_codigo text,
    asentamiento_lugar_n1_codigo text,
    asentamiento_lugar_n1_txt text,
    asentamiento_lugar_n2_codigo text,
    asentamiento_lugar_n2_txt text,
    asentamiento_lugar_n3_codigo text,
    asentamiento_lugar_n3_txt text,
    asentamiento_lugar_especifico text,
    asentamiento_lugar_n3_lat text,
    asentamiento_lugar_n3_lon text,
    --Modalidad y cantidad
    modalidad_salida text,
    cantidad_personas_salieron integer,
    cantidad_personas_nucleo_salieron integer,
    cantidad_personas_nucleo_quedaron integer,
    --Solicitud proteccion
    sp_asilado integer default 0,
    sp_pnpi integer default 0,
    sp_pth integer default 0,
    sp_refugiado integer default 0,
    estado_solicitud text,
    proteccion_aprobada text,
    proteccion_denegada text,
    ha_obtenido_residencia text,
    ha_sufrido_expulsion text,
    -- Traza
    created_at varchar(20),
    created_at_fecha varchar(20),
    created_at_mes varchar(20),
    updated_at  varchar(20),
    updated_at_fecha  varchar(20),
    updated_at_mes  varchar(20)
);

comment on table analitica.exilio_reasentamiento is 'Datos de reasentamientos salida';

alter table analitica.exilio_reasentamiento owner to dba;
grant select on analitica.exilio_reasentamiento to solo_lectura;

create index if not exists exilio_reasentamiento_codigo_entrevista_index
    on analitica.exilio_reasentamiento (codigo_entrevista);
create index if not exists exilio_reasentamiento_id_exilio_index
    on analitica.exilio_reasentamiento (id_exilio);
create index if not exists exilio_reasentamiento_id_entrevista_index
    on analitica.exilio_reasentamiento (id_entrevista);


comment on column analitica.exilio_retorno.id_exilio_movimiento is 'Llave primaria';
comment on column analitica.exilio_retorno.id_exilio is 'Llave foranea a ficha de exilio';
comment on column analitica.exilio_retorno.id_entrevista is 'Llave foranea hacia metadatos';
comment on column analitica.exilio_retorno.codigo_entrevista is 'Código de entrevista';
comment on column analitica.exilio_retorno.mot_r_conocidos is 'Motivos de reasentamiento: Conocía más personas cercnas en el otro país';
comment on column analitica.exilio_retorno.mot_r_hechos_victimizantes is 'Motivos de reasentamiento: Hechos victimizantes';
comment on column analitica.exilio_retorno.mot_r_impactos_emocionales is 'Motivos de reasentamiento: Impactos emocionales / Salud mental / Salud física';
comment on column analitica.exilio_retorno.mot_r_impactos_familiares is 'Motivos de reasentamiento: Impactos familiares';
comment on column analitica.exilio_retorno.mot_r_facilidades is 'Motivos de reasentamiento: Mayor facilidad en obtener el estatus de protección internacional';
comment on column analitica.exilio_retorno.mot_r_mejores_opciones is 'Motivos de reasentamiento: Mejores opciones económicas / políticas / culturales';
comment on column analitica.exilio_retorno.mot_r_ns_nr is 'Motivos de reasentamiento: No sabe / No responde';
comment on column analitica.exilio_retorno.mot_r_reagrupacion is 'Motivos de reasentamiento: Reagrupación familiar';
comment on column analitica.exilio_retorno.mot_r_deportacion is 'Motivos de reasentamiento: Situaciones o procesos de deportación';
--Salida
comment on column analitica.exilio_retorno.salida_fecha is 'Fecha de salida';
comment on column analitica.exilio_retorno.salida_lugar_codigo is 'Lugar de salida, código de maximo nivel especificado';
comment on column analitica.exilio_retorno.salida_lugar_n1_codigo is 'Lugar de salida, código de depto';
comment on column analitica.exilio_retorno.salida_lugar_n1_txt is 'Lugar de salida, nombre de depto';
comment on column analitica.exilio_retorno.salida_lugar_n2_codigo is 'Lugar de salida, código de municipio/pais';
comment on column analitica.exilio_retorno.salida_lugar_n2_txt is 'Lugar de salida, nombre de municipio/pais';
comment on column analitica.exilio_retorno.salida_lugar_n3_codigo is 'Lugar de salida, código de verda/ciudad';
comment on column analitica.exilio_retorno.salida_lugar_n3_txt is 'Lugar de salida, nombre de verda/ciudad';
comment on column analitica.exilio_retorno.salida_lugar_n3_lat is 'Lugar de salida: latitud';
comment on column analitica.exilio_retorno.salida_lugar_n3_lon is 'Lugar de salida: longitud';
comment on column analitica.exilio_retorno.salida_lugar_especifico is 'Lugar de salida: Lugar específico';
-- Llegada
comment on column analitica.exilio_retorno.llegada_fecha is 'Fecha de llegada inicial';
comment on column analitica.exilio_retorno.llegada_lugar_codigo is 'Lugar de llegada, código de maximo nivel especificado';
comment on column analitica.exilio_retorno.llegada_lugar_n1_codigo is 'Lugar de llegada, código de depto';
comment on column analitica.exilio_retorno.llegada_lugar_n1_txt is 'Lugar de llegada, nombre de depto';
comment on column analitica.exilio_retorno.llegada_lugar_n2_codigo is 'Lugar de llegada, código de municipio/pais';
comment on column analitica.exilio_retorno.llegada_lugar_n2_txt is 'Lugar de llegada, nombre de municipio/pais';
comment on column analitica.exilio_retorno.llegada_lugar_n3_codigo is 'Lugar de llegada, código de verda/ciudad';
comment on column analitica.exilio_retorno.llegada_lugar_n3_txt is 'Lugar de llegada, nombre de verda/ciudad';
comment on column analitica.exilio_retorno.llegada_lugar_n3_lat is 'Lugar de llegada: latitud';
comment on column analitica.exilio_retorno.llegada_lugar_n3_lon is 'Lugar de llegada: longitud';
comment on column analitica.exilio_retorno.llegada_lugar_especifico is 'Lugar de llegada: lugar específico';
-- Asentamiento posterior
comment on column analitica.exilio_retorno.asentamiento_especificado is 'Valor binario que indica si especifica reasentamiento posterior';
comment on column analitica.exilio_retorno.asentamiento_fecha is 'Fecha de asentamiento posterior, si aplica';
comment on column analitica.exilio_retorno.asentamiento_lugar_codigo is 'Lugar de asentamiento posterior, código de maximo nivel especificado';
comment on column analitica.exilio_retorno.asentamiento_lugar_n1_codigo is 'Lugar de asentamiento posterior, código de depto';
comment on column analitica.exilio_retorno.asentamiento_lugar_n1_txt is 'Lugar de asentamiento posterior, nombre de depto';
comment on column analitica.exilio_retorno.asentamiento_lugar_n2_codigo is 'Lugar de asentamiento posterior, código de municipio/pais';
comment on column analitica.exilio_retorno.asentamiento_lugar_n2_txt is 'Lugar de asentamiento posterior, nombre de municipio/pais';
comment on column analitica.exilio_retorno.asentamiento_lugar_n3_codigo is 'Lugar de asentamiento posterior, código de verda/ciudad';
comment on column analitica.exilio_retorno.asentamiento_lugar_n3_txt is 'Lugar de asentamiento posterior, nombre de verda/ciudad';
comment on column analitica.exilio_retorno.asentamiento_lugar_n3_lat is 'Lugar de asentamiento posterior: latitud';
comment on column analitica.exilio_retorno.asentamiento_lugar_n3_lon is 'Lugar de asentamiento posterior: longitud';
comment on column analitica.exilio_retorno.asentamiento_lugar_especifico is 'Lugar de asentamiento posterior: lugar específico';
--Modalidad de salida
comment on column analitica.exilio_retorno.modalidad_salida is 'Modalidad de salida';
comment on column analitica.exilio_retorno.cantidad_personas_salieron is 'Cantidad de personas que salieron:';
comment on column analitica.exilio_retorno.cantidad_personas_nucleo_salieron is 'Cant. de personas del núcleo familiar que salieron:';
comment on column analitica.exilio_retorno.cantidad_personas_nucleo_quedaron is 'Cant. de personas del núcleo familiar que se quedaron:';
--Proteccion
comment on column analitica.exilio_retorno.sp_asilado is '¿Ha solicitado estatus de protección internacional o del país de acogida?: Asilado';
comment on column analitica.exilio_retorno.sp_pnpi is '¿Ha solicitado estatus de protección internacional o del país de acogida?: Persona con necesidad de protección internacional (PNPI)';
comment on column analitica.exilio_retorno.sp_pth is '¿Ha solicitado estatus de protección internacional o del país de acogida?: Protección Temporal Humanitaria (PTH)';
comment on column analitica.exilio_retorno.sp_refugiado is '¿Ha solicitado estatus de protección internacional o del país de acogida?:Refugiado';
comment on column analitica.exilio_retorno.estado_solicitud is 'Estado de la solicitud:';
comment on column analitica.exilio_retorno.proteccion_aprobada is 'Si aprobada, por:';
comment on column analitica.exilio_retorno.proteccion_aprobada is 'Si denegada, ¿en qué condición se encuentra la persona?';
comment on column analitica.exilio_retorno.ha_obtenido_residencia is '¿Ha obtenido residencia en el país de acogida?';
comment on column analitica.exilio_retorno.ha_sufrido_expulsion is '¿Ha sufrido un proceso de expulsión, deportación y/o devolución? ';


-- Cambios a salida
drop table if exists analitica.exilio_salida;
create table analitica.exilio_salida
(
    id_exilio_movimiento integer not null
        constraint exilio_salida_pk
            primary key,
    id_exilio integer,
    id_entrevista integer,
    codigo_entrevista varchar(20),
    macroterritorio_id integer,
    macroterritorio_txt text,
    territorio_id integer,
    territorio_txt text,
    cat_asilado integer default 0,
    cat_desplazado integer default 0,
    cat_exiliado integer default 0,
    cat_familiar integer default 0,
    cat_migrante integer default 0,
    cat_ns_nr integer default 0,
    cat_otro integer default 0,
    cat_refugiado integer default 0,
    cat_retornado integer default 0,
    cat_solicitante_asilo integer default 0,
    cat_victima_exterior integer default 0,
    mot_amenaza_hijos integer default 0,
    mot_amenaza_vida integer default 0,
    mot_discriminacion integer default 0,
    mot_falta_garantias integer default 0,
    mot_hechos_violentos integer default 0,
    mot_miedos integer default 0,
    mot_ns_nr integer default 0,
    mot_persecusion integer default 0,
    mot_razones_politicas integer default 0,
    mot_reagrupacion_familiar integer default 0,
    mot_rechazo_cololmbia integer default 0,
    mot_sobrevivencia integer default 0,
    salida_fecha text,
    salida_anio text,
    salida_mes text,
    salida_lugar_codigo text,
    salida_lugar_n1_codigo text,
    salida_lugar_n1_txt text,
    salida_lugar_n2_codigo text,
    salida_lugar_n2_txt text,
    salida_lugar_n3_codigo text,
    salida_lugar_n3_txt text,
    salida_lugar_n3_lat text,
    salida_lugar_n3_lon text,
    llegada_fecha text,
    llegada_anio text,
    llegada_mes text,
    llegada_lugar_codigo text,
    llegada_lugar_n1_codigo text,
    llegada_lugar_n1_txt text,
    llegada_lugar_n2_codigo text,
    llegada_lugar_n2_txt text,
    llegada_lugar_n3_codigo text,
    llegada_lugar_n3_txt text,
    llegada_lugar_n3_lat text,
    llegada_lugar_n3_lon text,
    llegada_lugar_descripcion text,
    asentamiento_especificado integer,
    asentamiento_fecha text,
    asentamiento_anio text,
    asentamiento_mes text,
    asentamiento_lugar_codigo text,
    asentamiento_lugar_n1_codigo text,
    asentamiento_lugar_n1_txt text,
    asentamiento_lugar_n2_codigo text,
    asentamiento_lugar_n2_txt text,
    asentamiento_lugar_n3_codigo text,
    asentamiento_lugar_n3_txt text,
    asentamiento_lugar_n3_lat text,
    asentamiento_lugar_n3_lon text,
    asentamiento_lugar_descripcion text,
    modalidad_salida_id integer,
    modalidad_salida_txt text,
    cantidad_personas_salieron integer,
    cantidad_personas_nucleo_salieron integer,
    cantidad_personas_nucleo_quedaron integer,
    --Solicitud proteccion
    sp_asilado integer default 0,
    sp_pnpi integer default 0,
    sp_pth integer default 0,
    sp_refugiado integer default 0,
    estado_solicitud text,
    proteccion_aprobada text,
    proteccion_denegada text,
    ha_obtenido_residencia text,
    ha_sufrido_expulsion text,
    --
    cantidad_reasentamientos integer,
    tiene_datos_retorno integer,
    ha_retornado integer default '-99'::integer,
    otro_exilio integer default '-99'::integer,
    created_at varchar(20),
    created_at_fecha varchar(20),
    created_at_mes varchar(20),
    updated_at varchar(20),
    updated_at_fecha varchar(20),
    updated_at_mes varchar(20)
);

comment on table analitica.exilio_salida is 'Datos de la primera salida';

alter table analitica.exilio_salida owner to dba;

grant select on analitica.exilio_salida to solo_lectura;

create index exilio_salida_codigo_entrevista_index
    on analitica.exilio_salida (codigo_entrevista);


comment on column analitica.exilio_salida.id_exilio_movimiento is 'Llave primaria';
comment on column analitica.exilio_salida.id_exilio is 'Llave foranea a ficha de exilio';
comment on column analitica.exilio_salida.id_entrevista is 'Llave foranea hacia metadatos';
comment on column analitica.exilio_salida.codigo_entrevista is 'Código de entrevista';
comment on column analitica.exilio_salida.cat_asilado is 'Se reconoce en una de las siguientes categorías: Asilado';
comment on column analitica.exilio_salida.cat_desplazado is 'Se reconoce en una de las siguientes categorías: Desplazado/a';
comment on column analitica.exilio_salida.cat_exiliado is 'Se reconoce en una de las siguientes categorías: Exiliado/a';
comment on column analitica.exilio_salida.cat_familiar is 'Se reconoce en una de las siguientes categorías: Familiar de la víctima';
comment on column analitica.exilio_salida.cat_migrante is 'Se reconoce en una de las siguientes categorías: Migrante';
comment on column analitica.exilio_salida.cat_ns_nr is 'Se reconoce en una de las siguientes categorías: No sabe / No responde';
comment on column analitica.exilio_salida.cat_otro is 'Se reconoce en una de las siguientes categorías: Otro';
comment on column analitica.exilio_salida.cat_refugiado is 'Se reconoce en una de las siguientes categorías: Refugiado';
comment on column analitica.exilio_salida.cat_retornado is 'Se reconoce en una de las siguientes categorías: Retornado/a';
comment on column analitica.exilio_salida.cat_solicitante_asilo is 'Se reconoce en una de las siguientes categorías: Solicitante de asilo';
comment on column analitica.exilio_salida.cat_victima_exterior is 'Se reconoce en una de las siguientes categorías: Víctima en el exterior';
comment on column analitica.exilio_salida.mot_amenaza_hijos is 'Motivos de la salida del país: Amenaza a hijos / as';
comment on column analitica.exilio_salida.mot_amenaza_vida is 'Motivos de la salida del país: Amenaza al derecho a la vida';
comment on column analitica.exilio_salida.mot_discriminacion is 'Motivos de la salida del país: Discriminación en razón de identidad de género u orientación sexual';
comment on column analitica.exilio_salida.mot_falta_garantias is 'Motivos de la salida del país: Falta de garantías por parte del estado';
comment on column analitica.exilio_salida.mot_hechos_violentos is 'Motivos de la salida del país: Hechos violentos mencionado en la entrevista';
comment on column analitica.exilio_salida.mot_miedos is 'Motivos de la salida del país: Miedos relacionados con la zona ("Estaba muy caliente")';
comment on column analitica.exilio_salida.mot_ns_nr is 'Motivos de la salida del país: No sabe / No responde';
comment on column analitica.exilio_salida.mot_persecusion is 'Motivos de la salida del país: Persecución';
comment on column analitica.exilio_salida.mot_razones_politicas is 'Motivos de la salida del país: Por razones políticas';
comment on column analitica.exilio_salida.mot_reagrupacion_familiar is 'Motivos de la salida del país: Reagrupación familiar';
comment on column analitica.exilio_salida.mot_rechazo_cololmbia is 'Motivos de la salida del país: Rechazo / odio frente a Colombia';
comment on column analitica.exilio_salida.mot_sobrevivencia is 'Motivos de la salida del país: Sobrevivencia / búsqueda de mejores oportunidades';
--Salida
comment on column analitica.exilio_salida.salida_fecha is 'Fecha de salida';
comment on column analitica.exilio_salida.salida_lugar_codigo is 'Lugar de salida, código de maximo nivel especificado';
comment on column analitica.exilio_salida.salida_lugar_n1_codigo is 'Lugar de salida, código de depto';
comment on column analitica.exilio_salida.salida_lugar_n1_txt is 'Lugar de salida, nombre de depto';
comment on column analitica.exilio_salida.salida_lugar_n2_codigo is 'Lugar de salida, código de municipio/pais';
comment on column analitica.exilio_salida.salida_lugar_n2_txt is 'Lugar de salida, nombre de municipio/pais';
comment on column analitica.exilio_salida.salida_lugar_n3_codigo is 'Lugar de salida, código de verda/ciudad';
comment on column analitica.exilio_salida.salida_lugar_n3_txt is 'Lugar de salida, nombre de verda/ciudad';
comment on column analitica.exilio_salida.salida_lugar_n3_lat is 'Lugar de salida: latitud';
comment on column analitica.exilio_salida.salida_lugar_n3_lon is 'Lugar de salida: longitud';

-- Llegada
comment on column analitica.exilio_salida.llegada_fecha is 'Fecha de llegada inicial';
comment on column analitica.exilio_salida.llegada_lugar_codigo is 'Lugar de llegada, código de maximo nivel especificado';
comment on column analitica.exilio_salida.llegada_lugar_n1_codigo is 'Lugar de llegada, código de depto';
comment on column analitica.exilio_salida.llegada_lugar_n1_txt is 'Lugar de llegada, nombre de depto';
comment on column analitica.exilio_salida.llegada_lugar_n2_codigo is 'Lugar de llegada, código de municipio/pais';
comment on column analitica.exilio_salida.llegada_lugar_n2_txt is 'Lugar de llegada, nombre de municipio/pais';
comment on column analitica.exilio_salida.llegada_lugar_n3_codigo is 'Lugar de llegada, código de verda/ciudad';
comment on column analitica.exilio_salida.llegada_lugar_n3_txt is 'Lugar de llegada, nombre de verda/ciudad';
comment on column analitica.exilio_salida.llegada_lugar_n3_lat is 'Lugar de llegada: latitud';
comment on column analitica.exilio_salida.llegada_lugar_n3_lon is 'Lugar de llegada: longitud';
comment on column analitica.exilio_salida.llegada_lugar_descripcion is 'Lugar de llegada: lugar específico';
-- Asentamiento posterior
comment on column analitica.exilio_salida.asentamiento_especificado is 'Valor binario que indica si especifica reasentamiento posterior';
comment on column analitica.exilio_salida.asentamiento_fecha is 'Fecha de asentamiento posterior, si aplica';
comment on column analitica.exilio_salida.asentamiento_lugar_codigo is 'Lugar de asentamiento posterior, código de maximo nivel especificado';
comment on column analitica.exilio_salida.asentamiento_lugar_n1_codigo is 'Lugar de asentamiento posterior, código de depto';
comment on column analitica.exilio_salida.asentamiento_lugar_n1_txt is 'Lugar de asentamiento posterior, nombre de depto';
comment on column analitica.exilio_salida.asentamiento_lugar_n2_codigo is 'Lugar de asentamiento posterior, código de municipio/pais';
comment on column analitica.exilio_salida.asentamiento_lugar_n2_txt is 'Lugar de asentamiento posterior, nombre de municipio/pais';
comment on column analitica.exilio_salida.asentamiento_lugar_n3_codigo is 'Lugar de asentamiento posterior, código de verda/ciudad';
comment on column analitica.exilio_salida.asentamiento_lugar_n3_txt is 'Lugar de asentamiento posterior, nombre de verda/ciudad';
comment on column analitica.exilio_salida.asentamiento_lugar_n3_lat is 'Lugar de asentamiento posterior: latitud';
comment on column analitica.exilio_salida.asentamiento_lugar_n3_lon is 'Lugar de asentamiento posterior: longitud';
comment on column analitica.exilio_salida.asentamiento_lugar_descripcion is 'Lugar de asentamiento posterior: lugar específico';
--Modalidad de salida
comment on column analitica.exilio_salida.modalidad_salida_txt is 'Modalidad de salida';
comment on column analitica.exilio_salida.cantidad_personas_salieron is 'Cantidad de personas que salieron:';
comment on column analitica.exilio_salida.cantidad_personas_nucleo_salieron is 'Cant. de personas del núcleo familiar que salieron:';
comment on column analitica.exilio_salida.cantidad_personas_nucleo_quedaron is 'Cant. de personas del núcleo familiar que se quedaron:';
--Proteccion
comment on column analitica.exilio_salida.sp_asilado is '¿Ha solicitado estatus de protección internacional o del país de acogida?: Asilado';
comment on column analitica.exilio_salida.sp_pnpi is '¿Ha solicitado estatus de protección internacional o del país de acogida?: Persona con necesidad de protección internacional (PNPI)';
comment on column analitica.exilio_salida.sp_pth is '¿Ha solicitado estatus de protección internacional o del país de acogida?: Protección Temporal Humanitaria (PTH)';
comment on column analitica.exilio_salida.sp_refugiado is '¿Ha solicitado estatus de protección internacional o del país de acogida?:Refugiado';
comment on column analitica.exilio_salida.estado_solicitud is 'Estado de la solicitud:';
comment on column analitica.exilio_salida.proteccion_aprobada is 'Si aprobada, por:';
comment on column analitica.exilio_salida.proteccion_aprobada is 'Si denegada, ¿en qué condición se encuentra la persona?';
comment on column analitica.exilio_salida.ha_obtenido_residencia is '¿Ha obtenido residencia en el país de acogida?';
comment on column analitica.exilio_salida.ha_sufrido_expulsion is '¿Ha sufrido un proceso de expulsión, deportación y/o devolución? ';
--
comment on column analitica.exilio_salida.cantidad_reasentamientos is 'Cantidad de reasentamientos especificados en la ficha';
comment on column analitica.exilio_salida.tiene_datos_retorno is 'Valor lógico que indica si se diligencia información del retorno';
comment on column analitica.exilio_salida.otro_exilio is 'Valor lógico que indica si se volvió a exiliar';


-- RETORNO----------------------------------
drop table if exists analitica.exilio_retorno;
create table if not exists analitica.exilio_retorno
(
    id_exilio_movimiento integer not null
        constraint exilio_retorno_pk
            primary key,
    id_exilio integer,
    id_entrevista integer,
    codigo_entrevista varchar(20),
    macroterritorio_txt text,
    territorio_txt text,
    ha_retornado integer default 0,
    --
    pq_si_condiciones integer default 0,
    pq_si_proteccion integer default 0,
    pq_si_condiciones_economicas integer default 0,
    pq_si_familiares integer default 0,
    pq_si_nostalgia integer default 0,
    pq_si_persecucion integer default 0,
    pq_si_economicas integer default 0,
    pq_si_laborales integer default 0,
    pq_si_politicas integer default 0,
    pq_si_pendular integer default 0,
    pq_si_deportacion integer default 0,
    pq_si_subvenciones integer default 0,
    pq_no_proyecto_vida integer default 0,
    pq_no_dificultades_economicas integer default 0,
    pq_no_condiciones_politicas integer default 0,
    pq_no_falta_garantias integer default 0,
    pq_no_familia_fuera integer default 0,
    pq_no_faimlia_muerta integer default 0,
    pq_no_miedo integer default 0,
    pq_no_ns_nr integer default 0,
    pq_no_estudios integer default 0,
    pq_no_hijos integer default 0,
    pq_no_rechazo_colombia integer default 0,
    --
    salida_fecha text,
    salida_anio text,
    salida_mes text,
    salida_lugar_codigo text,
    salida_lugar_n1_codigo text,
    salida_lugar_n1_txt text,
    salida_lugar_n2_codigo text,
    salida_lugar_n2_txt text,
    salida_lugar_n3_codigo text,
    salida_lugar_n3_txt text,
    salida_lugar_especifico text,
    salida_lugar_n3_lat text,
    salida_lugar_n3_lon text,
    llegada_fecha text,
    llegada_anio text,
    llegada_mes text,
    llegada_lugar_codigo text,
    llegada_lugar_n1_codigo text,
    llegada_lugar_n1_txt text,
    llegada_lugar_n2_codigo text,
    llegada_lugar_n2_txt text,
    llegada_lugar_n3_codigo text,
    llegada_lugar_n3_txt text,
    llegada_lugar_especifico text,
    llegada_lugar_n3_lat text,
    llegada_lugar_n3_lon text,
    --Modalidad y cantidad
    modalidad_retorno text,
    cantidad_personas_salieron integer,
    cantidad_personas_nucleo_salieron integer,
    cantidad_personas_nucleo_quedaron integer,
    --Ayuda
    tuvo_ayuda integer default 0,
    institucion_ayuda text,
    ayuda_alimentaria integer default 0,
    ayuda_proyectos integer default 0,
    ayuda_educacion integer default 0,
    ayuda_documentos integer default 0,
    ayuda_vivienda integer default 0,
    ayuda_exilio integer default 0,
    ayuda_proteccion integer default 0,
    -- 
    otro_exilio integer default 0,

    -- Traza
    created_at varchar(20),
    created_at_fecha varchar(20),
    created_at_mes varchar(20),
    updated_at  varchar(20),
    updated_at_fecha  varchar(20),
    updated_at_mes  varchar(20)
);

comment on table analitica.exilio_retorno is 'Datos de retorno';

alter table analitica.exilio_retorno owner to dba;
grant select on analitica.exilio_retorno to solo_lectura;

create index if not exists exilio_retorno_codigo_entrevista_index
    on analitica.exilio_retorno (codigo_entrevista);
create index if not exists exilio_retorno_id_exilio_index
    on analitica.exilio_retorno (id_exilio);
create index if not exists exilio_retorno_id_entrevista_index
    on analitica.exilio_retorno (id_entrevista);


comment on column analitica.exilio_retorno.id_exilio_movimiento is 'Llave primaria';
comment on column analitica.exilio_retorno.id_exilio is 'Llave foranea a ficha de exilio';
comment on column analitica.exilio_retorno.id_entrevista is 'Llave foranea hacia metadatos';
comment on column analitica.exilio_retorno.codigo_entrevista is 'Código de entrevista';
comment on column analitica.exilio_retorno.pq_si_condiciones is 'Ahora están las condiciones en Colombia';
comment on column analitica.exilio_retorno.pq_si_proteccion is 'El país que lo acogió ya no lo protege';
comment on column analitica.exilio_retorno.pq_si_condiciones_economicas is 'Las condiciones económicas/políticas del país de acogida cambiaron ';
comment on column analitica.exilio_retorno.pq_si_familiares is 'Motivos familiares (enfermedades, padres muy mayores, etc.)';
comment on column analitica.exilio_retorno.pq_si_nostalgia is 'Nostalgia';
comment on column analitica.exilio_retorno.pq_si_persecucion is 'Persecución';
comment on column analitica.exilio_retorno.pq_si_economicas is 'Por razones económicas';
comment on column analitica.exilio_retorno.pq_si_laborales is 'Por razones laborales';
comment on column analitica.exilio_retorno.pq_si_politicas is 'Por razones políticas';
comment on column analitica.exilio_retorno.pq_si_pendular is 'Retorno pendular';
comment on column analitica.exilio_retorno.pq_si_deportacion is 'Situaciones o procesos de deportación';
comment on column analitica.exilio_retorno.pq_si_subvenciones is 'Subvenciones económicas para el retorno';
comment on column analitica.exilio_retorno.pq_no_proyecto_vida is 'Decidió quedarse en el país donde construyó un nuevo proyecto de vida';
comment on column analitica.exilio_retorno.pq_no_dificultades_economicas is 'Dificultades económicas para el retorno';
comment on column analitica.exilio_retorno.pq_no_condiciones_politicas is 'Falta de condiciones políticas para el retorno';
comment on column analitica.exilio_retorno.pq_no_falta_garantias is 'Falta de garantías de seguridad';
comment on column analitica.exilio_retorno.pq_no_familia_fuera is 'La familia/comunidad de referencia ya está afuera de Colombia';
comment on column analitica.exilio_retorno.pq_no_faimlia_muerta is 'La mayor parte de la familia/comunidad de referencia en Colombia ya está muerta o en otro lugar';
comment on column analitica.exilio_retorno.pq_no_miedo is 'Miedo al retorno';
comment on column analitica.exilio_retorno.pq_no_ns_nr is 'No sabe / No responde';
comment on column analitica.exilio_retorno.pq_no_estudios is 'Por estudios';
comment on column analitica.exilio_retorno.pq_no_hijos is 'Por los hijos';
comment on column analitica.exilio_retorno.pq_no_rechazo_colombia is 'Rechazo y apatía frente a Colombia';
--Salida
comment on column analitica.exilio_retorno.salida_fecha is 'Fecha de salida';
comment on column analitica.exilio_retorno.salida_lugar_codigo is 'Lugar de salida, código de maximo nivel especificado';
comment on column analitica.exilio_retorno.salida_lugar_n1_codigo is 'Lugar de salida, código de depto';
comment on column analitica.exilio_retorno.salida_lugar_n1_txt is 'Lugar de salida, nombre de depto';
comment on column analitica.exilio_retorno.salida_lugar_n2_codigo is 'Lugar de salida, código de municipio/pais';
comment on column analitica.exilio_retorno.salida_lugar_n2_txt is 'Lugar de salida, nombre de municipio/pais';
comment on column analitica.exilio_retorno.salida_lugar_n3_codigo is 'Lugar de salida, código de verda/ciudad';
comment on column analitica.exilio_retorno.salida_lugar_n3_txt is 'Lugar de salida, nombre de verda/ciudad';
comment on column analitica.exilio_retorno.salida_lugar_n3_lat is 'Lugar de salida: latitud';
comment on column analitica.exilio_retorno.salida_lugar_n3_lon is 'Lugar de salida: longitud';
comment on column analitica.exilio_retorno.salida_lugar_especifico is 'Lugar de salida: Lugar específico';
-- Llegada
comment on column analitica.exilio_retorno.llegada_fecha is 'Fecha de llegada inicial';
comment on column analitica.exilio_retorno.llegada_lugar_codigo is 'Lugar de llegada, código de maximo nivel especificado';
comment on column analitica.exilio_retorno.llegada_lugar_n1_codigo is 'Lugar de llegada, código de depto';
comment on column analitica.exilio_retorno.llegada_lugar_n1_txt is 'Lugar de llegada, nombre de depto';
comment on column analitica.exilio_retorno.llegada_lugar_n2_codigo is 'Lugar de llegada, código de municipio/pais';
comment on column analitica.exilio_retorno.llegada_lugar_n2_txt is 'Lugar de llegada, nombre de municipio/pais';
comment on column analitica.exilio_retorno.llegada_lugar_n3_codigo is 'Lugar de llegada, código de verda/ciudad';
comment on column analitica.exilio_retorno.llegada_lugar_n3_txt is 'Lugar de llegada, nombre de verda/ciudad';
comment on column analitica.exilio_retorno.llegada_lugar_n3_lat is 'Lugar de llegada: latitud';
comment on column analitica.exilio_retorno.llegada_lugar_n3_lon is 'Lugar de llegada: longitud';
comment on column analitica.exilio_retorno.llegada_lugar_especifico is 'Lugar de llegada: lugar específico';

--Modalidad de salida
comment on column analitica.exilio_retorno.modalidad_retorno is 'Modalidad de retorno';
comment on column analitica.exilio_retorno.cantidad_personas_salieron is 'Cantidad de personas que salieron:';
comment on column analitica.exilio_retorno.cantidad_personas_nucleo_salieron is 'Cant. de personas del núcleo familiar que salieron:';
comment on column analitica.exilio_retorno.cantidad_personas_nucleo_quedaron is 'Cant. de personas del núcleo familiar que se quedaron:';
--Proteccion
comment on column analitica.exilio_retorno.tuvo_ayuda is 'Una vez retornado, ¿Tuvo ayuda de alguna institución colombiana?';
comment on column analitica.exilio_retorno.institucion_ayuda is 'Institución que le ayudó:';
comment on column analitica.exilio_retorno.ayuda_alimentaria is 'Ayuda recibida: Ayuda alimentaria';
comment on column analitica.exilio_retorno.ayuda_proyectos is 'Ayuda recibida: Ayuda con proyectos laborales/productivos';
comment on column analitica.exilio_retorno.ayuda_educacion is 'Ayuda recibida: Ayuda en la educación (a la persona o a los hijos)';
comment on column analitica.exilio_retorno.ayuda_documentos is 'Ayuda recibida: Ayuda en recuperar la documentación de identidad';
comment on column analitica.exilio_retorno.ayuda_vivienda is 'Ayuda recibida: Ayuda para vivienda';
comment on column analitica.exilio_retorno.ayuda_exilio is 'Ayuda recibida: Exilio';
comment on column analitica.exilio_retorno.ayuda_proteccion is 'Ayuda recibida: Protección';
comment on column analitica.exilio_retorno.otro_exilio is 'Después del retorno, ¿volvió a exiliarse? ';


-- Acompañamiento
drop table if exists analitica.exilio_acompanamiento;
create table if not exists analitica.exilio_acompanamiento
(
    id_exilio_acompanamiento serial
        constraint exilio_acompanamiento_pk
            primary key,
    id_exilio_movimiento integer,
    id_exilio            integer,
    id_entrevista        integer,
    codigo_entrevista    varchar(20),
    macroterritorio  text,
    territorio       text,
    tipo_movimiento      text,
    momento              text,
    acompanamiento       text,
    institucion_ayuda   text
);
comment on table analitica.exilio_acompanamiento is 'Acompañamiento en las rutas de exilio';

alter table analitica.exilio_acompanamiento owner to dba;
grant select on analitica.exilio_acompanamiento to solo_lectura;

create index if not exists exilio_acompanamiento_codigo_entrevista_index
    on analitica.exilio_acompanamiento (codigo_entrevista);
create index if not exists exilio_acompanamiento_id_exilio_index
    on analitica.exilio_acompanamiento (id_exilio);
create index if not exists exilio_acompanamiento_id_exilio_movimiento_index
    on analitica.exilio_acompanamiento (id_exilio_movimiento);
create index if not exists exilio_acompanamiento_id_entrevista_index
    on analitica.exilio_acompanamiento (id_entrevista);


comment on column analitica.exilio_acompanamiento.id_exilio_acompanamiento is 'Llave primaria';
comment on column analitica.exilio_acompanamiento.id_exilio_movimiento is 'Llave foraneaa movimiento';
comment on column analitica.exilio_acompanamiento.id_exilio is 'Llave foranea a ficha de exilio';
comment on column analitica.exilio_acompanamiento.id_entrevista is 'Llave foranea hacia metadatos';
comment on column analitica.exilio_acompanamiento.codigo_entrevista is 'Código de entrevista';
comment on column analitica.exilio_acompanamiento.macroterritorio is 'Macroterritorio de la entrevista';
comment on column analitica.exilio_acompanamiento.territorio is 'Territorio de la entrevista';
comment on column analitica.exilio_acompanamiento.tipo_movimiento is 'Acompañamiento en la primera salida, reasentamiento, retorno';
comment on column analitica.exilio_acompanamiento.momento is 'Acompañamiento en la salida o en la llegada';
comment on column analitica.exilio_acompanamiento.acompanamiento is 'Acompañamiento';
comment on column analitica.exilio_acompanamiento.institucion_ayuda is 'Nombre de la institución que apoyó el retorno';



-- Impactos y afrontamientos
drop table if exists analitica.exilio_impacto_afrontamiento;
create table if not exists analitica.exilio_impacto_afrontamiento
(
    id_exilio_impacto_afrontamiento serial
        constraint exilio_impacto_afrontamiento_pk
            primary key,
    id_exilio            integer,
    id_entrevista        integer,
    codigo_entrevista    varchar(20),
    macroterritorio  text,
    territorio       text,
    impacto_afrontamiento text,
    movimiento           text,
    tipo              text,
    descripcion       text
);
comment on table analitica.exilio_impacto_afrontamiento is 'Impactos y afrontamientos propios del exilio';

alter table analitica.exilio_impacto_afrontamiento owner to dba;
grant select on analitica.exilio_impacto_afrontamiento to solo_lectura;

create index if not exists exilio_impacto_afrontamiento_codigo_entrevista_index
    on analitica.exilio_impacto_afrontamiento (codigo_entrevista);
create index if not exists exilio_impacto_afrontamiento_id_exilio_index
    on analitica.exilio_impacto_afrontamiento (id_exilio);
create index if not exists exilio_impacto_afrontamiento_id_entrevista_index
    on analitica.exilio_impacto_afrontamiento (id_entrevista);


comment on column analitica.exilio_impacto_afrontamiento.id_exilio_impacto_afrontamiento is 'Llave primaria';
comment on column analitica.exilio_impacto_afrontamiento.id_exilio is 'Llave foranea a ficha de exilio';
comment on column analitica.exilio_impacto_afrontamiento.id_entrevista is 'Llave foranea hacia metadatos';
comment on column analitica.exilio_impacto_afrontamiento.codigo_entrevista is 'Código de entrevista';
comment on column analitica.exilio_impacto_afrontamiento.macroterritorio is 'Macroterritorio de la entrevista';
comment on column analitica.exilio_impacto_afrontamiento.territorio is 'Territorio de la entrevista';
comment on column analitica.exilio_impacto_afrontamiento.impacto_afrontamiento is 'Impacto o afrontamiento';
comment on column analitica.exilio_impacto_afrontamiento.movimiento is 'Primera salida o Retorno';
comment on column analitica.exilio_impacto_afrontamiento.tipo is 'Tipo de impacto/afrontamiento';
comment on column analitica.exilio_impacto_afrontamiento.descripcion is 'Impacto o afrontamiento especificado';




