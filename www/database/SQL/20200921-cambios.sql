alter table esclarecimiento.mis_casos
    add id_avance int default 1;

comment on column esclarecimiento.mis_casos.id_avance is 'Nivel de avance del caso. Criterio fijo 52';

INSERT INTO catalogos.criterio_fijo_grupo (id_grupo, descripcion) VALUES (52, 'Mis casos: nivel de avance');
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion) VALUES (52, 1, '1. Metadatos ingresados');
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion) VALUES (52, 2, '2. Entrevistas asociadas');
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion) VALUES (52, 3, '3. Anexos de diseño metodológico');
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion) VALUES (52, 4, '4. Anexos de análisis y seguimiento');

UPDATE catalogos.criterio_fijo SET  descripcion = 'Fuentes secundarias' where id_grupo=50 and id_opcion=1;