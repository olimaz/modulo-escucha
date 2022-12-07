-- Ultimo estado de la transcripcion
alter table esclarecimiento.e_ind_fvt
    add id_transcrita int;

comment on column esclarecimiento.e_ind_fvt.id_transcrita is 'Estado de la última asignación';

alter table esclarecimiento.e_ind_fvt
    add id_etiquetada int;

comment on column esclarecimiento.e_ind_fvt.id_etiquetada is 'Estado de la última asignación';

create index e_ind_fvt_id_etiquetada_index
    on esclarecimiento.e_ind_fvt (id_etiquetada);

create index e_ind_fvt_id_transcrita_index
    on esclarecimiento.e_ind_fvt (id_transcrita);

-- Actualizar
update esclarecimiento.e_ind_fvt as e
set id_transcrita = a.id_situacion
from (
         select id_e_ind_fvt, max(id_transcribir_asignacion) as id
         from transcribir_asignacion
         group by 1  ) as m, transcribir_asignacion a
where e.id_e_ind_fvt=m.id_e_ind_fvt
  and a.id_transcribir_asignacion=m.id;

update esclarecimiento.e_ind_fvt as e
set id_etiquetada = a.id_situacion
from (
         select id_e_ind_fvt, max(id_etiquetar_asignacion) as id
         from etiquetar_asignacion
         group by 1  ) as m, etiquetar_asignacion a
where e.id_e_ind_fvt=m.id_e_ind_fvt
  and a.id_etiquetar_asignacion=m.id;

-- ----------------------------------------

-- Ultimo estado de la transcripcion: CO
alter table esclarecimiento.entrevista_colectiva
    add id_transcrita int;

comment on column esclarecimiento.entrevista_colectiva.id_transcrita is 'Estado de la última asignación';

alter table esclarecimiento.entrevista_colectiva
    add id_etiquetada int;

comment on column esclarecimiento.entrevista_colectiva.id_etiquetada is 'Estado de la última asignación';

create index entrevista_colectiva_id_etiquetada_index
    on esclarecimiento.entrevista_colectiva (id_etiquetada);

create index entrevista_colectiva_id_transcrita_index
    on esclarecimiento.entrevista_colectiva (id_transcrita);

-- Actualizar
update esclarecimiento.entrevista_colectiva as e
set id_transcrita = a.id_situacion
from (
         select id_entrevista_colectiva, max(id_transcribir_asignacion) as id
         from transcribir_asignacion
         group by 1  ) as m, transcribir_asignacion a
where e.id_entrevista_colectiva=m.id_entrevista_colectiva
  and a.id_transcribir_asignacion=m.id;

update esclarecimiento.entrevista_colectiva as e
set id_etiquetada = a.id_situacion
from (
         select id_entrevista_colectiva, max(id_etiquetar_asignacion) as id
         from etiquetar_asignacion
         group by 1  ) as m, etiquetar_asignacion a
where e.id_entrevista_colectiva=m.id_entrevista_colectiva
  and a.id_etiquetar_asignacion=m.id;

-- ----------------------------------------


-- Ultimo estado de la transcripcion: EE
alter table esclarecimiento.entrevista_etnica
    add id_transcrita int;

comment on column esclarecimiento.entrevista_etnica.id_transcrita is 'Estado de la última asignación';

alter table esclarecimiento.entrevista_etnica
    add id_etiquetada int;

comment on column esclarecimiento.entrevista_etnica.id_etiquetada is 'Estado de la última asignación';

create index entrevista_etnica_id_etiquetada_index
    on esclarecimiento.entrevista_etnica (id_etiquetada);

create index entrevista_etnica_id_transcrita_index
    on esclarecimiento.entrevista_etnica (id_transcrita);

-- Actualizar
update esclarecimiento.entrevista_etnica as e
set id_transcrita = a.id_situacion
from (
         select id_entrevista_etnica, max(id_transcribir_asignacion) as id
         from transcribir_asignacion
         group by 1  ) as m, transcribir_asignacion a
where e.id_entrevista_etnica=m.id_entrevista_etnica
  and a.id_transcribir_asignacion=m.id;

update esclarecimiento.entrevista_etnica as e
set id_etiquetada = a.id_situacion
from (
         select id_entrevista_etnica, max(id_etiquetar_asignacion) as id
         from etiquetar_asignacion
         group by 1  ) as m, etiquetar_asignacion a
where e.id_entrevista_etnica=m.id_entrevista_etnica
  and a.id_etiquetar_asignacion=m.id;

