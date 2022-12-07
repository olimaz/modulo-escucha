-- funciones generales
CREATE OR REPLACE FUNCTION marca_insert()
RETURNS TRIGGER AS $$
BEGIN
   NEW.fh_insert = now();
   RETURN NEW;
END;
$$ language 'plpgsql';

CREATE OR REPLACE FUNCTION marca_update()
RETURNS TRIGGER AS $$
BEGIN
   NEW.fh_update = now();
   RETURN NEW;
END;
$$ language 'plpgsql';


--  Entrevistadores

alter table esclarecimiento.entrevistador
	add fh_insert timestamp;

alter table esclarecimiento.entrevistador
	add fh_update timestamp;


CREATE TRIGGER entrevistador_insercion BEFORE insert
    ON esclarecimiento.entrevistador FOR EACH ROW EXECUTE PROCEDURE
    marca_insert();

CREATE TRIGGER entrevistador_edicion BEFORE update
    ON esclarecimiento.entrevistador FOR EACH ROW EXECUTE PROCEDURE
    marca_update();


-- Entrevistas

alter table esclarecimiento.e_ind_fvt
	add fh_insert timestamp;

alter table esclarecimiento.e_ind_fvt
	add fh_update timestamp;


CREATE TRIGGER entrevista_insercion BEFORE insert
    ON esclarecimiento.e_ind_fvt FOR EACH ROW EXECUTE PROCEDURE
    marca_insert();

CREATE TRIGGER entrevista_edicion BEFORE update
    ON esclarecimiento.e_ind_fvt FOR EACH ROW EXECUTE PROCEDURE
    marca_update();


-- Entrevistas_adjunto

alter table esclarecimiento.e_ind_fvt_adjunto
	add fh_insert timestamp;

alter table esclarecimiento.e_ind_fvt_adjunto
	add fh_update timestamp;


CREATE TRIGGER entrevista_a_insercion BEFORE insert
    ON esclarecimiento.e_ind_fvt_adjunto FOR EACH ROW EXECUTE PROCEDURE
    marca_insert();

CREATE TRIGGER entrevista_a_edicion BEFORE update
    ON esclarecimiento.e_ind_fvt_adjunto FOR EACH ROW EXECUTE PROCEDURE
    marca_update();
