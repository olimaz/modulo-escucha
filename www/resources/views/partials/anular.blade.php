@can('sistema-abierto')
    @can('nivel-1')
        <button class="btn btn-danger pull-right no-print" title="Anular expediente" data-toggle="tooltip" onclick="anular_confirmar_{{ $anular_id }}()"><i class="fa fa-trash"></i></button>


        @push('js')
            <script>
                function anular_confirmar_{{ $anular_id }}() {
                    Swal.fire({
                        title: '¿Desea anular este expediente?',
                        //icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, deseo anularlo',
                        cancelButtonText: 'Mejor no'
                    }).then((result) => {
                        if (result.value) {
                            document.location='{{ $anular_url }}';
                        }
                    })


                }
            </script>
        @endpush
    @endcan
@endcan