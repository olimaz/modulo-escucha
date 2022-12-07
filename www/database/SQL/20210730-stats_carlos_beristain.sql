-- Analisis de hechos
select e.id_e_ind_fvt, e.entrevista_codigo, h.*, vg.*
    from esclarecimiento.e_ind_fvt e
        join fichas.hecho h on e.id_e_ind_fvt = h.id_e_ind_fvt
        join catalogos.vista_geo vg on h.id_lugar =vg.id_geo
where
    e.id_activo=1
    and e.id_subserie=53
order by e.id_e_ind_fvt, h.id_hecho;

-- Analisis de contexo
select e.id_e_ind_fvt, e.entrevista_codigo, h.*, cat_cat.nombre as tipo, i.descripcion as contexto
    from esclarecimiento.e_ind_fvt e
        join fichas.hecho h on e.id_e_ind_fvt = h.id_e_ind_fvt
        join fichas.hecho_contexto c on h.id_hecho = c.id_hecho
        join catalogos.cat_item i on c.id_contexto = i.id_item
        join catalogos.cat_cat on i.id_cat= cat_cat.id_cat

where
    e.id_activo=1
    and e.id_subserie=53
order by e.id_e_ind_fvt, h.id_hecho, cat_cat.nombre, i.descripcion;

-- Analisis de violencia
select e.id_e_ind_fvt, e.entrevista_codigo, h.*, vg.*, hv.*, v.descripcion as tipo, v2.descripcion as subtipo
    from esclarecimiento.e_ind_fvt e
        join fichas.hecho h on e.id_e_ind_fvt = h.id_e_ind_fvt
        join catalogos.vista_geo vg on h.id_lugar =vg.id_geo
        join fichas.hecho_violencia hv on h.id_hecho = hv.id_hecho
        join catalogos.violencia v on hv.id_tipo_violencia=v.id_geo
        join catalogos.violencia v2 on hv.id_subtipo_violencia = v2.id_geo

where
    e.id_activo=1
    and e.id_subserie=53
order by e.id_e_ind_fvt, h.id_hecho;


-- Analisis de responsabilidad
select e.id_e_ind_fvt, e.entrevista_codigo, h.*, vg.*, hv.*, v.descripcion as tipo, v2.descripcion as subtipo
            , aa.descripcion as aa_tipo, aa2.descripcion as aa_subtipo, tc.descripcion as tc_tipo, tc2.descripcion as tc_subtipo
    from esclarecimiento.e_ind_fvt e
        join fichas.hecho h on e.id_e_ind_fvt = h.id_e_ind_fvt
        join catalogos.vista_geo vg on h.id_lugar =vg.id_geo
        join fichas.hecho_violencia hv on h.id_hecho = hv.id_hecho
        join catalogos.violencia v on hv.id_tipo_violencia=v.id_geo
        join catalogos.violencia v2 on hv.id_subtipo_violencia = v2.id_geo
        join fichas.hecho_responsabilidad hr on h.id_hecho = hr.id_hecho
        left join catalogos.aa on hr.aa_id_tipo = aa.id_geo
        left join catalogos.aa aa2 on hr.aa_id_subtipo = aa2.id_geo
        left join catalogos.tc on hr.tc_id_tipo = tc.id_geo
        left join catalogos.tc tc2 on hr.tc_id_subtipo = tc2.id_geo
where
    e.id_activo=1
    and e.id_subserie=53
order by e.id_e_ind_fvt, h.id_hecho;

