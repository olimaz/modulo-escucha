-- Organizaciones a las que pertenece
drop table if exists analitica.persona_organizacion;
create table if not exists analitica.persona_organizacion
(
    id_persona_organizacion serial
        constraint persona_organizacion_pk
            primary key,
    id_persona              integer,
    institucion_tipo        text,
    institucion_nombre      text,
    rol                     text
);
comment on table analitica.persona_organizacion is 'Instituciones de las que formaba parte la persona (víctima o persona entrevistada)';

alter table analitica.persona_organizacion owner to dba;
grant select on analitica.persona_organizacion to solo_lectura;

create index if not exists persona_organizacion_id_persona_index
    on analitica.persona_organizacion (id_persona);


comment on column analitica.persona_organizacion.id_persona_organizacion is 'Llave primaria';
comment on column analitica.persona_organizacion.id_persona is 'Llave foranea a víctimas o a persona entrevistada';
comment on column analitica.persona_organizacion.institucion_tipo is 'Tipo de institución a la que pertenecía';
comment on column analitica.persona_organizacion.institucion_nombre is 'Nombre de institución a la que pertenecía';
comment on column analitica.persona_organizacion.rol is 'Rol que desempeñaba en la institución a la que pertenecía';


--

-- Autoridad etnica
drop table if exists analitica.persona_autoridad_etnica;
create table if not exists analitica.persona_autoridad_etnica
(
    id_persona_autoridad_etnica serial
        constraint persona_autoridad_etnica_pk
            primary key,
    id_persona              integer,
    autoridad        text
);
comment on table analitica.persona_autoridad_etnica is 'Personas (víctimas/entrevistadas). Es autoridad étnico territorial';

alter table analitica.persona_autoridad_etnica owner to dba;
grant select on analitica.persona_autoridad_etnica to solo_lectura;

create index if not exists persona_autoridad_etnica_id_persona_index
    on analitica.persona_autoridad_etnica (id_persona);


comment on column analitica.persona_autoridad_etnica.id_persona_autoridad_etnica is 'Llave primaria';
comment on column analitica.persona_autoridad_etnica.id_persona is 'Llave foranea a víctimas o a persona entrevistada';
comment on column analitica.persona_autoridad_etnica.autoridad is 'Tipo de autoridad especificada';
