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


            $("#"+control+"_casilla").html(ico_cargando);

            var form_data = new FormData();
            form_data.append('file', img.files[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('control',img.name);
            form_data.append('id_expediente',{{ $entrevistaEtnica->id_entrevista_etnica }});


            $("#btn_grabar").prop("disabled",true);
            $("#btn_grabar").val(ico_cargando_boton);
            $.ajax({
                url: "{{url('/upload_adjuntar_ee')}}",
                data: form_data,
                type: 'POST',
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
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
                        Swal.fire(
                            'Archivo cargado exitosamente',
                            'El sistema ya adjuntó dicho archivo al expediente',
                            'success'
                        )

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

                    //alert("Problemas con la carga");
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

        function actualizar_tabla() {
            $.ajax({
                url: " {{ url("/tabla_adjuntos_ee/".$entrevistaEtnica->id_entrevista_etnica) }} ",
                type: 'GET',
                success: function (data) {
                    $("#div_tabla_adjuntos").html(data);
                },
                error: function (xhr, status, error) {
                    $("#div_tabla_adjuntos").html(error);
                }
            });

        }
    </script>
@endpush



