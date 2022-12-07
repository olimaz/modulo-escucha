-- 29-MAR-2022: NUEVA FUNCIONALIDAD: CALIFICAR EL ACCESO A LOS ADJUNTOS DE ENTREVISTAS; CASOS E INFORMES
-- PRIMERA PARTE: CAMBIOS A LA BD PARA CREAR NUEVAS TABLAS Y CAMPOS NECESARIOS PARA LA CALIFICACION DE ARCHIVOS ADJUNTOS


-- Traza
insert into catalogos.criterio_fijo (id_grupo, id_opcion, descripcion) values(21,75,'Calificación de acceso');

-- Nuevos valores
insert into catalogos.criterio_fijo_grupo(id_grupo,descripcion)
    values(125,'Calificación de acceso a la información'), (126,'Justificaciónes para pública clasificada'), (127,'Justificaciones para pública reservada'), (128,'Justificaciones para inteligencia y contrainteligencia');

insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values (125, 1,'Pública') , (125, 2, 'Pública clasificada'), (125, 3, 'Pública reservada'), (125, 4, 'Inteligencia y Contrainteligencia');

insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion)
    values (126,1,'Información exceptuada por daño de derechos a personas naturales o jurídicas. El derecho de toda persona a la intimidad.'),
           (126,2,'Información exceptuada por daño de derechos a personas naturales o jurídicas. El derecho de toda persona a la vida y/o la salud.'),
           (126,3,'Información exceptuada por daño de derechos a personas naturales o jurídicas. El derecho de toda persona a la seguridad.'),
           (126,4,'Información exceptuada por daño de derechos a personas naturales o jurídicas. Los secretos comerciales, industriales y profesionales.'),
           (126,5,'Voluntariedad o manifestación expresa del aportante privado de la información para que la Comisión de la Verdad guarde la confidencialidad.'),
           (126,6,'Entrega de información de entidad pública mediante acta de reserva debidamente justificada.'),
           (127,1,'Información exceptuada por daño a los intereses públicos. La defensa y seguridad nacional'),
           (127,2,'Información exceptuada por daño a los intereses públicos. La seguridad pública.'),
           (127,3,'Información exceptuada por daño a los intereses públicos. Las relaciones internacionales'),
           (127,4,'Información exceptuada por daño a los intereses públicos. La prevención, investigación y persecución de los delitos y las faltas disciplinarias aseguramiento o se formule pliego de cargos, según el caso'),
           (127,5,'Información exceptuada por daño a los intereses públicos. El debido proceso y la igualdad de las partes en los procesos judiciales'),
           (127,6,'Información exceptuada por daño a los intereses públicos. La administración efectiva de la justicia'),
           (127,7,'Información exceptuada por daño a los intereses públicos. Los derechos de la infancia y la adolescencia'),
           (127,8,'Información exceptuada por daño a los intereses públicos. La estabilidad macroeconómica y financiera del país'),
           (127,9,'Información exceptuada por daño a los intereses públicos. La salud pública'),
           (127,10,'Información exceptuada por daño a los intereses públicos. Documentos que contengan las opiniones o puntos de vista que formen parte del proceso deliberativo de los servidores públicos'),
           (127,11,'Voluntariedad o manifestación expresa del aportante privado de la información para que la Comisión de la Verdad guarde la confidencialidad.'),
           (127,12,'Entrega de información de entidad pública mediante acta de reserva debidamente justificada.'),
           (128,1,'Ultrasecreto'),
           (128,2,'Secreto'),
           (128,3,'Confidencial'),
           (128,4,'Restringido');

-- Cambios a tAbla de adjuntos
alter table esclarecimiento.adjunto
    add id_calificacion int;

comment on column esclarecimiento.adjunto.id_calificacion is 'CF 125: acceso a la informacion';

create index adjunto_id_calificacion_index
    on esclarecimiento.adjunto (id_calificacion);


-- Crear tabla de justificaciones
create table esclarecimiento.adjunto_justificacion
(
    id_adjunto_justificacion serial
        constraint adjunto_justificacion_pk
            primary key,
    id_adjunto int not null
        constraint adjunto_justificacion_adjunto_id_adjunto_fk
            references esclarecimiento.adjunto
            on update cascade on delete cascade,
    id_justificacion int not null,
    insert_fh timestamptz default now(),
    insert_id_entrevistador int
        constraint adjunto_justificacion_entrevistador_id_entrevistador_fk
            references esclarecimiento.entrevistador
            on update cascade on delete restrict
);

comment on table esclarecimiento.adjunto_justificacion is 'Justificaciones para la calificación de acceso al adjunto';

create unique index adjunto_justificacion_id_adjunto_id_justificacion_uindex
    on esclarecimiento.adjunto_justificacion (id_adjunto, id_justificacion);

create index adjunto_justificacion_insert_id_entrevistador_index
    on esclarecimiento.adjunto_justificacion (insert_id_entrevistador);

-- crear tabla para control de la calificacion
create table esclarecimiento.excel_control_adjuntos
(
    id_excel_control_adjuntos serial
        constraint excel_control_adjuntos_pk
            primary key,
    id_entrevista integer not null,
    id_adjunto integer not null,
    tipo_entrevista varchar(10),
    codigo_entrevista varchar(20),
    consecutivo integer not null,
    nombre_original text,
    tipo_adjunto varchar(200) not null,
    calificacion text,
    conteo_justificaciones integer default 0,
    justificaciones varchar(100),
    justificacion_01 text,
    justificacion_02 text,
    justificacion_03 text,
    justificacion_04 text,
    justificacion_05 text,
    justificacion_06 text,
    justificacion_07 text,
    justificacion_08 text,
    justificacion_09 text,
    justificacion_10 text
);

comment on table esclarecimiento.excel_control_adjuntos is 'Control de calificación de acceso a los adjuntos';

alter table esclarecimiento.excel_control_adjuntos owner to dba;

create index excel_control_adjuntos_calificacion_index
    on esclarecimiento.excel_control_adjuntos (calificacion);

create index excel_codigo_index
    on esclarecimiento.excel_control_adjuntos (codigo_entrevista);

create index excel_control_adjuntos_id_adjunto_index
    on esclarecimiento.excel_control_adjuntos (id_adjunto);

create index excel_control_adjuntos_id_entrevista_index
    on esclarecimiento.excel_control_adjuntos (id_entrevista);

create index excel_control_adjuntos_tipo_adjunto_index
    on esclarecimiento.excel_control_adjuntos (tipo_adjunto);

create index excel_control_adjuntos_tipo_entrevista_index
    on esclarecimiento.excel_control_adjuntos (tipo_entrevista);

