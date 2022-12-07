<?php

use Illuminate\Database\Seeder;

class CatalogosNuevos2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $codigo[]=array(
            'id_cat'=>'236' ,
            'nombre' => 'Grupo / fuerza armada',
            'descripcion' => 'Utilizado en la ficha de entrefilas de Actor armado',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'237' ,
            'nombre' => 'Grupos guerrilleros',
            'descripcion' => 'Utilizado en la ficha de entrefilas de Actor armado',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'238' ,
            'nombre' => 'Fuerza Pública',
            'descripcion' => 'Utilizado en la ficha de entrefilas de Actor armado',
            'editable' => 1
        );
        $codigo[]=array(
            'id_cat'=>'239' ,
            'nombre' => 'Cómo ingresó en el grupo armado / fuerza armada',
            'descripcion' => 'Utilizado en la ficha de entrefilas de Actor armado',
            'editable' => 1
        );
        $codigo[]=array(
            'id_cat'=>'240' ,
            'nombre' => 'Por qué ingreso en el grupo / fuerza armada',
            'descripcion' => 'Utilizado en la ficha de entrefilas de Actor armado',
            'editable' => 1
        );
        $codigo[]=array(
            'id_cat'=>'241' ,
            'nombre' => 'Aspectos de la experiencia entrefilas',
            'descripcion' => 'Utilizado en la ficha de entrefilas de Actor armado',
            'editable' => 1
        );


        $codigo[]=array(
            'id_cat'=>'242' ,
            'nombre' => 'Principales violaciones de derechos humanos e infracciones al DIH cometidas en este periodo',
            'descripcion' => 'Utilizado en la ficha de dinámicas de Actor armado',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'243' ,
            'nombre' => 'Principales sectores/ colectivos/ grupos/ pueblos víctimas de acciones del grupo',
            'descripcion' => 'Utilizado en la ficha de dinámicas de Actor armado',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'270' ,
            'nombre' => 'Tercero civil',
            'descripcion' => 'Utilizado en la ficha de dinámicas de Actor armado',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'274' ,
            'nombre' => 'Otro agente del estado',
            'descripcion' => 'Utilizado en la ficha de dinámicas de Actor armado',
            'editable' => 1
        );


        $codigo[]=array(
            'id_cat'=>'244' ,
            'nombre' => 'Vínculos con el narcotráfico',
            'descripcion' => 'Utilizado en la ficha de dinámicas de Actor armado',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'245' ,
            'nombre' => 'Dinámicas otros Aspectos',
            'descripcion' => 'Utilizado en la ficha de dinámicas de Actor armado',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'246' ,
            'nombre' => 'Individual/colectivo',
            'descripcion' => 'Utilizado en la ficha de dinámicas de Actor armado',
            'editable' => 1
        );



        $codigo[]=array(
            'id_cat'=>'271' ,
            'nombre' => 'Desaparición forzosa',
            'descripcion' => 'Utilizado en la ficha de hechos de Actor armado',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'247' ,
            'nombre' => 'Desaparición forzosa',
            'descripcion' => 'Utilizado en la ficha de hechos de Actor armado',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'248' ,
            'nombre' => 'Torura Física',
            'descripcion' => 'Utilizado en la ficha de hechos de Actor armado',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'273' ,
            'nombre' => 'Torura Física',
            'descripcion' => 'Utilizado en la ficha de hechos de Actor armado',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'249' ,
            'nombre' => 'Violencia Sexual',
            'descripcion' => 'Utilizado en la ficha hechos de Actor armado',
            'editable' => 1
        );
        $codigo[]=array(
            'id_cat'=>'250' ,
            'nombre' => 'Reclutamiento de Niños(as)',
            'descripcion' => 'Utilizado en la ficha hechos de Actor armado',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'251' ,
            'nombre' => 'Individual/ Familiar / colectivo',
            'descripcion' => 'Utilizado en la ficha hechos de Actor armado',
            'editable' => 1
        );

        $codigo[]=array(
            'id_cat'=>'275' ,
            'nombre' => 'Ataque a bien protegido',
            'descripcion' => 'Utilizado en la ficha hechos de Actor armado',
            'editable' => 1
        );


        $codigo[]=array(
            'id_cat'=>'252' ,
            'nombre' => 'Otros aspectos',
            'descripcion' => 'Utilizado en la ficha hechos de Actor armado',
            'editable' => 1
        );



        $codigo[]=array(
            'id_cat'=>'253' ,
            'nombre' => 'Motivos específicos por los que ocurrieron los hechos',
            'descripcion' => 'Utilizado en la ficha hechos de Actor armado',
            'editable' => 1
        );



        /////
         DB::table('catalogos.cat_cat')->insert($codigo);


    }
}
