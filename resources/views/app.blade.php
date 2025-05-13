<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    @inertiaHead
    {{-- @routes --}}
    <!-- FAVICON -->
    <link rel="icon" href="{{ asset('icons8-library-16.png') }}" type="image/x-icon" />
</head>

<body>
    @inertia
</body>

</html>
