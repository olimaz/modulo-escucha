select entrevista.entrevista_codigo, criterio_fijo.descripcion, adjunto.md5
from esclarecimiento.adjunto
         join esclarecimiento.e_ind_fvt_adjunto as adjuntado on adjunto.id_adjunto = adjuntado.id_adjunto
         join esclarecimiento.e_ind_fvt as entrevista on adjuntado.id_e_ind_fvt=entrevista.id_e_ind_fvt
         join catalogos.criterio_fijo on (adjuntado.id_tipo=criterio_fijo.id_opcion and criterio_fijo.id_grupo=1)
where entrevista.id_activo=1
  and md5 is not null

union

select entrevista.entrevista_codigo, criterio_fijo.descripcion, adjunto.md5
from esclarecimiento.adjunto
         join esclarecimiento.entrevista_colectiva_adjunto as adjuntado on adjunto.id_adjunto = adjuntado.id_adjunto
         join esclarecimiento.entrevista_colectiva as entrevista on adjuntado.id_entrevista_colectiva=entrevista.id_entrevista_colectiva
         join catalogos.criterio_fijo on (adjuntado.id_tipo=criterio_fijo.id_opcion and criterio_fijo.id_grupo=1)
where entrevista.id_activo=1
  and md5 is not null

union


select entrevista.entrevista_codigo, criterio_fijo.descripcion, adjunto.md5
from esclarecimiento.adjunto
         join esclarecimiento.entrevista_etnica_adjunto as adjuntado on adjunto.id_adjunto = adjuntado.id_adjunto
         join esclarecimiento.entrevista_etnica as entrevista on adjuntado.id_entrevista_etnica=entrevista.id_entrevista_etnica
         join catalogos.criterio_fijo on (adjuntado.id_tipo=criterio_fijo.id_opcion and criterio_fijo.id_grupo=1)
where entrevista.id_activo=1
  and md5 is not null


union

select entrevista.entrevista_codigo, criterio_fijo.descripcion, adjunto.md5
from esclarecimiento.adjunto
         join esclarecimiento.entrevista_profundidad_adjunto as adjuntado on adjunto.id_adjunto = adjuntado.id_adjunto
         join esclarecimiento.entrevista_profundidad as entrevista on adjuntado.id_entrevista_profundidad=entrevista.id_entrevista_profundidad
         join catalogos.criterio_fijo on (adjuntado.id_tipo=criterio_fijo.id_opcion and criterio_fijo.id_grupo=1)
where entrevista.id_activo=1
  and md5 is not null
union
select entrevista.entrevista_codigo, criterio_fijo.descripcion, adjunto.md5
from esclarecimiento.adjunto
         join esclarecimiento.diagnostico_comunitario_adjunto as adjuntado on adjunto.id_adjunto = adjuntado.id_adjunto
         join esclarecimiento.diagnostico_comunitario as entrevista on adjuntado.id_diagnostico_comunitario=entrevista.id_diagnostico_comunitario
         join catalogos.criterio_fijo on (adjuntado.id_tipo=criterio_fijo.id_opcion and criterio_fijo.id_grupo=1)
where entrevista.id_activo=1
  and md5 is not null

union

select entrevista.entrevista_codigo, criterio_fijo.descripcion, adjunto.md5
from esclarecimiento.adjunto
         join esclarecimiento.historia_vida_adjunto as adjuntado on adjunto.id_adjunto = adjuntado.id_adjunto
         join esclarecimiento.historia_vida as entrevista on adjuntado.id_historia_vida=entrevista.id_historia_vida
         join catalogos.criterio_fijo on (adjuntado.id_tipo=criterio_fijo.id_opcion and criterio_fijo.id_grupo=1)
where entrevista.id_activo=1
  and md5 is not null




