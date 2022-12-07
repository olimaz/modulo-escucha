<div class="row">
    @php($i=0)
    @foreach($datos->violencia->impactos['ctx'] as $id => $info)

        <div class="col-sm-6">
            @include("fichas.stats.p_tabla",
                                    ['info_titulo' => $info->descripcion
                                       , 'info_tabla' => $info
                                       , 'tabla_nombre' => 'ctx_'.$id
                                       , 'tabla_pie' => 'Respuestas recolectadas en un total de '.$datos->violencia->total_hechos.' hechos de violencia'
                                        ]
                               )

        </div>

        @if(++$i%2 == 0 )
            <div class="w-100"></div>
        @endif

    @endforeach

</div>