-- Analisis de victimizaciones
select e.id_e_ind_fvt, e.entrevista_codigo, h.*, vg.*, hv.*, v.descripcion as tipo, v2.descripcion as subtipo
        , hecho_victima.edad, p.id_sexo, p.id_etnia, p.id_identidad, p.id_estado_civil, p.cargo_publico, p.organizacion_colectivo, p.id_fuerza_publica, p.id_actor_armado
        , cs.descripcion as sexo, ce.descripcion as etnia, ci.descripcion as identidad, cc.descripcion as estado_civil, cf.descripcion as fuerza_publica, ca.descripcion as actor_armado
    from esclarecimiento.e_ind_fvt e
        join fichas.hecho h on e.id_e_ind_fvt = h.id_e_ind_fvt
        join catalogos.vista_geo vg on h.id_lugar =vg.id_geo
        join fichas.hecho_violencia hv on h.id_hecho = hv.id_hecho
        join catalogos.violencia v on hv.id_tipo_violencia=v.id_geo
        join catalogos.violencia v2 on hv.id_subtipo_violencia = v2.id_geo
        join fichas.hecho_victima on h.id_hecho = hecho_victima.id_hecho
        join fichas.victima on hecho_victima.id_victima = victima.id_victima
        join fichas.persona p on victima.id_persona = p.id_persona
        left join catalogos.cat_item cs on p.id_sexo=cs.id_item
        left join catalogos.cat_item ce on p.id_etnia=ce.id_item
        left join catalogos.cat_item ci on p.id_identidad = ci.id_item
        left join catalogos.cat_item cc on p.id_estado_civil = cc.id_item
        left join catalogos.cat_item cf on p.id_fuerza_publica = cf.id_item
        left join catalogos.cat_item ca on p.id_actor_armado = ca.id_item
where
    e.id_activo=1
    and e.id_subserie=53
order by e.id_e_ind_fvt, h.id_hecho;


-- Analisis de impactos y afrontamientos
select e.id_e_ind_fvt, e.entrevista_codigo, h.*, vg.*, hv.*, v.descripcion as tipo, v2.descripcion as subtipo
    , ca.nombre as tipo, ci.descripcion as impacto

    from esclarecimiento.e_ind_fvt e
        join fichas.hecho h on e.id_e_ind_fvt = h.id_e_ind_fvt
        join catalogos.vista_geo vg on h.id_lugar =vg.id_geo
        join fichas.hecho_violencia hv on h.id_hecho = hv.id_hecho
        join catalogos.violencia v on hv.id_tipo_violencia=v.id_geo
        join catalogos.violencia v2 on hv.id_subtipo_violencia = v2.id_geo
        join fichas.entrevista_impacto ei on e.id_e_ind_fvt = ei.id_e_ind_fvt
        join catalogos.cat_item ci on ei.id_impacto=ci.id_item
        join catalogos.cat_cat ca on ci.id_cat=ca.id_cat

where
    e.id_activo=1
    and e.id_subserie=53
order by e.id_e_ind_fvt, h.id_hecho, ca.nombre, ci.descripcion;

-- Vista geografica
drop materialized view if exists catalogos.vista_geo;
create   MATERIALIZED view catalogos.vista_geo
AS
select n3.id_geo, n3.codigo, n1.codigo as n1_codigo, n1.descripcion as depto, n2.codigo as n2_codigo, n2.descripcion as municipio, n3.codigo as n3_codigo, n3.descripcion as vereda
    from catalogos.geo as n3
        join catalogos.geo as n2 on n3.id_padre=n2.id_geo and n3.nivel=3
        join catalogos.geo as n1 on n2.id_padre=n1.id_geo and n2.nivel=2
    where n3.nivel=3
union
select n2.id_geo, n2.codigo, n1.codigo as n1_codigo, n1.descripcion as depto, n2.codigo as n2_codigo, n2.descripcion as municipio, null as n3_codigo, null as vereda
    from  catalogos.geo as n2
        join catalogos.geo as n1 on n2.id_padre=n1.id_geo and n2.nivel=2
    where n2.nivel=2
union
select n1.id_geo, n1.codigo,  n1.codigo as n1_codigo, n1.descripcion as depto, null as n2_codigo, null as municipio, null as n3_codigo, null as vereda
    from   catalogos.geo as n1
        where n1.nivel=1
order by  codigo;

create unique index vista_geo_id_geo
    on catalogos.vista_geo (id_geo);

create index vista_geo_codigo
    on catalogos.vista_geo (codigo);

refresh materialized view catalogos.vista_geo;