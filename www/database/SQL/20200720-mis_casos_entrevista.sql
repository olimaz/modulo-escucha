create table esclarecimiento.mis_casos_entrevista
(
	id_mis_casos_entrevista serial not null
		constraint mis_casos_entrevista_pk
			primary key,
    id_mis_casos integer not null
        constraint mis_casos_entrevista_mis_casos_id_mis_casos_fk
			references esclarecimiento.mis_casos
				on update cascade on delete cascade,
	id_subserie integer,
	id_entrevista integer,
	id_entrevistador integer
		constraint mis_casos_entrevista_entrevistador_id_entrevistador_fk
			references esclarecimiento.entrevistador
				on update cascade on delete restrict,
	fecha_hora timestamp default now(),
	codigo varchar(20)


);

comment on table esclarecimiento.mis_casos_entrevista is 'Asignar entrevistas a un caso transversal';

comment on column esclarecimiento.mis_casos_entrevista.codigo is 'Calculado. Para facilitar algunas consultas e intregración de datos';

alter table esclarecimiento.mis_casos_entrevista owner to dba;

create index mis_casos_entrevista_codigox_index
	on esclarecimiento.mis_casos_entrevista (codigo);

create index mis_casos_entrevista_id_entrevistador_index
	on esclarecimiento.mis_casos_entrevista (id_entrevistador);

create index mis_casos_entrevista_id_mis_casos_index
	on esclarecimiento.mis_casos_entrevista (id_mis_casos);

create unique index mis_casos_entrevista_id_subserie_id_entrevista_id_mis_casos_uin
	on esclarecimiento.mis_casos_entrevista (id_subserie, id_entrevista, id_mis_casos);

