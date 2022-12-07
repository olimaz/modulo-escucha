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

alter table catalogos.aa
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

alter table catalogos.tc
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

alter table catalogos.violencia
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
insert into catalogos.violencia (nivel,descripcion,codigo) values(2,'Torutra psicológica','0902');
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
insert into catalogos.cat_item(id_cat,descripcion,orden) values (127,'Opor su condición de liderazgo social',9);
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

--
