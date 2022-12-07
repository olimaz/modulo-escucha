alter table sim.entrevista_victima
	add procesamiento text;

comment on column sim.entrevista_victima.procesamiento is 'Detalles de la transcripcion, etiquetada, fichas';

