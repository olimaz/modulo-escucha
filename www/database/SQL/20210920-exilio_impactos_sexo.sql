select e.id_e_ind_fvt, e.entrevista_codigo,  sexo.descripcion as sexo
     , ca.nombre as tipo, ci.descripcion as impacto

from esclarecimiento.e_ind_fvt e
         join fichas.persona_entrevistada pe on e.id_e_ind_fvt = pe.id_e_ind_fvt
         join fichas.persona p on pe.id_persona = p.id_persona
         join fichas.entrevista_impacto ei on e.id_e_ind_fvt = ei.id_e_ind_fvt
         join catalogos.cat_item ci on ei.id_impacto=ci.id_item
         join catalogos.cat_cat ca on ci.id_cat=ca.id_cat
         join catalogos.cat_item sexo on p.id_sexo=sexo.id_item

where
        e.id_activo=1
  and e.id_subserie=53
  and e.id_e_ind_fvt in (
    select e.id_e_ind_fvt
    from esclarecimiento.e_ind_fvt e
             join fichas.hecho h on e.id_e_ind_fvt = h.id_e_ind_fvt
             join fichas.hecho_violencia v on h.id_hecho = v.id_hecho
             join catalogos.violencia on v.id_tipo_violencia = violencia.id_geo
    where violencia.codigo = '22'  -- con exilio como violencia

    union

    select e.id_e_ind_fvt
    from esclarecimiento.e_ind_fvt
             join fichas.exilio on e_ind_fvt.id_e_ind_fvt = exilio.id_e_ind_fvt
             join fichas.exilio_movimiento on exilio.id_exilio = exilio_movimiento.id_exilio
    -- con ficha de exilio
)  -- de interes para exilio
order by e.id_e_ind_fvt, tipo, impacto