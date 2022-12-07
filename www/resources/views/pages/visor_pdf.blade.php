@extends('layouts.app')

@section('content_header')
<h1 class="page-header"> {{ $adjunto->entrevista->entrevista_codigo }}
        - {{ $adjunto->tipo_adjunto }}
</h1>
@endsection
@section('content')

    <style>
        #visor_pdf {width: 100%; height: 100%;    justify-content: center; align-items: center;}
        #marca {width: 100%; height:100%; position: absolute; top: 0; left: 0;}
        #marca *{padding:0.4em; margin:0; }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                background-image: url('{{ $marca_agua }}');
            }
            #marca {
                -webkit-print-color-adjust: exact;
                background: url('{{ $marca_agua }}');
            }
            * {
                -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
                color-adjust: exact !important;  /*Firefox*/
            }
        }
    </style>
    @can('rol-descarga')
        <a href="{{ url('adjuntos/'.$adjunto->id_adjunto) }}" class="btn btn-xs btn-default pull-right"><i class="fa fa-file-pdf-o"></i> Descargar PDF </a>
    @endcan





    <section>

        <div id="divPDF"  class="col-sm-12">
            <div >
                <div id="visor_pdf" class="no-print">
                </div>
                <canvas id="the-canvas"></canvas>
            </div>

            <div id="marca" style="background: url('{{ $marca_agua }}')" >
            </div>
        </div>

    </section>

    <div class="clearfix"></div>



@endsection


@push('js')
    <script src="{{ url('js/pdf.js') }}" type="text/javascript"></script>

    <script>
            function mostrar_pdf(){
                // If absolute URL from the remote server is provided, configure the CORS
                // header on that server.
                var url = '{{ $ubicacion }}';

                // Loaded via <script> tag, create shortcut to access PDF.js exports.
                var pdfjsLib = window['pdfjs-dist/build/pdf'];

                // The workerSrc property shall be specified.
                pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ url('js/pdf.worker.js') }}';

                // Asynchronous download of PDF
                var loadingTask = pdfjsLib.getDocument(url);
                loadingTask.promise.then(function(pdf) {
                    console.log('PDF loaded');

                    // Fetch the first page
                    var pageNumber = 1;
                    pdf.getPage(pageNumber).then(function(page) {
                        console.log('Page loaded');

                        var scale = 1.5;
                        var viewport = page.getViewport({scale: scale});

                        // Prepare canvas using PDF page dimensions
                        var canvas = document.getElementById('the-canvas');
                        var context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        // Render PDF page into canvas context
                        var renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };
                        var renderTask = page.render(renderContext);
                        renderTask.promise.then(function () {
                            console.log('Page rendered');
                        });
                    });
                }, function (reason) {
                    // PDF loading error
                    console.error(reason);
                });
            }

            function mostrar_pdf2(){
                // If absolute URL from the remote server is provided, configure the CORS
                // header on that server.
                var url = '{{ $ubicacion }}';

                // Loaded via <script> tag, create shortcut to access PDF.js exports.
                var pdfjsLib = window['pdfjs-dist/build/pdf'];

                // The workerSrc property shall be specified.
                pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ url('js/pdf.worker.js') }}';

                // Asynchronous download of PDF
                var loadingTask = pdfjsLib.getDocument(url);
                loadingTask.promise.then(function(pdf) {
                    console.log('PDF loaded');

                    var container = document.getElementById("visor_pdf");


                    // Fetch the first page
                    var pageNumber = 1;
                    pdf.getPage(pageNumber).then(function(page) {
                        console.log('Page loaded');

                        var scale = 1.5;
                        var viewport = page.getViewport({scale: scale});

                        //Prueba

                        var div = document.createElement("div");

                        // Set id attribute with page-#{pdf_page_number} format
                        div.setAttribute("id", "page-" + (page.pageIndex + 1));

                        // This will keep positions of child elements as per our needs
                        div.setAttribute("style", "position: relative");


                        // Append div within div#container
                        container.appendChild(div);

                        // Create a new Canvas element
                        var canvas = document.createElement("canvas");

                        // Append Canvas within div#page-#{pdf_page_number}
                        div.appendChild(canvas);

                        var context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        var renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };

                        // Render PDF page
                        page.render(renderContext);

                    });
                }, function (reason) {
                    // PDF loading error
                    console.error(reason);
                });
            }

            function mostrar_pdf3(){
                // If absolute URL from the remote server is provided, configure the CORS
                // header on that server.
                var url = '{{ $ubicacion }}';

                // Loaded via <script> tag, create shortcut to access PDF.js exports.
                var pdfjsLib = window['pdfjs-dist/build/pdf'];

                // The workerSrc property shall be specified.
                pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ url('js/pdf.worker.js') }}';

                // Asynchronous download of PDF
                var loadingTask = pdfjsLib.getDocument(url);
                loadingTask.promise.then(function(pdf) {
                    console.log('PDF loaded');

                    var container = document.getElementById("visor_pdf");

                    for (var i = 1; i <= pdf.numPages; i++) {
                        // Fetch the first page
                        var pageNumber = i;
                        pdf.getPage(pageNumber).then(function(page) {
                            console.log('Page loaded');

                            var scale = 1.5;
                            var viewport = page.getViewport({scale: scale});

                            //Prueba
                            var h = document.createElement("h4");
                            var t = document.createTextNode("Página " + (page.pageIndex + 1) + ' de ' + (pdf.numPages) );
                            h.appendChild(t);
                            container.appendChild(h);




                            var div = document.createElement("div");

                            // Set id attribute with page-#{pdf_page_number} format
                            div.setAttribute("id", "page-" + (page.pageIndex + 1));
                            div.setAttribute('class','box box-info text-center');

                            // This will keep positions of child elements as per our needs
                            //div.setAttribute("style", "position: relative");


                            // Append div within div#container
                            container.appendChild(div);
                            //container.appendChild(document.createElement("hr"));


                            // Create a new Canvas element
                            var canvas = document.createElement("canvas");

                            // Append Canvas within div#page-#{pdf_page_number}
                            div.appendChild(canvas);

                            var context = canvas.getContext('2d');
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;

                            var renderContext = {
                                canvasContext: context,
                                viewport: viewport
                            };

                            // Render PDF page
                            page.render(renderContext);

                        });
                    }



                }, function (reason) {
                    // PDF loading error
                    console.error(reason);
                });

            }

            $(function() {
                mostrar_pdf3();
                $('#videoDiv').bind('contextmenu', function(e) {
                    return false;
                });
            });



    </script>


@endpush