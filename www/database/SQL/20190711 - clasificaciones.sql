alter table esclarecimiento.e_ind_fvt
	add clasifica_nna int default 1;

comment on column esclarecimiento.e_ind_fvt.clasifica_nna is '1:Si,2:No';

alter table esclarecimiento.e_ind_fvt
	add clasifica_sex int default 1;

comment on column esclarecimiento.e_ind_fvt.clasifica_sex is '1:Si,2:No';

alter table esclarecimiento.e_ind_fvt
	add clasifica_res int default 1;

comment on column esclarecimiento.e_ind_fvt.clasifica_res is '1:Si,2:No';

alter table esclarecimiento.e_ind_fvt
	add clasifica_nivel int default 3;

comment on column esclarecimiento.e_ind_fvt.clasifica_nivel is 'Niveles de acceso a informacion reservada (3 o 4)';

create index e_ind_fvt_clasifica_nivel_index
	on esclarecimiento.e_ind_fvt (clasifica_nivel);


-- Aplicar clasificacion a registros existentes

-- todos a nivel 4
update esclarecimiento.e_ind_fvt
set clasifica_nivel=4, clasifica_nna=2, clasifica_res=2, clasifica_sex=2
where true;

-- cambiar a nivel 3 los NNA
update esclarecimiento.e_ind_fvt
     set clasifica_nivel=3, clasifica_nna=1
     where nna=1;

-- cambiar a nivel 3 los de violencia sexual: buscar el id para violencia sexual (35 en el ejemplo)
update esclarecimiento.e_ind_fvt
set clasifica_nivel=3, clasifica_sex=1
from esclarecimiento.e_ind_fvt_tv
where e_ind_fvt.id_e_ind_fvt= e_ind_fvt_tv.id_e_ind_fvt and e_ind_fvt_tv.id_tv=35;


-- cambiar a nivel 3 los de Terceros Civiles/Actores armados: buscar el id en .env (4,98 en el ejemplo)
update esclarecimiento.e_ind_fvt
set clasifica_nivel=3, clasifica_res=1
from esclarecimiento.e_ind_fvt_tv
where id_subserie in (4,98);


---- Casos e informes

alter table esclarecimiento.casos_informes
	add clasifica_nna int default 1;

comment on column esclarecimiento.casos_informes.clasifica_nna is '1:Si,2:No';

alter table esclarecimiento.casos_informes
	add clasifica_sex int default 1;

comment on column esclarecimiento.casos_informes.clasifica_sex is '1:Si,2:No';

alter table esclarecimiento.casos_informes
	add clasifica_res int default 1;

comment on column esclarecimiento.casos_informes.clasifica_res is '1:Si,2:No';

alter table esclarecimiento.casos_informes
	add clasifica_nivel int default 3;

comment on column esclarecimiento.casos_informes.clasifica_nivel is 'Niveles de acceso a informacion reservada (3 o 4)';

create index casos_informes_clasifica_nivel_index
	on esclarecimiento.casos_informes (clasifica_nivel);


-- Aplicar clasificacion a registros existentes

-- todos a nivel 4
update esclarecimiento.casos_informes
set clasifica_nivel=4, clasifica_nna=2, clasifica_res=2, clasifica_sex=2
where true;

