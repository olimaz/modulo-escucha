drop table if exists esclarecimiento.excel_personas_entrevistadas;
create table esclarecimiento.excel_personas_entrevistadas
(
    id_excel_personas_entrevistadas serial not null
        constraint excel_personas_entrevistadas_pk
        primary key,
    codigo_entrevista varchar(25),
    tipo_entrevista varchar(25),
    cedula varchar(100),
    nombres varchar(200),
    apellidos varchar(200),
    otros_nombres varchar(200),
    sexo text,
    edad int,
    grupo_etario text,
    anio_nacimiento integer,
    sector text,
    clasificacion_nivel integer,
    macroterritorio text,
    territorio text,
    entrevista_fecha varchar(10),
    entrevista_lugar_n1_codigo text,
    entrevista_lugar_n1_txt text,
    entrevista_lugar_n2_codigo text,
    entrevista_lugar_n2_txt text,
    entrevista_lugar_n3_codigo text,
    entrevista_lugar_n3_txt text,
    entrevista_lugar_n3_lat varchar(20),
    entrevista_lugar_n3_lon varchar(20),
    id_sexo integer,
    id_sector integer,
    id_macroterritorio integer,
    id_territorio integer,
    id_entrevista_lugar integer,
    id_subserie integer,
    id_entrevista integer,
    id_persona integer,
    fts tsvector
);

comment on table esclarecimiento.excel_personas_entrevistadas is 'Integración de datos de VI, PR, HV';

comment on column esclarecimiento.excel_personas_entrevistadas.codigo_entrevista is 'Para integración con otras vistas';

comment on column esclarecimiento.excel_personas_entrevistadas.tipo_entrevista is 'Para determinar el origen fácilmente';

comment on column esclarecimiento.excel_personas_entrevistadas.cedula is 'Documento de identificación, extraído del consentimiento informado';

comment on column esclarecimiento.excel_personas_entrevistadas.sexo is 'Sexo de la persona entrevistada';

comment on column esclarecimiento.excel_personas_entrevistadas.sector is 'Sector con que se puede asociar a la persona entrevistada';

comment on column esclarecimiento.excel_personas_entrevistadas.clasificacion_nivel is 'Clasificación de la entrevista (R1 a R4)';

comment on column esclarecimiento.excel_personas_entrevistadas.macroterritorio is 'Macroterritorio donde se realiza la entrevista';

comment on column esclarecimiento.excel_personas_entrevistadas.territorio is 'Territorio donde se realiza la entrevista';

comment on column esclarecimiento.excel_personas_entrevistadas.entrevista_fecha is 'fecha en que se realiza la entrevista';

comment on column esclarecimiento.excel_personas_entrevistadas.entrevista_lugar_n1_codigo is 'N1 = Departamento (codigo) en que se realiza la entrevista';

comment on column esclarecimiento.excel_personas_entrevistadas.entrevista_lugar_n1_txt is 'N1 = Departamento (descripcion) en que se realiza la entrevista';

comment on column esclarecimiento.excel_personas_entrevistadas.entrevista_lugar_n2_codigo is 'N2 = Municipio (codigo) en que se realiza la entrevista';

comment on column esclarecimiento.excel_personas_entrevistadas.entrevista_lugar_n2_txt is 'N2 = Municipio (descripcion) en que se realiza la entrevista';

comment on column esclarecimiento.excel_personas_entrevistadas.entrevista_lugar_n3_codigo is 'N3 = Vereda (codigo) en que se realiza la entrevista';

comment on column esclarecimiento.excel_personas_entrevistadas.entrevista_lugar_n3_txt is 'N3 = Vereda (descripcion) en que se realiza la entrevista';

comment on column esclarecimiento.excel_personas_entrevistadas.entrevista_lugar_n3_lat is 'N3 = Vereda (latitud) en que se realiza la entrevista';

comment on column esclarecimiento.excel_personas_entrevistadas.entrevista_lugar_n3_lon is 'N3 = Vereda (logitud) en que se realiza la entrevista';

comment on column esclarecimiento.excel_personas_entrevistadas.id_sexo is 'Para filtros por sexo';

comment on column esclarecimiento.excel_personas_entrevistadas.id_sector is 'Para filtros por sector';

comment on column esclarecimiento.excel_personas_entrevistadas.id_macroterritorio is 'Para filtros por macroterritorio';

comment on column esclarecimiento.excel_personas_entrevistadas.id_territorio is 'Para filtros por territorio';

comment on column esclarecimiento.excel_personas_entrevistadas.id_entrevista_lugar is 'Para filtros por lugar de entrevista';

comment on column esclarecimiento.excel_personas_entrevistadas.id_subserie is 'Para determinar el tipo de entrevista';

comment on column esclarecimiento.excel_personas_entrevistadas.id_entrevista is 'Llave primaria de la tabla respectiva';

alter table esclarecimiento.excel_personas_entrevistadas owner to dba;

grant select on esclarecimiento.excel_personas_entrevistadas to solo_lectura;

create index excel_personas_entrevistadas_apellidos_index
    on esclarecimiento.excel_personas_entrevistadas (apellidos);

create index excel_personas_entrevistadas_clasificacion_nivel_index
    on esclarecimiento.excel_personas_entrevistadas (clasificacion_nivel);

create index excel_personas_entrevistadas_codigo_entrevista_index
    on esclarecimiento.excel_personas_entrevistadas (codigo_entrevista);

create index excel_personas_entrevistadas_id_sexo_index
    on esclarecimiento.excel_personas_entrevistadas (id_sexo);

create index excel_personas_entrevistadas_id_sector_index
    on esclarecimiento.excel_personas_entrevistadas (id_sector);

create index excel_personas_entrevistadas_id_macroterritorio_index
    on esclarecimiento.excel_personas_entrevistadas (id_macroterritorio);

create index excel_personas_entrevistadas_id_territorio_index
    on esclarecimiento.excel_personas_entrevistadas (id_territorio);

create index excel_personas_entrevistadas_id_entrevista_lugar_index
    on esclarecimiento.excel_personas_entrevistadas (id_entrevista_lugar);

create index excel_personas_entrevistadas_id_subserie_id_primaria_index
    on esclarecimiento.excel_personas_entrevistadas (id_subserie, id_entrevista);

create index excel_personas_entrevistadas_nombres_index
    on esclarecimiento.excel_personas_entrevistadas (nombres);

create index excel_personas_entrevistadas_otros_nombres_index
    on esclarecimiento.excel_personas_entrevistadas (otros_nombres);

create index eps_fts_gin_index
    on esclarecimiento.excel_personas_entrevistadas (fts);

create trigger fts_actualizar_excel_pe
    before insert or update
    on esclarecimiento.excel_personas_entrevistadas
    for each row
execute procedure indexar_excel_pe();

