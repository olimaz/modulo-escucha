drop table if exists esclarecimiento.excel_sujeto_colectivo;
create table esclarecimiento.excel_sujeto_colectivo
(
    id serial not null
        constraint excel_sujeto_colectivo_pkey
            primary key,
    codigo_entrevista text,
    medios_virtuales text,
    situacion_actual  text,
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
    --
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
    --Participantes
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

    -- Procesamiento
    transcrita integer default 0,
    transcrita_fecha text,
    transcrita_fecha_a text,
    transcrita_fecha_m text,
    etiquetada integer default 0,
    etiquetada_fecha text,
    etiquetada_fecha_a text,
    etiquetada_fecha_m text,
    -- Intereses
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
    -- mandato
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
    -- Adjuntos
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
    -- Carga al sistema
    fecha_carga text,
    mes_carga text,
    id_entrevistador integer,
    -- Priorizacion
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
    -- Consentimiento informado
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
    -- Procesamiento
    minutos_entrevista integer default '-99'::integer,
    minutos_transcripcion integer default '-99'::integer,
    minutos_etiquetado integer default '-99'::integer,
    minutos_diligenciado integer default '-99'::integer
);

alter table esclarecimiento.excel_sujeto_colectivo owner to dba;
GRANT SELECT ON esclarecimiento.excel_sujeto_colectivo TO solo_lectura;


create index excel_sujeto_colectivo_codigo_entrevista_index
    on esclarecimiento.excel_sujeto_colectivo (codigo_entrevista);

create index excel_sujeto_colectivo_id_entrevistador_index
    on esclarecimiento.excel_sujeto_colectivo (id_entrevistador);


