<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id_uso_tesauro
 * @property string $codigo
 * @property int $t_00_00_00
 * @property int $t_00_01_00
 * @property int $t_00_03_00
 * @property int $t_00_05_00
 * @property int $t_00_06_00
 * @property int $t_00_07_00
 * @property int $t_00_09_00
 * @property int $t_01_00_00
 * @property int $t_01_01_00
 * @property int $t_01_02_00
 * @property int $t_01_03_00
 * @property int $t_01_04_00
 * @property int $t_01_06_00
 * @property int $t_01_07_00
 * @property int $t_01_08_00
 * @property int $t_01_09_00
 * @property int $t_01_09_01
 * @property int $t_01_09_02
 * @property int $t_01_09_03
 * @property int $t_01_09_04
 * @property int $t_01_09_05
 * @property int $t_01_09_06
 * @property int $t_02_00_00
 * @property int $t_02_01_00
 * @property int $t_02_02_00
 * @property int $t_02_03_00
 * @property int $t_02_04_00
 * @property int $t_02_05_00
 * @property int $t_02_06_00
 * @property int $t_02_08_00
 * @property int $t_03_00_00
 * @property int $t_03_01_00
 * @property int $t_03_02_00
 * @property int $t_03_02_01
 * @property int $t_03_02_02
 * @property int $t_03_02_03
 * @property int $t_03_02_04
 * @property int $t_03_02_05
 * @property int $t_03_02_06
 * @property int $t_03_02_07
 * @property int $t_03_03_00
 * @property int $t_03_04_00
 * @property int $t_03_05_00
 * @property int $t_03_06_00
 * @property int $t_03_06_01
 * @property int $t_03_06_02
 * @property int $t_03_06_03
 * @property int $t_03_06_04
 * @property int $t_03_07_00
 * @property int $t_03_08_00
 * @property int $t_03_08_01
 * @property int $t_03_08_02
 * @property int $t_03_08_03
 * @property int $t_03_08_04
 * @property int $t_03_08_05
 * @property int $t_03_08_06
 * @property int $t_03_08_07
 * @property int $t_03_09_00
 * @property int $t_03_09_01
 * @property int $t_03_09_02
 * @property int $t_03_09_04
 * @property int $t_03_09_05
 * @property int $t_03_10_00
 * @property int $t_03_11_00
 * @property int $t_03_12_00
 * @property int $t_03_12_01
 * @property int $t_03_12_02
 * @property int $t_03_12_03
 * @property int $t_03_12_04
 * @property int $t_03_13_00
 * @property int $t_03_13_01
 * @property int $t_03_13_02
 * @property int $t_03_13_03
 * @property int $t_03_13_04
 * @property int $t_03_13_06
 * @property int $t_03_13_07
 * @property int $t_03_14_00
 * @property int $t_03_15_00
 * @property int $t_04_00_00
 * @property int $t_04_01_00
 * @property int $t_04_02_00
 * @property int $t_04_03_00
 * @property int $t_04_04_00
 * @property int $t_04_05_00
 * @property int $t_04_07_00
 * @property int $t_04_07_01
 * @property int $t_04_07_02
 * @property int $t_04_07_03
 * @property int $t_04_08_00
 * @property int $t_05_00_00
 * @property int $t_05_01_00
 * @property int $t_05_02_00
 * @property int $t_05_02_01
 * @property int $t_05_02_02
 * @property int $t_05_03_00
 * @property int $t_05_04_00
 * @property int $t_05_05_00
 * @property int $t_05_07_00
 * @property int $t_05_08_00
 * @property int $t_05_09_00
 * @property int $t_06_00_00
 * @property int $t_06_01_00
 * @property int $t_06_01_01
 * @property int $t_06_02_00
 * @property int $t_06_03_00
 * @property int $t_06_04_00
 * @property int $t_06_05_00
 * @property int $t_06_06_00
 * @property int $t_07_00_00
 * @property int $t_07_01_00
 * @property int $t_07_05_00
 * @property int $t_07_06_00
 * @property int $t_07_07_00
 * @property int $t_07_09_00
 * @property int $t_07_10_00
 * @property int $t_07_11_00
 * @property int $t_07_11_04
 * @property int $t_07_12_00
 * @property int $t_07_13_00
 * @property int $t_07_13_01
 * @property int $t_07_14_00
 * @property int $t_07_15_00
 * @property int $t_07_17_00
 * @property int $t_07_17_01
 * @property int $t_07_17_02
 * @property int $t_07_17_03
 * @property int $t_07_17_04
 * @property int $t_07_18_00
 * @property int $t_08_00_00
 * @property int $t_08_02_00
 * @property int $t_08_03_00
 * @property int $t_08_04_00
 * @property int $t_08_04_01
 * @property int $t_08_04_02
 * @property int $t_08_04_03
 * @property int $t_08_04_04
 * @property int $t_08_04_05
 * @property int $t_08_04_06
 * @property int $t_08_05_00
 * @property int $t_08_06_00
 * @property int $t_08_07_00
 * @property int $t_08_11_00
 * @property int $t_08_11_01
 * @property int $t_08_11_02
 * @property int $t_08_11_03
 * @property int $t_08_11_04
 * @property int $t_08_11_05
 * @property int $t_08_11_06
 * @property int $t_09_00_00
 * @property int $t_09_01_00
 * @property int $t_09_02_00
 * @property int $t_09_03_00
 * @property int $t_09_04_00
 * @property int $t_09_05_00
 * @property int $t_09_06_00
 * @property int $t_09_07_00
 * @property int $t_10_00_00
 * @property int $t_10_01_00
 * @property int $t_10_02_00
 * @property int $t_10_03_00
 * @property int $t_10_04_00
 * @property int $t_10_05_00
 * @property int $t_10_06_00
 * @property int $t_10_07_00
 * @property int $t_11_00_00
 * @property int $t_11_01_00
 * @property int $t_11_01_01
 * @property int $t_11_01_02
 * @property int $t_11_01_03
 * @property int $t_11_02_00
 * @property int $t_11_03_00
 * @property int $t_11_03_01
 * @property int $t_11_03_04
 * @property int $t_11_04_00
 * @property int $t_11_07_00
 * @property int $t_12_00_00
 * @property int $t_12_01_00
 * @property int $t_12_01_01
 * @property int $t_12_01_02
 * @property int $t_12_01_03
 * @property int $t_12_01_04
 * @property int $t_12_01_05
 * @property int $t_12_01_06
 * @property int $t_12_01_07
 * @property int $t_12_01_08
 * @property int $t_12_01_09
 * @property int $t_12_01_10
 * @property int $t_12_01_11
 * @property int $t_12_01_12
 * @property int $t_12_01_13
 * @property int $t_12_01_14
 * @property int $t_12_01_15
 * @property int $t_12_01_16
 * @property int $t_12_01_17
 * @property int $t_12_01_18
 * @property int $t_12_01_19
 * @property int $t_12_01_20
 * @property int $t_12_01_21
 * @property int $t_12_02_00
 * @property int $t_12_02_01
 * @property int $t_12_02_02
 * @property int $t_12_02_03
 * @property int $t_12_02_04
 * @property int $t_12_02_05
 * @property int $t_12_02_06
 * @property int $t_12_02_07
 * @property int $t_12_02_11
 * @property int $t_12_03_00
 * @property int $t_12_03_01
 * @property int $t_12_03_02
 * @property int $t_12_03_03
 * @property int $t_12_03_04
 * @property int $t_12_03_05
 * @property int $t_12_03_06
 * @property int $t_12_03_07
 * @property int $t_12_03_08
 * @property int $t_12_03_10
 * @property int $t_12_03_12
 * @property int $t_12_03_13
 * @property int $t_12_03_14
 * @property int $t_12_04_00
 * @property int $t_12_04_01
 * @property int $t_12_04_02
 * @property int $t_12_04_03
 * @property int $t_12_04_04
 * @property int $t_12_05_00
 * @property int $t_12_06_00
 * @property int $t_12_06_02
 * @property int $t_12_06_03
 * @property int $t_13_00_00
 * @property int $t_13_01_00
 * @property int $t_13_01_01
 * @property int $t_13_01_02
 * @property int $t_13_01_03
 * @property int $t_13_01_04
 * @property int $t_13_01_05
 * @property int $t_13_01_06
 * @property int $t_13_01_07
 * @property int $t_13_01_08
 * @property int $t_13_02_00
 * @property int $t_13_02_01
 * @property int $t_13_02_02
 * @property int $t_13_02_03
 * @property int $t_13_02_04
 * @property int $t_13_02_05
 * @property int $t_13_02_06
 * @property int $t_13_03_00
 * @property int $t_13_03_01
 * @property int $t_13_03_02
 * @property int $t_13_03_03
 * @property int $t_13_03_04
 * @property int $t_13_03_05
 * @property int $t_13_03_06
 * @property int $t_13_04_00
 * @property int $t_13_04_01
 * @property int $t_13_04_02
 * @property int $t_13_04_03
 * @property int $t_13_05_00
 * @property int $t_13_05_01
 * @property int $t_13_05_02
 * @property int $t_13_05_03
 * @property int $t_13_05_04
 * @property int $t_13_06_00
 * @property int $t_13_06_01
 * @property int $t_13_06_02
 * @property int $t_13_08_00
 * @property int $t_13_08_01
 * @property int $t_13_08_02
 * @property int $t_13_08_03
 * @property int $t_13_08_04
 * @property int $t_13_08_05
 * @property int $t_13_08_06
 * @property int $t_13_08_07
 * @property int $t_13_08_08
 * @property int $t_13_08_09
 * @property int $t_13_08_10
 * @property int $t_13_08_11
 * @property int $t_13_08_12
 * @property int $t_13_08_13
 * @property int $t_13_08_14
 * @property int $t_13_08_15
 * @property int $t_13_08_16
 * @property int $t_13_09_00
 * @property int $t_13_09_01
 * @property int $t_13_09_02
 * @property int $t_13_09_03
 * @property int $t_13_09_04
 * @property int $t_13_09_05
 * @property int $t_13_10_00
 * @property int $t_13_10_01
 * @property int $t_13_10_03
 * @property int $t_13_11_00
 * @property int $t_13_11_01
 * @property int $t_13_11_02
 * @property int $t_13_11_03
 * @property int $t_13_12_00
 * @property int $t_13_12_01
 * @property int $t_13_12_02
 * @property int $t_13_12_03
 * @property int $t_13_13_00
 * @property int $t_13_14_00
 * @property int $t_13_15_00
 * @property int $t_13_16_00
 * @property int $t_13_17_00
 * @property int $t_13_18_00
 * @property int $t_13_18_01
 * @property int $t_13_18_02
 * @property int $t_13_18_03
 * @property int $t_13_19_00
 * @property int $t_13_20_00
 * @property int $t_13_21_00
 * @property int $t_14_00_00
 * @property int $t_14_01_00
 * @property int $t_14_02_00
 * @property int $t_14_03_00
 * @property int $t_14_04_00
 * @property int $t_14_05_00
 * @property int $t_14_06_00
 * @property int $t_14_07_00
 * @property int $t_14_08_00
 * @property int $t_14_09_00
 * @property int $t_14_10_00
 * @property int $t_14_11_00
 * @property int $t_14_12_00
 * @property int $t_15_00_00
 * @property int $t_15_01_00
 * @property int $t_15_02_00
 * @property int $t_15_03_00
 * @property int $t_15_04_00
 * @property int $t_15_05_00
 * @property int $t_15_06_00
 * @property int $t_15_07_00
 * @property int $t_15_08_00
 * @property int $t_15_09_00
 * @property int $t_15_10_00
 * @property int $t_15_11_00
 * @property int $t_15_12_00
 * @property int $t_16_00_00
 * @property int $t_16_02_00
 * @property int $t_16_03_00
 * @property int $t_16_04_00
 * @property int $t_16_05_00
 * @property int $t_17_00_00
 * @property int $t_17_01_00
 * @property int $t_17_02_00
 * @property int $t_17_03_00
 * @property int $t_17_04_00
 * @property int $t_17_05_00
 * @property int $t_17_06_00
 * @property int $t_17_07_00
 * @property int $t_17_08_00
 * @property int $t_17_09_00
 * @property int $t_17_10_00
 * @property int $t_17_11_00
 * @property int $t_17_12_00
 * @property int $t_18_00_00
 * @property int $t_18_01_00
 * @property int $t_18_02_00
 * @property int $t_18_02_01
 * @property int $t_18_02_02
 * @property int $t_18_03_00
 * @property int $t_18_04_00
 * @property int $t_18_05_00
 * @property int $t_18_06_00
 * @property int $t_18_07_00
 * @property int $t_18_08_00
 * @property int $t_19_00_00
 * @property int $t_19_01_00
 * @property int $t_19_02_00
 * @property int $t_19_03_00
 * @property int $t_19_04_00
 * @property int $t_19_05_00
 * @property int $t_19_06_00
 * @property int $t_19_07_00
 * @property int $t_19_08_00
 * @property int $t_19_09_00
 * @property int $t_19_10_00
 * @property int $t_19_11_00
 * @property int $t_20_00_00
 * @property int $t_20_02_00
 * @property int $t_20_03_00
 * @property int $t_20_05_00
 * @property int $t_20_06_00
 * @property int $t_21_00_00
 * @property int $t_21_02_00
 * @property int $t_21_03_00
 * @property int $t_21_04_00
 * @property int $t_21_05_00
 * @property int $t_21_06_00
 * @property int $t_21_07_00
 * @property int $t_21_08_00
 * @property int $t_21_09_00
 * @property int $conteo_etiquetas
 * @property string $fh_insert
 */
