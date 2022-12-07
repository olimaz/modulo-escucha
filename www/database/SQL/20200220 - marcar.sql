create table esclarecimiento.marca
(
	id_marca serial not null
		constraint marca_pk
			primary key,
	texto varchar(100) not null
);

comment on table esclarecimiento.marca is 'Textos aplicados a las entrevistas';

alter table esclarecimiento.marca owner to dba;

create index marca_texto_index
	on esclarecimiento.marca (texto);



create table esclarecimiento.marca_entrevista
(
	id_marca_entrevista serial not null
		constraint marca_entrevista_pk
			primary key,
	id_subserie integer not null,
	id_entrevista integer not null,
	id_entrevistador integer not null
		constraint marca_entrevista_entrevistador_id_entrevistador_fk
			references esclarecimiento.entrevistador
				on update cascade on delete cascade,
	id_marca integer not null
		constraint marca_entrevista_marca_id_marca_fk
			references esclarecimiento.marca
				on update cascade on delete cascade
);

comment on table esclarecimiento.marca_entrevista is 'Marcas aplicadas a las entrevistas, por usuario';

comment on column esclarecimiento.marca_entrevista.id_subserie is 'Tipo de entrevista';

comment on column esclarecimiento.marca_entrevista.id_entrevista is 'llave primaria de la entrevista, segun id_subserie';

alter table esclarecimiento.marca_entrevista owner to dba;

create index marca_entrevista_id_entrevista_index
	on esclarecimiento.marca_entrevista (id_entrevista);

create index marca_entrevista_id_entrevistador_index
	on esclarecimiento.marca_entrevista (id_entrevistador);

create index marca_entrevista_id_marca_index
	on esclarecimiento.marca_entrevista (id_marca);

create unique index marca_entrevista_id_subserie_id_entrevista_id_entrevistador_id_
	on esclarecimiento.marca_entrevista (id_subserie, id_entrevista, id_entrevistador, id_marca);

create index marca_entrevista_id_subserie_index
	on esclarecimiento.marca_entrevista (id_subserie);

