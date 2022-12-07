-- Generacion de SQL para modificar catalogos

create table directorio_catalogo
(
    id_directorio_catalogo serial not null
        constraint directorio_catalogo_pkey
            primary key,
    id_catalogo integer not null,
    tabla varchar(200) not null,
    campo varchar(200) not null,
    descripcion varchar(200) not null,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table directorio_catalogo owner to dba;

-- Traza de cambios aplicados

create table traza_catalogo
(
    id_traza_catalogo serial not null
        constraint traza_catalogo_pkey
            primary key,
    id_directorio_catalogo integer not null
        constraint public_traza_catalogo_id_directorio_catalogo_foreign
            references directorio_catalogo
            on update restrict on delete restrict,
    id_entrevistador integer not null,
    valor_anterior integer not null,
    valor_nuevo integer not null,
    created_at timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table traza_catalogo owner to dba;

create index public_traza_catalogo_id_directorio_catalogo_index
    on traza_catalogo (id_directorio_catalogo);


-- Poblar la tabla
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (40, 'fichas.entrevista_condiciones', 'id_condicion', 'Campo acompañamiento de la tabla de entrevista');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (26, 'fichas.persona', 'id_identidad', 'Identidad de género en la tabla persona');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (27, 'fichas.persona', 'id_etnia', 'Pertenencia étnico racial en la tabla persona');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (41, 'fichas.persona', 'id_tipo_documento', 'Tipo de documento de identidad en la tabla persona');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (42, 'fichas.persona', 'id_otra_nacionalidad', 'Otra nacionalidad en la tabla persona');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (43, 'fichas.persona', 'id_estado_civil', 'Estado Civil en la tabla persona');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (46, 'fichas.persona', 'id_edu_formal', 'Educación formal en la tabla persona');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (47, 'fichas.persona', 'autoridad_etno_territorial', 'Autoridad ento-territorial en la tabla persona');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (49, 'fichas.persona', 'id_fuerza_publica', 'Es miembro de la fuerza pública en la tabla persona');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (50, 'fichas.persona', 'id_actor_armado', 'Fue miembro de un actor armado ilegal en la tabla persona');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (51, 'fichas.persona_organizacion', 'id_tipo_organizacion', 'Tipo de organización en la tabla persona_organización');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (52, 'fichas.per_ent_rel_victima', 'id_rel_victima', 'Parentesco con la persona entrevistada en la tabla per_ent_rel_victima');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (36, 'fichas.persona_responsable_responsabilidades', 'presunta_responsabilidad', 'Cuál es la presunta responsabilidad en tabla ');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (127, 'fichas.hecho_contexto', 'id_contexto', 'Motivos específicos por los cuales cree que ocurrieron los hechos');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (128, 'fichas.hecho_contexto', 'id_contexto', 'Contexto de control territorial y/o de la población en hecho_contexto');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (129, 'fichas.hecho_contexto', 'id_contexto', 'Si los hechos ocurrieron en lugares públicos, indique si dicho espacio es significativo para en hecho_contexto');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (130, 'fichas.hecho_contexto', 'id_contexto', 'Factores externos que influenciaron en los hechos: en hecho_contexto');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (131, 'fichas.hecho_contexto', 'id_contexto', ' La persona entrevistada considera que estos hechos violentos beneficiaron a: en hecho_contexto');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (132, 'fichas.entrevista_impacto', 'id_impacto', 'Impactos Individuales - Qué cambió en su vida? ');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (133, 'fichas.entrevista_impacto', 'id_impacto', 'Impactos Individuales - Impactos emocionales que permanecen el tiempo');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (134, 'fichas.entrevista_impacto', 'id_impacto', 'Impactos Individuales - Impactos en la salud');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (135, 'fichas.entrevista_impacto', 'id_impacto', 'Impactos Relacionales - Impactos a los familaires de la víctimqa');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (136, 'fichas.entrevista_impacto', 'id_impacto', 'Impactos relacionales - Impactos en la red social personal');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (137, 'fichas.entrevista_impacto', 'id_impacto', 'Impactos relacionales - Indique si hubo formas de revictimización como consecuencia de los hechos');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (138, 'fichas.entrevista_impacto', 'id_impacto', 'Impactos colectivos - Impactos colectivos derivados de los hechos');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (139, 'fichas.entrevista_impacto', 'id_impacto', 'Impactos colectivos - Impactos a sujetos colectivos étnicos-raciales');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (140, 'fichas.entrevista_impacto', 'id_impacto', 'Impactos colectivos - Impactos ambientales y al territorio');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (141, 'fichas.entrevista_impacto', 'id_impacto', 'Impactos colectivos - Impactos a los derechos sociales y ecónomicos');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (142, 'fichas.entrevista_impacto', 'id_impacto', 'Impactos colectivos - Impactos culturales');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (143, 'fichas.entrevista_impacto', 'id_impacto', 'Impactos colectivos - Impactos políticoss y la democracia');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (144, 'fichas.entrevista_impacto', 'id_impacto', 'Afrontamiento y resistencia - Afrontamiento individual - Cuando ocurrieron los hechos de violencia, ¿qué hizo para afrontar/ manejar la situación?');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (145, 'fichas.entrevista_impacto', 'id_impacto', 'Afrontamiento y resistencia - Afrontamiento familiar');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (146, 'fichas.entrevista_impacto', 'id_impacto', 'Afrontamiento y resistencia - Afrontamiento colectivo -  Para manejar/afontar la situación, participó o participa en');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (147, 'fichas.entrevista_impacto', 'id_impacto', 'Afrontamiento y resistencia - Afrontamiento colectivo - Durante su participación en el proceso colectivo tuvo/tiene dificultades');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (148, 'fichas.entrevista_impacto', 'id_impacto', 'Afrontamiento y resistencia - Afrontamiento colectivo - El proceso/la iniciativa colectiva fortaleció');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (149, 'fichas.entrevista_impacto', 'id_impacto', 'Afrontamiento y resistencia - Afrontamiento colectivo - El proceso/la iniciativa colectiva fortaleció');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (150, 'fichas.entrevista_impacto', 'id_impacto', 'Acceso a la justicia, reparación y no repetición - ¿Puso en conocimiento a alguna entidad o autoridad? Estatal');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (151, 'fichas.entrevista_impacto', 'id_impacto', 'Acceso a la justicia, reparación y no repetición - ¿Puso en conocimiento a alguna entidad o autoridad? Comunitario');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (152, 'fichas.entrevista_impacto', 'id_impacto', 'Acceso a la justicia, reparación y no repetición - ¿Puso en conocimiento a alguna entidad o autoridad? Internacional');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (153, 'fichas.entrevista_impacto', 'id_impacto', 'Acceso a la justicia, reparación y no repetición - ¿Por qué accedió a esta/s autoridad/es o entidad/es? Estatal');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (154, 'fichas.entrevista_impacto', 'id_impacto', 'Acceso a la justicia, reparación y no repetición - ¿Cuál era su objetivo principal al acceder a esta vía? Estatal');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (155, 'fichas.entrevista_impacto', 'id_impacto', 'Acceso a la justicia, reparación y no repetición - ¿Ha recibido apoyo para su caso ?');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (160, 'fichas.entrevista_impacto', 'id_impacto', 'Acceso a la justicia, reparación y no repetición - ¿Qué avances ha tenido su caso? - Responsable sancionado');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (161, 'fichas.entrevista_impacto', 'id_impacto', 'Acceso a la justicia, reparación y no repetición - ¿Qué avances ha tenido su caso? - Verdad esclarecida');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (162, 'fichas.entrevista_impacto', 'id_impacto', 'Acceso a la justicia, reparación y no repetición - ¿Qué avances ha tenido su caso? - Si no hubo avances, ¿Por qué?');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (163, 'fichas.entrevista_impacto', 'id_impacto', 'Acceso a la justicia, reparación y no repetición - ¿Qué avances ha tenido su caso? - Reparación');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (164, 'fichas.entrevista_impacto', 'id_impacto', '¿Qué medidas de reparación individual ha recibido? - Indemnización individual');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (165, 'fichas.entrevista_impacto', 'id_impacto', '¿Qué medidas de reparación individual ha recibido? - Medidas de reestablecimiento de derechos');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (166, 'fichas.entrevista_impacto', 'id_impacto', '¿Qué medidas de reparación individual ha recibido? - Medidas de rehabilitación');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (167, 'fichas.entrevista_impacto', 'id_impacto', '¿Qué medidas de reparación individual ha recibido? - Medidas de satisfacción');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (168, 'fichas.entrevista_impacto', 'id_impacto', '¿Qué medidas de reparación individual ha recibido? - Otras medidas');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (169, 'fichas.entrevista_impacto', 'id_impacto', 'Estado de avance de la reparación colectiva.');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (170, 'fichas.entrevista_impacto', 'id_impacto', '¿Las medidas de reparación han sido adecuadas?');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (171, 'fichas.entrevista_impacto', 'id_impacto', 'Qué se necesita para que estos hechos no se vuelvan a repetir (Garantías de no repetición)');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (208, 'fichas.exilio_impacto', 'id_impacto', 'Impactos Exilio - Impactos en la primera salida / primera llegada');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (209, 'fichas.exilio_impacto', 'id_impacto', 'Impactos Exilio - Afrontamiento en la primera llegada:');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (210, 'fichas.exilio_impacto', 'id_impacto', 'Impactos Exilio - Impactos de largo plazo del exilio');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (211, 'fichas.exilio_impacto', 'id_impacto', 'Impactos Exilio - Afrontamiento en en el largo plazo');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (214, 'fichas.exilio_impacto', 'id_impacto', 'Retorno- Impactos del retorno');
INSERT INTO public.directorio_catalogo (id_catalogo, tabla, campo, descripcion) VALUES (215, 'fichas.exilio_impacto', 'id_impacto', 'Retorno - Afrontamientos del retorno');



