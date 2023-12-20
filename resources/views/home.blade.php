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
                    <div class="stats shadow">

                        <div class="stat">
                            <div class="stat-figure text-secondary">
                                <i class="fa-solid fa-receipt text-4xl"></i>
                            </div>
                            <div class="stat-title">Transaksi Bulan ini</div>
                            <div class="stat-value">{{ $transaksiCountByMonth }}</div>
                            <div class="stat-desc">{{ now()->month()->format('F') }} - {{ now()->month()->addMonth()->format('F') }}</div>
                        </div>

                        <div class="stat">
                            <div class="stat-figure text-secondary">
                                <i class="fa-solid fa-cube text-4xl"></i>
                            </div>
                            <div class="stat-title">Total Stok</div>
                            <div class="stat-value">{{$stockCountByMonth}}</div>
                            {{-- <div class="stat-desc">↗︎ 400 (22%)</div> --}}
                            <div class="stat-desc">selindo</div>
                        </div>

                        <div class="stat">
                            <div class="stat-figure text-secondary">
                                <i class="fa-solid fa-user text-4xl"></i>
                            </div>
                            <div class="stat-title">Total Customer</div>
                            <div class="stat-value">{{$totalCustomer}}</div>
                            {{-- <div class="stat-desc">↘︎ 90 (14%)</div> --}}
                            <div class="stat-desc">selindo</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
