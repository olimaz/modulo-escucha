<?php

namespace App\Interfaces;

use App\Models\persona;

interface EntrevistaRol {
 
    public function guardarInformacionParticular(persona $persona, $parametros=[]);
}