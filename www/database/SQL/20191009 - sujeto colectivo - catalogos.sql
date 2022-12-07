insert into catalogos.cat_cat (id_cat,nombre,descripcion) values (90,'Tipo de entrevista a sujeto colectivo','Utilizado en metadatos de entrevistas etnicas');
insert into catalogos.cat_cat (id_cat,nombre,descripcion) values (91,'NARP','Utilizado en metadatos de entrevistas etnicas');
insert into catalogos.cat_cat (id_cat,nombre,descripcion) values (92,'Kumpany, Kumpania','Utilizado en metadatos de entrevistas etnicas');


insert into catalogos.cat_item (id_cat,descripcion) values (90,'Pueblo étnico');
insert into catalogos.cat_item (id_cat,descripcion) values (90,'Pueblo negro, afrocolombiano, raizal o palenquero');
insert into catalogos.cat_item (id_cat,descripcion) values (90,'Pueblo Rrom');
insert into catalogos.cat_item (id_cat,descripcion) values (90,'Interétnico');

insert into catalogos.cat_item (id_cat,descripcion) values (91,'Negro');
insert into catalogos.cat_item (id_cat,descripcion) values (91,'Afrocolombiano');
insert into catalogos.cat_item (id_cat,descripcion) values (91,'Raizal');
insert into catalogos.cat_item (id_cat,descripcion) values (91,'Palenquero');

insert into catalogos.cat_item (id_cat,descripcion) values (92,'Sahagún');
insert into catalogos.cat_item (id_cat,descripcion) values (92,'San Pelayo');
insert into catalogos.cat_item (id_cat,descripcion) values (92,'Sampués');
insert into catalogos.cat_item (id_cat,descripcion) values (92,'Sabanalarga');
insert into catalogos.cat_item (id_cat,descripcion) values (92,'Unión Romaní (Bogotá)');
insert into catalogos.cat_item (id_cat,descripcion) values (92,'ProRrom (Bogotá)');
insert into catalogos.cat_item (id_cat,descripcion) values (92,'Ibagué');
insert into catalogos.cat_item (id_cat,descripcion) values (92,'Cúcuta');
insert into catalogos.cat_item (id_cat,descripcion) values (92,'Girón');
insert into catalogos.cat_item (id_cat,descripcion) values (92,'Pasto');
insert into catalogos.cat_item (id_cat,descripcion) values (92,'Envigado');


insert into catalogos.cat_cat (id_cat,nombre,descripcion) values (93,'Tipo de sujeto colectivo','Utilizado en metadatos de entrevistas etnicas');
insert into catalogos.cat_item (id_cat,descripcion,predeterminado) values (93,'Único',1);
insert into catalogos.cat_item (id_cat,descripcion) values (93,'Múltiple');


-- Nuevos campos
alter table esclarecimiento.entrevista_etnica
    add id_tipo_entrevista int;

alter table esclarecimiento.entrevista_etnica
    add id_tipo_sujeto int;

create index entrevista_etnica_id_tipo_entrevista_index
    on esclarecimiento.entrevista_etnica (id_tipo_entrevista);

create index entrevista_etnica_id_tipo_sujeto_index
    on esclarecimiento.entrevista_etnica (id_tipo_sujeto);

alter table esclarecimiento.entrevista_etnica
    add constraint entrevista_etnica_cat_item_id_item_fk
        foreign key (id_tipo_entrevista) references catalogos.cat_item
            on update cascade on delete restrict;

alter table esclarecimiento.entrevista_etnica
    add constraint entrevista_etnica_cat_item_id_item_fk_2
        foreign key (id_tipo_sujeto) references catalogos.cat_item
            on update cascade on delete restrict;


-- Nuevas tablas: pueblos indigenas
create table esclarecimiento.entrevista_etnica_indigena
(
    id_entrevista_etnica_indigena serial
        constraint entrevista_etnica_indigena_pk
            primary key,
    id_entrevista_etnica int not null
        constraint entrevista_etnica_indigena_entrevista_etnica_id_entrevista_etnica_fk
            references esclarecimiento.entrevista_etnica
            on update cascade on delete cascade,
    id_indigena int not null
        constraint entrevista_etnica_indigena_cat_item_id_item_fk
            references catalogos.cat_item
            on update cascade on delete restrict
);

comment on table esclarecimiento.entrevista_etnica_indigena is 'Pueblos entrevistados';

create index entrevista_etnica_indigena_id_entrevista_etnica_index
    on esclarecimiento.entrevista_etnica_indigena (id_entrevista_etnica);

create index entrevista_etnica_indigena_id_indigena_index
    on esclarecimiento.entrevista_etnica_indigena (id_indigena);



-- Nuevas tablas pueblos negros
create table esclarecimiento.entrevista_etnica_narf
(
    id_entrevista_etnica_narf serial
        constraint entrevista_etnica_narf_pk
            primary key,
    id_entrevista_etnica int not null
        constraint entrevista_etnica_narf_entrevista_etnica_id_entrevista_etnica_fk
            references esclarecimiento.entrevista_etnica
            on update cascade on delete cascade,
    id_narf int not null
        constraint entrevista_etnica_narf_cat_item_id_item_fk
            references catalogos.cat_item
            on update cascade on delete restrict
);

comment on table esclarecimiento.entrevista_etnica_narf is 'Pueblos entrevistados';

create index entrevista_etnica_narf_id_entrevista_etnica_index
    on esclarecimiento.entrevista_etnica_narf (id_entrevista_etnica);

create index entrevista_etnica_narf_id_indigena_index
    on esclarecimiento.entrevista_etnica_narf (id_narf);





-- Nuevas tablas: kumpania rrom
create table esclarecimiento.entrevista_etnica_rrom
(
    id_entrevista_etnica_rrom serial
        constraint entrevista_etnica_rrom_pk
            primary key,
    id_entrevista_etnica int not null
        constraint entrevista_etnica_rrom_entrevista_etnica_id_entrevista_etnica_fk
            references esclarecimiento.entrevista_etnica
            on update cascade on delete cascade,
    id_rrom int not null
        constraint entrevista_etnica_rrom_cat_item_id_item_fk
            references catalogos.cat_item
            on update cascade on delete restrict
);

comment on table esclarecimiento.entrevista_etnica_rrom is 'Kumpany entrevistadas';

create index entrevista_etnica_rrom_id_entrevista_etnica_index
    on esclarecimiento.entrevista_etnica_rrom (id_entrevista_etnica);

create index entrevista_etnica_rrom_id_indigena_index
    on esclarecimiento.entrevista_etnica_rrom (id_rrom);



