-- ultimo adjunto que sea consentimiento o audio
select e.entrevista_codigo, max(a.fh_insert) as fh_ultimo_adjunto
    from esclarecimiento.e_ind_fvt e
        join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt = a.id_e_ind_fvt)
    where a.id_tipo in (1,2)
    group by 1
    order by e.entrevista_codigo;

-- ultima transcripcion
select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito
    from esclarecimiento.e_ind_fvt e
        join transcribir_asignacion a on (e.id_e_ind_fvt = a.id_e_ind_fvt)
    where a.id_situacion=2
    group by 1
    order by e.entrevista_codigo;

-- ultima no_transcripcion
select e.entrevista_codigo, max(a.fh_transcrito) as fh_no_transcrito
    from esclarecimiento.e_ind_fvt e
        join transcribir_asignacion a on (e.id_e_ind_fvt = a.id_e_ind_fvt)
    where a.id_situacion=4
    group by 1
    order by e.entrevista_codigo;

--Primer grupo: fecha transcripcion y fecha ultimo adjunto
select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito, fh_ultimo_adjunto
    from esclarecimiento.e_ind_fvt e
        join transcribir_asignacion a on (e.id_e_ind_fvt = a.id_e_ind_fvt)

    join (
        select e.entrevista_codigo, max(a.fh_insert) as fh_ultimo_adjunto
            from esclarecimiento.e_ind_fvt e
                join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt = a.id_e_ind_fvt)
            where a.id_tipo in (1,2)
            group by 1
         ) as adjunto on (e.entrevista_codigo=adjunto.entrevista_codigo)


    group by 1,3
    order by 1;

--TODOS LOS SOSPECHOSOS TRANSCRITOS
--Sospechosos transcritos VI
select * from
    (   --Primer select: fecha transcripcion y fecha ultimo adjunto
        select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito, fh_ultimo_adjunto
            from esclarecimiento.e_ind_fvt e
                join transcribir_asignacion a on (e.id_e_ind_fvt = a.id_e_ind_fvt)

            join (
                select e.entrevista_codigo, max(a.fh_insert) as fh_ultimo_adjunto
                    from esclarecimiento.e_ind_fvt e
                        join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt = a.id_e_ind_fvt)
                    where a.id_tipo in (1,2)
                    group by 1
                 ) as adjunto on (e.entrevista_codigo=adjunto.entrevista_codigo)
            WHERE a.id_situacion=2


            group by 1,3) as transcritos
    where fh_ultimo_adjunto > fh_transcrito
    --order by entrevista_codigo

UNION

--Sospechosos transcritos CO
select * from
    (  --Primer select: fecha transcripcion y fecha ultimo adjunto
        select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito, fh_ultimo_adjunto
            from esclarecimiento.entrevista_colectiva e
                join transcribir_asignacion a on (e.id_entrevista_colectiva = a.id_entrevista_colectiva)

            join (
                select e.entrevista_codigo, max(a.created_at) as fh_ultimo_adjunto
                    from esclarecimiento.entrevista_colectiva e
                        join esclarecimiento.entrevista_colectiva_adjunto a on (e.id_entrevista_colectiva = a.id_entrevista_colectiva)
                    where a.id_tipo in (1,2)
                    group by 1
                 ) as adjunto on (e.entrevista_codigo=adjunto.entrevista_codigo)
                WHERE a.id_situacion=2

            group by 1,3) as transcritos
    where fh_ultimo_adjunto > fh_transcrito

UNION
--Sospechosos transcritos EE
select * from
    (  --Primer select: fecha transcripcion y fecha ultimo adjunto
        select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito, fh_ultimo_adjunto
            from esclarecimiento.entrevista_etnica e
                join transcribir_asignacion a on (e.id_entrevista_etnica = a.id_entrevista_etnica)

            join (
                select e.entrevista_codigo, max(a.created_at) as fh_ultimo_adjunto
                    from esclarecimiento.entrevista_etnica e
                        join esclarecimiento.entrevista_etnica_adjunto a on (e.id_entrevista_etnica = a.id_entrevista_etnica)
                    where a.id_tipo in (1,2)
                    group by 1
                 ) as adjunto on (e.entrevista_codigo=adjunto.entrevista_codigo)
                WHERE a.id_situacion=2
            group by 1,3) as transcritos
    where fh_ultimo_adjunto > fh_transcrito

