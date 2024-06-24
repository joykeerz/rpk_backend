@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        // Function to trigger SweetAlert for data update
        function updateData(itemId) {
            const initialNamaKategori = document.querySelector(`tr[data-id="${itemId}"] .nama_kategori`).innerText;
            const initialDeskripsiKategori = document.querySelector(`tr[data-id="${itemId}"] .deskripsi_kategori`)
                .innerText;
            const initialExternalKategoriId = document.querySelector(`tr[data-id="${itemId}"] .external_kategori_id`)
                .innerText;

            Swal.fire({
                title: 'Update Data',
                html: `<form id="updateForm" method="post" action="/category/update/+${itemId}">` +
                    '@csrf' +
                    `<label class="block text-sm font-medium text-gray-700" for="kategori">Icon Kategori:</label>
                <input onchange="loadFile(event)" value="" type="file" name="file_icon_kategori"
                    id="file_icon_kategori"
                    class="mt-1 block w-full
                        rounded-md shadow-sm focus:border-indigo-300 focus:ring
                        focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">` +
                    `<br>` +
                    `<label for="tb_nama_kategori">Nama Kategori:</label>` +
                    `<br>` +
                    `<input id="tb_nama_kategori" class="swal2-input" placeholder="Nama Kategori" name="tb_nama_kategori" value="${initialNamaKategori}">` +
                    `<br>` +
                    `<label for="tb_desk_kategori">Deskripsi Kategori:</label>` +
                    `<textarea id="tb_desk_kategori" class="swal2-textarea w-3/4" placeholder="Deskripsi Kategori" name="tb_desk_kategori">${initialDeskripsiKategori}</textarea>` +
                    `<br>` +
                    `<label for="tb_external_kategori_id">ID External:</label>` +
                    `<input id="tb_external_kategori_id" class="swal2-input" placeholder="id external" name="tb_external_kategori_id" value="${initialExternalKategoriId}">` +
                    `</form>`,
                focusConfirm: false,
                preConfirm: () => {
                    const namaKategori = Swal.getPopup().querySelector('#tb_nama_kategori').value;
                    const deskripsiKategori = Swal.getPopup().querySelector('#tb_desk_kategori').value;
                    const externalKategoriId = Swal.getPopup().querySelector('#tb_external_kategori_id').value;
                    const iconKategori = Swal.getPopup().querySelector('#file_icon_kategori').value;

                    if (!iconKategori || !namaKategori || !deskripsiKategori || !externalKategoriId) {
                        Swal.showValidationMessage(`Please enter all the required fields`)
                    }
                    console.log(namaKategori);
                    console.log(deskripsiKategori);
                    return {
                        iconKategori: iconKategori,
                        namaKategori: namaKategori,
                        deskripsiKategori: deskripsiKategori,
                        externalKategoriId: externalKategoriId
                    }

                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('category.update', ':id') }}";
                    url = url.replace(':id', itemId);
                    const data = result.value;
                    console.log(data);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            file_icon_kategori: data.iconKategori,
                            tb_nama_kategori: data.namaKategori,
                            tb_desk_kategori: data.deskripsiKategori,
                            tb_external_kategori_id: data.externalKategoriId
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire({
                                title: 'Success!',
                                text: 'Data berhasil diupdate!',
                                icon: 'success',
                                confirmButtonText: 'Submit'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                        },
                        error: function(response) {
                            console.log(response);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Data gagal diupdate!',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })
                        }
                    })
                }
            })
        }
    </script>

    <div class="title bg-gray-200 p-4">
        <h3 class="text-xl">Kategori</h3>
    </div>

    @include('layouts.alert-popup')

    <div class="inputKategoriContainer">
        <form enctype="multipart/form-data" action="{{ route('category.store') }}" method="POST">
            @csrf
            <div class="inputKategori p-4">
                <label class="block text-sm font-medium text-gray-700" for="kategori">Icon Kategori:</label>
                <input onchange="loadFile(event)" value="" type="file" name="file_icon_kategori"
                    id="file_icon_kategori"
                    class="mt-1 block w-full
                        rounded-md shadow-sm focus:border-indigo-300 focus:ring
                        focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                @error('file_icon_kategori')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                <label class="block text-sm font-medium text-gray-700" for="kategori">Nama Kategori:</label>
                <input value="{{ old('tb_nama_kategori') }}"
                    class="mt-1 block w-full rounded-m shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                    type="text" name="tb_nama_kategori" id="tb_nama_kategori">
                @error('tb_nama_kategori')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                <label class="block text-sm font-medium text-gray-700" for="external">ID External:</label>
                <input value="{{ old('tb_external_id') }}"
                    class="mt-1 block w-full rounded-m shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                    type="text" name="tb_external_id" id="tb_external_id">
                @error('tb_external_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                <label class="block text-sm font-medium text-gray-700" for="deskripsiKategori">Deskripsi Kategori:</label>
                <textarea
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                    name="tb_desk_kategori" id="tb_desk_kategori" cols="100" rows="3">
                    {{ old('tb_desk_kategori') }}
                </textarea>
                @error('tb_desk_kategori')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex justify-center">
                <button type="submit" class="bg-yellowlog text-neutral py-1 px-4 rounded-md hover:bg-blue-600 m-auto my-2">
                    Submit
                </button>
            </div>
        </form>

    </div>

    <hr>

    <div class="table-container w-full p-3">
        <table class="table w-full  border-spacing-3">
            <thead class="border-b ">
                <tr>
                    <th>#</th>
                    <th>Icon Kategori</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi Kategori</th>
                    <th>ID External</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoriData as $item)
                    <tr class="text-start" data-id="{{ $item->id }}">
                        <td>{{ $kategoriData->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/' . $item->category_file_path) }}" alt="gambar"
                                class="w-20 h-20">
                        </td>
                        <td class="nama_kategori">{{ $item->nama_kategori }}</td>
                        <td class="deskripsi_kategori">{{ $item->deskripsi_kategori }}</td>
                        <td class="external_kategori_id">{{ $item->external_kategori_id }}</td>
                        <td>
                            <div class="flex items-center">
                                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </div>
                                    <ul tabindex="0"
                                        class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li><a href="{{ route('category.show', ['id' => $item->id]) }}">
                                                {{-- <svg class="showIcon"> </svg> --}}
                                                <i class="fa-solid fa-bars"></i>
                                                Lihat detail
                                            </a>


                                        </li>
                                        <li>
                                            <a href="{{ route('category.delete', ['id' => $item->id]) }}">
                                                Hapus kategori
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $kategoriData->links('pagination::tailwind') }}

    </div>
@endsection
