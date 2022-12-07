-- Obtener el ID y agregarlo en .env como EE
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 1, 'Entrevista a sujeto colectivo', 'EE', null, DEFAULT, DEFAULT, null, DEFAULT);
select * from catalogos.cat_item where id_cat=1 and descripcion ilike '%sujeto%';
-- Traza de seguridad
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (22, 14, 'Entrevista etnica', DEFAULT);

-- determinar el id_cat en cat_item
alter table esclarecimiento.e_ind_fvt drop constraint e_ind_fvt_cat_item_id_item_fk_4;
select * from catalogos.cat_item where id_cat=27 and descripcion ilike '%mestizo%';

update esclarecimiento.e_ind_fvt
    set id_etnico=1 where id_etnico is not null  and id_etnico <> 207;
update esclarecimiento.e_ind_fvt
    set id_etnico=2 where id_etnico is  null  or id_etnico <> 207;

insert into catalogos.cat_item (id_cat, descripcion) values (18,'Afrocolombianos, negros, raizal, palenquero');
insert into catalogos.cat_item (id_cat, descripcion) values (18,'Rrom');

--determinar el id del nucleo 8 (cat 19)
select * from catalogos.cat_item where id_cat=19 and descripcion like '8%';
update catalogos.cat_item set descripcion='8: Causas, Dinámicas e Impactos del Conflicto Armado Interno en los Pueblos Étnicos.' where id_item=242;
-- Entrevista Etnica
create table esclarecimiento.entrevista_etnica
(
    id_entrevista_etnica serial            not null
        constraint entrevista_etnica_pkey
            primary key,
    id_macroterritorio      integer           not null
        constraint esclarecimiento_entrevista_etnica_id_macroterritorio_foreign
            references catalogos.cev
            on update cascade on delete restrict,
    id_territorio           integer           not null
        constraint esclarecimiento_entrevista_etnica_id_territorio_foreign
            references catalogos.cev
            on update cascade on delete restrict,
    id_entrevistador        integer           not null
        constraint esclarecimiento_entrevista_etnica_id_entrevistador_foreign
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    numero_entrevistador    integer           not null,
    entrevista_codigo       varchar(20)       not null,
    entrevista_correlativo  integer           not null,
    entrevista_numero       integer           not null,
    entrevista_lugar        integer           not null
        constraint esclarecimiento_entrevista_etnica_entrevista_lugar_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    equipo_facilitador      varchar(255)      not null,
    equipo_memorista        varchar(255)      not null,
    equipo_otros            text,
    tema_descripcion        text              not null,
    tema_objetivo           text              not null,
    tema_del                timestamp(0)      not null,
    tema_al                 timestamp(0)      not null,
    tema_lugar              integer           not null
        constraint esclarecimiento_entrevista_etnica_tema_lugar_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    cantidad_participantes  integer           not null,
    id_sector               integer           not null
        constraint esclarecimiento_entrevista_etnica_id_sector_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    eventos_descripcion     text              not null,
    observaciones           text,
    clasificacion_nna       integer default 1 not null,
    clasificacion_sex       integer default 1 not null,
    clasificacion_res       integer default 1 not null,
    clasificacion_nivel     integer default 3 not null,
    id_usuario              integer           not null
        constraint esclarecimiento_entrevista_etnica_id_usuario_foreign
            references users
            on update cascade on delete restrict,
    created_at              timestamp(0),
    updated_at              timestamp(0),
    entrevista_fecha_inicio timestamp         not null,
    entrevista_fecha_final  timestamp,
    entrevista_avance       integer,
    titulo                  text,
    duracion_entrevista_minutos integer default 0
);

alter table esclarecimiento.entrevista_etnica
    owner to dba;

create index esclarecimiento_entrevista_etnica_id_macroterritorio_index
    on esclarecimiento.entrevista_etnica (id_macroterritorio);

create index esclarecimiento_entrevista_etnica_id_territorio_index
    on esclarecimiento.entrevista_etnica (id_territorio);

create index esclarecimiento_entrevista_etnica_id_entrevistador_index
    on esclarecimiento.entrevista_etnica (id_entrevistador);

create index esclarecimiento_entrevista_etnica_entrevista_codigo_index
    on esclarecimiento.entrevista_etnica (entrevista_codigo);

