alter table traza_buscador
	add id_tipo int default 1;

comment on column traza_buscador.id_tipo is '1: texto; 2: tesauro';

create index traza_buscador_id_tipo_index
	on traza_buscador (id_tipo);

alter table catalogos.tesauro
	add id_activo int default 1;

comment on column catalogos.tesauro.id_activo is 'cualquier valor diferente a 1 se considera como borrada';

create index tesauro_id_activo_index
	on catalogos.tesauro (id_activo);
