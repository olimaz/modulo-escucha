alter table transcribir_asignacion alter column created_at set default current_timestamp;

alter table transcribir_asignacion
	add fh_anulado timestamp(0);

alter table transcribir_asignacion
	add fh_inicio timestamp(0);

alter table transcribir_asignacion
	add fh_fin timestamp(0);

alter table transcribir_asignacion
	add terceros int default 2;

alter table transcribir_asignacion
	add duracion_transcripcion_minutos int default 0;
alter table transcribir_asignacion
	add duracion_transcripcion_real_minutos int default 0;


alter table transcribir_asignacion alter column id_e_ind_fvt drop not null;

alter table transcribir_asignacion
	add id_entrevista_profundidad int;

alter table transcribir_asignacion
	add id_entrevista_colectiva int;

alter table transcribir_asignacion
	add id_entrevista_etnica int;

alter table transcribir_asignacion
	add id_diagnostico_comunitario int;

alter table transcribir_asignacion
	add id_historia_vida int;


create index transcribir_asignacion_id_diagnostico_comunitario_index
	on transcribir_asignacion (id_diagnostico_comunitario);

create index transcribir_asignacion_id_entrevista_colectiva_index
	on transcribir_asignacion (id_entrevista_colectiva);

create index transcribir_asignacion_id_entrevista_etnica_index
	on transcribir_asignacion (id_entrevista_etnica);

create index transcribir_asignacion_id_entrevista_profundidad_index
	on transcribir_asignacion (id_entrevista_profundidad);

create index transcribir_asignacion_id_historia_vida_index
	on transcribir_asignacion (id_historia_vida);

alter table transcribir_asignacion
	add constraint transcribir_asignacion_diagnostico_comunitario_id_diagnostico_comunitario_fk
		foreign key (id_diagnostico_comunitario) references esclarecimiento.diagnostico_comunitario
			on update cascade on delete cascade;

alter table transcribir_asignacion
	add constraint transcribir_asignacion_entrevista_colectiva_id_entrevista_colectiva_fk
		foreign key (id_entrevista_colectiva) references esclarecimiento.entrevista_colectiva
			on update cascade on delete cascade;

alter table transcribir_asignacion
	add constraint transcribir_asignacion_entrevista_etnica_id_entrevista_etnica_fk
		foreign key (id_entrevista_etnica) references esclarecimiento.entrevista_etnica
			on update cascade on delete cascade;

alter table transcribir_asignacion
	add constraint transcribir_asignacion_entrevista_profundidad_id_entrevista_profundidad_fk
		foreign key (id_entrevista_profundidad) references esclarecimiento.entrevista_profundidad
			on update cascade on delete cascade;

alter table transcribir_asignacion
	add constraint transcribir_asignacion_historia_vida_id_historia_vida_fk
		foreign key (id_historia_vida) references esclarecimiento.historia_vida
			on update cascade on delete cascade;