create index esclarecimiento_entrevista_etnica_entrevista_correlativo_ind
    on esclarecimiento.entrevista_etnica (entrevista_correlativo);

create index esclarecimiento_entrevista_etnica_entrevista_numero_index
    on esclarecimiento.entrevista_etnica (entrevista_numero);

create index esclarecimiento_entrevista_etnica_entrevista_lugar_index
    on esclarecimiento.entrevista_etnica (entrevista_lugar);

create index esclarecimiento_entrevista_etnica_tema_del_index
    on esclarecimiento.entrevista_etnica (tema_del);

create index esclarecimiento_entrevista_etnica_tema_al_index
    on esclarecimiento.entrevista_etnica (tema_al);

create index esclarecimiento_entrevista_etnica_tema_lugar_index
    on esclarecimiento.entrevista_etnica (tema_lugar);

create index esclarecimiento_entrevista_etnica_clasificacion_nivel_index
    on esclarecimiento.entrevista_etnica (clasificacion_nivel);

create index esclarecimiento_entrevista_etnica_id_sector_index
    on esclarecimiento.entrevista_etnica (id_sector);

create index esclarecimiento_entrevista_etnica_id_usuario_index
    on esclarecimiento.entrevista_etnica (id_usuario);

create index entrevista_etnica_entrevista_avance_index
    on esclarecimiento.entrevista_etnica (entrevista_avance);

create index entrevista_etnica_entrevista_fecha_final_index
    on esclarecimiento.entrevista_etnica (entrevista_fecha_final);

create index entrevista_etnica_entrevista_fecha_inicio_index
    on esclarecimiento.entrevista_etnica (entrevista_fecha_inicio);


-- Adjuntos
create table esclarecimiento.entrevista_etnica_adjunto
(
    id_entrevista_etnica_adjunto serial  not null
        constraint entrevista_etnica_adjunto_pkey
            primary key,
    id_entrevista_etnica         integer not null
        constraint esclarecimiento_entrevista_etnica_adjunto_id_entrevista_cole
            references esclarecimiento.entrevista_etnica
            on update cascade on delete cascade,
    id_adjunto                      integer not null
        constraint esclarecimiento_entrevista_etnica_adjunto_id_adjunto_foreign
            references esclarecimiento.adjunto
            on update cascade on delete restrict,
    id_tipo                         integer not null,
    id_usuario                      integer not null,
    created_at                      timestamp(0),
    updated_at                      timestamp(0)
);

alter table esclarecimiento.entrevista_etnica_adjunto
    owner to dba;

create index esclarecimiento_entrevista_etnica_adjunto_id_entrevista_etnica
    on esclarecimiento.entrevista_etnica_adjunto (id_entrevista_etnica);

create index esclarecimiento_entrevista_etnica_adjunto_id_adjunto_index
    on esclarecimiento.entrevista_etnica_adjunto (id_adjunto);


-- Dinamicas
create table esclarecimiento.entrevista_etnica_dinamica
(
    id_entrevista_etnica_dinamica serial not null
        constraint entrevista_etnica_dinamica_pk
            primary key,
    id_entrevista_etnica          integer
        constraint entrevista_etnica_dinamica_entrevista_etnica_id_entrevist
            references esclarecimiento.entrevista_etnica
            on update cascade on delete cascade,
    dinamica                         text   not null,
    id_dinamica                      integer
        constraint entrevista_etnica_dinamica_cat_item_id_item_fk
            references catalogos.cat_item
            on update cascade on delete restrict
);

comment on table esclarecimiento.entrevista_etnica_dinamica is 'Dinamicas identificadas';

alter table esclarecimiento.entrevista_etnica_dinamica
    owner to dba;

create index entrevista_etnica_dinamica_dinamica_index
    on esclarecimiento.entrevista_etnica_dinamica(dinamica);

create index entrevista_etnica_dinamica_id_dinamica_index
    on esclarecimiento.entrevista_etnica_dinamica (id_dinamica);

create index entrevista_etnica_dinamica_id_entrevista_etnica_index
    on esclarecimiento.entrevista_etnica_dinamica (id_entrevista_etnica);



