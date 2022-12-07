alter table transcribir_asignacion
	add id_casos_informes int;

create index transcribir_asignacion_id_casos_informes_index
	on transcribir_asignacion (id_casos_informes);

alter table etiquetar_asignacion
	add id_casos_informes int;

create index etiquetar_asignacion_id_casos_informes_index
	on etiquetar_asignacion (id_casos_informes);


