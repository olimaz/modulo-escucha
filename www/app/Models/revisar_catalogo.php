<?php

namespace App\Models;
use Eloquent as Model;


class revisar_catalogo extends Model
{
    public static function sustituye($info_dir) {
      // /dd($info_dir['descripcion']);
      //dd($info_dir);
      /*
      "id_directorio_catalogo" => 20
      "tabla" => "fichas.entrevista_impacto"
      "campo" => "id_impacto"
      "descripcion" => "Impactos Individuales - Impactos emocionales que permanecen el tiempo"
      "id_cat" => "133"
      "id_item_asignar" => "755"
      "id_item" => "1024"
      1024	133	otro tiempo	(null)	(null)	0	2	(null)	1	1	2019-10-17 12:56:28	(null)
      */
        // $arreglo[0]['id_catalogo']=24;
        // $arreglo[0]['tabla']='fichas.persona';
        // $arreglo[0]['campo']='id_sexo';435	20	1152	(null)	(null)	2019-12-12 13:02:43

        $queries=array();
        $descripcion=array();
        foreach($info_dir as $fila) {
            $queries[] = "update ".$fila['tabla']. " set ". $fila['campo']. " = ".  $fila['id_item_asignar']." where ".  $fila['campo']. " = ".  $fila['id_item'];
            $descripcion[] = $fila['descripcion'];
        }
        //dd($descripcion);

        foreach($queries as $q) {
            $finalResult = \DB::update(\DB::raw($q));
            if($finalResult == 1){





            } else {
               $mensaje ="ERROR";
            }

            $traza = new traza_catalogo();
            $traza->id_directorio_catalogo=$fila['id_directorio_catalogo'];
            $traza->id_entrevistador=$fila['id_entrevistador'];
            $traza->valor_anterior=$fila['id_item'];
            $traza->valor_nuevo=$fila['id_item_asignar'];
            $traza->save();
            //\DB::raw($q);
            //echo $q;
            //\DB::statement($q);
        }

        $mensaje="Fueron actualizados los siguientes items:";
        foreach($descripcion as $x) {
          if($x)
            {$mensaje=$mensaje."<br>".$x;}
        }
        return $mensaje;

    }
}
