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
    <header class="bg-gray-200 p-3">
        <div class="flex justify-between">
            <h2>
                Manage {{ __('Pajak') }}
            </h2>
            <div class="button">
                <a class="btn btn-sm btn-primary" href="{{ route('pajak.create') }}">
                    <i class="fa-solid fa-add"></i>
                    New Pajak
                </a>
            </div>
        </div>
    </header>

    @include('layouts.alert-popup')

    @include('layouts.searchbar', ['routeName' => 'pajak.index', 'placeholder' => 'Masukkan nama pajak'])

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this pajak?");
        }
    </script>
    <div class="overflow-y-auto m-3">
        <table id="myTable" class="min-w-full table-auto border ">
            <thead class="text-center border-b-1 border">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nama Pajak</th>
                    <th class="px-4 py-2">Jenis Pajak</th>
                    <th class="px-4 py-2">Persentase(%)</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($pajak as $pjk)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} ">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $pjk->nama_pajak }}</td>
                        <td class="px-4 py-2">{{ $pjk->jenis_pajak }}</td>
                        <td class="px-4 py-2">{{ $pjk->persentase_pajak }}%</td>
                        <td class="px-4 py-2 flex justify-center gap-1">
                            <div class="flex items-center">
                                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </div>
                                    <ul tabindex="0"
                                        class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li><a href="{{ route('pajak.show', ['id' => $pjk->id]) }}">
                                                {{-- <svg class="showIcon"> </svg> --}}
                                                <i class="fa-solid fa-bars"></i>
                                                Lihat detail
                                            </a></li>
                                        <li><a href="{{ route('pajak.delete', ['id' => $pjk->id]) }}"
                                                onclick="return confirmDelete();" class="text-red-600">
                                                {{-- <svg class="deleteIcon"></svg> --}}
                                                <i class="fa-solid fa-trash"></i>
                                                Hapus produk

                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No data available</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        {{ $pajak->links('pagination::tailwind') }}
        <link rel="stylesheet" href="{{ asset('svg.css') }}">
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true,
                searching: false,
                ordering: true,
                paging: false,
                info: false,
            });
        });
    </script>
@endsection
