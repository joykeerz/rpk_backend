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
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        User Detail
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col">
                                <div class="card border-secondary">
                                    <div class="card-body">
                                        <h4 class="card-title">Account</h4>
                                        <hr>
                                        <form method="POST"
                                            action="{{ route('manage.user.update', ['id' => $userData->id]) }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input required id="tb_nama_user" value="{{ $userData->name }}" type="text"
                                                    class="form-control" name="tb_nama_user" aria-describedby="helpId"
                                                    placeholder="">

                                                @error('tb_nama_user')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input required id="tb_email_user" value="{{ $userData->email }}" type="text"
                                                    class="form-control" name="tb_email_user" aria-describedby="helpId"
                                                    placeholder="">
                                                @error('tb_email_user')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">No. Handphone</label>
                                                <input required id="tb_hp_user" value="{{ $userData->no_hp }}" type="text"
                                                    class="form-control" name="tb_hp_user" aria-describedby="helpId"
                                                    placeholder="">
                                                @error('tb_email_user')
                                                    <div class="" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                             <hr>
                                             @empty(!$userProfile)
                                             <div>
                                                 Biodata belum terisi
                                             </div>
                                             @endempty
                                             {{-- <div class="mb-3">
                                                <label class="form-label">Nama RPK</label>
                                                <input value="{{ $userData->name }}" type="text" class="form-control"
                                                    name="tb_nama_user" aria-describedby="helpId" placeholder="">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">No KTP</label>
                                                <input value="{{ $userData->name }}" type="text" class="form-control"
                                                    name="tb_nama_user" aria-describedby="helpId" placeholder="">
                                            </div> --}}
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card border-secondary">
                                    <div class="card-body">
                                        <h4 class="card-title">Reset Password</h4>
                                        <hr>
                                        <form method="POST"
                                            action="{{ route('manage.user.changePassword', ['id' => $userData->id]) }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">New Password</label>
                                                <input type="password" class="form-control" name="tb_password_user"
                                                    aria-describedby="helpId" placeholder="Masukan password baru...">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Change</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
