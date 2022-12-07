drop table if exists esclarecimiento.censo_archivos cascade;
create table esclarecimiento.censo_archivos
(
    id_censo_archivos serial not null
        constraint censo_archivos_pk
        primary key,
    id_macroterritorio integer,
    id_territorio integer,
    id_entrevistador integer,
    numero_entrevistador integer,
    id_subserie integer,
    entrevista_codigo varchar(20),
    entrevista_correlativo integer,
    entrevista_numero integer,
    id_tipo integer
        constraint censo_archivos_cat_item_id_item_fk
        references catalogos.cat_item
        on update cascade on delete restrict,
    perfil_productor text,
    id_nivel_organizacion integer,
    indice text,
    contenido_tematico text,
    sintesis text,
    anio_del integer,
    anio_al integer,
    custodio text,
    direccion text,
    consentimiento_repositorio integer default 2,
    consentimiento_publicar integer default 2,
    id_geo integer
        constraint censo_archivos_geo_id_geo_fk
        references catalogos.geo
        on update cascade on delete restrict,
    contacto_nombre varchar(200),
    contacto_correo varchar(200),
    contacto_telefono varchar(200),
    contacto_url text,
    archivo_fisico integer default 0,
    archivo_fisico_volumen varchar(200),
    archivo_fisico_ubicacion text,
    archivo_electronico integer default 0,
    archivo_electronico_volumen varchar(200),
    archivo_electronico_ubicacion text,
    archivo_virtual integer default 0,
    archivo_virtual_volumen varchar(200),
    archivo_virtual_ubicacion text,
    acceso_publico integer,
    acceso_publico_volumen varchar(200),
    acceso_publico_descripcion text,
    acceso_clasificado integer,
    acceso_clasificado_volumen varchar(200),
    acceso_clasificado_descripcion text,
    acceso_reservado integer,
    acceso_reservado_volumen varchar(200),
    acceso_reservado_descripcion text,
    anotaciones text,
    ficha_diligenciada_nombre varchar(200),
    ficha_diligenciada_telefono varchar(200),
    ficha_diligenciada_correo varchar(200),
    id_activo integer default 1,
    created_at timestamp default now(),
    updated_at timestamp,
    insert_ent integer,
    insert_ip character varying(100),
    insert_fh timestamp default now(),
    update_ent integer,
    update_ip character varying(100),
    update_fh timestamp
);


alter table esclarecimiento.censo_archivos owner to dba;

comment on table esclarecimiento.censo_archivos is 'Censo de archivos en el exilio y otras fuentes';

comment on column esclarecimiento.censo_archivos.archivo_fisico is 'Criterio fijo 2';
comment on column esclarecimiento.censo_archivos.consentimiento_publicar is 'Criterio fijo 2';
comment on column esclarecimiento.censo_archivos.consentimiento_repositorio is 'Criterio fijo 2';

comment on column esclarecimiento.censo_archivos.archivo_electronico is 'Criterio fijo 2';

comment on column esclarecimiento.censo_archivos.archivo_virtual is 'Criterio fijo 2';

comment on column esclarecimiento.censo_archivos.acceso_publico is 'Criterio fijo 150';

comment on column esclarecimiento.censo_archivos.acceso_clasificado is 'Criterio fijo 150';
comment on column esclarecimiento.censo_archivos.id_nivel_organizacion is 'Catalogo 356';


comment on column esclarecimiento.censo_archivos.acceso_reservado is 'Criterio fijo 150';
comment on column esclarecimiento.censo_archivos.entrevista_correlativo is 'Consecutivo general de toda la tabla, utilizada en el codigo';

comment on column esclarecimiento.censo_archivos.entrevista_numero is 'Consecutivo de cada entrevistador.  Se almacena como referencia';



create index censo_archivos_acceso_clasificado_index
    on esclarecimiento.censo_archivos (acceso_clasificado);

create index censo_archivos_acceso_publico_index
    on esclarecimiento.censo_archivos (acceso_publico);

create index censo_archivos_acceso_reservado_index
    on esclarecimiento.censo_archivos (acceso_reservado);

create index censo_archivos_archivo_electronico_index
    on esclarecimiento.censo_archivos (archivo_electronico);

create index censo_archivos_archivo_fisico_index
    on esclarecimiento.censo_archivos (archivo_fisico);

create index censo_archivos_archivo_virtual_index
    on esclarecimiento.censo_archivos (archivo_virtual);

create index censo_archivos_id_tipo_index
    on esclarecimiento.censo_archivos (id_tipo);

create index censo_archivos_entrevista_codigo_index
    on esclarecimiento.censo_archivos (entrevista_codigo);

create index censo_archivos_entrevista_correlativo_index
    on esclarecimiento.censo_archivos (entrevista_correlativo);

create index censo_archivos_entrevista_numero_index
    on esclarecimiento.censo_archivos (entrevista_numero);

create index censo_archivos_id_entrevistador_index
    on esclarecimiento.censo_archivos (id_entrevistador);

create index censo_archivos_id_macroterritorio_index
    on esclarecimiento.censo_archivos (id_macroterritorio);

create index censo_archivos_id_territorio_index
    on esclarecimiento.censo_archivos (id_territorio);

create index censo_archivos_id_nivel_organizacion_index
    on esclarecimiento.censo_archivos (id_nivel_organizacion);

