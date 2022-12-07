
--Criterios fijos
INSERT INTO catalogos.criterio_fijo_grupo (id_grupo, descripcion) VALUES (50, 'Mis casos: secciones');
INSERT INTO catalogos.criterio_fijo_grupo (id_grupo, descripcion) VALUES (51, 'Mis casos: nombres de los roles');
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (50, 1, 'Fuentes', 20);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (50, 2, 'Solicitudes', 30);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (50, 3, 'Diseño metodológico', 10);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (50, 4, 'Análisis y seguimiento', 40);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (51, 1, 'Propietario', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (51, 5, 'Colaborador', DEFAULT);
-- INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (51, 10, 'Acceso General', DEFAULT);

-- Traza de actividad
UPDATE "catalogos"."criterio_fijo" SET "descripcion" = 'Casos Transversales - metadatos' WHERE "id_grupo" = 22 AND "id_opcion" = 15;
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (22, 16, 'Casos Transversales - entrevistas', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (22, 17, 'Casos Transversales - personas', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (22, 18, 'Casos Transversales - tareas', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (22, 19, 'Casos Transversales - notas', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (22, 20, 'Casos Transversales - archivos anexos', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (22, 21, 'Casos Transversales - seguridad', DEFAULT);





--Cambiar de catalogo a criterio fijo
comment on column esclarecimiento.mis_casos_adjunto.id_seccion is 'Criterio fijo 50';
alter table esclarecimiento.mis_casos_adjunto drop constraint mis_casos_adjunto_cat_item_id_item_fk;
UPDATE esclarecimiento.mis_casos_adjunto
    SET id_seccion = 1
    where id_mis_casos_adjunto in (
        select a.id_mis_casos_adjunto
       from esclarecimiento.mis_casos_adjunto a
           join catalogos.cat_item c on (a.id_seccion=c.id_item and  c.texto='103')
        );

UPDATE esclarecimiento.mis_casos_adjunto
    SET id_seccion = 2
    where id_mis_casos_adjunto in (
        select a.id_mis_casos_adjunto
       from esclarecimiento.mis_casos_adjunto a
           join catalogos.cat_item c on (a.id_seccion=c.id_item and  c.texto='104')
        );

UPDATE esclarecimiento.mis_casos_adjunto
    SET id_seccion = 3
    where id_mis_casos_adjunto in (
        select a.id_mis_casos_adjunto
       from esclarecimiento.mis_casos_adjunto a
           join catalogos.cat_item c on (a.id_seccion=c.id_item and  c.texto='106')
        );


UPDATE esclarecimiento.mis_casos_adjunto
    SET id_seccion = 4
    where id_mis_casos_adjunto in (
        select a.id_mis_casos_adjunto
       from esclarecimiento.mis_casos_adjunto a
           join catalogos.cat_item c on (a.id_seccion=c.id_item and  c.texto='105')
        );





delete from catalogos.cat_item where id_cat=100;
delete from catalogos.cat_cat where id_cat=100;

drop table if exists esclarecimiento.mis_casos_entrevistador;
create table esclarecimiento.mis_casos_entrevistador
(
	id_mis_casos_entrevistador serial not null
		constraint mis_casos_entrevistador_pk
			primary key,
	id_mis_casos integer
		constraint mis_casos_entrevistador_mis_casos_id_mis_casos_fk
			references esclarecimiento.mis_casos
				on update cascade on delete cascade,
	id_entrevistador integer
		constraint mis_casos_entrevistador_entrevistador_id_entrevistador_fk
			references esclarecimiento.entrevistador
				on update cascade on delete restrict,
	id_perfil integer default 5,
	fh_insert timestamp default now()
);

comment on table esclarecimiento.mis_casos_entrevistador is 'Tabla de permisos de acceso';

comment on column esclarecimiento.mis_casos_entrevistador.id_perfil is 'Criterio fijo 51';

alter table esclarecimiento.mis_casos_entrevistador owner to dba;

create unique index mis_casos_entrevistador_id_mis_casos_id_entrevistador_uindex
	on esclarecimiento.mis_casos_entrevistador (id_mis_casos, id_entrevistador);

