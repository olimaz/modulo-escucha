
-- Primera parte: crear campos y trigger para actualizarlos
alter table fichas.persona_organizacion
    add nombre_buscable text;

drop function if exists persona_organizacion_buscables() cascade ;
CREATE OR REPLACE FUNCTION persona_organizacion_buscables() RETURNS trigger
              LANGUAGE 'plpgsql' VOLATILE NOT LEAKPROOF
              AS $BODY$
begin

    NEW.nombre_buscable = lower(unaccent(NEW.nombre));
    return new;
end
$BODY$;

CREATE TRIGGER actualizar_persona_organizacion_buscables
    BEFORE INSERT OR UPDATE ON fichas.persona_organizacion
    FOR EACH ROW EXECUTE PROCEDURE persona_organizacion_buscables();


-- Actualizar las nuevas columnas
update fichas.persona_organizacion set nombre=nombre;


-- Query de prueba: (antes y despues del indice)
explain
select count(1)
from fichas.persona_organizacion
where nombre_buscable ilike '%orga%';





-- Segunda parte: crear indice GIN con trigramas



-- Crear indice con apellidos

CREATE INDEX nombre_buscable_po_trigram_index
    on fichas.persona_organizacion
    USING gin(nombre_buscable gin_trgm_ops);
