<script>
    //console.log({!! $json_datos !!} );
    var mi_json = {!! $json_datos !!}  ;

    var data = {
        "$schema": "https://vega.github.io/schema/vega/v5.json",
        "description": "Comparativo de aplicación de etiquetas",
        "width": 900,
        "height": 2600,
        "padding": 10,
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
                        "type": "tree",
                        "method": "tidy",
                        "size": [{"signal": "height"}, {"signal": "width - 100"}],
                        "separation": true,
                        "as": ["y", "x", "depth", "children"]
                    }
                ]
            },
            {
                "name": "links",
                "source": "tree",
                "transform": [
                    { "type": "treelinks" },
                    {
                        "type": "linkpath",
                        "orient": "horizontal",
                        "shape": "diagonal"
                    }
                ]
            }
        ],

        "scales": [
            {
                "name": "color",
                "type": "linear",
                "range": {"scheme": "magma"},
                "domain": {"data": "tree", "field": "depth"},
                "zero": true
            }
        ],

        "marks": [
            {
                "type": "path",
                "from": {"data": "links"},
                "encode": {
                    "update": {
                        "path": {"field": "path"},
                        "stroke": {"value": "#ccc"}
                    }
                }
            },
            {
                "type": "symbol",
                "from": {"data": "tree"},
                "encode": {
                    "enter": {
                        "size": {"value": 100},
                        "stroke": {"value": "#fff"}
                    },
                    "update": {
                        "x": {"field": "x"},
                        "y": {"field": "y"},
                        "fill": {"scale": "color", "field": "depth"}
                    }
                }
            },
            {
                "type": "text",
                "from": {"data": "tree"},
                "encode": {
                    "enter": {
                        "text": {"field": "name"},
                        "fontSize": {"value": 9},
                        "baseline": {"value": "middle"}
                    },
                    "update": {
                        "x": {"field": "x"},
                        "y": {"field": "y"},
                        "dx": {"signal": "datum.children ? -7 : 7"},
                        "align": {"signal": "datum.children ? 'right' : 'left'"},
                        "opacity": "1"
                    }
                }
            }
        ]
    };


    vegaEmbed(
        '#tree',
        data,
        {"actions" :false}
    );
</script>