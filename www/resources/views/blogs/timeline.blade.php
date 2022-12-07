<div class="col-xs-12  ">
    <ul class="timeline no-padding">
        @php($fecha_anterior='')
        @foreach($listado as $blog)
            @if($fecha_anterior <> $blog->fmt_fecha )
                {{-- Marca de fecha --}}
                <li class="time-label">
                    <span class="bg-red">
                        {{ $blog->fmt_fecha }}
                    </span>
                </li>
                @php($fecha_anterior = $blog->fmt_fecha)

            @endif
            <!-- Entrada del blog -->
            <li>
                <!-- timeline icon -->
                <i class="fa fa-comment bg-blue"></i>
                <div class="timeline-item">
                    <span class="time">
                        <i class="fa fa-user"></i> {{ $blog->fmt_id_entrevistador }}
                        <i class="fa fa-clock-o"></i> {{ $blog->fmt_hora }}
                    </span>

                    <h3 class="timeline-header">{{ $blog->titulo }}</h3>

                    <div class="timeline-body">
                        {!! $blog->html !!}
                    </div>
                    <div class="timeline-footer">
                        @can('sistema-abierto')
                        @if(in_array($misCasos->privilegios,[1,5]))
                            <div class="btn-group pull-right">
                                <a class="btn btn-xs btn-warning btn-flat" href="{{ action('blogController@edit',$blog->id_blog) }}?id_mis_casos={{ $misCasos->id_mis_casos }}"><i class="fa fa-edit"></i> Editar</a>
                                <a class="btn btn-xs btn-danger btn-flat " href="{{ action('blogController@anular',$blog->id_blog) }}?id_mis_casos={{ $misCasos->id_mis_casos }}" onclick="return confirm('¿Esta segura de borrar la nota?')"><i class="fa fa-trash"></i> Borrar</a>
                            </div>
                        @endif
                        @endcan
                        <div class="clearfix"></div>
                    </div>

                </div>
            </li>
            <!-- END timeline item -->


        @endforeach
    </ul>
</div>