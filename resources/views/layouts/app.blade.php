<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SIAKAD RA ALIFIA</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            [x-cloak] { display: none !important; }
            .main-content { transition: all 0.3s ease; }
            ::-webkit-scrollbar { width: 5px; }
            ::-webkit-scrollbar-track { background: #f1f1f1; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#f8fafc] text-slate-900 h-full overflow-hidden">
        
        <div class="flex h-full overflow-hidden" x-data="{ sidebarOpen: false }">
            
            @include('layouts.navigation')

            <div class="flex flex-col flex-1 min-w-0 h-full">
                
                <div class="absolute top-0 left-0 right-0 h-48 bg-gradient-to-b from-blue-100/40 to-transparent pointer-events-none"></div>

                @isset($header)
                    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-20">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="flex items-center justify-between h-16 md:h-20">
                                <button @click="sidebarOpen = true" class="p-2 -ml-2 text-slate-600 lg:hidden focus:outline-none">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                </button>

                                <div class="flex flex-col items-end sm:items-start flex-1 sm:flex-none">
                                    <h1 class="text-lg md:text-xl font-bold text-slate-800 tracking-tight leading-none">
                                        {{ $header }}
                                    </h1>
                                    <p class="text-[10px] md:text-xs text-slate-500 font-medium hidden sm:block mt-1">
                                        Sistem Informasi Akademik RA Alifia
                                    </p>
                                </div>
                            </div>
                        </div>
                    </header>
                @endisset

                <main class="flex-1 overflow-y-auto relative z-10 custom-scrollbar focus:outline-none">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="animate-fade-in-up">
                            {{ $slot }}
                        </div>
                    </div>
                </main>

                <footer class="bg-white border-t border-slate-200 px-4 md:px-8 py-4 z-20">
                    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-[10px] font-bold text-slate-400 uppercase tracking-widest gap-2">
                        <p class="text-center md:text-left">&copy; {{ date('Y') }} SIAKAD RA ALIFIA</p>
                        <div class="flex space-x-6">
                            <a href="#" class="hover:text-blue-600 transition">Support</a>
                            <a href="#" class="hover:text-blue-600 transition">Privacy</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>