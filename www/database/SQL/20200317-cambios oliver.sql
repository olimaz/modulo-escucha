alter table esclarecimiento.entrevistador
	add r3_nna int default 2;

comment on column esclarecimiento.entrevistador.r3_nna is 'Desclasificar entrevistas a ninos, ninas y adolescentes. 1:si';

alter table esclarecimiento.entrevistador
	add r3_vs int default 2;

comment on column esclarecimiento.entrevistador.r3_vs is 'desclasificar entrevistas con violencia sexual. 1:si';

alter table esclarecimiento.entrevistador
	add r3_ri int default 2;

comment on column esclarecimiento.entrevistador.r3_ri is 'desclasificar entrevistas con responsabilidad individual. 1:Si';

