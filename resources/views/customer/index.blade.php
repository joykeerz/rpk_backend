@extends('layouts.bar')

@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection


@section('content')
<script>
    function deleteConfirmation() {
        return confirm("Are you sure you want to delete this customer?");
    }
</script>

<link rel="stylesheet" href="{{asset('svg.css')}}" >
<header class="bg-gray-200 p-3">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manage Customer') }}
    </h2>
</header>

<div class="table-responsive m-3">
    <table class="min-w-full divide-y divide-gray-200 text-center">
        <thead class="text-center">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Nama RPK</th>
                <th scope="col">Email</th>
                <th scope="col">No.Hp</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customer as $item=>$ud)
                <tr class="hover:bg-gray-50">
                    {{-- <td>{{ $loop->iteration }}</td> --}}
                    <td>{{ $item+1 }}</td>
                    <td>{{ $ud->name }}</td>
                    <td>
                        <span class="truncate">
                            {{ $ud->nama_rpk }}
                        </span>
                    </td>
                    <td>{{ $ud->email }}</td>
                    <td>{{ $ud->no_hp }}</td>
                    <td class="flex justify-evenly p-2">
                        <a href="{{ route('customer.delete', ['id' => $ud->bid]) }}"
                            class="bg-red-500 text-white py-1 px-3 rounded-lg" onclick="return deleteConfirmation()">
                            <svg class="deleteIcon"></svg>
                        </a>
                        <a href="{{ route('customer.show', ['id' => $ud->bid]) }}"
                            class="bg-blue-500 text-white py-1 px-3 rounded-lg">
                            <svg class="showIcon"></svg>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Data</td>
                </tr>
            @endforelse

        </tbody>
    </table>
</div>

<style>
    td{
        text-overflow: ellipsis;
    }
</style>


@endsection