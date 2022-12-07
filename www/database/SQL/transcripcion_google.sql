
select to_char(fh_recibido,'YY-mm-dd') as fecha, count(1) as conteo, sum(duracion) as duracion
from tiempo_transcripcion
group by 1
order by 1 desc;




select count(1) as cantidad, avg(duracion) as duracion, sum(duracion) as total
from tiempo_transcripcion;


select avg(conteo)
from (
         select to_char(fh_recibido,'YY-mm-dd') as fecha, count(1) as conteo, sum(duracion) as duracion
         from tiempo_transcripcion
         group by 1) as semanal

;
select count(1) from (
                         select distinct a.id_e_ind_fvt_adjunto
                         from esclarecimiento.e_ind_fvt e
                                  join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt = a.id_e_ind_fvt)
                         where a.id_tipo = 2
                           and a.id_transcripcion is null
                           -- Transcritos a mano
                           and a.id_e_ind_fvt not in (
                             select e.id_e_ind_fvt
                             from esclarecimiento.e_ind_fvt e
                                      join public.transcribir_asignacion a on (e.id_e_ind_fvt = a.id_e_ind_fvt)
                             where a.id_situacion = 2
                         )
                     ) as pendientes;

select count(1) from (
                         select distinct a.id_e_ind_fvt_adjunto
                         from esclarecimiento.e_ind_fvt e
                                  join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt = a.id_e_ind_fvt)
                         where a.id_tipo = 2
                           and a.id_transcripcion is not null


                     ) as transcritos;


select count(1)

FROM esclarecimiento.e_ind_fvt_adjunto t
WHERE id_transcripcion = -1;


select id_estado,count(1)
from control_transcripcion
group by 1