-- Interes para 
create table esclarecimiento.entrevista_etnica_interes
(
    id_entrevista_etnica_interes serial not null
        constraint entrevista_etnica_interes_pk
            primary key,
    id_entrevista_etnica         integer
        constraint entrevista_etnica_interes_entrevista_etnica_id_entrevista
            references esclarecimiento.entrevista_etnica
            on update cascade on delete cascade,
    id_interes                      integer
        constraint entrevista_etnica_interes_cat_item_id_item_fk
            references catalogos.cat_item
            on update cascade on delete restrict
);

comment on table esclarecimiento.entrevista_etnica_interes is 'Nucleos temáticos de interés';

alter table esclarecimiento.entrevista_etnica_interes
    owner to dba;

create unique index entrevista_etnica_interes_id_entrevista_etnica_id_interes
    on esclarecimiento.entrevista_etnica_interes (id_entrevista_etnica, id_interes);

create index entrevista_etnica_interes_id_entrevista_etnica_index
    on esclarecimiento.entrevista_etnica_interes (id_entrevista_etnica);

create index entrevista_etnica_interes_id_interes_index
    on esclarecimiento.entrevista_etnica_interes (id_interes);
    
-- Coincidencia con nucleos del mandato
create table esclarecimiento.entrevista_etnica_mandato
(
    id_entrevista_etnica_mandato serial  not null
        constraint entrevista_etnica_mandato_pkey
            primary key,
    id_entrevista_etnica         integer not null
        constraint esclarecimiento_entrevista_etnica_mandato_id_entrevista_cole
            references esclarecimiento.entrevista_etnica
            on update cascade on delete cascade,
    id_mandato                      integer not null
        constraint esclarecimiento_entrevista_etnica_mandato_id_mandato_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_usuario                      integer not null,
    created_at                      timestamp(0),
    updated_at                      timestamp(0)
);

alter table esclarecimiento.entrevista_etnica_mandato
    owner to dba;

create index esclarecimiento_entrevista_etnica_mandato_id_entrevista_cole
    on esclarecimiento.entrevista_etnica_mandato (id_entrevista_etnica);

create index esclarecimiento_entrevista_etnica_mandato_id_mandato_index
    on esclarecimiento.entrevista_etnica_mandato (id_mandato);


-- Añadir tiempo de la entrevista
alter table esclarecimiento.e_ind_fvt
	add tiempo_entrevista int default 0;

alter table esclarecimiento.diagnostico_comunitario
	add tiempo_entrevista int default 0;

alter table esclarecimiento.entrevista_colectiva
	add tiempo_entrevista int default 0;

alter table esclarecimiento.entrevista_etnica
	add tiempo_entrevista int default 0;

alter table esclarecimiento.entrevista_profundidad
	add tiempo_entrevista int default 0;

alter table esclarecimiento.historia_vida
	add tiempo_entrevista int default 0;


