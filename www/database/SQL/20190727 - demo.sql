
create schema demo;

ALTER SCHEMA demo
OWNER TO dba;

INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (21, 'Acompañamiento', 'Formulario de entrevista', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (22, 'Lengua del testimonio', 'Formulario de entrevista', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (23, 'Lenguas nativas', 'Datos sociodemográficos', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (24, 'Sexo', 'Datos sociodemográficos', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (25, 'Orientación Sexual', 'Datos sociodemográficos', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (26, 'Identidad de género', 'Datos sociodemográficos', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (27, 'Pertenencia étnica', 'Datos sociodemográficos', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (28, 'Pertenencia indígena', 'Datos sociodemográficos', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (29, 'Edad', 'Ficha de responsable individual', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (30, 'Categoría de exilio', 'Ficha de exilio', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (31, 'Motivo de salida del país', 'Ficha de exilio', 1);
INSERT INTO "catalogos"."cat_cat" ("id_cat", "nombre", "descripcion", "editable") VALUES (32, 'Modalidad de salida del país', 'Ficha de exilio', 1);
insert into catalogos.cat_item (id_cat,descripcion) values(21,'Familiar');
insert into catalogos.cat_item (id_cat,descripcion) values(21,'Espiritual');
insert into catalogos.cat_item (id_cat,descripcion) values(21,'Psicosocial/Psicocultural');
insert into catalogos.cat_item (id_cat,descripcion) values(21,'Acompañamiento NNA');
insert into catalogos.cat_item (id_cat,descripcion) values(21,'Acompañamientos a personas adultas');
insert into catalogos.cat_item (id_cat,descripcion) values(21,'Acompañamientos a personas en situacion de discapacidad');
insert into catalogos.cat_item (id_cat,descripcion) values(21,'Miembro de la comunidad, organización o pueblo étnico');
insert into catalogos.cat_item (id_cat,descripcion,orden) values(21,'Otro',99);
insert into catalogos.cat_item (id_cat,descripcion,predeterminado) values(22,'Español',1);
insert into catalogos.cat_item (id_cat,descripcion) values(22,'Idiomas nativos');
insert into catalogos.cat_item (id_cat,descripcion) values(22,'Lengua de señas');
insert into catalogos.cat_item (id_cat,descripcion,orden) values(22,'Otro',99);

insert into catalogos.cat_item (id_cat,descripcion) values(24,'Hombre');
insert into catalogos.cat_item (id_cat,descripcion) values(24,'Mujer');
insert into catalogos.cat_item (id_cat,descripcion) values(24,'Intersexual');
insert into catalogos.cat_item (id_cat,descripcion) values(25,'Hombres');
insert into catalogos.cat_item (id_cat,descripcion) values(25,'Mujeres');
insert into catalogos.cat_item (id_cat,descripcion) values(25,'Ambos');
insert into catalogos.cat_item (id_cat,descripcion) values(26,'Hombre');
insert into catalogos.cat_item (id_cat,descripcion) values(26,'Mujer');
insert into catalogos.cat_item (id_cat,descripcion,orden) values(26,'Otro',99);
insert into catalogos.cat_item (id_cat,descripcion,predeterminado) values(27,'Mestizo/a',1);
insert into catalogos.cat_item (id_cat,descripcion) values(27,'Afrocolombiano/a');
insert into catalogos.cat_item (id_cat,descripcion) values(27,'Negro/a');
insert into catalogos.cat_item (id_cat,descripcion) values(27,'Raizal');
insert into catalogos.cat_item (id_cat,descripcion) values(27,'Palenquero/a');
insert into catalogos.cat_item (id_cat,descripcion) values(27,'Rrom');
insert into catalogos.cat_item (id_cat,descripcion) values(27,'Indígena');
insert into catalogos.cat_item (id_cat,descripcion) values(27,'Extranjero');
insert into catalogos.cat_item (id_cat,descripcion,orden) values(27,'Otro',99);

insert into catalogos.cat_item (id_cat,descripcion,orden) values(29,'NNA (0-17)',1);
insert into catalogos.cat_item (id_cat,descripcion,orden,predeterminado) values(29,'Joven (18-26)',2,1);
insert into catalogos.cat_item (id_cat,descripcion,orden) values(29,'Adulto (27-59)',3);
insert into catalogos.cat_item (id_cat,descripcion,orden) values(29,'Persona mayor (60 y más)',4);
insert into catalogos.cat_item (id_cat,descripcion) values(30,'Exiliado/a');
insert into catalogos.cat_item (id_cat,descripcion) values(30,'Vícitima en el exterior');
insert into catalogos.cat_item (id_cat,descripcion) values(30,'Migrante');
insert into catalogos.cat_item (id_cat,descripcion) values(30,'Retornado');
insert into catalogos.cat_item (id_cat,descripcion) values(30,'Desplazado');
insert into catalogos.cat_item (id_cat,descripcion,orden) values(30,'Otro/a',99);
insert into catalogos.cat_item (id_cat,descripcion) values(31,'Hechos violentos mencionados en la entrevista');
insert into catalogos.cat_item (id_cat,descripcion) values(31,'Rechazo/odio frente a Colombia');
insert into catalogos.cat_item (id_cat,descripcion) values(31,'Sobrevivencia/ búsqueda de m ejores oportunidades');
insert into catalogos.cat_item (id_cat,descripcion) values(31,'Miedos relacionados con la zona');
insert into catalogos.cat_item (id_cat,descripcion) values(31,'Reagrupación familiar');
insert into catalogos.cat_item (id_cat,descripcion, orden) values(31,'Otro',99);
insert into catalogos.cat_item (id_cat,descripcion) values(32,'Individual');
insert into catalogos.cat_item (id_cat,descripcion) values(32,'Familiar');
insert into catalogos.cat_item (id_cat,descripcion) values(32,'Colectivo');

-- Parametros
create table catalogos.parametro
(
	id_parametro int
		constraint parametro_pk
			primary key,
	nombre character(100) not null,
	descripcion text,
	valor character(50) not null
);

alter table catalogos.parametro
    owner to dba;

comment on table catalogos.parametro is 'Parametros utilizados en el aplicativo';


insert into catalogos.parametro(id_parametro,nombre,descripcion,valor) values (1,'ID de exilio','id_item de la violencia exilio. Usado para la demo, para determinar si es necesaria la ficha de exilio','47');
insert into catalogos.parametro(id_parametro,nombre,descripcion,valor) values (2,'ID de violencia sexual','id_item de la violencia sexual. Usado para cambiar automaticamente la clasificacion de un expediente a nivel 3','35');

-- Tablas
create table demo.entrevista
(
    id_entrevista     serial       not null
        constraint entrevista_pkey
            primary key,
    id_e_ind_fvt      integer      not null
        constraint demo_entrevista_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete restrict,
    fecha             timestamp(0) not null,
    id_lugar          integer      not null,
    id_acompanamiento integer,
    id_idioma         integer      not null,
    anotaciones       text,
    id_usuario        integer      not null,
    created_at        timestamp(0),
    updated_at        timestamp(0)
);

alter table demo.entrevista
    owner to dba;

create index demo_entrevista_id_e_ind_fvt_index
    on demo.entrevista (id_e_ind_fvt);

create index demo_entrevista_id_usuario_index
    on demo.entrevista (id_usuario);

--
create table demo.entrevistado
(
    id_entrevistado           serial            not null
        constraint entrevistado_pkey
            primary key,
    id_e_ind_fvt              integer           not null
        constraint demo_entrevistado_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete restrict,
    id_entrevista             integer
        constraint demo_entrevistado_id_entrevista_foreign
            references demo.entrevista
            on update cascade on delete restrict,
    es_victima                integer default 2 not null,
    es_testigo                integer default 2 not null,
    nombres                   varchar(100),
    apellidos                 varchar(100),
    otros_nombres             varchar(100),
    nacimiento_fecha          timestamp(0)      not null,
    nacimiento_lugar          integer           not null,
    sexo                      integer           not null
        constraint demo_entrevistado_sexo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    orientacion_sexual        integer           not null
        constraint demo_entrevistado_orientacion_sexual_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    identidad_genero          integer           not null
        constraint demo_entrevistado_identidad_genero_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    pertenencia_etnico_racial integer           not null
        constraint demo_entrevistado_pertenencia_etnico_racial_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_usuario                integer           not null,
    created_at                timestamp(0),
    updated_at                timestamp(0)
);

alter table demo.entrevistado
    owner to dba;

create index demo_entrevistado_id_e_ind_fvt_index
    on demo.entrevistado (id_e_ind_fvt);

create index demo_entrevistado_id_entrevista_index
    on demo.entrevistado (id_entrevista);

create index demo_entrevistado_id_usuario_index
    on demo.entrevistado (id_usuario);

--
create table demo.victima
(
    id_victima                serial            not null
        constraint victima_pkey
            primary key,
    id_e_ind_fvt              integer           not null
        constraint demo_victima_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete restrict,
    es_declarante             integer default 2 not null,
    id_declarante             integer,
    nombres                   varchar(100),
    apellidos                 varchar(100),
    otros_nombres             varchar(100),
    nacimiento_fecha          timestamp(0)      not null,
    nacimiento_lugar          integer           not null,
    sexo                      integer           not null
        constraint demo_victima_sexo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    orientacion_sexual        integer           not null
        constraint demo_victima_orientacion_sexual_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    identidad_genero          integer           not null
        constraint demo_victima_identidad_genero_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    pertenencia_etnico_racial integer           not null
        constraint demo_victima_pertenencia_etnico_racial_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_usuario                integer           not null,
    created_at                timestamp(0),
    updated_at                timestamp(0)
);

alter table demo.victima
    owner to dba;

create index demo_victima_id_e_ind_fvt_index
    on demo.victima (id_e_ind_fvt);

create index demo_victima_id_usuario_index
    on demo.victima (id_usuario);

--
create table demo.responsable
(
    id_responsable            serial  not null
        constraint responsable_pkey
            primary key,
    id_e_ind_fvt              integer not null
        constraint demo_responsable_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete restrict,
    nombres                   varchar(100),
    apellidos                 varchar(100),
    otros_nombres             varchar(100),
    sexo                      integer not null,
    id_edad                   integer not null
        constraint demo_responsable_id_edad_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    pertenencia_etnico_racial integer not null
        constraint demo_responsable_pertenencia_etnico_racial_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_usuario                integer not null,
    created_at                timestamp(0),
    updated_at                timestamp(0)
);

alter table demo.responsable
    owner to dba;

create index demo_responsable_id_e_ind_fvt_index
    on demo.responsable (id_e_ind_fvt);

create index demo_responsable_id_usuario_index
    on demo.responsable (id_usuario);

create index demo_responsable_id_edad_index
    on demo.responsable (id_edad);

create index demo_responsable_pertenencia_etnico_racial_index
    on demo.responsable (pertenencia_etnico_racial);

--
create table demo.exilio
(
    id_exilio     serial       not null
        constraint exilio_pkey
            primary key,
    id_e_ind_fvt  integer      not null
        constraint demo_exilio_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete restrict,
    id_categoria  integer      not null
        constraint demo_exilio_id_categoria_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_motivo     integer      not null
        constraint demo_exilio_id_motivo_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    salida_fecha  timestamp(0) not null,
    salida_lugar  timestamp(0) not null,
    llegada_fecha timestamp(0) not null,
    llegada_lugar timestamp(0) not null,
    id_modalidad  integer      not null
        constraint demo_exilio_id_modalidad_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_usuario    integer      not null,
    created_at    timestamp(0),
    updated_at    timestamp(0)
);

alter table demo.exilio
    owner to dba;

create index demo_exilio_id_e_ind_fvt_index
    on demo.exilio (id_e_ind_fvt);

create index demo_exilio_id_usuario_index
    on demo.exilio (id_usuario);

create index demo_exilio_id_categoria_index
    on demo.exilio (id_categoria);

create index demo_exilio_id_motivo_index
    on demo.exilio (id_motivo);

create index demo_exilio_id_modalidad_index
    on demo.exilio (id_modalidad);

--

create table demo.consentimiento
(
    id_consentimiento   serial            not null
        constraint consentimiento_pkey
            primary key,
    id_e_ind_fvt        integer           not null
        constraint demo_consentimiento_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete restrict,
    fecha               timestamp(0)      not null,
    identificacion      varchar(100)      not null,
    acuerdo_entrevista  integer default 2 not null,
    acuerdo_audio       integer default 2 not null,
    acuerdo_informe     integer default 2 not null,
    personales_analisis integer default 2 not null,
    personales_informe  integer default 2 not null,
    personales_publicar integer default 2 not null,
    sensibles_analisis  integer default 2 not null,
    sensibles_informe   integer default 2 not null,
    sensibles_publicar  integer default 2 not null,
    id_usuario          integer           not null,
    created_at          timestamp(0),
    updated_at          timestamp(0)
);

alter table demo.consentimiento
    owner to dba;

create index demo_consentimiento_id_e_ind_fvt_index
    on demo.consentimiento (id_e_ind_fvt);

create index demo_consentimiento_id_usuario_index
    on demo.consentimiento (id_usuario);

--
create table demo.hechos
(
    id_hechos         serial            not null
        constraint hechos_pkey
            primary key,
    id_e_ind_fvt      integer           not null
        constraint demo_hechos_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete restrict,
    id_entrevista     integer           not null,
    hechos_fecha      timestamp(0)      not null,
    hechos_lugar      integer           not null,
    hechos_sitio      text,
    cantidad_victimas integer default 1 not null,
    id_usuario        integer           not null,
    created_at        timestamp(0),
    updated_at        timestamp(0)
);

alter table demo.hechos
    owner to dba;

create index demo_hechos_hechos_fecha_index
    on demo.hechos (hechos_fecha);

create index demo_hechos_hechos_lugar_index
    on demo.hechos (hechos_lugar);

--
create table demo.hechos_fuerza
(
    id_hechos_fuerza serial  not null
        constraint hechos_fuerza_pkey
            primary key,
    id_e_ind_fvt     integer not null
        constraint demo_hechos_fuerza_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete restrict,
    id_hechos        integer not null
        constraint demo_hechos_fuerza_id_hechos_foreign
            references demo.hechos
            on update cascade on delete cascade,
    id_fuerza        integer not null
        constraint demo_hechos_fuerza_id_fuerza_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_usuario       integer not null,
    created_at       timestamp(0),
    updated_at       timestamp(0)
);

alter table demo.hechos_fuerza
    owner to dba;

create index demo_hechos_fuerza_id_hechos_index
    on demo.hechos_fuerza (id_hechos);

create index demo_hechos_fuerza_id_fuerza_index
    on demo.hechos_fuerza (id_fuerza);

--
create table demo.hechos_responsable
(
    id_hechos_responsable serial  not null
        constraint hechos_responsable_pkey
            primary key,
    id_e_ind_fvt          integer not null
        constraint demo_hechos_responsable_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete restrict,
    id_hechos             integer not null
        constraint demo_hechos_responsable_id_hechos_foreign
            references demo.hechos
            on update cascade on delete cascade,
    id_responsable        integer not null
        constraint demo_hechos_responsable_id_responsable_foreign
            references demo.responsable
            on update cascade on delete cascade,
    id_usuario            integer not null,
    created_at            timestamp(0),
    updated_at            timestamp(0)
);

alter table demo.hechos_responsable
    owner to dba;

create index demo_hechos_responsable_id_hechos_index
    on demo.hechos_responsable (id_hechos);

create index demo_hechos_responsable_id_responsable_index
    on demo.hechos_responsable (id_responsable);

--
create table demo.hechos_victima
(
    id_hechos_victima serial  not null
        constraint hechos_victima_pkey
            primary key,
    id_e_ind_fvt      integer not null
        constraint demo_hechos_victima_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete restrict,
    id_hechos         integer not null
        constraint demo_hechos_victima_id_hechos_foreign
            references demo.hechos
            on update cascade on delete cascade,
    id_victima        integer not null
        constraint demo_hechos_victima_id_victima_foreign
            references demo.victima
            on update cascade on delete cascade,
    id_usuario        integer not null,
    created_at        timestamp(0),
    updated_at        timestamp(0)
);

alter table demo.hechos_victima
    owner to dba;

create index demo_hechos_victima_id_hechos_index
    on demo.hechos_victima (id_hechos);

create index demo_hechos_victima_id_victima_index
    on demo.hechos_victima (id_victima);

--
create table demo.hechos_violacion
(
    id_hechos_violacion serial  not null
        constraint hechos_violacion_pkey
            primary key,
    id_e_ind_fvt        integer not null
        constraint demo_hechos_violacion_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete restrict,
    id_hechos           integer not null
        constraint demo_hechos_violacion_id_hechos_foreign
            references demo.hechos
            on update cascade on delete cascade,
    id_violacion        integer not null
        constraint demo_hechos_violacion_id_violacion_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    id_usuario          integer not null,
    created_at          timestamp(0),
    updated_at          timestamp(0)
);

alter table demo.hechos_violacion
    owner to dba;

create index demo_hechos_violacion_id_hechos_index
    on demo.hechos_violacion (id_hechos);

create index demo_hechos_violacion_id_violacion_index
    on demo.hechos_violacion (id_violacion);

