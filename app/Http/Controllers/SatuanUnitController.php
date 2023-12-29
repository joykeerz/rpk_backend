<?php

namespace App\Http\Controllers;

use App\Models\SatuanUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SatuanUnitController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search  = $request->search;
        $satuanUnit = DB::table('satuan_unit')->when($search, function ($query, $search) {
            $query->where('nama_satuan', 'ilike', '%' . $search . '%')
            ->orWhere('satuan_unit_produk', 'ilike', '%' . $search . '%');
        })->paginate(15);
        return view('satuan-unit.index', compact('satuanUnit'));
    }

    public function show($id)
    {
        $satuanUnit = SatuanUnit::find($id);
        return view('satuan-unit.show', compact('satuanUnit'));
    }

    public function create()
    {
        return view('satuan-unit.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaSatuan' => 'required',
            'simbolSatuan' => 'required',
            'keteranganSatuan' => 'required',
        ], [
            'namaSatuan.required' => 'Nama satuan harus diisi',
            'simbolSatuan.required' => 'Simbol satuan harus diisi',
            'keteranganSatuan.required' => 'Keterangan harus diisi',
        ]);

        $satuanUnit = new SatuanUnit();
        $satuanUnit->nama_satuan = $request->namaSatuan;
        $satuanUnit->satuan_unit_produk = $request->simbolSatuan;
        $satuanUnit->keterangan = $request->keteranganSatuan;
        $satuanUnit->external_satuan_unit_id = $request->idExternal;
        $satuanUnit->save();

        return redirect()->route('satuan-unit.index')->with('message', 'Satuan unit berhasil ditambahkan');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'namaSatuan' => 'required',
            'simbolSatuan' => 'required',
            'keteranganSatuan' => 'required',
        ], [
            'namaSatuan.required' => 'Nama satuan harus diisi',
            'simbolSatuan.required' => 'Simbol satuan harus diisi',
            'keteranganSatuan.required' => 'Keterangan harus diisi',
        ]);

        $satuanUnit = SatuanUnit::findOrFail($request->id);
        $satuanUnit->nama_satuan = $request->namaSatuan;
        $satuanUnit->satuan_unit_produk = $request->simbolSatuan;
        $satuanUnit->keterangan = $request->keteranganSatuan;
        $satuanUnit->external_satuan_unit_id = $request->idExternal;
        $satuanUnit->save();

        return redirect()->route('satuan-unit.index')->with('message', 'Satuan unit berhasil diubah');
    }

    public function destroy($id)
    {
        $satuanUnit = SatuanUnit::findOrFail($id);
        $satuanUnit->delete();
        return redirect()->route('satuan-unit.index')->with('message', 'Satuan unit berhasil dihapus');
    }
}
