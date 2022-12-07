<div class="box box-info box-solid">
    <div class="box-header">
        <h3 class="box-title">
            Archivos adjuntos al caso/informe {{ $casosInformes->codigo }}
        </h3>
    </div>
    <div class="box-body">
        <!-- Archivos adjuntos -->
        <div class="form-group  col-sm-12">

            {!! Form::label('adjuntos', 'Archivos adjuntos:') !!}
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
                @foreach($casosInformes->adjuntos as $i=>$adjunto)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{!! $adjunto['tipo'] !!}</td>
                        <td>
                            @if(!$adjunto['adjunto']->existe)
                                (Archivo no disponible)
                            @else
                                @can('permiso-acceso',$adjunto['adjunto'])

                                    {!! $adjunto['url'] !!}
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
</div>
