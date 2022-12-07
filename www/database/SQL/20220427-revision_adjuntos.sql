alter table esclarecimiento.adjunto
    add existe_archivo int default 0;

comment on column esclarecimiento.adjunto.existe_archivo is '1 indica que el archivo fue ubicado';

create index adjunto_existe_index
    on esclarecimiento.adjunto (existe_archivo);

