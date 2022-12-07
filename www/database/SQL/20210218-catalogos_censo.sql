-- Anotar el id_subserie
INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar, fh_creacion, id_entrevistador) VALUES (DEFAULT, 1, 'Censo de archivos en el exilio', 'CA', null, 15, 2, null, 1, 2, DEFAULT, null);
-- Para la traza de seguridad
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (22, 9, 'Censo de archivos en el exilio', DEFAULT);
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (22, 26, 'Censo de archivos en el exilio - Adjunto', DEFAULT);

-- Rol temporal para pruebas
INSERT INTO catalogos.rol (id_rol, descripcion) VALUES (4, 'pruebas censo de archivos en exilio');

-- Catalogos nuevos
insert into catalogos.cat_cat(id_cat,nombre,descripcion,editable, otro_cual) values (355,'Tipo de registro en censo de archivos','Usado en el censo de archivos en exilio',1,2);
insert into catalogos.cat_item(id_cat,descripcion) values (355,'Personal');
insert into catalogos.cat_item(id_cat,descripcion) values (355,'Familiar');
insert into catalogos.cat_item(id_cat,descripcion) values (355,'Organizativo');
insert into catalogos.cat_item(id_cat,descripcion) values (355,'Entidad pública');
insert into catalogos.cat_item(id_cat,descripcion) values (355,'Organismo internacional');


insert into catalogos.cat_cat(id_cat,nombre,descripcion,editable, otro_cual) values (350,'Tipo de acceso (censo de archivos)','Usado en el censo de archivos en exilio',1,2);
insert into catalogos.cat_item(id_cat,descripcion) values (350,'Total');
insert into catalogos.cat_item(id_cat,descripcion) values (350,'Parcial');

insert into catalogos.cat_cat(id_cat,nombre,descripcion,editable, otro_cual) values (351,'Consultado por (censo de archivos)','Usado en el censo de archivos en exilio',1,2);
insert into catalogos.cat_item(id_cat,descripcion) values (351,'Público en general');
insert into catalogos.cat_item(id_cat,descripcion) values (351,'Estudiantes de colegio o universidad');
insert into catalogos.cat_item(id_cat,descripcion) values (351,'Profesionales de la rama judicial');
insert into catalogos.cat_item(id_cat,descripcion) values (351,'Profesionales de otras áreas');
insert into catalogos.cat_item(id_cat,descripcion) values (351,'El/La custodio/a y/o su organización o allegados');
insert into catalogos.cat_item(id_cat,descripcion) values (351,'No es consultado');
-- insert into catalogos.cat_item(id_cat,descripcion) values (351,'Otro');

insert into catalogos.cat_cat(id_cat,nombre,descripcion,editable, otro_cual) values (352,'Riesgo sociopolítico (censo de archivos)','Usado en el censo de archivos en exilio',1,2);
insert into catalogos.cat_item(id_cat,descripcion) values (352,'Sustracción');
insert into catalogos.cat_item(id_cat,descripcion) values (352,'Fragmetación');
insert into catalogos.cat_item(id_cat,descripcion) values (352,'Eliminación');
insert into catalogos.cat_item(id_cat,descripcion) values (352,'Relacionado con el conflicto armado');
-- insert into catalogos.cat_item(id_cat,descripcion) values (352,'Otro');

insert into catalogos.cat_cat(id_cat,nombre,descripcion,editable, otro_cual) values (353,'Riesgo ambiental (censo de archivos)','Usado en el censo de archivos en exilio',1,2);
insert into catalogos.cat_item(id_cat,descripcion) values (353,'Daños del edificio');
insert into catalogos.cat_item(id_cat,descripcion) values (353,'Almacenamiento inadecuado');
insert into catalogos.cat_item(id_cat,descripcion) values (353,'Deterioreos en los documentos');
insert into catalogos.cat_item(id_cat,descripcion) values (353,'Presencia de hongos, insectos, roedores');
-- insert into catalogos.cat_item(id_cat,descripcion) values (353,'Otro');

insert into catalogos.cat_cat(id_cat,nombre,descripcion,editable, otro_cual) values (356,'Nivel de organización (censo de archivos)','Usado en el censo de archivos en exilio',1,2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (356,'Muy bajo (menos del 20%)',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (356,'Bajo (20% al 50%)',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (356,'Medio (50% al 80%)',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (356,'Alto (más del 80%)',4);
