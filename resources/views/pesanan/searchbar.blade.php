<div class="searchBar flex justify-center m-3">
    <form class="flex flex-row" action="{{ route('pesanan.index', ['id' => $gudangId]) }}" method="GET">
        <label class="input input-bordered flex items-center gap-2 mr-3">
            <input id="searchInput" name="search" type="text" class="grow" placeholder="Masukkan kode transaksi"
                value="{{ request('search') }}" />
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70">
                <path fill-rule="evenodd"
                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                    clip-rule="evenodd" />
            </svg>
        </label>

        <label class="flex items-center gap-2 mr-3">
            <select name="status_pembayaran" class="input input-bordered">
                <option value="">Semua status pembayaran</option>
                <option value="belum dibayar" {{ request('status_pembayaran') == 'belum dibayar' ? 'selected' : '' }}>
                    Belum Bayar</option>
                <option value="sudah dibayar" {{ request('status_pembayaran') == 'sudah dibayar' ? 'selected' : '' }}>
                    Sudah Bayar</option>
                <!-- Add more status_pembayaran options as needed -->
            </select>
        </label>

        <label class="flex items-center gap-2 mr-3">
            <select name="status_pemesanan" class="input input-bordered">
                <option value="">Semua status pesanan</option>
                <option value="menunggu verifikasi"
                    {{ request('status_pemesanan') == 'menunggu verifikasi' ? 'selected' : '' }}>Menunggu verifikasi
                </option>
                <option value="terverifikasi" {{ request('status_pemesanan') == 'terverifikasi' ? 'selected' : '' }}>
                    Terverifikasi
                </option>
                <!-- Add more status_pemesanan options as needed -->
            </select>
        </label>

        <button class="btn btn-primary" type="submit">Cari</button>
    </form>
</div>
