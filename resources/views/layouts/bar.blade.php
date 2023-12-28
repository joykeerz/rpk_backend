<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPK BULOG DASHBOARD</title>
    <link rel="shortcut icon" href="{{ asset('images/dashboard/logo_1.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="../../css/svg.css">
    <script src="https://kit.fontawesome.com/545d382107.js" crossorigin="anonymous"></script>
    @yield('plugins')
    <style>
        .active {
            background-color: #4a5568;
            /* Change this color to match your design */
            color: #ffffff;
            /* Change this color to match your design */
        }

        #loader {
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.75) url("") no-repeat center center;
            z-index: 99999;
        }
    </style>
</head>

<body>
    <div id='loader'>
        <img class="" src="{{ asset('images/dashboard/Circle-Loader.gif') }}" alt="loading...">
    </div>
    @yield('navbar')
    <div class="flex">
        <div>
            @yield('sidebar')
        </div>

        <div class="w-full h-screen overflow-y-auto">
            <div class="my-14">
                {{-- <a class="btn btn-sm btn-ghost m-1" href="{{ URL::previous() }}">
                    <i class="fa-solid fa-arrow-left"></i>Back
                </a> --}}
                @yield('content')
            </div>
        </div>
    </div>
    @yield('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('loader').style.display = 'none';
        });

        window.onbeforeunload = function(event) {
            document.getElementById('loader').style.display = 'flex';
        }
    </script>
</body>

</html>
