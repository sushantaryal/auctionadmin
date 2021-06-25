<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title')@yield('title') - {{ config('app.name', 'Pylon Auction') }}@else{{ config('app.name', 'Pylon Auction') }}@endif</title>

    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/ico">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('styles')
</head>
<body class="layout-fixed sidebar-mini">
    <div class="wrapper">
        @include('partials._navbar')

        @include('partials._navigation')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('heading')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                @yield('breadcrumbs')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content pb-4">
                @yield('content')
            </section>

        </div>
    </div>
    
    <script src="{{ mix('js/app.js') }}"></script>
    @include('partials._notification')
    @stack('scripts')
</body>
</html>