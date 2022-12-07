
alter table fichas.entrevista
    add divulgar_material int default 0;

comment on column fichas.entrevista.divulgar_material is '9. Divulgación de material audiovisual y otros (Texto, datos, audio, vídeo y fotografía).  1 Sí; 2 No; 0 No indica';

alter table fichas.entrevista
    add traslado_info int default 0;

comment on column fichas.entrevista.traslado_info is '10. Refiere al traslado de la información.  1 Sí; 2 No; 0 No indica';

alter table fichas.entrevista
    add compartir_info int default 0;

comment on column fichas.entrevista.compartir_info is '11. Compartir información con terceros.  1 Sí; 2 No; 0 No indica';


alter table fichas.entrevista
    add restrictiva int default 0;

comment on column fichas.entrevista.restrictiva is 'Dentro de los consentimientos existentes, este es el mas restrictivo.  1 Sí; 2 No; 3 No indica';

create index entrevista_restrictiva_index
    on fichas.entrevista (restrictiva);

alter table fichas.entrevista
    add id_diagnostico_comunitario int;

create index id_diagnostico_comunitario_index
    on fichas.entrevista (id_diagnostico_comunitario);


-- correccion, desconocido debe ser 3 para que en el order se priorice la restrictiva
comment on column fichas.entrevista.restrictiva is 'Dentro de los consentimientos existentes, este es el mas restrictivo.  1 Sí; 2 No; 3 No indica';
update fichas.entrevista set restrictiva=3 where entrevista.restrictiva=0;
alter table fichas.entrevista alter column restrictiva set default 3;

