alter table fichas.persona_responsable add insert_ent int;
alter table fichas.persona_responsable add insert_ip varchar(100);
alter table fichas.persona_responsable add insert_fh timestamp;
alter table fichas.persona_responsable add update_ent int;
alter table fichas.persona_responsable add update_ip varchar(100);
alter table fichas.persona_responsable add update_fh timestamp;

alter table fichas.entrevista add insert_ent int;
alter table fichas.entrevista add insert_ip varchar(100);
alter table fichas.entrevista add insert_fh timestamp;
alter table fichas.entrevista add update_ent int;
alter table fichas.entrevista add update_ip varchar(100);
alter table fichas.entrevista add update_fh timestamp;
