create table sim.etiqueta
(
	id_etiqueta serial
		constraint etiqueta_pk
			primary key,
	etiqueta varchar(200) not null
);
alter table sim.etiqueta owner to dba;

comment on table sim.etiqueta is 'Etiquetas utilizadas en data turk';

create unique index etiqueta_etiqueta_uindex
	on sim.etiqueta (etiqueta);

--
drop table if exists sim.etiqueta_entrevista;
create table sim.etiqueta_entrevista
(
	id_etiqueta_entrevista serial,
	id_etiqueta int not null
		constraint etiqueta_entrevista_etiqueta_id_etiqueta_fk
			references sim.etiqueta
				on update cascade on delete cascade,
	id_entrevista int not null,
	id_subserie int not null
		constraint etiqueta_entrevista_cat_item_id_item_fk
			references catalogos.cat_item
				on update restrict on delete restrict,
	texto text,
	del int,
	al int
);



alter table sim.etiqueta_entrevista owner to dba;

comment on table sim.etiqueta_entrevista is 'Etiquetas marcadas en cada entrevsista';

comment on column sim.etiqueta_entrevista.id_entrevista is 'Llave primaria, según tipo de entrevista';

comment on column sim.etiqueta_entrevista.id_subserie is 'Permite determinar el tipo de entrevista (consultar cat_item)';

comment on column sim.etiqueta_entrevista.texto is 'Texto marcado';

comment on column sim.etiqueta_entrevista.del is 'Posición inicial dentro de la transcripción';

comment on column sim.etiqueta_entrevista.al is 'Posición final dentro de la transcripción';

create index etiqueta_entrevista_id_entrevista_index
	on sim.etiqueta_entrevista (id_entrevista);

create index etiqueta_entrevista_id_etiqueta_index
	on sim.etiqueta_entrevista (id_etiqueta);

create index etiqueta_entrevista_id_subserie_index
	on sim.etiqueta_entrevista (id_subserie);

---
drop table if exists catalogos.tesauro;
create table catalogos.tesauro
(
    id_geo           serial              not null
        constraint tesauro_pk
            primary key,
    id_padre         integer,
    nivel            integer   default 0 not null,
    descripcion      text       not null,
    id_tipo          integer,
    codigo           varchar(10),
    etiqueta        varchar(200),
    etiqueta_completa text,
    id_etiqueta     integer
);

comment on table catalogos.tesauro is 'Tesauro del sistema';

alter table catalogos.tesauro
    owner to dba;

create index tesauro_codigo_index
	on catalogos.tesauro (codigo);

create index tesauro_etiqueta_index
	on catalogos.tesauro (etiqueta);

create index tesauro_id_padre_index
	on catalogos.tesauro (id_padre);

create index tesauro_nivel_index
	on catalogos.tesauro (nivel);

create index tesauro_id_etiqueta_index
	on catalogos.tesauro (id_etiqueta);

create index tesauro_etiqueta_completa_index
    on catalogos.tesauro (etiqueta_completa);







--  Campos para grabar transcripción y etiquetado
alter table esclarecimiento.e_ind_fvt
	add html_transcripcion text;

alter table esclarecimiento.e_ind_fvt
	add json_etiquetado text;


--
drop index catalogos.tesauro_id_etiqueta_index;

create unique index tesauro_id_etiqueta_uindex
	on catalogos.tesauro (id_etiqueta);


