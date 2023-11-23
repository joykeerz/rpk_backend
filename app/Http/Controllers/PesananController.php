<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Kurir;
use App\Models\Pesanan;
use App\Models\Stok;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() ///ini tampilin semua transaksi pesanan
    {

        $transaksi = DB::table('transaksi')
            ->join('pesanan', 'pesanan.id', '=', 'transaksi.pesanan_id')
            ->join('users', 'users.id', '=', 'pesanan.user_id')
            ->select('transaksi.*', 'pesanan.*', 'users.*', 'transaksi.id as tid', 'pesanan.id as pid', 'users.id as uid')
            ->get();

        // $res = response()->json([
        //     'data' => $transaksi
        // ], 200);

        return view('pesanan.index', ['transaksi' => $transaksi]);
    }

    public function show($id)
    { ///ini tampilin detail transaksi pesanan
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

        // echo $res;
        return view('pesanan.show', ['transaksi' => $transaksi, 'detailPesanan' => $detailPesanan]);
    }

    public function newOrder($id)
    {
        $biodata = DB::table('biodata')
            ->join('users', 'users.id', '=', 'biodata.user_id')
            ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
            ->select('biodata.*', 'users.*', 'alamat.*', 'users.id as uid', 'biodata.id as bid', 'alamat.id as aid')
            ->get();

        $kurir = Kurir::all();

        $stok = DB::table('stok')
            ->join('produk', 'produk.id', '=', 'stok.produk_id')
            ->select('stok.*', 'produk.*', 'stok.id as sid', 'produk.id as pid')
            ->where('stok.jumlah_stok', '>', 0)
            ->where('stok.gudang_id', '=', $id)
            ->get();
        return view('pesanan.newOrder', ['product' => $stok, 'users' => $biodata, 'kurir' => $kurir]);
    }

    public function storeOrder(Request $request)
    {
        $total = 0;

        $pesanan = new Pesanan;
        $pesanan->user_id = $request->data['userData'][0];
        $pesanan->alamat_id = $request->data['userData'][1];
        $pesanan->kurir_id = $request->data['userData'][2];
        $pesanan->status_pemesanan = 'belum dipesan';
        $pesanan->save();

        $listDetailPesanan = [];
        foreach ($request->data['orderDetails'] as $key => $value) {
            array_push($listDetailPesanan, [
                'pesanan_id' => $pesanan->id,
                'produk_id' => $request->data['orderDetails'][$key]['tb_produk_id'],
                'qty' => $request->data['orderDetails'][$key]['tb_jumlah_produk'],
                'harga' => $request->data['orderDetails'][$key]['price'],
            ]);
            $currentStok = Stok::find($request->data['orderDetails'][$key]['tb_stok_id']);
            // if ($currentStok->jumlah_stok > 0 && $currentStok->jumlah_stok >= $request->data['orderDetails'][$key]['tb_jumlah_produk']) {
            //     $currentStok->decrement('jumlah_stok', $request->data['orderDetails'][$key]['tb_jumlah_produk']);
            // }
            if ($currentStok->jumlah_stok == 0 || $currentStok->jumlah_stok < $request->data['orderDetails'][$key]['tb_jumlah_produk']) {
                return response()->json([
                    'message' => 'Pesanan gagal ditambahkan, stok tidak mencukupi',
                ], 200);
            }
            $currentStok->decrement('jumlah_stok', $request->data['orderDetails'][$key]['tb_jumlah_produk']);
            $currentStok->save();
            $total += $request->data['orderDetails'][$key]['price'];
        }
        DB::table('detail_pesanan')->insert($listDetailPesanan);


        $transaksi = new Transaksi;
        $transaksi->pesanan_id = $pesanan->id;
        $transaksi->status_pembayaran = 'belum dibayar';
        $transaksi->subtotal_produk = $total;
        $transaksi->save();

        // $transaksi = new Transaksi;
        // $transaksi->pesanan_id = $pesanan->id;
        // $transaksi->tipe_pembayaran = $request->cb_tipe_pembayaran;
        // $transaksi->status_pembayaran = 'belum dibayar';
        // $transaksi->subtotal_produk = $total;
        // $transaksi->subtotal_pengiriman = $request->tb_subtotal_pengiriman;
        // $transaksi->save();

        return response()->json([
            'message' => 'Pesanan berhasil ditambahkan',
            'data' => $pesanan
        ], 200);
    }

    public function newTransaksi($id)
    {
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

    public function storeTransaksi(Request $request, $id)
    {
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

    public function orderByGudangSelector(){
        $gudang = DB::table('gudang')
            ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
            ->select('gudang.*', 'alamat.*', 'gudang.id as gid', 'alamat.id as aid', 'gudang.created_at as cat')
            ->orderBy('cat', 'desc')
            ->get();

        return view('pesanan.showByGudang', ['gudang' => $gudang]);
    }
}
