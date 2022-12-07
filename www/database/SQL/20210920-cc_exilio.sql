drop table if exists sim.cc_exilio;
create table sim.cc_exilio
(
    id_cc_exilio serial
        constraint cc_exilio_pk
            primary key,
    id_entrevista integer not null
        constraint cc_exilio_e_ind_fvt_id_e_ind_fvt_fk
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    codigo_entrevista varchar(20) not null,
    clasificacion integer default 0,
    macroterritorio varchar(200),
    territorio varchar(200),
    entrevistador varchar(200),
    fecha_entrevista varchar(20),
    metadato varchar(10) default 'No'::character varying,
    ficha_exilio varchar(10) default 'No'::character varying,
    ficha_larga varchar(10) default 'No'::character varying,
    grupo varchar(100),
    created_at timestamp with time zone default now()

);

comment on table sim.cc_exilio is 'Controles de Calidad de exilio';

alter table sim.cc_exilio owner to dba;
GRANT SELECT ON sim.cc_exilio TO solo_lectura;


create index cc_exilio_codigo_entrevista_index
    on sim.cc_exilio (codigo_entrevista);

create index cc_exilio_id_entrevista_index
    on sim.cc_exilio (id_entrevista);

create index if not exists cc_exilio_ficha_exilio_index
    on sim.cc_exilio (ficha_exilio);

create index if not exists cc_exilio_ficha_larga_index
    on sim.cc_exilio (ficha_larga);

create index if not exists cc_exilio_metadato_index
    on sim.cc_exilio (metadato);

