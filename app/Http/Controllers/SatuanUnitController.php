<?php

namespace App\Http\Controllers;

use App\Models\SatuanUnit;
use Illuminate\Http\Request;

class SatuanUnitController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $satuanUnit = SatuanUnit::paginate(15);
        return view('satuan-unit.index', compact('satuanUnit'));
    }

    public function show($id){
        $satuanUnit = SatuanUnit::find($id);
        return view('satuan-unit.show', compact('satuanUnit'));
    }

    public function create()
    {
        return view('satuan-unit.create');
    }

    public function store(Request $request){
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
        $satuanUnit->simbol_satuan = $request->simbolSatuan;
        $satuanUnit->keterangan = $request->keteranganSatuan;
        $satuanUnit->external_satuan_unit_id = $request->idExternal;
        $satuanUnit->save();

        return redirect()->route('satuan-unit.index')->with('message', 'Satuan unit berhasil ditambahkan');
    }

    public function update(Request $request){
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
        $satuanUnit->simbol_satuan = $request->simbolSatuan;
        $satuanUnit->keterangan = $request->keteranganSatuan;
        $satuanUnit->external_satuan_unit_id = $request->idExternal;
        $satuanUnit->save();

        return redirect()->route('satuan-unit.index')->with('message', 'Satuan unit berhasil diubah');
    }

    public function destroy($id){
        $satuanUnit = SatuanUnit::findOrFail($id);
        $satuanUnit->delete();
        return redirect()->route('satuan-unit.index')->with('message', 'Satuan unit berhasil dihapus');
    }
}
