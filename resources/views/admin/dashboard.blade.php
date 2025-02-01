<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Selamat Datang di Admin Dashboard SIAKAD RA ALIFIA!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                   
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4">
                        <a href={{route('admin.guru')}}>
                        <div class="flex justify-center items-center flex-col bg-blue-500  p-8 rounded-lg shadow-lg hover:bg-blue-600 transition-colors duration-300">
                            <h1 class="text-2xl font-bold mb-2">Total Guru</h1>
                            <h1 class="text-4xl font-bold">{{$guru}}</h1>
                        </div>
                    </a>
                    <a href="{{route('admin.siswa')}}">
                        <div class="flex justify-center items-center flex-col bg-green-500 p-8 rounded-lg shadow-lg hover:bg-green-600 transition-colors duration-300">
                            <h1 class="text-2xl font-bold mb-2">Total Siswa</h1>
                            <h1 class="text-4xl font-bold">{{$siswa}}</h1>
                        </div>
                    </a>
                    <a href="{{route('admin.mapel')}}">
                        <div class="flex justify-center items-center flex-col bg-purple-500  p-8 rounded-lg shadow-lg hover:bg-purple-600 transition-colors duration-300">
                            <h1 class="text-2xl font-bold mb-2">Total Mapel</h1>
                            <h1 class="text-4xl font-bold">{{$mapel}}</h1>
                        </div>
                    </a>
                    </div>                   
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
