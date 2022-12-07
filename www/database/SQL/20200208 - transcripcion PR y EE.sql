alter table esclarecimiento.entrevista_etnica_adjunto
    add id_transcripcion int;

create index entrevista_etnica_adjunto_id_transcripcion_index
    on esclarecimiento.entrevista_etnica_adjunto (id_transcripcion);


alter table esclarecimiento.adjunto
    add tamano int;

alter table esclarecimiento.adjunto
    add md5 varchar(100);

alter table esclarecimiento.adjunto alter column tamano type bigint using tamano::bigint;
create index adjunto_md5_index
    on esclarecimiento.adjunto (md5);


--
alter table esclarecimiento.entrevista_etnica_adjunto alter column id_usuario drop not null;
alter table esclarecimiento.entrevista_profundidad_adjunto alter column id_usuario drop not null;


