<?php

use Illuminate\Database\Seeder;

class camposFaltantes extends Seeder
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


      $registro['id_catalogo']=28;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_etnia_indigena';
      $registro['descripcion']='Persona - ¿A cuál étnia indígena pertenece?';
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


      $registro['id_catalogo']=48;
      $registro['tabla']='fichas.persona';
      $registro['campo']='id_fueza_publica_estado';
      $registro['descripcion']='Persona - Estado: fuerza pública';
      $fila[]=$registro;

      /*Responsable*/

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
