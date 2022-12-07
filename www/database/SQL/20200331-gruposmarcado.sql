create table esclarecimiento.marca_grupo
(
	id_marca_grupo serial not null
		constraint marca_grupo_pk
			primary key,
	descripcion varchar(200) not null
);

comment on table esclarecimiento.marca_grupo is 'Grupos de marcaje.  Usuarios que comparten marcas en un mismo grupo';

alter table esclarecimiento.marca_grupo owner to dba;

--
create table esclarecimiento.marca_grupo_entrevistador
(
	id_marca_grupo_enrevistador serial not null
		constraint marca_grupo_entrevistador_pk
			primary key,
	id_marca_grupo integer not null
		constraint marca_grupo_entrevistador_marca_grupo_id_marca_grupo_fk
			references esclarecimiento.marca_grupo
				on update cascade on delete cascade,
	id_entrevistador integer not null
		constraint marca_grupo_entrevistador_entrevistador_id_entrevistador_fk
			references esclarecimiento.entrevistador
				on update cascade on delete cascade
);

comment on table esclarecimiento.marca_grupo_entrevistador is 'Miembros de cada grupo de marcaje';

alter table esclarecimiento.marca_grupo_entrevistador owner to dba;

create unique index marca_grupo_entrevistador_id_marca_grupo_id_entrevistador_uinde
	on esclarecimiento.marca_grupo_entrevistador (id_marca_grupo, id_entrevistador);

