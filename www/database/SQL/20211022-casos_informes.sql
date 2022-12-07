-- Crear tabla nueva para registrar las opciones seleccionadas
drop table if exists esclarecimiento.casos_informes_sectores;
create table esclarecimiento.casos_informes_sectores
(
    id_casos_informes_sectores serial
        constraint casos_informes_sectores_pk
            primary key,
    id_casos_informes integer
        constraint casos_informes_sectores_casos_informes_id_casos_informes_fk
            references esclarecimiento.casos_informes
            on update cascade on delete restrict,
    id_item integer
        constraint casos_informes_sectores_cat_item_id_item_fk
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_entrevistador_insert integer
        constraint casos_informes_sectores_entrevistador_id_entrevistador_fk
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    fh_insert timestamp with time zone default now()
);
comment on table esclarecimiento.casos_informes_sectores is 'Normalizacion de sectores incluye';
comment on column esclarecimiento.casos_informes_sectores.id_casos_informes is 'Llave foranea a casos e informes';
comment on column esclarecimiento.casos_informes_sectores.id_item is 'Llave foranea a cat_item, incluye los tres catalogos: actores armados, poblaciones, ocupaciones';
comment on column esclarecimiento.casos_informes_sectores.id_entrevistador_insert is 'Entrevistador que ingresa el dato';
comment on column esclarecimiento.casos_informes_sectores.fh_insert is 'Marca de fecha hora de creación del registro';
alter table esclarecimiento.casos_informes_sectores owner to dba;
create index casos_informes_sectores_id_casos_informes_index
    on esclarecimiento.casos_informes_sectores (id_casos_informes);
create index casos_informes_sectores_id_entrevistador_insert_index
    on esclarecimiento.casos_informes_sectores (id_entrevistador_insert);
create index casos_informes_sectores_id_item_index
    on esclarecimiento.casos_informes_sectores (id_item);

-- Crear los catalogos nuevos
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable, otro_cual) VALUES (190, 'Actores Armados (casos e informes)', 'Normalización de sectores incluidos en Casos e Informes', 1, 2);
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable, otro_cual) VALUES (191, 'Poblaciones (casos e informes)', 'Normalización de sectores incluidos en Casos e Informes', 1, 2);
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable, otro_cual) VALUES (192, 'Ocupaciones (casos e informes)', 'Normalización de sectores incluidos en Casos e Informes', 1, 2);

-- Poblar los catálogos con sus respectivas opciones
-- Actores Armados
delete from catalogos.cat_item where id_cat=190;
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Bandas Criminales - BACRIM');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Carteles de narcotrafico');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos Armados Organizados - GAO');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos Delictivos Organizados - GDO');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos guerrilleros');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos guerrilleros - Coordinadora Guerrillera Simón Bolívar - CGSB');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos guerrilleros - Coordinadora Nacional Guerrillera - CNG');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos guerrilleros - Ejército de Liberación Nacional - ELN');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos guerrilleros - Ejército Popular de Liberación - EPL');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos guerrilleros - Fuerzas Armadas Revolucionarias de Colombia - FARC-EP');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos guerrilleros - Grupo guerrilero Corriente de Renovación Socialista - CRS');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos guerrilleros - Grupo guerrillero Partido Revolucionario de los Trabajadores - PRT');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos guerrilleros - Movimiento 19 de abril - M-19');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos guerrilleros - Movimiento Armado Quintín Lame - MAQL');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos paramilitares');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos paramilitares - Filiación Autodefensas Campesinas de Córdoba y Urabá - ACCU');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos paramilitares - Filiación Autodefensas Campesinas del Magdalena Medio - ACMM');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos paramilitares - Filiación Bloque Central Bolívar - BCB');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos paramilitares - Grupos paramilitares sin filiación ');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos posdesmovilización');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas ilegales - Grupos precursores');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas legales - Comando General de las Fuerzas Militares');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas legales - Comando General de las Fuerzas Militares - Armada de Colombia');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas legales - Comando General de las Fuerzas Militares - Ejército Nacional de Colombia');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas legales - Comando General de las Fuerzas Militares - Fuerza Aérea Colombiana - FAC');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Estructuras armadas legales - Policía Nacional de Colombia');
insert into catalogos.cat_item(id_cat,descripcion) values(190,'Actor no identificado');

-- Poblaciones
delete from catalogos.cat_item where id_cat=191;
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Activista');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Adultos mayores');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Candidatos políticos');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Comunidad palenquera');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Comunidad raizal');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Comunidades campesinas');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Comunidades negras y afrocolombianas');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Culturas urbanas');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Defensores de derechos humanos');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Desmovilizados y excombatientes');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Docentes');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Estudiantes');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Familiares de excombatientes');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Gestores ambientales');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Gestores culturales');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Jueces sin rostro');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Juventud');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Líderes sociales');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Mujeres ');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Niños, niñas y adolescentes');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Población con discapacidad');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Población de Lesbianas, Gays, Bisexuales, Trans e Intersexuales - LGBTI');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Población privada de la libertad');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Presos políticos');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Pueblo Rrom');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Pueblos indígenas');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Religiosos');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Sindicalistas');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Tercero civil');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Víctimas del conflicto armado interno');
insert into catalogos.cat_item(id_cat,descripcion) values(191,'Víctimas del conflicto armado interno - Exiliados');


-- Ocupaciones
delete from catalogos.cat_item where id_cat=192;
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Oficios ilegales');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Oficios ilegales - Contrabandista');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Oficios ilegales - Informante');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Oficios ilegales - Marimbero');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Oficios ilegales - Mercenario');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Oficios ilegales - Procesador de la hoja de coca');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Oficios ilegales - Secuestrador');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Oficios ilegales - Sicario');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Oficios ilegales - Testaferro');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Oficios ilegales - Traficante de armas');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Oficios ilegales - Traficante de drogas');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Abogado');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Académico');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Administrador');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Agricultor');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Agropecuario');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Artesano');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Autoridad étnica');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Autoridad tradicional');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Barequero');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Boticario');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Bracero');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Comerciante');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Conductor');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Empresario');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Esmeraldero');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Estilista');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Funcionarios públicos');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Ganadero');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Gasolinero');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Guardabosques');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Inspector - Inspector de policía');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Jornalero');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Militante político');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Minero');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Periodista');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Pescador');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Político');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Raspachín');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Sacerdote');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Trabajador');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Trabajador - Trabajador comunitario');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Trabajador - Trabajador de oficios rurales');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Trabajador - Trabajador de servicios domésticos');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Trabajador - Trabajador independiente');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Trabajador - Trabajador informal');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Trabajador - Trabajador social');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Trabajador - Trabajadora sexual');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Trabajador de la salud');
insert into catalogos.cat_item(id_cat,descripcion) values(192,'Profesiones y oficios legales - Vendedor');




