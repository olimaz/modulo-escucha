alter table esclarecimiento.casos_informes
    add cantidad_casos int default 1;

comment on column esclarecimiento.casos_informes.cantidad_casos is 'Usado para los tipo "Caso para la comisión"';
