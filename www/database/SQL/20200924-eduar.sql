drop table if exists  sim.datos_persona;
create table sim.datos_persona
(
    id_datos_persona serial not null,
    id_entrevista integer,
    id_persona integer,
    codigo_entrevista varchar(20),
    informacion_personal text,
    persona_entrevistada text,
    victima_violencia text,
    fh_insert timestamp default now()

);

comment on table sim.datos_persona is 'En formato JSON para el metabuscador';
comment on column sim.datos_persona.id_persona is 'llave foranea a tabla fichas.persona';
comment on column sim.datos_persona.id_persona is 'llave foranea a tabla esclarecimiento.e_ind_fvt';
comment on column sim.datos_persona.codigo_entrevista is 'Referencia';
comment on column sim.datos_persona.informacion_personal is 'Datos compartidos por víctimas y entrevistados';
comment on column sim.datos_persona.persona_entrevistada is 'Datos específicos de los declarantes';
comment on column sim.datos_persona.victima_violencia is 'Datos específicos de las víctimas, información al momento de los hechos';


alter table sim.datos_persona owner to dba;
grant select on sim.datos_persona to solo_lectura;


create index datos_persona_codigo_entrevista_index
    on sim.datos_persona (codigo_entrevista);

create index datos_persona_id_persona_index
    on sim.datos_persona (id_persona);

create index datos_persona_id_entrevista_index
    on sim.datos_persona (id_entrevista);

-- Usuario nuevo
CREATE USER sim_data_lake WITH PASSWORD 'datalake@cev';
GRANT solo_lectura TO sim_data_lake;
