<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ companyDetails($company->company_id)->title }}</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="" type="image/x-icon" />
    <!-- template bootstrap -->
    <link href="{{ asset('assets/css/template.min.css') }}" rel='stylesheet prefetch'>
    <!-- roboto -->
    <link href="{{ asset('assets/css/roboto.css') }}" rel='stylesheet'>
    <!-- material-design -->
    <link href="{{ asset('assets/css/material-design.css') }}" rel='stylesheet'>
    <!-- small-n-flat -->
    <link href="{{ asset('assets/css/small-n-flat.css') }}" rel='stylesheet'>
    <!-- font-awesome -->
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel='stylesheet'>
    <!-- jquery-ui -->
    <link href="{{ asset('assets/css/jquery-ui.min.css') }}" rel='stylesheet'>
    <!-- datatable -->
    <link href="{{ asset('assets/css/dataTables.min.css') }}" rel='stylesheet'>
    <!-- select2 -->
    <link href="{{ asset('assets/css/select2.min.css') }}" rel='stylesheet'>
    <!-- custom style -->
    <link href="{{ asset('assets/css/style.css') }}" rel='stylesheet'>
    <!-- Page styles -->
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('intelInput/style.css') }}">

    <!-- Jquery  -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <style>
        .iti {
            display: block !important;
        }
    </style>
</head>

<body class="cm-no-transition cm-1-navbar loader-process">

    <div class="loader">
        <div>
            <span>G</span>
            <span>O</span>
            <span></span>
            <span>K</span>
            <span>I</span>
            <span>I</span>
            <span>W</span>
        </div>
    </div>

    <!-- Starts of Header/Menu -->
    <header id="cm-header">
        <nav class="cm-navbar cm-navbar-primary">
            <div class="cm-flex text-center">
                <h1 class="clearfix">{{ companyDetails($company->company_id)->title }}</h1>
            </div>
        </nav>
    </header>
    <!-- Ends of Header/Menu -->

    <div id="global">

        <div class="container-fluid">
            <!-- Starts of Message -->
            @yield('info.message')
            <!-- Ends of Message -->

            <!-- Starts of Content -->
            @yield('content')
            <!-- Ends of Contents -->
        </div>

        <!-- Starts of Copyright -->
        <footer class="cm-footer text-right">
            <span class="pull-left text-center">Powered By Gokiiw</span>
            <span class="pull-right text-center">
                Owned By <a href="https://softafrique.net/" class="text-decoration-none" target="_blank">Softafrique
                    LLC</a>
            </span>
        </footer>
        <!-- Ends of Copyright -->
    </div>


    <!-- All js -->
    <!-- bootstrp -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- select2 -->
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <!-- juery-ui -->
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- jquery.mousewheel.min -->
    <script src="{{ asset('assets/js/jquery.mousewheel.min.js') }}"></script>
    <!-- jquery.cookie.min -->
    <script src="{{ asset('assets/js/jquery.cookie.min.js') }}"></script>
    <!-- fastclick -->
    <script src="{{ asset('assets/js/fastclick.min.js') }}"></script>
    <!-- template -->
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <!-- datatable -->
    <script src="{{ asset('assets/js/dataTables.min.js') }}"></script>
    <!-- custom script -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @if (session()->has('info'))
        <script>
            swal("", "{{ session('info') }}", "info");
        </script>
    @endif

    <script src="{{ asset('intelInput/jquery.min.js') }}"></script>
    <script src="{{ asset('intelInput/script.min.js') }}"></script>
    <script>
        $(function() {
            $("#mobile").intlTelInput({
                allowExtensions: true,
                autoFormat: false,
                autoHideDialCode: false,
                autoPlaceholder: false,
                // defaultCountry: "gh",
                defaultCountry: null,
                // ipinfoToken: "yolo",
                nationalMode: false,
                numberType: "MOBILE",
                // preferredCountries: ['gh', 'us'],
                preventInvalidNumbers: true,
            });
        });
    </script>

    <!-- Page Script -->
    @stack('scripts')
</body>

</html>
