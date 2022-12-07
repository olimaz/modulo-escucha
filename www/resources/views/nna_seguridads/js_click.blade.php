@push('js')
    <script>
        var control=$("input[name='alguien_acompana']");
        control.change(function() {
            var valor = $('input[name=alguien_acompana]:checked').val();
            if(valor==1) {
                $("#grupo_acompana").removeClass('hidden');
            }
            else {
                $("#alguien_acompana_padre_2").prop('checked',true);
                $("#alguien_acompana_ts_2").prop('checked',true);
                $("#alguien_acompana_otro_2").prop('checked',true);
                $("#grupo_acompana").addClass('hidden');
            }
           //alert("cambio: "+valor);
        });


        function buscar_vulnerabilidad(id) {
            var url = '{{ url('json/vulnerabilidad') }}'+'/'+id;

            $.getJSON( url, function( data ) {
                console.log(data);
                var mostrar=false;
                if(data.id_nna_vulnerabilidad > 0) {
                    if(data.dictamen !==1) {
                        alert("Evaluación con dictamen negativo");
                    }
                    else {
                        mostrar=true;
                        $("#id_nna_vulnerabilidad").val(data.id_nna_vulnerabilidad);
                        $("#vulnerabilidad").val(data.codigo);
                    }
                }
                else {
                    alert('Correlativo no encontrado en las evaluaciones de vulnerabilidad');
                }

                if(mostrar) {
                    $("#todos_campos").removeClass('hidden');
                }
                else {
                    $("#todos_campos").addClass('hidden');
                }
            });
        }

        $('#num_vulnerabilidad').change(function() {
            buscar_vulnerabilidad($('#num_vulnerabilidad').val());
        });
    </script>
@endpush