alter table esclarecimiento.entrevistador
    add r3_aa int default 2;

comment on column esclarecimiento.entrevistador.r3_aa is 'desclasificar entrevistas R3 para Actores Armados y Terceros Civiles';

