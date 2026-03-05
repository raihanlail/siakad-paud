<div x-show="sidebarOpen" 
     x-cloak
     @click="sidebarOpen = false" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-40 lg:hidden bg-slate-900/60 backdrop-blur-sm">
</div>

<aside 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
    class="fixed inset-y-0 left-0 z-50 w-72 bg-indigo-800 text-white transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 shadow-2xl flex flex-col h-screen overflow-hidden">
    
    <div class="flex items-center justify-between px-6 h-20 bg-indigo-900/50 border-b border-indigo-700/50 flex-shrink-0">
        <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="flex items-center space-x-3 group">
            <div class="p-2 bg-white/10 rounded-lg group-hover:bg-white/20 transition">
                <x-application-logo class="h-7 w-auto fill-current text-indigo-200" />
            </div>
            <div class="flex flex-col">
                <span class="font-black text-lg leading-none tracking-tight">SI ALIFIA</span>
                <span class="text-[10px] text-indigo-300 uppercase font-black tracking-[0.2em] mt-1">Akademik</span>
            </div>
        </a>
        
        <button @click="sidebarOpen = false" class="lg:hidden p-2 rounded-md text-indigo-200 hover:text-white hover:bg-white/10 transition">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">
        @php
            $role = Auth::user()->role;
            $dashRoute = ($role == 'admin') ? route('admin.dashboard') : ($role == 'guru' ? route('guru.dashboard') : route('dashboard'));
        @endphp

        <x-sidebar-link :href="$dashRoute" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')" icon="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
            {{ __('Dashboard') }}
        </x-sidebar-link>

        @if($role == 'admin')
            <div class="pt-6 pb-2 px-4 text-[10px] font-black text-indigo-400/80 uppercase tracking-[0.25em]">
                {{ __('Master Data') }}
            </div>
            
            <x-sidebar-link :href="route('admin.siswa')" :active="request()->routeIs('admin.siswa')" icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                {{ __('Data Siswa') }}
            </x-sidebar-link>
             <x-sidebar-link :href="route('admin.kelas')" :active="request()->routeIs('admin.kelas')" icon="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                {{ __('Data Kelas') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('admin.guru')" :active="request()->routeIs('admin.guru')" icon="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                {{ __('Data Guru') }}
            </x-sidebar-link>

              <x-sidebar-link :href="route('admin.orang-tua')" :active="request()->routeIs('admin.orang-tua')" icon="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                {{ __('Data Orang Tua') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('admin.mapel')" :active="request()->routeIs('admin.mapel')" icon="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                {{ __('Mata Pelajaran') }}
            </x-sidebar-link>

              <x-sidebar-link :href="route('admin.jadwal')" :active="request()->routeIs('admin.jadwal')" icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                {{ __('Kelola Jadwal') }}
            </x-sidebar-link>

            <div class="pt-6 pb-2 px-4 text-[10px] font-black text-indigo-400/80 uppercase tracking-[0.25em]">
                {{ __('Administrasi') }}
            </div>
            
            <x-sidebar-link :href="route('admin.pembayaran')" :active="request()->routeIs('admin.pembayaran')" icon="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                {{ __('Laporan Bayar') }}
            </x-sidebar-link>
        @endif

        @if($role == 'user')
            <div class="pt-6 pb-2 px-4 text-[10px] font-black text-indigo-400/80 uppercase tracking-[0.25em]">
                {{ __('Wali Murid') }}
            </div>

             <x-sidebar-link :href="route('user.jadwal')" :active="request()->routeIs('user.jadwal')" icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                {{ __('Lihat Jadwal') }}
            </x-sidebar-link>
            
            <x-sidebar-link :href="route('user.bayar')" :active="request()->routeIs('user.bayar')" icon="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                {{ __('Bayar SPP') }}
            </x-sidebar-link>
        @endif

        @if($role == 'guru')
                <div class="pt-6 pb-2 px-4 text-[10px] font-black text-indigo-400/80 uppercase tracking-[0.25em]">
                    {{ __('Guru') }}
                </div>
         <x-sidebar-link :href="route('guru.jadwal')" :active="request()->routeIs('guru.jadwal')" icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                {{ __('Lihat Jadwal') }}
            </x-sidebar-link>

        @endif
    </nav>

    <div class="p-4 bg-indigo-900/40 border-t border-indigo-700/50 flex-shrink-0">
        <div class="flex items-center space-x-3 mb-4 px-2">
            <div class="flex-shrink-0 relative group">
                <img class="h-11 w-11 rounded-xl object-cover border-2 border-indigo-500/50 group-hover:border-white/50 transition duration-300" 
                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff&bold=true" 
                     alt="{{ Auth::user()->name }}">
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-indigo-900 rounded-full"></div>
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold truncate leading-none text-white">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-indigo-300 uppercase font-black tracking-tighter mt-1.5 flex items-center">
                    <span class="bg-indigo-700/50 px-1.5 py-0.5 rounded">{{ Auth::user()->role }}</span>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
            <a href="{{ route('profile.edit') }}" class="flex items-center justify-center py-2.5 bg-indigo-700 hover:bg-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">
                {{ __('Profil') }}
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center py-2.5 bg-rose-600 hover:bg-rose-500 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all text-white shadow-lg shadow-rose-900/20">
                    {{ __('Keluar') }}
                </button>
            </form>
        </div>
    </div>
</aside>

<style>
    /* Custom Thin Scrollbar for Sidebar */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(165, 180, 252, 0.2); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(165, 180, 252, 0.4); }
</style>