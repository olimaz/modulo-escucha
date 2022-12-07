

insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (6,'Objetivos','Utilizado para clasificar documentos',2);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (7,'Instrumentos','Utilizado para clasificar documentos',2);

insert into catalogos.cat_item(id_cat, descripcion) values (6,'Esclarecimiento');
insert into catalogos.cat_item(id_cat, descripcion) values (6,'Reconocimiento');
insert into catalogos.cat_item(id_cat, descripcion) values (6,'Convivencia');
insert into catalogos.cat_item(id_cat, descripcion) values (6,'No Repetición');

insert into catalogos.cat_item(id_cat, descripcion) values (7,'Entrevista individual a familiares, víctimas o testigos');
insert into catalogos.cat_item(id_cat, descripcion) values (7,'Entrevista individual a actores armados');
insert into catalogos.cat_item(id_cat, descripcion) values (7,'Entrevista individual a terceros civiles');
insert into catalogos.cat_item(id_cat, descripcion) values (7,'Informes y casos');
insert into catalogos.cat_item(id_cat, descripcion) values (7,'Historias de vida y entrevistas a profundidad');
insert into catalogos.cat_item(id_cat, descripcion) values (7,'Diagnóstico comunitario');
insert into catalogos.cat_item(id_cat, descripcion) values (7,'Entrevista colectiva');
insert into catalogos.cat_item(id_cat, descripcion) values (7,'Matriz de caracterización');
insert into catalogos.cat_item(id_cat, descripcion) values (7,'Matriz de mapeo');


-- Criterios fijos

insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion) values (1,6,'Transcripción');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion) values (1,7,'Referencia');

-- Crear tabla
-- auto-generated definition
create table catalogos.documento
(
    id_documento   serial not null
        constraint documento_pkey
        primary key,
    id_objetivo    integer
        constraint fk_id_objetivo
        references catalogos.cat_item
        on update restrict on delete restrict,
    id_instrumento integer
        constraint fk_id_instrumento
        references catalogos.cat_item
        on update restrict on delete restrict,
    orden          integer,
    descripcion    varchar(200),
    id_adjunto     integer
        constraint fk_id_adjunto
        references esclarecimiento.adjunto
        on update restrict on delete restrict,
    fh_insert      timestamp(0) default CURRENT_TIMESTAMP(0),
    fh_update      timestamp(0)
);

alter table catalogos.documento
    owner to dba;

create index catalogos_documento_id_objetivo_index
    on catalogos.documento (id_objetivo);

create index catalogos_documento_id_instrumento_index
    on catalogos.documento (id_instrumento);

create index catalogos_documento_orden_index
    on catalogos.documento (orden);

create index catalogos_documento_descripcion_index
    on catalogos.documento (descripcion);


CREATE TRIGGER documento_insercion BEFORE insert
    ON catalogos.documento FOR EACH ROW EXECUTE PROCEDURE
    marca_insert();

CREATE TRIGGER documento_edicion BEFORE update
    ON catalogos.documento FOR EACH ROW EXECUTE PROCEDURE
    marca_update();
