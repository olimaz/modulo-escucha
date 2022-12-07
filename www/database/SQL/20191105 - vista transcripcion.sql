drop view vista_transcribir_asignacion;
CREATE or replace VIEW vista_transcribir_asignacion AS

    select id_transcribir_asignacion as id, id_autoriza as autoriza_id, a.numero_entrevistador as autoriza_txt
         , id_transcriptor as transcriptor_id, tr.numero_entrevistador as transcriptor_codigo, u.name as transcriptor_nombre
         , id_situacion as estado_id, cf.descripcion as estado_txt
         , id_causa as causa_id, c.descripcion as causa_txt
         , urgente as urgente_id, CASE when urgente=1 then 'Sí' else 'No' END as urgente_txt
         , t.observaciones, fh_asignado
         , to_char(fh_asignado,'yyyy-mm') as fh_asignado_mes, to_char(fh_asignado,'yyyy-mm-dd') as fh_asignado_dia , to_char(fh_asignado,'IYYY-IW') as fh_asignado_semana
         , fh_transcrito
         , to_char(fh_transcrito,'yyyy-mm') as fh_transcrito_mes, to_char(fh_transcrito,'yyyy-mm-dd') as fh_transcrito_dia , to_char(fh_transcrito,'IYYY-IW') as fh_transcrito_semana
         , fh_inicio, fh_fin, duracion_entrevista_minutos, duracion_transcripcion_minutos, duracion_transcripcion_real_minutos
         , terceros as terceros_id, CASE when terceros=1 then 'Sí' else 'No' END as terceros_txt
         , e.entrevista_codigo

    from public.transcribir_asignacion t join esclarecimiento.entrevistador a on t.id_autoriza=a.id_entrevistador
                                         join esclarecimiento.entrevistador as tr on (t.id_transcriptor=tr.id_entrevistador)
                                         join users u on (tr.id_usuario=u.id)
                                         join catalogos.criterio_fijo cf on (t.id_situacion=cf.id_opcion and cf.id_grupo=8)
                                         left join catalogos.cat_item c on (t.id_causa=c.id_item)
                                         join esclarecimiento.e_ind_fvt as e on (t.id_e_ind_fvt=e.id_e_ind_fvt)

    union

    select id_transcribir_asignacion as id, id_autoriza as autoriza_id, a.numero_entrevistador as autoriza_txt
         , id_transcriptor as transcriptor_id, tr.numero_entrevistador as transcriptor_codigo, u.name as transcriptor_nombre
         , id_situacion as estado_id, cf.descripcion as estado_txt
         , id_causa as causa_id, c.descripcion as causa_txt
         , urgente as urgente_id, CASE when urgente=1 then 'Sí' else 'No' END as urgente_txt
         , t.observaciones, fh_asignado
         , to_char(fh_asignado,'yyyy-mm') as fh_asignado_mes, to_char(fh_asignado,'yyyy-mm-dd') as fh_asignado_dia , to_char(fh_asignado,'IYYY-IW') as fh_asignado_semana
         , fh_transcrito
         , to_char(fh_transcrito,'yyyy-mm') as fh_transcrito_mes, to_char(fh_transcrito,'yyyy-mm-dd') as fh_transcrito_dia , to_char(fh_transcrito,'IYYY-IW') as fh_transcrito_semana
         , fh_inicio, fh_fin, duracion_entrevista_minutos, duracion_transcripcion_minutos, duracion_transcripcion_real_minutos
         , terceros as terceros_id, CASE when terceros=1 then 'Sí' else 'No' END as terceros_txt
         , e.entrevista_codigo

    from public.transcribir_asignacion t join esclarecimiento.entrevistador a on t.id_autoriza=a.id_entrevistador
                                         join esclarecimiento.entrevistador as tr on (t.id_transcriptor=tr.id_entrevistador)
                                         join users u on (tr.id_usuario=u.id)
                                         join catalogos.criterio_fijo cf on (t.id_situacion=cf.id_opcion and cf.id_grupo=8)
                                         left join catalogos.cat_item c on (t.id_causa=c.id_item)
                                         join esclarecimiento.entrevista_profundidad as e on (t.id_entrevista_profundidad=e.id_entrevista_profundidad)

    union

    select id_transcribir_asignacion as id, id_autoriza as autoriza_id, a.numero_entrevistador as autoriza_txt
         , id_transcriptor as transcriptor_id, tr.numero_entrevistador as transcriptor_codigo, u.name as transcriptor_nombre
         , id_situacion as estado_id, cf.descripcion as estado_txt
         , id_causa as causa_id, c.descripcion as causa_txt
         , urgente as urgente_id, CASE when urgente=1 then 'Sí' else 'No' END as urgente_txt
         , t.observaciones, fh_asignado
         , to_char(fh_asignado,'yyyy-mm') as fh_asignado_mes, to_char(fh_asignado,'yyyy-mm-dd') as fh_asignado_dia , to_char(fh_asignado,'IYYY-IW') as fh_asignado_semana
         , fh_transcrito
         , to_char(fh_transcrito,'yyyy-mm') as fh_transcrito_mes, to_char(fh_transcrito,'yyyy-mm-dd') as fh_transcrito_dia , to_char(fh_transcrito,'IYYY-IW') as fh_transcrito_semana
         , fh_inicio, fh_fin, duracion_entrevista_minutos, duracion_transcripcion_minutos, duracion_transcripcion_real_minutos
         , terceros as terceros_id, CASE when terceros=1 then 'Sí' else 'No' END as terceros_txt
         , e.entrevista_codigo

    from public.transcribir_asignacion t join esclarecimiento.entrevistador a on t.id_autoriza=a.id_entrevistador
                                         join esclarecimiento.entrevistador as tr on (t.id_transcriptor=tr.id_entrevistador)
                                         join users u on (tr.id_usuario=u.id)
                                         join catalogos.criterio_fijo cf on (t.id_situacion=cf.id_opcion and cf.id_grupo=8)
                                         left join catalogos.cat_item c on (t.id_causa=c.id_item)
                                         join esclarecimiento.entrevista_colectiva as e on (t.id_entrevista_colectiva=e.id_entrevista_colectiva)


    union

    select id_transcribir_asignacion as id, id_autoriza as autoriza_id, a.numero_entrevistador as autoriza_txt
         , id_transcriptor as transcriptor_id, tr.numero_entrevistador as transcriptor_codigo, u.name as transcriptor_nombre
         , id_situacion as estado_id, cf.descripcion as estado_txt
         , id_causa as causa_id, c.descripcion as causa_txt
         , urgente as urgente_id, CASE when urgente=1 then 'Sí' else 'No' END as urgente_txt
         , t.observaciones, fh_asignado
         , to_char(fh_asignado,'yyyy-mm') as fh_asignado_mes, to_char(fh_asignado,'yyyy-mm-dd') as fh_asignado_dia , to_char(fh_asignado,'IYYY-IW') as fh_asignado_semana
         , fh_transcrito
         , to_char(fh_transcrito,'yyyy-mm') as fh_transcrito_mes, to_char(fh_transcrito,'yyyy-mm-dd') as fh_transcrito_dia , to_char(fh_transcrito,'IYYY-IW') as fh_transcrito_semana
         , fh_inicio, fh_fin, t.duracion_entrevista_minutos, duracion_transcripcion_minutos, duracion_transcripcion_real_minutos
         , terceros as terceros_id, CASE when terceros=1 then 'Sí' else 'No' END as terceros_txt
         , e.entrevista_codigo

    from public.transcribir_asignacion t join esclarecimiento.entrevistador a on t.id_autoriza=a.id_entrevistador
                                         join esclarecimiento.entrevistador as tr on (t.id_transcriptor=tr.id_entrevistador)
                                         join users u on (tr.id_usuario=u.id)
                                         join catalogos.criterio_fijo cf on (t.id_situacion=cf.id_opcion and cf.id_grupo=8)
                                         left join catalogos.cat_item c on (t.id_causa=c.id_item)
                                         join esclarecimiento.entrevista_etnica as e on (t.id_entrevista_etnica=e.id_entrevista_etnica)

    union

    select id_transcribir_asignacion as id, id_autoriza as autoriza_id, a.numero_entrevistador as autoriza_txt
         , id_transcriptor as transcriptor_id, tr.numero_entrevistador as transcriptor_codigo, u.name as transcriptor_nombre
         , id_situacion as estado_id, cf.descripcion as estado_txt
         , id_causa as causa_id, c.descripcion as causa_txt
         , urgente as urgente_id, CASE when urgente=1 then 'Sí' else 'No' END as urgente_txt
         , t.observaciones, fh_asignado
         , to_char(fh_asignado,'yyyy-mm') as fh_asignado_mes, to_char(fh_asignado,'yyyy-mm-dd') as fh_asignado_dia , to_char(fh_asignado,'IYYY-IW') as fh_asignado_semana
         , fh_transcrito
         , to_char(fh_transcrito,'yyyy-mm') as fh_transcrito_mes, to_char(fh_transcrito,'yyyy-mm-dd') as fh_transcrito_dia , to_char(fh_transcrito,'IYYY-IW') as fh_transcrito_semana
         , fh_inicio, fh_fin, duracion_entrevista_minutos, duracion_transcripcion_minutos, duracion_transcripcion_real_minutos
         , terceros as terceros_id, CASE when terceros=1 then 'Sí' else 'No' END as terceros_txt
         , e.entrevista_codigo

    from public.transcribir_asignacion t join esclarecimiento.entrevistador a on t.id_autoriza=a.id_entrevistador
                                         join esclarecimiento.entrevistador as tr on (t.id_transcriptor=tr.id_entrevistador)
                                         join users u on (tr.id_usuario=u.id)
                                         join catalogos.criterio_fijo cf on (t.id_situacion=cf.id_opcion and cf.id_grupo=8)
                                         left join catalogos.cat_item c on (t.id_causa=c.id_item)
                                         join esclarecimiento.diagnostico_comunitario as e on (t.id_diagnostico_comunitario=e.id_diagnostico_comunitario)

    union

    select id_transcribir_asignacion as id, id_autoriza as autoriza_id, a.numero_entrevistador as autoriza_txt
         , id_transcriptor as transcriptor_id, tr.numero_entrevistador as transcriptor_codigo, u.name as transcriptor_nombre
         , id_situacion as estado_id, cf.descripcion as estado_txt
         , id_causa as causa_id, c.descripcion as causa_txt
         , urgente as urgente_id, CASE when urgente=1 then 'Sí' else 'No' END as urgente_txt
         , t.observaciones, fh_asignado
         , to_char(fh_asignado,'yyyy-mm') as fh_asignado_mes, to_char(fh_asignado,'yyyy-mm-dd') as fh_asignado_dia , to_char(fh_asignado,'IYYY-IW') as fh_asignado_semana
         , fh_transcrito
         , to_char(fh_transcrito,'yyyy-mm') as fh_transcrito_mes, to_char(fh_transcrito,'yyyy-mm-dd') as fh_transcrito_dia , to_char(fh_transcrito,'IYYY-IW') as fh_transcrito_semana
         , fh_inicio, fh_fin, duracion_entrevista_minutos, duracion_transcripcion_minutos, duracion_transcripcion_real_minutos
         , terceros as terceros_id, CASE when terceros=1 then 'Sí' else 'No' END as terceros_txt
         , e.entrevista_codigo

    from public.transcribir_asignacion t join esclarecimiento.entrevistador a on t.id_autoriza=a.id_entrevistador
                                         join esclarecimiento.entrevistador as tr on (t.id_transcriptor=tr.id_entrevistador)
                                         join users u on (tr.id_usuario=u.id)
                                         join catalogos.criterio_fijo cf on (t.id_situacion=cf.id_opcion and cf.id_grupo=8)
                                         left join catalogos.cat_item c on (t.id_causa=c.id_item)
                                         join esclarecimiento.historia_vida as e on (t.id_historia_vida=e.id_historia_vida)


    order by entrevista_codigo;


grant select on public.vista_transcribir_asignacion to solo_lectura;