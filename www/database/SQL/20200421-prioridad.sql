
-- limpieza

update prioridad set codigo=trim(codigo) where id_prioridad >=6404;
--ordernar por codigo y verificar


-- totales por subserie
select id_subserie,count(1)
    from prioridad
        group by 1;


-- asignar subserie.  Estos son valores de id_subserie en producción
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
where trim(p.codigo) ilike trim(e.entrevista_codigo)
    and p.id_tipo=1 and p.id_entrevista = 0;



update prioridad p
set id_entrevista=e.id_entrevista_colectiva
from esclarecimiento.entrevista_colectiva e
where trim(p.codigo) ilike trim(e.entrevista_codigo)
    and p.id_tipo=1 and p.id_entrevista  = 0;


update prioridad p
set id_entrevista=e.id_entrevista_etnica
from esclarecimiento.entrevista_etnica e
where trim(p.codigo) ilike trim(e.entrevista_codigo)
    and p.id_tipo=1 and p.id_entrevista  = 0;



update prioridad p
set id_entrevista=e.id_entrevista_profundidad
from esclarecimiento.entrevista_profundidad e
where trim(p.codigo) ilike trim(e.entrevista_codigo)
    and p.id_tipo=1 and p.id_entrevista  = 0;



update prioridad p
set id_entrevista=e.id_diagnostico_comunitario
from esclarecimiento.diagnostico_comunitario e
where trim(p.codigo) ilike trim(e.entrevista_codigo)
    and p.id_tipo=1 and p.id_entrevista  = 0;



update prioridad p
set id_entrevista=e.id_historia_vida
from esclarecimiento.historia_vida e
where trim(p.codigo) ilike trim(e.entrevista_codigo)
    and p.id_tipo=1 and p.id_entrevista  = 0;



-- revision de asignacion
select id_subserie,count(1)
    from prioridad
        where id_entrevista >0
        group by 1;


--Valores procesados
select count(1)
    from prioridad
    where id_subserie >0 and id_entrevista > 0
        and id_prioridad >=6404;

