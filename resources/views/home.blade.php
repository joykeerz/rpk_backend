@extends('layouts.bar')

@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <header class="bg-gray-200 p-4">
        <h2>
            Homepage
        </h2>
    </header>

    @include('layouts.alert')

    <div class="container mx-auto my-5 rounded">
        <div class="flex justify-center">
            <div class="bg-white shadow-md rounded-lg">
                <div class="bg-white dark:bg-gray-800 text-white py-2 px-4 rounded">{{ __('Selamat Datang,') }}
                    {{ Auth::user()->name }}</div>

                <div class="p-4">
                    @if (session('status'))
                        <div class="bg-green-200 text-green-800 border-l-4 border-green-500 py-2 px-4 mb-4">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="flex flex-col text-center gap-4">
                        <h1 class="text-3xl uppercase">Dashboard RPK</h1>
                        <div class="flex gap-4">
                            <div class="card w-96 bg-base-100 shadow-md">
                                <div class="card-body">
                                    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                                        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                                            <i class="fa-solid fa-cubes text-2xl"></i>
                                        </div>
                                        <div>
                                            <p class="mb-2 text-sm font-medium text-gray-600">
                                                Total Stok
                                            </p>
                                            <p class="text-lg font-semibold text-gray-700">
                                                {{$stockCountByMonth}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card w-96 bg-base-100 shadow-md">
                                <div class="card-body">
                                    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                                        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                                            <i class="fa-solid fa-receipt text-2xl"></i>
                                        </div>
                                        <div>
                                            <p class="mb-2 text-sm font-medium text-gray-600">
                                                Total Transaksi
                                            </p>
                                            <p class="text-lg font-semibold text-gray-700">
                                                {{$transaksiCountByMonth}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
