create table fichas.entrevista
(
    id_entrevista serial not null
        constraint entrevista_pkey
            primary key,
    id_e_ind_fvt integer not null
        constraint fichas_entrevista_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete restrict,
    id_idioma integer not null
        constraint fichas_entrevista_id_idioma_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_nativo integer
        constraint fichas_entrevista_id_nativo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    nombre_interprete varchar(200),
    documentacion_aporta integer default 2 not null,
    documentacion_especificar text,
    identifica_testigos integer default 2 not null,
    ampliar_relato integer default 2 not null,
    ampliar_relato_temas text,
    priorizar_entrevista integer default 2 not null,
    priorizar_entrevista_asuntos text,
    contiene_patrones integer default 2 not null,
    contiene_patrones_cuales text,
    indicaciones_transcripcion text,
    observaciones text,
    created_at timestamp(0),
    updated_at timestamp(0),
    identificacion_consentimiento varchar,
    conceder_entrevista integer default 2 not null,
    grabar_audio integer default 2 not null,
    elaborar_informe integer default 2 not null,
    tratamiento_datos_analizar integer default 2 not null,
    tratamiento_datos_analizar_sensible integer default 2 not null,
    tratamiento_datos_utilizar integer default 2 not null,
    tratamiento_datos_utilizar_sensible integer default 2 not null,
    tratamiento_datos_publicar integer default 2 not null
);

alter table fichas.entrevista owner to dba;

create index fichas_entrevista_id_e_ind_fvt_index
    on fichas.entrevista (id_e_ind_fvt);

create index fichas_entrevista_id_idioma_index
    on fichas.entrevista (id_idioma);

create index fichas_entrevista_id_nativo_index
    on fichas.entrevista (id_nativo);

create index fichas_entrevista_documentacion_aporta_index
    on fichas.entrevista (documentacion_aporta);

create index fichas_entrevista_identifica_testigos_index
    on fichas.entrevista (identifica_testigos);

create index fichas_entrevista_ampliar_relato_index
    on fichas.entrevista (ampliar_relato);

create index fichas_entrevista_priorizar_entrevista_index
    on fichas.entrevista (priorizar_entrevista);

create index fichas_entrevista_contiene_patrones_index
    on fichas.entrevista (contiene_patrones);

