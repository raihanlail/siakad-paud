<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIAKAD RA ALIFIA') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">

        <div class="min-h-screen flex">

            {{-- ── Left Panel (branding) ── shown on md+ --}}
            <div class="hidden md:flex md:w-1/2 relative flex-col justify-between p-12 overflow-hidden"
                 style="background-image: url('/BG.jpg'); background-size: cover; background-position: center;">

                {{-- Dark overlay --}}
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/80 via-indigo-800/70 to-blue-900/80"></div>

                {{-- Top: Logo / School name --}}
                <div class="relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <span class="text-white font-extrabold text-lg tracking-tight">SIAKAD RA ALIFIA</span>
                    </div>
                </div>

                {{-- Center: Tagline --}}
                <div class="relative z-10">
                    <h1 class="text-white text-4xl font-extrabold leading-tight tracking-tight">
                        Sistem Informasi<br>Akademik<br>
                        <span class="text-indigo-300">RA Alifia</span>
                    </h1>
                    <p class="text-indigo-200 text-sm mt-4 leading-relaxed max-w-xs">
                        Platform pengelolaan data siswa, guru, nilai, dan pembayaran sekolah secara terpadu.
                    </p>

                    {{-- Feature bullets --}}
                    <div class="mt-8 space-y-3">
                        @foreach ([
                            'Manajemen data siswa & kelas',
                            'Input & monitoring nilai akademik',
                            'Kelola pembayaran SPP',
                        ] as $feature)
                            <div class="flex items-center gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-indigo-400/30 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-indigo-100 text-sm">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Bottom: Footer --}}
                <div class="relative z-10">
                    <p class="text-indigo-300/60 text-xs">© {{ date('Y') }} RA Alifia. All rights reserved.</p>
                </div>
            </div>

            {{-- ── Right Panel (form) ────────────────────────────────────── --}}
            <div class="w-full md:w-1/2 flex flex-col justify-center items-center px-6 py-12 bg-gray-50">

                {{-- Mobile-only logo --}}
                <div class="flex md:hidden items-center gap-2 mb-8">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                        </svg>
                    </div>
                    <span class="font-extrabold text-gray-800 tracking-tight">SIAKAD RA ALIFIA</span>
                </div>

                {{-- Form card --}}
                <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-8">
                    {{ $slot }}
                </div>

                <p class="text-xs text-gray-400 mt-6 text-center">
                    Butuh bantuan? Hubungi administrator sekolah.
                </p>
            </div>

        </div>

    </body>
</html>