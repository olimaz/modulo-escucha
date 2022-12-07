/**
 * autor: Abimelec Enoc Martinez Robles
 * fecha: 29-05-2020
 * descripcion: Creación de campos para consentimiento informado de entevista sujeto colectivo (entrevistas étnicas)
 */
 
 alter table fichas.entrevista add nombre_autoridad_etnica varchar(255) default NULL;
 alter table fichas.entrevista add nombre_identitario varchar(255) default NULL;
 alter table fichas.entrevista add pueblo_representado varchar(255) default NULL;
 alter table fichas.entrevista add id_pueblo_representado integer default NULL;
 alter table fichas.entrevista add grabar_video integer default NULL;
 alter table fichas.entrevista add tomar_fotografia integer default NULL;