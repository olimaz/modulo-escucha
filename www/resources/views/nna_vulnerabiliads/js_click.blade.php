@push('js')
    <script>

        $( "#edad" ).change(function() {
            var val =  $( "#edad" ).val();
            if(val < 12) {
                $("#menor_12_1").prop('checked',true)
            }
            else {
                $("#menor_12_2").prop('checked',true)
            }
        });

        var control_familia=$("input[name='vive_familia']");
        control_familia.change(function() {
            var valor = $('input[name=vive_familia]:checked').val();
            if(valor==1) {
                $("#grupo_familia").removeClass('hidden');
            }
            else {
                $("#vive_padre_madre_2").prop('checked',true);
                $("#vive_rep_legal_2").prop('checked',true);
                $("#vive_familia_extensa_2").prop('checked',true);
                $("#grupo_familia").addClass('hidden');
            }
           //alert("cambio: "+valor);
        });

        var control_abuso=$("input[name='abuso_exposicion']");
        control_abuso.change(function() {
            var valor = $('input[name=abuso_exposicion]:checked').val();
            if(valor==1) {
                $("#grupo_abuso").removeClass('hidden');
            }
            else {
                $("#abuso_fisico_2").prop('checked',true);
                $("#abuso_sexual_2").prop('checked',true);
                $("#abuso_abandono_2").prop('checked',true);
                $("#abuso_ajustes_2").prop('checked',true);
                $("#grupo_abuso").addClass('hidden');
            }
            //alert("cambio: "+valor);
        });

    </script>
@endpush