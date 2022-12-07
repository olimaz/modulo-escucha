drop table if exists sim.retroalimentacion_etiquetado;
create table sim.retroalimentacion_etiquetado
(
    id_retroalimentacion_etiquetado serial not null,
    id_entrevistador integer
        constraint retroalimentacion_etiquetado_entrevistador_id_entrevistador_fk
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    fecha_hora timestamp default now(),
    etiqueta text,
    parrafo text,
    comentarios text,
    id_subserie integer,
    id_entrevista integer,
    codigo_entrevista varchar(50)
);

comment on table sim.retroalimentacion_etiquetado is 'Mensajes de retroalimentación de los usuarios';

comment on column sim.retroalimentacion_etiquetado.id_entrevistador is 'Llave foránea para identificar al remitente';

comment on column sim.retroalimentacion_etiquetado.etiqueta is 'Etiqueta reportada';

comment on column sim.retroalimentacion_etiquetado.parrafo is 'Parrafo de referencia';

comment on column sim.retroalimentacion_etiquetado.comentarios is 'retroalimentación del usuario';

comment on column sim.retroalimentacion_etiquetado.id_subserie is 'Llave foranea compuesta';

comment on column sim.retroalimentacion_etiquetado.id_entrevista is 'Llave foranea compuesta';

comment on column sim.retroalimentacion_etiquetado.codigo_entrevista is 'Referencia';

alter table sim.retroalimentacion_etiquetado owner to dba;

create index retroalimentacion_etiquetado_codigo_entrevista_index
    on sim.retroalimentacion_etiquetado (codigo_entrevista);

create index retroalimentacion_etiquetado_etiqueta_index
    on sim.retroalimentacion_etiquetado (etiqueta);

create index retroalimentacion_etiquetado_fecha_hora_index
    on sim.retroalimentacion_etiquetado (fecha_hora);

create index retroalimentacion_etiquetado_id_entrevistador_index
    on sim.retroalimentacion_etiquetado (id_entrevistador);

create index retroalimentacion_etiquetado_id_subserie_id_entrevista_index
    on sim.retroalimentacion_etiquetado (id_subserie, id_entrevista);

alter table sim.retroalimentacion_etiquetado
    add id_etiqueta_entrevista int;

comment on column sim.retroalimentacion_etiquetado.id_etiqueta_entrevista is 'Referencia a la tabla etiqueta_entrevista, por si acaso';

