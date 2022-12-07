@extends('layouts.app')
@section('content_header')
    @include("reportes.frm_filtros_entrevistados")
@endsection
@section('content')
    <h1>Reporte de personas entrevistadas <small>{{ $listado->total() }} personas en total</small></h1>
    <p>Información obtenida de fichas diligenciadas de entrevistas a víctimas (VI), Actores Armados (AA), Terceros Civiles (TC), entrevistas a profundidad (PR) e Historias de Vida (HV).  En los instrumentos colectivos (CO, EE, DC), se utiliza información obtenida a partir de los consentimientos informados.</p>
    @can('nivel-1')
        <a href="{{ action("statController@generar_excel_personas_entrevistadas")."?".$filtros->url }}" class="btn btn-info btn-xs"><i class="fa fa-file-excel-o"></i> Descargar estos datos en excel</a>
    @endcan
    <a href="{{ action("statController@generar_excel_personas_entrevistadas_anonimo")."?".$filtros->url }}" class="btn btn-default btn-xs"><i class="fa fa-file-excel-o"></i> Descargar excel anonimizado</a>
    </p>
    <div class="box box-primary">
        <div class="box-body table-responsive">
            <table class="table table-condensed table-striped table-condensed table-bordered" id="entrevistados-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Otros nombres</th>
                    <th>Sexo</th>
                    <th>Año nacimiento</th>
                    <th>Sector</th>
                    <th>Tipo de entrevista</th>
                    <th>Clasificación</th>
                    <th width="30px">Código</th>
                </tr>
                </thead>
                <tbody>
                @php($i=$listado->firstItem())
                @foreach($listado as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->fmt_nombre_completo }}</td>
                        <td>{{ $item->otros_nombres }}</td>
                        <td>{{ $item->fmt_id_sexo }}</td>
                        <td>{{ $item->fmt_anio_nacimiento }}</td>
                        <td>{{ $item->fmt_id_sector }}</td>
                        <td>{{ $item->fmt_id_subserie }}</td>
                        <td>{{ $item->fmt_nivel_clasificacion }}</td>
                        <td>{!! $item->enlace !!}  </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="no-print">
                {!! $listado->appends(Request::all())->render() !!}
            </div>
        </div>
    </div>
@endsection