UNION
--Sospechosos transcritos PR
select * from
    (  --Primer select: fecha transcripcion y fecha ultimo adjunto
        select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito, fh_ultimo_adjunto
            from esclarecimiento.entrevista_profundidad e
                join transcribir_asignacion a on (e.id_entrevista_profundidad = a.id_entrevista_profundidad)

            join (
                select e.entrevista_codigo, max(a.created_at) as fh_ultimo_adjunto
                    from esclarecimiento.entrevista_profundidad e
                        join esclarecimiento.entrevista_profundidad_adjunto a on (e.id_entrevista_profundidad = a.id_entrevista_profundidad)
                    where a.id_tipo in (1,2)
                    group by 1
                 ) as adjunto on (e.entrevista_codigo=adjunto.entrevista_codigo)


            group by 1,3) as transcritos
    where fh_ultimo_adjunto > fh_transcrito
UNION
--Sospechosos transcritos DC
select * from
    (  --Primer select: fecha transcripcion y fecha ultimo adjunto
        select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito, fh_ultimo_adjunto
            from esclarecimiento.diagnostico_comunitario e
                join transcribir_asignacion a on (e.id_diagnostico_comunitario = a.id_diagnostico_comunitario)

            join (
                select e.entrevista_codigo, max(a.created_at) as fh_ultimo_adjunto
                    from esclarecimiento.diagnostico_comunitario e
                        join esclarecimiento.diagnostico_comunitario_adjunto a on (e.id_diagnostico_comunitario = a.id_diagnostico_comunitario)
                    where a.id_tipo in (1,2)
                    group by 1
                 ) as adjunto on (e.entrevista_codigo=adjunto.entrevista_codigo)
            WHERE a.id_situacion=2

            group by 1,3) as transcritos
    where fh_ultimo_adjunto > fh_transcrito
UNION
--Sospechosos transcritos HV
select * from
    (  --Primer select: fecha transcripcion y fecha ultimo adjunto
        select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito, fh_ultimo_adjunto
            from esclarecimiento.historia_vida e
                join transcribir_asignacion a on (e.id_historia_vida = a.id_historia_vida)

            join (
                select e.entrevista_codigo, max(a.created_at) as fh_ultimo_adjunto
                    from esclarecimiento.historia_vida e
                        join esclarecimiento.historia_vida_adjunto a on (e.id_historia_vida = a.id_historia_vida)
                    where a.id_tipo in (1,2)
                    group by 1
                 ) as adjunto on (e.entrevista_codigo=adjunto.entrevista_codigo)
            WHERE a.id_situacion=2
            group by 1,3) as transcritos
    where fh_ultimo_adjunto > fh_transcrito

order by entrevista_codigo;



----------------------

--TODOS LOS SOSPECHOSOS NO TRANSCRITOS
--Sospechosos no transcritos VI
select entrevista_codigo, fh_transcrito as fh_no_transcrito, fh_ultimo_adjunto from
    (   --Primer select: fecha transcripcion y fecha ultimo adjunto
        select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito, fh_ultimo_adjunto
            from esclarecimiento.e_ind_fvt e
                join transcribir_asignacion a on (e.id_e_ind_fvt = a.id_e_ind_fvt)

            join (
                select e.entrevista_codigo, max(a.fh_insert) as fh_ultimo_adjunto
                    from esclarecimiento.e_ind_fvt e
                        join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt = a.id_e_ind_fvt)
                    where a.id_tipo in (1,2)
                    group by 1
                 ) as adjunto on (e.entrevista_codigo=adjunto.entrevista_codigo)
            WHERE a.id_situacion=4
            group by 1,3) as transcritos
    where fh_ultimo_adjunto > fh_transcrito
    --order by entrevista_codigo

UNION

