-- macros
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'ANTIOQUIA Y EJE CAFETERO','AE');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'CARIBE E INSULAR','CI');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'CENTROANDINA','CA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'MAGDALENA MEDIO','MM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'NORORIENTE','NO');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'ORINOQUÍA','OR');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'PACÍFICO','PA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'SURANDINA','SU');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'AMAZONIA','AM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Bogotá y Soacha','BS');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Equipo Nacional / Sede Central','SC');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,1,1,'Internacional','IN');

-- territoriales
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Antioquia ','AE');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Eje Cafetero ','AE');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Urabá ','AE');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Caribe Insular','CI');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Boyaca','CA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Cundinamarca','CA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Huila','CA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Macro Territorial','CA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Tolima','CA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Aguachica','MM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Barrancabermeja','MM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'La Dorada','MM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Territorial Arauca','NO');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Territorial Casanare','NO');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Territorial Norte de Santander','NO');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Territorial Sanatander','NO');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'(en blanco)','NO');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'CAQUETA','OR');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'GUAVIARE','OR');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'MACRO REGIÓN ','OR');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'META','OR');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'BUENAVENTURA','PA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Quibdó','PA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'TUMACO','PA');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Macro Surandina','SU');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Pasto','SU');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Amazonia','AM');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Bogotá','BS');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Equipo Nacional / Sede Central','SC');
insert into catalogos.cev(id_padre,nivel,id_tipo,descripcion,codigo) values (null,2,2,'Europa','IN');

-- actualizar id_padre
update catalogos.cev as hijo
    set id_padre =padre.id_geo
from catalogos.cev as padre
where hijo.codigo = padre.codigo
and hijo.nivel=2;

update catalogos.cev set descripcion=trim(descripcion);

-- defaults
update catalogos.cev set id_tipo=3
where nivel=2 and  descripcion ilike 'Antioquia';

update catalogos.cev set id_tipo=3
where codigo in ('CI','AM','BS','SC','IN') and nivel=2;

update catalogos.cev set id_tipo=3
where nivel=2 and  descripcion ilike 'Aguachica';


update catalogos.cev set id_tipo=3
where nivel=2 and  descripcion ilike '%Macro%';

update catalogos.cev set id_tipo=3
where nivel=2 and  descripcion ilike 'Territorial Arauca';

update catalogos.cev set id_tipo=3
where nivel=2 and  descripcion='BUENAVENTURA';

-- Equivalencias
update catalogos.cat_item
    set texto = id_geo
from catalogos.cev
where id_cat=3 and trim(abreviado)=trim(codigo) and id_tipo=3;


-- actualizar los entrevistadores
update esclarecimiento.entrevistador
set id_territorio = texto::integer
from catalogos.cat_item
where id_macroterritorio=id_item;

update esclarecimiento.entrevistador
set id_macroterritorio=id_padre
from catalogos.cev
where id_territorio=id_geo;


-- actualizar las entrevistas
update esclarecimiento.e_ind_fvt
set id_territorio = texto::integer
from catalogos.cat_item
where id_macroterritorio=id_item;

alter table esclarecimiento.e_ind_fvt drop constraint e_ind_fvt_cat_item_id_item_fk;

update esclarecimiento.e_ind_fvt
set id_macroterritorio=id_padre
from catalogos.cev
where id_territorio=id_geo;



--habilitar FK de id_macro
alter table esclarecimiento.e_ind_fvt
	add constraint e_ind_fvt_cev_id_geo_fk_2
		foreign key (id_macroterritorio) references catalogos.cev
			on update cascade on delete restrict;



