{{--  PARTIAL para agregarselo a la vista de victima --}}
@if(isset($id_hecho) && isset($id_persona))
    @php($este_hecho=\App\Models\hecho::find($id_hecho))
    @if(is_object($este_hecho))
        @php($esta_victima = $este_hecho->datos_victima($id_persona))
        @if(is_object($esta_victima))
            <div class="box box-info box-solid">
                <div class="box-header">
                    <h3 class="box-title">
                        <i class="fa fa-bolt"></i> Información de los hechos de violencia.
                    </h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-6">
                        <label>Fecha de ocurrencia</label>
                        <p>{{ $este_hecho->fmt_fecha_ocurrencia }}</p>

                        <label>Lugar de los hechos</label>
                        <p>{{ $este_hecho->fmt_id_lugar }}</p>

                        <label>Violencia:</label>
                        {!!   $este_hecho->fmt_violencia !!}
                    </div>

                    <div class="col-sm-6">
                        <label>Ocupación en el momento de los hechos</label>
                        <p>{{ $esta_victima->fmt_id_ocupacion }}</p>

                        <label>Edad en el momento de los hechos</label>
                        <p>{{ $esta_victima->fmt_edad }}</p>

                        <label>Lugar de residencia en el momento de los hechos</label>
                        <p>{{ $esta_victima->fmt_id_lugar_residencia }}</p>

                        <a href="{{ action('hechoController@show',$id_hecho) }}" class="btn btn-info btn-xs">Mayor información</a>
                    </div>
                </div>
            </div>
        @endif
    @endif
@else
    {{--
        <div class="box box-warning box-solid">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-bolt"></i> Información de los hechos.
                </h3>
            </div>
            <div class="box-body">
                <div class="text-yellow text-center">
                    <h4><i class="icon fa fa-warning"></i> Atención</h4>
                    No se ha completado la información de los hechos
                </div>
            </div>
        </div>
    --}}

@endif
