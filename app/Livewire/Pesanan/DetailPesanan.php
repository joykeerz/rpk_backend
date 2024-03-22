<?php

namespace App\Livewire\Pesanan;

use App\Models\Kurir;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.temp')]
class DetailPesanan extends Component
{
    public $transactionId;
    public $isEdit = false;

    //input variables
    public $tipePembayaran;
    public $statusPembayaran;
    public $statusPemesanan;
    public $kurir;

    public function mount($id)
    {
        $this->transactionId = $id;
    }

    public function render()
    {
        $transaksi = DB::table('transaksi')
            ->join('pesanan', 'pesanan.id', '=', 'transaksi.pesanan_id')
            ->join('users', 'users.id', '=', 'pesanan.user_id')
            ->join('alamat', 'alamat.id', '=', 'pesanan.alamat_id')
            ->join('kurir', 'kurir.id', '=', 'pesanan.kurir_id')
            ->where('transaksi.id', '=', $this->transactionId)
            ->select('transaksi.*', 'pesanan.*', 'users.*', 'alamat.*', 'kurir.*', 'transaksi.id as tid', 'pesanan.id as pid', 'users.id as uid', 'alamat.id as aid', 'kurir.id as kid', 'transaksi.created_at as cat')
            ->first();

        $detailPesanan = DB::table('detail_pesanan')
            ->join('produk', 'produk.id', '=', 'detail_pesanan.produk_id')
            ->join('pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
            ->where('pesanan.id', '=', $transaksi->pesanan_id)
            ->select('detail_pesanan.*', 'produk.*', 'detail_pesanan.id as did', 'produk.id as pid')
            ->get();

        $statusPemesananOpt = ['menunggu verifikasi', 'diproses', 'dikirim', 'selesai', 'batal'];

        $kurirOpt = Kurir::all();

        return view('livewire.pesanan.detail-pesanan', [
            'transaksi' => $transaksi,
            'detailPesanan' => $detailPesanan,
            'statusPemesananOpt' => $statusPemesananOpt,
            'kurirOpt' => $kurirOpt
        ]);
    }

    public function toggleEdit($id)
    {
        if ($this->isEdit == true) {
            $this->update($id);
        } else {
            $transaksi = Transaksi::find($id);
            $pesanan = Pesanan::find($transaksi->pesanan_id);
            $this->tipePembayaran = $transaksi->tipe_pembayaran;
            $this->statusPembayaran = $transaksi->status_pembayaran;
            $this->statusPemesanan = $pesanan->status_pemesanan;
            $this->kurir = $pesanan->kurir_id;
        }
        $this->isEdit = !$this->isEdit;
    }

    public function update($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->tipe_pembayaran = $this->tipePembayaran;
        $transaksi->status_pembayaran = $this->statusPembayaran;
        $transaksi->save();

        $pesanan = Pesanan::find($transaksi->pesanan_id);
        $pesanan->status_pemesanan = $this->statusPemesanan;
        $pesanan->kurir_id = $this->kurir;
        $pesanan->save();

        $this->clearInput();
    }

    public function clearInput()
    {
        $this->reset('tipePembayaran', 'statusPembayaran', 'statusPemesanan', 'kurir');
    }
}
