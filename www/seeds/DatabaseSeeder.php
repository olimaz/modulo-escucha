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
        $this->call(directorio_catalogo::class);
    }
}
