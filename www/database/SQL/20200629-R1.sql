-- VI, AA, TC
alter table esclarecimiento.e_ind_fvt
	add clasifica_r2 int default 2;

comment on column esclarecimiento.e_ind_fvt.clasifica_r2 is '1:Sí;  Otro valor: No';

alter table esclarecimiento.e_ind_fvt
	add clasifica_r1 int default 2;

comment on column esclarecimiento.e_ind_fvt.clasifica_r1 is '1:Sí;  Otro valor: No';


-- CO
alter table esclarecimiento.entrevista_colectiva
	add clasificacion_r2 int default 2;

comment on column esclarecimiento.entrevista_colectiva.clasificacion_r2 is '1:Sí;  Otro valor: No';

alter table esclarecimiento.entrevista_colectiva
	add clasificacion_r1 int default 2;

comment on column esclarecimiento.entrevista_colectiva.clasificacion_r1 is '1:Sí;  Otro valor: No';

-- EE
alter table esclarecimiento.entrevista_etnica
	add clasificacion_r2 int default 2;

comment on column esclarecimiento.entrevista_etnica.clasificacion_r2 is '1:Sí;  Otro valor: No';

alter table esclarecimiento.entrevista_etnica
	add clasificacion_r1 int default 2;

comment on column esclarecimiento.entrevista_etnica.clasificacion_r1 is '1:Sí;  Otro valor: No';


-- PR
alter table esclarecimiento.entrevista_profundidad
	add clasificacion_r1 int default 2;

comment on column esclarecimiento.entrevista_profundidad.clasificacion_r1 is '1:Sí;  Otro valor: No';


-- DC
alter table esclarecimiento.diagnostico_comunitario
	add clasificacion_r2 int default 2;

comment on column esclarecimiento.diagnostico_comunitario.clasificacion_r2 is '1:Sí;  Otro valor: No';

alter table esclarecimiento.diagnostico_comunitario
	add clasificacion_r1 int default 2;

comment on column esclarecimiento.diagnostico_comunitario.clasificacion_r1 is '1:Sí;  Otro valor: No';


-- HV
alter table esclarecimiento.historia_vida
	add clasificacion_r2 int default 2;

comment on column esclarecimiento.historia_vida.clasificacion_r2 is '1:Sí;  Otro valor: No';

alter table esclarecimiento.historia_vida
	add clasificacion_r1 int default 2;

comment on column esclarecimiento.historia_vida.clasificacion_r1 is '1:Sí;  Otro valor: No';

-- Casos e informes
alter table esclarecimiento.casos_informes
	add clasifica_r1 int default 2;

comment on column esclarecimiento.casos_informes.clasifica_r1 is '1:Sí.  Otra cosa: No';




