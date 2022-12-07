@extends('layouts.app')
@section('content_header')
    <h1 class="page-header">Aplicación del árbol de etiquetas</h1>

@endsection


@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Comparación del uso del árbol de etiquetas</h3>



        </div>
        <div class="box-body text-center">
            <div id="view"></div>
        </div>
    </div>




@endsection

@push("head")
    <script src="https://cdn.jsdelivr.net/npm/vega@5"></script>
    <script src="https://cdn.jsdelivr.net/npm/vega-lite@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/vega-embed@6"></script>
@endpush
@push("js")
    <script>
        //console.log({!! $json_datos !!} );
        var mi_json = {!! $json_datos !!}  ;

        var data = {
            "$schema": "https://vega.github.io/schema/vega/v5.json",
            "description": "Uso del tesauro en el etiquetado.",
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
                            "tooltip": {"signal": "datum.name + (datum.size ? ', ' + datum.size + ' entrevistas' : '')"}
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
            '#view',
            data,
            {"actions" :false}
        );
    </script>
@endpush