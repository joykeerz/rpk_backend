@extends('layouts.bar')
@section('navbar')
@include('layouts.navbar')
@endsection

@section('sidebar')
@include('layouts.sidebar')
@endsection


@section('content')

<header>
    <div class="title flex m-5 justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage User') }}
        </h2>

        <div class="button">
            <a class="btn btn-primary align-center w-full border border-black p-2 rounded hover:bg-gray-800 hover:text-white duration-200" href="{{route('manage.user.index')}}">New User</a>
</div>
    </div>
</header>
@if (Session::has('message'))
    <div class="bg-blue-200 border-t border-b border-blue-500 text-blue-700 px-4 py-3 relative" role="alert">
        <p>{{ Session::get('message') }}.</p>
        <button type="button" data-dismiss="alert" aria-label="Close" class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-blue-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.293 5.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.293a1 1 0 011.414-1.414L10 8.586l4.293-4.293z" />
            </svg>
        </button>
    </div>
@endif

<div class="table-responsive mx-3">
    <table class="min-w-full divide-y divide-gray-200 text-center">
        <thead class="text-center">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">No.Hp</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($usersData as $ud)
                <tr class="hover:bg-gray-50">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ud->name }}</td>
                    <td>{{ $ud->email }}</td>
                    <td>{{ $ud->no_hp }}</td>
                    <td>
                        @if ($ud->isVerified == 0)
                            Belum Terverifikasi
                        @endif

                        @if ($ud->isVerified == 1)
                            Terverifikasi
                        @else
                            Ditolak
                        @endif
                    </td>
                    <td class="flex justify-evenly p-2">
                        <a href="{{ route('manage.user.verify', ['id' => $ud->id]) }}"
                            class="bg-gray-300 text-gray-700 py-1 px-3 rounded-lg hover:bg-green-500 hover:text-white duration-200"
                            onclick="event.preventDefault(); document.getElementById('verify-form').submit();">Verify
                        </a>
                        <form id="verify-form" action="{{ route('manage.user.verify', ['id' => $ud->id]) }}"
                            method="POST" class="hidden">
                            @csrf
                        </form>

                        <a href="{{ route('manage.user.reject', ['id' => $ud->id]) }}"
                            class="bg-gray-300 text-gray-700 py-1 px-3 rounded-lg hover:bg-red-500 hover:text-white duration-200"
                            onclick="event.preventDefault(); document.getElementById('reject-form').submit();">Reject
                        </a>
                        <form id="reject-form" action="{{ route('manage.user.reject', ['id' => $ud->id]) }}"
                            method="POST" class="hidden">
                            @csrf
                        </form>
                        <a href="{{ route('manage.user.edit', ['id' => $ud->id]) }}"
                            class="bg-blue-500 text-white py-1 px-3 rounded-lg">Manage
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

@endsection
