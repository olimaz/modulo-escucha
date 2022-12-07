INSERT INTO "catalogos"."criterio_fijo_grupo" ("id_grupo", "descripcion") VALUES (10, 'Si, No, Si parcial');
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (10, 1, 'Sí', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (10, 2, 'No', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (10, 3, 'Sí, parcialmente.', DEFAULT);


-- "Solicitar asilo"
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion") VALUES (DEFAULT, 154, 'Solicitar asilo', null, null, 7, DEFAULT, null, 1, 2, DEFAULT);

-- Observaciones de la diligenciada en linea
alter table esclarecimiento.e_ind_fvt
	add observaciones_diligenciada text default null;
