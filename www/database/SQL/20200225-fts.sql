-- ENTREVISTAS COLECTIVAS
-- Campo para calculos
ALTER TABLE esclarecimiento.entrevista_colectiva ADD "fts" tsvector;
--Indice respectivo
CREATE INDEX fts_gin_co_index ON esclarecimiento.entrevista_colectiva USING gin(fts);

-- Primera actualización
UPDATE esclarecimiento.entrevista_colectiva
SET fts =   setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(titulo),'')), 'A') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(html_transcripcion),'')), 'B') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(tema_descripcion),'')), 'C') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(tema_objetivo),'')), 'C') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(eventos_descripcion),'')), 'C') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(observaciones),'')), 'D')
where true;

-- Trigger
--drop function indexar_entrevista_colectiva() cascade ;
CREATE FUNCTION indexar_entrevista_colectiva() RETURNS trigger
    LANGUAGE 'plpgsql' VOLATILE NOT LEAKPROOF
AS $BODY$
begin
    new.fts :=
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.titulo,'')), 'A') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.html_transcripcion,'')), 'B') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.tema_descripcion,'')), 'C') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.tema_objetivo,'')), 'C') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.eventos_descripcion,'')), 'C') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.observaciones,'')), 'D');
    return new;
end
$BODY$;


CREATE TRIGGER fts_actualizar_co
    BEFORE INSERT OR UPDATE ON esclarecimiento.entrevista_colectiva
    FOR EACH ROW EXECUTE PROCEDURE indexar_entrevista_colectiva();




-- ENTREVISTAS ETNICAS
-- Campo para calculos
ALTER TABLE esclarecimiento.entrevista_etnica ADD "fts" tsvector;
--Indice respectivo
CREATE INDEX ee_fts_gin_index ON esclarecimiento.entrevista_etnica USING gin(fts);

-- Primera actualización
UPDATE esclarecimiento.entrevista_etnica
SET fts =   setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(titulo),'')), 'A') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(html_transcripcion),'')), 'B') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(tema_descripcion),'')), 'C') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(tema_objetivo),'')), 'C') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(eventos_descripcion),'')), 'C') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(observaciones),'')), 'D')
where true;

-- Trigger
--drop function indexar_entrevista_etnica() cascade ;
CREATE FUNCTION indexar_entrevista_etnica() RETURNS trigger
    LANGUAGE 'plpgsql' VOLATILE NOT LEAKPROOF
AS $BODY$
begin
    new.fts :=
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.titulo,'')), 'A') ||
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.html_transcripcion,'')), 'B') ||
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.tema_descripcion,'')), 'C') ||
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.tema_objetivo,'')), 'C') ||
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.eventos_descripcion,'')), 'C') ||
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.observaciones,'')), 'D');
    return new;
end
$BODY$;


CREATE TRIGGER fts_actualizar_ee
    BEFORE INSERT OR UPDATE ON esclarecimiento.entrevista_etnica
    FOR EACH ROW EXECUTE PROCEDURE indexar_entrevista_etnica();



-- DIAGNOSTICO COMUNITACRIO


-- Campo para calculos
ALTER TABLE esclarecimiento.diagnostico_comunitario ADD "fts" tsvector;
--Indice respectivo
CREATE INDEX fts_gin_dc_index ON esclarecimiento.diagnostico_comunitario USING gin(fts);

-- Primera actualización
UPDATE esclarecimiento.diagnostico_comunitario
SET fts =   setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(titulo),'')), 'A') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(tema_comunidad),'')), 'B') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(tema_objetivo),'')), 'B') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(tema_dinamica),'')), 'B') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(html_transcripcion),'')), 'C') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(observaciones),'')), 'D')
where true;

-- Trigger
--drop function indexar_diagnostico_comunitario() cascade ;
CREATE FUNCTION indexar_diagnostico_comunitario() RETURNS trigger
    LANGUAGE 'plpgsql' VOLATILE NOT LEAKPROOF
AS $BODY$
begin
    new.fts :=
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.titulo,'')), 'A') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.tema_comunidad,'')), 'B') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.tema_objetivo,'')), 'B') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.tema_dinamica,'')), 'B') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.html_transcripcion,'')), 'C') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.observaciones,'')), 'D') ;
    return new;
end
$BODY$;


CREATE TRIGGER fts_actualizar_dc
    BEFORE INSERT OR UPDATE ON esclarecimiento.diagnostico_comunitario
    FOR EACH ROW EXECUTE PROCEDURE indexar_diagnostico_comunitario();




-- HISTORIA DE VIDA


-- Campo para calculos
ALTER TABLE esclarecimiento.historia_vida ADD "fts" tsvector;
--Indice respectivo
CREATE INDEX fts_gin_hv_index ON esclarecimiento.historia_vida USING gin(fts);

-- Primera actualización
UPDATE esclarecimiento.historia_vida
SET fts =   setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(titulo),'')), 'A') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(entrevistado_nombres),'')), 'B') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(entrevistado_apellidos),'')), 'B') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(entrevistado_otros_nombres),'')), 'B') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(entrevista_objetivo),'')), 'C') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(html_transcripcion),'')), 'C') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(observaciones),'')), 'D')
where true;

-- Trigger
--drop function indexar_historia_vida() cascade ;
CREATE FUNCTION indexar_historia_vida() RETURNS trigger
    LANGUAGE 'plpgsql' VOLATILE NOT LEAKPROOF
AS $BODY$
begin
    new.fts :=
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.titulo,'')), 'A') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.entrevistado_nombres,'')), 'B') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.entrevistado_apellidos,'')), 'B') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.entrevistado_otros_nombres,'')), 'B') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.entrevista_objetivo,'')), 'C') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.html_transcripcion,'')), 'C') ||
                                setweight(to_tsvector('pg_catalog.spanish',coalesce(new.observaciones,'')), 'D') ;
    return new;
end
$BODY$;


CREATE TRIGGER fts_actualizar_hv
    BEFORE INSERT OR UPDATE ON esclarecimiento.historia_vida
    FOR EACH ROW EXECUTE PROCEDURE indexar_historia_vida();




