
create table acceso_edicion
(
	id_acceso_edicion serial not null
		constraint modificar_asignacion_pk
			primary key,
	id_entrevista integer not null,
	id_subserie integer not null,
	id_autoriza integer not null
		constraint modificar_asignacion_entrevistador_id_entrevistador_fk_2
			references esclarecimiento.entrevistador
				on update restrict on delete restrict,
	id_autorizado integer not null
		constraint modificar_asignacion_entrevistador_id_entrevistador_fk
			references esclarecimiento.entrevistador
				on update restrict on delete restrict,
	observaciones text,
	id_situacion integer default 1,
	id_revocado integer
		constraint modificar_asignacion_entrevistador_id_entrevistador_fk_3
			references esclarecimiento.entrevistador
				on update restrict on delete restrict,
	fh_autorizado timestamp default now() not null,
	fh_revocado timestamp
);

comment on table acceso_edicion is 'Permite facilitar permisos de escritura a entrevistas';

comment on column acceso_edicion.id_entrevista is 'Llave primaria de la tabla foranea';

comment on column acceso_edicion.id_subserie is 'Permite saber a qué tabla apunta el campo id_entrevista';

comment on column acceso_edicion.id_autoriza is 'id_entrevistador que autoriza el acceso';

comment on column acceso_edicion.id_autorizado is 'id_entrevistador al que se facilita el acceso';

comment on column acceso_edicion.id_situacion is 'Criterio fijo 11';

comment on column acceso_edicion.id_revocado is 'id_entrevistador de quien revoca el permiso';

alter table acceso_edicion owner to dba;

create index modificar_asignacion_fh_autorizado_index
	on acceso_edicion (fh_autorizado);

create index modificar_asignacion_id_autoriza_index
	on acceso_edicion (id_autoriza);

create index modificar_asignacion_id_autorizado_index
	on acceso_edicion (id_autorizado);

create index modificar_asignacion_id_entrevista_index
	on acceso_edicion (id_entrevista);

create index modificar_asignacion_id_revocado_index
	on acceso_edicion (id_revocado);

create index modificar_asignacion_id_situacion_index
	on acceso_edicion (id_situacion);

create index modificar_asignacion_id_subserie_index
	on acceso_edicion (id_subserie);



-- Crear criterio fijo para el estado del acceso otorgado para edicion
INSERT INTO "catalogos"."criterio_fijo_grupo" ("id_grupo", "descripcion") VALUES (11, 'Estado del acceso para edición');
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (11, 1, 'Vigente', DEFAULT);
INSERT INTO "catalogos"."criterio_fijo" ("id_grupo", "id_opcion", "descripcion", "orden") VALUES (11, 2, 'Revocado', DEFAULT);

-- todos los solo lectura a entrevistador
update esclarecimiento.entrevistador
    set id_nivel=5
    where solo_lectura=1;


--quitar los solo lectura
update esclarecimiento.entrevistador
    set solo_lectura=2;


-- AA y TC se vuelven R-3
select *
    from esclarecimiento.e_ind_fvt
    where id_subserie <> 53;


update esclarecimiento.e_ind_fvt
    set clasifica_nivel=3
    where id_subserie <> 53;

-- actualizar entrevistas de comisionados
select *
    from esclarecimiento.e_ind_fvt entrevista
    join esclarecimiento.entrevistador on (entrevista.id_entrevistador=entrevistador.id_entrevistador)
    where entrevistador.id_nivel=6;

select *
    from esclarecimiento.e_ind_fvt
    where clasifica_nivel=2;


-- reset
update esclarecimiento.e_ind_fvt
    set clasifica_nivel=4 where true;
update esclarecimiento.e_ind_fvt
    set clasifica_nivel=3
    where id_subserie <> 53;
update esclarecimiento.e_ind_fvt
    set clasifica_nivel=3
    where clasifica_sex=1 or clasifica_res=1 or clasifica_nna=1;

-- update propiamente dicho

update
    esclarecimiento.e_ind_fvt e1
    set clasifica_nivel=2
    from esclarecimiento.e_ind_fvt e2
    join esclarecimiento.entrevistador on (e2.id_entrevistador=entrevistador.id_entrevistador)
    where entrevistador.id_nivel=6
            and e1.id_e_ind_fvt = e2.id_e_ind_fvt;


update
    esclarecimiento.entrevista_colectiva e1
    set clasificacion_nivel=2
    from esclarecimiento.entrevista_colectiva e2
    join esclarecimiento.entrevistador on (e2.id_entrevistador=entrevistador.id_entrevistador)
    where entrevistador.id_nivel=6
            and e1.id_entrevista_colectiva = e2.id_entrevista_colectiva;

update
    esclarecimiento.entrevista_etnica e1
    set clasificacion_nivel=2
    from esclarecimiento.entrevista_etnica e2
    join esclarecimiento.entrevistador on (e2.id_entrevistador=entrevistador.id_entrevistador)
    where entrevistador.id_nivel=6
            and e1.id_entrevista_etnica = e2.id_entrevista_etnica;

update
    esclarecimiento.entrevista_profundidad e1
    set clasificacion_nivel=2
    from esclarecimiento.entrevista_profundidad e2
    join esclarecimiento.entrevistador on (e2.id_entrevistador=entrevistador.id_entrevistador)
    where entrevistador.id_nivel=6
            and e1.id_entrevista_profundidad = e2.id_entrevista_profundidad;

update
    esclarecimiento.diagnostico_comunitario e1
    set clasificacion_nivel=2
    from esclarecimiento.diagnostico_comunitario e2
    join esclarecimiento.entrevistador on (e2.id_entrevistador=entrevistador.id_entrevistador)
    where entrevistador.id_nivel=6
            and e1.id_diagnostico_comunitario = e2.id_diagnostico_comunitario;

update
    esclarecimiento.historia_vida e1
    set clasificacion_nivel=2
    from esclarecimiento.historia_vida e2
    join esclarecimiento.entrevistador on (e2.id_entrevistador=entrevistador.id_entrevistador)
    where entrevistador.id_nivel=6
            and e1.id_historia_vida = e2.id_historia_vida;
