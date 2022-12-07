alter table fichas.exilio_movimiento
	add id_lugar_llegada_2 int;

create index exilio_movimiento_id_lugar_llegada_2_index
	on fichas.exilio_movimiento (id_lugar_llegada_2);

alter table fichas.exilio_movimiento
	add constraint exilio_movimiento_geo_id_geo_fk
		foreign key (id_lugar_llegada_2) references catalogos.geo
			on update cascade on delete restrict;

-- traza
alter table fichas.hecho
	add insert_ent int;

alter table fichas.hecho
	add insert_ip varchar(100);

alter table fichas.hecho
	add insert_fh timestamp;

alter table fichas.hecho
	add update_ent int;

alter table fichas.hecho
	add update_ip varchar(100);

alter table fichas.hecho
	add update_fh timestamp;

--
alter table fichas.exilio
	add insert_ent int;

alter table fichas.exilio
	add insert_ip varchar(100);

alter table fichas.exilio
	add insert_fh timestamp;

alter table fichas.exilio
	add update_ent int;

alter table fichas.exilio
	add update_ip varchar(100);

alter table fichas.exilio
	add update_fh timestamp;

--
alter table fichas.exilio_movimiento
	add insert_ent int;

alter table fichas.exilio_movimiento
	add insert_ip varchar(100);

alter table fichas.exilio_movimiento
	add insert_fh timestamp;

alter table fichas.exilio_movimiento
	add update_ent int;

alter table fichas.exilio_movimiento
	add update_ip varchar(100);

alter table fichas.exilio_movimiento
	add update_fh timestamp;

