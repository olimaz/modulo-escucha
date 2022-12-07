-- Tomado de: https://about.gitlab.com/blog/2016/03/18/fast-search-using-postgresql-trigram-indexes/
-- Otras soluciones no tan buenas:https://gist.github.com/mabrizio/7044220
-- Basado en: https://stackoverflow.com/questions/11005036/does-postgresql-support-accent-insensitive-collations/11007216
-- Teoría de los trigramas:https://scoutapm.com/blog/how-to-make-text-searches-in-postgresql-faster-with-trigram-similarity
-- Adaptado de: https://dba.stackexchange.com/questions/177020/creating-a-case-insensitive-and-accent-diacritics-insensitive-search-on-a-field
-- otras soluciones: a)Crear campo tipo nombres_unaccent, apellidos_unaccent con trigger. b) usar full text search.
-- Preferí esta por las consideraciones de gitLab

/*
 ¿Cual es la mejor solución?
 1. De acuerdo al post de gitlab trigram es mejor que full text search, pero tenemos el problema que ilike no usa indices y es sensible a tildes, así que todos los queries deben ser tipo:  (ver en adaptado de)
    select * from tabla where lower(f_unaccent(apellido)) LIKE '%whatever%';
 2. PAra evitar esto, voy a crear campos en minusculas y sin acentos para correr los queries allí
    Esta solución tiene un mayor overhead en los insert, pero aprovecha los indices en los select like; Además es más transparente para un dba, ya que con saber del campo, cualquier query funciona sin tener que usar lower(f_unaccent())

 */




-- Primera parte: crear campos y trigger para actualizarlos
alter table fichas.persona
    add apellido_buscable varchar(200);
alter table fichas.persona
    add nombre_buscable varchar(200);
alter table fichas.persona
    add alias_buscable varchar(200);
alter table fichas.persona
    add nombre_completo_buscable text;

drop function if exists persona_buscables() cascade ;
CREATE OR REPLACE FUNCTION persona_buscables() RETURNS trigger
              LANGUAGE 'plpgsql' VOLATILE NOT LEAKPROOF
              AS $BODY$
begin
    NEW.apellido_buscable = lower(unaccent(NEW.apellido));
NEW.nombre_buscable = lower(unaccent(NEW.nombre));
NEW.alias_buscable = lower(unaccent(NEW.alias));
NEW.nombre_completo_buscable = concat_ws(' ',lower(unaccent(NEW.nombre)),lower(unaccent(NEW.apellido)),lower(unaccent(NEW.alias)));
return new;
end
$BODY$;

CREATE TRIGGER actualizar_persona_buscables
    BEFORE INSERT OR UPDATE ON fichas.persona
    FOR EACH ROW EXECUTE PROCEDURE persona_buscables();


-- Actualizar las nuevas columnas
update fichas.persona set nombre=nombre;


-- Query de prueba: (antes y despues del indice)
explain
select count(1)
from fichas.persona
where apellido_buscable ilike '%erez%';



-- Segunda parte: crear indice GIN con trigramas

-- Extensión para indices gin con trigramas
CREATE EXTENSION pg_trgm;
-- Prueba
select show_trgm('alice');


-- Crear indice con apellidos
CREATE INDEX apellido_buscable_trigram_index
    on fichas.persona
    USING gin(apellido_buscable gin_trgm_ops);

CREATE INDEX nombre_buscable_trigram_index
    on fichas.persona
    USING gin(nombre_buscable gin_trgm_ops);

CREATE INDEX alias_buscable_trigram_index
    on fichas.persona
    USING gin(alias_buscable gin_trgm_ops);

CREATE INDEX nombre_completo_buscable_trigram_index
    on fichas.persona
    USING gin(nombre_completo_buscable gin_trgm_ops);

