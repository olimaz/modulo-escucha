-- Agregar opcion
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 11, 'Digital y físico', null, null, DEFAULT, DEFAULT, null, DEFAULT);


-- error de FK
alter table esclarecimiento.casos_informes drop constraint esclarecimiento_casos_informes_id_macroterritorio_foreign;

alter table esclarecimiento.casos_informes
	add constraint casos_informes_cev_id_geo_fk_3
		foreign key (id_macroterritorio) references catalogos.cev
			on update cascade on delete restrict;

insert into catalogos.cat_item (id_cat,descripcion) values (13,'Presidencia');
insert into catalogos.cat_item (id_cat,descripcion) values (13,'Comisionados y Comisionadas');
insert into catalogos.cat_item (id_cat,descripcion) values (13,'Dirección: Territorios');
insert into catalogos.cat_item (id_cat,descripcion) values (13,'Dirección: Investigación');
insert into catalogos.cat_item (id_cat,descripcion) values (13,'Sistema de Infromación');
insert into catalogos.cat_item (id_cat,descripcion) values (13,'Enlace: Sistema Integral (SIVJRNR)');
insert into catalogos.cat_item (id_cat,descripcion) values (13,'Grupo: Acceso a la información');
insert into catalogos.cat_item (id_cat,descripcion) values (13,'Otra');

-- Revisar los ID
UPDATE "catalogos"."cat_item" SET "descripcion" = 'Dirección: étnica' WHERE "id_item" = ;
UPDATE "catalogos"."cat_item" SET "descripcion" = 'Enfoque: curso de vida y discapacidad' WHERE "id_item" = ;
UPDATE "catalogos"."cat_item" SET "descripcion" = 'Información del Sistema Integral (SIVJRNR)' WHERE "id_item" = ;
UPDATE "catalogos"."cat_item" SET "descripcion" = '2. Las responsabilidades colectivas del Estado, guerrillas, grupos paramilitares y cualquier otro grupo, organización o institución.' WHERE "id_item" = ;
UPDATE "catalogos"."cat_item" SET "descripcion" = '1. Prácticas y hechos que constituyen graves violaciones a los derechos humanos y graves infracciones al Derecho Internacional Humanitario (DIH)' WHERE "id_item" = ;
