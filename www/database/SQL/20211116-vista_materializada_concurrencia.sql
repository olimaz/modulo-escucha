create materialized view if not exists analitica.concurrencia_victima as
SELECT victima.id_victima,
       CASE
           WHEN sum(violencia.v_muerte_homicidio) = 0 THEN 0
           ELSE 1
           END AS v_muerte_homicidio,
       CASE
           WHEN sum(violencia.v_atentado) = 0 THEN 0
           ELSE 1
           END AS v_atentado,
       CASE
           WHEN sum(violencia.v_amenaza) = 0 THEN 0
           ELSE 1
           END AS v_amenaza,
       CASE
           WHEN sum(violencia.v_desaparicion_forzada) = 0 THEN 0
           ELSE 1
           END AS v_desaparicion_forzada,
       CASE
           WHEN sum(violencia.v_tortura) = 0 THEN 0
           ELSE 1
           END AS v_tortura,
       CASE
           WHEN sum(violencia.v_violencia_sexual) = 0 THEN 0
           ELSE 1
           END AS v_violencia_sexual,
       CASE
           WHEN sum(violencia.v_esclavitud_no_sexual) = 0 THEN 0
           ELSE 1
           END AS v_esclavitud_no_sexual,
       CASE
           WHEN sum(violencia.v_reclutamiento) = 0 THEN 0
           ELSE 1
           END AS v_reclutamiento,
       CASE
           WHEN sum(violencia.v_detencion) = 0 THEN 0
           ELSE 1
           END AS v_detencion,
       CASE
           WHEN sum(violencia.v_secuestro) = 0 THEN 0
           ELSE 1
           END AS v_secuestro,
       CASE
           WHEN sum(violencia.v_confinamiento) = 0 THEN 0
           ELSE 1
           END AS v_confinamiento,
       CASE
           WHEN sum(violencia.v_pillaje) = 0 THEN 0
           ELSE 1
           END AS v_pillaje,
       CASE
           WHEN sum(violencia.v_extorsion) = 0 THEN 0
           ELSE 1
           END AS v_extorsion,
       CASE
           WHEN sum(violencia.v_ataque_bien_protegido) = 0 THEN 0
           ELSE 1
           END AS v_ataque_bien_protegido,
       CASE
           WHEN sum(violencia.v_ataque_indiscriminado) = 0 THEN 0
           ELSE 1
           END AS v_ataque_indiscriminado,
       CASE
           WHEN sum(violencia.v_despojo) = 0 THEN 0
           ELSE 1
           END AS v_despojo,
       CASE
           WHEN sum(violencia.v_desplazamiento) = 0 THEN 0
           ELSE 1
           END AS v_desplazamiento,
       CASE
           WHEN sum(violencia.v_exilio) = 0 THEN 0
           ELSE 1
           END AS v_exilio
FROM analitica.violencia
         JOIN analitica.victima_violencia ON violencia.id_hecho = victima_violencia.id_hecho
         JOIN analitica.victima ON victima_violencia.id_victima = victima.id_victima
GROUP BY victima.id_victima;

alter materialized view analitica.concurrencia_victima owner to dba;

create materialized view analitica.concurrencia_entrevista as
SELECT victima.codigo_entrevista,
       CASE
           WHEN sum(violencia.v_muerte_homicidio) = 0 THEN 0
           ELSE 1
           END AS v_muerte_homicidio,
       CASE
           WHEN sum(violencia.v_atentado) = 0 THEN 0
           ELSE 1
           END AS v_atentado,
       CASE
           WHEN sum(violencia.v_amenaza) = 0 THEN 0
           ELSE 1
           END AS v_amenaza,
       CASE
           WHEN sum(violencia.v_desaparicion_forzada) = 0 THEN 0
           ELSE 1
           END AS v_desaparicion_forzada,
       CASE
           WHEN sum(violencia.v_tortura) = 0 THEN 0
           ELSE 1
           END AS v_tortura,
       CASE
           WHEN sum(violencia.v_violencia_sexual) = 0 THEN 0
           ELSE 1
           END AS v_violencia_sexual,
       CASE
           WHEN sum(violencia.v_esclavitud_no_sexual) = 0 THEN 0
           ELSE 1
           END AS v_esclavitud_no_sexual,
       CASE
           WHEN sum(violencia.v_reclutamiento) = 0 THEN 0
           ELSE 1
           END AS v_reclutamiento,
       CASE
           WHEN sum(violencia.v_detencion) = 0 THEN 0
           ELSE 1
           END AS v_detencion,
       CASE
           WHEN sum(violencia.v_secuestro) = 0 THEN 0
           ELSE 1
           END AS v_secuestro,
       CASE
           WHEN sum(violencia.v_confinamiento) = 0 THEN 0
           ELSE 1
           END AS v_confinamiento,
       CASE
           WHEN sum(violencia.v_pillaje) = 0 THEN 0
           ELSE 1
           END AS v_pillaje,
       CASE
           WHEN sum(violencia.v_extorsion) = 0 THEN 0
           ELSE 1
           END AS v_extorsion,
       CASE
           WHEN sum(violencia.v_ataque_bien_protegido) = 0 THEN 0
           ELSE 1
           END AS v_ataque_bien_protegido,
       CASE
           WHEN sum(violencia.v_ataque_indiscriminado) = 0 THEN 0
           ELSE 1
           END AS v_ataque_indiscriminado,
       CASE
           WHEN sum(violencia.v_despojo) = 0 THEN 0
           ELSE 1
           END AS v_despojo,
       CASE
           WHEN sum(violencia.v_desplazamiento) = 0 THEN 0
           ELSE 1
           END AS v_desplazamiento,
       CASE
           WHEN sum(violencia.v_exilio) = 0 THEN 0
           ELSE 1
           END AS v_exilio