alter table esclarecimiento.censo_archivos
    add constraint censo_archivos_cev_id_geo_fk
        foreign key (id_macroterritorio) references catalogos.cev
            on update cascade on delete restrict;

alter table esclarecimiento.censo_archivos
    add constraint censo_archivos_cev_id_geo_fk_2
        foreign key (id_territorio) references catalogos.cev
            on update cascade on delete restrict;

alter table esclarecimiento.censo_archivos
    add constraint censo_archivos_entrevistador_id_entrevistador_fk
        foreign key (id_entrevistador) references esclarecimiento.entrevistador
            on update cascade on delete restrict;

alter table esclarecimiento.censo_archivos
    add constraint censo_archivos_cat_item_id_item_fk_5
        foreign key (id_nivel_organizacion) references catalogos.cat_item
            on update cascade on delete restrict;




alter table esclarecimiento.censo_archivos
    add constraint censo_archivos_cat_item_id_item_fk_2
        foreign key (acceso_reservado) references catalogos.cat_item
            on update cascade on delete restrict;

alter table esclarecimiento.censo_archivos
    add constraint censo_archivos_cat_item_id_item_fk_3
        foreign key (acceso_publico) references catalogos.cat_item
            on update cascade on delete restrict;

alter table esclarecimiento.censo_archivos
    add constraint censo_archivos_cat_item_id_item_fk_4
        foreign key (acceso_clasificado) references catalogos.cat_item
            on update cascade on delete restrict;







-- Tablas de detalle
drop table if exists esclarecimiento.censo_archivos_detalle cascade;
create table esclarecimiento.censo_archivos_detalle
(
    id_censo_archivos_detalle serial not null
        constraint censo_archivos_detalle_pk
        primary key,
    id_censo_archivos integer
        constraint censo_archivos_detalle_censo_archivos_id_censo_archivos_fk
        references esclarecimiento.censo_archivos
        on update cascade on delete cascade,
    id_opcion integer
        constraint censo_archivos_detalle_cat_item_id_item_fk
        references catalogos.cat_item
        on update cascade on delete restrict
);

comment on table esclarecimiento.censo_archivos_detalle is 'Opciones de riesgo sociopolitico, ambiental y otras opciones de seleccion multiple';

alter table esclarecimiento.censo_archivos_detalle owner to dba;

create unique index censo_archivos_detalle_id_censo_archivos_id_opcion_uindex
    on esclarecimiento.censo_archivos_detalle (id_censo_archivos, id_opcion);




--
drop table if exists esclarecimiento.censo_archivos_temas cascade;
create table esclarecimiento.censo_archivos_temas
(
    id_censo_archivos_temas serial not null
        constraint censo_archivos_temas_pk
        primary key,
    id_censo_archivos integer
        constraint censo_archivos_temas_censo_archivos_id_censo_archivos_fk
        references esclarecimiento.censo_archivos
        on update cascade on delete cascade,
    nombre varchar(200),
    descripcion text
);

comment on table esclarecimiento.censo_archivos_temas is 'Temas del censo de archivos en el exilio';

alter table esclarecimiento.censo_archivos_temas owner to dba;

create index censo_archivos_temas_id_censo_archivos_index
    on esclarecimiento.censo_archivos_temas (id_censo_archivos);

create index censo_archivos_temas_nombre_index
    on esclarecimiento.censo_archivos_temas (nombre);




--Adjuntos
drop table if exists  esclarecimiento.censo_archivos_adjunto cascade;
create table esclarecimiento.censo_archivos_adjunto
(
    id_censo_archivos_adjunto serial not null
        constraint censo_archivos_adjunto_pk
            primary key,
    id_censo_archivos integer not null
        constraint censo_archivos_adjunto_id_censo_archivos_fk
            references esclarecimiento.censo_archivos
            on update cascade on delete cascade,
    descripcion varchar(200) not null,
    id_adjunto integer not null
        constraint censo_archivos_adjunto_adjunto_id_adjunto_fk
            references esclarecimiento.adjunto
            on update cascade on delete restrict,
    fh_insert timestamp default now(),
    codigo_adjunto varchar(25),
    correlativo_caso integer default 1
);

comment on table esclarecimiento.censo_archivos_adjunto is 'Adjuntos a Censo de archvios';


comment on column esclarecimiento.censo_archivos_adjunto.codigo_adjunto is 'Identificador del adjunto, calculado en función del codigo del censo y el adjunto';

comment on column esclarecimiento.censo_archivos_adjunto.correlativo_caso is 'Calculado para cada id_censo_archivos';

alter table esclarecimiento.censo_archivos_adjunto owner to dba;

create index censo_archivos_adjunto_codigo_index
    on esclarecimiento.censo_archivos_adjunto (codigo_adjunto);

create index censo_archivos_adjunto_correlativo_index
    on esclarecimiento.censo_archivos_adjunto (correlativo_caso);

create index censo_archivos_adjunto_descripcion_index
    on esclarecimiento.censo_archivos_adjunto (descripcion);

create index censo_archivos_adjunto_id_adjunto_index
    on esclarecimiento.censo_archivos_adjunto (id_adjunto);

create index censo_archivos_adjunto_id_censo_archivos
    on esclarecimiento.censo_archivos_adjunto (id_censo_archivos);


