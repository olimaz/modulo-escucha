<?php

use Illuminate\Database\Seeder;

class directorio_catalogo_old extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //Ficha entrevista

    $registro['id_catalogo']=40;
      $registro['tabla']='fichas.entrevista_condiciones';
      $registro['campo']='id_condicion';
      $registro['descripcion']='Campo acompañamiento de la tabla de entrevista';
      $fila[]=$registro;

    // Ficha Persona


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

      $registro['id_catalogo']=41;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_tipo_documento';
      $registro['descripcion']='Tipo de documento de identidad en la tabla persona';
      $fila[]=$registro;

      $registro['id_catalogo']=42;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_otra_nacionalidad';
      $registro['descripcion']='Otra nacionalidad en la tabla persona';
      $fila[]=$registro;

      $registro['id_catalogo']=43;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_estado_civil';
      $registro['descripcion']='Estado Civil en la tabla persona';
      $fila[]=$registro;

      $registro['id_catalogo']=46;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_edu_formal';
      $registro['descripcion']='Educación formal en la tabla persona';
      $fila[]=$registro;

      $registro['id_catalogo']=47;
      $registro['tabla']='fichas.persona';
      $registro['campo']='autoridad_etno_territorial';
      $registro['descripcion']='Autoridad ento-territorial en la tabla persona';
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
      $registro['descripcion']='Tipo de organización en la tabla persona_organización';
      $fila[]=$registro;

      $registro['id_catalogo']=52;
      $registro['tabla']='fichas.per_ent_rel_victima';
      $registro['campo']='id_rel_victima';
      $registro['descripcion']='Parentesco con la persona entrevistada en la tabla per_ent_rel_victima';
      $fila[]=$registro;

      $registro['id_catalogo']=36;
      $registro['tabla']='fichas.persona_responsable_responsabilidades';
      $registro['campo']='presunta_responsabilidad';
      $registro['descripcion']='Cuál es la presunta responsabilidad en tabla ';
      $fila[]=$registro;

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
      $registro['descripcion']='Impactos Relacionales - Impactos a los familaires de la víctimqa';
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
      $registro['descripcion']='Impactos colectivos - Impactos políticoss y la democracia';
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

      $registro['id_catalogo']=149;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Afrontamiento y resistencia - Afrontamiento colectivo - El proceso/la iniciativa colectiva fortaleció';
      $fila[]=$registro;

      $registro['id_catalogo']=150;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Puso en conocimiento a alguna entidad o autoridad? Estatal';
      $fila[]=$registro;

      $registro['id_catalogo']=151;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Puso en conocimiento a alguna entidad o autoridad? Comunitario';
      $fila[]=$registro;

      $registro['id_catalogo']=152;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Puso en conocimiento a alguna entidad o autoridad? Internacional';
      $fila[]=$registro;

      $registro['id_catalogo']=153;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
      $registro['descripcion']='Acceso a la justicia, reparación y no repetición - ¿Por qué accedió a esta/s autoridad/es o entidad/es? Estatal';
      $fila[]=$registro;

      $registro['id_catalogo']=154;
      $registro['tabla']='fichas.entrevista_impacto';
      $registro['campo']='id_impacto';
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

        DB::table('public.directorio_catalogo')->insert($fila);
    }
}
