-- Para poder agregar otro en el front end
alter table catalogos.cat_item
    add pendiente_revisar int default 2;

alter table catalogos.cat_item
    add fh_creacion timestamp default current_timestamp;

create index cat_item_pendiente_revisar_index
    on catalogos.cat_item (pendiente_revisar);



INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (34, 'Rango (grupo) del responsable individual', 'usado en el inciso 8', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (35, 'Rango (cargo) del responsable individual, grupo paramilitar', 'usado en el inciso 8', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (36, 'Responsabilidad en los hechos', 'usado en el inciso 9 de responsable individual', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (37, 'Rango (cargo) del responsable individual, guerrilla', 'usado en el inciso 8', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (38, 'Rango (cargo) del responsable individual, fuerza pública', 'usado en el inciso 8', 1);

insert into catalogos.cat_item (id_cat,descripcion) values(34,'Grupo paramilitar');
insert into catalogos.cat_item (id_cat,descripcion) values(34,'Guerrillas');
insert into catalogos.cat_item (id_cat,descripcion) values(34,'Fuerza pública');

-- OJO buscar el ID del catalogo 34 para colocarlo en otro
-- paras
insert into catalogos.cat_item (id_cat,descripcion,otro) values(35,'Comandante',0);
insert into catalogos.cat_item (id_cat,descripcion,otro) values(35,'Combatiente',0);
insert into catalogos.cat_item (id_cat,descripcion,otro) values(35,'Urbano',0);
-- guerrillas
insert into catalogos.cat_item (id_cat,descripcion,otro) values(37,'Comandante',0);
insert into catalogos.cat_item (id_cat,descripcion,otro) values(37,'Combatiente',0);
insert into catalogos.cat_item (id_cat,descripcion,otro) values(37,'Miliciano',0);
-- fuerza publica
insert into catalogos.cat_item (id_cat,descripcion,otro) values(38,'Oficial',0);
insert into catalogos.cat_item (id_cat,descripcion,otro) values(38,'Suboficial',0);
insert into catalogos.cat_item (id_cat,descripcion,otro) values(38,'Soldado',0);




insert into catalogos.cat_item (id_cat,descripcion) values(36,'La persona ORDENÓ el/los hechos');
insert into catalogos.cat_item (id_cat,descripcion) values(36,'La persona PLANEÓ el/los hechos');
insert into catalogos.cat_item (id_cat,descripcion) values(36,'La persona REALIZÓ el/los hechos');
insert into catalogos.cat_item (id_cat,descripcion) values(36,'La persona PARTICIPÓ el/los hechos');
insert into catalogos.cat_item (id_cat,descripcion) values(36,'La persona NO ACTUÓ PARA EVITAR que se comietieran los hechos');


--
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (40,'Acompañamiento en la entrevista', 'Ficha de la entrevista');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (41,'Tipo de documento de identidad', 'usado en ficha de persona entrevistada');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (42,'Nacionalidad', 'usado en ficha de persona entrevistada');
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion) VALUES (43,'Estado civil', 'usado en ficha de persona entrevistada');
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion) VALUES (44,'Condición de discapacidad', 'usado en ficha de persona entrevistada');
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion) VALUES (45,'Zona geográfica', 'usado en ficha de persona entrevistada, lugar de residencia');
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion) VALUES (47,'Autoridad ético territoria', 'usado en ficha de persona entrevistada');
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion) VALUES (48,'Miembro activo/inactivo', 'usado en ficha de persona entrevistada');
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion) VALUES (49,'Miembro de la fuerza pública', 'usado en ficha de persona entrevistada');
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion) VALUES (50,'Miembro de algún actor armado ilegal', 'usado en ficha de persona entrevistada');
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion) VALUES (51,'Tipo de organización/Sector', 'usado en ficha de persona entrevistada');
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion) VALUES (52,'Relación con la víctima', 'usado en ficha de persona entrevistada');


INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (40, 'Familiar', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (40, 'Espiritual', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (40, 'Psicosocial / psicocultural', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (40, 'Acompañamiento a niños, niñas y adolescentes (NNA)', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (40, 'Acompañamiento a personas mayores', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (40, 'Acompañamiento a persona en situacion de discapacidad', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (40, 'Miembro de su comunidad, organizción o pueblo étnico', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (41, 'CC', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (41, 'CE', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (41, 'Pasaporte', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (41, 'Tarjeta de identidad', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (41, 'Sin documento', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (42, 'Colombiano/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (42, 'Peruano/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (42, 'Ecuatoriano/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (42, 'Venezolano/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (42, 'Panameño/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (43, 'Casado/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (43, 'Unión libre', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (43, 'Soltero/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (43, 'Viudo/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (43, 'Separado/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (44, 'Física', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (44, 'Sensorial', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (44, 'Intelectual / cognitiva', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (44, 'Psicosocial', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (45, 'Rural', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (45, 'Urbana', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (47, 'Política (gobernador, presidente de consejo comunitario, sere rromenge, etc.)', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (47, 'Espiritual (médico tradicional, partera, etc.)', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (48, 'Activo', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (48, 'Retirado', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (49, 'Militar', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (49, 'Policía', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (50, 'Guerrilla', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (50, 'Paramilitar', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Para la defensa y/o promoción de los DDHH', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Víctimas', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Víctimas de un hecho específico (ej. desplazamiento forzado, exilio, etc)', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Mujeres', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'LGBTI', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'N.N.A.', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Jóvenes', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Personas en condición de discapacidad', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Afrocolombiana, negra, raizal o palenquera', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Indígena', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Rrom', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Campesinos', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Sindicalistas', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Movimiento social', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Partido político', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Juntas de acción comunal', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Periodistas', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Agricultores', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Comerciantes', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Ganaderos/as', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Empresarios/as', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Sector salud', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Sector educación', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Religioso', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (51, 'Asociación / Cooperativa', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (52, 'Madre/padre', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (52, 'Esposo/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (52, 'Pareja', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (52, 'Hijo/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (52, 'Hermano/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (52, 'Abuelo/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (52, 'Familiar', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (52, 'Conocido/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (52, 'Vecino/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (52, 'Amigo/a', null, null, 0, 2, null, 1, 2);
INSERT INTO catalogos.cat_item (id_cat, descripcion, abreviado, texto, orden, predeterminado, otro, habilitado, pendiente_revisar) VALUES (52, 'Ninguna', null, null, 0, 2, null, 1, 2);



-- Fichas
create table catalogos.violencia
(
    id_geo      serial            not null
        constraint violencia_pk
            primary key,
    id_padre    integer,
    nivel       integer default 0 not null,
    descripcion varchar(100)      not null,
    id_tipo     integer,
    codigo      varchar(10)
);


comment on table catalogos.violencia is 'Catálogo de tipos de violencia, igual a geo';

alter table catalogos.violencia
    owner to dba;

create table catalogos.aa
(
    id_geo      serial            not null
        constraint aa_pk
            primary key,
    id_padre    integer,
    nivel       integer default 0 not null,
    descripcion varchar(100)      not null,
    id_tipo     integer,
    codigo      varchar(10)
);

comment on table catalogos.aa is 'Catálogo de actores armados';

alter table catalogos.aa
    owner to dba;

create table catalogos.tc
(
    id_geo      serial            not null
        constraint tc_pk
            primary key,
    id_padre    integer,
    nivel       integer default 0 not null,
    descripcion varchar(100)      not null,
    id_tipo     integer,
    codigo      varchar(10)
);

comment on table catalogos.tc is 'Catálogo de terceros civiles, igual a geo';

alter table catalogos.tc
    owner to dba;

-- Poblar Violencia
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Homicidio/Muerte','05');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Homicidio/Ejecución extrajudicial','0501');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Masacre (varias muertes)','0502');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Muerte de civiles en medio de combates','0503');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Muerte de civiles en atentados con bombas','0504');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Muerte de persona por activación de explosivos o minas','0505');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Muerte de civiles causada por ataques a bienes civiles','0506');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Muerte con servicio o violencia contra el puerto (post-mortem)','0507');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Atentado al derecho a la vida','06');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Herido en atentado','0601');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Víctima de atentado sin lesiones','0602');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Civil herido en medio de combate','0603');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Civil herido en atentado con bomba','0604');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Persona herida por activación de explosivos o minas','0605');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Civil herido en medio de ataques a bienes civiles','0606');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Amenaza al derecho a la vida','07');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Amenaza al derecho a la vida','0701');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Desaparición forzada','08');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Desaparición forzada','0801');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Tortura y otros tratos crueles, inhumanos o degradantes','09');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Tortura física','0901');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Tortura psicológica','0902');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Violencia sexual','10');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Violación sexual','1001');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Embarazo forzado','1002');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Amenaza de violación y/o violencia sexual','1003');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Anticoncepción y esterilización forzada','1004');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Trata de personas con fines de explotación sexual','1005');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Prostitución forzada','1006');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Tortura durante el embarazo','1007');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Mutilización de órganos sexuales','1008');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Enamoramiento como estrategia de guerra','1009');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Acoso sexual','1010');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Aborto forzado','1011');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Obligación de presenciar actos sexuales','1012');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Obligación de realizar actos sexuales','1013');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Cambios forzados enla corporalidad y la perfomatividadd del género','1014');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Otra forma de violencia sexual','1015');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Esclavitud sexual','1016');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Desnudez forzada','1017');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Maternidad forzada','1018');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Cohabitación forzada','1019');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Esclavitud / Trabajo forzoso sin fines sexuales','11');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Esclavitud / Trabajo forzoso sin fines sexuales','1101');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Recultamiento de niños, niñas y adolescentes','12');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Recultamiento de niños, niñas y adolescentes','1201');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Detención arbitraria','13');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Detención arbitraria','1301');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Secuestro / Toma de rehenes','14');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Secuestro / Toma de rehenes','1401');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Confinamiento','15');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Confinamiento','1501');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Pillaje','16');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Pillaje','1601');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Extorsión','17');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Extorsión','1701');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Ataque a bien protegido','18');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Bien civil','1801');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Bien sanitario','1802');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Bien religioso','1803');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Lugar sagrado','1804');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Bien cultural / educativo','1805');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Obras e instalaciones que contentan fuerzas peligrosas','1806');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Medioambiente','1807');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Ataque indiscriminado','19');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Ataque indiscriminado','1901');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Despojo / Abandono de tierras','20');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Despojo / Abandono de tierras','2001');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Desplazamiento forzado','21');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Desplazamiento forzado','2101');
insert into catalogos.violencia (nivel,descripcion,codigo) values(1,'Exilio','22');
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Exilio','2201');
-- actualizar arbol
update catalogos.violencia set id_padre=null where true;
update catalogos.violencia
set id_padre = padre.id_geo
from catalogos.violencia as padre
where violencia.nivel=2
  and padre.nivel=1
  and substring(violencia.codigo,1,2) = substring(padre.codigo,1,2);