create table fichas.entrevista_condiciones
(
    id_entrevista_condiciones serial not null
        constraint entrevista_condiciones_pkey
            primary key,
    id_entrevista integer not null
        constraint fichas_entrevista_condiciones_id_entrevista_foreign
            references fichas.entrevista
            on update cascade on delete cascade,
    id_condicion integer not null
        constraint fichas_entrevista_condiciones_id_condicion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table fichas.entrevista_condiciones owner to dba;

create index fichas_entrevista_condiciones_id_entrevista_index
    on fichas.entrevista_condiciones (id_entrevista);

create index fichas_entrevista_condiciones_id_condicion_index
    on fichas.entrevista_condiciones (id_condicion);

create table fichas.entrevista_testigo
(
    id_entrevista_testigo serial not null
        constraint entrevista_testigo_pkey
            primary key,
    id_entrevista integer not null
        constraint fichas_entrevista_testigo_id_entrevista_foreign
            references fichas.entrevista
            on update cascade on delete cascade,
    nombre varchar(200) not null,
    contacto varchar(200),
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table fichas.entrevista_testigo owner to dba;

create index fichas_entrevista_testigo_id_entrevista_index
    on fichas.entrevista_testigo (id_entrevista);

create table fichas.persona
(
    id_persona serial not null
        constraint persona_pkey
            primary key,
    nombre varchar(200),
    apellido varchar(200),
    alias varchar(200),
    fec_nac_a integer,
    fec_nac_m integer,
    fec_nac_d integer,
    id_lugar_nacimiento integer
        constraint fichas_persona_id_lugar_nacimiento_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    id_sexo integer
        constraint fichas_persona_id_sexo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_orientacion integer
        constraint fichas_persona_id_orientacion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_identidad integer
        constraint fichas_persona_id_identidad_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_etnia integer
        constraint fichas_persona_id_etnia_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_tipo_documento integer
        constraint fichas_persona_id_tipo_documento_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    num_documento varchar(20),
    id_nacionalidad integer
        constraint fichas_persona_id_nacionalidad_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_estado_civil integer
        constraint fichas_persona_id_estado_civil_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_lugar_residencia integer
        constraint fichas_persona_id_lugar_residencia_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    telefono varchar(20),
    correo_electronico varchar(200),
    id_zona integer
        constraint fichas_persona_id_zona_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_edu_formal integer
        constraint fichas_persona_id_edu_formal_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    profesion varchar(100),
    ocupacion_actual varchar(100),
    cargo_publico integer default 2 not null,
    cargo_publico_cual varchar(100),
    id_fuerza_publica_estado integer
        constraint fichas_persona_id_fuerza_publica_estado_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_fuerza_publica integer
        constraint fichas_persona_id_fuerza_publica_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_actor_armado integer
        constraint fichas_persona_id_actor_armado_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    organizacion_colectivo integer default 2 not null,
    id_discapacidad integer,
    created_at timestamp(0),
    updated_at timestamp(0),
    id_etnia_indigena integer
        constraint fichas_persona_id_etnia_indigena_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_e_ind_fvt integer not null
        constraint fichas_persona_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_otra_nacionalidad integer
        constraint fichas_persona_id_otra_nacionalidad_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_lugar_residencia_depto integer
        constraint fichas_persona_id_lugar_residencia_depto_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    id_lugar_residencia_muni integer
        constraint fichas_persona_id_lugar_residencia_muni_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    lugar_residencia_nombre_vereda varchar(100),
    id_lugar_nacimiento_depto integer
        constraint fichas_persona_id_lugar_nacimiento_depto_foreign
            references catalogos.geo
            on update cascade on delete restrict
);

alter table fichas.persona owner to dba;

create index fichas_persona_id_edu_formal_index
    on fichas.persona (id_edu_formal);

create index fichas_persona_id_lugar_nacimiento_index
    on fichas.persona (id_lugar_nacimiento);

create index fichas_persona_id_sexo_index
    on fichas.persona (id_sexo);

create index fichas_persona_id_identidad_index
    on fichas.persona (id_identidad);

create index fichas_persona_id_orientacion_index
    on fichas.persona (id_orientacion);

create index fichas_persona_id_etnia_index
    on fichas.persona (id_etnia);

create index fichas_persona_id_tipo_documento_index
    on fichas.persona (id_tipo_documento);

create index fichas_persona_id_nacionalidad_index
    on fichas.persona (id_nacionalidad);

create index fichas_persona_id_estado_civil_index
    on fichas.persona (id_estado_civil);

create index fichas_persona_id_lugar_residencia_index
    on fichas.persona (id_lugar_residencia);

create index fichas_persona_id_zona_index
    on fichas.persona (id_zona);

create index fichas_persona_id_fuerza_publica_estado_index
    on fichas.persona (id_fuerza_publica_estado);

create index fichas_persona_id_fuerza_publica_index
    on fichas.persona (id_fuerza_publica);

create index fichas_persona_id_actor_armado_index
    on fichas.persona (id_actor_armado);

create index fichas_persona_id_etnia_indigena_index
    on fichas.persona (id_etnia_indigena);

create index fichas_persona_id_e_ind_fvt_index
    on fichas.persona (id_e_ind_fvt);

create index fichas_persona_id_otra_nacionalidad_index
    on fichas.persona (id_otra_nacionalidad);

create index fichas_persona_id_lugar_residencia_depto_index
    on fichas.persona (id_lugar_residencia_depto);

create index fichas_persona_id_lugar_residencia_muni_index
    on fichas.persona (id_lugar_residencia_muni);

create index fichas_persona_lugar_residencia_nombre_vereda_index
    on fichas.persona (lugar_residencia_nombre_vereda);

create index fichas_persona_id_lugar_nacimiento_depto_index
    on fichas.persona (id_lugar_nacimiento_depto);

create table fichas.persona_discapacidad
(
    id_persona_discapacidad serial not null
        constraint persona_discapacidad_pkey
            primary key,
    id_persona integer not null
        constraint fichas_persona_discapacidad_id_persona_foreign
            references fichas.persona
            on update cascade on delete cascade,
    id_discapacidad integer not null
        constraint fichas_persona_discapacidad_id_discapacidad_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table fichas.persona_discapacidad owner to dba;

create index fichas_persona_discapacidad_id_persona_index
    on fichas.persona_discapacidad (id_persona);

create index fichas_persona_discapacidad_id_discapacidad_index
    on fichas.persona_discapacidad (id_discapacidad);

create table fichas.persona_aut_etnico_ter
(
    id_persona_aut_etnico_ter serial not null
        constraint persona_aut_etnico_ter_pkey
            primary key,
    id_persona integer not null
        constraint fichas_persona_aut_etnico_ter_id_persona_foreign
            references fichas.persona
            on update cascade on delete cascade,
    id_aut_etnico_ter integer not null
        constraint fichas_persona_aut_etnico_ter_id_aut_etnico_ter_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table fichas.persona_aut_etnico_ter owner to dba;

create index fichas_persona_aut_etnico_ter_id_persona_index
    on fichas.persona_aut_etnico_ter (id_persona);

create index fichas_persona_aut_etnico_ter_id_aut_etnico_ter_index
    on fichas.persona_aut_etnico_ter (id_aut_etnico_ter);

create table fichas.persona_entrevistada
(
    id_persona_entrevistada serial not null
        constraint persona_entrevistada_pkey
            primary key,
    id_persona integer not null
        constraint fichas_persona_entrevistada_id_persona_foreign
            references fichas.persona
            on update cascade on delete cascade,
    id_e_ind_fvt integer not null
        constraint fichas_persona_entrevistada_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    es_victima integer default 2 not null,
    es_testigo integer default 2 not null,
    created_at timestamp(0),
    updated_at timestamp(0),
    constraint fichas_persona_entrevistada_id_persona_id_e_ind_fvt_unique
        unique (id_persona, id_e_ind_fvt)
);

alter table fichas.persona_entrevistada owner to dba;

create index fichas_persona_entrevistada_id_persona_index
    on fichas.persona_entrevistada (id_persona);

create index fichas_persona_entrevistada_id_e_ind_fvt_index
    on fichas.persona_entrevistada (id_e_ind_fvt);

create table fichas.per_ent_rel_victima
(
    id_per_ent_rel_victima serial not null
        constraint per_ent_rel_victima_pkey
            primary key,
    id_persona_entrevistada integer not null
        constraint fichas_per_ent_rel_victima_id_persona_entrevistada_foreign
            references fichas.persona_entrevistada
            on update cascade on delete cascade,
    id_rel_victima integer not null
        constraint fichas_per_ent_rel_victima_id_rel_victima_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table fichas.per_ent_rel_victima owner to dba;

create index fichas_per_ent_rel_victima_id_persona_entrevistada_index
    on fichas.per_ent_rel_victima (id_persona_entrevistada);

create index fichas_per_ent_rel_victima_id_rel_victima_index
    on fichas.per_ent_rel_victima (id_rel_victima);

create table fichas.persona_organizacion
(
    id_persona_organizacion serial not null
        constraint persona_organizacion_pkey
            primary key,
    id_persona integer not null
        constraint fichas_persona_organizacion_id_persona_foreign
            references fichas.persona
            on update cascade on delete cascade,
    nombre varchar(100),
    rol varchar(30),
    id_tipo_organizacion integer not null
        constraint fichas_persona_organizacion_id_tipo_organizacion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table fichas.persona_organizacion owner to dba;

create index fichas_persona_organizacion_id_persona_index
    on fichas.persona_organizacion (id_persona);

create index fichas_persona_organizacion_id_tipo_organizacion_index
    on fichas.persona_organizacion (id_tipo_organizacion);

create table fichas.victima
(
    id_victima serial not null
        constraint victima_pkey
            primary key,
    id_persona integer not null
        constraint fichas_victima_id_persona_foreign
            references fichas.persona
            on update cascade on delete cascade,
    id_e_ind_fvt integer not null
        constraint fichas_victima_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table fichas.victima owner to dba;

create index fichas_victima_id_persona_index
    on fichas.victima (id_persona);

create index fichas_victima_id_e_ind_fvt_index
    on fichas.victima (id_e_ind_fvt);

create table fichas.persona_responsable
(
    id_persona_responsable serial not null
        constraint persona_responsable_pkey
            primary key,
    id_persona integer not null
        constraint fichas_persona_responsable_id_persona_foreign
            references fichas.persona
            on update cascade on delete cascade,
    id_e_ind_fvt integer not null
        constraint fichas_persona_responsable_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    created_at timestamp(0),
    updated_at timestamp(0),
    id_edad_aproximada integer
        constraint fichas_persona_responsable_id_edad_aproximada_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_rango_cargo integer
        constraint fichas_persona_responsable_id_rango_cargo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_grupo_paramilitar integer
        constraint fichas_persona_responsable_id_grupo_paramilitar_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_guerrilla integer
        constraint fichas_persona_responsable_id_guerrilla_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_fuerza_publica integer
        constraint fichas_persona_responsable_id_fuerza_publica_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    nombre_superior varchar(200),
    conoce_info integer default 2 not null,
    que_hace varchar(200),
    donde_esta varchar(200),
    otros_hechos integer default 2 not null,
    cuales varchar(200),
    id_otro integer,
    nombre_indigena varchar
);

alter table fichas.persona_responsable owner to dba;

create index fichas_persona_responsable_id_persona_index
    on fichas.persona_responsable (id_persona);

create index fichas_persona_responsable_id_e_ind_fvt_index
    on fichas.persona_responsable (id_e_ind_fvt);

create index fichas_persona_responsable_id_edad_aproximada_index
    on fichas.persona_responsable (id_edad_aproximada);

create index fichas_persona_responsable_id_rango_cargo_index
    on fichas.persona_responsable (id_rango_cargo);

create index fichas_persona_responsable_id_grupo_paramilitar_index
    on fichas.persona_responsable (id_grupo_paramilitar);

create index fichas_persona_responsable_id_guerrilla_index
    on fichas.persona_responsable (id_guerrilla);

create index fichas_persona_responsable_id_fuerza_publica_index
    on fichas.persona_responsable (id_fuerza_publica);

create table fichas.hecho
(
    id_hecho serial not null
        constraint hecho_pkey
            primary key,
    id_e_ind_fvt integer not null
        constraint fichas_hecho_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    cantidad_victimas integer default 1 not null,
    id_lugar integer not null
        constraint fichas_hecho_id_lugar_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    sitio_especifico varchar(200),
    id_lugar_tipo integer
        constraint fichas_hecho_id_lugar_tipo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    fecha_ocurrencia_d integer,
    fecha_ocurrencia_m integer,
    fecha_ocurrencia_a integer,
    fecha_fin_d integer,
    fecha_fin_m integer,
    fecha_fin_a integer,
    aun_continuan integer default 2 not null,
    observaciones text,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table fichas.hecho owner to dba;

create index fichas_hecho_id_e_ind_fvt_index
    on fichas.hecho (id_e_ind_fvt);

create index fichas_hecho_id_lugar_index
    on fichas.hecho (id_lugar);

create index fichas_hecho_id_lugar_tipo_index
    on fichas.hecho (id_lugar_tipo);

create index fichas_hecho_fecha_ocurrencia_d_index
    on fichas.hecho (fecha_ocurrencia_d);

create index fichas_hecho_fecha_ocurrencia_m_index
    on fichas.hecho (fecha_ocurrencia_m);

create index fichas_hecho_fecha_ocurrencia_a_index
    on fichas.hecho (fecha_ocurrencia_a);

create table fichas.hecho_victima
(
    id_hecho_victima serial not null
        constraint hecho_victima_pkey
            primary key,
    id_hecho integer not null
        constraint fichas_hecho_victima_id_hecho_foreign
            references fichas.hecho
            on update cascade on delete cascade,
    id_victima integer not null
        constraint fichas_hecho_victima_id_victima_foreign
            references fichas.victima
            on update cascade on delete cascade,
    edad integer,
    id_lugar_residencia integer
        constraint fichas_hecho_victima_id_lugar_residencia_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    id_lugar_residencia_tipo integer
        constraint fichas_hecho_victima_id_lugar_residencia_tipo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    ocupacion varchar(200)
);

alter table fichas.hecho_victima owner to dba;

create index fichas_hecho_victima_id_hecho_index
    on fichas.hecho_victima (id_hecho);

create index fichas_hecho_victima_id_victima_index
    on fichas.hecho_victima (id_victima);

create index fichas_hecho_victima_id_lugar_residencia_index
    on fichas.hecho_victima (id_lugar_residencia);

create index fichas_hecho_victima_id_lugar_residencia_tipo_index
    on fichas.hecho_victima (id_lugar_residencia_tipo);

create unique index hecho_victima_id_hecho_id_victima_uindex
    on fichas.hecho_victima (id_hecho, id_victima);

create table fichas.hecho_responsable
(
    id_hecho_responsable serial not null
        constraint hecho_responsable_pkey
            primary key,
    id_hecho integer not null
        constraint fichas_hecho_responsable_id_hecho_foreign
            references fichas.hecho
            on update cascade on delete cascade,
    id_persona_responsable integer not null
        constraint fichas_hecho_responsable_id_persona_responsable_foreign
            references fichas.persona_responsable
            on update cascade on delete cascade
);

alter table fichas.hecho_responsable owner to dba;

create index fichas_hecho_responsable_id_hecho_index
    on fichas.hecho_responsable (id_hecho);

create index fichas_hecho_responsable_id_persona_responsable_index
    on fichas.hecho_responsable (id_persona_responsable);

create unique index hecho_responsable_id_hecho_id_persona_responsable_uindex
    on fichas.hecho_responsable (id_hecho, id_persona_responsable);

create table fichas.hecho_violencia
(
    id_hecho_violencia serial not null
        constraint hecho_violencia_pkey
            primary key,
    id_hecho integer not null
        constraint fichas_hecho_violencia_id_hecho_foreign
            references fichas.hecho
            on update cascade on delete cascade,
    id_tipo_violencia integer not null
        constraint fichas_hecho_violencia_id_tipo_violencia_foreign
            references catalogos.violencia
            on update cascade on delete cascade,
    id_subtipo_violencia integer not null
        constraint fichas_hecho_violencia_id_subtipo_violencia_foreign
            references catalogos.violencia
            on update cascade on delete cascade,
    otro_cual varchar(200),
    cantidad_muertos integer,
    id_individual_colectiva integer,
    id_frente_otros integer,
    id_cometido_varios integer,
    id_hubo_embarazo integer,
    id_hubo_nacimiento integer,
    id_ind_fam_col integer,
    despojo_hectareas integer,
    despojo_recupero_tierras integer,
    despojo_recupero_derechos integer,
    id_lugar_salida integer
        constraint fichas_hecho_violencia_id_lugar_salida_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    id_lugar_llegada integer
        constraint fichas_hecho_violencia_id_lugar_llegada_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    id_lugar_llegada_tipo integer
        constraint fichas_hecho_violencia_id_lugar_llegada_tipo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_sentido_desplazamiento integer
        constraint fichas_hecho_violencia_id_sentido_desplazamiento_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_tuvo_retorno integer,
    id_tuvo_retorno_tipo integer
        constraint fichas_hecho_violencia_id_tuvo_retorno_tipo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_lugar_llegada_2 integer
        constraint fichas_hecho_violencia_id_lugar_llegada_2_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    id_lugar_llegada_2_tipo integer
        constraint fichas_hecho_violencia_id_lugar_llegada_2_tipo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_sentido_desplazamiento_2 integer
        constraint fichas_hecho_violencia_id_sentido_desplazamiento_2_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_tuvo_otros_desplazamientos integer,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.hecho_violencia owner to dba;

create index fichas_hecho_violencia_id_hecho_index
    on fichas.hecho_violencia (id_hecho);

create index fichas_hecho_violencia_id_tipo_violencia_index
    on fichas.hecho_violencia (id_tipo_violencia);

create index fichas_hecho_violencia_id_subtipo_violencia_index
    on fichas.hecho_violencia (id_subtipo_violencia);

create index fichas_hecho_violencia_id_individual_colectiva_index
    on fichas.hecho_violencia (id_individual_colectiva);

create index fichas_hecho_violencia_id_frente_otros_index
    on fichas.hecho_violencia (id_frente_otros);

create index fichas_hecho_violencia_id_cometido_varios_index
    on fichas.hecho_violencia (id_cometido_varios);

create index fichas_hecho_violencia_id_hubo_embarazo_index
    on fichas.hecho_violencia (id_hubo_embarazo);

create index fichas_hecho_violencia_id_hubo_nacimiento_index
    on fichas.hecho_violencia (id_hubo_nacimiento);

create index fichas_hecho_violencia_id_ind_fam_col_index
    on fichas.hecho_violencia (id_ind_fam_col);

create index fichas_hecho_violencia_id_lugar_salida_index
    on fichas.hecho_violencia (id_lugar_salida);

create index fichas_hecho_violencia_id_lugar_llegada_index
    on fichas.hecho_violencia (id_lugar_llegada);

create index fichas_hecho_violencia_id_lugar_llegada_tipo_index
    on fichas.hecho_violencia (id_lugar_llegada_tipo);

create index fichas_hecho_violencia_id_sentido_desplazamiento_index
    on fichas.hecho_violencia (id_sentido_desplazamiento);

create index fichas_hecho_violencia_id_tuvo_retorno_index
    on fichas.hecho_violencia (id_tuvo_retorno);

create index fichas_hecho_violencia_id_tuvo_retorno_tipo_index
    on fichas.hecho_violencia (id_tuvo_retorno_tipo);

create index fichas_hecho_violencia_id_lugar_llegada_2_index
    on fichas.hecho_violencia (id_lugar_llegada_2);

create index fichas_hecho_violencia_id_lugar_llegada_2_tipo_index
    on fichas.hecho_violencia (id_lugar_llegada_2_tipo);

create index fichas_hecho_violencia_id_sentido_desplazamiento_2_index
    on fichas.hecho_violencia (id_sentido_desplazamiento_2);

create index fichas_hecho_violencia_id_tuvo_otros_desplazamientos_index
    on fichas.hecho_violencia (id_tuvo_otros_desplazamientos);

create table fichas.hecho_violencia_mecanismo
(
    id_hecho_violencia_mecanismo serial not null
        constraint hecho_violencia_mecanismo_pkey
            primary key,
    id_hecho_violencia integer not null
        constraint fichas_hecho_violencia_mecanismo_id_hecho_violencia_foreign
            references fichas.hecho_violencia
            on update cascade on delete cascade,
    id_mecanismo integer not null
        constraint fichas_hecho_violencia_mecanismo_id_mecanismo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table fichas.hecho_violencia_mecanismo owner to dba;

create index fichas_hecho_violencia_mecanismo_id_hecho_violencia_index
    on fichas.hecho_violencia_mecanismo (id_hecho_violencia);

create index fichas_hecho_violencia_mecanismo_id_mecanismo_index
    on fichas.hecho_violencia_mecanismo (id_mecanismo);

create table fichas.hecho_responsabilidad
(
    id_hecho_responsabilidad serial not null
        constraint hecho_responsabilidad_pkey
            primary key,
    id_hecho integer not null
        constraint fichas_hecho_responsabilidad_id_hecho_foreign
            references fichas.hecho
            on update cascade on delete cascade,
    aa_id_tipo integer
        constraint fichas_hecho_responsabilidad_aa_id_tipo_foreign
            references catalogos.aa
            on update cascade on delete restrict,
    aa_id_subtipo integer
        constraint fichas_hecho_responsabilidad_aa_id_subtipo_foreign
            references catalogos.aa
            on update cascade on delete restrict,
    aa_nombre_grupo varchar(200),
    aa_bloque varchar(200),
    aa_frente varchar(200),
    aa_unidad varchar(200),
    tc_id_tipo integer
        constraint fichas_hecho_responsabilidad_tc_id_tipo_foreign
            references catalogos.tc
            on update cascade on delete restrict,
    tc_id_subtipo integer
        constraint fichas_hecho_responsabilidad_tc_id_subtipo_foreign
            references catalogos.tc
            on update cascade on delete restrict,
    tc_detalle varchar(255),
    aa_otro_cual varchar(200),
    tc_otro_cual varchar(200),
    otro_actor_cual varchar(200),
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.hecho_responsabilidad owner to dba;

create index fichas_hecho_responsabilidad_id_hecho_index
    on fichas.hecho_responsabilidad (id_hecho);

create index fichas_hecho_responsabilidad_aa_id_tipo_index
    on fichas.hecho_responsabilidad (aa_id_tipo);

create index fichas_hecho_responsabilidad_aa_id_subtipo_index
    on fichas.hecho_responsabilidad (aa_id_subtipo);

create index fichas_hecho_responsabilidad_tc_id_tipo_index
    on fichas.hecho_responsabilidad (tc_id_tipo);

create index fichas_hecho_responsabilidad_tc_id_subtipo_index
    on fichas.hecho_responsabilidad (tc_id_subtipo);

create table fichas.hecho_contexto
(
    id_hecho_contexto serial not null
        constraint hecho_contexto_pkey
            primary key,
    id_hecho integer not null
        constraint fichas_hecho_contexto_id_hecho_foreign
            references fichas.hecho
            on update cascade on delete cascade,
    id_contexto integer not null
        constraint fichas_hecho_contexto_id_contexto_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.hecho_contexto owner to dba;

create index fichas_hecho_contexto_id_hecho_index
    on fichas.hecho_contexto (id_hecho);

create index fichas_hecho_contexto_id_contexto_index
    on fichas.hecho_contexto (id_contexto);

create table fichas.entrevista_impacto
(
    id_entrevista_impacto serial not null
        constraint entrevista_impacto_pkey
            primary key,
    id_e_ind_fvt integer not null
        constraint fichas_entrevista_impacto_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_impacto integer
        constraint fichas_entrevista_impacto_id_impacto_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    transgeneracionales varchar(200),
    afrentamiento_proceso varchar(200),
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.entrevista_impacto owner to dba;

create index fichas_entrevista_impacto_id_e_ind_fvt_index
    on fichas.entrevista_impacto (id_e_ind_fvt);

create index fichas_entrevista_impacto_id_impacto_index
    on fichas.entrevista_impacto (id_impacto);

create table fichas.entrevista_justicia
(
    id_entrevista_justicia serial not null
        constraint entrevista_justicia_pkey
            primary key,
    id_e_ind_fvt integer not null
        constraint fichas_entrevista_justicia_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_denuncio integer default 2 not null,
    porque_no varchar(200),
    id_apoyo integer,
    id_adecuado integer,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.entrevista_justicia owner to dba;

create index fichas_entrevista_justicia_id_e_ind_fvt_index
    on fichas.entrevista_justicia (id_e_ind_fvt);

create index fichas_entrevista_justicia_id_denuncio_index
    on fichas.entrevista_justicia (id_denuncio);

create index fichas_entrevista_justicia_id_apoyo_index
    on fichas.entrevista_justicia (id_apoyo);

create index fichas_entrevista_justicia_id_adecuado_index
    on fichas.entrevista_justicia (id_adecuado);

create table fichas.justicia_institucion
(
    id_justicia_institucion serial not null
        constraint justicia_institucion_pkey
            primary key,
    id_e_ind_fvt integer not null
        constraint fichas_justicia_institucion_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_tipo integer default 0 not null,
    id_institucion integer not null
        constraint fichas_justicia_institucion_id_institucion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.justicia_institucion owner to dba;

create index fichas_justicia_institucion_id_e_ind_fvt_index
    on fichas.justicia_institucion (id_e_ind_fvt);

create index fichas_justicia_institucion_id_institucion_index
    on fichas.justicia_institucion (id_institucion);

create table fichas.justicia_porque
(
    id_justicia_porque serial not null
        constraint justicia_porque_pkey
            primary key,
    id_e_ind_fvt integer not null
        constraint fichas_justicia_porque_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_tipo integer default 0 not null,
    id_porque integer not null
        constraint fichas_justicia_porque_id_porque_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.justicia_porque owner to dba;

create index fichas_justicia_porque_id_e_ind_fvt_index
    on fichas.justicia_porque (id_e_ind_fvt);

create index fichas_justicia_porque_id_porque_index
    on fichas.justicia_porque (id_porque);

create table fichas.justicia_objetivo
(
    id_justicia_objetivo serial not null
        constraint justicia_objetivo_pkey
            primary key,
    id_e_ind_fvt integer not null
        constraint fichas_justicia_objetivo_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_tipo integer default 0 not null,
    id_objetivo integer not null
        constraint fichas_justicia_objetivo_id_objetivo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.justicia_objetivo owner to dba;

create index fichas_justicia_objetivo_id_e_ind_fvt_index
    on fichas.justicia_objetivo (id_e_ind_fvt);

create index fichas_justicia_objetivo_id_objetivo_index
    on fichas.justicia_objetivo (id_objetivo);

create table fichas.persona_responsable_responsabilidades
(
    id_persona_responsable_responsabilidades serial not null
        constraint persona_responsable_responsabilidades_pkey
            primary key,
    id_persona_responsable integer not null
        constraint fichas_persona_responsable_responsabilidades_id_persona_respons
            references fichas.persona_responsable
            on update cascade on delete cascade,
    id_responsabilidad integer not null
        constraint fichas_persona_responsable_responsabilidades_id_responsabilidad
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table fichas.persona_responsable_responsabilidades owner to dba;

create index fichas_persona_responsable_responsabilidades_id_persona_respons
    on fichas.persona_responsable_responsabilidades (id_persona_responsable);

create index fichas_persona_responsable_responsabilidades_id_responsabilidad
    on fichas.persona_responsable_responsabilidades (id_responsabilidad);

create table fichas.exilio
(
    id_exilio serial not null
        constraint exilio_pkey
            primary key,
    id_e_ind_fvt integer not null
        constraint fichas_exilio_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_ha_tenido_retorno integer,
    entidad_apoyo_retorno varchar(200),
    id_ha_tenido_ayuda integer,
    institucion_ayuda varchar(200),
    id_retorno integer,
    id_otro_exilio integer,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.exilio owner to dba;

create index fichas_exilio_id_e_ind_fvt_index
    on fichas.exilio (id_e_ind_fvt);

create index fichas_exilio_id_ha_tenido_retorno_index
    on fichas.exilio (id_ha_tenido_retorno);

create index fichas_exilio_id_ha_tenido_ayuda_index
    on fichas.exilio (id_ha_tenido_ayuda);

create index fichas_exilio_id_retorno_index
    on fichas.exilio (id_retorno);

create index fichas_exilio_id_otro_exilio_index
    on fichas.exilio (id_otro_exilio);

create table fichas.exilio_categoria
(
    id_exilio_categoria serial not null
        constraint exilio_categoria_pkey
            primary key,
    id_exilio integer not null
        constraint fichas_exilio_categoria_id_exilio_foreign
            references fichas.exilio
            on update cascade on delete cascade,
    id_categoria integer not null
        constraint fichas_exilio_categoria_id_categoria_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.exilio_categoria owner to dba;

create index fichas_exilio_categoria_id_exilio_index
    on fichas.exilio_categoria (id_exilio);

create index fichas_exilio_categoria_id_categoria_index
    on fichas.exilio_categoria (id_categoria);

create table fichas.exilio_movimiento
(
    id_exilio_movimiento serial not null
        constraint exilio_movimiento_pkey
            primary key,
    id_exilio integer not null
        constraint fichas_exilio_movimiento_id_exilio_foreign
            references fichas.exilio
            on update cascade on delete cascade,
    id_tipo_movimiento integer not null,
    fecha_salida_d integer default 0 not null,
    fecha_salida_m integer default 0 not null,
    fecha_salida_a integer default 0 not null,
    id_lugar_salida integer
        constraint fichas_exilio_movimiento_id_lugar_salida_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    salida_pais varchar(200),
    salida_estado varchar(200),
    salida_ciudad varchar(200),
    fecha_llegada_d integer default 0 not null,
    fecha_llegada_m integer default 0 not null,
    fecha_llegada_a integer default 0 not null,
    id_lugar_llegada integer
        constraint fichas_exilio_movimiento_id_lugar_llegada_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    llegada_pais varchar(200),
    llegada_estado varchar(200),
    llegada_ciudad varchar(200),
    llegada_2_pais varchar(200),
    llegada_2_estado varchar(200),
    llegada_2_ciudad varchar(200),
    fecha_asentamiento_d integer default 0 not null,
    fecha_asentamiento_m integer default 0 not null,
    fecha_asentamiento_a integer default 0 not null,
    id_modalidad integer
        constraint fichas_exilio_movimiento_id_modalidad_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    cant_personas_salieron integer default 0 not null,
    cant_personas_familia_salieron integer default 0 not null,
    cant_personas_familia_quedaron integer default 0 not null,
    id_solicitado_proteccion integer
        constraint fichas_exilio_movimiento_id_solicitado_proteccion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_estado_proteccion integer
        constraint fichas_exilio_movimiento_id_estado_proteccion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_aprobada_proteccion integer
        constraint fichas_exilio_movimiento_id_aprobada_proteccion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_denegada_proteccion integer
        constraint fichas_exilio_movimiento_id_denegada_proteccion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_residencia_proteccion integer
        constraint fichas_exilio_movimiento_id_residencia_proteccion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_expulsion integer,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.exilio_movimiento owner to dba;

create index fichas_exilio_movimiento_id_tipo_movimiento_index
    on fichas.exilio_movimiento (id_tipo_movimiento);

create index fichas_exilio_movimiento_id_exilio_index
    on fichas.exilio_movimiento (id_exilio);

create index fichas_exilio_movimiento_id_modalidad_index
    on fichas.exilio_movimiento (id_modalidad);

create index fichas_exilio_movimiento_id_lugar_salida_index
    on fichas.exilio_movimiento (id_lugar_salida);

create index fichas_exilio_movimiento_id_lugar_llegada_index
    on fichas.exilio_movimiento (id_lugar_llegada);

create index fichas_exilio_movimiento_id_solicitado_proteccion_index
    on fichas.exilio_movimiento (id_solicitado_proteccion);

create index fichas_exilio_movimiento_id_estado_proteccion_index
    on fichas.exilio_movimiento (id_estado_proteccion);

create index fichas_exilio_movimiento_id_aprobada_proteccion_index
    on fichas.exilio_movimiento (id_aprobada_proteccion);

create index fichas_exilio_movimiento_id_denegada_proteccion_index
    on fichas.exilio_movimiento (id_denegada_proteccion);

create index fichas_exilio_movimiento_id_residencia_proteccion_index
    on fichas.exilio_movimiento (id_residencia_proteccion);

create table fichas.exilio_movimiento_proteccion
(
    id_exilio_movimiento_proteccion serial not null
        constraint exilio_movimiento_proteccion_pkey
            primary key,
    id_exilio_movimiento integer not null
        constraint fichas_exilio_movimiento_proteccion_id_exilio_movimiento_foreig
            references fichas.exilio_movimiento
            on update cascade on delete cascade,
    id_proteccion integer not null
        constraint fichas_exilio_movimiento_proteccion_id_proteccion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null,
    id_tipo integer default 1
);

comment on column fichas.exilio_movimiento_proteccion.id_tipo is '1:acompañamiento en la salida. 2:en la llegada';

alter table fichas.exilio_movimiento_proteccion owner to dba;

create index fichas_exilio_movimiento_proteccion_id_exilio_movimiento_index
    on fichas.exilio_movimiento_proteccion (id_exilio_movimiento);

create index fichas_exilio_movimiento_proteccion_id_proteccion_index
    on fichas.exilio_movimiento_proteccion (id_proteccion);

create index exilio_movimiento_proteccion_id_tipo_index
    on fichas.exilio_movimiento_proteccion (id_tipo);

create table fichas.exilio_impacto
(
    id_exilio_impacto serial not null
        constraint exilio_impacto_pkey
            primary key,
    id_exilio integer not null
        constraint fichas_exilio_impacto_id_exilio_foreign
            references fichas.exilio
            on update cascade on delete cascade,
    id_impacto integer not null
        constraint fichas_exilio_impacto_id_impacto_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.exilio_impacto owner to dba;

create index fichas_exilio_impacto_id_exilio_index
    on fichas.exilio_impacto (id_exilio);

create index fichas_exilio_impacto_id_impacto_index
    on fichas.exilio_impacto (id_impacto);

create table fichas.exilio_movimiento_motivo
(
    id_exilio_movimiento_motivo serial not null
        constraint exilio_movimiento_motivo_pkey
            primary key,
    id_exilio_movimiento integer not null
        constraint fichas_exilio_movimiento_motivo_id_exilio_movimiento_foreign
            references fichas.exilio_movimiento
            on update cascade on delete cascade,
    id_motivo integer not null
        constraint fichas_exilio_movimiento_motivo_id_motivo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.exilio_movimiento_motivo owner to dba;

create index fichas_exilio_movimiento_motivo_id_exilio_movimiento_index
    on fichas.exilio_movimiento_motivo (id_exilio_movimiento);

create index fichas_exilio_movimiento_motivo_id_motivo_index
    on fichas.exilio_movimiento_motivo (id_motivo);

create table fichas.victima_duplicada
(
    id_victima_duplicada serial not null
        constraint victima_duplicada_pkey
            primary key,
    id_victima integer not null
        constraint fichas_victima_duplicada_id_victima_foreign
            references fichas.victima
            on update cascade on delete cascade,
    id_e_inv_fvt_nueva integer not null
        constraint fichas_victima_duplicada_id_e_inv_fvt_nueva_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_e_inv_fvt_existente integer not null
        constraint fichas_victima_duplicada_id_e_inv_fvt_existente_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    estado boolean default true not null,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table fichas.victima_duplicada owner to dba;

create index fichas_victima_duplicada_id_victima_index
    on fichas.victima_duplicada (id_victima);

