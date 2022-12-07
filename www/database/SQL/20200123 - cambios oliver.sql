alter table fichas.persona_responsable_responsabilidades
    add id_hecho int;

create index persona_responsable_responsabilidades_id_hecho_index
    on fichas.persona_responsable_responsabilidades (id_hecho);

alter table fichas.persona_responsable_responsabilidades
    add constraint persona_responsable_responsabilidades_hecho_id_hecho_fk
        foreign key (id_hecho) references fichas.hecho (id_hecho)
            on update cascade on delete cascade;
