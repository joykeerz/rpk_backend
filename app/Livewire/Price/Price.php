<?php

namespace App\Livewire\Price;

use App\Models\Price as ModelsPrice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.temp')]
class Price extends Component
{
    use WithPagination;

    /// Ui Variables
    public $isOpen = false;
    public $isEdit = false;

    //query filters
    #[Url(history: true)]
    public $search;

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $sortBy = 'prices.id';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    /// Input Variables
    public $produkId;
    public $pricevalue;

    /// Editing Variable
    public $priceIdEdit;
    public $priceValueEdit;

    /// Database Variables
    public $userCompanyId;

    public function mount()
    {
        $this->userCompanyId = Auth::user()->company_id;
    }

    public function render()
    {
        $prices = DB::table('prices')
            ->join('produk', 'produk.id', '=', 'prices.produk_id')
            ->select('prices.id', 'prices.price_value', 'prices.company_id', 'produk.nama_produk', 'produk.id as produk_id', 'produk.kode_produk')
            ->where('prices.company_id', '=', $this->userCompanyId)
            ->where('produk.nama_produk', 'ilike', "%{$this->search}%")
            ->where('produk.kode_produk', '!=', 0)
            // ->distinct('prices.produk_id')
            // ->orderBy('prices.produk_id')
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        $stocks = DB::table('stok')
            ->join('produk', 'stok.produk_id', '=', 'produk.id')
            ->join('gudang', 'stok.gudang_id', '=', 'gudang.id')
            ->where('gudang.company_id', '=', $this->userCompanyId)
            ->select('stok.id', 'produk.nama_produk', 'produk.kode_produk', 'produk.id as produk_id')
            ->get();

        return view('livewire.price.price', [
            'prices' => $prices,
            'stocks' => $stocks
        ]);
    }

    public function addPrice()
    {
        $this->validate([
            'produkId' => 'required',
            'pricevalue' => 'required'
        ], [
            'produkId.required' => 'Produk tidak boleh kosong',
            'pricevalue.required' => 'tipe payment tidak boleh kosong',
        ]);

        $checkProduct = Price::where('company_id', '=', $this->userCompanyId)->where('produk_id', '=', $this->produkId)->first();
        if ($checkProduct) {
            session()->flash('message', 'harga untuk produk ini sudah ada');
            $this->reset(['produkId', 'pricevalue']);
        } else {
            DB::table('prices')->insert([
                'id' => Price::count() + 1,
                'price_value' => $this->pricevalue,
                'produk_id' => $this->produkId,
                'company_id' => $this->userCompanyId,
            ]);
            $this->reset(['produkId', 'pricevalue']);
            session()->flash('message', 'Harga berhasil dibuat');
            $this->closeModal();
            $this->resetPage();
        }
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function setSortBy($sortByColumn)
    {
        if ($this->sortBy === $sortByColumn) {
            $this->sortDir = ($this->sortDir == "ASC" ? "DESC" : "ASC");
            return;
        }

        $this->sortBy = $sortByColumn;
        $this->sortDir = "DESC";
    }

    public function openEdit($id)
    {
        $price = ModelsPrice::find($id);
        $this->priceIdEdit = $id;
        $this->priceValueEdit = $price->price_value;
        $this->isEdit = true;
    }

    public function saveEdit()
    {
        $this->validate([
            'priceValueEdit' => 'required'
        ], [
            'priceValueEdit.required' => 'tipe payment tidak boleh kosong',
        ]);

        $price = ModelsPrice::find($this->priceIdEdit);
        $price->price_value = $this->priceValueEdit;
        $price->save();
        session()->flash('message', "Harga berhasil dirubah");
        $this->reset(['priceIdEdit', 'priceValueEdit']);
        $this->closeEdit();
    }

    public function closeEdit()
    {
        $this->reset(['priceIdEdit', 'priceValueEdit']);
        $this->isEdit = false;
    }

    public function closeAlert()
    {
        session()->forget('message');
    }
}
