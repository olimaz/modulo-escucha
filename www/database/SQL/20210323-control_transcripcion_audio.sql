select e.entrevista_codigo, audio.fh_insert as fecha_audio, trans.fh_insert as fecha_trans,
       DATE_PART('day', AGE(audio.fh_insert, trans.fh_insert)) AS dias_diferencia
from esclarecimiento.e_ind_fvt e
         join esclarecimiento.e_ind_fvt_adjunto audio on e.id_e_ind_fvt = audio.id_e_ind_fvt
         join esclarecimiento.e_ind_fvt_adjunto trans on e.id_e_ind_fvt = trans.id_e_ind_fvt
where audio.id_tipo = 2
  and trans.id_tipo = 6
  and audio > trans

union

select e.entrevista_codigo, audio.created_at as fecha_audio, trans.created_at as fecha_trans,
       DATE_PART('day', AGE(audio.created_at, trans.created_at)) AS dias_diferencia
from esclarecimiento.entrevista_colectiva e
         join esclarecimiento.entrevista_colectiva_adjunto audio on e.id_entrevista_colectiva = audio.id_entrevista_colectiva
         join esclarecimiento.entrevista_colectiva_adjunto trans on e.id_entrevista_colectiva = trans.id_entrevista_colectiva
where audio.id_tipo = 2
  and trans.id_tipo = 6
  and audio > trans

union

select e.entrevista_codigo, audio.created_at as fecha_audio, trans.created_at as fecha_trans,
       DATE_PART('day', AGE(audio.created_at, trans.created_at)) AS dias_diferencia
from esclarecimiento.entrevista_etnica e
         join esclarecimiento.entrevista_etnica_adjunto audio on e.id_entrevista_etnica = audio.id_entrevista_etnica
         join esclarecimiento.entrevista_etnica_adjunto trans on e.id_entrevista_etnica = trans.id_entrevista_etnica
where audio.id_tipo = 2
  and trans.id_tipo = 6
  and audio > trans

union
select e.entrevista_codigo, audio.created_at as fecha_audio, trans.created_at as fecha_trans,
       DATE_PART('day', AGE(audio.created_at, trans.created_at)) AS dias_diferencia
from esclarecimiento.entrevista_profundidad e
         join esclarecimiento.entrevista_profundidad_adjunto audio on e.id_entrevista_profundidad = audio.id_entrevista_profundidad
         join esclarecimiento.entrevista_profundidad_adjunto trans on e.id_entrevista_profundidad = trans.id_entrevista_profundidad
where audio.id_tipo = 2
  and trans.id_tipo = 6
  and audio > trans

union
select e.entrevista_codigo, audio.created_at as fecha_audio, trans.created_at as fecha_trans,
       DATE_PART('day', AGE(audio.created_at, trans.created_at)) AS dias_diferencia
from esclarecimiento.diagnostico_comunitario e
         join esclarecimiento.diagnostico_comunitario_adjunto audio on e.id_diagnostico_comunitario = audio.id_diagnostico_comunitario
         join esclarecimiento.diagnostico_comunitario_adjunto trans on e.id_diagnostico_comunitario = trans.id_diagnostico_comunitario
where audio.id_tipo = 2
  and trans.id_tipo = 6
  and audio > trans

union

select e.entrevista_codigo, audio.created_at as fecha_audio, trans.created_at as fecha_trans,
       DATE_PART('day', AGE(audio.created_at, trans.created_at)) AS dias_diferencia
from esclarecimiento.historia_vida e
         join esclarecimiento.historia_vida_adjunto audio on e.id_historia_vida = audio.id_historia_vida
         join esclarecimiento.historia_vida_adjunto trans on e.id_historia_vida = trans.id_historia_vida
where audio.id_tipo = 2
  and trans.id_tipo = 6
  and audio > trans

order by 1


