<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>



<body>

    <!-- <div class="header w-full h-screen bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        </div> -->
        @yield('navbar')


    <div class="flex">
    <div>
        @yield('sidebar')
    </div>

    <div class="w-full h-screen overflow-auto">
        @yield('content')

    </div>
    </div>

</body>

</html>
