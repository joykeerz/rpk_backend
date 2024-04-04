@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('plugins')
    {{-- code --}}
@endsection

<div>
    <header class=" bg-gray-200 p-4">
        <div class="title flex justify-between">
            <h2 class="text-xl text-gray-800 leading-tight">
                Manage Payment Options
            </h2>
            <button type="button" class="btn btn-sm btn-primary">
                @if ($isEdit)
                    <i class="fa-solid fa-pencil"></i>
                    Selesai
                @else
                    <i class="fa-solid fa-pencil"></i>
                    Edit
                @endif
            </button>
        </div>
    </header>

    <div class="container p-2">
    </div>
</div>

@section('script')
    {{-- code --}}
@endsection
