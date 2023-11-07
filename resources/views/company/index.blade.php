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
            {{ __('Kantor Wilayah') }}
        </h2>
    </header>

    <div class="overflow-y-auto m-3">
        <table class="min-w-full table-auto border ">
            <thead class="text-center border-b-1 border">
                <tr>
                    <th class="px-4 py-2">Kode Kantor</th>
                    <th class="px-4 py-2">Nama Kantor</th>
                    <th class="px-4 py-2">Partner</th>
                    <th class="px-4 py-2">Tagline</th>
                    <th class="px-4 py-2">Provinsi</th>
                    <th class="px-4 py-2">Detail</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($companies as $item)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white'}}  ">
                        <td class=" px-4 py-2">{{ $item->kode_company }}</td>
                        <td class=" px-4 py-2">{{ $item->nama_company }}</td>
                        <td class=" px-4 py-2">{{ $item->partner_company }}</td>
                        <td class=" px-4 py-2">{{ $item->tagline_company }}</td>
                        <td class=" px-4 py-2">{{ $item->provinsi }}</td>
                        <td class=" px-4 py-2">
                            <a href="{{ route('company.show', ['id' => $item->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border text-center py-4">No data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
