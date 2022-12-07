{{-- vista para RETORNO --}}

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
                @if($salida->salida_ciudad)
                    <p>{{ $salida->salida_ciudad }}</p>
                @endif

            </div>
            <div class="col-sm-6">
                {!! Form::label('acompanamiento', 'Acompañamiento en la salida:') !!}
                <ul>
                    @foreach($salida->arreglo_proteccion(218,1) as $id)
                        <li>{{ \App\Models\cat_item::describir($id) }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-6">
                {!! Form::label('entidad_apoyo_retorno', 'Entidad que le apoyó:') !!}
                <p> {{ $exilio->entidad_apoyo_retorno }}</p>
            </div>
        </div>
    </div>

</div>
<div class="col-sm-6">
    <div class="box box-info box-solid">
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
                {!! Form::label('lugar_llegada', 'Lugar de retorno en Colombia:') !!}
                <p> {{ $salida->fmt_id_lugar_llegada }}</p>

            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('salida', 'Acompañamiento en la llegada:') !!}
                <ul>
                    @foreach($salida->arreglo_proteccion(218,2) as $id)
                        <li>{{ \App\Models\cat_item::describir($id) }}</li>
                    @endforeach
                </ul>
            </div>


        </div>
    </div>

</div>
<div class="clearfix"></div>






<div class="col-sm-6">
    <label>Modalidad del retorno:</label>
    <p>{{ $salida->fmt_id_modalidad }}</p>
</div>
<div class="col-sm-6">
    <label>Personas que retornaron</label>
    <table class="table table-condensed">
        <tr>
            <td>Personas que retornaron</td>
            <td>{{ $salida->cant_personas_salieron }}</td>
        </tr>
        <tr>
            <td>Personas del núcleo familiar que retornaron</td>
            <td>{{ $salida->cant_personas_familia_salieron }}</td>
        </tr>
        <tr>
            <td>Personas del núcleo familiar que se quedaron</td>
            <td>{{ $salida->cant_personas_familia_quedaron }}</td>
        </tr>
    </table>
</div>
<div class="clearfix"></div>


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

