<?php

namespace App\Livewire;

use App\Models\Gudang;
use App\Models\StokEtalase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.temp')]
class DatasTable extends Component
{
    use WithPagination;

    //query filters
    #[Url(history: true)]
    public $statusFilter = '';

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 5;

    #[Url(history: true)]
    public $sortBy = 'stok_etalase.created_at';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    //forms
    public $isOpen = false;
    public $stok_id;
    public $jumlah_stok = 1;
    public $editingStockId;
    public $editingJumlahStock;

    public function render()
    {
        $gudangId = Gudang::where('company_id', Auth::user()->company_id)->select('id')->first();

        $stokGudang = DB::table('stok')
            ->join('produk', 'produk.id', 'stok.produk_id')
            ->join('kategori', 'kategori.id', 'produk.kategori_id')
            ->join('gudang', 'gudang.id', 'stok.gudang_id')
            ->select('produk.nama_produk', 'stok.id')
            ->where('gudang.company_id', Auth::user()->company_id)
            ->get();

        $stokEtalase2 = DB::table('stok_etalase')
            ->pluck('stok_id')
            ->all();

        $stokGudangFiltered = $stokGudang->reject(function ($item) use ($stokEtalase2) {
            return in_array($item->id, $stokEtalase2);
        });

        $stokEtalase = DB::table('stok_etalase')
            ->join('stok', 'stok.id', 'stok_etalase.stok_id')
            ->join('produk', 'produk.id', 'stok.produk_id')
            ->join('gudang', 'gudang.id', 'stok.gudang_id')
            ->select('stok_etalase.id', 'stok_etalase.jumlah_stok', 'stok_etalase.updated_at', 'stok_etalase.is_active', 'stok.jumlah_stok as stok_gudang', 'produk.nama_produk', 'gudang.nama_gudang')
            ->where('gudang.id', $gudangId->id)
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('stok_etalase.is_active', $this->statusFilter);
            })
            ->where('produk.nama_produk', 'ilike', "%{$this->search}%")
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.datas-table', [
            'stokEtalase' => $stokEtalase,
            'stokGudang' => $stokGudangFiltered
        ]);
    }

    public function addStock()
    {
        $this->validate([
            'stok_id' => 'required',
            'jumlah_stok' => 'required'
        ]);

        $checkStock = DB::table('stok_etalase')->where('stok_id', $this->stok_id)->first();
        $checkStockGudang = DB::table('stok')->where('id', $this->stok_id)->first();

        if ($checkStock) {
            session()->flash('error', 'stok sudah ada');
        } else {
            if ($checkStockGudang->jumlah_stok < $this->jumlah_stok) {
                session()->flash('error', 'stok etalase tidak bisa melebihi stok gudang!');
            } else {
                $addEtalase = StokEtalase::create([
                    'stok_id' => $this->stok_id,
                    'jumlah_stok' => $this->jumlah_stok,
                    'is_active' => true,
                ]);

                $this->reset(['stok_id', 'jumlah_stok']);

                session()->flash('message', 'etalase stok berhasil dibuat!');

                $this->closeModal();

                $this->dispatch('stockAdded');

                $this->resetPage();
            }
        }
    }

    public function delete($id)
    {
        DB::table('stok_etalase')->where('id', $id)->delete();
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

    public function toggleEtalase($id)
    {
        $StokEtalase = StokEtalase::find($id);
        $StokEtalase->is_active = !$StokEtalase->is_active;
        $StokEtalase->save();
    }

    public function changeStock($id)
    {
        $StokEtalase = StokEtalase::find($id);
        $this->editingStockId = $id;
        $this->editingJumlahStock = $StokEtalase->jumlah_stok;
    }

    public function cancelChange()
    {
        $this->reset('editingStockId', 'editingJumlahStock');
    }

    public function updateEtalaseStock()
    {
        $StokEtalase = StokEtalase::find($this->editingStockId);
        $StokEtalase->jumlah_stok = $this->editingJumlahStock;
        $StokEtalase->save();
        $this->cancelChange();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }
}
