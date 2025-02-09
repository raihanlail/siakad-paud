<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-400 to-blue-600 border-b border-gray-100 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="transition-transform hover:scale-105">
                        <x-application-logo class="block h-10 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="Auth::user()->role == 'admin' ? route('admin.dashboard') : route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-blue-200 transition-colors duration-200">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->role == 'admin') 
                    <x-nav-link :href="route('admin.siswa')" :active="request()->routeIs('admin.siswa')" class="text-white hover:text-blue-200 transition-colors duration-200">
                        {{ __('Data Siswa') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.guru')" :active="request()->routeIs('admin.guru')" class="text-white hover:text-blue-200 transition-colors duration-200">
                        {{ __('Data Guru') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.mapel')" :active="request()->routeIs('admin.mapel')" class="text-white hover:text-blue-200 transition-colors duration-200">
                        {{ __('Data Mapel') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.pembayaran')" :active="request()->routeIs('admin.pembayaran')" class="text-white hover:text-blue-200 transition-colors duration-200">
                        {{ __('Data Pembayaran') }}
                    </x-nav-link>
                    @endif

                    @if(Auth::user()->role == 'user')
                    <x-nav-link :href="route('user.bayar')" :active="request()->routeIs('user.bayar')" class="text-white hover:text-blue-200 transition-colors duration-200">
                        {{ __('Pembayaran') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white hover:bg-blue-500 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-blue-50">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="hover:bg-blue-50">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-blue-200 hover:bg-blue-500 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-blue-500">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if(Auth::user()->role == 'admin')
            <x-responsive-nav-link :href="route('admin.siswa')" :active="request()->routeIs('admin.siswa')" class="text-white hover:bg-blue-500">
                {{ __('Data Siswa') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.guru')" :active="request()->routeIs('admin.guru')" class="text-white hover:bg-blue-500">
                {{ __('Data Guru') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.mapel')" :active="request()->routeIs('admin.mapel')" class="text-white hover:bg-blue-500">
                {{ __('Data Mapel') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.pembayaran')" :active="request()->routeIs('admin.pembayaran')" class="text-white hover:bg-blue-500">
                {{ __('Data Pembayaran') }}
            </x-responsive-nav-link>
            @endif
            @if(Auth::user()->role == 'user')
            <x-responsive-nav-link :href="route('user.bayar')" :active="request()->routeIs('user.bayar')" class="text-white hover:bg-blue-500">
                {{ __('Pembayaran') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-blue-300">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-blue-200">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-blue-500">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="text-white hover:bg-blue-500">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
