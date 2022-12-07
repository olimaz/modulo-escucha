
--  Campos para grabar transcripción y etiquetado
alter table esclarecimiento.entrevista_colectiva
    add html_transcripcion text;

alter table esclarecimiento.entrevista_colectiva
    add json_etiquetado text;


alter table esclarecimiento.historia_vida
    add html_transcripcion text;

alter table esclarecimiento.historia_vida
    add json_etiquetado text;


alter table esclarecimiento.diagnostico_comunitario
    add html_transcripcion text;

alter table esclarecimiento.diagnostico_comunitario
    add json_etiquetado text;



alter table esclarecimiento.entrevista_etnica
    add html_transcripcion text;

alter table esclarecimiento.entrevista_etnica
    add json_etiquetado text;




