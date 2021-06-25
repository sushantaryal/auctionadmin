<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@hasSection('title')@yield('title') - {{ config('app.name', 'Pylon Auction') }}@else{{ config('app.name', 'Pylon Auction') }}@endif</title>

    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/ico">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="hold-transition login-page">
    @yield('content')
</body>
</html>