{{--

Carga de archivos.  Genera un control hidden con el nombre del archivo.
En el front end, utiliar dicho nombre para actualizar la BD
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_texto: Etiqueta a desplegar
$control_default: valor pre-seleccionado (para los edit)
$control_collapse: muestra el box contraido

--}}

@php
        //Por si no lo definen
        if(!isset($control_control)) {
            $control_control='file_'+date('is');
        }
        if(!isset($control_texto)) {
            $control_texto=null;
        }
        if(!isset($control_default)) {
            $control_default=null;
        }
        if(!isset($control_collapse)) {
            $control_collapse=false;
        }

@endphp

<!-- Carga de archivo -->
<div  class="box box-solid box-info  {{ $control_collapse ? "collapsed-box" : "" }}">
    <div class="box-header">
        <h3 class="box-title">{!! $control_texto !!}</h3>
            @if($control_collapse)
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
            @endif
    </div>
    <div class="box-body">
        <div class="col-xs-12 text-center">
            <h3>Carga de archivo</h3>

            <span id="{!! $control_control !!}_casilla">
                @if(!empty($control_default))
                    <i class="fa fa-check-square-o fa-4x text-green" aria-hidden="true"></i>
                @else
                    <i class="fa fa-square-o fa-4x text-red" aria-hidden="true"></i>
                @endif

            </span>
        </div>
        <div class="col-xs-12">
                    <span id="{!! $control_control !!}_url">
                        @if(!empty($control_default))
                            <a href='{{ url("/").$control_default }}' target='_blank'><i class='fa fa-hand-o-right' aria-hidden='true'></i> Verificar archivo</a>
                        @else

                        @endif
                    </span>
        </div>
        <div class="col-xs-12">

                <div class="progress">
                    <div id="{!! $control_control !!}_progreso"  class="progress-bar progress-bar-aqua" style="width: 0%">0%</div>
                </div>

        </div>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-xs-6 text-center">
                <a href="javascript:cargar('{!! $control_control !!}')" class='btn btn-success btn-xs' title="Tamaño máximo: {{ini_get("upload_max_filesize") }}" data-toggle="tooltip" data-placement="bottom">
                    <i class="glyphicon glyphicon-file"></i> Seleccionar
                </a>
            </div>
            <div class="col-xs-6 text-center">
                <a class='btn btn-danger btn-xs' href="javascript:quitar('{!! $control_control !!}')" >
                    <i class="glyphicon glyphicon-trash"></i> Quitar
                </a>
            </div>
        </div>
    </div>
</div>
<input type="file" id="{!! $control_control !!}" name="{!! $control_control !!}" class="carga_automatica" style="display: none"/>
<input type="hidden" name="{!! $control_control !!}_filename" id="{!! $control_control !!}_filename" value='{{ strlen($control_default)>0 ? "/storage".$control_default:"" }}' />

