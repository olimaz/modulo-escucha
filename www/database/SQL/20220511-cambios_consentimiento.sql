-- Campos nuevos en consentimiento informado
alter table fichas.entrevista
    add id_entrevista_colectiva int;

comment on column fichas.entrevista.id_entrevista_colectiva is 'Llave foranea a entrevista colectiva';

alter table fichas.entrevista
    add firma_consentimiento int default 0;

comment on column fichas.entrevista.firma_consentimiento is 'firma o no el consentimiento. 1=Sí, 2=No, 0= no se sabe';

alter table fichas.entrevista
    add firma_tratamiento int default 0;

comment on column fichas.entrevista.firma_tratamiento is 'firma o no la autorizacion de datos personales. 1=Sí, 2=No, 0= no se sabe';

create index entrevista_firma_consentimiento_index
    on fichas.entrevista (firma_consentimiento);

create index entrevista_firma_tratamiento_index
    on fichas.entrevista (firma_tratamiento);

create index entrevista_id_entrevista_colectiva_index
    on fichas.entrevista (id_entrevista_colectiva);

alter table fichas.entrevista
    add constraint entrevista_entrevista_colectiva_id_entrevista_colectiva_fk
        foreign key (id_entrevista_colectiva) references esclarecimiento.entrevista_colectiva
            on update cascade on delete restrict;

alter table fichas.entrevista
    add constraint entrevista_entrevista_profundidad_id_entrevista_profundidad_fk
        foreign key (id_entrevista_profundidad) references esclarecimiento.entrevista_profundidad
            on update cascade on delete restrict;

alter table fichas.entrevista
    add constraint entrevista_historia_vida_id_historia_vida_fk
        foreign key (id_historia_vida) references esclarecimiento.historia_vida
            on update cascade on delete restrict;
-- otros campos nuevos
alter table fichas.entrevista
    add consentimiento_nombres varchar(200);

comment on column fichas.entrevista.consentimiento_nombres is 'usado en entrevistas CO y EE';

alter table fichas.entrevista
    add consentimiento_apellidos varchar(200);

comment on column fichas.entrevista.consentimiento_apellidos is 'usado en entrevistas CO y EE';

alter table fichas.entrevista
    add consentimiento_correlativo int;

comment on column fichas.entrevista.consentimiento_correlativo is 'usado en entrevistas CO y EE';

alter table fichas.entrevista
    add consentimiento_sexo int;

comment on column fichas.entrevista.consentimiento_sexo is 'usado en entrevistas CO y EE';

create index entrevista_consentimiento_sexo_index
    on fichas.entrevista (consentimiento_sexo);

