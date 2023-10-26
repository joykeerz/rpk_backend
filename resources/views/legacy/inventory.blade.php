@extends('layouts.bar')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('content')

<header>
    <div class="title flex m-5 justify-between">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard RPK
        </h2>
    </div>
</header>
<div class="container mx-auto my-5 rounded">
    <div class="flex justify-center">
        <div class="w-8/12">
            <div class="bg-white shadow-md rounded-lg">
                <div class="bg-white dark:bg-gray-800 text-white py-2 px-4 rounded">{{ __('Hai,') }} {{Auth::user()->name}}</div>

                <div class="p-4">
                    @if (session('status'))
                    <div class="bg-green-200 text-green-800 border-l-4 border-green-500 py-2 px-4 mb-4">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="flex flex-wrap">
                        <div class="w-1/2">
                            <div class="bg-white border border-black rounded-lg p-4 m-3 text-center">
                                <h4 class="text-lg font-semibold">Products</h4>
                                <div class="button m-2">
                                    <a class="btn btn-primary align-center w-full border border-black p-2 rounded hover:bg-gray-800 hover:text-white duration-200" href="{{ route('product.index') }}">Manage</a>
                                </div>
                            </div>
                        </div>
                        <div class="w-1/2">
                            <div class="bg-white border rounded-lg border-black p-4 m-3 text-center">
                                <h4 class="text-lg font-semibold">Users</h4>
                                <div class="button m-2 ">
                                <a class="btn btn-primary align-center w-full border border-black p-2 rounded hover:bg-gray-800 hover:text-white duration-200" href="{{route('manage.user.index')}}">Manage</a>
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
