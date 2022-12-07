insert into catalogos.criterio_fijo_grupo(id_grupo,descripcion)
    values(21,'Traza: acciones');
insert into catalogos.criterio_fijo_grupo(id_grupo,descripcion)
    values(22,'Traza: objetos');

insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(21,1,'Iniciar sesión');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(21,2,'Cerrar sesión');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(21,3,'Crear nuevo');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(21,4,'Modificar existente');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(21,5,'Descargar adjunto');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(21,6,'Consultar / Descargar');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(21,7,'Cambiar privilegios');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(21,8,'Descargar Excel');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(21,9,'Dar acceso');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(21,10,'Eliminar');

--
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(22,1,'Entrevista');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(22,2,'Archivos anexos');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(22,3,'Casos e informes');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(22,4,'Entrevistador');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(22,5,'Catálogos');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(22,6,'Archivos de referencia');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(22,7,'NNA: Eval. Vulnerabilidad');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values(22,8,'NNA: Eval Seguridad');





-- Crear la tabla
create table traza_actividad
(
	id_traza_actividad serial
		constraint traza_actividad_pk
			primary key,
	fecha_hora timestamp default current_timestamp not null,
	id_usuario int,
	id_accion int,
	id_objeto int,
	referencia varchar(100),
	codigo varchar(50)
);
alter table traza_actividad
    owner to dba;

comment on table traza_actividad is 'Registra principales eventos en la interfaz';

comment on column traza_actividad.id_accion is 'Criterio fijo 21';

comment on column traza_actividad.id_objeto is 'Criterio fijo 22';

comment on column traza_actividad.referencia is 'opcional';

create index traza_actividad_codigo_index
	on traza_actividad (codigo);

create index traza_actividad_fecha_hora_index
	on traza_actividad (fecha_hora);

create index traza_actividad_id_accion_index
	on traza_actividad (id_accion);

create index traza_actividad_id_objeto_index
	on traza_actividad (id_objeto);

create index traza_actividad_id_traza_actividad_index
	on traza_actividad (id_traza_actividad);

create index traza_actividad_id_usuario_index
	on traza_actividad (id_usuario);


alter table traza_actividad
	add id_primaria int;

comment on column traza_actividad.id_primaria is 'llave primaria del objeto afectado';
create index traza_actividad_id_primaria_index
	on traza_actividad (id_primaria);



