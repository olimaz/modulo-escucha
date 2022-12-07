

<div class="card card-primary card-outline ">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user"></i> Impactos individuales de los hechos</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @php($i=0)
            @foreach($datos->violencia->impactos['ind'] as $id => $info)

                <div class="col-sm-6">
                    @include("fichas.stats.p_tabla",
                                            ['info_titulo' => $info->descripcion
                                               , 'info_tabla' => $info
                                               , 'tabla_nombre' => 'imp_ind_'.$id
                                               , 'tabla_pie' => 'Respuestas recolectadas en un total de '.$datos->violencia->total_entrevistas.' entrevistas'
                                                ]
                                       )

                </div>

                @if(++$i%2 == 0 )
                    <div class="w-100"></div>
                @endif

            @endforeach
        </div>
    </div>
</div>



<div class="w-100"></div>

<div class="card card-primary card-outline ">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users"></i> Impactos colectivos de los hechos</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @php($i=0)
            @foreach($datos->violencia->impactos['col'] as $id => $info)
                <div class="col-sm-6">
                    @include("fichas.stats.p_tabla",
                                            ['info_titulo' => $info->descripcion
                                               , 'info_tabla' => $info
                                               , 'tabla_nombre' => 'imp_col_'.$id
                                               , 'tabla_pie' => 'Respuestas recolectadas en un total de '.$datos->violencia->total_entrevistas.' entrevistas'
                                                ]
                                       )

                </div>
                @if(++$i%2 == 0 )
                    <div class="W-100"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>




<div class="w-100"></div>

<div class="card card-primary card-outline ">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-check"></i> Afrontamientos</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">

            @php($i=0)
            @foreach($datos->violencia->impactos['afr'] as $id => $info)
                <div class="col-sm-6">
                    @include("fichas.stats.p_tabla",
                                            ['info_titulo' => $info->descripcion
                                               , 'info_tabla' => $info
                                               , 'tabla_nombre' => 'imp_afr_'.$id
                                               , 'tabla_pie' => 'Respuestas recolectadas en un total de '.$datos->violencia->total_entrevistas.' entrevistas'
                                                ]
                                       )

                </div>
                @if(++$i%2 == 0 )
                    <div class="W-100"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<div class="w-100"></div>

<div class="card card-primary card-outline ">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-balance-scale"></i> Acceso a la justicia: instituciones estatales</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @php($i=0)
            @foreach($datos->violencia->impactos['aj'][1] as $id => $info)
                <div class="col-sm-6">
                    @include("fichas.stats.p_tabla",
                                            ['info_titulo' => $info->descripcion
                                               , 'info_tabla' => $info
                                               , 'tabla_nombre' => 'imp_aj_1_ins'
                                               , 'tabla_pie' => 'Respuestas recolectadas en un total de '.$datos->violencia->total_entrevistas.' entrevistas'
                                                ]
                                       )

                </div>
                @if(++$i%2 == 0 )
                    <div class="w-100"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>




<div class="w-100"></div>

<div class="card card-primary card-outline ">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-balance-scale"></i> Acceso a la justicia: instituciones comunitarias</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @php($i=0)
            @foreach($datos->violencia->impactos['aj'][2] as $id => $info)
                <div class="col-sm-6">
                    @include("fichas.stats.p_tabla",
                                 ['info_titulo' => $info->descripcion
                                    , 'info_tabla' => $info
                                    , 'tabla_nombre' => 'imp_aj_2_ins'
                                    , 'tabla_pie' => 'Respuestas recolectadas en un total de '.$datos->violencia->total_entrevistas.' entrevistas'
                                     ]
                            )

                </div>
                @if(++$i%2 == 0 )
                    <div class="w-100"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>



<div class="w-100"></div>

<div class="card card-primary card-outline ">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-balance-scale"></i> Acceso a la justicia: instituciones internacionales</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @php($i=0)
            @foreach($datos->violencia->impactos['aj'][3] as $id => $info)
                <div class="col-sm-6">
                    @include("fichas.stats.p_tabla",
                                 ['info_titulo' => $info->descripcion
                                    , 'info_tabla' => $info
                                    , 'tabla_nombre' => 'imp_aj_3_ins'
                                    , 'tabla_pie' => 'Respuestas recolectadas en un total de '.$datos->violencia->total_entrevistas.' entrevistas'
                                     ]
                            )

                </div>
                @if(++$i%2 == 0 )
                    <div class="w-100"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>




<div class="w-100"></div>

<div class="card card-primary card-outline ">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-balance-scale"></i> Avances en el acceso a la justicia</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @php($i=0)
            @foreach($datos->violencia->impactos['av'] as $id => $info)
                <div class="col-sm-6">
                    @include("fichas.stats.p_tabla",
                                            ['info_titulo' => $info->descripcion
                                               , 'info_tabla' => $info
                                               , 'tabla_nombre' => 'imp_av_'.$id
                                               , 'tabla_pie' => 'Respuestas recolectadas en un total de '.$datos->violencia->total_entrevistas.' entrevistas'
                                                ]
                                       )

                </div>
                @if(++$i%2 == 0 )
                    <div class="W-100"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>


<div class="w-100"></div>
