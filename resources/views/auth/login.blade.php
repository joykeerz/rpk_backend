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
                <img src="{{ asset('images/dashboard/Logo_BULOG.png') }}" class="p-14" alt="">
                {{-- <h1 class="text-3xl font-semibold mb-6 text-black text-center">Sign in</h1> --}}
                <h1 class="text-sm font-semibold mb-6 text-gray-500 text-center">Selamat Datang Di Dashboard RPK BULOG.
                    Masuk menggunakan email dan password yang telah terdaftar.</h1>
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Your form elements go here -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="text" id="email" name="email" value="{{ old('email') }}"
                            class="mt-1 p-2 w-full shadow rounded-md focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300 @error('email') text-red-800 @enderror">
                        @error('email')
                            <span class="text-red-800" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" value="{{ old('password') }}"
                            class="mt-1 p-2 w-full shadow rounded-md focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300 @error('email') text-red-800 @enderror">
                        @error('password')
                            <span class="text-red-800" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full shadow bg-yellowlog text-neutral p-2 rounded-md hover:bg-gray-800 focus:outline-none focus:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors duration-300">Masuk</button>
                    </div>
                </form>
                <div class="mt-4 text-sm text-gray-600 text-center">
                    @if (Route::has('password.request'))
                        <a class="text-gray-400 hover:text-gray-900" href="{{ route('password.request') }}">
                            Lupa kata sandi? {{ __('Klik di sini') }}
                        </a>
                    @endif
                    <p class="mt-10">Mengalami kendala atau bug? <a href="#"
                            class="text-black hover:underline">Klik disini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
