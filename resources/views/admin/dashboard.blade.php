<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Selamat Datang di Admin Dashboard SIAKAD RA ALIFIA!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                   
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 p-6">
                        <a href={{route('admin.guru')}}>
                        <div class="flex justify-center items-center flex-col bg-blue-500 p-10 rounded-xl shadow-2xl hover:bg-blue-600 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-12 h-12 mb-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                            </svg>
                            <h1 class="text-2xl font-bold mb-2">Total Guru</h1>
                            <h1 class="text-5xl font-bold">{{$guru}}</h1>
                        </div>
                    </a>
                    <a href="{{route('admin.siswa')}}">
                        <div class="flex justify-center items-center flex-col bg-green-500 p-10 rounded-xl shadow-2xl hover:bg-green-600 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-12 h-12 mb-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                            </svg>
                            <h1 class="text-2xl font-bold mb-2">Total Siswa</h1>
                            <h1 class="text-5xl font-bold">{{$siswa}}</h1>
                        </div>
                    </a>
                    <a href="{{route('admin.mapel')}}">
                        <div class="flex justify-center items-center flex-col bg-red-500 p-10 rounded-xl shadow-2xl hover:bg-red-600 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-12 h-12 mb-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                            </svg>
                            <h1 class="text-2xl font-bold mb-2">Total Mapel</h1>
                            <h1 class="text-5xl font-bold">{{$mapel}}</h1>
                        </div>
                    </a>
                    </div>                   
                    
                </div>            </div>
        </div>
    </div>
</x-app-layout>
