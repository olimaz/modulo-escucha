
@php($i=0)
@foreach($datos->violencia->impactos['ctx'] as $id => $info)

    <div class="col-sm-6">
        @include("dash_fichas.p_tabla",
                                ['info_titulo' => $info->descripcion
                                   , 'info_tabla' => $info
                                   , 'tabla_nombre' => 'ctx_'.$id
                                    ]
                           )

    </div>

    @if(++$i%2 == 0 )
        <div class="clearfix"></div>
    @endif

@endforeach


