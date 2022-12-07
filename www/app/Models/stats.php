<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class stats extends Model
{
    //
    public static function getChiSquare($x, $n) {
        if ( ($n==1) && ($x > 1000) ) {
            return 0;
        }

        if ( ($x>1000) || ($n>1000) ) {
            $q = getChiSquare(($x-$n)*($x-$n)/(2*$n),1) / 2;
            if($x > $n) {
                return $q;
            } else {
                return 1 - $q;
            }
        }
        $p = exp(-0.5 * $x);
        if(($n % 2) == 1) {
            $p = $p * sqrt(2*$x/pi());
        }
        $k = $n;
        while($k >= 2) {
            $p = $p * ($x/$k);
            $k = $k - 2;
        }
        $t = $p;
        $a = $n;
        while($t > 0.0000000001 * $p) {
            $a = $a + 2;
            $t = $t * ($x / $a);
            $p = $p + $t;
        }

        $retval = 1-$p;
        return $retval;
    }


    //Funcion que me devuelve el valor de la tabla

    /**
     * @param $p nivel de significancia
     * @param $n grados de libertad
     * @return float|int
     */
    public static function AChiSq($p,$n) {
        $v=0.5;
        $dv=0.5;
        $x=0;
        while($dv>1e-15) {
            $x=1/$v-1;
            $dv=$dv/2;
            if (self::ChiSq($x,$n)>$p) {
                $v=$v-$dv;
            }
            else {
                $v=$v+$dv;
            }
        }
        return $x;
    }
    public static function Norm($z) {
        $q=$z*$z;
        if (abs($z)>7)
            return (1-1/$q+3/($q*$q))*exp(-$q/2)/(abs($z)*sqrt(pi()/2));
        else
            return self::ChiSq($q,1);
    }
    public static function ChiSq($x,$n) {
        $Pi = pi();
        if ($x>1000 || $n>1000) {
            $q=self::Norm((pow($x/$n,1/3)+2/(9*$n)-1)/sqrt(2/(9*$n)))/2;
            if ($x>$n)
                return $q;
            else
                return 1-$q;
        }
        $p=exp(-0.5*$x);
        if(($n%2)==1) { $p=$p*sqrt(2*$x/pi());       }
        $k=$n;
        while($k>=2) {
            $p=$p*$x/$k;
            $k=$k-2;
        }
        $t=$p;
        $a=$n;
        while($t>1e-15*$p) {
            $a=$a+2;
            $t=$t*$x/$a;
            $p=$p+$t;
        }

        return 1-$p;
    }
    public static  function calppm($conf,$fails,$total)
    {
        $E5 = $conf/100;
        $F5 = $fails;
        $G5 = $total;

        $I5 = self::AChiSq((1-$E5),(2*($F5+1)))*1000000/(2*$G5);

        return round($I5);
    }


    //Exporta las transcripciones a un html
    //Recibe un arreglo con las transcripciones, crea el html y muestra la descarga
    public static function exportar_transcripciones($transcripciones) {
        $exportar="";
        $a_indice=array();
        //traza_buscador::create(['id_tipo'=>1,'texto_buscado'=>trim($filtros->fts)]);
        foreach($transcripciones as $codigo=>$html) {
            $exportar .= "<h1 id='$codigo'>$codigo</h1>";
            $exportar .= "<p style='font-size:smaller'><a href='#top'>(Regresar a la tabla de contenido)</a></p>";
            $exportar .= nl2br($html);
            $exportar .= '<p style="page-break-after: always;">&nbsp;</p>
                                    <p style="page-break-before: always;">&nbsp;</p>';
            $a_indice[] = "<a href='#$codigo'>$codigo</a>";
        }
        $tmp = implode("</li><li>",$a_indice);
        $tmp = "<ol><li>$tmp</li></ol>";

        $indice = "<h1 id='top'>Tabla de contenido</h1>".$tmp;
        $indice.='<p style="page-break-after: always;">&nbsp;</p>
                                    <p style="page-break-before: always;">&nbsp;</p>';
        $exportar = $indice.$exportar;

        //dd($exportar);
        $nombre = date("Y-m-d");
        $id=\Auth::user()->fmt_Numero_Entrevistador;
        $nombre.="_".$id."_transcripcinoes.html";

        return \Response::make($exportar, '200', array(
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=$nombre"
        ));
    }
}
