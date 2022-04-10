@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ config('app.name') }} » @yield("page-name")</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('img/gesam_logo.png') }}" type="image/x-icon">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">

    {{-- Bootstrap --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
    {{-- Waves --}}
    <link rel="stylesheet" href="{{ asset('css/waves.min.css') }}" type="text/css" media="all">

    {{-- Feather Icon --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/feather.css') }}">

    {{-- Font Awesome --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    {{-- <script src="{{ asset('js/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('js/_jquery.min.js') }}"></script>

    {{-- Select --}}
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    <!-- Datatables -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('css/datatables.min.css') }}" />
    <script type="text/javascript"
        src="{{ asset('js/datatables.min.js') }}">
    </script>
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js">
    </script> --}}
    {{-- Morris Chart --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/morris.css') }}">

    {{-- Custom Style --}}
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/widget.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
    <link href="{{ asset('css/material-icons.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-multiselect.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/multi-select.css') }}" />
    
    <!-- Sweet alert 2 -->
    <script src="{{ asset('js/sweetalert2.js') }}"></script>

    {{-- Load map.js --}}
    {{-- {!! $map['js'] !!} --}}

    <style>
        .select2-container {
            height: 35px;
        }

        .select2-selection {
            height: 35px;
        }

        /* .datatable {
                border-collapse: collapse !important;
                font-size: 0.9em !important;
                 width: 100% !important;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.15) !important;
            }

            .datatable thead tr {
                background-color: #263544 !important;
                color: #ffffff !important;
                text-align: left !important;
            }

            .datatable th,
            .datatable td {
                padding: 12px 15px !important;
            }

            .datatable tbody tr {
                border-bottom: 1px solid #dddddd !important;
            }

            .datatable tbody tr:nth-of-type(even) {
                background-color: #f3f3f3;
            }

            .datatable tbody tr:last-of-type {
                border-bottom: 2px solid #263544 !important;
            }

            .datatable tbody tr.active-row {
                font-weight: bold !important;
                color: #263544 !important;
            } */

        .activeClass {
            background-color: rgb(152, 214, 152);
        }

        .redClass {
            background-color: rgb(243, 73, 43);
        }

        .whiteText {
            color: rgb(255, 255, 255);
        }

    </style>

    <script>
        const APP_URL = "{{ config('app.url') }}";
        const CREATEUSER = "{{ Auth::user()->id }}";
        const ROLE = "{{ Auth::user()->usertype }}";
    </script>

@show
