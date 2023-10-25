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
                                        <h4 class="card-title">Profil</h4>
                                        <hr>
                                        <form action="{{ route('manage.user.update', ['id' => $userData->id]) }}">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input value="{{ $userData->name }}" type="text" class="form-control"
                                                    name="tb_nama_user" aria-describedby="helpId" placeholder="">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input value="{{ $userData->email }}" type="text" class="form-control"
                                                    name="tb_email_user" aria-describedby="helpId" placeholder="">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">No. Handphone</label>
                                                <input value="{{ $userData->no_hp }}" type="text" class="form-control"
                                                    name="tb_hp_user" aria-describedby="helpId" placeholder="">
                                            </div>
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
                                        <form action="{{ route('manage.user.update', ['id' => $userData->id]) }}">
                                            <div class="mb-3">
                                                <label class="form-label">New Password</label>
                                                <input value="{{ $userData->name }}" type="text" class="form-control"
                                                    name="tb_nama_user" aria-describedby="helpId" placeholder="">
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
