-- CODIGO PAIS --------------------

-- codigo 'XX' por defecto para paises extranjeros
update catalogos.geo set codigo_2='XX' where geo.codigo ilike 'ii%' and geo.nivel=2;
-- codigos de pais encontrados
update catalogos.geo
set codigo_2=maiz.iso2
from (
         select geo.id_geo, geo.nivel, geo.descripcion,iso_pais.descripcion as iso, iso_pais.iso2
         from catalogos.geo
                  join catalogos.iso_pais on (upper(trim(unaccent(geo.descripcion)))=upper(trim(unaccent(iso_pais.descripcion))))
         where geo.codigo ilike 'ii%' and geo.nivel=2
         order by geo.descripcion,iso_pais.descripcion
     ) as maiz
where geo.id_geo = maiz.id_geo;


-- CIUDAD ----------------------------------

-- Por defecto '??-???' en codigo de ciudad
update catalogos.geo set codigo_2='??-???' where geo.codigo ilike 'ii%' and geo.nivel=3;


-- Codigo de pais para ciudades que se conoce el codigo de pais
update catalogos.geo
set codigo_2 = codigo_ciudad
from (
         select geo.id_geo, geo.descripcion, concat(padre.codigo_2 , '-???') as codigo_ciudad
         from catalogos.geo join catalogos.geo as padre on (geo.id_padre=padre.id_geo)
         where geo.codigo ilike 'ii%' and geo.nivel=3
         order by geo.codigo
     ) as maiz
where geo.id_geo=maiz.id_geo;



--codigo de ciudad encontrado
update catalogos.geo
set codigo_2 = codigo_ciudad
from (
         select geo.id_geo, geo.nivel, geo.descripcion,iso_ciudad.descripcion as iso, iso_ciudad.codigo_ciudad
         from catalogos.geo
                  join catalogos.iso_ciudad on (upper(trim(unaccent(geo.descripcion)))=upper(trim(unaccent(iso_ciudad.descripcion))))
         where geo.codigo ilike 'ii%' and geo.nivel=3
         order by geo.descripcion,iso_ciudad.descripcion ) as maiz

where geo.id_geo=maiz.id_geo;




