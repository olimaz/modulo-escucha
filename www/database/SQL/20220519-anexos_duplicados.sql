

select a.md5, e.entrevista_codigo, conteo, cf.descripcion as tipo
from esclarecimiento.adjunto a
         join esclarecimiento.e_ind_fvt_adjunto ea on a.id_adjunto=ea.id_adjunto
         join esclarecimiento.e_ind_fvt e on ea.id_e_ind_fvt=e.id_e_ind_fvt
         join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
         join (

    select a.md5, count(1) as conteo
    from esclarecimiento.adjunto a
             join esclarecimiento.e_ind_fvt_adjunto ea on a.id_adjunto=ea.id_adjunto
             join esclarecimiento.e_ind_fvt e on ea.id_e_ind_fvt=e.id_e_ind_fvt
    where e.id_activo=1
    group by 1
    having count(1) >1) as duplicados
              on a.md5=duplicados.md5

union

select a.md5, e.entrevista_codigo, conteo, cf.descripcion as tipo
from esclarecimiento.adjunto a
         join esclarecimiento.entrevista_colectiva_adjunto ea on a.id_adjunto=ea.id_adjunto
         join esclarecimiento.entrevista_colectiva e on ea.id_entrevista_colectiva=e.id_entrevista_colectiva
         join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
         join (

    select a.md5, count(1) as conteo
    from esclarecimiento.adjunto a
             join esclarecimiento.entrevista_colectiva_adjunto ea on a.id_adjunto=ea.id_adjunto
             join esclarecimiento.entrevista_colectiva e on ea.id_entrevista_colectiva=e.id_entrevista_colectiva
    where e.id_activo=1
    group by 1
    having count(1) >1) as duplicados
              on a.md5=duplicados.md5


union


select a.md5, e.entrevista_codigo, conteo, cf.descripcion as tipo
from esclarecimiento.adjunto a
         join esclarecimiento.entrevista_etnica_adjunto ea on a.id_adjunto=ea.id_adjunto
         join esclarecimiento.entrevista_etnica e on ea.id_entrevista_etnica=e.id_entrevista_etnica
         join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
         join (

    select a.md5, count(1) as conteo
    from esclarecimiento.adjunto a
             join esclarecimiento.entrevista_etnica_adjunto ea on a.id_adjunto=ea.id_adjunto
             join esclarecimiento.entrevista_etnica e on ea.id_entrevista_etnica=e.id_entrevista_etnica
    where e.id_activo=1
    group by 1
    having count(1) >1) as duplicados
              on a.md5=duplicados.md5

union

select a.md5, e.entrevista_codigo, conteo, cf.descripcion as tipo
from esclarecimiento.adjunto a
         join esclarecimiento.entrevista_profundidad_adjunto ea on a.id_adjunto=ea.id_adjunto
         join esclarecimiento.entrevista_profundidad e on ea.id_entrevista_profundidad=e.id_entrevista_profundidad
         join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
         join (

    select a.md5, count(1) as conteo
    from esclarecimiento.adjunto a
             join esclarecimiento.entrevista_profundidad_adjunto ea on a.id_adjunto=ea.id_adjunto
             join esclarecimiento.entrevista_profundidad e on ea.id_entrevista_profundidad=e.id_entrevista_profundidad
    where e.id_activo=1
    group by 1
    having count(1) >1) as duplicados
              on a.md5=duplicados.md5

union

select a.md5, e.entrevista_codigo, conteo, cf.descripcion as tipo
from esclarecimiento.adjunto a
         join esclarecimiento.diagnostico_comunitario_adjunto ea on a.id_adjunto=ea.id_adjunto
         join esclarecimiento.diagnostico_comunitario e on ea.id_diagnostico_comunitario=e.id_diagnostico_comunitario
         join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
         join (

    select a.md5, count(1) as conteo
    from esclarecimiento.adjunto a
             join esclarecimiento.diagnostico_comunitario_adjunto ea on a.id_adjunto=ea.id_adjunto
             join esclarecimiento.diagnostico_comunitario e on ea.id_diagnostico_comunitario=e.id_diagnostico_comunitario
    where e.id_activo=1
    group by 1
    having count(1) >1) as duplicados
              on a.md5=duplicados.md5

union

select a.md5, e.entrevista_codigo, conteo, cf.descripcion as tipo
from esclarecimiento.adjunto a
         join esclarecimiento.historia_vida_adjunto ea on a.id_adjunto=ea.id_adjunto
         join esclarecimiento.historia_vida e on ea.id_historia_vida=e.id_historia_vida
         join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
         join (

    select a.md5, count(1) as conteo
    from esclarecimiento.adjunto a
             join esclarecimiento.historia_vida_adjunto ea on a.id_adjunto=ea.id_adjunto
             join esclarecimiento.historia_vida e on ea.id_historia_vida=e.id_historia_vida
    where e.id_activo=1
    group by 1
    having count(1) >1) as duplicados
              on a.md5=duplicados.md5



order by md5,entrevista_codigo;


-- V2