-- Cambios al excel
drop table if exists esclarecimiento.excel_entrevista_fvt;
create table esclarecimiento.excel_entrevista_fvt
(
    id_e_ind_fvt                integer      not null
        constraint excel_entrevista_fvt_pkey
            primary key,
    correlativo                 integer,
    clasificacion               integer default 3,
    codigo_entrevista           text,
    codigo_entrevistador        text,
    macroterritorio_id          integer,
    macroterritorio_txt         text,
    territorio_id               integer,
    territorio_txt              text,
    grupo_id                    integer,
    grupo_txt                   text,
    entrevista_fecha            text,
    tiempo_entrevista            integer default 0,
    entrevista_lugar_n1_codigo  text,
    entrevista_lugar_n1_txt     text,
    entrevista_lugar_n2_codigo  text,
    entrevista_lugar_n2_txt     text,
    entrevista_lugar_n3_codigo  text,
    entrevista_lugar_n3_txt     text,
    titulo                      text,
    hechos_lugar_n1_codigo      text,
    hechos_lugar_n1_txt         text,
    hechos_lugar_n2_codigo      text,
    hechos_lugar_n2_txt         text,
    hechos_lugar_n3_codigo      text,
    hechos_lugar_n3_txt         text,
    hechos_del                  text,
    hechos_al                   text,
    anotaciones                 text,
    es_prioritario              integer default 0,
    prioritario_tema            text,
    sector_victima              text,
    interes_etnico              integer default 0,
    remitido                    text,
    transcrita                  text,
    aa_paramilitar              integer default 0,
    aa_guerrilla                integer default 0,
    aa_fuerza_publica           integer default 0,
    aa_terceros_civiles         integer default 0,
    aa_otro_grupo_armado        integer default 0,
    aa_otro_agente_estado       integer default 0,
    aa_otro_actor               integer default 0,
    aa_ns_nr                    integer default 0,
    aa_internacional            integer default 0,
    viol_homicidio              integer default 0,
    viol_atentado_vida          integer default 0,
    viol_amenaza_vida           integer default 0,
    viol_desaparicion_f         integer default 0,
    viol_tortura                integer default 0,
    viol_violencia_sexual       integer default 0,
    viol_esclavitud             integer default 0,
    viol_reclutamiento          integer default 0,
    viol_detencion_arbitraria   integer default 0,
    viol_secuestro              integer default 0,
    viol_confinamiento          integer default 0,
    viol_pillaje                integer default 0,
    viol_extorsion              integer default 0,
    viol_ataque_bien_protegido  integer default 0,
    viol_ataque_indiscriminado  integer default 0,
    viol_despojo_tierras        integer default 0,
    viol_desplazamiento_forzado integer default 0,
    viol_exilio                 integer default 0,
    i_objetivo_esclarecimiento  integer default 0,
    i_objetivo_reconocimiento   integer default 0,
    i_objetivo_convivencia      integer default 0,
    i_objetivo_no_repeticion    integer default 0,
    i_enfoque_genero            integer default 0,
    i_enfoque_psicosocial       integer default 0,
    i_enfoque_curso_vida        integer default 0,
    i_direccion_investigacion   integer default 0,
    i_direccion_territorios     integer default 0,
    i_direccion_etnica          integer default 0,
    i_comisionados              integer default 0,
    i_estrategia_arte           integer default 0,
    i_estrategia_comunicacion   integer default 0,
    i_estrategia_participacion  integer default 0,
    i_estrategia_pedagogia      integer default 0,
    i_grupo_acceso_informacion  integer default 0,
    i_presidencia               integer default 0,
    i_otra                      integer default 0,
    i_enlace                    integer default 0,
    i_sistema_informacion       integer default 0,
    ia_pueblo_etnico            integer default 0,
    ia_dialogo_social           integer default 0,
    ia_ds_o_convivencia         integer default 0,
    ia_ds_o_reconocimiento      integer default 0,
    ia_ds_o_no_repeticion       integer default 0,
    ia_genero                   integer default 0,
    ia_enfoque_ps               integer default 0,
    ia_curso_vida               integer default 0,
    nucleo_01                   integer default 0,
    nucleo_02                   integer default 0,
    nucleo_03                   integer default 0,
    nucleo_04                   integer default 0,
    nucleo_05                   integer default 0,
    nucleo_06                   integer default 0,
    nucleo_07                   integer default 0,
    nucleo_08                   integer default 0,
    nucleo_09                   integer default 0,
    nucleo_10                   integer default 0,
    mandato_01                  integer default 0,
    mandato_02                  integer default 0,
    mandato_03                  integer default 0,
    mandato_04                  integer default 0,
    mandato_05                  integer default 0,
    mandato_06                  integer default 0,
    mandato_07                  integer default 0,
    mandato_08                  integer default 0,
    mandato_09                  integer default 0,
    mandato_10                  integer default 0,
    mandato_11                  integer default 0,
    mandato_12                  integer default 0,
    mandato_13                  integer default 0,
    dinamica_1                  text,
    dinamica_2                  text,
    dinamica_3                  text,
    a_consentimiento            integer default 0,
    a_audio                     integer default 0,
    a_ficha_corta               integer default 0,
    a_ficha_larga               integer default 0,
    a_otros                     integer default 0,
    a_transcripcion_preliminar  integer default 0,
    a_transcripcion_final       integer default 0,
    a_retroalimentacion         integer default 0,
    entrevista_lat              double precision,
    entrevista_lon              double precision,
    hechos_lat                  double precision,
    hechos_lon                  double precision,
    transcripcion_html          text,
    created_at                  timestamp(0) not null,
    updated_at                  timestamp(0) not null
);

alter table esclarecimiento.excel_entrevista_fvt
    owner to dba;

GRANT SELECT ON esclarecimiento.excel_entrevista_fvt TO solo_lectura;


    



