-- R1=3
update esclarecimiento.adjunto as a
    set id_calificacion=3
    from esclarecimiento.mis_casos_adjunto aa
    where a.id_adjunto=aa.id_adjunto
  and aa.clasificacion_nivel=1
    and a.id_calificacion is null;

-- R2=2
update esclarecimiento.adjunto as a
set id_calificacion=2
from esclarecimiento.mis_casos_adjunto aa
where a.id_adjunto=aa.id_adjunto
  and aa.clasificacion_nivel=2
  and a.id_calificacion is null;

-- R3=2
update esclarecimiento.adjunto as a
set id_calificacion=2
from esclarecimiento.mis_casos_adjunto aa
where a.id_adjunto=aa.id_adjunto
  and aa.clasificacion_nivel=3
  and a.id_calificacion is null;

-- R4=1
update esclarecimiento.adjunto as a
set id_calificacion=1
from esclarecimiento.mis_casos_adjunto aa
where a.id_adjunto=aa.id_adjunto
  and aa.clasificacion_nivel=4
  and a.id_calificacion is null;

-- JUSTIFICACIONES
--R1
insert into esclarecimiento.adjunto_justificacion (id_adjunto,id_justificacion)
    select a.id_adjunto,6
    from esclarecimiento.adjunto a, esclarecimiento.mis_casos_adjunto aa
    where a.id_adjunto=aa.id_adjunto and a.id_calificacion=3;

insert into esclarecimiento.adjunto_justificacion (id_adjunto,id_justificacion)
select a.id_adjunto,10
from esclarecimiento.adjunto a, esclarecimiento.mis_casos_adjunto aa
where a.id_adjunto=aa.id_adjunto and a.id_calificacion=3;

-- R2 y R3
insert into esclarecimiento.adjunto_justificacion (id_adjunto,id_justificacion)
select a.id_adjunto,1
from esclarecimiento.adjunto a, esclarecimiento.mis_casos_adjunto aa
where a.id_adjunto=aa.id_adjunto and a.id_calificacion=2;

insert into esclarecimiento.adjunto_justificacion (id_adjunto,id_justificacion)
select a.id_adjunto,2
from esclarecimiento.adjunto a, esclarecimiento.mis_casos_adjunto aa
where a.id_adjunto=aa.id_adjunto and a.id_calificacion=2;

insert into esclarecimiento.adjunto_justificacion (id_adjunto,id_justificacion)
select a.id_adjunto,3
from esclarecimiento.adjunto a, esclarecimiento.mis_casos_adjunto aa
where a.id_adjunto=aa.id_adjunto and a.id_calificacion=2;