alter table esclarecimiento.mis_casos_persona alter column nombre type varchar(200) using nombre::varchar(200);

alter table esclarecimiento.mis_casos_persona
	add entrevista_fecha_hora timestamp;