comment on column esclarecimiento.excel_sujeto_colectivo.i_achagua is 'Participantes ind??genas: ACHAGUA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_ambalo is 'Participantes ind??genas: AMBAL??';
comment on column esclarecimiento.excel_sujeto_colectivo.i_amorua is 'Participantes ind??genas: AMOR??A ';
comment on column esclarecimiento.excel_sujeto_colectivo.i_andoke is 'Participantes ind??genas: ANDOKE';
comment on column esclarecimiento.excel_sujeto_colectivo.i_arhuaco is 'Participantes ind??genas: ARHUACO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_awa is 'Participantes ind??genas: AW??';
comment on column esclarecimiento.excel_sujeto_colectivo.i_barasan is 'Participantes ind??genas: BARASANA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_bara is 'Participantes ind??genas: BAR??';
comment on column esclarecimiento.excel_sujeto_colectivo.i_bari is 'Participantes ind??genas: BAR??';
comment on column esclarecimiento.excel_sujeto_colectivo.i_betoye is 'Participantes ind??genas: BETOYE';
comment on column esclarecimiento.excel_sujeto_colectivo.i_bora is 'Participantes ind??genas: BORA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_carapana is 'Participantes ind??genas: CARAPANA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_chiricoa is 'Participantes ind??genas: CHIRICOA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_cocama is 'Participantes ind??genas: COCAMA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_coreguaje is 'Participantes ind??genas: COREGUAJE';
comment on column esclarecimiento.excel_sujeto_colectivo.i_curripako is 'Participantes ind??genas: CURRIPAKO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_desano is 'Participantes ind??genas: DESANO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_embera_chami is 'Participantes ind??genas: EMBERA CHAM??';
comment on column esclarecimiento.excel_sujeto_colectivo.i_embrea_dobida is 'Participantes ind??genas: EMBERA D??BIDA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_embera_katio is 'Participantes ind??genas: EMBERA KAT??O';
comment on column esclarecimiento.excel_sujeto_colectivo.i_eperara is 'Participantes ind??genas: EPERARA-SIAPIDARA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_ett is 'Participantes ind??genas: ETT E???NEKA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_guanaca is 'Participantes ind??genas: GUANACA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_guane is 'Participantes ind??genas: GUANE';
comment on column esclarecimiento.excel_sujeto_colectivo.i_guna is 'Participantes ind??genas: GUNA DULE';
comment on column esclarecimiento.excel_sujeto_colectivo.i_hitnu is 'Participantes ind??genas: HITNU';
comment on column esclarecimiento.excel_sujeto_colectivo.i_hupde is 'Participantes ind??genas: HUPD??-HUPDAH-HUPDU';
comment on column esclarecimiento.excel_sujeto_colectivo.i_ijku is 'Participantes ind??genas: IJKU';
comment on column esclarecimiento.excel_sujeto_colectivo.i_inga is 'Participantes ind??genas: INGA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_jiw is 'Participantes ind??genas: JIW';
comment on column esclarecimiento.excel_sujeto_colectivo.i_jupda is 'Participantes ind??genas: JUDPA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_juhup is 'Participantes ind??genas: JUHUP-YUJU';
comment on column esclarecimiento.excel_sujeto_colectivo.i_kakua is 'Participantes ind??genas: KAKUA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_kamentsa is 'Participantes ind??genas: KAM??NT????';
comment on column esclarecimiento.excel_sujeto_colectivo.i_kankuamo is 'Participantes ind??genas: KANKUAMO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_karijona is 'Participantes ind??genas: KARIJONA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_kawiyari is 'Participantes ind??genas: KAWIYAR??';
comment on column esclarecimiento.excel_sujeto_colectivo.i_kofan is 'Participantes ind??genas: KOF??N';
comment on column esclarecimiento.excel_sujeto_colectivo.i_kogui is 'Participantes ind??genas: KOGUI';
comment on column esclarecimiento.excel_sujeto_colectivo.i_kokonuko is 'Participantes ind??genas: KOKONUKO  ';
comment on column esclarecimiento.excel_sujeto_colectivo.i_kubeo is 'Participantes ind??genas: KUBEO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_leguama is 'Participantes ind??genas: LETUAMA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_makaguaje is 'Participantes ind??genas: MAKAGUAJE';
comment on column esclarecimiento.excel_sujeto_colectivo.i_makuma is 'Participantes ind??genas: MAKUMA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_mapayerri is 'Participantes ind??genas: MAPAYERRI';
comment on column esclarecimiento.excel_sujeto_colectivo.i_masiguare is 'Participantes ind??genas: MASIGUARE';
comment on column esclarecimiento.excel_sujeto_colectivo.i_matapi is 'Participantes ind??genas: MATAP??';
comment on column esclarecimiento.excel_sujeto_colectivo.i_mirana is 'Participantes ind??genas: MIRA??A';
comment on column esclarecimiento.excel_sujeto_colectivo.i_misak is 'Participantes ind??genas: MISAK';
comment on column esclarecimiento.excel_sujeto_colectivo.i_mokana is 'Participantes ind??genas: MOKAN??';
comment on column esclarecimiento.excel_sujeto_colectivo.i_muina is 'Participantes ind??genas: MUINA MURUI';
comment on column esclarecimiento.excel_sujeto_colectivo.i_muisca is 'Participantes ind??genas: MUISCA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_nasa is 'Participantes ind??genas: NASA ';
comment on column esclarecimiento.excel_sujeto_colectivo.i_nonyha is 'Participantes ind??genas: NONUYA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_nukak is 'Participantes ind??genas: NUKAK';
comment on column esclarecimiento.excel_sujeto_colectivo.i_pastos is 'Participantes ind??genas: PASTOS';
comment on column esclarecimiento.excel_sujeto_colectivo.i_piapoco is 'Participantes ind??genas: PIAPOCO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_piarona is 'Participantes ind??genas: PIAROA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_pijao is 'Participantes ind??genas: PIJAO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_piratapuyo is 'Participantes ind??genas: PIRATAPUYO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_pisamira is 'Participantes ind??genas: PISAMIRA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_plindara is 'Participantes ind??genas: POLINDARA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_pubense is 'Participantes ind??genas: PUBENSE';
comment on column esclarecimiento.excel_sujeto_colectivo.i_puinave is 'Participantes ind??genas: PUINAVE';
comment on column esclarecimiento.excel_sujeto_colectivo.i_quichua is 'Participantes ind??genas: QUICHUA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_quillanciga is 'Participantes ind??genas: QUILLACINGA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_quizgo is 'Participantes ind??genas: QUIZG??';
comment on column esclarecimiento.excel_sujeto_colectivo.i_sikuani is 'Participantes ind??genas: SIKUANI / GUAHIBO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_siona is 'Participantes ind??genas: SIONA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_saliba is 'Participantes ind??genas: S??LIBA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_taiwano is 'Participantes ind??genas: TAIWANO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_tama is 'Participantes ind??genas: TAMA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_tanigua is 'Participantes ind??genas: TANIGUA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_tanimuka is 'Participantes ind??genas: TANIMUKA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_tatuyo is 'Participantes ind??genas: TATUYO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_tikuna is 'Participantes ind??genas: TIKUNA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_totoro is 'Participantes ind??genas: TOTOR??';
comment on column esclarecimiento.excel_sujeto_colectivo.i_tsiripu is 'Participantes ind??genas: TSIRIPU';
comment on column esclarecimiento.excel_sujeto_colectivo.i_tubu is 'Participantes ind??genas: TUBU / SIRIANO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_tucano is 'Participantes ind??genas: TUCANO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_tuyuka is 'Participantes ind??genas: TUYUKA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_uwa is 'Participantes ind??genas: U WA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_uitoto is 'Participantes ind??genas: UITOTO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_wamonae is 'Participantes ind??genas: WAMONAE / COIBA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_wanano is 'Participantes ind??genas: WANANO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_waunan is 'Participantes ind??genas: WAUNAN';
comment on column esclarecimiento.excel_sujeto_colectivo.i_wayuu is 'Participantes ind??genas: WAYUU';
comment on column esclarecimiento.excel_sujeto_colectivo.i_wipijiki is 'Participantes ind??genas: WIPIJIKI';
comment on column esclarecimiento.excel_sujeto_colectivo.i_wiwa is 'Participantes ind??genas: WIWA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_yagua is 'Participantes ind??genas: YAGUA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_yamalero is 'Participantes ind??genas: YAMALERO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_yanacona is 'Participantes ind??genas: YANACONA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_yari is 'Participantes ind??genas: YARI';
comment on column esclarecimiento.excel_sujeto_colectivo.i_yaruro is 'Participantes ind??genas: YARURO';
comment on column esclarecimiento.excel_sujeto_colectivo.i_yauna is 'Participantes ind??genas: YAUNA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_yeral is 'Participantes ind??genas: YERAL';
comment on column esclarecimiento.excel_sujeto_colectivo.i_yukpa is 'Participantes ind??genas: YUKPA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_yukuna is 'Participantes ind??genas: YUKUNA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_yuri is 'Participantes ind??genas: YURI';
comment on column esclarecimiento.excel_sujeto_colectivo.i_yuruti is 'Participantes ind??genas: YURUT??';
comment on column esclarecimiento.excel_sujeto_colectivo.i_zenu is 'Participantes ind??genas: ZEN??';
comment on column esclarecimiento.excel_sujeto_colectivo.a_afrocolombiano is 'Participantes afro: Afrocolombiano';
comment on column esclarecimiento.excel_sujeto_colectivo.a_negro is 'Participantes afro: Negro';
comment on column esclarecimiento.excel_sujeto_colectivo.a_palenquero is 'Participantes afro: Palenquero';
comment on column esclarecimiento.excel_sujeto_colectivo.a_raizal is 'Participantes afro: Raizal';
comment on column esclarecimiento.excel_sujeto_colectivo.r_cucuta is 'Participantes rrom: C??cuta';
comment on column esclarecimiento.excel_sujeto_colectivo.r_envigado is 'Participantes rrom: Envigado';
comment on column esclarecimiento.excel_sujeto_colectivo.r_giron is 'Participantes rrom: Gir??n';
comment on column esclarecimiento.excel_sujeto_colectivo.r_ibague is 'Participantes rrom: Ibagu??';
comment on column esclarecimiento.excel_sujeto_colectivo.r_pasto is 'Participantes rrom: Pasto';
comment on column esclarecimiento.excel_sujeto_colectivo.r_prorom is 'Participantes rrom: ProRrom (Bogot??)';
comment on column esclarecimiento.excel_sujeto_colectivo.r_sabanalarga is 'Participantes rrom: Sabanalarga';
comment on column esclarecimiento.excel_sujeto_colectivo.r_sahagun is 'Participantes rrom: Sahag??n';
comment on column esclarecimiento.excel_sujeto_colectivo.r_sampues is 'Participantes rrom: Sampu??s';
comment on column esclarecimiento.excel_sujeto_colectivo.r_san_pelayo is 'Participantes rrom: San Pelayo';
comment on column esclarecimiento.excel_sujeto_colectivo.r_union_romani is 'Participantes rrom: Uni??n Roman?? (Bogot??)';

comment on column esclarecimiento.excel_sujeto_colectivo.i_nutabe is 'Participantes ind??genas: NUTABE';
comment on column esclarecimiento.excel_sujeto_colectivo.i_okaina is 'Participantes ind??genas: OKAINA';
comment on column esclarecimiento.excel_sujeto_colectivo.i_tariano is 'Participantes ind??genas: TARIANO';




drop index esclarecimiento.excel_sujeto_colectivo_codigo_entrevista_index;

create unique index excel_sujeto_colectivo_codigo_entrevista_uindex
    on esclarecimiento.excel_sujeto_colectivo (codigo_entrevista);



