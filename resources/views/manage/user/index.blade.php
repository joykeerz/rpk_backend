@extends('layouts.dashboard')

@section('page-title')
    Users
@endsection

@section('button-group')
    <button type="button" class="btn btn-sm btn-primary">New User</button>
@endsection

@section('section-title')
    {{-- Product Data --}}
@endsection

@section('content')
    @if (Session::has('message'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <p>{{ Session::get('message') }}.</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">No.Hp</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @forelse ($usersData as $ud)
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
                        <td>
                            <a href="{{ route('manage.user.verify', ['id' => $ud->id]) }}" class="badge bg-secondary"
                                onclick="event.preventDefault(); document.getElementById('verify-form').submit();">Verify
                            </a>
                            <form id="verify-form" action="{{ route('manage.user.verify', ['id' => $ud->id]) }}"
                                method="POST" class="d-none">
                                @csrf
                            </form>

                            <a href="{{ route('manage.user.reject', ['id' => $ud->id]) }}" class="badge bg-secondary"
                                onclick="event.preventDefault(); document.getElementById('reject-form').submit();">Reject
                            </a>
                            <form id="reject-form" action="{{ route('manage.user.reject', ['id' => $ud->id]) }}"
                                method="POST" class="d-none">
                                @csrf
                            </form>
                            <a href="{{ route('manage.user.edit', ['id' => $ud->id]) }}" class="badge bg-primary">Manage</a>
                        </td>
                    @empty
                        <td colspan="6" align="center">No Data</td>
                    @endforelse

                </tr>
            </tbody>
        </table>
    </div>
@endsection
