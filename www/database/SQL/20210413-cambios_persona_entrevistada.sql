alter table fichas.persona_entrevistada
    add id_entrevista_profundidad int;

alter table fichas.persona_entrevistada
    add id_historia_vida int;

create unique index persona_entrevistada_fkey_unico
    on fichas.persona_entrevistada (id_e_ind_fvt, id_entrevista_profundidad, id_historia_vida);

create index persona_entrevistada_id_entrevista_profundidad_index
    on fichas.persona_entrevistada (id_entrevista_profundidad);

create index persona_entrevistada_id_historia_vida_index
    on fichas.persona_entrevistada (id_historia_vida);

alter table fichas.persona_entrevistada
    add constraint persona_entrevistada_pr_id_entrevista_profundidad_fk
        foreign key (id_entrevista_profundidad) references esclarecimiento.entrevista_profundidad
            on update cascade on delete restrict;

alter table fichas.persona_entrevistada
    add constraint persona_entrevistada_hv_id_historia_vida_fk
        foreign key (id_historia_vida) references esclarecimiento.historia_vida
            on update cascade on delete restrict;

alter table fichas.persona_entrevistada alter column id_e_ind_fvt drop not null;

alter table fichas.persona_entrevistada alter column created_at set default now();