-- Actores armados
insert into catalogos.aa (nivel,descripcion,codigo) values(1,'Grupo Paramilitar','01');
insert into catalogos.aa (nivel,descripcion,codigo) values(2,'Grupo Paramilitar','0101');
insert into catalogos.aa (nivel,descripcion,codigo) values(1,'Guerrilla','02');
insert into catalogos.aa (nivel,descripcion,codigo) values(2,'FARC-EP','0201');
insert into catalogos.aa (nivel,descripcion,codigo) values(2,'ELN','0202');
insert into catalogos.aa (nivel,descripcion,codigo) values(2,'Otra','0203');
insert into catalogos.aa (nivel,descripcion,codigo) values(1,'Fuerza Pública','03');
insert into catalogos.aa (nivel,descripcion,codigo) values(2,'Ejército','0301');
insert into catalogos.aa (nivel,descripcion,codigo) values(2,'Armada (Naval)','0302');
insert into catalogos.aa (nivel,descripcion,codigo) values(2,'Fuerza Aérea','0303');
insert into catalogos.aa (nivel,descripcion,codigo) values(2,'Policía','0304');
insert into catalogos.aa (nivel,descripcion,codigo) values(1,'Otro grupo armado','04');
insert into catalogos.aa (nivel,descripcion,codigo) values(2,'Otro grupo armado','0401');
insert into catalogos.aa (nivel,descripcion,codigo) values(1,'No Sabe / No responde','05');
insert into catalogos.aa (nivel,descripcion,codigo) values(2,'No Sabe / No responde','0501');
-- actualizar arbol
update catalogos.aa set id_padre=null where true;
update catalogos.aa
set id_padre = padre.id_geo
from catalogos.aa as padre
where aa.nivel=2
  and padre.nivel=1
  and substring(aa.codigo,1,2) = substring(padre.codigo,1,2);


-- Terceros civiles
insert into catalogos.tc (nivel,descripcion,codigo) values(1,'Terceros civiles','01');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Sector político','0101');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Medios de comunicaciones','0102');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Sector social / comunitario','0103');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Sector académico','0104');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Sector religioso','0105');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Sector económico / empresas','0106');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Otro sector','0107');
insert into catalogos.tc (nivel,descripcion,codigo) values(1,'Otro agente del Estado','02');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Ejecutivo / Legislativo','0201');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Órganos de control','0202');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Sector justicia','0203');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Organismos de seguridad e inteligencia','0204');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Otro sector del Estado','0205');
insert into catalogos.tc (nivel,descripcion,codigo) values(1,'Internacional','03');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Gobierno extranjero','0301');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Empresa transnacional','0302');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Otro sector','0303');
insert into catalogos.tc (nivel,descripcion,codigo) values(1,'Otro Actor','04');
insert into catalogos.tc (nivel,descripcion,codigo) values(2,'Otro Actor','0401');

update catalogos.tc set id_padre=null where true;
update catalogos.tc
set id_padre = padre.id_geo
from catalogos.tc as padre
where tc.nivel=2
  and padre.nivel=1
  and substring(tc.codigo,1,2) = substring(padre.codigo,1,2);


-- Catalogos de un solo nivel
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',120,'Tipos de tortura física');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',121,'Tipos de tortura psicológica');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',122,'Tipos de amenaza a derecho a la vida');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',123,'Reclutamiento de niños');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',124,'Desaparición forzada');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',125,'Modalidad de despojo');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',126,'Sentido de desplazamiento');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',127,'Motivos por los cuales cree que ocurrieron los hechos');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',128,'Contexto de control territorial');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',129,'Espacios significativos');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',130,'Factores externos que influenciaron los hehcos');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',131,'Los hechos beneficiaron a');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',132,'Que cambió en su vida');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',133,'Impactos emocionales que permanencen en el tiempo');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',134,'Impactos en la salud');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',135,'Impactos a los familiares de las víctimas');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',136,'Impacos en la red social personal');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',137,'Formas de revictimización');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',138,'Impactos colectivos');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',139,'Impactos a sujetos colectivos étnicos-raciales');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',140,'impactos ambientales y al territorio');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',141,'impactos a derechos sociales y económicos');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',142,'Impactos culturales');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',143,'impactos políticos y a la democracia');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',144,'Afrontamiento individual al moment ode los hechos');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',145,'Afrontamiento familiar');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',146,'Afrontamiento colectivo - participación');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',147,'Afrontamiento colectivo - dificultados');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',148,'Afrontamiento colectivo - fortalecimiento');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',149,'Tipo de proceso de retorno');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',150,'Acceso justicia - Estado');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',151,'Acceso justicia - Comunitario');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',152,'Acceso justicia - Internacional');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',153,'Acceso justicia - porqué accedió');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',154,'Acceso justicia - objetivo');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',155,'Acceso justicia - apoyo');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',160,'Acceso justicia - avances - responsable sancionado');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',161,'Acceso justicia - avances - verdad esclarecida');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',162,'Acceso justicia - avances - sin avances');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',163,'Acceso justicia - reparación');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',164,'Indemnización individual');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',165,'Medidas de restablecimiento de derechos');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',166,'Medidas de rehabilitación');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',167,'Medidas de satisfacción');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',168,'Otras medidas');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',169,'Estado de avance de la reparación colectiva');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',170,'porqué no han sido adecuadas las medidas');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',171,'Iniciativas de no repetición');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',172,'Individual o colectivo');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',173,'Tipo de lugar de llegada (desplazamiento)');
insert into catalogos.cat_cat(descripcion, id_cat,nombre) values ('Utilizado en la ficha larga',174,'Detalle de rango o cargo para (otro responsable) en ficha de responsable individual');

