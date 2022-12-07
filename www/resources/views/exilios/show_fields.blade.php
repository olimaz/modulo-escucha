
<!-- Id Tipo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('categoria', 'Se reconoce en una o varias de las siguientes categorías:') !!}
    <ul>
        @foreach($exilio->arreglo_fmt_categoria as $txt)
            <li>{{ $txt }}</li>
        @endforeach
    </ul>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('salida', 'Motivos de la salida del país:') !!}
    <ul>
        @foreach($salida->arreglo_fmt_id_motivo as $txt)
            <li>{{ $txt }}</li>
        @endforeach
    </ul>
</div>
<div class="clearfix"></div>

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
                {!! Form::label('lugar_salida', 'Lugar de salida en Colombia:') !!}
                <p> {{ $salida->fmt_id_lugar_salida }}</p>
            </div>
            <div class="col-sm-12">
                {!! Form::label('acompanamiento', 'Acompañamiento:') !!}
                <ul>
                    @foreach($salida->arreglo_fmt_id_acompanamiento as $txt)
                        <li>{{ $txt }}</li>
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
                <p> {{ $salida->fmt_id_lugar_llegada }}</p>
                @if($salida->llegada_ciudad)
                    <p>{{ $salida->llegada_ciudad }}</p>
                @endif
            </div>
            <div class="col-sm-6">
                {!! Form::label('fecha_asentamiento', 'Fecha de llegada al lugar de asentamiento:') !!}
                <p> {{ $salida->fmt_fecha_asentamiento }}</p>
            </div>
            <div class="col-sm-6">
                {!! Form::label('lugar_llegada', 'Lugar de asentamiento posterior:') !!}
                <p> {{ $salida->fmt_id_lugar_llegada_2 }}</p>
                @if($salida->llegada_2_ciudad)
                    <p>{{ $salida->llegada_2_ciudad }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>




<div class="col-sm-6">
    <label>Modalidad de la primera salida del país</label>
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

<div class="col-sm-6">
    <label>¿Ha solicitado estatus de protección internacional o del país de acogida?</label>
    @if(count($salida->arreglo_proteccion(203)) == 0)
        No
    @else
        <ul>
            @foreach($salida->arreglo_proteccion(203) as $id)
                <li>{{ \App\Models\cat_item::describir($id) }}</li>
            @endforeach
        </ul>
    @endif
</div>

<div class="col-sm-6">
    <label>Estado de la solicitud</label>
    <p>{{ $salida->fmt_id_estado_proteccion }}</p>
</div>


<div class="clearfix"></div>
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
