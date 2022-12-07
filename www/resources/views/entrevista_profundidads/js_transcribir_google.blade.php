@push("js")
    <script>
        function transcribir(id) {
            var destino = "{{ url('/entrevistaProfundidadAdjuntos/') }}/"+id+"/trans";
            $.ajax({
                url: destino,
                type: 'GET',
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    actualizar_tabla();

                },
                error: function (xhr, status, error) {
                    actualizar_tabla();
                }
            });
        }

        function transcribir_revisar(id) {
            var destino = "{{ url('/entrevistaProfundidadAdjuntos/') }}/"+id+"/trans_revisar";
            $.ajax({
                url: destino,
                type: 'GET',
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if(data.transcrito) {
                        Swal.fire(
                            'Archivo transcrito exitosamente',
                            'El sistema ya adjuntó dicho archivo al expediente',
                            'success'
                        );
                        actualizar_tabla();

                    }
                    else {
                        Swal.fire(
                            'Archivo pendiente de transcribir',
                            'La tarea de transcripcion se encuentra en cola, su procesamiento no ha sido finalizado.'
                        );
                    }
                    //console.log(data.mensaje);
                    //console.log(data.detalle);
                },
                error: function (xhr, status, error) {
                    Swal.fire('Problemas al consultar el servicio.','Algo extraño pasó al revisar la tarea, favor de reportar este problema.','error');
                }
            });
        }


    </script>

@endpush