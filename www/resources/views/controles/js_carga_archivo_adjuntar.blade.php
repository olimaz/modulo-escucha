{{--
    JavaScript del control de  la carga de archivo
    Es un archivo separado por si son varios controles
    Debe incluirse una única vez.

    //Este javascript llama a otro método, que además de cargar el archivo, lo adjunta a un expediente específico

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
                //upload(this);
                cargar_barra(this);
            }
        });



        $('#file').change(function () {
            if ($(this).val() != '') {
                //upload(this);
                cargar_barra(this);
            }
        });


        function quitar(control) {
            $("#"+control+"_casilla").html(ico_no);
            $("#"+control+"_filename").val("");
            $("#"+control+"_url").html("");
        }

        function actualizar_tabla() {
            $.ajax({
                url: " {{ url("/tabla_adjuntos/".$entrevistaIndividual->id_e_ind_fvt) }} ",
                type: 'GET',
                success: function (data) {
                    $("#div_tabla_adjuntos").html(data);
                },
                error: function (xhr, status, error) {
                    $("#div_tabla_adjuntos").html(error);
                }
            });

        }

        function cargar_barra(img) {
            var control = img.name;

            cargas_pendientes++;


            $("#"+control+"_casilla").html(ico_cargando);
            var progreso = $("#"+control+"_progreso");
            //console.log(progreso);

            var form_data = new FormData();
            form_data.append('file', img.files[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('control',img.name);
            form_data.append('id_expediente',{{ $entrevistaIndividual->id_e_ind_fvt }});
            var inicio = new Date();
            var final = new Date();
            $.ajax({
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = ((evt.loaded / evt.total) * 100);
                            percentComplete = Math.floor(percentComplete);
                            console.log('Completado: ' + percentComplete);
                            progreso.width(percentComplete + '%');
                            progreso.html(percentComplete+'%');
                        }
                    }, false);
                    return xhr;
                },
                url: "{{url('/upload_adjuntar')}}",
                data: form_data,
                cache: false,
                type: 'POST',
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function(){
                    progreso.width('0%');
                    progreso.html('0%');
                    var today = new Date();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    inicio = time;
                    console.log("Inicio: "+inicio);
                },
                success: function (data) {
                    progreso.css({
                        width: '0%'
                    });
                    var today = new Date();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    final = time;
                    console.log("Inicio: "+inicio);
                    console.log("Fin: "+final);
                    cargas_pendientes--;
                    if (data.exito !== 1) {
                        $("#"+control+"_casilla").html(ico_no);
                        $("#"+control+"_filename").val("");
                        $("#"+control+"_url").html("");
                        alert(data.mensaje);

                    }
                    else {
                        //$("#"+control+"_filename").val(data.url);
                        $("#"+control+"_casilla").html(ico_no);
                        //$("#"+control+"_url").html("<a href='{{ url('/') }}"+ data.url+"' target='_blank'><i class='fa fa-hand-o-right' aria-hidden='true'></i> Archivo cargado.  Tamaño:  "+data.tamano+" </a>");
                        //Actualizar listado de adjuntos
                        actualizar_tabla();
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        //alert("Archivo cargado exitosamente");
                        //Mostrar boton para diligenciar fichas
                        console.log(control);
                        if(control=='archivo_1') {
                            $("#btn_no").addClass('hidden');
                            $("#btn_si").removeClass('hidden');
                        }


                        Swal.fire(
                            ' <i class="fa fa-smile-o" aria-hidden="true"></i> Gracias por su contribución a la verdad ',
                            'El archivo especificado ya hace parte del expediente.',
                            'success'
                        );
                        //console.log(data);

                    }
                    if(cargas_pendientes==0) {
                        $("#btn_grabar").val(texto_boton);
                        $("#btn_grabar").prop("disabled",false);
                    }
                },
                error: function (xhr, status, error) {
                    cargas_pendientes--;
                    $("#"+control+"_casilla").html(ico_no);
                    $("#"+control+"_filename").val("");
                    $("#"+control+"_url").html("");
                    Swal.fire('Lo siento, no se cargó el archivo.','Excede el tamaño máximo permitido de {{ini_get("upload_max_filesize") }}','error');
                    var today = new Date();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    final = time;
                    console.log("Inicio: "+inicio);
                    console.log("Fin ( "+error+" ): "+final);
                    //console.log(error);
                    //alert("Problemas con la carga");
                    if(cargas_pendientes==0) {
                        $("#btn_grabar").val(texto_boton);
                        $("#btn_grabar").prop("disabled",false);
                    }
                }
            });
        }
    </script>
@endpush


