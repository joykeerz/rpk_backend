{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    @vite('resources/css/app.css')

</head>

<body class="h-screen overflow-hidden flex items-center justify-center" style="background: #edf2f7;">
    <div class="flex h-screen">
        <!-- Left Pane -->
        <div class="hidden lg:flex items-center justify-center flex-1 bg-white text-black">
            <div class="max-w-md text-center">
                <img src="{{ asset('images/dashboard/18151572_5961102.svg') }}" class="w-full" alt="">
            </div>
        </div>
        <!-- Right Pane -->
        <div class="w-full bg-gray-100 lg:w-1/2 flex items-center justify-center">
            <div class="max-w-md w-full p-6">
                {{-- <img src="{{asset('images/dashboard/logo_1.png')}}" class="w-1/2 ml-16 my-8" alt=""> --}}
                <h1 class="text-3xl font-semibold mb-6 text-black text-center">{{ __('Reset Password') }}</h1>
                <h1 class="text-sm font-semibold mb-6 text-gray-500 text-center">Link untuk mereset password akan
                    dikirim melalui Email.</h1>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Your form elements go here -->
                    <div>
                        <label for="email"
                            class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                        <input type="text" id="email" name="email" value="{{ old('email') }}"
                            class="mt-1 p-2 w-full border rounded-md focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300 @error('email') text-red-800 @enderror">
                        @error('email')
                            <span class="text-red-800" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full bg-black text-white p-2 rounded-md hover:bg-gray-800 focus:outline-none focus:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors duration-300">{{ __('Send Password Reset Link') }}</button>
                    </div>
                </form>
                <div class="mt-4 text-sm text-gray-600 text-center">

                    <p class="mt-10">Mengalami kendala atau bug? <a href="#"
                            class="text-black hover:underline">Klik disini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