-- TESAURO
delete from catalogos.tesauro where true;
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Entidades',1,'000000','Entidades');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Núcleo 1. Democracia y conflicto armado',1,'010000','N1 Democracia');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Núcleo 2. El Estado y sus responsabilidades en el conflicto armado',1,'020000','N2 Estado');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Nucleo 3. Actores armados y otros participantes en las dinámicas de la guerra',1,'030000','N3 Actores');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Núcleo 4. Economía y modelos de desarrollo y conflicto armado interno',1,'040000','N4 Economía');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Núcleo 5. Despojo de tierras y desplazamiento forzado',1,'050000','N5 Despojo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Núcleo 6. Narcotráfico y conflicto armado',1,'060000','N6 Narcotrafico');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Núcleo 8. Causas, dinámicas e impactos del conflicto armado sobre los pueblos y territorios étnicos',1,'070000','N8 Causas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Núcleo 9.1. Exilio',1,'080000','N91 Exilio');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Núcleo 9.2. Dimensiones internacionales del conflicto',1,'090000','N92 Dim. Internacionales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Núcleo 10. Conflicto armado, sociedad y cultura',1,'100000','N10 Cultura');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Dominio temático de salud y misión médica',1,'110000','Salud');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Dominio tranversal 1. Impactos',1,'120000','Impactos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Dominio transversal 2. Hechos victimizantes',1,'130000','Hechos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Dominio transversal 3: Afrontamientos y resistencias no violentas -cotidianas',1,'140000','Afrontamientos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Dominio transversal 4: Resistencias organizadas ',1,'150000','Resistencia');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Dominio transversal 5. Políticas internacionales',1,'160000','Políticas Internacionales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Dominio transversal 6. Estereotipos y Estigmatización',1,'170000','Estigmatización');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Dominio transversal 7. Recomendaciones para la no repetición',1,'180000','No Repetición');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Dominio transversal 8.  Desarrollos institucionales y Políticas públicas',1,'190000','Políticas públicas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Dominio transversal 9. Procesos de Paz',1,'200000','Proceso de paz');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'Dominio transversal 10. Dinámicas transfronterizas',1,'210000','Transfronterizas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Violencia política',1,'010100','Violencia Política');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Conflictos entre patrones y trabajadores',1,'010200','Conflictos Patrones Trabajadores');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Conflicto por acceso a servicios públicos',1,'010300','Conflicto Servicios Públicos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Conflictos por la Defensa de DD. HH.-DIH',1,'010400','Conflictos Defensa DD HH DIH');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Represión de la protesta social ',1,'010500','Represión Protesta Social');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Discriminación en participación política contra colectivos por género o LGBTI',1,'010600','Discriminación Genero LGBTI');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Conflictos por los procesos de representación política ',1,'010700','Conflictos Representación Política');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Conflictos respecto a la resolución de la guerra',1,'010800','Conflictos Resolución Guerra');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Relación entre política y actores armados',1,'010900','Relac Política y Actores Armados');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Influencia electoral',1,'010901','Influencia Electoral');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Participación directa',1,'010902','Participación Directa');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Alianza o afinidad',1,'010903','Alianza Afinidad ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Influencia en la organizacion social o política',1,'010904','Influen Organizacional Socio Politica');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Descripción de élites regionales',1,'010905','Descrip Élites Regionales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Reparto de cargos o servicios públicos',1,'010906','Reparto Cargos Servi Públicos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Judicialización',1,'020100','Judicialización ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Inicio de investigación contra una persona',1,'020101','Inicio Invest A Una Persona ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Montajes judiciales',1,'020102','Montajes Judiciales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Allanamiento o requisas',1,'020103','Allanamiento Requisas ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Omisión Estado Frente Grupos Armados ',1,'020200','Omisión Estado Frente Grupos Armados ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Actuación Conjunta Estado Actores Armados ',1,'020300','Actuación Conjunta Estado Actores Armados ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Militarización Territorio ',1,'020400','Militarización Territorio ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Impunidad ',1,'020500','Impunidad ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Alianzas entre el sector judicial y los actores armados',1,'020501','Alianzas Sector Judicial y Actores Armados ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Cooptación de la justicia por parte de actores armados',1,'020502','Cooptación Justicia Actores Armados ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Beneficios privados indebidos a cambio de direccionar decisiones judiciales',1,'020503','Beneficios Por Direccionar Decisiones Judiciales  ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Obstáculos para presentar denuncias, seguir o impulsar los procesos judiciales',1,'020504','Obstaculos Denuncias y Procesos Judiciales ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Falta de confianza en la imparcialidad del órgano judicial',1,'020505','Falta Confianza Organo Judicial');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Miedo a las consecuencias por denunciar',1,'020506','Miedo a Denunciar ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Represalias por denunciar',1,'020507','Represalias por Denunciar ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Dilación del proceso',1,'020508','Dilación del Proceso ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Alteración o afectación de información y pruebas',1,'020509','Alteración Información Pruebas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Falta de sanción',1,'020510','Falta de Sanción ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Violencia contra funcionarios judiciales',1,'020600','Violen Funcionarios Judiciales ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Violencia contra funcionarios públicos ',1,'020700','Violen Funcionarios Públicos ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Orígenes de los actores armados',1,'030100','Origen Actores Armados ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Dinámicas espaciales de los actores armados',1,'030200','Dinámicas Espaciales Actores Armados ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Incursión',1,'030201','Incursión');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Expansión',1,'030202','Expansión');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Disputa',1,'030203','Disputa');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Asentamiento',1,'030204','Asentamiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Repliegue',1,'030205','Repliegue');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Cambios en la organización de los grupos armados',1,'030206','Cambios Oorganización Grupos Armados');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Relaciones de otros actores armados con la fuerza pública',1,'030207','Relación Actores Armados y Fuerza Pública ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Desarme, Desmovilización, Desvinculación, Reintegración / Reincorporación',1,'030300','Desarme Desmov. Desvinc.');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Experiencia de vida posdesmovilización',1,'030400','Experiencia Posdesmovilización ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Vida familiar y comunitaria de los excombatientes',1,'030500','Vida Familiar Comunitaria Excombatientes');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Estructura organizativa',1,'030600','Estructura Organizativa');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Organigrama',1,'030601','Organigrama');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Perfiles individuales de los comandantes o miembros representativos del grupo',1,'030602','Perfiles de miembros');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Descripción de roles y de la jerarquía',1,'030603','Descripcion de roles');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Ascenso y degradación en el grupo armado',1,'030604','Asenso y degradacion');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Contexto de vida previo a la vinculación de combatientes',1,'030700','Contexto previo a vinculacion');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Vida intrafilas',1,'030800','Vida intrafilas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Modalidades o motivo de ingreso',1,'030801','Modalidades ingreso');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Reglas dentro del grupo',1,'030802','Reglas dentro del grupo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Sanciones y castigos a combatientes',1,'030803','Sanciones y castigos a combatientes');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Incentivos intrafilas',1,'030804','Incentivos intrafilas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Vida cotidiana al interior del grupo',1,'030805','Vida cotidiana al interior del grupo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Relaciones afectivas',1,'030806','Relaciones afectivas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Violencias intrafilas',1,'030807','Violencias intrafilas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Control interno simbolico y de relaciones entre pares ',1,'030808','Control interno simbolico');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Obediencia ',1,'030809','Obediencia ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Entrenamiento y formación',1,'030900','Entrenamiento y formacioni');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Proceso de formación política/ideológica',1,'030901','Proceso de formación política/ideológica');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Proceso de entenamiento militar y de inteligencia',1,'030902','Proceso de entenamiento militar y de inteligencia');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Otros procesos de formación',1,'030904','Otros procesos de formación');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Percepciones que los actores armados tienen sobre otros/as o sobre sí mismos',1,'031000','Percepciones de si mismos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Ideas que los actores armados tienen sobre los civiles',1,'031001','Ideas que los actores armados tienen sobre los civiles');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Ideas que los actores armados tienen sobre sus enemigos/as',1,'031002','Ideas que los actores armados tienen sobre sus enemigos/as');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Ideas que los actores armados tienen sobre sus aliados/as',1,'031003','Ideas que los actores armados tienen sobre sus aliados/as');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Ideas que los actores armados tienen sobre sí mismos/as',1,'031004','Ideas que los actores armados tienen sobre sí mismos/as');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Percepciones de la población civil sobre los actores armados',1,'031100','Percepcion de los civiles');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Accionar de los actores armados',1,'031200','Accionar del AA');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Acciones bélicas',1,'031201','Acciones bélicas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Tácticas de inteligencia/contrainteligencia',1,'031202','Tácticas de inteligencia/contrainteligencia');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Patrullaje y registro',1,'031203','Patrullaje y registro');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Retenes',1,'031204','Retenes');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Control y orden social a población civil',1,'031300','Control a poblacion civil');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Regulación de la vida social y comunitaria',1,'031301','Regulación de la vida social y comunitaria');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Regulación económica',1,'031302','Regulación económica');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Estrategias de legitimación de los grupos armados',1,'031303','Estrategias de legitimación de los grupos armados');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Normas a la población civil',1,'031304','Normas a la población civil');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Órdenes y escenarios de terror ',1,'031305','Órdenes y escenarios de terror ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Sanciones y castigos a la población',1,'031306','Sanciones y castigos a la población');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Megaproyectos',1,'040100','Megaproyectos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Infraestructura',1,'040101','Infraestructura');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Minero-energético',1,'040102','Minero-energético');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Agroindustrial',1,'040103','Agroindustrial');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Economías ilegales (distintas al narcotráfico)',1,'040200','Economias ilegales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Cambios en el uso del suelo y tenencia de la tierra',1,'040300','Cambios en uso de suelo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Conflictos por la tierra',1,'040400','Conflictos por la tierra');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Relaciones entre el actor económico y el grupo armado',1,'040500','Relaciones AA y TC');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Acuerdos ',1,'040502','Acuerdos ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Víctima',1,'040503','Víctima');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Para obtener servicios de seguridad',1,'040504','Para obtener servicios de seguridad');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Para cometer grandes violaciones a los derechos humanos',1,'040505','Para cometer grandes violaciones a los derechos humanos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Financiamiento de actores económicos a grupos armados',1,'040600','Financiamiento de actores económicos a grupos armados');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Por coacción',1,'040601','Por coacción');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Voluntario o por interés',1,'040602','Voluntario o por interés');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Vida campesina y conflicto armado',1,'040700','Vida campesina y conflicto armado');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Economía campesina',1,'040701','Economía campesina');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Identidad campesina',1,'040702','Identidad campesina');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Formas sociales y organizaciones campesinas',1,'040703','Formas sociales y organizaciones campesinas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Vínculo con el territorio',1,'040704','Vínculo con el territorio');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Relación del conflicto con el medio ambiente',1,'040800','Relación del conflicto con el medio ambiente');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Regulación ambiental',1,'040801','Regulación ambiental');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Naturaleza como escenario del conflicto armado',1,'040802','Naturaleza como escenario del conflicto armado');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Causas del desplazamiento/abandono/confinamiento',1,'050100','Causas del desplazamiento/abandono/confinamiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Por accionar de actores armados',1,'050101','Por accionar de actores armados');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Por políticas antidrogas contra cultivos ilícitos',1,'050102','Por políticas antidrogas contra cultivos ilícitos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Por desarrollo de proyectos económicos',1,'050103','Por desarrollo de proyectos económicos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Por narcotráfico',1,'050104','Por narcotráfico');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Dinámicas urbanas del despojo y el desplazamiento',1,'050200','Dinámicas urbanas del despojo y el desplazamiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Desplazamiento intraurbano',1,'050201','Desplazamiento intraurbano');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Despojo urbano',1,'050202','Despojo urbano');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Reasentamiento en casco urbano',1,'050203','Reasentamiento en casco urbano');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Medios utilizados para el despojo',1,'050300','Medios utilizados para el despojo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Despojo por medios violentos',1,'050301','Despojo por medios violentos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Despojo con o sin uso de figuras jurídicas',1,'050302','Despojo con o sin uso de figuras jurídicas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Reasignación de tierras',1,'050303','Reasignación de tierras');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Procesos de recuperación de tierras',1,'050400','Procesos de recuperación de tierras');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Solicitud de adjudicación de tierras',1,'050500','Solicitud de adjudicación de tierras');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Terceros participantes en el despojo y sus actuaciones',1,'050600','Terceros participantes en el despojo y sus actuaciones');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Retorno y reasentamiento en zona rural',1,'050700','Retorno y reasentamiento en zona rural');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Revictimización en el proceso de reclamación de tierras o retorno',1,'050800','Revictimización en el proceso de reclamación de tierras o retorno');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Generación de conflictos como efecto de las medidas de restitución de tierras',1,'050900','Generación de conflictos como efecto de las medidas de restitución de tierras');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Cultivos de uso ilícito',1,'060100','Cultivo ilícito');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Formas de producción',1,'060101','Forma producción');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Dinámicas del cultivo',1,'060102','Dinámica cultivo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Acuerdos, reglas y órdenes de regulación',1,'060103','Acuerdos regulación ');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Estrategias de reducción del cultivos de uso ilícito',1,'060105','Estrategía reducción cultivo');


insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Procesamiento secundario, tráfico y microtráfico',1,'060200','Procesamiento tráfico');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Medios y dinámicas de transporte',1,'060201','Medios transporte');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Acuerdos, reglas y órdenes',1,'060202','Acuerdos y reglas');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Estrategias contra el tráfico',1,'060204','Estrategia tráfico');


insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Dineros ilícitos',1,'060300','Dineros ilícitos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Captación, legalización y uso de los dineros ilícitos',1,'060301','Captación ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Acuerdos/reglas',1,'060302','Acuerdos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Estrategias del Estado frente a los dineros ilícitos',1,'060303','Estrategia Estado ');


insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Consumo de drogas',1,'060400','Consumo drogas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Formas de consumo',1,'060401','Formas consumo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Acuerdos o reglas',1,'060402','Acuerdos');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Estrategias frente al consumo',1,'060404','Estrategías consumo ');


insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Impacto político del narcotráfico ',1,'060500','Impacto narcotráfico');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Institucionales ',1,'060501','Institucionales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Legales',1,'060502','Legales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Ejercicio del poder',1,'060503','Ejercicio poder');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Impactos culturales del narcotráfico',1,'060600','Impactos culturales del narcotráfico');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Racismo y discriminación étnico-racial',1,'070100','Racismo discriminación');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Racismo institucional',1,'070101','Racismo institucional');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Formas de relacionamiento',1,'070102','Formas relacionamiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Discriminación por prácticas culturales',1,'070103','Discriminación Cultural');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Referencias históricas',1,'070104','Referencias históricas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Exclusión y segregación étnico-racial',1,'070105','Exclusión segregación');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Tensiones identitarias',1,'070106','Tensiones identitarias');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Abandono de territorios étnicos',1,'070200','Abandono ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Confinamiento de pueblos étnicos',1,'070300','Confinamiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Desplazamiento étnico',1,'070400','Desplazamiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Economías extractivas en territorios étnicos',1,'070500','Economias extractivas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Uso de personas pertenecientes a los pueblos étnicos en economías ilegales',1,'070600','Uso personas economía ilegal');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Trata',1,'070601','Trata');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Narcotráfico',1,'070602','Narcotráfico');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Contrabando',1,'070603','Contrabando');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Tensiones por el uso de la hoja de coca',1,'070700','Tensiones hoja coca');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Precarización',1,'070800','Precarización');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Asignación de recursos a los pueblos étnicos',1,'070900','Asignación recursos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Relación entre el Estado y los pueblos étnicos',1,'071000','Rel Estado y étnicos ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Acuerdos políticos',1,'071001','Acuerdos políticos ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Consulta previa',1,'071002','Consulta previa');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Participación electoral étnica',1,'071003','Participación electoral');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Desarrollos institucionales étnicos',1,'071004','Desarrollos institucionales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Políticas públicas para los pueblos étnicos',1,'071005','Políticas publicas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Coordinación entre justicias',1,'071006','Coordinación justicias');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Militarización de territorios étnicos',1,'071100','Militarización');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Reclutamiento a miembros de los pueblos étnicos',1,'071101','Reclutamiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Formas de control de la población',1,'071102','Formas control');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Ocupación de territorios étnicos',1,'071103','Ocupación');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Presencia de MAPP-MUSE en territorios étnicos',1,'071104','Presencia MAPP-MUSE');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Idealización de lo militar',1,'071105','Idealización');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Enamoramiento a miembros de los pueblos étnicos',1,'071106','Enamoramiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Establecimiento de relaciones familiares como estrategia de guerra',1,'071107','Relaciones familiares estrategia');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Procesos de colonización en territorios étnicos',1,'071200','Procesos colonización');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Relaciones interétnicas o interculturales',1,'071300','Relaciones interétnicas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Conflictos interétnicos',1,'071301','Conflictos interétnicos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Convivencia',1,'071302','Convivencia');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Fronteras territoriales y pueblos étnicos',1,'071400','Fronteras');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Exterminio físico y cultural',1,'071500','Exterminio');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Impactos colectivos étnicos',1,'071600','Impactos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Territoriales',1,'071601','Territoriales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Culturales',1,'071602','Culturales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Autodeterminación y autonomía',1,'071603','Autodeterminación');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Socioeconómicos',1,'071604','Socioeconómicos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Dinámica comunitaria',1,'071605','Comunitaria');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Espirituales',1,'071606','Espirituales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Familiares',1,'071607','Familiares');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Derechos Territoriales',1,'071700','Derechos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Posesión y uso del territorio',1,'071701','Posesión uso');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Acceso a sitios sagrados y relaciones espirituales',1,'071702','Acceso y relaciones');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Recuperación de tierras y territorios',1,'071703','Recuperación');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Restitución de derechos territoriales',1,'071704','Restitución');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Exilio',1,'080100','Exilio');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Víctimas en el exterior',1,'080101','Víctimas exterior');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Flujos o trayectorias migratorias',1,'080200','Trayectorias ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Reasentamiento',1,'080201','Reasentamiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Violencias en los procesos migratorios',1,'080300','Violencia');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Abusos políciales o de otros actores ',1,'080301','Abusos policiales ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Retención o pérdida de documentos',1,'080302','Retención');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Cobros ilegales para los pasos fronterizos',1,'080303','Cobros ilegales para pasos ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Estatus migratorio',1,'080400','Estatus migratorio');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Con protección internacional',1,'080401','Con protección internacional');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Solicitante de protección internacional',1,'080402','Solicitante protección internacional');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Otros estatus migratorios',1,'080403','Otros ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Programas de protección temporal',1,'080404','Programas protección ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Migrantes irregulares',1,'080405','Migrantes irregulares');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Situaciones o procesos de deportación',1,'080406','Deportación ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Políticas y procedimentos migratorios',1,'080500','Políticas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Institucionalidad colombiana en el exterior',1,'080600','Institucionalidad ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Retorno',1,'080700','Retorno');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Retorno voluntario',1,'080701','Voluntario  ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Retorno forzado',1,'080702','Forzado ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Retorno pendular',1,'080703','Pendular');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Retorno simbólico',1,'080704','Simbólico ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Políticas y programas de retorno',1,'080705','Políticas y programas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Expectativas/condiciones para el retorno',1,'080706','Expectativas y condiciones');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Afrontamientos individuales en el exilio',1,'080800','Afrontamientos individuales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Procesos cognitivos/asimiliación',1,'080801','Asimilación');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Adaptación',1,'080802','Adaptación');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Redes de apoyo',1,'080803','Redes apoyo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Arte ',1,'080804','Arte');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Afrontamientos colectivos en el exilio',1,'080900','Afrontamientos colectivos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Participación en organizaciones de víctimas ',1,'080901','P organizaciones víctimas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Participación y adscripción política',1,'080902','P política');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Participación en el país de acogida ',1,'080903','P país de acogida');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Impactos individuales en el exilio',1,'081000','Impactos individuales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Culpa',1,'081001','Culpa');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Aislamiento',1,'081002','Aislamiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Autocensura',1,'081003','Autocensura');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Segregación y marginación',1,'081004','Segregación y marginación');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Relaciones con la cultura de acogida',1,'081100','Relaciones cultura de acogida');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Rechazo y apatía  frente a Colombia',1,'081101','Apatía a Colombia');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Estigmatización/discriminación',1,'081102','Estigmatización y discriminación ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Cambio identitario',1,'081103','Cambio identitario');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Cambio cultural',1,'081104','Cambio cultural');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Pérdida de estatus',1,'081105','Pérdida estatus');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Desarraigo',1,'081106','Desarraigo');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Impactos familiares en el exilio',1,'081200','Impactos familiares');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Silencios familiares',1,'081201','Silencios ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Trauma transgeneracional',1,'081202','Trauma transgeneracional');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Cooperación Internacional',1,'090100','Cooperación internacional');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Apoyo político internacional a actores del conflicto',1,'090200','Apoyo político actores conflicto');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Violencias contra extranjeros',1,'090300','Violencias ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Presencia bélica extranjera',1,'090400','Presencia bélica');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Apoyo militar extranjero a actores armados',1,'090500','Apoyo militar actores armados');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Acciones armadas transfronterizas',1,'090600','Acciones armadas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Instituciones fronterizas',1,'090700','Instituciones fronterizas');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Discursos y prácticas de las Iglesias relacionadas con el conflicto armado',1,'100100','Discursos iglesias');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Discursos y prácticas del sistema educativo que se han relacionado con el conflicto armado',1,'100200','Discursos sistema educativo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Discursos y prácticas que, desde los medios, fomentaron el conflicto armado',1,'100300','Discursos medios');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Afectaciones a las prácticas artisticas de individuos o colectividades',1,'100400','Afectaciones');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Transformaciones sobre lugares de valor cultural',1,'100500','Transformaciones Cultural ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Cambios en las formas de ver al otro producto del conflicto armado',1,'100600','Cambios formas de ver al otro');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Transformaciones en las identidades producto del conflicto armado',1,'100700','Transformaciones identidad');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Actividades sanitarias',1,'110100','Actividades sanitarias');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Prevención en salud o saneamiento ambiental',1,'110101','Prevención en salud o saneamiento ambiental');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Salud sexual y reproductiva',1,'110102','Salud sexual y reproductiva');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Atención en salud',1,'110103','Atención en salud');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Transporte de pacientes, heridos o personal sanitario',1,'110104','Transporte de pacientes, heridos o personal sanitario');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Infracciones contra bienes protegidos en salud',1,'110200','Infracciones contra bienes protegidos en salud');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Infracciones contra la infraestructura física',1,'110201','Infracciones contra la infraestructura física');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Infracciones a la misión médica',1,'110300','Infracciones a la misión médica');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Infracciones contra la actividad sanitaria',1,'110301','Infracciones contra la actividad sanitaria');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Infracciones contra información protegida.',1,'110302','Infracciones contra información protegida.');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Sanción judicial o de otro tipo',1,'110303','Sanción judicial o de otro tipo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Actos de perfidia',1,'110304','Actos de perfidia');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Cooptación de recursos de salud por actores armados',1,'110400','Cooptación de recursos de salud por actores armados');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Uso de cargos en administradoras de salud',1,'110401','Uso de cargos en administradoras de salud');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Uso de recursos financieros de secretarias de salud, del régimen subsidiado, del Sisbén o de hospitales públicos',1,'110402','Uso de recursos financieros');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Atención sanitaria a combatientes de grupos armados',1,'110500','Atención sanitaria a combatientes de grupos armados');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Directrices sobre salud intrafilas',1,'110501','Directrices sobre salud intrafilas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Patrimonio económico reportado en bienes de salud por parte de los grupos armados',1,'110502','Patrimonio económico reportado en bienes de salud por parte de los grupos armados');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Escuelas de formación de paramédicos/enfermeros',1,'110503','Escuelas de formación de paramédicos/enfermeros');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Prácticas de vinculación en salud intrafilas',1,'110504','Prácticas de vinculación en salud intrafilas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Prácticas de atención a combatientes heridos o enfermos por parte del personal sanitario de los grupos armados',1,'110505','Prácticas de atención a combatientes heridos o enfermos por parte del personal sanitario de los grupos armados');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Atención sanitaria en fuerza pública',1,'110600','Sanidad Fuerza Publica');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Atención sanitaria dirigida a la sociedad civil por parte de un grupo armado o de la fuerza pública',1,'110700','Sanidad Civil Por Fuerza Publica');


insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (1,'',1,'110700','');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Impactos Emocionales /Salud Mental/ Salud Fisica',1,'120100','Impact Emoc Salud Mental Fisica');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Enfermedades o daños de cualquier parte del cuerpo.',1,'120101','EnfermedadesDañosCuerpo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Discapacidad',1,'120102','Discapacidad');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Rabia',1,'120103','Rabia');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Tristeza',1,'120104','Tristeza');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Miedo',1,'120105','Miedo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Desesperanza',1,'120106','Desesperanza');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Desarraigo',1,'120107','Impacto Familiares');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Dificultades mentales',1,'120108','Dificultades mentales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'uso de sustancias psicoactivas',1,'120109','uso de sustancias psicoactivas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'A la salud sexual y reproductiva',1,'120110','A la salud sexual y reproductiva');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Baja autoestima y violencia contra sí mismo.',1,'120111','Baja autoestima y violencia contra sí mismo.');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Impacto familiares',1,'120200','Impacto Familiares');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Impactos en la estructura familiar,  las relaciones y vinculos',1,'120201','Impactos Comunitarios');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'En las relaciones y  arreglos de género',1,'120202','En las relaciones y  arreglos de género');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Cambios economicos y materiales',1,'120203','Cambios economicos y materiales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Cambios en los planes de vida',1,'120204','Cambios en los planes de vida');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Cambios en las costumbres y tradiciones',1,'120205','Cambios en las costumbres y tradiciones');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'desestructuracion familiar',1,'120206','desestructuracion familiar');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Impactos Comunitarios',1,'120300','Impactos Comunitarios');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Perdida de prácticas y saberes culturales',1,'120301','Perdida de prácticas y saberes culturales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Deterioro y/o ruptura del tejido social',1,'120302','Deterioro y/o ruptura del tejido social');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Incremento de las conflictividades, violencias y/o deshumanización de la vida',1,'120303','Incremento de las conflictividades, violencias y/o deshumanización de la vida');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'ruptura de procesos organizativos',1,'120304','ruptura de procesos organizativos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Silencio',1,'120305','Silencio');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'desconfianza colectiva',1,'120306','desconfianza colectiva');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'ruptura de practicas cotidianas',1,'120307','ruptura de practicas cotidianas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'impactos en liderazgos colectivos',1,'120308','impactos en liderazgos colectivos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'por perdida de los liderasgos colectivos',1,'120309','por perdida de los liderasgos colectivos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'clima emocional del terror.',1,'120310','clima emocional del terror.');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Impacto en el territorio y/o naturaleza',1,'120400','Impacto Terrestre');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Perdidas materiales y  económicas',1,'120401','Perdidas materiales y  económicas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Destrucción y/o contaminación del territorio/ y o naturaleza',1,'120402','Destruccion del territorio y naturaleza');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Transformación del paisaje',1,'120403','Transformación del paisaje');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Transformación de los usos y relaciones con el territorio',1,'120404','Transformación de los usos y relaciones con el territorio');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Impactos en los Derechos Económicos, Sociales, Culturales y Ambientales -DESCA',1,'120500','Impacto DESCA');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Acceso limitado a condiciones de vida sana y/o servicios de salud',1,'120501','Acceso limitado a condiciones de vida sana y/o servicios de salud');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Acceso limitado Educación /Salud/Trabajo',1,'120502','Acceso limitado Educación /Salud/Trabajo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Desempleo, informalidad y/o precariedad',1,'120503','Desempleo, informalidad y/o precariedad');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Pérdidad o imposibilidad de acceder a la Seguridad social: pensión y/o salud',1,'120504','Pérdidad o imposibilidad de acceder a la Seguridad social: pensión y/o salud');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Pérdida de beneficios de programas de asistencia social para la niñez, vejez o personas en condición de discapacidad.',1,'120505','Pérdida de beneficios de programas de asistencia social para la niñez, vejez o personas en condición de discapacidad.');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Pérdida de la seguridad y soberanía alimentaria',1,'120506','Pérdida de la seguridad y soberanía alimentaria');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Impactos a la Democracia',1,'120600','Impacto Democracia');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Afectaciones a Procesos organizativos',1,'120601','Afectaciones a Procesos organizativos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Afectación a la Libertad de prensa y derecho a la información',1,'120602','Afectaciones a libertad de prensa');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Afectación a derechos electorales',1,'120603','Afectación a derechos electorales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Afectación a la Participación ciudadana',1,'120604','Afectación a la Participación ciudadana');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Homicidio',1,'130100','Homicidio');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Ejecución extrajudicial, sumaria o arbitraria',1,'130101','Ejecucion Extrajudicial Arbitraria');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Ejecución extrajudicial presentada como muerte en combate o falso positivo',1,'130102','Ejecucion Extrajudicial Falso Positivo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Masacre',1,'130103','Masacre');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Muerte por discriminación o prejuicio',1,'130104','Muerte Discriminacion Prejuicio');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Muerte de civiles en medio de combates',1,'130105','Muerte Civiles Combate');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Muerte de civiles en atentados con bombas',1,'130106','Muerte Civiles Bombas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Muerte de civiles por activación de explosivos o minas',1,'130107','Muerte Civiles Esplosivos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Muerte de civiles causada por ataques a bienes civiles',1,'130108','Muerte Civiles Ataques Bienes Civiles');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Atentado al derecho a la vida',1,'130200','Atentado A la Vida');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Herido en atentado',1,'130201','Herido Atentado');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Víctima de atentado sin lesiones',1,'130202','Victima Sin Lesiones');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Civiles heridos en medio de combates',1,'130203','Civil Heridos Combate');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Civiles herido en atentado con bomba',1,'130204','Civiles Heridos Bombas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Civiles heridos por activación de explosivos o minas',1,'130205','Civiles Heridos Esplosivos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Civiles herido en medio de ataques a bienes civiles',1,'130206','Civiles Ataques Bienes Civiles');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Amenaza al derecho a la vida',1,'130300','Amenaza a la Vida');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Amenaza verbal',1,'130301','Amenaza Verbal');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Amenaza por llamada telefónica',1,'130302','Amenaza Llamada Telefonica');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Amenaza por correo electrónico',1,'130303','Amenaza Correo Electronico');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Amenaza por medio de familiar o amigo',1,'130304','Amenaza Familiar Amigos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Amenaza por seguimiento',1,'130305','Amenza Seguimiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Amenaza por panfleto',1,'130306','Amenaza Panfleto');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Amenaza por carta',1,'130307','Amenaza Carta');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Amenaza por sufragio',1,'130308','Amenaza Sufragio');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Prácticas de persecución o exterminio',1,'130400','Exterminio');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Genocidio',1,'130401','Genocidio');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Apología al genocidio',1,'130402','Apologia Genocidio');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Exterminio social',1,'130403','Exterminio Social');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Persecución por discriminación',1,'130404','Persecucion Discriminacion');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Desaparición forzada',1,'130500','Desaparición forzada');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Desaparición selectiva',1,'130501','Desaparic Selectiva');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Desaparición encubridora',1,'130502','Desaparic Encubridora');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Desaparición como medio de intimidación',1,'130503','Desaparic Medio Intimidacion');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Fosas comunes ',1,'130504','Fosas Comunes');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Tortura y otros tratos crueles',1,'130600','Tortura y otros tratos crueles');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Tortura física',1,'130601','Tortura Fisica');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Tortura psicológica',1,'130602','Tortura Psicologica');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Violencias sexuales',1,'130700','Violencias sexuales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Actos sexuales abusivos',1,'130800','Actos sexuales abusivos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Empalamiento',1,'130801','Empalamiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Anticoncepción o estirilización forzada',1,'130802','Anticoncep Estirilizacion Forzada');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Aborto forzado',1,'130803','Aborto Forzado');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Trata de personas con fines de explotación sexual',1,'130804','Explotacion Sexual');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Esclavitud sexual',1,'130805','Esclavitud Sexual');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Obligación a presenciar actos sexuales',1,'130806','Obligacion Ver Actos Sexuales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Obligación a realizar actos sexuales',1,'130807','Obligacion Actos Sexuales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Violación sexual',1,'130808','Violacion Sexual');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Prostitución forzada',1,'130809','Prostitucion Forzada');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Embarazo forzado',1,'130810','Embarazo Forzado');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Tortura durante el embarazo',1,'130811','Tortura en Embarazo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Maternidad o crianza forzada',1,'130812','Maternidad Crianza Forzada');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Desnudez forzada',1,'130813','Desnudez Forzada');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Mutilación de órganos sexuales',1,'130814','Mutilacion Organos Sexuales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Cambios forzados en la corporabilidad y performatividad del género',1,'130815','Cambios en Cuerpo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Reclutamiento, uso y utilización de niños, niñas y adolescentes',1,'130900','Reclutamiento NNA');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Utilización en acciones bélicas',1,'130901','Utilizacion Acciones Belicas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Utilización en actividades de vigilancia e inteligencia',1,'130902','Utilizacion Vigilacia Inteligencia');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Utilización en actividades logísticas y administrativas',1,'130903','Utilizacion Logisticas Administrativas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Utilización en actividades relacionadas con el narcotráfico',1,'130904','Utilizacion Narcotrafico');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Amenaza de reclutamiento',1,'130905','Amenaza Reclutamiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Reclutamiento Forzado ',1,'130906','Reclutamiento Forzado');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Detención arbitraria',1,'131000','Detención arbitraria');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Detención sin orden escrita de una autoridad judicial',1,'131001','Detencion Sin Orden');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Detención por agentes del Estado sin autoridad para hacerlo',1,'131002','Detencion Agentes Estado sin autoridad');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Detención tras cumplimiento de pena',1,'131003','Detencion Cumplimiento Pena');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Detención tras vencimiento de los términos legales',1,'131004','Detencion Vencimiento Terminos Legales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Secuestro/toma de rehenes',1,'131100','Secuestro/toma de rehenes');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Secuestro extorsivo',1,'131101','Secuestro Extorsivo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Secuestro político',1,'131102','Secuestro Politico');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Secuestro simple',1,'131103','Secuestro Simple');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Confinamiento',1,'131200','Confinamiento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Confinamiento individual',1,'131201','Confina Individual');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Confinamiento familiar',1,'131202','Confina Familiar');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Confinamiento colectivo',1,'131203','Confina Colectivo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Pillaje',1,'131300','Pillaje');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Extorsión',1,'131400','Extorsión');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Ataque a bien protegido',1,'131500','Ataque a bien protegido');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Ataque indiscriminado',1,'131600','Ataque indiscriminado');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Despojo/abandono de tierras',1,'131700','Despojo/abandono de tierras');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Desplazamiento forzado',1,'131800','Desplazamiento forzado');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Desplazamiento individual',1,'131801','Desplazam Individual');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Desplazamiento familiar',1,'131802','Desplazam Familiar');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Desplazamiento masivo',1,'131803','Desplazam Masivo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Exilio',1,'131900','Exilio');








insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Personales',1,'140100','Personales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Familiares',1,'140200','Familiares ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Redes o expresiones  de apoyo',1,'140300','Redes apoyo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Prácticas artísticas',1,'140400','Prácticas artísticas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Espiritualidad, religión y fe',1,'140500','Espiritualidad ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Actividad física, deporte y recreación',1,'140600','Actividad física');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Enfrentar al violento',1,'140700','Enfrentar violento');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Silencio ',1,'140800','Silencio');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Alimentación',1,'140900','Alimentación');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Descarga emocional',1,'141000','Descarga emocional');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Costumbres y tradiciones',1,'141100','Costumbres tradiciones');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Del campesinado',1,'150100','Campesinado');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Estrategias de resistencia étnica',1,'150200','Estrategias resistencia');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Movimiento cocalero',1,'150300','Movimiento cocalero');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Organizaciones de víctimas',1,'150400','Organizaciones víctimas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Defensa del ambiente y territorio',1,'150500','Defensa ambiente');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Acciones formativas',1,'150600','Acciones formativas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Espacio público',1,'150700','Espacio público');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Pactos para la convivencia y la paz desde la sociedad civil',1,'150800','Pactos convivencia paz');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Artísticos y deportivos',1,'150900','Artísticos deportivos');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Apoyo psicosocial',1,'151000','Apoyo psicosocial');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Apoyo legal',1,'151100','Apoyo legal');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Construcción de paz',1,'151200','Construcción paz');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Políticas económicas',1,'160200','Políticas económicas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Política de seguridad y  defensa',1,'160300','Políticas seguridad defensa');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Políticas antidrogas',1,'160400','Políticas antidrogas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Políticas de Derechos Humanos',1,'160500','Políticas derechos humanos');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Estgmatizacion a familias ',1,'170100','Estigmatización familias');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Estigmatización política ',1,'170200','Estigmatización política');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Construcción del enemigo ',1,'170300','Construcción enemigo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Colaborador ',1,'170400','Colaborador');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Por razones étnico-raciales',1,'170500','Razones étnico-racionales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Por razones de género',1,'170600','Razones género ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Por razones de clase',1,'170700','Razones clase');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Por discapacidad',1,'170800','Discapacidad');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Por ciclo vital',1,'170900','Ciclo vital');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Territorial ',1,'171000','Territorial');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Geografías racializadas',1,'171100','Geografías racializadas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Asociadas a economía de las drogas ilícitas ',1,'171200','Economía drogas ilícitas');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Recomendaciones de educacion ',1,'180100','R Educación ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Recomendaciones al Estado',1,'180200','R Estado');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Militarización',1,'180201','Militarización');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Fuerza pública',1,'180202','Fuerza Pública');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Recomendaciones DESCA',1,'180300','R DESCA');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Recomendaciones sobre la reintegración de excombatientes',1,'180400','R Reintegración excombatientes');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Reincidencia de los actores armados',1,'180500','Reisidencia actores armados');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Transformaciones culturales ',1,'180600','Transformaciones culturales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Recomendaciones sobre drogas ilícitas - narcotráfico',1,'180700','R Drogas ilícitas narcotráfico');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Seguridad y defensa del Estado',1,'190100','Seguridad y defensa Estado');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Agrarias ',1,'190200','Agrarias');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'De víctimas',1,'190300','Víctimas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Educación',1,'190400','Educación ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Salud',1,'190500','Salud');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Ambientales',1,'190600','Ambientales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Desarrollos institucionales étnicos',1,'190700','D Institucionales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Para la construcción de paz',1,'190800','Construcción paz');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Cultura',1,'190900','Cultura');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Económicas',1,'191000','Económicas');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Cambios institucionales producto de procesos de paz ',1,'200200','Cambios institucionales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Cambios sociales producto de procesos de paz ',1,'200300','Cambios sociales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Procesos locales de paz',1,'200400','Procesos locales ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Reacciones asociadas a los procesos de paz ',1,'200500','Reacciones');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Apoyos internacionales a procesos de paz y humanitarios ',1,'200600','Apoyos internacionales ');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Desplazamiento forzado transfronterizo ',1,'210200','Desplazamiento forzado transfonterizo');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Tráfico y trata de personas',1,'210300','Tráfico personas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Tráficos ilícitos de armas, insumos y drogas ',1,'210400','Tráfico ilícito armas ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Contrabando ',1,'210500','Contrabando');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Dinámicas de los pueblos étnicos binacionales ',1,'210600','D Pueblos étnicos binacionales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Dinámicas armadas transfronterizas ',1,'210700','D armadas ');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Dinámicas institucionales estatales ',1,'210800','D Instituciones estatales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Tránsitos pendulares ',1,'210900','Tránsitos pendulares');

insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Fecha',1,'000100','Fecha');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Divipola',1,'000200','Divipola');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Sitios/regiones',1,'000300','Sitios/regiones');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Personas',1,'000400','Personas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Organizaciones',1,'000500','Organizaciones');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Instituciones/entidades',1,'000501','Instituciones/entidades');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Ilegales',1,'000502','Ilegales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (3,'Grupos poblacionales',1,'000503','Grupos poblacionales');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Armas',1,'000600','Armas');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Roles',1,'000700','Roles');
insert into catalogos.tesauro(nivel, descripcion, id_tipo,codigo,etiqueta) values (2,'Politicas/Normas/Leyes',1,'000800','Politicas/Normas/Leyes');





-- Luego de los insert, actualizar el arbol
-- nivel 1
update catalogos.tesauro set id_padre=null where true;

--nivel 2
update catalogos.tesauro
set id_padre = padre.id_geo
from catalogos.tesauro as padre
where tesauro.nivel=2
  and padre.nivel=1
  and substring(tesauro.codigo,1,2) = substring(padre.codigo,1,2);

--nivel 3

update catalogos.tesauro
set id_padre = padre.id_geo
from catalogos.tesauro as padre
where tesauro.nivel=3
  and padre.nivel=2
  and substring(tesauro.codigo,1,4) = substring(padre.codigo,1,4);