-- ----------------------------------------------


-- Ultimo estado de la transcripcion: PR
alter table esclarecimiento.entrevista_profundidad
    add id_transcrita int;

comment on column esclarecimiento.entrevista_profundidad.id_transcrita is 'Estado de la última asignación';

alter table esclarecimiento.entrevista_profundidad
    add id_etiquetada int;

comment on column esclarecimiento.entrevista_profundidad.id_etiquetada is 'Estado de la última asignación';

create index entrevista_profundidad_id_etiquetada_index
    on esclarecimiento.entrevista_profundidad (id_etiquetada);

create index entrevista_profundidad_id_transcrita_index
    on esclarecimiento.entrevista_profundidad (id_transcrita);

-- Actualizar
update esclarecimiento.entrevista_profundidad as e
set id_transcrita = a.id_situacion
from (
         select id_entrevista_profundidad, max(id_transcribir_asignacion) as id
         from transcribir_asignacion
         group by 1  ) as m, transcribir_asignacion a
where e.id_entrevista_profundidad=m.id_entrevista_profundidad
  and a.id_transcribir_asignacion=m.id;

update esclarecimiento.entrevista_profundidad as e
set id_etiquetada = a.id_situacion
from (
         select id_entrevista_profundidad, max(id_etiquetar_asignacion) as id
         from etiquetar_asignacion
         group by 1  ) as m, etiquetar_asignacion a
where e.id_entrevista_profundidad=m.id_entrevista_profundidad
  and a.id_etiquetar_asignacion=m.id;

-- ----------------------------------------------


-- Ultimo estado de la transcripcion: DC
alter table esclarecimiento.diagnostico_comunitario
    add id_transcrita int;

comment on column esclarecimiento.diagnostico_comunitario.id_transcrita is 'Estado de la última asignación';

alter table esclarecimiento.diagnostico_comunitario
    add id_etiquetada int;

comment on column esclarecimiento.diagnostico_comunitario.id_etiquetada is 'Estado de la última asignación';

create index diagnostico_comunitario_id_etiquetada_index
    on esclarecimiento.diagnostico_comunitario (id_etiquetada);

create index diagnostico_comunitario_id_transcrita_index
    on esclarecimiento.diagnostico_comunitario (id_transcrita);

-- Actualizar
update esclarecimiento.diagnostico_comunitario as e
set id_transcrita = a.id_situacion
from (
         select id_diagnostico_comunitario, max(id_transcribir_asignacion) as id
         from transcribir_asignacion
         group by 1  ) as m, transcribir_asignacion a
where e.id_diagnostico_comunitario=m.id_diagnostico_comunitario
  and a.id_transcribir_asignacion=m.id;

update esclarecimiento.diagnostico_comunitario as e
set id_etiquetada = a.id_situacion
from (
         select id_diagnostico_comunitario, max(id_etiquetar_asignacion) as id
         from etiquetar_asignacion
         group by 1  ) as m, etiquetar_asignacion a
where e.id_diagnostico_comunitario=m.id_diagnostico_comunitario
  and a.id_etiquetar_asignacion=m.id;

-- ----------------------------------------------


-- Ultimo estado de la transcripcion: HV
alter table esclarecimiento.historia_vida
    add id_transcrita int;

comment on column esclarecimiento.historia_vida.id_transcrita is 'Estado de la última asignación';

alter table esclarecimiento.historia_vida
    add id_etiquetada int;

comment on column esclarecimiento.historia_vida.id_etiquetada is 'Estado de la última asignación';

create index historia_vida_id_etiquetada_index
    on esclarecimiento.historia_vida (id_etiquetada);

create index historia_vida_id_transcrita_index
    on esclarecimiento.historia_vida (id_transcrita);

-- Actualizar
update esclarecimiento.historia_vida as e
set id_transcrita = a.id_situacion
from (
         select id_historia_vida, max(id_transcribir_asignacion) as id
         from transcribir_asignacion
         group by 1  ) as m, transcribir_asignacion a
where e.id_historia_vida=m.id_historia_vida
  and a.id_transcribir_asignacion=m.id;

update esclarecimiento.historia_vida as e
set id_etiquetada = a.id_situacion
from (
         select id_historia_vida, max(id_etiquetar_asignacion) as id
         from etiquetar_asignacion
         group by 1  ) as m, etiquetar_asignacion a
where e.id_historia_vida=m.id_historia_vida
  and a.id_etiquetar_asignacion=m.id;

-- ----------------------------------------------




