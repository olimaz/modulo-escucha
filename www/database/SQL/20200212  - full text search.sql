-- Para las tildes: esto se crea en la linea de comandos
CREATE EXTENSION unaccent;

-- probar la extension
select unaccent('Hélène');



select to_tsvector('pg_catalog.spanish','Líder social');
select to_tsvector('pg_catalog.spanish','Lider social');


-- ENTREVISTAS INDIVIDUALES
-- Campo para calculos
ALTER TABLE esclarecimiento.e_ind_fvt ADD "fts" tsvector;
--Indice respectivo
CREATE INDEX fts_gin_index ON esclarecimiento.e_ind_fvt USING gin(fts);

-- Primera actualización
UPDATE esclarecimiento.e_ind_fvt
SET fts =   setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(titulo),'')), 'A') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(html_transcripcion),'')), 'B') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(anotaciones),'')), 'C') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(observaciones_diligenciada),'')), 'D')
where true;

-- Trigger
drop function indexar_entrevista_individual() cascade ;
CREATE FUNCTION indexar_entrevista_individual() RETURNS trigger
    LANGUAGE 'plpgsql' VOLATILE NOT LEAKPROOF
AS $BODY$
begin
    new.fts :=
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.titulo,'')), 'A') ||
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.html_transcripcion,'')), 'B') ||
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.anotaciones,'')), 'C') ||
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.observaciones_diligenciada,'')), 'D');
    return new;
end
$BODY$;


CREATE TRIGGER fts_actualizar_vi
    BEFORE INSERT OR UPDATE ON esclarecimiento.e_ind_fvt
    FOR EACH ROW EXECUTE PROCEDURE indexar_entrevista_individual();



-- ENTREVISTAS PROFUNDIDAD


--  Campos para grabar transcripción y etiquetado
alter table esclarecimiento.entrevista_profundidad
    add html_transcripcion text;

alter table esclarecimiento.entrevista_profundidad
    add json_etiquetado text;


-- Campo para calculos
ALTER TABLE esclarecimiento.entrevista_profundidad ADD "fts" tsvector;
--Indice respectivo
CREATE INDEX fts_gin_pr_index ON esclarecimiento.entrevista_profundidad USING gin(fts);

-- Primera actualización
UPDATE esclarecimiento.entrevista_profundidad
SET fts =   setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(titulo),'')), 'A') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(entrevista_objetivo),'')), 'A') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(entrevistado_apellidos),'')), 'A') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(entrevistado_nombres),'')), 'A') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(html_transcripcion),'')), 'B') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(observaciones),'')), 'C')
where true;

-- Trigger
drop function indexar_entrevista_profundidad() cascade ;
CREATE FUNCTION indexar_entrevista_profundidad() RETURNS trigger
    LANGUAGE 'plpgsql' VOLATILE NOT LEAKPROOF
AS $BODY$
begin
    new.fts :=
                    setweight(to_tsvector('pg_catalog.spanish',coalesce(new.titulo,'')), 'A') ||
                    setweight(to_tsvector('pg_catalog.spanish',coalesce(new.entrevista_objetivo,'')), 'A') ||
                    setweight(to_tsvector('pg_catalog.spanish',coalesce(new.entrevistado_apellidos,'')), 'A') ||
                    setweight(to_tsvector('pg_catalog.spanish',coalesce(new.entrevistado_nombres,'')), 'A') ||
                    setweight(to_tsvector('pg_catalog.spanish',coalesce(new.html_transcripcion,'')), 'B') ||
                    setweight(to_tsvector('pg_catalog.spanish',coalesce(new.observaciones,'')), 'C') ;
    return new;
end
$BODY$;


CREATE TRIGGER fts_actualizar_pr
    BEFORE INSERT OR UPDATE ON esclarecimiento.entrevista_profundidad
    FOR EACH ROW EXECUTE PROCEDURE indexar_entrevista_profundidad();



-- ------------------------------------------



sELECT titulo, anotaciones, html_transcripcion
from esclarecimiento.e_ind_fvt
WHERE fts @@ to_tsquery('líder');

sELECT titulo, anotaciones, html_transcripcion
from esclarecimiento.e_ind_fvt
WHERE fts @@ to_tsquery('lider');

sELECT titulo, anotaciones, html_transcripcion
from esclarecimiento.e_ind_fvt
WHERE fts @@ to_tsquery(unaccent('líder'));

sELECT titulo, anotaciones, html_transcripcion
from esclarecimiento.e_ind_fvt
WHERE fts @@ to_tsquery(unaccent('líder'));



-- to_tsquery utiliza conectores logicos


sELECT titulo, anotaciones, html_transcripcion,
       ts_rank("fts",to_tsquery('pg_catalog.spanish',unaccent('líder & social'))) AS rank
from esclarecimiento.e_ind_fvt
WHERE fts @@ to_tsquery('pg_catalog.spanish', unaccent('el & líder & social'))
order by rank desc


-- plainto_tsquery es mas simple pero menos poderoso
sELECT titulo, anotaciones, html_transcripcion,
       ts_rank("fts",plainto_tsquery('pg_catalog.spanish',unaccent('líder & social'))) AS rank
from esclarecimiento.e_ind_fvt
WHERE fts @@ plainto_tsquery('pg_catalog.spanish',unaccent('el líder social'))
order by rank desc






