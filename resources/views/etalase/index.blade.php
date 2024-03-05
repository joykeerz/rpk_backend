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
@endsection

@section('content')
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this etalase stok?");
        }
    </script>

    <livewire:etalase.etalase-index />
@endsection

@section('script')
    <script>
        // $(document).ready(function() {
        //     $('#myTable').DataTable({
        //         responsive: true,
        //         searching: false,
        //         ordering: true,
        //         paging: false,
        //         info: false,
        //     });
        // });
    </script>
@endsection