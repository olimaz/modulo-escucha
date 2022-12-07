drop table if exists sim.entrevista_victima;
create table sim.entrevista_victima
(
    id_entrevista_victima     serial not null
        constraint entrevista_victima_pk
        primary key,
    titulo                    varchar(200),
    creador                   varchar(100),
    fecha_inicio_entrevista   varchar(20),
    fecha_fin_entrevista      varchar(20),
    tipo_recurso              text,
    tipo_entrevista           text,
    identificador             varchar(20),
    nivel_descripcion         text,
    derechos_acceso           integer default 4,
    fecha_carga               varchar(20),
    cobertura_temporal_inicio varchar(20),
    cobertura_temporal_fin    varchar(20),
    cobertura_geografica      text,
    lugar_entrevista          text,
    poblacion                 varchar(100),
    derechos                  text,
    actores_conflicto         text,
    hecho_victimizante        text,
    territorio                text,
    areas_interes             text,
    adjuntos                  text,
    transcripcion             text,
    transcripcion_txt         text,
    etiquetado_json           text,
    titulo_entrevista         text,
    sintesis_entrevista       text,
    otros_datos               text,
    procesamiento             text,
    entrevista_codigo         varchar(25),
    priorizacion              text,
    created_at                timestamp,
    updated_at                timestamp
);

comment on table sim.entrevista_victima is 'Tabla para integración de datos';

comment on column sim.entrevista_victima.id_entrevista_victima is 'Autoincrimental, llave primaria';

comment on column sim.entrevista_victima.titulo is 'Código de la entrevista';

comment on column sim.entrevista_victima.creador is 'Código del entrevistador';

comment on column sim.entrevista_victima.fecha_inicio_entrevista is 'Fecha de la entrevista';

comment on column sim.entrevista_victima.fecha_fin_entrevista is 'Fecha de la entrevista';

comment on column sim.entrevista_victima.tipo_recurso is 'Tipo de entrevista, para PR, HV y EE incluye el nombre del sujeto  entrevistado';

comment on column sim.entrevista_victima.tipo_entrevista is 'Tipo de expediente: VI, AA, TC, PR, CO, EE, HV, DC';

comment on column sim.entrevista_victima.identificador is 'Permite rastrear de regreso hacia el sistema.  Código de la entrevista';

comment on column sim.entrevista_victima.nivel_descripcion is 'Texto predefinido';

comment on column sim.entrevista_victima.derechos_acceso is 'Nivel de clasificación';

comment on column sim.entrevista_victima.fecha_carga is 'Fecha de creación en el sistema';

comment on column sim.entrevista_victima.cobertura_temporal_inicio is 'Utiliza anyo de inicio de los hechos';

comment on column sim.entrevista_victima.cobertura_temporal_fin is 'Utiliza anyo de finalización de los hechos';

comment on column sim.entrevista_victima.cobertura_geografica is 'json con los tres niveles';

comment on column sim.entrevista_victima.lugar_entrevista is 'json con lugar de la entrevista';

comment on column sim.entrevista_victima.poblacion is 'Sector con que identifica la persona entrevistada';

comment on column sim.entrevista_victima.derechos is 'Texto predefinido';

comment on column sim.entrevista_victima.actores_conflicto is 'json con codigo y descripción de actores';

comment on column sim.entrevista_victima.hecho_victimizante is 'json con id y descripcion de violaciones';

comment on column sim.entrevista_victima.territorio is 'json con id, macro y territorio';

comment on column sim.entrevista_victima.areas_interes is 'json con arreglo de nucleos, areas y puntos del mandato';

comment on column sim.entrevista_victima.adjuntos is 'JSON con ubicación de archivos adjuntos';

comment on column sim.entrevista_victima.transcripcion is 'JSON del otranscribe';

comment on column sim.entrevista_victima.transcripcion_txt is 'Transcripcion en texto plano, sin html ni json';

comment on column sim.entrevista_victima.etiquetado_json is 'JSON del dataturks';

comment on column sim.entrevista_victima.procesamiento is 'Detalles de la transcripcion, etiquetada, fichas';

comment on column sim.entrevista_victima.priorizacion is 'Evaluación de la entrevista';

alter table sim.entrevista_victima
    owner to dba;
grant select on sim.entrevista_victima to solo_lectura;

create index entrevista_victima_created_at_index
    on sim.entrevista_victima (created_at);

create index entrevista_victima_entrevista_codigo_index
    on sim.entrevista_victima (entrevista_codigo);

create index entrevista_victima_updated_at_index
    on sim.entrevista_victima (updated_at);

