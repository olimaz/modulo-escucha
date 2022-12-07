-- crear campo en cat_cat
alter table catalogos.cat_cat
    add id_reclasificado int default null;

comment on column catalogos.cat_cat.id_reclasificado is 'id_cat del catalogo que lo reclasifica';

create index cat_cat_id_reclasificado_index
    on catalogos.cat_cat (id_reclasificado);



-- Crear campo en cat_item:
alter table catalogos.cat_item
    add id_reclasificado int default null;

comment on column catalogos.cat_item.id_reclasificado is 'id_item del registro que sustituye al actual según el proceso de reclasificacion. -1 indica que se debe ignorar ya que se trata de una opción inválida';

create index cat_item_id_reclasificado_index
    on catalogos.cat_item (id_reclasificado);



-- Crear nuevos catalogos a partir de los anteriores
insert into catalogos.cat_cat (id_cat, nombre, descripcion, editable, otro_cual)
(
    select id_cat+1000, concat(nombre,' (reclasificado)'), descripcion, 2,2
        from catalogos.cat_cat where id_cat between 127 and 148 or id_cat=171
    )

-- Actualizar cat_cat
update catalogos.cat_cat set id_reclasificado=id_cat+1000
    where  id_cat between 127 and 148 or id_cat=171;


--   fh_edicion: crear campo y trigger
alter table catalogos.cat_item
    add fh_edicion timestamptz;

CREATE OR REPLACE FUNCTION trigger_set_fh_edicion()
    RETURNS TRIGGER AS $$
BEGIN
    NEW.fh_edicion = NOW();
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER cat_item_set_fh_edicion
    BEFORE UPDATE ON catalogos.cat_item
    FOR EACH ROW
EXECUTE PROCEDURE trigger_set_fh_edicion();

-- Para la traza de seguridad
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion) VALUES (21, 70, 'Reclasificar opción');


