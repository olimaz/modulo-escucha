alter table esclarecimiento.e_ind_fvt
	add fichas_alarmas text;
comment on column esclarecimiento.e_ind_fvt.fichas_alarmas is 'json con arreglo de alertas';

alter table esclarecimiento.e_ind_fvt
	add fichas_estado int default 0;

comment on column esclarecimiento.e_ind_fvt.fichas_estado is '0: Desconocido; 1: Diligenciado; 2: Incompleto/No Diligenciado';

create index e_ind_fvt_fichas_estado_index
	on esclarecimiento.e_ind_fvt (fichas_estado);
