{{-- macroterritorio --}}
<div class="col-sm-4">
    <div class="form-group">
        {!! Form::label('id_macroterritorio', 'Territorio:') !!}
        <p>{{ $misCasos->fmt_id_territorio }}</p>
    </div>
</div>

{{-- Tiempo --}}
<div class="col-sm-4">
    <div class="form-group">
        {!! Form::label('anyo', 'Período de tiempo:') !!}
        <p>{{ $misCasos->anyo_inicio }} - {{ $misCasos->anyo_fin }}</p>
    </div>
</div>
{{-- espacio --}}
<div class="col-sm-4">
    <div class="form-group">
        {!! Form::label('ambito', 'Ámbito:') !!}
        <p>{{ $misCasos->fmt_id_ambito }}: {{ $misCasos->territorio }}</p>
    </div>
</div>
<div class="clearfix"></div>

{{-- Tipo de victima --}}
<div class="col-sm-4">
    <div class="form-group">
        {!! Form::label('id_tipo_victima', 'Tipo de caso:') !!}
        <p>{{ $misCasos->fmt_id_tipo_victima }}</p>
    </div>
</div>
{{-- Sector --}}
<div class="col-sm-8">
    <div class="form-group">
        {!! Form::label('id_sector', 'Sector/es con el que se puede identificar el caso:') !!}
        <ul>
            @foreach($misCasos->arreglo_detalle(18) as $id)
                <li> {{ \App\Models\cat_item::describir($id) }}</li>
            @endforeach
        </ul>
    </div>
</div>

<div class="clearfix"></div>
<!--
{{-- Nombre --}}
<div class="col-sm-12">
    <div class="form-group">
        {!! Form::label('nombre', 'Nombre:') !!}
        <p>{{ $misCasos->nombre }}</p>
    </div>
</div>

{{-- Descripcion --}}
<div class="col-sm-12">
    <div class="form-group">
        {!! Form::label('descripcion', 'Descripción:') !!}
        <p>{!! nl2br($misCasos->descripcion) !!}  </p>
    </div>
</div>
 -->
{{-- Investigaciones judiciales --}}
<div class="col-sm-12">
    <div class="form-group">
        {!! Form::label('judicial', 'Investigaciones judiciales:') !!}
        <p>{!!   nl2br($misCasos->investigacion_judicial) !!}</p>
    </div>
</div>


{{-- Restitucion --}}
<div class="col-sm-12">
    <div class="form-group">
        {!! Form::label('reparacion', 'Medidas de reparacion:') !!}
        <p>{!!  nl2br($misCasos->medidas_reparacion) !!}</p>
    </div>
</div>
<div class="clearfix"></div>
{{-- violencia --}}
<div class="col-sm-12">
    <div class="form-group">
        {!! Form::label('violencia', 'Violencia:') !!}
        <ul>
            @foreach($misCasos->arreglo_detalle(5) as $id)
                <li> {{ \App\Models\cat_item::describir($id) }}</li>
            @endforeach
        </ul>
    </div>
</div>
{{-- patrones --}}
<div class="col-sm-12">
    <div class="form-group">
        {!! Form::label('patrones', 'Patrones identificados:') !!}
        <ul>
            @foreach($misCasos->arreglo_detalle(280) as $id)
                <li> {{ \App\Models\cat_item::describir($id) }}</li>
            @endforeach
        </ul>
    </div>
</div>



<div class="clearfix"></div>
{{-- Fuerzas responsables --}}
<div class="col-sm-6">
    <div class="form-group">
        {!! Form::label('fr', 'Fuerzas responsables:') !!}
        <ul>
            @foreach($misCasos->arreglo_detalle(4) as $id)
                <li> {{ \App\Models\cat_item::describir($id) }}</li>
            @endforeach
        </ul>
    </div>
</div>
{{-- Terceros civiles --}}
<div class="col-sm-6">
    <div class="form-group">
        {!! Form::label('tc', 'Terceros civiles:') !!}
        <ul>
            @foreach($misCasos->arreglo_detalle(10) as $id)
                <li> {{ \App\Models\cat_item::describir($id) }}</li>
            @endforeach
        </ul>
    </div>
</div>


{{-- Observaciones --}}
<div class="col-sm-12">
    <div class="form-group">
        {!! Form::label('observaciones', 'Observaciones/Anotaciones:') !!}
        <p>{!! nl2br($misCasos->observaciones) !!}</p>
    </div>
</div>

<div class="clearfix"></div>