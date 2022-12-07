-- iniciales de c/macro
UPDATE "catalogos"."cat_item" SET "abreviado" = 'BS' WHERE "id_item" = 21;
UPDATE "catalogos"."cat_item" SET "abreviado" = 'SC' WHERE "id_item" = 18;
UPDATE "catalogos"."cat_item" SET "abreviado" = 'IN' WHERE "id_item" = 29;
UPDATE "catalogos"."cat_item" SET "abreviado" = 'PA' WHERE "id_item" = 27;
UPDATE "catalogos"."cat_item" SET "abreviado" = 'NO' WHERE "id_item" = 25;
UPDATE "catalogos"."cat_item" SET "abreviado" = 'SU' WHERE "id_item" = 28;
UPDATE "catalogos"."cat_item" SET "abreviado" = 'MM' WHERE "id_item" = 24;
UPDATE "catalogos"."cat_item" SET "abreviado" = 'AE' WHERE "id_item" = 20;
UPDATE "catalogos"."cat_item" SET "abreviado" = 'CA' WHERE "id_item" = 23;
UPDATE "catalogos"."cat_item" SET "abreviado" = 'CI' WHERE "id_item" = 22;
UPDATE "catalogos"."cat_item" SET "abreviado" = 'AM' WHERE "id_item" = 19;
UPDATE "catalogos"."cat_item" SET "abreviado" = 'OR' WHERE "id_item" = 26;

-- Crear criterio fijo para grupos de usuarios
INSERT INTO "catalogos"."criterio_fijo_grupo" ("id_grupo", "descripcion") VALUES (5, 'Grupos de usuarios');
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (5, 1, 'Personal Comisión de la Verdad', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (5, 2, 'Ruta Pacífica', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (5, 3, 'O.I.M.', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (5, 4, 'Exilio', DEFAULT);

-- modificar tabla entrevistadores
alter table esclarecimiento.entrevistador
    add id_grupo int default 1;


create index entrevistador_id_grupo_index
    on esclarecimiento.entrevistador (id_grupo);

-- correccion de diseño
alter table catalogos.criterio_fijo
    add constraint criterio_fijo_pk
        unique (id_grupo, id_opcion);

UPDATE "catalogos"."criterio_fijo" SET "descripcion" = 'Coordinador/a de macroterritorio' WHERE id_grupo = 4 AND id_opcion = 3 ;
