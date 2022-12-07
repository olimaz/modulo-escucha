{{--
    JavaScript del control de  la carga de archivo
    Es un archivo separado por si son varios controles
    Debe incluirse una única vez.

    //Activa y desactiva un #btn_grabar que debe estar en el formulario que lo contiene
--}}

@push('js')

    <script>

        var ico_si='<i class="fa fa-check-square-o fa-4x text-green" aria-hidden="true"></i>';
        var ico_no='<i class="fa fa-square-o fa-4x text-red" aria-hidden="true"></i>';
        var ico_cargando='<i class="fa fa-spinner fa-spin fa-2x fa-fw" ></i>';
        var ico_cargando_boton='Cargando archivos...';

        var cargas_pendientes=0;
        var texto_boton = $("#btn_grabar").val(); //Guardar el texto que tiene al inicio

        function cargar(control) {
            $('#'+control).click();
        }

        $('.carga_automatica').change(function () {
            if ($(this).val() != '') {
                upload(this);
            }
        });



        $('#file').change(function () {
            if ($(this).val() != '') {
                upload(this);
            }
        });
        function upload(img) {
            var control = img.name;
            cargas_pendientes++;

            var inicio = new Date();
            var final = new Date();


            $("#"+control+"_casilla").html(ico_cargando);
            var progreso = $("#"+control+"_progreso");

            var form_data = new FormData();
            form_data.append('file', img.files[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('control',img.name);

            $("#btn_grabar").prop("disabled",true);
            $("#btn_grabar").val(ico_cargando_boton);
            $.ajax({
                url: "{{url('/upload')}}",
                data: form_data,
                type: 'POST',
                dataType: "json",
                contentType: false,
                processData: false,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = ((evt.loaded / evt.total) * 100);
                            console.log('Completado: ' + percentComplete);
                            percentComplete = Math.floor(percentComplete);
                            progreso.width(percentComplete + '%');
                            progreso.html(percentComplete+'%');
                        }
                    }, false);
                    return xhr;
                },
                beforeSend: function(){
                    progreso.width('0%');
                    progreso.html('0%');
                    var today = new Date();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    inicio = time;
                    console.log("Inicio: "+time);
                },
                success: function (data) {
                    cargas_pendientes--;
                    var today = new Date();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    final = time;
                    console.log("Inicio: "+inicio);
                    console.log("Fin: "+final);
                    if (data.exito !== 1) {
                        $("#"+control+"_casilla").html(ico_no);
                        $("#"+control+"_filename").val("");
                        $("#"+control+"_url").html("");
                        alert(data.mensaje);
                    }
                    else {
                        $("#"+control+"_filename").val(data.url);
                        $("#"+control+"_casilla").html(ico_si);
                        $("#"+control+"_url").html("<a href='{{ url('/') }}"+ data.url+"' target='_blank'><i class='fa fa-hand-o-right' aria-hidden='true'></i> Archivo cargado.  Tamaño:  "+data.tamano+" </a>");

                    }
                    if(cargas_pendientes==0) {
                        $("#btn_grabar").val(texto_boton);
                        $("#btn_grabar").prop("disabled",false);
                    }

                },
                error: function (xhr, status, error) {
                    cargas_pendientes--;

                    var today = new Date();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    final = time;
                    console.log("Inicio: "+inicio);
                    console.log("Fin ( "+error+" ): "+final);

                    $("#"+control+"_casilla").html(ico_no);
                    $("#"+control+"_filename").val("");
                    $("#"+control+"_url").html("");
                   // alert(xhr.responseText);
                    Swal.fire('No se cargó el archivo, es muy grande.','Excede el tamaño máximo permitido de ','error');

                    if(cargas_pendientes==0) {
                        $("#btn_grabar").val(texto_boton);
                        $("#btn_grabar").prop("disabled",false);
                    }

                }
            });
        }

        function quitar(control) {
            $("#"+control+"_casilla").html(ico_no);
            $("#"+control+"_filename").val("");
            $("#"+control+"_url").html("");
        }
    </script>
@endpush



