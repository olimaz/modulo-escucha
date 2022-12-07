-- Catalogo 11: tipo de soporte
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (11, 'Tipo de soporte', 'para recepción de casos e informes', DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 11, 'Digital', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 11, 'Físico', null, null, DEFAULT, DEFAULT, null, DEFAULT);

-- Catalogo 12: tipo de organización
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (12, 'Tipo de organización', 'Utilizado en la recepción de casos e informes', 1)
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 12, 'Asociación', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 12, 'Fundación', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 12, 'Gremio', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 12, 'Institucion Académica', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 12, 'Organización Social', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 12, 'Organización política o económica', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 12, 'Organización de víctimas', null, null, DEFAULT, 1, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 12, 'Otros', null, null, DEFAULT, DEFAULT, null, DEFAULT)

-- Catalogo 13: areas de la comisión
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (13, 'Areas de la Comisión', 'Para clasificar la recepción de casos e informes', DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 13, 'Objetivo: esclarecimiento', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 13, 'Objetivo: reconocimiento', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 13, 'Objetivo: convivencia', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 13, 'Objetivo: no repetición', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 13, 'Enfoque: étnico', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 13, 'Enfoque: de género', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 13, 'Enfoque: psicosocial', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 13, 'Enfoque: curso de vida', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 13, 'Estrategia: comunicación', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 13, 'Estrategia: pedagogía', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 13, 'Estrategia: arte y cultura', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 13, 'Estrategia: participación', null, null, DEFAULT, DEFAULT, null, DEFAULT);

-- Catalogo 14: tipo de caso/informe
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (14, 'Tipo de fuente', 'Utilizado en casos e informes', DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 14, 'Informe para La Comisión', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 14, 'Caso para La Comisión', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 14, 'Publicación', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 14, 'Sentencia', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 14, 'Base de datos', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 14, 'Archivo', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 14, 'Información del Sistema Integral VJRNRN', null, null, DEFAULT, DEFAULT, null, DEFAULT);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado") VALUES (DEFAULT, 14, 'Otros', null, null, DEFAULT, DEFAULT, null, DEFAULT);
