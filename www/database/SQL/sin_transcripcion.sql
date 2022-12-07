-- pendientes de transcribir
select distinct a.id_e_ind_fvt_adjunto
from esclarecimiento.e_ind_fvt e join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt=a.id_e_ind_fvt)
where a.id_tipo=2 and a.id_transcripcion is null
    -- Transcritos a mano
  and a.id_e_ind_fvt not in (
      select e.id_e_ind_fvt
            from esclarecimiento.e_ind_fvt e join public.transcribir_asignacion a on (e.id_e_ind_fvt=a.id_e_ind_fvt)
            where a.id_situacion=2

    )
order by 1


-- pendientes de revisar

select distinct a.id_e_ind_fvt_adjunto
from esclarecimiento.e_ind_fvt e join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt=a.id_e_ind_fvt)
where a.id_tipo=2 and a.id_transcripcion =0
    -- Transcritos a mano
  and a.id_e_ind_fvt not in (
      select e.id_e_ind_fvt
            from esclarecimiento.e_ind_fvt e join public.transcribir_asignacion a on (e.id_e_ind_fvt=a.id_e_ind_fvt)
            where a.id_situacion=2

    )
order by 1




