drop table if exists esclarecimiento.excel_sujeto_colectivo;
create table if not exists esclarecimiento.excel_sujeto_colectivo
(
    id serial
        constraint excel_sujeto_colectivo_pkey
            primary key,
    id_entrevista_etnica integer,
    codigo_entrevista text,
    medios_virtuales text,
    situacion_actual text,
    personas_entrevistadas integer default 1,
    macroterritorio text,
    territorio text,
    clasificacion integer default 3,
    codigo_entrevistador text,
    grupo_entrevistador text,
    entrevista_fecha text,
    entrevista_mes text,
    tiempo_entrevista integer default 0,
    entrevista_lugar_n1 text,
    entrevista_lugar_n2 text,
    entrevista_lugar_n3 text,
    entrevista_lat double precision,
    entrevista_lon double precision,
    tipo_entrevista text,
    tipo_sujeto_colectivo text,
    sector_entrevistado text,
    tema text,
    objetivo text,
    hechos_anio_del text,
    hechos_anio_al text,
    hechos_lugar_n1 text,
    hechos_lugar_n2 text,
    hechos_lugar_n3 text,
    descripcin_eventos text,
    titulo text,
    dinamica_1 text,
    dinamica_2 text,
    dinamica_3 text,
    i_achagua integer default 0,
    i_ambalo integer default 0,
    i_amorua integer default 0,
    i_andoke integer default 0,
    i_arhuaco integer default 0,
    i_awa integer default 0,
    i_barasan integer default 0,
    i_bara integer default 0,
    i_bari integer default 0,
    i_betoye integer default 0,
    i_bora integer default 0,
    i_carapana integer default 0,
    i_chiricoa integer default 0,
    i_cocama integer default 0,
    i_coreguaje integer default 0,
    i_curripako integer default 0,
    i_desano integer default 0,
    i_embera_chami integer default 0,
    i_embrea_dobida integer default 0,
    i_embera_katio integer default 0,
    i_eperara integer default 0,
    i_ett integer default 0,
    i_guanaca integer default 0,
    i_guane integer default 0,
    i_guna integer default 0,
    i_hitnu integer default 0,
    i_hupde integer default 0,
    i_ijku integer default 0,
    i_inga integer default 0,
    i_jiw integer default 0,
    i_jupda integer default 0,
    i_juhup integer default 0,
    i_kakua integer default 0,
    i_kamentsa integer default 0,
    i_kankuamo integer default 0,
    i_karijona integer default 0,
    i_kawiyari integer default 0,
    i_kofan integer default 0,
    i_kogui integer default 0,
    i_kokonuko integer default 0,
    i_kubeo integer default 0,
    i_leguama integer default 0,
    i_makaguaje integer default 0,
    i_makuma integer default 0,
    i_mapayerri integer default 0,
    i_masiguare integer default 0,
    i_matapi integer default 0,
    i_mirana integer default 0,
    i_misak integer default 0,
    i_mokana integer default 0,
    i_muina integer default 0,
    i_muisca integer default 0,
    i_nasa integer default 0,
    i_nonyha integer default 0,
    i_nukak integer default 0,
    i_nutabe integer default 0,
    i_okaina integer default 0,
    i_pastos integer default 0,
    i_piapoco integer default 0,
    i_piarona integer default 0,
    i_pijao integer default 0,
    i_piratapuyo integer default 0,
    i_pisamira integer default 0,
    i_plindara integer default 0,
    i_pubense integer default 0,
    i_puinave integer default 0,
    i_quichua integer default 0,
    i_quillanciga integer default 0,
    i_quizgo integer default 0,
    i_sikuani integer default 0,
    i_siona integer default 0,
    i_saliba integer default 0,
    i_taiwano integer default 0,
    i_tama integer default 0,
    i_tanigua integer default 0,
    i_tanimuka integer default 0,
    i_tariano integer default 0,
    i_tatuyo integer default 0,
    i_tikuna integer default 0,
    i_totoro integer default 0,
    i_tsiripu integer default 0,
    i_tubu integer default 0,
    i_tucano integer default 0,
    i_tuyuka integer default 0,
    i_uitoto integer default 0,
    i_uwa integer default 0,
    i_wamonae integer default 0,
    i_wanano integer default 0,
    i_waunan integer default 0,
    i_wayuu integer default 0,
    i_wipijiki integer default 0,
    i_wiwa integer default 0,
    i_yagua integer default 0,
    i_yamalero integer default 0,
    i_yanacona integer default 0,
    i_yari integer default 0,
    i_yaruro integer default 0,
    i_yauna integer default 0,
    i_yeral integer default 0,
    i_yukpa integer default 0,
    i_yukuna integer default 0,
    i_yuri integer default 0,
    i_yuruti integer default 0,
    i_zenu integer default 0,
    a_afrocolombiano integer default 0,
    a_negro integer default 0,
    a_palenquero integer default 0,
    a_raizal integer default 0,
    r_cucuta integer default 0,
    r_envigado integer default 0,
    r_giron integer default 0,
    r_ibague integer default 0,
    r_pasto integer default 0,
    r_prorom integer default 0,
    r_sabanalarga integer default 0,
    r_sahagun integer default 0,
    r_sampues integer default 0,
    r_san_pelayo integer default 0,
    r_union_romani integer default 0,
    transcrita integer default 0,
    transcrita_fecha text,
    transcrita_fecha_a text,
    transcrita_fecha_m text,
    etiquetada integer default 0,
    etiquetada_fecha text,
    etiquetada_fecha_a text,
    etiquetada_fecha_m text,
    i_objetivo_esclarecimiento integer default 0,
    i_objetivo_reconocimiento integer default 0,
    i_objetivo_convivencia integer default 0,
    i_objetivo_no_repeticion integer default 0,
    i_enfoque_genero integer default 0,
    i_enfoque_psicosocial integer default 0,
    i_enfoque_curso_vida integer default 0,
    i_direccion_investigacion integer default 0,
    i_direccion_territorios integer default 0,
    i_direccion_etnica integer default 0,
    i_comisionados integer default 0,
    i_estrategia_arte integer default 0,
    i_estrategia_comunicacion integer default 0,
    i_estrategia_participacion integer default 0,
    i_estrategia_pedagogia integer default 0,
    i_grupo_acceso_informacion integer default 0,
    i_presidencia integer default 0,
    i_otra integer default 0,
    i_enlace integer default 0,
    i_sistema_informacion integer default 0,
    ia_pueblo_etnico integer default 0,
    ia_dialogo_social integer default 0,
    ia_genero integer default 0,
    ia_enfoque_ps integer default 0,
    ia_curso_vida integer default 0,
    nucleo_01 integer default 0,
    nucleo_02 integer default 0,
    nucleo_03 integer default 0,
    nucleo_04 integer default 0,
    nucleo_05 integer default 0,
    nucleo_06 integer default 0,
    nucleo_07 integer default 0,
    nucleo_08 integer default 0,
    nucleo_09 integer default 0,
    nucleo_10 integer default 0,
    mandato_01 integer default 0,
    mandato_02 integer default 0,
    mandato_03 integer default 0,
    mandato_04 integer default 0,
    mandato_05 integer default 0,
    mandato_06 integer default 0,
    mandato_07 integer default 0,
    mandato_08 integer default 0,
    mandato_09 integer default 0,
    mandato_10 integer default 0,
    mandato_11 integer default 0,
    mandato_12 integer default 0,
    mandato_13 integer default 0,
    a_consentimiento integer default 0,
    a_audio integer default 0,
    a_ficha_corta integer default 0,
    a_ficha_larga integer default 0,
    a_otros integer default 0,
    a_transcripcion_preliminar integer default 0,
    a_transcripcion_final integer default 0,
    a_etiquetado integer default 0,
    a_retroalimentacion integer default 0,
    a_relatoria integer default 0,
    a_certificacion_inicial integer default 0,
    a_certificacion_final integer default 0,
    a_plan_trabajo integer default 0,
    a_valoracion integer default 0,
    fecha_carga text,
    mes_carga text,
    id_entrevistador integer,
    prioridad_e_fecha text,
    prioridad_e_ponderacion integer default '-99'::integer,
    prioridad_e_fluidez integer default '-99'::integer,
    prioridad_e_d_hecho integer default '-99'::integer,
    prioridad_e_d_contexto integer default '-99'::integer,
    prioridad_e_d_impacto integer default '-99'::integer,
    prioridad_e_d_justicia integer default '-99'::integer,
    prioridad_e_cierre integer default '-99'::integer,
    prioridad_e_ahora_entiendo text,
    prioridad_e_cambio_perspectiva text,
    prioridad_t_fecha text,
    prioridad_t_ponderacion integer default '-99'::integer,
    prioridad_t_fluidez integer default '-99'::integer,
    prioridad_t_d_hecho integer default '-99'::integer,
    prioridad_t_d_contexto integer default '-99'::integer,
    prioridad_t_d_impacto integer default '-99'::integer,
    prioridad_t_d_justicia integer default '-99'::integer,
    prioridad_t_cierre integer default '-99'::integer,
    prioridad_t_ahora_entiendo text,
    prioridad_t_cambio_perspectiva text,
    -- nuevas columnas
    consentimiento_nombre_autoridad text,
    consentimiento_nombre_identitario text,
    consentimiento_pueblo_representado text,
    consentimiento_numero_identificacion text,
    --
    consentimiento_conceder_entrevista integer default '-99'::integer,
    consentimiento_grabar_audio integer default '-99'::integer,
    consentimiento_elaborar_informe integer default '-99'::integer,
    consentimiento_grabar_video integer default '-99'::integer,
    consentimiento_tomar_fotos integer default '-99'::integer,
    consentimiento_tratamiento_datos_analizar integer default '-99'::integer,
    consentimiento_tratamiento_datos_analizar_sensible integer default '-99'::integer,
    consentimiento_tratamiento_datos_utilizar integer default '-99'::integer,
    consentimiento_tratamiento_datos_utilizar_sensible integer default '-99'::integer,
    consentimiento_tratamiento_datos_publicar integer default '-99'::integer,
    minutos_entrevista integer default '-99'::integer,
    minutos_transcripcion integer default '-99'::integer,
    minutos_etiquetado integer default '-99'::integer,
    minutos_diligenciado integer default '-99'::integer
);

