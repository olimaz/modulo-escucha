
-- rechazados
select c.id_entrevistador, u.name, count(1) as conteo
from catalogos.cat_item c
    join esclarecimiento.entrevistador e on (c.id_entrevistador=e.id_entrevistador)
    join users u on e.id_usuario = u.id
where pendiente_revisar=3 and habilitado=2
group by 1,2
order by 3 desc;


-- aceptados
select c.id_entrevistador, u.name, count(1) as conteo
from catalogos.cat_item c
    join esclarecimiento.entrevistador e on (c.id_entrevistador=e.id_entrevistador)
    join users u on e.id_usuario = u.id
where pendiente_revisar=3 and habilitado=1
group by 1,2
order by 3 desc;
