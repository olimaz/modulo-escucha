

{!!  Form::model($filtros, ['action' =>'statController@buscadora', 'method' => 'get']) !!}
<input type="hidden" name="p" value="3">
<div class="col-sm-12" >

    <div class="col-xs-8">
        @include('controles.tesauro3', ['control_control' => 'id_tesauro'
                                        , 'control_id' => 'id_tesauro_compara'
                                            , 'control_default'=>$filtros->id_tesauro
                                            , 'control_vacio' => '[Mostrar todos]'
                                           ,'control_texto'=>''])


    </div>
    <div class="col-xs-4 text-left" style="padding-top: 22px">
        <button class="btn bg-purple" type="submit" title="Comparar tesauro" data-toggle="tooltip">Comparar <i class="fa fa-search"></i></button>
        <a  class="btn btn-default"  data-toggle="collapse" href="#frm_avanzado_tes_co"  ><i class="fa fa-eyedropper "></i> Opciones avanzadas</a>
    </div>
</div>
<div class="clearfix"></div>
@include("buscador.frm_filtros", ["frm_id"=>"frm_avanzado_tes_co", "ocultar_tes"=>true])
{!! Form::close() !!}

@if($activa==3)
    <div class="clearfix"></div>
    @if($filtros->id_tesauro > 0 )
    {{-- Resultados --}}
    <div class="col-xs-12">
        {{-- Circulitos --}}
        <div class="box collapsed-box">
            <div class="box-header">
                <h3 class="box-title">Gráfica comparativa de la aplicación del árbol de etiquetas</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body text-center">
                @include("reportes.js_tesauro_circulos", ['unidad_conteo'=>'párrafos'])
            </div>
        </div>

        {{-- Tabla de datos --}}
        <div class="box box-primary">
            <div class="box-header">
                <h1 class="box-title">Uso de etiquetas combinadas con la etiqueta base:  <span class="text-primary">{{ \App\Models\tesauro::nombre_completo($filtros->id_tesauro) }}</span></h1>

            </div>
            <div class="box-body table-responsive">
                <table class="table table-condensed table-bordered table-hover" id="tabla-tesauro">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Dominio Temático</th>
                        <th>Categoría</th>
                        <th>Sub categoría</th>
                        <th>Nomenclatura</th>
                        <th>Etiquetas aplicadas</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($filas=1)
                    @php($filas1=1)
                    @php($filas2=1)
                    @php($filas3=1)
                    @foreach($tesauro->n1 as $n1=>$txt1)
                        <tr >
                            <td>{{ $filas++ }}</td>
                            <td class="text-purple">{{ $filas1++ }}. {{$txt1['texto']}}</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>{{$txt1['etiqueta']}}</td>
                            <td class="text-center">
                                @php($link = $filtros->url)
                                @php($link = str_replace("p=3","p=1",$link))
                                @php($link = str_replace("id_tesauro","id_tesauro_2",$link))
                                @php($link.="id_tesauro_3_depto=$n1")
                                @if($txt1['conteo_aplicaciones'] > 0 )
                                    <a href=" {{ Request::url()."?".$link}}">
                                        {{ $txt1['conteo_aplicaciones'] }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @if(isset($tesauro->n2[$n1]))

                            @foreach($tesauro->n2[$n1] as $n2 => $txt2)
                                <tr >
                                    <td>{{ $filas++ }}</td>
                                    <td>&nbsp;</td>
                                    <td  class="text-primary">{{ $filas2++ }}. {{ $txt2['texto'] }}</td>
                                    <td>&nbsp;</td>
                                    <td>{{$txt2['etiqueta']}}</td>
                                    <td class="text-center">
                                        @php($link = $filtros->url)
                                        @php($link = str_replace("p=3","p=1",$link))
                                        @php($link = str_replace("id_tesauro","id_tesauro_2",$link))
                                        @php($link.="id_tesauro_3_depto=$n1&id_tesauro_3_muni=$n2")
                                        @if($txt2['conteo_aplicaciones'] > 0)
                                            <a href=" {{ Request::url()."?".$link}}">
                                                {{ $txt2['conteo_aplicaciones'] }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                @if(isset($tesauro->n3[$n1][$n2]))
                                    @php($filas3=1)
                                    @foreach($tesauro->n3[$n1][$n2] as $n3 => $txt3)
                                        <tr>
                                            <td>{{ $filas++ }}</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>{{ $filas3++ }}. {{ $txt3['texto'] }}</td>
                                            <td>{{$txt3['etiqueta']}}</td>
                                            <td class="text-center">
                                                @php($link = $filtros->url)
                                                @php($link = str_replace("p=3","p=1",$link))
                                                @php($link = str_replace("id_tesauro","id_tesauro_2",$link))
                                                @php($link.="id_tesauro_3_depto=$n1&id_tesauro_3_muni=$n2&id_tesauro_3=$n3")
                                                @if( $txt3['conteo_aplicaciones'] >0 )
                                                    <a href=" {{ Request::url()."?".$link}}">
                                                        {{ $txt3['conteo_aplicaciones'] }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            @endforeach
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>
@endif
@endif
<div class="clearfix"></div>
