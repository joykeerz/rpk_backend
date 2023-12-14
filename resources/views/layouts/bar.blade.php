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
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels"></script> --}}
    <style>
        .active {
            background-color: #4a5568;
            /* Change this color to match your design */
            color: #ffffff;
            /* Change this color to match your design */
        }
    </style>
</head>

<body>
    @yield('navbar')


    <div class="flex">
        <div>
            @yield('sidebar')
        </div>

        <div class="w-full h-screen overflow-y-auto">
            <div class="my-14">
                @yield('content')
            </div>
            {{-- @yield('searchBar') --}}
        </div>
    </div>
    @yield('script')
</body>

</html>
