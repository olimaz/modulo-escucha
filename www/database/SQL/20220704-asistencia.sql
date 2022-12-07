
alter table fichas.entrevista
    add asistencia int default 2;

comment on column fichas.entrevista.asistencia is '1=sí.   Listados de asistencia, se muestran junto a los consentimientos informados, sin la información del consentimiento.

Se mantienen en esta tabla para tener un mejor reporte de personas entrevistadas';

--
