<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Page Not Found</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-blue-100 flex items-center justify-center">
            <div class="text-center space-y-6">
                <div class="space-y-2">
                    <h1 class="text-6xl font-bold text-blue-800">404</h1>
                    <h2 class="text-3xl font-semibold text-gray-700">Page Not Found</h2>
                </div>
                <p class="text-xl text-gray-600">Maaf, sepertinya halaman ini tidak tersedia</p>
                <div class="mt-8">
                    <a href="{{route('dashboard')}}" class="bg-blue-600 hover:bg-blue-700 text-black font-semibold px-6 py-3 rounded-lg transition duration-300">
                        Back to Home
                    </a>
                </div>
                <div class="mt-4">
                    <img src="https://illustrations.popsy.co/gray/crashed-error.svg" alt="404 illustration" class="w-64 h-64 mx-auto">
                </div>
            </div>
        </div>
    </body>
</html>