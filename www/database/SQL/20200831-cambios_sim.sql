alter table sim.entrevista_victima
    add entrevista_codigo varchar(25);


alter table sim.entrevista_victima
    add created_at timestamp;

alter table sim.entrevista_victima
    add updated_at timestamp;



create index entrevista_victima_created_at_index
    on sim.entrevista_victima (created_at);

create index entrevista_victima_entrevista_codigo_index
    on sim.entrevista_victima (entrevista_codigo);

create index entrevista_victima_updated_at_index
    on sim.entrevista_victima (updated_at);

-- Otras tablas
create index excel_ficha_persona_entrevistada_codigo_entrevista_index
    on esclarecimiento.excel_ficha_persona_entrevistada (codigo_entrevista);

create index excel_ficha_victima_codigo_entrevista_index
    on esclarecimiento.excel_ficha_victima (codigo_entrevista);

create index persona_entrevistada_codigo_entrevista_index
    on analitica.persona_entrevistada (codigo_entrevista);
create index victima_codigo_entrevista_index
    on analitica.victima (codigo_entrevista);
