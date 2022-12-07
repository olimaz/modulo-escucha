-- Crear nuevo catalogo
insert into  catalogos.cat_cat(id_cat,nombre,descripcion,id_reclasificado, editable, otro_cual)
values (500,'Ocupación','Utilizado en ocupación actual y al momento de los hechos',1500,2,2);

-- Craear catalogo equivalente para la recategorización
insert into catalogos.cat_cat(id_cat,nombre,descripcion,id_reclasificado, editable, otro_cual)
values (1500,'Ocupación - Reclasificado','Utilizado en ocupación actual y al momento de los hechos',null,2,2);


-- Poblar el nuevo catálogo con los valores existentes
insert into catalogos.cat_item (id_cat,descripcion)
select 500, txt from
    (
        select distinct ocupacion_actual as txt
        from fichas.persona
        union
        select distinct ocupacion as txt
        from fichas.hecho_victima
    ) as textos
where txt is not null and length(trim(txt))>0
order by txt


-- Crear campo para el catálogo
alter table fichas.persona
    add id_ocupacion_actual int;

comment on column fichas.persona.id_ocupacion_actual is 'Sustituye al campo ocupacion_actual';

create index persona_id_ocupacion_actual_index
    on fichas.persona (id_ocupacion_actual);

alter table fichas.persona
    add constraint persona_cat_item_id_item_fk
        foreign key (id_ocupacion_actual) references catalogos.cat_item
            on update cascade on delete restrict;

-- tabla hecho_victima
alter table fichas.hecho_victima
    add id_ocupacion int;

comment on column fichas.hecho_victima.id_ocupacion is 'Sustituye al campo ocupacion';

create index hecho_victima_id_ocupacion_index
    on fichas.hecho_victima (id_ocupacion);

alter table fichas.hecho_victima
    add constraint hecho_victima_id_ocupacion_cat_item_id_item_fk
        foreign key (id_ocupacion) references catalogos.cat_item
            on update cascade on delete restrict;


-- publar los nuevos campos
update fichas.persona
set id_ocupacion_actual=id_item
from (
         select descripcion,ocupacion_actual, id_item
         from catalogos.cat_item join fichas.persona on (ocupacion_actual=descripcion and id_cat=500)
     ) as tmp
where persona.ocupacion_actual=tmp.descripcion;

-- verificacion
select ocupacion_actual, descripcion
from fichas.persona
         join catalogos.cat_item on (id_ocupacion_actual=cat_item.id_item)
order by 1;

-- publar los nuevos campos
update fichas.hecho_victima
set id_ocupacion=id_item
from (
         select descripcion,ocupacion, id_item
         from catalogos.cat_item join fichas.hecho_victima on (ocupacion=descripcion and id_cat=500)
     ) as tmp
where hecho_victima.ocupacion=tmp.descripcion;

-- verificacion
select ocupacion, descripcion
from fichas.hecho_victima
         join catalogos.cat_item on (hecho_victima.id_ocupacion=cat_item.id_item)
order by 1


