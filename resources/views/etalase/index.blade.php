@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('plugins')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="{{ asset('plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    @livewireStyles
@endsection

@section('content')
    {{ $slot }}
@endsection

@section('script')
    @livewireScripts
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this etalase stok?");
        }
    </script>
@endsection
