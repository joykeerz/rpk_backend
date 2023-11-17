@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    @if (session('message'))
        <div class="bg-green-200 border-t border-b border-white-500  px-4 py-3 relative" id="alertMessage">
            {{ session('message') }}
            <button type="button" data-dismiss="alert" aria-label="Close"
                class="close-button absolute top-0 bottom-0 right-0 px-4 py-3 text-rose">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#ff3b00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </button>
        </div>

        <script>
            // After the page loads
            document.addEventListener('DOMContentLoaded', function() {
                var alert = document.getElementById('alertMessage');

                if (alert) {
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 5000); // 5000 milliseconds = 5 seconds
                }

                // Optionally, you might want to add functionality to close the alert with the close button
                var closeButton = alert.querySelector('.close-button');
                if (closeButton) {
                    closeButton.addEventListener('click', function() {
                        alert.style.display = 'none';
                    });
                }
            });
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        // Function to trigger SweetAlert for data update
        function updateData(itemId) {
            const initialNamaKategori = document.querySelector(`tr[data-id="${itemId}"] .nama_kategori`).innerText;
            const initialDeskripsiKategori = document.querySelector(`tr[data-id="${itemId}"] .deskripsi_kategori`)
            .innerText;

            Swal.fire({
                title: 'Update Data',
                html: `<form id="updateForm" method="post" action="/category/update/+${itemId}">` +
                    '@csrf' +
                    `<label for="tb_nama_kategori">Nama Kategori:</label>` +
                    `<input id="tb_nama_kategori" class="swal2-input" placeholder="Nama Kategori" name="tb_nama_kategori" value="${initialNamaKategori}">` +
                    `<br>` +
                    `<label for="tb_desk_kategori">Deskripsi Kategori:</label>` +
                    `<textarea id="tb_desk_kategori" class="swal2-textarea w-3/4" placeholder="Deskripsi Kategori" name="tb_desk_kategori">${initialDeskripsiKategori}</textarea>` +
                    `</form>`,
                focusConfirm: false,
                preConfirm: () => {
                    const namaKategori = Swal.getPopup().querySelector('#tb_nama_kategori').value;
                    const deskripsiKategori = Swal.getPopup().querySelector('#tb_desk_kategori').value;

                    if (!namaKategori || !deskripsiKategori) {
                        Swal.showValidationMessage(`Please enter all the required fields`)
                    }
                    console.log(namaKategori);
                    console.log(deskripsiKategori);
                    return {
                        namaKategori: namaKategori,
                        deskripsiKategori: deskripsiKategori
                    }

                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let url let url = {{route('category.update', ['id' => ${itemId}])}}';
                    const data = result.value;
                    console.log(data);
                    $.ajax({
                        url: '/category/update/' + itemId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            tb_nama_kategori: data.namaKategori,
                            tb_desk_kategori: data.deskripsiKategori
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

    <div class="inputKategoriContainer">
        <form action="{{ route('category.store') }}" method="POST">
            @csrf
            <div class="inputKategori p-4">
                <label class="block text-sm font-medium text-gray-700" for="kategori">Nama Kategori:</label>
                <input
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                    type="text" name="tb_nama_kategori" id="tb_nama_kategori">
                @error('tb_nama_kategori')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                <label class="block text-sm font-medium text-gray-700" for="deskripsiKategori">Deskripsi Kategori:</label>
                <textarea
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                    name="tb_desk_kategori" id="tb_desk_kategori" cols="100" rows="3"></textarea>
                @error('tb_desk_kategori')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex justify-center">
                <button type="submit" class="bg-blue-500 text-white py-1 px-4 rounded-md hover:bg-blue-600 m-auto my-2">
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
                    <th>Nama Kategori</th>
                    <th>Deskripsi Kategori</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoriData as $item)
                    <tr class="text-center " data-id="{{ $item->id }}">
                        <td class="w-1/3 nama_kategori">{{ $item->nama_kategori }}</td>
                        <td class="deskripsi_kategori">{{ $item->deskripsi_kategori }}</td>
                        <td>
                            <button onclick="updateData({{ $item->id }})"
                                class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                                edit
                            </button>
                            <a href="{{ route('category.delete', ['id' => $item->id]) }}"
                                class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">
                                delete
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
