@extends('layouts.app')
@section('content_header')
    <h1 class="page-header">Pruebas de visualización</h1>

@endsection


@section('content')

    <svg id="demo1" width=500 height=500>
        <g  ></g>
    </svg>

    <div class="box">
        <div id="plot"></div>
    </div>



    {{-- Tree --}}
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Nube de términos</h3>
            </div>
            <div class="box-body">
                <div id="grafiquita">
                </div>
            </div>
        </div>

@endsection

@push("head")
    <style>
        circle {
            fill: cadetblue;
            opacity: 0.3;
            stroke: black;
        }
    </style>
@endpush
@push("js")
    {{--
    <script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>



        <script src="//d3js.org/d3.v4.min.js"></script>
    --}}
    <script src="{{ url('js/d3.min.js') }}" type="text/javascript"></script>
   {{-- test --}}
    <script>
        var data = {"children": [
                {"children": [
                        {"name": "55", "stat": 5},
                        {"name": "1a", "stat": 1},
                        {"name": "1b", "stat": 1}
                    ]},
                {"children": [
                        {"stat": 1},
                        {"stat": 1},
                        {"stat": 2},
                        {"stat": 3}
                    ]},
                {"children": [
                        {"stat": 1},
                        {"stat": 1},
                        {"stat": 1},
                        {"stat": 1},
                        {"stat": 2},
                        {"stat": 2},
                        {"stat": 2},
                        {"stat": 4},
                        {"stat": 4},
                        {"stat": 8}
                    ]},
            ]};

        
        var root = d3.hierarchy(data)
            .sum(d => d.hasOwnProperty("stat") ? d.stat : 0)
            .sort((a,b) => b.value - a.value);

        var partition = d3.pack()
            .size([400,400]);

        partition(root);

        d3.select("#demo1 g")
            .selectAll('circle.node')
            .data(root.descendants())
            .enter()
            .append('circle')
            .classed('node', true)
            .attr('cx', d => d.x)
            .attr('cy', d => d.y)
            .attr('r', d => d.r);
    </script>





    <script> {{-- Circulitos --}}
        var w = 500, h = 500, pad = 50; // defining width and height of the SVG element; and a little padding for the plot

        var svg = d3.select("#plot") // Select the plot element from the DOM
            .append("svg") // Append an SVG element to it
            .attr("height", h)
            .attr("width", w);
        const dataset = [[5, 20, 30], [480, 90, 20], [250, 50, 100], [100, 33, 40], [330, 85, 60]];
        // Scales
        var xScale = d3.scaleLinear() // For the X axis
            .domain([0, d3.max(dataset, function(d) { return d[0]; })])
            .range([pad, w - pad]);

        var yScale = d3.scaleLinear() // For the Y axis
            .domain([0, d3.max(dataset, function(d) { return d[1]; })])
            .range([h - pad, pad]);

        var rScale = d3.scaleLinear() // Custom scale for the radii
            .domain([0, d3.max(dataset, function(d) { return d[2]; })])
            .range([1, 30]); // Custom range, change it to see the effects!

        // Axes
        var xAxis = d3.axisBottom(xScale); // handy axes for any orientation
        var yAxis = d3.axisLeft(yScale);

        var circ = svg.selectAll("circle") // Returns ALL matching elements
            .data(dataset) // Bind data to DOM
            .enter() // Add one circle per such data point
            .append("circle")
            .attr("cx", function(d) { return xScale(d[0]); })
            .attr("cy", function(d) { return yScale(d[1]); })
            .attr("r", function(d) { return rScale(d[2]); })
            .attr("fill", "blue").attr("opacity", 0.5);

        //X axis
        svg.append("g") // Creates a group
            .attr("class", "axis") // adding a CSS class for styling
            .attr("transform", "translate(0," + (h - pad) + ")")
            .call(xAxis);

        //Y axis
        svg.append("g")
            .attr("class", "axis")
            .attr("transform", "translate(" + pad +", 0)")
            .call(yAxis);




    </script>
    <script> {{-- Arbolito --}}
        // Set the dimensions and margins of the diagram
        var margin = {top: 20, right: 90, bottom: 30, left: 90},
            width = 960 - margin.left - margin.right,
            height = 500 - margin.top - margin.bottom;

        // declares a tree layout and assigns the size
        var treemap = d3.tree().size([height, width]);

        var flatData = [
            {"name": "Mother Father", "parent": null},
            {"name": "Kid 1", "parent": "Mother Father" },
            {"name": "Kid 2", "parent": "Mother Father" },
            {"name": "Kid 11", "parent": "Kid 1" },
            {"name": "Kid 12", "parent": "Kid 1" },
            {"name": "Kid 21", "parent": "Kid 2" },
            {"name": "Kid 22", "parent": "Kid 2" },
            {"name": "Kid 211", "parent": "Kid 21" },
            {"name": "Kid 212", "parent": "Kid 21" }
        ];

        // convert the flat data into a hierarchy
        var treeData = d3.stratify()
            .id(function(d) { return d.name; })
            .parentId(function(d) { return d.parent; })
            (flatData);

        // assign the name to each node
        treeData.each(function(d) {
            d.name = d.id;
        });

        // append the svg object to the body of the page
        // appends a 'group' element to 'svg'
        // moves the 'group' element to the top left margin
        var svg = d3.select("#grafiquita").append("svg")
            .attr("width", width + margin.right + margin.left)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate("
                + margin.left + "," + margin.top + ")");

        var i = 0,
            duration = 550,
            root;



        // Assigns parent, children, height, depth
        root = d3.hierarchy(treeData, function(d) { return d.children; });
        root.x0 = height / 2;
        root.y0 = 0;

        // Collapse after the second level
        root.children.forEach(collapse);

        update(root);

        // Collapse the node and all it's children
        function collapse(d) {
            if(d.children) {
                d._children = d.children
                d._children.forEach(collapse)
                d.children = null
            }
        }

        function update(source) {

            // Assigns the x and y position for the nodes
            var treeData = treemap(root);

            // Compute the new tree layout.
            var nodes = treeData.descendants(),
                links = treeData.descendants().slice(1);

            // Normalize for fixed-depth.
            nodes.forEach(function(d){ d.y = d.depth * 180});

            // ****************** Nodes section ***************************

            // Update the nodes...
            var node = svg.selectAll('g.node')
                .data(nodes, function(d) {return d.id || (d.id = ++i); });

            // Enter any new modes at the parent's previous position.
            var nodeEnter = node.enter().append('g')
                .attr('class', 'node')
                .attr("transform", function(d) {
                    return "translate(" + source.y0 + "," + source.x0 + ")";
                })
                .on('click', click);

            // Add Circle for the nodes
            nodeEnter.append('circle')
                .attr('class', 'node')
                .attr('r', 1e-6)
                .style("fill", function(d) {
                    return d._children ? "lightsteelblue" : "#fff";
                });

            // Add labels for the nodes
            nodeEnter.append('text')
                .attr("dy", ".35em")
                .attr("x", function(d) {
                    return d.children || d._children ? -13 : 13;
                })
                .attr("text-anchor", function(d) {
                    return d.children || d._children ? "end" : "start";
                })
                .text(function(d) { return d.data.name; });

            // UPDATE
            var nodeUpdate = nodeEnter.merge(node);

            // Transition to the proper position for the node
            nodeUpdate.transition()
                .duration(duration)
                .attr("transform", function(d) {
                    return "translate(" + d.y + "," + d.x + ")";
                });

            // Update the node attributes and style
            nodeUpdate.select('circle.node')
                .attr('r', 10)
                .style("fill", function(d) {
                    return d._children ? "lightsteelblue" : "#fff";
                })
                .attr('cursor', 'pointer');


            // Remove any exiting nodes
            var nodeExit = node.exit().transition()
                .duration(duration)
                .attr("transform", function(d) {
                    return "translate(" + source.y + "," + source.x + ")";
                })
                .remove();

            // On exit reduce the node circles size to 0
            nodeExit.select('circle')
                .attr('r', 1e-6);

            // On exit reduce the opacity of text labels
            nodeExit.select('text')
                .style('fill-opacity', 1e-6);

            // ****************** links section ***************************

            // Update the links...
            var link = svg.selectAll('path.link')
                .data(links, function(d) { return d.id; });

            // Enter any new links at the parent's previous position.
            var linkEnter = link.enter().insert('path', "g")
                .attr("class", "link")
                .attr('d', function(d){
                    var o = {x: source.x0, y: source.y0}
                    return diagonal(o, o)
                });

            // UPDATE
            var linkUpdate = linkEnter.merge(link);

            // Transition back to the parent element position
            linkUpdate.transition()
                .duration(duration)
                .attr('d', function(d){ return diagonal(d, d.parent) });

            // Remove any exiting links
            var linkExit = link.exit().transition()
                .duration(duration)
                .attr('d', function(d) {
                    var o = {x: source.x, y: source.y}
                    return diagonal(o, o)
                })
                .remove();

            // Store the old positions for transition.
            nodes.forEach(function(d){
                d.x0 = d.x;
                d.y0 = d.y;
            });

            // Creates a curved (diagonal) path from parent to the child nodes
            function diagonal(s, d) {

                path = `M ${s.y} ${s.x}
					C ${(s.y + d.y) / 2} ${s.x},
					  ${(s.y + d.y) / 2} ${d.x},
					  ${d.y} ${d.x}`

                return path
            }

            // Toggle children on click.
            function click(d) {
                if (d.children) {
                    d._children = d.children;
                    d.children = null;
                } else {
                    d.children = d._children;
                    d._children = null;
                }
                update(d);
            }
        }
        {{--

        var sample_data = [
            { text:"hola", value:3},
            { text:"mundo", value:1},
            { text:"esta", value:4},
        ];

        var svg = d3.select("#grafiquita").append("svg")
            //.attr("width", width + margin.right + margin.left)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate("
                + margin.left + "," + margin.top + ")");

        // instantiate d3plus
        d3.viz()
            .container("#grafiquita")
            .type("cloud")
            .data(sample_data)       // 載入資料
            .tooltip([               // 指定要顯示的property
                "name",
                "size",
                "color",
                "a",
                "b",
                "c",
                "d",
                "e",
                "f",
                "g",
                "h",
                "i",
                "j"])
            .color("color")
            .size("size")            // node大小
            .id("name")              // 指定data的key
            .class((d)=>{return d.a})
            // class 可以加在 svg 上面
            .draw();



        --}}

    </script>
@endpush