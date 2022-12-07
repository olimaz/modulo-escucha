INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (4, 6, 'Confidencial', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (4, 7, 'Estadístico', DEFAULT);

UPDATE "catalogos"."criterio_fijo" SET "orden" = 2 WHERE "id_grupo" = 4 AND "id_opcion" = 1;
UPDATE "catalogos"."criterio_fijo" SET "orden" = 3 WHERE "id_grupo" = 4 AND "id_opcion" = 2;
UPDATE "catalogos"."criterio_fijo" SET "orden" = 4 WHERE "id_grupo" = 4 AND "id_opcion" = 3;
UPDATE "catalogos"."criterio_fijo" SET "orden" = 5 WHERE "id_grupo" = 4 AND "id_opcion" = 4;
UPDATE "catalogos"."criterio_fijo" SET "orden" = 6 WHERE "id_grupo" = 4 AND "id_opcion" = 5;
UPDATE "catalogos"."criterio_fijo" SET "orden" = 1 WHERE "id_grupo" = 4 AND "id_opcion" = 6;
UPDATE "catalogos"."criterio_fijo" SET "orden" = 7 WHERE "id_grupo" = 4 AND "id_opcion" = 7;


INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (21, 11, 'Dar acceso a entrevista restringida-3', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (21, 12, 'Remover acceso a entrevista restringida-3', DEFAULT);


-- Acceso a restringido-3
create table esclarecimiento.reservado_acceso
(
    id_reservado_acceso serial                                 not null
        constraint reservado_acceso_pkey
            primary key,
    id_autorizador      integer                                not null,
    id_autorizado       integer                                not null,
    id_subserie         integer                                not null,
    id_primaria         integer                                not null,
    fh_insert           timestamp(0) default CURRENT_TIMESTAMP not null,
    id_activo           integer      default 1,
    id_denegador        integer,
    fh_update           timestamp
);

alter table esclarecimiento.reservado_acceso
    owner to dba;

create index esclarecimiento_reservado_acceso_id_autorizador_index
    on esclarecimiento.reservado_acceso (id_autorizador);

create index esclarecimiento_reservado_acceso_id_autorizado_index
    on esclarecimiento.reservado_acceso (id_autorizado);

create index esclarecimiento_reservado_acceso_id_subserie_index
    on esclarecimiento.reservado_acceso (id_subserie);

create index esclarecimiento_reservado_acceso_id_primaria_index
    on esclarecimiento.reservado_acceso (id_primaria);

create index reservado_acceso_id_activo_index
    on esclarecimiento.reservado_acceso (id_activo);


-- Remitido por
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (33,'Remitido por',null,1);
insert into catalogos.cat_item(id_cat, descripcion) values (33,'JEP');
insert into catalogos.cat_item(id_cat, descripcion) values (33,'UPB');

alter table esclarecimiento.e_ind_fvt
	add id_remitido int;

alter table esclarecimiento.e_ind_fvt
	add constraint e_ind_fvt_cat_item_id_item_fk
		foreign key (id_remitido) references catalogos.cat_item
			on update cascade on delete restrict;


alter table esclarecimiento.entrevista_profundidad
	add id_remitido int;

alter table esclarecimiento.entrevista_profundidad
	add constraint entrevista_profundidad_cat_item_id_item_fk_2
		foreign key (id_remitido) references catalogos.cat_item
		on update cascade on delete restrict;



