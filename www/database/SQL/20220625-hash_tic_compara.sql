select  hash_tic.nombre_archivo, hash_tic.ubicacion_archivo,  e_ind_fvt.entrevista_codigo, es_virtual, abreviado as tipo_entrevista
from sim.hash_tic join esclarecimiento.adjunto on hash_tic.md5=adjunto.md5
                  join esclarecimiento.e_ind_fvt_adjunto on adjunto.id_adjunto = e_ind_fvt_adjunto.id_adjunto
                  join esclarecimiento.e_ind_fvt on e_ind_fvt_adjunto.id_e_ind_fvt = e_ind_fvt.id_e_ind_fvt
                  join catalogos.cat_item on e_ind_fvt.id_subserie=cat_item.id_item

union

select  hash_tic.nombre_archivo, hash_tic.ubicacion_archivo,  entrevista_colectiva.entrevista_codigo, es_virtual, 'CO' as tipo_entrevista
from sim.hash_tic join esclarecimiento.adjunto on hash_tic.md5=adjunto.md5
                  join esclarecimiento.entrevista_colectiva_adjunto on adjunto.id_adjunto = entrevista_colectiva_adjunto.id_adjunto
                  join esclarecimiento.entrevista_colectiva on entrevista_colectiva_adjunto.id_entrevista_colectiva = entrevista_colectiva.id_entrevista_colectiva

union

select  hash_tic.nombre_archivo, hash_tic.ubicacion_archivo,  entrevista_etnica.entrevista_codigo, es_virtual, 'EE' as tipo_entrevista
from sim.hash_tic join esclarecimiento.adjunto on hash_tic.md5=adjunto.md5
                  join esclarecimiento.entrevista_etnica_adjunto on adjunto.id_adjunto = entrevista_etnica_adjunto.id_adjunto
                  join esclarecimiento.entrevista_etnica on entrevista_etnica_adjunto.id_entrevista_etnica = entrevista_etnica.id_entrevista_etnica
union
select  hash_tic.nombre_archivo, hash_tic.ubicacion_archivo,  entrevista_profundidad.entrevista_codigo, es_virtual, 'PR' as tipo_entrevista
from sim.hash_tic join esclarecimiento.adjunto on hash_tic.md5=adjunto.md5
                  join esclarecimiento.entrevista_profundidad_adjunto on adjunto.id_adjunto = entrevista_profundidad_adjunto.id_adjunto
                  join esclarecimiento.entrevista_profundidad on entrevista_profundidad_adjunto.id_entrevista_profundidad = entrevista_profundidad.id_entrevista_profundidad
union
select  hash_tic.nombre_archivo, hash_tic.ubicacion_archivo,  diagnostico_comunitario.entrevista_codigo, es_virtual, 'DC' as tipo_entrevista
from sim.hash_tic join esclarecimiento.adjunto on hash_tic.md5=adjunto.md5
                  join esclarecimiento.diagnostico_comunitario_adjunto on adjunto.id_adjunto = diagnostico_comunitario_adjunto.id_adjunto
                  join esclarecimiento.diagnostico_comunitario on diagnostico_comunitario_adjunto.id_diagnostico_comunitario = diagnostico_comunitario.id_diagnostico_comunitario
union
select  hash_tic.nombre_archivo, hash_tic.ubicacion_archivo,  historia_vida.entrevista_codigo, es_virtual, 'HV' as tipo_entrevista
from sim.hash_tic join esclarecimiento.adjunto on hash_tic.md5=adjunto.md5
                  join esclarecimiento.historia_vida_adjunto on adjunto.id_adjunto = historia_vida_adjunto.id_adjunto
                  join esclarecimiento.historia_vida on historia_vida_adjunto.id_historia_vida = historia_vida.id_historia_vida


order by 2,1,3;


-- otra version
select hash_tic.*, adjunto.id_adjunto,
       e_ind_fvt.entrevista_codigo as c1,
       entrevista_colectiva.entrevista_codigo as c2,
       entrevista_etnica.entrevista_codigo as c3,
       entrevista_profundidad.entrevista_codigo as c4,
       diagnostico_comunitario.entrevista_codigo as c5,
       historia_vida.entrevista_codigo as c6

from sim.hash_tic
         left join esclarecimiento.adjunto on hash_tic.md5=adjunto.md5
    --
         left join esclarecimiento.e_ind_fvt_adjunto on adjunto.id_adjunto = e_ind_fvt_adjunto.id_adjunto
         left join esclarecimiento.e_ind_fvt on e_ind_fvt_adjunto.id_e_ind_fvt = e_ind_fvt.id_e_ind_fvt
    --
         left join esclarecimiento.entrevista_profundidad_adjunto on adjunto.id_adjunto = entrevista_profundidad_adjunto.id_adjunto
         left join esclarecimiento.entrevista_profundidad on entrevista_profundidad_adjunto.id_entrevista_profundidad = entrevista_profundidad.id_entrevista_profundidad
    --
         left join esclarecimiento.historia_vida_adjunto on adjunto.id_adjunto = historia_vida_adjunto.id_adjunto
         left join esclarecimiento.historia_vida on historia_vida_adjunto.id_historia_vida = historia_vida.id_historia_vida
    --
         left join esclarecimiento.entrevista_colectiva_adjunto on adjunto.id_adjunto = entrevista_colectiva_adjunto.id_adjunto
         left join esclarecimiento.entrevista_colectiva on entrevista_colectiva_adjunto.id_entrevista_colectiva = entrevista_colectiva.id_entrevista_colectiva
    --
         left join esclarecimiento.entrevista_etnica_adjunto on adjunto.id_adjunto = entrevista_etnica_adjunto.id_adjunto
         left join esclarecimiento.entrevista_etnica on entrevista_etnica_adjunto.id_entrevista_etnica = entrevista_etnica.id_entrevista_etnica
    --
         left join esclarecimiento.diagnostico_comunitario_adjunto on adjunto.id_adjunto = diagnostico_comunitario_adjunto.id_adjunto
         left join esclarecimiento.diagnostico_comunitario on diagnostico_comunitario_adjunto.id_diagnostico_comunitario = diagnostico_comunitario.id_diagnostico_comunitario
