drop table if exists analitica.exilio_victimas;
create table analitica.exilio_victimas
(
    id_exilio_victimas serial,
    id_entrevista integer,
    id_persona integer,
    id_victima integer,
    id_hecho integer,
    codigo_entrevista varchar(20),
    nombres varchar(200),
    apellidos varchar(200),
    otros_nombres varchar(200),
    sexo varchar(100),
    orientacion_sexual varchar(200),
    identidad_genero varchar(200),
    edad integer,
    ocupacion varchar(200),
    estado_civil varchar(200),
    pertenencia_etnica varchar(200),
    pertenencia_indigena varchar(200),
    lugar_residencia varchar(200),
    lugar_residencia_codigo varchar(20),
    lugar_nacimiento varchar(200),
    lugar_nacimiento_codigo varchar(20),
    fecha_exilio_anio integer,
    fecha_exilio_mes integer,
    fecha_exilio_dia integer,
    lugar_exilio varchar(200),
    lugar_exilio_codigo varchar(20)
);

comment on table analitica.exilio_victimas is 'Victimas de exilio, extraidas de la ficha larga';

comment on column analitica.exilio_victimas.codigo_entrevista is 'Utilizado como referencia';

comment on column analitica.exilio_victimas.id_entrevista is 'referencia a entrevista inidividual a familliares victimas y testigos';


comment on column analitica.exilio_victimas.id_persona is 'referencia a tabla de personas';

comment on column analitica.exilio_victimas.id_victima is 'referencia a tabla de victimas';

comment on column analitica.exilio_victimas.id_hecho is 'referenia a tabla de violencia';

comment on column analitica.exilio_victimas.edad is 'edad al momento de los hechos';

comment on column analitica.exilio_victimas.ocupacion is 'ocupación al momento de los hechos';

comment on column analitica.exilio_victimas.lugar_residencia is 'Lugar de residencia al momento de los hechos';

comment on column analitica.exilio_victimas.lugar_residencia_codigo is 'Código del lugar de residencia al momento de los hechos';

comment on column analitica.exilio_victimas.lugar_nacimiento is 'Lugar de nacimiento de la víctima';

comment on column analitica.exilio_victimas.lugar_nacimiento_codigo is 'Código del lugar de nacimiento de la víctima';

comment on column analitica.exilio_victimas.fecha_exilio_anio is 'Año en que ocurre el exilio';

comment on column analitica.exilio_victimas.fecha_exilio_mes is 'Mes en que ocurre el exilio';

comment on column analitica.exilio_victimas.fecha_exilio_dia is 'día en que ocurre el exilio';
comment on column analitica.exilio_victimas.lugar_exilio is 'De acuerdo a la ficha larga';
comment on column analitica.exilio_victimas.lugar_exilio_codigo is 'De acuerdo a la ficha larga';

alter table analitica.exilio_victimas owner to dba;
grant select on analitica.exilio_victimas to solo_lectura;

create index exilio_victimas_codigo_entrevista_index
    on analitica.exilio_victimas (codigo_entrevista);

create index exilio_victimas_id_entrevista_index
    on analitica.exilio_victimas (id_entrevista);



create index exilio_victimas_id_hecho_index
    on analitica.exilio_victimas (id_hecho);

create index exilio_victimas_id_persona_index
    on analitica.exilio_victimas (id_persona);

create index exilio_victimas_id_victima_index
    on analitica.exilio_victimas (id_victima);


alter table analitica.exilio_victimas
    add constraint exilio_victimas_pk
        primary key (id_exilio_victimas);


