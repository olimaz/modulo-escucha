select distinct ee.id_etiqueta, e.id_etiqueta, e.etiqueta
    from sim.etiqueta_entrevista ee join sim.etiqueta e on (ee.id_etiqueta = e.id_etiqueta)
        left join catalogos.tesauro t on (e.id_etiqueta=t.id_etiqueta and t.id_activo=1)
    where t.id_etiqueta is null
    order by etiqueta;


insert into sim.etiqueta (etiqueta)
    (
    select etiqueta_completa from catalogos.tesauro where id_etiqueta is null order by codigo
    );



select t.id_geo, t.id_etiqueta, e.id_etiqueta, t.etiqueta_completa
    from catalogos.tesauro t
        join sim.etiqueta e on (t.etiqueta_completa=e.etiqueta)
            where t.id_etiqueta is null
    order by codigo;

update catalogos.tesauro t
    set id_etiqueta = e.id_etiqueta
    from sim.etiqueta e
        where e.etiqueta=t.etiqueta_completa
            and t.id_etiqueta is null;