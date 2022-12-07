create table esclarecimiento.entrevistador_acceso
(
	id_entrevistador_acceso serial,
	id_entrevistador int not null
		constraint entrevistador_acceso_entrevistador_id_entrevistador_fk
			references esclarecimiento.entrevistador (id_entrevistador)
				on update cascade on delete cascade,
	id_grupo_acceso int not null
);

comment on table esclarecimiento.entrevistador_acceso is 'Grupos de entrevistadores a los que tiene acceso';

create unique index entrevistador_acceso_id_entrevistador_acceso_uindex
	on esclarecimiento.entrevistador_acceso (id_entrevistador_acceso);

create unique index entrevistador_acceso_id_entrevistador_id_grupo_acceso_uindex
	on esclarecimiento.entrevistador_acceso (id_entrevistador, id_grupo_acceso);

alter table esclarecimiento.entrevistador_acceso
	add constraint entrevistador_acceso_pk_2
		primary key (id_entrevistador, id_grupo_acceso);

alter table esclarecimiento.entrevistador_acceso
	add constraint entrevistador_acceso_pk
		unique (id_entrevistador_acceso);

insert into esclarecimiento.entrevistador_acceso(id_entrevistador, id_grupo_acceso)
select id_entrevistador, id_grupo from esclarecimiento.entrevistador where id_nivel in (3,4) and id_grupo>1;


INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (15, 'Mandatos', 'Según el acuerdo', DEFAULT);
--
insert into catalogos.cat_item(id_cat,descripcion,orden) values (15,'1. Prácticas y hechos que constituyen graves violaciones a los derechos humanos y graves infracciones al Derecho Internacional Humanitario (DIH',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (15,'2. Las responsabilidades colectivas del Estado',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (15,'3. El impacto humano y social del conflicto en la sociedad',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (15,'4. El impacto del conflicto sobre el ejercicio de la política y el funcionamiento de la democracia en su conjunto',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (15,'5. El impacto del conflicto sobre quienes participaron directamente en el',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (15,'6. El contexto histórico; los orígenes y múltiples causas del conflicto',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (15,'7. Los factores y condiciones que facilitaron o contribuyeron a la persistencia del conflicto',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (15,'8. El desarrollo del conflicto',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (15,'9. El fenómeno del paramilitarismo',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (15,'10. El desplazamiento forzado y despojo de tierras con ocasión del conflicto y sus consecuencias',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (15,'11. La relación entre el conflicto y los cultivos de uso ilícito',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (15,'12. Los procesos de fortalecimiento del tejido social en las comunidades y las experiencias de resiliencia individual o colectiva',12);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (15,'13. Los procesos de transformación positiva de las organizaciones e instituciones a lo largo del conflicto',13);

-- auto-generated definition
create table esclarecimiento.casos_informes_mandato
(
    id_casos_informes_mandato serial  not null
        constraint casos_informes_mandato_pkey
            primary key,
    id_casos_informes         integer not null
        constraint esclarecimiento_casos_informes_mandato_id_casos_informes_foreig
            references esclarecimiento.casos_informes
            on update cascade on delete cascade,
    id_mandato               integer not null
        constraint esclarecimiento_casos_informes_mandato_id_interes_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    constraint esclarecimiento_casos_informes_mandato_id_casos_informes_id_int
        unique (id_casos_informes, id_mandato)
);

alter table esclarecimiento.casos_informes_interes
    owner to dba;


-- correcciones
alter table esclarecimiento.casos_informes alter column registro_fecha drop not null;
alter table esclarecimiento.casos_informes alter column entrega_lugar drop not null;
alter table esclarecimiento.casos_informes alter column receptor_almacenaje drop not null;
alter table esclarecimiento.casos_informes alter column receptor_anotaciones drop not null;
alter table esclarecimiento.casos_informes alter column caracterizacion_fecha_caracterizacion drop not null;
create unique index casos_informes_codigo_uindex
	on esclarecimiento.casos_informes (codigo);

-- anexar transcripcion preliminar
UPDATE "catalogos"."criterio_fijo" SET "descripcion" = 'Transcripción final' WHERE "id_grupo" = 1 AND "id_opcion" = 6;
UPDATE "catalogos"."criterio_fijo" SET "orden" = 7 WHERE "id_grupo" = 1 AND "id_opcion" = 6;
UPDATE "catalogos"."criterio_fijo" SET "orden" = 8 WHERE "id_grupo" = 1 AND "id_opcion" = 7;
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (1, 8, 'Transcripción preliminar', 6);

-- especificar para los grupos, a que nivel se dá el acceso
alter table esclarecimiento.entrevistador_acceso
	add id_nivel int default 4;


-- adjuntar archivos a un caso/informe
create table esclarecimiento.casos_informes_adjunto
(
	id_casos_informes_adjunto serial
		constraint casos_informes_adjunto_pk
			primary key,
	id_casos_informes int not null
		constraint casos_informes_adjunto_casos_informes_id_casos_informes_fk
			references esclarecimiento.casos_informes (id_casos_informes)
				on update cascade on delete cascade,
	id_tipo int not null,
	id_adjunto int
		constraint casos_informes_adjunto_adjunto_id_adjunto_fk
			references esclarecimiento.adjunto (id_adjunto)
				on update cascade on delete cascade,
	fh_insert timestamp not null,
	fh_update timestamp
);

comment on table esclarecimiento.casos_informes_adjunto is 'Archivos adjuntos para Casos e Informes';

create index casos_informes_adjunto_id_adjunto_index
	on esclarecimiento.casos_informes_adjunto (id_adjunto);

create index casos_informes_adjunto_id_casos_informes_index
	on esclarecimiento.casos_informes_adjunto (id_casos_informes);

create index casos_informes_adjunto_id_tipo_index
	on esclarecimiento.casos_informes_adjunto (id_tipo);

 CREATE TRIGGER auditoria_ingreso_casos_informes_adjunto
                      BEFORE INSERT
                      ON esclarecimiento.casos_informes_adjunto
                      for each row
                        execute procedure public.marca_insert();

 CREATE TRIGGER auditoria_update_casos_informes_adjunto
                      BEFORE update
                      ON esclarecimiento.casos_informes_adjunto
                      for each row
                        execute procedure public.marca_update();


INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES (11, 'Tipo de soporte', 'para recepción de casos e informes', 1);
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES (12, 'Tipo de organización', 'Utilizado en la recepción de casos e informes', 1);
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES (13, 'Areas de la Comisión', 'Para clasificar la recepción de casos e informes', 1);
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES (14, 'Tipo de fuente', 'Utilizado en casos e informes', 1);

INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (13, 'Objetivo: esclarecimiento', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (11, 'Digital', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (11, 'Físico', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (12, 'Asociación', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (12, 'Fundación', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (12, 'Gremio', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (12, 'Institucion Académica', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (12, 'Organización Social', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES ( 12, 'Organización política o económica', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (12, 'Organización de víctimas', null, null, 0, 1, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (12, 'Otros', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (13, 'Objetivo: reconocimiento', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (13, 'Objetivo: convivencia', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (13, 'Objetivo: no repetición', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES ( 13, 'Enfoque: étnico', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (13, 'Enfoque: de género', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES ( 13, 'Enfoque: psicosocial', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES ( 13, 'Enfoque: curso de vida', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES ( 13, 'Estrategia: comunicación', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (13, 'Estrategia: pedagogía', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (13, 'Estrategia: arte y cultura', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (13, 'Estrategia: participación', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (14, 'Informe para La Comisión', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (14, 'Caso para La Comisión', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (14, 'Publicación', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES ( 14, 'Sentencia', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (14, 'Base de datos', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (14, 'Archivo', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES (14, 'Información del Sistema Integral VJRNRN', null, null, 0, 2, null, 1);
INSERT INTO catalogos.cat_item ( id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado) VALUES ( 14, 'Otros', null, null, 0, 2, null, 1);
