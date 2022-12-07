-- Criterio fijo para cierre de expedientes
INSERT INTO "catalogos"."criterio_fijo_grupo" ("id_grupo", "descripcion") VALUES (35, 'Cierre de expedientes');
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (35, 1, 'Sí, cerrado.', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (35, 2, 'No, abierto. Pendiente de procesar.', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (35, 3, 'No, abierto. Con algo pendiente de resolver.', DEFAULT);


-- Modificar tabla de entrevistas individuales
alter table esclarecimiento.e_ind_fvt
	add id_cerrado int default 2;

comment on column esclarecimiento.e_ind_fvt.id_cerrado is 'Criterio fijo 35';

create index e_ind_fvt_id_cerrado_index
	on esclarecimiento.e_ind_fvt (id_cerrado);


-- Modificar tabla de entrevistas colectivas
alter table esclarecimiento.entrevista_colectiva
	add id_cerrado int default 2;

comment on column esclarecimiento.entrevista_colectiva.id_cerrado is 'Criterio fijo 35';

create index entrevista_colectiva_id_cerrado_index
	on esclarecimiento.entrevista_colectiva (id_cerrado);


-- Modificar tabla de entrevistas etnicas
alter table esclarecimiento.entrevista_etnica
	add id_cerrado int default 2;

comment on column esclarecimiento.entrevista_etnica.id_cerrado is 'Criterio fijo 35';

create index entrevista_etnica_id_cerrado_index
	on esclarecimiento.entrevista_etnica (id_cerrado);

--

-- Modificar tabla de entrevistas profundidad
alter table esclarecimiento.entrevista_profundidad
	add id_cerrado int default 2;

comment on column esclarecimiento.entrevista_profundidad.id_cerrado is 'Criterio fijo 35';

create index entrevista_profundidad_id_cerrado_index
	on esclarecimiento.entrevista_profundidad (id_cerrado);


-- Modificar tabla de diagnosticos
alter table esclarecimiento.diagnostico_comunitario
	add id_cerrado int default 2;

comment on column esclarecimiento.diagnostico_comunitario.id_cerrado is 'Criterio fijo 35';

create index diagnostico_comunitario_id_cerrado_index
	on esclarecimiento.diagnostico_comunitario (id_cerrado);

-- Modificar tabla de historia vida
alter table esclarecimiento.historia_vida
	add id_cerrado int default 2;

comment on column esclarecimiento.historia_vida.id_cerrado is 'Criterio fijo 35';

create index historia_vida_id_cerrado_index
	on esclarecimiento.historia_vida (id_cerrado);


-- Actualizar el estado

update esclarecimiento.e_ind_fvt e
    set id_cerrado = s.id_cerrado
from public.seguimiento s
where e.id_e_ind_fvt=s.id_entrevista and e.id_subserie=s.id_subserie


-- colectiva
update esclarecimiento.entrevista_colectiva e
    set id_cerrado = s.id_cerrado
from public.seguimiento s
where e.id_entrevista_colectiva=s.id_entrevista and s.id_subserie=78;

--etnica
update esclarecimiento.entrevista_etnica e
    set id_cerrado = s.id_cerrado
from public.seguimiento s
where e.id_entrevista_etnica=s.id_entrevista and s.id_subserie=586;


--PR
update esclarecimiento.entrevista_profundidad e
    set id_cerrado = s.id_cerrado
from public.seguimiento s
where e.id_entrevista_profundidad=s.id_entrevista and s.id_subserie=75;

--DC
update esclarecimiento.diagnostico_comunitario e
    set id_cerrado = s.id_cerrado
from public.seguimiento s
where e.id_diagnostico_comunitario=s.id_entrevista and s.id_subserie=79;

--HV
update esclarecimiento.historia_vida e
    set id_cerrado = s.id_cerrado
from public.seguimiento s
where e.id_historia_vida=s.id_entrevista and s.id_subserie=76;