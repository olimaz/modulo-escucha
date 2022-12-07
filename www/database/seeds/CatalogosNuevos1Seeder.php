<?php

use Illuminate\Database\Seeder;

class CatalogosNuevos1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


         $codigo[]=array(
            'id_cat'=>'254' ,
            'nombre' => 'Presunta responsabilidad de los hechos',
            'descripcion' => 'Utilizado en la ficha de dinámicas AA',
            'editable' => 1
        );



        $codigo[]=array(
            'id_cat'=>'255' ,
            'nombre' => 'Por qué desobedeció las órdenes de los hechos',
            'descripcion' => 'Utilizado en la ficha de dinámicas AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'256' ,
            'nombre' => 'Terceros civiles',
            'descripcion' => 'Utilizado en la ficha de dinámicas AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'257' ,
            'nombre' => 'Otros agentes del estado',
            'descripcion' => 'Utilizado en la ficha de dinámicas AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'258' ,
            'nombre' => 'INTERNACIONAL',
            'descripcion' => 'Utilizado en la ficha de IMPACTOS/ AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'259' ,
            'nombre' => 'Experiencias que causaron impacto',
            'descripcion' => 'Utilizado en la ficha de IMPACTOS AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'260' ,
            'nombre' => 'Impactos Individuales',
            'descripcion' => 'Utilizado en la ficha de IMPACTOS AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'261' ,
            'nombre' => 'Impactos emocionales',
            'descripcion' => 'Utilizado en la ficha de IMPACTOS AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'262' ,
            'nombre' => 'Impactos familiares',
            'descripcion' => 'Utilizado en la ficha de IMPACTOS AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'263' ,
            'nombre' => 'Impactos en la red social personal',
            'descripcion' => 'Utilizado en la ficha de IMPACTOS AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'264' ,
            'nombre' => 'Impactos en el grupo de combatientes',
            'descripcion' => 'Utilizado en la ficha de IMPACTOS AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'265' ,
            'nombre' => 'Afrontamiento individual',
            'descripcion' => 'Utilizado en la ficha de IMPACTOS AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'266' ,
            'nombre' => 'Afrontamiento colectivo',
            'descripcion' => 'Utilizado en la ficha de IMPACTOS AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'267' ,
            'nombre' => 'Hubo respuesta positiva del grupo / la fuerza',
            'descripcion' => 'Utilizado en la ficha de IMPACTOS AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'277' ,
            'nombre' => 'Terceros Civiles',
            'descripcion' => 'Utilizado en la ficha de Responsabilidades AA',
            'editable' => 1
        );

         $codigo[]=array(
            'id_cat'=>'278' ,
            'nombre' => 'Emociones predominantes en la familia',
            'descripcion' => 'Utilizado en la ficha de Impactos AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'279' ,
            'nombre' => 'Desmovilización - Cómo se desmovilizó',
            'descripcion' => 'Utilizado en la ficha de IDEsmovilización AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'280' ,
            'nombre' => 'En el marco de algún proceso de desmovilización',
            'descripcion' => 'Utilizado en la ficha de Desmovilización AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'281' ,
            'nombre' => 'Procesos de reincorporación - Con qué institución',
            'descripcion' => 'Utilizado en la ficha de Desmovilización AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'282' ,
            'nombre' => 'Procesos de reincorporación - Fue efectivo',
            'descripcion' => 'Utilizado en la ficha de Desmovilización AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'283' ,
            'nombre' => 'Procesos de reincorporación - Consecuencias negativas',
            'descripcion' => 'Utilizado en la ficha de Desmovilización AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'284' ,
            'nombre' => 'Contribución a la reparación de las víctimas',
            'descripcion' => 'Utilizado en la ficha de Desmovilización AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'285' ,
            'nombre' => 'Por qué decidió hablar ante la comisión',
            'descripcion' => 'Utilizado en la ficha de Desmovilización AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'286' ,
            'nombre' => 'Cómo más quiere aportar a la comisión de la verdad',
            'descripcion' => 'Utilizado en la ficha de Desmovilización AA',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'287' ,
            'nombre' => 'Privado/ público',
            'descripcion' => 'Utilizado en la ficha de Desmovilización AA',
            'editable' => 1
        );
DB::table('catalogos.cat_cat')->insert($codigo);
    }


}
