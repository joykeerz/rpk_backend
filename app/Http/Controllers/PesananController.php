<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Kurir;
use App\Models\PaymentOption;
use App\Models\Pesanan;
use App\Models\Stok;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $id)
    {
        $search = $request->search;
        $transaksi = DB::table('transaksi')
            ->join('pesanan', 'pesanan.id', '=', 'transaksi.pesanan_id')
            ->join('users', 'users.id', '=', 'pesanan.user_id')
            ->join('gudang', 'gudang.id', '=', 'pesanan.gudang_id')
            ->select('transaksi.*', 'pesanan.*', 'users.*', 'transaksi.id as tid', 'pesanan.id as pid', 'users.id as uid')
            ->where('pesanan.gudang_id', '=', $id)
            ->when($search, function ($query, $search) {
                $query->where('kode_transaksi', 'ilike', '%' . $search . '%')
                    ->orWhere('name', 'ilike', '%' . $search . '%')
                    ->orWhere('status_pembayaran', 'ilike', '%' . $search . '%');
            })
            ->paginate(15);

        return view('pesanan.index', ['transaksi' => $transaksi, 'gudangId' => $id]);
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
        // dd($transaksi);

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

        $currentEntity = DB::table('companies')
            ->join('branches', 'branches.company_id', '=', 'companies.id')
            ->join('users', 'users.company_id', '=', 'companies.id')
            ->join('alamat', 'alamat.id', '=', 'companies.alamat_id')
            ->select('alamat.provinsi', 'alamat.kota_kabupaten', 'companies.nama_company', 'branches.nama_branch', 'branches.id as bid', 'companies.id as cid', 'alamat.id as aid')
            ->where('users.id', '=', Auth::user()->id)
            ->first();

        $biodata = DB::table('biodata')
            ->join('users', 'users.id', '=', 'biodata.user_id')
            ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
            ->select('biodata.*', 'users.*', 'alamat.*', 'users.id as uid', 'biodata.id as bid', 'alamat.id as aid')
            ->where('biodata.branch_id', '=', $currentEntity->bid)
            ->get();

        $kurir = Kurir::all();

        $paymentOptions = DB::table('payment_options')
            ->join('rekening_tujuan', 'rekening_tujuan.id', 'payment_options.rekening_tujuan_id')
            ->select('payment_options.id', 'payment_options.payment_type', 'rekening_tujuan.bank_acc_number', 'rekening_tujuan.name', 'rekening_tujuan.display_name')
            ->where('payment_options.company_id', Auth::user()->company_id)
            ->get();

        // $stok = DB::table('stok')
        //     ->join('produk', 'produk.id', '=', 'stok.produk_id')
        //     ->join('satuan_unit', 'satuan_unit.id', '=', 'produk.satuan_unit_id')
        //     ->join('pajak', 'pajak.id', '=', 'produk.pajak_id')
        //     ->select('stok.*', 'produk.*', 'pajak.jenis_pajak', 'pajak.persentase_pajak', 'satuan_unit.satuan_unit_produk', 'satuan_unit.id as suid', 'stok.id as sid', 'produk.id as pid')
        //     ->where('stok.jumlah_stok', '>', 0)
        //     ->where('stok.gudang_id', '=', $id)
        //     ->get();

        // $stok = DB::table('prices')
        //     ->join('produk', 'prices.produk_id', '=', 'produk.id')
        //     ->join('stok', 'stok.produk_id', '=', 'produk.id')
        //     ->join('satuan_unit', 'satuan_unit.id', '=', 'produk.satuan_unit_id')
        //     ->join('pajak', 'pajak.id', '=', 'produk.pajak_id')
        //     // ->select('pajak.persentase_pajak', 'pajak.jenis_pajak', 'prices.price_value', 'satuan_unit.satuan_unit_produk', 'stok.jumlah_stok', 'produk.nama_produk', 'stok.id as sid', 'satuan_unit.id as suid', 'produk.id as pid')
        //     ->select('prices.price_value', 'stok.*', 'produk.*', 'pajak.jenis_pajak', 'pajak.persentase_pajak', 'satuan_unit.satuan_unit_produk', 'satuan_unit.id as suid', 'stok.id as sid', 'produk.id as pid')
        //     ->where('stok.jumlah_stok', '>', 0)
        //     ->where('stok.gudang_id', '=', $id)
        //     ->orderBy('stok.id', 'desc')
        //     ->distinct()
        //     ->get();

        $kodeCompany = DB::table('gudang')
            ->join('companies', 'companies.id', '=', 'gudang.company_id')
            ->select('companies.kode_company')
            ->where('gudang.id', '=', $id)
            ->first();

        /// query tanpa stok etalase
        // $stok2 = DB::table('stok')
        //     ->join('produk', 'produk.id', '=', 'stok.produk_id')
        //     ->join('satuan_unit', 'satuan_unit.id', '=', 'produk.satuan_unit_id')
        //     ->join('pajak', 'pajak.id', '=', 'produk.pajak_id')
        //     ->join('prices', 'prices.id', '=', 'stok.id')
        //     ->select('prices.price_value', 'stok.*', 'produk.*', 'pajak.jenis_pajak', 'pajak.persentase_pajak', 'satuan_unit.satuan_unit_produk', 'satuan_unit.id as suid', 'stok.id as sid', 'produk.id as pid')
        //     ->where('prices.company_id', Auth::user()->company_id)
        //     ->where('stok.gudang_id', '=', $id)
        //     ->where('stok.jumlah_stok', '>', 0)
        //     ->distinct('prices.produk_id') // ini datanya jadi lebih sedikit. kalo ga dipake bakal ada kode produk duplikat, tapi memang dari import erp banyak data duplikat
        //     ->get();

        /// query stok etalase
        $stokEtalase = DB::table('stok_etalase')
            ->join('stok', 'stok.id', 'stok_etalase.stok_id')
            ->join('prices', 'prices.id', '=', 'stok.id')
            ->join('produk', 'produk.id', '=', 'stok.produk_id')
            ->join('satuan_unit', 'satuan_unit.id', '=', 'produk.satuan_unit_id')
            ->join('pajak', 'pajak.id', '=', 'produk.pajak_id')
            ->select('prices.price_value', 'stok.*', 'produk.*', 'pajak.jenis_pajak', 'pajak.persentase_pajak', 'satuan_unit.satuan_unit_produk', 'satuan_unit.id as suid', 'stok.id as sid', 'produk.id as pid')
            ->where('prices.company_id', Auth::user()->company_id)
            ->where('stok.gudang_id', '=', $id)
            ->where('stok.jumlah_stok', '>', 0)
            ->distinct('prices.produk_id') // ini datanya jadi lebih sedikit. kalo ga dipake bakal ada kode produk duplikat, tapi memang dari import erp banyak data duplikat
            ->get();

        return view('pesanan.newOrderEx', ['product' => $stokEtalase, 'users' => $biodata, 'kurir' => $kurir, 'gudang_id' => $id, 'kodeCompany' => $kodeCompany->kode_company, 'paymentOptions' => $paymentOptions]);
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
        $pesanan->nama_penerima = $request->data['userData'][11];
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

            // $currentStok->decrement('jumlah_stok', $request->data['orderDetails'][$key]['tb_jumlah_produk']);
            $currentStok->save();

            $total_qty += $request->data['orderDetails'][$key]['tb_jumlah_produk'];
            $subtotal_produk += $request->data['orderDetails'][$key]['subtotal'];
        }
        DB::table('detail_pesanan')->insert($listDetailPesanan);

        $transaksi = new Transaksi;
        $transaksi->pesanan_id = $pesanan->id;
        $tipe_pembayaran = DB::table('payment_options')
            ->where('payment_options.id', $request->data['userData'][13])
            ->join('payment_types', 'payment_types.id', 'payment_options.payment_type_id')
            ->pluck('type_name')
            ->first();
        $transaksi->tipe_pembayaran = $tipe_pembayaran;
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
        $transaksi->nomor_pembayaran = $request->data['userData'][12];
        $transaksi->payment_option_id = $request->data['userData'][13];
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

    public function orderByGudangSelector(Request $request)
    {
        $currentEntity = [];
        $gudang = [];
        $isProvinsi = false;

        $currentEntity = DB::table('companies')
            ->join('branches', 'branches.company_id', '=', 'companies.id')
            ->join('users', 'users.company_id', '=', 'companies.id')
            ->join('alamat', 'alamat.id', '=', 'companies.alamat_id')
            ->select('alamat.provinsi', 'alamat.kota_kabupaten', 'companies.nama_company', 'branches.nama_branch', 'branches.id as bid', 'companies.id as cid', 'alamat.id as aid')
            ->where('users.id', '=', Auth::user()->id)
            ->first();

        if (empty($currentEntity)) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar di entitas/company manapun, harap hubungi admin');
        }

        if ($request->has('provinsi')) {
            $isProvinsi = true;
            $gudang = DB::table('gudang')
                ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
                ->select('gudang.*', 'alamat.*', 'gudang.id as gid', 'alamat.id as aid', 'gudang.created_at as cat')
                ->where('gudang.company_id', '=', $currentEntity->cid)
                ->orderBy('cat', 'desc')
                ->get();
        } else {
            $gudang = DB::table('gudang')
                ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
                ->select('gudang.*', 'alamat.*', 'gudang.id as gid', 'alamat.id as aid', 'gudang.created_at as cat')
                ->where('gudang.branch_id', '=', $currentEntity->bid)
                ->orderBy('cat', 'desc')
                ->get();
        }

        return view('pesanan.showByGudang', ['gudang' => $gudang, 'currentEntity' => $currentEntity, 'isProvinsi' => $isProvinsi]);
    }

    public function update(Request $request, $id)
    {
        // dd('bjir');
        $transaksi = Transaksi::find($id);
        $transaksi->tipe_pembayaran = $request->cb_tipe_pembayaran;
        $transaksi->status_pembayaran = $request->cb_status_pembayaran;
        $transaksi->subtotal_pengiriman = $request->tb_biaya_kirim;
        $transaksi->diskon = $request->tb_diskon;
        $transaksi->total_pembayaran = $request->tb_total_pembayaran;
        $transaksi->save();

        $pesanan = Pesanan::find($transaksi->pesanan_id);
        $pesanan->status_pemesanan = $request->cb_status_pemesanan;
        $pesanan->kurir_id = $request->cb_kurir;
        $pesanan->save();

        return redirect()->route('pesanan.index', ['id' => $pesanan->gudang_id])->with('message', 'Transaksi berhasil diupdate');
    }

    public function transaksiByGudangSelector(Request $request)
    {
        $currentEntity = [];
        $gudang = [];
        $isProvinsi = false;

        $currentEntity = DB::table('companies')
            ->join('branches', 'branches.company_id', '=', 'companies.id')
            ->join('users', 'users.company_id', '=', 'companies.id')
            ->join('alamat', 'alamat.id', '=', 'companies.alamat_id')
            ->select('alamat.provinsi', 'alamat.kota_kabupaten', 'companies.nama_company', 'branches.nama_branch', 'branches.id as bid', 'companies.id as cid', 'alamat.id as aid')
            ->where('users.id', '=', Auth::user()->id)
            ->first();

        if (empty($currentEntity)) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar di entitas/company manapun, harap hubungi admin');
        }

        if ($request->has('provinsi')) {
            $isProvinsi = true;
            $gudang = DB::table('gudang')
                ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
                ->select('gudang.*', 'alamat.*', 'gudang.id as gid', 'alamat.id as aid', 'gudang.created_at as cat')
                ->where('gudang.company_id', '=', $currentEntity->cid)
                ->orderBy('cat', 'desc')
                ->get();
        } else {
            $gudang = DB::table('gudang')
                ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
                ->select('gudang.*', 'alamat.*', 'gudang.id as gid', 'alamat.id as aid', 'gudang.created_at as cat')
                // ->where('gudang.branch_id', '=', $currentEntity->bid)
                ->where('gudang.company_id', '=', $currentEntity->cid)
                ->orderBy('cat', 'desc')
                ->get();
        }

        return view('pesanan.transaksiByGudang', ['gudang' => $gudang, 'currentEntity' => $currentEntity, 'isProvinsi' => $isProvinsi]);
    }

    public function verify($id)
    {
        $pesanan = Pesanan::find($id);
        $pesanan->status_pemesanan = 'diproses';
        $pesanan->save();
        return redirect()->route('pesanan.index', ['id' => $pesanan->gudang_id])->with('message', 'Transaksi berhasil diproses');
    }
}
