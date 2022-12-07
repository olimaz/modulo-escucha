
create materialized view analitica.concurrencia_victima as
select
    victima.id_victima
     ,case when sum(v_muerte_homicidio) =0 then 0 else 1 end as v_muerte_homicidio
     ,case when sum(v_atentado) = 0 then 0 else 1 end as v_atentado
     ,case when sum(v_amenaza) =0 then 0 else 1 end  as v_amenaza
     ,case when  sum(v_desaparicion_forzada) =0 then 0 else 1 end  as v_desaparicion_forzada
     ,case when  sum(v_tortura) =0 then 0 else 1 end  as v_tortura
     ,case when sum(v_violencia_sexual) =0 then 0 else 1 end  as v_violencia_sexual
     ,case when  sum(v_esclavitud_no_sexual) =0 then 0 else 1 end  as v_esclavitud_no_sexual
     ,case when sum(v_reclutamiento) =0 then 0 else 1 end  as v_reclutamiento
     ,case when  sum(v_detencion) =0 then 0 else 1 end  as v_detencion
     ,case when  sum(v_secuestro) =0 then 0 else 1 end  as v_secuestro
     ,case when sum(v_confinamiento) =0 then 0 else 1 end  as v_confinamiento
     ,case when  sum(v_pillaje) =0 then 0 else 1 end  as v_pillaje
     ,case when  sum(v_extorsion) =0 then 0 else 1 end  as v_extorsion
     ,case when  sum(v_ataque_bien_protegido) =0 then 0 else 1 end  as v_ataque_bien_protegido
     ,case when  sum(v_ataque_indiscriminado) =0 then 0 else 1 end  as v_ataque_indiscriminado
     ,case when  sum(v_despojo) =0 then 0 else 1 end  as v_despojo
     ,case when sum(v_desplazamiento) =0 then 0 else 1 end  as v_desplazamiento
     ,case when sum( v_exilio) =0 then 0 else 1 end  as v_exilio
from
    analitica.violencia
        join analitica.victima_violencia on violencia.id_hecho=victima_violencia.id_hecho
        join analitica.victima on victima_violencia.id_victima=victima.id_victima


group by
    victima.id_victima;


alter  materialized view analitica.concurrencia_victima owner to  dba;




-- Concurrencia a nivel de entrevista

create materialized view analitica.concurrencia_entrevista as
select
    victima.codigo_entrevista
     ,case when sum(v_muerte_homicidio) =0 then 0 else 1 end as v_muerte_homicidio
     ,case when sum(v_atentado) = 0 then 0 else 1 end as v_atentado
     ,case when sum(v_amenaza) =0 then 0 else 1 end  as v_amenaza
     ,case when  sum(v_desaparicion_forzada) =0 then 0 else 1 end  as v_desaparicion_forzada
     ,case when  sum(v_tortura) =0 then 0 else 1 end  as v_tortura
     ,case when sum(v_violencia_sexual) =0 then 0 else 1 end  as v_violencia_sexual
     ,case when  sum(v_esclavitud_no_sexual) =0 then 0 else 1 end  as v_esclavitud_no_sexual
     ,case when sum(v_reclutamiento) =0 then 0 else 1 end  as v_reclutamiento
     ,case when  sum(v_detencion) =0 then 0 else 1 end  as v_detencion
     ,case when  sum(v_secuestro) =0 then 0 else 1 end  as v_secuestro
     ,case when sum(v_confinamiento) =0 then 0 else 1 end  as v_confinamiento
     ,case when  sum(v_pillaje) =0 then 0 else 1 end  as v_pillaje
     ,case when  sum(v_extorsion) =0 then 0 else 1 end  as v_extorsion
     ,case when  sum(v_ataque_bien_protegido) =0 then 0 else 1 end  as v_ataque_bien_protegido
     ,case when  sum(v_ataque_indiscriminado) =0 then 0 else 1 end  as v_ataque_indiscriminado
     ,case when  sum(v_despojo) =0 then 0 else 1 end  as v_despojo
     ,case when sum(v_desplazamiento) =0 then 0 else 1 end  as v_desplazamiento
     ,case when sum( v_exilio) =0 then 0 else 1 end  as v_exilio
from
    analitica.violencia
        join analitica.victima_violencia on violencia.id_hecho=victima_violencia.id_hecho
        join analitica.victima on victima_violencia.id_victima=victima.id_victima


group by
    victima.codigo_entrevista;


alter  materialized view analitica.concurrencia_entrevista owner to  dba;