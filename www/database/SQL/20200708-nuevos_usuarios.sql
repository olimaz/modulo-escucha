ALTER USER tableau WITH PASSWORD 'sim@cev';
CREATE USER sim_analitica WITH PASSWORD 'consulta@cev';
CREATE USER sim_desarrollo WITH PASSWORD 'acceso@cev';
GRANT solo_lectura TO sim_analitica;
GRANT solo_lectura TO sim_desarrollo;