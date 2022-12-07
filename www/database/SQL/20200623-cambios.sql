INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (103, 'Categorías de adjunto de casos transversales', 'Utilizado en casos transversales', DEFAULT);
UPDATE "catalogos"."cat_cat" SET "nombre" = 'Adjuntos de casos transversales, fuentes primarias', "descripcion" = 'Utilizado en adjuntos de casos transversales' WHERE "id_cat" = 103;
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (104, 'Adjuntos de casos transversales, Solicitudes de información', 'Utilizado en adjuntos de casos transversales', DEFAULT);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (105, 'Adjuntos de casos transversales, Analisis y seguimiento', 'Utilizado en adjuntos de casos transversales', DEFAULT);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (106, 'Adjuntos de casos transversales, diseño metodológico', 'Utilizado en adjuntos de casos transversales', DEFAULT);


INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 103, 'Entidades públicas', 'fp', null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 103, 'Organizaciones Sociales', 'fp', null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 103, 'Organismos internacionales', 'fp', null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 103, 'Prensa', 'fp', null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 103, 'Bibliografía', 'fp', null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 103, 'Otros', 'fp', null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 104, 'Entidades de la rama ejecutiva', 'si', null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 104, 'Entidades de la rama legislativa', 'si', null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 104, 'Entidades de la rama judicial', 'si', null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 104, 'Entes de control', 'si', null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 104, 'Organizaciones sociales', 'si', null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 104, 'Organismos internacionales', 'si', null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 105, 'Informes de avance', 'as', null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 105, 'Reuniones de validación y retroalimentación', null, null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 105, 'Versiones informe final del caso', null, null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 105, 'Comunicaciones oficiales envío de informe final', null, null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
INSERT INTO "catalogos"."cat_item" ("id_item", "id_cat", "descripcion", "abreviado", "texto", "orden", "predeterminado", "otro", "habilitado", "pendiente_revisar", "fh_creacion", "id_entrevistador") VALUES (DEFAULT, 105, 'Documentos de soporte', null, null, DEFAULT, DEFAULT, null, DEFAULT, DEFAULT, DEFAULT, null);
-- Indicar que catalogo pertenece a que seccion, usando el campo texto
update catalogos.cat_item
set texto='103'
where id_cat=100
and descripcion ilike '%fuentes%';
update catalogos.cat_item
set texto='104'
where id_cat=100
and descripcion ilike '%solici%';
update catalogos.cat_item
set texto='105'
where id_cat=100
and descripcion ilike '%seguimi%';
update catalogos.cat_item
set texto='106'
where id_cat=100
and descripcion ilike '%metodo%';

-- Actualizar adjuntos
alter table esclarecimiento.mis_casos_adjunto
	add id_categoria int;
comment on column esclarecimiento.mis_casos_adjunto.id_categoria is 'catalogos 103 al 105 segun seccion';
alter table esclarecimiento.mis_casos_adjunto
	add clasificacion_nivel int default 4;
comment on column esclarecimiento.mis_casos_adjunto.clasificacion_nivel is 'Nivel de acceso al documento';

