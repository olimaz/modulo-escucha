{{-- HTML mínimo que incluye CSS y JS.  incluye HEAD y BODY sin ningun div ni contenido --}}
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    @php($txt_titulo = isset($txt_titulo) ? $txt_titulo: "")
    @if(strlen($txt_titulo) > 0)
        <title>
            @yield('title_prefix', config('adminlte.title_prefix', ''))
            {{ $txt_titulo }}
            @yield('title_postfix', config('adminlte.title_postfix',''))
        </title>
    @else
        <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
            @yield('title', config('adminlte.title', 'Entrevistas'))
            @yield('title_postfix', config('adminlte.title_postfix',''))</title>
    @endif

    {{-- FAVICONS https://realfavicongenerator.net/ --}}

    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('favicon/favicon-16x16.png') }}" >
    <link rel="manifest" href="{{ url('favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ url('favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">



    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ url('adminlte3/plugins/fa5/css/all.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('adminlte3/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <style>
        .typeahead .active, .dropdown-item:hover {
            z-index: 2;
            background-color: #007bff !important;
            border-color: #007bff !important;
        }

        .typeahead .active .dropdown-item {
            color: white !important;
        }

    </style>



    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('adminlte3/dist/css/adminlte.min.css') }}">


    {{-- DataTables

    <link rel="stylesheet" href="{{ url('adminlte3/plugins/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">
    --}}
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ url('adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    @include('layouts.fonts')

    @stack("head") {{-- Por si hay que meter encabezados --}}

    @yield('adminlte_css')


</head>
<body class="hold-transition sidebar-mini-no layout-top-nav layout-fixed layout-navbar-fixed   ">
@yield('body')


{{-- JAVASCRIPT MINIMO --}}
{{-- jQuery: el mismo que en el otro adminlte --}}
<script src="{{ url('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ url('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte3/dist/js/adminlte.min.js') }}"></script>


{{-- OTROS JS --}}
{{-- datatables
<script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/DataTables-1.10.24/js/dataTables.bootstrap4.min.js') }}"></script>
--}}
<script src="{{ url('adminlte3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>



<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>

{{-- Dependent Drop Down --}}
<script src="{{ url('js/dependent-dropdown.js') }}" type="text/javascript"></script>

{{-- Date Picker --}}
<script src="{{ url('js/picker.js') }}" type="text/javascript"></script>
<script src="{{ url('js/picker.date.js') }}"></script>
{{-- Time Picker --}}
<script src="{{ url('js/picker.time.js') }}" type="text/javascript"></script>

{{-- DateRangePicker --}}
<script src="{{ url('js/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ url('js/daterangepicker.js') }}" type="text/javascript"></script>

{{-- echarts
<script src="{{ url('js/echarts.min.js') }}" type="text/javascript"></script>
<script src="{{ url('vendor/echarts-5.0.1/dist/echarts.js') }}" type="text/javascript"></script>

--}}
<script src="{{ url('vendor/echarts-4.9.0/dist/echarts.js') }}" type="text/javascript"></script>

{{-- iCheck --}}
<script src="{{ url('vendor/adminlte/plugins/iCheck/icheck.js') }}" type="text/javascript"></script>


{{-- Exportar a excel por JavaScript--}}
<script src="{{ url('js/jquery.table2excel.min.js') }}" type="text/javascript"></script>

{{-- Sweet alert --}}
<script src="{{ url('js/sweetalert2.all.min.js') }}" type="text/javascript"></script>

{{-- Autocompletar: https://github.com/bassjobsen/Bootstrap-3-Typeahead --}}
<script src="{{ url('js/bootstrap3-typeahead.min.js') }}" type="text/javascript"></script>

{{-- editor wysiswyg  https://summernote.org/getting-started/#basic-api --}}
<script src="{{ url('vendor/wysiwyg/summernote.min.js') }}" type="text/javascript"></script>
<script src="{{ url('vendor/wysiwyg/lang/summernote-es-ES.min.js') }}" type="text/javascript"></script>
    <!-- Select2 -->
    <script src="{{ url('js/select2.full.min.js') }}"></script>



{{-- Habilitar el tooltip --}}
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({ container: 'body'});
        $('[data-toggle="popover"]').popover({ container: 'body', html:true});
    })

</script>



{{-- Para javascript al final extras --}}

@stack('js')
@yield('js')

</body>
</html>
