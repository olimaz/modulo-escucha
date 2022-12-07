<?php

use Illuminate\Database\Seeder;

class directorio_catalogo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //Ficha entrevista

      $registro['id_catalogo']=84;
      $registro['tabla']='esclarecimiento.e_ind_fvt_fr';
      $registro['campo']='id_fr';
      $registro['descripcion']='Entrevista - Responsable / Participante';
      $fila[]=$registro;

      $registro['id_catalogo']=4;
      $registro['tabla']='esclarecimiento.e_ind_fvt_fr';
      $registro['campo']='id_fr';
      $registro['descripcion']='Entrevista - Responsable / Participante';
      $fila[]=$registro;

      $registro['id_catalogo']=5;
      $registro['tabla']='esclarecimiento.e_ind_fvt_tv';
      $registro['campo']='id_tv';
      $registro['descripcion']='Entrevista - Violencia registrada';
      $fila[]=$registro;

      

      $registro['id_catalogo']=15;
      $registro['tabla']='esclarecimiento.e_ind_fvt_interes_mandato';
      $registro['campo']='id_mandato';
      $registro['descripcion']='Entrevista - Puede ser de utilidad para el/las área/s de:';
      $fila[]=$registro;

      $registro['id_catalogo']=18;
      $registro['tabla']='esclarecimiento.e_ind_fvt';
      $registro['campo']='id_sector';
      $registro['descripcion']='Entrevista - Sector con el que se puede identificar a la organización de víctimas en el relato:';
      $fila[]=$registro;

      $registro['id_catalogo']=19;
      $registro['tabla']='esclarecimiento.e_ind_fvt_interes';
      $registro['campo']='id_intereses';
      $registro['descripcion']='Entrevista - Es de utilidad para el/los núcleo/s de:';
      $fila[]=$registro;

      $registro['id_catalogo']=22;
      $registro['tabla']='fichas.entrevista';
      $registro['campo']='id_idioma';
      $registro['descripcion']='Entrevista - Idioma/lengua de la entrevista:';
      $fila[]=$registro;

      $registro['id_catalogo']=23;
      $registro['tabla']='fichas.entrevista';
      $registro['campo']='id_nativo';
      $registro['descripcion']='Entrevista - Idiomas nativos';
      $fila[]=$registro;

      

      $registro['id_catalogo']=33;
      $registro['tabla']='esclarecimiento.e_ind_fvt';
      $registro['campo']='id_remitido';
      $registro['descripcion']='Entrevista - Esta es una entrevista remitida por:';
      $fila[]=$registro;


      $registro['id_catalogo']=40;
      $registro['tabla']='fichas.entrevista_condiciones';
      $registro['campo']='id_condicion';
      $registro['descripcion']='Entrevista - Campo acompañamiento de la tabla de entrevista';
      $fila[]=$registro;

      $registro['id_catalogo']=85;
      $registro['tabla']='esclarecimiento.e_ind_fvt_interes_area';
      $registro['campo']='id_interes';
      $registro['descripcion']='Entrevista - Puede ser de utilidad para el/las área/s de:';
      $fila[]=$registro;


      

    // Ficha Persona
      $registro['id_catalogo']=24;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_orientacion';
      $registro['descripcion']='Persona - Sexo';
      $fila[]=$registro;

      $registro['id_catalogo']=25;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_sexo';
      $registro['descripcion']='Persona - Orientación sexual';
      $fila[]=$registro;

      $registro['id_catalogo']=26;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_identidad';
      $registro['descripcion']='Identidad de género en la tabla persona';
      $fila[]=$registro;

      $registro['id_catalogo']=27;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_etnia';
      $registro['descripcion']='Pertenencia étnico racial en la tabla persona';
      $fila[]=$registro;

      $registro['id_catalogo']=28;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_etnia_indigena';
      $registro['descripcion']='Persona - ¿A cuál étnia indígena pertenece?';
      $fila[]=$registro;


      $registro['id_catalogo']=41;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_tipo_documento';
      $registro['descripcion']='Tipo de documento de identidad en la tabla persona';
      $fila[]=$registro;

      $registro['id_catalogo']=42;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_otra_nacionalidad';
      $registro['descripcion']='Persona - Otra nacionalidad en la tabla persona';
      $fila[]=$registro;

      $registro['id_catalogo']=43;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_estado_civil';
      $registro['descripcion']='Persona - Estado Civil en la tabla persona';
      $fila[]=$registro;

      $registro['id_catalogo']=44;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_discapacidad';
      $registro['descripcion']='Persona - Condición de discapacidad';
      $fila[]=$registro;

      $registro['id_catalogo']=45;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_zona';
      $registro['descripcion']='Persona - Zona';
      $fila[]=$registro;

      $registro['id_catalogo']=46;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_edu_formal';
      $registro['descripcion']='Persona - Educación formal en la tabla persona';
      $fila[]=$registro;

      $registro['id_catalogo']=47;
      $registro['tabla']='fichas.persona_aut_etnico_ter';
      $registro['campo']='id_aut_etnico_ter';
      $registro['descripcion']='Persona - Autoridad etno-territorial en la tabla persona';
      $fila[]=$registro;

      $registro['id_catalogo']=48;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_fueza_publica_estado';
      $registro['descripcion']='Persona - Estado: fuerza pública';
      $fila[]=$registro;

      $registro['id_catalogo']=49;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_fuerza_publica';
      $registro['descripcion']='Es miembro de la fuerza pública en la tabla persona';
      $fila[]=$registro;

      $registro['id_catalogo']=50;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_actor_armado';
      $registro['descripcion']='Fue miembro de un actor armado ilegal en la tabla persona';
      $fila[]=$registro;

      $registro['id_catalogo']=51;
      $registro['tabla']='fichas.persona_organizacion';
      $registro['campo']='id_tipo_organizacion';
      $registro['descripcion']='Persona - Tipo de organización';
      $fila[]=$registro;

      /*Víctima */

      $registro['id_catalogo']=52;
      $registro['tabla']='fichas.per_ent_rel_victima';
      $registro['campo']='id_rel_victima';
      $registro['descripcion']="Persona - Parentesco con la persona entrevistada";
      $fila[]=$registro;

      /*Responsable*/

      $registro['id_catalogo']=4;
      $registro['tabla']='esclarecimiento.e_ind_fvt_fr';
      $registro['campo']='id_fr';
      $registro['descripcion']='Responsable - Actor armado del que hacía parte';
      $fila[]=$registro;

      $registro['id_catalogo']=29;
      $registro['tabla']='fichas.persona_responsable';
      $registro['campo']='id_edad_aproximada';
      $registro['descripcion']='Responsable - Edad aproximada al momento de los hechos';
      $fila[]=$registro;

      

      $registro['id_catalogo']=34;
      $registro['tabla']='fichas.persona_responsable';
      $registro['campo']='id_rango_cargo';
      $registro['descripcion']='Responsable - id_rango_cargo';
      $fila[]=$registro;



      $registro['id_catalogo']=35;
      $registro['tabla']='fichas.persona_responsable';
      $registro['campo']='id_grupo_paramilitar';
      $registro['descripcion']='Responsable - Rango-Paramilitares';
      $fila[]=$registro;

      $registro['id_catalogo']=36;
      $registro['tabla']='fichas.persona_responsable_responsabilidades';
      $registro['campo']='presunta_responsabilidad';
      $registro['descripcion']='Cuál es la presunta responsabilidad en tabla ';
      $fila[]=$registro;

      $registro['id_catalogo']=37;
      $registro['tabla']='fichas.persona_responsable';
      $registro['campo']='id_guerrilla';
      $registro['descripcion']='Responsable - Rango. Guerrillas';
      $fila[]=$registro;

      $registro['id_catalogo']=38;
      $registro['tabla']='fichas.persona_responsable';
      $registro['campo']='id_fuerza_publica';
      $registro['descripcion']='Responsable - Rango fuerza pública';
      $fila[]=$registro;


      /* Tipos de violencia*/
      $registro['id_catalogo']=120;
      $registro['tabla']='fichas.hecho_violencia_mecanismo';
      $registro['campo']='id_mecanismo';
      $registro['descripcion']='Tipos de violencia - Tipos de tortura física';
      $fila[]=$registro;

      $registro['id_catalogo']=121;
      $registro['tabla']='fichas.hecho_violencia_mecanismo';
      $registro['campo']='id_mecanismo';
      $registro['descripcion']='Tipos de violencia - Tipos de tortura psicológica';
      $fila[]=$registro;


      $registro['id_catalogo']=122;
      $registro['tabla']='fichas.hecho_violencia_mecanismo';
      $registro['campo']='id_mecanismo';
      $registro['descripcion']='Tipos de violencia - Tipos de amenaza a derecho de vida';
      $fila[]=$registro;

      $registro['id_catalogo']=123;
      $registro['tabla']='fichas.hecho_violencia_mecanismo';
      $registro['campo']='id_mecanismo';
      $registro['descripcion']='Tipos de violencia - Reclutamiento de niños';
      $fila[]=$registro;

      $registro['id_catalogo']=124;
      $registro['tabla']='fichas.hecho_violencia_mecanismo';
      $registro['campo']='id_mecanismo';
      $registro['descripcion']='Tipos de violencia - Desaparición forzada';
      $fila[]=$registro;



      /* Hechos*/

      $registro['id_catalogo']=127;
      $registro['tabla']='fichas.hecho_contexto';
      $registro['campo']='id_contexto';
      $registro['descripcion']='Motivos específicos por los cuales cree que ocurrieron los hechos';
      $fila[]=$registro;

      $registro['id_catalogo']=128;
      $registro['tabla']='fichas.hecho_contexto';
      $registro['campo']='id_contexto';
      $registro['descripcion']='Contexto de control territorial y/o de la población en hecho_contexto';
      $fila[]=$registro;

      $registro['id_catalogo']=129;
      $registro['tabla']='fichas.hecho_contexto';
      $registro['campo']='id_contexto';
      $registro['descripcion']='Si los hechos ocurrieron en lugares públicos, indique si dicho espacio es significativo para en hecho_contexto';
      $fila[]=$registro;

      $registro['id_catalogo']=130;
      $registro['tabla']='fichas.hecho_contexto';
      $registro['campo']='id_contexto';
      $registro['descripcion']='Factores externos que influenciaron en los hechos: en hecho_contexto';
      $fila[]=$registro;

      $registro['id_catalogo']=131;
      $registro['tabla']='fichas.hecho_contexto';
      $registro['campo']='id_contexto';
      $registro['descripcion']=' La persona entrevistada considera que estos hechos violentos beneficiaron a: en hecho_contexto';
      $fila[]=$registro;

      $registro['id_catalogo']=132;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos Individuales - Qué cambió en su vida? ';
      $fila[]=$registro;

      $registro['id_catalogo']=133;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos Individuales - Impactos emocionales que permanecen el tiempo';
      $fila[]=$registro;

      $registro['id_catalogo']=134;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos Individuales - Impactos en la salud';
      $fila[]=$registro;

      $registro['id_catalogo']=135;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos Relacionales - Impactos a los familiares de la víctimqa';
      $fila[]=$registro;

      $registro['id_catalogo']=136;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos relacionales - Impactos en la red social personal';
      $fila[]=$registro;

      $registro['id_catalogo']=137;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos relacionales - Indique si hubo formas de revictimización como consecuencia de los hechos';
      $fila[]=$registro;

      $registro['id_catalogo']=138;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos colectivos - Impactos colectivos derivados de los hechos';
      $fila[]=$registro;

      $registro['id_catalogo']=139;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos colectivos - Impactos a sujetos colectivos étnicos-raciales';
      $fila[]=$registro;

      $registro['id_catalogo']=140;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos colectivos - Impactos ambientales y al territorio';
      $fila[]=$registro;

      $registro['id_catalogo']=141;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos colectivos - Impactos a los derechos sociales y ecónomicos';
      $fila[]=$registro;

      $registro['id_catalogo']=142;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos colectivos - Impactos culturales';
      $fila[]=$registro;

      $registro['id_catalogo']=143;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos colectivos - Impactos políticos y la democracia';
      $fila[]=$registro;

      $registro['id_catalogo']=144;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Afrontamiento y resistencia - Afrontamiento individual - Cuando ocurrieron los hechos de violencia, ¿qué hizo para afrontar/ manejar la situación?';
      $fila[]=$registro;

      $registro['id_catalogo']=145;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Afrontamiento y resistencia - Afrontamiento familiar';
      $fila[]=$registro;

      $registro['id_catalogo']=146;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Afrontamiento y resistencia - Afrontamiento colectivo -  Para manejar/afontar la situación, participó o participa en';
      $fila[]=$registro;

      $registro['id_catalogo']=147;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Afrontamiento y resistencia - Afrontamiento colectivo - Durante su participación en el proceso colectivo tuvo/tiene dificultades';
      $fila[]=$registro;

      $registro['id_catalogo']=148;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Afrontamiento y resistencia - Afrontamiento colectivo - El proceso/la iniciativa colectiva fortaleció';
      $fila[]=$registro;


      $registro['id_catalogo']=150;
      $registro['tabla']='fichas.justicia_institucion';
      $registro['campo']='id_institucion';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Puso en conocimiento a alguna entidad o autoridad? Estatal';
      $fila[]=$registro;

      $registro['id_catalogo']=151;
      $registro['tabla']='fichas.justicia_institucion';
      $registro['campo']='id_institucion';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Puso en conocimiento a alguna entidad o autoridad? Comunitario';
      $fila[]=$registro;

      $registro['id_catalogo']=152;
      $registro['tabla']='fichas.justicia_institucion';
      $registro['campo']='id_institucion';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Puso en conocimiento a alguna entidad o autoridad? Internacional';
      $fila[]=$registro;

      $registro['id_catalogo']=153;
      $registro['tabla']='fichas.justicia_porque';
      $registro['campo']='id_porque';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Por qué accedió a esta/s autoridad/es o entidad/es? Estatal';
      $fila[]=$registro;

      $registro['id_catalogo']=154;
      $registro['tabla']='fichas.justicia_objetivo';
      $registro['campo']='id_objetivo';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Cuál era su objetivo principal al acceder a esta vía? Estatal';
      $fila[]=$registro;

      $registro['id_catalogo']=155;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Ha recibido apoyo para su caso ?';
      $fila[]=$registro;

      $registro['id_catalogo']=160;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Qué avances ha tenido su caso? - Responsable sancionado';
      $fila[]=$registro;

      $registro['id_catalogo']=161;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Qué avances ha tenido su caso? - Verdad esclarecida';
      $fila[]=$registro;

      $registro['id_catalogo']=162;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Qué avances ha tenido su caso? - Si no hubo avances, ¿Por qué?';
      $fila[]=$registro;

      $registro['id_catalogo']=163;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Qué avances ha tenido su caso? - Reparación';
      $fila[]=$registro;

      $registro['id_catalogo']=164;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='¿Qué medidas de reparación individual ha recibido? - Indemnización individual';
      $fila[]=$registro;

      $registro['id_catalogo']=165;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='¿Qué medidas de reparación individual ha recibido? - Medidas de reestablecimiento de derechos';
      $fila[]=$registro;

      $registro['id_catalogo']=166;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='¿Qué medidas de reparación individual ha recibido? - Medidas de rehabilitación';
      $fila[]=$registro;

      $registro['id_catalogo']=167;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='¿Qué medidas de reparación individual ha recibido? - Medidas de satisfacción';
      $fila[]=$registro;

      $registro['id_catalogo']=168;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='¿Qué medidas de reparación individual ha recibido? - Otras medidas';
      $fila[]=$registro;

      $registro['id_catalogo']=169;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Estado de avance de la reparación colectiva.';
      $fila[]=$registro;

      $registro['id_catalogo']=170;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='¿Las medidas de reparación han sido adecuadas?';
      $fila[]=$registro;

      $registro['id_catalogo']=171;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Qué se necesita para que estos hechos no se vuelvan a repetir (Garantías de no repetición)';
      $fila[]=$registro;

      $registro['id_catalogo']=172;
      $registro['tabla']='fichas.hecho_violencia';
      $registro['campo']='id_individual_colectiva';
      $registro['descripcion']='Utilizada en diferentes lugares de la ficha larga. ej: Tipo de violencia - Violencia Sexual';
      $fila[]=$registro;

      $registro['id_catalogo']=173;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Tipos de violencia - ';
      $fila[]=$registro;

      /*Exilio*/

      $registro['id_catalogo']=30;
      $registro['tabla']='fichas.persona_responsable';
      $registro['campo']='id_rnago_cargo';
      $registro['descripcion']='Exilio - categoria de exilio';
      $fila[]=$registro;

      $registro['id_catalogo']=149;
      $registro['tabla']='fichas.exilio_movimiento';
      $registro['campo']='id_modalidad';
      $registro['descripcion']='Exilio - Modalidad de la salida del país';
      $fila[]=$registro;

      $registro['id_catalogo']=201;
      $registro['tabla']='fichas.exilio_categoria';
      $registro['campo']='id_categoria';
      $registro['descripcion']='Exilio - Se reconoce en una o varias de las siguientes categorías:';
      $fila[]=$registro;

      $registro['id_catalogo']=202;
      $registro['tabla']='fichas.exilio_movimiento_motivo';
      $registro['campo']='id_motivo';
      $registro['descripcion']='Exilio - Motivos de la salida del país:';
      $fila[]=$registro;

      $registro['id_catalogo']=203;
      $registro['tabla']='fichas.exilio_movimiento';
      $registro['campo']='';
      $registro['descripcion']='Exilio - ¿Ha solicitado estatus de protección internacional o del país de acogida?:';
      $fila[]=$registro;

      $registro['id_catalogo']=204;
      $registro['tabla']='fichas.exilio_movimiento';
      $registro['campo']='id_solicitado_proteccion';
      $registro['descripcion']='Exilio - Estado de la solicitud de protección:';
      $fila[]=$registro;

      $registro['id_catalogo']=205;
      $registro['tabla']='fichas.exilio_movimiento';
      $registro['campo']='id_aprobada_proteccion';
      $registro['descripcion']='Exilio - Si aprobada, por: (solicitud de protección)';
      $fila[]=$registro;

      $registro['id_catalogo']=206;
      $registro['tabla']='fichas.exilio_movimiento';
      $registro['campo']='id_denegada_proteccion';
      $registro['descripcion']='Exilio - Si denegada (protección internacional), ¿en qué condición se encuentra la persona?';
      $fila[]=$registro;

      $registro['id_catalogo']=207;
      $registro['tabla']='fichas.exilio_movimiento_motivo';
      $registro['campo']='id_motivo';
      $registro['descripcion']='Exilio (Reasentamiento) - Motivos de la salida del país del anterior asentamiento:';
      $fila[]=$registro;      

      /*Impacto exilio*/

      $registro['id_catalogo']=208;
      $registro['tabla']='fichas.exilio_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos Exilio - Impactos en la primera salida / primera llegada';
      $fila[]=$registro;

      $registro['id_catalogo']=209;
      $registro['tabla']='fichas.exilio_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos Exilio - Afrontamiento en la primera llegada:';
      $fila[]=$registro;


      $registro['id_catalogo']=210;
      $registro['tabla']='fichas.exilio_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos Exilio - Impactos de largo plazo del exilio';
      $fila[]=$registro;

      $registro['id_catalogo']=211;
      $registro['tabla']='fichas.exilio_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Impactos Exilio - Afrontamiento en en el largo plazo';
      $fila[]=$registro;

      $registro['id_catalogo']=212;
      $registro['tabla']='fichas.exilio_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Retorno- Si ha tenido procesos de retorno, ¿Por qué retornó?';
      $fila[]=$registro;

      $registro['id_catalogo']=213;
      $registro['tabla']='fichas.exilio_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Retorno- Si no ha tenido procesos de retorno, ¿Por qué no ha retornado?';
      $fila[]=$registro;

      $registro['id_catalogo']=214;
      $registro['tabla']='fichas.exilio_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Retorno- Impactos del retorno';
      $fila[]=$registro;

      $registro['id_catalogo']=215;
      $registro['tabla']='fichas.exilio_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Retorno - Afrontamientos del retorno';
      $fila[]=$registro;

      $registro['id_catalogo']=216;
      $registro['tabla']='fichas.exilio_movimiento_motivo';
      $registro['campo']='id_motivo';
      $registro['descripcion']='Retorno - Una vez retornado, ¿Tuvo ayuda de alguna institución colombiana?';
      $fila[]=$registro;

      $registro['id_catalogo']=217;
      $registro['tabla']='fichas.exilio_movimiento';
      $registro['campo']='id_residencia_proteccion';
      $registro['descripcion']='Exilio -  ¿Ha obtenido residencia en el país de acogida?';
      $fila[]=$registro;

      $registro['id_catalogo']=218;
      $registro['tabla']='fichas.exilio_movimiento_proteccion';
      $registro['campo']='id_proteccion';
      $registro['descripcion']='Exilio - Acompañamiento';
      $fila[]=$registro;



        DB::table('public.directorio_catalogo')->insert($fila);
    }
}
