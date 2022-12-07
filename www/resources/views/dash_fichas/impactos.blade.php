
<h3>Impactos individuales de los hechos</h3>
@php($i=0)
@foreach($datos->violencia->impactos['ind'] as $id => $info)

    <div class="col-sm-6">
        @include("dash_fichas.p_tabla",
                                ['info_titulo' => $info->descripcion
                                   , 'info_tabla' => $info
                                   , 'tabla_nombre' => 'imp_ind_'.$id
                                    ]
                           )

    </div>

    @if(++$i%2 == 0 )
        <div class="clearfix"></div>
    @endif

@endforeach

<div class="clearfix"></div>
<h3>Impactos colectivos de los hechos</h3>
@php($i=0)
@foreach($datos->violencia->impactos['col'] as $id => $info)
    <div class="col-sm-6">
        @include("dash_fichas.p_tabla",
                                ['info_titulo' => $info->descripcion
                                   , 'info_tabla' => $info
                                   , 'tabla_nombre' => 'imp_col_'.$id
                                    ]
                           )

    </div>
    @if(++$i%2 == 0 )
        <div class="clearfix"></div>
    @endif
@endforeach


<div class="clearfix"></div>
<h3>Afrontamientos</h3>
@php($i=0)
@foreach($datos->violencia->impactos['afr'] as $id => $info)
    <div class="col-sm-6">
        @include("dash_fichas.p_tabla",
                                ['info_titulo' => $info->descripcion
                                   , 'info_tabla' => $info
                                   , 'tabla_nombre' => 'imp_afr_'.$id
                                    ]
                           )

    </div>
    @if(++$i%2 == 0 )
        <div class="clearfix"></div>
    @endif
@endforeach


<div class="clearfix"></div>
<h3>Acceso a la justicia</h3>
<h4>Instituciones estatales</h4>
@php($i=0)
@foreach($datos->violencia->impactos['aj'][1] as $id => $info)
    <div class="col-sm-6">
        @include("dash_fichas.p_tabla",
                                ['info_titulo' => $info->descripcion
                                   , 'info_tabla' => $info
                                   , 'tabla_nombre' => 'imp_aj_1_ins'
                                    ]
                           )

    </div>
    @if(++$i%2 == 0 )
        <div class="clearfix"></div>
    @endif
@endforeach

<div class="clearfix"></div>
<h4>Instituciones comunitarias</h4>
@php($i=0)
@foreach($datos->violencia->impactos['aj'][2] as $id => $info)
    <div class="col-sm-6">
        @include("dash_fichas.p_tabla",
                                ['info_titulo' => $info->descripcion
                                   , 'info_tabla' => $info
                                   , 'tabla_nombre' => 'imp_aj_1_ins'
                                    ]
                           )

    </div>
    @if(++$i%2 == 0 )
        <div class="clearfix"></div>
    @endif
@endforeach
<div class="clearfix"></div>
<h4>Instituciones internacionales</h4>
@php($i=0)
@foreach($datos->violencia->impactos['aj'][3] as $id => $info)
    <div class="col-sm-6">
        @include("dash_fichas.p_tabla",
                                ['info_titulo' => $info->descripcion
                                   , 'info_tabla' => $info
                                   , 'tabla_nombre' => 'imp_aj_1_ins'
                                    ]
                           )

    </div>
    @if(++$i%2 == 0 )
        <div class="clearfix"></div>
    @endif
@endforeach



<div class="clearfix"></div>
<h3>Avances en el acceso a la justicia</h3>
@php($i=0)
@foreach($datos->violencia->impactos['av'] as $id => $info)
    <div class="col-sm-6">
        @include("dash_fichas.p_tabla",
                                ['info_titulo' => $info->descripcion
                                   , 'info_tabla' => $info
                                   , 'tabla_nombre' => 'imp_av_'.$id
                                    ]
                           )

    </div>
    @if(++$i%2 == 0 )
        <div class="clearfix"></div>
    @endif
@endforeach