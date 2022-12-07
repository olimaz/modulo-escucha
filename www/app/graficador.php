<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class graficador extends Model
{
    public static function g_area($datos, $bandas_tiempo=false, $otro_estilo=false) {

        //Barras a graficar
        $g_series=array();

        $primer_anio=0;  //Para las bandas de tiempo
        foreach($datos->a_serie as $id_serie=>$serie) {
            $val=array();
            foreach($datos->categorias as $id_cat=>$categoria) {
                $punto = new \stdClass();
                $punto->name=$id_cat;
                $punto->value=$datos->a_serie[$id_serie][$id_cat];
                $val[]=$punto;
                if($primer_anio == 0) {
                    $primer_anio = $id_cat;
                }
            }

            $s['name']=$datos->nombre_serie[$id_serie];
            $tipo = isset($datos->tipo_serie[$id_serie]) ? $datos->tipo_serie[$id_serie] : 'line';
            $s['type']=$tipo;
            $s['data']=$val;
            $s['smooth']=true;
            $s['areaStyle']= new \stdClass();
            //$s['lineStyle']['color']='blue';
            //$s['lineStyle']['width']=3;

            if($bandas_tiempo) {
                $m = new \stdClass();
                $m->symbol = ['none','none'];
                $m->label = new \stdClass();
                $m->label->show = false;
                $x = new \stdClass();
                $x->xAxis=1944-$primer_anio;
                $m->data[]=clone $x;
                $x->xAxis=1959-$primer_anio;
                $m->data[]=clone $x;
                $x->xAxis=1978-$primer_anio;
                $m->data[]=clone $x;
                $x->xAxis=1992-$primer_anio;
                $m->data[]=clone $x;
                $x->xAxis=2003-$primer_anio;
                $m->data[]=clone $x;
                $x->xAxis=2017-$primer_anio;
                $m->data[]=clone $x;
                $s['markLine']=$m;
            }
            $g_series[]=$s;
        }
        //dd($g_series);

        // Configurar grafica
        $grafico=array();
        if(isset($datos->titulo)) {
            $grafico['title']['text']=$datos->titulo;
        }
        if(isset($datos->sub_titulo)) {
            $grafico['title']['subtext']=$datos->sub_titulo;
        }


        $a_categoria = array();
        foreach($datos->categorias as $id_cat=>$categoria) {
            $a_categoria[]=$categoria;
        }


        $grafico['tooltip']['trigger']= "axis";
        $grafico['tooltip']['axisPointer']['type']= "shadow";

        if($otro_estilo) {
            $grafico['color']=['#ca8622','#ffff00', '#ff0000', '#000000', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
            $grafico['backgroundColor']='#aaaaaa';
        }

        //Eje X
        $grafico['xAxis']['data']=$a_categoria;
        $grafico['xAxis']['type']='category';
        $grafico['xAxis']['boundaryGap']=false;
        $grafico['xAxis']['axisPointer']['type']='shadow';

        //Eje Y
        $grafico['yAxis'][0]['type']="value";
        $grafico['yAxis'][0]['name']= isset($datos->yAxis) ? $datos->yAxis : "Entrevistas";
        $grafico['yAxis'][0]['axisTick']['show']=false;
        $grafico['yAxis'][0]['splitLine']['show']=false;
        //$grafico['yAxis'][0]['boundaryGap']= [0, '10%'];



        //Leyenda
        $grafico['legend']['orient']="horizontal";
        //$grafico['legend']['bottom']=0;
        $grafico['legend']['left']='center';
        $grafico['legend']['show']=true;



        //Asignacion de datos
        $grafico['series']=$g_series;

        //PAra que no quede amontonado, esto define el espacio del gráfico como tal
        $grafico['grid']['left']='10%';
        $grafico['grid']['right']='10%';
        //$grafico['grid']['top']='90';
        //$grafico['grid']['height']='50%';



///////////////// OPCIONAL /////////////////////////////////
//$grafico['legend']['right']='50%';
//$grafico['legend']['data']=array("A","B","C","D");  //Ocultar alguno

//Iconitos superiores
        //$grafico['toolbox']['orient']="vertical";
        //Descargar
        $grafico['toolbox']['feature']['saveAsImage']['title']="Descargar";
        $grafico['toolbox']['feature']['saveAsImage']['name']= isset($datos->descarga) ? $datos->descarga : "entrevistas";
        $grafico['toolbox']['feature']['saveAsImage']['pixelRatio']=2;

//Ver tabla de datos
       $grafico['toolbox']['feature']['dataView']['show']=false;
       $grafico['toolbox']['feature']['dataView']['title']="data";
       $grafico['toolbox']['feature']['dataView']['lang']=['datos', 'atras' , 'refrescar'];
// Marcar para zoom
        $grafico['toolbox']['feature']['dataZoom']['show']=false;
        $grafico['toolbox']['feature']['dataZoom']['title']['zoom']="Zoom";
        $grafico['toolbox']['feature']['dataZoom']['title']['back']="Regresar";
// REsetear
        $grafico['toolbox']['feature']['restore']['show']=false;
        $grafico['toolbox']['feature']['restore']['title']="Reiniciar";
//Cambiar el tipo
        //$grafico['toolbox']['feature']['magicType']['type'] =array('line', 'bar', 'stack', 'tiled');
        //$grafico['toolbox']['feature']['magicType']['title'] =array('line'=>'Línea', 'bar'=>'Barra', 'stack'=>'Apilado', 'tiled'=>'Comparado');

//Zoom

        $grafico['dataZoom'][0]['type']="slider";
        //$grafico['dataZoom'][0]['start']=50;
        //$grafico['dataZoom'][0]['end']=100;

        $grafico['dataZoom'][1]['type']="inside";
        //$grafico['dataZoom'][1]['start']=50;
        //$grafico['dataZoom'][1]['end']=100;

        if($bandas_tiempo) {  //visualMap
            $v= new \stdClass();
            $v->type='piecewise';
            $v->show=false;
            $v->dimension=0;
            $v->seriesIndex=0;
            $b = new \stdClass();
            $b->color = 'rgba(0, 180, 0, 0.5)';
            $b->gt = 1944-$primer_anio;
            $b->lt = 1959-$primer_anio;
            $v->pieces[]=clone $b;
            $b->gt = 1978-$primer_anio;
            $b->lt = 1992-$primer_anio;
            $v->pieces[]=clone $b;
            $b->gt = 2003-$primer_anio;
            $b->lt = 2017-$primer_anio;
            $v->pieces[]=clone $b;
            //$grafico['visualMap']=$v;

        }

        //dd($grafico);


        $json_grafico=json_encode($grafico);
        return $json_grafico;
    }

    public static function g_area_doble_eje($datos) {

        //Barras a graficar
        $g_series=array();


        foreach($datos->a_serie as $id_serie=>$serie) {

            $val=array();
            foreach($datos->categorias as $id_cat=>$categoria) {
                $punto = new \stdClass();
                $punto->name=$id_cat;
                $punto->value=$datos->a_serie[$id_serie][$id_cat];
                $val[]=$punto;
            }
            $s['name']=$datos->nombre_serie[$id_serie];
            $tipo = isset($datos->tipo_serie[$id_serie]) ? $datos->tipo_serie[$id_serie] : 'line';
            if($tipo == 'line') {
                $s['yAxisIndex']=1;
            }
            else {
                $s['yAxisIndex']=0;
            }
            $s['type']=$tipo;
            $s['data']=$val;
            $s['smooth']=true;
            $s['areaStyle']= new \stdClass();
            $g_series[]=$s;
        }
        //dd($g_series);

        // Configurar grafica
        $grafico=array();
        if(isset($datos->titulo)) {
            $grafico['title']['text']=$datos->titulo;
        }
        if(isset($datos->sub_titulo)) {
            $grafico['title']['subtext']=$datos->sub_titulo;
        }


        $a_categoria = array();
        foreach($datos->categorias as $id_cat=>$categoria) {
            $a_categoria[]=$categoria;
        }


        $grafico['tooltip']['trigger']= "axis";
        $grafico['tooltip']['axisPointer']['type']= "cross";
        $grafico['tooltip']['axisPointer']['animation']= false;
        $grafico['tooltip']['axisPointer']['label']['backgroundColor']= '#505765';


        //$grafico['tooltip']['axisPointer']['type']= "shadow";


        //$grafico['color']=['#00ff00','#ffff00', '#ff0000', '#000000', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
        $grafico['backgroundColor']='#ffffff';
        //Eje X
        $grafico['xAxis']['data']=$a_categoria;
        $grafico['xAxis']['type']='category';
        $grafico['xAxis']['axisPointer']['type']='shadow';

        //Eje Y
        $grafico['yAxis'][0]['type']="value";
        $grafico['yAxis'][0]['name']="Entrevistas diarias";
        $grafico['yAxis'][0]['axisTick']['show']=false;
        $grafico['yAxis'][0]['splitLine']['show']=false;

        $grafico['yAxis'][1]['type']="value";
        $grafico['yAxis'][1]['name']="Entrevistas acumuladas";
        $grafico['yAxis'][1]['axisTick']['show']=false;
        $grafico['yAxis'][1]['splitLine']['show']=false;


        //Leyenda
        $grafico['legend']['orient']="horizontal";
        //$grafico['legend']['bottom']=0;
        $grafico['legend']['left']='center';
        $grafico['legend']['show']=true;

        //Asignacion de datos
        $grafico['series']=$g_series;

        //PAra que no quede amontonado, esto define el espacio del gráfico como tal
        $grafico['grid']['left']='10%';
        $grafico['grid']['right']='10%';
        //$grafico['grid']['top']='90';
        //$grafico['grid']['height']='50%';



///////////////// OPCIONAL /////////////////////////////////
//$grafico['legend']['right']='50%';
//$grafico['legend']['data']=array("A","B","C","D");  //Ocultar alguno

//Iconitos superiores
        //$grafico['toolbox']['orient']="vertical";
        //Descargar
        $grafico['toolbox']['feature']['saveAsImage']['title']="Descargar";
        $grafico['toolbox']['feature']['saveAsImage']['name']= isset($datos->descarga) ? $datos->descarga : "entrevistas";
        $grafico['toolbox']['feature']['saveAsImage']['pixelRatio']=2;

//Ver tabla de datos
        $grafico['toolbox']['feature']['dataView']['show']=false;
        $grafico['toolbox']['feature']['dataView']['title']="data";
        $grafico['toolbox']['feature']['dataView']['lang']=['datos', 'atras' , 'refrescar'];
// Marcar para zoom
        $grafico['toolbox']['feature']['dataZoom']['show']=false;
        $grafico['toolbox']['feature']['dataZoom']['title']['zoom']="Zoom";
        $grafico['toolbox']['feature']['dataZoom']['title']['back']="Regresar";
// REsetear
        $grafico['toolbox']['feature']['restore']['show']=false;
        $grafico['toolbox']['feature']['restore']['title']="Reiniciar";
//Cambiar el tipo
        //$grafico['toolbox']['feature']['magicType']['type'] =array('line', 'bar', 'stack', 'tiled');
        //$grafico['toolbox']['feature']['magicType']['title'] =array('line'=>'Línea', 'bar'=>'Barra', 'stack'=>'Apilado', 'tiled'=>'Comparado');

//Zoom

        $grafico['dataZoom'][0]['type']="slider";
        //$grafico['dataZoom'][0]['start']=50;
        //$grafico['dataZoom'][0]['end']=100;

        $grafico['dataZoom'][1]['type']="inside";
        //$grafico['dataZoom'][1]['start']=50;
        //$grafico['dataZoom'][1]['end']=100;



        $json_grafico=json_encode($grafico);
        return $json_grafico;
    }


    public static function g_columna($datos) {

        //Barras a graficar
        $g_series=array();

        $largo_etiquetas=0;




        foreach($datos->a_serie as $id_serie=>$serie) {
            $val=array();
            foreach($datos->categorias as $id_cat=>$categoria) {
                $punto = new \stdClass();
                $punto->name=$id_cat;
                $punto->value=$datos->a_serie[$id_serie][$id_cat];
                $val[]=$punto;
                //Para definir el height del grid
                if(strlen($categoria)>$largo_etiquetas) {
                    $largo_etiquetas=strlen($categoria);
                }
            }
            $s['name']=$datos->nombre_serie[$id_serie];

            $s['type']='bar';
            $s['data']=$val;
            $s['smooth']=true;
            $s['areaStyle']= new \stdClass();
            $g_series[]=$s;
        }

        // Configurar grafica
        $grafico=array();
        if(isset($datos->titulo)) {
            $grafico['title']['text']=$datos->titulo;
        }
        if(isset($datos->sub_titulo)) {
            $grafico['title']['subtext']=$datos->sub_titulo;
        }


        $a_categoria = array();
        foreach($datos->categorias as $id_cat=>$categoria) {
            $a_categoria[]=$categoria;
        }


        $grafico['tooltip']['trigger']= "axis";
        $grafico['tooltip']['axisPointer']['type']= "shadow";


        //$grafico['color']=['#00ff00','#ffff00', '#ff0000', '#000000', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
        $grafico['backgroundColor']='#ffffff';
        //Eje X
        $grafico['xAxis']['data']=$a_categoria;
        $grafico['xAxis']['type']='category';
        $grafico['xAxis']['axisPointer']['type']='shadow';
        $grafico['xAxis']['axisLabel']['overflow'] = 'truncate';
        //$grafico['yAxis'][0]['name']="Ejecito";
        if($largo_etiquetas > 15) {
            $grafico['xAxis']['axisLabel']['rotate'] = 35;
            $grafico['xAxis']['axisLabel']['fontSize'] = 10;
        }
        //Eje Y
        $grafico['yAxis'][0]['type']="value";
        $grafico['yAxis'][0]['name']=isset($datos->yAxis) ? $datos->yAxis : $datos->nombre_serie[0];
        $grafico['yAxis'][0]['axisTick']['show']=false;
        $grafico['yAxis'][0]['splitLine']['show']=false;


        //Leyenda
        $grafico['legend']['orient']="horizontal";
        //$grafico['legend']['bottom']=0;
        $grafico['legend']['left']='center';
        $grafico['legend']['show']=false;

        //Asignacion de datos
        $grafico['series']=$g_series;


        //Descargar
        $grafico['toolbox']['feature']['saveAsImage']['title']="Descargar";
        $grafico['toolbox']['feature']['saveAsImage']['name']= isset($datos->descarga) ? $datos->descarga : "entrevistas";
        $grafico['toolbox']['feature']['saveAsImage']['pixelRatio']=2;



        //$grafico['dataZoom'][0]['type']="slider";
        //$grafico['dataZoom'][0]['start']=50;
        //$grafico['dataZoom'][0]['end']=100;

        //$grafico['dataZoom'][1]['type']="inside";
        //$grafico['dataZoom'][1]['start']=50;
        //$grafico['dataZoom'][1]['end']=100;


        //$grafico['grid']['top']='10';
        if($largo_etiquetas > 15) {
            $grafico['grid']['height']='40%';
        }



        $json_grafico=json_encode($grafico);
        return $json_grafico;
    }

    /*
     * Apilada.  espera una estructura como la siguiente:
        $respuesta->a_barra = $a_macro;  //Cada barra
        $respuesta->a_series = $a_entrevistas;  //Cada colorcito
        $respuesta->a_datos = $datos;  // datos[barra][color] = val
        $respuesta->descarga="por_macro";
     */
    public static function g_columna_stack($datos) {

        //Barras a graficar
        $g_series=array();

        $largo_etiquetas=0;

        foreach($datos->a_series as $id_serie => $txt_serie) {
            $val = array();
            foreach($datos->a_barra as $id_barra => $txt_barra) {
                $valor = isset($datos->a_datos[$id_barra][$id_serie]) ? $datos->a_datos[$id_barra][$id_serie] : 0 ;
                $punto = new \stdClass();
                $punto->name=$id_serie;
                $punto->value=$valor;
                $val[]=$punto;
                //Para definir el height del grid
                if(strlen($txt_serie)>$largo_etiquetas) {
                    $largo_etiquetas=strlen($txt_serie);
                }
            }
            $s['name']=$txt_serie;
            $s['stack']='macro';
            $s['type']='bar';
            $s['data']=$val;
            $s['smooth']=true;
            $s['areaStyle']= new \stdClass();
            $g_series[]=$s;
        }
        /*


        foreach($datos->a_serie as $id_serie=>$serie) {
            $val=array();
            foreach($datos->categorias as $id_cat=>$categoria) {
                $punto = new \stdClass();
                $punto->name=$id_cat;
                $punto->value=$datos->a_serie[$id_serie][$id_cat];
                $val[]=$punto;
                //Para definir el height del grid
                if(strlen($categoria)>$largo_etiquetas) {
                    $largo_etiquetas=strlen($categoria);
                }
            }
            $s['name']=$datos->nombre_serie[$id_serie];
            $s['type']='bar';
            $s['data']=$val;
            $s['smooth']=true;
            $s['areaStyle']= new \stdClass();
            $g_series[]=$s;
        }
        */

        // Configurar grafica
        $grafico=array();
        if(isset($datos->titulo)) {
            $grafico['title']['text']=$datos->titulo;
        }
        if(isset($datos->sub_titulo)) {
            $grafico['title']['subtext']=$datos->sub_titulo;
        }


        $a_categoria = array();
        foreach($datos->a_barra as $id_cat=>$categoria) {
            $a_categoria[]=$categoria;
        }


        $grafico['tooltip']['trigger']= "axis";
        $grafico['tooltip']['axisPointer']['type']= "shadow";


        //$grafico['color']=['#00ff00','#ffff00', '#ff0000', '#000000', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
        $grafico['backgroundColor']='#ffffff';
        //Eje X
        $grafico['xAxis']['data']=$a_categoria;
        $grafico['xAxis']['type']='category';
        $grafico['xAxis']['axisPointer']['type']='shadow';
        $grafico['yAxis'][0]['name']="Ejecito";
        if($largo_etiquetas > 15) {
            $grafico['xAxis']['axisLabel']['rotate'] = 45;
        }
        //Eje Y
        $grafico['yAxis'][0]['type']="value";
        $grafico['yAxis'][0]['name']="Entrevistas";
        $grafico['yAxis'][0]['axisTick']['show']=false;
        $grafico['yAxis'][0]['splitLine']['show']=false;


        //Leyenda
        $grafico['legend']['orient']="horizontal";
        //$grafico['legend']['bottom']=0;
        $grafico['legend']['left']='center';
        $grafico['legend']['show']=false;

        //Asignacion de datos
        $grafico['series']=$g_series;


        //Descargar
        $grafico['toolbox']['feature']['saveAsImage']['title']="Descargar";
        $grafico['toolbox']['feature']['saveAsImage']['name']= isset($datos->descarga) ? $datos->descarga : "entrevistas";
        $grafico['toolbox']['feature']['saveAsImage']['pixelRatio']=2;



        $grafico['dataZoom'][0]['type']="slider";
        //$grafico['dataZoom'][0]['start']=50;
        //$grafico['dataZoom'][0]['end']=100;

        $grafico['dataZoom'][1]['type']="inside";
        //$grafico['dataZoom'][1]['start']=50;
        //$grafico['dataZoom'][1]['end']=100;


        //$grafico['grid']['top']='10';
        if($largo_etiquetas > 15) {
            $grafico['grid']['height']='40%';
        }



        $json_grafico=json_encode($grafico);
        return $json_grafico;
    }

    public static function g_barra($datos) {

        //Barras a graficar
        $g_series=array();
        $largo_etiquetas=0;


        foreach($datos->a_serie as $id_serie=>$serie) {
            $val=array();
            foreach($datos->categorias as $id_cat=>$categoria) {
                if(strlen($categoria)>$largo_etiquetas) {
                    $largo_etiquetas=strlen($categoria);
                }
                //$val[]=$datos->a_serie[$id_serie][$id_cat];
                $punto = new \stdClass();
                $punto->name=$id_cat;
                $punto->value=$datos->a_serie[$id_serie][$id_cat];
                $val[]=$punto;
            }
            $s['name']=$datos->nombre_serie[$id_serie];
            $s['type']='bar';
            $s['data']=$val;
            $s['smooth']=true;
            $s['areaStyle']= new \stdClass();
            $g_series[]=$s;
        }

        // Configurar grafica
        $grafico=array();
        if(isset($datos->titulo)) {
            $grafico['title']['text']=$datos->titulo;
        }
        if(isset($datos->sub_titulo)) {
            $grafico['title']['subtext']=$datos->sub_titulo;
        }


        $a_categoria = array();
        foreach($datos->categorias as $id_cat=>$categoria) {
            $a_categoria[]=$categoria;
        }


        $grafico['tooltip']['trigger']= "axis";
        $grafico['tooltip']['axisPointer']['type']= "shadow";
        //$grafico['tooltip']['formatter']= "{a} <br/>{b}: {c} ";

        $grafico['grid']['left']='200px';
        $grafico['grid']['right']='100px';


        //$grafico['color']=['#00ff00','#ffff00', '#ff0000', '#000000', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
        $grafico['backgroundColor']='#ffffff';
        //Eje X
        $grafico['yAxis']['data']=$a_categoria;
        $grafico['yAxis']['type']='category';
        $grafico['yAxis']['axisPointer']['type']='shadow';
        //Eje Y
        $grafico['xAxis'][0]['type']="value";
        //$grafico['xAxis'][0]['name']="Entrevistas";
        $grafico['xAxis'][0]['axisTick']['show']=false;
        $grafico['xAxis'][0]['splitLine']['show']=false;
        $grafico['yAxis']['axisLabel']['overflow'] = 'truncate';
        if($largo_etiquetas > 15) {
            $grafico['yAxis']['axisLabel']['fontSize'] = 10;

        }
        if($largo_etiquetas > 25) {
            $grafico['yAxis']['axisLabel']['fontSize'] = 9;

        }


        //Leyenda
        $grafico['legend']['orient']="horizontal";
        //$grafico['legend']['bottom']=0;
        $grafico['legend']['left']='center';
        $grafico['legend']['show']=false;

        //Descargar
        $grafico['toolbox']['feature']['saveAsImage']['title']="Descargar";
        $grafico['toolbox']['feature']['saveAsImage']['name']= isset($datos->descarga) ? $datos->descarga : "entrevistas";
        $grafico['toolbox']['feature']['saveAsImage']['pixelRatio']=2;

        //Asignacion de datos
        $grafico['series']=$g_series;

        $json_grafico=json_encode($grafico);
        return $json_grafico;
    }

    public static function g_pie($datos) {

        //Barras a graficar
        $g_series=array();

        $label = new \stdClass();
        $label->normal = new \stdClass();
        $label->normal->show = false;
        $label->normal->position = 'center';
        $label->emphasis = new \stdClass();
        $label->emphasis->show = true;
        $label->emphasis->textStyle = new \stdClass();
        $label->emphasis->textStyle->fontSize='20';
        $label->emphasis->textStyle->fontWeight='bold';
        $label->emphasis->formatter="{b}: {c} ";


        foreach($datos->a_serie as $id_serie=>$serie) {
            $val=array();
            foreach($datos->categorias as $id_cat=>$categoria) {
                if(isset($datos->a_serie[$id_serie][$id_cat])) {
                    $t = new \stdClass();
                    $t->value = $datos->a_serie[$id_serie][$id_cat];
                    $t->name = $categoria;
                    $val[]=$t;
                }
            }
            $s['name']=$datos->nombre_serie[$id_serie];
            $s['type']='pie';
            $s['radius']=['50%', '70%'];
            $s['data']=$val;
            $s['label'] = $label;

            $g_series[]=$s;
        }

        // Configurar grafica
        $grafico=array();
        if(isset($datos->titulo)) {
            $grafico['title']['text']=$datos->titulo;
        }
        if(isset($datos->sub_titulo)) {
            $grafico['title']['subtext']=$datos->sub_titulo;
        }


        $a_categoria = array();
        foreach($datos->categorias as $id_cat=>$categoria) {
            $a_categoria[]=$categoria;
        }


        $grafico['tooltip']['trigger']= "item";
        $grafico['tooltip']['formatter']= "{a} <br/>{b}: {c} ({d}%)";

        //Leyenda
        $grafico['legend']['orient']="vertical";
        $grafico['legend']['x']='left';
        $grafico['legend']['data']=$a_categoria;

        //Descargar
        $grafico['toolbox']['feature']['saveAsImage']['title']="Descargar";
        $grafico['toolbox']['feature']['saveAsImage']['name']= isset($datos->descarga) ? $datos->descarga : "entrevistas";
        $grafico['toolbox']['feature']['saveAsImage']['pixelRatio']=2;


        //$grafico['color']=['#00ff00','#ffff00', '#ff0000', '#000000', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
        $grafico['backgroundColor']='#ffffff';


        //Asignacion de datos
        $grafico['series']=$g_series;

        $json_grafico=json_encode($grafico);
        return $json_grafico;
    }
}
