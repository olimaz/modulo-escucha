alter table etiquetar_asignacion
	add codigo varchar(20);

comment on column etiquetar_asignacion.codigo is 'Facilita la integracion con excel_entrevista_integrado y otras vistas que integran todas las entrevistas';

create index etiquetar_asignacion_codigo_index
	on etiquetar_asignacion (codigo);



alter table transcribir_asignacion
	add codigo varchar(20);

comment on column transcribir_asignacion.codigo is 'Facilita la integracion con excel_entrevista_integrado y otras vistas que integran todas las entrevistas';

create index transcribir_asignacion_codigo_index
	on transcribir_asignacion (codigo);



-- etiquetado
update etiquetar_asignacion as a
set codigo = e.entrevista_codigo
from esclarecimiento.e_ind_fvt e
    where e.id_e_ind_fvt = a.id_e_ind_fvt;


update etiquetar_asignacion as a
set codigo = e.entrevista_codigo
from esclarecimiento.entrevista_colectiva e
    where e.id_entrevista_colectiva = a.id_entrevista_colectiva;


update etiquetar_asignacion as a
set codigo = e.entrevista_codigo
from esclarecimiento.entrevista_etnica e
    where e.id_entrevista_etnica = a.id_entrevista_etnica;

update etiquetar_asignacion as a
set codigo = e.entrevista_codigo
from esclarecimiento.entrevista_profundidad e
    where e.id_entrevista_profundidad = a.id_entrevista_profundidad;

update etiquetar_asignacion as a
set codigo = e.entrevista_codigo
from esclarecimiento.diagnostico_comunitario e
    where e.id_diagnostico_comunitario = a.id_diagnostico_comunitario;

update etiquetar_asignacion as a
set codigo = e.entrevista_codigo
from esclarecimiento.historia_vida e
    where e.id_historia_vida = a.id_historia_vida;



--transcrito
update transcribir_asignacion as a
set codigo = e.entrevista_codigo
from esclarecimiento.e_ind_fvt e
    where e.id_e_ind_fvt = a.id_e_ind_fvt;


update transcribir_asignacion as a
set codigo = e.entrevista_codigo
from esclarecimiento.entrevista_colectiva e
    where e.id_entrevista_colectiva = a.id_entrevista_colectiva;


update transcribir_asignacion as a
set codigo = e.entrevista_codigo
from esclarecimiento.entrevista_etnica e
    where e.id_entrevista_etnica = a.id_entrevista_etnica;

update transcribir_asignacion as a
set codigo = e.entrevista_codigo
from esclarecimiento.entrevista_profundidad e
    where e.id_entrevista_profundidad = a.id_entrevista_profundidad;

update transcribir_asignacion as a
set codigo = e.entrevista_codigo
from esclarecimiento.diagnostico_comunitario e
    where e.id_diagnostico_comunitario = a.id_diagnostico_comunitario;

update transcribir_asignacion as a
set codigo = e.entrevista_codigo
from esclarecimiento.historia_vida e
    where e.id_historia_vida = a.id_historia_vida;



-- ----------------------
alter table sim.etiqueta_entrevista
	add codigo varchar(20);

comment on column sim.etiqueta_entrevista.codigo is 'Facilita la integracion con algunas vistas, como el excel integrado';

create index etiqueta_entrevista_codigo_index
	on sim.etiqueta_entrevista (codigo);



update sim.etiqueta_entrevista as et
    set codigo = e.entrevista_codigo
    from esclarecimiento.e_ind_fvt e
        where et.id_entrevista = e.id_e_ind_fvt
                and et.id_subserie = e.id_subserie;


update sim.etiqueta_entrevista as et
    set codigo = e.entrevista_codigo
    from esclarecimiento.entrevista_colectiva e
        where et.id_entrevista = e.id_entrevista_colectiva
                and et.id_subserie = 102;


update sim.etiqueta_entrevista as et
    set codigo = e.entrevista_codigo
    from esclarecimiento.entrevista_etnica e
        where et.id_entrevista = e.id_entrevista_etnica
                and et.id_subserie = 263;


update sim.etiqueta_entrevista as et
    set codigo = e.entrevista_codigo
    from esclarecimiento.entrevista_profundidad e
        where et.id_entrevista = e.id_entrevista_profundidad
                and et.id_subserie = 99;


update sim.etiqueta_entrevista as et
    set codigo = e.entrevista_codigo
    from esclarecimiento.diagnostico_comunitario e
        where et.id_entrevista = e.id_diagnostico_comunitario
                and et.id_subserie = 103;

update sim.etiqueta_entrevista as et
    set codigo = e.entrevista_codigo
    from esclarecimiento.historia_vida e
        where et.id_entrevista = e.id_historia_vida
                and et.id_subserie = 100;