--Sospechosos no transcritos CO
select * from
    (  --Primer select: fecha transcripcion y fecha ultimo adjunto
        select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito, fh_ultimo_adjunto
            from esclarecimiento.entrevista_colectiva e
                join transcribir_asignacion a on (e.id_entrevista_colectiva = a.id_entrevista_colectiva)

            join (
                select e.entrevista_codigo, max(a.created_at) as fh_ultimo_adjunto
                    from esclarecimiento.entrevista_colectiva e
                        join esclarecimiento.entrevista_colectiva_adjunto a on (e.id_entrevista_colectiva = a.id_entrevista_colectiva)
                    where a.id_tipo in (1,2)
                    group by 1
                 ) as adjunto on (e.entrevista_codigo=adjunto.entrevista_codigo)
            WHERE a.id_situacion=4
            group by 1,3) as transcritos
    where fh_ultimo_adjunto > fh_transcrito

UNION
--Sospechosos no transcritos EE
select * from
    (  --Primer select: fecha transcripcion y fecha ultimo adjunto
        select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito, fh_ultimo_adjunto
            from esclarecimiento.entrevista_etnica e
                join transcribir_asignacion a on (e.id_entrevista_etnica = a.id_entrevista_etnica)

            join (
                select e.entrevista_codigo, max(a.created_at) as fh_ultimo_adjunto
                    from esclarecimiento.entrevista_etnica e
                        join esclarecimiento.entrevista_etnica_adjunto a on (e.id_entrevista_etnica = a.id_entrevista_etnica)
                    where a.id_tipo in (1,2)
                    group by 1
                 ) as adjunto on (e.entrevista_codigo=adjunto.entrevista_codigo)
            WHERE a.id_situacion=4
            group by 1,3) as transcritos
    where fh_ultimo_adjunto > fh_transcrito

UNION
--Sospechosos no transcritos PR
select * from
    (  --Primer select: fecha transcripcion y fecha ultimo adjunto
        select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito, fh_ultimo_adjunto
            from esclarecimiento.entrevista_profundidad e
                join transcribir_asignacion a on (e.id_entrevista_profundidad = a.id_entrevista_profundidad)

            join (
                select e.entrevista_codigo, max(a.created_at) as fh_ultimo_adjunto
                    from esclarecimiento.entrevista_profundidad e
                        join esclarecimiento.entrevista_profundidad_adjunto a on (e.id_entrevista_profundidad = a.id_entrevista_profundidad)
                    where a.id_tipo in (1,2)
                    group by 1
                 ) as adjunto on (e.entrevista_codigo=adjunto.entrevista_codigo)
            WHERE a.id_situacion=4
            group by 1,3) as transcritos
    where fh_ultimo_adjunto > fh_transcrito
UNION
--Sospechosos no transcritos DC
select * from
    (  --Primer select: fecha transcripcion y fecha ultimo adjunto
        select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito, fh_ultimo_adjunto
            from esclarecimiento.diagnostico_comunitario e
                join transcribir_asignacion a on (e.id_diagnostico_comunitario = a.id_diagnostico_comunitario)

            join (
                select e.entrevista_codigo, max(a.created_at) as fh_ultimo_adjunto
                    from esclarecimiento.diagnostico_comunitario e
                        join esclarecimiento.diagnostico_comunitario_adjunto a on (e.id_diagnostico_comunitario = a.id_diagnostico_comunitario)
                    where a.id_tipo in (1,2)
                    group by 1
                 ) as adjunto on (e.entrevista_codigo=adjunto.entrevista_codigo)
            WHERE a.id_situacion=4
            group by 1,3) as transcritos
    where fh_ultimo_adjunto > fh_transcrito
UNION
--Sospechosos no transcritos HV
select * from
    (  --Primer select: fecha transcripcion y fecha ultimo adjunto
        select e.entrevista_codigo, max(a.fh_transcrito) as fh_transcrito, fh_ultimo_adjunto
            from esclarecimiento.historia_vida e
                join transcribir_asignacion a on (e.id_historia_vida = a.id_historia_vida)

            join (
                select e.entrevista_codigo, max(a.created_at) as fh_ultimo_adjunto
                    from esclarecimiento.historia_vida e
                        join esclarecimiento.historia_vida_adjunto a on (e.id_historia_vida = a.id_historia_vida)
                    where a.id_tipo in (1,2)
                    group by 1
                 ) as adjunto on (e.entrevista_codigo=adjunto.entrevista_codigo)
            WHERE a.id_situacion=4
            group by 1,3) as transcritos
    where fh_ultimo_adjunto > fh_transcrito




order by entrevista_codigo

