
alter table esclarecimiento.mis_casos_adjunto
    add correlativo_caso int default 1;

alter table esclarecimiento.mis_casos_adjunto
    add codigo_adjunto varchar(25);

comment on column esclarecimiento.mis_casos_adjunto.codigo_adjunto is 'Identificador del adjunto, calculado en función del codigo del caso y el id_mis_casos_adjunto';

create index mis_casos_adjunto_codigo_index
    on esclarecimiento.mis_casos_adjunto (codigo_adjunto);


comment on column esclarecimiento.mis_casos_adjunto.correlativo_caso is 'Calculado para cada id_mis_casos';



--
drop index esclarecimiento.mis_casos_adjunto_codigo_index;

create unique index mis_casos_adjunto_codigo_index
    on esclarecimiento.mis_casos_adjunto (codigo_adjunto);