comment on column esclarecimiento.excel_sujeto_colectivo.id_entrevista_etnica is 'Trazabilidad a tabla original';

comment on column esclarecimiento.excel_sujeto_colectivo.i_achagua is 'Participantes indígenas: ACHAGUA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_ambalo is 'Participantes indígenas: AMBALÓ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_amorua is 'Participantes indígenas: AMORÚA ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_andoke is 'Participantes indígenas: ANDOKE';

comment on column esclarecimiento.excel_sujeto_colectivo.i_arhuaco is 'Participantes indígenas: ARHUACO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_awa is 'Participantes indígenas: AWÁ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_barasan is 'Participantes indígenas: BARASANA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_bara is 'Participantes indígenas: BARÁ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_bari is 'Participantes indígenas: BARÍ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_betoye is 'Participantes indígenas: BETOYE';

comment on column esclarecimiento.excel_sujeto_colectivo.i_bora is 'Participantes indígenas: BORA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_carapana is 'Participantes indígenas: CARAPANA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_chiricoa is 'Participantes indígenas: CHIRICOA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_cocama is 'Participantes indígenas: COCAMA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_coreguaje is 'Participantes indígenas: COREGUAJE';

comment on column esclarecimiento.excel_sujeto_colectivo.i_curripako is 'Participantes indígenas: CURRIPAKO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_desano is 'Participantes indígenas: DESANO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_embera_chami is 'Participantes indígenas: EMBERA CHAMÍ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_embrea_dobida is 'Participantes indígenas: EMBERA DÓBIDA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_embera_katio is 'Participantes indígenas: EMBERA KATÍO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_eperara is 'Participantes indígenas: EPERARA-SIAPIDARA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_ett is 'Participantes indígenas: ETT E‘NEKA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_guanaca is 'Participantes indígenas: GUANACA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_guane is 'Participantes indígenas: GUANE';

