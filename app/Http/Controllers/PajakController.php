<?php

namespace App\Http\Controllers;

use App\Models\Pajak;
use Illuminate\Http\Request;

class PajakController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pajak = Pajak::paginate(15);
        return view('pajak.index', compact('pajak'));
    }

    public function show($id)
    {
        $pajak = Pajak::find($id);
        return view('pajak.show', compact('pajak'));
    }

    public function create()
    {
        return view('pajak.create');
    }

    public function store(Request $request)
    {
        //validate input
        $request->validate([
            'namaPajak' => 'required',
            'jenisPajak' => 'required',
            'persentasePajak' => 'required|numeric',
        ], [
            'namaPajak.required' => 'Nama pajak harus diisi',
            'jenisPajak.required' => 'Jenis pajak harus diisi',
            'persentasePajak.required' => 'Peresentase pajak harus diisi',
            'persentasePajak.numeric' => 'Peresentase pajak harus berupa angka',
        ]);

        $pajak = new Pajak();
        $pajak->nama_pajak = $request->namaPajak;
        $pajak->jenis_pajak = $request->jenisPajak;
        $pajak->persentase_pajak = $request->persentasePajak;
        $pajak->external_pajak_id = $request->idExternal;
        $pajak->save();
        return redirect()->route('pajak.index')->with('message', 'Pajak berhasil ditambahkan');

        // // PPN Included
        // $price = $request->price; // assuming price is coming from request
        // $ppnRate = $request->persentasePajak; // assuming PPN rate is coming from request
        // $totalAmountIncluded = (100 / (100 + $ppnRate)) * $price;

        // // PPN Excluded
        // $totalAmountExcluded = $price + ($price * $ppnRate / 100);
    }

    public function update(Request $request, $id)
    {
        //validate input
        $request->validate([
            'namaPajak' => 'required',
            'jenisPajak' => 'required',
            'persentasePajak' => 'required|numeric',
        ], [
            'namaPajak.required' => 'Nama pajak harus diisi',
            'jenisPajak.required' => 'Jenis pajak harus diisi',
            'persentasePajak.required' => 'Peresentase pajak harus diisi',
            'persentasePajak.numeric' => 'Peresentase pajak harus berupa angka',
        ]);

        $pajak = Pajak::find($id);
        $pajak->nama_pajak = $request->namaPajak;
        $pajak->jenis_pajak = $request->jenisPajak;
        $pajak->persentase_pajak = $request->persentasePajak;
        $pajak->external_pajak_id = $request->idExternal;
        $pajak->save();
        return redirect()->route('pajak.index')->with('message', 'Pajak berhasil diubah');
    }

    public function destroy($id)
    {
        $pajak = Pajak::find($id);
        $pajak->delete();
        return redirect()->route('pajak.index')->with('message', 'Pajak berhasil dihapus');
    }

    public function search(Request $request)
    {
    }
}
