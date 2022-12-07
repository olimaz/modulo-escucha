insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (41, 'Tipo de documento de identidad', 'usado en ficha de persona entrevistada', 1);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (42, 'Nacionalidad', 'usado en ficha de persona entrevistada', 1);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (43, 'Estado civil', 'usado en ficha de persona entrevistada', 1);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (44, 'Condición de discapacidad', 'usado en ficha de persona entrevistada', 1);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (45, 'Zona geográfica', 'usado en ficha de persona entrevistada, lugar de residencia', 1);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (46, 'Educación formal', 'usado en ficha de persona entrevistada', 1);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (47, 'Autoridad ético territoria', 'usado en ficha de persona entrevistada', 1);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (48, 'Miembro activo/inactivo', 'usado en ficha de persona entrevistada', 1);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (49, 'Miembro de la fuerza pública', 'usado en ficha de persona entrevistada', 1);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (50, 'Miembro de algún actor armado ilegal', 'usado en ficha de persona entrevistada', 1);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (51, 'Tipo de organización/Sector', 'usado en ficha de persona entrevistada', 1);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (52, 'Relación con la víctima', 'usado en ficha de persona entrevistada', 1);

insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (34, 'Rango (grupo) del presunto responsable individual', 'usado en ficha de presunto responsable individual', 1);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (35, 'Rango (cargo) del presunto responsable individual', 'usado en ficha de presunto responsable individual', 1);
insert into catalogos.cat_cat(id_cat, nombre, descripcion, editable) values (36, 'Presunta responsabilidad responsable individual', 'usado en ficha de presunto responsable individual', 1);



insert into catalogos.cat_item (id_cat,descripcion) values(34,'Grupo paramilitar');
insert into catalogos.cat_item (id_cat,descripcion) values(34,'Grupo paramilitar');
insert into catalogos.cat_item (id_cat,descripcion) values(34,'Guerrilas');
insert into catalogos.cat_item (id_cat,descripcion) values(34,'Fuerza pública');

-- OJO buscar el ID del catalogo 34 para colocarlo en otro
-- paras
insert into catalogos.cat_item (id_cat,descripcion,otro) values(35,'Comandante',0);
insert into catalogos.cat_item (id_cat,descripcion,otro) values(35,'Combatiente',0);
insert into catalogos.cat_item (id_cat,descripcion,otro) values(35,'Urbano',0);
-- guerrilas
insert into catalogos.cat_item (id_cat,descripcion,otro) values(35,'Comandante',0);
insert into catalogos.cat_item (id_cat,descripcion,otro) values(35,'Combatiente',0);
insert into catalogos.cat_item (id_cat,descripcion,otro) values(35,'Miliciano',0);
-- fuerza publica
insert into catalogos.cat_item (id_cat,descripcion,otro) values(35,'Oficial',0);
insert into catalogos.cat_item (id_cat,descripcion,otro) values(35,'Suboficial',0);
insert into catalogos.cat_item (id_cat,descripcion,otro) values(35,'Soldado',0);
-- Responsabilidad
insert into catalogos.cat_cat (id_cat, nombre, descripcion, editable) values (36, 'Responsabilidad en los hechos', 'usado en el inciso 9 de responsable individual', 1);
insert into catalogos.cat_item (id_cat,descripcion) values(36,'La persona ORDENÓ el/los hechos');
insert into catalogos.cat_item (id_cat,descripcion) values(36,'La persona PLANEÓ el/los hechos');
insert into catalogos.cat_item (id_cat,descripcion) values(36,'La persona REALIZÓ el/los hechos');
insert into catalogos.cat_item (id_cat,descripcion) values(36,'La persona PARTICIPÓ el/los hechos');
insert into catalogos.cat_item (id_cat,descripcion) values(36,'La persona NO ACTUÓ PARA EVITAR que se comietieran los hechos');
-- documento de identidad
insert into catalogos.cat_item (id_cat,descripcion) values(41,'CC');
insert into catalogos.cat_item (id_cat,descripcion) values(41,'CE');
insert into catalogos.cat_item (id_cat,descripcion) values(41,'Pasaporte');
insert into catalogos.cat_item (id_cat,descripcion) values(41,'Tarjeta de identidad');
insert into catalogos.cat_item (id_cat,descripcion) values(41,'Sin documento');
-- nacionalidad
insert into catalogos.cat_item (id_cat,descripcion) values(42,'Colombiano/a');
insert into catalogos.cat_item (id_cat,descripcion) values(42,'Peruano/a');
insert into catalogos.cat_item (id_cat,descripcion) values(42,'Ecuatoriano/a');
insert into catalogos.cat_item (id_cat,descripcion) values(42,'Venezolano/a');
insert into catalogos.cat_item (id_cat,descripcion) values(42,'Panameño/a');
-- estado civil
insert into catalogos.cat_item (id_cat,descripcion) values(43,'Casado/a');
insert into catalogos.cat_item (id_cat,descripcion) values(43,'Unión libre');
insert into catalogos.cat_item (id_cat,descripcion) values(43,'Soltero/a');
insert into catalogos.cat_item (id_cat,descripcion) values(43,'Viudo/a');
insert into catalogos.cat_item (id_cat,descripcion) values(43,'Separado/a');
-- Condición de discapacidad
insert into catalogos.cat_item (id_cat,descripcion) values(44,'Física');
insert into catalogos.cat_item (id_cat,descripcion) values(44,'Sensorial');
insert into catalogos.cat_item (id_cat,descripcion) values(44,'Intelectual / cognitiva');
insert into catalogos.cat_item (id_cat,descripcion) values(44,'Psicosocial');
-- Zona geográfica
insert into catalogos.cat_item (id_cat,descripcion) values(45,'Rural');
insert into catalogos.cat_item (id_cat,descripcion) values(45,'Urbana');
-- Educación Formal
insert into catalogos.cat_item (id_cat,descripcion) values(46,'Primaria');
insert into catalogos.cat_item (id_cat,descripcion) values(46,'Bachillerato');
insert into catalogos.cat_item (id_cat,descripcion) values(46,'Técnica');
insert into catalogos.cat_item (id_cat,descripcion) values(46,'Universitaria');
insert into catalogos.cat_item (id_cat,descripcion) values(46,'Ninguna');


