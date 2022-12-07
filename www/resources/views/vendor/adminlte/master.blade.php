<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


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
{{--    <link rel="manifest" href="{{ url('favicon/site.webmanifest') }}">--}}
    <link rel="mask-icon" href="{{ url('favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    {{--
    <link rel="icon" href="{{ url('favicon/favicon.ico') }}" type="image/x-icon" />
    --}}



    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">

    {{-- iCheck --}}
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/all.css') }}">

    @if(config('adminlte.plugins.select2'))
        <!-- Select2 -->
            <link rel="stylesheet" href="{{ url('css/select2.min.css') }}">

    @endif

    {{-- wysiwyg CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/wysiwyg/summernote-bs4.min.css') }}">





    @if(config('adminlte.plugins.datatables'))
        <!-- DataTables with bootstrap 3 style -->
            <link rel="stylesheet" href="{{ url('css/dataTables.bootstrap.min.css') }}">
    @endif

<!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}?ultimo=20200826">


    {{-- date picker --}}
    <link rel="stylesheet" href="{{ url('css/datepicker/default.css') }}">
    <link rel="stylesheet" href="{{ url('css/datepicker/default.date.css') }}">
    <link rel="stylesheet" href="{{ url('css/datepicker/default.time.css') }}">

    {{--  date rage picker --}}
    <link rel="stylesheet" href="{{ url('css/daterangepicker.css') }}">


    {{--  date rage picker opcion 2
    <link rel="stylesheet" href="{{ url('css/daterangepicker.min.css') }}">
    --}}

    {{-- sweet alert --}}
    <link rel="stylesheet" href="{{ url('css/sweetalert2.min.css') }}">
    <style>
        .swal2-popup {
            font-size: 1.6rem !important;
        }
    </style>



    @stack("head") {{-- Por si hay que meter encabezados --}}

    @yield('adminlte_css')

{{--
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
--}}

    {{--
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    --}}

    <!-- Select 2 -->
    <style>
        .select2-container .select2-selection__rendered > *:first-child.select2-search--inline {
            width: 100% !important;
        }
        .select2-container .select2-selection__rendered > *:first-child.select2-search--inline .select2-search__field {
            width: 100% !important;
        }
        .select2-container *:focus {
            border-color: #3c8dbc;
            box-shadow: none;
        }
    </style>


    <style>
        /* source-sans-pro-300 - latin-ext_latin */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: normal;
            font-weight: 300;
            src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.eot') }}'); /* IE9 Compat Modes */
            src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.eot') }}'); /* IE9 Compat Modes */
            src: local('Source Sans Pro Light'), local('SourceSansPro-Light'),
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
        }
        /* source-sans-pro-300italic - latin-ext_latin */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: italic;
            font-weight: 300;
            src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300italic.eot') }}'); /* IE9 Compat Modes */
            src: local('Source Sans Pro Light Italic'), local('SourceSansPro-LightItalic'),
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300italic.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300italic.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300italic.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300italic.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300italic.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
        }
        /* source-sans-pro-regular - latin-ext_latin */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: normal;
            font-weight: 400;
            src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-regular.eot') }}'); /* IE9 Compat Modes */
            src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'),
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-regular.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-regular.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-regular.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-regular.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-regular.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
        }
        /* source-sans-pro-italic - latin-ext_latin */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: italic;
            font-weight: 400;
            src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-italic.eot') }}'); /* IE9 Compat Modes */
            src: local('Source Sans Pro Italic'), local('SourceSansPro-Italic'),
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-italic.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-italic.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-italic.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-italic.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-italic.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
        }
        /* source-sans-pro-600 - latin-ext_latin */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: normal;
            font-weight: 600;
            src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600.eot') }}'); /* IE9 Compat Modes */
            src: local('Source Sans Pro SemiBold'), local('SourceSansPro-SemiBold'),
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
        }
        /* source-sans-pro-600italic - latin-ext_latin */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: italic;
            font-weight: 600;
            src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600italic.eot') }}'); /* IE9 Compat Modes */
            src: local('Source Sans Pro SemiBold Italic'), local('SourceSansPro-SemiBoldItalic'),
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600italic.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600italic.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600italic.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600italic.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600italic.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
        }
        /* source-sans-pro-700 - latin-ext_latin */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: normal;
            font-weight: 700;
            src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700.eot') }}'); /* IE9 Compat Modes */
            src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'),
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
        }
        /* source-sans-pro-700italic - latin-ext_latin */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: italic;
            font-weight: 700;
            src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700italic.eot') }}'); /* IE9 Compat Modes */
            src: local('Source Sans Pro Bold Italic'), local('SourceSansPro-BoldItalic'),
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700italic.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700italic.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700italic.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700italic.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700italic.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
        }

    </style>
</head>
<body class="hold-transition @yield('body_class')">

@yield('body')

<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}?ultimo=20200826"></script>



{{-- Resaltar en amarillo  https://markjs.io/ --}}
<script src="{{ url('js/jquery.mark.min.js') }}" type="text/javascript"></script>


<!-- DataTables with bootstrap 3 renderer -->
@if(config('adminlte.plugins.datatables'))

    <script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('js/dataTables.bootstrap.min.js') }}"></script>


@endif

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

{{-- daterange, otra opcion
<script src="{{ url('js/knockout-3.5.0.js') }}" type="text/javascript"></script>
<script src="{{ url('js/daterangepicker.min.js') }}" type="text/javascript"></script>
--}}




{{-- echarts --}}
<script src="{{ url('js/echarts.min.js') }}" type="text/javascript"></script>

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

{{-- Libreria D3 --}}
{{--
<script src="{{ url('js/d3.min.js') }}" type="text/javascript"></script>
--}}


@if(config('adminlte.plugins.select2'))
    <!-- Select2 -->
    <script src="{{ url('js/select2.full.min.js') }}"></script>
@endif

{{--
@if(config('adminlte.plugins.chartjs'))
    <!-- ChartJS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
@endif
--}}

@yield('adminlte_js')

{{-- Habilitar el tooltip --}}
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({ container: 'body'});
        $('[data-toggle="popover"]').popover({ container: 'body', html:true});
    })

</script>

</body>
</html>
