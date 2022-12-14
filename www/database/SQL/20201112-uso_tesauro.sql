-- Traza
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (22, 25, 'Uso del tesauro', DEFAULT);


-- Tabla principal
drop table if exists analitica.uso_tesauro;
create table analitica.uso_tesauro
(
    id_uso_tesauro serial not null
        constraint uso_tesauro_pkey
        primary key,
    codigo varchar(20),
    t_00_00_00 integer default 0,
    t_00_01_00 integer default 0,
    t_00_03_00 integer default 0,
    t_00_05_00 integer default 0,
    t_00_06_00 integer default 0,
    t_00_07_00 integer default 0,
    t_00_09_00 integer default 0,
    t_01_00_00 integer default 0,
    t_01_01_00 integer default 0,
    t_01_02_00 integer default 0,
    t_01_03_00 integer default 0,
    t_01_04_00 integer default 0,
    t_01_06_00 integer default 0,
    t_01_07_00 integer default 0,
    t_01_08_00 integer default 0,
    t_01_09_00 integer default 0,
    t_01_09_01 integer default 0,
    t_01_09_02 integer default 0,
    t_01_09_03 integer default 0,
    t_01_09_04 integer default 0,
    t_01_09_05 integer default 0,
    t_01_09_06 integer default 0,
    t_02_00_00 integer default 0,
    t_02_01_00 integer default 0,
    t_02_02_00 integer default 0,
    t_02_03_00 integer default 0,
    t_02_04_00 integer default 0,
    t_02_05_00 integer default 0,
    t_02_06_00 integer default 0,
    t_02_08_00 integer default 0,
    t_03_00_00 integer default 0,
    t_03_01_00 integer default 0,
    t_03_02_00 integer default 0,
    t_03_02_01 integer default 0,
    t_03_02_02 integer default 0,
    t_03_02_03 integer default 0,
    t_03_02_04 integer default 0,
    t_03_02_05 integer default 0,
    t_03_02_06 integer default 0,
    t_03_02_07 integer default 0,
    t_03_03_00 integer default 0,
    t_03_04_00 integer default 0,
    t_03_05_00 integer default 0,
    t_03_06_00 integer default 0,
    t_03_06_01 integer default 0,
    t_03_06_02 integer default 0,
    t_03_06_03 integer default 0,
    t_03_06_04 integer default 0,
    t_03_07_00 integer default 0,
    t_03_08_00 integer default 0,
    t_03_08_01 integer default 0,
    t_03_08_02 integer default 0,
    t_03_08_03 integer default 0,
    t_03_08_04 integer default 0,
    t_03_08_05 integer default 0,
    t_03_08_06 integer default 0,
    t_03_08_07 integer default 0,
    t_03_09_00 integer default 0,
    t_03_09_01 integer default 0,
    t_03_09_02 integer default 0,
    t_03_09_04 integer default 0,
    t_03_09_05 integer default 0,
    t_03_10_00 integer default 0,
    t_03_11_00 integer default 0,
    t_03_12_00 integer default 0,
    t_03_12_01 integer default 0,
    t_03_12_02 integer default 0,
    t_03_12_03 integer default 0,
    t_03_12_04 integer default 0,
    t_03_13_00 integer default 0,
    t_03_13_01 integer default 0,
    t_03_13_02 integer default 0,
    t_03_13_03 integer default 0,
    t_03_13_04 integer default 0,
    t_03_13_06 integer default 0,
    t_03_13_07 integer default 0,
    t_03_14_00 integer default 0,
    t_03_15_00 integer default 0,
    t_04_00_00 integer default 0,
    t_04_01_00 integer default 0,
    t_04_02_00 integer default 0,
    t_04_03_00 integer default 0,
    t_04_04_00 integer default 0,
    t_04_05_00 integer default 0,
    t_04_07_00 integer default 0,
    t_04_07_01 integer default 0,
    t_04_07_02 integer default 0,
    t_04_07_03 integer default 0,
    t_04_08_00 integer default 0,
    t_05_00_00 integer default 0,
    t_05_01_00 integer default 0,
    t_05_02_00 integer default 0,
    t_05_02_01 integer default 0,
    t_05_02_02 integer default 0,
    t_05_03_00 integer default 0,
    t_05_04_00 integer default 0,
    t_05_05_00 integer default 0,
    t_05_07_00 integer default 0,
    t_05_08_00 integer default 0,
    t_05_09_00 integer default 0,
    t_06_00_00 integer default 0,
    t_06_01_00 integer default 0,
    t_06_01_01 integer default 0,
    t_06_02_00 integer default 0,
    t_06_03_00 integer default 0,
    t_06_04_00 integer default 0,
    t_06_05_00 integer default 0,
    t_06_06_00 integer default 0,
    t_07_00_00 integer default 0,
    t_07_01_00 integer default 0,
    t_07_05_00 integer default 0,
    t_07_06_00 integer default 0,
    t_07_07_00 integer default 0,
    t_07_09_00 integer default 0,
    t_07_10_00 integer default 0,
    t_07_11_00 integer default 0,
    t_07_11_04 integer default 0,
    t_07_12_00 integer default 0,
    t_07_13_00 integer default 0,
    t_07_13_01 integer default 0,
    t_07_14_00 integer default 0,
    t_07_15_00 integer default 0,
    t_07_17_00 integer default 0,
    t_07_17_01 integer default 0,
    t_07_17_02 integer default 0,
    t_07_17_03 integer default 0,
    t_07_17_04 integer default 0,
    t_07_18_00 integer default 0,
    t_08_00_00 integer default 0,
    t_08_02_00 integer default 0,
    t_08_03_00 integer default 0,
    t_08_04_00 integer default 0,
    t_08_04_01 integer default 0,
    t_08_04_02 integer default 0,
    t_08_04_03 integer default 0,
    t_08_04_04 integer default 0,
    t_08_04_05 integer default 0,
    t_08_04_06 integer default 0,
    t_08_05_00 integer default 0,
    t_08_06_00 integer default 0,
    t_08_07_00 integer default 0,
    t_08_11_00 integer default 0,
    t_08_11_01 integer default 0,
    t_08_11_02 integer default 0,
    t_08_11_03 integer default 0,
    t_08_11_04 integer default 0,
    t_08_11_05 integer default 0,
    t_08_11_06 integer default 0,
    t_09_00_00 integer default 0,
    t_09_01_00 integer default 0,
    t_09_02_00 integer default 0,
    t_09_03_00 integer default 0,
    t_09_04_00 integer default 0,
    t_09_05_00 integer default 0,
    t_09_06_00 integer default 0,
    t_09_07_00 integer default 0,
    t_10_00_00 integer default 0,
    t_10_01_00 integer default 0,
    t_10_02_00 integer default 0,
    t_10_03_00 integer default 0,
    t_10_04_00 integer default 0,
    t_10_05_00 integer default 0,
    t_10_06_00 integer default 0,
    t_10_07_00 integer default 0,
    t_11_00_00 integer default 0,
    t_11_01_00 integer default 0,
    t_11_01_01 integer default 0,
    t_11_01_02 integer default 0,
    t_11_01_03 integer default 0,
    t_11_02_00 integer default 0,
    t_11_03_00 integer default 0,
    t_11_03_01 integer default 0,
    t_11_03_04 integer default 0,
    t_11_04_00 integer default 0,
    t_11_07_00 integer default 0,
    t_12_00_00 integer default 0,
    t_12_01_00 integer default 0,
    t_12_01_01 integer default 0,
    t_12_01_02 integer default 0,
    t_12_01_03 integer default 0,
    t_12_01_04 integer default 0,
    t_12_01_05 integer default 0,
    t_12_01_06 integer default 0,
    t_12_01_07 integer default 0,
    t_12_01_08 integer default 0,
    t_12_01_09 integer default 0,
    t_12_01_10 integer default 0,
    t_12_01_11 integer default 0,
    t_12_01_12 integer default 0,
    t_12_01_13 integer default 0,
    t_12_01_14 integer default 0,
    t_12_01_15 integer default 0,
    t_12_01_16 integer default 0,
    t_12_01_17 integer default 0,
    t_12_01_18 integer default 0,
    t_12_01_19 integer default 0,
    t_12_01_20 integer default 0,
    t_12_01_21 integer default 0,
    t_12_02_00 integer default 0,
    t_12_02_01 integer default 0,
    t_12_02_02 integer default 0,
    t_12_02_03 integer default 0,
    t_12_02_04 integer default 0,
    t_12_02_05 integer default 0,
    t_12_02_06 integer default 0,
    t_12_02_07 integer default 0,
    t_12_02_11 integer default 0,
    t_12_03_00 integer default 0,
    t_12_03_01 integer default 0,
    t_12_03_02 integer default 0,
    t_12_03_03 integer default 0,
    t_12_03_04 integer default 0,
    t_12_03_05 integer default 0,
    t_12_03_06 integer default 0,
    t_12_03_07 integer default 0,
    t_12_03_08 integer default 0,
    t_12_03_10 integer default 0,
    t_12_03_12 integer default 0,
    t_12_03_13 integer default 0,
    t_12_03_14 integer default 0,
    t_12_04_00 integer default 0,
    t_12_04_01 integer default 0,
    t_12_04_02 integer default 0,
    t_12_04_03 integer default 0,
    t_12_04_04 integer default 0,
    t_12_05_00 integer default 0,
    t_12_06_00 integer default 0,
    t_12_06_02 integer default 0,
    t_12_06_03 integer default 0,
    t_13_00_00 integer default 0,
    t_13_01_00 integer default 0,
    t_13_01_01 integer default 0,
    t_13_01_02 integer default 0,
    t_13_01_03 integer default 0,
    t_13_01_04 integer default 0,
    t_13_01_05 integer default 0,
    t_13_01_06 integer default 0,
    t_13_01_07 integer default 0,
    t_13_01_08 integer default 0,
    t_13_02_00 integer default 0,
    t_13_02_01 integer default 0,
    t_13_02_02 integer default 0,
    t_13_02_03 integer default 0,
    t_13_02_04 integer default 0,
    t_13_02_05 integer default 0,
    t_13_02_06 integer default 0,
    t_13_03_00 integer default 0,
    t_13_03_01 integer default 0,
    t_13_03_02 integer default 0,
    t_13_03_03 integer default 0,
    t_13_03_04 integer default 0,
    t_13_03_05 integer default 0,
    t_13_03_06 integer default 0,
    t_13_04_00 integer default 0,
    t_13_04_01 integer default 0,
    t_13_04_02 integer default 0,
    t_13_04_03 integer default 0,
    t_13_05_00 integer default 0,
    t_13_05_01 integer default 0,
    t_13_05_02 integer default 0,
    t_13_05_03 integer default 0,
    t_13_05_04 integer default 0,
    t_13_06_00 integer default 0,
    t_13_06_01 integer default 0,
    t_13_06_02 integer default 0,
    t_13_08_00 integer default 0,
    t_13_08_01 integer default 0,
    t_13_08_02 integer default 0,
    t_13_08_03 integer default 0,
    t_13_08_04 integer default 0,
    t_13_08_05 integer default 0,
    t_13_08_06 integer default 0,
    t_13_08_07 integer default 0,
    t_13_08_08 integer default 0,
    t_13_08_09 integer default 0,
    t_13_08_10 integer default 0,
    t_13_08_11 integer default 0,
    t_13_08_12 integer default 0,
    t_13_08_13 integer default 0,
    t_13_08_14 integer default 0,
    t_13_08_15 integer default 0,
    t_13_08_16 integer default 0,
    t_13_09_00 integer default 0,
    t_13_09_01 integer default 0,
    t_13_09_02 integer default 0,
    t_13_09_03 integer default 0,
    t_13_09_04 integer default 0,
    t_13_09_05 integer default 0,
    t_13_10_00 integer default 0,
    t_13_10_01 integer default 0,
    t_13_10_03 integer default 0,
    t_13_11_00 integer default 0,
    t_13_11_01 integer default 0,
    t_13_11_02 integer default 0,
    t_13_11_03 integer default 0,
    t_13_12_00 integer default 0,
    t_13_12_01 integer default 0,
    t_13_12_02 integer default 0,
    t_13_12_03 integer default 0,
    t_13_13_00 integer default 0,
    t_13_14_00 integer default 0,
    t_13_15_00 integer default 0,
    t_13_16_00 integer default 0,
    t_13_17_00 integer default 0,
    t_13_18_00 integer default 0,
    t_13_18_01 integer default 0,
    t_13_18_02 integer default 0,
    t_13_18_03 integer default 0,
    t_13_19_00 integer default 0,
    t_13_20_00 integer default 0,
    t_13_21_00 integer default 0,
    t_14_00_00 integer default 0,
    t_14_01_00 integer default 0,
    t_14_02_00 integer default 0,
    t_14_03_00 integer default 0,
    t_14_04_00 integer default 0,
    t_14_05_00 integer default 0,
    t_14_06_00 integer default 0,
    t_14_07_00 integer default 0,
    t_14_08_00 integer default 0,
    t_14_09_00 integer default 0,
    t_14_10_00 integer default 0,
    t_14_11_00 integer default 0,
    t_14_12_00 integer default 0,
    t_15_00_00 integer default 0,
    t_15_01_00 integer default 0,
    t_15_02_00 integer default 0,
    t_15_03_00 integer default 0,
    t_15_04_00 integer default 0,
    t_15_05_00 integer default 0,
    t_15_06_00 integer default 0,
    t_15_07_00 integer default 0,
    t_15_08_00 integer default 0,
    t_15_09_00 integer default 0,
    t_15_10_00 integer default 0,
    t_15_11_00 integer default 0,
    t_15_12_00 integer default 0,
    t_16_00_00 integer default 0,
    t_16_02_00 integer default 0,
    t_16_03_00 integer default 0,
    t_16_04_00 integer default 0,
    t_16_05_00 integer default 0,
    t_17_00_00 integer default 0,
    t_17_01_00 integer default 0,
    t_17_02_00 integer default 0,
    t_17_03_00 integer default 0,
    t_17_04_00 integer default 0,
    t_17_05_00 integer default 0,
    t_17_06_00 integer default 0,
    t_17_07_00 integer default 0,
    t_17_08_00 integer default 0,
    t_17_09_00 integer default 0,
    t_17_10_00 integer default 0,
    t_17_11_00 integer default 0,
    t_17_12_00 integer default 0,
    t_18_00_00 integer default 0,
    t_18_01_00 integer default 0,
    t_18_02_00 integer default 0,
    t_18_02_01 integer default 0,
    t_18_02_02 integer default 0,
    t_18_03_00 integer default 0,
    t_18_04_00 integer default 0,
    t_18_05_00 integer default 0,
    t_18_06_00 integer default 0,
    t_18_07_00 integer default 0,
    t_18_08_00 integer default 0,
    t_19_00_00 integer default 0,
    t_19_01_00 integer default 0,
    t_19_02_00 integer default 0,
    t_19_03_00 integer default 0,
    t_19_04_00 integer default 0,
    t_19_05_00 integer default 0,
    t_19_06_00 integer default 0,
    t_19_07_00 integer default 0,
    t_19_08_00 integer default 0,
    t_19_09_00 integer default 0,
    t_19_10_00 integer default 0,
    t_19_11_00 integer default 0,
    t_20_00_00 integer default 0,
    t_20_02_00 integer default 0,
    t_20_03_00 integer default 0,
    t_20_05_00 integer default 0,
    t_20_06_00 integer default 0,
    t_21_00_00 integer default 0,
    t_21_02_00 integer default 0,
    t_21_03_00 integer default 0,
    t_21_04_00 integer default 0,
    t_21_05_00 integer default 0,
    t_21_06_00 integer default 0,
    t_21_07_00 integer default 0,
    t_21_08_00 integer default 0,
    t_21_09_00 integer default 0,
    conteo_etiquetas integer default 0,
    fh_insert timestamp default now()

);
alter table analitica.uso_tesauro owner to dba;
grant select on analitica.uso_tesauro to solo_lectura;

