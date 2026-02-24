<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-white antialiased bg-slate-900">
    <div class="min-h-screen flex flex-col items-center justify-center px-6 py-10 bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-slate-400" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 shadow-xl overflow-hidden rounded-2xl">
            {{ $slot }}
        </div>
    </div>
</body>

</html>