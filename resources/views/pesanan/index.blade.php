@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection


@section('content')
    <header class=" bg-gray-200 p-4"
        <div class="title flex m-5 justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transaksi') }}
            </h2>
        </div>
    </header>

    {{-- @if($transaksi->count())
       masuk sini

    @else
        masuk ketidak sini
    @endif --}}


@endsection
