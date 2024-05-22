<?php

namespace App\Livewire\Kurir;

use App\Models\Kurir;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.temp')]
class KurirIndex extends Component
{
    use WithPagination, WithFileUploads;

    /// Ui Variables
    public $isOpen = false;
    public $isEdit = false;

    /// query filters Variables
    #[Url(history: true)]
    public $search;

    #[Url(history: true)]
    public $perPage = 5;

    #[Url(history: true)]
    public $sortBy = 'kurir.created_at';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    /// Input Variables
    public $namaKurir;
    public $deliveryType;
    public $fixedPrice = 0;
    public $description;
    public $marginPercentage = 0;
    public $imageKurir;

    /// Editing Variable
    public $kurirIdEdit;
    public $namaKurirEdit;
    public $deliveryTypeEdit;
    public $fixedPriceEdit;
    public $descriptionEdit;
    public $marginPercentageEdit;
    public $imageKurirEdit;

    /// Database Variables
    public $companyId;
    public $deliveryTypeEnum = ['fixed', 'base_on_rule', 'rajaongkir'];
    public function mount()
    {
        $this->companyId = Auth::user()->company_id;
    }

    public function render()
    {
        $kurir = Kurir::where('kurir.company_id', $this->companyId)
            ->where('kurir.nama_kurir', 'ilike', "%{$this->search}%")
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
        return view('livewire.kurir.kurir-index', [
            'couriers' => $kurir,
        ]);
    }

    public function addKurir()
    {
        $this->validate([
            'namaKurir' => 'required',
            'deliveryType' => 'required',
            'fixedPrice' => 'required',
            'description' => 'required',
            'marginPercentage' => 'required',
            'imageKurir' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'namaKurir.required' => 'nama kurir tidak boleh kosong',
            'deliveryType.required' => 'tipe Delivery tidak boleh kosong',
            'fixedPrice.required' => 'fixed price tidak boleh kosong',
            'description.required' => 'deskripsi tidak boleh kosong',
            'marginPercentage.required' => 'persentase margin tidak boleh kosong',
            'imageKurir' => 'gambar belum sesuai kriteria',
        ]);

        $kurir = new Kurir;
        $kurir->company_id = $this->companyId;
        $kurir->nama_kurir = $this->namaKurir;
        $kurir->delivery_type = $this->deliveryType;
        $kurir->fixed_price = $this->fixedPrice;
        $kurir->description = $this->description;
        $kurir->margin_percentage = $this->marginPercentage;
        if ($this->imageKurir) {
            $filePath = $this->imageKurir->store('images/kurir', 'public');
            $kurir->image_filepath = $filePath;
        }
        $kurir->save();

        $this->reset(['namaKurir', 'deliveryType', 'fixedPrice', 'description', 'marginPercentage', 'imageKurir']);

        session()->flash('message', 'kurir berhasil dibuat');

        $this->closeModal();

        $this->resetPage();
    }

    public function delete($id)
    {
        $kurir = Kurir::find($id)->delete();
        session()->flash('message', "kurir $kurir->nama_kurir berhasil dihapus");
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
        $kurir = Kurir::where('id', $id)->first();
        $this->kurirIdEdit = $id;
        $this->namaKurirEdit = $kurir->nama_kurir;
        $this->deliveryTypeEdit = $kurir->delivery_type;
        $this->fixedPriceEdit = $kurir->fixed_price;
        $this->descriptionEdit = $kurir->description;
        $this->marginPercentageEdit = $kurir->margin_percentage;
        $this->imageKurirEdit = $kurir->image_filepath;
        $this->isEdit = true;
    }

    public function saveEdit()
    {
        $this->validate([
            'namaKurirEdit' => 'required',
            'deliveryTypeEdit' => 'required',
            'fixedPriceEdit' => 'required',
            'descriptionEdit' => 'required',
            'marginPercentageEdit' => 'required',
            'imageKurirEdit' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'namaKurirEdit.required' => 'nama kurir tidak boleh kosong',
            'deliveryTypeEdit.required' => 'tipe Delivery tidak boleh kosong',
            'fixedPriceEdit.required' => 'fixed price tidak boleh kosong',
            'descriptionEdit.required' => 'deskripsi tidak boleh kosong',
            'marginPercentageEdit.required' => 'persentase margin tidak boleh kosong',
            'imageKurirEdit.image' => 'file harus berupa gambar',
        ]);

        $kurir = Kurir::find($this->kurirIdEdit);
        $kurir->nama_kurir = $this->namaKurirEdit;
        $kurir->delivery_type = $this->deliveryTypeEdit;
        $kurir->fixed_price = $this->fixedPriceEdit;
        $kurir->description = $this->descriptionEdit;
        $kurir->margin_percentage = $this->marginPercentageEdit;
        if ($this->imageKurirEdit) {
            $filePath = $this->imageKurirEdit->store('images/kurir', 'public');
            $kurir->image_filepath = $filePath;
        }
        $kurir->save();

        session()->flash('message', 'kurir berhasil diupdate');

        $this->closeEdit();

        $this->resetPage();
    }

    public function closeEdit()
    {
        $this->reset(['kurirIdEdit', 'namaKurirEdit', 'deliveryTypeEdit', 'fixedPriceEdit', 'descriptionEdit', 'marginPercentageEdit', 'imageKurirEdit']);
        $this->isEdit = false;
    }
}
