create table catalogos.rol
(
	id_rol integer not null
		constraint rol_pk
			primary key,
	descripcion varchar(100)
);

comment on table catalogos.rol is 'Para permisos específicos';

alter table catalogos.rol owner to dba;

create index rol_id_rol_index
	on catalogos.rol (id_rol);

create table catalogos.rol_entrevistador
(
	id_rol_entrevistador serial not null
		constraint rol_entrevistador_pk
			primary key,
	id_rol integer
		constraint rol_entrevistador_rol_id_rol_fk
			references catalogos.rol
				on update cascade on delete cascade,
	id_entrevistador integer
		constraint rol_entrevistador_entrevistador_id_entrevistador_fk
			references esclarecimiento.entrevistador
				on update cascade on delete cascade,
	fh_insert timestamp default now()
);

comment on table catalogos.rol_entrevistador is 'Para asignar permisos especiales';

alter table catalogos.rol_entrevistador owner to dba;

create unique index rol_entrevistador_id_rol_id_entrevistador_uindex
	on catalogos.rol_entrevistador (id_rol, id_entrevistador);



insert into catalogos.rol (id_rol, descripcion) values (1, 'Tesauro: gestion de catalogos');