comment on column esclarecimiento.excel_sujeto_colectivo.i_guna is 'Participantes indígenas: GUNA DULE';

comment on column esclarecimiento.excel_sujeto_colectivo.i_hitnu is 'Participantes indígenas: HITNU';

comment on column esclarecimiento.excel_sujeto_colectivo.i_hupde is 'Participantes indígenas: HUPDë-HUPDAH-HUPDU';

comment on column esclarecimiento.excel_sujeto_colectivo.i_ijku is 'Participantes indígenas: IJKU';

comment on column esclarecimiento.excel_sujeto_colectivo.i_inga is 'Participantes indígenas: INGA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_jiw is 'Participantes indígenas: JIW';

comment on column esclarecimiento.excel_sujeto_colectivo.i_jupda is 'Participantes indígenas: JUDPA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_juhup is 'Participantes indígenas: JUHUP-YUJU';

comment on column esclarecimiento.excel_sujeto_colectivo.i_kakua is 'Participantes indígenas: KAKUA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_kamentsa is 'Participantes indígenas: KAMËNTŠÁ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_kankuamo is 'Participantes indígenas: KANKUAMO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_karijona is 'Participantes indígenas: KARIJONA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_kawiyari is 'Participantes indígenas: KAWIYARÍ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_kofan is 'Participantes indígenas: KOFÁN';

