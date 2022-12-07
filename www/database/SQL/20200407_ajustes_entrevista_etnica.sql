-- Script SQL 2 abril 2020
/*update catalogos.cat_item set predeterminado = 2 where id_cat = 276;
update catalogos.cat_item set predeterminado = 2 where id_cat = 269;
*/

alter table fichas.entrevista_impacto add id_reparacion_etnica int;
alter table esclarecimiento.entrevista_etnica add id_prioritario int;
alter table esclarecimiento.entrevista_etnica add prioritario_tema varchar(100);
