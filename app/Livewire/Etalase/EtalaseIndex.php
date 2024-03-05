<?php

namespace App\Livewire\Etalase;

use App\Models\Banner;
use App\Models\StokEtalase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class EtalaseIndex extends Component
{
    use WithPagination;

    public $isOpen = false;

    #[Rule('required')]
    public $stok_id;

    #[Rule('required|min:10')]
    public $jumlah_stok = 1;

    public function render()
    {
        $stokGudang = DB::table('stok')
            ->join('produk', 'produk.id', 'stok.produk_id')
            ->join('kategori', 'kategori.id', 'produk.kategori_id')
            ->join('gudang', 'gudang.id', 'stok.gudang_id')
            ->select('produk.nama_produk', 'stok.id')
            ->where('gudang.company_id', Auth::user()->company_id)
            ->get();

        $stokEtalase = DB::table('stok_etalase')
            ->join('stok', 'stok.id', 'stok_etalase.stok_id')
            ->join('produk', 'produk.id', 'stok.produk_id')
            ->join('gudang', 'gudang.id', 'stok.gudang_id')
            ->select('stok_etalase.id', 'stok_etalase.jumlah_stok', 'stok_etalase.updated_at', 'stok_etalase.is_active', 'produk.nama_produk', 'gudang.nama_gudang')
            ->paginate(15);

        return view('livewire.etalase.etalase-index', [
            'stokEtalase' => $stokEtalase,
            'stokGudang' => $stokGudang
        ]);
    }

    public function addStock()
    {
        $this->validate([
            'stok_id' => 'required',
            'jumlah_stok' => 'required'
        ]);

        $checkStock = DB::table('stok_etalase')->where('stok_id', $this->stok_id)->first();

        if ($checkStock) {
            session()->flash('error', 'stok sudah ada');
        } else {
            $addEtalase = StokEtalase::create([
                'stok_id' => $this->stok_id,
                'jumlah_stok' => $this->jumlah_stok,
                'is_active' => true,
            ]);

            $this->reset(['stok_id', 'jumlah_stok']);

            $this->dispatch('stockAdded');

            session()->flash('message', 'etalase stok berhasil dibuat');

            $this->closeModal();
        }
    }

    public function increaseStock()
    {
        //code
    }

    public function decreaseStok()
    {
        //code
    }

    public function toggleEtalase()
    {
        //code
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
