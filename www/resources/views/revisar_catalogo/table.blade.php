<div class="table-responsive">
    <table class="table" id="trazaActividads-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Catálogo</th>
                <th>Opciones disponibles del catalogo:</th>
                <th>Nueva opción</th>
                <th>Creador</th>
                @can('sistema-abierto')
                    <th>Aprobar</th>
                    <th>Rechazar <br> (re-asignar)</th>
                @endcan

            </tr>
        </thead>
        <tbody>

        @php($i=1)
        @foreach($catalogos as $catalogo)
            <tr>
                <td>{!! $i++ !!}</td>
                <td>{!! $catalogo->FmtIdCatRevisar !!}</td>
                <td>
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#colapsar_opciones{!! $catalogo->id_item !!}">
                                        <i class="fa fa-arrow-down pull-right" aria-hidden="true"></i>
                                        Ver opciones aprobadas

                                    </a>
                                </h5>

                            </div>
                            <div id="colapsar_opciones{!! $catalogo->id_item !!}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ol>
                                        @foreach($catalogo->opciones as $opcion)
                                            <li>{!! $opcion->descripcion !!}</li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td >{!! $catalogo->descripcion !!} &nbsp;
                    @can('sistema-abierto')
                        <a data-toggle="modal" class='btn btn-info btn-xs ' data-target="#editar{!! $catalogo->id_item !!}" ><i class="glyphicon glyphicon-pencil"></i></a>
                    @endcan
                </td>

                <td>
                    @if($catalogo->id_entrevistador)
                        {{ \App\Models\entrevistador::find($catalogo->id_entrevistador)->correo }}
                    @else
                        Desconocido
                    @endif
                </td>
                @can('sistema-abierto')
                    <td class="text-center">
                        <a href="{!! action('revisar_catalogoController@aprobar', [$catalogo->id_item]) !!}" onclick="return confirm('¿Desea aprobar este item?')" class='btn btn-default btn-sm'>
                            <i class="glyphicon glyphicon-ok"></i>
                        </a>
                    </td>
                    <!-- <td><a data-toggle="modal" data-target="#listar{!! $catalogo->id_cat !!}" href="{!! action('revisar_catalogoController@reasignar', [$catalogo->id_cat] ) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a></td> -->
                    {{-- boton de revisar catalogos --}}
                    <td class="text-center">
                        <a data-toggle="modal" data-target="#listar{!! $catalogo->id_item !!}" class='btn btn-default btn-sm'>
                            <i class="glyphicon glyphicon-edit"></i>
                        </a>
                    </td>
                @endcan

        </tr>
         @include('revisar_catalogo.lista_items')
         @include('revisar_catalogo.items_edit')
        @endforeach
        </tbody>
    </table>
</div>
@push('js')
<script>
var $template = $(".template");

var hash = 2;
$(".btn-add-panel").on("click", function () {
    var $newPanel = $template.clone();
    $newPanel.find(".collapse").removeClass("in");
    $newPanel.find(".accordion-toggle").attr("href",  "#" + (++hash))
             .text("Dynamic panel #" + hash);
    $newPanel.find(".panel-collapse").attr("id", hash).addClass("collapse").removeClass("in");
    $("#accordion").append($newPanel.fadeIn());
});
</script>
@endpush
