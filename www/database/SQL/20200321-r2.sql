alter table esclarecimiento.entrevista_profundidad
	add clasificacion_r2 int default 2;

comment on column esclarecimiento.entrevista_profundidad.clasificacion_r2 is '1: Si / 2:no';


alter table esclarecimiento.casos_informes
	add clasifica_r2 int default 2;

comment on column esclarecimiento.casos_informes.clasifica_r2 is '1:Si, 2:No';

