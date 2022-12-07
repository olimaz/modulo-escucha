-- Prioridad
create table prioridad
(
	id_prioridad serial not null
		constraint prioridad_pk
			primary key,
	id_entrevista integer default 0 not null,
	id_subserie integer default 0 not null,
	id_tipo integer default 1,
	codigo varchar(20),
	fluidez integer default 0,
	d_hecho integer default 1,
	d_contexto integer default 1,
	d_impacto integer default 1,
	d_justicia integer default 1,
	cierre integer default 0,
	ponderacion integer default 0,
	observaciones text,
	ahora_entiendo text,
	cambio_perspectiva text,
	fecha_hora timestamp default CURRENT_TIMESTAMP
);

comment on column prioridad.id_tipo is '1: entrevistador; 2:transcriptor';

comment on column prioridad.codigo is 'Temporal, para importar el excel';



create index prioridad_cierre_index
	on prioridad (cierre);

create index prioridad_d_contexto_index
	on prioridad (d_contexto);

create index prioridad_d_hecho_index
	on prioridad (d_hecho);

create index prioridad_d_impacto_index
	on prioridad (d_impacto);

create index prioridad_d_justicia_index
	on prioridad (d_justicia);

create index prioridad_id_entrevista_index
	on prioridad (id_entrevista);

create index prioridad_id_prioridad_index
	on prioridad (id_prioridad);

create index prioridad_id_subserie_index
	on prioridad (id_subserie);

create index prioridad_ponderacion_index
	on prioridad (ponderacion);

create unique index prioridad_codigo_uindex
	on prioridad (codigo);

alter table public.prioridad
owner to dba;


-- Arreglar entrevista etnica para que acepte softdelete
alter table esclarecimiento.entrevista_etnica
	add id_activo int default 1;

create index entrevista_etnica_id_activo_index
	on esclarecimiento.entrevista_etnica (id_activo);




-- limpieza

update prioridad set codigo=trim(codigo);
--ordernar por codigo y verificar


-- totales por subserie
select id_subserie,count(1)
    from prioridad
        group by 1;


-- asignar subserie (valores de produccion)

update prioridad set id_subserie=53 where codigo ilike '%-VI-%';
update prioridad set id_subserie=4 where codigo ilike '%-AA-%';
update prioridad set id_subserie=98 where codigo ilike '%-TC-%';
update prioridad set id_subserie=102 where codigo ilike '%-CO-%';
update prioridad set id_subserie=263 where codigo ilike '%-EE-%';
update prioridad set id_subserie=99 where codigo ilike '%-PR-%';
update prioridad set id_subserie=103 where codigo ilike '%-DC-%';
update prioridad set id_subserie=100 where codigo ilike '%-HV-%';


--Revision final
select codigo
    from prioridad
    where id_subserie=0;


--Aplicar id_entrevista

update prioridad p
set id_entrevista=e.id_e_ind_fvt
from esclarecimiento.e_ind_fvt e
where trim(p.codigo) ilike trim(e.entrevista_codigo);



update prioridad p
set id_entrevista=e.id_entrevista_colectiva
from esclarecimiento.entrevista_colectiva e
where trim(p.codigo) ilike trim(e.entrevista_codigo);


update prioridad p
set id_entrevista=e.id_entrevista_etnica
from esclarecimiento.entrevista_etnica e
where trim(p.codigo) ilike trim(e.entrevista_codigo);



update prioridad p
set id_entrevista=e.id_entrevista_profundidad
from esclarecimiento.entrevista_profundidad e
where trim(p.codigo) ilike trim(e.entrevista_codigo);



update prioridad p
set id_entrevista=e.id_diagnostico_comunitario
from esclarecimiento.diagnostico_comunitario e
where trim(p.codigo) ilike trim(e.entrevista_codigo);



update prioridad p
set id_entrevista=e.id_historia_vida
from esclarecimiento.historia_vida e
where trim(p.codigo) ilike trim(e.entrevista_codigo);



-- revision de asignacion
select id_subserie,count(1)
    from prioridad
        where id_entrevista >0
        group by 1;

