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
            Home > {{ __('Pajak') }}
        </h2>
    </header>

    @include('layouts.alert')
    @include('layouts.searchbar')

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this pajak?");
        }
    </script>
    <div class="overflow-y-auto m-3">
        <table class="min-w-full table-auto border ">
            <thead class="text-center border-b-1 border">
                <tr>
                    <th class="px-4 py-2">Nama Pajak</th>
                    <th class="px-4 py-2">Jenis Pajak</th>
                    <th class="px-4 py-2">Persentase(%)</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($pajak as $pjk)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} ">
                        <td class="px-4 py-2">{{ $pjk->nama_pajak }}</td>
                        <td class="px-4 py-2">{{ $pjk->jenis_pajak }}</td>
                        <td class="px-4 py-2">{{ $pjk->persentase_pajak }}%</td>
                        <td class="px-4 py-2 flex justify-center">
                            <a href="{{ route('pajak.show', ['id' => $pjk->id]) }}"
                                class="m-2 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                                <svg class="showIcon"> </svg>
                            </a>
                            <a href="{{ route('pajak.delete', ['id' => $pjk->id]) }}" onclick="return confirmDelete();"
                                class="m-2 bg-red-500 text-white rounded-md px-3 py-1 flex items-center justify-center">
                                <svg class="deleteIcon"></svg>
                            </a>
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
