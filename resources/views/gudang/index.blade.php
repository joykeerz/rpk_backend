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

<table class="min-w-full">
    <thead class="border-b text-center">
        <tr class="">
            <th class="p-3">Nama Gudang</th>
            <th class="p-3">Alamat</th>
            <th class="p-3">Action</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @forelse ($gudangData as $gudang)
        <tr class="border-b">
            <td class="p-3">{{ $gudang->nama_gudang }}</td>
            <td class="p-3">
                Provinsi: {{ $gudang->provinsi }}
                <br>
                Kota: {{ $gudang->kota_kabupaten }}
            </td>
            <td class="p-3 flex justify-evenly">
                <a href="{{route('gudang.show', ['id' => $gudang->id] )}}" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Button 1</a>
                <a href="{{ route('gudang.delete', ['id' => $gudang->id]) }}" onclick="return confirmDelete();" class="bg-red-500 text-white rounded-md px-3 py-1 flex items-center justify-center">
                    delete
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

@endsection
