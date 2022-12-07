-- error de diseño
drop index esclarecimiento.e_ind_fvt__unico_entrevistador_entrevista;

create index e_ind_fvt_id_entrevistador_id_subserie_entrevista_numero_index
    on esclarecimiento.e_ind_fvt (id_entrevistador, id_subserie, entrevista_numero);

-- tipo de instrumento

UPDATE "catalogos"."cat_item" SET "abreviado" = 'AA' WHERE "id_item" = 4;
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 1, 'Entrevista a Terceros civiles', 'TC', null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 1, 'Entrevista a Profundiad', 'PR', null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 1, 'Hoja de Vida', 'HV', null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 1, 'Casos e Informes', 'CI', null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 1, 'Entrevistas Colectivas', 'CO', null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 1, 'Diagnóstico Comunitario', 'DC', null, DEFAULT, DEFAULT, null, DEFAULT);


UPDATE "catalogos"."cat_cat" SET "descripcion" = 'Utilizado para clasificar documentos de referencia' WHERE "id_cat" = 6;
UPDATE "catalogos"."cat_cat" SET "descripcion" = 'Utilizado para clasificar documentos de referencia' WHERE "id_cat" = 7;

-- actores armados y terceros civiles
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (8, 'Temas Actores Armados', 'Para clasificar las entrevistas', DEFAULT);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (9, 'Temas Terceros Civiles', 'Para clasificar las entrevistas', DEFAULT);

INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 8, 'Vida intrafilas', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 8, 'Dinámicas y patrones de violencia', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 8, 'Hechos y responsabilidades específicas', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 8, 'Impactos y afrontamiento', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 8, 'Desmovilización y reintegración', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 8, 'Contribución a justicia, verdad, reparación y no repetición', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 9, 'Dinámicas de participación/beneficios', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 9, 'Hechos y responsabilidades en las violencias', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 9, 'Impactos y afrontamiento', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 9, 'Contribución a justicia, verdad, reparación y no repetición', null, null, DEFAULT, DEFAULT, null, DEFAULT);


INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (10, 'Sectores de los  Terceros Civiles', 'Para clasificar las entrevistas', DEFAULT);
INSERT INTO "catalogos"."cat_item" (id_cat, descripcion) VALUES (10,'Persona natural (Ciudadano común)');
INSERT INTO "catalogos"."cat_item" (id_cat, descripcion) VALUES (10,'Sector político');
INSERT INTO "catalogos"."cat_item" (id_cat, descripcion) VALUES (10,'Medios de comunicaciones');
INSERT INTO "catalogos"."cat_item" (id_cat, descripcion) VALUES (10,'Sector social/comunitario');
INSERT INTO "catalogos"."cat_item" (id_cat, descripcion) VALUES (10,'Sector académico/escolar');
INSERT INTO "catalogos"."cat_item" (id_cat, descripcion) VALUES (10,'Sector religioso');
INSERT INTO "catalogos"."cat_item" (id_cat, descripcion) VALUES (10,'Sector económico');
INSERT INTO "catalogos"."cat_item" (id_cat, descripcion) VALUES (10,'Otro sector');

UPDATE "catalogos"."cat_item" SET "descripcion" = 'Entrevista a Actores Armados' WHERE "id_item" = 4;
-- tabla hija


create table esclarecimiento.e_ind_fvt_aa
(
    id_e_ind_fvt_aa serial  not null
        constraint e_ind_fvt_aa_pk
        primary key,
    id_e_ind_fvt    integer not null
        constraint e_ind_fvt_aa_e_ind_fvt_id_e_ind_fvt_fk
        references esclarecimiento.e_ind_fvt
        on update cascade on delete cascade,
    id_aa           integer not null
        constraint e_ind_fvt_aa_cat_item_id_item_fk
        references catalogos.cat_item
        on update restrict on delete restrict
);


comment on table esclarecimiento.e_ind_fvt_aa is 'Temas abordados en entrevistas a actores armados';

comment on column esclarecimiento.e_ind_fvt_aa.id_aa is 'Catalogo 8';

alter table esclarecimiento.e_ind_fvt_aa
    owner to dba;

create index e_ind_fvt_aa_id_e_ind_fvt_index
    on esclarecimiento.e_ind_fvt_aa (id_e_ind_fvt);

create index e_ind_fvt_fr_id_aa_index
    on esclarecimiento.e_ind_fvt_aa (id_aa);




create table esclarecimiento.e_ind_fvt_tc
(
    id_e_ind_fvt_tc serial  not null
        constraint e_ind_fvt_tc_pk
        primary key,
    id_e_ind_fvt    integer not null
        constraint e_ind_fvt_tc_e_ind_fvt_id_e_ind_fvt_fk
        references esclarecimiento.e_ind_fvt
        on update cascade on delete cascade,
    id_tc           integer not null
        constraint e_ind_fvt_tc_cat_item_id_item_fk
        references catalogos.cat_item
        on update restrict on delete restrict
);


comment on table esclarecimiento.e_ind_fvt_tc is 'Temas abordados en entrevistas a terceros civiles';

comment on column esclarecimiento.e_ind_fvt_tc.id_tc is 'Catalogo 9';

alter table esclarecimiento.e_ind_fvt_tc
    owner to dba;

create index e_ind_fvt_tc_id_e_ind_fvt_index
    on esclarecimiento.e_ind_fvt_tc (id_e_ind_fvt);

create index e_ind_fvt_fr_id_tc_index
    on esclarecimiento.e_ind_fvt_tc (id_tc);




-- stc: sector al que pertenece

create table esclarecimiento.e_ind_fvt_stc
(
    id_e_ind_fvt_stc serial  not null
        constraint e_ind_fvt_stc_pk
        primary key,
    id_e_ind_fvt    integer not null
        constraint e_ind_fvt_stc_e_ind_fvt_id_e_ind_fvt_fk
        references esclarecimiento.e_ind_fvt
        on update cascade on delete cascade,
    id_stc           integer not null
        constraint e_ind_fvt_stc_cat_item_id_item_fk
        references catalogos.cat_item
        on update restrict on delete restrict
);


comment on table esclarecimiento.e_ind_fvt_stc is 'Sectores a los que pertenece el entrevistado';

comment on column esclarecimiento.e_ind_fvt_stc.id_stc is 'Catalogo 10';

alter table esclarecimiento.e_ind_fvt_stc
    owner to dba;

create index e_ind_fvt_stc_id_e_ind_fvt_index
    on esclarecimiento.e_ind_fvt_stc (id_e_ind_fvt);

create index e_ind_fvt_fr_id_stc_index
    on esclarecimiento.e_ind_fvt_stc (id_stc);




alter table esclarecimiento.e_ind_fvt_interes
    owner to dba;


alter table esclarecimiento.e_ind_fvt_mandato
    owner to dba;


alter table esclarecimiento.e_ind_fvt_dinamica
    owner to dba;
