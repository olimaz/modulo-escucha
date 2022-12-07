alter table sim.entrevista_victima
	add otros_datos text;


alter table esclarecimiento.diagnostico_comunitario
	add id_activo int default 1;

create index diagnostico_comunitario_id_activo_index
	on esclarecimiento.diagnostico_comunitario (id_activo);


alter table esclarecimiento.historia_vida
	add id_activo int default 1;

create index historia_vida_id_activo_index
	on esclarecimiento.historia_vida (id_activo);




