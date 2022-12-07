-- Asignacion, transcrito=si
select count(1) from (

select distinct e.entrevista_codigo, 1 as asignacion_transcrita
    from esclarecimiento.e_ind_fvt e join transcribir_asignacion ta on e.id_e_ind_fvt = ta.id_e_ind_fvt
    where ta.id_situacion=2      and id_activo=1                   ) as asignadas;



select distinct e.entrevista_codigo, 1 as asignacion_transcrita
    from esclarecimiento.e_ind_fvt e join transcribir_asignacion ta on e.id_e_ind_fvt = ta.id_e_ind_fvt
    where ta.id_situacion=2 and id_activo=1;

--- adjunto de transcripcion

select count(1) from (
                     select distinct e.entrevista_codigo, 1 as adjunto_transcrito
    from esclarecimiento.e_ind_fvt e join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt=a.id_e_ind_fvt)
        where a.id_tipo=6 and id_activo=1
                         ) as adjuntados;

select distinct e.entrevista_codigo, 1 as adjunto_transcrito
    from esclarecimiento.e_ind_fvt e join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt=a.id_e_ind_fvt)
        where a.id_tipo=6 and id_activo=1;

-- campo html_transcripcion

select count(1) from (
                     select distinct e.entrevista_codigo, 1 as transcripcion_transcrito
    from esclarecimiento.e_ind_fvt e
        where html_transcripcion is not null and id_activo=1
                         ) as transcripcion;




select distinct e.entrevista_codigo, 1 as transcripcion_transcrito
    from esclarecimiento.e_ind_fvt e
        where html_transcripcion is not null;


-- Asignadas transcritas, sin transcripcion
select distinct e.entrevista_codigo, 1 as transcripcion_transcrito
    from esclarecimiento.e_ind_fvt e
        where html_transcripcion is  null and id_activo=1 and id_e_ind_fvt  in
                 (
                select e.id_e_ind_fvt
                        from esclarecimiento.e_ind_fvt e join transcribir_asignacion ta on e.id_e_ind_fvt = ta.id_e_ind_fvt
                        where ta.id_situacion=2
                                                 );


select count(1)
    from esclarecimiento.e_ind_fvt e
    where id_activo=1


select codigo_entrevista, id_e_ind_fvt
    where transcrita='Transcrita' and transcripcion_html is null;

-- Caso 1: en asignacion aparecen transcritas, pero no tienen campo con transcripcion
select codigo_entrevista, id_e_ind_fvt
    from esclarecimiento.excel_entrevista_fvt
    where transcrita='Transcrita' and transcripcion_html is null
    order by codigo_entrevista;

-- Caso 2: Tienen campo de transcripcion, no se muestran como transcritas
select codigo_entrevista, transcrita, id_e_ind_fvt
    from esclarecimiento.excel_entrevista_fvt
    where transcrita<>'Transcrita' and transcrita <> 'Asignada' and transcripcion_html is not null
    order by codigo_entrevista;

--Caso 3: Tienen adjunto de transcripcion, pero no se muestran como transcritas
select distinct e.entrevista_codigo, 1 as adjunto_transcrito
    from esclarecimiento.e_ind_fvt e join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt=a.id_e_ind_fvt)
        where a.id_tipo=6 and id_activo=1 and e.html_transcripcion is null
        and a.id_e_ind_fvt not in
            (
                select distinct e.id_e_ind_fvt
                    from esclarecimiento.e_ind_fvt e
                        join transcribir_asignacion ta on e.id_e_ind_fvt = ta.id_e_ind_fvt
                            where ta.id_situacion=2
                              and id_activo=1
                )
    order by entrevista_codigo