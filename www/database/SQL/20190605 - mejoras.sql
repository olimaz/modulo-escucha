-- Analisis preliminar en entervistas individuales

-- de interes para
create table esclarecimiento.e_ind_fvt_interes
(
	id_e_ind_fvt_interes serial
		constraint e_ind_fvt_interes_pk
			primary key,
	id_e_ind_fvt int
		constraint e_ind_fvt_interes_e_ind_fvt_id_e_ind_fvt_fk
			references esclarecimiento.e_ind_fvt (id_e_ind_fvt)
				on update cascade on delete cascade,
	id_interes int
		constraint e_ind_fvt_interes_cat_item_id_item_fk
			references catalogos.cat_item (id_item)
				on update cascade on delete restrict
);

comment on table esclarecimiento.e_ind_fvt_interes is 'Areas de interes de las entrevistas';

create unique index e_ind_fvt_interes_id_e_ind_fvt_id_interes_uindex
	on esclarecimiento.e_ind_fvt_interes (id_e_ind_fvt, id_interes);

create index e_ind_fvt_interes_id_e_ind_fvt_index
	on esclarecimiento.e_ind_fvt_interes (id_e_ind_fvt);

create index e_ind_fvt_interes_id_interes_index
	on esclarecimiento.e_ind_fvt_interes (id_interes);


-- puntos del mandato

create table esclarecimiento.e_ind_fvt_mandato
(
	id_e_ind_fvt_mandato serial
		constraint e_ind_fvt_mandato_pk
			primary key,
	id_e_ind_fvt int
		constraint e_ind_fvt_mandato_e_ind_fvt_id_e_ind_fvt_fk
			references esclarecimiento.e_ind_fvt (id_e_ind_fvt)
				on update cascade on delete cascade,
	id_mandato int
		constraint e_ind_fvt_mandato_cat_item_id_item_fk
			references catalogos.cat_item (id_item)
				on update cascade on delete restrict
);

comment on table esclarecimiento.e_ind_fvt_mandato is 'Puntos del mandato identificados en la entrevista';

create index e_ind_fvt_mandato_id_e_ind_fvt_index
	on esclarecimiento.e_ind_fvt_mandato (id_e_ind_fvt);

create unique index e_ind_fvt_mandato_id_mandato_id_e_ind_fvt_uindex
	on esclarecimiento.e_ind_fvt_mandato (id_mandato, id_e_ind_fvt);

create index e_ind_fvt_mandato_id_mandato_index
	on esclarecimiento.e_ind_fvt_mandato (id_mandato);

-- dinamicas identificadas
create table esclarecimiento.e_ind_fvt_dinamica
(
	id_e_ind_fvt_dinamica serial
		constraint e_ind_fvt_dinamica_pk
			primary key,
	id_e_ind_fvt int
		constraint e_ind_fvt_dinamica_e_ind_fvt_id_e_ind_fvt_fk
			references esclarecimiento.e_ind_fvt (id_e_ind_fvt)
				on update cascade on delete cascade,
	dinamica text not null,
	id_dinamica int
		constraint e_ind_fvt_dinamica_cat_item_id_item_fk
			references catalogos.cat_item (id_item)
				on update cascade on delete restrict
);

comment on table esclarecimiento.e_ind_fvt_dinamica is 'Dinamicas identificadas en la entrevista individual';

create index e_ind_fvt_dinamica_dinamica_index
	on esclarecimiento.e_ind_fvt_dinamica (dinamica);

create index e_ind_fvt_dinamica_id_dinamica_index
	on esclarecimiento.e_ind_fvt_dinamica (id_dinamica);

create index e_ind_fvt_dinamica_id_e_ind_fvt_index
	on esclarecimiento.e_ind_fvt_dinamica (id_e_ind_fvt);

-- Adjunto: Retroalimentación
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (1, 10, 'Retroalimentación a la entrevista', 10);

-- Titulo en entrevista
alter table esclarecimiento.e_ind_fvt
	add titulo text;


-- Excelazo
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
    aa_paramilitar              integer default 0,
    aa_guerrilla                integer default 0,
    aa_fuerza_publica           integer default 0,
    aa_terceros_civiles         integer default 0,
    aa_otro                     integer default 0,
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




-- referencia
update catalogos.cat_item set otro =
       regexp_replace(otro, E'[\\n\\r]+', ' ', 'g' );

update catalogos.cat_item set otro=trim(otro);

update catalogos.cat_item set otro = concat('m',otro) where id_cat=15;