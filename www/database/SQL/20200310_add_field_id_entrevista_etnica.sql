-- Sentencias SQL para implementar entrevistas sujeto colectivo étnico

-- Crea el campo id_entrevista_etnica en la tabla fichas.hecho
alter table fichas.hecho add column id_entrevista_etnica int;


-- Permite que el campo id_e_ind_fvt acepte valores nulos en la tabla fichas.hecho
ALTER TABLE fichas.hecho ALTER COLUMN id_e_ind_fvt DROP NOT NULL;


-- Permite que el campo id_lugar acepte valores nulos en la tabla fichas.hecho
ALTER TABLE fichas.hecho ALTER COLUMN id_lugar DROP NOT NULL;


-- Permite que el campo aun_continuan acepte valores nulos en la tabla fichas.hecho
ALTER TABLE fichas.hecho ALTER COLUMN aun_continuan DROP NOT NULL;

-- Permite que el campo cantidad_victimas acepte valores nulos en la tabla fichas.hecho
ALTER TABLE fichas.hecho ALTER COLUMN cantidad_victimas DROP NOT NULL;


-- Crea la llave foránea id_entrevista_etnica en la tabla fichas.hecho referenciada de la tabla esclarecimiento.entrevista_etnica
ALTER TABLE fichas.hecho
ADD FOREIGN KEY (id_entrevista_etnica) 
REFERENCES esclarecimiento.entrevista_etnica(id_entrevista_etnica);


-- Crea el campo id_entrevista_etnica en la tabla fichas.entrevista
alter table fichas.entrevista add column id_entrevista_etnica int;

-- Permite que el campo id_e_ind_fvt acepte valores nulos en la tabla fichas.entrevista
ALTER TABLE fichas.entrevista ALTER COLUMN id_e_ind_fvt DROP NOT NULL;

-- Crea la llave foránea id_entrevista_etnica en la tabla fichas.entrevista referenciada de la tabla esclarecimiento.entrevista_etnica
ALTER TABLE fichas.entrevista
ADD FOREIGN KEY (id_entrevista_etnica) 
REFERENCES esclarecimiento.entrevista_etnica(id_entrevista_etnica);


-- Crea el campo id_entrevista_etnica en la tabla fichas.persona_responsable
alter table fichas.persona_responsable add column id_entrevista_etnica int;

-- Permite que el campo id_e_ind_fvt acepte valores nulos en la tabla fichas.persona_reponsable
ALTER TABLE fichas.persona_responsable ALTER COLUMN id_e_ind_fvt DROP NOT NULL;

-- Crea la llave foránea id_entrevista_etnica en la tabla fichas.persona_responsable referenciada de la tabla esclarecimiento.entrevista_etnica
ALTER TABLE fichas.persona_responsable
ADD FOREIGN KEY (id_entrevista_etnica) 
REFERENCES esclarecimiento.entrevista_etnica(id_entrevista_etnica);


-- Ultimos cambios

-- Permite que el campo id_e_ind_fvt acepte valores nulos en la tabla fichas.persona
ALTER TABLE fichas.persona ALTER COLUMN id_e_ind_fvt DROP NOT NULL;


-- Permite que el campo id_e_ind_fvt acepte valores nulos en la tabla fichas.entrevista_justicia
ALTER TABLE fichas.entrevista_justicia ALTER COLUMN id_e_ind_fvt DROP NOT NULL;

-- Crea el campo id_entrevista_etnica en la tabla fichas.entrevista_justicia
alter table fichas.entrevista_justicia add column id_entrevista_etnica int;


-- Permite que el campo id_e_ind_fvt acepte valores nulos en la tabla fichas.entrevista_impacto
ALTER TABLE fichas.entrevista_impacto ALTER COLUMN id_e_ind_fvt DROP NOT NULL;

-- Crea el campo id_entrevista_etnica en la tabla fichas.entrevista_impacto
alter table fichas.entrevista_impacto add column id_entrevista_etnica int;




-- Crea la llave foránea id_entrevista_etnica en la tabla fichas.entrevista_justicia referenciada de la tabla esclarecimiento.entrevista_etnica
ALTER TABLE fichas.entrevista_justicia
ADD FOREIGN KEY (id_entrevista_etnica) 
REFERENCES esclarecimiento.entrevista_etnica(id_entrevista_etnica);



-- Crea la llave foránea id_entrevista_etnica en la tabla fichas.entrevista_impacto referenciada de la tabla esclarecimiento.entrevista_etnica
ALTER TABLE fichas.entrevista_impacto
ADD FOREIGN KEY (id_entrevista_etnica) 
REFERENCES esclarecimiento.entrevista_etnica(id_entrevista_etnica);








-- Permite que el campo id_e_ind_fvt acepte valores nulos en la tabla fichas.justicia_institucion
ALTER TABLE fichas.justicia_institucion ALTER COLUMN id_e_ind_fvt DROP NOT NULL;

-- Crea el campo id_entrevista_etnica en la tabla fichas.justicia_institucion
alter table fichas.justicia_institucion add column id_entrevista_etnica int;

-- Crea la llave foránea id_entrevista_etnica en la tabla fichas.justicia_institucion referenciada de la tabla esclarecimiento.entrevista_etnica
ALTER TABLE fichas.justicia_institucion
ADD FOREIGN KEY (id_entrevista_etnica) 
REFERENCES esclarecimiento.entrevista_etnica(id_entrevista_etnica);




-- Permite que el campo id_e_ind_fvt acepte valores nulos en la tabla fichas.justicia_porque
ALTER TABLE fichas.justicia_porque ALTER COLUMN id_e_ind_fvt DROP NOT NULL;

-- Crea el campo id_entrevista_etnica en la tabla fichas.justicia_porque
alter table fichas.justicia_porque add column id_entrevista_etnica int;

-- Crea la llave foránea id_entrevista_etnica en la tabla fichas.justicia_porque referenciada de la tabla esclarecimiento.entrevista_etnica
ALTER TABLE fichas.justicia_porque
ADD FOREIGN KEY (id_entrevista_etnica) 
REFERENCES esclarecimiento.entrevista_etnica(id_entrevista_etnica);




-- Permite que el campo id_e_ind_fvt acepte valores nulos en la tabla fichas.justicia_objetivo
ALTER TABLE fichas.justicia_objetivo ALTER COLUMN id_e_ind_fvt DROP NOT NULL;

-- Crea el campo id_entrevista_etnica en la tabla fichas.justicia_objetivo
alter table fichas.justicia_objetivo add column id_entrevista_etnica int;

-- Crea la llave foránea id_entrevista_etnica en la tabla fichas.justicia_objetivo referenciada de la tabla esclarecimiento.entrevista_etnica
ALTER TABLE fichas.justicia_objetivo
ADD FOREIGN KEY (id_entrevista_etnica) 
REFERENCES esclarecimiento.entrevista_etnica(id_entrevista_etnica);


-- Crea el campo observaciones_diligenciada en la tabla esclarecimiento.entrevista_etnica
alter table esclarecimiento.entrevista_etnica add column observaciones_diligenciada text;
