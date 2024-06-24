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
            return confirm("Are you sure you want to delete this company?");
        }
    </script>
    <header class="bg-gray-200 p-4">
        <div class="flex justify-between items-center">
            <h2 class="">
                {{ __('Company (Kanwil)') }}
            </h2>
            <div class="flex items-center">
                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                        Sync Entitas
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </div>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('odoo.company.import') }}">Import Entitas & Branch</a></li>
                        <li><a>Export Entitas & Branch RPK</a></li>
                        <li><a>Sync All</a></li>
                    </ul>
                </div>
                <div class="button">
                    <a class="btn btn-sm btn-primary" href="{{ route('company.create') }}">
                        <i class="fa-solid fa-add"></i>
                        New Company
                    </a>
                </div>
            </div>
        </div>
    </header>

    @include('layouts.alert-popup')

    @include('layouts.searchbar', [
        'routeName' => 'company.index',
        'placeholder' => 'Masukkan kode atau nama entitas, contoh: Kantor Cabang Takengon',
    ])

    <div class="overflow-y-auto m-3">
        <table id="myTable" class="table table-sm table-zebra hover">
            <thead class="border border-b-1">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Kode Entitas</th>
                    <th class="px-4 py-2">Nama Entitas</th>
                    <th class="px-4 py-2">PIC</th>
                    <th class="px-4 py-2">Tagline</th>
                    <th class="px-4 py-2">Provinsi</th>
                    <th class="px-4 py-2">Detail</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($companies as $item)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}  ">
                        <td class=" px-4 py-2">{{ $companies->firstItem() + $loop->index }}</td>
                        <td class=" px-4 py-2">{{ $item->kode_company }}</td>
                        <td class=" px-4 py-2">{{ $item->nama_company }}</td>
                        <td class=" px-4 py-2">{{ $item->partner_company }}</td>
                        <td class=" px-4 py-2">{{ $item->tagline_company }}</td>
                        <td class=" px-4 py-2">{{ $item->provinsi }}</td>
                        <td class=" px-4 py-2 flex justify-center">
                            <div class="flex items-center">
                                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </div>
                                    <ul tabindex="0"
                                        class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li><a href="{{ route('company.show', ['id' => $item->cid]) }}">
                                                {{-- <svg class="showIcon"> </svg> --}}
                                                <i class="fa-solid fa-bars"></i>
                                                Lihat detail
                                            </a></li>
                                        <li><a href="{{ route('company.delete', ['id' => $item->cid]) }}"
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
                @endforelse
            </tbody>
        </table>
        {{ $companies->links('pagination::tailwind') }}

    </div>

    <link rel="stylesheet" href="{{ asset('svg.css') }}">
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
