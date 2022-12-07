{{--
    JavaScript del control de  la carga de archivo
    Espera estos parametros

    $id_primaria = llave primaria de la entrevista, equivalente a: "id_e_ind_fvt
    $url_upload_adjuntar = controller al que apunta, equivalente a "upload_controller_pr"
    $url_tabla_adjuntos = enlace que actualiza el listado de adjuntos, "tabla_adjuntos_pr"

--}}
{{-- Para la traza de fallas  --}}
@php($codigo = isset($codigo) ? $codigo : "(desconocido)")

@push('js')
    //Version integrada

    <script>

        var ico_si='<i class="fa fa-check-square-o fa-4x text-green" aria-hidden="true"></i>';
        var ico_no='<i class="fa fa-square-o fa-4x text-red" aria-hidden="true"></i>';
        var ico_cargando='<i class="fa fa-spinner fa-spin fa-2x fa-fw" ></i>';
        var ico_cargando_boton='Cargando archivos...';

        var cargas_pendientes=0;
        var texto_boton = $("#btn_grabar").val(); //Guardar el texto que tiene al inicio

        //Agregar listener
        function cargar(control) {
            $('#'+control).click();
        }

        //Actualizar el porcentaje de carga
        $('.carga_automatica').change(function () {
            if ($(this).val() != '') {
                cargar_barra(this);
            }
        });



        //Otro Listener
        $('#file').change(function () {
            if ($(this).val() != '') {
                cargar_barra(this);
            }
        });


        //Quitar el adjunto
        function quitar(control) {
            $("#"+control+"_casilla").html(ico_no);
            $("#"+control+"_filename").val("");
            $("#"+control+"_url").html("");
        }

        //Actualizar el listado de
        function actualizar_tabla() {
            $.ajax({
                url: " {{ url("/".$url_adjuntos."/".$id_primaria) }} ",
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
            form_data.append('id_expediente',{{ $id_primaria }});
            var inicio = new Date();
            var final = new Date();
            $.ajax({
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
                url: "{{ url($url_upload) }}",
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
                    console.log("Inicio: "+time);
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
                    //console.log(data);
                    cargas_pendientes--;
                    if (data.exito !== 1) {
                        $("#"+control+"_casilla").html(ico_no);
                        $("#"+control+"_filename").val("");
                        $("#"+control+"_url").html("");
                        $.get( "{{ action("UploadController@registrar_falla") }}", { id_primaria: "{{ $id_primaria }}", codigo: "{{ $codigo }}", control: img.name } )
                            .done(function( data ) {
                                console.log( "Falla registrada: " + data );
                            });
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
                        //console.log(control);
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
                    //Registrar traza
                    $.get( "{{ action("UploadController@registrar_falla") }}", { id_primaria: "{{ $id_primaria }}", codigo: "{{ $codigo }}", control: img.name } )
                        .done(function( data ) {
                            console.log( "Falla registrada: " + data );
                        });
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


