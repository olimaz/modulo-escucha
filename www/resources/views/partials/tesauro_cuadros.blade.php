<div class="row  table-responsive">
    <div class="col-md-8 col-md-offset-4 text-center">
        <div id="cuadro_etiquetas" CLASS="text-center " >
        </div>
        <p>Proporción de etiquetas analíticas utilizadas. Se excluyen las etiquetas de entidades</p>
    </div>
</div>


@push("js")
    <script src="https://cdn.jsdelivr.net/npm/vega@5"></script>
    <script src="https://cdn.jsdelivr.net/npm/vega-lite@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/vega-embed@6"></script>
    <script>

        //console.log({!! $json_datos_cuadros !!} );

        var mi_json_cuadros = {!! $json_datos_cuadros !!}  ;

        var data = {
            "$schema": "https://vega.github.io/schema/vega/v5.json",
            "description": "Uso del tesauro en el etiquetado.",
            "width": 300,
            "height": 300,
            "padding": 5,
            "autosize": "none",

            "data": [
                {
                    "name": "tree",
                    "values": mi_json_cuadros,
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
                            "tooltip": {"signal": "datum.name + (datum.size ? ', ' + datum.size + ' párrafos' : '')"}
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
            '#cuadro_etiquetas',
            data,
            {"actions" :false}
        );
    </script>
@endpush