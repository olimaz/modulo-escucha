select 'VI' as subserie, e.entrevista_correlativo, e.entrevista_codigo, cf.descripcion as tipo, a.ubicacion, a.tamano, regexp_matches(a.ubicacion,'\.(\w+)$') as extension
from esclarecimiento.e_ind_fvt as e
         join esclarecimiento.e_ind_fvt_adjunto as ea on e.id_e_ind_fvt = ea.id_e_ind_fvt
         join esclarecimiento.adjunto as a on ea.id_adjunto=a.id_adjunto
         join catalogos.criterio_fijo as cf on (ea.id_tipo=cf.id_opcion and cf.id_grupo=1)
where e.id_activo=1
  and id_subserie=53

union

select 'AA' as subserie, e.entrevista_correlativo, e.entrevista_codigo, cf.descripcion as tipo, a.ubicacion, a.tamano, regexp_matches(a.ubicacion,'\.(\w+)$') as extension
from esclarecimiento.e_ind_fvt as e
         join esclarecimiento.e_ind_fvt_adjunto as ea on e.id_e_ind_fvt = ea.id_e_ind_fvt
         join esclarecimiento.adjunto as a on ea.id_adjunto=a.id_adjunto
         join catalogos.criterio_fijo as cf on (ea.id_tipo=cf.id_opcion and cf.id_grupo=1)
where e.id_activo=1
  and id_subserie=4

union

select 'TC' as subserie, e.entrevista_correlativo, e.entrevista_codigo, cf.descripcion as tipo, a.ubicacion, a.tamano, regexp_matches(a.ubicacion,'\.(\w+)$') as extension
from esclarecimiento.e_ind_fvt as e
         join esclarecimiento.e_ind_fvt_adjunto as ea on e.id_e_ind_fvt = ea.id_e_ind_fvt
         join esclarecimiento.adjunto as a on ea.id_adjunto=a.id_adjunto
         join catalogos.criterio_fijo as cf on (ea.id_tipo=cf.id_opcion and cf.id_grupo=1)
where e.id_activo=1
  and id_subserie=98
union
select 'CO' as subserie, e.entrevista_correlativo, e.entrevista_codigo, cf.descripcion as tipo, a.ubicacion, a.tamano, regexp_matches(a.ubicacion,'\.(\w+)$') as extension
from esclarecimiento.entrevista_colectiva as e
         join esclarecimiento.entrevista_colectiva_adjunto as ea on e.id_entrevista_colectiva = ea.id_entrevista_colectiva
         join esclarecimiento.adjunto as a on ea.id_adjunto=a.id_adjunto
         join catalogos.criterio_fijo as cf on (ea.id_tipo=cf.id_opcion and cf.id_grupo=1)
where e.id_activo=1
union
select 'EE' as subserie, e.entrevista_correlativo, e.entrevista_codigo, cf.descripcion as tipo, a.ubicacion, a.tamano, regexp_matches(a.ubicacion,'\.(\w+)$') as extension
from esclarecimiento.entrevista_etnica as e
         join esclarecimiento.entrevista_etnica_adjunto as ea on e.id_entrevista_etnica = ea.id_entrevista_etnica
         join esclarecimiento.adjunto as a on ea.id_adjunto=a.id_adjunto
         join catalogos.criterio_fijo as cf on (ea.id_tipo=cf.id_opcion and cf.id_grupo=1)
where e.id_activo=1
union
select 'PR' as subserie, e.entrevista_correlativo, e.entrevista_codigo, cf.descripcion as tipo, a.ubicacion, a.tamano, regexp_matches(a.ubicacion,'\.(\w+)$') as extension
from esclarecimiento.entrevista_profundidad as e
         join esclarecimiento.entrevista_profundidad_adjunto as ea on e.id_entrevista_profundidad = ea.id_entrevista_profundidad
         join esclarecimiento.adjunto as a on ea.id_adjunto=a.id_adjunto
         join catalogos.criterio_fijo as cf on (ea.id_tipo=cf.id_opcion and cf.id_grupo=1)
where e.id_activo=1
union
select 'DC' as subserie, e.entrevista_correlativo, e.entrevista_codigo, cf.descripcion as tipo, a.ubicacion, a.tamano, regexp_matches(a.ubicacion,'\.(\w+)$') as extension
from esclarecimiento.diagnostico_comunitario as e
         join esclarecimiento.diagnostico_comunitario_adjunto as ea on e.id_diagnostico_comunitario = ea.id_diagnostico_comunitario
         join esclarecimiento.adjunto as a on ea.id_adjunto=a.id_adjunto
         join catalogos.criterio_fijo as cf on (ea.id_tipo=cf.id_opcion and cf.id_grupo=1)
where e.id_activo=1
union
select 'HV' as subserie, e.entrevista_correlativo, e.entrevista_codigo, cf.descripcion as tipo, a.ubicacion, a.tamano, regexp_matches(a.ubicacion,'\.(\w+)$') as extension
from esclarecimiento.historia_vida as e
         join esclarecimiento.historia_vida_adjunto as ea on e.id_historia_vida = ea.id_historia_vida
         join esclarecimiento.adjunto as a on ea.id_adjunto=a.id_adjunto
         join catalogos.criterio_fijo as cf on (ea.id_tipo=cf.id_opcion and cf.id_grupo=1)
where e.id_activo=1
order by 1,2,4





