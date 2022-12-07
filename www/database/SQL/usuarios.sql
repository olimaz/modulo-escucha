CREATE DATABASE cev
    WITH OWNER "dba"
    ENCODING 'UTF8'
    LC_COLLATE = 'es_ES.UTF-8'
    LC_CTYPE = 'es_ES.UTF-8'
    TEMPLATE template0;

CREATE ROLE solo_lectura;
GRANT CONNECT ON DATABASE cev TO solo_lectura;
GRANT CONNECT ON DATABASE cev_desarrollo TO solo_lectura;
GRANT USAGE ON SCHEMA esclarecimiento TO solo_lectura;
GRANT SELECT ON esclarecimiento.excel_entrevista_fvt TO solo_lectura;
CREATE USER tableau WITH PASSWORD 'consulta';
GRANT solo_lectura TO tableau;

GRANT CONNECT ON DATABASE cev TO solo_lectura;
CREATE USER tableau WITH PASSWORD 'consulta';
GRANT solo_lectura TO tableau;

-- como postgres, ojo con ingresar dos veces la clave
pg_dump --clean -h 192.168.1.21 -U dba cev | psql -h 127.0.0.1 -U dba cev



GRANT CONNECT ON DATABASE cev TO solo_lectura;
GRANT USAGE ON SCHEMA esclarecimiento TO solo_lectura;
GRANT USAGE ON SCHEMA sim TO solo_lectura;
GRANT SELECT ON esclarecimiento.excel_entrevista_fvt TO solo_lectura;
GRANT solo_lectura TO tableau;

-- control
select count(1) from traza_actividad;


--
GRANT USAGE ON SCHEMA sim TO solo_lectura;
GRANT USAGE ON SCHEMA catalogos TO solo_lectura;


GRANT SELECT ON sim.etiqueta TO solo_lectura;
GRANT SELECT ON sim.etiqueta_entrevista TO solo_lectura;

GRANT SELECT ON catalogos.tesauro TO solo_lectura;


GRANT SELECT ON public.transcribir_asignacion TO solo_lectura;
GRANT SELECT ON public.etiquetar_asignacion TO solo_lectura;



