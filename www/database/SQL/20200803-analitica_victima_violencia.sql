drop table if exists analitica.victima_violencia;
create table analitica.victima_violencia
(
    id serial not null
		constraint victima_violencia_pk
			primary key,
	id_hecho integer not null,
	id_victima integer not null,
	edad int,
	ocupacion text,
	lugar_res_codigo varchar(25),
	lugar_res_n1_codigo varchar(25),
	lugar_res_n1_txt text,
	lugar_res_n2_codigo varchar(25),
	lugar_res_n2_txt text,
	lugar_res_n3_codigo varchar(25),
	lugar_res_n3_txt text,
	lugar_res_n3_lat varchar(25),
	lugar_res_n3_lon varchar(25),
	lugar_res_zona_id integer,
	lugar_res_zona_txt text


);

comment on table analitica.victima_violencia is 'Enlace entre datos de víctima y datos de la violencia.';
comment on column analitica.victima_violencia.id is 'Llave primaria de la tabla';
comment on column analitica.victima_violencia.id_hecho is 'Enlace a tabla analitica.violencia';
comment on column analitica.victima_violencia.id_victima is 'Enlace a tabla analitica.victima';
comment on column analitica.victima_violencia.edad is 'Edad al momento de los hechos';
comment on column analitica.victima_violencia.lugar_res_codigo is 'Lugar de residencia al momento de los hechos, código';
comment on column analitica.victima_violencia.lugar_res_n1_codigo is 'Lugar de residencia al momento de los hechos, departamento, codigo';
comment on column analitica.victima_violencia.lugar_res_n1_txt is 'Lugar de residencia al momento de los hechos, departamento, nombre';
comment on column analitica.victima_violencia.lugar_res_n2_codigo is 'Lugar de residencia al momento de los hechos, municipio, codigo';
comment on column analitica.victima_violencia.lugar_res_n2_txt is 'Lugar de residencia al momento de los hechos, municipio, nombre';
comment on column analitica.victima_violencia.lugar_res_n3_codigo is 'Lugar de residencia al momento de los hechos, vereda, codigo';
comment on column analitica.victima_violencia.lugar_res_n3_txt is 'Lugar de residencia al momento de los hechos, vereda, nombre';
comment on column analitica.victima_violencia.lugar_res_n3_lat is 'Lugar de residencia al momento de los hechos, vereda, latitud';
comment on column analitica.victima_violencia.lugar_res_n3_lon is 'Lugar de residencia al momento de los hechos, vereda, longitud';
comment on column analitica.victima_violencia.lugar_res_zona_id is 'Lugar de residencia al momento de los hechos, vereda, tipo de zona, identificador';
comment on column analitica.victima_violencia.lugar_res_zona_txt is 'Lugar de residencia al momento de los hechos, vereda, tipo de zona, descripcion';
comment on column analitica.victima_violencia.ocupacion is 'Ubicacion al momento de los hechos';





alter table analitica.victima_violencia owner to dba;
grant select on analitica.victima_violencia to solo_lectura;


create unique index victima_violencia_id_hecho_id_victima_uindex
	on analitica.victima_violencia (id_hecho, id_victima);

