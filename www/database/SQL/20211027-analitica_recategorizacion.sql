alter table analitica.entrevista_impactos
    add recategorizado text;

comment on column analitica.entrevista_impactos.recategorizado is 'si lo hubiera, presenta el nuevo valor que corresponde al proceso de recategorización';


alter table analitica.entrevista_afrontamientos
    add recategorizado text;

comment on column analitica.entrevista_afrontamientos.recategorizado is 'si lo hubiera, presenta el nuevo valor que corresponde al proceso de recategorización';


alter table analitica.entrevista_no_repeticion
    add recategorizado text;

comment on column analitica.entrevista_no_repeticion.recategorizado is 'si lo hubiera, presenta el nuevo valor que corresponde al proceso de recategorización';
