<!DOCTYPE html>
<html lang="en" data-theme="business">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPK BULOG DASHBOARD</title>
    <link rel="shortcut icon" href="{{ asset('images/dashboard/Logo_BULOG_notext.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/theme-change@2.0.2/index.js"></script>
    <script src="https://kit.fontawesome.com/545d382107.js" crossorigin="anonymous"></script>
    @yield('plugins')
    <style>
        #switchTheme {
            width: 64px;
            height: 32px;
            border-radius: 20px;
            transition: background-color 0.3s ease;
        }

        .hide {
            visibility: hidden;
        }

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
    @php
        $jobCount = DB::table('jobs')->count();
    @endphp
    <div id='loader' class="flex-col">
        <img class="" src="{{ asset('images/dashboard/Circle-Loader.gif') }}" alt="loading...">
        @if ($jobCount > 0)
            <h1 class="text-white">
                Syncing data with erp database...
            </h1>
        @endif
    </div>
    @yield('navbar')
    <div class="flex">
        <div>
            @yield('sidebar')
        </div>

        <div class="w-full h-screen overflow-y-auto dark:bg-neutral-900">
            <div class="mt-24">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let jobCount = {{ $jobCount }};
            if (jobCount > 0) {
                document.getElementById('loader').style.display = 'flex';
                setTimeout(function() {
                    location.reload();
                }, 30000); // 300,000 milliseconds = 5 minutes
            } else {
                document.getElementById('loader').style.display = 'none';
            }
        });

        window.onbeforeunload = function(event) {
            let jobCount = {{ $jobCount }};
            if (jobCount > 0) {
                document.getElementById('loader').style.display = 'flex';
            } else {
                document.getElementById('loader').style.display = 'none';
            }
        }

        function toggleTheme() {
            $('#switchTheme>.lightMode').toggleClass('hide')
            $('#switchTheme>.darkMode').toggleClass('hide')
            if ($('html').attr('data-theme') == 'corporate') {

                $('#switchTheme').css({
                    'background-color': 'white'
                })
            } else if ($('html').attr('data-theme') == 'business') {
                $('#switchTheme').css({
                    'background-color': 'black'
                })
            }
        }

        $(document).ready(function() {
            if ($('html').attr('data-theme') == 'corporate') {
                $('#switchTheme>.darkMode').toggleClass('hide')

                $('#switchTheme').css({
                    'background-color': 'white'
                })
            } else if ($('html').attr('data-theme') == 'business') {
                $('#switchTheme>.lightMode').toggleClass('hide')
                $('#switchTheme').css({
                    'background-color': 'black'
                })
            }
            $('#switchTheme').click(function() {
                toggleTheme();

            });
        });
    </script>
</body>

</html>