class uso_tesauro extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.uso_tesauro';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_uso_tesauro';

    /**
     * @var array
     */
    protected $fillable = ['codigo', 't_00_00_00', 't_00_01_00', 't_00_03_00', 't_00_05_00', 't_00_06_00', 't_00_07_00', 't_00_09_00', 't_01_00_00', 't_01_01_00', 't_01_02_00', 't_01_03_00', 't_01_04_00', 't_01_06_00', 't_01_07_00', 't_01_08_00', 't_01_09_00', 't_01_09_01', 't_01_09_02', 't_01_09_03', 't_01_09_04', 't_01_09_05', 't_01_09_06', 't_02_00_00', 't_02_01_00', 't_02_02_00', 't_02_03_00', 't_02_04_00', 't_02_05_00', 't_02_06_00', 't_02_08_00', 't_03_00_00', 't_03_01_00', 't_03_02_00', 't_03_02_01', 't_03_02_02', 't_03_02_03', 't_03_02_04', 't_03_02_05', 't_03_02_06', 't_03_02_07', 't_03_03_00', 't_03_04_00', 't_03_05_00', 't_03_06_00', 't_03_06_01', 't_03_06_02', 't_03_06_03', 't_03_06_04', 't_03_07_00', 't_03_08_00', 't_03_08_01', 't_03_08_02', 't_03_08_03', 't_03_08_04', 't_03_08_05', 't_03_08_06', 't_03_08_07', 't_03_09_00', 't_03_09_01', 't_03_09_02', 't_03_09_04', 't_03_09_05', 't_03_10_00', 't_03_11_00', 't_03_12_00', 't_03_12_01', 't_03_12_02', 't_03_12_03', 't_03_12_04', 't_03_13_00', 't_03_13_01', 't_03_13_02', 't_03_13_03', 't_03_13_04', 't_03_13_06', 't_03_13_07', 't_03_14_00', 't_03_15_00', 't_04_00_00', 't_04_01_00', 't_04_02_00', 't_04_03_00', 't_04_04_00', 't_04_05_00', 't_04_07_00', 't_04_07_01', 't_04_07_02', 't_04_07_03', 't_04_08_00', 't_05_00_00', 't_05_01_00', 't_05_02_00', 't_05_02_01', 't_05_02_02', 't_05_03_00', 't_05_04_00', 't_05_05_00', 't_05_07_00', 't_05_08_00', 't_05_09_00', 't_06_00_00', 't_06_01_00', 't_06_01_01', 't_06_02_00', 't_06_03_00', 't_06_04_00', 't_06_05_00', 't_06_06_00', 't_07_00_00', 't_07_01_00', 't_07_05_00', 't_07_06_00', 't_07_07_00', 't_07_09_00', 't_07_10_00', 't_07_11_00', 't_07_11_04', 't_07_12_00', 't_07_13_00', 't_07_13_01', 't_07_14_00', 't_07_15_00', 't_07_17_00', 't_07_17_01', 't_07_17_02', 't_07_17_03', 't_07_17_04', 't_07_18_00', 't_08_00_00', 't_08_02_00', 't_08_03_00', 't_08_04_00', 't_08_04_01', 't_08_04_02', 't_08_04_03', 't_08_04_04', 't_08_04_05', 't_08_04_06', 't_08_05_00', 't_08_06_00', 't_08_07_00', 't_08_11_00', 't_08_11_01', 't_08_11_02', 't_08_11_03', 't_08_11_04', 't_08_11_05', 't_08_11_06', 't_09_00_00', 't_09_01_00', 't_09_02_00', 't_09_03_00', 't_09_04_00', 't_09_05_00', 't_09_06_00', 't_09_07_00', 't_10_00_00', 't_10_01_00', 't_10_02_00', 't_10_03_00', 't_10_04_00', 't_10_05_00', 't_10_06_00', 't_10_07_00', 't_11_00_00', 't_11_01_00', 't_11_01_01', 't_11_01_02', 't_11_01_03', 't_11_02_00', 't_11_03_00', 't_11_03_01', 't_11_03_04', 't_11_04_00', 't_11_07_00', 't_12_00_00', 't_12_01_00', 't_12_01_01', 't_12_01_02', 't_12_01_03', 't_12_01_04', 't_12_01_05', 't_12_01_06', 't_12_01_07', 't_12_01_08', 't_12_01_09', 't_12_01_10', 't_12_01_11', 't_12_01_12', 't_12_01_13', 't_12_01_14', 't_12_01_15', 't_12_01_16', 't_12_01_17', 't_12_01_18', 't_12_01_19', 't_12_01_20', 't_12_01_21', 't_12_02_00', 't_12_02_01', 't_12_02_02', 't_12_02_03', 't_12_02_04', 't_12_02_05', 't_12_02_06', 't_12_02_07', 't_12_02_11', 't_12_03_00', 't_12_03_01', 't_12_03_02', 't_12_03_03', 't_12_03_04', 't_12_03_05', 't_12_03_06', 't_12_03_07', 't_12_03_08', 't_12_03_10', 't_12_03_12', 't_12_03_13', 't_12_03_14', 't_12_04_00', 't_12_04_01', 't_12_04_02', 't_12_04_03', 't_12_04_04', 't_12_05_00', 't_12_06_00', 't_12_06_02', 't_12_06_03', 't_13_00_00', 't_13_01_00', 't_13_01_01', 't_13_01_02', 't_13_01_03', 't_13_01_04', 't_13_01_05', 't_13_01_06', 't_13_01_07', 't_13_01_08', 't_13_02_00', 't_13_02_01', 't_13_02_02', 't_13_02_03', 't_13_02_04', 't_13_02_05', 't_13_02_06', 't_13_03_00', 't_13_03_01', 't_13_03_02', 't_13_03_03', 't_13_03_04', 't_13_03_05', 't_13_03_06', 't_13_04_00', 't_13_04_01', 't_13_04_02', 't_13_04_03', 't_13_05_00', 't_13_05_01', 't_13_05_02', 't_13_05_03', 't_13_05_04', 't_13_06_00', 't_13_06_01', 't_13_06_02', 't_13_08_00', 't_13_08_01', 't_13_08_02', 't_13_08_03', 't_13_08_04', 't_13_08_05', 't_13_08_06', 't_13_08_07', 't_13_08_08', 't_13_08_09', 't_13_08_10', 't_13_08_11', 't_13_08_12', 't_13_08_13', 't_13_08_14', 't_13_08_15', 't_13_08_16', 't_13_09_00', 't_13_09_01', 't_13_09_02', 't_13_09_03', 't_13_09_04', 't_13_09_05', 't_13_10_00', 't_13_10_01', 't_13_10_03', 't_13_11_00', 't_13_11_01', 't_13_11_02', 't_13_11_03', 't_13_12_00', 't_13_12_01', 't_13_12_02', 't_13_12_03', 't_13_13_00', 't_13_14_00', 't_13_15_00', 't_13_16_00', 't_13_17_00', 't_13_18_00', 't_13_18_01', 't_13_18_02', 't_13_18_03', 't_13_19_00', 't_13_20_00', 't_13_21_00', 't_14_00_00', 't_14_01_00', 't_14_02_00', 't_14_03_00', 't_14_04_00', 't_14_05_00', 't_14_06_00', 't_14_07_00', 't_14_08_00', 't_14_09_00', 't_14_10_00', 't_14_11_00', 't_14_12_00', 't_15_00_00', 't_15_01_00', 't_15_02_00', 't_15_03_00', 't_15_04_00', 't_15_05_00', 't_15_06_00', 't_15_07_00', 't_15_08_00', 't_15_09_00', 't_15_10_00', 't_15_11_00', 't_15_12_00', 't_16_00_00', 't_16_02_00', 't_16_03_00', 't_16_04_00', 't_16_05_00', 't_17_00_00', 't_17_01_00', 't_17_02_00', 't_17_03_00', 't_17_04_00', 't_17_05_00', 't_17_06_00', 't_17_07_00', 't_17_08_00', 't_17_09_00', 't_17_10_00', 't_17_11_00', 't_17_12_00', 't_18_00_00', 't_18_01_00', 't_18_02_00', 't_18_02_01', 't_18_02_02', 't_18_03_00', 't_18_04_00', 't_18_05_00', 't_18_06_00', 't_18_07_00', 't_18_08_00', 't_19_00_00', 't_19_01_00', 't_19_02_00', 't_19_03_00', 't_19_04_00', 't_19_05_00', 't_19_06_00', 't_19_07_00', 't_19_08_00', 't_19_09_00', 't_19_10_00', 't_19_11_00', 't_20_00_00', 't_20_02_00', 't_20_03_00', 't_20_05_00', 't_20_06_00', 't_21_00_00', 't_21_02_00', 't_21_03_00', 't_21_04_00', 't_21_05_00', 't_21_06_00', 't_21_07_00', 't_21_08_00', 't_21_09_00', 'conteo_etiquetas', 'fh_insert'];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * The storage format of the model's date columns.
     * 
     * @var string
     */
    protected $dateFormat = 'U';


    public static function encabezados() {
        $arreglo = array();
        $arreglo['id_uso_tesauro'] = '#';
        $arreglo['codigo'] = 'Entrevista';
        $arreglo['t_00_00_00'] = 'Entidades';
        $arreglo['t_00_01_00'] = 'Entidades - Fecha';
        $arreglo['t_00_03_00'] = 'Entidades - Divipola/Sitios/regiones';
        $arreglo['t_00_05_00'] = 'Entidades - Personas';
        $arreglo['t_00_06_00'] = 'Entidades - Organizaciones';
        $arreglo['t_00_07_00'] = 'Entidades - Armas';
        $arreglo['t_00_09_00'] = 'Entidades - Roles y poblaciones';
        $arreglo['t_01_00_00'] = 'N1 Democracia';
        $arreglo['t_01_01_00'] = 'N1 Democracia - Violencia Pol??tica y represi??n a la protesta social';
        $arreglo['t_01_02_00'] = 'N1 Democracia - Conflictos Patrones Trabajadores';
        $arreglo['t_01_03_00'] = 'N1 Democracia - Conflicto Servicios P??blicos';
        $arreglo['t_01_04_00'] = 'N1 Democracia - Conflictos Defensa DD HH DIH';
        $arreglo['t_01_06_00'] = 'N1 Democracia - Discriminaci??n Genero LGBTI';
        $arreglo['t_01_07_00'] = 'N1 Democracia - Conflictos Representaci??n Pol??tica';
        $arreglo['t_01_08_00'] = 'N1 Democracia - Conflictos Resoluci??n Guerra';
        $arreglo['t_01_09_00'] = 'N1 Democracia - Relac Pol??tica y Actores Armados';
        $arreglo['t_01_09_01'] = 'N1 Democracia - Relac Pol??tica y Actores Armados - Influencia Electoral';
        $arreglo['t_01_09_02'] = 'N1 Democracia - Relac Pol??tica y Actores Armados - Participaci??n Directa';
        $arreglo['t_01_09_03'] = 'N1 Democracia - Relac Pol??tica y Actores Armados - Alianza Afinidad';
        $arreglo['t_01_09_04'] = 'N1 Democracia - Relac Pol??tica y Actores Armados - Influen Organizacional Socio Politica';
        $arreglo['t_01_09_05'] = 'N1 Democracia - Relac Pol??tica y Actores Armados - Descrip ??lites Regionales';
        $arreglo['t_01_09_06'] = 'N1 Democracia - Relac Pol??tica y Actores Armados - Reparto Cargos Servi P??blicos';
        $arreglo['t_02_00_00'] = 'N2 Estado';
        $arreglo['t_02_01_00'] = 'N2 Estado - Judicializaci??n';
        $arreglo['t_02_02_00'] = 'N2 Estado - Omisi??n Estado Frente Grupos Armados';
        $arreglo['t_02_03_00'] = 'N2 Estado - Actuaci??n Conjunta Estado Actores Armados';
        $arreglo['t_02_04_00'] = 'N2 Estado - Militarizaci??n Territorio';
        $arreglo['t_02_05_00'] = 'N2 Estado - Impunidad';
        $arreglo['t_02_06_00'] = 'N2 Estado - Violen Funcionarios Estado';
        $arreglo['t_02_08_00'] = 'N2 Estado - Abandono estatal';
        $arreglo['t_03_00_00'] = 'N3 Actores';
        $arreglo['t_03_01_00'] = 'N3 Actores - Origen Actores Armados';
        $arreglo['t_03_02_00'] = 'N3 Actores - Din??micas Espaciales Actores Armados';
        $arreglo['t_03_02_01'] = 'N3 Actores - Din??micas Espaciales Actores Armados  - Incursi??n';
        $arreglo['t_03_02_02'] = 'N3 Actores - Din??micas Espaciales Actores Armados  - Expansi??n';
        $arreglo['t_03_02_03'] = 'N3 Actores - Din??micas Espaciales Actores Armados  - Disputa';
        $arreglo['t_03_02_04'] = 'N3 Actores - Din??micas Espaciales Actores Armados  - Asentamiento';
        $arreglo['t_03_02_05'] = 'N3 Actores - Din??micas Espaciales Actores Armados  - Repliegue';
        $arreglo['t_03_02_06'] = 'N3 Actores - Din??micas Espaciales Actores Armados  - Cambios Oorganizaci??n Grupos Armados';
        $arreglo['t_03_02_07'] = 'N3 Actores - Din??micas Espaciales Actores Armados  - Relaci??n Actores Armados';
        $arreglo['t_03_03_00'] = 'N3 Actores - Desarme Desmov. Desvinc.';
        $arreglo['t_03_04_00'] = 'N3 Actores - Experiencia Posdesmovilizaci??n';
        $arreglo['t_03_05_00'] = 'N3 Actores - Vida Familiar Comunitaria Excombatientes';
        $arreglo['t_03_06_00'] = 'N3 Actores - Estructura Organizativa';
        $arreglo['t_03_06_01'] = 'N3 Actores - Estructura Organizativa - Organigrama';
        $arreglo['t_03_06_02'] = 'N3 Actores - Estructura Organizativa - Perfiles de miembros';
        $arreglo['t_03_06_03'] = 'N3 Actores - Estructura Organizativa - Descripcion de roles';
        $arreglo['t_03_06_04'] = 'N3 Actores - Estructura Organizativa - Asenso y degradacion';
        $arreglo['t_03_07_00'] = 'N3 Actores - Contexto previo a vinculacion';
        $arreglo['t_03_08_00'] = 'N3 Actores - Vida intrafilas';
        $arreglo['t_03_08_01'] = 'N3 Actores - Vida intrafilas - Modalidades ingreso';
        $arreglo['t_03_08_02'] = 'N3 Actores - Vida intrafilas - Reglas dentro del grupo';
        $arreglo['t_03_08_03'] = 'N3 Actores - Vida intrafilas - Sanciones y castigos a combatientes';
        $arreglo['t_03_08_04'] = 'N3 Actores - Vida intrafilas - Incentivos intrafilas';
        $arreglo['t_03_08_05'] = 'N3 Actores - Vida intrafilas - Vida cotidiana al interior del grupo';
        $arreglo['t_03_08_06'] = 'N3 Actores - Vida intrafilas - Relaciones afectivas';
        $arreglo['t_03_08_07'] = 'N3 Actores - Vida intrafilas - Violencias intrafilas';
        $arreglo['t_03_09_00'] = 'N3 Actores - Entrenamiento y formaci??n';
        $arreglo['t_03_09_01'] = 'N3 Actores - Entrenamiento y formaci??n - Proceso de formaci??n pol??tica/ideol??gica';
        $arreglo['t_03_09_02'] = 'N3 Actores - Entrenamiento y formaci??n - Proceso de entenamiento militar y de inteligencia';
        $arreglo['t_03_09_04'] = 'N3 Actores - Entrenamiento y formaci??n - Otros procesos de formaci??n';
        $arreglo['t_03_09_05'] = 'N3 Actores - Entrenamiento y formaci??n - Entrenamiento en Salud';
        $arreglo['t_03_10_00'] = 'N3 Actores - Percepciones de si mismos y otros';
        $arreglo['t_03_11_00'] = 'N3 Actores - Percepcion de los civiles';
        $arreglo['t_03_12_00'] = 'N3 Actores - Accionar del AA';
        $arreglo['t_03_12_01'] = 'N3 Actores - Accionar del AA - Acciones b??licas';
        $arreglo['t_03_12_02'] = 'N3 Actores - Accionar del AA - T??cticas de inteligencia/contrainteligencia';
        $arreglo['t_03_12_03'] = 'N3 Actores - Accionar del AA - Patrullaje y registro';
        $arreglo['t_03_12_04'] = 'N3 Actores - Accionar del AA - Retenes';
        $arreglo['t_03_13_00'] = 'N3 Actores - Control a poblacion civil';
        $arreglo['t_03_13_01'] = 'N3 Actores - Control a poblacion civil - Regulaci??n de la vida social y comunitaria';
        $arreglo['t_03_13_02'] = 'N3 Actores - Control a poblacion civil - Regulaci??n econ??mica';
        $arreglo['t_03_13_03'] = 'N3 Actores - Control a poblacion civil - Estrategias de legitimaci??n de los grupos armados';
        $arreglo['t_03_13_04'] = 'N3 Actores - Control a poblacion civil - Normas a la poblaci??n civil';
        $arreglo['t_03_13_06'] = 'N3 Actores - Control a poblacion civil - Sanciones y castigos a la poblaci??n';
        $arreglo['t_03_13_07'] = 'N3 Actores - Control a poblacion civil - Enamoramiento o seducci??n';
        $arreglo['t_03_14_00'] = 'N3 Actores - Deserci??n';
        $arreglo['t_03_15_00'] = 'N3 Actores - Falsa desmovilizaci??n';
        $arreglo['t_04_00_00'] = 'N41 Econom??a';
        $arreglo['t_04_01_00'] = 'N41 Econom??a - Megaproyectos';
        $arreglo['t_04_02_00'] = 'N41 Econom??a - Economias ilegales';
        $arreglo['t_04_03_00'] = 'N41 Econom??a - Cambios en uso de suelo';
        $arreglo['t_04_04_00'] = 'N41 Econom??a - Conflictos por la tierra';
        $arreglo['t_04_05_00'] = 'N41 Econom??a - Relaciones AA y TC';
        $arreglo['t_04_07_00'] = 'N41 Econom??a - Vida campesina y conflicto armado';
        $arreglo['t_04_07_01'] = 'N41 Econom??a - Vida campesina y conflicto armado - Econom??a campesina';
        $arreglo['t_04_07_02'] = 'N41 Econom??a - Vida campesina y conflicto armado - Identidad campesina y v??nculo con el territorio';
        $arreglo['t_04_07_03'] = 'N41 Econom??a - Vida campesina y conflicto armado - Formas sociales y organizaciones campesinas';
        $arreglo['t_04_08_00'] = 'N41 Econom??a - Relaci??n del conflicto con el medio ambiente';
        $arreglo['t_05_00_00'] = 'N42 Despojo';
        $arreglo['t_05_01_00'] = 'N42 Despojo - Causas del desplazamiento/abandono/confinamiento';
        $arreglo['t_05_02_00'] = 'N42 Despojo - Din??micas urbanas del despojo y el desplazamiento';
        $arreglo['t_05_02_01'] = 'N42 Despojo - Din??micas urbanas del despojo y el desplazamiento - Desplazamiento intraurbano';
        $arreglo['t_05_02_02'] = 'N42 Despojo - Din??micas urbanas del despojo y el desplazamiento - Despojo urbano';
        $arreglo['t_05_03_00'] = 'N42 Despojo - Medios y participantes que act??an en el despojo';
        $arreglo['t_05_04_00'] = 'N42 Despojo - Procesos de recuperaci??n de tierras';
        $arreglo['t_05_05_00'] = 'N42 Despojo - Solicitud de adjudicaci??n de tierras';
        $arreglo['t_05_07_00'] = 'N42 Despojo - Retorno y reasentamiento';
        $arreglo['t_05_08_00'] = 'N42 Despojo - Revictimizaci??n en el proceso de reclamaci??n de tierras o retorno';
        $arreglo['t_05_09_00'] = 'N42 Despojo - Generaci??n de conflictos como efecto de las medidas de restituci??n de tierras';
        $arreglo['t_06_00_00'] = 'N5 Narcotrafico';
        $arreglo['t_06_01_00'] = 'N5 Narcotrafico - Cultivo il??cito';
        $arreglo['t_06_01_01'] = 'N5 Narcotrafico - Cultivo il??cito - Formas y din??micas de producci??n';
        $arreglo['t_06_02_00'] = 'N5 Narcotrafico - Procesamiento tr??fico';
        $arreglo['t_06_03_00'] = 'N5 Narcotrafico - Dineros il??citos';
        $arreglo['t_06_04_00'] = 'N5 Narcotrafico - Consumo drogas';
        $arreglo['t_06_05_00'] = 'N5 Narcotrafico - Impacto narcotr??fico';
        $arreglo['t_06_06_00'] = 'N5 Narcotrafico - Impactos culturales del narcotr??fico';
        $arreglo['t_07_00_00'] = 'N7 Pueblos ??tnicos';
        $arreglo['t_07_01_00'] = 'N7 Pueblos ??tnicos - Racismo discriminaci??n';
        $arreglo['t_07_05_00'] = 'N7 Pueblos ??tnicos - Economias extractivas';
        $arreglo['t_07_06_00'] = 'N7 Pueblos ??tnicos - Uso personas econom??a ilegal';
        $arreglo['t_07_07_00'] = 'N7 Pueblos ??tnicos - Tensiones hoja coca';
        $arreglo['t_07_09_00'] = 'N7 Pueblos ??tnicos - Asignaci??n recursos';
        $arreglo['t_07_10_00'] = 'N7 Pueblos ??tnicos - Rel Estado y ??tnicos';
        $arreglo['t_07_11_00'] = 'N7 Pueblos ??tnicos - Militarizaci??n';
        $arreglo['t_07_11_04'] = 'N7 Pueblos ??tnicos - Militarizaci??n - Presencia MAPP-MUSE';
        $arreglo['t_07_12_00'] = 'N7 Pueblos ??tnicos - Procesos colonizaci??n';
        $arreglo['t_07_13_00'] = 'N7 Pueblos ??tnicos - Relaciones inter??tnicas';
        $arreglo['t_07_13_01'] = 'N7 Pueblos ??tnicos - Relaciones inter??tnicas - Conflictos inter??tnicos';
        $arreglo['t_07_14_00'] = 'N7 Pueblos ??tnicos - Din??micas entre fronteras territoriales y pueblos ??tnicos';
        $arreglo['t_07_15_00'] = 'N7 Pueblos ??tnicos - Exterminio';
        $arreglo['t_07_17_00'] = 'N7 Pueblos ??tnicos - Derechos';
        $arreglo['t_07_17_01'] = 'N7 Pueblos ??tnicos - Derechos - Posesi??n uso';
        $arreglo['t_07_17_02'] = 'N7 Pueblos ??tnicos - Derechos - Acceso y relaciones';
        $arreglo['t_07_17_03'] = 'N7 Pueblos ??tnicos - Derechos - Recuperaci??n';
        $arreglo['t_07_17_04'] = 'N7 Pueblos ??tnicos - Derechos - Restituci??n';
        $arreglo['t_07_18_00'] = 'N7 Pueblos ??tnicos - Tensiones identitarias';
        $arreglo['t_08_00_00'] = 'N81 Exilio';
        $arreglo['t_08_02_00'] = 'N81 Exilio - Trayectorias y Reasentamientos';
        $arreglo['t_08_03_00'] = 'N81 Exilio - Violencia';
        $arreglo['t_08_04_00'] = 'N81 Exilio - Estatus migratorio';
        $arreglo['t_08_04_01'] = 'N81 Exilio - Estatus migratorio - Con protecci??n internacional';
        $arreglo['t_08_04_02'] = 'N81 Exilio - Estatus migratorio - Solicitante protecci??n internacional';
        $arreglo['t_08_04_03'] = 'N81 Exilio - Estatus migratorio - Otros';
        $arreglo['t_08_04_04'] = 'N81 Exilio - Estatus migratorio - Programas protecci??n';
        $arreglo['t_08_04_05'] = 'N81 Exilio - Estatus migratorio - Migrantes irregulares';
        $arreglo['t_08_04_06'] = 'N81 Exilio - Estatus migratorio - Deportaci??n';
        $arreglo['t_08_05_00'] = 'N81 Exilio - Pol??ticas';
        $arreglo['t_08_06_00'] = 'N81 Exilio - Institucionalidad';
        $arreglo['t_08_07_00'] = 'N81 Exilio - Retorno';
        $arreglo['t_08_11_00'] = 'N81 Exilio - Relaciones cultura de acogida';
        $arreglo['t_08_11_01'] = 'N81 Exilio - Relaciones cultura de acogida - Apat??a a Colombia';
        $arreglo['t_08_11_02'] = 'N81 Exilio - Relaciones cultura de acogida - Estigmatizaci??n y discriminaci??n';
        $arreglo['t_08_11_03'] = 'N81 Exilio - Relaciones cultura de acogida - Cambio identitario';
        $arreglo['t_08_11_04'] = 'N81 Exilio - Relaciones cultura de acogida - Cambio cultural';
        $arreglo['t_08_11_05'] = 'N81 Exilio - Relaciones cultura de acogida - P??rdida estatus';
        $arreglo['t_08_11_06'] = 'N81 Exilio - Relaciones cultura de acogida - Desarraigo';
        $arreglo['t_09_00_00'] = 'N82 Dim. Internacionales';
        $arreglo['t_09_01_00'] = 'N82 Dim. Internacionales - Cooperaci??n internacional';
        $arreglo['t_09_02_00'] = 'N82 Dim. Internacionales - Apoyo pol??tico actores conflicto';
        $arreglo['t_09_03_00'] = 'N82 Dim. Internacionales - Violencias';
        $arreglo['t_09_04_00'] = 'N82 Dim. Internacionales - Presencia b??lica';
        $arreglo['t_09_05_00'] = 'N82 Dim. Internacionales - Apoyo militar actores armados';
        $arreglo['t_09_06_00'] = 'N82 Dim. Internacionales - Acciones armadas';
        $arreglo['t_09_07_00'] = 'N82 Dim. Internacionales - Instituciones fronterizas';
        $arreglo['t_10_00_00'] = 'N9 Cultura';
        $arreglo['t_10_01_00'] = 'N9 Cultura - Discursos iglesias';
        $arreglo['t_10_02_00'] = 'N9 Cultura - Discursos sistema educativo';
        $arreglo['t_10_03_00'] = 'N9 Cultura - Discursos medios';
        $arreglo['t_10_04_00'] = 'N9 Cultura - Afectaciones';
        $arreglo['t_10_05_00'] = 'N9 Cultura - Transformaciones sobre lugares de valor cultural';
        $arreglo['t_10_06_00'] = 'N9 Cultura - Cambios formas de ver al otro';
        $arreglo['t_10_07_00'] = 'N9 Cultura - Transformaciones identidad';
        $arreglo['t_11_00_00'] = 'Salud';
        $arreglo['t_11_01_00'] = 'Salud - Actividades sanitarias';
        $arreglo['t_11_01_01'] = 'Salud - Actividades sanitarias - Prevenci??n en salud o saneamiento ambiental';
        $arreglo['t_11_01_02'] = 'Salud - Actividades sanitarias - Salud sexual y reproductiva';
        $arreglo['t_11_01_03'] = 'Salud - Actividades sanitarias - Atenci??n en salud';
        $arreglo['t_11_02_00'] = 'Salud - Infracciones contra bienes protegidos en salud';
        $arreglo['t_11_03_00'] = 'Salud - Infracciones a la misi??n m??dica';
        $arreglo['t_11_03_01'] = 'Salud - Infracciones a la misi??n m??dica - Infracciones contra la actividad sanitaria';
        $arreglo['t_11_03_04'] = 'Salud - Infracciones a la misi??n m??dica - Actos de perfidia';
        $arreglo['t_11_04_00'] = 'Salud - Cooptaci??n de recursos de salud por actores armados';
        $arreglo['t_11_07_00'] = 'Salud - Sanidad Civil Por Actor Armado';
        $arreglo['t_12_00_00'] = 'Impactos';
        $arreglo['t_12_01_00'] = 'Impactos - Impact Emoc Salud Mental Fisica';
        $arreglo['t_12_01_01'] = 'Impactos - Impact Emoc Salud Mental Fisica - EnfermedadesDa??osCuerpo';
        $arreglo['t_12_01_02'] = 'Impactos - Impact Emoc Salud Mental Fisica - Discapacidad';
        $arreglo['t_12_01_03'] = 'Impactos - Impact Emoc Salud Mental Fisica - Rabia';
        $arreglo['t_12_01_04'] = 'Impactos - Impact Emoc Salud Mental Fisica - Tristeza';
        $arreglo['t_12_01_05'] = 'Impactos - Impact Emoc Salud Mental Fisica - Miedo';
        $arreglo['t_12_01_06'] = 'Impactos - Impact Emoc Salud Mental Fisica - Desesperanza';
        $arreglo['t_12_01_07'] = 'Impactos - Impact Emoc Salud Mental Fisica - Desarraigo';
        $arreglo['t_12_01_08'] = 'Impactos - Impact Emoc Salud Mental Fisica - Dificultades mentales';
        $arreglo['t_12_01_09'] = 'Impactos - Impact Emoc Salud Mental Fisica - uso de sustancias psicoactivas';
        $arreglo['t_12_01_10'] = 'Impactos - Impact Emoc Salud Mental Fisica - A la salud sexual y reproductiva';
        $arreglo['t_12_01_11'] = 'Impactos - Impact Emoc Salud Mental Fisica - Baja autoestima y violencia contra s?? mismo.';
        $arreglo['t_12_01_12'] = 'Impactos - Impact Emoc Salud Mental Fisica - Resentimiento';
        $arreglo['t_12_01_13'] = 'Impactos - Impact Emoc Salud Mental Fisica - Odio';
        $arreglo['t_12_01_14'] = 'Impactos - Impact Emoc Salud Mental Fisica - Culpa';
        $arreglo['t_12_01_15'] = 'Impactos - Impact Emoc Salud Mental Fisica - Estigmatizaci??n';
        $arreglo['t_12_01_16'] = 'Impactos - Impact Emoc Salud Mental Fisica - Impotencia';
        $arreglo['t_12_01_17'] = 'Impactos - Impact Emoc Salud Mental Fisica - Desconfianza';
        $arreglo['t_12_01_18'] = 'Impactos - Impact Emoc Salud Mental Fisica - Aislamiento';
        $arreglo['t_12_01_19'] = 'Impactos - Impact Emoc Salud Mental Fisica - Suicidio';
        $arreglo['t_12_01_20'] = 'Impactos - Impact Emoc Salud Mental Fisica - Autocensura';
        $arreglo['t_12_01_21'] = 'Impactos - Impact Emoc Salud Mental Fisica - Marginaci??n y segregaci??n';
        $arreglo['t_12_02_00'] = 'Impactos - Impacto Familiares';
        $arreglo['t_12_02_01'] = 'Impactos - Impacto Familiares - Estructura familiar';
        $arreglo['t_12_02_02'] = 'Impactos - Impacto Familiares - En las relaciones y  arreglos de g??nero';
        $arreglo['t_12_02_03'] = 'Impactos - Impacto Familiares - Cambios economicos y materiales';
        $arreglo['t_12_02_04'] = 'Impactos - Impacto Familiares - Cambios en los planes de vida';
        $arreglo['t_12_02_05'] = 'Impactos - Impacto Familiares - Cambios en las costumbres y tradiciones';
        $arreglo['t_12_02_06'] = 'Impactos - Impacto Familiares - desestructuracion familiar';
        $arreglo['t_12_02_07'] = 'Impactos - Impacto Familiares - Impactos transmitidos a las siguientes generaciones';
        $arreglo['t_12_02_11'] = 'Impactos - Impacto Familiares - P??rdida de autonom??a y dificultad en la toma de decisiones';
        $arreglo['t_12_03_00'] = 'Impactos - Impactos Comunitarios o Colectivos';
        $arreglo['t_12_03_01'] = 'Impactos - Impactos Comunitarios o Colectivos - Perdida de pr??cticas y saberes culturales';
        $arreglo['t_12_03_02'] = 'Impactos - Impactos Comunitarios o Colectivos - Deterioro y/o ruptura del tejido social';
        $arreglo['t_12_03_03'] = 'Impactos - Impactos Comunitarios o Colectivos - Incremento de las conflictividades, violencias y/o deshumanizaci??n de la vida';
        $arreglo['t_12_03_04'] = 'Impactos - Impactos Comunitarios o Colectivos - ruptura de procesos organizativos';
        $arreglo['t_12_03_05'] = 'Impactos - Impactos Comunitarios o Colectivos - Silencio';
        $arreglo['t_12_03_06'] = 'Impactos - Impactos Comunitarios o Colectivos - desconfianza colectiva';
        $arreglo['t_12_03_07'] = 'Impactos - Impactos Comunitarios o Colectivos - ruptura de practicas cotidianas';
        $arreglo['t_12_03_08'] = 'Impactos - Impactos Comunitarios o Colectivos - impactos en liderazgos colectivos';
        $arreglo['t_12_03_10'] = 'Impactos - Impactos Comunitarios o Colectivos - clima emocional del terror.';
        $arreglo['t_12_03_12'] = 'Impactos - Impactos Comunitarios o Colectivos - Naturalizaci??n de la violencia e indiferencia';
        $arreglo['t_12_03_13'] = 'Impactos - Impactos Comunitarios o Colectivos - Espiritual';
        $arreglo['t_12_03_14'] = 'Impactos - Impactos Comunitarios o Colectivos - Autodeterminaci??n y autonom??a';
        $arreglo['t_12_04_00'] = 'Impactos - Impacto Terrestre';
        $arreglo['t_12_04_01'] = 'Impactos - Impacto Terrestre - Perdidas materiales y  econ??micas';
        $arreglo['t_12_04_02'] = 'Impactos - Impacto Terrestre - Destruccion del territorio y naturaleza';
        $arreglo['t_12_04_03'] = 'Impactos - Impacto Terrestre - Transformaci??n del paisaje';
        $arreglo['t_12_04_04'] = 'Impactos - Impacto Terrestre - Transformaci??n de los usos y relaciones con el territorio';
        $arreglo['t_12_05_00'] = 'Impactos - Impacto DESCA';
        $arreglo['t_12_06_00'] = 'Impactos - Impacto Democracia';
        $arreglo['t_12_06_02'] = 'Impactos - Impacto Democracia - Afectaciones a libertad de prensa';
        $arreglo['t_12_06_03'] = 'Impactos - Impacto Democracia - Afectaci??n a derechos electorales';
        $arreglo['t_13_00_00'] = 'Hechos';
        $arreglo['t_13_01_00'] = 'Hechos - Homicidio';
        $arreglo['t_13_01_01'] = 'Hechos - Homicidio - Ejecucion Extrajudicial Arbitraria';
        $arreglo['t_13_01_02'] = 'Hechos - Homicidio - Ejecucion Extrajudicial Falso Positivo';
        $arreglo['t_13_01_03'] = 'Hechos - Homicidio - Masacre';
        $arreglo['t_13_01_04'] = 'Hechos - Homicidio - Muerte Discriminacion Prejuicio';
        $arreglo['t_13_01_05'] = 'Hechos - Homicidio - Muerte Civiles Combate';
        $arreglo['t_13_01_06'] = 'Hechos - Homicidio - Muerte Civiles Bombas';
        $arreglo['t_13_01_07'] = 'Hechos - Homicidio - Muerte Civiles Esplosivos';
        $arreglo['t_13_01_08'] = 'Hechos - Homicidio - Muerte Civiles Ataques Bienes Civiles';
        $arreglo['t_13_02_00'] = 'Hechos - Atentado A la Vida';
        $arreglo['t_13_02_01'] = 'Hechos - Atentado A la Vida - Herido Atentado';
        $arreglo['t_13_02_02'] = 'Hechos - Atentado A la Vida - Victima Sin Lesiones';
        $arreglo['t_13_02_03'] = 'Hechos - Atentado A la Vida - Civil Heridos Combate';
        $arreglo['t_13_02_04'] = 'Hechos - Atentado A la Vida - Civiles Heridos Bombas';
        $arreglo['t_13_02_05'] = 'Hechos - Atentado A la Vida - Civiles Heridos Esplosivos';
        $arreglo['t_13_02_06'] = 'Hechos - Atentado A la Vida - Civiles Ataques Bienes Civiles';
        $arreglo['t_13_03_00'] = 'Hechos - Amenaza a la Vida';
        $arreglo['t_13_03_01'] = 'Hechos - Amenaza a la Vida - Amenaza Verbal';
        $arreglo['t_13_03_02'] = 'Hechos - Amenaza a la Vida - Amenaza Llamada Telefonica';
        $arreglo['t_13_03_03'] = 'Hechos - Amenaza a la Vida - Amenaza Correo Electronico o redes sociales';
        $arreglo['t_13_03_04'] = 'Hechos - Amenaza a la Vida - Amenaza Familiar Amigos';
        $arreglo['t_13_03_05'] = 'Hechos - Amenaza a la Vida - Amenza Seguimiento';
        $arreglo['t_13_03_06'] = 'Hechos - Amenaza a la Vida - Amenaza Panfleto carta o sufragio';
        $arreglo['t_13_04_00'] = 'Hechos - Exterminio';
        $arreglo['t_13_04_01'] = 'Hechos - Exterminio - Genocidio';
        $arreglo['t_13_04_02'] = 'Hechos - Exterminio - Apologia Genocidio';
        $arreglo['t_13_04_03'] = 'Hechos - Exterminio - Exterminio Social';
        $arreglo['t_13_05_00'] = 'Hechos - Desaparici??n forzada';
        $arreglo['t_13_05_01'] = 'Hechos - Desaparici??n forzada - Desaparic Selectiva';
        $arreglo['t_13_05_02'] = 'Hechos - Desaparici??n forzada - Desaparic Encubridora';
        $arreglo['t_13_05_03'] = 'Hechos - Desaparici??n forzada - Desaparic Medio Intimidacion';
        $arreglo['t_13_05_04'] = 'Hechos - Desaparici??n forzada - Fosas Comunes';
        $arreglo['t_13_06_00'] = 'Hechos - Tortura y otros tratos crueles';
        $arreglo['t_13_06_01'] = 'Hechos - Tortura y otros tratos crueles - Tortura Fisica';
        $arreglo['t_13_06_02'] = 'Hechos - Tortura y otros tratos crueles - Tortura Psicologica';
        $arreglo['t_13_08_00'] = 'Hechos - Violencias sexuales';
        $arreglo['t_13_08_01'] = 'Hechos - Violencias sexuales - Empalamiento';
        $arreglo['t_13_08_02'] = 'Hechos - Violencias sexuales - Anticoncep Estirilizacion Forzada';
        $arreglo['t_13_08_03'] = 'Hechos - Violencias sexuales - Aborto Forzado';
        $arreglo['t_13_08_04'] = 'Hechos - Violencias sexuales - Explotacion Sexual';
        $arreglo['t_13_08_05'] = 'Hechos - Violencias sexuales - Esclavitud Sexual';
        $arreglo['t_13_08_06'] = 'Hechos - Violencias sexuales - Obligacion Ver Actos Sexuales';
        $arreglo['t_13_08_07'] = 'Hechos - Violencias sexuales - Obligacion Actos Sexuales';
        $arreglo['t_13_08_08'] = 'Hechos - Violencias sexuales - Violacion Sexual';
        $arreglo['t_13_08_09'] = 'Hechos - Violencias sexuales - Prostitucion Forzada';
        $arreglo['t_13_08_10'] = 'Hechos - Violencias sexuales - Embarazo Forzado';
        $arreglo['t_13_08_11'] = 'Hechos - Violencias sexuales - Tortura en Embarazo';
        $arreglo['t_13_08_12'] = 'Hechos - Violencias sexuales - Maternidad Crianza Forzada';
        $arreglo['t_13_08_13'] = 'Hechos - Violencias sexuales - Desnudez Forzada';
        $arreglo['t_13_08_14'] = 'Hechos - Violencias sexuales - Mutilacion Organos Sexuales';
        $arreglo['t_13_08_15'] = 'Hechos - Violencias sexuales - Cambios en Cuerpo';
        $arreglo['t_13_08_16'] = 'Hechos - Violencias sexuales - Acoso sexual';
        $arreglo['t_13_09_00'] = 'Hechos - Reclutamiento NNA';
        $arreglo['t_13_09_01'] = 'Hechos - Reclutamiento NNA - Utilizacion Acciones Belicas';
        $arreglo['t_13_09_02'] = 'Hechos - Reclutamiento NNA - Utilizacion Vigilacia Inteligencia';
        $arreglo['t_13_09_03'] = 'Hechos - Reclutamiento NNA - Utilizacion Logisticas Administrativas';
        $arreglo['t_13_09_04'] = 'Hechos - Reclutamiento NNA - Utilizacion Narcotrafico';
        $arreglo['t_13_09_05'] = 'Hechos - Reclutamiento NNA - Amenaza Reclutamiento';
        $arreglo['t_13_10_00'] = 'Hechos - Detenci??n arbitraria';
        $arreglo['t_13_10_01'] = 'Hechos - Detenci??n arbitraria - Detencion Sin Orden';
        $arreglo['t_13_10_03'] = 'Hechos - Detenci??n arbitraria - Detencion Cumplimiento Pena';
        $arreglo['t_13_11_00'] = 'Hechos - Secuestro/toma de rehenes';
        $arreglo['t_13_11_01'] = 'Hechos - Secuestro/toma de rehenes - Secuestro Extorsivo';
        $arreglo['t_13_11_02'] = 'Hechos - Secuestro/toma de rehenes - Secuestro Politico';
        $arreglo['t_13_11_03'] = 'Hechos - Secuestro/toma de rehenes - Secuestro Simple';
        $arreglo['t_13_12_00'] = 'Hechos - Confinamiento';
        $arreglo['t_13_12_01'] = 'Hechos - Confinamiento - Confina Individual';
        $arreglo['t_13_12_02'] = 'Hechos - Confinamiento - Confina Familiar';
        $arreglo['t_13_12_03'] = 'Hechos - Confinamiento - Confina Colectivo';
        $arreglo['t_13_13_00'] = 'Hechos - Pillaje';
        $arreglo['t_13_14_00'] = 'Hechos - Extorsi??n';
        $arreglo['t_13_15_00'] = 'Hechos - Ataque a bien protegido';
        $arreglo['t_13_16_00'] = 'Hechos - Ataque indiscriminado';
        $arreglo['t_13_17_00'] = 'Hechos - Despojo/abandono de tierras';
        $arreglo['t_13_18_00'] = 'Hechos - Desplazamiento forzado';
        $arreglo['t_13_18_01'] = 'Hechos - Desplazamiento forzado - Desplazam Individual';
        $arreglo['t_13_18_02'] = 'Hechos - Desplazamiento forzado - Desplazam Familiar';
        $arreglo['t_13_18_03'] = 'Hechos - Desplazamiento forzado - Desplazam Masivo';
        $arreglo['t_13_19_00'] = 'Hechos - Exilio';
        $arreglo['t_13_20_00'] = 'Hechos - Trabajos o servicios forzados';
        $arreglo['t_13_21_00'] = 'Hechos - Limpieza social';
        $arreglo['t_14_00_00'] = 'Afrontamientos';
        $arreglo['t_14_01_00'] = 'Afrontamientos - Personales';
        $arreglo['t_14_02_00'] = 'Afrontamientos - Familiares';
        $arreglo['t_14_03_00'] = 'Afrontamientos - Redes apoyo';
        $arreglo['t_14_04_00'] = 'Afrontamientos - Pr??cticas art??sticas';
        $arreglo['t_14_05_00'] = 'Afrontamientos - Espiritualidad';
        $arreglo['t_14_06_00'] = 'Afrontamientos - Actividad f??sica';
        $arreglo['t_14_07_00'] = 'Afrontamientos - Enfrentar violento';
        $arreglo['t_14_08_00'] = 'Afrontamientos - Silencio';
        $arreglo['t_14_09_00'] = 'Afrontamientos - Alimentaci??n';
        $arreglo['t_14_10_00'] = 'Afrontamientos - Descarga emocional';
        $arreglo['t_14_11_00'] = 'Afrontamientos - Costumbres tradiciones';
        $arreglo['t_14_12_00'] = 'Afrontamientos - Asimilaci??n o adaptaci??n';
        $arreglo['t_15_00_00'] = 'Resistencia';
        $arreglo['t_15_01_00'] = 'Resistencia - Campesinado';
        $arreglo['t_15_02_00'] = 'Resistencia - Estrategias resistencia ??tnica';
        $arreglo['t_15_03_00'] = 'Resistencia - Movimiento cocalero';
        $arreglo['t_15_04_00'] = 'Resistencia - Organizaciones v??ctimas';
        $arreglo['t_15_05_00'] = 'Resistencia - Defensa ambiente';
        $arreglo['t_15_06_00'] = 'Resistencia - Acciones formativas';
        $arreglo['t_15_07_00'] = 'Resistencia - Espacio p??blico';
        $arreglo['t_15_08_00'] = 'Resistencia - Pactos convivencia paz';
        $arreglo['t_15_09_00'] = 'Resistencia - Art??sticos deportivos';
        $arreglo['t_15_10_00'] = 'Resistencia - Apoyo psicosocial';
        $arreglo['t_15_11_00'] = 'Resistencia - Apoyo legal';
        $arreglo['t_15_12_00'] = 'Resistencia - Construcci??n paz';
        $arreglo['t_16_00_00'] = 'Pol??ticas Internacionales';
        $arreglo['t_16_02_00'] = 'Pol??ticas Internacionales - Pol??ticas econ??micas';
        $arreglo['t_16_03_00'] = 'Pol??ticas Internacionales - Pol??ticas seguridad defensa';
        $arreglo['t_16_04_00'] = 'Pol??ticas Internacionales - Pol??ticas antidrogas';
        $arreglo['t_16_05_00'] = 'Pol??ticas Internacionales - Pol??ticas derechos humanos';
        $arreglo['t_17_00_00'] = 'Estigmatizaci??n';
        $arreglo['t_17_01_00'] = 'Estigmatizaci??n - Estigmatizaci??n familias';
        $arreglo['t_17_02_00'] = 'Estigmatizaci??n - Estigmatizaci??n pol??tica';
        $arreglo['t_17_03_00'] = 'Estigmatizaci??n - Construcci??n enemigo';
        $arreglo['t_17_04_00'] = 'Estigmatizaci??n - Colaborador';
        $arreglo['t_17_05_00'] = 'Estigmatizaci??n - Razones ??tnico-raciales';
        $arreglo['t_17_06_00'] = 'Estigmatizaci??n - Razones g??nero';
        $arreglo['t_17_07_00'] = 'Estigmatizaci??n - Razones clase';
        $arreglo['t_17_08_00'] = 'Estigmatizaci??n - Discapacidad';
        $arreglo['t_17_09_00'] = 'Estigmatizaci??n - Ciclo vital';
        $arreglo['t_17_10_00'] = 'Estigmatizaci??n - Territorial';
        $arreglo['t_17_11_00'] = 'Estigmatizaci??n - Geograf??as racializadas';
        $arreglo['t_17_12_00'] = 'Estigmatizaci??n - Econom??a drogas il??citas';
        $arreglo['t_18_00_00'] = 'No Repetici??n';
        $arreglo['t_18_01_00'] = 'No Repetici??n - R Educaci??n';
        $arreglo['t_18_02_00'] = 'No Repetici??n - R Estado';
        $arreglo['t_18_02_01'] = 'No Repetici??n - R Estado - Militarizaci??n';
        $arreglo['t_18_02_02'] = 'No Repetici??n - R Estado - Fuerza P??blica';
        $arreglo['t_18_03_00'] = 'No Repetici??n - R DESCA';
        $arreglo['t_18_04_00'] = 'No Repetici??n - R Reintegraci??n excombatientes';
        $arreglo['t_18_05_00'] = 'No Repetici??n - Reincidencia actores armados';
        $arreglo['t_18_06_00'] = 'No Repetici??n - Transformaciones culturales';
        $arreglo['t_18_07_00'] = 'No Repetici??n - R Drogas il??citas narcotr??fico';
        $arreglo['t_18_08_00'] = 'No Repetici??n - Desactivaci??n de minas';
        $arreglo['t_19_00_00'] = 'Pol??ticas p??blicas';
        $arreglo['t_19_01_00'] = 'Pol??ticas p??blicas - Seguridad y defensa Estado';
        $arreglo['t_19_02_00'] = 'Pol??ticas p??blicas - Agrarias';
        $arreglo['t_19_03_00'] = 'Pol??ticas p??blicas - V??ctimas';
        $arreglo['t_19_04_00'] = 'Pol??ticas p??blicas - Educaci??n';
        $arreglo['t_19_05_00'] = 'Pol??ticas p??blicas - Salud';
        $arreglo['t_19_06_00'] = 'Pol??ticas p??blicas - Ambientales';
        $arreglo['t_19_07_00'] = 'Pol??ticas p??blicas - D Institucionales ??tnicos';
        $arreglo['t_19_08_00'] = 'Pol??ticas p??blicas - Construcci??n paz';
        $arreglo['t_19_09_00'] = 'Pol??ticas p??blicas - Cultura';
        $arreglo['t_19_10_00'] = 'Pol??ticas p??blicas - Econ??micas';
        $arreglo['t_19_11_00'] = 'Pol??ticas p??blicas - Contra el narcotr??fico';
        $arreglo['t_20_00_00'] = 'Proceso de paz';
        $arreglo['t_20_02_00'] = 'Proceso de paz - Cambios institucionales';
        $arreglo['t_20_03_00'] = 'Proceso de paz - Cambios sociales';
        $arreglo['t_20_05_00'] = 'Proceso de paz - Reacciones';
        $arreglo['t_20_06_00'] = 'Proceso de paz - Apoyos internacionales';
        $arreglo['t_21_00_00'] = 'Transfronterizas';
        $arreglo['t_21_02_00'] = 'Transfronterizas - Desplazamiento forzado transfonterizo';
        $arreglo['t_21_03_00'] = 'Transfronterizas - Tr??fico personas';
        $arreglo['t_21_04_00'] = 'Transfronterizas - Tr??fico il??cito armas';
        $arreglo['t_21_05_00'] = 'Transfronterizas - Contrabando';
        $arreglo['t_21_06_00'] = 'Transfronterizas - D Pueblos ??tnicos binacionales';
        $arreglo['t_21_07_00'] = 'Transfronterizas - D armadas';
        $arreglo['t_21_08_00'] = 'Transfronterizas - D Instituciones estatales';
        $arreglo['conteo_etiquetas'] = 'Total de etiquetas aplicadas';
        $arreglo['fh_insert'] = 'Fecha de actualizaci??n';
        return $arreglo;
    }
    public static function codigo_a_campo($codigo) {
        $texto = "t_";
        $texto.=substr($codigo,0,2);
        $texto.="_";
        $texto.=substr($codigo,2,2);
        $texto.="_";
        $texto.=substr($codigo,4,2);
        return $texto;
    }

    //Actualizar la tabla
    public static function generar_plana($vaciar=false) {
        $inicio = Carbon::now();
        // Nueva logica, siempre truncar
        Log::notice("ETL de uso de tesauro: inicio del proceso");

        //No est?? al d??a, procesar
        $total_filas=0;
        $total_errores=0;
        uso_tesauro::truncate();
        //$listado = entrevista_individual::filtrar($filtros)->orderby('entrevista_correlativo')->get();
        $listado = etiqueta_entrevista::selectRaw(\DB::raw("etiqueta_entrevista.codigo as codigo_entrevista, tesauro.codigo as codigo_etiqueta, count(1) as conteo"))
                                    ->join('catalogos.tesauro','tesauro.id_etiqueta','etiqueta_entrevista.id_etiqueta')
                                    ->where('tesauro.id_activo',1)
                                    ->groupby('codigo_entrevista')
                                    ->groupby('codigo_etiqueta')
                                    ->orderby('codigo_entrevista')
                                    ->orderby('codigo_etiqueta')
                                    ->get();

        //La variable arreglo me permite "aplanar" los resultados
        $arreglo=array();
        foreach($listado as $fila) {
            $campo = self::codigo_a_campo($fila->codigo_etiqueta);
            $arreglo[$fila->codigo_entrevista][$campo] = $fila->conteo;
        }

        //Validar que existan los campos
        $a_campos = uso_tesauro::encabezados();
        foreach($arreglo as $codigo => $datos) {
            $excel = new uso_tesauro();
            $excel->codigo = $codigo;
            $conteo=0;
            foreach($datos as $campo => $valor) {
                if(isset($a_campos[$campo])) {  //Validacion de que exista el campo
                    $excel->$campo = $valor;
                    $conteo += $valor;
                }
            }
            $excel->conteo_etiquetas = $conteo;
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                Log::error('Problemas con el ETL de uso de tesauro' .PHP_EOL.$e->getMessage());
                $total_errores++;
            }
        }
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;
        $respuesta->total_errores = $total_errores;

        Log::info("ETL de uso de tesauro: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }

}
