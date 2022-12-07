-- controlar nuevos catalogos
alter table catalogos.cat_item
	add id_entrevistador int;

create index cat_item_id_entrevistador_index
	on catalogos.cat_item (id_entrevistador);

alter table catalogos.cat_item
	add constraint cat_item_entrevistador_id_entrevistador_fk
		foreign key (id_entrevistador) references esclarecimiento.entrevistador
			on update cascade on delete restrict;


-- controlar nuevas veredas
alter table catalogos.geo
	add fh_insert timestamp default now();

alter table catalogos.geo
	add id_entrevistador int;

create index geo_id_entrevistador_index
	on catalogos.geo (id_entrevistador);

alter table catalogos.geo
	add constraint geo_entrevistador_id_entrevistador_fk
		foreign key (id_entrevistador) references esclarecimiento.entrevistador
			on update cascade on delete restrict;

-- Asignación de permisos a nivel-3 con límite de tiempo
alter table esclarecimiento.reservado_acceso
	add fh_del timestamp;

alter table esclarecimiento.reservado_acceso
	add fh_al timestamp;

alter table esclarecimiento.reservado_acceso
	add id_adjunto int;

create index reservado_acceso_fh_al_index
	on esclarecimiento.reservado_acceso (fh_al);

create index reservado_acceso_fh_del_index
	on esclarecimiento.reservado_acceso (fh_del);

create index reservado_acceso_id_adjunto_index
	on esclarecimiento.reservado_acceso (id_adjunto);

alter table esclarecimiento.reservado_acceso
	add constraint reservado_acceso_adjunto_id_adjunto_fk
		foreign key (id_adjunto) references esclarecimiento.adjunto
			on update cascade on delete restrict;

INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden")
        VALUES (1, 20, 'Autorizaciones para acceso a información reservada', 20);


-- soft delte
alter table esclarecimiento.entrevista_colectiva
	add id_activo int default 1;

create index entrevista_colectiva_id_activo_index
	on esclarecimiento.entrevista_colectiva (id_activo);

