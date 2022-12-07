@php
    $txt_nube = str_replace("\n", "", $txt_nube);
    $txt_nube = str_replace("\r", "", $txt_nube);
    $txt_nube = str_replace('"', "'", $txt_nube);
    //$txt_nube = json_encode($txt_nube);

@endphp
<!-- Botoncito perez -->
<a href="javascript:mostrar_nube()" class="btn btn-default pull-right no-print" title="Mostrar nube de términos" data-toggle="tooltip"><i class="fa fa-cloud text-aqua"></i></a>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Nube de palabras: generada a partir de la transcripción</h4>
            </div>
            <div class="modal-body">
                <div id="nube_palabras" style="width: 99%; height: 300px">
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
    <script src="{{ url("js/d3.v3.min.js") }}" charset="utf-8"></script>
    <script src="{{ url("js/cloud.js") }}" charset="utf-8"></script>
    {{-- nube --}}
    <script>

        //console.log("{!! $txt_nube !!}");
        var text_string = "{!! $txt_nube !!}";
        var common = "{!! \App\Models\cat_item::terminos_bloqueados() !!}";
        //drawWordCloud(text_string,common);

        function drawWordCloud(text_string, common){
            //var common = ;
            var word_count = {};

            var words = text_string.split(/[ '\-\(\)\*":;\[\]|{},.!?]+/);
            if (words.length == 1){
                word_count[words[0]] = 1;
            } else {
                words.forEach(function(word){
                    var word = word.toLowerCase();
                    if (word != "" && common.indexOf(word)==-1 && word.length>1){
                        if (word_count[word]){
                            word_count[word]++;
                        } else {
                            word_count[word] = 1;
                        }
                    }
                })
            }

            var svg_location = "#nube_palabras";
            var width = $("#nube_palabras").width();
            var height = $("#nube_palabras").height();

            var fill = d3.scale.category20();

            var word_entries = d3.entries(word_count);

            var xScale = d3.scale.linear()
                .domain([0, d3.max(word_entries, function(d) {
                    return d.value;
                })
                ])
                .range([10,100]);

            d3.layout.cloud().size([width, height])
                .timeInterval(20)
                .words(word_entries)
                .fontSize(function(d) { return xScale(+d.value); })
                .text(function(d) { return d.key; })
                .rotate(function() { return ~~(Math.random() * 2) * 90; })
                .font("Impact")
                .on("end", draw)
                .start();

            function draw(words) {
                d3.select(svg_location).append("svg")
                    .attr("width", width)
                    .attr("height", height)
                    .append("g")
                    .attr("transform", "translate(" + [width >> 1, height >> 1] + ")")
                    .selectAll("text")
                    .data(words)
                    .enter().append("text")
                    .style("font-size", function(d) { return xScale(d.value) + "px"; })
                    .style("font-family", "Impact")
                    .style("fill", function(d, i) { return fill(i); })
                    .attr("text-anchor", "middle")
                    .attr("transform", function(d) {
                        return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
                    })
                    .text(function(d) { return d.key; });
            }

            d3.layout.cloud().stop();
        }

        function mostrar_nube() {
            $('#myModal').modal('show');

        }

        //Para generar una unica vez
        var nube_generada=false;
        $('#myModal').on('shown.bs.modal', function (e) {
            if(!nube_generada) {
                nube_generada=true;
                drawWordCloud(text_string,common);
            }

        })
    </script>



@endpush