alter table catalogos.cat_cat
	add otro_cual int default 2;

comment on column catalogos.cat_cat.otro_cual is '1: Sí; 2:No.  En desarrollo, me permite determinar si puedo agregar la opcion "otro, ¿cual?"';

