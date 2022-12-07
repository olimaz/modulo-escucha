create table etiquetar_asignacion
(
    id_etiquetar_asignacion serial not null
        constraint etiquetar_asignacion_pkey
            primary key,
    id_e_ind_fvt integer
        constraint public_etiquetar_asignacion_id_e_ind_fvt_foreign
            references esclarecimiento.e_ind_fvt
            on update cascade on delete cascade,
    id_entrevista_profundidad integer
        constraint etiquetar_asignacion_entrevista_profundidad_id_entrevista_pro
            references esclarecimiento.entrevista_profundidad
            on update cascade on delete cascade,
    id_entrevista_colectiva integer
        constraint etiquetar_asignacion_entrevista_colectiva_id_entrevista_colec
            references esclarecimiento.entrevista_colectiva
            on update cascade on delete cascade,
    id_entrevista_etnica integer
        constraint etiquetar_asignacion_entrevista_etnica_id_entrevista_etnica_f
            references esclarecimiento.entrevista_etnica
            on update cascade on delete cascade,
    id_diagnostico_comunitario integer
        constraint etiquetar_asignacion_diagnostico_comunitario_id_diagnostico_c
            references esclarecimiento.diagnostico_comunitario
            on update cascade on delete cascade,
    id_historia_vida integer
        constraint etiquetar_asignacion_historia_vida_id_historia_vida_fk
            references esclarecimiento.historia_vida
            on update cascade on delete cascade,
    id_autoriza integer not null
        constraint public_etiquetar_asignacion_id_autoriza_foreign
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    id_transcriptor integer not null
        constraint public_etiquetar_asignacion_id_transcriptor_foreign
            references esclarecimiento.entrevistador
            on update cascade on delete restrict,
    id_situacion integer default 1 not null,
    id_causa integer
        constraint public_etiquetar_asignacion_id_causa_foreign
            references catalogos.cat_item
            on update cascade on delete restrict,
    urgente integer default 2 not null,
    observaciones text,
    fh_asignado timestamp(0) not null,
    fh_revocado timestamp(0),
    fh_transcrito timestamp(0),
    fh_anulado timestamp(0),
    fh_inicio timestamp(0),
    fh_fin timestamp(0),
    terceros integer default 2,
    duracion_etiquetado_minutos integer default 0,
    duracion_etiquetado_real_minutos integer default 0,
    created_at timestamp(0) default CURRENT_TIMESTAMP,
    updated_at timestamp(0)

);

alter table etiquetar_asignacion owner to dba;

create index public_etiquetar_asignacion_id_e_ind_fvt_index
    on etiquetar_asignacion (id_e_ind_fvt);

create index public_etiquetar_asignacion_id_autoriza_index
    on etiquetar_asignacion (id_autoriza);

create index public_etiquetar_asignacion_id_transcriptor_index
    on etiquetar_asignacion (id_transcriptor);

create index public_etiquetar_asignacion_id_causa_index
    on etiquetar_asignacion (id_causa);

create index public_etiquetar_asignacion_id_situacion_index
    on etiquetar_asignacion (id_situacion);

create index public_etiquetar_asignacion_urgente_index
    on etiquetar_asignacion (urgente);

create index etiquetar_asignacion_id_diagnostico_comunitario_index
    on etiquetar_asignacion (id_diagnostico_comunitario);

create index etiquetar_asignacion_id_entrevista_colectiva_index
    on etiquetar_asignacion (id_entrevista_colectiva);

create index etiquetar_asignacion_id_entrevista_etnica_index
    on etiquetar_asignacion (id_entrevista_etnica);

create index etiquetar_asignacion_id_entrevista_profundidad_index
    on etiquetar_asignacion (id_entrevista_profundidad);

create index etiquetar_asignacion_id_historia_vida_index
    on etiquetar_asignacion (id_historia_vida);

--
INSERT INTO catalogos.criterio_fijo_grupo (id_grupo, descripcion) VALUES (9, 'Estado de asignación de etiquetado');
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (9, 1, 'Asignado', 1);
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (9, 2, 'Etiquetado', 3);
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (9, 3, 'Revocado', 2);
INSERT INTO catalogos.criterio_fijo (id_grupo, id_opcion, descripcion, orden) VALUES (9, 4, 'No etiquetado', 4);

--
insert into catalogos.criterio_fijo (id_grupo, id_opcion, descripcion)
values (1,25,'Documento de etiquetado');

--
insert into catalogos.criterio_fijo (id_grupo, id_opcion, descripcion) values (21,17,'Asignar etiquetado');
insert into catalogos.criterio_fijo (id_grupo, id_opcion, descripcion) values (21,18,'Revocar etiquetado');
insert into catalogos.criterio_fijo (id_grupo, id_opcion, descripcion) values (21,19,'Finalizar etiquetado');

--
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES (86, 'Causas por las que no se etiqueta la entrevista', 'Usado en el panel de asignar etiquetado', 1);
insert into catalogos.cat_item(id_cat,descripcion) values (86,'Transcripción incompleta / inadecuada / ilegible')

