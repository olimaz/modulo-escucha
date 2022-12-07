INSERT INTO "catalogos"."criterio_fijo_grupo" ("id_grupo", "descripcion") VALUES (12, 'Sí, No, No Aplica');
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (12, 1, 'Sí', 1);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (12, 2, 'No', 2);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (12, 3, 'No Aplica', 3);


alter table seguimiento_problema
	add id_resolvible int default 1;

comment on column seguimiento_problema.id_resolvible is 'Criterio fijo 12: si, no, no aplica';

alter table seguimiento_problema
	add sugerencia text;

comment on column seguimiento_problema.sugerencia is 'cómo se puede resolver';

alter table seguimiento_problema
	add sugerencia_fh timestamp;

alter table seguimiento_problema
	add sugerencia_id_entrevistador int;


-- VIRTUALES
alter table esclarecimiento.e_ind_fvt
	add es_virtual int default 2;

create index e_ind_fvt_es_virtual_index
	on esclarecimiento.e_ind_fvt (es_virtual);

alter table esclarecimiento.entrevista_colectiva
	add es_virtual int default 2;

create index entrevista_colectiva_es_virtual_index
	on esclarecimiento.entrevista_colectiva (es_virtual);


alter table esclarecimiento.entrevista_etnica
	add es_virtual int default 2;

create index entrevista_etnica_es_virtual_index
	on esclarecimiento.entrevista_etnica (es_virtual);


alter table esclarecimiento.entrevista_profundidad
	add es_virtual int default 2;

create index entrevista_profundidad_es_virtual_index
	on esclarecimiento.entrevista_profundidad (es_virtual);


alter table esclarecimiento.diagnostico_comunitario
	add es_virtual int default 2;

create index diagnostico_comunitario_es_virtual_index
	on esclarecimiento.diagnostico_comunitario (es_virtual);


alter table esclarecimiento.historia_vida
	add es_virtual int default 2;

create index historia_vida_es_virtual_index
	on esclarecimiento.historia_vida (es_virtual);
