alter table esclarecimiento.e_ind_fvt
    add id_activo int default 1;

alter table esclarecimiento.e_ind_fvt
    add id_prioritario int default 2;

create index e_ind_fvt_id_activo_index
    on esclarecimiento.e_ind_fvt (id_activo);

create index e_ind_fvt_id_prioritario_index
    on esclarecimiento.e_ind_fvt (id_prioritario);


alter table esclarecimiento.e_ind_fvt
	add id_sector int;

create index e_ind_fvt_id_sector_index
	on esclarecimiento.e_ind_fvt (id_sector);

alter table esclarecimiento.e_ind_fvt
	add constraint e_ind_fvt_cat_item_id_item_fk_3
		foreign key (id_sector) references catalogos.cat_item
			on update cascade on delete restrict;

alter table esclarecimiento.e_ind_fvt
	add id_etnico int;

create index e_ind_fvt_id_etnico_index
	on esclarecimiento.e_ind_fvt (id_etnico);

alter table esclarecimiento.e_ind_fvt
	add constraint e_ind_fvt_cat_item_id_item_fk_4
		foreign key (id_etnico) references catalogos.cat_item
			on update cascade on delete restrict;

-- Areas de interes
create table esclarecimiento.e_ind_fvt_interes_area
(
	id_e_ind_fvt_interes_area serial
		constraint e_ind_fvt_interes_area_pk
			primary key,
	id_e_ind_fvt integer,
	id_interes int
);

alter table esclarecimiento.e_ind_fvt_interes_area
    owner to dba;

comment on table esclarecimiento.e_ind_fvt_interes_area is 'Areas a las que puede interesarle';

create unique index e_ind_fvt_interes_area_id_e_ind_fvt_id_interes_uindex
	on esclarecimiento.e_ind_fvt_interes_area (id_e_ind_fvt, id_interes);

create index e_ind_fvt_interes_area_id_e_ind_fvt_index
	on esclarecimiento.e_ind_fvt_interes_area (id_e_ind_fvt);

create index e_ind_fvt_interes_area_id_interes_index
	on esclarecimiento.e_ind_fvt_interes_area (id_interes);


insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (85,'Áreas de las que puede ser de interés una entrevista','Usado en metadatos de entrevista',1);
insert into catalogos.cat_item (id_cat,descripcion,otro) values (85,'Dirección de Pueblos Étnicos','ia_pueblo_etnico');
insert into catalogos.cat_item (id_cat,descripcion,otro) values (85,'Dirección de Diálogo Social','ia_dialogo_social');
insert into catalogos.cat_item (id_cat,descripcion,otro) values (85,'Grupo de Trabajo de Género','ia_genero');
insert into catalogos.cat_item (id_cat,descripcion,otro) values (85,'Enfoque Psicosocial','ia_enfoque_ps');
insert into catalogos.cat_item (id_cat,descripcion,otro) values (85,'Enfoque de Curso de Vida y Discapacidad','ia_curso_vida');




