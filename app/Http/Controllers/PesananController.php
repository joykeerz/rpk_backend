<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Kurir;
use App\Models\Pesanan;
use App\Models\Stok;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {

        $transaksi = DB::table('transaksi')
            ->join('pesanan', 'pesanan.id', '=', 'transaksi.pesanan_id')
            ->join('users', 'users.id', '=', 'pesanan.user_id')
            ->join('gudang', 'gudang.id', '=', 'pesanan.gudang_id')
            ->select('transaksi.*', 'pesanan.*', 'users.*', 'transaksi.id as tid', 'pesanan.id as pid', 'users.id as uid')
            ->where('pesanan.gudang_id', '=', $id)
            ->paginate(15);

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
            ->select('transaksi.*', 'pesanan.*', 'users.*', 'alamat.*', 'kurir.*', 'transaksi.id as tid', 'pesanan.id as pid', 'users.id as uid', 'alamat.id as aid', 'kurir.id as kid', 'transaksi.created_at as cat')
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

        return view('pesanan.show', ['transaksi' => $transaksi, 'detailPesanan' => $detailPesanan]);
    }

    public function edit($id)
    {
        $transaksi = DB::table('transaksi')
            ->join('pesanan', 'pesanan.id', '=', 'transaksi.pesanan_id')
            ->join('users', 'users.id', '=', 'pesanan.user_id')
            ->join('alamat', 'alamat.id', '=', 'pesanan.alamat_id')
            ->join('kurir', 'kurir.id', '=', 'pesanan.kurir_id')
            ->where('transaksi.id', '=', $id)
            ->select('transaksi.*', 'pesanan.*', 'users.*', 'alamat.*', 'kurir.*', 'transaksi.id as tid', 'pesanan.id as pid', 'users.id as uid', 'alamat.id as aid', 'kurir.id as kid', 'transaksi.created_at as cat')
            ->first();

        $detailPesanan = DB::table('detail_pesanan')
            ->join('produk', 'produk.id', '=', 'detail_pesanan.produk_id')
            ->join('pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
            ->where('pesanan.id', '=', $transaksi->pesanan_id)
            ->select('detail_pesanan.*', 'produk.*', 'detail_pesanan.id as did', 'produk.id as pid')
            ->get();

        $kurir = Kurir::all();

        $res = response()->json([
            'data' => [
                'transaksi' => $transaksi,
                'detailPesanan' => $detailPesanan
            ],
        ], 200);

        return view('pesanan.edit', ['transaksi' => $transaksi, 'detailPesanan' => $detailPesanan, 'kurir' => $kurir]);
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
            ->join('satuan_unit', 'satuan_unit.id', '=', 'produk.satuan_unit_id')
            ->join('pajak', 'pajak.id', '=', 'produk.pajak_id')
            ->select('stok.*', 'produk.*', 'pajak.jenis_pajak', 'pajak.persentase_pajak', 'satuan_unit.satuan_unit_produk', 'satuan_unit.id as suid', 'stok.id as sid', 'produk.id as pid')
            ->where('stok.jumlah_stok', '>', 0)
            ->where('stok.gudang_id', '=', $id)
            ->get();

        $kodeCompany = DB::table('gudang')
            ->join('companies', 'companies.id', '=', 'gudang.company_id')
            ->select('companies.kode_company')
            ->where('gudang.id', '=', $id)
            ->first();

        return view('pesanan.newOrderEx', ['product' => $stok, 'users' => $biodata, 'kurir' => $kurir, 'gudang_id' => $id, 'kodeCompany' => $kodeCompany->kode_company]);
    }

    public function storeOrder(Request $request)
    {
        /*
        $lastTransactionLastMonth = Transaksi::whereMonth('created_at', '=', now()->subMonth()->month)
            ->whereYear('created_at', '=', now()->subMonth()->year)
            ->orderBy('created_at', 'desc')
            ->select('created_at', 'kode_transaksi')
            ->first();
        $count = 0;
        $lastTransactionLastMonth = Transaksi::orderBy('created_at', 'desc')
            ->select('created_at', 'kode_transaksi')
            ->first();
        if (isEmpty($lastTransactionLastMonth)) {
            $nextNomorUrut = str_pad($count+1, 6, '0', STR_PAD_LEFT);
        } else {
            $currentNomorUrut = explode('/', $lastTransactionLastMonth->kode_transaksi);
            if ($currentNomorUrut[1] < 100000) {
                $nextNomorUrut = str_pad($count+1, 6, '0', STR_PAD_LEFT);
            } else {
                $nextNomorUrut = str_pad($currentNomorUrut[1] + 1, 6, '0', STR_PAD_LEFT);;
            }
        }
        return response()->json($nextNomorUrut, 200);
        */
        // return response()->json($request->data['userData'], 200);

        $subtotal_produk = 0;
        $total_qty = 0;
        $subtotal_pengiriman = 0;

        $pesanan = new Pesanan;
        $pesanan->user_id = $request->data['userData'][0];
        $pesanan->alamat_id = $request->data['userData'][1];
        $pesanan->kurir_id = $request->data['userData'][2];
        $pesanan->gudang_id = $request->data['userData'][3];
        $pesanan->status_pemesanan = 'menunggu verifikasi';
        $pesanan->save();

        $listDetailPesanan = [];
        foreach ($request->data['orderDetails'] as $key => $value) {
            array_push($listDetailPesanan, [
                'pesanan_id' => $pesanan->id,
                'produk_id' => $request->data['orderDetails'][$key]['tb_produk_id'],
                'qty' => $request->data['orderDetails'][$key]['tb_jumlah_produk'],
                'harga' => $request->data['orderDetails'][$key]['price'],
                'dpp' => $request->data['orderDetails'][$key]['dpp'],
                'ppn' => $request->data['orderDetails'][$key]['ppn'],
                'jenis_pajak' => $request->data['orderDetails'][$key]['jenis_pajak'],
                'persentase_pajak' => $request->data['orderDetails'][$key]['persentase_pajak'],
                'subtotal_detail' => $request->data['orderDetails'][$key]['subtotal'],
            ]);

            $currentStok = Stok::find($request->data['orderDetails'][$key]['tb_stok_id']);
            if ($currentStok->jumlah_stok == 0 || $currentStok->jumlah_stok < $request->data['orderDetails'][$key]['tb_jumlah_produk']) {
                return response()->json([
                    'message' => 'Pesanan gagal ditambahkan, stok tidak mencukupi',
                ], 200);
            }

            $currentStok->decrement('jumlah_stok', $request->data['orderDetails'][$key]['tb_jumlah_produk']);
            $currentStok->save();

            $total_qty += $request->data['orderDetails'][$key]['tb_jumlah_produk'];
            $subtotal_produk += $request->data['orderDetails'][$key]['subtotal'];
        }
        DB::table('detail_pesanan')->insert($listDetailPesanan);

        $transaksi = new Transaksi;
        $transaksi->pesanan_id = $pesanan->id;
        $transaksi->tipe_pembayaran = 'Transef Bank';
        $transaksi->status_pembayaran = 'belum dibayar';
        $transaksi->subtotal_produk = $subtotal_produk;
        $transaksi->subtotal_pengiriman = $subtotal_pengiriman;
        $transaksi->total_qty = $total_qty;
        $transaksi->total_pembayaran = $subtotal_produk + $subtotal_pengiriman;
        $transaksi->kode_transaksi = 'ORD/' . $pesanan->id . '/' . now()->format('m') . '/' . now()->format('Y') . '/' . $request->data['userData'][4];
        $transaksi->total_dpp = $request->data['userData'][5];
        $transaksi->total_ppn = $request->data['userData'][6];
        $transaksi->dpp_terutang = $request->data['userData'][7];
        $transaksi->ppn_terutang = $request->data['userData'][8];
        $transaksi->dpp_dibebaskan = $request->data['userData'][9];
        $transaksi->ppn_dibebaskan = $request->data['userData'][10];
        $transaksi->save();

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

    public function orderByGudangSelector()
    {
        $gudang = DB::table('gudang')
            ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
            ->select('gudang.*', 'alamat.*', 'gudang.id as gid', 'alamat.id as aid', 'gudang.created_at as cat')
            ->orderBy('cat', 'desc')
            ->get();

        return view('pesanan.showByGudang', ['gudang' => $gudang]);
    }

    public function update(Request $request, $id)
    {
        // dd('bjir');
        $transaksi = Transaksi::find($id);
        $transaksi->tipe_pembayaran = $request->cb_status_pembayaran;
        $transaksi->status_pembayaran = $request->cb_status_pembayaran;
        $transaksi->subtotal_pengiriman = $request->tb_biaya_kirim;
        $transaksi->diskon = $request->tb_diskon;
        $transaksi->total_pembayaran = $request->tb_total_pembayaran;
        $transaksi->save();

        $pesanan = Pesanan::find($transaksi->pesanan_id);
        $pesanan->status_pemesanan = $request->cb_status_pemesanan;
        $pesanan->kurir_id = $request->cb_kurir;
        $pesanan->save();

        return redirect()->route('pesanan.index')->with('message', 'Transaksi berhasil diupdate');
    }

    public function transaksiByGudangSelector()
    {
        $gudang = DB::table('gudang')
            ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
            ->select('gudang.*', 'alamat.*', 'gudang.id as gid', 'alamat.id as aid', 'gudang.created_at as cat')
            ->orderBy('cat', 'desc')
            ->get();

        return view('pesanan.transaksiByGudang', ['gudang' => $gudang]);
    }
}
