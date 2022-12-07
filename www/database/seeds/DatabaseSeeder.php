<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(CodigoPredefinidoTableSeeder::class);
        $this->call(camposFaltantes::class);
        $this->call(CatalogosNuevos1Seeder::class);
        $this->call(CatalogosNuevos2Seeder::class);
        $this->call(CatalogosNuevosItems1Seeder::class);
        $this->call(CatalogosNuevosItems2Seeder::class);
    }
}