-- Autoridades étnico territoriales
insert into catalogos.cat_item (id_cat,descripcion) values(47,'Política (gobernador, presidente de consejo comunitario, sere rromenge, etc.)');
insert into catalogos.cat_item (id_cat,descripcion) values(47,'Espiritual (médico tradicional, partera, etc.)');
-- Miembro de fuerza pública
insert into catalogos.cat_item (id_cat,descripcion) values(48,'Activo');
insert into catalogos.cat_item (id_cat,descripcion) values(48,'Retirado');
-- Miembro de fuerza pública
insert into catalogos.cat_item (id_cat,descripcion) values(49,'Militar');
insert into catalogos.cat_item (id_cat,descripcion) values(49,'Policía');
-- Miembro de fuerza irregular
insert into catalogos.cat_item (id_cat,descripcion) values(50,'Guerrila');
insert into catalogos.cat_item (id_cat,descripcion) values(50,'Paramilitar');
-- Tipos de organización
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Para la defensa y/o promoción de los DDHH');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Víctimas');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Víctimas de un hecho específico (ej. desplazamiento forzado, exilio, etc)');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Mujeres');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'LGBTI');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'N.N.A.');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Jóvenes');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Personas en condición de discapacidad');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Afrocolombiana, negra, raizal o palenquera');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Indígena');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Rrom');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Campesinos');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Sindicalistas');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Movimiento social');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Partido político');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Juntas de acción comunal');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Periodistas');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Agricultores');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Comerciantes');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Ganaderos/as');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Empresarios/as');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Sector salud');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Sector educación');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Religioso');
insert into catalogos.cat_item (id_cat,descripcion) values(51,'Asociación / Cooperativa');
-- Relación con la víctima
insert into catalogos.cat_item (id_cat,descripcion) values(52,'Madre/padre');
insert into catalogos.cat_item (id_cat,descripcion) values(52,'Esposo/a');
insert into catalogos.cat_item (id_cat,descripcion) values(52,'Pareja');
insert into catalogos.cat_item (id_cat,descripcion) values(52,'Hijo/a');
insert into catalogos.cat_item (id_cat,descripcion) values(52,'Hermano/a');
insert into catalogos.cat_item (id_cat,descripcion) values(52,'Abuelo/a');
insert into catalogos.cat_item (id_cat,descripcion) values(52,'Familiar');
insert into catalogos.cat_item (id_cat,descripcion) values(52,'Conocido/a');
insert into catalogos.cat_item (id_cat,descripcion) values(52,'Vecino/a');
insert into catalogos.cat_item (id_cat,descripcion) values(52,'Amigo/a');
insert into catalogos.cat_item (id_cat,descripcion) values(52,'Ninguna');

