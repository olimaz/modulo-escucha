
@section('sidebar')
    @if($filtros->hay_filtro)
        <h5 class="text-warning"><i class="fas fa-filter"></i> Filtros aplicados</h5>
        <p>Todos los datos se encuentran calculados de acuerdo a los filtros especificados.  Estos filtros aplican a un total de <span class="text-warning">{{ $datos->conteos->entrevistas }} entrevistas.</span> </p>
        <br>
        @if($filtros->entrevista_lugar>0 || $filtros->id_territorio>0 || $filtros->id_macroterritorio >0)
            <h6>Filtros de metadatos</h6>
            <ul>
                @if($filtros->entrevista_lugar>0)
                    <li>Lugar de la entrevista.</li>
                @endif
                @if($filtros->id_territorio>0)
                    <li>Territorio que realiza la entrevista</li>
                @endif
                @if($filtros->id_macroterritorio>0)
                    <li>Macroterritorio que realiza la entrevista.</li>
                @endif
            </ul>
        @endif
        @if($filtros->violencia_tipo>0 || $filtros->violencia_lugar>0 || $filtros->violencia_anio_del >0 || $filtros->violencia_anio_al >0 || $filtros->violencia_aa >0 || $filtros->violencia_tc >0  )
            <h6>Filtros de metadatos</h6>
            <ul>
                @if($filtros->violencia_tipo>0)
                    <li>Tipo de violencia</li>
                @endif
                @if($filtros->violencia_lugar>0)
                    <li>Lugar de los hechos</li>
                @endif
                @if($filtros->violencia_anio_del>0)
                    <li>Año de inicio de violencia</li>
                @endif
                @if($filtros->violencia_anio_al>0)
                    <li>Año de finalización de violencia</li>
                @endif

                @if($filtros->violencia_aa>0)
                    <li>Actor Armado</li>
                @endif
                @if($filtros->violencia_tc>0)
                    <li>Tercero Civil</li>
                @endif
            </ul>
        @endif
        @if($filtros->id_excel_listados>0)
            <h6>Listados de códigos</h6>
            <ul>
                <li>Listados de entrevistas, cargados en excel</li>
            </ul>

        @endif

        <a href="#" class="btn btn-default btn-sm text-primary" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fas fa-angle-double-right"></i>Ocultar esta notificación</a>
    @endif

@endsection


@if($filtros->hay_filtro)
    @push("js")
        <script>
            $(function() {
                $("#boton_sidebar").ControlSidebar('toggle');
            });

        </script>

    @endpush
@endif