comment on column esclarecimiento.excel_sujeto_colectivo.i_kogui is 'Participantes indígenas: KOGUI';

comment on column esclarecimiento.excel_sujeto_colectivo.i_kokonuko is 'Participantes indígenas: KOKONUKO  ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_kubeo is 'Participantes indígenas: KUBEO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_leguama is 'Participantes indígenas: LETUAMA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_makaguaje is 'Participantes indígenas: MAKAGUAJE';

comment on column esclarecimiento.excel_sujeto_colectivo.i_makuma is 'Participantes indígenas: MAKUMA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_mapayerri is 'Participantes indígenas: MAPAYERRI';

comment on column esclarecimiento.excel_sujeto_colectivo.i_masiguare is 'Participantes indígenas: MASIGUARE';

comment on column esclarecimiento.excel_sujeto_colectivo.i_matapi is 'Participantes indígenas: MATAPÍ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_mirana is 'Participantes indígenas: MIRAÑA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_misak is 'Participantes indígenas: MISAK';

comment on column esclarecimiento.excel_sujeto_colectivo.i_mokana is 'Participantes indígenas: MOKANÁ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_muina is 'Participantes indígenas: MUINA MURUI';

comment on column esclarecimiento.excel_sujeto_colectivo.i_muisca is 'Participantes indígenas: MUISCA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_nasa is 'Participantes indígenas: NASA ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_nonyha is 'Participantes indígenas: NONUYA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_nukak is 'Participantes indígenas: NUKAK';

comment on column esclarecimiento.excel_sujeto_colectivo.i_nutabe is 'Participantes indígenas: NUTABE';

comment on column esclarecimiento.excel_sujeto_colectivo.i_okaina is 'Participantes indígenas: OKAINA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_pastos is 'Participantes indígenas: PASTOS';

comment on column esclarecimiento.excel_sujeto_colectivo.i_piapoco is 'Participantes indígenas: PIAPOCO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_piarona is 'Participantes indígenas: PIAROA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_pijao is 'Participantes indígenas: PIJAO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_piratapuyo is 'Participantes indígenas: PIRATAPUYO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_pisamira is 'Participantes indígenas: PISAMIRA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_plindara is 'Participantes indígenas: POLINDARA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_pubense is 'Participantes indígenas: PUBENSE';

comment on column esclarecimiento.excel_sujeto_colectivo.i_puinave is 'Participantes indígenas: PUINAVE';

comment on column esclarecimiento.excel_sujeto_colectivo.i_quichua is 'Participantes indígenas: QUICHUA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_quillanciga is 'Participantes indígenas: QUILLACINGA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_quizgo is 'Participantes indígenas: QUIZGÓ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_sikuani is 'Participantes indígenas: SIKUANI / GUAHIBO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_siona is 'Participantes indígenas: SIONA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_saliba is 'Participantes indígenas: SÁLIBA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_taiwano is 'Participantes indígenas: TAIWANO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_tama is 'Participantes indígenas: TAMA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_tanigua is 'Participantes indígenas: TANIGUA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_tanimuka is 'Participantes indígenas: TANIMUKA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_tariano is 'Participantes indígenas: TARIANO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_tatuyo is 'Participantes indígenas: TATUYO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_tikuna is 'Participantes indígenas: TIKUNA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_totoro is 'Participantes indígenas: TOTORÓ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_tsiripu is 'Participantes indígenas: TSIRIPU';

