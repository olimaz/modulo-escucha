-- Referencia a archivo de transcripción
alter table esclarecimiento.entrevista_colectiva_adjunto
    add id_transcripcion int;

-- Referencia a archivo de transcripción
alter table esclarecimiento.entrevista_profundidad_adjunto
    add id_transcripcion int;

-- Referencia a archivo de transcripción
alter table esclarecimiento.historia_vida_adjunto
    add id_transcripcion int;

-- Referencia a archivo de transcripción
alter table esclarecimiento.diagnostico_comunitario_adjunto
    add id_transcripcion int;


