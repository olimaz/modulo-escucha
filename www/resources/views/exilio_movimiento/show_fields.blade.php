
<div class="col-sm-6">
    <div class="box box-solid box-info">
        <div class="box-header">
            <h3 class="box-title">
                Salida
            </h3>
        </div>
        <div class="box-body">
            <div class="col-sm-6">
                {!! Form::label('fecha_salida', 'Fecha de salida:') !!}
                <p> {{ $salida->fmt_fecha_salida }}</p>
            </div>
            <div class="col-sm-6">
                {!! Form::label('lugar_salida', 'Lugar de salida:') !!}
                <p> {{ $salida->fmt_id_lugar_salida }}</p>
            </div>
            <div class="col-sm-6">
                {!! Form::label('acompanamiento', 'Acompañamiento en la salida:') !!}
                <ul>
                    @foreach($salida->arreglo_proteccion(218,1) as $id)
                        <li>{{ \App\Models\cat_item::describir($id) }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</div>
<div class="col-sm-6">
    <div class="box box-solid box-info">
        <div class="box-header">
            <h3 class="box-title">
                Llegada
            </h3>
        </div>
        <div class="box-body">
            <div class="col-sm-6">
                {!! Form::label('fecha_llegada', 'Fecha de llegada:') !!}
                <p> {{ $salida->fmt_fecha_llegada }}</p>
            </div>

            <div class="col-sm-6">
                {!! Form::label('lugar_llegada', 'Lugar de llegada inicial:') !!}
                <p> {{ $salida->fmt_lugar_llegada }}</p>
            </div>
            <div class="col-sm-6">
                {!! Form::label('fecha_asentamiento', 'Fecha de llegada al lugar de asentamiento:') !!}
                <p> {{ $salida->fmt_fecha_asentamiento }}</p>
            </div>
            <div class="col-sm-6">
                {!! Form::label('lugar_salida', 'Lugar de asentamiento posterior:') !!}
                <p> {{ $salida->fmt_lugar_llegada }}</p>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>






<div class="col-sm-6">
    <label>Modalidad:</label>
    <p>{{ $salida->fmt_id_modalidad }}</p>
</div>
<div class="col-sm-6">
    <label>Personas que salieron</label>
    <table class="table table-condensed">
        <tr>
            <td>Personas que salieron</td>
            <td>{{ $salida->cant_personas_salieron }}</td>
        </tr>
        <tr>
            <td>Personas del núcleo familiar que salieron</td>
            <td>{{ $salida->cant_personas_familia_salieron }}</td>
        </tr>
        <tr>
            <td>Personas del núcleo familiar que se quedaron</td>
            <td>{{ $salida->cant_personas_familia_quedaron }}</td>
        </tr>
    </table>
</div>


@if($salida->id_tipo_movimiento == 2)
    <div class="col-sm-6">
        <label>¿Ha solicitado estatus de protección internacional o del país de acogida?</label>
        <p>{{ $salida->fmt_id_solicitado_proteccion }}</p>
    </div>

    <div class="col-sm-6">
        <label>Estado de la solicitud</label>
        <p>{{ $salida->fmt_id_estado_proteccion }}</p>
    </div>

    <div class="col-sm-6">
        <label>¿Ha solicitado estatus de protección internacional o del país de acogida?</label>
        <p>{{ $salida->fmt_id_solicitado_proteccion }}</p>
    </div>

    <div class="col-sm-6">
        <label>Si aprobada, por:</label>
        <p>{{ $salida->fmt_id_aprobada_proteccion }}</p>
    </div>
    <div class="col-sm-6">
        <label>Si denegada, ¿en qué condición se encuentra?:</label>
        <p>{{ $salida->fmt_id_denegada_proteccion }}</p>
    </div>
    <div class="clearfix"></div>

    <div class="col-sm-6">
        <label>¿Ha obtenido residencia en el país de acogida?</label>
        <p>{{ $salida->fmt_id_residencia_proteccion }}</p>
    </div>
    <div class="col-sm-6">
        <label>¿Ha sufrido un proceso de expulsión, deportación y/o devolución?</label>
        <p>{{ $salida->fmt_id_expulsion }}</p>
    </div>
@else
    {{-- RETORNO --}}
    <div class="col-sm-6">
        <label>Impactos del retorno</label>
        <ul>
            @foreach($exilio->arreglo_impacto(214) as $id)
                <li>{{ \App\Models\cat_item::describir($id) }}</li>
            @endforeach
        </ul>
    </div>
    <div class="col-sm-6">
        <label>Afrontamientos en el retorno</label>
        <ul>
            @foreach($exilio->arreglo_impacto(215) as $id)
                <li>{{ \App\Models\cat_item::describir($id) }}</li>
            @endforeach
        </ul>
    </div>

    <div class="col-sm-6">
        <label>Una vez retornado ¿Tuvo ayuda de alguna institución colombiana? </label>
        <p>{{ $exilio->fmt_id_ha_tenido_ayuda }}
            @if(strlen($exilio->institucion_ayuda)>0)
                : {{ $exilio->institucion_ayuda }}
            @endif
        </p>
    </div>

    <div class="col-sm-6">
        <label>Ayuda recibida</label>
        <ul>
            @foreach($exilio->arreglo_impacto(216) as $id)
                <li>{{ \App\Models\cat_item::describir($id) }}</li>
            @endforeach
        </ul>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-12">
        <label>Después del retorno ¿Volvió a exiliarse?</label>
        <p>{{ $exilio->fmt_id_otro_exilio }}</p>
    </div>

@endif