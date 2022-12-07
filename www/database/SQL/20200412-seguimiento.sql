alter table seguimiento_problema
	add cerrado_id_estado int default 2;

alter table seguimiento_problema
	add cerrado_id_entrevistador int;

alter table seguimiento_problema
	add cerrado_fecha_hora timestamp;

alter table seguimiento_problema
	add cerrado_anotaciones text;

create index seguimiento_problema_cerrado_id_estado_index
	on seguimiento_problema (cerrado_id_estado);