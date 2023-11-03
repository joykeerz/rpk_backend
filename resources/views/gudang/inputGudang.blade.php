@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')

<header>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Input Gudang') }}
    </h2>

</header>


@endsection