FROM analitica.violencia
         JOIN analitica.victima_violencia ON violencia.id_hecho = victima_violencia.id_hecho
         JOIN analitica.victima ON victima_violencia.id_victima = victima.id_victima
GROUP BY victima.codigo_entrevista;

alter materialized view analitica.concurrencia_entrevista owner to dba;

create materialized view analitica.concurrencia_responsabilidad_victima as
SELECT victima.id_victima,
       CASE
           WHEN sum(violencia.aa_p_grupo_paramilitar + violencia.aa_p_ns_nr) = 0 THEN 0
           ELSE 1
           END AS aa_paramilitar,
       CASE
           WHEN sum(violencia.aa_g_farc + violencia.aa_g_eln + violencia.aa_g_otro + violencia.aa_g_ns_nr) = 0 THEN 0
           ELSE 1
           END AS aa_guerrilla,
       CASE
           WHEN sum(violencia.aa_fp_ejercito + violencia.aa_fp_armada + violencia.aa_fp_fuerza_aerea +
                    violencia.aa_fp_policia) = 0 THEN 0
           ELSE 1
           END AS aa_fuerza_publica,
       CASE
           WHEN sum(violencia.aa_oga_otro_grupo_armado + violencia.aa_oga_otro_pais) = 0 THEN 0
           ELSE 1
           END AS aa_otro_grupo_armado,
       CASE
           WHEN sum(violencia.aa_ns_nr) = 0 THEN 0
           ELSE 1
           END AS aa_ns_nr,
       CASE
           WHEN sum(violencia.tc_tc_politico + violencia.tc_tc_medios_comunicacion +
                    violencia.tc_tc_social_comunitario + violencia.tc_tc_academico + violencia.tc_tc_econcomico +
                    violencia.tc_tc_otros) = 0 THEN 0
           ELSE 1
           END AS tc_tercero_civil,
       CASE
           WHEN sum(violencia.tc_oae_ejecutivo_legislativo + violencia.tc_oae_organos_control +
                    violencia.tc_oae_justicia + violencia.tc_oae_inteligencia + violencia.tc_oae_otro) = 0 THEN 0
           ELSE 1
           END AS tc_estado,
       CASE
           WHEN sum(violencia.tc_int_gobierno_extranjero + violencia.tc_int_empresa_transnacional +
                    violencia.tc_int_otros) = 0 THEN 0
           ELSE 1
           END AS tc_internacional,
       CASE
           WHEN sum(violencia.tc_otro_actor) = 0 THEN 0
           ELSE 1
           END AS tc_otro_actor
FROM analitica.violencia
         JOIN analitica.victima_violencia ON violencia.id_hecho = victima_violencia.id_hecho
         JOIN analitica.victima ON victima_violencia.id_victima = victima.id_victima
GROUP BY victima.id_victima;

alter materialized view analitica.concurrencia_responsabilidad_victima owner to dba;



