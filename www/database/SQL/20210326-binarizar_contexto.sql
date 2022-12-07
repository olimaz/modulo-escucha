-- Crear nombre de campos en campo otro
-- Limpieza de nombres de campo.

-- minusculas, espacios, tildes
update catalogos.cat_item set otro = substring(replace(lower(unaccent(descripcion)),' ','_'),1,40)
where habilitado=1
  and id_cat in (127,128,129,130,131);
--puntos
update catalogos.cat_item set otro = replace(otro,'.','_')
where habilitado=1
  and id_cat in (127,128,129,130,131);
--comas
update catalogos.cat_item set otro = replace(otro,',','_')
where habilitado=1
  and id_cat in (127,128,129,130,131);
--comillas
update catalogos.cat_item set otro = replace(otro,'','_')
where habilitado=1
  and id_cat in (127,128,129,130,131);
-- apostrofes
update catalogos.cat_item set otro = replace(otro,'\''','_')
where habilitado=1
  and id_cat in (127,128,129,130,131);
-- slash
update catalogos.cat_item set otro = replace(otro,'/','_')
where habilitado=1
  and id_cat in (127,128,129,130,131);

-- dos puntos
update catalogos.cat_item set otro = replace(otro,':','_')
where habilitado=1
  and id_cat in (127,128,129,130,131);

-- punto y coma
update catalogos.cat_item set otro = replace(otro,';','_')
where habilitado=1
  and id_cat in (127,128,129,130,131);

--parentesis
update catalogos.cat_item set otro = replace(otro,'(','_')
where habilitado=1
  and id_cat in (127,128,129,130,131);
update catalogos.cat_item set otro = replace(otro,')','_')
where habilitado=1
  and id_cat in (127,128,129,130,131);

--guiones
update catalogos.cat_item set otro = replace(otro,'-','_')
where habilitado=1
  and id_cat in (127,128,129,130,131);


-- Prefijo a c/tipo
update catalogos.cat_item
set otro = concat('motivos_',otro)
where habilitado=1 and id_cat=127;

update catalogos.cat_item
set otro = concat('con_cont_',otro)
where habilitado=1 and id_cat=128;

update catalogos.cat_item
set otro = concat('esp_sig_',otro)
where habilitado=1 and id_cat=129;

update catalogos.cat_item
set otro = concat('fact_ext_',otro)
where habilitado=1 and id_cat=130;

update catalogos.cat_item
set otro = concat('benef_',otro)
where habilitado=1 and id_cat=131;


-- Verificar
select descripcion, otro
from catalogos.cat_item
where habilitado=1
  and id_cat in (127,128,129,130,131)
order by id_cat, descripcion;

--Query para crear campos
select concat( otro, ' integer default 0, '  ) as campo
from catalogos.cat_item
where habilitado=1
  and id_cat in (127,128,129,130,131)
order by id_cat,campo;


-- Query para crear comentarios
select concat('comment on column analitica.violencia_contexto_binarizado.',otro,' is ''',replace(descripcion,'\''','_'),''';') as campo
from catalogos.cat_item
where habilitado=1
  and id_cat in (127,128,129,130,131)
order by id_cat,campo;



-- Crear tabla
drop table if exists analitica.violencia_contexto_binarizado cascade ;

create table analitica.violencia_contexto_binarizado
(
    id_violencia_contexto_binarizado                  serial not null
        constraint violencia_contexto_binarizado_pk
            primary key,
    id_hecho integer,
    codigo_entrevista varchar(20),
    --Copiar resultado del query  (quitar commillas)
    motivos_ataques_a_infraestructura_minero_energet integer default 0, 
        motivos_consumo_de_sustancias_psicoactivas integer default 0, 
        motivos_falta_de_informacion_o_desconocimiento integer default 0, 
        motivos_no_sabe___no_responde integer default 0, 
        motivos_para_evitar_otros_hechos_violentos integer default 0, 
        motivos_para_impedir_una_denuncia integer default 0, 
        motivos_parentesco_o_relacion_con_miembros_o_exm integer default 0, 
        motivos_por_abandono_por_parte_del_estado integer default 0, 
        motivos_por_abuso_de_poder__por_parte_de_la_fuer integer default 0, 
        motivos_por_actos_en_contra_de_la_ley_efectuados integer default 0, 
        motivos_por_actos_violentos_ocurridos_a_la_s__pe integer default 0, 
        motivos_por_ajusticiamiento integer default 0, 
        motivos_por_amenazas integer default 0, 
        motivos_por_ayudar_en_la_liberacion_de_secuestra integer default 0, 
        motivos_por_buscar_o_tratar_de_contactar_a_famil integer default 0, 
        motivos_por_condicion_de_discapacidad integer default 0, 
        motivos_por_condicion_social integer default 0, 
        motivos_por_conflictos_sociales_que_se_dan_en_la integer default 0, 
        motivos_por_confusion integer default 0, 
        motivos_por_connivencia_entre_paramilitares_y_fu integer default 0, 
        motivos_por_control_social integer default 0, 
        motivos_por_control_territorial integer default 0, 
        motivos_por_denunciar integer default 0, 
        motivos_por_denunciar_irregularidades_en_institu integer default 0, 
        motivos_por_desacato_a_orden_de_grupo_ilegal integer default 0, 
        motivos_por_ejecucion_extrajudicial_presentada_c integer default 0, 
        motivos_por_el_oficio_o_la_profesion integer default 0, 
        motivos_por_enfrentamientos_entre_grupos_armados integer default 0, 
        motivos_por_escapar_de_secuestro_o_reclutamiento integer default 0, 
        motivos_por_estereotipos_culturales integer default 0, 
        motivos_por_estigmatizacion integer default 0, 
        motivos_por_extorsion integer default 0, 
        motivos_por_hacer_parte_o_haber_hecho_parte_de_u integer default 0, 
        motivos_por_hechos_violentos_en_la_zona integer default 0, 
        motivos_por_hostigamientos integer default 0, 
        motivos_por_intentar_esclarecer_homicidio_s__o_d integer default 0, 
        motivos_por_investigacion_de_la_fiscalia_y_del_c integer default 0, 
        motivos_por_limpieza_social integer default 0, 
        motivos_por_miedo_e_inseguridad_en_la_zona integer default 0, 
        motivos_por_motivos_economicos integer default 0, 
        motivos_por_motivos_politicos integer default 0, 
        motivos_por_motivos_religiosos integer default 0, 
        motivos_por_operaciones_militares_en_la_zona integer default 0, 
        motivos_por_pagos_efectuados_por_personas_adiner integer default 0, 
        motivos_por_persecucion integer default 0, 
        motivos_por_pertenencia_etnica integer default 0, 
        motivos_por_presencia_de_actores_armados_en_la_z integer default 0, 
        motivos_por_presion_a_la_fuerza_publica_a_presen integer default 0, 
        motivos_por_presunta_colaboracion_con_actor_arma integer default 0, 
        motivos_por_problemas_personales__o_familiares__ integer default 0, 
        motivos_por_querer__ser_parte_de_actor_armado integer default 0, 
        motivos_por_querer_ser_parte_de_un_grupo_armado integer default 0, 
        motivos_porque_su_sitio_de_residencia_era_un_pun integer default 0, 
        motivos_por_racismo integer default 0, 
        motivos_por_relacion_en_actividad_sindical integer default 0, 
        motivos_por_retaliacion integer default 0, 
        motivos_por_ser_familiar_o_tener_relacion_con_vi integer default 0, 
        motivos_por_ser_hombre integer default 0, 
        motivos_por_ser_mujer integer default 0, 
        motivos_por_ser_obligado_s__a_ayudar_o_brindar_i integer default 0, 
        motivos_por_ser_senalados_de_haber_cometido_acto integer default 0, 
        motivos_por_ser_testigo_de_acto_violento integer default 0, 
        motivos_por_su_condicion_de_liderazgo_social integer default 0, 
        motivos_por_su_edad integer default 0, 
        motivos_por_su_identidad_de_genero integer default 0, 
        motivos_por_su_orientacion_sexual integer default 0, 
        motivos_por_su_relacion_con_la_insurgencia integer default 0, 
        motivos_por_temas_relacionados_al_narcotrafico integer default 0, 
        motivos_por_tener_informacion_y_o_desinformar_a_ integer default 0, 
        motivos_por_tener_relacion_con_instituciones_est integer default 0, 
        motivos_reclutamiento_de_ninos___ninas_o_adolesc integer default 0, 
        con_cont_abandono_del_estado integer default 0, 
        con_cont_abuso_de_autoridad_de_la_fuerza_publica integer default 0, 
        con_cont_actores_armados_ilegales_ejercen_control integer default 0, 
        con_cont_afectacion_a_derechos_electorales integer default 0, 
        con_cont_afectaciones_a_la_participacion_ciudadan integer default 0, 
        con_cont_agregado_militar integer default 0, 
        con_cont_allanamiento integer default 0, 
        con_cont_amenazas_a_personas integer default 0, 
        con_cont_atentado_al_derecho_a_la_vida integer default 0, 
        con_cont_cambios_en_el_uso_del_suelo_y_tenencia_d integer default 0, 
        con_cont_comunidad__lgtbi integer default 0, 
        con_cont_confinamiento integer default 0, 
        con_cont_conflicto_entre_patrones_y_trabajadores integer default 0, 
        con_cont_connivencia_de_la_fuerza_publica integer default 0, 
        con_cont_control_de_la_movilidad integer default 0, 
        con_cont_control_hegemonico_por_parte_de_un_actor integer default 0, 
        con_cont_corrupcion integer default 0, 
        con_cont_debilidad_institucional_en_la_zona integer default 0, 
        con_cont_desapariciones_forzadas integer default 0, 
        con_cont_desarme__desmovilizacion__desvinculacion integer default 0, 
        con_cont_desarrollos_institucionales_y_politicas_ integer default 0, 
        con_cont_descripcion_de_elites_regionales integer default 0, 
        con_cont_desplazamiento_forzado integer default 0, 
        con_cont_dimensiones_internacionales_del_conflict integer default 0, 
        con_cont_dinamicas_espaciales_de_los_actores_arma integer default 0, 
        con_cont_disputas_entre_la_poblacion_por_recursos integer default 0, 
        con_cont_economias_ilegales_en_la_region integer default 0, 
        con_cont_ejecuciones_extrajudiciales__falsos_posi integer default 0, 
        con_cont_enfrentamientos_por_disputa_territorial_ integer default 0, 
        con_cont_estigmatizacion_politica integer default 0, 
        con_cont_estrategias_de_resistencia_etnica integer default 0, 
        con_cont_extorsiones integer default 0, 
        con_cont_funcionarios_publicos integer default 0, 
        con_cont_homicidios_selectivos integer default 0, 
        con_cont_impactos_en_los_liderazgos_colectivos integer default 0, 
        con_cont_la_comunidad_debia_actuar_como_informant integer default 0, 
        con_cont_masacre_s_ integer default 0, 
        con_cont_mineria_ilegal_en_la_zona integer default 0, 
        con_cont_movilidad_y_transito_de_grupos_armados_i integer default 0, 
        con_cont_narcotrafico_o__actividades_relacionadas integer default 0, 
        con_cont_no_sabe___no_responde integer default 0, 
        con_cont_ocupacion_temporal_de_espacios_sociales_ integer default 0, 
        con_cont_omision_de_la_accion_protectora_por_part integer default 0, 
        con_cont_operaciones_militares_en_el_terreno integer default 0, 
        con_cont_organismos_nacionales_e_internacionales integer default 0, 
        con_cont_partidos_y_movimientos_politicos integer default 0, 
        con_cont_pillajes_por_actor_armado integer default 0, 
        con_cont_plan_pistola integer default 0, 
        con_cont_presencia_de_actor_es__armado_s__en_la_z integer default 0, 
        con_cont_proceso_de_formacion_politica_ideologica integer default 0, 
        con_cont_procesos_de_recuperacion_de_tierras integer default 0, 
        con_cont_reclutamiento_a_miembros_de_los_pueblos_ integer default 0, 
        con_cont_reclutamiento_forzado_de_menores integer default 0, 
        con_cont_recuperacion_de_tierras integer default 0, 
        con_cont_relacion_entre_politica_y_actores_armado integer default 0, 
        con_cont_represion_de_la_protesta_social integer default 0, 
        con_cont_retorno_y_reasentamiento integer default 0, 
        con_cont_rinas_callejeras integer default 0, 
        con_cont_secuestro___toma_de_rehenes integer default 0, 
        con_cont_senalamientos___persecusion integer default 0, 
        con_cont_tacticas_de_inteligencia_contrainteligen integer default 0, 
        con_cont_trafico_y_trata_de_personas integer default 0, 
        con_cont_violencia_de_genero_efectuada_por_actor_ integer default 0, 
        con_cont_violencia_politica integer default 0, 
        esp_sig_campesinos integer default 0, 
        esp_sig_cocaleros integer default 0, 
        esp_sig_comerciantes integer default 0, 
        esp_sig_consumidores_as_de_drogas integer default 0, 
        esp_sig_el_estado integer default 0, 
        esp_sig_empresa__cooperativa__entidad integer default 0, 
        esp_sig_empresarios__as integer default 0, 
        esp_sig_estudiantes__docentes_y_o_personas_acade integer default 0, 
        esp_sig_exiliados_as_y_victimas_en_el_exterior integer default 0, 
        esp_sig_expresiones_religiosas integer default 0, 
        esp_sig_familiares_de_ex_combatientes integer default 0, 
        esp_sig_ganaderos integer default 0, 
        esp_sig_grupo_armado integer default 0, 
        esp_sig_hombres integer default 0, 
        esp_sig_industria_bananera integer default 0, 
        esp_sig_jovenes integer default 0, 
        esp_sig_lideres_sociales integer default 0, 
        esp_sig_mayores_de_edad integer default 0, 
        esp_sig_militares___policias integer default 0, 
        esp_sig_mineros integer default 0, 
        esp_sig_mujeres integer default 0, 
        esp_sig_ninos__ninas_y_adolescentes integer default 0, 
        esp_sig_no_sabe___no_responde integer default 0, 
        esp_sig_para_el_sector_sindical_y_o_politico integer default 0, 
        esp_sig_personas_cerca_a_la_frontera integer default 0, 
        esp_sig_personas_en_ejercicio_de_prostitucion integer default 0, 
        esp_sig_personas_lgbti integer default 0, 
        esp_sig_pescadores integer default 0, 
        esp_sig_pueblos_etnicos integer default 0, 
        esp_sig_su_familia_y_o_vecinos integer default 0, 
        esp_sig_toda_la_comunidad integer default 0, 
        esp_sig_transportistas integer default 0, 
        fact_ext_abusos_contra_grupos_etnicos integer default 0, 
        fact_ext_accion_continuada_de_grupo_armado_que_no integer default 0, 
        fact_ext_acciones_armadas_y_combates_en_la_zona integer default 0, 
        fact_ext_actividades_extractivas_ilegales_informa_hidroc integer default 0, 
        fact_ext_actividades_extractivas_ilegales_informa_madera integer default 0, 
        fact_ext_actividades_extractivas_ilegales_informa_mineria integer default 0, 
        fact_ext_actividades_ilegales_diferentes_al_narco integer default 0, 
        fact_ext_actividad_sindical integer default 0, 
        fact_ext_actores_armados_presentes_en_la_zona integer default 0, 
        fact_ext_agroindustrias__cana integer default 0, 
        fact_ext_agroindustrias__otro integer default 0, 
        fact_ext_agroindustrias__palma_de_aceite integer default 0, 
        fact_ext_amenaza_a_la_actividad_sindical integer default 0, 
        fact_ext_ausencia_del_estado_o_ineficiencia_de_su integer default 0, 
        fact_ext_beneficios_economicos integer default 0, 
        fact_ext_cambios_en_la_estructura_y_dinamica_fami integer default 0, 
        fact_ext_connivencia_entre_el_estado_y_grupos_par integer default 0, 
        fact_ext_connivencia_entre_grupo_armado_y_civiles integer default 0, 
        fact_ext_contexto_politico integer default 0, 
        fact_ext_contexto_social_de_la_zona integer default 0, 
        fact_ext_control_social integer default 0, 
        fact_ext_control_territorial integer default 0, 
        fact_ext_corrupcion integer default 0, 
        fact_ext_denuncias_de_actos_delictivos integer default 0, 
        fact_ext_denuncias_hechas_por_crimenes_de_estado integer default 0, 
        fact_ext_ejecuciones_extrajudiciales_perpetrados_ integer default 0, 
        fact_ext_elecciones integer default 0, 
        fact_ext_estigmatizacion_por_parentesco_o_relacio integer default 0, 
        fact_ext_factores_asociados_a_creencias__religios integer default 0, 
        fact_ext_factores_personales_o_familiares integer default 0, 
        fact_ext_falta_de_oportunidades_sociales_y_econom integer default 0, 
        fact_ext_ganaderia integer default 0, 
        fact_ext_hechos__violentos integer default 0, 
        fact_ext_impunidad integer default 0, 
        fact_ext_incumplimiento_de_los_acuerdos_de_paz integer default 0, 
        fact_ext_laborales__vulneracion_de_derechos__priv integer default 0, 
        fact_ext_miedo integer default 0, 
        fact_ext_movilizaciones_sociales_en_la_zona integer default 0, 
        fact_ext_narcotrafico integer default 0, 
        fact_ext_narcotrafico__comercializacion integer default 0, 
        fact_ext_narcotrafico__cultivo integer default 0, 
        fact_ext_narcotrafico__procesamiento integer default 0, 
        fact_ext_negociaciones_del_estado_con_las_farc integer default 0, 
        fact_ext_no_acatar_las_ordenes_de_actor_armado integer default 0, 
        fact_ext_no_sabe___no_responde integer default 0, 
        fact_ext_operativo_policial_o_militar integer default 0, 
        fact_ext_otras_industrias_o_comercios integer default 0, 
        fact_ext_persecuciones_a_personas_o_organizacione integer default 0, 
        fact_ext_pobreza_y_vulneracion_a_derechos_sociale integer default 0, 
        fact_ext_politicas_estatales_para_la_eliminacion_ integer default 0, 
        fact_ext_por_el_oficio_o_la_profesion integer default 0, 
        fact_ext_presencia_de_grupos_armados integer default 0, 
        fact_ext_presunta__ayuda_a_actor_armado integer default 0, 
        fact_ext_presuntamente_ser_miembro_o_tener_relaci integer default 0, 
        fact_ext_problemas_familiares_o_personales__chism integer default 0, 
        fact_ext_prostitucion integer default 0, 
        fact_ext_proyectos_de_infraestructura__hidroelect integer default 0, 
        fact_ext_proyectos_de_infraestructura__otro integer default 0, 
        fact_ext_proyectos_de_infraestructura__portuarios integer default 0, 
        fact_ext_proyectos_de_infraestructura__viales integer default 0, 
        fact_ext_racismo_y_discriminacion integer default 0, 
        fact_ext_residencia_en_ubicacion_estrategica_para integer default 0, 
        fact_ext_resistencia_y_critica_al_accionar_de_gru integer default 0, 
        fact_ext_retaliacion integer default 0, 
        fact_ext_robos___pillaje integer default 0, 
        fact_ext_robo___transporte_de_armas integer default 0, 
        fact_ext_seguridad integer default 0, 
        fact_ext_su_condicion_de_liderazgo_social integer default 0, 
        fact_ext_suministrar_informacion_a_actor_armado integer default 0, 
        fact_ext_violacion_del_derecho_internacional_huma integer default 0, 
        benef_agentes_externos_que_imponian_politica_e integer default 0, 
        benef_agentes_inmobiliarios_o_compradores_de_t integer default 0, 
        benef_alguno_de_los_grupos_armados integer default 0, 
        benef_alvaro_uribe integer default 0, 
        benef_autoridades_locales integer default 0, 
        benef_autoridades_universitarias integer default 0, 
        benef_cabildo_indigena integer default 0, 
        benef_civil_es_ integer default 0, 
        benef_clase_politica_de_derecha_del_pais integer default 0, 
        benef_comerciantes_de_la_zona integer default 0, 
        benef_corporaciones__ongs__instituciones_no_gu integer default 0, 
        benef_departamento_administrativo_de_seguridad integer default 0, 
        benef_directores_de_carceles integer default 0, 
        benef_dirigentes_politicos_regionales integer default 0, 
        benef_el_estado integer default 0, 
        benef_empresarios_de_la_zona integer default 0, 
        benef_empresas_multinacionales_transnacionales integer default 0, 
        benef_entidades_estatales integer default 0, 
        benef_exintegrantes_de_grupos_armados_ilegales integer default 0, 
        benef_familiares integer default 0, 
        benef_fuerzas_armadas_del_estado__militares__p integer default 0, 
        benef_ganaderos_de_la_zona integer default 0, 
        benef_grupo_criminal_de_la_zona integer default 0, 
        benef_grupo_dedicado_a_l_narcotrafico_u_otros_ integer default 0, 
        benef_grupos_politicos_y_o_economicos__del_pai integer default 0, 
        benef_interesados_en_mantener_la_guerra integer default 0, 
        benef_la_iglesia integer default 0, 
        benef_la_oligarquia_de_la_zona integer default 0, 
        benef_lider_de_grupo_ilegal integer default 0, 
        benef_militares_de_la_zona integer default 0, 
        benef_mineros integer default 0, 
        benef_no_hubo_beneficiados integer default 0, 
        benef_no_sabe integer default 0, 
        benef_pobladores_de_la_zona integer default 0, 
        benef_politicos_de_la_zona integer default 0, 
        benef_terratenientes_de_la_zona integer default 0, 
        benef_testferro_de_grupos_armados integer default 0, 

        --Agregar esto al final de los campos
    created_at timestamp default now()

);
alter table analitica.violencia_contexto_binarizado owner to dba;

comment on table analitica.violencia_contexto_binarizado is 'Versión binarizada del contexto, una fila por hecho';
comment on column analitica.violencia_contexto_binarizado.id_hecho is 'Cada hecho tiene su contexto';
comment on column analitica.violencia_contexto_binarizado.codigo_entrevista is 'Referencia rápida';

GRANT SELECT ON analitica.violencia_contexto_binarizado  TO solo_lectura;

create index if not exists analitica_violencia_contexto_binarizado_id_hecho_index
    on analitica.violencia_contexto_binarizado (id_hecho);

create index if not exists analitica_violencia_contexto_binarizado_codigo_entrevista_index
    on analitica.violencia_contexto_binarizado (codigo_entrevista);





-- Pegar resultados del query de comentarios
comment on column analitica.violencia_contexto_binarizado.motivos_ataques_a_infraestructura_minero_energet is 'Ataques a infraestructura minero-energética';
comment on column analitica.violencia_contexto_binarizado.motivos_consumo_de_sustancias_psicoactivas is 'Consumo de sustancias psicoactivas';
comment on column analitica.violencia_contexto_binarizado.motivos_falta_de_informacion_o_desconocimiento is 'Falta de información o desconocimiento';
comment on column analitica.violencia_contexto_binarizado.motivos_no_sabe___no_responde is 'No sabe / no responde';
comment on column analitica.violencia_contexto_binarizado.motivos_para_evitar_otros_hechos_violentos is 'Para evitar otros hechos violentos';
comment on column analitica.violencia_contexto_binarizado.motivos_para_impedir_una_denuncia is 'Para impedir una denuncia';
comment on column analitica.violencia_contexto_binarizado.motivos_parentesco_o_relacion_con_miembros_o_exm is 'Parentesco o relación con miembros o exmiembros de actores armados.';
comment on column analitica.violencia_contexto_binarizado.motivos_por_abandono_por_parte_del_estado is 'Por abandono por parte del estado';
comment on column analitica.violencia_contexto_binarizado.motivos_por_abuso_de_poder__por_parte_de_la_fuer is 'Por abuso de poder  por parte de la fuerza pública';
comment on column analitica.violencia_contexto_binarizado.motivos_por_actos_en_contra_de_la_ley_efectuados is 'Por actos en contra de la ley efectuados por funcionarios del estado';
comment on column analitica.violencia_contexto_binarizado.motivos_por_actos_violentos_ocurridos_a_la_s__pe is 'Por actos violentos ocurridos a la(s) persona(s), a familiares o conocidos';
comment on column analitica.violencia_contexto_binarizado.motivos_por_ajusticiamiento is 'Por Ajusticiamiento';
comment on column analitica.violencia_contexto_binarizado.motivos_por_amenazas is 'Por amenazas';
comment on column analitica.violencia_contexto_binarizado.motivos_por_ayudar_en_la_liberacion_de_secuestra is 'Por ayudar en la liberación de secuestrado';
comment on column analitica.violencia_contexto_binarizado.motivos_por_buscar_o_tratar_de_contactar_a_famil is 'Por buscar o tratar de contactar a familiares o conocidos';
comment on column analitica.violencia_contexto_binarizado.motivos_por_condicion_de_discapacidad is 'Por condición de discapacidad';
comment on column analitica.violencia_contexto_binarizado.motivos_por_condicion_social is 'Por condición social';
comment on column analitica.violencia_contexto_binarizado.motivos_por_conflictos_sociales_que_se_dan_en_la is 'Por conflictos sociales que se dan en la zona';
comment on column analitica.violencia_contexto_binarizado.motivos_por_confusion is 'Por confusión';
comment on column analitica.violencia_contexto_binarizado.motivos_por_connivencia_entre_paramilitares_y_fu is 'Por connivencia entre paramilitares y fuerza pública';
comment on column analitica.violencia_contexto_binarizado.motivos_por_control_social is 'Por control social';
comment on column analitica.violencia_contexto_binarizado.motivos_por_control_territorial is 'Por control territorial';
comment on column analitica.violencia_contexto_binarizado.motivos_por_denunciar is 'Por denunciar';
comment on column analitica.violencia_contexto_binarizado.motivos_por_denunciar_irregularidades_en_institu is 'Por denunciar irregularidades en instituciones del estado';
comment on column analitica.violencia_contexto_binarizado.motivos_por_desacato_a_orden_de_grupo_ilegal is 'Por desacato a orden de grupo ilegal';
comment on column analitica.violencia_contexto_binarizado.motivos_por_ejecucion_extrajudicial_presentada_c is 'Por ejecución extrajudicial presentada como muerte en combate o falso positivo';
comment on column analitica.violencia_contexto_binarizado.motivos_por_el_oficio_o_la_profesion is 'Por el oficio o la profesión';
comment on column analitica.violencia_contexto_binarizado.motivos_por_enfrentamientos_entre_grupos_armados is 'Por enfrentamientos entre grupos armados';
comment on column analitica.violencia_contexto_binarizado.motivos_por_escapar_de_secuestro_o_reclutamiento is 'Por escapar de secuestro o reclutamiento';
comment on column analitica.violencia_contexto_binarizado.motivos_por_estereotipos_culturales is 'Por estereotipos culturales';
comment on column analitica.violencia_contexto_binarizado.motivos_por_estigmatizacion is 'Por estigmatización';
comment on column analitica.violencia_contexto_binarizado.motivos_por_extorsion is 'Por extorsión';
comment on column analitica.violencia_contexto_binarizado.motivos_por_hacer_parte_o_haber_hecho_parte_de_u is 'Por hacer parte o haber hecho parte de un Actor Armado';
comment on column analitica.violencia_contexto_binarizado.motivos_por_hechos_violentos_en_la_zona is 'Por hechos violentos en la zona';
comment on column analitica.violencia_contexto_binarizado.motivos_por_hostigamientos is 'Por hostigamientos';
comment on column analitica.violencia_contexto_binarizado.motivos_por_intentar_esclarecer_homicidio_s__o_d is 'Por intentar esclarecer homicidio(s) o desaparición(es)';
comment on column analitica.violencia_contexto_binarizado.motivos_por_investigacion_de_la_fiscalia_y_del_c is 'Por investigación de la fiscalía y del CTI';
comment on column analitica.violencia_contexto_binarizado.motivos_por_limpieza_social is 'Por limpieza social';
comment on column analitica.violencia_contexto_binarizado.motivos_por_miedo_e_inseguridad_en_la_zona is 'Por miedo e inseguridad en la zona';
comment on column analitica.violencia_contexto_binarizado.motivos_por_motivos_economicos is 'Por motivos económicos';
comment on column analitica.violencia_contexto_binarizado.motivos_por_motivos_politicos is 'Por motivos políticos';
comment on column analitica.violencia_contexto_binarizado.motivos_por_motivos_religiosos is 'Por motivos religiosos';
comment on column analitica.violencia_contexto_binarizado.motivos_por_operaciones_militares_en_la_zona is 'Por operaciones militares en la zona';
comment on column analitica.violencia_contexto_binarizado.motivos_por_pagos_efectuados_por_personas_adiner is 'Por pagos efectuados por personas adineradas para cometer actos delictivos';
comment on column analitica.violencia_contexto_binarizado.motivos_por_persecucion is 'Por persecución';
comment on column analitica.violencia_contexto_binarizado.motivos_por_pertenencia_etnica is 'Por pertenencia étnica';
comment on column analitica.violencia_contexto_binarizado.motivos_por_presencia_de_actores_armados_en_la_z is 'Por presencia de actores armados en la zona';
comment on column analitica.violencia_contexto_binarizado.motivos_por_presion_a_la_fuerza_publica_a_presen is 'Por presión a la fuerza pública a presentar resultados en combate';
comment on column analitica.violencia_contexto_binarizado.motivos_por_presunta_colaboracion_con_actor_arma is 'Por presunta colaboración con actor armado';
comment on column analitica.violencia_contexto_binarizado.motivos_por_problemas_personales__o_familiares__ is 'Por problemas personales  o familiares (chismes, celos, problemas amorosos, etc.)';
comment on column analitica.violencia_contexto_binarizado.motivos_por_querer__ser_parte_de_actor_armado is 'Por querer  ser parte de actor armado';
comment on column analitica.violencia_contexto_binarizado.motivos_por_querer_ser_parte_de_un_grupo_armado is 'Por querer ser parte de un grupo armado';
comment on column analitica.violencia_contexto_binarizado.motivos_porque_su_sitio_de_residencia_era_un_pun is 'Porque su sitio de residencia era un punto estratégico para los actores armados';
comment on column analitica.violencia_contexto_binarizado.motivos_por_racismo is 'Por racismo';
comment on column analitica.violencia_contexto_binarizado.motivos_por_relacion_en_actividad_sindical is 'Por relación en actividad sindical';
comment on column analitica.violencia_contexto_binarizado.motivos_por_retaliacion is 'Por retaliación';
comment on column analitica.violencia_contexto_binarizado.motivos_por_ser_familiar_o_tener_relacion_con_vi is 'Por ser familiar o tener relación con víctima o objetivo militar.';
comment on column analitica.violencia_contexto_binarizado.motivos_por_ser_hombre is 'Por ser hombre';
comment on column analitica.violencia_contexto_binarizado.motivos_por_ser_mujer is 'Por ser mujer';
comment on column analitica.violencia_contexto_binarizado.motivos_por_ser_obligado_s__a_ayudar_o_brindar_i is 'Por ser obligado(s) a ayudar o brindar información a actor armado';
comment on column analitica.violencia_contexto_binarizado.motivos_por_ser_senalados_de_haber_cometido_acto is 'Por ser señalados de haber cometido actos delictivos';
comment on column analitica.violencia_contexto_binarizado.motivos_por_ser_testigo_de_acto_violento is 'Por ser testigo de acto violento';
comment on column analitica.violencia_contexto_binarizado.motivos_por_su_condicion_de_liderazgo_social is 'Por su condición de liderazgo social';
comment on column analitica.violencia_contexto_binarizado.motivos_por_su_edad is 'Por su edad';
comment on column analitica.violencia_contexto_binarizado.motivos_por_su_identidad_de_genero is 'Por su identidad de género';
comment on column analitica.violencia_contexto_binarizado.motivos_por_su_orientacion_sexual is 'Por su orientación sexual';
comment on column analitica.violencia_contexto_binarizado.motivos_por_su_relacion_con_la_insurgencia is 'Por su relación con la insurgencia';
comment on column analitica.violencia_contexto_binarizado.motivos_por_temas_relacionados_al_narcotrafico is 'Por temas relacionados al narcotráfico';
comment on column analitica.violencia_contexto_binarizado.motivos_por_tener_informacion_y_o_desinformar_a_ is 'Por tener información y/o desinformar a actor armado';
comment on column analitica.violencia_contexto_binarizado.motivos_por_tener_relacion_con_instituciones_est is 'Por tener relación con instituciones estatales';
comment on column analitica.violencia_contexto_binarizado.motivos_reclutamiento_de_ninos___ninas_o_adolesc is 'Reclutamiento de niños / niñas o adolescentes';
comment on column analitica.violencia_contexto_binarizado.con_cont_abandono_del_estado is 'Abandono del Estado';
comment on column analitica.violencia_contexto_binarizado.con_cont_abuso_de_autoridad_de_la_fuerza_publica is 'Abuso de autoridad de la Fuerza Pública';
comment on column analitica.violencia_contexto_binarizado.con_cont_actores_armados_ilegales_ejercen_control is 'Actores armados ilegales ejercen control social y/o de justicia';
comment on column analitica.violencia_contexto_binarizado.con_cont_afectacion_a_derechos_electorales is 'Afectación a derechos electorales';
comment on column analitica.violencia_contexto_binarizado.con_cont_afectaciones_a_la_participacion_ciudadan is 'Afectaciones a la participación ciudadana';
comment on column analitica.violencia_contexto_binarizado.con_cont_agregado_militar is 'Agregado militar';
comment on column analitica.violencia_contexto_binarizado.con_cont_allanamiento is 'Allanamiento';
comment on column analitica.violencia_contexto_binarizado.con_cont_amenazas_a_personas is 'Amenazas a personas';
comment on column analitica.violencia_contexto_binarizado.con_cont_atentado_al_derecho_a_la_vida is 'Atentado al derecho a la vida';
comment on column analitica.violencia_contexto_binarizado.con_cont_cambios_en_el_uso_del_suelo_y_tenencia_d is 'Cambios en el uso del suelo y tenencia de la tierra';
comment on column analitica.violencia_contexto_binarizado.con_cont_comunidad__lgtbi is 'Comunidad  LGTBI';
comment on column analitica.violencia_contexto_binarizado.con_cont_confinamiento is 'Confinamiento';
comment on column analitica.violencia_contexto_binarizado.con_cont_conflicto_entre_patrones_y_trabajadores is 'Conflicto entre patrones y trabajadores';
comment on column analitica.violencia_contexto_binarizado.con_cont_connivencia_de_la_fuerza_publica is 'Connivencia de la Fuerza Pública';
comment on column analitica.violencia_contexto_binarizado.con_cont_control_de_la_movilidad is 'Control de la movilidad';
comment on column analitica.violencia_contexto_binarizado.con_cont_control_hegemonico_por_parte_de_un_actor is 'Control hegemónico por parte de un actor armado ilegal';
comment on column analitica.violencia_contexto_binarizado.con_cont_corrupcion is 'Corrupción';
comment on column analitica.violencia_contexto_binarizado.con_cont_debilidad_institucional_en_la_zona is 'Debilidad Institucional en la zona';
comment on column analitica.violencia_contexto_binarizado.con_cont_desapariciones_forzadas is 'Desapariciones forzadas';
comment on column analitica.violencia_contexto_binarizado.con_cont_desarme__desmovilizacion__desvinculacion is 'Desarme, desmovilización, desvinculación, reintegración / reincorporación';
comment on column analitica.violencia_contexto_binarizado.con_cont_desarrollos_institucionales_y_politicas_ is 'Desarrollos institucionales y políticas públicas';
comment on column analitica.violencia_contexto_binarizado.con_cont_descripcion_de_elites_regionales is 'Descripción de élites regionales';
comment on column analitica.violencia_contexto_binarizado.con_cont_desplazamiento_forzado is 'Desplazamiento forzado';
comment on column analitica.violencia_contexto_binarizado.con_cont_dimensiones_internacionales_del_conflict is 'Dimensiones internacionales del conflicto';
comment on column analitica.violencia_contexto_binarizado.con_cont_dinamicas_espaciales_de_los_actores_arma is 'Dinámicas espaciales de los actores armados';
comment on column analitica.violencia_contexto_binarizado.con_cont_disputas_entre_la_poblacion_por_recursos is 'Disputas entre la población por recursos vitales (agua, luz, etc.)';
comment on column analitica.violencia_contexto_binarizado.con_cont_economias_ilegales_en_la_region is 'Economías ilegales en la región';
comment on column analitica.violencia_contexto_binarizado.con_cont_ejecuciones_extrajudiciales__falsos_posi is 'Ejecuciones extrajudiciales (falsos positivos)';
comment on column analitica.violencia_contexto_binarizado.con_cont_enfrentamientos_por_disputa_territorial_ is 'Enfrentamientos por disputa territorial entre varios actores armados';
comment on column analitica.violencia_contexto_binarizado.con_cont_estigmatizacion_politica is 'Estigmatización política';
comment on column analitica.violencia_contexto_binarizado.con_cont_estrategias_de_resistencia_etnica is 'Estrategias de resistencia étnica';
comment on column analitica.violencia_contexto_binarizado.con_cont_extorsiones is 'Extorsiones';
comment on column analitica.violencia_contexto_binarizado.con_cont_funcionarios_publicos is 'Funcionarios públicos';
comment on column analitica.violencia_contexto_binarizado.con_cont_homicidios_selectivos is 'Homicidios selectivos';
comment on column analitica.violencia_contexto_binarizado.con_cont_impactos_en_los_liderazgos_colectivos is 'Impactos en los liderazgos colectivos';
comment on column analitica.violencia_contexto_binarizado.con_cont_la_comunidad_debia_actuar_como_informant is 'La comunidad debía actuar como informante';
comment on column analitica.violencia_contexto_binarizado.con_cont_masacre_s_ is 'Masacre(s)';
comment on column analitica.violencia_contexto_binarizado.con_cont_mineria_ilegal_en_la_zona is 'Minería ilegal en la zona';
comment on column analitica.violencia_contexto_binarizado.con_cont_movilidad_y_transito_de_grupos_armados_i is 'Movilidad y tránsito de grupos armados ilegales en el territorio';
comment on column analitica.violencia_contexto_binarizado.con_cont_narcotrafico_o__actividades_relacionadas is 'Narcotráfico o  actividades relacionadas.';
comment on column analitica.violencia_contexto_binarizado.con_cont_no_sabe___no_responde is 'No sabe / No responde';
comment on column analitica.violencia_contexto_binarizado.con_cont_ocupacion_temporal_de_espacios_sociales_ is 'Ocupación temporal de espacios sociales comunitarios';
comment on column analitica.violencia_contexto_binarizado.con_cont_omision_de_la_accion_protectora_por_part is 'Omisión de la acción protectora por parte de la institucionalidad';
comment on column analitica.violencia_contexto_binarizado.con_cont_operaciones_militares_en_el_terreno is 'Operaciones militares en el terreno';
comment on column analitica.violencia_contexto_binarizado.con_cont_organismos_nacionales_e_internacionales is 'Organismos nacionales e internacionales';
comment on column analitica.violencia_contexto_binarizado.con_cont_partidos_y_movimientos_politicos is 'Partidos y movimientos políticos';
comment on column analitica.violencia_contexto_binarizado.con_cont_pillajes_por_actor_armado is 'Pillajes por actor armado';
comment on column analitica.violencia_contexto_binarizado.con_cont_plan_pistola is 'Plan Pistola';
comment on column analitica.violencia_contexto_binarizado.con_cont_presencia_de_actor_es__armado_s__en_la_z is 'Presencia de actor(es) armado(s) en la zona.';
comment on column analitica.violencia_contexto_binarizado.con_cont_proceso_de_formacion_politica_ideologica is 'Proceso de formación política/ideológica';
comment on column analitica.violencia_contexto_binarizado.con_cont_procesos_de_recuperacion_de_tierras is 'Procesos de recuperación de tierras';
comment on column analitica.violencia_contexto_binarizado.con_cont_reclutamiento_a_miembros_de_los_pueblos_ is 'Reclutamiento a miembros de los pueblos étnicos';
comment on column analitica.violencia_contexto_binarizado.con_cont_reclutamiento_forzado_de_menores is 'Reclutamiento forzado de menores';
comment on column analitica.violencia_contexto_binarizado.con_cont_recuperacion_de_tierras is 'Recuperación de tierras';
comment on column analitica.violencia_contexto_binarizado.con_cont_relacion_entre_politica_y_actores_armado is 'Relación entre política y actores armados';
comment on column analitica.violencia_contexto_binarizado.con_cont_represion_de_la_protesta_social is 'Represión de la protesta social';
comment on column analitica.violencia_contexto_binarizado.con_cont_retorno_y_reasentamiento is 'Retorno y reasentamiento';
comment on column analitica.violencia_contexto_binarizado.con_cont_rinas_callejeras is 'Riñas callejeras';
comment on column analitica.violencia_contexto_binarizado.con_cont_secuestro___toma_de_rehenes is 'Secuestro / toma de rehenes';
comment on column analitica.violencia_contexto_binarizado.con_cont_senalamientos___persecusion is 'Señalamientos / persecusión';
comment on column analitica.violencia_contexto_binarizado.con_cont_tacticas_de_inteligencia_contrainteligen is 'Tácticas de inteligencia/contrainteligencia';
comment on column analitica.violencia_contexto_binarizado.con_cont_trafico_y_trata_de_personas is 'Tráfico y trata de personas';
comment on column analitica.violencia_contexto_binarizado.con_cont_violencia_de_genero_efectuada_por_actor_ is 'Violencia de género efectuada por actor armado';
comment on column analitica.violencia_contexto_binarizado.con_cont_violencia_politica is 'Violencia política';
comment on column analitica.violencia_contexto_binarizado.esp_sig_campesinos is 'Campesinos';
comment on column analitica.violencia_contexto_binarizado.esp_sig_cocaleros is 'Cocaleros';
comment on column analitica.violencia_contexto_binarizado.esp_sig_comerciantes is 'Comerciantes';
comment on column analitica.violencia_contexto_binarizado.esp_sig_consumidores_as_de_drogas is 'Consumidores/as de drogas';
comment on column analitica.violencia_contexto_binarizado.esp_sig_el_estado is 'El Estado';
comment on column analitica.violencia_contexto_binarizado.esp_sig_empresa__cooperativa__entidad is 'Empresa, cooperativa, entidad';
comment on column analitica.violencia_contexto_binarizado.esp_sig_empresarios__as is 'Empresarios /as';
comment on column analitica.violencia_contexto_binarizado.esp_sig_estudiantes__docentes_y_o_personas_acade is 'Estudiantes, docentes y/o personas académicas';
comment on column analitica.violencia_contexto_binarizado.esp_sig_exiliados_as_y_victimas_en_el_exterior is 'Exiliados/as y víctimas en el exterior';
comment on column analitica.violencia_contexto_binarizado.esp_sig_expresiones_religiosas is 'Expresiones religiosas';
comment on column analitica.violencia_contexto_binarizado.esp_sig_familiares_de_ex_combatientes is 'Familiares de ex-combatientes';
comment on column analitica.violencia_contexto_binarizado.esp_sig_ganaderos is 'Ganaderos';
comment on column analitica.violencia_contexto_binarizado.esp_sig_grupo_armado is 'Grupo Armado';
comment on column analitica.violencia_contexto_binarizado.esp_sig_hombres is 'Hombres';
comment on column analitica.violencia_contexto_binarizado.esp_sig_industria_bananera is 'Industria Bananera';
comment on column analitica.violencia_contexto_binarizado.esp_sig_jovenes is 'Jóvenes';
comment on column analitica.violencia_contexto_binarizado.esp_sig_lideres_sociales is 'Líderes sociales';
comment on column analitica.violencia_contexto_binarizado.esp_sig_mayores_de_edad is 'Mayores de edad';
comment on column analitica.violencia_contexto_binarizado.esp_sig_militares___policias is 'Militares / policías';
comment on column analitica.violencia_contexto_binarizado.esp_sig_mineros is 'Mineros';
comment on column analitica.violencia_contexto_binarizado.esp_sig_mujeres is 'Mujeres';
comment on column analitica.violencia_contexto_binarizado.esp_sig_ninos__ninas_y_adolescentes is 'Niños, niñas y adolescentes';
comment on column analitica.violencia_contexto_binarizado.esp_sig_no_sabe___no_responde is 'No sabe / No responde';
comment on column analitica.violencia_contexto_binarizado.esp_sig_para_el_sector_sindical_y_o_politico is 'Para el sector sindical y/o político';
comment on column analitica.violencia_contexto_binarizado.esp_sig_personas_cerca_a_la_frontera is 'Personas cerca a la frontera';
comment on column analitica.violencia_contexto_binarizado.esp_sig_personas_en_ejercicio_de_prostitucion is 'Personas en ejercicio de prostitución';
comment on column analitica.violencia_contexto_binarizado.esp_sig_personas_lgbti is 'Personas LGBTI';
comment on column analitica.violencia_contexto_binarizado.esp_sig_pescadores is 'Pescadores';
comment on column analitica.violencia_contexto_binarizado.esp_sig_pueblos_etnicos is 'Pueblos étnicos';
comment on column analitica.violencia_contexto_binarizado.esp_sig_su_familia_y_o_vecinos is 'Su familia y/o vecinos';
comment on column analitica.violencia_contexto_binarizado.esp_sig_toda_la_comunidad is 'Toda la comunidad';
comment on column analitica.violencia_contexto_binarizado.esp_sig_transportistas is 'Transportistas';
comment on column analitica.violencia_contexto_binarizado.fact_ext_abusos_contra_grupos_etnicos is 'Abusos contra grupos étnicos';
comment on column analitica.violencia_contexto_binarizado.fact_ext_accion_continuada_de_grupo_armado_que_no is 'Acción continuada de grupo armado que no se demovilizó';
comment on column analitica.violencia_contexto_binarizado.fact_ext_acciones_armadas_y_combates_en_la_zona is 'Acciones armadas y combates en la zona';
comment on column analitica.violencia_contexto_binarizado.fact_ext_actividades_extractivas_ilegales_informa_hidroc is 'Actividades extractivas ilegales/informales: hidrocarburos';
comment on column analitica.violencia_contexto_binarizado.fact_ext_actividades_extractivas_ilegales_informa_madera is 'Actividades extractivas ilegales/informales: madera';
comment on column analitica.violencia_contexto_binarizado.fact_ext_actividades_extractivas_ilegales_informa_mineria is 'Actividades extractivas ilegales/informales: minería';
comment on column analitica.violencia_contexto_binarizado.fact_ext_actividades_ilegales_diferentes_al_narco is 'Actividades ilegales diferentes al narcotráfico';
comment on column analitica.violencia_contexto_binarizado.fact_ext_actividad_sindical is 'Actividad sindical';
comment on column analitica.violencia_contexto_binarizado.fact_ext_actores_armados_presentes_en_la_zona is 'Actores armados presentes en la zona';
comment on column analitica.violencia_contexto_binarizado.fact_ext_agroindustrias__cana is 'Agroindustrias: Caña';
comment on column analitica.violencia_contexto_binarizado.fact_ext_agroindustrias__otro is 'Agroindustrias: Otro';
comment on column analitica.violencia_contexto_binarizado.fact_ext_agroindustrias__palma_de_aceite is 'Agroindustrias: palma de aceite';
comment on column analitica.violencia_contexto_binarizado.fact_ext_amenaza_a_la_actividad_sindical is 'Amenaza a la actividad sindical';
comment on column analitica.violencia_contexto_binarizado.fact_ext_ausencia_del_estado_o_ineficiencia_de_su is 'Ausencia del Estado o ineficiencia de sus fuerzas armadas';
comment on column analitica.violencia_contexto_binarizado.fact_ext_beneficios_economicos is 'Beneficios económicos';
comment on column analitica.violencia_contexto_binarizado.fact_ext_cambios_en_la_estructura_y_dinamica_fami is 'Cambios en la estructura y dinámica familiar';
comment on column analitica.violencia_contexto_binarizado.fact_ext_connivencia_entre_el_estado_y_grupos_par is 'Connivencia entre el Estado y grupos paramilitares';
comment on column analitica.violencia_contexto_binarizado.fact_ext_connivencia_entre_grupo_armado_y_civiles is 'Connivencia entre grupo armado y civiles';
comment on column analitica.violencia_contexto_binarizado.fact_ext_contexto_politico is 'Contexto político';
comment on column analitica.violencia_contexto_binarizado.fact_ext_contexto_social_de_la_zona is 'Contexto social de la zona';
comment on column analitica.violencia_contexto_binarizado.fact_ext_control_social is 'Control social';
comment on column analitica.violencia_contexto_binarizado.fact_ext_control_territorial is 'Control territorial';
comment on column analitica.violencia_contexto_binarizado.fact_ext_corrupcion is 'Corrupción';
comment on column analitica.violencia_contexto_binarizado.fact_ext_denuncias_de_actos_delictivos is 'Denuncias de actos delictivos';
comment on column analitica.violencia_contexto_binarizado.fact_ext_denuncias_hechas_por_crimenes_de_estado is 'Denuncias hechas por crímenes de Estado';
comment on column analitica.violencia_contexto_binarizado.fact_ext_ejecuciones_extrajudiciales_perpetrados_ is 'Ejecuciones extrajudiciales perpetrados por la fuerza pública';
comment on column analitica.violencia_contexto_binarizado.fact_ext_elecciones is 'Elecciones';
comment on column analitica.violencia_contexto_binarizado.fact_ext_estigmatizacion_por_parentesco_o_relacio is 'Estigmatización por parentesco o relación con actor armado';
comment on column analitica.violencia_contexto_binarizado.fact_ext_factores_asociados_a_creencias__religios is 'Factores asociados a creencias, religiosos o espirituales';
comment on column analitica.violencia_contexto_binarizado.fact_ext_factores_personales_o_familiares is 'Factores personales o familiares';
comment on column analitica.violencia_contexto_binarizado.fact_ext_falta_de_oportunidades_sociales_y_econom is 'Falta de oportunidades sociales y económicas';
comment on column analitica.violencia_contexto_binarizado.fact_ext_ganaderia is 'Ganadería';
comment on column analitica.violencia_contexto_binarizado.fact_ext_hechos__violentos is 'Hechos  violentos';
comment on column analitica.violencia_contexto_binarizado.fact_ext_impunidad is 'Impunidad';
comment on column analitica.violencia_contexto_binarizado.fact_ext_incumplimiento_de_los_acuerdos_de_paz is 'Incumplimiento de los acuerdos de paz';
comment on column analitica.violencia_contexto_binarizado.fact_ext_laborales__vulneracion_de_derechos__priv is 'Laborales (vulneración de derechos, privatización, etc.)';
comment on column analitica.violencia_contexto_binarizado.fact_ext_miedo is 'Miedo';
comment on column analitica.violencia_contexto_binarizado.fact_ext_movilizaciones_sociales_en_la_zona is 'Movilizaciones sociales en la zona';
comment on column analitica.violencia_contexto_binarizado.fact_ext_narcotrafico is 'Narcotráfico';
comment on column analitica.violencia_contexto_binarizado.fact_ext_narcotrafico__comercializacion is 'Narcotráfico: comercialización';
comment on column analitica.violencia_contexto_binarizado.fact_ext_narcotrafico__cultivo is 'Narcotráfico: cultivo';
comment on column analitica.violencia_contexto_binarizado.fact_ext_narcotrafico__procesamiento is 'Narcotráfico: procesamiento';
comment on column analitica.violencia_contexto_binarizado.fact_ext_negociaciones_del_estado_con_las_farc is 'Negociaciones del Estado con las FARC';
comment on column analitica.violencia_contexto_binarizado.fact_ext_no_acatar_las_ordenes_de_actor_armado is 'No acatar las órdenes de actor armado';
comment on column analitica.violencia_contexto_binarizado.fact_ext_no_sabe___no_responde is 'No sabe / No responde';
comment on column analitica.violencia_contexto_binarizado.fact_ext_operativo_policial_o_militar is 'Operativo policial o militar';
comment on column analitica.violencia_contexto_binarizado.fact_ext_otras_industrias_o_comercios is 'Otras industrias o comercios';
comment on column analitica.violencia_contexto_binarizado.fact_ext_persecuciones_a_personas_o_organizacione is 'Persecuciones a personas o organizaciones con pensamiento diferente al del grupo armado';
comment on column analitica.violencia_contexto_binarizado.fact_ext_pobreza_y_vulneracion_a_derechos_sociale is 'Pobreza y vulneración a derechos sociales, económicos y culturales';
comment on column analitica.violencia_contexto_binarizado.fact_ext_politicas_estatales_para_la_eliminacion_ is 'Políticas estatales para la eliminación de cultivos ilícitos';
comment on column analitica.violencia_contexto_binarizado.fact_ext_por_el_oficio_o_la_profesion is 'Por el oficio o la profesión';
comment on column analitica.violencia_contexto_binarizado.fact_ext_presencia_de_grupos_armados is 'Presencia de grupos armados';
comment on column analitica.violencia_contexto_binarizado.fact_ext_presunta__ayuda_a_actor_armado is 'Presunta  ayuda a actor armado';
comment on column analitica.violencia_contexto_binarizado.fact_ext_presuntamente_ser_miembro_o_tener_relaci is 'Presuntamente ser miembro o tener relación con actor armado';
comment on column analitica.violencia_contexto_binarizado.fact_ext_problemas_familiares_o_personales__chism is 'Problemas familiares o personales (chismes, problemas amorosos, etc)';
comment on column analitica.violencia_contexto_binarizado.fact_ext_prostitucion is 'Prostitución';
comment on column analitica.violencia_contexto_binarizado.fact_ext_proyectos_de_infraestructura__hidroelect is 'Proyectos de infraestructura: hidroeléctricos';
comment on column analitica.violencia_contexto_binarizado.fact_ext_proyectos_de_infraestructura__otro is 'Proyectos de infraestructura: otro';
comment on column analitica.violencia_contexto_binarizado.fact_ext_proyectos_de_infraestructura__portuarios is 'Proyectos de infraestructura: portuarios';
comment on column analitica.violencia_contexto_binarizado.fact_ext_proyectos_de_infraestructura__viales is 'Proyectos de infraestructura: viales';
comment on column analitica.violencia_contexto_binarizado.fact_ext_racismo_y_discriminacion is 'Racismo y discriminación';
comment on column analitica.violencia_contexto_binarizado.fact_ext_residencia_en_ubicacion_estrategica_para is 'Residencia en ubicación estratégica para grupos armado';
comment on column analitica.violencia_contexto_binarizado.fact_ext_resistencia_y_critica_al_accionar_de_gru is 'Resistencia y crítica al accionar de grupo armado';
comment on column analitica.violencia_contexto_binarizado.fact_ext_retaliacion is 'Retaliación';
comment on column analitica.violencia_contexto_binarizado.fact_ext_robos___pillaje is 'Robos / pillaje';
comment on column analitica.violencia_contexto_binarizado.fact_ext_robo___transporte_de_armas is 'Robo / transporte de armas';
comment on column analitica.violencia_contexto_binarizado.fact_ext_seguridad is 'Seguridad';
comment on column analitica.violencia_contexto_binarizado.fact_ext_su_condicion_de_liderazgo_social is 'Su condición de liderazgo social';
comment on column analitica.violencia_contexto_binarizado.fact_ext_suministrar_informacion_a_actor_armado is 'Suministrar información a actor armado';
comment on column analitica.violencia_contexto_binarizado.fact_ext_violacion_del_derecho_internacional_huma is 'Violación del derecho Internacional Humanitario';
comment on column analitica.violencia_contexto_binarizado.benef_agentes_externos_que_imponian_politica_e is 'Agentes externos que imponían política educativa y económica (FMI-BM)';
comment on column analitica.violencia_contexto_binarizado.benef_agentes_inmobiliarios_o_compradores_de_t is 'Agentes inmobiliarios o compradores de tierras';
comment on column analitica.violencia_contexto_binarizado.benef_alguno_de_los_grupos_armados is 'Alguno de los grupos armados';
comment on column analitica.violencia_contexto_binarizado.benef_alvaro_uribe is 'Álvaro Uribe';
comment on column analitica.violencia_contexto_binarizado.benef_autoridades_locales is 'Autoridades locales';
comment on column analitica.violencia_contexto_binarizado.benef_autoridades_universitarias is 'Autoridades universitarias';
comment on column analitica.violencia_contexto_binarizado.benef_cabildo_indigena is 'Cabildo indígena';
comment on column analitica.violencia_contexto_binarizado.benef_civil_es_ is 'Civil(es)';
comment on column analitica.violencia_contexto_binarizado.benef_clase_politica_de_derecha_del_pais is 'Clase política de derecha del país';
comment on column analitica.violencia_contexto_binarizado.benef_comerciantes_de_la_zona is 'Comerciantes de la zona';
comment on column analitica.violencia_contexto_binarizado.benef_corporaciones__ongs__instituciones_no_gu is 'Corporaciones, ONGs, instituciones no gubernamentales';
comment on column analitica.violencia_contexto_binarizado.benef_departamento_administrativo_de_seguridad is 'Departamento Administrativo de seguridad (DAS)';
comment on column analitica.violencia_contexto_binarizado.benef_directores_de_carceles is 'Directores de Cárceles';
comment on column analitica.violencia_contexto_binarizado.benef_dirigentes_politicos_regionales is 'Dirigentes políticos regionales';
comment on column analitica.violencia_contexto_binarizado.benef_el_estado is 'El Estado';
comment on column analitica.violencia_contexto_binarizado.benef_empresarios_de_la_zona is 'Empresarios de la zona';
comment on column analitica.violencia_contexto_binarizado.benef_empresas_multinacionales_transnacionales is 'Empresas multinacionales/transnacionales';
comment on column analitica.violencia_contexto_binarizado.benef_entidades_estatales is 'Entidades estatales';
comment on column analitica.violencia_contexto_binarizado.benef_exintegrantes_de_grupos_armados_ilegales is 'Exintegrantes de grupos armados ilegales';
comment on column analitica.violencia_contexto_binarizado.benef_familiares is 'Familiares';
comment on column analitica.violencia_contexto_binarizado.benef_fuerzas_armadas_del_estado__militares__p is 'Fuerzas armadas del estado (militares, policías, etc.)';
comment on column analitica.violencia_contexto_binarizado.benef_ganaderos_de_la_zona is 'Ganaderos de la zona';
comment on column analitica.violencia_contexto_binarizado.benef_grupo_criminal_de_la_zona is 'Grupo criminal de la zona';
comment on column analitica.violencia_contexto_binarizado.benef_grupo_dedicado_a_l_narcotrafico_u_otros_ is 'Grupo dedicado a l narcotráfico u otros negocios ilegales';
comment on column analitica.violencia_contexto_binarizado.benef_grupos_politicos_y_o_economicos__del_pai is 'Grupos Politicos y/o Economicos  del pais';
comment on column analitica.violencia_contexto_binarizado.benef_interesados_en_mantener_la_guerra is 'Interesados en mantener la guerra';
comment on column analitica.violencia_contexto_binarizado.benef_la_iglesia is 'La Iglesia';
comment on column analitica.violencia_contexto_binarizado.benef_la_oligarquia_de_la_zona is 'La Oligarquía de la zona';
comment on column analitica.violencia_contexto_binarizado.benef_lider_de_grupo_ilegal is 'Líder de grupo ilegal';
comment on column analitica.violencia_contexto_binarizado.benef_militares_de_la_zona is 'Militares de la zona';
comment on column analitica.violencia_contexto_binarizado.benef_mineros is 'Mineros';
comment on column analitica.violencia_contexto_binarizado.benef_no_hubo_beneficiados is 'No hubo beneficiados';
comment on column analitica.violencia_contexto_binarizado.benef_no_sabe is 'No sabe';
comment on column analitica.violencia_contexto_binarizado.benef_pobladores_de_la_zona is 'Pobladores de la zona';
comment on column analitica.violencia_contexto_binarizado.benef_politicos_de_la_zona is 'Políticos de la zona';
comment on column analitica.violencia_contexto_binarizado.benef_terratenientes_de_la_zona is 'Terratenientes de la zona';
comment on column analitica.violencia_contexto_binarizado.benef_testferro_de_grupos_armados is 'Testferro de grupos armados';



