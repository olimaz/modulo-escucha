<div class="clearfix"></div>
<div class="col-xs-12">
    <div class="box {{ $conteos->color_exilio_box  }}  {{ $conteos->exilio_collapsed ? ' collapsed-box ' : '' }}">
        <div class="box-header">
            <h3 class="box-title">
                <i class="fa fa-globe"></i> 2a. Información del exilio  (opcional)
            </h3>
            @if($conteos->exilio_collapsed)
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
            @else
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            @endif
        </div>
        <div class="box-body">

        @if($conteos->exilio  > 0)
            @php($exilios = \App\Models\exilio::where('id_e_ind_fvt',$expediente->id_e_ind_fvt)->selectraw(\DB::raw('exilio.*'))->ordenado()->get())
            @include("exilios.table")
        @else

                <div class="text-yellow text-center">
                    <h4><i class="icon fa fa-warning"></i> Atención</h4>
                    No se ha ingresado información de exilio
                </div>

        @endif
        </div>
        @if(isset($no_editar))
        @else
            <div class="box-footer text-center">
                <a href="{{ action('exilioController@create') }}?id_e_ind_fvt={{$expediente->id_e_ind_fvt}}" class="btn btn-success"><i class="fa fa-sitemap"></i> Agregar información de exilio</a>
            </div>
        @endif
    </div>
</div>
<div class="clearfix"></div>