create index uso_tesauro_codigoindex
    on analitica.uso_tesauro (codigo);

comment on table analitica.uso_tesauro is 'Aplicacion de etiquetas por testimonio';
comment on column analitica.uso_tesauro.t_00_00_00 is 'Entidades';
comment on column analitica.uso_tesauro.t_00_01_00 is 'Entidades - Fecha';
comment on column analitica.uso_tesauro.t_00_03_00 is 'Entidades - Divipola/Sitios/regiones';
comment on column analitica.uso_tesauro.t_00_05_00 is 'Entidades - Personas';
comment on column analitica.uso_tesauro.t_00_06_00 is 'Entidades - Organizaciones';
comment on column analitica.uso_tesauro.t_00_07_00 is 'Entidades - Armas';
comment on column analitica.uso_tesauro.t_00_09_00 is 'Entidades - Roles y poblaciones';
comment on column analitica.uso_tesauro.t_01_00_00 is 'N1 Democracia';
comment on column analitica.uso_tesauro.t_01_01_00 is 'N1 Democracia - Violencia Pol??tica y represi??n a la protesta social';
comment on column analitica.uso_tesauro.t_01_02_00 is 'N1 Democracia - Conflictos Patrones Trabajadores';
comment on column analitica.uso_tesauro.t_01_03_00 is 'N1 Democracia - Conflicto Servicios P??blicos';
comment on column analitica.uso_tesauro.t_01_04_00 is 'N1 Democracia - Conflictos Defensa DD HH DIH';
comment on column analitica.uso_tesauro.t_01_06_00 is 'N1 Democracia - Discriminaci??n Genero LGBTI';
comment on column analitica.uso_tesauro.t_01_07_00 is 'N1 Democracia - Conflictos Representaci??n Pol??tica';
comment on column analitica.uso_tesauro.t_01_08_00 is 'N1 Democracia - Conflictos Resoluci??n Guerra';
comment on column analitica.uso_tesauro.t_01_09_00 is 'N1 Democracia - Relac Pol??tica y Actores Armados';
comment on column analitica.uso_tesauro.t_01_09_01 is 'N1 Democracia - Relac Pol??tica y Actores Armados - Influencia Electoral';
comment on column analitica.uso_tesauro.t_01_09_02 is 'N1 Democracia - Relac Pol??tica y Actores Armados - Participaci??n Directa';
comment on column analitica.uso_tesauro.t_01_09_03 is 'N1 Democracia - Relac Pol??tica y Actores Armados - Alianza Afinidad';
comment on column analitica.uso_tesauro.t_01_09_04 is 'N1 Democracia - Relac Pol??tica y Actores Armados - Influen Organizacional Socio Politica';
comment on column analitica.uso_tesauro.t_01_09_05 is 'N1 Democracia - Relac Pol??tica y Actores Armados - Descrip ??lites Regionales';
comment on column analitica.uso_tesauro.t_01_09_06 is 'N1 Democracia - Relac Pol??tica y Actores Armados - Reparto Cargos Servi P??blicos';
comment on column analitica.uso_tesauro.t_02_00_00 is 'N2 Estado';
comment on column analitica.uso_tesauro.t_02_01_00 is 'N2 Estado - Judicializaci??n';
comment on column analitica.uso_tesauro.t_02_02_00 is 'N2 Estado - Omisi??n Estado Frente Grupos Armados';
comment on column analitica.uso_tesauro.t_02_03_00 is 'N2 Estado - Actuaci??n Conjunta Estado Actores Armados';
comment on column analitica.uso_tesauro.t_02_04_00 is 'N2 Estado - Militarizaci??n Territorio';
comment on column analitica.uso_tesauro.t_02_05_00 is 'N2 Estado - Impunidad';
comment on column analitica.uso_tesauro.t_02_06_00 is 'N2 Estado - Violen Funcionarios Estado';
comment on column analitica.uso_tesauro.t_02_08_00 is 'N2 Estado - Abandono estatal';
comment on column analitica.uso_tesauro.t_03_00_00 is 'N3 Actores';
comment on column analitica.uso_tesauro.t_03_01_00 is 'N3 Actores - Origen Actores Armados';
comment on column analitica.uso_tesauro.t_03_02_00 is 'N3 Actores - Din??micas Espaciales Actores Armados';
comment on column analitica.uso_tesauro.t_03_02_01 is 'N3 Actores - Din??micas Espaciales Actores Armados  - Incursi??n';
comment on column analitica.uso_tesauro.t_03_02_02 is 'N3 Actores - Din??micas Espaciales Actores Armados  - Expansi??n';
comment on column analitica.uso_tesauro.t_03_02_03 is 'N3 Actores - Din??micas Espaciales Actores Armados  - Disputa';
comment on column analitica.uso_tesauro.t_03_02_04 is 'N3 Actores - Din??micas Espaciales Actores Armados  - Asentamiento';
comment on column analitica.uso_tesauro.t_03_02_05 is 'N3 Actores - Din??micas Espaciales Actores Armados  - Repliegue';
comment on column analitica.uso_tesauro.t_03_02_06 is 'N3 Actores - Din??micas Espaciales Actores Armados  - Cambios Oorganizaci??n Grupos Armados';
comment on column analitica.uso_tesauro.t_03_02_07 is 'N3 Actores - Din??micas Espaciales Actores Armados  - Relaci??n Actores Armados';
comment on column analitica.uso_tesauro.t_03_03_00 is 'N3 Actores - Desarme Desmov. Desvinc.';
comment on column analitica.uso_tesauro.t_03_04_00 is 'N3 Actores - Experiencia Posdesmovilizaci??n';
comment on column analitica.uso_tesauro.t_03_05_00 is 'N3 Actores - Vida Familiar Comunitaria Excombatientes';
comment on column analitica.uso_tesauro.t_03_06_00 is 'N3 Actores - Estructura Organizativa';
comment on column analitica.uso_tesauro.t_03_06_01 is 'N3 Actores - Estructura Organizativa - Organigrama';
comment on column analitica.uso_tesauro.t_03_06_02 is 'N3 Actores - Estructura Organizativa - Perfiles de miembros';
comment on column analitica.uso_tesauro.t_03_06_03 is 'N3 Actores - Estructura Organizativa - Descripcion de roles';
comment on column analitica.uso_tesauro.t_03_06_04 is 'N3 Actores - Estructura Organizativa - Asenso y degradacion';
comment on column analitica.uso_tesauro.t_03_07_00 is 'N3 Actores - Contexto previo a vinculacion';
comment on column analitica.uso_tesauro.t_03_08_00 is 'N3 Actores - Vida intrafilas';
comment on column analitica.uso_tesauro.t_03_08_01 is 'N3 Actores - Vida intrafilas - Modalidades ingreso';
comment on column analitica.uso_tesauro.t_03_08_02 is 'N3 Actores - Vida intrafilas - Reglas dentro del grupo';
comment on column analitica.uso_tesauro.t_03_08_03 is 'N3 Actores - Vida intrafilas - Sanciones y castigos a combatientes';
comment on column analitica.uso_tesauro.t_03_08_04 is 'N3 Actores - Vida intrafilas - Incentivos intrafilas';
comment on column analitica.uso_tesauro.t_03_08_05 is 'N3 Actores - Vida intrafilas - Vida cotidiana al interior del grupo';
comment on column analitica.uso_tesauro.t_03_08_06 is 'N3 Actores - Vida intrafilas - Relaciones afectivas';
comment on column analitica.uso_tesauro.t_03_08_07 is 'N3 Actores - Vida intrafilas - Violencias intrafilas';
comment on column analitica.uso_tesauro.t_03_09_00 is 'N3 Actores - Entrenamiento y formaci??n';
comment on column analitica.uso_tesauro.t_03_09_01 is 'N3 Actores - Entrenamiento y formaci??n - Proceso de formaci??n pol??tica/ideol??gica';
comment on column analitica.uso_tesauro.t_03_09_02 is 'N3 Actores - Entrenamiento y formaci??n - Proceso de entenamiento militar y de inteligencia';
comment on column analitica.uso_tesauro.t_03_09_04 is 'N3 Actores - Entrenamiento y formaci??n - Otros procesos de formaci??n';
comment on column analitica.uso_tesauro.t_03_09_05 is 'N3 Actores - Entrenamiento y formaci??n - Entrenamiento en Salud';
comment on column analitica.uso_tesauro.t_03_10_00 is 'N3 Actores - Percepciones de si mismos y otros';
comment on column analitica.uso_tesauro.t_03_11_00 is 'N3 Actores - Percepcion de los civiles';
comment on column analitica.uso_tesauro.t_03_12_00 is 'N3 Actores - Accionar del AA';
comment on column analitica.uso_tesauro.t_03_12_01 is 'N3 Actores - Accionar del AA - Acciones b??licas';
comment on column analitica.uso_tesauro.t_03_12_02 is 'N3 Actores - Accionar del AA - T??cticas de inteligencia/contrainteligencia';
comment on column analitica.uso_tesauro.t_03_12_03 is 'N3 Actores - Accionar del AA - Patrullaje y registro';
comment on column analitica.uso_tesauro.t_03_12_04 is 'N3 Actores - Accionar del AA - Retenes';
comment on column analitica.uso_tesauro.t_03_13_00 is 'N3 Actores - Control a poblacion civil';
comment on column analitica.uso_tesauro.t_03_13_01 is 'N3 Actores - Control a poblacion civil - Regulaci??n de la vida social y comunitaria';
comment on column analitica.uso_tesauro.t_03_13_02 is 'N3 Actores - Control a poblacion civil - Regulaci??n econ??mica';
comment on column analitica.uso_tesauro.t_03_13_03 is 'N3 Actores - Control a poblacion civil - Estrategias de legitimaci??n de los grupos armados';
comment on column analitica.uso_tesauro.t_03_13_04 is 'N3 Actores - Control a poblacion civil - Normas a la poblaci??n civil';
comment on column analitica.uso_tesauro.t_03_13_06 is 'N3 Actores - Control a poblacion civil - Sanciones y castigos a la poblaci??n';
comment on column analitica.uso_tesauro.t_03_13_07 is 'N3 Actores - Control a poblacion civil - Enamoramiento o seducci??n';
comment on column analitica.uso_tesauro.t_03_14_00 is 'N3 Actores - Deserci??n';
comment on column analitica.uso_tesauro.t_03_15_00 is 'N3 Actores - Falsa desmovilizaci??n';
comment on column analitica.uso_tesauro.t_04_00_00 is 'N41 Econom??a';
comment on column analitica.uso_tesauro.t_04_01_00 is 'N41 Econom??a - Megaproyectos';
comment on column analitica.uso_tesauro.t_04_02_00 is 'N41 Econom??a - Economias ilegales';
comment on column analitica.uso_tesauro.t_04_03_00 is 'N41 Econom??a - Cambios en uso de suelo';
comment on column analitica.uso_tesauro.t_04_04_00 is 'N41 Econom??a - Conflictos por la tierra';
comment on column analitica.uso_tesauro.t_04_05_00 is 'N41 Econom??a - Relaciones AA y TC';
comment on column analitica.uso_tesauro.t_04_07_00 is 'N41 Econom??a - Vida campesina y conflicto armado';
comment on column analitica.uso_tesauro.t_04_07_01 is 'N41 Econom??a - Vida campesina y conflicto armado - Econom??a campesina';
comment on column analitica.uso_tesauro.t_04_07_02 is 'N41 Econom??a - Vida campesina y conflicto armado - Identidad campesina y v??nculo con el territorio';
comment on column analitica.uso_tesauro.t_04_07_03 is 'N41 Econom??a - Vida campesina y conflicto armado - Formas sociales y organizaciones campesinas';
comment on column analitica.uso_tesauro.t_04_08_00 is 'N41 Econom??a - Relaci??n del conflicto con el medio ambiente';
comment on column analitica.uso_tesauro.t_05_00_00 is 'N42 Despojo';
comment on column analitica.uso_tesauro.t_05_01_00 is 'N42 Despojo - Causas del desplazamiento/abandono/confinamiento';
comment on column analitica.uso_tesauro.t_05_02_00 is 'N42 Despojo - Din??micas urbanas del despojo y el desplazamiento';
comment on column analitica.uso_tesauro.t_05_02_01 is 'N42 Despojo - Din??micas urbanas del despojo y el desplazamiento - Desplazamiento intraurbano';
comment on column analitica.uso_tesauro.t_05_02_02 is 'N42 Despojo - Din??micas urbanas del despojo y el desplazamiento - Despojo urbano';
comment on column analitica.uso_tesauro.t_05_03_00 is 'N42 Despojo - Medios y participantes que act??an en el despojo';
comment on column analitica.uso_tesauro.t_05_04_00 is 'N42 Despojo - Procesos de recuperaci??n de tierras';
comment on column analitica.uso_tesauro.t_05_05_00 is 'N42 Despojo - Solicitud de adjudicaci??n de tierras';
comment on column analitica.uso_tesauro.t_05_07_00 is 'N42 Despojo - Retorno y reasentamiento';
comment on column analitica.uso_tesauro.t_05_08_00 is 'N42 Despojo - Revictimizaci??n en el proceso de reclamaci??n de tierras o retorno';
comment on column analitica.uso_tesauro.t_05_09_00 is 'N42 Despojo - Generaci??n de conflictos como efecto de las medidas de restituci??n de tierras';
comment on column analitica.uso_tesauro.t_06_00_00 is 'N5 Narcotrafico';
comment on column analitica.uso_tesauro.t_06_01_00 is 'N5 Narcotrafico - Cultivo il??cito';
comment on column analitica.uso_tesauro.t_06_01_01 is 'N5 Narcotrafico - Cultivo il??cito - Formas y din??micas de producci??n';
comment on column analitica.uso_tesauro.t_06_02_00 is 'N5 Narcotrafico - Procesamiento tr??fico';
comment on column analitica.uso_tesauro.t_06_03_00 is 'N5 Narcotrafico - Dineros il??citos';
comment on column analitica.uso_tesauro.t_06_04_00 is 'N5 Narcotrafico - Consumo drogas';
comment on column analitica.uso_tesauro.t_06_05_00 is 'N5 Narcotrafico - Impacto narcotr??fico';
comment on column analitica.uso_tesauro.t_06_06_00 is 'N5 Narcotrafico - Impactos culturales del narcotr??fico';
comment on column analitica.uso_tesauro.t_07_00_00 is 'N7 Pueblos ??tnicos';
comment on column analitica.uso_tesauro.t_07_01_00 is 'N7 Pueblos ??tnicos - Racismo discriminaci??n';
comment on column analitica.uso_tesauro.t_07_05_00 is 'N7 Pueblos ??tnicos - Economias extractivas';
comment on column analitica.uso_tesauro.t_07_06_00 is 'N7 Pueblos ??tnicos - Uso personas econom??a ilegal';
comment on column analitica.uso_tesauro.t_07_07_00 is 'N7 Pueblos ??tnicos - Tensiones hoja coca';
comment on column analitica.uso_tesauro.t_07_09_00 is 'N7 Pueblos ??tnicos - Asignaci??n recursos';
comment on column analitica.uso_tesauro.t_07_10_00 is 'N7 Pueblos ??tnicos - Rel Estado y ??tnicos';
comment on column analitica.uso_tesauro.t_07_11_00 is 'N7 Pueblos ??tnicos - Militarizaci??n';
comment on column analitica.uso_tesauro.t_07_11_04 is 'N7 Pueblos ??tnicos - Militarizaci??n - Presencia MAPP-MUSE';
comment on column analitica.uso_tesauro.t_07_12_00 is 'N7 Pueblos ??tnicos - Procesos colonizaci??n';
comment on column analitica.uso_tesauro.t_07_13_00 is 'N7 Pueblos ??tnicos - Relaciones inter??tnicas';
comment on column analitica.uso_tesauro.t_07_13_01 is 'N7 Pueblos ??tnicos - Relaciones inter??tnicas - Conflictos inter??tnicos';
comment on column analitica.uso_tesauro.t_07_14_00 is 'N7 Pueblos ??tnicos - Din??micas entre fronteras territoriales y pueblos ??tnicos';
comment on column analitica.uso_tesauro.t_07_15_00 is 'N7 Pueblos ??tnicos - Exterminio';
comment on column analitica.uso_tesauro.t_07_17_00 is 'N7 Pueblos ??tnicos - Derechos';
comment on column analitica.uso_tesauro.t_07_17_01 is 'N7 Pueblos ??tnicos - Derechos - Posesi??n uso';
comment on column analitica.uso_tesauro.t_07_17_02 is 'N7 Pueblos ??tnicos - Derechos - Acceso y relaciones';
comment on column analitica.uso_tesauro.t_07_17_03 is 'N7 Pueblos ??tnicos - Derechos - Recuperaci??n';
comment on column analitica.uso_tesauro.t_07_17_04 is 'N7 Pueblos ??tnicos - Derechos - Restituci??n';
comment on column analitica.uso_tesauro.t_07_18_00 is 'N7 Pueblos ??tnicos - Tensiones identitarias';
comment on column analitica.uso_tesauro.t_08_00_00 is 'N81 Exilio';
comment on column analitica.uso_tesauro.t_08_02_00 is 'N81 Exilio - Trayectorias y Reasentamientos';
comment on column analitica.uso_tesauro.t_08_03_00 is 'N81 Exilio - Violencia';
comment on column analitica.uso_tesauro.t_08_04_00 is 'N81 Exilio - Estatus migratorio';
comment on column analitica.uso_tesauro.t_08_04_01 is 'N81 Exilio - Estatus migratorio - Con protecci??n internacional';
comment on column analitica.uso_tesauro.t_08_04_02 is 'N81 Exilio - Estatus migratorio - Solicitante protecci??n internacional';
comment on column analitica.uso_tesauro.t_08_04_03 is 'N81 Exilio - Estatus migratorio - Otros';
comment on column analitica.uso_tesauro.t_08_04_04 is 'N81 Exilio - Estatus migratorio - Programas protecci??n';
comment on column analitica.uso_tesauro.t_08_04_05 is 'N81 Exilio - Estatus migratorio - Migrantes irregulares';
comment on column analitica.uso_tesauro.t_08_04_06 is 'N81 Exilio - Estatus migratorio - Deportaci??n';
comment on column analitica.uso_tesauro.t_08_05_00 is 'N81 Exilio - Pol??ticas';
comment on column analitica.uso_tesauro.t_08_06_00 is 'N81 Exilio - Institucionalidad';
comment on column analitica.uso_tesauro.t_08_07_00 is 'N81 Exilio - Retorno';
comment on column analitica.uso_tesauro.t_08_11_00 is 'N81 Exilio - Relaciones cultura de acogida';
comment on column analitica.uso_tesauro.t_08_11_01 is 'N81 Exilio - Relaciones cultura de acogida - Apat??a a Colombia';
comment on column analitica.uso_tesauro.t_08_11_02 is 'N81 Exilio - Relaciones cultura de acogida - Estigmatizaci??n y discriminaci??n';
comment on column analitica.uso_tesauro.t_08_11_03 is 'N81 Exilio - Relaciones cultura de acogida - Cambio identitario';
comment on column analitica.uso_tesauro.t_08_11_04 is 'N81 Exilio - Relaciones cultura de acogida - Cambio cultural';
comment on column analitica.uso_tesauro.t_08_11_05 is 'N81 Exilio - Relaciones cultura de acogida - P??rdida estatus';
comment on column analitica.uso_tesauro.t_08_11_06 is 'N81 Exilio - Relaciones cultura de acogida - Desarraigo';
comment on column analitica.uso_tesauro.t_09_00_00 is 'N82 Dim. Internacionales';
comment on column analitica.uso_tesauro.t_09_01_00 is 'N82 Dim. Internacionales - Cooperaci??n internacional';
comment on column analitica.uso_tesauro.t_09_02_00 is 'N82 Dim. Internacionales - Apoyo pol??tico actores conflicto';
comment on column analitica.uso_tesauro.t_09_03_00 is 'N82 Dim. Internacionales - Violencias';
comment on column analitica.uso_tesauro.t_09_04_00 is 'N82 Dim. Internacionales - Presencia b??lica';
comment on column analitica.uso_tesauro.t_09_05_00 is 'N82 Dim. Internacionales - Apoyo militar actores armados';
comment on column analitica.uso_tesauro.t_09_06_00 is 'N82 Dim. Internacionales - Acciones armadas';
comment on column analitica.uso_tesauro.t_09_07_00 is 'N82 Dim. Internacionales - Instituciones fronterizas';
comment on column analitica.uso_tesauro.t_10_00_00 is 'N9 Cultura';
comment on column analitica.uso_tesauro.t_10_01_00 is 'N9 Cultura - Discursos iglesias';
comment on column analitica.uso_tesauro.t_10_02_00 is 'N9 Cultura - Discursos sistema educativo';
comment on column analitica.uso_tesauro.t_10_03_00 is 'N9 Cultura - Discursos medios';
comment on column analitica.uso_tesauro.t_10_04_00 is 'N9 Cultura - Afectaciones';
comment on column analitica.uso_tesauro.t_10_05_00 is 'N9 Cultura - Transformaciones sobre lugares de valor cultural';
comment on column analitica.uso_tesauro.t_10_06_00 is 'N9 Cultura - Cambios formas de ver al otro';
comment on column analitica.uso_tesauro.t_10_07_00 is 'N9 Cultura - Transformaciones identidad';
comment on column analitica.uso_tesauro.t_11_00_00 is 'Salud';
comment on column analitica.uso_tesauro.t_11_01_00 is 'Salud - Actividades sanitarias';
comment on column analitica.uso_tesauro.t_11_01_01 is 'Salud - Actividades sanitarias - Prevenci??n en salud o saneamiento ambiental';
comment on column analitica.uso_tesauro.t_11_01_02 is 'Salud - Actividades sanitarias - Salud sexual y reproductiva';
comment on column analitica.uso_tesauro.t_11_01_03 is 'Salud - Actividades sanitarias - Atenci??n en salud';
comment on column analitica.uso_tesauro.t_11_02_00 is 'Salud - Infracciones contra bienes protegidos en salud';
comment on column analitica.uso_tesauro.t_11_03_00 is 'Salud - Infracciones a la misi??n m??dica';
comment on column analitica.uso_tesauro.t_11_03_01 is 'Salud - Infracciones a la misi??n m??dica - Infracciones contra la actividad sanitaria';
comment on column analitica.uso_tesauro.t_11_03_04 is 'Salud - Infracciones a la misi??n m??dica - Actos de perfidia';
comment on column analitica.uso_tesauro.t_11_04_00 is 'Salud - Cooptaci??n de recursos de salud por actores armados';
comment on column analitica.uso_tesauro.t_11_07_00 is 'Salud - Sanidad Civil Por Actor Armado';
comment on column analitica.uso_tesauro.t_12_00_00 is 'Impactos';
comment on column analitica.uso_tesauro.t_12_01_00 is 'Impactos - Impact Emoc Salud Mental Fisica';
comment on column analitica.uso_tesauro.t_12_01_01 is 'Impactos - Impact Emoc Salud Mental Fisica - EnfermedadesDa??osCuerpo';
comment on column analitica.uso_tesauro.t_12_01_02 is 'Impactos - Impact Emoc Salud Mental Fisica - Discapacidad';
comment on column analitica.uso_tesauro.t_12_01_03 is 'Impactos - Impact Emoc Salud Mental Fisica - Rabia';
comment on column analitica.uso_tesauro.t_12_01_04 is 'Impactos - Impact Emoc Salud Mental Fisica - Tristeza';
comment on column analitica.uso_tesauro.t_12_01_05 is 'Impactos - Impact Emoc Salud Mental Fisica - Miedo';
comment on column analitica.uso_tesauro.t_12_01_06 is 'Impactos - Impact Emoc Salud Mental Fisica - Desesperanza';
comment on column analitica.uso_tesauro.t_12_01_07 is 'Impactos - Impact Emoc Salud Mental Fisica - Desarraigo';
comment on column analitica.uso_tesauro.t_12_01_08 is 'Impactos - Impact Emoc Salud Mental Fisica - Dificultades mentales';
comment on column analitica.uso_tesauro.t_12_01_09 is 'Impactos - Impact Emoc Salud Mental Fisica - uso de sustancias psicoactivas';
comment on column analitica.uso_tesauro.t_12_01_10 is 'Impactos - Impact Emoc Salud Mental Fisica - A la salud sexual y reproductiva';
comment on column analitica.uso_tesauro.t_12_01_11 is 'Impactos - Impact Emoc Salud Mental Fisica - Baja autoestima y violencia contra s?? mismo.';
comment on column analitica.uso_tesauro.t_12_01_12 is 'Impactos - Impact Emoc Salud Mental Fisica - Resentimiento';
comment on column analitica.uso_tesauro.t_12_01_13 is 'Impactos - Impact Emoc Salud Mental Fisica - Odio';
comment on column analitica.uso_tesauro.t_12_01_14 is 'Impactos - Impact Emoc Salud Mental Fisica - Culpa';
comment on column analitica.uso_tesauro.t_12_01_15 is 'Impactos - Impact Emoc Salud Mental Fisica - Estigmatizaci??n';
comment on column analitica.uso_tesauro.t_12_01_16 is 'Impactos - Impact Emoc Salud Mental Fisica - Impotencia';
comment on column analitica.uso_tesauro.t_12_01_17 is 'Impactos - Impact Emoc Salud Mental Fisica - Desconfianza';
comment on column analitica.uso_tesauro.t_12_01_18 is 'Impactos - Impact Emoc Salud Mental Fisica - Aislamiento';
comment on column analitica.uso_tesauro.t_12_01_19 is 'Impactos - Impact Emoc Salud Mental Fisica - Suicidio';
comment on column analitica.uso_tesauro.t_12_01_20 is 'Impactos - Impact Emoc Salud Mental Fisica - Autocensura';
comment on column analitica.uso_tesauro.t_12_01_21 is 'Impactos - Impact Emoc Salud Mental Fisica - Marginaci??n y segregaci??n';
comment on column analitica.uso_tesauro.t_12_02_00 is 'Impactos - Impacto Familiares';
comment on column analitica.uso_tesauro.t_12_02_01 is 'Impactos - Impacto Familiares - Estructura familiar';
comment on column analitica.uso_tesauro.t_12_02_02 is 'Impactos - Impacto Familiares - En las relaciones y  arreglos de g??nero';
comment on column analitica.uso_tesauro.t_12_02_03 is 'Impactos - Impacto Familiares - Cambios economicos y materiales';
comment on column analitica.uso_tesauro.t_12_02_04 is 'Impactos - Impacto Familiares - Cambios en los planes de vida';
comment on column analitica.uso_tesauro.t_12_02_05 is 'Impactos - Impacto Familiares - Cambios en las costumbres y tradiciones';
comment on column analitica.uso_tesauro.t_12_02_06 is 'Impactos - Impacto Familiares - desestructuracion familiar';
comment on column analitica.uso_tesauro.t_12_02_07 is 'Impactos - Impacto Familiares - Impactos transmitidos a las siguientes generaciones';
comment on column analitica.uso_tesauro.t_12_02_11 is 'Impactos - Impacto Familiares - P??rdida de autonom??a y dificultad en la toma de decisiones';
comment on column analitica.uso_tesauro.t_12_03_00 is 'Impactos - Impactos Comunitarios o Colectivos';
comment on column analitica.uso_tesauro.t_12_03_01 is 'Impactos - Impactos Comunitarios o Colectivos - Perdida de pr??cticas y saberes culturales';
comment on column analitica.uso_tesauro.t_12_03_02 is 'Impactos - Impactos Comunitarios o Colectivos - Deterioro y/o ruptura del tejido social';
comment on column analitica.uso_tesauro.t_12_03_03 is 'Impactos - Impactos Comunitarios o Colectivos - Incremento de las conflictividades, violencias y/o deshumanizaci??n de la vida';
comment on column analitica.uso_tesauro.t_12_03_04 is 'Impactos - Impactos Comunitarios o Colectivos - ruptura de procesos organizativos';
comment on column analitica.uso_tesauro.t_12_03_05 is 'Impactos - Impactos Comunitarios o Colectivos - Silencio';
comment on column analitica.uso_tesauro.t_12_03_06 is 'Impactos - Impactos Comunitarios o Colectivos - desconfianza colectiva';
comment on column analitica.uso_tesauro.t_12_03_07 is 'Impactos - Impactos Comunitarios o Colectivos - ruptura de practicas cotidianas';
comment on column analitica.uso_tesauro.t_12_03_08 is 'Impactos - Impactos Comunitarios o Colectivos - impactos en liderazgos colectivos';
comment on column analitica.uso_tesauro.t_12_03_10 is 'Impactos - Impactos Comunitarios o Colectivos - clima emocional del terror.';
comment on column analitica.uso_tesauro.t_12_03_12 is 'Impactos - Impactos Comunitarios o Colectivos - Naturalizaci??n de la violencia e indiferencia';
comment on column analitica.uso_tesauro.t_12_03_13 is 'Impactos - Impactos Comunitarios o Colectivos - Espiritual';
comment on column analitica.uso_tesauro.t_12_03_14 is 'Impactos - Impactos Comunitarios o Colectivos - Autodeterminaci??n y autonom??a';
comment on column analitica.uso_tesauro.t_12_04_00 is 'Impactos - Impacto Terrestre';
comment on column analitica.uso_tesauro.t_12_04_01 is 'Impactos - Impacto Terrestre - Perdidas materiales y  econ??micas';
comment on column analitica.uso_tesauro.t_12_04_02 is 'Impactos - Impacto Terrestre - Destruccion del territorio y naturaleza';
comment on column analitica.uso_tesauro.t_12_04_03 is 'Impactos - Impacto Terrestre - Transformaci??n del paisaje';
comment on column analitica.uso_tesauro.t_12_04_04 is 'Impactos - Impacto Terrestre - Transformaci??n de los usos y relaciones con el territorio';
comment on column analitica.uso_tesauro.t_12_05_00 is 'Impactos - Impacto DESCA';
comment on column analitica.uso_tesauro.t_12_06_00 is 'Impactos - Impacto Democracia';
comment on column analitica.uso_tesauro.t_12_06_02 is 'Impactos - Impacto Democracia - Afectaciones a libertad de prensa';
comment on column analitica.uso_tesauro.t_12_06_03 is 'Impactos - Impacto Democracia - Afectaci??n a derechos electorales';
comment on column analitica.uso_tesauro.t_13_00_00 is 'Hechos';
comment on column analitica.uso_tesauro.t_13_01_00 is 'Hechos - Homicidio';
comment on column analitica.uso_tesauro.t_13_01_01 is 'Hechos - Homicidio - Ejecucion Extrajudicial Arbitraria';
comment on column analitica.uso_tesauro.t_13_01_02 is 'Hechos - Homicidio - Ejecucion Extrajudicial Falso Positivo';
comment on column analitica.uso_tesauro.t_13_01_03 is 'Hechos - Homicidio - Masacre';
comment on column analitica.uso_tesauro.t_13_01_04 is 'Hechos - Homicidio - Muerte Discriminacion Prejuicio';
comment on column analitica.uso_tesauro.t_13_01_05 is 'Hechos - Homicidio - Muerte Civiles Combate';
comment on column analitica.uso_tesauro.t_13_01_06 is 'Hechos - Homicidio - Muerte Civiles Bombas';
comment on column analitica.uso_tesauro.t_13_01_07 is 'Hechos - Homicidio - Muerte Civiles Esplosivos';
comment on column analitica.uso_tesauro.t_13_01_08 is 'Hechos - Homicidio - Muerte Civiles Ataques Bienes Civiles';
comment on column analitica.uso_tesauro.t_13_02_00 is 'Hechos - Atentado A la Vida';
comment on column analitica.uso_tesauro.t_13_02_01 is 'Hechos - Atentado A la Vida - Herido Atentado';
comment on column analitica.uso_tesauro.t_13_02_02 is 'Hechos - Atentado A la Vida - Victima Sin Lesiones';
comment on column analitica.uso_tesauro.t_13_02_03 is 'Hechos - Atentado A la Vida - Civil Heridos Combate';
comment on column analitica.uso_tesauro.t_13_02_04 is 'Hechos - Atentado A la Vida - Civiles Heridos Bombas';
comment on column analitica.uso_tesauro.t_13_02_05 is 'Hechos - Atentado A la Vida - Civiles Heridos Esplosivos';
comment on column analitica.uso_tesauro.t_13_02_06 is 'Hechos - Atentado A la Vida - Civiles Ataques Bienes Civiles';
comment on column analitica.uso_tesauro.t_13_03_00 is 'Hechos - Amenaza a la Vida';
comment on column analitica.uso_tesauro.t_13_03_01 is 'Hechos - Amenaza a la Vida - Amenaza Verbal';
comment on column analitica.uso_tesauro.t_13_03_02 is 'Hechos - Amenaza a la Vida - Amenaza Llamada Telefonica';
comment on column analitica.uso_tesauro.t_13_03_03 is 'Hechos - Amenaza a la Vida - Amenaza Correo Electronico o redes sociales';
comment on column analitica.uso_tesauro.t_13_03_04 is 'Hechos - Amenaza a la Vida - Amenaza Familiar Amigos';
comment on column analitica.uso_tesauro.t_13_03_05 is 'Hechos - Amenaza a la Vida - Amenza Seguimiento';
comment on column analitica.uso_tesauro.t_13_03_06 is 'Hechos - Amenaza a la Vida - Amenaza Panfleto carta o sufragio';
comment on column analitica.uso_tesauro.t_13_04_00 is 'Hechos - Exterminio';
comment on column analitica.uso_tesauro.t_13_04_01 is 'Hechos - Exterminio - Genocidio';
comment on column analitica.uso_tesauro.t_13_04_02 is 'Hechos - Exterminio - Apologia Genocidio';
comment on column analitica.uso_tesauro.t_13_04_03 is 'Hechos - Exterminio - Exterminio Social';
comment on column analitica.uso_tesauro.t_13_05_00 is 'Hechos - Desaparici??n forzada';
comment on column analitica.uso_tesauro.t_13_05_01 is 'Hechos - Desaparici??n forzada - Desaparic Selectiva';
comment on column analitica.uso_tesauro.t_13_05_02 is 'Hechos - Desaparici??n forzada - Desaparic Encubridora';
comment on column analitica.uso_tesauro.t_13_05_03 is 'Hechos - Desaparici??n forzada - Desaparic Medio Intimidacion';
comment on column analitica.uso_tesauro.t_13_05_04 is 'Hechos - Desaparici??n forzada - Fosas Comunes';
comment on column analitica.uso_tesauro.t_13_06_00 is 'Hechos - Tortura y otros tratos crueles';
comment on column analitica.uso_tesauro.t_13_06_01 is 'Hechos - Tortura y otros tratos crueles - Tortura Fisica';
comment on column analitica.uso_tesauro.t_13_06_02 is 'Hechos - Tortura y otros tratos crueles - Tortura Psicologica';
comment on column analitica.uso_tesauro.t_13_08_00 is 'Hechos - Violencias sexuales';
comment on column analitica.uso_tesauro.t_13_08_01 is 'Hechos - Violencias sexuales - Empalamiento';
comment on column analitica.uso_tesauro.t_13_08_02 is 'Hechos - Violencias sexuales - Anticoncep Estirilizacion Forzada';
comment on column analitica.uso_tesauro.t_13_08_03 is 'Hechos - Violencias sexuales - Aborto Forzado';
comment on column analitica.uso_tesauro.t_13_08_04 is 'Hechos - Violencias sexuales - Explotacion Sexual';
comment on column analitica.uso_tesauro.t_13_08_05 is 'Hechos - Violencias sexuales - Esclavitud Sexual';
comment on column analitica.uso_tesauro.t_13_08_06 is 'Hechos - Violencias sexuales - Obligacion Ver Actos Sexuales';
comment on column analitica.uso_tesauro.t_13_08_07 is 'Hechos - Violencias sexuales - Obligacion Actos Sexuales';
comment on column analitica.uso_tesauro.t_13_08_08 is 'Hechos - Violencias sexuales - Violacion Sexual';
comment on column analitica.uso_tesauro.t_13_08_09 is 'Hechos - Violencias sexuales - Prostitucion Forzada';
comment on column analitica.uso_tesauro.t_13_08_10 is 'Hechos - Violencias sexuales - Embarazo Forzado';
comment on column analitica.uso_tesauro.t_13_08_11 is 'Hechos - Violencias sexuales - Tortura en Embarazo';
comment on column analitica.uso_tesauro.t_13_08_12 is 'Hechos - Violencias sexuales - Maternidad Crianza Forzada';
comment on column analitica.uso_tesauro.t_13_08_13 is 'Hechos - Violencias sexuales - Desnudez Forzada';
comment on column analitica.uso_tesauro.t_13_08_14 is 'Hechos - Violencias sexuales - Mutilacion Organos Sexuales';
comment on column analitica.uso_tesauro.t_13_08_15 is 'Hechos - Violencias sexuales - Cambios en Cuerpo';
comment on column analitica.uso_tesauro.t_13_08_16 is 'Hechos - Violencias sexuales - Acoso sexual';
comment on column analitica.uso_tesauro.t_13_09_00 is 'Hechos - Reclutamiento NNA';
comment on column analitica.uso_tesauro.t_13_09_01 is 'Hechos - Reclutamiento NNA - Utilizacion Acciones Belicas';
comment on column analitica.uso_tesauro.t_13_09_02 is 'Hechos - Reclutamiento NNA - Utilizacion Vigilacia Inteligencia';
comment on column analitica.uso_tesauro.t_13_09_03 is 'Hechos - Reclutamiento NNA - Utilizacion Logisticas Administrativas';
comment on column analitica.uso_tesauro.t_13_09_04 is 'Hechos - Reclutamiento NNA - Utilizacion Narcotrafico';
comment on column analitica.uso_tesauro.t_13_09_05 is 'Hechos - Reclutamiento NNA - Amenaza Reclutamiento';
comment on column analitica.uso_tesauro.t_13_10_00 is 'Hechos - Detenci??n arbitraria';
comment on column analitica.uso_tesauro.t_13_10_01 is 'Hechos - Detenci??n arbitraria - Detencion Sin Orden';
comment on column analitica.uso_tesauro.t_13_10_03 is 'Hechos - Detenci??n arbitraria - Detencion Cumplimiento Pena';
comment on column analitica.uso_tesauro.t_13_11_00 is 'Hechos - Secuestro/toma de rehenes';
comment on column analitica.uso_tesauro.t_13_11_01 is 'Hechos - Secuestro/toma de rehenes - Secuestro Extorsivo';
comment on column analitica.uso_tesauro.t_13_11_02 is 'Hechos - Secuestro/toma de rehenes - Secuestro Politico';
comment on column analitica.uso_tesauro.t_13_11_03 is 'Hechos - Secuestro/toma de rehenes - Secuestro Simple';
comment on column analitica.uso_tesauro.t_13_12_00 is 'Hechos - Confinamiento';
comment on column analitica.uso_tesauro.t_13_12_01 is 'Hechos - Confinamiento - Confina Individual';
comment on column analitica.uso_tesauro.t_13_12_02 is 'Hechos - Confinamiento - Confina Familiar';
comment on column analitica.uso_tesauro.t_13_12_03 is 'Hechos - Confinamiento - Confina Colectivo';
comment on column analitica.uso_tesauro.t_13_13_00 is 'Hechos - Pillaje';
comment on column analitica.uso_tesauro.t_13_14_00 is 'Hechos - Extorsi??n';
comment on column analitica.uso_tesauro.t_13_15_00 is 'Hechos - Ataque a bien protegido';
comment on column analitica.uso_tesauro.t_13_16_00 is 'Hechos - Ataque indiscriminado';
comment on column analitica.uso_tesauro.t_13_17_00 is 'Hechos - Despojo/abandono de tierras';
comment on column analitica.uso_tesauro.t_13_18_00 is 'Hechos - Desplazamiento forzado';
comment on column analitica.uso_tesauro.t_13_18_01 is 'Hechos - Desplazamiento forzado - Desplazam Individual';
comment on column analitica.uso_tesauro.t_13_18_02 is 'Hechos - Desplazamiento forzado - Desplazam Familiar';
comment on column analitica.uso_tesauro.t_13_18_03 is 'Hechos - Desplazamiento forzado - Desplazam Masivo';
comment on column analitica.uso_tesauro.t_13_19_00 is 'Hechos - Exilio';
comment on column analitica.uso_tesauro.t_13_20_00 is 'Hechos - Trabajos o servicios forzados';
comment on column analitica.uso_tesauro.t_13_21_00 is 'Hechos - Limpieza social';
comment on column analitica.uso_tesauro.t_14_00_00 is 'Afrontamientos';
comment on column analitica.uso_tesauro.t_14_01_00 is 'Afrontamientos - Personales';
comment on column analitica.uso_tesauro.t_14_02_00 is 'Afrontamientos - Familiares';
comment on column analitica.uso_tesauro.t_14_03_00 is 'Afrontamientos - Redes apoyo';
comment on column analitica.uso_tesauro.t_14_04_00 is 'Afrontamientos - Pr??cticas art??sticas';
comment on column analitica.uso_tesauro.t_14_05_00 is 'Afrontamientos - Espiritualidad';
comment on column analitica.uso_tesauro.t_14_06_00 is 'Afrontamientos - Actividad f??sica';
comment on column analitica.uso_tesauro.t_14_07_00 is 'Afrontamientos - Enfrentar violento';
comment on column analitica.uso_tesauro.t_14_08_00 is 'Afrontamientos - Silencio';
comment on column analitica.uso_tesauro.t_14_09_00 is 'Afrontamientos - Alimentaci??n';
comment on column analitica.uso_tesauro.t_14_10_00 is 'Afrontamientos - Descarga emocional';
comment on column analitica.uso_tesauro.t_14_11_00 is 'Afrontamientos - Costumbres tradiciones';
comment on column analitica.uso_tesauro.t_14_12_00 is 'Afrontamientos - Asimilaci??n o adaptaci??n';
comment on column analitica.uso_tesauro.t_15_00_00 is 'Resistencia';
comment on column analitica.uso_tesauro.t_15_01_00 is 'Resistencia - Campesinado';
comment on column analitica.uso_tesauro.t_15_02_00 is 'Resistencia - Estrategias resistencia ??tnica';
comment on column analitica.uso_tesauro.t_15_03_00 is 'Resistencia - Movimiento cocalero';
comment on column analitica.uso_tesauro.t_15_04_00 is 'Resistencia - Organizaciones v??ctimas';
comment on column analitica.uso_tesauro.t_15_05_00 is 'Resistencia - Defensa ambiente';
comment on column analitica.uso_tesauro.t_15_06_00 is 'Resistencia - Acciones formativas';
comment on column analitica.uso_tesauro.t_15_07_00 is 'Resistencia - Espacio p??blico';
comment on column analitica.uso_tesauro.t_15_08_00 is 'Resistencia - Pactos convivencia paz';
comment on column analitica.uso_tesauro.t_15_09_00 is 'Resistencia - Art??sticos deportivos';
comment on column analitica.uso_tesauro.t_15_10_00 is 'Resistencia - Apoyo psicosocial';
comment on column analitica.uso_tesauro.t_15_11_00 is 'Resistencia - Apoyo legal';
comment on column analitica.uso_tesauro.t_15_12_00 is 'Resistencia - Construcci??n paz';
comment on column analitica.uso_tesauro.t_16_00_00 is 'Pol??ticas Internacionales';
comment on column analitica.uso_tesauro.t_16_02_00 is 'Pol??ticas Internacionales - Pol??ticas econ??micas';
comment on column analitica.uso_tesauro.t_16_03_00 is 'Pol??ticas Internacionales - Pol??ticas seguridad defensa';
comment on column analitica.uso_tesauro.t_16_04_00 is 'Pol??ticas Internacionales - Pol??ticas antidrogas';
comment on column analitica.uso_tesauro.t_16_05_00 is 'Pol??ticas Internacionales - Pol??ticas derechos humanos';
comment on column analitica.uso_tesauro.t_17_00_00 is 'Estigmatizaci??n';
comment on column analitica.uso_tesauro.t_17_01_00 is 'Estigmatizaci??n - Estigmatizaci??n familias';
comment on column analitica.uso_tesauro.t_17_02_00 is 'Estigmatizaci??n - Estigmatizaci??n pol??tica';
comment on column analitica.uso_tesauro.t_17_03_00 is 'Estigmatizaci??n - Construcci??n enemigo';
comment on column analitica.uso_tesauro.t_17_04_00 is 'Estigmatizaci??n - Colaborador';
comment on column analitica.uso_tesauro.t_17_05_00 is 'Estigmatizaci??n - Razones ??tnico-raciales';
comment on column analitica.uso_tesauro.t_17_06_00 is 'Estigmatizaci??n - Razones g??nero';
comment on column analitica.uso_tesauro.t_17_07_00 is 'Estigmatizaci??n - Razones clase';
comment on column analitica.uso_tesauro.t_17_08_00 is 'Estigmatizaci??n - Discapacidad';
comment on column analitica.uso_tesauro.t_17_09_00 is 'Estigmatizaci??n - Ciclo vital';
comment on column analitica.uso_tesauro.t_17_10_00 is 'Estigmatizaci??n - Territorial';
comment on column analitica.uso_tesauro.t_17_11_00 is 'Estigmatizaci??n - Geograf??as racializadas';
comment on column analitica.uso_tesauro.t_17_12_00 is 'Estigmatizaci??n - Econom??a drogas il??citas';
comment on column analitica.uso_tesauro.t_18_00_00 is 'No Repetici??n';
comment on column analitica.uso_tesauro.t_18_01_00 is 'No Repetici??n - R Educaci??n';
comment on column analitica.uso_tesauro.t_18_02_00 is 'No Repetici??n - R Estado';
comment on column analitica.uso_tesauro.t_18_02_01 is 'No Repetici??n - R Estado - Militarizaci??n';
comment on column analitica.uso_tesauro.t_18_02_02 is 'No Repetici??n - R Estado - Fuerza P??blica';
comment on column analitica.uso_tesauro.t_18_03_00 is 'No Repetici??n - R DESCA';
comment on column analitica.uso_tesauro.t_18_04_00 is 'No Repetici??n - R Reintegraci??n excombatientes';
comment on column analitica.uso_tesauro.t_18_05_00 is 'No Repetici??n - Reincidencia actores armados';
comment on column analitica.uso_tesauro.t_18_06_00 is 'No Repetici??n - Transformaciones culturales';
comment on column analitica.uso_tesauro.t_18_07_00 is 'No Repetici??n - R Drogas il??citas narcotr??fico';
comment on column analitica.uso_tesauro.t_18_08_00 is 'No Repetici??n - Desactivaci??n de minas';
comment on column analitica.uso_tesauro.t_19_00_00 is 'Pol??ticas p??blicas';
comment on column analitica.uso_tesauro.t_19_01_00 is 'Pol??ticas p??blicas - Seguridad y defensa Estado';
comment on column analitica.uso_tesauro.t_19_02_00 is 'Pol??ticas p??blicas - Agrarias';
comment on column analitica.uso_tesauro.t_19_03_00 is 'Pol??ticas p??blicas - V??ctimas';
comment on column analitica.uso_tesauro.t_19_04_00 is 'Pol??ticas p??blicas - Educaci??n';
comment on column analitica.uso_tesauro.t_19_05_00 is 'Pol??ticas p??blicas - Salud';
comment on column analitica.uso_tesauro.t_19_06_00 is 'Pol??ticas p??blicas - Ambientales';
comment on column analitica.uso_tesauro.t_19_07_00 is 'Pol??ticas p??blicas - D Institucionales ??tnicos';
comment on column analitica.uso_tesauro.t_19_08_00 is 'Pol??ticas p??blicas - Construcci??n paz';
comment on column analitica.uso_tesauro.t_19_09_00 is 'Pol??ticas p??blicas - Cultura';
comment on column analitica.uso_tesauro.t_19_10_00 is 'Pol??ticas p??blicas - Econ??micas';
comment on column analitica.uso_tesauro.t_19_11_00 is 'Pol??ticas p??blicas - Contra el narcotr??fico';
comment on column analitica.uso_tesauro.t_20_00_00 is 'Proceso de paz';
comment on column analitica.uso_tesauro.t_20_02_00 is 'Proceso de paz - Cambios institucionales';
comment on column analitica.uso_tesauro.t_20_03_00 is 'Proceso de paz - Cambios sociales';
comment on column analitica.uso_tesauro.t_20_05_00 is 'Proceso de paz - Reacciones';
comment on column analitica.uso_tesauro.t_20_06_00 is 'Proceso de paz - Apoyos internacionales';
comment on column analitica.uso_tesauro.t_21_00_00 is 'Transfronterizas';
comment on column analitica.uso_tesauro.t_21_02_00 is 'Transfronterizas - Desplazamiento forzado transfonterizo';
comment on column analitica.uso_tesauro.t_21_03_00 is 'Transfronterizas - Tr??fico personas';
comment on column analitica.uso_tesauro.t_21_04_00 is 'Transfronterizas - Tr??fico il??cito armas';
comment on column analitica.uso_tesauro.t_21_05_00 is 'Transfronterizas - Contrabando';
comment on column analitica.uso_tesauro.t_21_06_00 is 'Transfronterizas - D Pueblos ??tnicos binacionales';
comment on column analitica.uso_tesauro.t_21_07_00 is 'Transfronterizas - D armadas';
comment on column analitica.uso_tesauro.t_21_08_00 is 'Transfronterizas - D Instituciones estatales';
comment on column analitica.uso_tesauro.t_21_09_00 is 'Transfronterizas - Tr??nsitos y retornos pendulares';




