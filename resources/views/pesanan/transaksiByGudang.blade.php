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
    <header class="bg-gray-200 p-4">
        <h2>
            Transaksi By Gudang
            @if (empty($currentEntity))
                Selindo
            @else
                @if ($isProvinsi)
                    {{ $currentEntity->provinsi }}
                @else
                    {{ $currentEntity->kota_kabupaten }}
                @endif
            @endif
        </h2>
    </header>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this product?");
        }
    </script>

    <div class="overflow-auto m-3">
        @if (!empty($currentEntity))
            @if (!$isProvinsi)
                <div
                    class="flex justify-between items-center w-100 p-2 rounded border border-opacity-30 border-slate-500 bg-blue-950 text-white">
                    <h1 class="font-medium">GUDANG SE-{{ $currentEntity->provinsi }}</h1>
                    <form action="{{ route('pesanan.selectTransaksi') }}">
                        <input type="hidden" name="provinsi" value="{{ $currentEntity->provinsi }}">
                        <button type="submit" class="btn btn-sm btn-outline text-white">
                            Lihat
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </form>
                </div>
            @endif
        @endif
        <table id="myTable" class="min-w-full bg-white text-center">
            <thead>
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telp
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($gudang as $key => $gd)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $gd->nama_gudang_erp }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $gd->no_telp }}</td>
                        <td class="px-6 py-4 whitespace-normal">
                            <p class="line-clamp-1">
                                {{ $gd->jalan }},
                                {{ $gd->blok }},
                                RT {{ $gd->rt }},
                                RW {{ $gd->rw }},
                                {{ $gd->kelurahan }},
                                {{ $gd->kecamatan }},
                                {{ $gd->kota_kabupaten }},
                                {{ $gd->provinsi }}
                            </p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap flex justify-center">
                            <a href="{{ route('pesanan.index', ['id' => $gd->gid]) }}"
                                class="m-2 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
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
