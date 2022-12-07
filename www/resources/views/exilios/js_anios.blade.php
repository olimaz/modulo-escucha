{{-- Si en año de la fecha de llegada es menor que el de salida, copia el valor de la de salida --}}

@push("js")
    <script>
        $(function(){
            $("#fecha_salida_a").on('change',function() {
                if($("#fecha_llegada_a").val() <  $("#fecha_salida_a").val()) {
                    //console.log('cambiar');
                    $("#fecha_llegada_a").val($("#fecha_salida_a").val()).trigger('change');
                }
                if($("#fecha_asentamiento_a").val() <  $("#fecha_salida_a").val()) {
                    //console.log('cambiar');
                    $("#fecha_asentamiento_a").val($("#fecha_salida_a").val()).trigger('change');
                }
            })
        });
    </script>
@endpush