create materialized view analitica.vista_violencia as
SELECT vio.victimas_total,
       vio.victimas_identificadas,
       vio.responsables_identificados,
       vio.cantidad_muertos,
       vio.v_amenaza,
       vio.v_amenaza_ind_col,
       vio.v_a_m_verbal,
       vio.v_a_m_correo_e,
       vio.v_a_m_redes_sociales,
       vio.v_a_m_familiar,
       vio.v_a_m_carta,
       vio.v_a_m_telefono,
       vio.v_a_m_mensaje_celular,
       vio.v_a_m_hostigamiento,
       vio.v_a_m_panfleto,
       vio.v_a_m_sufragio,
       vio.v_a_m_seguimiento,
       vio.v_tortura_fisica,
       vio.v_tortura_psicologica,
       vio.v_vs_violacion_sexual,
       vio.v_vs_violacion_sexual_ind_col,
       vio.v_vs_violacion_sexual_publico,
       vio.v_vs_violacion_sexual_multiple_responsable,
       vio.v_vs_violacion_sexual_embarazo,
       vio.v_vs_violacion_sexual_embarazo_nacimiento,
       vio.v_vs_embarazo_forzado_ind_col,
       vio.v_vs_embarazo_forzado_publico,
       vio.v_vs_embarazo_forzado_multiple_responsable,
       vio.v_vs_embarazo_forzado_embarazo,
       vio.v_vs_amenaza,
       vio.v_vs_amenaza_ind_col,
       vio.v_vs_amenaza_publico,
       vio.v_vs_amenaza_multiple_responsable,
       vio.v_vs_amenaza_embarazo,
       vio.v_vs_amenaza_embarazo_nacimiento,
       vio.v_vs_acoso_sexual,
       vio.v_vs_aborto_forzado,
       vio.v_vs_obligar_realizar,
       vio.v_vs_esclavitud,
       vio.v_vs_desnudez_forzada,
       vio.v_confinamiento,
       vio.v_despojo,
       vio.v_desplazamiento,
       vio.tc_tc_politico,
       vio.fecha_inicio,
       vio.hechos_continuan,
       vio.lugar_n1_txt,
       vio.lugar_n2_txt,
       vio.lugar_n3_txt,
       vio.lugar_zona,
       vio.v_m_homicidio,
       vio.v_m_masacre,
       vio.v_m_combates,
       vio.v_m_minas,
       vio.v_m_atentado_bombas,
       vio.v_m_ataque_bienes,
       vio.v_m_sevicia,
       vio.v_at_herido,
       vio.v_at_sin_lesiones,
       vio.v_at_civil_herido_combate,
       vio.v_at_civil_herido_bomba,
       vio.v_at_civil_minas,
       vio.v_at_civil_ataque_bienes,
       vio.v_desaparicion_forzada,
       vio.v_d_m_paradero_desconocido,
       vio.v_d_m_encontrado_sin_identificar,
       vio.v_d_m_encontrado_identificado,
       vio.v_d_m_destruccion_cuerpos,
       vio.v_d_m_cuerpo_entregado,
       vio.v_d_m_encontrada_viva,
       vio.v_d_m_fosa_comun,
       vio.v_tortura_fisica_ind_col,
       vio.v_tortura_fisica_publico,
       vio.v_t_m_golpes_sin_instrumentos,
       vio.v_t_m_golpes_con_instrumentos,
       vio.v_t_m_castigos,
       vio.v_t_m_vendaje,
       vio.v_t_m_colgamiento,
       vio.v_t_m_mordazas,
       vio.v_t_m_asfixia_bolsas,
       vio.v_t_m_asfixia_inmersion,
       vio.v_t_m_asfixia_otros,
       vio.v_t_m_electricidad,
       vio.v_t_m_drogas,
       vio.v_t_m_animales,
       vio.v_t_m_trabajo_forzado,
       vio.v_t_m_quemaduras,
       vio.v_t_m_temperaturas_extremas,
       vio.v_t_m_alimentacion,
       vio.v_tortura_psicologica_ind_col,
       vio.v_tortura_psicologica_publico,
       vio.v_t_m_senyalamientos,
       vio.v_t_m_escarnio,
       vio.v_t_m_hacinamiento,
       vio.v_t_m_aislamiento,
       vio.v_t_m_higiene,
       vio.v_t_m_suenyo,
       vio.v_t_m_incomunicacion,
       vio.v_t_m_presenciar_tortura,
       vio.v_t_m_insultos,
       vio.v_t_m_amenazas,
       vio.v_t_m_falta_atencion_medica,
       vio.v_t_m_musica_estridente,
       vio.v_t_m_humillacion_racial,
       vio.v_t_m_seguimientos,
       vio.v_vs_embarazo_forzado,
       vio.v_vs_acoso_sexual_ind_col,
       vio.v_vs_acoso_sexual_publico,
       vio.v_vs_acoso_sexual_multiple_responsable,
       vio.v_vs_acoso_sexual_embarazo,
       vio.v_vs_acoso_sexual_embarazo_nacimiento,
       vio.v_vs_aborto_forzado_ind_col,
       vio.v_vs_aborto_forzado_publico,
       vio.v_vs_aborto_forzado_multiple_responsable,
       vio.v_vs_aborto_forzado_embarazo,
       vio.v_vs_aborto_forzado_embarazo_nacimiento,
       vio.v_vs_obligar_presenciar,
       vio.v_vs_obligar_presenciar_ind_col,
       vio.v_vs_obligar_presenciar_publico,
       vio.v_vs_obligar_presenciar_multiple_responsable,
       vio.v_vs_obligar_presenciar_embarazo,
       vio.v_vs_obligar_presenciar_embarazo_nacimiento,
       vio.v_vs_obligar_realizar_ind_col,
       vio.v_vs_obligar_realizar_publico,
       vio.v_vs_obligar_realizar_multiple_responsable,
       vio.v_vs_obligar_realizar_embarazo,
       vio.v_vs_obligar_realizar_embarazo_nacimiento,
       vio.v_vs_cambios_forzados_ind_col,
       vio.v_vs_cambios_forzados_publico,
       vio.v_vs_cambios_forzados_multiple_responsable,
       vio.v_vs_cambios_forzados_embarazo,
       vio.v_vs_cambios_forzados_embarazo_nacimiento,
       vio.v_vs_esclavitud_ind_col,
       vio.v_vs_esclavitud_publico,
       vio.v_vs_esclavitud_multiple_responsable,
       vio.v_vs_esclavitud_embarazo,
       vio.v_vs_esclavitud_embarazo_nacimiento,
       vio.v_vs_desnudez_forzada_ind_col,
       vio.v_vs_desnudez_forzada_publico,
       vio.v_vs_desnudez_forzada_multiple_responsable,
       vio.v_vs_desnudez_forzada_embarazo,
       vio.v_vs_maternidad_forzada_ind_col,
       vio.v_vs_maternidad_forzada_publico,
       vio.v_vs_maternidad_forzada_multiple_responsable,
       vio.v_vs_maternidad_forzada_embarazo,
       vio.v_vs_maternidad_forzada_embarazo_nacimiento,
       vio.v_vs_cohabitacion_forzada_ind_col,
       vio.v_vs_cohabitacion_forzada_publico,
       vio.v_vs_cohabitacion_forzada_multiple_responsable,
       vio.v_vs_cohabitacion_forzada_embarazo,
       vio.v_vs_cohabitacion_forzada_embarazo_nacimiento,
       vio.v_vs_otra_forma_ind_col,
       vio.v_vs_otra_forma_publico,
       vio.v_vs_otra_forma_multiple_responsable,
       vio.v_vs_otra_forma_embarazo,
       vio.v_vs_otra_forma_embarazo_nacimiento,
       vio.v_esclavitud_no_sexual,
       vio.v_esclavitud_no_sexual_publico,
       vio.v_reclutamiento,
       vio.v_reclutamiento_publico,
       vio.v_reclutamiento_ind_col,
       vio.v_r_m_acciones_belicas,
       vio.v_r_m_vigilancia,
       vio.v_r_m_sexual,
       vio.v_r_m_trata,
       vio.v_r_m_logistica,
       vio.v_r_m_narcotrafico,
       vio.v_r_m_amenaza,
       vio.v_r_m_otros,
       vio.v_detencion,
       vio.v_detencion_ind_col,
       vio.v_secuestro,
       vio.v_secuestro_ind_col,
       vio.v_secuestro_publico,
       vio.v_confinamiento_ind_col,
       vio.v_pillaje,
       vio.v_extorsion,
       vio.v_abp_civil,
       vio.v_abp_sanitario,
       vio.v_abp_religioso,
       vio.v_abp_sagrado,
       vio.v_abp_cultural,
       vio.v_abp_peligroso,
       vio.v_abp_medioambiente,
       vio.v_ataque_indiscriminado,
       vio.v_despojo_ind_col,
       vio.v_despojo_hectareas,
       vio.v_despojo_recupero_tierras,
       vio.v_despojo_recupero_derechos,
       vio.v_dp_m_abandono,
       vio.v_dp_m_acto_juridico,
       vio.v_dp_m_armado,
       vio.v_dp_m_apropiacion,
       vio.v_dp_m_venta_forzada,
       vio.v_dp_m_revocacion,
       vio.v_desplazamiento_ind_col,
       vio.v_desplazamiento_origen_n1_txt,
       vio.v_desplazamiento_origen_n2_txt,
       vio.v_desplazamiento_origen_n3_txt,
       vio.v_desplazamiento_llegada_n1_txt,
       vio.v_desplazamiento_llegada_n2_txt,
       vio.v_desplazamiento_llegada_n3_txt,
       vio.v_desplazamiento_sentido,
       vio.v_desplazamiento_retorno,
       vio.v_desplazamiento_retorno_ind_col,
       vio.v_exilio,
       vio.aa_p_grupo_paramilitar,
       vio.aa_p_grupo_paramilitar_detalle,
       vio.aa_p_ns_nr,
       vio.aa_g_farc,
       vio.aa_g_eln,
       vio.aa_g_otro,
       vio.aa_g_ns_nr,
       vio.aa_fp_ejercito,
       vio.aa_fp_armada,
       vio.aa_fp_fuerza_aerea,
       vio.aa_fp_policia,
       vio.aa_oga_otro_grupo_armado,
       vio.aa_oga_otro_pais,
       vio.aa_ns_nr,
       vio.tc_tc_politico_detalle,
       vic.id_victima,
       vic.id_entrevista,
       vic.fec_nac_anio,
       vic.fec_nac_mes,
       vic.fec_nac_dia,
       vic.lugar_nac_n1_txt,
       vic.lugar_nac_n2_txt,
       vic.sexo_txt,
       vic.orientacion_sexual_txt,
       vic.identidad_genero_txt,
       vic.pertenencia_etnica_txt,
       vic.pertenencia_indigena_txt,
       vic.documento_identidad_tipo_txt,
       vic.nacionalidad_txt,
       vic.estado_civil_txt,
       vic.lugar_residencia_n1_txt,
       vic.lugar_residencia_n2_txt,
       vic.lugar_residencia_n3_txt,
       vic.lugar_residencia_zona_txt,
       vic.educacion_formal_txt,
       vic.profesion,
       vic.ocupacion_actual,
       vic.d_sensorial,
       vic.d_intelectual,
       vic.d_psicosocial,
       vic.d_fisica,
       vic.cargo_publico,
       vic.cargo_publico_cual,
       vic.fuerza_publica_miembro,
       vic.fuerza_publica_estado,
       vic.fuerza_publica_especificar,
       vic.actor_armado_ilegal,
       vic.actor_armado_ilegal_especificar,
       vic.relacion_persona_entrevistada,
       vic.id_persona_entrevistada,
       vv.id_hecho,
       vv.edad      AS edad_victima,
       vv.ocupacion AS ocupacion_victima,
       vv.lugar_res_n1_txt,
       vv.lugar_res_n2_txt,
       vv.lugar_res_n3_txt,
       vv.lugar_res_zona_txt,
       ri.id_hecho_responsable,
       ri.id_responsable,
       ri.nombre,
       ri.apellido,
       ri.otros_nombres,
       ri.edad      AS edad_responsable,
       ri.sexo,
       ri.actor_armado,
       ri.rango_cargo,
       ri.responsabilidad_ordeno,
       ri.responsabilidad_planeo,
       ri.responsabilidad_realizo,
       ri.responsabilidad_participo,
       ri.responsabilidad_no_evito,
       ri.nombre_superior,
       ri.sabe_que_hace_ahora,
       ri.ahora_que_hace,
       ri.ahora_donde_esta,
       ri.sabe_otros_hechos,
       ri.cuales_otros_hechos,
       vc.grupo,
       vc.contexto,
       met.fichas_diligenciadas
FROM analitica.violencia vio
         LEFT JOIN analitica.victima_violencia vv ON vio.id_hecho = vv.id_hecho
         LEFT JOIN analitica.victima vic ON vv.id_victima = vic.id_victima
         LEFT JOIN analitica.presunto_responsable_individual ri ON vio.id_hecho = ri.id_hecho
         LEFT JOIN analitica.violencia_contexto vc ON vio.id_hecho = vc.id_hecho
         LEFT JOIN analitica.metadatos met ON vio.id_entrevista = met.id_entrevista
WHERE met.fichas_diligenciadas = 'Completado'::text;

alter materialized view analitica.vista_violencia owner to dba;

grant select on analitica.vista_violencia to solo_lectura;

