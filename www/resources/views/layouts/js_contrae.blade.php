{{-- Para contraer el menu lateral izquierda --}}
@push("js")
    <script>
        $(function() {
            $('[data-toggle="push-menu"]').pushMenu('toggle');
        });
    </script>
@endpush