comment on column esclarecimiento.excel_sujeto_colectivo.i_tubu is 'Participantes indígenas: TUBU / SIRIANO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_tucano is 'Participantes indígenas: TUCANO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_tuyuka is 'Participantes indígenas: TUYUKA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_uitoto is 'Participantes indígenas: UITOTO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_uwa is 'Participantes indígenas: U WA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_wamonae is 'Participantes indígenas: WAMONAE / COIBA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_wanano is 'Participantes indígenas: WANANO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_waunan is 'Participantes indígenas: WAUNAN';

comment on column esclarecimiento.excel_sujeto_colectivo.i_wayuu is 'Participantes indígenas: WAYUU';

comment on column esclarecimiento.excel_sujeto_colectivo.i_wipijiki is 'Participantes indígenas: WIPIJIKI';

comment on column esclarecimiento.excel_sujeto_colectivo.i_wiwa is 'Participantes indígenas: WIWA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_yagua is 'Participantes indígenas: YAGUA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_yamalero is 'Participantes indígenas: YAMALERO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_yanacona is 'Participantes indígenas: YANACONA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_yari is 'Participantes indígenas: YARI';

comment on column esclarecimiento.excel_sujeto_colectivo.i_yaruro is 'Participantes indígenas: YARURO';

comment on column esclarecimiento.excel_sujeto_colectivo.i_yauna is 'Participantes indígenas: YAUNA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_yeral is 'Participantes indígenas: YERAL';

comment on column esclarecimiento.excel_sujeto_colectivo.i_yukpa is 'Participantes indígenas: YUKPA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_yukuna is 'Participantes indígenas: YUKUNA';

comment on column esclarecimiento.excel_sujeto_colectivo.i_yuri is 'Participantes indígenas: YURI';

comment on column esclarecimiento.excel_sujeto_colectivo.i_yuruti is 'Participantes indígenas: YURUTÍ';

comment on column esclarecimiento.excel_sujeto_colectivo.i_zenu is 'Participantes indígenas: ZENÚ';

comment on column esclarecimiento.excel_sujeto_colectivo.a_afrocolombiano is 'Participantes afro: Afrocolombiano';

comment on column esclarecimiento.excel_sujeto_colectivo.a_negro is 'Participantes afro: Negro';

comment on column esclarecimiento.excel_sujeto_colectivo.a_palenquero is 'Participantes afro: Palenquero';

comment on column esclarecimiento.excel_sujeto_colectivo.a_raizal is 'Participantes afro: Raizal';

comment on column esclarecimiento.excel_sujeto_colectivo.r_cucuta is 'Participantes rrom: Cúcuta';

comment on column esclarecimiento.excel_sujeto_colectivo.r_envigado is 'Participantes rrom: Envigado';

comment on column esclarecimiento.excel_sujeto_colectivo.r_giron is 'Participantes rrom: Girón';

comment on column esclarecimiento.excel_sujeto_colectivo.r_ibague is 'Participantes rrom: Ibagué';

comment on column esclarecimiento.excel_sujeto_colectivo.r_pasto is 'Participantes rrom: Pasto';

comment on column esclarecimiento.excel_sujeto_colectivo.r_prorom is 'Participantes rrom: ProRrom (Bogotá)';

comment on column esclarecimiento.excel_sujeto_colectivo.r_sabanalarga is 'Participantes rrom: Sabanalarga';

comment on column esclarecimiento.excel_sujeto_colectivo.r_sahagun is 'Participantes rrom: Sahagún';

comment on column esclarecimiento.excel_sujeto_colectivo.r_sampues is 'Participantes rrom: Sampués';

comment on column esclarecimiento.excel_sujeto_colectivo.r_san_pelayo is 'Participantes rrom: San Pelayo';

comment on column esclarecimiento.excel_sujeto_colectivo.r_union_romani is 'Participantes rrom: Unión Romaní (Bogotá)';

alter table esclarecimiento.excel_sujeto_colectivo owner to dba;

create unique index if not exists excel_sujeto_colectivo_codigo_entrevista_uindex
    on esclarecimiento.excel_sujeto_colectivo (codigo_entrevista);

create index if not exists excel_sujeto_colectivo_id_entrevista_etnica_index
    on esclarecimiento.excel_sujeto_colectivo (id_entrevista_etnica);

create index if not exists excel_sujeto_colectivo_id_entrevistador_index
    on esclarecimiento.excel_sujeto_colectivo (id_entrevistador);

grant select on esclarecimiento.excel_sujeto_colectivo to solo_lectura;

