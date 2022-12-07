
alter table fichas.entrevista
    add borrable int default 0;

comment on column fichas.entrevista.borrable is 'Para marcar los duplicados';

create index entrevista_borrable_index
    on fichas.entrevista (borrable);

