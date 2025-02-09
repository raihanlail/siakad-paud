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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-blue-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-blue-50 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const openModalButton = document.querySelector("[data-modal-toggle='tambahSiswaModal']");
                const closeModalButton = document.querySelector("[data-modal-hide='tambahSiswaModal']");
                const modal = document.getElementById("tambahSiswaModal");
        
                if (openModalButton) {
                    openModalButton.addEventListener("click", function () {
                        modal.classList.remove("hidden");
                    });
                }
        
                if (closeModalButton) {
                    closeModalButton.addEventListener("click", function () {
                        modal.classList.add("hidden");
                    });
                }
            });
        </script>
    </body>
</html>