-- Contenido de cada catalogo
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Golpes sin empleo de instrumentos',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Golpes con instrumentos',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Castigos',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Vendaje de ojos y/o utilización de capuchas',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Colgamiento, amarrar y/o posiciones extremas',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Mordazas',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Asfixia con bolsas',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Asfixia por inmersión en agua',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Otras formas de asfixia',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Utilización de electricidad en el cuerpo',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Utilización de drogas',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Utilización de animales',12);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Trabajo forzado',13);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Quemaduras, cortes o marcas en el cuerpo',14);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Exposición a temperaturas extremas',15);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (120,'Insuficiente alimentación y/o privación de alimentos',16);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Aislamiento individual extremo',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Seguimientos',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Señalamientos',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Escarnio público',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Falta de atención médica',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Hacinamiento',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Condiciones insalibres y/o situación de higiene',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Privación del sueño',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Incomunicación',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Presenciar tortura de terceros',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Insultos',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Amenza de muerte, daños o calumnas a familiares o personas cercanas',12);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Escuchar música estridente',13);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (121,'Humillación étnico racial',14);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (122,'Amenaza verbal',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (122,'Por correo electrónico',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (122,'Por redes sociales',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (122,'Amenza por medio de un familiar o amigo',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (122,'Por carta',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (122,'Por llamada telefónica',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (122,'Por mensaje de celular',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (122,'Hostigamiento',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (122,'Por panfleto',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (122,'Por sufrajia',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (122,'Seguimiento',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (123,'Utilización en acciones bélicas',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (123,'Utilización en actividades de vigilancia e inteligencia',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (123,'Utilización con fin de explotación sexual',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (123,'Utilización con fin de trata de personas',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (123,'Utilización en actividades logísticas y/o administrativas',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (123,'Utilización en actividades relacionadas con el narcotráfico',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (123,'Amenaza de reclutamiento',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (124,'Personas con paradero desconocido',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (124,'Cuerpo/restos encontrados sin identificar',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (124,'Cuerpo/restos identificados',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (124,'Se recibió notiica de la destrucción de los cuerpos',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (124,'Cuerpo/restos entregados a la familia',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (124,'Persona encontrada viva',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (124,'Cuerpos encontrados en fosa común',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (125,'Abandono',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (125,'Acto jurídico administrativo',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (125,'Desalojo armado',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (125,'Apropiación total o parcial de las tierras por aprte del actor armado o tercero civil',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (125,'Venta forzosa por amenaza o violencia',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (125,'Revocación arbitraria de adjudicación de reorma agriaria',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (126,'Rural a Urbano',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (126,'Rural a Rural',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (126,'Urbano a Rural',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (126,'Urbano a Urbano',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (126,'Intraurbano',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por motivos políticos',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por motivos religiosos',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por motivos económicos',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por conflictos sociales que se dan en la zona',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por el oficio o la profesión',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por estereotipos culturales',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por ser mujer',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por ser hombre',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por su condición de liderazgo social',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por su orientación sexual',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por su identidad de género',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por pertenencia étnica',12);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por racismo',13);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por su edad',14);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por condición de discapacidad',15);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Por condición social',16);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'No sabe',17);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (128,'Control hegemónico por parte de un actor armado ilegal',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (128,'Enfrentamientos por disputa territorial entre varios actores armados',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (128,'Movilidad y tránsito de grupos armados ilegales en el territorio',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (128,'Ocupación temporal de espacios sociales comunitarios',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (128,'Omisión de la acción protectora por parte de la institucionalidad',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (128,'Actores armados ilegales ejercen control social y/o de justicia',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (128,'Convivencia de la Fuerza Pública',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (128,'Operaciones militares en el terreno',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (128,'Señalamientos / persecusión',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (128,'Homicidios selectivos',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (128,'Amenazas a personas',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (128,'Control de la movilidad',12);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (129,'Mujeres',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (129,'Jóvenes',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (129,'Personas LGBTI',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (129,'Pueblos étnicos',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (129,'Niños, niñas y adolescentes',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (129,'Líderes sociales',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (129,'Empresarios /as',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (129,'Expresiones religiosas',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (129,'Exiliados/as y víctimas en el exterior',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (129,'Personas en ejercicio de prostitución',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (129,'Consumidores/as de drogas',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Narcotráfico: cultivo',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Narcotráfico: procesamiento',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Narcotráfico: comercialización',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Agroindustrias: palma de aceite',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Agroindustrias: Caña',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Agroindustrias: Otro',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Proyectos de infraestructura: portuarios',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Proyectos de infraestructura: viales',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Proyectos de infraestructura: otro',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Actividades exractivas ilegales/informales: minería',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Actividades exractivas ilegales/informales: hidrocarburos',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Actividades exractivas ilegales/informales: madera',12);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Pobreza y vulneración a derechos sociales, económicos y culturales',13);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (130,'Racismo y discriminación',14);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'Alguno de los grupos armados',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'Políticos de la zona',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'El Estado',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'Militares de la zona',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'Autoridades locales',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'Empresarios de la zona',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'Comerciantes de la zona',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'Terratenientes de la zona',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'Ganaderos de la zona',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'Empresas multinacionales/transnacionales',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'Grupo criminal de la zona',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'Grupo dedicado a l narcotráfico u otros negocios ilegales',12);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'Testferro de grupos armados',13);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (131,'No sabe',14);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (132,'Su comportamiento',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (132,'Confianza en sí mismo',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (132,'Sus valores',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (132,'Su proyecto de vida',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (132,'Impacto espiritual/religioso',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (132,'Capacidad para manejar ls situaciones de la vida',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (132,'Imposibilidad de construir vícnculos o relaciones afectivas',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (132,'Imposibilidad de construir su identidad de género',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (132,'Su proyecto político',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (133,'Tristeza',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (133,'Rabia',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (133,'Culpa',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (133,'Depresión',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (133,'Miedo',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Alteración del sueño / alimentación',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Alteración en la consciencia del tiempo y /o ubicación',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Infecciones de tranmisión sexual (VID-SIDA, entre otras)',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Discapacidad física',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Discapacidad sensorial auditiva',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Discapacidad sensorial visual',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Discapacidad intelectural /cognitiva',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Discapacidad psicosocial (ej. Esquizofrenia o bipolaridad)',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Impactos en crecimiento y desarrollo (niños y niñas)',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Dificultad / imposibilidad de tener relaciones sexuales',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Impsibilidad de tener hijos/as',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Lesiones en aparato reproductivo / sexual',12);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Detención del proceso de hormonización y/o transformación corporal (personas trans)',13);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Intento de suicido y/o lesiones a sí mismo',14);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Problemas respiratorios',15);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Problemas digestivos',16);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Problemas óseos',17);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Dolor crónico',18);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Dolor de cabeza',19);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Tension arterial / problemas cardiovasculares',20);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Diabetes',21);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Consumo de drogas/ alcohol',22);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Otras adicciones',23);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (134,'Cáncer',24);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (135,'Se rompió el núcleo familiar',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (135,'Se rompieron las relaciones familiares extensas',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (135,'Apareció o aumentó la violencia intrafamiliar / de género',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (135,'Impacto en la forma de crianza y socialización',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (135,'Sobrecarga de roles',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (135,'Muerte relacionada con el impacto de los hechos (ej. "murió de tristeza")',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (135,'Enfermedad de algún familiar',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (135,'Suicidio de algún familiar',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (135,'Silencia y alteración en la comunicación',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (135,'Adicción en algún familiar',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (136,'Aislar a la víctima',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (136,'Justificación de los hechos',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (136,'Estigmatización',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (136,'Indiferencia ante los hechos',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (136,'Actitudes iolentas en contra de la víctima',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (136,'Negación (ej. Pensar que es mentira lo que las vícitmas cuentan)',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (136,'Cambio en las relaciones entre niños, niñas, adultos y personas mayores',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (137,'Atropellos físicos',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (137,'Allanamientos',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (137,'Requisas',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (137,'Discriminación',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (137,'Amenazas por denunciar los hechos',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (137,'Seguimientos / vigilancia',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (137,'Estigmatización',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (137,'Maltrato por servidores públicos',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (137,'Solicitud de relatar los hechos repetitivamente',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (137,'Negación de acceso a servicios (salud, educación, etc)',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (137,'Racismo',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (138,'Impacto por pérdida de líderes sociales / políticos / espiriuales',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (138,'Estigmatización / afectación a la reputación del colectivo social / político / étnico',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (138,'Desintegración de la organización política / social / comunitaria',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (138,'Transformación demográfica del territorio (proporción de niños, ancianos, etc.)',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (138,'Suicidio (con impacto en la comunidad)',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (138,'Desmotivación de participar en política / en movimientos sociales',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Cambio en la organización política del territorio étnico',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Pérdida de espacios de uso y aprovechamiento colectivo',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Restricción a la movilidad / libre circulación del sujeto étnico',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Cambio en patrones de asentamiento',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Vulneración de la autonomía para la administración del territorio étnico',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Militarización del territorio étnico',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Pérdida en la capacidad de aplicar justicia propia en territorio étnico',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Riesgo de extinsión física y/o cultrural del grupo / pueblo',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Interferencia en el uso de recursos públicos de los pueblos étnicos (transferencias)',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Alteración en la cosmovisión del pueblo / comunidad',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Conflictos enter-étnicos',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Irrespeto o suplantación de autoridades propias',12);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Suplantación de autoridades propias',13);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Afectación a la medicina tradicional',14);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Agudización del racismo y la discriminación racial',15);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Restricción de acceso a sitios sagrados',16);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Afectación a las prácticas de partería tradicional',17);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (139,'Invisibilización del desplazamiento (Rrom)',18);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (140,'Afectación o destrucción del medio ambiente (ríos, reservas naturales, etc.)',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (140,'Pérdida o deterioro de una comunidad o pueblo',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (140,'Cambios en la forma de subsistencia y sostenibilidad del pueblo / comunidad',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (140,'Impacto en la seguridad jurídica sobre el territorio (formalización y delimintación)',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (140,'Apropiación de los recursos naturales del territorio por actores armados o terceros civiles',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (140,'Daños al territorio por fumigación o aspersión aérea',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (140,'Generación de fronteras invisibles',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (140,'Repoblamiento del territorio',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (141,'Bloqueos o dificultades de acceso a la alimentación y/o al agua',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (141,'Impacto en los servicios de salud (ej. dificultad de acceso al servicio, falta de personal o medicamentos)',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (141,'Deterioro de las condiciones de vida y/o salud de la comunidad/ pueblo',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (141,'Impacto a la educación (dificultad de acceso, ausencia de maestros, etc.)',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (141,'Falta de acceso y garantía a los derechos sexuales y reproductivos (ej. IVE)',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (141,'Pérdida o dificultad de acceso al trabajo o al sustento económico ',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (141,'Nuevas enfermedades/infecciones o aumento de las que ya existían antes de los hechos',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (141,'Impacto en el desarrollo de economías propias',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (141,'Pérdida, destrucción o daños a la vivienda',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (141,'Mendicidad o vivir en la calle',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (141,'Aumento de la deserción escolar o del atraso escolar',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (142,'Imposición de reglas y/o formas de comportamiento ',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (142,'Prohibición en uso de lengua/idioma ',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (142,'Pérdida en la transmisión del conocimiento (ej. saberes ancestrales)',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (142,'Alteración de las prácticas tradicionales o culturales (incuida la aculturación forzada)',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (142,'Pérdida o destrucción de espacio (físico o simbólico) para la expresión cultural, espiritual o religiosa',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (142,'Modificación en patrones estéticos-culturales',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (142,'Estigmatización de prácticas culturales',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (142,'Cambios en patrones de alimentación propios',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (143,'Dificultad o imposibilidad de participar como candidato en las elecciones',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (143,'Falta de garantías para participar en política, movilizarse y/o reunirse',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (143,'Influencia/ingerencia de los actores armados en instituciones locales',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (143,'Dificultad o imposibilidad de acceder a cargos de representación política (incluyendo étnicos)',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (143,'Pérdida de credibilidad en instituciones públicas',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (143,'Impedir u obligar al electorado en su ejercicio del voto',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Denunciar',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'No hablar',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Centrarse en la familia',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Buscar apoyo psicosocial',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Irse a otro lugar o país',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Organizarse para defender sus derechos',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Acudir a la autoridad étnica',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Asumir el liderazgo',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Realizar o participar en rituales culturales para la elaboración de duelos y memoria',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Dar un sentido a la experiencia vivida',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Buscar apoyo religioso o espiritual, según la creencia',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Buscar apoyo en la comunidad',12);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Normalizar la violencia en la zona/comunidad',13);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Solicitar medidas de protección',14);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Recurrir a medidas de protección propias (étnicas/campesinas/etc.)',15);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Acudir a ONGs (organizaciones no gubernamentales)',16);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (144,'Se vió en la obligación de desarrollar actividades ilícitas para obtener dinero',17);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (145,'Cada persona manejó la situación por su lado',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (145,'La familia se mantuvo unida',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (145,'La familila se separó o se alejó',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (145,'No se habló de lo sucedido',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (145,'Se activó o fortaleció la red familiar extensa',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (145,'Un miembro de la familia asumió el liderazgo',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (146,'Organización social/de base',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (146,'Iniciativa institucional',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (146,'Escenario de fortalecimiento espiritual colectivo',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (146,'Iniciativa colectiva étnica (ej. minga)',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (146,'Colectivo cultural/artistico',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (146,'Junta de acción comunal',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (146,'Iniciativa de convivencia',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (146,'Iniciativa de No Repetición',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (147,'De seguridad',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (147,'Con las instituciones',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (147,'Económicas',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (147,'Socio-Culturales',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (147,'Políticas',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (148,'Las relaciones con su entorno',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (148,'La reivindicación de derechos',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (148,'Nuevas formas de resolver conflictos',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (148,'El tejido social/comunitario',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (148,'Otras formas de convivencia',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (148,'La no Repetición',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (148,'El intercambio cultural/artistico',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (148,'Nuevas prácticas colectivas de atención en salud o educación',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (148,'La organización/autoridad étnica o tradicional',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (148,'Mecanismos de resistencia/resiliencia colectivos',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (148,'Cambios en las instituciones locales',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (149,'Individual',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (149,'Familiar',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (149,'Colectivo / masivo',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (150,'Fiscalía',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (150,'Juzgado',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (150,'Defensoría',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (150,'Procuraduría',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (150,'Personería',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (150,'Unidad de Búsqueda de Personas dadas por Desaparecidas',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (150,'Instituto Colombiano de Bienestar Familiar (ICBF)',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (150,'Unidad de Restitución de Tierras',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (150,'Centro Nacional de Memoria Histórica',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (150,'Jurisdicción Especial para la Paz',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (150,'Unidad para las Víctimas',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (151,'Autoridad consejo comunitario',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (151,'Autoridad Indígena',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (151,'Autoridad Étnica',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (151,'Mediador',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (151,'Religioso',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (152,'Naciones Unidas (ONU)',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (152,'Corte Interamericana de Derechos Humanos',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (152,'Comisión Interamericana de Derechos Humanos',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (153,'Proximidad',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (153,'Competencia',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (153,'Me obligaron',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (153,'Confianza',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (153,'Miedo',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (153,'No tenía otra alternativa',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (154,'Justicia',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (154,'Verdad',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (154,'Reparación',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (154,'Protección',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (155,'ONG',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (155,'Abogado particular',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (155,'Organismo del Estado',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (155,'Organismo Internacional (ej. ONU)',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (155,'Autoridades comunitarias',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (155,'Pueblo/organización étnica',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (155,'Autoridades religiosas',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (160,'Sanción penal',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (160,'Sanción disciplinaria',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (160,'Sanción administrativa',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (160,'Ninguna sanción',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (161,'Fueron esclarecidos todos los hechos',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (161,'Fueron esclarecidos todos los responsables',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (161,'Fueron esclarecidos algunos de los hechos',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (161,'Fueron esclarecidos algunos de los responsables',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (161,'No fueron esclarecidos hechos ni responsables',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (162,'Falta de recursos',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (162,'Excesiva burocracia / lentitud',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (162,'Falta de interés de las autoridades',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (162,'Complejidad del caso',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (162,'Problemas de corrupción',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (162,'Obstrucción política',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (162,'Racismo / discriminación',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (163,'Ha accedido a algún proceso de reparación individual',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (163,'Hace parte de un proceso de reparación colectiva',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (163,'NO hace parte de ningún proceso de reparación individual o colectiva',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (164,'Administrativa (Ley 1448 de 2011)',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (164,'Administrativa (otra Ley o Decreto)',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (164,'Judicial',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (164,'Encargo fiduciario',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (165,'Retorno y reubicación',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (165,'Restitución efectiva de las tierras',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (165,'Compensación',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (165,'Reestitución de derechos territoriales (colectivo)',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (166,'Atención en Salud',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (166,'Atención Psicosocial',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (167,'Acto conmemorativo u homenaje público',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (167,'Reconocimiento público del carácter de víctima',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (167,'Difusión pública del relato y de la verdad de lo sucedido',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (167,'Medidas simbólicas para preservar y difundir la memoria',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (167,'Reconocimiento público de responsabilidades ',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (167,'Monumento público',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (167,'Exención en la prestación del servicio militar',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (168,'Ayuda Humanitaria',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (168,'En  Educación',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (168,'En  Salud',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (168,'En Vivienda',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (168,'En trabajo',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (168,'Alivio de pasivos',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (169,'Diagnóstico del daño',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (169,'Caracterización psicosocial',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (169,'Plan Integral de Reparación Colectiva (PIRC)',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (169,'Implementación de las medidas',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (170,'El monto de indemnización no cumplió con expectativas',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (170,'Tardaron mucho en brindar las medidas ',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (170,'No pudo participar en los procesos de implementación',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (170,'El acto de reconocimiento u homenaje no fue adecuado',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (170,'Recibió solo algunas medidas, y otras no',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (170,'No se avanzó en verdad y justicia',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (170,'Las acciones de reparación fueron reivictimizantes',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (170,'No corresponden a los daños',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (171,'Mejorar el acceso a la justicia y las garantías para denunciar',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (171,'Reconocer públicamente las víctimas y devolverles la dignidad',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (171,'Reconocer públicamente las trasformaciones positivas de la comunidad',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (171,'Reintegrar con éxito a excombatientes y niños/as reclutados/as',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (171,'Mejorar los mecanismos de alerta de riesgos y de protección',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (171,'Educar a la sociedad sobre el conflicto, especialmente en las escuelas',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (171,'Transformación de prácticas de discriminación y exclusión',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (171,'Reconocer las responsabilidades de los actores armados',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (171,'Juzgar y sancionar los responsables',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (171,'Reconocer los derechos de los pueblos étnicos',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (171,'Fortalecer los procesos de convivencia ',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (172,'Individual',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (172,'Colectivo',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (173,'Inicial',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (173,'Definitivo',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (34,'Otro responsable',99);


create table fichas.entrevista
(
    id_entrevista                       serial            not null
        constraint entrevista_pkey
            primary key,
    id_e_ind_fvt                        integer           not null
        constraint fichas_entrevista_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete restrict,
    id_idioma                           integer           not null
        constraint fichas_entrevista_id_idioma_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_nativo                           integer
        constraint fichas_entrevista_id_nativo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    nombre_interprete                   varchar(200),
    documentacion_aporta                integer default 2 not null,
    documentacion_especificar           text,
    identifica_testigos                 integer default 2 not null,
    ampliar_relato                      integer default 2 not null,
    ampliar_relato_temas                text,
    priorizar_entrevista                integer default 2 not null,
    priorizar_entrevista_asuntos        text,
    contiene_patrones                   integer default 2 not null,
    contiene_patrones_cuales            text,
    indicaciones_transcripcion          text,
    observaciones                       text,
    created_at                          timestamp(0),
    updated_at                          timestamp(0),
    identificacion_consentimiento       varchar,
    conceder_entrevista                 integer default 2 not null,
    grabar_audio                        integer default 2 not null,
    elaborar_informe                    integer default 2 not null,
    tratamiento_datos_analizar          integer default 2 not null,
    tratamiento_datos_analizar_sensible integer default 2 not null,
    tratamiento_datos_utilizar          integer default 2 not null,
    tratamiento_datos_utilizar_sensible integer default 2 not null,
    tratamiento_datos_publicar          integer default 2 not null
);

alter table fichas.entrevista
    owner to dba;

create index fichas_entrevista_id_e_ind_fvt_index
    on fichas.entrevista (id_e_ind_fvt);

create index fichas_entrevista_id_idioma_index
    on fichas.entrevista (id_idioma);

create index fichas_entrevista_id_nativo_index
    on fichas.entrevista (id_nativo);

create index fichas_entrevista_documentacion_aporta_index
    on fichas.entrevista (documentacion_aporta);

create index fichas_entrevista_identifica_testigos_index
    on fichas.entrevista (identifica_testigos);

create index fichas_entrevista_ampliar_relato_index
    on fichas.entrevista (ampliar_relato);

create index fichas_entrevista_priorizar_entrevista_index
    on fichas.entrevista (priorizar_entrevista);

create index fichas_entrevista_contiene_patrones_index
    on fichas.entrevista (contiene_patrones);

create table fichas.entrevista_condiciones
(
    id_entrevista_condiciones serial  not null
        constraint entrevista_condiciones_pkey
            primary key,
    id_entrevista             integer not null
        constraint fichas_entrevista_condiciones_id_entrevista_foreign
            references fichas.entrevista
            on update cascade on delete cascade,
    id_condicion              integer not null
        constraint fichas_entrevista_condiciones_id_condicion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at                timestamp(0),
    updated_at                timestamp(0)
);

alter table fichas.entrevista_condiciones
    owner to dba;

create index fichas_entrevista_condiciones_id_entrevista_index
    on fichas.entrevista_condiciones (id_entrevista);

create index fichas_entrevista_condiciones_id_condicion_index
    on fichas.entrevista_condiciones (id_condicion);

create table fichas.entrevista_testigo
(
    id_entrevista_testigo serial       not null
        constraint entrevista_testigo_pkey
            primary key,
    id_entrevista         integer      not null
        constraint fichas_entrevista_testigo_id_entrevista_foreign
            references fichas.entrevista
            on update cascade on delete cascade,
    nombre                varchar(200) not null,
    contacto              varchar(200),
    created_at            timestamp(0),
    updated_at            timestamp(0)
);

alter table fichas.entrevista_testigo
    owner to dba;

create index fichas_entrevista_testigo_id_entrevista_index
    on fichas.entrevista_testigo (id_entrevista);

create table fichas.persona
(
    id_persona                     serial            not null
        constraint persona_pkey
            primary key,
    nombre                         varchar(200),
    apellido                       varchar(200),
    alias                          varchar(200),
    fec_nac_a                      integer,
    fec_nac_m                      integer,
    fec_nac_d                      integer,
    id_lugar_nacimiento            integer
        constraint fichas_persona_id_lugar_nacimiento_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    id_sexo                        integer
        constraint fichas_persona_id_sexo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_orientacion                 integer
        constraint fichas_persona_id_orientacion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_identidad                   integer
        constraint fichas_persona_id_identidad_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_etnia                       integer
        constraint fichas_persona_id_etnia_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_tipo_documento              integer
        constraint fichas_persona_id_tipo_documento_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    num_documento                  varchar(20),
    id_nacionalidad                integer
        constraint fichas_persona_id_nacionalidad_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_estado_civil                integer
        constraint fichas_persona_id_estado_civil_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_lugar_residencia            integer
        constraint fichas_persona_id_lugar_residencia_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    telefono                       varchar(20),
    correo_electronico             varchar(200),
    id_zona                        integer
        constraint fichas_persona_id_zona_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_edu_formal                  integer
        constraint fichas_persona_id_edu_formal_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    profesion                      varchar(100),
    ocupacion_actual               varchar(100),
    cargo_publico                  integer default 2 not null,
    cargo_publico_cual             varchar(100),
    id_fuerza_publica_estado       integer
        constraint fichas_persona_id_fuerza_publica_estado_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_fuerza_publica              integer
        constraint fichas_persona_id_fuerza_publica_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_actor_armado                integer
        constraint fichas_persona_id_actor_armado_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    organizacion_colectivo         integer default 2 not null,
    id_discapacidad                integer,
    created_at                     timestamp(0),
    updated_at                     timestamp(0),
    id_etnia_indigena              integer
        constraint fichas_persona_id_etnia_indigena_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_e_ind_fvt                   integer           not null
        constraint fichas_persona_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_otra_nacionalidad           integer
        constraint fichas_persona_id_otra_nacionalidad_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_lugar_residencia_depto      integer
        constraint fichas_persona_id_lugar_residencia_depto_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    id_lugar_residencia_muni       integer
        constraint fichas_persona_id_lugar_residencia_muni_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    lugar_residencia_nombre_vereda varchar(100),
    id_lugar_nacimiento_depto      integer
        constraint fichas_persona_id_lugar_nacimiento_depto_foreign
            references catalogos.geo
            on update cascade on delete restrict
);

alter table fichas.persona
    owner to dba;

create index fichas_persona_id_edu_formal_index
    on fichas.persona (id_edu_formal);

create index fichas_persona_id_lugar_nacimiento_index
    on fichas.persona (id_lugar_nacimiento);

create index fichas_persona_id_sexo_index
    on fichas.persona (id_sexo);

create index fichas_persona_id_identidad_index
    on fichas.persona (id_identidad);

create index fichas_persona_id_orientacion_index
    on fichas.persona (id_orientacion);

create index fichas_persona_id_etnia_index
    on fichas.persona (id_etnia);

create index fichas_persona_id_tipo_documento_index
    on fichas.persona (id_tipo_documento);

create index fichas_persona_id_nacionalidad_index
    on fichas.persona (id_nacionalidad);

create index fichas_persona_id_estado_civil_index
    on fichas.persona (id_estado_civil);

create index fichas_persona_id_lugar_residencia_index
    on fichas.persona (id_lugar_residencia);

create index fichas_persona_id_zona_index
    on fichas.persona (id_zona);

create index fichas_persona_id_fuerza_publica_estado_index
    on fichas.persona (id_fuerza_publica_estado);

create index fichas_persona_id_fuerza_publica_index
    on fichas.persona (id_fuerza_publica);

create index fichas_persona_id_actor_armado_index
    on fichas.persona (id_actor_armado);

create index fichas_persona_id_etnia_indigena_index
    on fichas.persona (id_etnia_indigena);

create index fichas_persona_id_e_ind_fvt_index
    on fichas.persona (id_e_ind_fvt);

create index fichas_persona_id_otra_nacionalidad_index
    on fichas.persona (id_otra_nacionalidad);

create index fichas_persona_id_lugar_residencia_depto_index
    on fichas.persona (id_lugar_residencia_depto);

create index fichas_persona_id_lugar_residencia_muni_index
    on fichas.persona (id_lugar_residencia_muni);

create index fichas_persona_lugar_residencia_nombre_vereda_index
    on fichas.persona (lugar_residencia_nombre_vereda);

create index fichas_persona_id_lugar_nacimiento_depto_index
    on fichas.persona (id_lugar_nacimiento_depto);

create table fichas.persona_discapacidad
(
    id_persona_discapacidad serial  not null
        constraint persona_discapacidad_pkey
            primary key,
    id_persona              integer not null
        constraint fichas_persona_discapacidad_id_persona_foreign
            references fichas.persona
            on update cascade on delete cascade,
    id_discapacidad         integer not null
        constraint fichas_persona_discapacidad_id_discapacidad_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at              timestamp(0),
    updated_at              timestamp(0)
);

alter table fichas.persona_discapacidad
    owner to dba;

create index fichas_persona_discapacidad_id_persona_index
    on fichas.persona_discapacidad (id_persona);

create index fichas_persona_discapacidad_id_discapacidad_index
    on fichas.persona_discapacidad (id_discapacidad);

create table fichas.persona_aut_etnico_ter
(
    id_persona_aut_etnico_ter serial  not null
        constraint persona_aut_etnico_ter_pkey
            primary key,
    id_persona                integer not null
        constraint fichas_persona_aut_etnico_ter_id_persona_foreign
            references fichas.persona
            on update cascade on delete cascade,
    id_aut_etnico_ter         integer not null
        constraint fichas_persona_aut_etnico_ter_id_aut_etnico_ter_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at                timestamp(0),
    updated_at                timestamp(0)
);

alter table fichas.persona_aut_etnico_ter
    owner to dba;

create index fichas_persona_aut_etnico_ter_id_persona_index
    on fichas.persona_aut_etnico_ter (id_persona);

create index fichas_persona_aut_etnico_ter_id_aut_etnico_ter_index
    on fichas.persona_aut_etnico_ter (id_aut_etnico_ter);

create table fichas.persona_entrevistada
(
    id_persona_entrevistada serial            not null
        constraint persona_entrevistada_pkey
            primary key,
    id_persona              integer           not null
        constraint fichas_persona_entrevistada_id_persona_foreign
            references fichas.persona
            on update cascade on delete cascade,
    id_e_ind_fvt            integer           not null
        constraint fichas_persona_entrevistada_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    es_victima              integer default 2 not null,
    es_testigo              integer default 2 not null,
    created_at              timestamp(0),
    updated_at              timestamp(0),
    constraint fichas_persona_entrevistada_id_persona_id_e_ind_fvt_unique
        unique (id_persona, id_e_ind_fvt)
);

alter table fichas.persona_entrevistada
    owner to dba;

create index fichas_persona_entrevistada_id_persona_index
    on fichas.persona_entrevistada (id_persona);

create index fichas_persona_entrevistada_id_e_ind_fvt_index
    on fichas.persona_entrevistada (id_e_ind_fvt);

create table fichas.per_ent_rel_victima
(
    id_per_ent_rel_victima  serial  not null
        constraint per_ent_rel_victima_pkey
            primary key,
    id_persona_entrevistada integer not null
        constraint fichas_per_ent_rel_victima_id_persona_entrevistada_foreign
            references fichas.persona_entrevistada
            on update cascade on delete cascade,
    id_rel_victima          integer not null
        constraint fichas_per_ent_rel_victima_id_rel_victima_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at              timestamp(0),
    updated_at              timestamp(0)
);

alter table fichas.per_ent_rel_victima
    owner to dba;

create index fichas_per_ent_rel_victima_id_persona_entrevistada_index
    on fichas.per_ent_rel_victima (id_persona_entrevistada);

create index fichas_per_ent_rel_victima_id_rel_victima_index
    on fichas.per_ent_rel_victima (id_rel_victima);

create table fichas.persona_organizacion
(
    id_persona_organizacion serial  not null
        constraint persona_organizacion_pkey
            primary key,
    id_persona              integer not null
        constraint fichas_persona_organizacion_id_persona_foreign
            references fichas.persona
            on update cascade on delete cascade,
    nombre                  varchar(100),
    rol                     varchar(30),
    id_tipo_organizacion    integer not null
        constraint fichas_persona_organizacion_id_tipo_organizacion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at              timestamp(0),
    updated_at              timestamp(0)
);

alter table fichas.persona_organizacion
    owner to dba;

create index fichas_persona_organizacion_id_persona_index
    on fichas.persona_organizacion (id_persona);

create index fichas_persona_organizacion_id_tipo_organizacion_index
    on fichas.persona_organizacion (id_tipo_organizacion);

create table fichas.victima
(
    id_victima   serial  not null
        constraint victima_pkey
            primary key,
    id_persona   integer not null
        constraint fichas_victima_id_persona_foreign
            references fichas.persona
            on update cascade on delete cascade,
    id_e_ind_fvt integer not null
        constraint fichas_victima_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    created_at   timestamp(0),
    updated_at   timestamp(0)
);

alter table fichas.victima
    owner to dba;

create index fichas_victima_id_persona_index
    on fichas.victima (id_persona);

create index fichas_victima_id_e_ind_fvt_index
    on fichas.victima (id_e_ind_fvt);

create table fichas.persona_responsable
(
    id_persona_responsable serial            not null
        constraint persona_responsable_pkey
            primary key,
    id_persona             integer           not null
        constraint fichas_persona_responsable_id_persona_foreign
            references fichas.persona
            on update cascade on delete cascade,
    id_e_ind_fvt           integer           not null
        constraint fichas_persona_responsable_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    created_at             timestamp(0),
    updated_at             timestamp(0),
    id_edad_aproximada     integer
        constraint fichas_persona_responsable_id_edad_aproximada_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_rango_cargo         integer
        constraint fichas_persona_responsable_id_rango_cargo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_grupo_paramilitar   integer
        constraint fichas_persona_responsable_id_grupo_paramilitar_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_guerrilla           integer
        constraint fichas_persona_responsable_id_guerrilla_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_fuerza_publica      integer
        constraint fichas_persona_responsable_id_fuerza_publica_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    nombre_superior        varchar(200),
    conoce_info            integer default 2 not null,
    que_hace               varchar(200),
    donde_esta             varchar(200),
    otros_hechos           integer default 2 not null,
    cuales                 varchar(200),
    id_otro                integer
);

alter table fichas.persona_responsable
    owner to dba;

create index fichas_persona_responsable_id_persona_index
    on fichas.persona_responsable (id_persona);

create index fichas_persona_responsable_id_e_ind_fvt_index
    on fichas.persona_responsable (id_e_ind_fvt);

create index fichas_persona_responsable_id_edad_aproximada_index
    on fichas.persona_responsable (id_edad_aproximada);

create index fichas_persona_responsable_id_rango_cargo_index
    on fichas.persona_responsable (id_rango_cargo);

create index fichas_persona_responsable_id_grupo_paramilitar_index
    on fichas.persona_responsable (id_grupo_paramilitar);

create index fichas_persona_responsable_id_guerrilla_index
    on fichas.persona_responsable (id_guerrilla);

create index fichas_persona_responsable_id_fuerza_publica_index
    on fichas.persona_responsable (id_fuerza_publica);

create table fichas.hecho
(
    id_hecho           serial            not null
        constraint hecho_pkey
            primary key,
    id_e_ind_fvt       integer           not null
        constraint fichas_hecho_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    cantidad_victimas  integer default 1 not null,
    id_lugar           integer           not null
        constraint fichas_hecho_id_lugar_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    sitio_especifico   varchar(200),
    id_lugar_tipo      integer           not null
        constraint fichas_hecho_id_lugar_tipo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    fecha_ocurrencia_d integer,
    fecha_ocurrencia_m integer,
    fecha_ocurrencia_a integer,
    fecha_fin_d        integer,
    fecha_fin_m        integer,
    fecha_fin_a        integer,
    aun_continuan      integer default 2 not null,
    observaciones      text,
    created_at         timestamp(0),
    updated_at         timestamp(0)
);

alter table fichas.hecho
    owner to dba;

create index fichas_hecho_id_e_ind_fvt_index
    on fichas.hecho (id_e_ind_fvt);

create index fichas_hecho_id_lugar_index
    on fichas.hecho (id_lugar);

create index fichas_hecho_id_lugar_tipo_index
    on fichas.hecho (id_lugar_tipo);

create index fichas_hecho_fecha_ocurrencia_d_index
    on fichas.hecho (fecha_ocurrencia_d);

create index fichas_hecho_fecha_ocurrencia_m_index
    on fichas.hecho (fecha_ocurrencia_m);

create index fichas_hecho_fecha_ocurrencia_a_index
    on fichas.hecho (fecha_ocurrencia_a);

create table fichas.hecho_victima
(
    id_hecho_victima         serial  not null
        constraint hecho_victima_pkey
            primary key,
    id_hecho                 integer not null
        constraint fichas_hecho_victima_id_hecho_foreign
            references fichas.hecho
            on update cascade on delete cascade,
    id_victima               integer not null
        constraint fichas_hecho_victima_id_victima_foreign
            references fichas.victima
            on update cascade on delete cascade,
    edad                     integer,
    id_lugar_residencia      integer
        constraint fichas_hecho_victima_id_lugar_residencia_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    id_lugar_residencia_tipo integer
        constraint fichas_hecho_victima_id_lugar_residencia_tipo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    ocupacion                varchar(200)
);

alter table fichas.hecho_victima
    owner to dba;

create index fichas_hecho_victima_id_hecho_index
    on fichas.hecho_victima (id_hecho);

create index fichas_hecho_victima_id_victima_index
    on fichas.hecho_victima (id_victima);

create index fichas_hecho_victima_id_lugar_residencia_index
    on fichas.hecho_victima (id_lugar_residencia);

create index fichas_hecho_victima_id_lugar_residencia_tipo_index
    on fichas.hecho_victima (id_lugar_residencia_tipo);

create unique index hecho_victima_id_hecho_id_victima_uindex
    on fichas.hecho_victima (id_hecho, id_victima);

create table fichas.hecho_responsable
(
    id_hecho_responsable   serial  not null
        constraint hecho_responsable_pkey
            primary key,
    id_hecho               integer not null
        constraint fichas_hecho_responsable_id_hecho_foreign
            references fichas.hecho
            on update cascade on delete cascade,
    id_persona_responsable integer not null
        constraint fichas_hecho_responsable_id_persona_responsable_foreign
            references fichas.persona_responsable
            on update cascade on delete cascade
);

alter table fichas.hecho_responsable
    owner to dba;

create index fichas_hecho_responsable_id_hecho_index
    on fichas.hecho_responsable (id_hecho);

create index fichas_hecho_responsable_id_persona_responsable_index
    on fichas.hecho_responsable (id_persona_responsable);

create unique index hecho_responsable_id_hecho_id_persona_responsable_uindex
    on fichas.hecho_responsable (id_hecho, id_persona_responsable);

create table fichas.hecho_violencia
(
    id_hecho_violencia            serial                                 not null
        constraint hecho_violencia_pkey
            primary key,
    id_hecho                      integer                                not null
        constraint fichas_hecho_violencia_id_hecho_foreign
            references fichas.hecho
            on update cascade on delete cascade,
    id_tipo_violencia             integer                                not null
        constraint fichas_hecho_violencia_id_tipo_violencia_foreign
            references catalogos.violencia
            on update cascade on delete cascade,
    id_subtipo_violencia          integer                                not null
        constraint fichas_hecho_violencia_id_subtipo_violencia_foreign
            references catalogos.violencia
            on update cascade on delete cascade,
    otro_cual                     varchar(200),
    cantidad_muertos              integer,
    id_individual_colectiva       integer,
    id_frente_otros               integer,
    id_cometido_varios            integer,
    id_hubo_embarazo              integer,
    id_hubo_nacimiento            integer,
    id_ind_fam_col                integer,
    despojo_hectareas             integer,
    despojo_recupero_tierras      integer,
    despojo_recupero_derechos     integer,
    id_lugar_salida               integer
        constraint fichas_hecho_violencia_id_lugar_salida_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    id_lugar_llegada              integer
        constraint fichas_hecho_violencia_id_lugar_llegada_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    id_lugar_llegada_tipo         integer
        constraint fichas_hecho_violencia_id_lugar_llegada_tipo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_sentido_desplazamiento     integer
        constraint fichas_hecho_violencia_id_sentido_desplazamiento_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_tuvo_retorno               integer,
    id_tuvo_retorno_tipo          integer
        constraint fichas_hecho_violencia_id_tuvo_retorno_tipo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_lugar_llegada_2            integer
        constraint fichas_hecho_violencia_id_lugar_llegada_2_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    id_lugar_llegada_2_tipo       integer
        constraint fichas_hecho_violencia_id_lugar_llegada_2_tipo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_sentido_desplazamiento_2   integer
        constraint fichas_hecho_violencia_id_sentido_desplazamiento_2_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_tuvo_otros_desplazamientos integer,
    created_at                    timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.hecho_violencia
    owner to dba;

create index fichas_hecho_violencia_id_hecho_index
    on fichas.hecho_violencia (id_hecho);

create index fichas_hecho_violencia_id_tipo_violencia_index
    on fichas.hecho_violencia (id_tipo_violencia);

create index fichas_hecho_violencia_id_subtipo_violencia_index
    on fichas.hecho_violencia (id_subtipo_violencia);

create index fichas_hecho_violencia_id_individual_colectiva_index
    on fichas.hecho_violencia (id_individual_colectiva);

create index fichas_hecho_violencia_id_frente_otros_index
    on fichas.hecho_violencia (id_frente_otros);

create index fichas_hecho_violencia_id_cometido_varios_index
    on fichas.hecho_violencia (id_cometido_varios);

create index fichas_hecho_violencia_id_hubo_embarazo_index
    on fichas.hecho_violencia (id_hubo_embarazo);

create index fichas_hecho_violencia_id_hubo_nacimiento_index
    on fichas.hecho_violencia (id_hubo_nacimiento);

create index fichas_hecho_violencia_id_ind_fam_col_index
    on fichas.hecho_violencia (id_ind_fam_col);

create index fichas_hecho_violencia_id_lugar_salida_index
    on fichas.hecho_violencia (id_lugar_salida);

create index fichas_hecho_violencia_id_lugar_llegada_index
    on fichas.hecho_violencia (id_lugar_llegada);

create index fichas_hecho_violencia_id_lugar_llegada_tipo_index
    on fichas.hecho_violencia (id_lugar_llegada_tipo);

create index fichas_hecho_violencia_id_sentido_desplazamiento_index
    on fichas.hecho_violencia (id_sentido_desplazamiento);

create index fichas_hecho_violencia_id_tuvo_retorno_index
    on fichas.hecho_violencia (id_tuvo_retorno);

create index fichas_hecho_violencia_id_tuvo_retorno_tipo_index
    on fichas.hecho_violencia (id_tuvo_retorno_tipo);

create index fichas_hecho_violencia_id_lugar_llegada_2_index
    on fichas.hecho_violencia (id_lugar_llegada_2);

create index fichas_hecho_violencia_id_lugar_llegada_2_tipo_index
    on fichas.hecho_violencia (id_lugar_llegada_2_tipo);

create index fichas_hecho_violencia_id_sentido_desplazamiento_2_index
    on fichas.hecho_violencia (id_sentido_desplazamiento_2);

create index fichas_hecho_violencia_id_tuvo_otros_desplazamientos_index
    on fichas.hecho_violencia (id_tuvo_otros_desplazamientos);

create table fichas.hecho_violencia_mecanismo
(
    id_hecho_violencia_mecanismo serial  not null
        constraint hecho_violencia_mecanismo_pkey
            primary key,
    id_hecho_violencia           integer not null
        constraint fichas_hecho_violencia_mecanismo_id_hecho_violencia_foreign
            references fichas.hecho_violencia
            on update cascade on delete cascade,
    id_mecanismo                 integer not null
        constraint fichas_hecho_violencia_mecanismo_id_mecanismo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at                   timestamp(0),
    updated_at                   timestamp(0)
);

alter table fichas.hecho_violencia_mecanismo
    owner to dba;

create index fichas_hecho_violencia_mecanismo_id_hecho_violencia_index
    on fichas.hecho_violencia_mecanismo (id_hecho_violencia);

create index fichas_hecho_violencia_mecanismo_id_mecanismo_index
    on fichas.hecho_violencia_mecanismo (id_mecanismo);

create table fichas.hecho_responsabilidad
(
    id_hecho_responsabilidad serial                                 not null
        constraint hecho_responsabilidad_pkey
            primary key,
    id_hecho                 integer                                not null
        constraint fichas_hecho_responsabilidad_id_hecho_foreign
            references fichas.hecho
            on update cascade on delete cascade,
    aa_id_tipo               integer
        constraint fichas_hecho_responsabilidad_aa_id_tipo_foreign
            references catalogos.aa
            on update cascade on delete restrict,
    aa_id_subtipo            integer
        constraint fichas_hecho_responsabilidad_aa_id_subtipo_foreign
            references catalogos.aa
            on update cascade on delete restrict,
    aa_nombre_grupo          varchar(200),
    aa_bloque                varchar(200),
    aa_frente                varchar(200),
    aa_unidad                varchar(200),
    tc_id_tipo               integer
        constraint fichas_hecho_responsabilidad_tc_id_tipo_foreign
            references catalogos.tc
            on update cascade on delete restrict,
    tc_id_subtipo            integer
        constraint fichas_hecho_responsabilidad_tc_id_subtipo_foreign
            references catalogos.tc
            on update cascade on delete restrict,
    tc_detalle               varchar(255),
    aa_otro_cual             varchar(200),
    tc_otro_cual             varchar(200),
    otro_actor_cual          varchar(200),
    created_at               timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.hecho_responsabilidad
    owner to dba;

create index fichas_hecho_responsabilidad_id_hecho_index
    on fichas.hecho_responsabilidad (id_hecho);

create index fichas_hecho_responsabilidad_aa_id_tipo_index
    on fichas.hecho_responsabilidad (aa_id_tipo);

create index fichas_hecho_responsabilidad_aa_id_subtipo_index
    on fichas.hecho_responsabilidad (aa_id_subtipo);

create index fichas_hecho_responsabilidad_tc_id_tipo_index
    on fichas.hecho_responsabilidad (tc_id_tipo);

create index fichas_hecho_responsabilidad_tc_id_subtipo_index
    on fichas.hecho_responsabilidad (tc_id_subtipo);

create table fichas.hecho_contexto
(
    id_hecho_contexto serial                                 not null
        constraint hecho_contexto_pkey
            primary key,
    id_hecho          integer                                not null
        constraint fichas_hecho_contexto_id_hecho_foreign
            references fichas.hecho
            on update cascade on delete cascade,
    id_contexto       integer                                not null
        constraint fichas_hecho_contexto_id_contexto_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at        timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.hecho_contexto
    owner to dba;

create index fichas_hecho_contexto_id_hecho_index
    on fichas.hecho_contexto (id_hecho);

create index fichas_hecho_contexto_id_contexto_index
    on fichas.hecho_contexto (id_contexto);

create table fichas.entrevista_impacto
(
    id_entrevista_impacto serial                                 not null
        constraint entrevista_impacto_pkey
            primary key,
    id_e_ind_fvt          integer                                not null
        constraint fichas_entrevista_impacto_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_impacto            integer
        constraint fichas_entrevista_impacto_id_impacto_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    transgeneracionales   varchar(200),
    afrentamiento_proceso varchar(200),
    created_at            timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.entrevista_impacto
    owner to dba;

create index fichas_entrevista_impacto_id_e_ind_fvt_index
    on fichas.entrevista_impacto (id_e_ind_fvt);

create index fichas_entrevista_impacto_id_impacto_index
    on fichas.entrevista_impacto (id_impacto);

create table fichas.entrevista_justicia
(
    id_entrevista_justicia serial                                 not null
        constraint entrevista_justicia_pkey
            primary key,
    id_e_ind_fvt           integer                                not null
        constraint fichas_entrevista_justicia_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_denuncio            integer      default 2                 not null,
    porque_no              varchar(200),
    id_apoyo               integer,
    id_adecuado            integer,
    created_at             timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.entrevista_justicia
    owner to dba;

create index fichas_entrevista_justicia_id_e_ind_fvt_index
    on fichas.entrevista_justicia (id_e_ind_fvt);

create index fichas_entrevista_justicia_id_denuncio_index
    on fichas.entrevista_justicia (id_denuncio);

create index fichas_entrevista_justicia_id_apoyo_index
    on fichas.entrevista_justicia (id_apoyo);

create index fichas_entrevista_justicia_id_adecuado_index
    on fichas.entrevista_justicia (id_adecuado);

create table fichas.justicia_institucion
(
    id_justicia_institucion serial                                 not null
        constraint justicia_institucion_pkey
            primary key,
    id_e_ind_fvt            integer                                not null
        constraint fichas_justicia_institucion_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_tipo                 integer      default 0                 not null,
    id_institucion          integer                                not null
        constraint fichas_justicia_institucion_id_institucion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at              timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.justicia_institucion
    owner to dba;

create index fichas_justicia_institucion_id_e_ind_fvt_index
    on fichas.justicia_institucion (id_e_ind_fvt);

create index fichas_justicia_institucion_id_institucion_index
    on fichas.justicia_institucion (id_institucion);

create table fichas.justicia_porque
(
    id_justicia_porque serial                                 not null
        constraint justicia_porque_pkey
            primary key,
    id_e_ind_fvt       integer                                not null
        constraint fichas_justicia_porque_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_tipo            integer      default 0                 not null,
    id_porque          integer                                not null
        constraint fichas_justicia_porque_id_porque_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at         timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.justicia_porque
    owner to dba;

create index fichas_justicia_porque_id_e_ind_fvt_index
    on fichas.justicia_porque (id_e_ind_fvt);

create index fichas_justicia_porque_id_porque_index
    on fichas.justicia_porque (id_porque);

create table fichas.justicia_objetivo
(
    id_justicia_objetivo serial                                 not null
        constraint justicia_objetivo_pkey
            primary key,
    id_e_ind_fvt         integer                                not null
        constraint fichas_justicia_objetivo_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_tipo              integer      default 0                 not null,
    id_objetivo          integer                                not null
        constraint fichas_justicia_objetivo_id_objetivo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at           timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.justicia_objetivo
    owner to dba;

create index fichas_justicia_objetivo_id_e_ind_fvt_index
    on fichas.justicia_objetivo (id_e_ind_fvt);

create index fichas_justicia_objetivo_id_objetivo_index
    on fichas.justicia_objetivo (id_objetivo);

create table fichas.persona_responsable_responsabilidades
(
    id_persona_responsable_responsabilidades serial  not null
        constraint persona_responsable_responsabilidades_pkey
            primary key,
    id_persona_responsable                   integer not null
        constraint fichas_persona_responsable_responsabilidades_id_persona_respons
            references fichas.persona_responsable
            on update cascade on delete cascade,
    id_responsabilidad                       integer not null
        constraint fichas_persona_responsable_responsabilidades_id_responsabilidad
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at                               timestamp(0),
    updated_at                               timestamp(0)
);

alter table fichas.persona_responsable_responsabilidades
    owner to dba;

create index fichas_persona_responsable_responsabilidades_id_persona_respons
    on fichas.persona_responsable_responsabilidades (id_persona_responsable);

create index fichas_persona_responsable_responsabilidades_id_responsabilidad
    on fichas.persona_responsable_responsabilidades (id_responsabilidad);



-- Ficha de exilio
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (201,'Categoría de exiliado', 'Ficha de exilio inciso 1');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (202,'Motivos de salida del país', 'Ficha de exilio inciso 2');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (203,'Estatus de protección internacional', 'Ficha de exilio inciso 6');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (204,'Estado de la solicitud de protección internacional', 'Ficha de exilio inciso 6.1');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (205,'Protección internacional aprobada por ', 'Ficha de exilio inciso 6.2');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (206,'Condición, si protección denegada', 'Ficha de exilio inciso 6.3');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (217,'Residencia en pais de acogida', 'Ficha de exilio inciso 7');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (207,'Motivos de salida, primer resasentamiento', 'Ficha de exilio inciso 1');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (208,'Impactos en la primera salida/primera llegada', 'Ficha de exilio inciso 5.c.1');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (209,'Afrontamiento en la primera llegada', 'Ficha de exilio inciso 5.c.2');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (210,'Impactos de largo plazo del exilio', 'Ficha de exilio inciso 5.c.3');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (211,'Afrontamiento en el largo plazo', 'Ficha de exilio inciso 5.c.4');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (212,'Por qué retorno', 'Ficha de exilio inciso 5.d.1');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (213,'Por qué no ha retornado', 'Ficha de exilio inciso 5.d.2');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (214,'Impactos del retorno', 'Ficha de exilio inciso 5.d.5');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (215,'Afrontamientos en el retorno', 'Ficha de exilio inciso 5.d.6');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (216,'Ayuda recibida en el retorno', 'Ficha de exilio inciso 5.d.7');
INSERT INTO catalogos.cat_cat (id_cat,nombre, descripcion) VALUES (218,'Acompañamiento en el exilio', 'Ficha de exilio, salidas');



insert into catalogos.cat_item(id_cat,descripcion,orden) values (201,'Exiliado/a',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (201,'Víctima en el exterior',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (201,'Migrante',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (201,'Retornado/a',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (201,'Desplazado/a',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (202,'Hechos violentos mencionado en la entrevista',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (202,'Rechazo / odio frente a Colombia',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (202,'Sobrevivencia / búsqueda de mejores oportunidades',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (202,'Discriminación en razón de identidad de género u orientación sexual',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (202,'Miedos relacionados con la zona ("Estaba muy caliente")',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (202,'Reagrupación familiar',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (202,'Amenaza a hijos / as',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (203,'Refugiado',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (203,'Asilado',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (203,'Persona con necesidad de protección internacional (PNPI)',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (203,'Protección Temporal Humanitaria (PTH)',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (204,'Aprobada',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (204,'Pendiente',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (204,'Denegada',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (205,'Gobierno o país de acogida',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (205,'Otro país antes de llegar en el país donde se encuentra',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (206,'Sin papeles',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (206,'Otra forma de reconocimiento',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (217,'Residencia',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (217,'Ciudadanía',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (217,'Naturalización',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Separación familiar',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Separación social (ej. dejó amigos/colegas)',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Peligro/riesgo en el trayecto',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Dificultad en obtener un estatus en el país de llegada',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Dificultad de resolver necesidades básicas (alimentación, abrigo)',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Conformación de nuevo núcleo familiar',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Impactos del trauma vivido',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Choque cultural',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Estigmatización',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Amenazas',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Nostalgia',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Imposibilidad de continuar proyecto político personal',12);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Miedo a ser repatriado',13);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (208,'Violencia basada en género',14);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (209,'Apoyo familiar',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (209,'Apoyo de instituciones colombianas en el exterior',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (209,'Apoyo de organizaciones del país de acogida',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (209,'Sensación de libertad',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (209,'Apoyo de connacionales',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (209,'Recursos/fortalezas personales en el nuevo contexto',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (209,'Creación de organizaciones sociales',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Problemas con la lengua/idioma',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Conflicto cultural',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Cambios en la identidad',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Dificultades/conflictos en relacionarse con la población local',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Dificultad en integrarse en el país',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Salud física (impactos a largo plazo de los hechos)',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Impactos psicológicos (impactos a largo plazo de los hechos)',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Cambio de status de la posición social / roles sociales',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Dureza en el régimen de vida',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Dificultades en encontrar trabajo',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Riesgos de seguridad',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Estigmatización',12);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Aislamiento de la vida política',13);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Discriminación étnica y/o racismo',14);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (210,'Discriminación por sexo, orientación sexual o identidad de género.',15);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (211,'Mantener relaciones con Colombia',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (211,'Relacionarse con colombianos en el exterior',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (211,'Promover/participar en una organización/colectivo',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (211,'Valorar el arraigo familiar en el país de acogida',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (211,'Dedicarse a la nueva carrera/vida profesional',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (211,'Olvidar todo lo que pasó en Colombia / Romper vínculos con Colombia',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (212,'Nostalgia',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (212,'Ahora están las condiciones en Colombia',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (212,'El país que lo acogió ya no lo protege',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (212,'Motivos familiares (enfermedades, padres muy mayores, etc.)',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (212,'Subvenciones económicas para el retorno',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (212,'Las condiciones económicas/políticas del país de acogida cambiaron ',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (213,'Decidió quedarse en el país donde construyó un nuevo proyecto de vida',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (213,'La familia/comunidad de referencia ya está afuera de Colombia',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (213,'La mayor parte de la familia/comunidad de referencia en Colombia ya está muerta o en otro lugar',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (213,'Por los hijos',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (213,'Miedo al retorno',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (213,'Dificultades económicas para el retorno',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (213,'Falta de condiciones políticas para el retorno',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Choque entre expectativas y realidad',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Cambios negativos respecto a la condición de vida en el exilio',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Problemas de identidad (refugiado-repatriado) / Cambio en el status social',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Conflictos familiares',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Dificultad en relacionarse con la familia/el entorno',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Separaciones del núcleo familiar creado en el exilio',6);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Escasas infraestructuras y posibilidad de desarrollo en las zonas de retorno',7);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Empeoramiento del estatus socio-económico',8);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Perdida de la organización/grupo constituido en el exilio',9);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Recuerdo de la experiencia traumática',10);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Estigmatización como exiliado/retornado',11);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Dificultad en recuperar tierra',12);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Amenazas',13);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (214,'Ausencia de afiliación al sistema de salud',14);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (215,'Acudir a entidad de apoyo al retorno',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (215,'Apoyarse en la familia',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (215,'Organizarse entre personas retornadas',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (215,'Poner en prácticas capacidades adquiridas en el exilio',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (215,'Apoyo de la comunidad de acogida en Colombia',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (216,'Ayuda en la educación (a la persona o a los hijos)',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (216,'Ayuda con proyectos laborales/productivos',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (216,'Ayuda para vivienda',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (216,'Ayuda alimentaria',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (216,'Ayuda en recuperar la documentación de identidad',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (218,'Institución colombiana',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (218,'Delegación de otro país',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (218,'Organización internacional',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (218,'ONG',4);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (218,'Ninguno',5);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (207,'Conocía más personas cercnas en el otro país',1);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (207,'Reagrupación familiar',2);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (207,'Mejores opciones económicas / políticas / culturales',3);
insert into catalogos.cat_item(id_cat,descripcion,orden) values (207,'Mayor facilidad en obtener el estatus de protección internacional',4);


-- exilio
insert into catalogos.criterio_fijo_grupo(id_grupo, descripcion) values (30,'Exilio: tipo de movimiento');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion) values (30,1,'Primera salida');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion) values (30,2,'Reasentamiento');
insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion) values (30,3,'Retorno');


-- Tablas de exilio
create table fichas.exilio
(
    id_exilio             serial                                 not null
        constraint exilio_pkey
            primary key,
    id_e_ind_fvt          integer                                not null
        constraint fichas_exilio_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_ha_tenido_retorno  integer,
    entidad_apoyo_retorno varchar(200),
    id_ha_tenido_ayuda    integer,
    institucion_ayuda     varchar(200),
    id_retorno            integer,
    id_otro_exilio        integer,
    created_at            timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.exilio
    owner to dba;

create index fichas_exilio_id_e_ind_fvt_index
    on fichas.exilio (id_e_ind_fvt);

create index fichas_exilio_id_ha_tenido_ayuda_index
    on fichas.exilio (id_ha_tenido_ayuda);

create index fichas_exilio_id_ha_tenido_retorno_index
    on fichas.exilio (id_ha_tenido_retorno);

create index fichas_exilio_id_otro_exilio_index
    on fichas.exilio (id_otro_exilio);

create index fichas_exilio_id_retorno_index
    on fichas.exilio (id_retorno);

create table fichas.exilio_categoria
(
    id_exilio_categoria serial                                 not null
        constraint exilio_categoria_pkey
            primary key,
    id_exilio           integer                                not null
        constraint fichas_exilio_categoria_id_exilio_foreign
            references fichas.exilio
            on update cascade on delete cascade,
    id_categoria        integer                                not null
        constraint fichas_exilio_categoria_id_categoria_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at          timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.exilio_categoria
    owner to dba;

create index fichas_exilio_categoria_id_categoria_index
    on fichas.exilio_categoria (id_categoria);

create index fichas_exilio_categoria_id_exilio_index
    on fichas.exilio_categoria (id_exilio);

create table fichas.exilio_impacto
(
    id_exilio_impacto serial                                 not null
        constraint exilio_impacto_pkey
            primary key,
    id_exilio         integer                                not null
        constraint fichas_exilio_impacto_id_exilio_foreign
            references fichas.exilio
            on update cascade on delete cascade,
    id_impacto        integer                                not null
        constraint fichas_exilio_impacto_id_impacto_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at        timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.exilio_impacto
    owner to dba;

create index fichas_exilio_impacto_id_exilio_index
    on fichas.exilio_impacto (id_exilio);

create index fichas_exilio_impacto_id_impacto_index
    on fichas.exilio_impacto (id_impacto);



create table fichas.exilio_movimiento
(
    id_exilio_movimiento           serial                                 not null
        constraint exilio_movimiento_pkey
            primary key,
    id_exilio                      integer                                not null
        constraint fichas_exilio_movimiento_id_exilio_foreign
            references fichas.exilio
            on update cascade on delete cascade,
    id_tipo_movimiento             integer                                not null,
    fecha_salida_d                 integer      default 0                 not null,
    fecha_salida_m                 integer      default 0                 not null,
    fecha_salida_a                 integer      default 0                 not null,
    id_lugar_salida                integer
        constraint fichas_exilio_movimiento_id_lugar_salida_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    salida_pais                    varchar(200),
    salida_estado                  varchar(200),
    salida_ciudad                  varchar(200),
    fecha_llegada_d                integer      default 0                 not null,
    fecha_llegada_m                integer      default 0                 not null,
    fecha_llegada_a                integer      default 0                 not null,
    id_lugar_llegada               integer
        constraint fichas_exilio_movimiento_id_lugar_llegada_foreign
            references catalogos.geo
            on update cascade on delete restrict,
    llegada_pais                   varchar(200),
    llegada_estado                 varchar(200),
    llegada_ciudad                 varchar(200),
    llegada_2_pais                 varchar(200),
    llegada_2_estado               varchar(200),
    llegada_2_ciudad               varchar(200),
    fecha_asentamiento_d           integer      default 0                 not null,
    fecha_asentamiento_m           integer      default 0                 not null,
    fecha_asentamiento_a           integer      default 0                 not null,
    id_modalidad                   integer
        constraint fichas_exilio_movimiento_id_modalidad_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    cant_personas_salieron         integer      default 0                 not null,
    cant_personas_familia_salieron integer      default 0                 not null,
    cant_personas_familia_quedaron integer      default 0                 not null,
    id_solicitado_proteccion       integer
        constraint fichas_exilio_movimiento_id_solicitado_proteccion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_estado_proteccion           integer
        constraint fichas_exilio_movimiento_id_estado_proteccion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_aprobada_proteccion         integer
        constraint fichas_exilio_movimiento_id_aprobada_proteccion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_denegada_proteccion         integer
        constraint fichas_exilio_movimiento_id_denegada_proteccion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_residencia_proteccion       integer
        constraint fichas_exilio_movimiento_id_residencia_proteccion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_expulsion                   integer,
    created_at                     timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.exilio_movimiento
    owner to dba;

create index fichas_exilio_movimiento_id_aprobada_proteccion_index
    on fichas.exilio_movimiento (id_aprobada_proteccion);

create index fichas_exilio_movimiento_id_denegada_proteccion_index
    on fichas.exilio_movimiento (id_denegada_proteccion);

create index fichas_exilio_movimiento_id_estado_proteccion_index
    on fichas.exilio_movimiento (id_estado_proteccion);

create index fichas_exilio_movimiento_id_exilio_index
    on fichas.exilio_movimiento (id_exilio);

create index fichas_exilio_movimiento_id_lugar_llegada_index
    on fichas.exilio_movimiento (id_lugar_llegada);

create index fichas_exilio_movimiento_id_lugar_salida_index
    on fichas.exilio_movimiento (id_lugar_salida);

create index fichas_exilio_movimiento_id_modalidad_index
    on fichas.exilio_movimiento (id_modalidad);

create index fichas_exilio_movimiento_id_residencia_proteccion_index
    on fichas.exilio_movimiento (id_residencia_proteccion);

create index fichas_exilio_movimiento_id_solicitado_proteccion_index
    on fichas.exilio_movimiento (id_solicitado_proteccion);

create index fichas_exilio_movimiento_id_tipo_movimiento_index
    on fichas.exilio_movimiento (id_tipo_movimiento);

create table fichas.exilio_movimiento_motivo
(
    id_exilio_movimiento_motivo serial                                 not null
        constraint exilio_movimiento_motivo_pkey
            primary key,
    id_exilio_movimiento        integer                                not null
        constraint fichas_exilio_movimiento_motivo_id_exilio_movimiento_foreign
            references fichas.exilio_movimiento
            on update cascade on delete cascade,
    id_motivo                   integer                                not null
        constraint fichas_exilio_movimiento_motivo_id_motivo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at                  timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table fichas.exilio_movimiento_motivo
    owner to dba;

create index fichas_exilio_movimiento_motivo_id_exilio_movimiento_index
    on fichas.exilio_movimiento_motivo (id_exilio_movimiento);

create index fichas_exilio_movimiento_motivo_id_motivo_index
    on fichas.exilio_movimiento_motivo (id_motivo);

create table fichas.exilio_movimiento_proteccion
(
    id_exilio_movimiento_proteccion serial                                 not null
        constraint exilio_movimiento_proteccion_pkey
            primary key,
    id_exilio_movimiento            integer                                not null
        constraint fichas_exilio_movimiento_proteccion_id_exilio_movimiento_foreig
            references fichas.exilio_movimiento
            on update cascade on delete cascade,
    id_proteccion                   integer                                not null
        constraint fichas_exilio_movimiento_proteccion_id_proteccion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    created_at                      timestamp(0) default CURRENT_TIMESTAMP not null,
    id_tipo                         integer      default 1
);

comment on column fichas.exilio_movimiento_proteccion.id_tipo is '1:acompañamiento en la salida. 2:en la llegada';

alter table fichas.exilio_movimiento_proteccion
    owner to dba;

create index exilio_movimiento_proteccion_id_tipo_index
    on fichas.exilio_movimiento_proteccion (id_tipo);

create index fichas_exilio_movimiento_proteccion_id_exilio_movimiento_index
    on fichas.exilio_movimiento_proteccion (id_exilio_movimiento);

create index fichas_exilio_movimiento_proteccion_id_proteccion_index
    on fichas.exilio_movimiento_proteccion (id_proteccion);


-- Nueva versión para llenar ficha de hechos
alter table fichas.hecho alter column id_lugar_tipo drop not null;
