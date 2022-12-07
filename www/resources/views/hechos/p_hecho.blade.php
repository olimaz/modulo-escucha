<div class="col-sm-6">
    <label>Fecha de ocurrencia de los hechos</label>
    <p>{!! $hecho->fmt_fecha_ocurrencia !!}
        @if($hecho->fecha_fin_a > 0)
            al {{ $hecho->fmt_fecha_fin }}
        @endif

        @if($hecho->aun_continuan ==1)
            (Los hechos aún continúan)
        @endif
    </p>
</div>

<div class="col-sm-6 ">
    <label>Lugar de ocurrencia de los hechos</label>
    <p>{!! $hecho->fmt_id_lugar !!}</p>
</div>

<div class="col-sm-6">
    <label>Sitio específico</label>
    <p>{!! $hecho->sitio_especifico !!}</p>
</div>
<div class="col-sm-6">
    <label>Zona</label>
    <p>{!! $hecho->fmt_id_lugar_tipo !!}</p>
</div>