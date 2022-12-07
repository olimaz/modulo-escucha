drop table if exists esclarecimiento.mis_casos_adjunto_compartir;
create table esclarecimiento.mis_casos_adjunto_compartir
(
    id_mis_casos_adjunto_compartir serial not null,
    id_mis_casos_adjunto integer
        constraint mis_casos_adjunto_compartir_mis_casos_adjunto_id_mis_casos_adju
            references esclarecimiento.mis_casos_adjunto
            on update cascade on delete cascade,
    id_autorizador integer
        constraint mis_casos_adjunto_compartir_entrevistador_id_entrevistador_fk_2
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    id_autorizado integer
        constraint mis_casos_adjunto_compartir_entrevistador_id_entrevistador_fk
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    anotaciones text,
    id_situacion integer default 1,
    fh_autorizado timestamp default now(),
    fh_revocado timestamp
);

comment on table esclarecimiento.mis_casos_adjunto_compartir is 'Autorizaciones de acceso a adjuntos de casos transversales ';
comment on column esclarecimiento.mis_casos_adjunto_compartir.id_mis_casos_adjunto is 'Archivo autorizado';
comment on column esclarecimiento.mis_casos_adjunto_compartir.id_autorizador is 'Quien autoriza';
comment on column esclarecimiento.mis_casos_adjunto_compartir.id_autorizado is 'A quien se autoriza';
comment on column esclarecimiento.mis_casos_adjunto_compartir.id_situacion is '1: activo; cualquier otro valor, inactivo.  Criterio fijo 11';
comment on column esclarecimiento.mis_casos_adjunto_compartir.fh_autorizado is 'Marca de tiempo de cuando se autoriza';
comment on column esclarecimiento.mis_casos_adjunto_compartir.fh_revocado is 'Marca de tiempo de cuando se quita la autorizacion';

alter table esclarecimiento.mis_casos_adjunto_compartir owner to dba;

create index mis_casos_adjunto_compartir_id_autorizado_index
    on esclarecimiento.mis_casos_adjunto_compartir (id_autorizado);

create index mis_casos_adjunto_compartir_id_autorizador_index
    on esclarecimiento.mis_casos_adjunto_compartir (id_autorizador);

create index mis_casos_adjunto_compartir_id_mis_casos_adjunto_index
    on esclarecimiento.mis_casos_adjunto_compartir (id_mis_casos_adjunto);

create index mis_casos_adjunto_compartir_id_situacion_index
    on esclarecimiento.mis_casos_adjunto_compartir (id_situacion);


insert into catalogos.criterio_fijo(id_grupo, id_opcion, descripcion) values(21,24,'Revocar acceso');



