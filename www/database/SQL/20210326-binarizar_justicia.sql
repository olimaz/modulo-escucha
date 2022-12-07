-- Catalogos a tocar
select id_cat,count(1)
from catalogos.cat_item
where id_cat in (150,151,152,153,154)
  and habilitado=1
group by 1;


--
-- minusculas, espacios, tildes
update catalogos.cat_item set otro = substring(replace(lower(unaccent(descripcion)),' ','_'),1,40)
where habilitado=1
  and id_cat in (150,151,152,153,154);
--puntos
update catalogos.cat_item set otro = replace(otro,'.','_')
where habilitado=1
  and id_cat in (150,151,152,153,154);
--comas
update catalogos.cat_item set otro = replace(otro,',','_')
where habilitado=1
  and id_cat in (150,151,152,153,154);
--comillas
update catalogos.cat_item set otro = replace(otro,'','_')
where habilitado=1
  and id_cat in (150,151,152,153,154);
-- apostrofes
update catalogos.cat_item set otro = replace(otro,'\''','_')
where habilitado=1
  and id_cat in (150,151,152,153,154);
-- slash
update catalogos.cat_item set otro = replace(otro,'/','_')
where habilitado=1
  and id_cat in (150,151,152,153,154);

-- dos puntos
update catalogos.cat_item set otro = replace(otro,':','_')
where habilitado=1
  and id_cat in (150,151,152,153,154);

-- punto y coma
update catalogos.cat_item set otro = replace(otro,';','_')
where habilitado=1
  and id_cat in (150,151,152,153,154);

--parentesis
update catalogos.cat_item set otro = replace(otro,'(','_')
where habilitado=1
  and id_cat in (150,151,152,153,154);
update catalogos.cat_item set otro = replace(otro,')','_')
where habilitado=1
  and id_cat in (150,151,152,153,154);

--guiones
update catalogos.cat_item set otro = replace(otro,'-','_')
where habilitado=1
  and id_cat in (150,151,152,153,154);

-- Verificar
select descripcion, otro
from catalogos.cat_item
where habilitado=1
  and id_cat in (150,151,152,153,154)
order by id_cat, descripcion;

-- --------------

-- Queries para crar tabla
--Query para crear campos institucion del estado
select concat('inst_est_', otro, ' integer default 0, '  ) as campo
from catalogos.cat_item
where habilitado=1
  and id_cat =150
order by id_cat,campo;

--Query para crear campos institucion comunitaria
select concat('inst_com_', otro, ' integer default 0, '  ) as campo
from catalogos.cat_item
where habilitado=1
  and id_cat =151
order by id_cat,campo;

--Query para crear campos institucion internacional
select concat('inst_int_', otro, ' integer default 0, '  ) as campo
from catalogos.cat_item
where habilitado=1
  and id_cat =152
order by id_cat,campo;

--Query para los campos porqué en estado
select concat('pq_est_', otro, ' integer default 0, '  ) as campo
from catalogos.cat_item
where habilitado=1
  and id_cat =153
order by id_cat,campo;
--Query para los campos porqué en comunitario
select concat('pq_com_', otro, ' integer default 0, '  ) as campo
from catalogos.cat_item
where habilitado=1
  and id_cat =153
order by id_cat,campo;
--Query para los campos porqué en internacional
select concat('pq_int_', otro, ' integer default 0, '  ) as campo
from catalogos.cat_item
where habilitado=1
  and id_cat =153
order by id_cat,campo;




--Query para los campos objetivo en estado
select concat('obj_est_', otro, ' integer default 0, '  ) as campo
from catalogos.cat_item
where habilitado=1
  and id_cat =154
order by id_cat,campo;
--Query para los campos objetivo en comunitario
select concat('obj_com_', otro, ' integer default 0, '  ) as campo
from catalogos.cat_item
where habilitado=1
  and id_cat =154
order by id_cat,campo;
--Query para los campos objetivo en internacional
select concat('obj_int_', otro, ' integer default 0, '  ) as campo
from catalogos.cat_item
where habilitado=1
  and id_cat =154
order by id_cat,campo;

-- Query para los comentarios en instituciones
select concat('comment on column analitica.acceso_justicia_binarizado.inst_est_',otro,' is ''',replace(descripcion,'\''','_'),''';') as campo
from catalogos.cat_item
where habilitado=1
  and id_cat in (150)

union

select concat('comment on column analitica.acceso_justicia_binarizado.inst_com_',otro,' is ''',replace(descripcion,'\''','_'),''';') as campo
from catalogos.cat_item
where habilitado=1
  and id_cat in (151)

union

select concat('comment on column analitica.acceso_justicia_binarizado.inst_int_',otro,' is ''',replace(descripcion,'\''','_'),''';') as campo
from catalogos.cat_item
where habilitado=1
  and id_cat in (152)

union

select concat('comment on column analitica.acceso_justicia_binarizado.pq_est_',otro,' is ''',replace(descripcion,'\''','_'),''';') as campo
from catalogos.cat_item
where habilitado=1
  and id_cat in (153)

union

select concat('comment on column analitica.acceso_justicia_binarizado.pq_com_',otro,' is ''',replace(descripcion,'\''','_'),''';') as campo
from catalogos.cat_item
where habilitado=1
  and id_cat in (153)

union

select concat('comment on column analitica.acceso_justicia_binarizado.pq_int_',otro,' is ''',replace(descripcion,'\''','_'),''';') as campo
from catalogos.cat_item
where habilitado=1
  and id_cat in (153)

union


select concat('comment on column analitica.acceso_justicia_binarizado.obj_est_',otro,' is ''',replace(descripcion,'\''','_'),''';') as campo
from catalogos.cat_item
where habilitado=1
  and id_cat in (154)

union

select concat('comment on column analitica.acceso_justicia_binarizado.obj_com_',otro,' is ''',replace(descripcion,'\''','_'),''';') as campo
from catalogos.cat_item
where habilitado=1
  and id_cat in (154)

union

select concat('comment on column analitica.acceso_justicia_binarizado.obj_int_',otro,' is ''',replace(descripcion,'\''','_'),''';') as campo
from catalogos.cat_item
where habilitado=1
  and id_cat in (154)






--Crear tabla

drop table if exists analitica.acceso_justicia_binarizado cascade ;

create table analitica.acceso_justicia_binarizado
(
    id_acceso_justicia_binarizado                  serial not null
        constraint acceso_justicia_binarizado_pk
            primary key,
    id_entrevista integer,
    codigo_entrevista varchar(20),
    --Copiar resultado de los queries  (quitar commillas)
    inst_est_acnudh__oficina_del_alto_comisionado_de_ integer default 0, 
        inst_est_acnur__alto_comisionado_de_las_naciones_ integer default 0, 
        inst_est_acr__agencia_colombiana_para_la_reintegr integer default 0, 
        inst_est_alcaldia integer default 0, 
        inst_est_apc__agencia_presidencial_para_la_accion integer default 0, 
        inst_est_armada_nacional integer default 0, 
        inst_est_arn__agencia_para_la_reincorporacion_y_l integer default 0, 
        inst_est_autoridades_eclesiasticas integer default 0, 
        inst_est_autoridad_gubernamental integer default 0, 
        inst_est_autoridad_raizal integer default 0, 
        inst_est_casa_de_justicia integer default 0, 
        inst_est_centro_nacional_de_memoria_historica integer default 0, 
        inst_est_cidh__comision_interamericana_de_derecho integer default 0, 
        inst_est_cipol__comision_internacional_para_la_ob integer default 0, 
        inst_est_cls__comite_de_libertad_sindical_ integer default 0, 
        inst_est_comisaria_de_familia integer default 0, 
        inst_est_comision_de_la_verdad__colombia_ integer default 0, 
        inst_est_comision_de_la_verdad__ecuador_ integer default 0, 
        inst_est_consejo_de_estado integer default 0, 
        inst_est_consulado_de_colombia_en_el_exterior integer default 0, 
        inst_est_corpoamazonia__corporacion_para_el_desar integer default 0, 
        inst_est_corte_constitucional_de_colombia integer default 0, 
        inst_est_corteidh__corte_interamericana_de_derech integer default 0, 
        inst_est_corte_suprema_de_justicia integer default 0, 
        inst_est_cpi___corte_penal_internacional_ integer default 0, 
        inst_est_cruz_roja integer default 0, 
        inst_est_csb__corporacion_autonoma_regional_del_s integer default 0, 
        inst_est_das__departamento_administrativo_de_segu integer default 0, 
        inst_est_defensa_civil_colombiana integer default 0, 
        inst_est_defensoria integer default 0, 
        inst_est_dijin__departamento_de_investigacion_cri integer default 0, 
        inst_est_dnp__departamento_de_la_prosperidad_soci integer default 0, 
        inst_est_ejercito_nacional_de_colombia integer default 0, 
        inst_est_el_estado_colombiano integer default 0, 
        inst_est_fdhoc__fundacion_para_la_defensa_de_los_ integer default 0, 
        inst_est_fiscalia integer default 0, 
        inst_est_flip__fundacion_para_la_libertad_de_pren integer default 0, 
        inst_est_fuerza_publica integer default 0, 
        inst_est_gaula__grupos_de_accion_unificada_por_la integer default 0, 
        inst_est_gobernacion integer default 0, 
        inst_est_gobiernos_internacionales integer default 0, 
        inst_est_incoder__instituto_colombiano_de_desarro integer default 0, 
        inst_est_instituciones_estatales integer default 0, 
        inst_est_instituto_colombiano_de_bienestar_famili integer default 0, 
        inst_est_instituto_de_medicina_legal_y_ciencias_f integer default 0, 
        inst_est_jurisdiccion_especial_para_la_paz integer default 0, 
        inst_est_justicia_penal_militar integer default 0, 
        inst_est_juzgado integer default 0, 
        inst_est_ley_de_justicia_y_paz_ integer default 0, 
        inst_est_ministerio_de_defensa_de_colombia integer default 0, 
        inst_est_ministerio_de_educacion_nacional integer default 0, 
        inst_est_ministerio_del_interior integer default 0, 
        inst_est_movice__movimiento_nacional_de_victimas_ integer default 0, 
        inst_est_no_sabe___no_responde integer default 0, 
        inst_est_notaria integer default 0, 
        inst_est_oea__organizacion_de_los_estados_america integer default 0, 
        inst_est_ong__organizacion_no_gubernamental_ integer default 0, 
        inst_est_organismos_internacionales integer default 0, 
        inst_est_organismos_nacionales_e_internacionales integer default 0, 
        inst_est_organizaciones_de_sociedad_civil integer default 0, 
        inst_est_parques_nacionales_naturales_de_colombia integer default 0, 
        inst_est_personeria integer default 0, 
        inst_est_policia_nacional_de_colombia integer default 0, 
        inst_est_procuraduria integer default 0, 
        inst_est_red_de_solidaridad_social integer default 0, 
        inst_est_secretaria_de_educacion integer default 0, 
        inst_est_secretaria_de_gobierno integer default 0, 
        inst_est_secretaria_de_salud integer default 0, 
        inst_est_secretarias___ministerios_de_relaciones_ integer default 0, 
        inst_est_uao__unidad_de_atencion_y_orientacion_al integer default 0, 
        inst_est_unidad_de_busqueda_de_personas_dadas_por integer default 0, 
        inst_est_unidad_de_restitucion_de_tierras integer default 0, 
        inst_est_unidad_para_las_victimas integer default 0, 
        inst_est_unp__unidad_nacional_de_proteccion_ integer default 0, 

        inst_com_autoridad_consejo_comunitario integer default 0, 
        inst_com_autoridad_etnica integer default 0, 
        inst_com_autoridad_indigena integer default 0, 
        inst_com_instituciones_estatales integer default 0, 
        inst_com_mediador integer default 0, 
        inst_com_ninguno integer default 0, 
        inst_com_organizaciones_de_sociedad_civil integer default 0, 
        inst_com_partidos_y_movimientos_politicos integer default 0, 
        inst_com_religioso integer default 0, 

        inst_int_comision_interamericana_de_derechos_huma integer default 0, 
        inst_int_corte_interamericana_de_derechos_humanos integer default 0, 
        inst_int_instituciones_estatales integer default 0, 
        inst_int_naciones_unidas__onu_ integer default 0, 
        inst_int_ninguna integer default 0, 
        inst_int_organizaciones_de_sociedad_civil integer default 0, 
        inst_int_organizaciones_no_gubernamentales integer default 0, 

        pq_est_competencia integer default 0, 
        pq_est_confianza integer default 0, 
        pq_est_me_obligaron integer default 0, 
        pq_est_miedo integer default 0, 
        pq_est_no_sabe___no_responde integer default 0, 
        pq_est_no_tenia_otra_alternativa integer default 0, 
        pq_est_proximidad integer default 0, 

        pq_com_competencia integer default 0, 
        pq_com_confianza integer default 0, 
        pq_com_me_obligaron integer default 0, 
        pq_com_miedo integer default 0, 
        pq_com_no_sabe___no_responde integer default 0, 
        pq_com_no_tenia_otra_alternativa integer default 0, 
        pq_com_proximidad integer default 0, 

        pq_int_competencia integer default 0, 
        pq_int_confianza integer default 0, 
        pq_int_me_obligaron integer default 0, 
        pq_int_miedo integer default 0, 
        pq_int_no_sabe___no_responde integer default 0, 
        pq_int_no_tenia_otra_alternativa integer default 0, 
        pq_int_proximidad integer default 0, 

        obj_est_justicia integer default 0, 
        obj_est_no_sabe___no_responde integer default 0, 
        obj_est_orientacion integer default 0, 
        obj_est_proteccion integer default 0, 
        obj_est_reparacion integer default 0, 
        obj_est_solicitar_asilo integer default 0, 
        obj_est_verdad integer default 0, 

        obj_com_justicia integer default 0, 
        obj_com_no_sabe___no_responde integer default 0, 
        obj_com_orientacion integer default 0, 
        obj_com_proteccion integer default 0, 
        obj_com_reparacion integer default 0, 
        obj_com_solicitar_asilo integer default 0, 
        obj_com_verdad integer default 0, 

        obj_int_justicia integer default 0, 
        obj_int_no_sabe___no_responde integer default 0, 
        obj_int_orientacion integer default 0, 
        obj_int_proteccion integer default 0, 
        obj_int_reparacion integer default 0, 
        obj_int_solicitar_asilo integer default 0, 
        obj_int_verdad integer default 0, 


        --Agregar esto al final de los campos
    created_at timestamp default now()

);
alter table analitica.acceso_justicia_binarizado owner to dba;

comment on table analitica.acceso_justicia_binarizado is 'Versión binarizada del acceso a la justicia, una fila por entrevista.  Prefijos: inst_ (institucion), pq_ (Porqué accedió), obj_ (objetivo de acceder).  _est (estado), _com (comunitario), _int (internacional)';
comment on column analitica.acceso_justicia_binarizado.id_entrevista is 'Cada hecho tiene su contexto';
comment on column analitica.acceso_justicia_binarizado.codigo_entrevista is 'Referencia rápida';

GRANT SELECT ON analitica.acceso_justicia_binarizado  TO solo_lectura;

create index if not exists acceso_justicia_binarizado_id_entrevista_index
    on analitica.acceso_justicia_binarizado (id_entrevista);

create index if not exists acceso_justicia_binarizado_codigo_entrevista_index
    on analitica.acceso_justicia_binarizado (codigo_entrevista);


--Agregar resultados del query de comentarios
comment on column analitica.acceso_justicia_binarizado.obj_est_orientacion is 'Orientación';
comment on column analitica.acceso_justicia_binarizado.inst_est_fuerza_publica is 'Fuerza Pública';
comment on column analitica.acceso_justicia_binarizado.obj_com_orientacion is 'Orientación';
comment on column analitica.acceso_justicia_binarizado.inst_est_acr__agencia_colombiana_para_la_reintegr is 'ACR (AGENCIA COLOMBIANA PARA LA REINTEGRACIÓN)';
comment on column analitica.acceso_justicia_binarizado.obj_est_no_sabe___no_responde is 'No sabe / No responde';
comment on column analitica.acceso_justicia_binarizado.inst_est_unp__unidad_nacional_de_proteccion_ is 'UNP (Unidad Nacional de Protección)';
comment on column analitica.acceso_justicia_binarizado.inst_int_organizaciones_no_gubernamentales is 'Organizaciones no gubernamentales';
comment on column analitica.acceso_justicia_binarizado.inst_est_das__departamento_administrativo_de_segu is 'DAS (Departamento Administrativo de Seguridad)';
comment on column analitica.acceso_justicia_binarizado.inst_est_policia_nacional_de_colombia is 'Policía Nacional de Colombia';
comment on column analitica.acceso_justicia_binarizado.inst_est_juzgado is 'Juzgado';
comment on column analitica.acceso_justicia_binarizado.inst_est_defensoria is 'Defensoría';
comment on column analitica.acceso_justicia_binarizado.inst_est_unidad_para_las_victimas is 'Unidad para las Víctimas';
comment on column analitica.acceso_justicia_binarizado.inst_est_incoder__instituto_colombiano_de_desarro is 'INCODER (Instituto Colombiano de Desarrollo Rural)';
comment on column analitica.acceso_justicia_binarizado.inst_est_armada_nacional is 'Armada Nacional';
comment on column analitica.acceso_justicia_binarizado.obj_com_solicitar_asilo is 'Solicitar asilo';
comment on column analitica.acceso_justicia_binarizado.inst_int_corte_interamericana_de_derechos_humanos is 'Corte Interamericana de Derechos Humanos';
comment on column analitica.acceso_justicia_binarizado.inst_est_cidh__comision_interamericana_de_derecho is 'CIDH (Comisión Interamericana de Derechos Humanos)';
comment on column analitica.acceso_justicia_binarizado.inst_est_fiscalia is 'Fiscalía';
comment on column analitica.acceso_justicia_binarizado.inst_est_notaria is 'Notaría';
comment on column analitica.acceso_justicia_binarizado.inst_est_centro_nacional_de_memoria_historica is 'Centro Nacional de Memoria Histórica';
comment on column analitica.acceso_justicia_binarizado.obj_est_verdad is 'Verdad';
comment on column analitica.acceso_justicia_binarizado.inst_est_secretaria_de_educacion is 'Secretaría de Educación';
comment on column analitica.acceso_justicia_binarizado.pq_int_competencia is 'Competencia';
comment on column analitica.acceso_justicia_binarizado.inst_int_organizaciones_de_sociedad_civil is 'Organizaciones de sociedad civil';
comment on column analitica.acceso_justicia_binarizado.inst_est_movice__movimiento_nacional_de_victimas_ is 'Movice (Movimiento Nacional de Víctimas de Crímenes de Estado)';
comment on column analitica.acceso_justicia_binarizado.obj_int_justicia is 'Justicia';
comment on column analitica.acceso_justicia_binarizado.inst_int_comision_interamericana_de_derechos_huma is 'Comisión Interamericana de Derechos Humanos';
comment on column analitica.acceso_justicia_binarizado.inst_est_corte_suprema_de_justicia is 'Corte Suprema de Justicia';
comment on column analitica.acceso_justicia_binarizado.inst_int_naciones_unidas__onu_ is 'Naciones Unidas (ONU)';
comment on column analitica.acceso_justicia_binarizado.inst_est_autoridad_raizal is 'Autoridad Raizal';
comment on column analitica.acceso_justicia_binarizado.inst_est_comisaria_de_familia is 'Comisaría de Familia';
comment on column analitica.acceso_justicia_binarizado.inst_est_procuraduria is 'Procuraduría';
comment on column analitica.acceso_justicia_binarizado.inst_est_csb__corporacion_autonoma_regional_del_s is 'CSB (Corporación Autónoma Regional del Sur de Bolívar)';
comment on column analitica.acceso_justicia_binarizado.pq_int_miedo is 'Miedo';
comment on column analitica.acceso_justicia_binarizado.pq_com_competencia is 'Competencia';
comment on column analitica.acceso_justicia_binarizado.inst_est_personeria is 'Personería';
comment on column analitica.acceso_justicia_binarizado.inst_est_corpoamazonia__corporacion_para_el_desar is 'Corpoamazonia (Corporación para el desarrollo sostenible del sur de la Amazonia)';
comment on column analitica.acceso_justicia_binarizado.inst_int_ninguna is 'Ninguna';
comment on column analitica.acceso_justicia_binarizado.inst_est_gobiernos_internacionales is 'Gobiernos internacionales';
comment on column analitica.acceso_justicia_binarizado.inst_est_jurisdiccion_especial_para_la_paz is 'Jurisdicción Especial para la Paz';
comment on column analitica.acceso_justicia_binarizado.inst_est_secretarias___ministerios_de_relaciones_ is 'Secretarías / ministerios de relaciones exteriores de otros países';
comment on column analitica.acceso_justicia_binarizado.inst_est_ong__organizacion_no_gubernamental_ is 'ONG (Organización no gubernamental)';
comment on column analitica.acceso_justicia_binarizado.inst_est_arn__agencia_para_la_reincorporacion_y_l is 'ARN (Agencia para la Reincorporación y la Normalización)';
comment on column analitica.acceso_justicia_binarizado.pq_com_me_obligaron is 'Me obligaron';
comment on column analitica.acceso_justicia_binarizado.obj_est_proteccion is 'Protección';
comment on column analitica.acceso_justicia_binarizado.pq_est_me_obligaron is 'Me obligaron';
comment on column analitica.acceso_justicia_binarizado.inst_est_consejo_de_estado is 'Consejo de Estado';
comment on column analitica.acceso_justicia_binarizado.inst_est_el_estado_colombiano is 'El Estado colombiano';
comment on column analitica.acceso_justicia_binarizado.inst_com_autoridad_consejo_comunitario is 'Autoridad consejo comunitario';
comment on column analitica.acceso_justicia_binarizado.inst_com_partidos_y_movimientos_politicos is 'Partidos y movimientos políticos';
comment on column analitica.acceso_justicia_binarizado.inst_com_mediador is 'Mediador';
comment on column analitica.acceso_justicia_binarizado.inst_est_casa_de_justicia is 'Casa de Justicia';
comment on column analitica.acceso_justicia_binarizado.inst_est_gobernacion is 'Gobernación';
comment on column analitica.acceso_justicia_binarizado.inst_est_uao__unidad_de_atencion_y_orientacion_al is 'UAO (Unidad de Atención y Orientación al Desplazado)';
comment on column analitica.acceso_justicia_binarizado.inst_est_corte_constitucional_de_colombia is 'Corte Constitucional de Colombia';
comment on column analitica.acceso_justicia_binarizado.inst_est_gaula__grupos_de_accion_unificada_por_la is 'GAULA (Grupos de Acción Unificada por la Libertad Personal)';
comment on column analitica.acceso_justicia_binarizado.inst_est_comision_de_la_verdad__ecuador_ is 'Comisión de la Verdad (Ecuador)';
comment on column analitica.acceso_justicia_binarizado.obj_com_no_sabe___no_responde is 'No sabe / No responde';
comment on column analitica.acceso_justicia_binarizado.inst_est_secretaria_de_gobierno is 'Secretaría de Gobierno';
comment on column analitica.acceso_justicia_binarizado.inst_est_cls__comite_de_libertad_sindical_ is 'CLS (Comité de Libertad Sindical)';
comment on column analitica.acceso_justicia_binarizado.inst_est_acnur__alto_comisionado_de_las_naciones_ is 'ACNUR (Alto Comisionado de las Naciones Unidas para los Refugiados)';
comment on column analitica.acceso_justicia_binarizado.obj_int_solicitar_asilo is 'Solicitar asilo';
comment on column analitica.acceso_justicia_binarizado.inst_est_organizaciones_de_sociedad_civil is 'Organizaciones de sociedad civil';
comment on column analitica.acceso_justicia_binarizado.inst_est_acnudh__oficina_del_alto_comisionado_de_ is 'ACNUDH (Oficina del Alto Comisionado de las Naciones Unidas para los Derechos Humanos)';
comment on column analitica.acceso_justicia_binarizado.inst_est_instituto_colombiano_de_bienestar_famili is 'Instituto Colombiano de Bienestar Familiar (ICBF)';
comment on column analitica.acceso_justicia_binarizado.inst_est_ejercito_nacional_de_colombia is 'Ejército Nacional de Colombia';
comment on column analitica.acceso_justicia_binarizado.obj_int_no_sabe___no_responde is 'No sabe / No responde';
comment on column analitica.acceso_justicia_binarizado.pq_com_miedo is 'Miedo';
comment on column analitica.acceso_justicia_binarizado.obj_int_verdad is 'Verdad';
comment on column analitica.acceso_justicia_binarizado.inst_int_instituciones_estatales is 'Instituciones estatales';
comment on column analitica.acceso_justicia_binarizado.inst_est_defensa_civil_colombiana is 'Defensa Civil Colombiana';
comment on column analitica.acceso_justicia_binarizado.pq_est_miedo is 'Miedo';
comment on column analitica.acceso_justicia_binarizado.inst_est_ministerio_del_interior is 'Ministerio del Interior';
comment on column analitica.acceso_justicia_binarizado.pq_int_no_tenia_otra_alternativa is 'No tenía otra alternativa';
comment on column analitica.acceso_justicia_binarizado.pq_com_no_sabe___no_responde is 'No sabe / No responde';
comment on column analitica.acceso_justicia_binarizado.inst_est_apc__agencia_presidencial_para_la_accion is 'APC (Agencia Presidencial para la Acción Social y la Cooperación Internacional)';
comment on column analitica.acceso_justicia_binarizado.inst_est_alcaldia is 'Alcaldía';
comment on column analitica.acceso_justicia_binarizado.pq_est_no_sabe___no_responde is 'No sabe / No responde';
comment on column analitica.acceso_justicia_binarizado.inst_est_organismos_nacionales_e_internacionales is 'Organismos nacionales e internacionales';
comment on column analitica.acceso_justicia_binarizado.obj_est_reparacion is 'Reparación';
comment on column analitica.acceso_justicia_binarizado.obj_est_justicia is 'Justicia';
comment on column analitica.acceso_justicia_binarizado.inst_est_comision_de_la_verdad__colombia_ is 'Comisión de la Verdad (Colombia)';
comment on column analitica.acceso_justicia_binarizado.inst_est_organismos_internacionales is 'Organismos internacionales';
comment on column analitica.acceso_justicia_binarizado.inst_est_fdhoc__fundacion_para_la_defensa_de_los_ is 'FDHOC (Fundación para la Defensa de los Derechos Humanos del Oriente Colombiano)';
comment on column analitica.acceso_justicia_binarizado.inst_est_cpi___corte_penal_internacional_ is 'CPI  (Corte Penal Internacional)';
comment on column analitica.acceso_justicia_binarizado.inst_est_secretaria_de_salud is 'Secretaría de Salud';
comment on column analitica.acceso_justicia_binarizado.pq_com_confianza is 'Confianza';
comment on column analitica.acceso_justicia_binarizado.obj_est_solicitar_asilo is 'Solicitar asilo';
comment on column analitica.acceso_justicia_binarizado.pq_int_confianza is 'Confianza';
comment on column analitica.acceso_justicia_binarizado.pq_int_no_sabe___no_responde is 'No sabe / No responde';
comment on column analitica.acceso_justicia_binarizado.inst_est_flip__fundacion_para_la_libertad_de_pren is 'FLIP (Fundación para la Libertad de Prensa)';
comment on column analitica.acceso_justicia_binarizado.pq_est_proximidad is 'Proximidad';
comment on column analitica.acceso_justicia_binarizado.inst_est_cruz_roja is 'Cruz Roja';
comment on column analitica.acceso_justicia_binarizado.inst_est_autoridad_gubernamental is 'Autoridad gubernamental';
comment on column analitica.acceso_justicia_binarizado.inst_est_no_sabe___no_responde is 'No sabe / No responde';
comment on column analitica.acceso_justicia_binarizado.inst_est_red_de_solidaridad_social is 'Red de Solidaridad Social';
comment on column analitica.acceso_justicia_binarizado.inst_est_ley_de_justicia_y_paz_ is 'Ley de Justicia y paz.';
comment on column analitica.acceso_justicia_binarizado.pq_est_confianza is 'Confianza';
comment on column analitica.acceso_justicia_binarizado.inst_est_instituto_de_medicina_legal_y_ciencias_f is 'Instituto de Medicina Legal y Ciencias Forenses';
comment on column analitica.acceso_justicia_binarizado.inst_com_autoridad_indigena is 'Autoridad Indígena';
comment on column analitica.acceso_justicia_binarizado.inst_est_corteidh__corte_interamericana_de_derech is 'CorteIDH (Corte Interamericana de Derechos Humanos)';
comment on column analitica.acceso_justicia_binarizado.inst_est_cipol__comision_internacional_para_la_ob is 'CIPOL (Comisión Internacional para la Observación de la Ley)';
comment on column analitica.acceso_justicia_binarizado.obj_int_orientacion is 'Orientación';
comment on column analitica.acceso_justicia_binarizado.obj_com_verdad is 'Verdad';
comment on column analitica.acceso_justicia_binarizado.pq_est_no_tenia_otra_alternativa is 'No tenía otra alternativa';
comment on column analitica.acceso_justicia_binarizado.obj_com_proteccion is 'Protección';
comment on column analitica.acceso_justicia_binarizado.pq_int_me_obligaron is 'Me obligaron';
comment on column analitica.acceso_justicia_binarizado.obj_com_justicia is 'Justicia';
comment on column analitica.acceso_justicia_binarizado.inst_com_ninguno is 'Ninguno';
comment on column analitica.acceso_justicia_binarizado.inst_est_dijin__departamento_de_investigacion_cri is 'DIJIN (Departamento de Investigación Criminal e Interpol)';
comment on column analitica.acceso_justicia_binarizado.inst_com_religioso is 'Religioso';
comment on column analitica.acceso_justicia_binarizado.inst_est_unidad_de_restitucion_de_tierras is 'Unidad de Restitución de Tierras';
comment on column analitica.acceso_justicia_binarizado.pq_est_competencia is 'Competencia';
comment on column analitica.acceso_justicia_binarizado.inst_est_unidad_de_busqueda_de_personas_dadas_por is 'Unidad de Búsqueda de Personas dadas por Desaparecidas';
comment on column analitica.acceso_justicia_binarizado.inst_est_parques_nacionales_naturales_de_colombia is 'Parques Nacionales Naturales de Colombia';
comment on column analitica.acceso_justicia_binarizado.inst_com_instituciones_estatales is 'Instituciones estatales';
comment on column analitica.acceso_justicia_binarizado.inst_est_instituciones_estatales is 'Instituciones estatales';
comment on column analitica.acceso_justicia_binarizado.pq_com_proximidad is 'Proximidad';
comment on column analitica.acceso_justicia_binarizado.obj_int_proteccion is 'Protección';
comment on column analitica.acceso_justicia_binarizado.inst_est_oea__organizacion_de_los_estados_america is 'OEA (Organización de los Estados Americanos )';
comment on column analitica.acceso_justicia_binarizado.inst_com_autoridad_etnica is 'Autoridad Étnica';
comment on column analitica.acceso_justicia_binarizado.pq_com_no_tenia_otra_alternativa is 'No tenía otra alternativa';
comment on column analitica.acceso_justicia_binarizado.inst_est_autoridades_eclesiasticas is 'Autoridades eclesiásticas';
comment on column analitica.acceso_justicia_binarizado.inst_est_dnp__departamento_de_la_prosperidad_soci is 'DNP (Departamento de la Prosperidad Social)';
comment on column analitica.acceso_justicia_binarizado.inst_est_justicia_penal_militar is 'Justicia Penal Militar';
comment on column analitica.acceso_justicia_binarizado.inst_est_ministerio_de_educacion_nacional is 'Ministerio de Educación Nacional';
comment on column analitica.acceso_justicia_binarizado.inst_est_consulado_de_colombia_en_el_exterior is 'Consulado de Colombia en el exterior';
comment on column analitica.acceso_justicia_binarizado.inst_com_organizaciones_de_sociedad_civil is 'Organizaciones de sociedad civil';
comment on column analitica.acceso_justicia_binarizado.obj_int_reparacion is 'Reparación';
comment on column analitica.acceso_justicia_binarizado.obj_com_reparacion is 'Reparación';
comment on column analitica.acceso_justicia_binarizado.pq_int_proximidad is 'Proximidad';
comment on column analitica.acceso_justicia_binarizado.inst_est_ministerio_de_defensa_de_colombia is 'Ministerio de Defensa de Colombia';
