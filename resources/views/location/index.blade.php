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
            return confirm("Are you sure you want to delete this product?");
        }
    </script>

    <header class="bg-gray-200 p-4">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Locations') }}
            </h2>



            <div class="flex items-center">
                {{-- @if (Auth::user()->role_id != 4 || Auth::user()->role_id != 5) --}}
                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                        Sync Locations
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </div>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('odoo.location.import') }}">Sync Locations</a></li>
                    </ul>
                </div>
                <div class="button">
                    <a class="btn btn-sm btn-primary" href="{{ route('location.create', ['id' => $gudangID]) }}">
                        <i class="fa-solid fa-add"></i>
                        New Location
                    </a>
                </div>
                {{-- @endif --}}
            </div>
        </div>
    </header>

    @include('layouts.searchbar', ['routeName' => 'gudang.index'])

    <div class="flex overflow-y-auto m-3 justify-center">
        <div class="card w-96 mb-7 bg-base-100 shadow-xl">
            <div class="card-body">
                @if (count($activeLocations) == 0)
                    <h2 class="card-title">Pilih Location Gudang</h2>
                    <form action="{{ route('location.activate', ['id' => $gudangID]) }}" method="post">
                        @csrf
                        <div class="join">
                            <select name="cb_location_id" class="select select-bordered w-full max-w-xs join-item">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                @endforeach
                            </select>
                            <button class="btn join-item rounded-r-full">Pilih</button>
                        </div>
                    </form>
                @else
                    <h2 class="card-title">Location Gudang</h2>
                @endif
                {{-- <div class="card-actions justify-end">
                    <button class="btn btn-primary">Buy Now</button>
                </div> --}}
            </div>
        </div>

        {{-- <table id="myTable" class="min-w-full table-auto border">
            <thead class="border text-center">
                <tr class="">
                    <th class="p-3">#</th>
                    <th class="p-3">Nama Gudang</th>
                    <th class="p-3">Location</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($locations as $location)
                    <tr class="border {{ $loop->even ? 'bg-gray-100' : 'bg-white' }} ">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3">{{ $location->nama_gudang }}</td>
                        <td class="p-3">{{ $location->location_name }}</td>
                        <td class="p-3 flex justify-center">
                            <a href="{{ route('location.show', ['id' => $location->id]) }}"
                                class="btn btn-sm btn-primary mr-2">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('location.delete', ['id' => $location->id]) }}"
                                onclick="return confirmDelete();" class="btn btn-sm btn-error text-white">
                                <i class="fa-solid fa-trash"></i>
                            </a>

                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table> --}}
        {{-- {{ $locations->links('pagination::tailwind') }} --}}
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('svg.css') }}">
@endsection

@section('script')
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this location?");
        }
    </script>
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
