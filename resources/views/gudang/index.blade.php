@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this product?");
        }
    </script>

    <header class="bg-gray-200 p-3">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gudang') }}
        </h2>
    </header>

    @include('layouts.searchbar')

    <div class="overflow-y-auto m-3">
        <table class="min-w-full table-auto border">
            <thead class="border text-center">
                <tr class="">
                    <th class="p-3">Nama Gudang</th>
                    <th class="p-3">Alamat</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($gudangData as $gudang)
                    <tr class="border {{ $loop->even ? 'bg-gray-100' : 'bg-white'}} ">
                        <td class="p-3">{{ $gudang->nama_gudang }}</td>
                        <td class="p-3">
                            Provinsi: {{ $gudang->provinsi }}
                            <br>
                            Kota: {{ $gudang->kota_kabupaten }}
                        </td>
                        <td class="p-3 flex justify-center">
                            <a href="{{ route('gudang.show', ['id' => $gudang->gid]) }}"
                                class="btn btn-sm btn-primary mr-2">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('gudang.delete', ['id' => $gudang->gid]) }}" onclick="return confirmDelete();"
                                class="btn btn-sm btn-error text-white">
                                <i class="fa-solid fa-trash"></i>
                            </a>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-3">No data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    {{ $gudangData->links('pagination::tailwind') }}

    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{asset('svg.css')}}" >

@endsection
