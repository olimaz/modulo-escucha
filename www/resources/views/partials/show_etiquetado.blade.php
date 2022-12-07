{{-- Mostrar la transcripción o el etiquetado, si lo hubiera --}}
@if($entrevista->puede_acceder_adjuntos())  {{-- Proteger R3 y R2 --}}

@if($entrevista->json_etiquetado)
    <div class="box box-info  collapsed-box box-solid">
        <div class="box-header ">
            <h3 class="box-title">Etiquetas aplicadas: {{ $entrevista->rel_etiquetas()->count() }}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div>

        </div>
        <div class="box-body">
            @include("partials.tesauro_cuadros",['json_datos_cuadros' => \App\Models\etiqueta_entrevista::json_jerarquico_entrevista($id_subserie, $id_entrevista)])
            <ol>
                @foreach($entrevista->listar_etiquetas() as $marca)
                    <li>{{ $marca->fmt_etiqueta }}. {{-- <span class="text-muted">{{ $marca->fmt_texto }}</span> --}}
                        <br> <span class="text-success">{{ $marca->texto }}</span>
                    </li>
                @endforeach
            </ol>

        </div>
    </div>

    <div class="box box-info  collapsed-box box-solid">
        <div class="box-header ">
            <h3 class="box-title"> Transcripción completa </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div>

        </div>
        <div class="box-body">
            {!! $entrevista->etiquetado->texto_resaltado !!}
        </div>
    </div>
@else
    @if($entrevista->html_transcripcion)
        <div class="box box-info  collapsed-box box-solid">
            <div class="box-header ">
                <h3 class="box-title"> Transcripción</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>

            </div>
            <div class="box-body">
                {!! nl2br($entrevista->fmt_html_transcripcion) !!}
            </div>
        </div>

    @endif

@endif
@endif