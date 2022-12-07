@php
    $txt_nube_tesauro = str_replace("\n", "", $txt_nube_tesauro);
    $txt_nube_tesauro = str_replace("\r", "", $txt_nube_tesauro);
    $txt_nube_tesauro = str_replace('"', "'", $txt_nube_tesauro);
    //$txt_nube = json_encode($txt_nube);

@endphp
<!-- Botoncito perez -->
<a href="javascript:mostrar_nube_tesauro()" class="btn btn-default pull-right no-print" title="Mostrar nube de etiquetas" data-toggle="tooltip"><i class="fa fa-tree text-aqua"></i></a>
<!-- Modal -->
<style>
    .cloud svg {
        border: 0px solid grey;
        text-align: center;
    }
</style>
<div class="modal fade" id="myModal_tesauro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Nube de términos: generada a partir de las etiquetas aplicadas. <small>Se excluyen las etiquetas de entidades</small></h4>
            </div>
            <div class="modal-body text-center">
                <div id="nube_palabras_tesauro" class="cloud">
                </div>
            </div>
            <div class="modal-footer">
                <p class="pull-left">
                    <span class="text-danger">Atención:</span> Algunas veces, las nubes de palabras <a href="https://www.niemanlab.org/2011/10/word-clouds-considered-harmful/" target="_blank">pueden ser consideradas inapropiadas</a>
                </p>

                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>





@push("js")
    {{--
    <script src="{{ url("js/d3.v3.min.js") }}" charset="utf-8"></script>
    <script src="{{ url("js/cloud.js") }}" charset="utf-8"></script>
    --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-cloud/1.2.5/d3.layout.cloud.min.js"></script>
    {{-- nube --}}
    <script>

        //console.log("{!! $txt_nube_tesauro !!}");
        var text_string_tes = "{!! $txt_nube_tesauro !!}";
        var common_tes = "{!! \App\Models\cat_item::terminos_bloqueados() !!}";
        //drawWordCloud(text_string,common);
        //console.log(text_string_tes);

        var words = sortByFrequency( text_string_tes.split(/[|]+/) )
            .map(function(d,i) {
                //console.log(d);
                return {text: d, size: -i};
            });
        //console.log("Mirame");
        //console.log(words);

        var fontName = "Impact",
            cWidth = 720,
            cHeight = 400,
            svg,
            wCloud,
            bbox,
            ctm,
            bScale,
            bWidth,
            bHeight,
            bMidX,
            bMidY,
            bDeltaX,
            bDeltaY;

        var cTemp = document.createElement('canvas'),
            ctx = cTemp.getContext('2d');
        ctx.font = "100px " + fontName;

        var fRatio = Math.min(cWidth, cHeight) / ctx.measureText(words[0].text).width,
            fontScale = d3.scale.linear()
                .domain([
                    d3.min(words, function(d) { return d.size; }),
                    d3.max(words, function(d) { return d.size; })
                ])
                //.range([20,120]),
                .range([20,100*fRatio/2]), // tbc
            fill = d3.scale.category20();

        d3.layout.cloud()
            .size([cWidth, cHeight])
            .words(words)
            //.padding(2) // controls
            .rotate(function() { return ~~(Math.random() * 2) * 90; })
            .font(fontName)
            .fontSize(function(d) { return fontScale(d.size) })
            .on("end", draw)
            .start();

        function draw(words, bounds) {
            // move and scale cloud bounds to canvas
            // bounds = [{x0, y0}, {x1, y1}]
            bWidth = bounds[1].x - bounds[0].x;
            bHeight = bounds[1].y - bounds[0].y;
            bMidX = bounds[0].x + bWidth/2;
            bMidY = bounds[0].y + bHeight/2;
            bDeltaX = cWidth/2 - bounds[0].x + bWidth/2;
            bDeltaY = cHeight/2 - bounds[0].y + bHeight/2;
            bScale = bounds ? Math.min( cWidth / bWidth, cHeight / bHeight) : 1;
            {{--
            console.log(
                "bounds (" + bounds[0].x +
                ", " + bounds[0].y +
                ", " + bounds[1].x +
                ", " + bounds[1].y +
                "), width " + bWidth +
                ", height " + bHeight +
                ", mid (" + bMidX +
                ", " + bMidY +
                "), delta (" + bDeltaX +
                ", " + bDeltaY +
                "), scale " + bScale
            );
            --}}

            // the library's bounds seem not to correspond to reality?
            // try using .getBBox() instead?

            svg = d3.select("#nube_palabras_tesauro").append("svg")
                .attr("width", cWidth)
                .attr("height", cHeight);

            wCloud = svg.append("g")
            //.attr("transform", "translate(" + [bDeltaX, bDeltaY] + ") scale(" + 1 + ")") // nah!
                .attr("transform", "translate(" + [bWidth>>1, bHeight>>1] + ") scale(" + bScale + ")") // nah!
                .selectAll("text")
                .data(words)
                .enter().append("text")
                .style("font-size", function(d) { return d.size + "px"; })
                .style("font-family", fontName)
                .style("fill", function(d, i) { return fill(i); })
                .attr("text-anchor", "middle")
                .transition()
                .duration(500)
                .attr("transform", function(d) {
                    return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
                })
                .text(function(d) { return d.text; });

            // TO DO: function to find min and max x,y of all words
            // and use it as the group's bbox
            // then do the transformation
            bbox = wCloud.node(0).getBBox();
            //ctm = wCloud.node().getCTM();
            {{--
            console.log(
                "bbox (x: " + bbox.x +
                ", y: " + bbox.y +
                ", w: " + bbox.width +
                ", h: " + bbox.height +
                ")"
            );
            --}}

        };

        function sortByFrequency(arr) {
            arr.map(s => s.trim());
            var f = {};
            arr.forEach(function(i) { f[i] = 0; });
            var u = arr.filter(function(i) { return ++f[i] == 1; });
            return u.sort(function(a, b) { return f[b] - f[a]; });
        }

        function mostrar_nube_tesauro() {
            $('#myModal_tesauro').modal('show');

        }


    </script>



@endpush