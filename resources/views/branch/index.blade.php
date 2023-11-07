@extends('layouts.bar')

@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')

<header class="bg-gray-200 p-3">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Branch
    </h2>
</header>

<div class="overflow-y-auto m-3">
    <table class="min-w-full table-auto border ">
        <thead class="text-center border-b-1 border">
            <tr>
                <th  class="px-4 py-2">Nama Branch</th>
                <th  class="px-4 py-2">Partner</th>
                <th  class="px-4 py-2">No Telp</th>
                <th  class="px-4 py-2">Alamat</th>
                <th  class="px-4 py-2">Detail</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @forelse ($branch as $item)
                <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white'}} ">
                    <td class=" px-4 py-2">{{ $item->nama_branch }}</td>
                    <td class=" px-4 py-2">{{ $item->nama_company }}</td>
                    <td class=" px-4 py-2">{{ $item->no_telp_branch }}</td>
                    <td class=" px-4 py-2">{{ $item->alamat_branch }}</td>
                    <td class=" px-4 py-2">
                        <a href="{{ route('branch.show', ['id' => $item->id]) }}">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


@endsection