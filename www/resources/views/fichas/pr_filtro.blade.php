
{{ Form::open(array('url' =>"#",'method' => 'get')) }}
<div class="card   {{ $filtros->hay_filtro >0 ? ' collapsed-card card-success' : ' card-info ' }}">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter"></i> Presunto responsable individual: aplicar filtros a la información mostrada {{ $filtros->hay_filtro>0 ? ($filtros->hay_filtro==1 ? "($filtros->hay_filtro filtro aplicado)" : "($filtros->hay_filtro filtros aplicados)") : "" }}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas {{ $filtros->hay_filtro>0 ? 'fa-plus' : 'fa-minus'}} "></i>
            </button>
        </div>
    </div>
    <div class="card-body text-sm">
        @include("fichas.partials.filtros_socio",['tipo'=>3])
        <div class="row">
            <div class="col-md-6">
                @include("fichas.partials.filtros_metadatos",['tipo'=>3])
            </div>
            <div class="col-md-6">
                @include("fichas.partials.filtros_buscadora",['tipo'=>3])
            </div>

        </div>
        <div class="row">
            <div class="col-sm-6">

            </div>
            {{-- Datos como víctima: grupos, etc. --}}
            <div class="col-sm-6">
                @include("fichas.partials.filtros_violencia",['tipo'=>3])
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                @include("fichas.partials.filtros_contexto",['tipo'=>3])
            </div>
            {{-- Datos como víctima: grupos, etc. --}}
            <div class="col-sm-6">
                @include("fichas.partials.filtros_impactos",['tipo'=>3])
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ Request::url() }}"  class="btn btn-secondary">Quitar filtros y mostrar todo</a>
        <button type="submit" class="btn btn-success float-right" id="boton_filtrar">Aplicar filtros</button>
    </div>
</div>
{{ Form::hidden('id_tipo_listado',$filtros->id_tipo_listado, ['id'=>'id_tipo_listado'])  }}
{{ Form::close() }}


{{-- Para cambiar el tipo de listado --}}
@push('js')
    <script>
        function cambiar_tipo_listado(cual) {
            $("#id_tipo_listado").val(cual);
            $("#boton_filtrar").click();
            //console.log(cual);
        }
    </script>
@endpush