<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function index(Request $request, $gudangID)
    {
        $search = $request->search;
        $locations = DB::table('locations')
            ->join('gudang', 'locations.gudang_id', '=', 'gudang.id')
            ->select('locations.*', 'gudang.nama_gudang')
            ->where('locations.gudang_id', '=', $gudangID)
            ->when($search, function ($query, $search) {
                $query->where('name', 'ilike', '%' . $search . '%')
                    ->orWhere('parent_location', 'ilike', '%' . $search . '%')
                    ->orWhere('unique_or_many', 'ilike', '%' . $search . '%');
            })
            ->paginate(15);
        return view('location.index', ['locations' => $locations, 'gudangID' => $gudangID]);
    }

    public function create($gudangID)
    {
        return view('location.create', ['gudangID' => $gudangID]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tb_nama_location' => 'required',
        ], [
            'tb_nama_location.required' => 'Nama lokasi harus diisi',
        ]);

        Location::create([
            'location_name' => $request->tb_nama_location,
            'parent_location' => $request->tb_parent_location,
            'unique_or_many' => 'many_products',
            'gudang_id' => $request->tb_gudang_id,
            'external_location_id' => $request->tb_external_location_id,
        ]);

        return redirect()->route('location.index', ['id' => $request->tb_gudang_id])
            ->with('message', 'Location created successfully.');
    }

    public function show($id)
    {
        $location = Location::find($id);
        return view('location.show', ['location' => $location]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'tb_nama_location' => 'required',
        ], [
            'tb_nama_location.required' => 'Nama lokasi harus diisi',
        ]);

        $location = Location::find($id);
        $location->location_name = $request->tb_nama_location;
        $location->parent_location = $request->tb_parent_location;
        $location->unique_or_many = 'many_products';
        $location->gudang_id = $request->tb_gudang_id;
        $location->external_location_id = $request->tb_external_location_id;
        $location->save();

        return redirect()->route('location.index', ['id' => $request->tb_gudang_id])
            ->with('message', 'Location updated successfully.');
    }

    public function destroy($id)
    {
        $location = Location::find($id);
        $location->delete();

        return redirect()->route('location.index', ['id' => $location->gudang_id])
            ->with('message', 'Location deleted successfully');
    }
}
