create table transcribir_asignacion
(
    id_transcribir_asignacion   serial            not null
        constraint transcribir_asignacion_pkey
            primary key,
    id_e_ind_fvt                integer           not null
        constraint public_transcribir_asignacion_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_autoriza                 integer           not null
        constraint public_transcribir_asignacion_id_autoriza_foreign
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    id_transcriptor             integer           not null
        constraint public_transcribir_asignacion_id_transcriptor_foreign
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    id_situacion                integer default 1 not null,
    id_causa                    integer
        constraint public_transcribir_asignacion_id_causa_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    urgente                     integer default 2 not null,
    duracion_entrevista_minutos integer,
    observaciones               text,
    fh_asignado                 timestamp(0)      not null,
    fh_revocado                 timestamp(0)      not null,
    fh_transcrito               timestamp(0)      not null,
    created_at                  timestamp(0),
    updated_at                  timestamp(0)
);

alter table transcribir_asignacion
    owner to dba;

create index public_transcribir_asignacion_id_e_ind_fvt_index
    on transcribir_asignacion (id_e_ind_fvt);

create index public_transcribir_asignacion_id_autoriza_index
    on transcribir_asignacion (id_autoriza);

create index public_transcribir_asignacion_id_transcriptor_index
    on transcribir_asignacion (id_transcriptor);

create index public_transcribir_asignacion_id_causa_index
    on transcribir_asignacion (id_causa);

create index public_transcribir_asignacion_id_situacion_index
    on transcribir_asignacion (id_situacion);

create index public_transcribir_asignacion_urgente_index
    on transcribir_asignacion (urgente);





INSERT INTO "catalogos"."criterio_fijo_grupo" ("id_grupo", "descripcion") VALUES (8, 'Estado de asignacion de transcripcion');
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (8, 1, 'Asignado', 1);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (8, 2, 'Transcrito', 3);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (8, 3, 'Revocado', 2);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (8, 4, 'No transcrito', 4);

insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (84,'Causas por las que no se transcribe el audio','Usado en el panel de transcripcion',1);
insert into catalogos.cat_item (id_cat,descripcion) values (84,'Mala calidad del audio');
insert into catalogos.cat_item (id_cat,descripcion) values (84,'Audio en blanco');
insert into catalogos.cat_item (id_cat,descripcion) values (84,'Audio no corresponde');
insert into catalogos.cat_item (id_cat,descripcion) values (84,'Otros');

-- Roles
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion,orden) values (4, 10, 'Coordinador Transcriptores',10);
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion,orden) values (4, 11, 'Transcriptor/a',11);

-- Nuevos adjuntos
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion,orden) values (1, 12, 'Certificaciones',12);
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion,orden) values (1, 13, 'Evaluación de vulnerabilidad',13);
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion,orden) values (1, 14, 'Evaluación de seguridad',14);

-- traza de auditoria
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (21, 13, 'Asignar transcripcion', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (21, 14, 'Revocar transcripcion', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (21, 15, 'Finalizar transcripcion', DEFAULT);

-- correccion
alter table transcribir_asignacion alter column fh_revocado drop not null;
alter table transcribir_asignacion alter column fh_transcrito drop not null;

-- nuevo excel
drop table if exists esclarecimiento.excel_entrevista_fvt;
create table esclarecimiento.excel_entrevista_fvt
(
    id_e_ind_fvt                integer not null
        constraint excel_entrevista_fvt_pkey
            primary key,
    correlativo                 integer,
    codigo_entrevista           text,
    codigo_entrevistador        text,
    macroterritorio_id          integer,
    macroterritorio_txt         text,
    territorio_id               integer,
    territorio_txt              text,
    grupo_id                    integer,
    grupo_txt                   text,
    entrevista_fecha            text,
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
    prioritario                 integer default 0,
    sector_victima              text,
    interes_etnico              text,
    remitido                    text,
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
    a_consentimiento            text    default '0'::text,
    a_audio                     text    default '0'::text,
    a_ficha_corta               text    default '0'::text,
    a_ficha_larga               text    default '0'::text,
    a_otros                     text    default '0'::text,
    a_transcripcion_preliminar  text    default '0'::text,
    a_transcripcion_final       text    default '0'::text,
    a_retroalimentacion         text    default '0'::text,
    created_at                  timestamp(0),
    updated_at                  timestamp(0)
);

alter table esclarecimiento.excel_entrevista_fvt
    owner to dba;

