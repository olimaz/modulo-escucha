@php
    $id_nivel = \Auth::user()->id_nivel;
@endphp
<div class="box box-info box-solid">
    <div class="box-header">
        <h3 class="box-title">
            Archivos adjuntos a la entrevista {{ $expediente->entrevista_codigo }} - LEGADO
        </h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_ret"><i
                        class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body table-responsive">

        <table class="table table-bordered table-condensed table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tipo</th>
                    <th>Enlace</th>
                    <th>Calificación de acceso</th>
                    <th>Justificación</th>
                </tr>
            </thead>
            <tbody>
            @foreach($expediente->adjuntos as $i=>$adjunto)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{!! $adjunto['tipo'] !!}</td>
                    <td>
                        @if(!$adjunto['adjunto']->existe)
                            (Archivo no disponible)
                        @else
                            @can('permiso-acceso',$adjunto['adjunto'])

                                @if(strlen($adjunto['url_stream'])>0)
                                    <audio controls controlsList="nodownload">
                                        <source src="{!! $adjunto['url_stream'] !!}" type="audio/mpeg">
                                        Su navegador no permite transmitir audio.
                                    </audio>
                                    @can('nivel-1')
                                        <br>{!! $adjunto['url'] !!}
                                    @endcan
                                @else
                                        {!! $adjunto['url'] !!}
                                @endif
                            @else
                                Acceso denegado por insuficientes privilegios
                            @endcan
                        @endif
                    </td>
                    {{-- Calificación de acceso --}}
                    <td>
                        {{ $adjunto['adjunto']->fmt_id_calificacion }}
                    </td>
                    <td class="text-center">
                        {!! $adjunto['adjunto']->ico_justificacion() !!}

                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>

    </div>
</div>
