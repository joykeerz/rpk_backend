<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index() ///ini tampilin semua transaksi pesanan
    {
        $transaksi = DB::table('transaksi')
        ->join('pesanan', 'pesanan.id', '=', 'transaksi.pesanan_id')
        ->join('users', 'users.id', '=', 'pesanan.user_id')
        ->get();
        $res = response()->json([
            'data' => $transaksi
        ], 200);

        return view('pesanan.index', ['transaksi' => $transaksi]);
    }

    public function show($id){ ///ini tampilin detail transaksi pesanan
        $transaksi = DB::table('transaksi')
        ->join('pesanan', 'pesanan.id', '=', 'transaksi.pesanan_id')
        ->join('users', 'users.id', '=', 'pesanan.user_id')
        ->join('alamat', 'alamat.id', '=', 'pesanan.alamat_id')
        ->join('kurir', 'kurir.id', '=', 'pesanan.kurir_id')
        ->where('transaksi.id', '=', $id)
        ->select('transaksi.*', 'pesanan.*', 'users.*', 'alamat.*', 'kurir.*', 'transaksi.id as tid', 'pesanan.id as pid', 'users.id as uid', 'alamat.id as aid', 'kurir.id as kid')
        ->first();

        $detailPesanan = DB::table('detail_pesanan')
        ->join('produk', 'produk.id', '=', 'detail_pesanan.produk_id')
        ->join('pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
        ->where('pesanan.id', '=', $transaksi->pesanan_id)
        ->select('detail_pesanan.*', 'produk.*', 'detail_pesanan.id as did', 'produk.id as pid')
        ->get();

        $res = response()->json([
            'data' => [
                'transaksi' => $transaksi,
                'detailPesanan' => $detailPesanan
            ],
        ], 200);
        // return view('pesanan.show', ['transaksi' => $transaksi, 'detailPesanan' => $detailPesanan]);
    }

    public function newOrder(){/// ini tampilin form buat pesanan baru
        // $products = DB::table('produk')
        // ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
        // ->join('stok', 'stok.produk_id', '=', 'produk.id')
        // ->select('kategori.*', 'produk.*', 'kategori.id as kid', 'produk.id as pid')
        // ->where('stok.jumlah_stok', '>', 0) //.jumlah -> .jumlah_stok
        // ->get();

        $biodata = DB::table('biodata')
        ->join('users', 'users.id', '=', 'biodata.user_id')
        ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
        ->select('biodata.*', 'users.*', 'alamat.*')
        ->get();

        $stok = DB::table('stok')
        ->join('produk', 'produk.id', '=', 'stok.produk_id')
        ->select('stok.*', 'produk.*', 'stok.id as sid', 'produk.id as pid')
        ->where('stok.jumlah_stok', '>', 0) //.jumlah -> .jumlah_stok
        ->get();
        // $res = response()->json([
        //     'data' => $products
        // ], 200);
        return view('pesanan.newOrder', ['product' => $stok, 'users' => $biodata]);
    }

    public function storeOrder(Request $request){
        $pesanan = new Pesanan;
        $pesanan->user_id = $request->tb_user_id;
        $pesanan->alamat_id = $request->tb_alamat_id;
        $pesanan->kurir_id = $request->tb_kurir_id;
        $pesanan->status_pemesanan = 'belum dipesan';
        $pesanan->save();

        $transaksi = new Transaksi;
        $transaksi->pesanan_id = $pesanan->id;
        $transaksi->status_transaksi = 'belum dibayar';
        $transaksi->save();

        $listDetailPesanan = [];
        foreach ($request->tb_produk_id as $key => $value) {
            array_push($listDetailPesanan, [
                'pesanan_id' => $pesanan->id,
                'produk_id' => $value,
                'qty' => $request->tb_qty_produk[$key],
                'harga' => $request->tb_harga_produk[$key],
            ]);
        }
        DB::table('detail_pesanan')->insert($listDetailPesanan);

        // foreach ($request->tb_produk_id as $key => $value) {
        //     $detailPesanan = new DetailPesanan;
        //     $detailPesanan->pesanan_id = $pesanan->id;
        //     $detailPesanan->produk_id = $value;
        //     $detailPesanan->qty = $request->tb_qty_produk[$key];
        //     $detailPesanan->harga = $request->tb_harga_produk[$key];
        //     $detailPesanan->save();
        // }

        return response()->json([
            'message' => 'Pesanan berhasil ditambahkan',
            'data' => $pesanan
        ], 200);
    }

    public function newTransaksi($id){
        $pesanan = DB::table('pesanan')
        ->join('users', 'users.id', '=', 'pesanan.user_id')
        ->join('alamat', 'alamat.id', '=', 'pesanan.alamat_id')
        ->join('kurir', 'kurir.id', '=', 'pesanan.kurir_id')
        ->where('pesanan.id', '=', $id);

        $detailPesanan = DB::table('detail_pesanan')
        ->join('produk', 'produk.id', '=', 'detail_pesanan.produk_id')
        ->join('pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
        ->where('pesanan.id', '=', $id)
        ->get();

        $res = response()->json([
            'data' => [
                'pesanan' => $pesanan,
                'detailPesanan' => $detailPesanan
            ],
        ], 200);

        // return view('pesanan.newTransaksi', ['pesanan' => $pesanan, 'detailPesanan' => $detailPesanan]);
    }

    public function storeTransaksi(Request $request, $id){
        $transaksi = Transaksi::find($id);
        $transaksi->status_transaksi = $request->tb_status_transaksi;
        $transaksi->tipe_pembayaran = $request->tb_tipe_pembayaran;
        $transaksi->diskon = $request->tb_diskon;
        $transaksi->subtotal_produk = $request->tb_subtotal_produk;
        $transaksi->subtotal_pengiriman = $request->tb_subtotal_pengiriman;
        $transaksi->save();

        return response()->json([
            'message' => 'Transaksi berhasil ditambahkan',
            'data' => $transaksi
        ], 200);

        // return redirect()->route('pesanan.index')->with('success', 'Transaksi berhasil ditambahkan');
    }
}
