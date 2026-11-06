<!doctype html>
<html lang="id">
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Homi - Find Your Dream Home</title>
    
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    @stack('after-styles')
   
</head>
<body>
    @yield('content')

    @stack('after-scipts')
</body>