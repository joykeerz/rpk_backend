<?php

namespace App\Livewire\Payment;

use App\Models\PaymentOption as ModelsPaymentOption;
use App\Models\PaymentTerm;
use App\Models\PaymentType;
use App\Models\RekeningTujuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.temp')]
class PaymentOption extends Component
{
    use WithPagination;

    /// Ui Variables
    public $isOpen = false;
    public $isEdit = false;

    //query filters
    #[Url(history: true)]
    public $search;

    #[Url(history: true)]
    public $perPage = 5;

    #[Url(history: true)]
    public $statusFilter = '';

    #[Url(history: true)]
    public $sortBy = 'payment_options.created_at';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    /// Input Variables
    public $rekeningTujuanId;
    public $paymentTermId;
    public $paymentTypeId;

    /// Editing Variable
    public $paymentOptionIdEdit;
    public $rekeningTujuanIdEdit;
    public $paymentTermIdEdit;
    public $paymentTypeEdit;

    /// Database Variables
    public $companyId;

    public function mount()
    {
        $this->companyId = Auth::user()->company_id;
    }

    public function render()
    {
        $paymentOptions = DB::table('payment_options')
            ->join('rekening_tujuan', 'rekening_tujuan.id', 'payment_options.rekening_tujuan_id')
            ->join('payment_terms', 'payment_terms.id', 'payment_options.payment_term_id')
            ->join('payment_types', 'payment_types.id', 'payment_options.payment_type_id')
            ->select(
                'payment_options.id',
                'rekening_tujuan.name as rekening_name',
                'rekening_tujuan.bank_acc_number',
                'payment_terms.name as term_name',
                'payment_types.display_name'
            )
            ->where('payment_options.company_id', $this->companyId)
            ->where('rekening_tujuan.bank_acc_number', 'ilike', "%{$this->search}%")
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        $rekeningTujuanList = RekeningTujuan::all();

        $paymentTerms = PaymentTerm::all();

        $paymentTypes = PaymentType::all();

        return view('livewire.payment.payment-option', [
            'paymentOptions' => $paymentOptions,
            'paymentTerms' => $paymentTerms,
            'rekeningTujuanList' => $rekeningTujuanList,
            'paymentTypes' => $paymentTypes,

        ]);
    }

    public function addPayment()
    {
        $this->validate([
            'rekeningTujuanId' => 'required',
            'paymentTermId' => 'required',
            'paymentTypeId' => 'required'
        ], [
            'rekeningTujuanId.required' => 'rekening tujuan tidak boleh kosong',
            'paymentTermId.required' => 'payment term tidak boleh kosong',
            'paymentTypeId.required' => 'tipe payment tidak boleh kosong',
        ]);

        $paymentOptions = ModelsPaymentOption::create([
            'company_id' => $this->companyId,
            'rekening_tujuan_id' => $this->rekeningTujuanId,
            'payment_term_id' => $this->paymentTermId,
            'payment_type_id' => $this->paymentTypeId
        ]);

        $this->reset(['rekeningTujuanId', 'paymentTermId', 'paymentTypeId']);

        session()->flash('message', 'payment option berhasil dibuat');

        $this->closeModal();

        $this->resetPage();
    }

    public function delete($id)
    {
        DB::table('payment_options')->where('id', $id)->delete();
        session()->flash('message', 'payment option berhasil dihapus');

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
        $paymentOption = ModelsPaymentOption::find($id);
        $this->paymentOptionIdEdit = $id;
        $this->rekeningTujuanIdEdit = $paymentOption->rekening_tujuan_id;
        $this->paymentTermIdEdit = $paymentOption->payment_term_id;
        $this->paymentTypeEdit = $paymentOption->payment_type_id;
        $this->isEdit = true;
    }

    public function saveEdit()
    {
        $this->validate([
            'rekeningTujuanIdEdit' => 'required',
            'paymentTermIdEdit' => 'required',
            'paymentTypeEdit' => 'required'
        ], [
            'rekeningTujuanIdEdit.required' => 'rekening tujuan tidak boleh kosong',
            'paymentTermIdEdit.required' => 'payment term tidak boleh kosong',
            'paymentTypeEdit.required' => 'tipe payment tidak boleh kosong',
        ]);

        $paymentOption = ModelsPaymentOption::find($this->paymentOptionIdEdit);
        $paymentOption->rekening_tujuan_id = $this->rekeningTujuanIdEdit;
        $paymentOption->payment_term_id = $this->paymentTermIdEdit;
        $paymentOption->payment_type_id = $this->paymentTypeEdit;
        $paymentOption->save();
        session()->flash('message', 'payment option berhasil diupdate');
        $this->reset(['paymentOptionIdEdit', 'rekeningTujuanIdEdit', 'paymentTermIdEdit', 'paymentTypeEdit']);
        $this->closeEdit();

    }

    public function closeEdit()
    {
        $this->reset(['rekeningTujuanIdEdit', 'paymentTermIdEdit', 'paymentTypeEdit']);
        $this->isEdit = false;
    }

    public function closeAlert()
    {
        session()->forget('message');
    }
}
