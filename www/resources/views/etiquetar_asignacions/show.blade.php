@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Detalles del etiquetado
            <div class="pull-right">
                <a href="{!! route('etiquetarAsignacions.index') !!}" class="btn btn-default">Regresar</a>
            </div>
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('etiquetar_asignacions.show_fields')

                </div>
            </div>
        </div>
        @if(count($seguimiento)>0)
            <div class="col-sm-6">
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Seguimiento de la entrevista</h3>
                    </div>
                    <div class="box-body">
                        <ol>
                            @foreach($seguimiento as $detalle)
                                <li>
                                    {{ $detalle->fmt_fecha_hora }}. {{ $detalle->fmt_id_entrevistador }}
                                    <ul>
                                        <li>Cerrado: {{ $detalle->fmt_id_cerrado }}</li>
                                        @if($detalle->anotaciones)
                                            <li>Anotaciones: {{ $detalle->anotaciones }}</li>
                                        @endif
                                        @foreach($detalle->rel_seguimiento_problema as $problema)
                                            <li>{{ $problema->fmt_id_tipo_problema }}: {{ $problema->descripcion }}</li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
