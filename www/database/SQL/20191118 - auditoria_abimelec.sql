-- Persona
alter table fichas.persona add COLUMN insert_ent integer;
alter table fichas.persona add COLUMN insert_ip varchar(100);
alter table fichas.persona add COLUMN insert_fh TIMESTAMP;
alter table fichas.persona add COLUMN update_ent integer;
alter table fichas.persona add COLUMN update_ip varchar(100);
alter table fichas.persona add COLUMN update_fh TIMESTAMP;


-- Victima
alter table fichas.victima add COLUMN insert_ent integer;
alter table fichas.victima add COLUMN insert_ip varchar(100);
alter table fichas.victima add COLUMN insert_fh TIMESTAMP;
alter table fichas.victima add COLUMN update_ent integer;
alter table fichas.victima add COLUMN update_ip varchar(100);
alter table fichas.victima add COLUMN update_fh TIMESTAMP;

-- Persona_entrevistada

alter table fichas.persona_entrevistada add COLUMN insert_ent integer;
alter table fichas.persona_entrevistada add COLUMN insert_ip varchar(100);
alter table fichas.persona_entrevistada add COLUMN insert_fh TIMESTAMP;
alter table fichas.persona_entrevistada add COLUMN update_ent integer;
alter table fichas.persona_entrevistada add COLUMN update_ip varchar(100);
alter table fichas.persona_entrevistada add COLUMN update_fh TIMESTAMP;