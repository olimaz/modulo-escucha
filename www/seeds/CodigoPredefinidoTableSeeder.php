<?php

use Illuminate\Database\Seeder;

class CodigoPredefinidoTableSeeder extends Seeder
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
            'nombres'=>'MARÍA JOSÉ' ,
            'apellidos' => 'TOBAR LASSO',
            'usuario' => 'maria.tobar',
            'numero' => 32
        );
        $codigo[]=array(
            'nombres'=>'ERIKA VANESA' ,
            'apellidos' => 'TOBÓN GONZALEZ',
            'usuario' => 'erika.tobon',
            'numero' => 33
        );
        $codigo[]=array(
            'nombres'=>'TERESA' ,
            'apellidos' => 'CASAS ROBLEDO',
            'usuario' => 'teresa.casas',
            'numero' => 34
        );
        $codigo[]=array(
            'nombres'=>'DAMARIS' ,
            'apellidos' => 'PALACIOS BECERRA',
            'usuario' => 'damaris.palacios',
            'numero' => 35
        );
        $codigo[]=array(
            'nombres'=>'BEATRIZ HELENA' ,
            'apellidos' => 'SALDARRIAGA GOMEZ',
            'usuario' => 'beatriz.saldarriaga',
            'numero' => 36
        );
        $codigo[]=array(
            'nombres'=>'CLARA INÉS' ,
            'apellidos' => 'MAZO LÓPEZ',
            'usuario' => 'clara.mazo',
            'numero' => 37
        );
        $codigo[]=array(
            'nombres'=>'TERESA' ,
            'apellidos' => 'FRANCO RÍOS',
            'usuario' => 'teresa.franco',
            'numero' => 38
        );
        $codigo[]=array(
            'nombres'=>'GLORIA ELENA' ,
            'apellidos' => 'MISAS MACIAS',
            'usuario' => 'gloria.misas',
            'numero' => 39
        );
        //
        $codigo[]=array(
            'nombres'=>'LUZ MERY' ,
            'apellidos' => 'LÓPEZ AYALA',
            'usuario' => 'luz.lopez',
            'numero' => 40
        );
        $codigo[]=array(
            'nombres'=>'MARTA CECILIA' ,
            'apellidos' => 'YEPES RESTREPO',
            'usuario' => 'marta.yepes',
            'numero' => 41
        );
        $codigo[]=array(
            'nombres'=>'JULIE  MARCELA' ,
            'apellidos' => 'GALIANO GARCÍA',
            'usuario' => 'julie.galiano',
            'numero' => 42
        );
        $codigo[]=array(
            'nombres'=>'MONICA LIZETH' ,
            'apellidos' => 'BURBANO',
            'usuario' => 'monica.burbano',
            'numero' => 43
        );
        $codigo[]=array(
            'nombres'=>'VALERIA' ,
            'apellidos' => 'MOSQUERA ACOSTA',
            'usuario' => 'valeria.mosquera',
            'numero' => 44
        );
        $codigo[]=array(
            'nombres'=>'GLORIA EMILSEN' ,
            'apellidos' => 'RODRIGUEZ MENESES',
            'usuario' => 'gloria.rodriguez',
            'numero' => 45
        );
        $codigo[]=array(
            'nombres'=>'ILIANA MARIA' ,
            'apellidos' => 'COLONIA LLANOS',
            'usuario' => 'iliana.colonia',
            'numero' => 46
        );
        $codigo[]=array(
            'nombres'=>'JOHANA VICTORIA' ,
            'apellidos' => 'BOHORQUEZ ROSERO ',
            'usuario' => 'johana.bohorquez',
            'numero' => 47
        );
        $codigo[]=array(
            'nombres'=>'MARIA MIRALBA' ,
            'apellidos' => 'IBARRA HERNANDEZ',
            'usuario' => 'maria.ibarra',
            'numero' => 48
        );
        $codigo[]=array(
            'nombres'=>'KELLY  JOHANA' ,
            'apellidos' => 'ECHEVERRY ALZATE',
            'usuario' => 'kelly.echeverry',
            'numero' => 49
        );

        /////
        DB::table('codigo_predefinido')->insert($codigo);
    }
}
