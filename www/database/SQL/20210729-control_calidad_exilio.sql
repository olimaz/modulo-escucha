-- 1 macro internacional: conteo de fichas de exilio
select en.entrevista_codigo, count(id_exilio) as fichas_exilio
    from esclarecimiento.e_ind_fvt en
        left join fichas.exilio ex on en.id_e_ind_fvt = ex.id_e_ind_fvt
    where en.id_activo=1 and en.id_macroterritorio=110
        and en.id_subserie=53

group by 1
order by 2,1;

-- 2 entrevistas con exilio como violencia en metadatos: fichas de exilio
select en.entrevista_codigo, count(id_exilio) as fichas_exilio
    from esclarecimiento.e_ind_fvt en
        join esclarecimiento.e_ind_fvt_tv tv on en.id_e_ind_fvt = tv.id_e_ind_fvt
        left join fichas.exilio ex on en.id_e_ind_fvt = ex.id_e_ind_fvt
    where en.id_activo=1
        and en.id_subserie=53
        and tv.id_tv=47
group by 1
order by 2,1;

-- entrevistas con ficha de exilio, revisar que tengan exilio como violencia en metadatos
select en.entrevista_codigo, count(id_tv) as violencia_exilio
    from esclarecimiento.e_ind_fvt en
        join fichas.exilio ex on en.id_e_ind_fvt = ex.id_e_ind_fvt
        left join esclarecimiento.e_ind_fvt_tv tv on en.id_e_ind_fvt = tv.id_e_ind_fvt
    where en.id_activo=1
        and en.id_subserie=53
        and tv.id_tv=47
group by 1
order by 2,1;



-- 4 entrevistas con exilio en ficha larga, conteo de fichas de exilio
select en.entrevista_codigo, count(id_exilio) as fichas_exilio
    from esclarecimiento.e_ind_fvt en
        join fichas.hecho on en.id_e_ind_fvt = hecho.id_e_ind_fvt
        join fichas.hecho_violencia on hecho.id_hecho = hecho_violencia.id_hecho
        left join fichas.exilio ex on en.id_e_ind_fvt = ex.id_e_ind_fvt
    where en.id_activo=1
        and en.id_subserie=53
        and hecho_violencia.id_tipo_violencia=71
group by 1
order by 2,1;


-- 5 entrevistas con ficha de exilio, conteo de violencias con exilio
select en.entrevista_codigo, count(hecho.id_hecho) as hechos_exilio
    from esclarecimiento.e_ind_fvt en
        join fichas.exilio ex on en.id_e_ind_fvt = ex.id_e_ind_fvt
        left join fichas.hecho on en.id_e_ind_fvt = hecho.id_e_ind_fvt
        left join fichas.hecho_violencia on hecho.id_hecho = hecho_violencia.id_hecho
    where en.id_activo=1
        and en.id_subserie=53
        and hecho_violencia.id_tipo_violencia=71
group by 1
order by 2,1;

-- 6. Que las entrevistas de macro internacional tengan exilio como violencia en metadatos
select en.entrevista_codigo, count(id_tv) as violencia_exilio
    from esclarecimiento.e_ind_fvt en
        left join esclarecimiento.e_ind_fvt_tv tv on en.id_e_ind_fvt = tv.id_e_ind_fvt
    where en.id_activo=1
        and en.id_subserie=53
        and en.id_activo=1 and en.id_macroterritorio=110
group by 1
order by 2,1;