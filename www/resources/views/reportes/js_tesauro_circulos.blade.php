{{-- Muestra la visualización de packed circles --}}

@php($unidad_conteo = isset($unidad_conteo) ? $unidad_conteo : "entrevistas")

<div id="view_tes_circulitos"></div>


@push("js")
    <script src="https://cdn.jsdelivr.net/npm/vega@5"></script>
    <script src="https://cdn.jsdelivr.net/npm/vega-lite@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/vega-embed@6"></script>
    <script>
        //console.log({!! $json_datos !!} );
        var mi_json = {!! $json_datos !!}  ;

        var data = {
            "$schema": "https://vega.github.io/schema/vega/v5.json",
            "description": "Comparativo de aplicación de etiquetas",
            "width": 600,
            "height": 600,
            "padding": 5,
            "autosize": "none",

            "data": [
                {
                    "name": "tree",
                    "values": mi_json,
                    "transform": [
                        {
                            "type": "stratify",
                            "key": "id",
                            "parentKey": "parent"
                        },
                        {
                            "type": "pack",
                            "field": "size",
                            "sort": {"field": "value"},
                            "size": [{"signal": "width"}, {"signal": "height"}]
                        }
                    ]
                }
            ],

            "scales": [
                {
                    "name": "color",
                    "type": "ordinal",
                    "domain": {"data": "tree", "field": "depth"},
                    "range": {"scheme": "category20"}
                }
            ],

            "marks": [
                {
                    "type": "symbol",
                    "from": {"data": "tree"},
                    "encode": {
                        "enter": {
                            "shape": {"value": "circle"},
                            "fill": {"scale": "color", "field": "depth"},
                            "tooltip": {"signal": "datum.name + (datum.size ? ', ' + datum.size + ' {{ $unidad_conteo }}' : '')"}
                        },
                        "update": {
                            "x": {"field": "x"},
                            "y": {"field": "y"},
                            "size": {"signal": "4 * datum.r * datum.r"},
                            "stroke": {"value": "white"},
                            "strokeWidth": {"value": 0.5}
                        },
                        "hover": {
                            "stroke": {"value": "red"},
                            "strokeWidth": {"value": 2}
                        }
                    }
                }
            ]
        };


        vegaEmbed(
            '#view_tes_circulitos',
            data,
            {"actions" :false}
        );
    </script>
@endpush