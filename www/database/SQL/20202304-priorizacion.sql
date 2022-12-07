
INSERT INTO "catalogos"."criterio_fijo_grupo" ("id_grupo", "descripcion") VALUES (24, 'Priorización: quien establece la prioridad');
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (24, 1, 'Entrevistador', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (24, 2, 'Transcriptor', DEFAULT);

UPDATE "catalogos"."criterio_fijo" SET "descripcion" = 'Entrevistador (prioridad para transcripción)' WHERE "id_grupo" = 24 AND "id_opcion" = 1 ;
UPDATE "catalogos"."criterio_fijo" SET "descripcion" = 'Transcriptor (prioridad para análisis)' WHERE "id_grupo" = 24 AND "id_opcion" = 2  ;

