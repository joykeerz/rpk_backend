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
</head>



<body>
    @yield('navbar')


    <div class="flex">
        <div>
            @yield('sidebar')
        </div>

        <div class="w-full h-screen overflow-y-auto my-16">

            @yield('content')
            @yield('searchBar')

        </div>
    </div>

</body>

</html>
