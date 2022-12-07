
drop table if exists analitica.presunto_responsable_individual;
create table if not exists analitica.presunto_responsable_individual
(
    id_hecho_responsable integer
        constraint analitica_presunto_responsable_individual_pk
            primary key,
    id_responsable integer,
    id_entrevista integer,
    id_hecho    integer,
    id_persona integer,
    codigo_entrevista varchar(100),
    nombre text,
    apellido text,
    otros_nombres text,
    edad text,
    sexo text,
    pertenencia_etnica text,
    pertenencia_indigena text,
    actor_armado text,
    rango_cargo  text,
    responsabilidad_ordeno integer default 0,
    responsabilidad_planeo integer default 0,
    responsabilidad_realizo integer default 0,
    responsabilidad_participo integer default 0,
    responsabilidad_no_evito integer default 0,
    nombre_superior text,
    sabe_que_hace_ahora integer default 0,
    ahora_que_hace text,
    ahora_donde_esta text,
    sabe_otros_hechos integer default 0,
    cuales_otros_hechos text,
    insert_fecha_hora text,
    insert_fecha text,
    insert_fecha_mes text,
    update_fecha_hora text,
    update_fecha text,
    update_fecha_mes text

);

alter table analitica.presunto_responsable_individual owner to dba;
GRANT SELECT ON analitica.presunto_responsable_individual  TO solo_lectura;

create index if not exists presunto_responsable_individual_id_entrevista_index
    on analitica.presunto_responsable_individual (id_entrevista);

create index if not exists presunto_responsable_individual_id_persona_index
    on analitica.presunto_responsable_individual (id_persona);

create index if not exists presunto_responsable_individual_codigo_index
    on analitica.presunto_responsable_individual (codigo_entrevista);

comment on column analitica.presunto_responsable_individual.id_hecho_responsable is 'Llave primaria: unión de hecho con responsable';
comment on column analitica.presunto_responsable_individual.id_entrevista is 'Llave foránea a tabla entrevista';
comment on column analitica.presunto_responsable_individual.id_hecho is 'Llave foránea a tabla de violencia';
comment on column analitica.presunto_responsable_individual.id_persona is 'Llave foránea a tabla persona';
comment on column analitica.presunto_responsable_individual.id_responsable is 'Llave foránea a tabla responsable individual';
comment on column analitica.presunto_responsable_individual.nombre is 'Nombres';
comment on column analitica.presunto_responsable_individual.apellido is 'Apellidos';
comment on column analitica.presunto_responsable_individual.otros_nombres is 'Otros nombres';
comment on column analitica.presunto_responsable_individual.edad is 'Rango de edad, al momento de los hechos';
comment on column analitica.presunto_responsable_individual.sexo is 'Sexo del responsable';
comment on column analitica.presunto_responsable_individual.pertenencia_etnica is 'Pertenencia etnico-racial';
comment on column analitica.presunto_responsable_individual.pertenencia_indigena is 'Pertenencia a grupo indígena específico (si aplica)';
comment on column analitica.presunto_responsable_individual.actor_armado is 'Actor armado del que hacía parte';
comment on column analitica.presunto_responsable_individual.rango_cargo is 'Rango o cargo que tenía';
comment on column analitica.presunto_responsable_individual.responsabilidad_ordeno is 'responsabilidad en los hechos: La persona ORDENÓ el/los hechos';
comment on column analitica.presunto_responsable_individual.responsabilidad_planeo is 'responsabilidad en los hechos: La persona PLANEÓ el/los hechos';
comment on column analitica.presunto_responsable_individual.responsabilidad_realizo is 'responsabilidad en los hechos: La persona REALIZÓ el/los hechos';
comment on column analitica.presunto_responsable_individual.responsabilidad_participo is 'responsabilidad en los hechos: La persona PARTICIÓ el/los hechos';
comment on column analitica.presunto_responsable_individual.responsabilidad_no_evito is 'responsabilidad en los hechos: La persona NO ACTUÓ PARA EVITAR que se comietieran los hechos';
comment on column analitica.presunto_responsable_individual.nombre_superior is ' Nombre del superior o el que mandaba en el momento de los hechos';
comment on column analitica.presunto_responsable_individual.sabe_que_hace_ahora is ' ¿Sabe qué hace y dónde está el responsable ahora?';
comment on column analitica.presunto_responsable_individual.ahora_que_hace is ' ¿Qué hace?';
comment on column analitica.presunto_responsable_individual.ahora_donde_esta is '¿Dónde está?';
comment on column analitica.presunto_responsable_individual.sabe_otros_hechos is '¿Sabe si participó en otros hechos de violencia?';
comment on column analitica.presunto_responsable_individual.cuales_otros_hechos is '¿En cuáles?';