select * from
    (
        select a.md5, e.entrevista_codigo, cf.descripcion as tipo
        from esclarecimiento.adjunto a
                 join esclarecimiento.e_ind_fvt_adjunto ea on a.id_adjunto=ea.id_adjunto
                 join esclarecimiento.e_ind_fvt e on ea.id_e_ind_fvt=e.id_e_ind_fvt
                 join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
        where e.id_activo=1

        union

        select a.md5, e.entrevista_codigo, cf.descripcion as tipo
        from esclarecimiento.adjunto a
                 join esclarecimiento.entrevista_colectiva_adjunto ea on a.id_adjunto=ea.id_adjunto
                 join esclarecimiento.entrevista_colectiva e on ea.id_entrevista_colectiva=e.id_entrevista_colectiva
                 join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
        where e.id_activo=1

        union



        select a.md5, e.entrevista_codigo, cf.descripcion as tipo
        from esclarecimiento.adjunto a
                 join esclarecimiento.entrevista_etnica_adjunto ea on a.id_adjunto=ea.id_adjunto
                 join esclarecimiento.entrevista_etnica e on ea.id_entrevista_etnica=e.id_entrevista_etnica
                 join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
        where e.id_activo=1

        union


        select a.md5, e.entrevista_codigo, cf.descripcion as tipo
        from esclarecimiento.adjunto a
                 join esclarecimiento.entrevista_profundidad_adjunto ea on a.id_adjunto=ea.id_adjunto
                 join esclarecimiento.entrevista_profundidad e on ea.id_entrevista_profundidad=e.id_entrevista_profundidad
                 join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
        where e.id_activo=1

        union

        select a.md5, e.entrevista_codigo, cf.descripcion as tipo
        from esclarecimiento.adjunto a
                 join esclarecimiento.diagnostico_comunitario_adjunto ea on a.id_adjunto=ea.id_adjunto
                 join esclarecimiento.diagnostico_comunitario e on ea.id_diagnostico_comunitario=e.id_diagnostico_comunitario
                 join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
        where e.id_activo=1

        union

        select a.md5, e.entrevista_codigo, cf.descripcion as tipo
        from esclarecimiento.adjunto a
                 join esclarecimiento.historia_vida_adjunto ea on a.id_adjunto=ea.id_adjunto
                 join esclarecimiento.historia_vida e on ea.id_historia_vida=e.id_historia_vida
                 join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
        where e.id_activo=1

    )      as anexados
where md5 in
      ( select md5 from (
                            select md5, count(1) from
                                (
                                    select a.md5, e.entrevista_codigo, cf.descripcion as tipo
                                    from esclarecimiento.adjunto a
                                             join esclarecimiento.e_ind_fvt_adjunto ea on a.id_adjunto=ea.id_adjunto
                                             join esclarecimiento.e_ind_fvt e on ea.id_e_ind_fvt=e.id_e_ind_fvt
                                             join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
                                    where e.id_activo=1

                                    union

                                    select a.md5, e.entrevista_codigo, cf.descripcion as tipo
                                    from esclarecimiento.adjunto a
                                             join esclarecimiento.entrevista_colectiva_adjunto ea on a.id_adjunto=ea.id_adjunto
                                             join esclarecimiento.entrevista_colectiva e on ea.id_entrevista_colectiva=e.id_entrevista_colectiva
                                             join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
                                    where e.id_activo=1

                                    union



                                    select a.md5, e.entrevista_codigo, cf.descripcion as tipo
                                    from esclarecimiento.adjunto a
                                             join esclarecimiento.entrevista_etnica_adjunto ea on a.id_adjunto=ea.id_adjunto
                                             join esclarecimiento.entrevista_etnica e on ea.id_entrevista_etnica=e.id_entrevista_etnica
                                             join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
                                    where e.id_activo=1

                                    union


                                    select a.md5, e.entrevista_codigo, cf.descripcion as tipo
                                    from esclarecimiento.adjunto a
                                             join esclarecimiento.entrevista_profundidad_adjunto ea on a.id_adjunto=ea.id_adjunto
                                             join esclarecimiento.entrevista_profundidad e on ea.id_entrevista_profundidad=e.id_entrevista_profundidad
                                             join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
                                    where e.id_activo=1

                                    union

                                    select a.md5, e.entrevista_codigo, cf.descripcion as tipo
                                    from esclarecimiento.adjunto a
                                             join esclarecimiento.diagnostico_comunitario_adjunto ea on a.id_adjunto=ea.id_adjunto
                                             join esclarecimiento.diagnostico_comunitario e on ea.id_diagnostico_comunitario=e.id_diagnostico_comunitario
                                             join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
                                    where e.id_activo=1

                                    union

                                    select a.md5, e.entrevista_codigo, cf.descripcion as tipo
                                    from esclarecimiento.adjunto a
                                             join esclarecimiento.historia_vida_adjunto ea on a.id_adjunto=ea.id_adjunto
                                             join esclarecimiento.historia_vida e on ea.id_historia_vida=e.id_historia_vida
                                             join catalogos.criterio_fijo cf on ea.id_tipo=cf.id_opcion and cf.id_grupo=1
                                    where e.id_activo=1

                                ) as todo
                            group by 1
                            having count(1) >1) as duplicados)
order by 1,2,3;

