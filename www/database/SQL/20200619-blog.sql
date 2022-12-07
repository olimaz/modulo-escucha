create table esclarecimiento.blog
(
	id_blog serial not null
		constraint blog_pk
			primary key,
	id_entrevistador integer not null
		constraint blog_entrevistador_id_entrevistador_fk
			references esclarecimiento.entrevistador
				on update cascade on delete restrict,
	fecha_hora timestamp default now(),
	titulo varchar(200),
	html text,
	texto text,
	id_activo integer default 1,
	id_blog_respondido integer
		constraint blog_blog_id_blog_fk
			references esclarecimiento.blog
				on update cascade on delete cascade,
	fh_update timestamp
);

comment on table esclarecimiento.blog is 'Blog general, para uso en diferentes partes';

comment on column esclarecimiento.blog.id_activo is 'softdelte. 1: vigente; cualquier otro valor=borrado';

alter table esclarecimiento.blog owner to dba;

create index blog_fecha_hora_index
	on esclarecimiento.blog (fecha_hora);

create index blog_id_activo_index
	on esclarecimiento.blog (id_activo);

create index blog_id_blog_respondido_index
	on esclarecimiento.blog (id_blog_respondido);

create index blog_id_entrevistador_index
	on esclarecimiento.blog (id_entrevistador);

create index blog_titulo_index
	on esclarecimiento.blog (titulo);

	create table esclarecimiento.mis_casos_blog
(
	id_mis_casos_blog serial not null
		constraint mis_casos_blog_pk
			primary key,
	id_mis_casos integer not null
		constraint mis_casos_blog_mis_casos_id_mis_casos_fk
			references esclarecimiento.mis_casos
				on update cascade on delete restrict,
	id_blog integer not null
		constraint mis_casos_blog_blog_id_blog_fk
			references esclarecimiento.blog
				on update cascade on delete cascade,
	fh_insert timestamp default now()
);

comment on table esclarecimiento.mis_casos_blog is 'Asociar blogs al caso';

alter table esclarecimiento.mis_casos_blog owner to dba;

create unique index mis_casos_blog_id_mis_casos_id_blog_uindex
	on esclarecimiento.mis_casos_blog (id_mis_casos, id_blog);



