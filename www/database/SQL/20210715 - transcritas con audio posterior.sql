select 1 as grupo, t.entrevista_codigo, t.fecha_transcripcion, a.maximo_adjunto
from (
         select e.entrevista_codigo, max(a.fh_insert) as fecha_transcripcion
         from esclarecimiento.e_ind_fvt e
                  join esclarecimiento.e_ind_fvt_adjunto a on e.id_e_ind_fvt = a.id_e_ind_fvt
         where a.id_tipo = 6
         group by 1) as t
         join
     (
         select e.entrevista_codigo, max(a.fh_insert) as maximo_adjunto
         from esclarecimiento.e_ind_fvt e
                  join esclarecimiento.e_ind_fvt_adjunto a on e.id_e_ind_fvt = a.id_e_ind_fvt
         where a.id_tipo = 2
         group by 1) as a
     on t.entrevista_codigo = a.entrevista_codigo

where maximo_adjunto > fecha_transcripcion


union
-- CO
select 2 as grupo, t.entrevista_codigo, t.fecha_transcripcion, a.maximo_adjunto
from (
         select e.entrevista_codigo, max(a.created_at) as fecha_transcripcion
         from esclarecimiento.entrevista_colectiva e
                  join esclarecimiento.entrevista_colectiva_adjunto a
                       on e.id_entrevista_colectiva = a.id_entrevista_colectiva
         where a.id_tipo = 6
         group by 1) as t
         join
     (
         select e.entrevista_codigo, max(a.created_at) as maximo_adjunto
         from esclarecimiento.entrevista_colectiva e
                  join esclarecimiento.entrevista_colectiva_adjunto a
                       on e.id_entrevista_colectiva = a.id_entrevista_colectiva

         where a.id_tipo = 2
         group by 1) as a
     on t.entrevista_codigo = a.entrevista_codigo

where maximo_adjunto > fecha_transcripcion

union
-- EE
select 3 as grupo, t.entrevista_codigo, t.fecha_transcripcion, a.maximo_adjunto
from (
         select e.entrevista_codigo, max(a.created_at) as fecha_transcripcion
         from esclarecimiento.entrevista_etnica e
                  join esclarecimiento.entrevista_etnica_adjunto a on e.id_entrevista_etnica = a.id_entrevista_etnica
         where a.id_tipo = 6
         group by 1) as t
         join
     (
         select e.entrevista_codigo, max(a.created_at) as maximo_adjunto
         from esclarecimiento.entrevista_etnica e
                  join esclarecimiento.entrevista_etnica_adjunto a on e.id_entrevista_etnica = a.id_entrevista_etnica

         where a.id_tipo = 2
         group by 1) as a
     on t.entrevista_codigo = a.entrevista_codigo
where maximo_adjunto > fecha_transcripcion
union
--PR
select 4 as grupo, t.entrevista_codigo, t.fecha_transcripcion, a.maximo_adjunto
from (
         select e.entrevista_codigo, max(a.created_at) as fecha_transcripcion
         from esclarecimiento.entrevista_profundidad e
                  join esclarecimiento.entrevista_profundidad_adjunto a on e.id_entrevista_profundidad = a.id_entrevista_profundidad
         where a.id_tipo = 6
         group by 1) as t
         join
     (
         select e.entrevista_codigo, max(a.created_at) as maximo_adjunto
         from esclarecimiento.entrevista_profundidad e
                  join esclarecimiento.entrevista_profundidad_adjunto a on e.id_entrevista_profundidad = a.id_entrevista_profundidad
         where a.id_tipo = 2
         group by 1) as a
     on t.entrevista_codigo = a.entrevista_codigo
where maximo_adjunto > fecha_transcripcion

union
-- DC
select 5 as grupo, t.entrevista_codigo, t.fecha_transcripcion, a.maximo_adjunto
from (
         select e.entrevista_codigo, max(a.created_at) as fecha_transcripcion
         from esclarecimiento.diagnostico_comunitario e
                  join esclarecimiento.diagnostico_comunitario_adjunto a on e.id_diagnostico_comunitario = a.id_diagnostico_comunitario
         where a.id_tipo = 6
         group by 1) as t
         join
     (
         select e.entrevista_codigo, max(a.created_at) as maximo_adjunto
         from esclarecimiento.diagnostico_comunitario e
                  join esclarecimiento.diagnostico_comunitario_adjunto a on e.id_diagnostico_comunitario = a.id_diagnostico_comunitario
         where a.id_tipo = 2
         group by 1) as a
     on t.entrevista_codigo = a.entrevista_codigo
where maximo_adjunto > fecha_transcripcion

union
--HV
select 6 as grupo,  t.entrevista_codigo, t.fecha_transcripcion, a.maximo_adjunto
from (
         select e.entrevista_codigo, max(a.created_at) as fecha_transcripcion
         from esclarecimiento.diagnostico_comunitario e
                  join esclarecimiento.diagnostico_comunitario_adjunto a on e.id_diagnostico_comunitario = a.id_diagnostico_comunitario
         where a.id_tipo = 6
         group by 1) as t
         join
     (
         select e.entrevista_codigo, max(a.created_at) as maximo_adjunto
         from esclarecimiento.historia_vida e
                  join esclarecimiento.historia_vida_adjunto a on e.id_historia_vida = a.id_historia_vida
         where a.id_tipo = 2
         group by 1) as a
     on t.entrevista_codigo = a.entrevista_codigo
where maximo_adjunto > fecha_transcripcion

order by grupo, entrevista_codigo