-- Para el filtro de clasificacion
INSERT INTO catalogos.criterio_fijo_grupo (id_grupo, descripcion) VALUES (13, 'Niveles de clasificación');
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (13, 1, 'R-1', DEFAULT);
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (13, 2, 'R-2', DEFAULT);
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (13, 3, 'R-3', DEFAULT);
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (13, 4, 'R-4', DEFAULT);


-- Tabla principal
drop table if exists esclarecimiento.excel_personas_entrevistadas cascade ;
create table esclarecimiento.excel_personas_entrevistadas
(
    id_excel_personas_entrevistadas serial not null
        constraint excel_personas_entrevistadas_pk
        primary key,
    nombres varchar(200),
    apellidos varchar(200),
    otros_nombres varchar(200),
    id_sexo integer,
    anio_nacimiento integer,
    id_sector integer,
    codigo_entrevista varchar(25),
    clasificacion_nivel integer,
    id_subserie integer,
    id_entrevista integer
);

comment on table esclarecimiento.excel_personas_entrevistadas is 'Integración de datos de VI, PR, HV';
comment on column esclarecimiento.excel_personas_entrevistadas.id_subserie is 'Para determinar el tipo de entrevista';
comment on column esclarecimiento.excel_personas_entrevistadas.id_entrevista is 'Llave primaria de la tabla respectiva';
comment on column esclarecimiento.excel_personas_entrevistadas.codigo_entrevista is 'Para integración con otras vistas';

alter table esclarecimiento.excel_personas_entrevistadas owner to dba;
GRANT SELECT ON esclarecimiento.excel_personas_entrevistadas TO solo_lectura;


create index excel_personas_entrevistadas_apellidos_index
    on esclarecimiento.excel_personas_entrevistadas (apellidos);

create index excel_personas_entrevistadas_clasificacion_nivel_index
    on esclarecimiento.excel_personas_entrevistadas (clasificacion_nivel);

create index excel_personas_entrevistadas_codigo_entrevista_index
    on esclarecimiento.excel_personas_entrevistadas (codigo_entrevista);

create index excel_personas_entrevistadas_id_sexo_index
    on esclarecimiento.excel_personas_entrevistadas (id_sexo);

create index excel_personas_entrevistadas_id_sector_index
    on esclarecimiento.excel_personas_entrevistadas (id_sector);


create index excel_personas_entrevistadas_id_subserie_id_primaria_index
    on esclarecimiento.excel_personas_entrevistadas (id_subserie, id_entrevista);

create index excel_personas_entrevistadas_nombres_index
    on esclarecimiento.excel_personas_entrevistadas (nombres);

create index excel_personas_entrevistadas_otros_nombres_index
    on esclarecimiento.excel_personas_entrevistadas (otros_nombres);


-- Full Text search
ALTER TABLE esclarecimiento.excel_personas_entrevistadas ADD fts tsvector;

CREATE INDEX eps_fts_gin_index ON esclarecimiento.excel_personas_entrevistadas USING gin(fts);

-- Primera actualización
UPDATE esclarecimiento.excel_personas_entrevistadas
SET fts =   setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(nombres),'')), 'A') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(apellidos),'')), 'B') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(otros_nombres),'')), 'C') ||
            setweight(to_tsvector('pg_catalog.spanish',coalesce(unaccent(codigo_entrevista),'')), 'D')
where true;

-- Trigger
drop function if exists indexar_excel_pe() cascade ;
CREATE FUNCTION indexar_excel_pe() RETURNS trigger
    LANGUAGE 'plpgsql' VOLATILE NOT LEAKPROOF
AS $BODY$
begin
    new.fts :=
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.nombres,'')), 'A') ||
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.apellidos,'')), 'B') ||
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.otros_nombres,'')), 'C') ||
                        setweight(to_tsvector('pg_catalog.spanish',coalesce(new.codigo_entrevista,'')), 'D');
return new;
end
$BODY$;


CREATE TRIGGER fts_actualizar_excel_pe
    BEFORE INSERT OR UPDATE ON esclarecimiento.excel_personas_entrevistadas
    FOR EACH ROW EXECUTE PROCEDURE indexar_excel_pe();


