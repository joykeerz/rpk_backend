<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $currentEntity = [];
        $gudang = [];
        $isProvinsi = false;

        $currentEntity = DB::table('companies')
            ->join('users', 'users.id', '=', 'companies.user_id')
            ->join('alamat', 'alamat.id', '=', 'companies.alamat_id')
            ->select('alamat.provinsi', 'alamat.kota_kabupaten')
            ->where('users.id', '=', Auth::user()->id)
            ->first();
        dd(Auth::user()->id);

        if (empty($currentEntity)) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar di entitas/company manapun, harap hubungi admin');
        }

        if ($request->has('provinsi')) {
            $isProvinsi = true;
            $gudang = DB::table('gudang')
                ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
                ->select('gudang.*', 'alamat.*', 'gudang.id as gid', 'alamat.id as aid', 'gudang.created_at as cat')
                ->where('alamat.provinsi', '=', $currentEntity->provinsi)
                ->orderBy('cat', 'desc')
                ->get();
        } else {
            $gudang = DB::table('gudang')
                ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
                ->select('gudang.*', 'alamat.*', 'gudang.id as gid', 'alamat.id as aid', 'gudang.created_at as cat')
                ->where('alamat.kota_kabupaten', '=', $currentEntity->kota_kabupaten)
                ->orderBy('cat', 'desc')
                ->get();
        }

        return view('stock.index', ['gudang' => $gudang, 'currentEntity' => $currentEntity, 'isProvinsi' => $isProvinsi]);
    }

    public function stockByGudang($id)
    {
        $gudang = Gudang::findOrFail($id);
        $stocks = DB::table('stok')
            ->join('produk', 'stok.produk_id', '=', 'produk.id')
            ->join('gudang', 'stok.gudang_id', '=', 'gudang.id')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select('stok.*', 'kategori.nama_kategori', 'produk.*', 'gudang.*', 'stok.id as sid', 'produk.id as pid', 'gudang.id as gid', 'stok.created_at as cat')
            ->where('stok.gudang_id', '=', $id)
            ->orderBy('stok.id', 'desc')
            ->paginate(15);

        return view('stock.showByGudang', ['gudang' => $gudang, 'stocks' => $stocks]);
    }

    public function showStock($id)
    {
        $stock = DB::table('stok')
            ->join('produk', 'stok.produk_id', '=', 'produk.id')
            ->join('gudang', 'stok.gudang_id', '=', 'gudang.id')
            ->select('stok.*', 'produk.*', 'gudang.*', 'stok.id as sid', 'produk.id as pid', 'gudang.id as gid', 'stok.created_at as cat')
            ->where('stok.id', '=', $id)
            ->first();

        return view('stock.detail', ['stock' => $stock]);
    }

    public function createStock($id)
    {
        $gudang = Gudang::findOrFail($id);
        $products = DB::table('produk')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select('produk.*', 'kategori.*', 'produk.id as pid', 'kategori.id as kid')
            ->orderBy('produk.created_at', 'desc')
            ->get();

        return view('stock.create', ['gudang' => $gudang, 'products' => $products]);
    }

    public function insertStock(Request $request, $id)
    {
        $validated = $request->validate([
            'tb_jumlah_produk' => 'required|numeric',
            'tb_harga_stok' => 'required|numeric',
            'cb_produk' => 'required'
        ], [
            'tb_jumlah_produk.required' => 'jumlah stok tidak boleh kosong',
            'tb_jumlah_produk.numeric' => 'jumlah stok harus berupa angka',
            'tb_harga_stok.required' => 'harga stok tidak boleh kosong',
            'tb_harga_stok.numeric' => 'harga stok harus berupa angka',
            'cb_produk.required' => 'produk tidak boleh kosong',
        ]);

        $checkUniqueProduct = Stok::where('produk_id', '=', $request->cb_produk)
            ->where('gudang_id', '=', $id)
            ->first();
        if ($checkUniqueProduct) {
            return redirect()->back()->with('error', 'produk sudah ada di gudang ini');
        }

        $stock = Stok::create([
            'produk_id' => $request->cb_produk,
            'gudang_id' => $id,
            'jumlah_stok' => $request->tb_jumlah_produk,
            'harga_stok' => $request->tb_harga_stok
        ]);

        return redirect()->route('stok.show', ['id' => $id])->with('message', 'stok produk berhasil ditambahkan');
    }

    public function updateJumlahStock(Request $request, $id)
    {
        $stok = Stok::findOrfail($id);
        $stok->jumlah_stok = $request->tb_jumlah_produk;
        $stok->save();
        return response()->json([
            'data' => [$stok],
            'message' => 'stok berhasil diupdate'
        ], '200');
    }

    public function increaseStock(Request $request, $id)
    {
        $stok = Stok::findOrfail($id);
        if ($request->qty_stock == null || $request->qty_stock == '' || $request->qty_stock == 0) {
            return redirect()->back()->with('message', 'jumlah stok tidak boleh kosong');
        }
        if ($stok->jumlah_stok + $request->qty_stock < 0) {
            return redirect()->back()->with('message', 'jumlah stok tidak boleh kurang dari 0');
        }

        $stok->jumlah_stok = $stok->jumlah_stok + $request->qty_stock;
        $stok->save();
        return redirect()->back()->with('message', 'stok berhasil dirubah');
    }

    public function updateStock(Request $request, $id)
    {
        $validated = $request->validate([
            'tb_jumlah_produk' => 'required|numeric',
            'tb_harga_stok' => 'required|numeric'
        ], [
            'tb_jumlah_produk.required' => 'jumlah stok tidak boleh kosong',
            'tb_jumlah_produk.numeric' => 'jumlah stok harus berupa angka',
            'tb_harga_stok.required' => 'harga stok tidak boleh kosong',
            'tb_harga_stok.numeric' => 'harga stok harus berupa angka'
        ]);

        $stok = Stok::findOrfail($id);
        $stok->jumlah_stok = $request->tb_jumlah_produk;
        $stok->harga_stok = $request->tb_harga_stok;
        $stok->save();

        return redirect()->route('stok.show', ['id' => $request->tb_gudang_id])->with('message', 'stok produk berhasil diupdate');
    }

    public function delete($id)
    {
        $stok = Stok::findOrFail($id);
        $stok->delete();

        return redirect()->back()->with('message', 'stok berhasil dihapus');
    }
}
